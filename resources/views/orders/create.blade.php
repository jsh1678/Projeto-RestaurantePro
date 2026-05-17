<file path="resources/views/orders/create.blade.php">
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
    <strong>Modo de edição</strong> — Pedido #{{ str_pad($pedido->id,4,'0',STR_PAD_LEFT) }} para Mesa {{ $pedido->table->numero ?? '—' }}. Altere os itens e salve para atualizar.
</div>
@endif

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
                <div class="menu-card"
                     id="card-{{ $item->id }}"
                     data-id="{{ $item->id }}"
                     data-nome="{{ strtolower($item->nome) }}"
                     data-subtipo="{{ strtolower($item->subtipo ?? '') }}"
                     onclick="addItem({{ $item->id }})">
                    <div class="menu-card-nome">{{ $item->nome }}</div>
                    @if($item->descricao)
                    <div class="menu-card-desc">{{ $item->descricao }}</div>
                    @endif
                    <div class="menu-card-preco">R$ {{ number_format($item->preco,2,',','.') }}</div>
                    @if($item->serves_count > 1)
                    <div class="menu-card-serves">👤 Serve {{ $item->serves_count }} pessoas</div>
                    @endif
                    <div class="menu-card-ctrl" onclick="event.stopPropagation()">
                        <button type="button" class="qty-btn minus" onclick="changeQty({{ $item->id }}, -1)" aria-label="Diminuir quantidade de {{ $item->nome }}">−</button>
                        <span class="qty-num" id="qty-{{ $item->id }}">0</span>
                        <button type="button" class="qty-btn plus"  onclick="changeQty({{ $item->id }}, 1)" aria-label="Aumentar quantidade de {{ $item->nome }}">+</button>
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
                <select name="table_id" class="form-select {{ $errors->has('table_id') ? 'is-invalid' : '' }}" required {{ $pedido ? 'disabled' : '' }}>
                    <option value="">— Selecione —</option>
                    @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}" {{ old('table_id', $tableId) == $mesa->id ? 'selected' : '' }}>
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
                <textarea name="observacoes" class="form-control" rows="2"
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

            @if($errors->has('itens'))
            <div class="alert alert-error" style="margin-bottom:12px; padding:10px 14px; font-size:13px">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first('itens') }}
            </div>
            @endif

            <button type="submit" id="btn-submit" class="btn-enviar" disabled>
                <i class="fas fa-paper-plane"></i> {{ $pedido ? 'Salvar Alterações' : 'Enviar Pedido' }}
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