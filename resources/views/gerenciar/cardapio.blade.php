@extends('layouts.app')
@section('page-title', 'Gerenciar Cardápio')
@section('breadcrumb', 'Itens do menu')
@section('styles')
<style>
.ger-tabs{display:flex;gap:8px;margin-bottom:24px;flex-wrap:wrap}
.ger-tab{padding:8px 18px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:700;color:var(--muted);background:var(--bg2);border:1px solid var(--border);transition:.15s}
.ger-tab.active,.ger-tab:hover{background:rgba(249,115,22,.12);color:var(--accent);border-color:rgba(249,115,22,.3)}
.btn-edit{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;border:1px solid rgba(59,130,246,.3);background:rgba(59,130,246,.1);color:#60a5fa;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .15s;white-space:nowrap;text-decoration:none}
.btn-edit:hover{background:rgba(59,130,246,.2);border-color:rgba(59,130,246,.5)}
.btn-del{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;border:1px solid rgba(239,68,68,.3);background:rgba(239,68,68,.1);color:#f87171;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .15s;white-space:nowrap}
.btn-del:hover{background:rgba(239,68,68,.2);border-color:rgba(239,68,68,.5)}
.btn-toggle{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;border:1px solid rgba(234,179,8,.3);background:rgba(234,179,8,.1);color:#facc15;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .15s;white-space:nowrap}
.btn-toggle:hover{background:rgba(234,179,8,.2)}
.btn-toggle.ativo{border-color:rgba(239,68,68,.3);background:rgba(239,68,68,.1);color:#f87171}
.btn-toggle.ativo:hover{background:rgba(239,68,68,.2)}
@media(max-width:768px){[style*="grid-template-columns:360px"]{display:block!important}[style*="grid-template-columns:340px"]{display:block!important}.panel[style*="sticky"]{position:static!important}}
</style>
@endsection
@section('content')

<div style="display:grid;grid-template-columns:360px 1fr;gap:20px;align-items:start">
    <div class="panel" style="position:sticky;top:80px">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-plus"></i> Novo Item</div></div>
        <form method="POST" action="{{ route('gerenciar.cardapio.store') }}">
            @csrf
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control {{ $errors->has('nome')?'is-invalid':'' }}" value="{{ old('nome') }}" required>
                @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">— Selecione —</option>
                        @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Preço (R$)</label>
                    <input type="number" name="preco" step="0.01" min="0.01" class="form-control" value="{{ old('preco') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="descricao" class="form-control" value="{{ old('descricao') }}" placeholder="Descrição breve...">
            </div>
            <div class="form-group">
                <label>Ingrediente Principal (estoque)</label>
                <select name="stock_item_id" class="form-select">
                    <option value="">— Nenhum —</option>
                    @foreach($estoque as $s)
                    <option value="{{ $s->id }}" {{ old('stock_item_id')==$s->id?'selected':'' }}>{{ $s->nome }} ({{ $s->unidade }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                    <input type="checkbox" name="disponivel" value="1" checked style="width:16px;height:16px"> Disponível no cardápio
                </label>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                <i class="fas fa-save"></i> Adicionar Item
            </button>
        </form>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2><i class="fas fa-utensils"></i> Itens do Cardápio ({{ $itens->count() }})</h2>
            <input type="text" id="search-cardapio" placeholder="Buscar..." class="form-control" style="width:200px;padding:7px 12px;font-size:13px">
        </div>
        @if($itens->isEmpty())
            <div class="empty-state"><i class="fas fa-utensils"></i><p>Nenhum item cadastrado</p></div>
        @else
        <table>
            <thead><tr><th>Item</th><th>Categoria</th><th>Preço</th><th>Ingrediente</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody id="tbody-cardapio">
            @foreach($itens as $item)
            <tr data-nome="{{ strtolower($item->nome) }}">
                <td class="td-primary">{{ $item->nome }}<div style="font-size:11px;color:var(--muted)">{{ Str::limit($item->descricao,40) }}</div></td>
                <td style="color:var(--muted)">{{ $item->category->nome ?? '—' }}</td>
                <td class="td-mono" style="color:var(--accent);font-weight:700">R$ {{ number_format($item->preco,2,',','.') }}</td>
                <td style="font-size:12px;color:var(--muted)">{{ $item->stockItem->nome ?? '—' }}</td>
                <td><span class="badge badge-{{ $item->disponivel?'success':'danger' }}">{{ $item->disponivel?'Disponível':'Indisponível' }}</span></td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button class="btn-edit" title="Editar"
                            onclick="editItem({{ $item->id }},'{{ addslashes($item->nome) }}',{{ $item->category_id }},{{ $item->preco }},'{{ addslashes($item->descricao??'') }}',{{ $item->stock_item_id??'null' }},{{ $item->disponivel?1:0 }})">
                            <i class="fas fa-pencil"></i>
                        </button>
                        <form method="POST" action="{{ route('gerenciar.cardapio.destroy',$item) }}" onsubmit="return confirm('Remover {{ $item->nome }}?')">
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

<div id="modal-item" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:999;align-items:center;justify-content:center">
    <div class="panel" style="width:420px;margin:0;max-height:90vh;overflow-y:auto">
        <div class="panel-header">
            <div class="panel-title">Editar Item</div>
            <button onclick="document.getElementById('modal-item').style.display='none'" class="btn btn-secondary btn-sm btn-icon">×</button>
        </div>
        <form method="POST" id="form-edit-item">
            @csrf @method('PUT')
            <div class="form-group"><label>Nome</label><input type="text" name="nome" id="ei-nome" class="form-control" required></div>
            <div class="form-row">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id" id="ei-cat" class="form-select" required>
                        @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group"><label>Preço</label><input type="number" name="preco" id="ei-preco" step="0.01" min="0.01" class="form-control" required></div>
            </div>
            <div class="form-group"><label>Descrição</label><input type="text" name="descricao" id="ei-desc" class="form-control"></div>
            <div class="form-group">
                <label>Ingrediente Principal</label>
                <select name="stock_item_id" id="ei-stock" class="form-select">
                    <option value="">— Nenhum —</option>
                    @foreach($estoque as $s)
                    <option value="{{ $s->id }}">{{ $s->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><label style="display:flex;align-items:center;gap:8px;cursor:pointer"><input type="checkbox" name="disponivel" id="ei-disp" value="1" style="width:16px;height:16px"> Disponível</label></div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Salvar</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
function editItem(id,nome,catId,preco,desc,stockId,disp) {
    document.getElementById('ei-nome').value = nome;
    document.getElementById('ei-cat').value = catId;
    document.getElementById('ei-preco').value = preco;
    document.getElementById('ei-desc').value = desc;
    document.getElementById('ei-stock').value = stockId || '';
    document.getElementById('ei-disp').checked = disp == 1;
    document.getElementById('form-edit-item').action = '/gerenciar/cardapio/' + id;
    document.getElementById('modal-item').style.display = 'flex';
}
document.getElementById('search-cardapio').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tbody-cardapio tr').forEach(r => {
        r.style.display = r.dataset.nome.includes(q) ? '' : 'none';
    });
});
</script>
@endsection
