<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Sangria;
use App\Models\Purchase;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CaixaController extends Controller
{
    public function dashboard(): View
    {
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente'])) {
            abort(403);
        }

        $dataHoje  = Carbon::today();
        $dataInicio = $dataHoje->copy()->startOfMonth();
        $dataFim    = $dataHoje->copy()->endOfMonth();

        $vendaHoje  = Payment::whereDate('created_at', $dataHoje)->where('status','confirmado')->sum('valor_final');
        $vendaDoMes = Payment::whereBetween('created_at', [$dataInicio,$dataFim])->where('status','confirmado')->sum('valor_final');

        $pagamentosHoje = Payment::whereDate('created_at', $dataHoje)->with('order')->orderByDesc('created_at')->get();

        $pedidosProntosPagamento = Order::whereIn('status',['pronto_entrega','aguardando_pagamento'])
            ->with('table','user','items')->orderBy('created_at')->get();

        $pagamentosCartao = Payment::whereDate('created_at', $dataHoje)
            ->whereIn('metodo',['cartao_credito','cartao_debito'])->where('status','confirmado')->sum('valor_final');
        $pagamentosNumerario = Payment::whereDate('created_at', $dataHoje)
            ->where('metodo','dinheiro')->where('status','confirmado')->sum('valor_final');

        $comprasHoje  = Purchase::whereDate('created_at', $dataHoje)->where('status','recebido')->sum('total');
        $comprasDoMes = Purchase::whereBetween('created_at', [$dataInicio,$dataFim])->where('status','recebido')->sum('total');

        $sangriasHoje  = Sangria::whereDate('created_at', $dataHoje)->sum('valor');
        $sangriasDoMes = Sangria::whereBetween('created_at', [$dataInicio,$dataFim])->sum('valor');
        $historicoSangrias = Sangria::with('user')->orderByDesc('created_at')->limit(20)->get();

        $saldoHoje = $vendaHoje - $comprasHoje - $sangriasHoje;

        return view('dashboard.caixa', compact(
            'vendaHoje','vendaDoMes','pagamentosHoje','pedidosProntosPagamento',
            'pagamentosCartao','pagamentosNumerario','comprasHoje','comprasDoMes',
            'saldoHoje','sangriasHoje','sangriasDoMes','historicoSangrias'
        ));
    }

    public function registrarSangria(): RedirectResponse
    {
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa','gerente'])) {
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

        return back()->with('success', '✅ Sangria de R$ ' . number_format($validated['valor'],2,',','.') . ' registrada!');
    }

    public function confirmarPagamento(Order $order): RedirectResponse|JsonResponse
    {
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa','gerente','garcom'])) {
            abort(403);
        }

        // Verificar se o caixa está fechado
        $caixaFechadoEm = cache()->get('caixa_fechado_em');
        if ($caixaFechadoEm) {
            $reabreEm = Carbon::parse($caixaFechadoEm)->addDay()->setTime(10, 0, 0);
            if (now()->lessThan($reabreEm)) {
                if (request()->expectsJson()) {
                    return response()->json(['success'=>false,'message'=>'🔒 Caixa fechado.'], 403);
                }
                return back()->with('error', '🔒 Caixa fechado. Nenhum pagamento pode ser feito até amanhã às 10h.');
            }
        }

        try {
            $validated = request()->validate([
                'metodo'     => 'required|in:dinheiro,cartao_credito,cartao_debito,pix',
                'valor_pago' => 'required|numeric|min:0.01',
            ]);
        } catch (ValidationException $e) {
            if (request()->expectsJson()) {
                return response()->json(['success'=>false,'errors'=>$e->errors()], 422);
            }
            return back()->withErrors($e)->withInput();
        }

        $order->load('items');
        $total = $order->items->sum('subtotal');

        Payment::create([
            'order_id'       => $order->id,
            'valor'          => $total,
            'valor_final'    => $validated['valor_pago'],
            'metodo'         => $validated['metodo'],
            'status'         => 'confirmado',
            'data_pagamento' => now(),
        ]);

        $order->update(['status' => 'pago']);

        if ($order->table) {
            $pedidosAtivos = Order::where('table_id', $order->table_id)
                ->whereNotIn('status',['pago','cancelado'])
                ->where('id','!=',$order->id)
                ->count();
            if ($pedidosAtivos === 0) {
                $order->table->update(['status' => 'disponivel']);
            }
        }

        if (request()->expectsJson()) {
            return response()->json(['success'=>true,'message'=>'Pagamento confirmado!']);
        }

        return redirect()->route('dashboard')->with('success', '✅ Pagamento confirmado!');
    }

    public function diaria(): View
    {
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente'])) {
            abort(403);
        }

        $dataHoje = Carbon::today();

        // Verifica se o caixa está fechado (cache/sessão)
        $caixaFechadoEm = cache()->get('caixa_fechado_em');
        $caixaAberto    = true;

        if ($caixaFechadoEm) {
            $fechadoEm    = Carbon::parse($caixaFechadoEm);
            $reabreEm     = $fechadoEm->copy()->addDay()->setTime(10, 0, 0);
            $caixaAberto  = now()->greaterThanOrEqualTo($reabreEm);
            if ($caixaAberto) {
                cache()->forget('caixa_fechado_em');
            }
        }

        // Conciliação por método de pagamento
        $metodos = ['pix', 'cartao_credito', 'cartao_debito', 'dinheiro'];
        $conciliacao = collect($metodos)->map(function ($metodo) use ($dataHoje) {
            $pagamentos = Payment::whereDate('created_at', $dataHoje)
                ->where('metodo', $metodo)
                ->where('status', 'confirmado');
            return [
                'metodo'      => $metodo,
                'label'       => ucfirst(str_replace('_', ' ', $metodo)),
                'total'       => $pagamentos->sum('valor_final'),
                'quantidade'  => $pagamentos->count(),
            ];
        });

        $totalDia        = Payment::whereDate('created_at', $dataHoje)->where('status', 'confirmado')->sum('valor_final');
        $totalPedidos    = Payment::whereDate('created_at', $dataHoje)->where('status', 'confirmado')->count();
        $totalCancelados = Order::whereDate('created_at', $dataHoje)->where('status', 'cancelado')->count();

        // Histórico dos últimos fechamentos
        $fechamentos = cache()->get('caixa_historico_fechamentos', []);

        return view('caixa.diaria', compact(
            'conciliacao', 'totalDia', 'totalPedidos',
            'totalCancelados', 'caixaAberto', 'caixaFechadoEm',
            'fechamentos', 'dataHoje'
        ));
    }

    public function fecharCaixa(): RedirectResponse
    {
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa', 'gerente'])) {
            abort(403);
        }

        $agora = now();
        cache()->put('caixa_fechado_em', $agora->toIso8601String(), now()->addDays(2));

        // Salva no histórico
        $historico   = cache()->get('caixa_historico_fechamentos', []);
        $historico[] = [
            'fechado_em'  => $agora->format('d/m/Y H:i'),
            'usuario'     => Auth::user()->name,
            'total'       => Payment::whereDate('created_at', $agora)->where('status', 'confirmado')->sum('valor_final'),
        ];
        cache()->put('caixa_historico_fechamentos', array_slice($historico, -10), now()->addDays(30));

        return redirect()->route('caixa.diaria')->with('success', '✅ Caixa fechado! Reabre automaticamente amanhã às 10h.');
    }

    public function abrirCaixa(): RedirectResponse
    {
        if (!Auth::user() || Auth::user()->role !== 'gerente') {
            abort(403);
        }
        cache()->forget('caixa_fechado_em');
        return redirect()->route('caixa.diaria')->with('success', '✅ Caixa reaberto pelo gerente.');
    }

    public function pagarMesa(): View
    {
        if (!Auth::user() || !in_array(Auth::user()->role, ['caixa','gerente'])) {
            abort(403);
        }

        $mesas = Table::with([
            'orders' => fn($q) => $q->whereIn('status',['aberto','em_preparo','pronto_entrega','pronto','aguardando_pagamento'])
        ])->get();

        return view('caixa.pagar-mesa', compact('mesas'));
    }
}
