@extends('layouts.app')
@section('page-title', 'Compras')
@section('breadcrumb', 'Registro de entradas de estoque')
@section('content')
<div style="display:grid; grid-template-columns: 380px 1fr; gap:24px">

    <div class="panel" style="position:sticky; top:80px; align-self:start">
        <div class="panel-header"><div class="panel-title">➕ Nova Compra</div></div>

        <form method="POST" action="{{ route('compras.store') }}" id="form-compra">
            @csrf
            <div class="form-group">
                <label>Item de Estoque</label>
                <select name="stock_item_id" class="form-select {{ $errors->has('stock_item_id')?'is-invalid':'' }}" required>
                    <option value="">— Selecione —</option>
                    @foreach($itens as $item)
                    <option value="{{ $item->id }}" {{ old('stock_item_id')==$item->id?'selected':'' }}>
                        {{ $item->nome }} ({{ $item->unidade }})
                    </option>
                    @endforeach
                </select>
                @error('stock_item_id')<div class="invalid-feedback">⚠️ {{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Quantidade <span style="color:var(--muted);font-weight:400">(máx. 99.999)</span></label>
                    <input type="number" name="quantidade" id="input-quantidade"
                           step="0.01" min="0.01" max="99999"
                           class="form-control {{ $errors->has('quantidade')?'is-invalid':'' }}"
                           value="{{ old('quantidade') }}"
                           oninput="validarNumero(this, 99999, 'erro-quantidade')" required>
                    <div id="erro-quantidade" class="campo-erro" style="display:none">
                        ⚠️ Máximo: 99.999
                    </div>
                    @error('quantidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Preço Unit. (R$) <span style="color:var(--muted);font-weight:400">(máx. 999.999)</span></label>
                    <input type="number" name="preco_unitario" id="input-preco"
                           step="0.01" min="0.01" max="999999"
                           class="form-control {{ $errors->has('preco_unitario')?'is-invalid':'' }}"
                           value="{{ old('preco_unitario') }}"
                           oninput="validarNumero(this, 999999, 'erro-preco')" required>
                    <div id="erro-preco" class="campo-erro" style="display:none">
                        ⚠️ Máximo: R$ 999.999,00
                    </div>
                    @error('preco_unitario')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Preview total --}}
            <div id="preview-total" style="display:none; background:rgba(249,115,22,.08); border:1px solid rgba(249,115,22,.2); border-radius:10px; padding:12px 16px; margin-bottom:18px">
                <span style="color:var(--muted); font-size:13px">Total estimado:</span>
                <span id="valor-total" style="font-weight:800; color:var(--accent); font-family:monospace; font-size:16px; float:right"></span>
            </div>

            <div class="form-group">
                <label>Fornecedor <span style="color:var(--muted);font-weight:400">(apenas letras)</span></label>
                <input type="text" name="fornecedor" id="input-fornecedor"
                       class="form-control {{ $errors->has('fornecedor')?'is-invalid':'' }}"
                       value="{{ old('fornecedor') }}"
                       placeholder="Nome do fornecedor"
                       oninput="validarFornecedor(this)">
                <div id="erro-fornecedor" class="campo-erro" style="display:none">
                    ⚠️ Apenas letras são permitidas (sem números ou símbolos)
                </div>
                @error('fornecedor')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Data de Entrega</label>
                <input type="date" name="data_entrega" class="form-control" value="{{ old('data_entrega') }}">
            </div>
            <div class="form-group">
                <label>Observações</label>
                <textarea name="observacoes" class="form-control" rows="2" placeholder="Observações...">{{ old('observacoes') }}</textarea>
            </div>

            <button type="submit" id="btn-submit" class="btn btn-primary" style="width:100%; justify-content:center">
                💾 Registrar Compra
            </button>
        </form>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2>🕐 Histórico ({{ $compras->count() }})</h2>
        </div>
        @if($compras->isEmpty())
            <div class="empty-state">🛒<p>Nenhuma compra registrada</p></div>
        @else
        <table>
            <thead><tr><th>#</th><th>Item</th><th>Qtd</th><th>Preço Unit.</th><th>Total</th><th>Fornecedor</th><th>Data</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @foreach($compras as $c)
            <tr>
                <td class="td-mono td-primary">#{{ $c->id }}</td>
                <td>{{ $c->stockItem->nome ?? '—' }}</td>
                <td class="td-mono">{{ number_format($c->quantidade,2,',','.') }} {{ $c->stockItem->unidade??'' }}</td>
                <td class="td-mono">R$ {{ number_format($c->preco_unitario,2,',','.') }}</td>
                <td class="td-mono" style="color:#4ade80;font-weight:700">R$ {{ number_format($c->total,2,',','.') }}</td>
                <td style="color:var(--muted)">{{ $c->fornecedor ?? '—' }}</td>
                <td style="color:var(--muted);font-size:12px">{{ $c->created_at->format('d/m H:i') }}</td>
                <td><span class="badge badge-{{ $c->status==='recebido'?'success':($c->status==='cancelado'?'danger':'warning') }}">{{ ucfirst($c->status) }}</span></td>
                <td>
                    @if($c->status==='recebido')
                    <form method="POST" action="{{ route('compras.cancelar',$c) }}" onsubmit="return confirm('Cancelar esta compra? O estoque será revertido.')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm btn-icon">✕</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
.campo-erro { color:#f87171; font-size:12px; margin-top:5px; display:none; }
</style>
@endsection

@section('scripts')
<script>
let erros = { quantidade: false, preco: false, fornecedor: false };

function validarNumero(el, max, erroId) {
    const val = parseFloat(el.value);
    const erroEl = document.getElementById(erroId);
    const campo = erroId.replace('erro-', '');
    if (el.value !== '' && (isNaN(val) || val > max)) {
        el.style.borderColor = '#ef4444';
        erroEl.style.display = 'block';
        erros[campo] = true;
    } else {
        el.style.borderColor = '';
        erroEl.style.display = 'none';
        erros[campo] = false;
    }
    atualizarBotao();
    atualizarTotal();
}

function validarFornecedor(el) {
    const val = el.value;
    const erroEl = document.getElementById('erro-fornecedor');
    // Aceita letras (incluindo acentos), espaços, pontos e hífens
    const valido = /^[a-zA-ZÀ-ÿ\s\.\-]*$/.test(val);
    if (!valido) {
        el.style.borderColor = '#ef4444';
        erroEl.style.display = 'block';
        erros.fornecedor = true;
        // Remove o caractere inválido automaticamente
        el.value = val.replace(/[^a-zA-ZÀ-ÿ\s\.\-]/g, '');
        erros.fornecedor = false;
        el.style.borderColor = '';
        erroEl.style.display = 'none';
    } else {
        el.style.borderColor = '';
        erroEl.style.display = 'none';
        erros.fornecedor = false;
    }
    atualizarBotao();
}

function atualizarBotao() {
    const temErro = Object.values(erros).some(v => v);
    const btn = document.getElementById('btn-submit');
    btn.disabled = temErro;
    btn.style.opacity = temErro ? '0.5' : '1';
}

function atualizarTotal() {
    const qtd   = parseFloat(document.getElementById('input-quantidade').value) || 0;
    const preco = parseFloat(document.getElementById('input-preco').value) || 0;
    const preview = document.getElementById('preview-total');
    if (qtd > 0 && preco > 0 && qtd <= 99999 && preco <= 999999) {
        preview.style.display = 'block';
        document.getElementById('valor-total').textContent =
            'R$ ' + (qtd * preco).toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits:2});
    } else {
        preview.style.display = 'none';
    }
}

// Última barreira no submit
document.getElementById('form-compra').addEventListener('submit', function(e) {
    const qtd        = parseFloat(document.getElementById('input-quantidade').value);
    const preco      = parseFloat(document.getElementById('input-preco').value);
    const fornecedor = document.getElementById('input-fornecedor').value;
    const fornecedorOk = /^[a-zA-ZÀ-ÿ\s\.\-]*$/.test(fornecedor);
    if (qtd > 99999 || preco > 999999 || !fornecedorOk) {
        e.preventDefault();
        alert('❌ Corrija os campos com erro antes de salvar.');
    }
});
</script>
@endsection
