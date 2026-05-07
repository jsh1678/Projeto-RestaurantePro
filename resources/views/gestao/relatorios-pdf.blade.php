<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Relatório de Gestão — {{ $inicio->format('d/m/Y') }} a {{ $fim->format('d/m/Y') }}</title>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family: Arial, sans-serif; font-size: 12px; color: #1a1a1a; background: #fff; }

  .header { background: #1a1a1a; color: #fff; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; }
  .header-title { font-size: 20px; font-weight: 800; }
  .header-sub { font-size: 12px; opacity: .7; margin-top: 4px; }
  .header-date { text-align: right; font-size: 13px; }

  .content { padding: 24px 30px; }

  .section { margin-bottom: 24px; }
  .section-title { font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #f97316; border-bottom: 2px solid #f97316; padding-bottom: 6px; margin-bottom: 14px; }

  .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
  .kpi { border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; border-top: 3px solid var(--c, #f97316); }
  .kpi-val { font-size: 20px; font-weight: 900; color: #1a1a1a; margin: 4px 0; }
  .kpi-lbl { font-size: 11px; color: #6b7280; }

  table { width: 100%; border-collapse: collapse; font-size: 12px; }
  thead th { background: #f3f4f6; padding: 8px 10px; text-align: left; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #6b7280; border-bottom: 2px solid #e5e7eb; }
  tbody td { padding: 8px 10px; border-bottom: 1px solid #f3f4f6; }
  tbody tr:hover td { background: #fafafa; }

  .badge { padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 700; }
  .badge-ok      { background: #dcfce7; color: #16a34a; }
  .badge-alerta  { background: #fef9c3; color: #b45309; }
  .badge-critico { background: #fee2e2; color: #dc2626; }

  .bar-wrap { background: #f3f4f6; border-radius: 4px; height: 8px; width: 100%; }
  .bar-fill  { height: 8px; border-radius: 4px; background: #f97316; }

  .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

  .footer { margin-top: 30px; padding: 12px 30px; background: #f9fafb; border-top: 1px solid #e5e7eb; font-size: 11px; color: #9ca3af; display: flex; justify-content: space-between; }

  .no-print { display: flex; justify-content: center; gap: 12px; padding: 16px; background: #1a1a1a; }
  .btn-print { padding: 10px 28px; background: #f97316; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; }
  .btn-close { padding: 10px 20px; background: #374151; color: #fff; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; }

  @media print {
    .no-print { display: none !important; }
    body { font-size: 11px; }
    .kpi-grid { grid-template-columns: repeat(4, 1fr); }
    .two-col  { grid-template-columns: 1fr 1fr; }
  }
</style>
</head>
<body>

{{-- Barra de ações (só aparece na tela) --}}
<div class="no-print" style="flex-direction:column; align-items:center; gap:16px; padding:20px">
    <div style="font-size:18px; font-weight:800; color:#fff; margin-bottom:4px">🖨️ Exportar PDF — Selecione as seções</div>

    {{-- Checkboxes de seções --}}
    <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center">
        <label style="color:#d1d5db; font-size:13px; display:flex; align-items:center; gap:6px; cursor:pointer">
            <input type="checkbox" id="chk-financeiro" checked onchange="toggleSection('sec-financeiro', this.checked)"> Resumo Financeiro
        </label>
        <label style="color:#d1d5db; font-size:13px; display:flex; align-items:center; gap:6px; cursor:pointer">
            <input type="checkbox" id="chk-itens" checked onchange="toggleSection('sec-itens', this.checked)"> Itens Vendidos
        </label>
        <label style="color:#d1d5db; font-size:13px; display:flex; align-items:center; gap:6px; cursor:pointer">
            <input type="checkbox" id="chk-equipe" checked onchange="toggleSection('sec-equipe', this.checked)"> Equipe
        </label>
        <label style="color:#d1d5db; font-size:13px; display:flex; align-items:center; gap:6px; cursor:pointer">
            <input type="checkbox" id="chk-vendas-dia" checked onchange="toggleSection('sec-vendas-dia', this.checked)"> Vendas por Dia
        </label>
        <label style="color:#d1d5db; font-size:13px; display:flex; align-items:center; gap:6px; cursor:pointer">
            <input type="checkbox" id="chk-estoque" checked onchange="toggleSection('sec-estoque', this.checked)"> Estoque Crítico
        </label>
    </div>

    <div style="display:flex; gap:12px">
        <button class="btn-print" onclick="window.print()">🖨️ Imprimir / Salvar PDF</button>
        <button onclick="selectAll(true)"  style="padding:10px 16px; background:#374151; color:#fff; border:none; border-radius:8px; font-size:13px; cursor:pointer">✅ Selecionar Tudo</button>
        <button onclick="selectAll(false)" style="padding:10px 16px; background:#374151; color:#fff; border:none; border-radius:8px; font-size:13px; cursor:pointer">☐ Desmarcar Tudo</button>
        <button class="btn-close" onclick="window.close()">✕ Fechar</button>
    </div>
</div>

<script>
function toggleSection(id, visible) {
    const el = document.getElementById(id);
    if (el) el.style.display = visible ? '' : 'none';
}
function selectAll(val) {
    ['financeiro','itens','equipe','vendas-dia','estoque'].forEach(s => {
        const chk = document.getElementById('chk-' + s);
        if (chk) { chk.checked = val; toggleSection('sec-' + s, val); }
    });
}
</script>

{{-- Cabeçalho --}}
<div class="header">
    <div>
        <div class="header-title">🍳 RestaurantePRO — Relatório de Gestão</div>
        <div class="header-sub">Período: {{ $inicio->format('d/m/Y') }} a {{ $fim->format('d/m/Y') }}</div>
    </div>
    <div class="header-date">
        Gerado em {{ now()->format('d/m/Y H:i') }}<br>
        por {{ Auth::user()->name }}
    </div>
</div>

<div class="content">

    {{-- KPIs principais --}}
    <div class="section" id="sec-financeiro">
        <div class="section-title">📊 Resumo Financeiro</div>
        <div class="kpi-grid">
            <div class="kpi" style="--c:#22c55e">
                <div class="kpi-lbl">Faturamento</div>
                <div class="kpi-val">R$ {{ number_format($totalVendas,2,',','.') }}</div>
                <div class="kpi-lbl">{{ $totalPedidos }} pedidos</div>
            </div>
            <div class="kpi" style="--c:#3b82f6">
                <div class="kpi-lbl">Ticket Médio</div>
                <div class="kpi-val">R$ {{ number_format($ticketMedio,2,',','.') }}</div>
                <div class="kpi-lbl">por pagamento</div>
            </div>
            <div class="kpi" style="--c:#ef4444">
                <div class="kpi-lbl">Custo Insumos</div>
                <div class="kpi-val">R$ {{ number_format($custoInsumos,2,',','.') }}</div>
                <div class="kpi-lbl">margem {{ $margemBruta }}%</div>
            </div>
            <div class="kpi" style="--c:{{ $lucro >= 0 ? '#4ade80' : '#f87171' }}">
                <div class="kpi-lbl">Lucro Estimado</div>
                <div class="kpi-val" style="color:{{ $lucro >= 0 ? '#16a34a' : '#dc2626' }}">R$ {{ number_format($lucro,2,',','.') }}</div>
                <div class="kpi-lbl">vendas − custos − sangrias</div>
            </div>
        </div>
        <div class="kpi-grid">
            <div class="kpi" style="--c:#f97316">
                <div class="kpi-lbl">Sangrias</div>
                <div class="kpi-val">R$ {{ number_format($totalSangrias,2,',','.') }}</div>
                <div class="kpi-lbl">retiradas do caixa</div>
            </div>
            <div class="kpi" style="--c:#ef4444">
                <div class="kpi-lbl">Cancelamentos</div>
                <div class="kpi-val">{{ $cancelamentos }}</div>
                <div class="kpi-lbl">taxa {{ $taxaCancelamento }}%</div>
            </div>
            @foreach($porMetodo as $metodo => $dados)
            @php $labels = ['dinheiro'=>'💵 Dinheiro','pix'=>'📱 Pix','cartao_debito'=>'💳 Débito','cartao_credito'=>'💳 Crédito']; @endphp
            <div class="kpi" style="--c:#a855f7">
                <div class="kpi-lbl">{{ $labels[$metodo] ?? $metodo }}</div>
                <div class="kpi-val">R$ {{ number_format($dados['total'],2,',','.') }}</div>
                <div class="kpi-lbl">{{ $dados['qtd'] }} pagamento(s)</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="two-col" id="sec-cols">

        {{-- Itens mais vendidos --}}
        <div class="section" id="sec-itens">
            <div class="section-title">🏆 Top 10 Itens Vendidos</div>
            @php $maxI = $itensMaisVendidos->max('quantidade') ?: 1; @endphp
            <table>
                <thead><tr><th>#</th><th>Item</th><th>Qtd</th><th>Receita</th><th>Participação</th></tr></thead>
                <tbody>
                @foreach($itensMaisVendidos as $i => $item)
                <tr>
                    <td style="font-weight:700; color:#f97316">{{ $i+1 }}</td>
                    <td style="font-weight:600">{{ $item['nome'] }}</td>
                    <td>{{ $item['quantidade'] }}×</td>
                    <td>R$ {{ number_format($item['receita'],2,',','.') }}</td>
                    <td>
                        <div class="bar-wrap"><div class="bar-fill" style="width:{{ ($item['quantidade']/$maxI)*100 }}%"></div></div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Desempenho garçons --}}
        <div class="section" id="sec-equipe">
            <div class="section-title">👨‍🍳 Desempenho da Equipe</div>
            <table>
                <thead><tr><th>#</th><th>Funcionário</th><th>Pedidos</th><th>Total</th></tr></thead>
                <tbody>
                @foreach($desempenhoGarcom as $i => $g)
                <tr>
                    <td style="font-weight:700; color:#f97316">{{ $i+1 }}</td>
                    <td style="font-weight:600">{{ $g['nome'] }}</td>
                    <td>{{ $g['pedidos'] }}</td>
                    <td style="font-weight:700">R$ {{ number_format($g['total'],2,',','.') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Vendas por dia --}}
    @if($vendasDia->isNotEmpty())
    <div class="section" id="sec-vendas-dia">
        <div class="section-title">📈 Vendas por Dia</div>
        <table>
            <thead><tr>
                @foreach($vendasDia as $dia => $v)<th style="text-align:center">{{ $dia }}</th>@endforeach
            </tr></thead>
            <tbody><tr>
                @foreach($vendasDia as $dia => $v)
                <td style="text-align:center; font-weight:700">R$ {{ number_format($v,0,',','.') }}</td>
                @endforeach
            </tr></tbody>
        </table>
    </div>
    @endif

    {{-- Estoque crítico --}}
    @if($estoqueAlerta->isNotEmpty())
    <div class="section" id="sec-estoque">
        <div class="section-title">⚠️ Estoque Crítico</div>
        <table>
            <thead><tr><th>Produto</th><th>Atual</th><th>Mínimo</th><th>Unidade</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($estoqueAlerta as $e)
            <tr>
                <td style="font-weight:600">{{ $e->nome }}</td>
                <td style="color:{{ $e->quantidade_atual <= 0 ? '#dc2626' : '#b45309' }}; font-weight:700">{{ number_format($e->quantidade_atual,3,',','.') }}</td>
                <td>{{ number_format($e->quantidade_minima,3,',','.') }}</td>
                <td>{{ $e->unidade }}</td>
                <td>
                    @if($e->quantidade_atual <= 0)
                        <span class="badge badge-critico">Esgotado</span>
                    @else
                        <span class="badge badge-alerta">Estoque baixo</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>

<div class="footer">
    <span>RestaurantePRO — Sistema de Gestão</span>
    <span>Relatório gerado em {{ now()->format('d/m/Y \à\s H:i:s') }}</span>
</div>

</body>
</html>
