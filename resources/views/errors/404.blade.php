@extends('layouts.app')

@section('content')
<div style="text-align:center; padding: 4rem 2rem;">
    <h1 style="font-size: 4rem;">🔍 404</h1>
    <h2>Página não encontrada</h2>
    <p>A página que você está procurando não existe ou foi removida.</p>
    <a href="{{ url('/dashboard') }}"
       style="display:inline-block; margin-top:1rem; padding:.75rem 2rem;
              background:#c0a060; color:#fff; border-radius:8px; text-decoration:none;">
        ← Voltar ao Dashboard
    </a>
</div>
@endsection