@extends('layouts.app')
@section('page-title', 'Gerenciar Produtos')
@section('breadcrumb', 'Cadastro de insumos e estoque')
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
        <div class="panel-header"><div class="panel-title"><i class="fas fa-plus"></i> Novo Produto</div></div>
        <form method="POST" action="{{ route('gerenciar.produtos.store') }}">
            @csrf
            <div class="form-group"><label>Nome</label><input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required></div>
            <div class="form-row">
                <div class="form-group">
                    <label>Unidade</label>
                    <select name="unidade" class="form-select" required>
                        <option value="kg" {{ old('unidade')=='kg'?'selected':'' }}>kg (peso)</option>
                        <option value="un" {{ old('unidade','un')=='un'?'selected':'' }}>un (unidade)</option>
                        <option value="l"  {{ old('unidade')=='l'?'selected':'' }}>L (litro)</option>
                        <option value="g"  {{ old('unidade')=='g'?'selected':'' }}>g (gramas)</option>
                        <option value="ml" {{ old('unidade')=='ml'?'selected':'' }}>mL</option>
                        <option value="cx" {{ old('unidade')=='cx'?'selected':'' }}>cx (caixa)</option>
                    </select>
                </div>
                <div class="form-group"><label>Preço Unit. (R$)</label><input type="number" name="preco_unitario" step="0.01" min="0" class="form-control" value="{{ old('preco_unitario') }}" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Qtd. Atual</label><input type="number" name="quantidade_atual" step="0.001" min="0" class="form-control" value="{{ old('quantidade_atual',0) }}" required></div>
                <div class="form-group"><label>Qtd. Mínima</label><input type="number" name="quantidade_minima" step="0.001" min="0" class="form-control" value="{{ old('quantidade_minima',0) }}" required></div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                <i class="fas fa-save"></i> Cadastrar Produto
            </button>
        </form>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2><i class="fas fa-boxes"></i> Produtos Cadastrados ({{ $itens->count() }})</h2>
            <input type="text" id="search-prod" placeholder="Buscar..." class="form-control" style="width:200px;padding:7px 12px;font-size:13px">
        </div>
        @if($itens->isEmpty())
            <div class="empty-state"><i class="fas fa-boxes"></i><p>Nenhum produto cadastrado</p></div>
        @else
        <table>
            <thead><tr><th>Produto</th><th>Unidade</th><th>Estoque Atual</th><th>Mínimo</th><th>Preço Unit.</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody id="tbody-prod">
            @foreach($itens as $item)
            @php $alerta = $item->quantidade_atual <= $item->quantidade_minima; @endphp
            <tr data-nome="{{ strtolower($item->nome) }}">
                <td class="td-primary">{{ $item->nome }}</td>
                <td><span style="background:rgba(99,102,241,.15);color:#818cf8;padding:2px 8px;border-radius:6px;font-size:11px;font-weight:700">{{ $item->unidade }}</span></td>
                <td class="td-mono" style="color:{{ $alerta?'#f87171':'#4ade80' }};font-weight:700">{{ number_format($item->quantidade_atual,3,',','.') }}</td>
                <td class="td-mono" style="color:var(--muted)">{{ number_format($item->quantidade_minima,3,',','.') }}</td>
                <td class="td-mono">R$ {{ number_format($item->preco_unitario,2,',','.') }}</td>
                <td>
                    @if($item->quantidade_atual <= 0) <span class="badge badge-danger">Esgotado</span>
                    @elseif($alerta) <span class="badge badge-warning">Baixo</span>
                    @else <span class="badge badge-success">OK</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button class="btn-edit"
                            onclick="editProd({{ $item->id }},'{{ addslashes($item->nome) }}','{{ $item->unidade }}',{{ $item->quantidade_minima }},{{ $item->preco_unitario }})">
                            ✏️ Editar
                        </button>
                        <form method="POST" action="{{ route('gerenciar.produtos.destroy',$item) }}" onsubmit="return confirm('Remover {{ $item->nome }}?')">
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

<div id="modal-prod" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:999;align-items:center;justify-content:center">
    <div class="panel" style="width:380px;margin:0">
        <div class="panel-header"><div class="panel-title">Editar Produto</div><button onclick="document.getElementById('modal-prod').style.display='none'" class="btn btn-secondary btn-sm btn-icon">×</button></div>
        <form method="POST" id="form-edit-prod">@csrf @method('PUT')
            <div class="form-group"><label>Nome</label><input type="text" name="nome" id="ep-nome" class="form-control" required></div>
            <div class="form-row">
                <div class="form-group">
                    <label>Unidade</label>
                    <select name="unidade" id="ep-unidade" class="form-select">
                        <option value="kg">kg</option><option value="un">un</option>
                        <option value="l">L</option><option value="g">g</option>
                        <option value="ml">mL</option><option value="cx">cx</option>
                    </select>
                </div>
                <div class="form-group"><label>Preço Unit.</label><input type="number" name="preco_unitario" id="ep-preco" step="0.01" min="0" class="form-control" required></div>
            </div>
            <div class="form-group"><label>Qtd. Mínima</label><input type="number" name="quantidade_minima" id="ep-min" step="0.001" min="0" class="form-control" required></div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Salvar</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
function editProd(id,nome,unidade,min,preco) {
    document.getElementById('ep-nome').value = nome;
    document.getElementById('ep-unidade').value = unidade;
    document.getElementById('ep-min').value = min;
    document.getElementById('ep-preco').value = preco;
    document.getElementById('form-edit-prod').action = '/gerenciar/produtos/' + id;
    document.getElementById('modal-prod').style.display = 'flex';
}
document.getElementById('search-prod').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tbody-prod tr').forEach(r => r.style.display = r.dataset.nome.includes(q)?'':'none');
});
</script>
@endsection
