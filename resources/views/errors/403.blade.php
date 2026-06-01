@extends('layouts.app')

@section('content')
<div style="text-align:center; padding: 4rem 2rem;">
    <h1 style="font-size: 4rem;">🔒 403</h1>
    <h2>Acesso Negado</h2>
    <p>Você não tem permissão para acessar esta página.</p>
    <a href="{{ url('/dashboard') }}"
       style="display:inline-block; margin-top:1rem; padding:.75rem 2rem;
              background:#c0a060; color:#fff; border-radius:8px; text-decoration:none;">
        ← Voltar ao Dashboard
    </a>
</div>
@endsection