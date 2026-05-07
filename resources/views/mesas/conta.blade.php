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
        @if(!$contaFechada && in_array(Auth::user()->role, ['garcom','gerente']))
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
    @if(in_array(Auth::user()->role, ['garcom','gerente']))
    <a href="{{ route('orders.create', ['table_id' => $mesa->id]) }}" class="btn btn-primary" style="margin-top:16px">
        <i class="fas fa-plus"></i> Criar Pedido
    </a>
    @endif
</div>
@else

<div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start">

    {{-- Lista de pedidos --}}
    <div>
        @foreach($pedidos as $pedido)
        @php
            $cores  = ['em_preparo'=>'warning','pronto'=>'success','pronto_entrega'=>'warning','aguardando_pagamento'=>'info','entregue'=>'info','aberto'=>'secondary'];
            $labels = ['em_preparo'=>'Em preparo','pronto'=>'Pronto','pronto_entrega'=>'Aguardando pagamento','aguardando_pagamento'=>'Aguardando pagamento','entregue'=>'Entregue','aberto'=>'Aberto'];
            $podeCancel = !in_array($pedido->status, ['pago','pronto_entrega','aguardando_pagamento','cancelado'])
                          && in_array(Auth::user()->role, ['garcom','gerente']);
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
                    {{-- Botão cancelar pedido --}}
                    @if($podeCancel)
                    <form method="POST" action="{{ route('orders.cancelar', $pedido) }}">
                        @csrf
                        @php $numPedido = str_pad($pedido->id,4,'0',STR_PAD_LEFT); @endphp
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Cancelar o pedido #{{ $numPedido }}? Esta ação não pode ser desfeita.')"
                                style="font-size:12px; padding:4px 10px">
                            <i class="fas fa-times"></i> Cancelar Pedido
                        </button>
                    </form>
                    @endif
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
    <div style="position:sticky; top:80px">
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
            @if(!$contaFechada && in_array(Auth::user()->role, ['garcom','gerente']))
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
            @if($contaFechada && in_array(Auth::user()->role, ['garcom']) && !in_array(Auth::user()->role, ['caixa','gerente']))
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
            @if(in_array(Auth::user()->role, ['caixa','gerente']))
            <div style="border-top:1px solid var(--border); padding-top:16px">
                <div style="font-size:13px; font-weight:700; color:#fff; margin-bottom:12px">
                    <i class="fas fa-credit-card"></i> Registrar Pagamento
                </div>
                <form method="POST" action="{{ route('mesas.pagar-conta', $mesa) }}">
                    @csrf
                    <div class="form-group">
                        <label>Forma de Pagamento</label>
                        <select name="metodo" class="form-select" required>
                            <option value="dinheiro">💵 Dinheiro</option>
                            <option value="pix">📱 Pix</option>
                            <option value="cartao_debito">💳 Débito</option>
                            <option value="cartao_credito">💳 Crédito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valor Recebido (R$)</label>
                        <input type="number" name="valor_pago" id="valor_pago_input" step="0.01"
                               min="0.01" class="form-control"
                               value="{{ number_format($totalConta,2,'.','') }}" required>
                        <div style="font-size:11px; color:var(--muted); margin-top:4px" id="label-total-conta">
                            Total da conta: <strong style="color:#fff">R$ {{ number_format($totalConta,2,',','.') }}</strong>
                        </div>
                    </div>
                    @php $totalFmt = number_format($totalConta,2,',','.'); @endphp
                    <button type="submit" class="btn btn-success"
                            style="width:100%; justify-content:center; padding:12px"
                            onclick="return confirm('Confirmar pagamento de R$ {{ $totalFmt }}?')">
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
const totalConta = {{ $totalConta ?? 0 }};

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
</script>
@endsection
