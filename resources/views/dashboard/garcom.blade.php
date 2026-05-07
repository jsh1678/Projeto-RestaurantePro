@extends('layouts.app')
@section('page-title', 'Dashboard — Garçom')
@section('breadcrumb', 'Seu painel de trabalho')
@section('content')

<div class="cards-grid">
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon">🪑</div><span class="sc-badge">Agora</span></div>
        <div class="sc-value">{{ $mesasOcupadas }}<span style="font-size:16px;font-weight:500;color:var(--muted)">/{{ $totalMesas }}</span></div>
        <div class="sc-label">Mesas ocupadas</div>
    </div>
    <div class="stat-card" style="--card-color:#f97316">
        <div class="sc-header"><div class="sc-icon">🧾</div><span class="sc-badge">Seus pedidos</span></div>
        <div class="sc-value">{{ $pedidosGarcom->count() }}</div>
        <div class="sc-label">Pedidos abertos</div>
    </div>
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon">🔔</div><span class="sc-badge">Prontos</span></div>
        <div class="sc-value">{{ $pedidosProntosPagamento->count() }}</div>
        <div class="sc-label">Para entregar</div>
    </div>
    <div class="stat-card" style="--card-color:#a855f7">
        <div class="sc-header"><div class="sc-icon">$</div><span class="sc-badge">Hoje</span></div>
        <div class="sc-value" style="font-size:20px">R$ {{ number_format($totalPagamentosDia, 2, ',', '.') }}</div>
        <div class="sc-label">Total recebido</div>
    </div>
</div>

@if($pedidosProntosPagamento->isNotEmpty())
<div class="panel" style="border-color: rgba(34,197,94,.3); background: rgba(34,197,94,.05)">
    <div class="panel-header">
        <div class="panel-title" style="color:#4ade80">🔔 Prontos para Entregar ({{ $pedidosProntosPagamento->count() }})</div>
    </div>
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px,1fr)); gap:12px">
        @foreach($pedidosProntosPagamento as $p)
        <a href="{{ route('orders.show', $p) }}" style="text-decoration:none">
            <div style="background:rgba(34,197,94,.08); border:1px solid rgba(34,197,94,.2); border-radius:12px; padding:16px; transition:.2s" onmouseover="this.style.background='rgba(34,197,94,.14)'" onmouseout="this.style.background='rgba(34,197,94,.08)'">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px">
                    <span style="font-family:monospace; font-weight:700; color:#4ade80">#{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}</span>
                    <span style="font-size:12px; color:rgba(255,255,255,.4)">Mesa {{ $p->table->numero ?? '—' }}</span>
                </div>
                <div style="font-size:13px; color:rgba(255,255,255,.6); margin-bottom:8px">{{ $p->items->count() }} item(s)</div>
                <div style="font-weight:800; color:#fff">R$ {{ number_format($p->total,2,',','.') }}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px">

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">🪑 Mesas do Salão</div>
            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">➕ Novo Pedido</a>
        </div>
        <div class="mesas-grid">
            @foreach($mesas as $mesa)
            @php
                $temPedido    = $mesa->orders->isNotEmpty();
                $contaFechada = $mesa->orders->contains(fn($o) => in_array($o->status, ['pronto_entrega', 'aguardando_pagamento']));
                // Conta fechada → vai para a conta (só visualiza)
                // Tem pedido aberto → vai para a conta
                // Sem pedido → abre novo pedido
                $href = ($temPedido || $contaFechada)
                    ? route('mesas.conta', $mesa)
                    : route('orders.create', ['table_id' => $mesa->id]);
            @endphp
            <a href="{{ $href }}" style="text-decoration:none">
                <div class="mesa-card {{ $mesa->status }}">
                    <div class="mc-number">{{ $mesa->numero }}</div>
                    <div class="mc-seats">{{ $mesa->assentos }} lugares</div>
                    @if($temPedido)
                    <div style="font-size:11px; font-weight:700; margin-top:2px; color:{{ $contaFechada ? '#fbbf24' : 'var(--accent)' }}">
                        {{ $mesa->orders->count() }} pedido(s)
                        @if($contaFechada)· <span>🔒 Fechada</span>@endif
                    </div>
                    @endif
                    <span class="badge badge-{{ $mesa->status === 'disponivel' ? 'success' : ($mesa->status === 'ocupada' ? 'danger' : 'warning') }}">
                        {{ ucfirst($mesa->status) }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2> Meus Pedidos Recentes</h2>
            <a href="{{ route('dashboard.pedidos') }}" class="btn btn-secondary btn-sm">Ver todos</a>
        </div>
        @if($pedidosGarcom->isEmpty())
            <div class="empty-state">🧾<p>Nenhum pedido ainda hoje</p></div>
        @else
        <table>
            <thead><tr><th>#</th><th>Mesa</th><th>Status</th><th>Total</th></tr></thead>
            <tbody>
            @foreach($pedidosGarcom->take(8) as $p)
            @php $cores = ['em_preparo'=>'warning','pronto_entrega'=>'success','aguardando_pagamento'=>'info','pago'=>'info','cancelado'=>'danger','entregue'=>'secondary']; @endphp
            <tr onclick="window.location='{{ route('orders.show', $p) }}'" style="cursor:pointer">
                <td class="td-mono td-primary">#{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}</td>
                <td>Mesa {{ $p->table->numero ?? '—' }}</td>
                <td><span class="badge badge-{{ $cores[$p->status] ?? 'secondary' }}">{{ str_replace('_',' ',ucfirst($p->status)) }}</span></td>
                <td class="td-mono">R$ {{ number_format($p->total,2,',','.') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
