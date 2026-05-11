@extends('layouts.app')
@section('page-title', 'Mesas')
@section('breadcrumb', 'Controle do salão')

@section('styles')
<style>
.mesas-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:16px; }
.mesa-wrap { display:flex; flex-direction:column; gap:6px; }

.mesa-card {
    border-radius:14px; padding:16px 12px 14px;
    border:2px solid var(--border);
    text-align:center; cursor:pointer;
    transition:all .18s; position:relative;
    background:var(--bg2);
}
.mesa-card::after {
    content:''; position:absolute; bottom:0; left:0; right:0;
    height:3px; border-radius:0 0 12px 12px;
    background: var(--mc, var(--muted));
}
.mesa-card.disponivel { --mc:#22c55e; border-color:rgba(34,197,94,.2); }
.mesa-card.ocupada    { --mc:#ef4444; border-color:rgba(239,68,68,.35); background:rgba(239,68,68,.04); }
.mesa-card.reservada  { --mc:#eab308; border-color:rgba(234,179,8,.35); background:rgba(234,179,8,.04); }
.mesa-card:hover      { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.3); }

.mc-number { font-size:28px; font-weight:900; color:#fff; line-height:1; }
.mc-seats  { font-size:11px; color:var(--muted); margin:2px 0 8px; }
.mc-pedidos{ font-size:11px; color:var(--accent); font-weight:700; margin-bottom:4px; }

.status-btns { display:flex; gap:5px; justify-content:center; flex-wrap:wrap; }
.sbtn {
    font-size:11px; padding:5px 10px; border-radius:8px;
    border:1.5px solid transparent; cursor:pointer;
    font-weight:700; font-family:inherit; transition:.15s;
    background:transparent;
}
.sbtn:disabled { opacity:.35; cursor:not-allowed; }
.sbtn-disponivel { border-color:rgba(34,197,94,.4); color:#4ade80; }
.sbtn-disponivel:not(:disabled):hover { background:rgba(34,197,94,.12); }
.sbtn-disponivel.ativo { background:rgba(34,197,94,.15); border-color:#4ade80; }
.sbtn-reservada  { border-color:rgba(234,179,8,.4);  color:#fbbf24; }
.sbtn-reservada:not(:disabled):hover  { background:rgba(234,179,8,.12); }
.sbtn-reservada.ativo  { background:rgba(234,179,8,.15);  border-color:#fbbf24; }
</style>
@endsection

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px">
    <div style="display:flex; gap:8px; flex-wrap:wrap">
        <span class="badge badge-success" style="padding:6px 14px">● Disponível</span>
        <span class="badge badge-danger"  style="padding:6px 14px">● Ocupada</span>
        <span class="badge badge-warning" style="padding:6px 14px">● Reservada</span>
    </div>
    @if(Auth::user()->role === 'gerente')
    <a href="{{ route('mesas.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova Mesa
    </a>
    @endif
</div>

<div class="mesas-grid">
    @forelse($mesas as $mesa)
    @php
        $temPedido    = $mesa->orders->isNotEmpty();
        $contaFechada = $mesa->orders->contains('status','pronto_entrega');
        $href = $temPedido ? route('mesas.conta', $mesa) : null;
    @endphp
    <div class="mesa-wrap">
        {{-- Card clicável --}}
        <div class="mesa-card {{ $mesa->status }}"
             @if($href) onclick="window.location='{{ $href }}'" @else style="cursor:default" @endif>
            <div class="mc-number">{{ $mesa->numero }}</div>
            <div class="mc-seats">{{ $mesa->assentos }} lugares</div>

            @if($temPedido)
            <div class="mc-pedidos">
                {{ $mesa->orders->count() }} pedido(s)
                @if($contaFechada)
                <br><span style="color:#fbbf24">Conta fechada</span>
                @endif
            </div>
            @endif

            <span class="badge badge-{{ $mesa->status==='disponivel'?'success':($mesa->status==='ocupada'?'danger':'warning') }}">
                {{ ucfirst($mesa->status) }}
            </span>
        </div>

        {{-- Botões de status — só aparece se não tiver pedidos ativos --}}
        @if(in_array(Auth::user()->role, ['garcom','gerente']) && !$temPedido)
        <div class="status-btns">
            <form method="POST" action="{{ route('mesas.atualizar', $mesa) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="disponivel">
                <button type="submit" class="sbtn sbtn-disponivel {{ $mesa->status==='disponivel'?'ativo':'' }}"
                        @if($mesa->status==='disponivel') disabled @endif>
                    Livre
                </button>
            </form>
            <form method="POST" action="{{ route('mesas.atualizar', $mesa) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="reservada">
                <button type="submit" class="sbtn sbtn-reservada {{ $mesa->status==='reservada'?'ativo':'' }}"
                        @if($mesa->status==='reservada') disabled @endif>
                    Reservar
                </button>
            </form>
        </div>
        @elseif(in_array(Auth::user()->role, ['garcom','gerente']) && $temPedido)
        <div style="text-align:center; font-size:11px; padding:4px 0">
            @if($contaFechada)
            <span style="color:#fbbf24"><i class="fas fa-clock" style="font-size:10px"></i> Aguardando pagamento</span>
            @else
            <span style="color:var(--muted)"><i class="fas fa-lock" style="font-size:10px"></i> Pedidos em aberto</span>
            @endif
        </div>
        @endif

        {{-- Editar/excluir gerente --}}
        @if(Auth::user()->role === 'gerente')
        <div style="display:flex; gap:5px; justify-content:center">
            <a href="{{ route('mesas.edit', $mesa) }}" class="btn btn-secondary btn-sm btn-icon">
                <i class="fas fa-pencil"></i>
            </a>
            <form method="POST" action="{{ route('mesas.destroy', $mesa) }}"
                  onsubmit="return confirm('Deletar Mesa {{ $mesa->numero }}?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm btn-icon">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
        @endif
    </div>
    @empty
    <div class="empty-state" style="grid-column:1/-1">
        <i class="fas fa-chair"></i><p>Nenhuma mesa cadastrada</p>
    </div>
    @endforelse
</div>
@endsection
