@extends('layouts.app')
@section('page-title', 'Equipe')
@section('breadcrumb', 'Gerenciar usuários do sistema')

@section('styles')
<style>
.role-badge { padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.role-gerente  { background:rgba(168,85,247,.15); color:#c084fc; }
.role-garcom   { background:rgba(59,130,246,.15);  color:#60a5fa; }
.role-chef     { background:rgba(249,115,22,.15);  color:#fb923c; }
.role-caixa    { background:rgba(34,197,94,.15);   color:#4ade80; }
.user-avatar {
    width:38px; height:38px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-weight:800; font-size:15px; color:#fff;
}
</style>
@endsection

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px">
    <div>
        <h2 style="font-size:20px; font-weight:800; color:#fff; margin:0">Equipe</h2>
        <div style="color:var(--muted); font-size:13px; margin-top:2px">{{ $usuarios->count() }} usuário(s) cadastrado(s)</div>
    </div>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Usuário
    </a>
</div>

{{-- Cards por cargo --}}
@php
    $grupos = ['gerente'=>'Gerentes','garcom'=>'Garçons','chef'=>'Chefs','caixa'=>'Caixas'];
    $cores  = ['gerente'=>'#a855f7','garcom'=>'#3b82f6','chef'=>'#f97316','caixa'=>'#22c55e'];
    $icones = ['gerente'=>'fa-crown','garcom'=>'fa-concierge-bell','chef'=>'fa-hat-chef','caixa'=>'fa-cash-register'];
@endphp

@foreach($grupos as $role => $label)
@php $grupo = $usuarios->where('role', $role); @endphp
@if($grupo->isNotEmpty())
<div class="panel" style="margin-bottom:20px">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas {{ $icones[$role] }}" style="color:{{ $cores[$role] }}"></i>
            {{ $label }} <span style="color:var(--muted); font-weight:400">({{ $grupo->count() }})</span>
        </div>
    </div>
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:12px">
        @foreach($grupo as $u)
        <div style="background:var(--bg); border:1px solid var(--border); border-radius:12px; padding:16px; display:flex; align-items:center; gap:14px">
            <div class="user-avatar" style="background:{{ $cores[$role] }}20; color:{{ $cores[$role] }}">
                {{ strtoupper(substr($u->name,0,1)) }}
            </div>
            <div style="flex:1; min-width:0">
                <div style="font-weight:700; color:#fff; font-size:14px">{{ $u->name }}</div>
                <div style="font-size:12px; color:var(--muted); overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $u->email }}</div>
                <div style="margin-top:4px">
                    <span class="role-badge role-{{ $u->role }}">{{ $label }}</span>
                    @if(!$u->ativo)
                    <span class="badge badge-danger" style="margin-left:4px">Inativo</span>
                    @endif
                </div>
            </div>
            <div style="display:flex; gap:6px; flex-shrink:0">
                <a href="{{ route('usuarios.edit', $u) }}" class="btn btn-secondary btn-sm btn-icon" title="Editar">
                    <i class="fas fa-pencil"></i>
                </a>
                @if($u->id !== Auth::id())
                <form method="POST" action="{{ route('usuarios.toggle', $u) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-icon {{ $u->ativo ? 'btn-warning' : 'btn-success' }}"
                            title="{{ $u->ativo ? 'Desativar' : 'Ativar' }}"
                            onclick="return confirm('{{ $u->ativo ? 'Desativar' : 'Ativar' }} este usuário?')">
                        <i class="fas {{ $u->ativo ? 'fa-ban' : 'fa-check' }}"></i>
                    </button>
                </form>
                <form method="POST" action="{{ route('usuarios.destroy', $u) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Excluir"
                            onclick="return confirm('Excluir {{ $u->name }}? Esta ação não pode ser desfeita.')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                @else
                <span style="font-size:11px; color:var(--muted); padding:6px 10px; border:1px solid var(--border); border-radius:7px; white-space:nowrap">
                    <i class="fas fa-lock" style="font-size:10px"></i> Sua conta
                </span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endforeach
@endsection
