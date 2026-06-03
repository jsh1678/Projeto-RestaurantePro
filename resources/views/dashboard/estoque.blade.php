@extends('layouts.app')
@section('page-title', 'Estoque')
@section('breadcrumb', 'Controle de inventário')

@section('styles')
<style>
.unidade-badge {
    padding:2px 8px; border-radius:6px; font-size:11px; font-weight:700;
    background:rgba(99,102,241,.15); color:#818cf8;
}
.qtd-display { font-family:monospace; font-weight:800; font-size:15px; }
.qtd-display.ok     { color:#4ade80; }
.qtd-display.alerta { color:#f87171; }
.form-ajuste {
    display:none; margin-top:10px; padding:14px;
    background:var(--bg3); border-radius:10px; border:1px solid var(--border);
}
.compra-form {
    display:grid; grid-template-columns:2fr 1fr 1fr 1.5fr auto; gap:10px; align-items:end;
}
.history-grid {
    display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-top:18px;
}
@media (max-width: 920px) {
    .compra-form, .history-grid { grid-template-columns:1fr; }
}
</style>
@endsection

@section('content')

@if($estoqueAlerta->isNotEmpty())
<div class="alert alert-warning">
    ⚠️ <span><strong>{{ $estoqueAlerta->count() }} item(s)</strong> abaixo do estoque mínimo — reposição necessária!</span>
</div>
@endif

<div class="panel" style="margin-bottom:18px">
    <div class="panel-header">
        <div class="panel-title"><i class="fa-solid fa-cart-shopping"></i> Registrar compra para estoque</div>
    </div>
    <form method="POST" action="{{ route('compras.store') }}" class="compra-form">
        @csrf
        <div class="form-group" style="margin:0">
            <label>Produto</label>
            <select name="stock_item_id" class="form-select" required>
                <option value="">Selecione</option>
                @foreach($itens as $itemCompra)
                <option value="{{ $itemCompra->id }}">{{ $itemCompra->nome }} ({{ $itemCompra->unidade }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0">
            <label>Quantidade</label>
            <input type="number" name="quantidade" step="0.001" min="0.001" max="99999" class="form-control" required>
        </div>
        <div class="form-group" style="margin:0">
            <label>Preco unit.</label>
            <input type="number" name="preco_unitario" step="0.01" min="0.01" max="999999" class="form-control" required>
        </div>
        <div class="form-group" style="margin:0">
            <label>Fornecedor</label>
            <input type="text" name="fornecedor" class="form-control" placeholder="Opcional">
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<div class="table-wrap">
    <div class="table-header">
        <h2>📦 Inventário ({{ $itens->count() }} itens)</h2>
        <input type="text" id="stock-search" placeholder="Buscar item..."
               class="form-control" style="width:220px; padding:7px 12px; font-size:13px">
    </div>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantidade Atual</th>
                <th>Mínimo</th>
                <th>Unidade</th>
                <th>Fornecedor</th>
                <th>Sugestao</th>
                <th>Preço Unit.</th>
                <th>Status</th>
                <th>Ajuste</th>
            </tr>
        </thead>
        <tbody>
        @forelse($itens as $item)
        @php
            $alerta = $item->quantidade_atual <= $item->quantidade_minima;
            // Unidades de peso usam gramas/kg; resto usa unidade
            $unidadesPeso = ['kg', 'g', 'gramas', 'grama'];
            $unidadesVolume = ['l', 'ml', 'litro', 'litros'];
            $isPeso   = in_array(strtolower($item->unidade), $unidadesPeso);
            $isVolume = in_array(strtolower($item->unidade), $unidadesVolume);

            // Exibição inteligente
            if ($isPeso) {
                if ($item->quantidade_atual >= 1) {
                    $qtdDisplay = number_format($item->quantidade_atual, 3, ',', '.') . ' kg';
                    $minDisplay = number_format($item->quantidade_minima, 3, ',', '.') . ' kg';
                } else {
                    $qtdDisplay = number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' g';
                    $minDisplay = number_format($item->quantidade_minima * 1000, 0, ',', '.') . ' g';
                }
            } elseif ($isVolume) {
                if ($item->quantidade_atual >= 1) {
                    $qtdDisplay = number_format($item->quantidade_atual, 2, ',', '.') . ' L';
                    $minDisplay = number_format($item->quantidade_minima, 2, ',', '.') . ' L';
                } else {
                    $qtdDisplay = number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' mL';
                    $minDisplay = number_format($item->quantidade_minima * 1000, 0, ',', '.') . ' mL';
                }
            } else {
                $qtdDisplay = number_format($item->quantidade_atual, 0, ',', '.') . ' un';
                $minDisplay = number_format($item->quantidade_minima, 0, ',', '.') . ' un';
            }
            $ultimaCompra = $comprasRecentes->firstWhere('stock_item_id', $item->id);
            $sugestaoCompra = max(0, ($item->quantidade_minima * 2) - $item->quantidade_atual);
            $sugestaoDisplay = $isPeso
                ? number_format($sugestaoCompra, 3, ',', '.') . ' kg'
                : ($isVolume
                    ? number_format($sugestaoCompra, 2, ',', '.') . ' L'
                    : number_format($sugestaoCompra, 0, ',', '.') . ' un');
        @endphp
        <tr class="stock-row" data-nome="{{ strtolower($item->nome) }}">
            <td>
                <div class="td-primary" style="font-weight:600">{{ $item->nome }}</div>
            </td>
            <td>
                <span class="qtd-display {{ $alerta ? 'alerta' : 'ok' }}">
                    {{ $qtdDisplay }}
                </span>
            </td>
            <td style="color:var(--muted); font-family:monospace; font-size:13px">
                {{ $minDisplay }}
            </td>
            <td>
                <span class="unidade-badge">{{ $item->unidade }}</span>
            </td>
            <td style="color:var(--muted); font-size:12px">
                {{ $ultimaCompra?->fornecedor ?: '-' }}
            </td>
            <td>
                @if($sugestaoCompra > 0)
                    <span class="badge badge-warning">Comprar {{ $sugestaoDisplay }}</span>
                @else
                    <span class="badge badge-success">OK</span>
                @endif
            </td>
            <td class="td-mono">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
            <td>
                @if($item->quantidade_atual <= 0)
                    <span class="badge badge-danger">Esgotado</span>
                @elseif($alerta)
                    <span class="badge badge-warning">Estoque baixo</span>
                @else
                    <span class="badge badge-success">Normal</span>
                @endif
            </td>
            <td>
                <button class="btn btn-secondary btn-sm" onclick="toggleForm('form-{{ $item->id }}')">
                    ✏️ Ajustar
                </button>
                <div id="form-{{ $item->id }}" class="form-ajuste">
                    <form method="POST" action="{{ route('estoque.movimento', $item) }}"
                          style="display:flex; gap:8px; align-items:flex-end; flex-wrap:wrap">
                        @csrf
                        <div class="form-group" style="margin:0; min-width:100px">
                            <label style="font-size:10px; text-transform:uppercase; letter-spacing:.5px">Tipo</label>
                            <select name="tipo" class="form-select" style="font-size:12px; padding:7px 10px" required>
                                <option value="entrada">➕ Entrada</option>
                                <option value="saida">➖ Saída</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin:0; min-width:110px">
                            <label style="font-size:10px; text-transform:uppercase; letter-spacing:.5px">
                                Quantidade
                                @if($isPeso)
                                <span style="color:var(--accent)">(kg)</span>
                                @elseif($isVolume)
                                <span style="color:var(--accent)">(L)</span>
                                @else
                                <span style="color:var(--accent)">(un)</span>
                                @endif
                            </label>
                            <input type="number" name="quantidade"
                                   step="{{ $isPeso || $isVolume ? '0.001' : '1' }}"
                                   min="{{ $isPeso || $isVolume ? '0.001' : '1' }}"
                                   max="99999"
                                   class="form-control" style="font-size:12px; padding:7px 10px" required>
                        </div>
                        <div class="form-group" style="margin:0; flex:1; min-width:130px">
                            <label style="font-size:10px; text-transform:uppercase; letter-spacing:.5px">Motivo</label>
                            <input type="text" name="motivo" class="form-control"
                                   style="font-size:12px; padding:7px 10px" placeholder="Motivo...">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                        <button type="button" class="btn btn-secondary btn-sm"
                                onclick="toggleForm('form-{{ $item->id }}')">×</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="9">
            <div class="empty-state">📦<p>Nenhum item cadastrado</p></div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="history-grid">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fa-solid fa-receipt"></i> Compras recentes</div>
        </div>
        <div class="table-wrap" style="box-shadow:none; margin:0">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Qtd.</th>
                        <th>Fornecedor</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($comprasRecentes as $compra)
                    <tr>
                        <td>{{ $compra->stockItem?->nome ?? '-' }}</td>
                        <td>{{ number_format($compra->quantidade, 3, ',', '.') }}</td>
                        <td>{{ $compra->fornecedor ?: '-' }}</td>
                        <td class="td-mono">R$ {{ number_format($compra->total, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4"><div class="empty-state"><p>Nenhuma compra registrada</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fa-solid fa-clock-rotate-left"></i> Movimentações recentes</div>
        </div>
        <div class="table-wrap" style="box-shadow:none; margin:0">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Qtd.</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($movimentosRecentes as $movimento)
                    <tr>
                        <td>{{ $movimento->stockItem?->nome ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $movimento->tipo === 'entrada' ? 'badge-success' : 'badge-warning' }}">
                                {{ ucfirst($movimento->tipo) }}
                            </span>
                        </td>
                        <td>{{ number_format($movimento->quantidade, 3, ',', '.') }}</td>
                        <td style="color:var(--muted); font-size:12px">{{ $movimento->motivo ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4"><div class="empty-state"><p>Nenhuma movimentação registrada</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleForm(id) {
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
document.getElementById('stock-search').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.stock-row').forEach(row => {
        row.style.display = row.dataset.nome.includes(q) ? '' : 'none';
    });
});
</script>
@endsection
