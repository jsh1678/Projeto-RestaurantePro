@extends('layouts.app')

@section('content')
<div style="text-align:center; padding: 4rem 2rem;">
    <h1 style="font-size: 4rem;">⚠️ 500</h1>
    <h2>Erro Interno</h2>
    <p>Algo inesperado aconteceu. Nossa equipe já foi notificada.</p>
    <a href="{{ url('/dashboard') }}"
       style="display:inline-block; margin-top:1rem; padding:.75rem 2rem;
              background:#c0a060; color:#fff; border-radius:8px; text-decoration:none;">
        Ir para o Dashboard
    </a>
</div>
@endsection