<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Order;
use App\Models\Payment;
use App\Models\CaixaFechamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function index()
    {
        $mesas = Table::with(['orders' => fn($q) => $q->whereNotIn('status', ['pago', 'cancelado'])])
            ->orderBy('numero')
            ->get();

        // Sincronizar status com a realidade
        foreach ($mesas as $mesa) {
            $temPedido = $mesa->orders->isNotEmpty();
            if ($temPedido && $mesa->status !== 'ocupada') {
                $mesa->update(['status' => 'ocupada']);
                $mesa->status = 'ocupada';
            } elseif (!$temPedido && $mesa->status === 'ocupada') {
                $mesa->update(['status' => 'disponivel']);
                $mesa->status = 'disponivel';
            }
        }

        return view('mesas.index', compact('mesas'));
    }

    public function show(Table $table)
{
    // Se a mesa tem pedidos ativos, vai direto para a conta
    $temPedidoAtivo = Order::where('table_id', $table->id)
        ->whereNotIn('status', ['pago', 'cancelado'])
        ->exists();

    if ($temPedidoAtivo) {
        return redirect()->route('mesas.conta', $table);
    }

    return view('mesas.show', [
        'mesa'        => $table,
        'pedidoAtivo' => null,
    ]);
}
    // ── CONTA DA MESA ────────────────────────────────────────────────────────
    public function conta(Table $mesa)
    {
        // Soft hide: apenas pedidos ativos (pago/cancelado ficam ocultos das views)
        $pedidos = Order::where('table_id', $mesa->id)
            ->whereNotIn('status', ['pago', 'cancelado'])
            ->with('items.menuItem', 'user')
            ->orderBy('created_at')
            ->get();

        $totalConta = $pedidos->sum('total');
        $totalItens = $pedidos->sum(fn($p) => $p->items->sum('quantidade'));
        $orderIds = $pedidos->pluck('id');
        $totalPago = Payment::whereIn('order_id', $orderIds)->where('status', 'confirmado')->sum('valor_final');
        $taxaGarcom = Payment::whereIn('order_id', $orderIds)->where('status', 'confirmado')->sum('taxa');
        $totalComTaxa = $totalConta + $taxaGarcom;
        $saldoRestante = max(0, round($totalComTaxa - $totalPago, 2));

        // Conta fechada significa que os pedidos já foram enviados para o caixa.
        $contaFechada = $pedidos->contains(
            fn($p) => $p->status === 'aguardando_pagamento'
        );

        return view('mesas.conta', compact(
            'mesa',
            'pedidos',
            'totalConta',
            'totalItens',
            'contaFechada',
            'totalPago',
            'taxaGarcom',
            'totalComTaxa',
            'saldoRestante'
        ));
    }

    // ── FECHAR CONTA (garçom fecha a conta da mesa) ──────────────────────────
    public function fecharConta(Table $mesa)
    {
        if (Auth::user()?->role !== 'garcom') abort(403);

        // Buscar pedidos que ainda não foram enviados para o caixa.
        // Pedidos em pronto_entrega também devem virar aguardando_pagamento ao fechar a conta.
        $pedidos = Order::where('table_id', $mesa->id)
            ->whereNotIn('status', ['pago', 'cancelado', 'aguardando_pagamento'])
            ->get();

        if ($pedidos->isEmpty()) {
            // Verificar se já tem pedidos fechados esperando pagamento
            $jaFechados = Order::where('table_id', $mesa->id)
                ->where('status', 'aguardando_pagamento')
                ->exists();

            if ($jaFechados) {
                return redirect()->route('mesas.conta', $mesa)
                    ->with('info', 'ℹ️ A conta desta mesa já foi fechada. Aguardando pagamento no caixa.');
            }

            return back()->with('error', '❌ Nenhum pedido em aberto nesta mesa.');
        }

        $temEmPreparo = $pedidos->contains(fn($p) => $p->status === 'em_preparo');

        if ($temEmPreparo) {
            return redirect()->route('mesas.conta', $mesa)
                ->with('error', '⚠️ Ainda há pedidos em preparo. Aguarde a cozinha marcar como pronto antes de fechar a conta.');
        }

        DB::transaction(function () use ($pedidos, $mesa) {
            foreach ($pedidos as $pedido) {
                $pedido->update([
                    'status'          => 'aguardando_pagamento',
                    'horario_entrega' => $pedido->horario_entrega ?? now(),
                ]);
                $pedido->items()->update(['status' => 'entregue']);
            }
            $mesa->update(['status' => 'ocupada']);
        });

        return redirect()->route('mesas.conta', $mesa)
            ->with('success', '✅ Conta fechada! Pedidos enviados para o caixa.');
    }

    public function juntar(Request $request, Table $mesa)
    {
        if (Auth::user()?->role !== 'garcom') abort(403);

        $validated = $request->validate([
            'destino_id' => 'required|integer|exists:tables,id',
        ]);

        $destino = Table::findOrFail($validated['destino_id']);

        if ($destino->id === $mesa->id) {
            return back()->with('error', 'Escolha uma mesa diferente para juntar.');
        }

        $pedidosOrigem = Order::where('table_id', $mesa->id)
            ->whereNotIn('status', ['pago', 'cancelado'])
            ->get();

        if ($pedidosOrigem->isEmpty()) {
            return back()->with('error', 'Esta mesa nao possui pedidos ativos para juntar.');
        }

        DB::transaction(function () use ($mesa, $destino, $pedidosOrigem) {
            Order::whereIn('id', $pedidosOrigem->pluck('id'))
                ->update(['table_id' => $destino->id]);

            $destino->update([
                'status' => 'ocupada',
                'garcom_id' => $destino->garcom_id ?: ($mesa->garcom_id ?: Auth::id()),
            ]);

            $mesa->update([
                'status' => 'disponivel',
                'garcom_id' => null,
            ]);
        });

        return redirect()->route('mesas.conta', $destino)
            ->with('success', 'Mesa ' . $mesa->numero . ' juntada com a Mesa ' . $destino->numero . '.');
    }

    // ── PAGAR CONTA DA MESA (aceita pagamento parcial/dividido) ──────────────
    public function pagarConta(Request $request, Table $mesa)
    {
        if (Auth::user()?->role !== 'caixa') abort(403);

        if (CaixaFechamento::fechadoAtual()) {
            return back()->with('error', '🔒 Caixa fechado. Nenhum pagamento pode ser feito até a reabertura.');
        }

        $request->validate([
            'metodo'       => 'required|in:dinheiro,cartao_credito,cartao_debito,pix',
            'valor_pago'   => 'required|numeric|min:0.01',
            'taxa_garcom'  => 'nullable|boolean',
            'parcelas'     => 'nullable|required_if:metodo,cartao_credito|integer|min:1|max:12',
        ]);

        $pedidos = Order::where('table_id', $mesa->id)
            ->whereNotIn('status', ['pago', 'cancelado'])
            ->with('items', 'payments')
            ->get();

        if ($pedidos->isEmpty()) {
            return back()->with('error', '❌ Nenhum pedido em aberto nesta mesa.');
        }

        $totalConta = round($pedidos->sum('total'), 2);
        $orderIds = $pedidos->pluck('id');
        $totalPagoAntes = round(Payment::whereIn('order_id', $orderIds)->where('status', 'confirmado')->sum('valor_final'), 2);
        $taxaAntes = round(Payment::whereIn('order_id', $orderIds)->where('status', 'confirmado')->sum('taxa'), 2);
        $taxaNova = ($request->boolean('taxa_garcom') && $taxaAntes <= 0)
            ? round($totalConta * 0.10, 2)
            : 0.0;
        $totalDevido = round($totalConta + $taxaAntes + $taxaNova, 2);
        $saldoRestante = max(0, round($totalDevido - $totalPagoAntes, 2));
        $valorSolicitado = round((float) $request->valor_pago, 2);

        if ($valorSolicitado > $saldoRestante) {
            return back()
                ->withInput()
                ->with('error', 'O valor pago nao pode passar de R$ ' . number_format($saldoRestante, 2, ',', '.') . '.');
        }

        $valorPago = $valorSolicitado;

        if ($valorPago <= 0) {
            return back()->with('error', 'Esta conta ja esta quitada.');
        }

        DB::transaction(function () use ($pedidos, $request, $mesa, $valorPago, $taxaNova, $totalConta, $totalDevido, $totalPagoAntes) {
            $restanteParaDistribuir = $valorPago;

            foreach ($pedidos as $idx => $pedido) {
                $proporcao = $totalConta > 0 ? ($pedido->total / $totalConta) : (1 / max(1, $pedidos->count()));
                $valorEste = ($idx === $pedidos->count() - 1)
                    ? $restanteParaDistribuir
                    : round($valorPago * $proporcao, 2);
                $restanteParaDistribuir = round($restanteParaDistribuir - $valorEste, 2);

                Payment::create([
                    'order_id'       => $pedido->id,
                    'metodo'         => $request->metodo,
                    'valor'          => max(0, round($valorEste - ($idx === 0 ? $taxaNova : 0), 2)),
                    'taxa'           => $idx === 0 ? $taxaNova : 0,
                    'valor_final'    => $valorEste,
                    'parcelas'       => $request->metodo === 'cartao_credito' ? (int) $request->input('parcelas', 1) : 1,
                    'status'         => 'confirmado',
                    'data_pagamento' => now(),
                ]);
            }

            $totalPagoDepois = round($totalPagoAntes + $valorPago, 2);
            if ($totalPagoDepois + 0.009 >= $totalDevido) {
                foreach ($pedidos as $pedido) {
                    // ✅ Marca como 'pago' E define pago_em para o soft hide funcionar
                    $pedido->update([
                        'status'             => 'pago',
                        'pago_em'            => now(),
                        'horario_pagamento'  => now(),
                    ]);
                }

                // ✅ Mesa volta para disponível apenas quando a conta inteira foi quitada
                $mesa->update(['status' => 'disponivel']);
            } else {
                $mesa->update(['status' => 'ocupada']);
            }
        });

        $quitada = ($totalPagoAntes + $valorPago) + 0.009 >= $totalDevido;
        $destino = $quitada ? route('mesas.index') : route('mesas.conta', $mesa);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'quitada' => $quitada,
                'redirect' => $destino,
                'message' => 'Pagamento confirmado!' . ($quitada ? ' Mesa liberada.' : ' Ainda ha saldo restante na mesa.'),
            ]);
        }

        return redirect($destino)
            ->with('success', '✅ Pagamento de R$ ' . number_format($valorPago, 2, ',', '.') . ' confirmado!' . ($quitada ? ' Mesa ' . $mesa->numero . ' liberada.' : ' Ainda ha saldo restante na mesa.'));
    }

    public function create()
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        return view('mesas.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        $validated = $request->validate([
            'numero'   => 'required|unique:tables|integer|min:1',
            'assentos' => 'required|integer|min:1|max:20',
        ]);
        Table::create($validated);
        return redirect()->route('mesas.index')->with('success', '✅ Mesa criada!');
    }

    public function edit(Table $table)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        return view('mesas.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        $validated = $request->validate([
            'numero'   => 'required|unique:tables,numero,' . $table->id . '|integer|min:1',
            'assentos' => 'required|integer|min:1|max:20',
        ]);
        $table->update($validated);
        return redirect()->route('mesas.index')->with('success', '✅ Mesa atualizada!');
    }

    public function destroy(Table $table)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        $table->delete();
        return redirect()->route('mesas.index')->with('success', '✅ Mesa removida!');
    }

    public function atualizar(Request $request, Table $mesa)
    {
        if (Auth::user()?->role !== 'garcom') {
            abort(403);
        }

        $request->validate(['status' => 'required|in:disponivel,ocupada,reservada']);

        $pedidosAtivos = Order::where('table_id', $mesa->id)
            ->whereNotIn('status', ['pago', 'cancelado'])
            ->count();

        if ($pedidosAtivos > 0) {
            return back()->with('error', '❌ Mesa ' . $mesa->numero . ' tem pedidos em aberto. Finalize os pedidos para mudar o status.');
        }

        $mesa->update(['status' => $request->status]);

        $labels = ['disponivel' => 'Disponível', 'reservada' => 'Reservada', 'ocupada' => 'Ocupada'];
        return back()->with('success', '✅ Mesa ' . $mesa->numero . ' → ' . $labels[$request->status]);
    }
}
