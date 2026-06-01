@extends('layouts.app')
@section('page-title', 'Gerenciar Mesas')
@section('breadcrumb', 'Cadastro e configuração de mesas')
@section('styles')
<style>
.ger-tabs{display:flex;gap:8px;margin-bottom:24px;flex-wrap:wrap}
.ger-tab{padding:8px 18px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:700;color:var(--muted);background:var(--bg2);border:1px solid var(--border);transition:.15s}
.ger-tab.active,.ger-tab:hover{background:rgba(249,115,22,.12);color:var(--accent);border-color:rgba(249,115,22,.3)}
.btn-edit{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;border:1px solid rgba(59,130,246,.3);background:rgba(59,130,246,.1);color:#60a5fa;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .15s;white-space:nowrap;text-decoration:none}
.btn-edit:hover{background:rgba(59,130,246,.2);border-color:rgba(59,130,246,.5)}
.btn-del{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;border:1px solid rgba(239,68,68,.3);background:rgba(239,68,68,.1);color:#f87171;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .15s;white-space:nowrap}
.btn-del:hover{background:rgba(239,68,68,.2);border-color:rgba(239,68,68,.5)}
@media(max-width:768px){[style*="grid-template-columns:360px"]{display:block!important}[style*="grid-template-columns:340px"]{display:block!important}.panel[style*="sticky"]{position:static!important}}
</style>
@endsection
@section('content')

<div style="display:grid; grid-template-columns:340px 1fr; gap:20px; align-items:start">
    <div class="panel" style="position:sticky; top:80px">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-plus"></i> Nova Mesa</div></div>
        <form method="POST" action="{{ route('mesas.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Número</label>
                    <input type="number" name="numero" class="form-control {{ $errors->has('numero')?'is-invalid':'' }}" min="1" value="{{ old('numero') }}" required>
                    @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Assentos</label>
                    <input type="number" name="assentos" class="form-control" min="1" max="20" value="{{ old('assentos',4) }}" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                <i class="fas fa-save"></i> Criar Mesa
            </button>
        </form>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2><i class="fas fa-chair"></i> Mesas Cadastradas ({{ $mesas->count() }})</h2>
        </div>
        @if($mesas->isEmpty())
            <div class="empty-state"><i class="fas fa-chair"></i><p>Nenhuma mesa cadastrada</p></div>
        @else
        <table>
            <thead><tr><th>Número</th><th>Assentos</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody>
            @foreach($mesas as $mesa)
            <tr>
                <td class="td-primary td-mono">Mesa {{ $mesa->numero }}</td>
                <td>{{ $mesa->assentos }} lugares</td>
                <td><span class="badge badge-{{ $mesa->status==='disponivel'?'success':($mesa->status==='ocupada'?'danger':'warning') }}">{{ ucfirst($mesa->status) }}</span></td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button class="btn btn-secondary btn-sm btn-icon" onclick="editMesa({{ $mesa->id }},{{ $mesa->numero }},{{ $mesa->assentos }})" title="Editar"><i class="fas fa-pencil"></i></button>
                        <form method="POST" action="{{ route('mesas.destroy',$mesa) }}" onsubmit="return confirm('Deletar Mesa {{ $mesa->numero }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-del">🗑️ Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- Modal editar --}}
<div id="modal-edit" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:999;display:none;align-items:center;justify-content:center">
    <div class="panel" style="width:360px;margin:0">
        <div class="panel-header"><div class="panel-title">Editar Mesa</div><button onclick="document.getElementById('modal-edit').style.display='none'" class="btn btn-secondary btn-sm btn-icon">×</button></div>
        <form method="POST" id="form-edit-mesa">
            @csrf @method('PUT')
            <div class="form-row">
                <div class="form-group"><label>Número</label><input type="number" name="numero" id="edit-numero" class="form-control" required></div>
                <div class="form-group"><label>Assentos</label><input type="number" name="assentos" id="edit-assentos" class="form-control" required></div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Salvar</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
function editMesa(id, num, ass) {
    document.getElementById('edit-numero').value = num;
    document.getElementById('edit-assentos').value = ass;
    document.getElementById('form-edit-mesa').action = '/mesas/' + id;
    document.getElementById('modal-edit').style.display = 'flex';
}
</script>
@endsection
