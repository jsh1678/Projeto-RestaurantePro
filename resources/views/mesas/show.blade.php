@extends('layouts.app')
@section('page-title')
Mesa {{ $mesa->numero }}
@endsection
@section('breadcrumb', 'Detalhes e controle da mesa')

@section('styles')
<style>
/* [FIX #9] Grid responsivo em vez de inline style */
.mesa-show-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
@media (max-width: 768px) {
    .mesa-show-grid {
        grid-template-columns: 1fr;
    }
}
.mesa-info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}
.mesa-info-row:last-child { border-bottom: none; }
.mesa-pedido-ativo {
    background: rgba(249,115,22,.06);
    border: 1px solid rgba(249,115,22,.2);
    border-radius: 12px;
    padding: 18px;
}
</style>
@endsection

@section('content')
<div class="mesa-show-grid">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">🪑 Mesa {{ $mesa->numero }}</div>
            <span class="badge badge-{{ $mesa->status==='disponivel'?'success':($mesa->status==='ocupada'?'danger':'warning') }}"
                  style="font-size:13px; padding:6px 14px">
                {{ ucfirst($mesa->status) }}
            </span>
        </div>

        <div style="display:grid; gap:14px; margin-bottom:20px">
            <div class="mesa-info-row">
                <span style="color:var(--muted)">Capacidade</span>
                <strong>{{ $mesa->assentos }} pessoas</strong>
            </div>
            @if($mesa->garcom)
            <div class="mesa-info-row">
                <span style="color:var(--muted)">Garçom</span>
                <strong>{{ $mesa->garcom->name }}</strong>
            </div>
            @endif
        </div>

        {{-- [FIX #4] Role verificada no controller (TableController@atualizar já tem abort(403)) --}}
        @if(Auth::user()?->role==='garcom')
        <form method="POST" action="{{ route('mesas.atualizar',$mesa) }}">
            @csrf @method('PATCH')
            <div class="form-group">
                {{-- [FIX #15] label com for associado ao id do select --}}
                <label for="status-mesa">Alterar Status</label>
                <select id="status-mesa" name="status" class="form-select" required>
                    <option value="disponivel" {{ $mesa->status==='disponivel'?'selected':'' }}>✅ Disponível</option>
                    <option value="ocupada"    {{ $mesa->status==='ocupada'?'selected':'' }}>🔴 Ocupada</option>
                    <option value="reservada"  {{ $mesa->status==='reservada'?'selected':'' }}>🟡 Reservada</option>
                </select>
            </div>
            {{-- [FIX #12] Loading no botão de submit --}}
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-floppy-disk"></i> Atualizar
            </button>
        </form>
        @endif

        <hr class="divider">
        <div style="display:flex; gap:8px">
            <a href="{{ route('mesas.index') }}" class="btn btn-secondary btn-sm">← Voltar</a>
            @if(Auth::user()?->role==='garcom')
            <a href="{{ route('orders.create',['table_id'=>$mesa->id]) }}" class="btn btn-primary btn-sm">➕ Novo Pedido</a>
            @endif
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">🧾 Pedido Ativo</div>
        </div>
        @if($pedidoAtivo)
        <div class="mesa-pedido-ativo">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
                <span style="font-size:18px; font-weight:800; color:#fff">
                    Pedido <span style="color:var(--gold); font-family:monospace">#{{ str_pad($pedidoAtivo->id,4,'0',STR_PAD_LEFT) }}</span>
                </span>
                <span class="badge badge-warning">{{ str_replace('_',' ',ucfirst($pedidoAtivo->status)) }}</span>
            </div>
            <div style="font-size:13px; color:var(--muted); margin-bottom:14px">
                Aberto {{ $pedidoAtivo->created_at->diffForHumans() }}
            </div>
            <a href="{{ route('orders.show',$pedidoAtivo) }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-eye"></i> Ver Pedido
            </a>
        </div>
        @else
        <div class="empty-state" style="padding:32px">
            <span class="es-icon">✅</span>
            <p>Nenhum pedido ativo nesta mesa</p>
        </div>
        @endif
    </div>
</div>
@endsection
