@extends('layouts.app')
@section('page-title', 'Vendas')
@section('breadcrumb', 'Vendas fechadas e pagamentos confirmados')

@section('styles')
<style>
.vendas-grid {
    display:grid;
    grid-template-columns:repeat(3, minmax(0, 1fr));
    gap:16px;
    margin-bottom:18px;
}
.venda-stat {
    background:var(--bg2);
    border:1px solid var(--border);
    border-radius:8px;
    padding:18px;
}
.venda-stat span {
    display:block;
    color:var(--muted);
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.4px;
    margin-bottom:8px;
}
.venda-stat strong {
    color:var(--text);
    font-size:28px;
    line-height:1;
}
.chart-list {
    display:flex;
    flex-direction:column;
    gap:10px;
}
.chart-row {
    display:grid;
    grid-template-columns:120px 1fr 110px;
    gap:12px;
    align-items:center;
}
.chart-track {
    height:10px;
    border-radius:999px;
    background:var(--bg3);
    overflow:hidden;
}
.chart-bar {
    height:100%;
    min-width:6px;
    border-radius:999px;
    background:linear-gradient(90deg, var(--accent), #f59e0b);
}
.payment-method {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:76px;
    padding:4px 8px;
    border-radius:6px;
    background:rgba(245,158,11,.12);
    color:#fbbf24;
    font-size:11px;
    font-weight:800;
    text-transform:uppercase;
}
@media (max-width: 920px) {
    .vendas-grid { grid-template-columns:1fr; }
    .chart-row { grid-template-columns:84px 1fr; }
    .chart-row strong { grid-column:2; }
}
</style>
@endsection

@section('content')
@php
    $maiorVendaDia = max(1, (float) $vendasGrafico->max('total'));
    $ticketMedio = $vendas->count() > 0 ? $totalMes / $vendas->count() : 0;
@endphp

<div class="vendas-grid">
    <div class="venda-stat">
        <span>Vendas hoje</span>
        <strong>R$ {{ number_format($totalHoje, 2, ',', '.') }}</strong>
    </div>
    <div class="venda-stat">
        <span>Total do mês</span>
        <strong>R$ {{ number_format($totalMes, 2, ',', '.') }}</strong>
    </div>
    <div class="venda-stat">
        <span>Ticket médio</span>
        <strong>R$ {{ number_format($ticketMedio, 2, ',', '.') }}</strong>
    </div>
</div>

<div class="panel" style="margin-bottom:18px">
    <div class="panel-header">
        <div class="panel-title"><i class="fa-solid fa-chart-line"></i> Vendas por dia</div>
    </div>
    <div class="chart-list">
        @forelse($vendasGrafico as $dia)
            @php
                $percentual = max(4, ((float) $dia->total / $maiorVendaDia) * 100);
            @endphp
            <div class="chart-row">
                <span style="color:var(--muted); font-size:12px">{{ \Carbon\Carbon::parse($dia->dia)->format('d/m/Y') }}</span>
                <div class="chart-track">
                    <div class="chart-bar" style="width:{{ $percentual }}%"></div>
                </div>
                <strong class="td-mono">R$ {{ number_format($dia->total, 2, ',', '.') }}</strong>
            </div>
        @empty
            <div class="empty-state"><p>Nenhuma venda confirmada neste mês</p></div>
        @endforelse
    </div>
</div>

<div class="table-wrap">
    <div class="table-header">
        <h2>Vendas confirmadas ({{ $vendas->count() }})</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Pedido</th>
                <th>Mesa</th>
                <th>Pagamento</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse($vendas as $venda)
            <tr>
                <td>{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    @if($venda->order)
                        <a href="{{ route('orders.show', $venda->order) }}" class="td-primary">
                            #{{ str_pad($venda->order->id, 4, '0', STR_PAD_LEFT) }}
                        </a>
                    @else
                        <span class="td-primary">Sem pedido</span>
                    @endif
                </td>
                <td>{{ $venda->order?->table ? 'Mesa '.$venda->order->table->numero : '-' }}</td>
                <td><span class="payment-method">{{ $venda->metodo_pagamento }}</span></td>
                <td class="td-mono">R$ {{ number_format($venda->valor_final, 2, ',', '.') }}</td>
                <td><span class="badge badge-success">{{ ucfirst($venda->status) }}</span></td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state"><p>Nenhuma venda encontrada para o período</p></div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
