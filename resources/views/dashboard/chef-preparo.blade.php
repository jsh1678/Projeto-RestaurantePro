@extends('layouts.app')
@section('page-title', 'Cozinha — Preparo')
@section('breadcrumb', 'Fila de pedidos em preparo')

@section('styles')
<style>
.ing-tag {
    display:inline-flex; align-items:center; gap:5px;
    padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;
    background:rgba(99,102,241,.12); color:#a5b4fc;
    border:1px solid rgba(99,102,241,.2);
    margin:2px;
}
.ing-tag.baixo { background:rgba(239,68,68,.12); color:#fca5a5; border-color:rgba(239,68,68,.2); }
<<<<<<< HEAD

=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
.item-row {
    background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.06);
    border-radius:10px; padding:12px 14px;
    transition:.2s;
}
<<<<<<< HEAD
.item-row.pendente {
    border-color:rgba(249,115,22,.35);
    background:rgba(249,115,22,.05);
}
.item-row.em_preparo {
    border-color:rgba(234,179,8,.3);
    background:rgba(234,179,8,.04);
}
.item-row.pronto {
    border-color:rgba(34,197,94,.25);
    background:rgba(34,197,94,.04);
    opacity:.75;
}

.badge-novo {
    display:inline-flex; align-items:center; gap:3px;
    padding:2px 8px; border-radius:20px; font-size:10px; font-weight:800;
    background:rgba(249,115,22,.2); color:#fb923c;
    border:1px solid rgba(249,115,22,.4);
    letter-spacing:.4px; text-transform:uppercase;
}

.rodada-sep {
    display:flex; align-items:center; gap:8px;
    margin: 10px 0 6px;
    font-size:10px; font-weight:800; text-transform:uppercase;
    letter-spacing:.8px; color:var(--muted);
}
.rodada-sep::before, .rodada-sep::after {
    content:''; flex:1; height:1px; background:rgba(255,255,255,.07);
}

.kitchen-mobile-tabs {
    display: none;
}

.kitchen-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(400px,1fr));
    gap:20px;
}

@media (max-width: 768px) {
    .kitchen-mobile-tabs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        margin-bottom: 12px;
        padding-bottom: 2px;
    }

    .kitchen-mobile-tabs button {
        min-height: 44px;
        border: 1px solid var(--border);
        border-radius: 999px;
        background: var(--bg2);
        color: var(--muted);
        padding: 8px 14px;
        font-weight: 900;
        white-space: nowrap;
    }

    .kitchen-mobile-tabs button.active {
        border-color: var(--accent);
        color: #fff;
        background: rgba(236,45,1,.12);
    }

    .kitchen-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .item-row {
        padding: 12px;
    }
=======
.item-row.pronto {
    border-color:rgba(34,197,94,.25);
    background:rgba(34,197,94,.04);
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
}
</style>
@endsection

@section('content')

<div class="cards-grid" style="grid-template-columns:repeat(3,1fr); margin-bottom:24px">
    <div class="stat-card" style="--card-color:#f97316">
        <div class="sc-header"><div class="sc-icon">🔥</div></div>
        <div class="sc-value">{{ $pedidosEmPreparo->count() }}</div>
        <div class="sc-label">Pedidos em preparo</div>
    </div>
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon">🍴</div></div>
        <div class="sc-value">{{ $totalItems }}</div>
        <div class="sc-label">Total de itens</div>
    </div>
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon">✅</div></div>
        <div class="sc-value">{{ $itensProntos }}<span style="font-size:16px;font-weight:500;color:var(--muted)">/{{ $totalItems }}</span></div>
        <div class="sc-label">Itens prontos</div>
    </div>
</div>

@if($pedidosEmPreparo->isEmpty())
<div class="panel" style="text-align:center; padding:64px">
    <div style="font-size:64px; margin-bottom:16px">🍳</div>
    <div style="font-size:18px; font-weight:700; color:#fff; margin-bottom:8px">Cozinha Livre</div>
    <div style="color:var(--muted); font-size:14px">Nenhum pedido em preparo no momento</div>
</div>
@else
<<<<<<< HEAD
<div class="kitchen-mobile-tabs" aria-label="Filtro de pedidos da cozinha">
    <button type="button" class="active" data-kitchen-filter="todos" onclick="filtrarCozinha('todos', this)">Todos</button>
    <button type="button" data-kitchen-filter="novos" onclick="filtrarCozinha('novos', this)">Novos</button>
    <button type="button" data-kitchen-filter="preparo" onclick="filtrarCozinha('preparo', this)">Em preparo</button>
    <button type="button" data-kitchen-filter="prontos" onclick="filtrarCozinha('prontos', this)">Prontos</button>
</div>

<div class="kitchen-grid">
    @foreach($pedidosEmPreparo as $pedido)
    @php
        $itensPendentes  = $pedido->items->whereIn('status', ['pendente']);
        $itensEmPreparo  = $pedido->items->where('status', 'em_preparo');
        $itensProntos    = $pedido->items->where('status', 'pronto');
        $itensEntregues  = $pedido->items->where('status', 'entregue');

        $totalAtivos = $pedido->items->whereNotIn('status', ['entregue'])->count();
        $totalFeitos = $itensProntos->count();
        $pct         = $totalAtivos > 0 ? round($totalFeitos / $totalAtivos * 100) : 0;

        // ✅ CORRIGIDO: usa created_at como fallback e garante valor positivo
        $dataReferencia = $pedido->horario_pedido ?? $pedido->created_at;
        $minutos = $dataReferencia ? (int) abs(now()->diffInMinutes($dataReferencia)) : 0;

        $isViagem    = !empty($pedido->pedido_viagem);
        $temNovos    = $itensPendentes->isNotEmpty();
        $temAtivos   = $itensPendentes->isNotEmpty() || $itensEmPreparo->isNotEmpty();

        // Ingredientes agregados dos itens ainda não prontos
        $ingredientesAgregados = collect();
        foreach($pedido->items->whereNotIn('status', ['pronto','entregue']) as $orderItem) {
            $menuItem = $orderItem->menuItem;
            if (!$menuItem) continue;
=======
<div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(400px,1fr)); gap:20px">
    @foreach($pedidosEmPreparo as $pedido)
    @php
        $prontos  = $pedido->items->where('status','pronto')->count();
        $total    = $pedido->items->count();
        $pct      = $total > 0 ? round($prontos/$total*100) : 0;
        $minutos  = $pedido->horario_pedido ? now()->diffInMinutes($pedido->horario_pedido) : 0;
        $isViagem = !empty($pedido->pedido_viagem);

        // Agregar TODOS os ingredientes do pedido inteiro
        $ingredientesAgregados = collect();
        foreach($pedido->items as $orderItem) {
            $menuItem = $orderItem->menuItem;
            if (!$menuItem) continue;

>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            if ($menuItem->ingredients->isNotEmpty()) {
                foreach($menuItem->ingredients as $ing) {
                    $stock = $ing->stockItem;
                    if (!$stock) continue;
                    $qtdPorcao = $ing->quantidade > 0 ? $ing->quantidade
                        : ($ing->quantidade_gramas > 0 ? ($stock->unidade === 'kg' ? $ing->quantidade_gramas/1000 : $ing->quantidade_gramas) : 0);
                    $qtdTotal = $qtdPorcao * $orderItem->quantidade;
                    $chave = $stock->id;
                    if ($ingredientesAgregados->has($chave)) {
<<<<<<< HEAD
                        $agregado = $ingredientesAgregados->get($chave);
                        $agregado['qtd'] += $qtdTotal;
                        $agregado['suficiente'] = $agregado['atual'] >= $agregado['qtd'];
                        $ingredientesAgregados->put($chave, $agregado);
                    } else {
                        $ingredientesAgregados->put($chave, [
                            'nome'       => $stock->nome,
                            'unidade'    => $stock->unidade,
                            'qtd'        => $qtdTotal,
                            'atual'      => $stock->quantidade_atual,
                            'suficiente' => $stock->quantidade_atual >= $qtdTotal,
                        ]);
=======
                        $ingredientesAgregados[$chave]['qtd'] += $qtdTotal;
                    } else {
                        $ingredientesAgregados[$chave] = [
                            'nome'    => $stock->nome,
                            'unidade' => $stock->unidade,
                            'qtd'     => $qtdTotal,
                            'atual'   => $stock->quantidade_atual,
                            'suficiente' => $stock->quantidade_atual >= $qtdTotal,
                        ];
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
                    }
                }
            } elseif ($menuItem->stockItem) {
                $stock = $menuItem->stockItem;
                $unidade = strtolower($stock->unidade);
                $qtdPorcao = in_array($unidade, ['kg','g','l','ml']) ? 0.3 : 1;
                $qtdTotal = $qtdPorcao * $orderItem->quantidade;
                $chave = $stock->id;
                if ($ingredientesAgregados->has($chave)) {
<<<<<<< HEAD
                    $agregado = $ingredientesAgregados->get($chave);
                    $agregado['qtd'] += $qtdTotal;
                    $agregado['suficiente'] = $agregado['atual'] >= $agregado['qtd'];
                    $ingredientesAgregados->put($chave, $agregado);
                } else {
                    $ingredientesAgregados->put($chave, [
                        'nome'       => $stock->nome,
                        'unidade'    => $stock->unidade,
                        'qtd'        => $qtdTotal,
                        'atual'      => $stock->quantidade_atual,
                        'suficiente' => $stock->quantidade_atual >= $qtdTotal,
                    ]);
=======
                    $ingredientesAgregados[$chave]['qtd'] += $qtdTotal;
                } else {
                    $ingredientesAgregados[$chave] = [
                        'nome'    => $stock->nome,
                        'unidade' => $stock->unidade,
                        'qtd'     => $qtdTotal,
                        'atual'   => $stock->quantidade_atual,
                        'suficiente' => $stock->quantidade_atual >= $qtdTotal,
                    ];
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
                }
            }
        }
    @endphp

<<<<<<< HEAD
    <div class="panel"
         data-pedido-id="{{ $pedido->id }}"
         data-kitchen-card
         data-kitchen-status="{{ $temNovos ? 'novos' : ($itensEmPreparo->isNotEmpty() ? 'preparo' : 'prontos') }}"
         style="margin-bottom:0; border-color:{{ $minutos > 20 ? 'rgba(239,68,68,.35)' : ($temNovos ? 'rgba(249,115,22,.4)' : 'rgba(255,255,255,.07)') }}">
=======
    <div class="panel" style="margin-bottom:0; border-color:{{ $minutos > 20 ? 'rgba(239,68,68,.35)' : 'rgba(255,255,255,.07)' }}">
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

        {{-- Cabeçalho --}}
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px">
            <div>
<<<<<<< HEAD
                <div style="display:flex; align-items:center; gap:8px; font-size:18px; font-weight:800; color:#fff">
                    Pedido <span style="color:var(--accent); font-family:monospace">#{{ str_pad($pedido->id,4,'0',STR_PAD_LEFT) }}</span>
                    @if($temNovos)<span class="badge-novo">🆕 novo item</span>@endif
=======
                <div style="font-size:18px; font-weight:800; color:#fff">
                    Pedido <span style="color:var(--accent); font-family:monospace">#{{ str_pad($pedido->id,4,'0',STR_PAD_LEFT) }}</span>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
                </div>
                <div style="font-size:13px; color:var(--muted); margin-top:3px">
                    Mesa {{ $pedido->table->numero ?? '—' }}
                    @if($isViagem)<span style="display:inline-flex;align-items:center;gap:3px;padding:1px 8px;border-radius:20px;background:rgba(249,115,22,.2);border:1px solid rgba(249,115,22,.4);color:#fb923c;font-size:10px;font-weight:800;margin-left:6px;vertical-align:middle;letter-spacing:.5px">🛵 VIAGEM</span>@endif
                    @if($pedido->user) · {{ $pedido->user->name }} @endif
<<<<<<< HEAD
                    · <span style="color:{{ $minutos > 20 ? '#f87171' : ($minutos > 10 ? '#facc15' : '#4ade80') }}; font-weight:700">
                        {{ $minutos }} min
                    </span>
                </div>
            </div>
            <span class="badge badge-{{ $pct===100 ? 'success' : 'warning' }}">{{ $totalFeitos }}/{{ $totalAtivos }}</span>
=======
                    @if($pedido->horario_pedido)
                    · <span style="color:{{ $minutos > 20 ? '#f87171' : ($minutos > 10 ? '#facc15' : '#4ade80') }}; font-weight:700">
                        {{ $minutos }} min
                    </span>
                    @endif
                </div>
            </div>
            <span class="badge badge-{{ $pct===100 ? 'success' : 'warning' }}">{{ $prontos }}/{{ $total }}</span>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        </div>

        {{-- Barra de progresso --}}
        <div style="background:rgba(255,255,255,.06); border-radius:4px; height:4px; margin-bottom:14px">
            <div style="height:4px; border-radius:4px; background:{{ $pct===100 ? '#22c55e' : 'var(--accent)' }}; width:{{ $pct }}%; transition:.3s"></div>
        </div>

        {{-- Observações --}}
        @if($pedido->observacoes)
        <div style="background:rgba(234,179,8,.08); border:1px solid rgba(234,179,8,.2); border-radius:8px; padding:8px 12px; margin-bottom:12px; font-size:12px; color:#facc15">
            ⚠️ {{ $pedido->observacoes }}
        </div>
        @endif

<<<<<<< HEAD
        {{-- Ingredientes necessários --}}
=======
        {{-- Ingredientes necessários para o pedido inteiro --}}
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        @if($ingredientesAgregados->isNotEmpty())
        <div style="background:rgba(99,102,241,.06); border:1px solid rgba(99,102,241,.15); border-radius:10px; padding:10px 12px; margin-bottom:14px">
            <div style="font-size:11px; font-weight:700; color:#a5b4fc; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px">
                <i class="fas fa-boxes"></i> Ingredientes necessários
            </div>
            <div style="display:flex; flex-wrap:wrap; gap:4px">
                @foreach($ingredientesAgregados as $ing)
                <span class="ing-tag {{ !$ing['suficiente'] ? 'baixo' : '' }}"
                      title="{{ $ing['suficiente'] ? 'Estoque OK' : 'Estoque insuficiente!' }}">
                    {{ !$ing['suficiente'] ? '⚠️ ' : '' }}
                    {{ $ing['nome'] }}:
                    {{ number_format($ing['qtd'], 3, ',', '.') }} {{ $ing['unidade'] }}
                    @if(!$ing['suficiente'])
                    (disponível: {{ number_format($ing['atual'], 3, ',', '.') }})
                    @endif
                </span>
                @endforeach
            </div>
        </div>
        @endif

<<<<<<< HEAD
        {{-- ITENS POR GRUPO --}}
        <div style="display:flex; flex-direction:column; gap:6px">

            {{-- 🆕 Novos / Pendentes --}}
            @if($itensPendentes->isNotEmpty())
            <div class="rodada-sep" style="color:#fb923c">🆕 Novos pedidos</div>
            @foreach($itensPendentes as $item)
                @include('dashboard._item-row', ['item' => $item])
            @endforeach
            @endif

            {{-- 🔥 Em Preparo --}}
            @if($itensEmPreparo->isNotEmpty())
            <div class="rodada-sep" style="color:#facc15">🔥 Em preparo</div>
            @foreach($itensEmPreparo as $item)
                @include('dashboard._item-row', ['item' => $item])
            @endforeach
            @endif

            {{-- ✅ Prontos — só mostra se ainda há itens ativos no pedido --}}
            @if($itensProntos->isNotEmpty() && $temAtivos)
            <div class="rodada-sep">✅ Prontos ({{ $itensProntos->count() }})</div>
            @foreach($itensProntos as $item)
                @include('dashboard._item-row', ['item' => $item])
            @endforeach
            @endif

=======
        {{-- Itens do pedido --}}
        <div style="display:flex; flex-direction:column; gap:8px">
            @foreach($pedido->items as $item)
            @php
                // Ingredientes deste item específico
                $ingItem = collect();
                $menuItem = $item->menuItem;
                if ($menuItem) {
                    if ($menuItem->ingredients->isNotEmpty()) {
                        foreach($menuItem->ingredients as $ing) {
                            if (!$ing->stockItem) continue;
                            $qtdP = $ing->quantidade > 0 ? $ing->quantidade
                                : ($ing->quantidade_gramas > 0 ? ($ing->stockItem->unidade === 'kg' ? $ing->quantidade_gramas/1000 : $ing->quantidade_gramas) : 0);
                            $ingItem->push($ing->stockItem->nome . ' ' . number_format($qtdP * $item->quantidade, 3, ',', '.') . ' ' . $ing->stockItem->unidade);
                        }
                    } elseif ($menuItem->stockItem) {
                        $u = strtolower($menuItem->stockItem->unidade);
                        $qp = in_array($u, ['kg','g','l','ml']) ? 0.3 : 1;
                        $ingItem->push($menuItem->stockItem->nome . ' ' . number_format($qp * $item->quantidade, 3, ',', '.') . ' ' . $menuItem->stockItem->unidade);
                    }
                }
            @endphp
            <div class="item-row {{ $item->status === 'pronto' ? 'pronto' : '' }}">
                <div style="display:flex; align-items:center; justify-content:space-between; gap:10px">
                    <div style="display:flex; align-items:center; gap:10px; flex:1; min-width:0">
                        <div style="width:30px; height:30px; border-radius:8px; flex-shrink:0;
                             background:{{ $item->status==='pronto' ? 'rgba(34,197,94,.15)' : 'rgba(255,255,255,.05)' }};
                             display:flex; align-items:center; justify-content:center;
                             font-weight:800; font-size:14px;
                             color:{{ $item->status==='pronto' ? '#4ade80' : '#fff' }}">
                            {{ $item->quantidade }}
                        </div>
                        <div style="min-width:0">
                            <div style="font-weight:700; color:#fff; font-size:13.5px">
                                {{ $item->menuItem->nome ?? 'Item' }}
                            </div>
                            @if($ingItem->isNotEmpty())
                            <div style="font-size:11px; color:#a5b4fc; margin-top:2px">
                                <i class="fas fa-leaf" style="font-size:10px"></i>
                                {{ $ingItem->implode(' · ') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <form method="POST" action="{{ route('chef.item.status', $item) }}">
                        @csrf @method('PATCH')
                        @if($item->status !== 'pronto')
                            <input type="hidden" name="status" value="pronto">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Pronto
                            </button>
                        @else
                            <input type="hidden" name="status" value="em_preparo">
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-undo"></i>
                            </button>
                        @endif
                    </form>
                </div>
            </div>
            @endforeach
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

@section('scripts')
<script>
<<<<<<< HEAD
function tocarSom() {
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        [0, 0.25].forEach(offset => {
            const osc  = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.frequency.value = 880;
            osc.type = 'sine';
            gain.gain.setValueAtTime(0.4, ctx.currentTime + offset);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + offset + 0.18);
            osc.start(ctx.currentTime + offset);
            osc.stop(ctx.currentTime + offset + 0.2);
        });
    } catch(e) {}
}

function escaparHtml(valor) {
    return String(valor ?? '').replace(/[&<>"']/g, function(c) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c];
    });
}

function filtrarCozinha(status, button) {
    document.querySelectorAll('[data-kitchen-filter]').forEach((btn) => btn.classList.remove('active'));
    if (button) button.classList.add('active');
    document.querySelectorAll('[data-kitchen-card]').forEach((card) => {
        card.style.display = status === 'todos' || card.dataset.kitchenStatus === status ? '' : 'none';
    });
}

function mostrarToast(eventos) {
    if (!document.getElementById('toast-style')) {
        const s = document.createElement('style');
        s.id = 'toast-style';
        s.textContent = `
            .toast-cozinha{position:fixed;top:20px;right:20px;z-index:9999;background:#1b1714;
                border:1px solid #f97316;border-radius:10px;padding:14px 16px;min-width:300px;
                max-width:400px;box-shadow:0 12px 28px rgba(0,0,0,.28);}
        `;
        document.head.appendChild(s);
    }

    eventos.forEach((evento, idx) => {
        const pedido = evento.payload || {};
        const tipo = evento.type || 'item_added';
        const titulo = tipo === 'order_cancelled'
            ? 'Pedido cancelado'
            : (tipo === 'order_updated' ? 'Pedido alterado' : 'Novo pedido na cozinha');
        const borda = tipo === 'order_cancelled' ? '#ef4444' : (tipo === 'order_updated' ? '#facc15' : '#f97316');

        const toast = document.createElement('div');
        toast.className = 'toast-cozinha';
        toast.style.top = (20 + idx * 10) + 'px';
        toast.style.borderColor = borda;

        const itens = pedido.itens || [];
        const removidos = pedido.itens_removidos || [];
        const itensHtml = itens
            .map(i => `<div style="display:flex;justify-content:space-between;padding:4px 0;
                border-bottom:1px solid rgba(255,255,255,.07)">
                <span style="color:#fff;font-size:13px">${escaparHtml(i.nome)}</span>
                <span style="color:#f97316;font-weight:800;font-size:13px">${escaparHtml(i.quantidade)}×</span>
            </div>`).join('');
        const removidosHtml = removidos
            .map(i => `<div style="display:flex;justify-content:space-between;padding:4px 0;color:#fca5a5">
                <span style="font-size:13px">${escaparHtml(i.nome)}</span>
                <span style="font-weight:800;font-size:13px">${escaparHtml(i.quantidade)}× removido</span>
            </div>`).join('');

        toast.innerHTML = `
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px">
                <span style="font-size:20px">🔔</span>
                <div>
                    <div style="font-weight:800;color:${borda};font-size:15px">
                        ${titulo}: #${escaparHtml(pedido.numero)} — Mesa ${escaparHtml(pedido.mesa)}
                    </div>
                    <div style="font-size:11px;color:#9ca3af">
                        ${escaparHtml(pedido.garcom)}${pedido.viagem ? ' &nbsp;🛵 VIAGEM' : ''}
                    </div>
                </div>
                <button onclick="this.closest('.toast-cozinha').remove()"
                    style="margin-left:auto;background:none;border:none;color:#9ca3af;
                           font-size:20px;cursor:pointer;line-height:1">×</button>
            </div>
            ${itensHtml ? `<div>${itensHtml}</div>` : ''}
            ${removidosHtml ? `<div style="margin-top:6px">${removidosHtml}</div>` : ''}
            ${pedido.obs ? `<div style="font-size:11px;color:#facc15;margin-top:8px;padding:6px 8px;
                background:rgba(234,179,8,.1);border-radius:6px">⚠️ ${escaparHtml(pedido.obs)}</div>` : ''}
        `;

        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 15000);
    });
}

let sse;
let tentativas = 0;
let ultimoEventoId = {{ (int) $cozinhaEventCursor }};
let recarregando = false;

function conectarSSE() {
    if (sse) sse.close();
    sse = new EventSource('{{ route("cozinha.stream") }}?after=' + encodeURIComponent(ultimoEventoId));

    sse.addEventListener('connected', () => {
        tentativas = 0;
    });

    sse.addEventListener('cozinha_eventos', (e) => {
        const eventos = JSON.parse(e.data);
        if (!eventos.length) return;

        ultimoEventoId = eventos[eventos.length - 1].id || ultimoEventoId;
        if (eventos.some(evento => evento.type === 'item_added')) {
            tocarSom();
        }
        mostrarToast(eventos);

        if (!recarregando) {
            recarregando = true;
            setTimeout(() => {
                location.reload();
            }, 1200);
        }
    });

    sse.addEventListener('reconectar', () => {
        sse.close();
        setTimeout(conectarSSE, 1000);
    });

    sse.onerror = () => {
        sse.close();
        tentativas++;
        setTimeout(conectarSSE, Math.min(1000 * Math.pow(2, tentativas), 30000));
    };
}

document.addEventListener('DOMContentLoaded', () => {
    conectarSSE();
    setInterval(() => {
        if (!sse || sse.readyState === EventSource.CLOSED) location.reload();
    }, 60000);
});
=======
    setTimeout(() => location.reload(), 30000);
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
</script>
@endsection
