@php
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
            $u  = strtolower($menuItem->stockItem->unidade);
            $qp = in_array($u, ['kg','g','l','ml']) ? 0.3 : 1;
            $ingItem->push($menuItem->stockItem->nome . ' ' . number_format($qp * $item->quantidade, 3, ',', '.') . ' ' . $menuItem->stockItem->unidade);
        }
    }

    $statusColor = match($item->status) {
        'pendente'   => ['bg' => 'rgba(249,115,22,.15)', 'txt' => '#fb923c'],
        'em_preparo' => ['bg' => 'rgba(234,179,8,.12)',  'txt' => '#facc15'],
        'pronto'     => ['bg' => 'rgba(34,197,94,.15)',  'txt' => '#4ade80'],
        default      => ['bg' => 'rgba(255,255,255,.05)', 'txt' => '#fff'],
    };
@endphp
<div class="item-row {{ $item->status }}">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px">
        <div style="display:flex; align-items:center; gap:10px; flex:1; min-width:0">
            <div style="width:34px; height:34px; border-radius:8px; flex-shrink:0;
                 background:{{ $statusColor['bg'] }};
                 display:flex; align-items:center; justify-content:center;
                 font-weight:800; font-size:15px;
                 color:{{ $statusColor['txt'] }}">
                {{ $item->quantidade }}
            </div>
            <div style="min-width:0">
                <div style="font-weight:700; color:#fff; font-size:13.5px">
                    {{ $item->menuItem->nome ?? 'Item' }}
                    @if($item->status === 'pendente')
                        <span style="font-size:10px; font-weight:800; color:#fb923c; margin-left:4px; text-transform:uppercase">NOVO</span>
                    @endif
                </div>
                @if($ingItem->isNotEmpty())
                <div style="font-size:11px; color:#a5b4fc; margin-top:2px">
                    <i class="fas fa-leaf" style="font-size:10px"></i>
                    {{ $ingItem->implode(' · ') }}
                </div>
                @endif
                @if($item->horario_pronto)
                <div style="font-size:10px; color:var(--muted); margin-top:2px">
                    Pronto às {{ $item->horario_pronto->format('H:i') }}
                </div>
                @endif
            </div>
        </div>

        {{-- Botões de ação por status --}}
        <div style="display:flex; flex-direction:column; gap:4px">
            @if($item->status === 'pendente')
                <form method="POST" action="{{ route('chef.item.status', $item) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="em_preparo">
                    <button type="submit" class="btn btn-warning btn-sm" title="Iniciar preparo">
                        🔥
                    </button>
                </form>
                <form method="POST" action="{{ route('chef.item.status', $item) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="pronto">
                    <button type="submit" class="btn btn-success btn-sm" title="Marcar pronto direto">
                        <i class="fas fa-check"></i>
                    </button>
                </form>
            @elseif($item->status === 'em_preparo')
                <form method="POST" action="{{ route('chef.item.status', $item) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="pronto">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check"></i> Pronto
                    </button>
                </form>
                <form method="POST" action="{{ route('chef.item.status', $item) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="pendente">
                    <button type="submit" class="btn btn-secondary btn-sm" title="Voltar para pendente">
                        <i class="fas fa-undo"></i>
                    </button>
                </form>
            @elseif($item->status === 'pronto')
                <form method="POST" action="{{ route('chef.item.status', $item) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="em_preparo">
                    <button type="submit" class="btn btn-warning btn-sm" title="Desfazer">
                        <i class="fas fa-undo"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
