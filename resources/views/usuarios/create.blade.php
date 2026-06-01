@extends('layouts.app')
@section('page-title', 'Novo Usuário')
@section('breadcrumb', 'Cadastrar funcionário')
@section('content')
<div style="max-width:520px; margin:0 auto">
<div class="panel">
    <div class="panel-header">
<<<<<<< HEAD
        <div class="panel-title"><i class="fa-solid fa-user-plus"></i> Cadastrar Usuário</div>
    </div>
    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        {{-- [FIX #15] Todos os labels com for/id associados --}}
        <div class="form-group">
            <label for="name">Nome completo</label>
            <input type="text" id="name" name="name"
                   class="form-control {{ $errors->has('name')?'is-invalid':'' }}"
                   value="{{ old('name') }}" placeholder="Nome do funcionário" required
                   autocomplete="name"
                   oninput="this.value=this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g,'')">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email"
                   class="form-control {{ $errors->has('email')?'is-invalid':'' }}"
                   value="{{ old('email') }}" placeholder="email@restaurante.com" required
                   autocomplete="email">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="role">Cargo</label>
            <select id="role" name="role"
                    class="form-select {{ $errors->has('role')?'is-invalid':'' }}" required>
=======
        <div class="panel-title"><i class="fas fa-user-plus"></i> Cadastrar Usuário</div>
    </div>
    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf
        <div class="form-group">
            <label>Nome completo</label>
            <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}"
                   value="{{ old('name') }}" placeholder="Nome do funcionário" required
                   oninput="this.value=this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g,'')">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" class="form-control {{ $errors->has('email')?'is-invalid':'' }}"
                   value="{{ old('email') }}" placeholder="email@restaurante.com" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Cargo</label>
            <select name="role" class="form-select {{ $errors->has('role')?'is-invalid':'' }}" required>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
                <option value="">— Selecione —</option>
                <option value="garcom"  {{ old('role')=='garcom' ?'selected':'' }}>🍽️ Garçom</option>
                <option value="chef"    {{ old('role')=='chef'   ?'selected':'' }}>👨‍🍳 Chef</option>
                <option value="caixa"   {{ old('role')=='caixa'  ?'selected':'' }}>💰 Caixa</option>
                <option value="gerente" {{ old('role')=='gerente'?'selected':'' }}>👑 Gerente</option>
            </select>
            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
<<<<<<< HEAD

        <div class="form-row">
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password"
                       class="form-control {{ $errors->has('password')?'is-invalid':'' }}"
                       placeholder="Mínimo 6 caracteres" required
                       autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmar Senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="form-control" placeholder="Repita a senha" required
                       autocomplete="new-password">
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:8px">
            {{-- [FIX #12] Loading automático via JS global do layout --}}
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center">
                <i class="fa-solid fa-floppy-disk"></i> Cadastrar
=======
        <div class="form-row">
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}"
                       placeholder="Mínimo 6 caracteres" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Confirmar Senha</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required>
            </div>
        </div>
        <div style="display:flex; gap:10px; margin-top:8px">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center">
                <i class="fas fa-save"></i> Cadastrar
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            </button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</div>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
