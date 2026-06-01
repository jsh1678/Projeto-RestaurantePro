@extends('layouts.app')

@section('content')
<div style="text-align:center; padding: 4rem 2rem;">
    <h1 style="font-size: 4rem;">⏱️ 419</h1>
    <h2>Sessão Expirada</h2>
    <p>Sua sessão expirou por inatividade. Por favor, volte e tente novamente.</p>
    <a href="{{ url()->previous() }}" onclick="history.back(); return false;"
       style="display:inline-block; margin-top:1rem; padding:.75rem 2rem;
              background:#c0a060; color:#fff; border-radius:8px; text-decoration:none;">
        ← Voltar
    </a>
</div>
@endsection