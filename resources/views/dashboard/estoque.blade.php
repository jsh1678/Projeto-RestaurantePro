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
</style>
@endsection

@section('content')

@if($estoqueAlerta->isNotEmpty())
<div class="alert alert-warning">
    ⚠️ <span><strong>{{ $estoqueAlerta->count() }} item(s)</strong> abaixo do estoque mínimo — reposição necessária!</span>
</div>
@endif

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
        <tr><td colspan="7">
            <div class="empty-state">📦<p>Nenhum item cadastrado</p></div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
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
