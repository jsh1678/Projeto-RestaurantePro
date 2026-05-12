<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControleEstoqueController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'gerente') abort(403);

        $itens = StockItem::orderBy('nome')->get();

        $di = request('data_inicio')
            ? Carbon::parse(request('data_inicio'))->startOfDay()
            : Carbon::today()->subDays(29)->startOfDay();
        $df = request('data_fim')
            ? Carbon::parse(request('data_fim'))->endOfDay()
            : Carbon::today()->endOfDay();

        $entradas = StockMovement::with('stockItem', 'user')
            ->where('tipo', 'entrada')
            ->whereBetween('created_at', [$di, $df])
            ->orderByDesc('created_at')->get();

        $saidas = StockMovement::with('stockItem', 'user')
            ->where('tipo', 'saida')
            ->whereBetween('created_at', [$di, $df])
            ->orderByDesc('created_at')->get();

        $ajustes = StockMovement::with('stockItem', 'user')
            ->where('tipo', 'ajuste')
            ->whereBetween('created_at', [$di, $df])
            ->orderByDesc('created_at')->get();

        $saldo = $itens->map(function ($item) use ($di, $df) {
            $entTotal = StockMovement::where('stock_item_id', $item->id)->where('tipo', 'entrada')->whereBetween('created_at', [$di, $df])->sum('quantidade');
            $saiTotal = StockMovement::where('stock_item_id', $item->id)->where('tipo', 'saida')->whereBetween('created_at', [$di, $df])->sum('quantidade');
            return [
                'item'     => $item,
                'entradas' => $entTotal,
                'saidas'   => $saiTotal,
                'saldo'    => $item->quantidade_atual,
                'valor'    => $item->quantidade_atual * $item->preco_unitario,
            ];
        });

        $totalEntradas = $entradas->sum('quantidade');
        $totalSaidas   = $saidas->sum('quantidade');
        $valorEstoque  = $itens->sum(fn($i) => $i->quantidade_atual * $i->preco_unitario);

        return view('controle.estoque', compact(
            'itens', 'entradas', 'saidas', 'ajustes', 'saldo',
            'totalEntradas', 'totalSaidas', 'valorEstoque', 'di', 'df'
        ));
    }

    /**
     * Converte automaticamente unidades: 1000g -> 1kg | 1000ml -> 1L
     */
    private function converterUnidade(float $quantidade, string $unidade): array
    {
        if ($unidade === 'g' && $quantidade >= 1000) {
            $conv = round($quantidade / 1000, 3);
            return [$conv, 'kg', "({$quantidade}g convertido para {$conv}kg)"];
        }
        if ($unidade === 'ml' && $quantidade >= 1000) {
            $conv = round($quantidade / 1000, 3);
            return [$conv, 'l', "({$quantidade}ml convertido para {$conv}L)"];
        }
        return [$quantidade, $unidade, null];
    }

    public function entrada(Request $request)
    {
        if (Auth::user()->role !== 'gerente') abort(403);
        $v = $request->validate([
            'stock_item_id' => 'required|exists:stock_items,id',
            'quantidade'    => 'required|numeric|min:0.001|max:9999999',
        ]);
        $item = StockItem::find($v['stock_item_id']);

        [$qtd, $unidade, $msgConv] = $this->converterUnidade((float)$v['quantidade'], $item->unidade);

        if ($msgConv && $unidade !== $item->unidade) {
            $item->unidade = $unidade;
        }

        $anterior = $item->quantidade_atual;
        $item->quantidade_atual += $qtd;
        $item->save();

        StockMovement::create([
            'stock_item_id'       => $item->id,
            'user_id'             => Auth::id(),
            'tipo'                => 'entrada',
            'quantidade'          => $qtd,
            'quantidade_anterior' => $anterior,
            'quantidade_nova'     => $item->quantidade_atual,
            'motivo'              => 'Entrada manual',
        ]);

        $extra = $msgConv ? " $msgConv" : '';
        return back()->with('success', "✅ Entrada de {$qtd} {$item->unidade} registrada para {$item->nome}!{$extra}");
    }

    public function saida(Request $request)
    {
        if (Auth::user()->role !== 'gerente') abort(403);
        $v = $request->validate([
            'stock_item_id' => 'required|exists:stock_items,id',
            'quantidade'    => 'required|numeric|min:0.001|max:9999999',
            'motivo'        => 'required|string|max:255',
        ], [
            'motivo.required' => 'Informe o motivo da saída.',
        ]);
        $item = StockItem::find($v['stock_item_id']);

        [$qtd, , $msgConv] = $this->converterUnidade((float)$v['quantidade'], $item->unidade);

        if ($item->quantidade_atual < $qtd) {
            return back()->withInput()->with('error', "❌ Estoque insuficiente. Disponível: {$item->quantidade_atual} {$item->unidade}.");
        }

        $anterior = $item->quantidade_atual;
        $item->quantidade_atual -= $qtd;
        $item->save();

        StockMovement::create([
            'stock_item_id'       => $item->id,
            'user_id'             => Auth::id(),
            'tipo'                => 'saida',
            'quantidade'          => $qtd,
            'quantidade_anterior' => $anterior,
            'quantidade_nova'     => $item->quantidade_atual,
            'motivo'              => $v['motivo'],
        ]);

        $extra = $msgConv ? " $msgConv" : '';
        return back()->with('success', "✅ Saída de {$qtd} {$item->unidade} registrada para {$item->nome}!{$extra}");
    }

    /**
     * INVENTÁRIO FÍSICO (antigo "ajuste")
     * O usuário informa a quantidade real contada.
     * O sistema calcula a diferença e atualiza o saldo para o valor real.
     */
    public function ajuste(Request $request)
    {
        if (Auth::user()->role !== 'gerente') abort(403);
        $v = $request->validate([
            'stock_item_id'   => 'required|exists:stock_items,id',
            'quantidade_real' => 'required|numeric|min:0|max:9999999',
            'motivo'          => 'nullable|string|max:255',
        ]);

        $item      = StockItem::find($v['stock_item_id']);
        $anterior  = $item->quantidade_atual;
        $nova      = round((float)$v['quantidade_real'], 3);
        $diferenca = $nova - $anterior;

        // Atualiza o saldo para a quantidade real contada
        $item->quantidade_atual = $nova;
        $item->save();

        StockMovement::create([
            'stock_item_id'       => $item->id,
            'user_id'             => Auth::id(),
            'tipo'                => 'ajuste',
            'quantidade'          => abs($diferenca),
            'quantidade_anterior' => $anterior,
            'quantidade_nova'     => $nova,
            'motivo'              => $v['motivo'] ?: 'Inventário físico',
        ]);

        $sinal = $diferenca >= 0 ? '+' : '';
        $msg   = "📋 Inventário registrado para {$item->nome}. Saldo atualizado de {$anterior} para {$nova} {$item->unidade} (diferença: {$sinal}" . number_format($diferenca, 3, ',', '.') . ").";

        return back()->with('success', $msg);
    }
}
