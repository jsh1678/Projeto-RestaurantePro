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
    
    $pedidosCancelados = Order::whereBetween('created_at', [$dataInicio, $dataFim])
        ->where('status', 'cancelado')
        ->count();
    
    $ticketMedio = $totalPedidos > 0 ? round($totalVendas / $totalPedidos, 2) : 0;
    
    $vendasPorDia = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
        ->where('status', 'confirmado')
        ->selectRaw('DATE(created_at) as dia, SUM(valor_final) as total')
        ->groupBy('dia')
        ->orderBy('dia')
        ->get();
    
    $totalCompras = Purchase::whereBetween('created_at', [$dataInicio, $dataFim])
        ->where('status', 'recebido')
        ->sum('total');
    
    $totalSangrias = Sangria::whereBetween('created_at', [$dataInicio, $dataFim])
        ->sum('valor');
    
    $lucroEstimado = $totalVendas - $totalCompras - $totalSangrias;
    
    $itensMaisVendidos = OrderItem::with('menuItem')
        ->whereHas('order', function($q) use ($dataInicio, $dataFim) {
            $q->whereBetween('created_at', [$dataInicio, $dataFim])
              ->where('status', '!=', 'cancelado');
        })
        ->get()
        ->groupBy('menu_item_id')
        ->map(function($g) {
            return [
                'nome' => $g->first()->menuItem->nome ?? '—',
                'quantidade' => $g->sum('quantidade'),
                'receita' => $g->sum('subtotal'),
            ];
        })
        ->sortByDesc('quantidade')
        ->take(10);
    
    $desempenhoGarcom = Order::whereBetween('created_at', [$dataInicio, $dataFim])
        ->where('status', '!=', 'cancelado')
        ->with('user')
        ->get()
        ->groupBy('user_id')
        ->map(function($g) {
            return [
                'nome' => $g->first()->user->name ?? '—',
                'pedidos' => $g->count(),
                'total' => $g->sum('total'),
            ];
        })
        ->sortByDesc('total')
        ->take(5);
    
    $metodosPagamento = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
        ->where('status', 'confirmado')
        ->get()
        ->groupBy('metodo')
        ->map(function($g) {
            return [
                'quantidade' => $g->count(),
                'total' => $g->sum('valor_final'),
            ];
        });
    
    return view('dashboard.relatorios', compact(
        'dataInicio',
        'dataFim',
        'vendas',
        'totalVendas',
        'totalPedidos',
        'pedidosCancelados',
        'ticketMedio',
        'vendasPorDia',
        'totalCompras',
        'totalSangrias',
        'lucroEstimado',
        'itensMaisVendidos',
        'desempenhoGarcom',
        'metodosPagamento'
    ));
}