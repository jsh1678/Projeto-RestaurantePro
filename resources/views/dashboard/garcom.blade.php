@extends('layouts.app')
<<<<<<< HEAD
@section('page-title', 'Dashboard - Garçom')
@section('breadcrumb', 'Seu painel de trabalho')
@section('styles')
<style>
.garcom-quick-actions {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 10px;
    margin-bottom: 18px;
}

.garcom-action {
    min-height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: var(--bg2);
    color: var(--cream);
    text-decoration: none;
    font-weight: 900;
}

.garcom-action i {
    color: var(--accent);
}

.ready-delivery-hub {
    border-color: rgba(34,197,94,.28) !important;
}

.ready-hub-button {
    width: 100%;
    min-height: 68px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    border: 1px solid rgba(34,197,94,.25);
    border-radius: 14px;
    background: rgba(34,197,94,.08);
    color: var(--cream);
    padding: 14px;
    cursor: pointer;
    text-align: left;
}

.ready-hub-button strong {
    display: block;
    color: #fff;
    font-size: 17px;
}

.ready-hub-button span {
    color: var(--muted);
    font-size: 13px;
}

.ready-delivery-list {
    display: grid;
    gap: 10px;
    margin-top: 12px;
}

.ready-delivery-card {
    border: 1px solid var(--border);
    border-left: 4px solid var(--wait-color);
    border-radius: 12px;
    background: var(--bg2);
    padding: 13px;
}

.ready-delivery-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 8px;
}

.ready-delivery-top strong {
    color: #fff;
    font-size: 18px;
}

.ready-wait {
    color: var(--wait-color);
    font-size: 12px;
    font-weight: 900;
    white-space: nowrap;
}

.ready-item-line {
    color: var(--muted);
    font-size: 13px;
    line-height: 1.45;
}

.ready-deliver-form {
    margin-top: 12px;
}

.ready-deliver-button {
    width: 100%;
    min-height: 48px;
    border: 0;
    border-radius: 10px;
    background: var(--green);
    color: #fff;
    font-weight: 900;
    cursor: pointer;
}

.ready-deliver-button:disabled {
    opacity: .55;
    cursor: wait;
}

@media (max-width: 768px) {
    .garcom-quick-actions {
        grid-template-columns: 1fr;
        gap: 9px;
    }

    .garcom-action {
        min-height: 54px;
        justify-content: flex-start;
        padding: 0 14px;
        font-size: 16px;
    }
}
</style>
@endsection

@section('content')

<div class="cards-grid">
    <div class="stat-card stat-card-info">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-chair"></i></div>
            <span class="sc-badge">Agora</span>
        </div>
        <div class="sc-value">
            {{ $mesasOcupadas }}<span class="sc-value-muted">/{{ $totalMesas }}</span>
        </div>
        <div class="sc-label">Mesas ocupadas</div>
    </div>

    <div class="stat-card stat-card-warning">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-receipt"></i></div>
            <span class="sc-badge">Hoje</span>
        </div>
        <div class="sc-value">{{ $pedidosGarcom->count() }}</div>
        <div class="sc-label">Meus pedidos hoje</div>
    </div>

    <div class="stat-card stat-card-success">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-bell-concierge"></i></div>
            <span class="sc-badge">Prontos</span>
        </div>
        <div class="sc-value">{{ $pedidosProntosPagamento->count() }}</div>
        <div class="sc-label">Prontos para entregar</div>
    </div>

    <div class="stat-card stat-card-danger">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-dollar-sign"></i></div>
            <span class="sc-badge">Hoje</span>
        </div>
        <div class="sc-value sc-value-money">R$ {{ number_format($totalPagamentosDia, 2, ',', '.') }}</div>
=======
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
        <div class="sc-header"><div class="sc-icon">🧾</div><span class="sc-badge">Hoje</span></div>
        <div class="sc-value">{{ $pedidosGarcom->count() }}</div>
        <div class="sc-label">Meus pedidos hoje</div>
    </div>
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon">🔔</div><span class="sc-badge">Prontos</span></div>
        {{-- Só mostra pedidos prontos pela cozinha (pronto_entrega), não os já entregues --}}
        <div class="sc-value">{{ $pedidosProntosPagamento->count() }}</div>
        <div class="sc-label">Prontos para entregar</div>
    </div>
    <div class="stat-card" style="--card-color:#a855f7">
        <div class="sc-header"><div class="sc-icon">$</div><span class="sc-badge">Hoje</span></div>
        <div class="sc-value" style="font-size:20px">R$ {{ number_format($totalPagamentosDia, 2, ',', '.') }}</div>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        <div class="sc-label">Total recebido</div>
    </div>
</div>

<<<<<<< HEAD
@php
    $gruposEntrega = $pedidosProntosPagamento->groupBy('table_id');
@endphp
<div class="panel ready-delivery-hub" id="entregas">
    <button type="button" class="ready-hub-button" onclick="document.getElementById('readyDeliveryList')?.scrollIntoView({behavior:'smooth', block:'start'})">
        <div>
            <strong>🔥 Prontos para Entrega</strong>
            <span>{{ $pedidosProntosPagamento->count() }} pedido(s) aguardando entrega</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </button>

    <div class="ready-delivery-list" id="readyDeliveryList">
        @forelse($gruposEntrega as $mesaId => $pedidosMesa)
        @php
            $primeiro = $pedidosMesa->sortBy(fn($pedido) => $pedido->horario_termino_preparo ?? $pedido->updated_at)->first();
            $referencia = $primeiro?->horario_termino_preparo ?? $primeiro?->updated_at ?? now();
            $espera = max(0, (int) $referencia->diffInMinutes(now()));
            $waitColor = $espera < 2 ? '#22c55e' : ($espera <= 5 ? '#eab308' : '#ef4444');
            $todosItens = $pedidosMesa->flatMap->items;
            $mesaNumero = $primeiro?->table?->numero ?? '-';
        @endphp
        <div class="ready-delivery-card" style="--wait-color:{{ $waitColor }}" data-ready-group>
            <div class="ready-delivery-top">
                <div>
                    <strong>Mesa {{ $mesaNumero }}</strong>
                    <div class="ready-item-line">
                        {{ $pedidosMesa->pluck('id')->map(fn($id) => '#' . str_pad($id, 4, '0', STR_PAD_LEFT))->implode(' · ') }}
                    </div>
                </div>
                <span class="ready-wait">Pronto há {{ $espera }} min</span>
            </div>

            @foreach($todosItens->take(4) as $item)
            <div class="ready-item-line">{{ $item->quantidade }}x {{ $item->menuItem->nome ?? 'Item' }}</div>
            @endforeach
            @if($todosItens->count() > 4)
            <div class="ready-item-line">+ {{ $todosItens->count() - 4 }} item(ns)</div>
            @endif

            <form method="POST"
                  action="{{ route('orders.updateStatus', $primeiro) }}"
                  class="ready-deliver-form js-ready-deliver"
                  data-order-ids="{{ $pedidosMesa->pluck('id')->implode(',') }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="entregue">
                <button type="submit" class="ready-deliver-button">
                    <i class="fa-solid fa-check"></i> {{ $pedidosMesa->count() > 1 ? 'Entregar Tudo' : 'Entregar' }}
                </button>
            </form>
        </div>
        @empty
        <div class="empty-state" style="padding:28px 12px">
            <i class="fa-solid fa-circle-check"></i>
            <p>Nenhum pedido pronto para entrega</p>
        </div>
        @endforelse
    </div>
</div>

<div class="garcom-quick-actions" aria-label="Atalhos rapidos do garcom">
    <a href="{{ route('mesas.index') }}" class="garcom-action"><i class="fa-solid fa-chair"></i> Ver Mesas</a>
    <a href="{{ route('orders.create') }}" class="garcom-action"><i class="fa-solid fa-plus"></i> Novo Pedido</a>
    <a href="#entregas" class="garcom-action"><i class="fa-solid fa-bell-concierge"></i> Entregas ({{ $pedidosProntosPagamento->count() }})</a>
    <a href="{{ route('mesas.index') }}" class="garcom-action"><i class="fa-solid fa-lock"></i> Fechar Conta</a>
</div>

<div class="panel" style="margin-bottom:18px">
    <div class="panel-header">
        <div class="panel-title"><i class="fa-solid fa-chair"></i> Mesas do salao</div>
        <a href="{{ route('mesas.index') }}" class="btn btn-secondary btn-sm">Abrir painel</a>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px">
        @forelse($mesas as $mesa)
        @php
            $temPedido = $mesa->orders->whereNotIn('status', ['pago', 'cancelado'])->isNotEmpty();
            $href = $temPedido ? route('mesas.conta', $mesa) : route('orders.create', ['table_id' => $mesa->id]);
            $cor = $mesa->status === 'disponivel' ? '#4ade80' : ($mesa->status === 'ocupada' ? '#f87171' : '#fbbf24');
        @endphp
        <a href="{{ $href }}" style="display:block;border:1px solid var(--border);border-radius:12px;padding:12px;background:var(--bg2);color:inherit;text-decoration:none">
            <div style="color:#fff;font-size:22px;font-weight:900;line-height:1">Mesa {{ $mesa->numero }}</div>
            <div style="margin-top:5px;color:var(--muted);font-size:11px">{{ $mesa->assentos }} lugares</div>
            <div style="display:flex;align-items:center;gap:6px;margin-top:10px;font-size:11px;font-weight:800">
                <span style="width:8px;height:8px;border-radius:50%;background:{{ $cor }}"></span>
                {{ ucfirst($mesa->status) }}
            </div>
        </a>
        @empty
        <div class="empty-state" style="grid-column:1/-1">
            <i class="fa-solid fa-chair"></i>
            <p>Nenhuma mesa cadastrada</p>
        </div>
        @endforelse
    </div>
</div>

@if(false && $pedidosProntosPagamento->isNotEmpty())
<div class="panel panel-accent-success">
    <div class="panel-header">
        <div class="panel-title"><i class="fa-solid fa-bell-concierge"></i> Prontos para Entregar ({{ $pedidosProntosPagamento->count() }})</div>
        <span class="panel-note">Chef finalizou - leve à mesa</span>
    </div>

    <div class="ready-orders-grid">
        @foreach($pedidosProntosPagamento as $p)
        <div class="ready-order-card">
            <a href="{{ route('orders.show', $p) }}" class="ready-order-link">
                <div class="ready-order-top">
                    <span class="ready-order-code">#{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span>
                    <span class="ready-order-table">Mesa {{ $p->table->numero ?? '-' }}</span>
                </div>
                <div class="ready-order-meta">{{ $p->items->count() }} item(s)</div>
                <div class="ready-order-total">R$ {{ number_format($p->total, 2, ',', '.') }}</div>
            </a>

            <form method="POST" action="{{ route('orders.updateStatus', $p) }}" class="ready-order-form">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="entregue">
                <button type="submit" class="ready-order-button">
                    <i class="fa-solid fa-circle-check"></i> Marcar como Entregue
                </button>
            </form>
        </div>
=======
{{-- Seção: Prontos para Entregar (chef finalizou, garçom precisa levar) --}}
@if($pedidosProntosPagamento->isNotEmpty())
<div class="panel" style="border-color: rgba(34,197,94,.3); background: rgba(34,197,94,.05)">
    <div class="panel-header">
        <div class="panel-title" style="color:#4ade80">🔔 Prontos para Entregar ({{ $pedidosProntosPagamento->count() }})</div>
        <span style="font-size:12px; color:rgba(255,255,255,.5)">Chef finalizou — leve à mesa!</span>
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

                {{-- Botão rápido de marcar como entregue --}}
                <form method="POST" action="{{ route('orders.updateStatus', $p) }}" onclick="event.stopPropagation()" style="margin-top:10px">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="entregue">
                    <button type="submit" style="width:100%; padding:6px; border-radius:8px; border:none; background:rgba(34,197,94,.3); color:#fff; font-size:12px; font-weight:700; cursor:pointer;" onmouseover="this.style.background='rgba(34,197,94,.5)'" onmouseout="this.style.background='rgba(34,197,94,.3)'">
                        ✅ Marcar como Entregue
                    </button>
                </form>
            </div>
        </a>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        @endforeach
    </div>
</div>
@endif

<<<<<<< HEAD
<div class="table-wrap">
    <div class="table-header">
        <h2><i class="fa-solid fa-receipt"></i> Meus Pedidos de Hoje</h2>
        <a href="{{ route('dashboard.pedidos') }}" class="btn btn-secondary btn-sm">Ver todos</a>
    </div>

    @if($pedidosGarcom->isEmpty())
        <div class="empty-state">
            <i class="fa-solid fa-receipt"></i>
            <p>Nenhum pedido ainda hoje</p>
        </div>
    @else
=======
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
                        @if($contaFechada) · <span>🔒 Fechada</span>@endif
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
            <h2>🧾 Meus Pedidos de Hoje</h2>
            <a href="{{ route('dashboard.pedidos') }}" class="btn btn-secondary btn-sm">Ver todos</a>
        </div>
        @if($pedidosGarcom->isEmpty())
            <div class="empty-state">🧾<p>Nenhum pedido ainda hoje</p></div>
        @else
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        <table>
            <thead>
                <tr><th>#</th><th>Mesa</th><th>Status</th><th>Total</th></tr>
            </thead>
            <tbody>
<<<<<<< HEAD
                @foreach($pedidosGarcom->take(8) as $p)
                @php
                    $cores = [
                        'aberto' => 'secondary',
                        'em_preparo' => 'warning',
                        'pronto' => 'info',
                        'pronto_entrega' => 'success',
                        'aguardando_pagamento' => 'primary',
                        'pago' => 'info',
                        'cancelado' => 'danger',
                        'entregue' => 'secondary',
                    ];
                    $labels = [
                        'aberto' => 'Aberto',
                        'em_preparo' => 'Em Preparo',
                        'pronto' => 'Pronto',
                        'pronto_entrega' => 'Pronto p/ Entregar',
                        'aguardando_pagamento' => 'Entregue',
                        'pago' => 'Pago',
                        'cancelado' => 'Cancelado',
                        'entregue' => 'Entregue',
                    ];
                @endphp
                <tr class="clickable-row" onclick="window.location='{{ route('orders.show', $p) }}'">
                    <td class="td-mono td-primary">#{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>Mesa {{ $p->table->numero ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $cores[$p->status] ?? 'secondary' }}">
                            {{ $labels[$p->status] ?? str_replace('_', ' ', ucfirst($p->status)) }}
                        </span>
                    </td>
                    <td class="td-mono">R$ {{ number_format($p->total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

@section('scripts')
<script>
async function entregarPedido(url) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const body = new FormData();
    body.append('_method', 'PATCH');
    body.append('status', 'entregue');

    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body
    });

    if (!response.ok) throw new Error('Falha ao entregar pedido');
    return response.json();
}

document.querySelectorAll('.js-ready-deliver').forEach((form) => {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const card = form.closest('[data-ready-group]');
        const button = form.querySelector('button');
        const urls = (form.dataset.orderIds || '')
            .split(',')
            .filter(Boolean)
            .map((id) => @json('/pedidos') + '/' + id + '/status');

        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Entregando...';

        try {
            for (const url of urls) {
                await entregarPedido(url);
            }
            card?.remove();
            if (typeof mostrarToast === 'function') {
                mostrarToast({
                    icone: '<i class="fa-solid fa-circle-check"></i>',
                    titulo: 'Pedido entregue',
                    msg: 'Entrega registrada com sucesso.',
                    duracao: 3500
                });
            }
        } catch (error) {
            button.disabled = false;
            button.innerHTML = '<i class="fa-solid fa-check"></i> Entregar';
            if (typeof mostrarToast === 'function') {
                mostrarToast({
                    icone: '<i class="fa-solid fa-triangle-exclamation"></i>',
                    titulo: 'Erro na entrega',
                    msg: 'Nao foi possivel marcar como entregue.',
                    duracao: 5000
                });
            }
        }
    });
});

@if(isset($cozinhaEventCursor))
let garcomSse;
let garcomCursor = {{ (int) $cozinhaEventCursor }};

function conectarEntregasGarcom() {
    if (garcomSse) garcomSse.close();
    garcomSse = new EventSource('{{ route("cozinha.stream") }}?after=' + encodeURIComponent(garcomCursor));

    garcomSse.addEventListener('cozinha_eventos', (event) => {
        const eventos = JSON.parse(event.data || '[]');
        eventos.forEach((evento) => {
            garcomCursor = Math.max(garcomCursor, Number(evento.id || 0));
            if (evento.type !== 'order_ready') return;

            const pedido = evento.payload || {};
            if (typeof mostrarToast === 'function') {
                mostrarToast({
                    icone: '<i class="fa-solid fa-bell-concierge"></i>',
                    titulo: 'Mesa ' + (pedido.mesa || '-') + ' pronta',
                    msg: 'Toque para abrir o pedido #' + (pedido.numero || pedido.id || ''),
                    duracao: 9000,
                    botoes: [{
                        label: 'Abrir',
                        primario: true,
                        acao: function() {
                            if (pedido.id) window.location.href = @json('/pedidos') + '/' + pedido.id;
                        }
                    }]
                });
            }
        });
    });

    garcomSse.onerror = () => {
        garcomSse.close();
        setTimeout(conectarEntregasGarcom, 5000);
    };
}

document.addEventListener('DOMContentLoaded', conectarEntregasGarcom);
@endif
</script>
@endsection
=======
            @foreach($pedidosGarcom->take(8) as $p)
            @php
                $cores = [
                    'aberto'               => 'secondary',
                    'em_preparo'           => 'warning',
                    'pronto'               => 'info',
                    'pronto_entrega'       => 'success',
                    'aguardando_pagamento' => 'primary',
                    'pago'                 => 'info',
                    'cancelado'            => 'danger',
                    'entregue'             => 'secondary',
                ];
                $labels = [
                    'aberto'               => 'Aberto',
                    'em_preparo'           => 'Em Preparo',
                    'pronto'               => 'Pronto',
                    'pronto_entrega'       => 'Pronto p/ Entregar',
                    'aguardando_pagamento' => 'Entregue',
                    'pago'                 => 'Pago',
                    'cancelado'            => 'Cancelado',
                    'entregue'             => 'Entregue',
                ];
            @endphp
            <tr onclick="window.location='{{ route('orders.show', $p) }}'" style="cursor:pointer">
                <td class="td-mono td-primary">#{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}</td>
                <td>Mesa {{ $p->table->numero ?? '—' }}</td>
                <td>
                    <span class="badge badge-{{ $cores[$p->status] ?? 'secondary' }}">
                        {{ $labels[$p->status] ?? str_replace('_',' ',ucfirst($p->status)) }}
                    </span>
                </td>
                <td class="td-mono">R$ {{ number_format($p->total,2,',','.') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
