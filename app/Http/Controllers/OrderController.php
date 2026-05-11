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

        DB::transaction(function () use ($validated, $order, $request) {
            $total = 0;
            $order->items()->delete();

            foreach ($validated['itens'] as $item) {
                $menuItem = MenuItem::find($item['menu_item_id']);
                $subtotal = $menuItem->preco * $item['quantidade'];
                OrderItem::create([
                    'order_id'       => $order->id,
                    'menu_item_id'   => $menuItem->id,
                    'quantidade'     => $item['quantidade'],
                    'preco_unitario' => $menuItem->preco,
                    'subtotal'       => $subtotal,
                ]);
                $total += $subtotal;
            }

            $order->update([
                'total'         => $total,
                'observacoes'   => $validated['observacoes'] ?? null,
                'pedido_viagem' => $request->has('pedido_viagem'),
            ]);
        });

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
                    'order_id'       => $pedido->id,
                    'menu_item_id'   => $menuItem->id,
                    'quantidade'     => $item['quantidade'],
                    'preco_unitario' => $menuItem->preco,
                    'subtotal'       => $subtotal,
                ]);
                $total += $subtotal;
            }

            $pedido->update(['total' => $total]);
            return $pedido;
        });

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
     * Garçom marca o pedido como entregue → status vira aguardando_pagamento.
     * TAMBÉM marca todos os order_items como 'entregue' para o chef não ver mais.
     * TAMBÉM atualiza o status da mesa para 'ocupada' (já estava, mas garante).
     */
    public function updateStatus(Request $request, Order $order)
    {
        if (!Auth::user() || Auth::user()->role !== 'garcom') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:aberto,em_preparo,pronto,pronto_entrega,entregue,aguardando_pagamento,pago,cancelado',
        ]);

        $novoStatus = $request->status;

        // "entregue" pelo garçom → vira aguardando_pagamento no Order
        // mas os order_items ficam marcados como 'entregue'
        $statusPedido = $novoStatus;
        if ($novoStatus === 'entregue') {
            $statusPedido = 'aguardando_pagamento';
        }

        DB::transaction(function () use ($order, $statusPedido, $novoStatus) {
            $updates = ['status' => $statusPedido];

            if ($statusPedido === 'aguardando_pagamento') {
                $updates['horario_entrega'] = now();

                // ✅ FIX: Marcar todos os itens do pedido como 'entregue'
                $order->items()->update(['status' => 'entregue']);
            }

            $order->update($updates);

            // Garantir que a mesa continua como 'ocupada' (aguardando pagamento)
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
            // Cancelar os itens também
            $order->items()->update(['status' => 'entregue']); // marcar como finalizado
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