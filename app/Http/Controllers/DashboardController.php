<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Sangria;
use App\Models\Table;
use App\Models\StockItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $pedidosAbertos = Order::where('status', 'aberto')->count();
        $mesasOcupadas  = Table::where('status', 'ocupada')->count();
        $totalMesas     = Table::count();

        $dataHoje = Carbon::today();
        $vendaHoje = Payment::whereDate('created_at', $dataHoje)
            ->where('status', 'confirmado')
            ->sum('valor_final');

        $pedidosEmPreparo = Order::where('status', 'em_preparo')->with('table', 'items')->get();

        $estoqueAlerta = StockItem::whereRaw('quantidade_atual <= quantidade_minima')->get();

        return match ($user->role) {
            'gerente' => view('dashboard.admin', [
                'pedidosAbertos'   => $pedidosAbertos,
                'mesasOcupadas'    => $mesasOcupadas,
                'totalMesas'       => $totalMesas,
                'vendaHoje'        => $vendaHoje,
                'pedidosEmPreparo' => $pedidosEmPreparo,
                'estoqueAlerta'    => $estoqueAlerta,
            ]),

            'garcom' => view('dashboard.garcom', [
                'mesas' => Table::with([
                    'orders' => fn($q) => $q->whereIn('status', [
                        'aberto', 'em_preparo', 'pronto', 'pronto_entrega', 'aguardando_pagamento',
                    ]),
                ])->orderBy('numero')->get(),

                'pedidosGarcom' => Order::where('user_id', $user->id)
                    ->whereDate('created_at', $dataHoje)
                    ->with('table', 'items')
                    ->orderByDesc('created_at')
                    ->get(),

                'categorias'    => Category::with('menuItems')->get(),
                'mesasOcupadas' => $mesasOcupadas,
                'totalMesas'    => $totalMesas,
                'pedidosProntosPagamento' => Order::whereIn('status', ['pronto', 'pronto_entrega'])
                    ->with('table', 'items')
                    ->get(),
                'pagamentosDia'      => Payment::whereDate('created_at', $dataHoje)
                    ->where('status', 'confirmado')
                    ->with('order')
                    ->orderByDesc('created_at')
                    ->get(),
                'totalPagamentosDia' => Payment::whereDate('created_at', $dataHoje)
                    ->where('status', 'confirmado')
                    ->sum('valor_final'),
            ]),

            'chef'  => app(ChefController::class)->dashboard(),
            'caixa' => app(CaixaController::class)->dashboard(),

            default => view('dashboard.admin', [
                'pedidosAbertos'   => $pedidosAbertos,
                'mesasOcupadas'    => $mesasOcupadas,
                'totalMesas'       => $totalMesas,
                'vendaHoje'        => $vendaHoje,
                'pedidosEmPreparo' => $pedidosEmPreparo,
                'estoqueAlerta'    => $estoqueAlerta,
            ]),
        };
    }

    public function vendas()
    {
        $dataHoje   = Carbon::today();
        $dataInicio = $dataHoje->copy()->startOfMonth();
        $dataFim    = $dataHoje->copy()->endOfMonth();

        $vendas = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->with('order.table')
            ->orderByDesc('created_at')
            ->get();

        $totalMes  = $vendas->sum('valor_final');
        $totalHoje = Payment::whereDate('created_at', $dataHoje)
            ->where('status', 'confirmado')
            ->sum('valor_final');

        $vendasPorDia = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->selectRaw('DATE(created_at) as dia, SUM(valor_final) as total')
            ->groupBy('dia')
            ->orderByDesc('total')
            ->get();

        $topDias    = $vendasPorDia->take(3);
        $topDiasIds = $topDias->pluck('dia')->toArray();

        $vendasGrafico = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->selectRaw('DATE(created_at) as dia, SUM(valor_final) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return view('dashboard.vendas', [
            'vendas'        => $vendas,
            'totalMes'      => $totalMes,
            'totalHoje'     => $totalHoje,
            'topDias'       => $topDias,
            'topDiasIds'    => $topDiasIds,
            'vendasGrafico' => $vendasGrafico,
        ]);
    }

    public function mesas()
    {
        $mesas = Table::with('garcom')->get();
        return view('dashboard.mesas', compact('mesas'));
    }

    public function pedidos()
    {
        $pedidos = Order::with('table', 'user', 'items')->orderByDesc('created_at')->get();
        return view('dashboard.pedidos', compact('pedidos'));
    }

    public function relatorios()
    {
        if (Auth::user()->role !== 'gerente') abort(403);
        
        $dataInicio = request('data_inicio') 
            ? Carbon::parse(request('data_inicio'))->startOfDay()
            : Carbon::today()->subDays(29)->startOfDay();
        
        $dataFim = request('data_fim')
            ? Carbon::parse(request('data_fim'))->endOfDay()
            : Carbon::today()->endOfDay();
        
        $vendas = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->with('order.table')
            ->orderByDesc('created_at')
            ->get();
        
        $totalVendas = $vendas->sum('valor_final');
        $totalPedidos = Order::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', '!=', 'cancelado')
            ->count();
        
        $ticketMedio = $totalPedidos > 0 ? round($totalVendas / $totalPedidos, 2) : 0;
        
        $vendasPorDia = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->selectRaw('DATE(created_at) as dia, SUM(valor_final) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
        
        // ===== NOVAS VARIÁVEIS =====
        $totalCompras = Purchase::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'recebido')
            ->sum('total');
        
        $totalSangrias = Sangria::whereBetween('created_at', [$dataInicio, $dataFim])
            ->sum('valor');
        
        $lucroEstimado = $totalVendas - $totalCompras - $totalSangrias;
        
        return view('dashboard.relatorios', compact(
            'dataInicio',
            'dataFim',
            'vendas',
            'totalVendas',
            'totalPedidos',
            'ticketMedio',
            'vendasPorDia',
            'totalCompras',
            'totalSangrias',
            'lucroEstimado'
        ));
    }
}