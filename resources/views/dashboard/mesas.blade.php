@extends('layouts.app')
@section('page-title', 'Mesas — Visão Geral')
@section('breadcrumb', 'Status atual do salão')
@section('content')
<div class="mesas-grid">
    @forelse($mesas as $mesa)
    <div class="mesa-card {{ $mesa->status }}" style="cursor:default">
        <div class="mc-number">{{ $mesa->numero }}</div>
        <div class="mc-seats">{{ $mesa->assentos }} lugares</div>
        @if($mesa->garcom)<div style="font-size:11px;color:var(--muted);margin-bottom:6px">{{ $mesa->garcom->name }}</div>@endif
        <span class="badge badge-{{ $mesa->status==='disponivel'?'success':($mesa->status==='ocupada'?'danger':'warning') }}">{{ ucfirst($mesa->status) }}</span>
    </div>
    @empty
    <div class="empty-state" style="grid-column:1/-1">🪑<p>Nenhuma mesa cadastrada</p></div>
    @endforelse
</div>
@endsection
