@extends('layouts.app')
@section('page-title')
Editar Mesa {{ $table->numero }}
@endsection
@section('breadcrumb', 'Alterar dados da mesa')
@section('content')
<div class="panel" style="max-width:480px">
    <div class="panel-header"><div class="panel-title">✏️ Editar Mesa {{ $table->numero }}</div></div>
    <form method="POST" action="{{ route('mesas.update',$table) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Número da Mesa</label>
            <input type="number" name="numero" class="form-control {{ $errors->has('numero')?'is-invalid':'' }}" value="{{ old('numero',$table->numero) }}" min="1" required>
            @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Quantidade de Assentos</label>
            <input type="number" name="assentos" class="form-control {{ $errors->has('assentos')?'is-invalid':'' }}" value="{{ old('assentos',$table->assentos) }}" min="1" max="20" required>
            @error('assentos')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div style="display:flex; gap:10px">
            <button type="submit" class="btn btn-primary">💾 Salvar</button>
            <a href="{{ route('mesas.index') }}" class="btn btn-secondary">✕ Cancelar</a>
        </div>
    </form>
</div>
@endsection
