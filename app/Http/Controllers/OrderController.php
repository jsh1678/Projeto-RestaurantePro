<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Table;
use App\Models\StockItem;
use App\Models\StockMovement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'garcom') {
            abort(403, 'Acesso negado. Apenas usuários com papel de garçom podem criar pedidos.');
        }
        $tableId = $request->query('table_id');

        if ($tableId) {
            $pedidoAtivo = Order::where('table_id', $tableId)
                ->whereNotIn('status', ['pago', 'cancelado', 'pronto_entrega', 'aguardando_pagamento'])
                ->first();

            if ($pedidoAtivo) {
                return redirect()->route('orders.edit', $pedidoAtivo->id)
                    ->with('info', '⚠️ Esta mesa já possui um pedido ativo. Você pode editar ou finalizar o pedido existente.');
            }

            $contaFechada = Order::where('table_id', $tableId)
                ->whereIn('status', ['pronto_entrega', 'aguardando_pagamento'])
                ->exists();

            if ($contaFechada) {
                return redirect()->route('mesas.conta', $tableId)
                    ->with('error', '❌ A conta desta mesa já foi fechada. Não é possível adicionar novos pedidos.');
            }
        }

        $categorias = Category::with('menuItems.stockItem')->get();

        $categoriasDisponiveis = $categorias->map(function ($categoria) {
            $categoria->menuItems = $categoria->menuItems->filter(function ($item) {
                if (!$item->disponivel) return false;
                if (!$item->stockItem) return true;
                return $item->stockItem->quantidade_atual > 0;
            });
            return $categoria;
        })->filter(fn($cat) => $cat->menuItems->count() > 0);

        $mesas = Table::all();

        return view('orders.create', [
            'tableId'    => $tableId,
            'categorias' => $categoriasDisponiveis,
            'mesas'      => $mesas,
            'pedido'     => null,
        ]);
    }

    public function edit(Order $order)
    {
        if (!Auth::user() || Auth::user()->role !== 'garcom') {
            abort(403);
        }

        if (in_array($order->status, ['pago', 'cancelado', 'pronto_entrega', 'aguardando_pagamento'])) {
            return redirect()->route('mesas.conta', $order->table_id)
                ->with('error', '❌ Este pedido não pode mais ser editado.');
        }

        $categorias = Category::with('menuItems.stockItem')->get();
        $categoriasDisponiveis = $categorias->map(function ($categoria) {
            $categoria->menuItems = $categoria->menuItems->filter(function ($item) {
                if (!$item->disponivel) return false;
                if (!$item->stockItem) return true;
                return $item->stockItem->quantidade_atual > 0;
            });
            return $categoria;
        })->filter(fn($cat) => $cat->menuItems->count() > 0);

        $mesas = Table::all();
        $order->load('items');

        return view('orders.create', [
            'tableId'    => $order->table_id,
            'categorias' => $categoriasDisponiveis,
            'mesas'      => $mesas,
            'pedido'     => $order,
        ]);
    }

    /**
     * Atualiza um pedido existente com diff inteligente:
     * - Itens que já existiam e continuam → preservados (mantém status da cozinha)
     * - Itens com quantidade aumentada → quantidade atualizada + marcado como não enviado
     * - Itens novos (não existiam antes) → criados com enviado_cozinha = false
     * - Itens removidos → deletados
     */
    public function update(Request $request, Order $order)
    {
        if (!Auth::user() || Auth::user()->role !== 'garcom') {
            abort(403);
        }

        if (in_array($order->status, ['pago', 'cancelado', 'pronto_entrega', 'aguardando_pagamento'])) {
            return back()->with('error', '❌ Este pedido não pode mais ser editado.');
        }

        $validated = $request->validate([
            'table_id'             => 'required|exists:tables,id',
            'observacoes'          => 'nullable|string',
            'pedido_viagem'        => 'nullable|boolean',
            'itens'                => 'required|array',
            'itens.*.menu_item_id' => 'required|exists:menu_items,id',
            'itens.*.quantidade'   => 'required|integer|min:1',
        ]);

        $itensNovos = DB::transaction(function () use ($validated, $order, $request) {
            // Mapa dos itens atuais: menu_item_id → OrderItem
            $itensAtuais = $order->items->keyBy('menu_item_id');

            // Mapa do que foi enviado pelo garçom: menu_item_id → quantidade
            $itensEnviados = collect($validated['itens'])->keyBy('menu_item_id');

            $total        = 0;
            $itensNovos   = collect(); // novos ou com quantidade aumentada

            // ── 1. Criar ou atualizar itens ──────────────────────────────────
            foreach ($itensEnviados as $menuItemId => $dados) {
                $menuItem = MenuItem::find($menuItemId);
                if (!$menuItem) continue;

                $qtdNova  = (int) $dados['quantidade'];
                $subtotal = $menuItem->preco * $qtdNova;
                $total   += $subtotal;

                if ($itensAtuais->has($menuItemId)) {
                    // Item já existia
                    $itemExistente = $itensAtuais[$menuItemId];
                    $qtdAnterior   = $itemExistente->quantidade;

                    if ($qtdNova > $qtdAnterior) {
                        // Quantidade aumentou → re-envia delta para cozinha
                        $itemExistente->update([
                            'quantidade'         => $qtdNova,
                            'subtotal'           => $subtotal,
                            'enviado_cozinha'    => false,  // re-notifica cozinha
                            'enviado_cozinha_em' => null,
                        ]);
                        $itensNovos->push([
                            'item'        => $itemExistente->fresh()->load('menuItem'),
                            'delta'       => $qtdNova - $qtdAnterior, // só o acréscimo
                            'quantidade'  => $qtdNova,
                            'tipo'        => 'adicionado',
                        ]);
                    } elseif ($qtdNova < $qtdAnterior) {
                        // Quantidade diminuiu → atualiza mas NÃO re-notifica
                        $itemExistente->update([
                            'quantidade' => $qtdNova,
                            'subtotal'   => $subtotal,
                        ]);
                    }
                    // Se igual: não faz nada

                } else {
                    // Item novo → cria e marca para envio à cozinha
                    $novoItem = OrderItem::create([
                        'order_id'        => $order->id,
                        'menu_item_id'    => $menuItem->id,
                        'quantidade'      => $qtdNova,
                        'preco_unitario'  => $menuItem->preco,
                        'subtotal'        => $subtotal,
                        'status'          => 'pendente',
                        'enviado_cozinha' => false,
                    ]);
                    $itensNovos->push([
                        'item'       => $novoItem->load('menuItem'),
                        'delta'      => $qtdNova,
                        'quantidade' => $qtdNova,
                        'tipo'       => 'novo',
                    ]);
                }
            }

            // ── 2. Deletar itens que foram removidos ─────────────────────────
            foreach ($itensAtuais as $menuItemId => $itemExistente) {
                if (!$itensEnviados->has($menuItemId)) {
                    $itemExistente->delete();
                }
            }

            // ── 3. Atualizar totais e status do pedido ───────────────────────
            $updates = [
                'total'         => $total,
                'observacoes'   => $validated['observacoes'] ?? null,
                'pedido_viagem' => $request->has('pedido_viagem'),
            ];

            // Se o pedido estava 'pronto' (chef terminou) mas o garçom adicionou
            // itens novos → volta para 'em_preparo'
            if ($itensNovos->isNotEmpty() && $order->status === 'pronto') {
                $updates['status']          = 'em_preparo';
                $updates['horario_pronto']  = null;
            }

            $order->update($updates);

            return $itensNovos;
        });

        // ── 4. Notificar cozinha via cache (lido pelo SSE) ───────────────────
        if ($itensNovos->isNotEmpty()) {
            $this->notificarCozinha($order, $itensNovos);
        }

        return redirect()->route('dashboard')
            ->with('success', '✅ Pedido atualizado com sucesso!');
    }

    public function store(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'garcom') {
            abort(403, 'Acesso negado. Apenas usuários com papel de garçom podem criar pedidos.');
        }

        $caixaFechadoEm = cache()->get('caixa_fechado_em');
        if ($caixaFechadoEm) {
            $reabreEm = \Carbon\Carbon::parse($caixaFechadoEm)->addDay()->setTime(10, 0, 0);
            if (now()->lessThan($reabreEm)) {
                return back()->with('error', '🔒 Caixa fechado. Nenhum pedido pode ser feito até amanhã às 10h.');
            }
        }

        $validated = $request->validate([
            'table_id'             => 'required|exists:tables,id',
            'observacoes'          => 'nullable|string',
            'pedido_viagem'        => 'nullable|boolean',
            'itens'                => 'required|array',
            'itens.*.menu_item_id' => 'required|exists:menu_items,id',
            'itens.*.quantidade'   => 'required|integer|min:1',
        ]);

        $pedidoAtivo = Order::where('table_id', $validated['table_id'])
            ->whereNotIn('status', ['pago', 'cancelado', 'pronto_entrega', 'aguardando_pagamento'])
            ->first();

        if ($pedidoAtivo) {
            return redirect()->route('orders.edit', $pedidoAtivo->id)
                ->with('info', '⚠️ Esta mesa já possui um pedido ativo. Edite o pedido existente.');
        }

        $contaFechada = Order::where('table_id', $validated['table_id'])
            ->whereIn('status', ['pronto_entrega', 'aguardando_pagamento'])
            ->exists();

        if ($contaFechada) {
            return redirect()->route('mesas.conta', $validated['table_id'])
                ->with('error', '❌ A conta desta mesa já foi fechada. Não é possível adicionar novos pedidos.');
        }

        // Validação de estoque
        $requiredByStock = [];
        $menuItemsCache  = [];

        foreach ($validated['itens'] as $item) {
            $menuItem = MenuItem::find($item['menu_item_id']);
            if (!$menuItem) {
                return back()->with('error', "Item de menu não encontrado (ID: {$item['menu_item_id']}).");
            }
            $menuItemsCache[$menuItem->id] = $menuItem;
            if ($menuItem->stockItem) {
                $stockId = $menuItem->stockItem->id;
                if (!isset($requiredByStock[$stockId])) $requiredByStock[$stockId] = 0;
                $requiredByStock[$stockId] += $item['quantidade'];
            }
        }

        $insuficientes = [];
        foreach ($requiredByStock as $stockId => $requiredQty) {
            $stockItem = StockItem::find($stockId);
            if (!$stockItem || $stockItem->quantidade_atual < $requiredQty) {
                $insuficientes[] = ['stock' => $stockItem, 'required' => $requiredQty];
            }
        }

        if (count($insuficientes) > 0) {
            $messages = [];
            foreach ($insuficientes as $inc) {
                $nome      = $inc['stock'] ? $inc['stock']->nome : 'Item removido';
                $available = $inc['stock'] ? $inc['stock']->quantidade_atual : 0;
                $messages[] = "{$nome} — disponível: {$available}, necessário: {$inc['required']}";
            }
            return back()->with('error', 'Estoque insuficiente: ' . implode('; ', $messages));
        }

        $pedido = DB::transaction(function () use ($validated, $menuItemsCache, $request) {
            $total  = 0;
            $pedido = Order::create([
                'table_id'      => $validated['table_id'],
                'user_id'       => Auth::id(),
                'status'        => 'em_preparo',
                'observacoes'   => $validated['observacoes'] ?? null,
                'pedido_viagem' => $request->has('pedido_viagem'),
            ]);

            Table::find($validated['table_id'])?->update(['status' => 'ocupada']);

            foreach ($validated['itens'] as $item) {
                $menuItem = $menuItemsCache[$item['menu_item_id']];
                $subtotal = $menuItem->preco * $item['quantidade'];
                OrderItem::create([
                    'order_id'        => $pedido->id,
                    'menu_item_id'    => $menuItem->id,
                    'quantidade'      => $item['quantidade'],
                    'preco_unitario'  => $menuItem->preco,
                    'subtotal'        => $subtotal,
                    'status'          => 'pendente',
                    'enviado_cozinha' => false,   // será marcado pelo SSE ao enviar
                ]);
                $total += $subtotal;
            }

            $pedido->update(['total' => $total]);
            return $pedido;
        });

        // Notificar cozinha: todos os itens são "novos"
        $pedido->load('items.menuItem');
        $itensNovos = $pedido->items->map(fn($item) => [
            'item'       => $item,
            'delta'      => $item->quantidade,
            'quantidade' => $item->quantidade,
            'tipo'       => 'novo',
        ]);
        $this->notificarCozinha($pedido, $itensNovos);

        return redirect()->route('dashboard')
            ->with('success', 'Pedido criado com sucesso!');
    }

    public function show(Order $order)
    {
        return view('orders.show', [
            'pedido' => $order->load('table', 'items.menuItem', 'payment'),
        ]);
    }

    /**
     * Endpoint SSE — a cozinha abre esta URL e fica escutando eventos em tempo real.
     * Compatível com PHP síncrono (sem WebSockets, sem Redis, sem filas).
     */
    public function cozinhaStream(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'chef') {
            abort(403);
        }

        return response()->stream(function () {
            // Cabeçalho inicial — mantém conexão viva
            echo "data: " . json_encode(['type' => 'connected']) . "\n\n";
            ob_flush();
            flush();

            $ultimoCheck = now();
            $maxSegundos = 55; // reconecta antes do timeout do proxy (60s)
            $inicio      = time();

            while ((time() - $inicio) < $maxSegundos) {
                // Busca itens que chegaram após o último check E ainda não foram
                // marcados como enviados para a cozinha.
                $itensNovos = OrderItem::with(['order.table', 'order.user', 'menuItem'])
                    ->where('enviado_cozinha', false)
                    ->whereHas('order', fn($q) => $q->whereIn('status', ['em_preparo', 'pronto']))
                    ->where('created_at', '>=', $ultimoCheck->subSeconds(2)) // janela de segurança
                    ->orderBy('created_at')
                    ->get();

                if ($itensNovos->isNotEmpty()) {
                    // Agrupa por pedido para o payload
                    $payload = $itensNovos->groupBy('order_id')->map(function ($itens, $orderId) {
                        $pedido = $itens->first()->order;
                        return [
                            'order_id'  => $orderId,
                            'numero'    => str_pad($orderId, 4, '0', STR_PAD_LEFT),
                            'mesa'      => $pedido->table->numero ?? '—',
                            'garcom'    => $pedido->user->name ?? '—',
                            'viagem'    => (bool) $pedido->pedido_viagem,
                            'obs'       => $pedido->observacoes,
                            'itens'     => $itens->map(fn($i) => [
                                'id'        => $i->id,
                                'nome'      => $i->menuItem->nome ?? 'Item',
                                'quantidade'=> $i->quantidade,
                            ])->values(),
                        ];
                    })->values();

                    echo "event: novos_itens\n";
                    echo "data: " . json_encode($payload) . "\n\n";
                    ob_flush();
                    flush();

                    // Marca como enviados para não re-notificar
                    OrderItem::whereIn('id', $itensNovos->pluck('id'))
                        ->update([
                            'enviado_cozinha'    => true,
                            'enviado_cozinha_em' => now(),
                        ]);
                }

                $ultimoCheck = now();

                // Heartbeat a cada ciclo para manter a conexão viva
                echo ": heartbeat\n\n";
                ob_flush();
                flush();

                if (connection_aborted()) break;

                sleep(2); // verifica a cada 2 segundos
            }

            // Diz ao cliente para reconectar em 1s
            echo "event: reconectar\n";
            echo "data: {}\n\n";
            ob_flush();
            flush();
        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache',
            'X-Accel-Buffering' => 'no',   // desativa buffer do Nginx
            'Connection'        => 'keep-alive',
        ]);
    }

    /**
     * Armazena no cache um "sinal" de novos itens para o SSE pegar.
     * Também garante que todos os itens passados estejam com enviado_cozinha = false.
     */
    private function notificarCozinha(Order $order, $itensNovos): void
    {
        // Garante que os itens novos estão com flag false no banco
        $ids = $itensNovos->pluck('item.id')->filter();
        if ($ids->isNotEmpty()) {
            OrderItem::whereIn('id', $ids)->update([
                'enviado_cozinha'    => false,
                'enviado_cozinha_em' => null,
            ]);
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (!Auth::user() || Auth::user()->role !== 'garcom') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:aberto,em_preparo,pronto,pronto_entrega,entregue,aguardando_pagamento,pago,cancelado',
        ]);

        $novoStatus   = $request->status;
        $statusPedido = $novoStatus;
        if ($novoStatus === 'entregue') {
            $statusPedido = 'aguardando_pagamento';
        }

        DB::transaction(function () use ($order, $statusPedido, $novoStatus) {
            $updates = ['status' => $statusPedido];

            if ($statusPedido === 'aguardando_pagamento') {
                $updates['horario_entrega'] = now();
                $order->items()->update(['status' => 'entregue']);
            }

            $order->update($updates);
            $order->table?->update(['status' => 'ocupada']);
        });

        return redirect()->route('dashboard')
            ->with('success', '✅ Pedido marcado como entregue! Aguardando pagamento.');
    }

    public function cancelar(Order $order)
    {
        if (!in_array(Auth::user()->role, ['garcom', 'gerente'])) {
            abort(403);
        }
        if ($order->status === 'pago') {
            return back()->with('error', '❌ Não é possível cancelar um pedido já pago.');
        }
        if (in_array($order->status, ['pronto_entrega', 'aguardando_pagamento'])) {
            return back()->with('error', '❌ A conta já foi fechada. Fale com o caixa para cancelar.');
        }

        DB::transaction(function () use ($order) {
            $order->items()->update(['status' => 'entregue']);
            $order->update(['status' => 'cancelado']);

            $pedidosAtivos = Order::where('table_id', $order->table_id)
                ->whereNotIn('status', ['pago', 'cancelado'])
                ->count();

            if ($pedidosAtivos === 0) {
                $order->table?->update(['status' => 'disponivel']);
            }
        });

        if ($order->table_id) {
            return redirect()->route('mesas.conta', $order->table_id)
                ->with('success', '✅ Pedido #' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' cancelado.');
        }
        return redirect()->route('dashboard')->with('success', '✅ Pedido cancelado.');
    }
}