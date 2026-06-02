@extends('layouts.app')
@section('page-title', 'Mesas - Visao Geral')
@section('breadcrumb', 'Status atual do salao')

@section('styles')
<style>
.simple-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 12px;
    margin-bottom: 18px;
}
.simple-summary-card {
    background: var(--bg2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px;
}
.simple-summary-card span {
    display: block;
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
}
.simple-summary-card strong {
    display: block;
    margin-top: 6px;
    color: #fff;
    font-size: 24px;
    line-height: 1;
}
.simple-title-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
}
.simple-title-row h2 {
    margin: 0;
    color: #fff;
    font-size: 18px;
}
@media (max-width: 640px) {
    .simple-title-row {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>
@endsection

@section('content')
@php
    $livres = $mesas->where('status', 'disponivel')->count();
    $ocupadas = $mesas->where('status', 'ocupada')->count();
    $reservadas = $mesas->where('status', 'reservada')->count();
@endphp

<div class="simple-summary">
    <div class="simple-summary-card">
        <span>Total de mesas</span>
        <strong>{{ $mesas->count() }}</strong>
    </div>
    <div class="simple-summary-card">
        <span>Disponiveis</span>
        <strong style="color:#4ade80">{{ $livres }}</strong>
    </div>
    <div class="simple-summary-card">
        <span>Ocupadas</span>
        <strong style="color:#f87171">{{ $ocupadas }}</strong>
    </div>
    <div class="simple-summary-card">
        <span>Reservadas</span>
        <strong style="color:#fbbf24">{{ $reservadas }}</strong>
    </div>
</div>

<div class="simple-title-row">
    <h2><i class="fa-solid fa-chair"></i> Mesas do salao</h2>
    <a href="{{ route('mesas.index') }}" class="btn btn-secondary btn-sm">Gerenciar mesas</a>
</div>

<div class="mesas-grid">
    @forelse($mesas as $mesa)
    <div class="mesa-card {{ $mesa->status }}" style="cursor:default">
        <div class="mc-number">{{ $mesa->numero }}</div>
        <div class="mc-seats">{{ $mesa->assentos }} lugares</div>
        @if($mesa->garcom)
            <div style="font-size:11px;color:var(--muted);margin-bottom:6px">{{ $mesa->garcom->name }}</div>
        @endif
        <span class="badge badge-{{ $mesa->status === 'disponivel' ? 'success' : ($mesa->status === 'ocupada' ? 'danger' : 'warning') }}">
            {{ ucfirst($mesa->status) }}
        </span>
    </div>
    @empty
    <div class="empty-state" style="grid-column:1/-1">
        <i class="fa-solid fa-chair"></i>
        <p>Nenhuma mesa cadastrada</p>
    </div>
    @endforelse
</div>
@endsection
