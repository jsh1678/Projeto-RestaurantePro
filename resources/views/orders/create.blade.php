@extends('layouts.app')
@section('page-title', $pedido ? 'Editar Pedido #'.str_pad($pedido->id,4,'0',STR_PAD_LEFT) : 'Novo Pedido')
@section('breadcrumb', $pedido ? 'Editar pedido existente' : 'Criar pedido para mesa')

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
/* Filtros por tipo */
.filtro-bar {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}
.filtro-btn {
    padding: 6px 14px;
    border-radius: 20px;
    border: 1.5px solid var(--border);
    background: var(--bg2);
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all .15s;
    display: inline-flex; align-items: center; gap: 5px;
}
.filtro-btn:hover, .filtro-btn.ativo {
    border-color: var(--accent);
    background: rgba(249,115,22,.1);
    color: var(--accent);
}
/* Subtipo filtros */
.subtipo-bar {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 10px;
    padding: 8px 12px;
    background: rgba(255,255,255,.02);
    border-radius: 10px;
    border: 1px solid var(--border);
}
.subtipo-btn {
    padding: 4px 12px;
    border-radius: 16px;
    border: 1px solid rgba(99,102,241,.3);
    background: rgba(99,102,241,.08);
    color: #a5b4fc;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: all .15s;
}
.subtipo-btn:hover, .subtipo-btn.ativo {
    background: rgba(99,102,241,.2);
    border-color: rgba(99,102,241,.6);
    color: #c7d2fe;
}
.item-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 10px;
    margin-bottom: 20px;
}
.menu-card {
    background: var(--bg2);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 10px;
    cursor: pointer;
    transition: all .18s;
    display: flex;
    flex-direction: column;
    gap: 5px;
    overflow: hidden;
}
.menu-card:hover  { border-color: rgba(249,115,22,.5); background: rgba(249,115,22,.05); }
.menu-card.active { border-color: var(--accent); background: rgba(249,115,22,.1); }
.menu-card-img {
    width: 100%;
    aspect-ratio: 16 / 10;
    border-radius: 9px;
    object-fit: cover;
    background: rgba(255,255,255,.04);
    border: 1px solid var(--border);
    margin-bottom: 4px;
}
.menu-card-img-empty {
    width: 100%;
    aspect-ratio: 16 / 10;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    background: rgba(255,255,255,.04);
    border: 1px dashed var(--border);
    margin-bottom: 4px;
}
.menu-card-nome  { font-weight: 700; color: #fff; font-size: 13px; }
.menu-card-desc  { font-size: 11px; color: var(--muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.menu-card-preco { font-weight: 800; color: var(--accent); font-size: 14px; }
.menu-card-serves { font-size: 10px; color: #a5b4fc; display: flex; align-items: center; gap: 3px; }
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
/* Viagem checkbox */
.viagem-check {
    display: flex; align-items: center; gap: 10px;
    background: rgba(249,115,22,.06);
    border: 1px solid rgba(249,115,22,.2);
    border-radius: 10px; padding: 10px 14px; margin-bottom: 10px;
    cursor: pointer; transition: .15s;
}
.viagem-check:hover { background: rgba(249,115,22,.1); }
.viagem-check input { width: 16px; height: 16px; cursor: pointer; accent-color: var(--accent); }
.viagem-check label { font-size: 13px; font-weight: 700; color: var(--cream); cursor: pointer; }
/* Edit mode banner */
.edit-banner {
    background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.3);
    border-radius: 10px; padding: 10px 14px; margin-bottom: 16px;
    display: flex; align-items: center; gap: 8px; font-size: 13px; color: #93c5fd;
}

.quick-obs {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 8px;
}

.quick-obs button {
    min-height: 34px;
    border: 1px solid var(--border);
    border-radius: 999px;
    background: rgba(250,178,105,.06);
    color: var(--muted);
    padding: 5px 10px;
    font-weight: 800;
    cursor: pointer;
}

.mobile-cart-bar {
    display: none;
}

.mobile-order-actionbar,
.mobile-order-fab,
.express-products {
    display: none;
}

@media (max-width: 768px) {
    .order-layout {
        display: block;
    }

    .cardapio-col {
        padding-bottom: 238px;
    }

    .resumo-col {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 160;
        width: 100%;
        min-width: 0;
        max-height: 86vh;
        overflow-y: auto;
        padding: 12px;
        background: #17110d;
        border-top: 1px solid var(--border);
        box-shadow: 0 -18px 42px rgba(0,0,0,.45);
        transform: translateY(105%);
        transition: transform .18s ease;
    }

    .resumo-col.open {
        transform: translateY(0);
    }

    .resumo-col .panel {
        margin: 0;
    }

    .mobile-cart-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        min-height: 56px;
        margin-bottom: 10px;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--bg2);
        color: var(--cream);
        font-weight: 900;
        cursor: pointer;
    }

    .mobile-order-actionbar {
        position: fixed;
        left: 10px;
        right: 10px;
        bottom: calc(78px + env(safe-area-inset-bottom));
        z-index: 130;
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) auto auto minmax(104px, .9fr);
        align-items: center;
        gap: 8px;
        min-height: 62px;
        padding: 9px;
        border: 1px solid var(--border);
        border-radius: 14px;
        background: #17110d;
        box-shadow: 0 10px 34px rgba(0,0,0,.48);
    }

    .mobile-order-actionbar strong,
    .mobile-order-actionbar span {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 12px;
    }

    .mobile-order-actionbar strong {
        color: #fff;
        font-size: 13px;
    }

    .mobile-order-actionbar button {
        min-height: 44px;
        border: 0;
        border-radius: 10px;
        background: var(--accent);
        color: #fff;
        padding: 0 10px;
        font-weight: 900;
        cursor: pointer;
    }

    .mobile-order-actionbar button:disabled {
        opacity: .48;
        cursor: not-allowed;
    }

    .mobile-order-fab {
        position: fixed;
        right: 16px;
        bottom: calc(150px + env(safe-area-inset-bottom));
        z-index: 131;
        width: 56px;
        height: 56px;
        display: grid;
        place-items: center;
        border: 1px solid rgba(250,178,105,.32);
        border-radius: 50%;
        background: var(--accent);
        color: #fff;
        box-shadow: 0 12px 28px rgba(0,0,0,.42);
        font-weight: 900;
        cursor: pointer;
    }

    .mobile-order-fab small {
        position: absolute;
        top: -5px;
        right: -3px;
        min-width: 22px;
        height: 22px;
        display: grid;
        place-items: center;
        border-radius: 999px;
        background: #fff;
        color: var(--red);
        font-size: 11px;
        font-weight: 900;
    }

    .express-products {
        display: block;
        margin-bottom: 12px;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--bg2);
    }

    .express-products-title {
        margin-bottom: 8px;
        color: #fff;
        font-size: 12px;
        font-weight: 900;
    }

    .express-products-list {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 2px;
        -webkit-overflow-scrolling: touch;
    }

    .express-chip {
        min-height: 42px;
        border: 1px solid var(--border);
        border-radius: 999px;
        background: rgba(250,178,105,.06);
        color: var(--cream);
        padding: 7px 12px;
        font-weight: 900;
        white-space: nowrap;
        cursor: pointer;
    }

    .filtro-bar,
    .subtipo-bar {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
    }

    .filtro-btn,
    .subtipo-btn {
        min-height: 42px;
        white-space: nowrap;
    }

    .item-grid {
        grid-template-columns: 1fr;
        gap: 9px;
    }

    .menu-card {
        display: grid;
        grid-template-columns: 76px 1fr auto;
        gap: 10px;
        align-items: center;
        padding: 10px;
    }

    .menu-card-img,
    .menu-card-img-empty {
        grid-row: span 4;
        width: 76px;
        height: 76px;
        aspect-ratio: auto;
        margin: 0;
    }

    .menu-card-ctrl {
        grid-column: 3;
        grid-row: 1 / span 4;
        flex-direction: column-reverse;
        margin: 0;
    }

    .qty-btn {
        width: 44px;
        height: 44px;
        font-size: 22px;
    }

    .cat-sep {
        position: sticky;
        top: 58px;
        z-index: 4;
        margin: 12px 0 8px;
        padding: 6px 0;
        background: var(--bg);
    }
}
</style>
@endsection

@section('content')

@if(session('info'))
<div class="alert" style="background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.3);border-radius:10px;padding:12px 16px;margin-bottom:16px;color:#fde047;display:flex;align-items:center;gap:8px">
    <i class="fas fa-info-circle"></i> {{ session('info') }}
</div>
@endif

@if($pedido)
<div class="edit-banner">
    <i class="fas fa-pencil-alt"></i>
    <strong>Adicionar itens</strong> — Pedido #{{ str_pad($pedido->id,4,'0',STR_PAD_LEFT) }} para Mesa {{ $pedido->table->numero ?? '—' }}. Selecione apenas os novos itens para enviar à cozinha.
</div>
@endif

@php
    $atalhosPedido = $categorias->flatMap(fn($categoria) => $categoria->menuItems->take(3))->take(8);
@endphp

<form method="POST" action="{{ $pedido ? route('orders.update', $pedido) : route('orders.store') }}" id="order-form">
@csrf
@if($pedido) @method('PUT') @endif

<div class="order-layout">

    {{-- CARDÁPIO --}}
    <div class="cardapio-col">

        <div class="panel" style="padding:12px 16px; margin-bottom:16px">
            <input type="text" id="search-input" class="form-control"
                   placeholder="🔍  Buscar no cardápio...">
        </div>

        @if($atalhosPedido->isNotEmpty())
        <div class="express-products" aria-label="Atalhos de produtos">
            <div class="express-products-title">Mais pedidos</div>
            <div class="express-products-list">
                @foreach($atalhosPedido as $atalho)
                <button type="button" class="express-chip" onclick="addItem({{ $atalho->id }})">
                    {{ $atalho->nome }}
                </button>
                @endforeach
            </div>
        </div>
        @endif

        {{-- MELHORIA 4: Filtros por tipo principal --}}
        @php
            $tiposUnicos = $categorias->pluck('tipo_principal')->filter()->unique()->values();
        @endphp
        @if($tiposUnicos->count() > 0)
        <div class="filtro-bar" id="filtro-tipo">
            <button type="button" class="filtro-btn ativo" data-tipo="todos" onclick="filtrarTipo('todos', this)">
                🍽️ Todos
            </button>
            @foreach($tiposUnicos as $tipo)
            @php
                $tipoLabels = [
                    'prato_principal' => ['emoji' => '🥘', 'label' => 'Prato Principal'],
                    'entrada'         => ['emoji' => '🥗', 'label' => 'Entrada'],
                    'sobremesa'       => ['emoji' => '🍮', 'label' => 'Sobremesa'],
                    'bebida'          => ['emoji' => '🥤', 'label' => 'Bebida'],
                ];
                $info = $tipoLabels[$tipo] ?? ['emoji' => '📦', 'label' => ucfirst($tipo)];
            @endphp
            <button type="button" class="filtro-btn" data-tipo="{{ $tipo }}" onclick="filtrarTipo('{{ $tipo }}', this)">
                {{ $info['emoji'] }} {{ $info['label'] }}
            </button>
            @endforeach
        </div>
        @endif

        {{-- Subtipo filtros (aparecem dinamicamente) --}}
        <div id="subtipo-container" style="display:none; margin-bottom:10px">
            <div class="subtipo-bar" id="subtipo-bar"></div>
        </div>

        @forelse($categorias as $categoria)
        <div class="categoria-block"
             data-cat="{{ strtolower($categoria->nome) }}"
             data-tipo="{{ $categoria->tipo_principal ?? 'sem_tipo' }}">
            <div class="cat-sep">
                <div class="cat-sep-line"></div>
                <span class="cat-sep-label">{{ $categoria->nome }}</span>
                <div class="cat-sep-line"></div>
            </div>
            <div class="item-grid">
                @foreach($categoria->menuItems as $item)
                @php
                    $imagemUrl = $item->imagem_url;
                @endphp
                <div class="menu-card"
                     id="card-{{ $item->id }}"
                     data-id="{{ $item->id }}"
                     data-nome="{{ strtolower($item->nome) }}"
                     data-subtipo="{{ strtolower($item->subtipo ?? '') }}"
                     onclick="addItem({{ $item->id }})">
                    @if($imagemUrl)
                    <img src="{{ $imagemUrl }}" alt="{{ $item->nome }}" class="menu-card-img" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="menu-card-img-empty" style="display:none"><i class="fas fa-image"></i></div>
                    @else
                    <div class="menu-card-img-empty"><i class="fas fa-image"></i></div>
                    @endif
                    <div class="menu-card-nome">{{ $item->nome }}</div>
                    @if($item->descricao)
                    <div class="menu-card-desc">{{ $item->descricao }}</div>
                    @endif
                    <div class="menu-card-preco">R$ {{ number_format($item->preco,2,',','.') }}</div>
                    @if($item->serves_count >= 1)
                    @php $serveLabel = strtolower($item->subtipo ?? '') === 'porcao' ? 'Porção para' : 'Serve'; @endphp
                    <div class="menu-card-serves">👤 {{ $serveLabel }} {{ $item->serves_count }} {{ $item->serves_count == 1 ? 'pessoa' : 'pessoas' }}</div>
                    @endif
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
        <button type="button" class="mobile-cart-bar" onclick="toggleResumoMobile()">
            <span id="mobile-cart-items">0 itens</span>
            <span id="mobile-cart-total">R$ 0,00</span>
            <span>Continuar</span>
        </button>
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-clipboard-list"></i> Resumo</div>
                <button type="button" class="btn btn-secondary btn-sm btn-icon" onclick="clearAll()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="form-group">
                <label>Mesa</label>
                <select name="table_id" id="table-id-select" class="form-select {{ $errors->has('table_id') ? 'is-invalid' : '' }}" required {{ $pedido ? 'disabled' : '' }}>
                    <option value="">— Selecione —</option>
                    @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}" {{ old('table_id', $tableId ?? null) == $mesa->id ? 'selected' : '' }}>
                        Mesa {{ $mesa->numero }} · {{ $mesa->assentos }} lugares
                    </option>
                    @endforeach
                </select>
                @if($pedido)
                <input type="hidden" name="table_id" value="{{ $pedido->table_id }}">
                @endif
                @error('table_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Observações</label>
                <div class="quick-obs" aria-label="Observacoes rapidas">
                    @foreach(['Sem cebola','Sem gelo','Sem acucar','Ao ponto','Bem passado','Mal passado','Pouco sal','Sem pimenta','Separar molho'] as $obsRapida)
                    <button type="button" data-quick-obs="{{ $obsRapida }}">{{ $obsRapida }}</button>
                    @endforeach
                </div>
                <textarea name="observacoes" id="observacoes-input" class="form-control" rows="2"
                          placeholder="Alergias, preferências...">{{ old('observacoes', $pedido->observacoes ?? '') }}</textarea>
            </div>

            {{-- MELHORIA 8: Checkbox pedido para viagem --}}
            <div class="viagem-check" onclick="document.getElementById('pedido_viagem').click()">
                <input type="checkbox" name="pedido_viagem" id="pedido_viagem" value="1"
                    {{ old('pedido_viagem', $pedido->pedido_viagem ?? false) ? 'checked' : '' }}>
                <label for="pedido_viagem">🛵 Pedido para viagem</label>
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

            @if($errors->has('items'))
            <div class="alert alert-error" style="margin-bottom:12px; padding:10px 14px; font-size:13px">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first('items') }}
            </div>
            @endif

            <button type="button" id="btn-submit" class="btn-enviar" disabled
                    onclick="enviarPedido()">
                <i class="fas fa-paper-plane"></i> {{ $pedido ? 'Salvar Alterações' : 'Enviar Pedido' }}
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary"
               style="width:100%; margin-top:8px; justify-content:center">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </div>

</div>

<button type="button" class="mobile-order-fab" onclick="openResumoMobile()" aria-label="Abrir resumo do pedido">
    <i class="fas fa-cart-shopping"></i>
    <small id="mobile-fab-count">0</small>
</button>

<div class="mobile-order-actionbar" aria-label="Resumo rapido do pedido">
    <strong id="mobile-bar-mesa">Mesa -</strong>
    <span id="mobile-bar-items">0 itens</span>
    <span id="mobile-bar-total">R$ 0,00</span>
    <button type="button" id="mobile-bar-submit" onclick="enviarPedido()" disabled>Enviar</button>
</div>
</form>
@endsection

@section('scripts')
<script>
const precos = {
    @foreach($categorias as $cat)
    @foreach($cat->menuItems as $item)
    {{ $item->id }}: { nome: @json($item->nome), preco: {{ $item->preco }}, serves: {{ $item->serves_count ?? 1 }} },
    @endforeach
    @endforeach
};

const qtds = {};

// Chave única por pedido/mesa para o localStorage
const STORAGE_KEY = 'carrinho_{{ $pedido ? "edit_".$pedido->id : "new_".(request()->query("table_id","0")) }}';

function salvarCarrinho() {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(qtds)); } catch(e) {}
}

function limparCarrinho() {
    try { localStorage.removeItem(STORAGE_KEY); } catch(e) {}
}

document.addEventListener('DOMContentLoaded', () => {
    @if($pedido && $pedido->items)
        // Mantem no carrinho somente itens que ainda podem ser ajustados na cozinha.
        @foreach($pedido->items->whereIn('status', ['pendente', 'em_preparo']) as $oi)
        qtds[{{ $oi->menu_item_id }}] = {{ $oi->quantidade }};
        @endforeach
    @else
        // Modo criação: restaurar carrinho do localStorage após erro de validação
        @if($errors->any())
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved) {
                const restored = JSON.parse(saved);
                Object.assign(qtds, restored);
            }
        } catch(e) {}
        @endif
    @endif

    for (const id in qtds) {
        if (qtds[id] > 0) {
            const el   = document.getElementById('qty-' + id);
            if (el) el.textContent = qtds[id];
            const card = document.getElementById('card-' + id);
            if (card) card.classList.add('active');
        }
    }
    updateResumo();
    document.getElementById('table-id-select')?.addEventListener('change', updateResumo);
});

function addItem(id) { changeQty(id, 1); }

function changeQty(id, delta) {
    qtds[id] = Math.max(0, (qtds[id] || 0) + delta);
    document.getElementById('qty-' + id).textContent = qtds[id];
    const card = document.getElementById('card-' + id);
    if (card) card.classList.toggle('active', qtds[id] > 0);
    updateResumo();
    salvarCarrinho();
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

function toggleResumoMobile() {
    document.querySelector('.resumo-col')?.classList.toggle('open');
}

function openResumoMobile() {
    document.querySelector('.resumo-col')?.classList.add('open');
}

function closeResumoMobile() {
    document.querySelector('.resumo-col')?.classList.remove('open');
}

window.addObs = function(texto) {
    const input = document.getElementById('observacoes-input');
    if (!input) return;
    const atual = input.value.trim();
    input.value = atual ? atual + '; ' + texto : texto;
    input.dispatchEvent(new Event('input', { bubbles: true }));
    input.focus();
};

document.querySelectorAll('[data-quick-obs]').forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        window.addObs(button.dataset.quickObs || button.textContent.trim());
    });
});

function selectedMesaText() {
    const select = document.getElementById('table-id-select');
    if (!select || !select.value) return 'Mesa -';
    const label = select.options[select.selectedIndex]?.textContent || '';
    return label.split('·')[0].trim() || 'Mesa -';
}

function updateResumo() {
    let total = 0, totalItens = 0, hasItems = false, resumoHtml = '', hiddenHtml = '', idx = 0;
    for (const id in qtds) {
        if (qtds[id] > 0) {
            hasItems = true;
            const p = precos[id];
            const sub = p.preco * qtds[id];
            total += sub;
            totalItens += qtds[id];
            resumoHtml += `<div class="resumo-row">
                <span style="color:var(--text);flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${qtds[id]}× ${p.nome}</span>
                <span style="font-weight:700;color:#fff;white-space:nowrap;margin-left:8px">R$ ${sub.toFixed(2).replace('.',',')}</span>
            </div>`;
            hiddenHtml += `<input type="hidden" name="items[${idx}][menu_item_id]" value="${id}">`;
            hiddenHtml += `<input type="hidden" name="items[${idx}][quantidade]" value="${qtds[id]}">`;
            idx++;
        }
    }
    document.getElementById('resumo-items').innerHTML = hasItems ? resumoHtml
        : '<div style="text-align:center;color:var(--muted);font-size:13px;padding:18px 0">'
        + '<i class="fas fa-cart-plus" style="font-size:24px;opacity:.25;display:block;margin-bottom:8px"></i>'
        + 'Nenhum item selecionado</div>';
    document.getElementById('hidden-inputs').innerHTML = hiddenHtml;
    document.getElementById('total-display').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    document.getElementById('btn-submit').disabled = !hasItems;
    document.getElementById('mobile-cart-items').textContent = totalItens + (totalItens === 1 ? ' item' : ' itens');
    document.getElementById('mobile-cart-total').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    document.getElementById('mobile-fab-count').textContent = totalItens;
    document.getElementById('mobile-bar-mesa').textContent = selectedMesaText();
    document.getElementById('mobile-bar-items').textContent = totalItens + (totalItens === 1 ? ' item' : ' itens');
    document.getElementById('mobile-bar-total').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    document.getElementById('mobile-bar-submit').disabled = !hasItems;
}

// Busca
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

// MELHORIA 4: Filtros por tipo + subtipo
let tipoAtual = 'todos';
let subtipoAtual = 'todos';

function filtrarTipo(tipo, btn) {
    tipoAtual = tipo;
    subtipoAtual = 'todos';

    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('ativo'));
    btn.classList.add('ativo');

    // Coletar subtipos disponíveis para este tipo
    const subtipos = new Set();
    document.querySelectorAll('.categoria-block').forEach(bloco => {
        const blocoTipo = bloco.dataset.tipo;
        const mostrarBloco = (tipo === 'todos' || blocoTipo === tipo);
        bloco.style.display = mostrarBloco ? '' : 'none';

        if (mostrarBloco) {
            bloco.querySelectorAll('.menu-card').forEach(card => {
                card.style.display = '';
                if (card.dataset.subtipo) subtipos.add(card.dataset.subtipo);
            });
        }
    });

    // Mostrar subtipo bar se existir subtipos
    const subtContainer = document.getElementById('subtipo-container');
    const subtBar = document.getElementById('subtipo-bar');
    if (subtipos.size > 0 && tipo !== 'todos') {
        let html = '<button type="button" class="subtipo-btn ativo" data-sub="todos" onclick="filtrarSubtipo(\'todos\',this)">Todos</button>';
        subtipos.forEach(s => {
            if (s) html += `<button type="button" class="subtipo-btn" data-sub="${s}" onclick="filtrarSubtipo('${s}',this)">${s.charAt(0).toUpperCase()+s.slice(1)}</button>`;
        });
        subtBar.innerHTML = html;
        subtContainer.style.display = '';
    } else {
        subtContainer.style.display = 'none';
    }
}

function filtrarSubtipo(subtipo, btn) {
    subtipoAtual = subtipo;
    document.querySelectorAll('.subtipo-btn').forEach(b => b.classList.remove('ativo'));
    btn.classList.add('ativo');

    document.querySelectorAll('.categoria-block').forEach(bloco => {
        if (bloco.style.display === 'none') return;
        bloco.querySelectorAll('.menu-card').forEach(card => {
            if (subtipo === 'todos') {
                card.style.display = '';
            } else {
                card.style.display = card.dataset.subtipo === subtipo ? '' : 'none';
            }
        });
    });
}

function enviarPedido() {
    const hasItems = Object.values(qtds).some(q => q > 0);
    if (!hasItems) {
        if (typeof mostrarToast === 'function') {
            mostrarToast({
                icone: '<i class="fa-solid fa-cart-plus"></i>',
                titulo: 'Pedido vazio',
                msg: 'Adicione ao menos um item antes de enviar.',
                duracao: 3200
            });
        }
        return;
    }

    const form = document.getElementById('order-form');
    const mesa = document.getElementById('table-id-select');
    if (mesa && !mesa.value) {
        openResumoMobile();
        if (typeof mostrarToast === 'function') {
            mostrarToast({
                icone: '<i class="fa-solid fa-chair"></i>',
                titulo: 'Selecione a mesa',
                msg: 'Escolha a mesa antes de enviar para a cozinha.',
                duracao: 3500
            });
        }
        return;
    }

    // Remove inputs anteriores de items
    form.querySelectorAll('input[name^="items["]').forEach(el => el.remove());

    // Cria os inputs diretamente no form com o nome que o controller espera
    let idx = 0;
    for (const id in qtds) {
        if (qtds[id] > 0) {
            const preco    = precos[id] ? precos[id].preco : 0;
            const subtotal = (preco * qtds[id]).toFixed(2);

            const i1 = document.createElement('input');
            i1.type  = 'hidden';
            i1.name  = 'items[' + idx + '][menu_item_id]';
            i1.value = id;
            form.appendChild(i1);

            const i2 = document.createElement('input');
            i2.type  = 'hidden';
            i2.name  = 'items[' + idx + '][quantidade]';
            i2.value = qtds[id];
            form.appendChild(i2);

            const i3 = document.createElement('input');
            i3.type  = 'hidden';
            i3.name  = 'items[' + idx + '][subtotal]';
            i3.value = subtotal;
            form.appendChild(i3);

            idx++;
        }
    }

    limparCarrinho();
    form.submit();
}
</script>
@endsection
