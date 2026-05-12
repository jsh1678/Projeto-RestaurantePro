@extends('layouts.app')
@section('page-title', 'Relatórios')
@section('breadcrumb', 'Análise gerencial por período')

@section('styles')
<style>
.rel-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:14px; margin-bottom:24px; }
.rel-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:18px; position:relative; overflow:hidden; }
.rel-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--cc,var(--accent)); }
.rel-card-label { font-size:12px; color:var(--muted); margin-bottom:6px; }
.rel-card-value { font-size:22px; font-weight:800; color:#fff; }
.rel-card-sub   { font-size:12px; color:var(--muted); margin-top:4px; }

.rank-row { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid rgba(255,255,255,.05); }
.rank-row:last-child { border-bottom:none; }
.rank-num { width:24px; height:24px; border-radius:6px; background:rgba(249,115,22,.15); color:var(--accent); font-size:11px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.rank-bar-bg { flex:1; height:6px; background:rgba(255,255,255,.06); border-radius:3px; overflow:hidden; }
.rank-bar    { height:100%; background:var(--accent); border-radius:3px; transition:.4s; }

.metodo-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid rgba(255,255,255,.05); }
.metodo-row:last-child { border-bottom:none; }

.chart-wrap { display:flex; align-items:flex-end; gap:4px; height:120px; margin-top:12px; }
.chart-bar-col { flex:1; display:flex; flex-direction:column; align-items:center; gap:4px; min-width:0; }
.chart-bar-col .bar { width:100%; background:rgba(249,115,22,.5); border-radius:4px 4px 0 0; transition:.4s; min-height:4px; }
.chart-bar-col .bar:hover { background:var(--accent); }
.chart-bar-col .lbl { font-size:9px; color:var(--muted); text-align:center; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; width:100%; }
</style>
@endsection

@section('content')

{{-- Filtro de período --}}
<div class="panel" style="margin-bottom:20px">
    <form method="GET" action="{{ route('dashboard.relatorios') }}"
          style="display:flex; gap:14px; align-items:flex-end; flex-wrap:wrap">
        <div class="form-group" style="margin:0; flex:1; min-width:150px">
            <label>Data Início</label>
            <input type="date" name="data_inicio" class="form-control"
                   value="{{ $dataInicio->format('Y-m-d') }}">
        </div>
        <div class="form-group" style="margin:0; flex:1; min-width:150px">
            <label>Data Fim</label>
            <input type="date" name="data_fim" class="form-control"
                   value="{{ $dataFim->format('Y-m-d') }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrar</button>
        <a href="{{ route('dashboard.relatorios') }}" class="btn btn-secondary">Últimos 30 dias</a>
    </form>
</div>

{{-- KPIs principais --}}
<div class="rel-grid">
    <div class="rel-card" style="--cc:#22c55e">
        <div class="rel-card-label">💰 Faturamento</div>
        <div class="rel-card-value">R$ {{ number_format($totalVendas,2,',','.') }}</div>
        <div class="rel-card-sub">Total no período</div>
    </div>
    <div class="rel-card" style="--cc:#ef4444">
        <div class="rel-card-label">🛒 Compras</div>
        <div class="rel-card-value">R$ {{ number_format($totalCompras,2,',','.') }}</div>
        <div class="rel-card-sub">Custo de estoque</div>
    </div>
    <div class="rel-card" style="--cc:#f97316">
        <div class="rel-card-label">💸 Sangrias</div>
        <div class="rel-card-value">R$ {{ number_format($totalSangrias,2,',','.') }}</div>
        <div class="rel-card-sub">Retiradas do caixa</div>
    </div>
    <div class="rel-card" style="--cc:{{ $lucroEstimado >= 0 ? '#4ade80' : '#f87171' }}">
        <div class="rel-card-label">📈 Lucro Estimado</div>
        <div class="rel-card-value" style="color:{{ $lucroEstimado >= 0 ? '#4ade80' : '#f87171' }}">
            R$ {{ number_format($lucroEstimado,2,',','.') }}
        </div>
        <div class="rel-card-sub">Vendas − compras − sangrias</div>
    </div>
    <div class="rel-card" style="--cc:#3b82f6">
        <div class="rel-card-label">🧾 Pedidos</div>
        <div class="rel-card-value">{{ $totalPedidos }}</div>
        <div class="rel-card-sub">{{ $pedidosCancelados }} cancelado(s)</div>
    </div>
    <div class="rel-card" style="--cc:#a855f7">
        <div class="rel-card-label">🎯 Ticket Médio</div>
        <div class="rel-card-value">R$ {{ number_format($ticketMedio,2,',','.') }}</div>
        <div class="rel-card-sub">Por pagamento</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px">

    {{-- Itens mais vendidos --}}
    <div class="panel" style="margin:0">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-trophy"></i> Itens Mais Vendidos</div>
        </div>
        @php $maxQtd = $itensMaisVendidos->max('quantidade') ?: 1; @endphp
        @forelse($itensMaisVendidos as $i => $item)
        <div class="rank-row">
            <div class="rank-num">{{ $i+1 }}</div>
            <div style="flex:1; min-width:0">
                <div style="font-size:13px; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis">{{ $item['nome'] }}</div>
                <div class="rank-bar-bg" style="margin-top:5px">
                    <div class="rank-bar" style="width:{{ ($item['quantidade']/$maxQtd)*100 }}%"></div>
                </div>
            </div>
            <div style="text-align:right; flex-shrink:0; margin-left:10px">
                <div style="font-weight:800; color:#fff">{{ $item['quantidade'] }}x</div>
                <div style="font-size:11px; color:var(--muted)">R$ {{ number_format($item['total'],2,',','.') }}</div>
            </div>
        </div>
        @empty
        <div class="empty-state" style="padding:24px"><p>Sem dados no período</p></div>
        @endforelse
    </div>

    {{-- Método de pagamento + Garçons --}}
    <div style="display:flex; flex-direction:column; gap:20px">

        <div class="panel" style="margin:0">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-credit-card"></i> Forma de Pagamento</div>
            </div>
            @php
                $metodoLabel = ['dinheiro'=>'💵 Dinheiro','cartao_credito'=>'💳 Crédito','cartao_debito'=>'💳 Débito','pix'=>'📱 Pix'];
                $totalMetodo = $porMetodo->sum('total') ?: 1;
            @endphp
            @forelse($porMetodo as $metodo => $dados)
            <div class="metodo-row">
                <div>
                    <div style="font-weight:600; color:#fff; font-size:13px">{{ $metodoLabel[$metodo] ?? $metodo }}</div>
                    <div style="font-size:11px; color:var(--muted)">{{ $dados['qtd'] }} pagamento(s)</div>
                </div>
                <div style="text-align:right">
                    <div style="font-weight:800; color:#4ade80">R$ {{ number_format($dados['total'],2,',','.') }}</div>
                    <div style="font-size:11px; color:var(--muted)">{{ number_format(($dados['total']/$totalMetodo)*100,1) }}%</div>
                </div>
            </div>
            @empty
            <div class="empty-state" style="padding:20px"><p>Sem pagamentos</p></div>
            @endforelse
        </div>

        <div class="panel" style="margin:0">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-concierge-bell"></i> Desempenho Garçons</div>
            </div>
            @forelse($porGarcom as $g)
            <div class="metodo-row">
                <div>
                    <div style="font-weight:600; color:#fff; font-size:13px">{{ $g['nome'] }}</div>
                    <div style="font-size:11px; color:var(--muted)">{{ $g['pedidos'] }} pedido(s)</div>
                </div>
                <div style="font-weight:800; color:var(--accent)">R$ {{ number_format($g['total'],2,',','.') }}</div>
            </div>
            @empty
            <div class="empty-state" style="padding:20px"><p>Sem dados</p></div>
            @endforelse
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px">

    {{-- Vendas por dia --}}
    <div class="panel" style="margin:0">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-chart-bar"></i> Vendas por Dia</div>
            <span style="font-size:12px; color:var(--muted)">R$ {{ number_format($totalVendas,2,',','.') }} total</span>
        </div>
        @if($vendasPorDia->isEmpty())
        <div class="empty-state" style="padding:24px"><p>Sem dados no período</p></div>
        @else
        @php $maxVenda = $vendasPorDia->max() ?: 1; @endphp
        <div class="chart-wrap">
            @foreach($vendasPorDia as $dia => $valor)
            <div class="chart-bar-col">
                <div class="bar" style="height:{{ ($valor/$maxVenda)*100 }}px" title="{{ $dia }}: R$ {{ number_format($valor,2,',','.') }}"></div>
                <div class="lbl">{{ $dia }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Mesas mais usadas --}}
    <div class="panel" style="margin:0">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-chair"></i> Mesas Mais Usadas</div>
        </div>
        @php $maxMesa = $porMesa->max('pedidos') ?: 1; @endphp
        @forelse($porMesa as $m)
        <div class="rank-row">
            <div style="min-width:60px; font-weight:700; color:#fff; font-size:13px">{{ $m['mesa'] }}</div>
            <div class="rank-bar-bg">
                <div class="rank-bar" style="width:{{ ($m['pedidos']/$maxMesa)*100 }}%"></div>
            </div>
            <div style="text-align:right; margin-left:10px; flex-shrink:0">
                <div style="font-weight:800; color:#fff">{{ $m['pedidos'] }}x</div>
                <div style="font-size:11px; color:var(--muted)">R$ {{ number_format($m['total'],2,',','.') }}</div>
            </div>
        </div>
        @empty
        <div class="empty-state" style="padding:24px"><p>Sem dados</p></div>
        @endforelse
    </div>
</div>

{{-- Estoque crítico --}}
@if($estoqueCritico->isNotEmpty())
<div class="panel">
    <div class="panel-header">
        <div class="panel-title" style="color:#f87171"><i class="fas fa-exclamation-triangle"></i> Estoque Crítico</div>
        <span class="badge badge-danger">{{ $estoqueCritico->count() }} item(ns)</span>
    </div>
    <table>
        <thead><tr><th>Item</th><th>Atual</th><th>Mínimo</th><th>Situação</th></tr></thead>
        <tbody>
        @foreach($estoqueCritico as $e)
        <tr>
            <td style="font-weight:600; color:#fff">{{ $e->nome }}</td>
            <td class="td-mono" style="color:#f87171; font-weight:700">{{ number_format($e->quantidade_atual,2,',','.') }} {{ $e->unidade }}</td>
            <td class="td-mono" style="color:var(--muted)">{{ number_format($e->quantidade_minima,2,',','.') }} {{ $e->unidade }}</td>
            <td><span class="badge badge-danger">⚠️ Repor</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Tabela detalhada de pagamentos --}}
<div class="table-wrap">
    <div class="table-header">
        <h2><i class="fas fa-list"></i> Pagamentos no Período</h2>
        <span class="badge badge-secondary">{{ $pagamentos->count() }}</span>
    </div>
    @if($pagamentos->isEmpty())
        <div class="empty-state"><p>Nenhum pagamento no período</p></div>
    @else
    <table>
        <thead><tr><th>Data</th><th>Pedido</th><th>Mesa</th><th>Método</th><th>Valor</th></tr></thead>
        <tbody>
        @foreach($pagamentos->sortByDesc('created_at') as $pg)
        <tr>
            <td style="color:var(--muted);font-size:12px">{{ $pg->created_at->format('d/m/Y H:i') }}</td>
            <td class="td-mono td-primary">#{{ str_pad($pg->order_id,4,'0',STR_PAD_LEFT) }}</td>
            <td style="color:var(--muted)">Mesa {{ $pg->order->table->numero ?? '—' }}</td>
            <td>
                @php $mi=['dinheiro'=>'💵','cartao_credito'=>'💳','cartao_debito'=>'💳','pix'=>'📱']; @endphp
                {{ $mi[$pg->metodo]??'' }} {{ ucfirst(str_replace('_',' ',$pg->metodo)) }}
            </td>
            <td class="td-mono" style="color:#4ade80;font-weight:700">R$ {{ number_format($pg->valor_final,2,',','.') }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection
