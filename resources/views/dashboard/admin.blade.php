@extends('layouts.app')
<<<<<<< HEAD
@section('page-title', 'Dashboard - Gerente')
=======
@section('page-title', 'Dashboard — Gerente')
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
@section('breadcrumb', 'Visão geral do restaurante')
@section('content')

<div class="cards-grid">
<<<<<<< HEAD
    <div class="stat-card stat-card-success">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-dollar-sign"></i></div>
=======
    <div class="stat-card" style="--card-color: #22c55e">
        <div class="sc-header">
            <div class="sc-icon">$</div>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            <span class="sc-badge">Hoje</span>
        </div>
        <div class="sc-value">R$ {{ number_format($vendaHoje, 2, ',', '.') }}</div>
        <div class="sc-label">Vendas do dia</div>
    </div>
<<<<<<< HEAD

    <div class="stat-card stat-card-warning">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-fire-burner"></i></div>
=======
    <div class="stat-card" style="--card-color: #f97316">
        <div class="sc-header">
            <div class="sc-icon">🔥</div>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            <span class="sc-badge">Agora</span>
        </div>
        <div class="sc-value">{{ $pedidosEmPreparo->count() }}</div>
        <div class="sc-label">Pedidos em preparo</div>
    </div>
<<<<<<< HEAD

    <div class="stat-card stat-card-info">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-chair"></i></div>
            <span class="sc-badge">Ocupação</span>
        </div>
        <div class="sc-value">
            {{ $mesasOcupadas }}<span class="sc-value-muted">/{{ $totalMesas }}</span>
        </div>
        <div class="sc-label">Mesas ocupadas</div>
    </div>

    <div class="stat-card {{ $estoqueAlerta->count() > 0 ? 'stat-card-danger' : 'stat-card-success' }}">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
=======
    <div class="stat-card" style="--card-color: #3b82f6">
        <div class="sc-header">
            <div class="sc-icon">🪑</div>
            <span class="sc-badge">Ocupação</span>
        </div>
        <div class="sc-value">{{ $mesasOcupadas }}<span style="font-size:16px;font-weight:500;color:var(--muted)">/{{ $totalMesas }}</span></div>
        <div class="sc-label">Mesas ocupadas</div>
    </div>
    <div class="stat-card" style="--card-color: {{ $estoqueAlerta->count() > 0 ? '#ef4444' : '#22c55e' }}">
        <div class="sc-header">
            <div class="sc-icon">⚠️</div>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            <span class="sc-badge">Alerta</span>
        </div>
        <div class="sc-value">{{ $estoqueAlerta->count() }}</div>
        <div class="sc-label">Itens em estoque crítico</div>
    </div>
</div>

<<<<<<< HEAD
<div class="dashboard-grid dashboard-grid-main">
    <div class="table-wrap">
        <div class="table-header">
            <h2><i class="fa-solid fa-fire-burner"></i> Em Preparo Agora</h2>
            <a href="{{ route('dashboard.pedidos') }}" class="btn btn-secondary btn-sm">Ver todos</a>
        </div>

        @if($pedidosEmPreparo->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-circle-check"></i>
                <p>Nenhum pedido em preparo</p>
            </div>
        @else
            <table>
                <thead>
                    <tr><th>Pedido</th><th>Mesa</th><th>Itens</th><th>Valor</th><th>Tempo</th></tr>
                </thead>
                <tbody>
                    @foreach($pedidosEmPreparo as $p)
                    <tr>
                        <td><span class="td-primary td-mono">#{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                        <td>Mesa {{ $p->table->numero ?? '-' }}</td>
                        <td><span class="badge badge-warning">{{ $p->items->count() }} itens</span></td>
                        <td class="td-mono">R$ {{ number_format($p->total, 2, ',', '.') }}</td>
                        <td class="td-muted td-small">{{ $p->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
=======
<div style="display:grid; grid-template-columns: 1.2fr 1fr; gap: 24px;">

    <div class="table-wrap">
        <div class="table-header">
            <h2>🔥 Em Preparo Agora</h2>
            <a href="{{ route('dashboard.pedidos') }}" class="btn btn-secondary btn-sm">Ver todos</a>
        </div>
        @if($pedidosEmPreparo->isEmpty())
            <div class="empty-state">✅<p>Nenhum pedido em preparo</p></div>
        @else
        <table>
            <thead><tr><th>Pedido</th><th>Mesa</th><th>Itens</th><th>Valor</th><th>Tempo</th></tr></thead>
            <tbody>
            @foreach($pedidosEmPreparo as $p)
            <tr>
                <td><span class="td-primary td-mono">#{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                <td>Mesa {{ $p->table->numero ?? '—' }}</td>
                <td><span class="badge badge-warning">{{ $p->items->count() }} itens</span></td>
                <td class="td-mono">R$ {{ number_format($p->total, 2, ',', '.') }}</td>
                <td style="color:var(--muted); font-size:12px">{{ $p->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        @endif
    </div>

    <div class="table-wrap">
        <div class="table-header">
<<<<<<< HEAD
            <h2><i class="fa-solid fa-triangle-exclamation"></i> Estoque Crítico</h2>
            <a href="{{ route('dashboard.estoque') }}" class="btn btn-secondary btn-sm">Gerenciar</a>
        </div>

        @if($estoqueAlerta->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-boxes-stacked"></i>
                <p>Estoque normalizado</p>
            </div>
        @else
            <table>
                <thead>
                    <tr><th>Item</th><th>Atual</th><th>Mínimo</th></tr>
                </thead>
                <tbody>
                    @foreach($estoqueAlerta as $item)
                    @php
                        $unidade = strtolower($item->unidade);
                        $isPeso = in_array($unidade, ['kg', 'g', 'gramas', 'grama']);
                        $isVolume = in_array($unidade, ['l', 'ml', 'litro', 'litros']);

                        if ($isPeso) {
                            $quantidadeAtual = $item->quantidade_atual >= 1
                                ? number_format($item->quantidade_atual, 3, ',', '.') . ' kg'
                                : number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' g';
                        } elseif ($isVolume) {
                            $quantidadeAtual = $item->quantidade_atual >= 1
                                ? number_format($item->quantidade_atual, 2, ',', '.') . ' L'
                                : number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' mL';
                        } else {
                            $quantidadeAtual = number_format($item->quantidade_atual, 0, ',', '.') . ' un';
                        }
                    @endphp
                    <tr>
                        <td class="td-primary">{{ $item->nome }}</td>
                        <td><span class="td-danger td-mono">{{ $quantidadeAtual }}</span></td>
                        <td class="td-muted">mín. {{ number_format($item->quantidade_minima, 2, ',', '.') }} {{ $item->unidade }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
=======
            <h2>⚠️ Estoque Crítico</h2>
            <a href="{{ route('dashboard.estoque') }}" class="btn btn-secondary btn-sm">Gerenciar</a>
        </div>
        @if($estoqueAlerta->isEmpty())
            <div class="empty-state">📦<p>Estoque normalizado</p></div>
        @else
        <table>
            <thead><tr><th>Item</th><th>Atual</th><th>Mínimo</th></tr></thead>
            <tbody>
            @foreach($estoqueAlerta as $item)
            @php
                $u2 = strtolower($item->unidade);
                $isPeso2 = in_array($u2, ['kg','g','gramas','grama']);
                $isVol2  = in_array($u2, ['l','ml','litro','litros']);
                if ($isPeso2) {
                    $qd = $item->quantidade_atual >= 1
                        ? number_format($item->quantidade_atual,3,',','.') . ' kg'
                        : number_format($item->quantidade_atual*1000,0,',','.') . ' g';
                } elseif ($isVol2) {
                    $qd = $item->quantidade_atual >= 1
                        ? number_format($item->quantidade_atual,2,',','.') . ' L'
                        : number_format($item->quantidade_atual*1000,0,',','.') . ' mL';
                } else {
                    $qd = number_format($item->quantidade_atual,0,',','.') . ' un';
                }
            @endphp
            <tr>
                <td class="td-primary">{{ $item->nome }}</td>
                <td><span style="color:#f87171; font-weight:700; font-family:monospace">{{ $qd }}</span></td>
                <td style="color:var(--muted)">mín. {{ number_format($item->quantidade_minima,2,',','.') }} {{ $item->unidade }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        @endif
    </div>
</div>

<<<<<<< HEAD
<div class="dashboard-actions">
    <a href="{{ route('dashboard.vendas') }}" class="action-card action-card-success">
        <div class="sc-icon"><i class="fa-solid fa-chart-line"></i></div>
        <div class="action-card-body">
            <div class="action-card-title">Relatório de Vendas</div>
            <div class="sc-label">Ver histórico do mês</div>
        </div>
        <i class="fa-solid fa-arrow-right action-card-arrow"></i>
    </a>

    <a href="{{ route('compras.index') }}" class="action-card action-card-info">
        <div class="sc-icon"><i class="fa-solid fa-cart-shopping"></i></div>
        <div class="action-card-body">
            <div class="action-card-title">Registrar Compra</div>
            <div class="sc-label">Entrada de estoque</div>
        </div>
        <i class="fa-solid fa-arrow-right action-card-arrow"></i>
    </a>

    <a href="{{ route('mesas.index') }}" class="action-card action-card-warning">
        <div class="sc-icon"><i class="fa-solid fa-chair"></i></div>
        <div class="action-card-body">
            <div class="action-card-title">Gerenciar Mesas</div>
            <div class="sc-label">{{ $totalMesas }} mesas cadastradas</div>
        </div>
        <i class="fa-solid fa-arrow-right action-card-arrow"></i>
=======
<div style="display:grid; grid-template-columns: repeat(3,1fr); gap:16px; margin-top:8px">
    <a href="{{ route('dashboard.vendas') }}" class="stat-card" style="--card-color:#22c55e; text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px 22px">
        <div class="sc-icon">📈</div>
        <div><div style="color:#fff; font-weight:700; font-size:14px">Relatório de Vendas</div><div class="sc-label">Ver histórico do mês</div></div>
        →
    </a>
    <a href="{{ route('compras.index') }}" class="stat-card" style="--card-color:#3b82f6; text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px 22px">
        <div class="sc-icon">🛒</div>
        <div><div style="color:#fff; font-weight:700; font-size:14px">Registrar Compra</div><div class="sc-label">Entrada de estoque</div></div>
        →
    </a>
    <a href="{{ route('mesas.index') }}" class="stat-card" style="--card-color:#a855f7; text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px 22px">
        <div class="sc-icon">🪑</div>
        <div><div style="color:#fff; font-weight:700; font-size:14px">Gerenciar Mesas</div><div class="sc-label">{{ $totalMesas }} mesas cadastradas</div></div>
        →
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    </a>
</div>
@endsection
