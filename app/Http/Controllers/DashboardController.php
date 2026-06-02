<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\KitchenEvent;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Sangria;
use App\Models\Table;
use App\Models\StockItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                    'orders' => fn($q) => $q->whereNotIn('status', ['pago', 'cancelado']),
                ])->orderBy('numero')->get(),

                'pedidosGarcom' => Order::where('user_id', $user->id)
                    ->whereDate('created_at', $dataHoje)
                    ->with('table', 'items')
                    ->orderByDesc('created_at')
                    ->get(),

                'categorias'    => Category::with('menuItems')->get(),
                'mesasOcupadas' => $mesasOcupadas,
                'totalMesas'    => $totalMesas,
                'pedidosProntosPagamento' => Order::where('status', 'pronto_entrega')
                    ->with('table', 'user', 'items.menuItem')
                    ->orderByRaw('CASE WHEN user_id = ? THEN 0 ELSE 1 END', [$user->id])
                    ->orderBy('horario_termino_preparo')
                    ->orderBy('created_at')
                    ->get(),
                'cozinhaEventCursor' => KitchenEvent::max('id') ?? 0,
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

    public function relatorios(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || $user->role !== 'gerente') {
            abort(403);
        }

        $dataInicio = $request->filled('data_inicio')
            ? Carbon::parse((string) $request->input('data_inicio'))->startOfDay()
            : Carbon::today()->subDays(29)->startOfDay();

        $dataFim = $request->filled('data_fim')
            ? Carbon::parse((string) $request->input('data_fim'))->endOfDay()
            : Carbon::today()->endOfDay();

        // ===== PAGAMENTOS =====
        $pagamentos = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->with('order.table')
            ->orderByDesc('created_at')
            ->get();

        $totalVendas = $pagamentos->sum('valor_final');
        $totalPedidos = Order::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', '!=', 'cancelado')
            ->count();

        $pedidosCancelados = Order::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'cancelado')
            ->count();

        $ticketMedio = $totalPedidos > 0 ? round($totalVendas / $totalPedidos, 2) : 0;

        // ===== VENDAS POR DIA =====
        $vendasPorDia = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->selectRaw('DATE(created_at) as dia, SUM(valor_final) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->pluck('total', 'dia')
            ->toArray();

        // ===== COMPRAS E SANGRIA =====
        $totalCompras = Purchase::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'recebido')
            ->sum('total');

        $totalSangrias = Sangria::whereBetween('created_at', [$dataInicio, $dataFim])
            ->sum('valor');

        $lucroEstimado = $totalVendas - $totalCompras - $totalSangrias;

        // ===== ITENS MAIS VENDIDOS =====
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

        // ===== FORMA DE PAGAMENTO =====
        $porMetodo = Payment::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->get()
            ->groupBy('metodo')
            ->map(function($g) {
                return [
                    'qtd' => $g->count(),
                    'total' => $g->sum('valor_final'),
                ];
            });

        // ===== DESEMPENHO POR GARÇOM =====
        $porGarcom = Order::whereBetween('created_at', [$dataInicio, $dataFim])
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

        // ===== MESAS MAIS USADAS =====
        $porMesa = Order::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', '!=', 'cancelado')
            ->with('table')
            ->get()
            ->groupBy('table_id')
            ->map(function($g) {
                return [
                    'mesa' => $g->first()->table->numero ?? '—',
                    'pedidos' => $g->count(),
                    'total' => $g->sum('total'),
                ];
            })
            ->sortByDesc('pedidos')
            ->take(5);

        // ===== ESTOQUE CRÍTICO =====
        $estoqueCritico = StockItem::whereRaw('quantidade_atual <= quantidade_minima')
            ->where('quantidade_atual', '>', 0)
            ->get();

        return view('dashboard.relatorios', compact(
            'dataInicio',
            'dataFim',
            'pagamentos',
            'totalVendas',
            'totalPedidos',
            'pedidosCancelados',
            'ticketMedio',
            'vendasPorDia',
            'totalCompras',
            'totalSangrias',
            'lucroEstimado',
            'itensMaisVendidos',
            'porMetodo',
            'porGarcom',
            'porMesa',
            'estoqueCritico'
        ));
    }
}
