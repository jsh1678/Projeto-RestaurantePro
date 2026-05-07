@extends('layouts.app')
@section('page-title', 'Novo Pedido')
@section('breadcrumb', 'Criar pedido para mesa')

@section('styles')
<style>
.order-layout {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    width: 100%;
}
.cardapio-col {
    flex: 1;
    min-width: 0;
}
.resumo-col {
    width: 300px;
    min-width: 300px;
    position: sticky;
    top: 80px;
}
.item-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
    margin-bottom: 20px;
}
.menu-card {
    background: var(--bg2);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 14px;
    cursor: pointer;
    transition: all .18s;
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.menu-card:hover  { border-color: rgba(249,115,22,.5); background: rgba(249,115,22,.05); }
.menu-card.active { border-color: var(--accent); background: rgba(249,115,22,.1); }
.menu-card-nome  { font-weight: 700; color: #fff; font-size: 13px; }
.menu-card-desc  { font-size: 11px; color: var(--muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.menu-card-preco { font-weight: 800; color: var(--accent); font-size: 14px; }
.menu-card-ctrl  { display: flex; align-items: center; gap: 8px; margin-top: 6px; }
.qty-btn {
    width: 28px; height: 28px; border-radius: 7px; border: none;
    font-size: 18px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: .15s;
}
.qty-btn.minus { background: rgba(255,255,255,.08); color: var(--muted); }
.qty-btn.minus:hover { background: rgba(239,68,68,.25); color: #f87171; }
.qty-btn.plus  { background: var(--accent); color: #fff; }
.qty-btn.plus:hover { background: #ea6a0a; }
.qty-num { font-weight: 800; color: #fff; font-size: 15px; min-width: 22px; text-align: center; }
.cat-sep {
    display: flex; align-items: center; gap: 12px; margin: 16px 0 12px;
}
.cat-sep-line { flex: 1; height: 1px; background: var(--border); }
.cat-sep-label { font-size: 11px; font-weight: 800; color: var(--accent); text-transform: uppercase; letter-spacing: 1.5px; white-space: nowrap; }
.resumo-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 7px 0; border-bottom: 1px solid var(--border); font-size: 13px; gap: 8px;
}
.resumo-row:last-child { border-bottom: none; }
.btn-enviar {
    width: 100%; padding: 13px; font-size: 15px; font-weight: 700;
    background: var(--accent); color: #fff; border: none; border-radius: 10px;
    cursor: pointer; transition: .18s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-enviar:hover:not(:disabled) { background: #ea6a0a; }
.btn-enviar:disabled { opacity: .45; cursor: not-allowed; }
</style>
@endsection

@section('content')
<form method="POST" action="{{ route('orders.store') }}" id="order-form">
@csrf

<div class="order-layout">

    {{-- CARDÁPIO --}}
    <div class="cardapio-col">

        <div class="panel" style="padding:12px 16px; margin-bottom:16px">
            <input type="text" id="search-input" class="form-control"
                   placeholder="🔍  Buscar no cardápio...">
        </div>

        @forelse($categorias as $categoria)
        <div class="categoria-block" data-cat="{{ strtolower($categoria->nome) }}">
            <div class="cat-sep">
                <div class="cat-sep-line"></div>
                <span class="cat-sep-label">{{ $categoria->nome }}</span>
                <div class="cat-sep-line"></div>
            </div>
            <div class="item-grid">
                @foreach($categoria->menuItems as $item)
                <div class="menu-card"
                     id="card-{{ $item->id }}"
                     data-id="{{ $item->id }}"
                     data-nome="{{ strtolower($item->nome) }}"
                     onclick="addItem({{ $item->id }})">
                    <div class="menu-card-nome">{{ $item->nome }}</div>
                    @if($item->descricao)
                    <div class="menu-card-desc">{{ $item->descricao }}</div>
                    @endif
                    <div class="menu-card-preco">R$ {{ number_format($item->preco,2,',','.') }}</div>
                    <div class="menu-card-ctrl" onclick="event.stopPropagation()">
                        <button type="button" class="qty-btn minus" onclick="changeQty({{ $item->id }}, -1)">−</button>
                        <span class="qty-num" id="qty-{{ $item->id }}">0</span>
                        <button type="button" class="qty-btn plus"  onclick="changeQty({{ $item->id }}, 1)">+</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="empty-state" style="margin-top:60px">
            <i class="fas fa-utensils"></i>
            <p>Nenhum item disponível no cardápio</p>
        </div>
        @endforelse
    </div>

    {{-- RESUMO --}}
    <div class="resumo-col">
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-clipboard-list"></i> Resumo</div>
                <button type="button" class="btn btn-secondary btn-sm btn-icon" onclick="clearAll()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="form-group">
                <label>Mesa</label>
                <select name="table_id" class="form-select {{ $errors->has('table_id') ? 'is-invalid' : '' }}" required>
                    <option value="">— Selecione —</option>
                    @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}" {{ old('table_id', $tableId) == $mesa->id ? 'selected' : '' }}>
                        Mesa {{ $mesa->numero }} · {{ $mesa->assentos }} lugares
                    </option>
                    @endforeach
                </select>
                @error('table_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Observações</label>
                <textarea name="observacoes" class="form-control" rows="2"
                          placeholder="Alergias, preferências...">{{ old('observacoes') }}</textarea>
            </div>

            <div id="resumo-items" style="margin-bottom:14px; max-height:240px; overflow-y:auto">
                <div style="text-align:center; color:var(--muted); font-size:13px; padding:18px 0">
                    <i class="fas fa-cart-plus" style="font-size:24px; opacity:.25; display:block; margin-bottom:8px"></i>
                    Nenhum item selecionado
                </div>
            </div>

            <div id="hidden-inputs"></div>

            <div style="border-top:1px solid var(--border); padding-top:12px; margin-bottom:14px">
                <div style="display:flex; justify-content:space-between; font-size:18px; font-weight:800; color:#fff">
                    <span>Total</span>
                    <span id="total-display" style="color:var(--accent)">R$ 0,00</span>
                </div>
            </div>

            @if($errors->has('itens'))
            <div class="alert alert-error" style="margin-bottom:12px; padding:10px 14px; font-size:13px">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first('itens') }}
            </div>
            @endif

            <button type="submit" id="btn-submit" class="btn-enviar" disabled>
                <i class="fas fa-paper-plane"></i> Enviar Pedido
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary"
               style="width:100%; margin-top:8px; justify-content:center">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </div>

</div>
</form>
@endsection

@section('scripts')
<script>
const precos = {
    @foreach($categorias as $cat)
    @foreach($cat->menuItems as $item)
    {{ $item->id }}: { nome: @json($item->nome), preco: {{ $item->preco }} },
    @endforeach
    @endforeach
};

const qtds = {};

function addItem(id) { changeQty(id, 1); }

function changeQty(id, delta) {
    qtds[id] = Math.max(0, (qtds[id] || 0) + delta);
    document.getElementById('qty-' + id).textContent = qtds[id];
    const card = document.getElementById('card-' + id);
    if (card) card.classList.toggle('active', qtds[id] > 0);
    updateResumo();
}

function clearAll() {
    for (const id in qtds) {
        qtds[id] = 0;
        const el = document.getElementById('qty-' + id);
        if (el) el.textContent = 0;
        const card = document.getElementById('card-' + id);
        if (card) card.classList.remove('active');
    }
    updateResumo();
}

function updateResumo() {
    let total = 0, hasItems = false, resumoHtml = '', hiddenHtml = '';

    for (const id in qtds) {
        if (qtds[id] > 0) {
            hasItems = true;
            const p = precos[id];
            const sub = p.preco * qtds[id];
            total += sub;
            resumoHtml += `<div class="resumo-row">
                <span style="color:var(--text);flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${qtds[id]}× ${p.nome}</span>
                <span style="font-weight:700;color:#fff;white-space:nowrap;margin-left:8px">R$ ${sub.toFixed(2).replace('.',',')}</span>
            </div>`;
            hiddenHtml += `<input type="hidden" name="itens[${id}][menu_item_id]" value="${id}">`;
            hiddenHtml += `<input type="hidden" name="itens[${id}][quantidade]" value="${qtds[id]}">`;
        }
    }

    document.getElementById('resumo-items').innerHTML = hasItems ? resumoHtml
        : '<div style="text-align:center;color:var(--muted);font-size:13px;padding:18px 0">'
        + '<i class="fas fa-cart-plus" style="font-size:24px;opacity:.25;display:block;margin-bottom:8px"></i>'
        + 'Nenhum item selecionado</div>';

    document.getElementById('hidden-inputs').innerHTML = hiddenHtml;
    document.getElementById('total-display').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    document.getElementById('btn-submit').disabled = !hasItems;
}

document.getElementById('search-input').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('.menu-card').forEach(c => {
        c.style.display = (!q || c.dataset.nome.includes(q)) ? '' : 'none';
    });
    document.querySelectorAll('.categoria-block').forEach(b => {
        const vis = [...b.querySelectorAll('.menu-card')].some(c => c.style.display !== 'none');
        b.style.display = vis ? '' : 'none';
    });
});
</script>
@endsection
