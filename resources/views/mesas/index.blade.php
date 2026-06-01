@extends('layouts.app')
@section('page-title', 'Mesas')
@section('breadcrumb', 'Controle do salao')

@section('styles')
<style>
.mesa-page {
    display: grid;
    gap: 18px;
}

.mesa-summary {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
}

.mesa-summary-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    min-height: 78px;
    padding: 14px 16px;
    border: 1px solid var(--border);
    border-radius: 14px;
    background: var(--bg2);
}

.mesa-summary-card span {
    display: block;
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
}

.mesa-summary-card strong {
    display: block;
    margin-top: 5px;
    color: #fff;
    font-size: 25px;
    line-height: 1;
}

.mesa-summary-icon {
    width: 38px;
    height: 38px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    color: var(--status-color);
    background: color-mix(in srgb, var(--status-color) 12%, transparent);
    border: 1px solid color-mix(in srgb, var(--status-color) 24%, transparent);
}

.mesa-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}

.mesa-toolbar-left {
    display: flex;
    gap: 10px;
    flex: 1;
    min-width: 260px;
}

.mesa-search,
.mesa-filter {
    min-height: 42px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: var(--bg2);
    color: #fff;
    outline: none;
    padding: 9px 12px;
    font: 700 13px inherit;
}

.mesa-search {
    width: min(360px, 100%);
}

.mesa-filter {
    min-width: 180px;
    cursor: pointer;
}

.mesa-search:focus,
.mesa-filter:focus {
    border-color: rgba(249,115,22,.45);
    box-shadow: 0 0 0 3px rgba(249,115,22,.08);
}

.mesa-status-legend {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.mesa-legend {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--muted);
    font-size: 11px;
    font-weight: 800;
}

.mesa-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: var(--status-color);
}

.mesas-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 14px;
}

.mesa-item {
    min-width: 0;
}

.mesa-card-simple {
    width: 100%;
    min-height: 178px;
    display: grid;
    gap: 12px;
    border: 1px solid var(--border);
    border-left: 4px solid var(--status-color);
    border-radius: 14px;
    background: var(--bg2);
    color: inherit;
    cursor: pointer;
    padding: 15px;
    text-align: left;
    transition: transform .15s ease, border-color .15s ease, background .15s ease;
}

.mesa-card-simple:hover {
    transform: translateY(-2px);
    border-color: rgba(255,255,255,.16);
    background: rgba(255,255,255,.045);
}

.mesa-card-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.mesa-number {
    color: #fff;
    font-size: 30px;
    font-weight: 900;
    line-height: 1;
}

.mesa-number span {
    display: block;
    margin-bottom: 4px;
    color: var(--muted);
    font-size: 11px;
    font-weight: 800;
}

.mesa-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    max-width: 130px;
    padding: 6px 9px;
    border-radius: 999px;
    background: color-mix(in srgb, var(--status-color) 12%, transparent);
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
}

.mesa-info-list {
    display: grid;
    gap: 8px;
}

.mesa-info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    color: var(--muted);
    font-size: 12px;
}

.mesa-info-row strong {
    min-width: 0;
    overflow: hidden;
    color: #fff;
    font-weight: 800;
    text-align: right;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.mesa-actions {
    display: flex;
    gap: 6px;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 8px;
}

.mesa-mini-btn {
    min-height: 31px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: rgba(255,255,255,.035);
    color: var(--muted);
    cursor: pointer;
    padding: 6px 10px;
    font: 800 11px inherit;
    transition: border-color .15s ease, color .15s ease, background .15s ease;
}

.mesa-mini-btn:hover:not(:disabled) {
    border-color: rgba(249,115,22,.42);
    background: rgba(249,115,22,.08);
    color: #fff;
}

.mesa-mini-btn:disabled {
    opacity: .45;
    cursor: not-allowed;
}

.mesa-manager-actions {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-top: 8px;
}

.mesa-empty {
    grid-column: 1 / -1;
    padding: 46px 18px;
    border: 1px dashed var(--border);
    border-radius: 14px;
    background: var(--bg2);
    color: var(--muted);
    text-align: center;
}

.mesa-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 18px;
    background: rgba(0,0,0,.62);
}

.mesa-modal.active {
    display: flex;
}

.mesa-modal-card {
    width: min(520px, 100%);
    border: 1px solid var(--border);
    border-radius: 16px;
    background: #111418;
    box-shadow: 0 24px 70px rgba(0,0,0,.45);
}

.mesa-modal-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
    padding: 18px 18px 14px;
    border-bottom: 1px solid var(--border);
}

.mesa-modal-head h3 {
    margin: 0;
    color: #fff;
    font-size: 20px;
}

.mesa-modal-head p {
    margin: 5px 0 0;
    color: var(--muted);
    font-size: 13px;
}

.mesa-modal-close {
    width: 34px;
    height: 34px;
    display: grid;
    place-items: center;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: transparent;
    color: #fff;
    cursor: pointer;
}

.mesa-modal-body {
    padding: 18px;
}

.mesa-modal-info {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
    margin-bottom: 16px;
}

.mesa-modal-info div {
    padding: 11px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: rgba(255,255,255,.03);
}

.mesa-modal-info span {
    display: block;
    color: var(--muted);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
}

.mesa-modal-info strong {
    display: block;
    margin-top: 4px;
    color: #fff;
    font-size: 13px;
}

.mesa-form-group {
    margin-bottom: 14px;
}

.mesa-form-group label {
    display: block;
    margin-bottom: 7px;
    color: #fff;
    font-size: 12px;
    font-weight: 800;
}

.mesa-form-group input,
.mesa-form-group select,
.mesa-form-group textarea {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: rgba(255,255,255,.035);
    color: #fff;
    outline: none;
    padding: 11px 12px;
    font: 700 13px inherit;
}

.mesa-form-group textarea {
    min-height: 78px;
    resize: vertical;
}

.mesa-form-help {
    margin: 7px 0 0;
    color: var(--muted);
    font-size: 12px;
    line-height: 1.4;
}

.people-simple {
    display: flex;
    gap: 7px;
    flex-wrap: wrap;
}

.people-simple button {
    width: 36px;
    height: 36px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: rgba(255,255,255,.035);
    color: var(--muted);
    cursor: pointer;
    font: 800 13px inherit;
}

.people-simple button.active {
    border-color: rgba(249,115,22,.55);
    background: rgba(249,115,22,.12);
    color: var(--accent);
}

.mesa-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 18px;
}

.hidden-by-filter {
    display: none !important;
}

@media (max-width: 900px) {
    .mesa-summary {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .mesa-summary,
    .mesas-grid-modern {
        grid-template-columns: 1fr;
    }

    .mesa-summary {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .mesa-summary-card {
        min-height: 68px;
        padding: 12px;
    }

    .mesa-toolbar {
        display: grid;
        gap: 10px;
    }

    .mesa-toolbar-left {
        display: grid;
        grid-template-columns: 1fr;
        min-width: 100%;
    }

    .mesa-search,
    .mesa-filter {
        width: 100%;
    }

    .mesa-status-legend {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 2px;
        -webkit-overflow-scrolling: touch;
    }

    .mesa-legend {
        white-space: nowrap;
    }

    .mesa-card-simple {
        min-height: 156px;
        padding: 14px;
    }

    .mesa-actions,
    .mesa-manager-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .mesa-actions form,
    .mesa-actions .mesa-mini-btn,
    .mesa-actions .mesa-legend {
        width: 100%;
        justify-content: center;
    }

    .mesa-modal {
        align-items: stretch;
        padding: 0;
    }

    .mesa-modal-card {
        width: 100%;
        border-radius: 0;
        overflow-y: auto;
    }

    .mesa-modal-info {
        grid-template-columns: 1fr;
    }

    .mesa-modal-actions {
        display: grid;
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
@php
    $totalDisponiveis = 0;
    $totalOcupadas = 0;
    $totalReservadas = 0;
    $totalPagamento = 0;

    foreach ($mesas as $mesaResumo) {
        $ordersResumo = $mesaResumo->orders;
        $temPedidoResumo = $ordersResumo->isNotEmpty();
        $pagamentoResumo = $ordersResumo->contains('status', 'aguardando_pagamento');

        if ($pagamentoResumo) {
            $totalPagamento++;
            $totalOcupadas++;
        } elseif ($temPedidoResumo || $mesaResumo->status === 'ocupada') {
            $totalOcupadas++;
        } elseif ($mesaResumo->status === 'reservada') {
            $totalReservadas++;
        } else {
            $totalDisponiveis++;
        }
    }
@endphp

@if(session('info'))
<div class="alert" style="background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.3);border-radius:10px;padding:12px 16px;margin-bottom:16px;color:#93c5fd;display:flex;align-items:center;gap:8px">
    <i class="fas fa-info-circle"></i> {{ session('info') }}
</div>
@endif

<div class="mesa-page">
    <section class="mesa-summary" aria-label="Resumo das mesas">
        <div class="mesa-summary-card" style="--status-color:#22c55e">
            <div><span>Mesas Disponiveis</span><strong>{{ $totalDisponiveis }}</strong></div>
            <div class="mesa-summary-icon"><i class="fas fa-check"></i></div>
        </div>
        <div class="mesa-summary-card" style="--status-color:#eab308">
            <div><span>Mesas Ocupadas</span><strong>{{ $totalOcupadas }}</strong></div>
            <div class="mesa-summary-icon"><i class="fas fa-users"></i></div>
        </div>
        <div class="mesa-summary-card" style="--status-color:#94a3b8">
            <div><span>Mesas Reservadas</span><strong>{{ $totalReservadas }}</strong></div>
            <div class="mesa-summary-icon"><i class="fas fa-bookmark"></i></div>
        </div>
        <div class="mesa-summary-card" style="--status-color:#ef4444">
            <div><span>Aguardando Pagamento</span><strong>{{ $totalPagamento }}</strong></div>
            <div class="mesa-summary-icon"><i class="fas fa-receipt"></i></div>
        </div>
    </section>

    <section class="mesa-toolbar" aria-label="Busca e filtros">
        <div class="mesa-toolbar-left">
            <input type="search" id="mesaSearch" class="mesa-search" placeholder="Buscar mesa">
            <select id="mesaStatusFilter" class="mesa-filter" aria-label="Filtrar por status">
                <option value="">Todos os status</option>
                <option value="disponivel">Disponivel</option>
                <option value="ocupada">Ocupada</option>
                <option value="pedido">Pedido em andamento</option>
                <option value="aguardando_pagamento">Aguardando pagamento</option>
                <option value="reservada">Reservada</option>
                <option value="indisponivel">Indisponivel</option>
            </select>
        </div>

        <div class="mesa-status-legend">
            <span class="mesa-legend"><i class="mesa-dot" style="--status-color:#22c55e"></i> Disponivel</span>
            <span class="mesa-legend"><i class="mesa-dot" style="--status-color:#eab308"></i> Ocupada</span>
            <span class="mesa-legend"><i class="mesa-dot" style="--status-color:#f97316"></i> Pedido</span>
            <span class="mesa-legend"><i class="mesa-dot" style="--status-color:#ef4444"></i> Pagamento</span>
            <span class="mesa-legend"><i class="mesa-dot" style="--status-color:#94a3b8"></i> Indisponivel</span>
        </div>
    </section>

    <section class="mesas-grid-modern" id="mesasGrid">
        @forelse($mesas as $mesa)
        @php
            $orders = $mesa->orders;
            $temPedido = $orders->isNotEmpty();
            $contaFechada = $orders->contains('status', 'aguardando_pagamento');
            $pedidoEmAndamento = $orders->contains(fn($order) => in_array($order->status, ['aberto', 'em_preparo', 'pronto', 'pronto_entrega']));
            $primeiroPedido = $orders->sortBy('created_at')->first();
            $abertura = $primeiroPedido?->created_at;
            $valorAtual = $orders->sum('total');
            $responsavel = $mesa->garcom->name ?? $primeiroPedido?->user?->name ?? 'Sem responsavel';
            $href = $temPedido ? route('mesas.conta', $mesa) : route('orders.create', ['table_id' => $mesa->id]);

            if ($contaFechada) {
                $uiStatus = 'aguardando_pagamento';
                $statusLabel = 'Aguardando pagamento';
                $statusColor = '#ef4444';
            } elseif ($pedidoEmAndamento) {
                $uiStatus = 'pedido';
                $statusLabel = 'Pedido em andamento';
                $statusColor = '#f97316';
            } elseif ($mesa->status === 'ocupada') {
                $uiStatus = 'ocupada';
                $statusLabel = 'Ocupada';
                $statusColor = '#eab308';
            } elseif ($mesa->status === 'reservada') {
                $uiStatus = 'reservada';
                $statusLabel = 'Reservada';
                $statusColor = '#94a3b8';
            } elseif ($mesa->status === 'bloqueada') {
                $uiStatus = 'indisponivel';
                $statusLabel = 'Indisponivel';
                $statusColor = '#64748b';
            } else {
                $uiStatus = 'disponivel';
                $statusLabel = 'Disponivel';
                $statusColor = '#22c55e';
            }
        @endphp

        <div class="mesa-item"
             data-mesa-item
             data-number="{{ $mesa->numero }}"
             data-status="{{ $uiStatus }}">
            <button type="button"
                    class="mesa-card-simple"
                    style="--status-color:{{ $statusColor }}"
                    data-href="{{ $href }}"
                    data-numero="{{ $mesa->numero }}"
                    data-assentos="{{ $mesa->assentos }}"
                    data-status-label="{{ $statusLabel }}"
                    data-abertura="{{ $abertura ? $abertura->format('H:i') : 'Agora' }}"
                    data-can-open="{{ $temPedido ? '0' : '1' }}"
                    onclick="openMesaModal(this)">
                <div class="mesa-card-head">
                    <div class="mesa-number"><span>Mesa</span>{{ $mesa->numero }}</div>
                    <div class="mesa-status"><i class="mesa-dot" style="--status-color:{{ $statusColor }}"></i>{{ $statusLabel }}</div>
                </div>

                <div class="mesa-info-list">
                    <div class="mesa-info-row"><span>Responsavel</span><strong>{{ $responsavel }}</strong></div>
                    <div class="mesa-info-row"><span>Abertura</span><strong>{{ $abertura ? $abertura->format('H:i') : 'Livre' }}</strong></div>
                    <div class="mesa-info-row"><span>Valor atual</span><strong>R$ {{ number_format($valorAtual, 2, ',', '.') }}</strong></div>
                    <div class="mesa-info-row"><span>Lugares</span><strong>{{ $mesa->assentos }}</strong></div>
                </div>
            </button>

            <div class="mesa-actions">
                @if(in_array(Auth::user()?->role, ['garcom','gerente']) && !$temPedido)
                <form method="POST" action="{{ route('mesas.atualizar', $mesa) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="disponivel">
                    <button type="submit" class="mesa-mini-btn" @if($mesa->status==='disponivel') disabled @endif>
                        Livre
                    </button>
                </form>
                <form method="POST" action="{{ route('mesas.atualizar', $mesa) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="reservada">
                    <button type="submit" class="mesa-mini-btn" @if($mesa->status==='reservada') disabled @endif>
                        Reservar
                    </button>
                </form>
                @else
                <span class="mesa-legend"><i class="mesa-dot" style="--status-color:{{ $statusColor }}"></i>{{ $contaFechada ? 'Conta pendente' : 'Pedidos em aberto' }}</span>
                    @if(in_array(Auth::user()?->role, ['garcom','gerente']) && $temPedido)
                    <button type="button"
                            class="mesa-mini-btn"
                            data-juntar-origem="{{ $mesa->id }}"
                            data-juntar-numero="{{ $mesa->numero }}"
                            onclick="openJuntarModal(this)">
                        Juntar
                    </button>
                    @endif
                @endif
            </div>

            @if(Auth::user()?->role === 'gerente')
            <div class="mesa-manager-actions">
                <a href="{{ route('mesas.edit', $mesa) }}" class="btn btn-secondary btn-sm btn-icon" title="Editar mesa">
                    <i class="fas fa-pencil"></i>
                </a>
                <form method="POST" action="{{ route('mesas.destroy', $mesa) }}"
                      onsubmit="return confirm('Deletar Mesa {{ $mesa->numero }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm btn-icon" type="submit" title="Excluir mesa">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div class="mesa-empty">
            <i class="fas fa-chair" style="font-size:34px;margin-bottom:10px;color:var(--muted)"></i>
            <p>Nenhuma mesa cadastrada</p>
        </div>
        @endforelse
    </section>
</div>

<div class="mesa-modal" id="juntarModal" aria-hidden="true">
    <div class="mesa-modal-card" role="dialog" aria-modal="true" aria-labelledby="juntarModalTitle">
        <div class="mesa-modal-head">
            <div>
                <h3 id="juntarModalTitle">Juntar Mesas</h3>
                <p>Escolha para qual mesa os pedidos ativos serao movidos.</p>
            </div>
            <button type="button" class="mesa-modal-close" onclick="closeJuntarModal()" aria-label="Fechar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" id="juntarForm">
            @csrf
            <div class="mesa-modal-body">
                <div class="mesa-modal-info">
                    <div><span>Mesa origem</span><strong id="juntarOrigemLabel">-</strong></div>
                    <div><span>Acao</span><strong>Unir pedidos</strong></div>
                    <div><span>Resultado</span><strong>Origem livre</strong></div>
                </div>

                <div class="mesa-form-group">
                    <label for="juntarDestino">Mesa destino</label>
                    <select id="juntarDestino" name="destino_id" required>
                        <option value="">Selecione a mesa</option>
                        @foreach($mesas as $mesaDestino)
                        <option value="{{ $mesaDestino->id }}">
                            Mesa {{ $mesaDestino->numero }} - {{ ucfirst(str_replace('_', ' ', $mesaDestino->status)) }}
                        </option>
                        @endforeach
                    </select>
                    <p class="mesa-form-help">Os pedidos da mesa origem serao transferidos para a mesa destino e a origem ficara livre.</p>
                </div>

                <div class="mesa-modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeJuntarModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Juntar Mesas</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mesa-modal" id="mesaModal" aria-hidden="true">
    <div class="mesa-modal-card" role="dialog" aria-modal="true" aria-labelledby="mesaModalTitle">
        <div class="mesa-modal-head">
            <div>
                <h3 id="mesaModalTitle">Abrir Mesa</h3>
                <p id="mesaModalSubtitle">Confira as informacoes antes de continuar.</p>
            </div>
            <button type="button" class="mesa-modal-close" onclick="closeMesaModal()" aria-label="Fechar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="mesa-modal-body">
            <div class="mesa-modal-info">
                <div><span>Mesa</span><strong id="modalMesaNumero">-</strong></div>
                <div><span>Horario atual</span><strong id="modalHorario">-</strong></div>
                <div><span>Status</span><strong id="modalStatus">-</strong></div>
            </div>

            <div class="mesa-form-group" data-open-only>
                <label for="modalCliente">Cliente</label>
                <input type="text" id="modalCliente" placeholder="Nome do cliente">
            </div>

            <div class="mesa-form-group" data-open-only>
                <label>Quantidade de Pessoas</label>
                <div class="people-simple">
                    @for($i = 1; $i <= 10; $i++)
                    <button type="button" data-people="{{ $i }}" onclick="selectPeople({{ $i }})">{{ $i }}</button>
                    @endfor
                </div>
            </div>

            <div class="mesa-form-group" data-open-only>
                <label for="modalObs">Observacoes</label>
                <textarea id="modalObs" placeholder="Opcional"></textarea>
            </div>

            <div class="mesa-modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeMesaModal()">Cancelar</button>
                <button type="button" class="btn btn-primary" id="modalPrimaryAction">Abrir Mesa</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const mesaSearch = document.getElementById('mesaSearch');
const mesaStatusFilter = document.getElementById('mesaStatusFilter');
const mesaModal = document.getElementById('mesaModal');
const juntarModal = document.getElementById('juntarModal');
const juntarForm = document.getElementById('juntarForm');
const juntarDestino = document.getElementById('juntarDestino');
const mesasBaseUrl = @json(url('/mesas'));
const modalPrimaryAction = document.getElementById('modalPrimaryAction');
let mesaModalHref = '';

function filterMesas() {
    const query = (mesaSearch.value || '').trim().toLowerCase();
    const status = mesaStatusFilter.value;

    document.querySelectorAll('[data-mesa-item]').forEach(function(item) {
        const matchesNumber = !query || String(item.dataset.number).toLowerCase().includes(query);
        const matchesStatus = !status || item.dataset.status === status;
        item.classList.toggle('hidden-by-filter', !(matchesNumber && matchesStatus));
    });
}

function openMesaModal(button) {
    const canOpen = button.dataset.canOpen === '1';
    const assentos = Math.max(1, Number(button.dataset.assentos || 1));
    mesaModalHref = button.dataset.href;

    document.getElementById('mesaModalTitle').textContent = canOpen ? 'Abrir Mesa' : 'Mesa ' + button.dataset.numero;
    document.getElementById('mesaModalSubtitle').textContent = canOpen
        ? 'Informe os dados iniciais e siga para o pedido.'
        : 'Mesa em atendimento. Continue para visualizar os detalhes.';
    document.getElementById('modalMesaNumero').textContent = 'Mesa ' + button.dataset.numero;
    document.getElementById('modalHorario').textContent = new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
    document.getElementById('modalStatus').textContent = button.dataset.statusLabel;
    document.getElementById('modalCliente').value = '';
    document.getElementById('modalObs').value = '';
    modalPrimaryAction.textContent = canOpen ? 'Abrir Mesa' : 'Ver Mesa';
    document.querySelectorAll('[data-open-only]').forEach(function(section) {
        section.style.display = canOpen ? '' : 'none';
    });
    document.querySelectorAll('[data-people]').forEach(function(personButton) {
        const value = Number(personButton.dataset.people);
        personButton.hidden = value > assentos;
        personButton.disabled = value > assentos;
    });
    selectPeople(Math.min(2, assentos));

    mesaModal.classList.add('active');
    mesaModal.setAttribute('aria-hidden', 'false');
}

function closeMesaModal() {
    mesaModal.classList.remove('active');
    mesaModal.setAttribute('aria-hidden', 'true');
}

function openJuntarModal(button) {
    const origemId = button.dataset.juntarOrigem;
    const origemNumero = button.dataset.juntarNumero;

    document.getElementById('juntarOrigemLabel').textContent = 'Mesa ' + origemNumero;
    juntarForm.action = mesasBaseUrl + '/' + origemId + '/juntar';
    juntarDestino.value = '';

    juntarDestino.querySelectorAll('option').forEach(function(option) {
        const mesmaMesa = option.value === origemId;
        option.disabled = mesmaMesa;
        option.hidden = mesmaMesa;
    });

    juntarModal.classList.add('active');
    juntarModal.setAttribute('aria-hidden', 'false');
    juntarDestino.focus();
}

function closeJuntarModal() {
    juntarModal.classList.remove('active');
    juntarModal.setAttribute('aria-hidden', 'true');
}

function selectPeople(total) {
    document.querySelectorAll('[data-people]').forEach(function(button) {
        button.classList.toggle('active', Number(button.dataset.people) === Number(total));
    });
}

modalPrimaryAction.addEventListener('click', function() {
    if (mesaModalHref) {
        window.location = mesaModalHref;
    }
});

mesaModal.addEventListener('click', function(event) {
    if (event.target === mesaModal) closeMesaModal();
});

juntarModal.addEventListener('click', function(event) {
    if (event.target === juntarModal) closeJuntarModal();
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeMesaModal();
        closeJuntarModal();
    }
});

mesaSearch.addEventListener('input', filterMesas);
mesaStatusFilter.addEventListener('change', filterMesas);
</script>
@endsection
