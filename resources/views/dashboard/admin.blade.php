@extends('layouts.app')
@section('page-title', 'Dashboard - Gerente')
@section('breadcrumb', 'Visão geral do restaurante')
@section('content')

<div class="cards-grid">
    <div class="stat-card stat-card-success">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-dollar-sign"></i></div>
            <span class="sc-badge">Hoje</span>
        </div>
        <div class="sc-value">R$ {{ number_format($vendaHoje, 2, ',', '.') }}</div>
        <div class="sc-label">Vendas do dia</div>
    </div>

    <div class="stat-card stat-card-warning">
        <div class="sc-header">
            <div class="sc-icon"><i class="fa-solid fa-fire-burner"></i></div>
            <span class="sc-badge">Agora</span>
        </div>
        <div class="sc-value">{{ $pedidosEmPreparo->count() }}</div>
        <div class="sc-label">Pedidos em preparo</div>
    </div>

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
            <span class="sc-badge">Alerta</span>
        </div>
        <div class="sc-value">{{ $estoqueAlerta->count() }}</div>
        <div class="sc-label">Itens em estoque crítico</div>
    </div>
</div>

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
        @endif
    </div>

    <div class="table-wrap">
        <div class="table-header">
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
        @endif
    </div>
</div>

<div class="dashboard-actions">
    <a href="{{ route('dashboard.vendas') }}" class="action-card action-card-success">
        <div class="sc-icon"><i class="fa-solid fa-chart-line"></i></div>
        <div class="action-card-body">
            <div class="action-card-title">Relatório de Vendas</div>
            <div class="sc-label">Ver histórico do mês</div>
        </div>
        <i class="fa-solid fa-arrow-right action-card-arrow"></i>
    </a>

    <a href="{{ route('dashboard.estoque') }}" class="action-card action-card-info">
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
    </a>
</div>
@endsection
