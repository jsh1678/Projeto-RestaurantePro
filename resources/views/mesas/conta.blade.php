@extends('layouts.app')
@section('page-title')
Mesa {{ $mesa->numero }} — Conta
@endsection
@section('breadcrumb', 'Conta completa da mesa')

@section('styles')
<style>
.conta-item-row {
    display:flex; align-items:center; gap:10px;
    padding:8px 0; border-bottom:1px solid rgba(255,255,255,.05);
}
.conta-item-row:last-child { border-bottom:none; }
.pedido-bloco {
    background:var(--bg); border:1px solid var(--border);
    border-radius:10px; padding:14px; margin-bottom:12px;
}
.pedido-bloco.cancelado-bloco {
    opacity:.45; border-style:dashed;
}
.pedido-bloco-header {
    display:flex; justify-content:space-between; align-items:center;
    margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid var(--border);
    flex-wrap:wrap; gap:8px;
}
.aviso-fechada {
    background:rgba(249,115,22,.08); border:1px solid rgba(249,115,22,.25);
    border-radius:10px; padding:12px 16px; margin-bottom:16px;
    display:flex; align-items:center; gap:10px; font-size:13px; color:#fb923c;
}
.conta-layout {
    display:grid;
    grid-template-columns:minmax(0, 1fr) 430px;
    gap:14px;
    align-items:start;
}
.conta-resumo {
    position:sticky;
    top:80px;
}
.conta-hero {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 12px;
    align-items: center;
    border: 1px solid var(--border);
    border-radius: 14px;
    background: var(--bg2);
    padding: 12px 14px;
    margin-bottom: 12px;
}
.conta-hero-title {
    color: #fff;
    font-size: 22px;
    font-weight: 900;
    line-height: 1;
}
.conta-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 6px 10px;
    margin-top: 6px;
    color: var(--muted);
    font-size: 12px;
}
.conta-hero-meta strong {
    display: inline;
    color: #fff;
    font-size: 12px;
    margin: 0;
}
.conta-hero-total {
    text-align: right;
}
.conta-hero-total span {
    display: block;
    color: var(--muted);
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}
.conta-hero-total strong {
    display: block;
    color: var(--accent);
    font-size: 24px;
    font-family: monospace;
    line-height: 1.1;
}
.conta-hero-meta span,
.payment-line span {
    color: var(--muted);
    font-size: 12px;
}
.conta-hero-meta strong,
.payment-line strong {
    display: block;
    color: #fff;
    font-size: 13px;
    margin-top: 2px;
}
.status-pay-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 28px;
    padding: 0 10px;
    border-radius: 999px;
    background: rgba(249,115,22,.14);
    border: 1px solid rgba(249,115,22,.35);
    color: #fdba74;
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    white-space: nowrap;
}
.payment-summary {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 8px;
    margin-bottom: 10px;
}
.payment-line {
    display: block;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--bg);
    padding: 8px 10px;
}
.payment-line.total {
    border-color: rgba(249,115,22,.35);
    margin-top: 0;
    padding-top: 8px;
}
.payment-line.total strong {
    color: var(--accent);
    font-size: 18px;
}
.service-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: var(--bg);
    padding: 8px 10px;
    margin-bottom: 10px;
    cursor: pointer;
}
.service-toggle input { display: none; }
.service-switch {
    width: 46px;
    height: 26px;
    border-radius: 999px;
    background: #374151;
    position: relative;
    flex: 0 0 auto;
}
.service-switch::after {
    content: "";
    position: absolute;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #fff;
    top: 4px;
    left: 4px;
    transition: .18s;
}
.service-toggle input:checked + .service-switch {
    background: #22c55e;
}
.service-toggle input:checked + .service-switch::after {
    transform: translateX(20px);
}
.service-toggle.active .service-switch {
    background: #22c55e;
}
.service-toggle.active .service-switch::after {
    transform: translateX(20px);
}
.method-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 6px;
    margin-bottom: 10px;
}
.method-btn {
    min-height: 38px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--bg);
    color: #fff;
    font-weight: 900;
    cursor: pointer;
}
.method-btn.active {
    border-color: var(--accent);
    background: rgba(249,115,22,.14);
    color: var(--accent);
}
.payment-flow {
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--bg);
    padding: 8px;
    margin-bottom: 10px;
}
.money-change-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
}
.payment-confirm {
    width: 100%;
    min-height: 44px;
    justify-content: center;
    font-size: 15px;
    font-weight: 900;
}
.consumo-toggle {
    width: 100%;
    min-height: 36px;
    justify-content: center;
    margin-bottom: 8px;
}
.consumo-details {
    display: none;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 8px;
    margin-bottom: 10px;
    background: var(--bg);
}
.consumo-details.open {
    display: block;
}
.pagamento-form > .form-group,
.pagamento-form > .viagem-check {
    display: none !important;
}
.pagamento-form .form-control,
.pagamento-form .form-select {
    min-height: 38px;
    padding-top: 7px;
    padding-bottom: 7px;
}

@media (max-width: 768px) {
    .conta-layout {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .conta-resumo {
        position: static;
    }

    .conta-item-row {
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
    }

    .conta-item-row form {
        grid-column: 1 / -1;
    }

    .conta-item-row form .btn {
        width: 100%;
        margin-top: 6px;
    }
    .conta-hero {
        grid-template-columns: 1fr;
    }
    .status-pay-badge {
        width: 100%;
        justify-content: center;
    }
    .method-grid,
    .money-change-grid {
        grid-template-columns: 1fr;
    }
    .conta-resumo {
        padding-bottom: 74px;
    }
    .payment-confirm {
        position: sticky;
        bottom: 10px;
        z-index: 5;
    }
}
</style>
@endsection

@section('content')

{{-- Cabeçalho --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px">
    <div>
        <h2 style="font-size:22px; font-weight:800; color:#fff; margin:0">
            🪑 Mesa {{ $mesa->numero }}
            @if($contaFechada)
            <span class="badge badge-warning" style="font-size:13px; margin-left:8px">Conta Fechada</span>
            @endif
        </h2>
        <div style="color:var(--muted); font-size:13px; margin-top:2px">
            {{ $pedidos->count() }} pedido(s) · {{ $mesa->assentos }} lugares
        </div>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap">
        {{-- Só mostra "Novo Pedido" se a conta NÃO estiver fechada --}}
        @if(!$contaFechada && in_array(Auth::user()?->role, ['garcom','gerente']))
        <a href="{{ route('orders.create', ['table_id' => $mesa->id]) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Pedido
        </a>
        @endif
        <a href="{{ route('mesas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

{{-- Aviso conta fechada --}}
@if(session('warning'))
<div style="background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.3);border-radius:10px;padding:12px 16px;margin-bottom:16px;color:#fde047;display:flex;align-items:flex-start;gap:10px;font-size:13px">
    <i class="fas fa-exclamation-triangle" style="margin-top:2px;flex-shrink:0;font-size:16px"></i>
    <div>{{ session('warning') }}</div>
</div>
@endif
@if($contaFechada)
<div class="aviso-fechada">
    <i class="fas fa-lock" style="font-size:18px; flex-shrink:0"></i>
    <div>
        <strong>Conta fechada.</strong> Não é possível adicionar novos pedidos.
        O caixa irá processar o pagamento em breve.
    </div>
</div>
@endif

@if($pedidos->isEmpty())
<div class="empty-state" style="margin-top:60px">
    <i class="fas fa-utensils"></i>
    <p>Nenhum pedido em aberto para esta mesa</p>
    @if(in_array(Auth::user()?->role, ['garcom','gerente']))
    <a href="{{ route('orders.create', ['table_id' => $mesa->id]) }}" class="btn btn-primary" style="margin-top:16px">
        <i class="fas fa-plus"></i> Criar Pedido
    </a>
    @endif
</div>
@else

@php
    $pedidoInicial = $pedidos->sortBy('created_at')->first();
    $abertaHa = $pedidoInicial?->created_at ? $pedidoInicial->created_at->diffForHumans(null, true) : 'agora';
    $garcomResponsavel = $pedidoInicial?->user?->name ?? $pedidos->first(fn($pedido) => $pedido->user)?->user?->name ?? 'Nao informado';
    $statusContaLabel = $contaFechada ? 'Pronto para receber' : 'Conta em consumo';
@endphp
<div class="conta-hero">
    <div>
        <div class="conta-hero-title">Mesa {{ str_pad($mesa->numero, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="conta-hero-meta">
            <span>Aberta ha <strong>{{ $abertaHa }}</strong></span>
            <span>Garcom <strong>{{ $garcomResponsavel }}</strong></span>
            <span><strong>{{ $totalItens }}</strong> itens</span>
            <span>{{ $statusContaLabel }}</span>
        </div>
    </div>
    <div class="conta-hero-total">
        <span>Total</span>
        <strong>R$ {{ number_format($saldoRestante > 0 ? $saldoRestante : $totalConta,2,',','.') }}</strong>
    </div>
</div>

<div class="conta-layout">

    {{-- Lista de pedidos --}}
    <div>
        @foreach($pedidos as $pedido)
        @php
            $cores  = ['em_preparo'=>'warning','pronto'=>'success','pronto_entrega'=>'warning','aguardando_pagamento'=>'info','entregue'=>'info','aberto'=>'secondary'];
            $labels = ['em_preparo'=>'Em preparo','pronto'=>'Pronto','pronto_entrega'=>'Aguardando pagamento','aguardando_pagamento'=>'Aguardando pagamento','entregue'=>'Entregue','aberto'=>'Aberto'];
            $podeCancelItem = !in_array($pedido->status, ['pago','aguardando_pagamento','cancelado'])
                              && in_array(Auth::user()?->role, ['garcom','gerente']);
        @endphp
        <div class="pedido-bloco">
            <div class="pedido-bloco-header">
                <div style="display:flex; align-items:center; gap:10px">
                    <span style="font-family:monospace; font-weight:800; color:var(--accent); font-size:15px">
                        #{{ str_pad($pedido->id,4,'0',STR_PAD_LEFT) }}
                    </span>
                    <span class="badge badge-{{ $cores[$pedido->status] ?? 'secondary' }}">
                        {{ $labels[$pedido->status] ?? $pedido->status }}
                    </span>
                </div>
                <div style="display:flex; align-items:center; gap:10px">
                    <span style="font-size:12px; color:var(--muted)">
                        {{ $pedido->created_at->format('H:i') }}
                        @if($pedido->user) · {{ $pedido->user->name }} @endif
                    </span>
                </div>
            </div>

            @foreach($pedido->items as $item)
            <div class="conta-item-row">
                <span style="color:var(--muted); font-size:13px; min-width:28px; text-align:right">{{ $item->quantidade }}×</span>
                <span style="flex:1; color:#fff; font-size:13px">{{ $item->menuItem->nome ?? '—' }}</span>
                @php $si = ['pendente'=>'warning','em_preparo'=>'warning','pronto'=>'success']; @endphp
                <span class="badge badge-{{ $si[$item->status] ?? 'secondary' }}" style="font-size:10px">
                    {{ ucfirst($item->status) }}
                </span>
                <span style="font-family:monospace; font-weight:700; color:#fff; white-space:nowrap">
                    R$ {{ number_format($item->subtotal,2,',','.') }}
                </span>
                @if($podeCancelItem)
                <form method="POST" action="{{ route('order-items.cancelar', $item) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm btn-icon"
                            title="Cancelar 1 unidade"
                            onclick="return confirm('Cancelar 1 unidade deste item?')">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
                @endif
            </div>
            @endforeach

            @if($pedido->observacoes)
            <div style="margin-top:8px; font-size:12px; color:var(--muted); font-style:italic">
                <i class="fas fa-comment"></i> {{ $pedido->observacoes }}
            </div>
            @endif

            <div style="text-align:right; margin-top:8px; font-weight:700; color:var(--accent); font-size:14px">
                Subtotal: R$ {{ number_format($pedido->total,2,',','.') }}
            </div>
        </div>
        @endforeach
    </div>

    {{-- Resumo fixo --}}
    <div class="conta-resumo">
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-receipt"></i> Resumo da Conta</div>
            </div>

            @foreach($pedidos as $pedido)
            <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid rgba(255,255,255,.04); font-size:13px">
                <span style="color:var(--muted)">
                    #{{ str_pad($pedido->id,4,'0',STR_PAD_LEFT) }}
                    <span style="font-size:11px">({{ $pedido->items->count() }} item(s))</span>
                </span>
                <span style="color:#fff; font-weight:600">R$ {{ number_format($pedido->total,2,',','.') }}</span>
            </div>
            @endforeach

            <div style="border-top:2px solid var(--accent); margin-top:10px; padding-top:12px; margin-bottom:16px">
                <div style="display:flex; justify-content:space-between; align-items:center">
                    <span style="font-size:18px; font-weight:800; color:#fff">Total</span>
                    <span style="font-size:22px; font-weight:800; color:var(--accent)">
                        R$ {{ number_format($totalConta,2,',','.') }}
                    </span>
                </div>
                <div style="font-size:12px; color:var(--muted); margin-top:4px">
                    {{ $totalItens }} item(s) · {{ $pedidos->count() }} pedido(s)
                </div>
            </div>

            {{-- Fechar conta (garçom) — só se ainda não fechada --}}
            @if(($totalPago ?? 0) > 0 || ($taxaGarcom ?? 0) > 0)
            <div style="background:rgba(34,197,94,.06); border:1px solid rgba(34,197,94,.18); border-radius:10px; padding:12px; margin-bottom:14px; font-size:13px">
                @if(($taxaGarcom ?? 0) > 0)
                <div style="display:flex; justify-content:space-between; margin-bottom:6px">
                    <span style="color:var(--muted)">10% garcom</span>
                    <strong>R$ {{ number_format($taxaGarcom,2,',','.') }}</strong>
                </div>
                @endif
                <div style="display:flex; justify-content:space-between; margin-bottom:6px">
                    <span style="color:var(--muted)">Pago</span>
                    <strong style="color:#4ade80">R$ {{ number_format($totalPago,2,',','.') }}</strong>
                </div>
                <div style="display:flex; justify-content:space-between">
                    <span style="color:var(--muted)">Restante</span>
                    <strong style="color:#fff">R$ {{ number_format($saldoRestante,2,',','.') }}</strong>
                </div>
            </div>
            @endif

            @if(!$contaFechada && in_array(Auth::user()?->role, ['garcom','gerente']))
            <form method="POST" action="{{ route('mesas.fechar-conta', $mesa) }}">
                @csrf
                <button type="submit" class="btn btn-warning"
                        style="width:100%; justify-content:center; padding:12px; margin-bottom:10px"
                        onclick="return confirm('Fechar a conta da Mesa {{ $mesa->numero }}?\n\nApós fechar não será possível adicionar novos pedidos.')">
                    <i class="fas fa-lock"></i> Fechar Conta
                </button>
            </form>
            @endif

            {{-- Já fechada: aviso para garçom --}}
            @if($contaFechada && in_array(Auth::user()?->role, ['garcom']) && !in_array(Auth::user()?->role, ['caixa','gerente']))
            <div style="text-align:center; color:var(--muted); font-size:13px; padding:10px 0">
                <i class="fas fa-hourglass-half"></i> Aguardando pagamento no caixa
            </div>
            @endif

            {{-- Divisão de conta --}}
            <div style="border-top:1px solid var(--border); padding-top:14px; margin-bottom:14px">
                <div style="font-size:13px; font-weight:700; color:#fff; margin-bottom:10px">
                    <i class="fas fa-users"></i> Dividir Conta
                </div>
                {{-- Atalhos rápidos --}}
                <div style="display:flex; gap:6px; margin-bottom:10px; flex-wrap:wrap">
                    @foreach([2,3,4,5,6] as $n)
                    <button type="button" onclick="calcDivisao({{ $n }})"
                            style="padding:6px 14px; border-radius:8px; border:1.5px solid var(--border); background:transparent; color:var(--muted); cursor:pointer; font-weight:700; font-size:13px; transition:.15s"
                            onmouseover="this.style.borderColor='#60a5fa';this.style.color='#60a5fa'"
                            onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted)'">
                        {{ $n }}x
                    </button>
                    @endforeach
                    <input type="number" id="divisao-pessoas" min="1" max="99" placeholder="Outro"
                           class="form-control" style="width:80px; text-align:center; padding:6px 8px"
                           oninput="calcDivisao(this.value)">
                </div>
                <div id="divisao-resultado" style="display:none;
                     background:rgba(59,130,246,.08); border:1px solid rgba(59,130,246,.25);
                     border-radius:10px; padding:14px">
                    <div style="font-size:12px; color:var(--muted); margin-bottom:6px">
                        <i class="fas fa-divide"></i> Divisão igual — cada pessoa paga:
                    </div>
                    <div id="divisao-valor" style="font-size:26px; font-weight:900; color:#60a5fa; font-family:monospace; margin-bottom:4px"></div>
                    <div id="divisao-info" style="font-size:12px; color:var(--muted)"></div>
                </div>
            </div>

            {{-- Pagar (caixa/gerente) --}}
            @if(in_array(Auth::user()?->role, ['caixa','gerente']))
            <div style="border-top:1px solid var(--border); padding-top:16px">
                <div style="font-size:13px; font-weight:700; color:#fff; margin-bottom:12px">
                    <i class="fas fa-credit-card"></i> Registrar Pagamento
                </div>
                <form method="POST" action="{{ route('mesas.pagar-conta', $mesa) }}" class="pagamento-form js-ajax-payment" data-total="{{ $saldoRestante > 0 ? $saldoRestante : $totalConta }}" data-base-total="{{ $totalConta }}" data-taxa-aplicada="{{ $taxaGarcom > 0 ? 1 : 0 }}" data-pedido="MESA-{{ $mesa->numero }}" data-pix-payload="{{ e(\App\Support\PixPayload::make((float) ($saldoRestante > 0 ? $saldoRestante : $totalConta), 'MESA' . $mesa->numero)) }}">
                    @csrf
                    @php
                        $subtotalPagamento = $saldoRestante > 0 ? $saldoRestante : $totalConta;
                        $taxaPreview = round($totalConta * 0.10, 2);
                    @endphp
                    <div class="payment-summary">
                        <div class="payment-line"><span>Subtotal</span><strong>R$ {{ number_format($totalConta,2,',','.') }}</strong></div>
                        <div class="payment-line"><span>Taxa de Servico</span><strong class="js-service-value">{{ ($taxaGarcom ?? 0) > 0 ? 'R$ ' . number_format($taxaGarcom,2,',','.') : 'R$ 0,00' }}</strong></div>
                        <div class="payment-line"><span>Descontos</span><strong>R$ 0,00</strong></div>
                        @if(($totalPago ?? 0) > 0)
                        <div class="payment-line"><span>Ja pago</span><strong style="color:#4ade80">R$ {{ number_format($totalPago,2,',','.') }}</strong></div>
                        @endif
                        <div class="payment-line total"><span>Total</span><strong class="js-payment-total">R$ {{ number_format($subtotalPagamento,2,',','.') }}</strong></div>
                    </div>

                    <button type="button" class="btn btn-secondary consumo-toggle js-consumo-toggle">
                        <i class="fas fa-chevron-down"></i> Ver consumo ({{ $totalItens }} itens)
                    </button>
                    <div class="consumo-details js-consumo-details">
                        @foreach($pedidos as $pedido)
                            @foreach($pedido->items as $item)
                            <div class="payment-line" style="padding:5px 0">
                                <span>{{ $item->quantidade }}x {{ $item->menuItem->nome ?? 'Item' }}</span>
                                <strong>R$ {{ number_format($item->subtotal,2,',','.') }}</strong>
                            </div>
                            @endforeach
                        @endforeach
                    </div>

                    @if(($taxaGarcom ?? 0) <= 0)
                    <button type="button" class="service-toggle js-service-toggle">
                        <span class="service-switch" aria-hidden="true"></span>
                        <span style="flex:1;text-align:left">
                            <strong style="display:block;color:#fff">Taxa de Servico</strong>
                            <small style="color:var(--muted)">OFF - cobrar 10% adiciona R$ {{ number_format($taxaPreview,2,',','.') }}</small>
                        </span>
                    </button>
                    @endif

                    <div class="method-grid" aria-label="Forma de pagamento">
                        <button type="button" class="method-btn" data-method="pix">PIX</button>
                        <button type="button" class="method-btn active" data-method="dinheiro">DINHEIRO</button>
                        <button type="button" class="method-btn" data-method="cartao_credito">CREDITO</button>
                        <button type="button" class="method-btn" data-method="cartao_debito">DEBITO</button>
                        <button type="button" class="method-btn" data-method="multiplo">MULTIPLO</button>
                    </div>

                    <div class="payment-flow js-flow-default" style="display:none">
                        <div class="payment-line"><span>Forma de pagamento</span><strong class="js-method-label">PIX</strong></div>
                        <div class="payment-line"><span>Total</span><strong class="js-flow-total">R$ {{ number_format($subtotalPagamento,2,',','.') }}</strong></div>
                    </div>

                    <div class="payment-flow js-flow-money">
                        <div class="money-change-grid">
                            <div class="form-group" style="margin:0;display:block!important">
                                <label>Valor da Conta</label>
                                <input type="text" class="form-control js-conta-display" readonly value="R$ {{ number_format($subtotalPagamento,2,',','.') }}">
                            </div>
                            <div class="form-group" style="margin:0;display:block!important">
                                <label>Valor Recebido</label>
                                <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control js-cash-received" value="{{ number_format($subtotalPagamento,2,'.','') }}">
                            </div>
                            <div class="form-group" style="margin:0;display:block!important">
                                <label>Troco</label>
                                <input type="text" class="form-control js-change-display" readonly value="R$ 0,00">
                            </div>
                        </div>
                        <strong class="js-change-value" style="display:none">R$ 0,00</strong>
                    </div>

                    <div class="payment-flow js-flow-multiple" style="display:none">
                        <div class="payment-line"><span>Pagamento multiplo</span><strong>registre uma parte por vez</strong></div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px">
                            <div class="form-group" style="margin:0;display:block!important">
                                <label>Valor desta parte</label>
                                <input type="number" step="0.01" min="0.01" inputmode="decimal" class="form-control js-partial-value" value="{{ number_format($subtotalPagamento,2,'.','') }}">
                            </div>
                            <div class="form-group" style="margin:0;display:block!important">
                                <label>Restante apos pagar</label>
                                <input type="text" class="form-control js-remaining-display" readonly value="R$ 0,00">
                            </div>
                        </div>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:10px">
                            <button type="button" class="btn btn-secondary btn-sm js-split-suggest" data-method="pix">PIX + Dinheiro</button>
                            <button type="button" class="btn btn-secondary btn-sm js-split-suggest" data-method="cartao_debito">Debito + Dinheiro</button>
                            <button type="button" class="btn btn-secondary btn-sm js-split-suggest" data-method="cartao_credito">Credito + Dinheiro</button>
                        </div>
                    </div>
                    <div class="payment-extra js-credito-extra" style="display:none; background:rgba(168,85,247,.08); border:1px solid rgba(168,85,247,.24); border-radius:10px; padding:10px; margin-bottom:12px">
                        <label style="font-size:12px; color:var(--muted); display:block; margin-bottom:6px">Parcelas no crédito</label>
                        <select name="parcelas" class="form-select js-parcelas" disabled>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }}x</option>
                            @endfor
                        </select>
                        <div class="js-parcela-info" style="font-size:12px; color:var(--muted); margin-top:6px"></div>
                    </div>
                    <div class="payment-extra js-pix-extra" style="display:none; background:rgba(59,130,246,.08); border:1px solid rgba(59,130,246,.24); border-radius:10px; padding:10px; margin-bottom:12px; text-align:center">
                        <img class="js-pix-qr" alt="QR Code PIX" width="150" height="150" style="background:#fff; border-radius:8px; padding:6px; margin-bottom:8px">
                        <div class="js-pix-code td-mono" style="font-size:11px; color:var(--muted); word-break:break-all"></div>
                    </div>
                    <div class="form-group">
                        <label>Forma de Pagamento</label>
                        <select name="metodo" class="form-select js-metodo-pagamento" required>
                            <option value="dinheiro">💵 Dinheiro</option>
                            <option value="pix">📱 Pix</option>
                            <option value="cartao_debito">💳 Débito</option>
                            <option value="cartao_credito">💳 Crédito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valor Recebido (R$)</label>
                        <input type="number" name="valor_pago" id="valor_pago_input" step="0.01"
                               min="0.01" max="{{ number_format($saldoRestante > 0 ? $saldoRestante : $totalConta,2,'.','') }}"
                               inputmode="decimal" class="form-control"
                               value="{{ number_format($saldoRestante > 0 ? $saldoRestante : $totalConta,2,'.','') }}" required>
                        <div style="font-size:11px; color:var(--muted); margin-top:4px" id="label-total-conta">
                            Restante da conta: <strong style="color:#fff">R$ {{ number_format($saldoRestante > 0 ? $saldoRestante : $totalConta,2,',','.') }}</strong>
                        </div>
                    </div>
                    @if(($taxaGarcom ?? 0) <= 0)
                    <label class="viagem-check" style="margin-bottom:12px">
                        <input type="checkbox" name="taxa_garcom" id="taxa_garcom" value="1">
                        <span>Adicionar 10% do garcom</span>
                    </label>
                    @endif
                    @php $totalFmt = number_format($saldoRestante > 0 ? $saldoRestante : $totalConta,2,',','.'); @endphp
                    <button type="submit" class="btn btn-success payment-confirm">
                        <i class="fas fa-money-bill-wave"></i> Confirmar Pagamento
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
const totalConta = {{ ($saldoRestante ?? $totalConta) > 0 ? ($saldoRestante ?? $totalConta) : ($totalConta ?? 0) }};
const totalBaseConta = {{ $totalConta ?? 0 }};
const taxaJaAplicada = {{ ($taxaGarcom ?? 0) > 0 ? 'true' : 'false' }};

function calcDivisao(n) {
    const pessoas = parseInt(n) || parseInt(document.getElementById('divisao-pessoas').value) || 0;
    const resultado = document.getElementById('divisao-resultado');
    const valorEl   = document.getElementById('divisao-valor');
    const infoEl    = document.getElementById('divisao-info');

    if (pessoas < 2) {
        resultado.style.display = 'none';
        // Restaurar valor total no campo de pagamento
        const vp = document.getElementById('valor_pago_input');
        if (vp) vp.value = totalConta.toFixed(2);
        return;
    }

    const porPessoa = totalConta / pessoas;
    valorEl.textContent = 'R$ ' + porPessoa.toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits:2});
    infoEl.textContent  = pessoas + ' pessoas × R$ ' + porPessoa.toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits:2}) + ' = R$ ' + totalConta.toLocaleString('pt-BR', {minimumFractionDigits:2});
    resultado.style.display = 'block';

    // Atualizar campo valor_pago com o valor POR PESSOA
    const vp = document.getElementById('valor_pago_input');
    if (vp) {
        vp.value = porPessoa.toFixed(2);
        vp.title = 'Valor por pessoa (total: R$ ' + totalConta.toLocaleString('pt-BR', {minimumFractionDigits:2}) + ')';
    }

    // Atualizar label informativo
    const labelTotal = document.getElementById('label-total-conta');
    if (labelTotal) {
        labelTotal.textContent = 'Valor por pessoa (' + pessoas + 'x) — total: R$ ' + totalConta.toLocaleString('pt-BR', {minimumFractionDigits:2});
    }
}

document.querySelectorAll('.pagamento-form').forEach((form) => {
    const metodo = form.querySelector('.js-metodo-pagamento');
    const creditoExtra = form.querySelector('.js-credito-extra');
    const pixExtra = form.querySelector('.js-pix-extra');
    const parcelas = form.querySelector('.js-parcelas');
    const parcelaInfo = form.querySelector('.js-parcela-info');
    const pixQr = form.querySelector('.js-pix-qr');
    const pixCode = form.querySelector('.js-pix-code');
    let total = Number(form.dataset.total || 0);
    const baseTotal = Number(form.dataset.baseTotal || 0);
    const taxaCheckbox = form.querySelector('input[name="taxa_garcom"]');
    const valorInput = form.querySelector('input[name="valor_pago"]');
    const labelTotal = document.getElementById('label-total-conta');
    const originalPixPayload = form.dataset.pixPayload || '';
    const pedido = form.dataset.pedido || '';
    const methodButtons = form.querySelectorAll('.method-btn');
    const defaultFlow = form.querySelector('.js-flow-default');
    const moneyFlow = form.querySelector('.js-flow-money');
    const multipleFlow = form.querySelector('.js-flow-multiple');
    const methodLabel = form.querySelector('.js-method-label');
    const paymentTotal = form.querySelector('.js-payment-total');
    const flowTotal = form.querySelector('.js-flow-total');
    const contaDisplay = form.querySelector('.js-conta-display');
    const cashReceived = form.querySelector('.js-cash-received');
    const changeValue = form.querySelector('.js-change-value');
    const changeDisplay = form.querySelector('.js-change-display');
    const partialValue = form.querySelector('.js-partial-value');
    const remainingDisplay = form.querySelector('.js-remaining-display');
    const serviceValue = form.querySelector('.js-service-value');
    const serviceToggle = form.querySelector('.js-service-toggle');
    const consumoToggle = form.querySelector('.js-consumo-toggle');
    const consumoDetails = form.querySelector('.js-consumo-details');
    let modoMultiplo = false;

    const formatMoney = (value) => value.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

    const updateParcelas = () => {
        const qtd = Number(parcelas.value || 1);
        parcelaInfo.textContent = `${qtd}x de ${formatMoney(total / qtd)} sem juros`;
    };

    const syncTotalLabels = () => {
        if (paymentTotal) paymentTotal.textContent = formatMoney(total);
        if (flowTotal) flowTotal.textContent = formatMoney(total);
        if (contaDisplay) contaDisplay.value = formatMoney(total);
        if (serviceValue && taxaCheckbox) {
            serviceValue.textContent = taxaCheckbox.checked ? formatMoney(baseTotal * 0.10) : formatMoney(0);
        }
    };

    const clampValor = () => {
        if (!valorInput) return;

        const valor = Number(valorInput.value || 0);
        valorInput.max = total.toFixed(2);

        if (valor > total) {
            valorInput.value = total.toFixed(2);
        }
    };

    const updateTroco = () => {
        if (!cashReceived || !changeValue) return;
        const recebido = Number(cashReceived.value || 0);
        const troco = formatMoney(Math.max(0, recebido - total));
        changeValue.textContent = troco;
        if (changeDisplay) changeDisplay.value = troco;
    };

    const updateRestanteMultiplo = () => {
        if (!partialValue || !remainingDisplay || !valorInput) return;
        const parcial = Math.min(total, Math.max(0.01, Number(partialValue.value || 0)));
        valorInput.value = parcial.toFixed(2);
        remainingDisplay.value = formatMoney(Math.max(0, total - parcial));
    };

    const setMetodo = (method) => {
        modoMultiplo = method === 'multiplo';
        const metodoReal = modoMultiplo ? 'pix' : method;
        metodo.value = metodoReal;

        methodButtons.forEach((button) => button.classList.toggle('active', button.dataset.method === method));
        if (methodLabel) methodLabel.textContent = metodoReal === 'pix' ? 'PIX' : metodoReal.replace('cartao_', '').toUpperCase();

        if (defaultFlow) defaultFlow.style.display = ['pix', 'cartao_credito', 'cartao_debito'].includes(method) ? 'block' : 'none';
        if (moneyFlow) moneyFlow.style.display = method === 'dinheiro' ? 'block' : 'none';
        if (multipleFlow) multipleFlow.style.display = modoMultiplo ? 'block' : 'none';

        if (valorInput && !modoMultiplo) valorInput.value = total.toFixed(2);
        if (modoMultiplo) updateRestanteMultiplo();
        updateTroco();
        updatePaymentExtras();
    };

    const updateTaxaGarcom = () => {
        if (!taxaCheckbox) return;

        total = Number(form.dataset.total || 0) + (taxaCheckbox.checked ? baseTotal * 0.10 : 0);
        if (valorInput) valorInput.value = total.toFixed(2);
        clampValor();
        syncTotalLabels();
        updateTroco();
        updateRestanteMultiplo();
        if (labelTotal) {
            labelTotal.innerHTML = 'Restante da conta: <strong style="color:#fff">' + formatMoney(total) + '</strong>';
        }
        form.dataset.pixPayload = taxaCheckbox.checked ? '' : originalPixPayload;
        if (metodo.value === 'cartao_credito') updateParcelas();
    };

    const updatePaymentExtras = () => {
        const isCredito = metodo.value === 'cartao_credito';
        const isPix = metodo.value === 'pix';

        creditoExtra.style.display = isCredito ? 'block' : 'none';
        pixExtra.style.display = isPix ? 'block' : 'none';
        parcelas.disabled = !isCredito;

        if (isCredito) {
            updateParcelas();
        }

        if (isPix) {
            const payload = form.dataset.pixPayload || '';
            pixCode.textContent = payload || `Valor: ${formatMoney(total)}`;
            pixQr.style.display = payload ? '' : 'none';
            if (payload) {
                pixQr.src = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(payload)}`;
            }
        }
    };

    if (taxaCheckbox) {
        taxaCheckbox.addEventListener('change', () => {
            updateTaxaGarcom();
            updatePaymentExtras();
        });
    }
    if (serviceToggle && taxaCheckbox) {
        serviceToggle.addEventListener('click', () => {
            taxaCheckbox.checked = !taxaCheckbox.checked;
            serviceToggle.classList.toggle('active', taxaCheckbox.checked);
            const small = serviceToggle.querySelector('small');
            if (small) small.textContent = taxaCheckbox.checked ? 'ON - taxa aplicada ao total' : 'OFF - cobrar 10% adiciona ' + formatMoney(baseTotal * 0.10);
            updateTaxaGarcom();
        });
    }
    if (consumoToggle && consumoDetails) {
        consumoToggle.addEventListener('click', () => consumoDetails.classList.toggle('open'));
    }
    methodButtons.forEach((button) => {
        button.addEventListener('click', () => setMetodo(button.dataset.method));
    });
    form.querySelectorAll('.js-split-suggest').forEach((button) => {
        button.addEventListener('click', () => {
            metodo.value = button.dataset.method || 'pix';
            if (methodLabel) methodLabel.textContent = button.textContent.trim();
            updatePaymentExtras();
        });
    });
    if (cashReceived) cashReceived.addEventListener('input', updateTroco);
    if (partialValue) partialValue.addEventListener('input', updateRestanteMultiplo);
    metodo.addEventListener('change', updatePaymentExtras);
    parcelas.addEventListener('change', updateParcelas);
    if (valorInput) valorInput.addEventListener('input', clampValor);
    clampValor();
    syncTotalLabels();
    setMetodo(metodo.value || 'dinheiro');
    updatePaymentExtras();
});

document.querySelectorAll('.js-ajax-payment').forEach((form) => {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const button = form.querySelector('.payment-confirm');
        const originalHtml = button ? button.innerHTML : '';
        if (button) {
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            });

            const data = await response.json().catch(() => ({}));
            if (!response.ok || data.success === false) {
                throw new Error(data.message || 'Nao foi possivel confirmar o pagamento.');
            }

            if (typeof mostrarToast === 'function') {
                mostrarToast({
                    icone: '<i class="fas fa-check-circle"></i>',
                    titulo: 'Pagamento realizado',
                    msg: data.quitada ? 'Mesa liberada e caixa atualizado.' : 'Pagamento parcial registrado.',
                    duracao: 3500
                });
            }

            setTimeout(() => {
                window.location.href = data.redirect || window.location.href;
            }, 650);
        } catch (error) {
            if (button) {
                button.disabled = false;
                button.innerHTML = originalHtml;
            }
            if (typeof mostrarToast === 'function') {
                mostrarToast({
                    icone: '<i class="fas fa-triangle-exclamation"></i>',
                    titulo: 'Erro no pagamento',
                    msg: error.message,
                    duracao: 5000
                });
            } else {
                alert(error.message);
            }
        }
    });
});
</script>
@endsection
