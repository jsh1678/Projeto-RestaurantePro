<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
<<<<<<< HEAD
use App\Models\CaixaFechamento;
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
use App\Models\Sangria;
use App\Models\Purchase;
use App\Models\Table;
use Carbon\Carbon;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CaixaController extends Controller
{
    public function dashboard(): View
    {
<<<<<<< HEAD
        if (!in_array(Auth::user()?->role, ['caixa', 'gerente'])) {
=======
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente'])) {
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            abort(403);
        }

        $dataHoje   = Carbon::today();
        $dataInicio = $dataHoje->copy()->startOfMonth();
        $dataFim    = $dataHoje->copy()->endOfMonth();

        $vendaHoje  = Payment::whereDate('created_at', $dataHoje)->where('status', 'confirmado')->sum('valor_final');
        $vendaDoMes = Payment::whereBetween('created_at', [$dataInicio, $dataFim])->where('status', 'confirmado')->sum('valor_final');

        $pagamentosHoje = Payment::whereDate('created_at', $dataHoje)->with('order.table')->orderByDesc('created_at')->get();

<<<<<<< HEAD
        // Pedidos enviados ao caixa pelo fechamento da conta.
        $pedidosProntosPagamento = Order::where('status', 'aguardando_pagamento')
            ->with('table', 'user', 'items.menuItem', 'payments')
=======
        // Soft hide: só mostra pedidos que ainda não foram pagos
        $pedidosProntosPagamento = Order::whereIn('status', ['pronto_entrega', 'aguardando_pagamento'])
            ->with('table', 'user', 'items')
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            ->orderBy('created_at')
            ->get();

        $pagamentosCartao = Payment::whereDate('created_at', $dataHoje)
            ->whereIn('metodo', ['cartao_credito', 'cartao_debito'])->where('status', 'confirmado')->sum('valor_final');
        $pagamentosNumerario = Payment::whereDate('created_at', $dataHoje)
            ->where('metodo', 'dinheiro')->where('status', 'confirmado')->sum('valor_final');

        $comprasHoje  = Purchase::whereDate('created_at', $dataHoje)->where('status', 'recebido')->sum('total');
        $comprasDoMes = Purchase::whereBetween('created_at', [$dataInicio, $dataFim])->where('status', 'recebido')->sum('total');

        $sangriasHoje     = Sangria::whereDate('created_at', $dataHoje)->sum('valor');
        $sangriasDoMes    = Sangria::whereBetween('created_at', [$dataInicio, $dataFim])->sum('valor');
        $historicoSangrias = Sangria::with('user')->orderByDesc('created_at')->limit(20)->get();

        $saldoHoje = $vendaHoje - $comprasHoje - $sangriasHoje;

        return view('dashboard.caixa', compact(
            'vendaHoje', 'vendaDoMes', 'pagamentosHoje', 'pedidosProntosPagamento',
            'pagamentosCartao', 'pagamentosNumerario', 'comprasHoje', 'comprasDoMes',
            'saldoHoje', 'sangriasHoje', 'sangriasDoMes', 'historicoSangrias'
        ));
    }

    public function registrarSangria(): RedirectResponse
    {
<<<<<<< HEAD
        if (!in_array(Auth::user()?->role, ['caixa', 'gerente'])) {
=======
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente'])) {
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            abort(403);
        }
        $validated = request()->validate([
            'valor'  => 'required|numeric|min:0.01|max:999999',
            'motivo' => 'nullable|string|max:255',
        ]);

        Sangria::create([
            'user_id' => Auth::id(),
            'valor'   => $validated['valor'],
            'motivo'  => $validated['motivo'] ?? null,
        ]);

        return back()->with('success', '✅ Sangria de R$ ' . number_format($validated['valor'], 2, ',', '.') . ' registrada!');
    }

    /**
     * Confirma pagamento de um pedido individual.
     * ✅ FIX: Após pagar, define pago_em e verifica se a mesa pode ser liberada.
     */
    public function confirmarPagamento(Order $order): RedirectResponse|JsonResponse
    {
<<<<<<< HEAD
        if (!in_array(Auth::user()?->role, ['caixa', 'gerente', 'garcom'])) {
            abort(403);
        }

        $fechamentoAtual = CaixaFechamento::fechadoAtual();
        if ($fechamentoAtual) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => '🔒 Caixa fechado.'], 403);
            }
            return back()->with('error', '🔒 Caixa fechado. Nenhum pagamento pode ser feito até amanhã às 10h.');
=======
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente', 'garcom'])) {
            abort(403);
        }

        $caixaFechadoEm = cache()->get('caixa_fechado_em');
        if ($caixaFechadoEm) {
            $reabreEm = Carbon::parse($caixaFechadoEm)->addDay()->setTime(10, 0, 0);
            if (now()->lessThan($reabreEm)) {
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => '🔒 Caixa fechado.'], 403);
                }
                return back()->with('error', '🔒 Caixa fechado. Nenhum pagamento pode ser feito até amanhã às 10h.');
            }
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        }

        try {
            $validated = request()->validate([
<<<<<<< HEAD
                'metodo'      => 'required|in:dinheiro,cartao_credito,cartao_debito,pix',
                'valor_pago'  => 'required|numeric|min:0.01',
                'taxa_garcom' => 'nullable|boolean',
                'parcelas'    => 'nullable|required_if:metodo,cartao_credito|integer|min:1|max:12',
=======
                'metodo'     => 'required|in:dinheiro,cartao_credito,cartao_debito,pix',
                'valor_pago' => 'required|numeric|min:0.01',
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            ]);
        } catch (ValidationException $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            }
            return back()->withErrors($e)->withInput();
        }

        $order->load('items');
        $total = $order->items->sum('subtotal');
<<<<<<< HEAD
        $totalPagoAntes = $order->payments()->where('status', 'confirmado')->sum('valor_final');
        $taxaAntes = $order->payments()->where('status', 'confirmado')->sum('taxa');
        $taxaNova = (request()->boolean('taxa_garcom') && $taxaAntes <= 0)
            ? round($total * 0.10, 2)
            : 0.0;
        $totalDevido = round($total + $taxaAntes + $taxaNova, 2);
        $saldoRestante = max(0, round($totalDevido - $totalPagoAntes, 2));
        $valorSolicitado = round((float) $validated['valor_pago'], 2);

        if ($valorSolicitado > $saldoRestante) {
            return back()
                ->withInput()
                ->with('error', 'O valor pago nao pode passar de R$ ' . number_format($saldoRestante, 2, ',', '.') . '.');
        }

        $valorPago = $valorSolicitado;

        if ($valorPago <= 0) {
            return back()->with('error', 'Este pedido ja esta quitado.');
        }

        Payment::create([
            'order_id'       => $order->id,
            'valor'          => max(0, round($valorPago - $taxaNova, 2)),
            'taxa'           => $taxaNova,
            'valor_final'    => $valorPago,
            'metodo'         => $validated['metodo'],
            'parcelas'       => $validated['metodo'] === 'cartao_credito' ? (int) ($validated['parcelas'] ?? 1) : 1,
=======

        Payment::create([
            'order_id'       => $order->id,
            'valor'          => $total,
            'valor_final'    => $validated['valor_pago'],
            'metodo'         => $validated['metodo'],
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            'status'         => 'confirmado',
            'data_pagamento' => now(),
        ]);

<<<<<<< HEAD
        $quitado = ($totalPagoAntes + $valorPago) + 0.009 >= $totalDevido;

        if ($quitado) {
            // ✅ FIX: Marca como pago com timestamp para soft hide
            $order->update([
                'status'             => 'pago',
                'pago_em'            => now(),
                'horario_pagamento'  => now(),
            ]);
        } elseif ($order->table_id) {
            $order->table?->update(['status' => 'ocupada']);
        }
=======
        // ✅ FIX: Marca como pago com timestamp para soft hide
        $order->update([
            'status'  => 'pago',
            'pago_em' => now(),
        ]);
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

        // ✅ FIX: Verifica se TODOS os pedidos da mesa foram pagos/cancelados
        // Se sim, libera a mesa → próximo cliente pode usar
        if ($order->table_id) {
            $pedidosAtivos = Order::where('table_id', $order->table_id)
                ->whereNotIn('status', ['pago', 'cancelado'])
                ->where('id', '!=', $order->id)
                ->count();

<<<<<<< HEAD
            if ($quitado && $pedidosAtivos === 0) {
=======
            if ($pedidosAtivos === 0) {
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
                $order->table?->update(['status' => 'disponivel']);
            }
        }

        if (request()->expectsJson()) {
<<<<<<< HEAD
            return response()->json([
                'success' => true,
                'quitado' => $quitado,
                'message' => $quitado
                    ? 'Pagamento confirmado! Mesa liberada.'
                    : 'Pagamento parcial confirmado. A mesa continua ocupada.',
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', $quitado
                ? '✅ Pagamento confirmado! Mesa liberada.'
                : '✅ Pagamento parcial confirmado! A mesa continua ocupada ate quitar o restante.'
            );
=======
            return response()->json(['success' => true, 'message' => 'Pagamento confirmado!']);
        }

        return redirect()->route('dashboard')
            ->with('success', '✅ Pagamento confirmado! Mesa liberada.');
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    }

    public function diaria(): View
    {
<<<<<<< HEAD
        if (!in_array(Auth::user()?->role, ['caixa', 'gerente'])) {
=======
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente'])) {
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            abort(403);
        }

        $dataHoje = Carbon::today();

<<<<<<< HEAD
        $fechamentoAtual = CaixaFechamento::fechadoAtual();
        $caixaAberto     = !$fechamentoAtual;
        $caixaFechadoEm  = $fechamentoAtual?->fechado_em?->toIso8601String();
        $caixaReabreEm   = $fechamentoAtual ? $fechamentoAtual->reabreEm()->toIso8601String() : null;
        $periodoInicio   = $this->periodoInicioAtual();
        $periodoFim      = now();
        $resumoPeriodo   = $this->resumoFinanceiro($periodoInicio, $periodoFim);
        $comandasAbertas = $this->comandasAbertas();
        $valorPendente   = $comandasAbertas->sum('total');

        $metodos = ['pix', 'cartao_credito', 'cartao_debito', 'dinheiro'];
        $conciliacao = collect($metodos)->map(function ($metodo) use ($periodoInicio, $periodoFim) {
            $pagamentos = $this->pagamentosDoPeriodo($periodoInicio, $periodoFim)
                ->where('metodo', $metodo);
=======
        $caixaFechadoEm = cache()->get('caixa_fechado_em');
        $caixaAberto    = true;

        if ($caixaFechadoEm) {
            $fechadoEm   = Carbon::parse($caixaFechadoEm);
            $reabreEm    = $fechadoEm->copy()->addDay()->setTime(10, 0, 0);
            $caixaAberto = now()->greaterThanOrEqualTo($reabreEm);
            if ($caixaAberto) {
                cache()->forget('caixa_fechado_em');
            }
        }

        $metodos = ['pix', 'cartao_credito', 'cartao_debito', 'dinheiro'];
        $conciliacao = collect($metodos)->map(function ($metodo) use ($dataHoje) {
            $pagamentos = Payment::whereDate('created_at', $dataHoje)
                ->where('metodo', $metodo)
                ->where('status', 'confirmado');
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            return [
                'metodo'     => $metodo,
                'label'      => ucfirst(str_replace('_', ' ', $metodo)),
                'total'      => $pagamentos->sum('valor_final'),
                'quantidade' => $pagamentos->count(),
            ];
        });

<<<<<<< HEAD
        $totalDia        = $resumoPeriodo['total_vendido'];
        $totalPedidos    = $resumoPeriodo['total_pagamentos'];
        $totalCancelados = Order::whereBetween('created_at', [$periodoInicio, $periodoFim])
            ->where('status', 'cancelado')
            ->count();

        $fechamentos = CaixaFechamento::with('user')
            ->orderByDesc('fechado_em')
            ->limit(10)
            ->get()
            ->map(fn(CaixaFechamento $fechamento) => [
                'fechado_em'       => $fechamento->fechado_em->format('d/m/Y H:i'),
                'periodo_inicio'   => $fechamento->periodo_inicio?->format('d/m/Y H:i'),
                'usuario'          => $fechamento->user->name ?? 'Sistema',
                'total'            => $fechamento->total,
                'valor_esperado'   => $fechamento->valor_esperado_caixa,
                'comandas_abertas' => $fechamento->total_comandas_abertas,
            ])
            ->reverse()
            ->values()
            ->all();
=======
        $totalDia        = Payment::whereDate('created_at', $dataHoje)->where('status', 'confirmado')->sum('valor_final');
        $totalPedidos    = Payment::whereDate('created_at', $dataHoje)->where('status', 'confirmado')->count();
        $totalCancelados = Order::whereDate('created_at', $dataHoje)->where('status', 'cancelado')->count();

        $fechamentos = cache()->get('caixa_historico_fechamentos', []);
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

        return view('caixa.diaria', compact(
            'conciliacao', 'totalDia', 'totalPedidos',
            'totalCancelados', 'caixaAberto', 'caixaFechadoEm',
<<<<<<< HEAD
            'caixaReabreEm', 'fechamentos', 'dataHoje',
            'periodoInicio', 'periodoFim', 'resumoPeriodo',
            'comandasAbertas', 'valorPendente'
=======
            'fechamentos', 'dataHoje'
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        ));
    }

    public function fecharCaixa(): RedirectResponse
    {
<<<<<<< HEAD
        if (!in_array(Auth::user()?->role, ['caixa', 'gerente'])) {
=======
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente'])) {
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            abort(403);
        }

        $agora = now();
<<<<<<< HEAD

        if (CaixaFechamento::fechadoAtual()) {
            return redirect()->route('caixa.diaria')->with('error', '🔒 Caixa já está fechado.');
        }

        $periodoInicio = $this->periodoInicioAtual();
        $resumo        = $this->resumoFinanceiro($periodoInicio, $agora);
        $comandas      = $this->comandasAbertas();

        DB::transaction(function () use ($periodoInicio, $agora, $resumo, $comandas) {
            $fechamento = CaixaFechamento::create([
                'user_id'                 => Auth::id(),
                'fechado_em'              => $agora,
                'periodo_inicio'          => $periodoInicio,
                'periodo_fim'             => $agora,
                'total'                   => $resumo['total_vendido'],
                'total_dinheiro'          => $resumo['dinheiro'],
                'total_pix'               => $resumo['pix'],
                'total_cartao_debito'     => $resumo['cartao_debito'],
                'total_cartao_credito'    => $resumo['cartao_credito'],
                'total_compras'           => $resumo['compras'],
                'total_sangrias'          => $resumo['sangrias'],
                'valor_esperado_caixa'    => $resumo['valor_esperado_caixa'],
                'total_pagamentos'        => $resumo['total_pagamentos'],
                'total_comandas_abertas'  => $comandas->count(),
                'relatorio'               => [
                    'periodo' => [
                        'inicio' => $periodoInicio->toDateTimeString(),
                        'fim'    => $agora->toDateTimeString(),
                    ],
                    'pagamentos'       => $resumo,
                    'comandas_abertas' => $this->relatorioComandasAbertas($comandas),
                    'fechado_por'      => Auth::user()?->name ?? 'Sistema',
                ],
            ]);

            $this->pagamentosDoPeriodo($periodoInicio, $agora)
                ->whereNull('caixa_fechamento_id')
                ->update(['caixa_fechamento_id' => $fechamento->id]);
        });

        return redirect()->route('caixa.diaria')
            ->with('success', '✅ Caixa fechado com relatório salvo.');
=======
        cache()->put('caixa_fechado_em', $agora->toIso8601String(), now()->addDays(2));

        $historico   = cache()->get('caixa_historico_fechamentos', []);
        $historico[] = [
            'fechado_em' => $agora->format('d/m/Y H:i'),
            'usuario'    => Auth::user()->name,
            'total'      => Payment::whereDate('created_at', $agora)->where('status', 'confirmado')->sum('valor_final'),
        ];
        cache()->put('caixa_historico_fechamentos', array_slice($historico, -10), now()->addDays(30));

        return redirect()->route('caixa.diaria')->with('success', '✅ Caixa fechado! Reabre automaticamente amanhã às 10h.');
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    }

    public function abrirCaixa(): RedirectResponse
    {
<<<<<<< HEAD
        if (Auth::user()?->role !== 'gerente') {
            abort(403);
        }

        $fechamentoAtual = CaixaFechamento::whereNull('reaberto_em')
            ->orderByDesc('fechado_em')
            ->first();

        if ($fechamentoAtual) {
            $fechamentoAtual->update([
                'reaberto_em'  => now(),
                'reaberto_por' => Auth::id(),
            ]);
        }

=======
        if (!Auth::user() || Auth::user()->role !== 'gerente') {
            abort(403);
        }
        cache()->forget('caixa_fechado_em');
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        return redirect()->route('caixa.diaria')->with('success', '✅ Caixa reaberto pelo gerente.');
    }

    public function pagarMesa(): View
    {
<<<<<<< HEAD
        if (!in_array(Auth::user()?->role, ['caixa', 'gerente'])) {
            abort(403);
        }

        // Só mesas com conta fechada e aguardando pagamento.
        $mesas = Table::with([
            'orders' => fn($q) => $q->where('status', 'aguardando_pagamento'),
=======
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente'])) {
            abort(403);
        }

        // Soft hide: só mesas com pedidos ativos (não pagos)
        $mesas = Table::with([
            'orders' => fn($q) => $q->whereIn('status', [
                'aberto', 'em_preparo', 'pronto_entrega', 'pronto', 'aguardando_pagamento',
            ]),
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        ])->get()->filter(fn($m) => $m->orders->isNotEmpty());

        return view('caixa.pagar-mesa', compact('mesas'));
    }
<<<<<<< HEAD

    private function periodoInicioAtual(): Carbon
    {
        $ultimoFechamentoReaberto = CaixaFechamento::whereNotNull('reaberto_em')
            ->orderByDesc('reaberto_em')
            ->first();

        return $ultimoFechamentoReaberto?->reaberto_em ?? now()->copy()->startOfDay();
    }

    private function pagamentosDoPeriodo(Carbon $inicio, Carbon $fim)
    {
        return Payment::where('status', 'confirmado')
            ->whereBetween('created_at', [$inicio, $fim]);
    }

    private function resumoFinanceiro(Carbon $inicio, Carbon $fim): array
    {
        $pagamentos = $this->pagamentosDoPeriodo($inicio, $fim);
        $totaisPorMetodo = (clone $pagamentos)
            ->selectRaw('metodo, SUM(valor_final) as total, COUNT(*) as quantidade')
            ->groupBy('metodo')
            ->get()
            ->keyBy('metodo');

        $dinheiro = (float) ($totaisPorMetodo->get('dinheiro')->total ?? 0);
        $pix = (float) ($totaisPorMetodo->get('pix')->total ?? 0);
        $debito = (float) ($totaisPorMetodo->get('cartao_debito')->total ?? 0);
        $credito = (float) ($totaisPorMetodo->get('cartao_credito')->total ?? 0);
        $compras = (float) Purchase::whereBetween('created_at', [$inicio, $fim])
            ->where('status', 'recebido')
            ->sum('total');
        $sangrias = (float) Sangria::whereBetween('created_at', [$inicio, $fim])->sum('valor');

        return [
            'dinheiro'              => round($dinheiro, 2),
            'pix'                   => round($pix, 2),
            'cartao_debito'         => round($debito, 2),
            'cartao_credito'        => round($credito, 2),
            'total_vendido'         => round($dinheiro + $pix + $debito + $credito, 2),
            'compras'               => round($compras, 2),
            'sangrias'              => round($sangrias, 2),
            'valor_esperado_caixa'  => round($dinheiro - $compras - $sangrias, 2),
            'total_pagamentos'      => (clone $pagamentos)->count(),
        ];
    }

    private function comandasAbertas()
    {
        return Order::whereNotIn('status', ['pago', 'cancelado'])
            ->with('table', 'user', 'items')
            ->orderBy('created_at')
            ->get();
    }

    private function relatorioComandasAbertas($comandas): array
    {
        return $comandas->map(fn(Order $order) => [
            'comanda'       => str_pad($order->id, 4, '0', STR_PAD_LEFT),
            'mesa'          => $order->table->numero ?? null,
            'valor_pendente'=> (float) $order->total,
            'garcom'        => $order->user->name ?? null,
            'status'        => $order->status,
        ])->values()->all();
    }
}
=======
}
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
