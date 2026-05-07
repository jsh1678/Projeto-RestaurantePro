@extends('layouts.app')
@section('page-title')
Mesa {{ $mesa->numero }}
@endsection
@section('breadcrumb', 'Detalhes e controle da mesa')
@section('content')
<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">🪑 Mesa {{ $mesa->numero }}</div>
            <span class="badge badge-{{ $mesa->status==='disponivel'?'success':($mesa->status==='ocupada'?'danger':'warning') }}" style="font-size:13px; padding:6px 14px">{{ ucfirst($mesa->status) }}</span>
        </div>
        <div style="display:grid; gap:14px; margin-bottom:20px">
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border)">
                <span style="color:var(--muted)">Capacidade</span>
                <strong>{{ $mesa->assentos }} pessoas</strong>
            </div>
            @if($mesa->garcom)
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border)">
                <span style="color:var(--muted)">Garçom</span>
                <strong>{{ $mesa->garcom->name }}</strong>
            </div>
            @endif
        </div>
        @if(Auth::user()->role==='garcom')
        <form method="POST" action="{{ route('mesas.atualizar',$mesa) }}">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Alterar Status</label>
                <select name="status" class="form-select" required>
                    <option value="disponivel" {{ $mesa->status==='disponivel'?'selected':'' }}>✅ Disponível</option>
                    <option value="ocupada"    {{ $mesa->status==='ocupada'?'selected':'' }}>🔴 Ocupada</option>
                    <option value="reservada"  {{ $mesa->status==='reservada'?'selected':'' }}>🟡 Reservada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">💾 Atualizar</button>
        </form>
        @endif
        <hr class="divider">
        <div style="display:flex; gap:8px">
            <a href="{{ route('mesas.index') }}" class="btn btn-secondary btn-sm">← Voltar</a>
            @if(Auth::user()->role==='garcom')
            <a href="{{ route('orders.create',['table_id'=>$mesa->id]) }}" class="btn btn-primary btn-sm">➕ Novo Pedido</a>
            @endif
        </div>
    </div>
    <div class="panel">
        <div class="panel-header"><div class="panel-title">🧾 Pedido Ativo</div></div>
        @if($pedidoAtivo)
        <div style="background:rgba(249,115,22,.06); border:1px solid rgba(249,115,22,.2); border-radius:12px; padding:18px">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
                <span style="font-size:18px; font-weight:800; color:#fff">Pedido <span style="color:var(--accent); font-family:monospace">#{{ str_pad($pedidoAtivo->id,4,'0',STR_PAD_LEFT) }}</span></span>
                <span class="badge badge-warning">{{ str_replace('_',' ',ucfirst($pedidoAtivo->status)) }}</span>
            </div>
            <div style="font-size:13px; color:var(--muted); margin-bottom:14px">Aberto {{ $pedidoAtivo->created_at->diffForHumans() }}</div>
            <a href="{{ route('orders.show',$pedidoAtivo) }}" class="btn btn-primary btn-sm">👁 Ver Pedido</a>
        </div>
        @else
        <div class="empty-state" style="padding:32px">✅<p>Nenhum pedido ativo nesta mesa</p></div>
        @endif
    </div>
</div>
@endsection
