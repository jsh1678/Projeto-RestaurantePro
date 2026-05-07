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
.item-row {
    background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.06);
    border-radius:10px; padding:12px 14px;
    transition:.2s;
}
.item-row.pronto {
    border-color:rgba(34,197,94,.25);
    background:rgba(34,197,94,.04);
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
<div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(400px,1fr)); gap:20px">
    @foreach($pedidosEmPreparo as $pedido)
    @php
        $prontos  = $pedido->items->where('status','pronto')->count();
        $total    = $pedido->items->count();
        $pct      = $total > 0 ? round($prontos/$total*100) : 0;
        $minutos  = $pedido->horario_pedido ? now()->diffInMinutes($pedido->horario_pedido) : 0;

        // Agregar TODOS os ingredientes do pedido inteiro
        $ingredientesAgregados = collect();
        foreach($pedido->items as $orderItem) {
            $menuItem = $orderItem->menuItem;
            if (!$menuItem) continue;

            if ($menuItem->ingredients->isNotEmpty()) {
                foreach($menuItem->ingredients as $ing) {
                    $stock = $ing->stockItem;
                    if (!$stock) continue;
                    $qtdPorcao = $ing->quantidade > 0 ? $ing->quantidade
                        : ($ing->quantidade_gramas > 0 ? ($stock->unidade === 'kg' ? $ing->quantidade_gramas/1000 : $ing->quantidade_gramas) : 0);
                    $qtdTotal = $qtdPorcao * $orderItem->quantidade;
                    $chave = $stock->id;
                    if ($ingredientesAgregados->has($chave)) {
                        $ingredientesAgregados[$chave]['qtd'] += $qtdTotal;
                    } else {
                        $ingredientesAgregados[$chave] = [
                            'nome'    => $stock->nome,
                            'unidade' => $stock->unidade,
                            'qtd'     => $qtdTotal,
                            'atual'   => $stock->quantidade_atual,
                            'suficiente' => $stock->quantidade_atual >= $qtdTotal,
                        ];
                    }
                }
            } elseif ($menuItem->stockItem) {
                $stock = $menuItem->stockItem;
                $unidade = strtolower($stock->unidade);
                $qtdPorcao = in_array($unidade, ['kg','g','l','ml']) ? 0.3 : 1;
                $qtdTotal = $qtdPorcao * $orderItem->quantidade;
                $chave = $stock->id;
                if ($ingredientesAgregados->has($chave)) {
                    $ingredientesAgregados[$chave]['qtd'] += $qtdTotal;
                } else {
                    $ingredientesAgregados[$chave] = [
                        'nome'    => $stock->nome,
                        'unidade' => $stock->unidade,
                        'qtd'     => $qtdTotal,
                        'atual'   => $stock->quantidade_atual,
                        'suficiente' => $stock->quantidade_atual >= $qtdTotal,
                    ];
                }
            }
        }
    @endphp

    <div class="panel" style="margin-bottom:0; border-color:{{ $minutos > 20 ? 'rgba(239,68,68,.35)' : 'rgba(255,255,255,.07)' }}">

        {{-- Cabeçalho --}}
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px">
            <div>
                <div style="font-size:18px; font-weight:800; color:#fff">
                    Pedido <span style="color:var(--accent); font-family:monospace">#{{ str_pad($pedido->id,4,'0',STR_PAD_LEFT) }}</span>
                </div>
                <div style="font-size:13px; color:var(--muted); margin-top:3px">
                    Mesa {{ $pedido->table->numero ?? '—' }}
                    @if($pedido->user) · {{ $pedido->user->name }} @endif
                    @if($pedido->horario_pedido)
                    · <span style="color:{{ $minutos > 20 ? '#f87171' : ($minutos > 10 ? '#facc15' : '#4ade80') }}; font-weight:700">
                        {{ $minutos }} min
                    </span>
                    @endif
                </div>
            </div>
            <span class="badge badge-{{ $pct===100 ? 'success' : 'warning' }}">{{ $prontos }}/{{ $total }}</span>
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

        {{-- Ingredientes necessários para o pedido inteiro --}}
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
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

@section('scripts')
<script>
    setTimeout(() => location.reload(), 30000);
</script>
@endsection
