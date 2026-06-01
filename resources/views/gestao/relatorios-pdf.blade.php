<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relat&oacute;rio de Gest&atilde;o - {{ $inicio->format('d/m/Y') }} a {{ $fim->format('d/m/Y') }}</title>
<style>
  @page {
    size: A4;
    margin: 13mm 11mm 15mm;
  }

  * { box-sizing: border-box; }

  body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    color: #1f2937;
    background: #eef0f3;
    font-size: 11px;
    line-height: 1.45;
  }

  .toolbar {
    position: sticky;
    top: 0;
    z-index: 10;
    background: #111827;
    color: #f9fafb;
    padding: 18px;
    box-shadow: 0 14px 34px rgba(15,23,42,.22);
  }

  .toolbar-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 18px;
    align-items: center;
  }

  .toolbar-title {
    font-size: 18px;
    font-weight: 800;
    letter-spacing: -.02em;
  }

  .toolbar-sub {
    margin-top: 4px;
    color: #9ca3af;
    font-size: 12px;
  }

  .section-picker {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 14px;
  }

  .section-picker label {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 10px;
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 999px;
    background: rgba(255,255,255,.06);
    color: #e5e7eb;
    cursor: pointer;
    user-select: none;
    font-size: 12px;
  }

  .section-picker input { accent-color: #f97316; }

  .toolbar-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: flex-end;
  }

  .toolbar button {
    border: 0;
    border-radius: 12px;
    padding: 10px 16px;
    color: #fff;
    font-weight: 800;
    cursor: pointer;
  }

  .btn-print { background: #f97316; }
  .btn-neutral { background: #374151; }

  .sheet {
    width: min(1100px, calc(100% - 32px));
    margin: 24px auto;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 24px 70px rgba(15,23,42,.16);
  }

  .cover {
    padding: 30px 34px 24px;
    color: #fff;
    background: linear-gradient(135deg, #111827 0%, #25140a 58%, #f97316 170%);
    position: relative;
  }

  .cover::after {
    content: "";
    position: absolute;
    inset: auto 34px 0;
    height: 4px;
    background: #f97316;
    border-radius: 999px 999px 0 0;
  }

  .brand-row {
    display: table;
    width: 100%;
  }

  .brand-main,
  .brand-meta {
    display: table-cell;
    vertical-align: top;
  }

  .brand-meta { text-align: right; width: 34%; }

  .brand-kicker {
    color: #fdba74;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.8px;
    text-transform: uppercase;
    margin-bottom: 9px;
  }

  .brand-title {
    font-size: 27px;
    font-weight: 900;
    letter-spacing: -.03em;
  }

  .brand-subtitle {
    margin-top: 8px;
    color: rgba(255,255,255,.72);
    font-size: 12px;
  }

  .meta-card {
    display: inline-block;
    min-width: 210px;
    padding: 13px 15px;
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 14px;
    background: rgba(255,255,255,.07);
    text-align: left;
  }

  .meta-label {
    color: #fdba74;
    font-size: 9px;
    text-transform: uppercase;
    font-weight: 800;
    letter-spacing: 1px;
  }

  .meta-value {
    margin-top: 3px;
    font-size: 12px;
    font-weight: 700;
    color: #fff;
  }

  .content { padding: 26px 34px 30px; }

  .section {
    margin-bottom: 24px;
    page-break-inside: avoid;
  }

  .section-title {
    display: table;
    width: 100%;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e5e7eb;
  }

  .section-title span {
    display: table-cell;
    color: #111827;
    font-size: 13px;
    font-weight: 900;
    letter-spacing: .9px;
    text-transform: uppercase;
  }

  .section-title small {
    display: table-cell;
    color: #9ca3af;
    text-align: right;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
  }

  .kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 12px;
  }

  .kpi {
    min-height: 92px;
    padding: 13px;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    border-top: 4px solid var(--c, #f97316);
    background: #fff;
  }

  .kpi-lbl {
    color: #6b7280;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .6px;
    text-transform: uppercase;
  }

  .kpi-val {
    margin: 8px 0 6px;
    color: #111827;
    font-size: 20px;
    font-weight: 900;
    line-height: 1.05;
    letter-spacing: -.03em;
  }

  .two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
  }

  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 10.5px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
  }

  thead th {
    background: #f8fafc;
    color: #64748b;
    padding: 8px 9px;
    text-align: left;
    font-size: 9px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .7px;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
  }

  tbody td {
    padding: 8px 9px;
    border-bottom: 1px solid #edf2f7;
    vertical-align: middle;
  }

  tbody tr:nth-child(even) td { background: #fcfcfd; }
  tbody tr:last-child td { border-bottom: 0; }

  .rank {
    color: #f97316;
    font-weight: 900;
  }

  .money,
  .num {
    font-weight: 800;
    white-space: nowrap;
  }

  .muted { color: #6b7280; }

  .badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 999px;
    font-size: 9px;
    font-weight: 900;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .badge-ok      { background: #dcfce7; color: #15803d; }
  .badge-alerta  { background: #fef3c7; color: #b45309; }
  .badge-critico { background: #fee2e2; color: #dc2626; }

  .bar-wrap {
    height: 7px;
    min-width: 82px;
    background: #e5e7eb;
    border-radius: 999px;
    overflow: hidden;
  }

  .bar-fill {
    height: 7px;
    border-radius: 999px;
    background: linear-gradient(90deg, #f97316, #fb923c);
  }

  .sales-days {
    table-layout: fixed;
    font-size: 9.5px;
  }

  .sales-days th,
  .sales-days td {
    text-align: center;
    padding-left: 5px;
    padding-right: 5px;
  }

  .footer {
    display: table;
    width: 100%;
    padding: 14px 34px;
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    color: #64748b;
    font-size: 10px;
  }

  .footer span {
    display: table-cell;
  }

  .footer span:last-child {
    text-align: right;
  }

  .empty-note {
    padding: 15px;
    border: 1px dashed #d1d5db;
    border-radius: 12px;
    color: #6b7280;
    background: #f9fafb;
  }

  @media print {
    body {
      background: #fff;
      color: #111827;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .toolbar { display: none !important; }
    .sheet {
      width: 100%;
      margin: 0;
      border-radius: 0;
      box-shadow: none;
    }

    .cover { padding: 24px 26px 20px; }
    .content { padding: 22px 26px 24px; }
    .footer { padding: 11px 26px; }
    .section { page-break-inside: avoid; break-inside: avoid; }
    table { page-break-inside: auto; }
    tr { page-break-inside: avoid; page-break-after: auto; }
  }

  @media (max-width: 760px) {
    .toolbar-inner { grid-template-columns: 1fr; }
    .toolbar-actions { justify-content: flex-start; }
    .sheet { width: 100%; margin: 0; border-radius: 0; }
    .brand-main, .brand-meta { display: block; width: 100%; text-align: left; }
    .brand-meta { margin-top: 16px; }
    .kpi-grid, .two-col { grid-template-columns: 1fr; }
    .content, .cover, .footer { padding-left: 18px; padding-right: 18px; }
  }
</style>
</head>
<body>

<div class="toolbar">
  <div class="toolbar-inner">
    <div>
      <div class="toolbar-title">Exportar relat&oacute;rio em PDF</div>
      <div class="toolbar-sub">Escolha as se&ccedil;&otilde;es que v&atilde;o aparecer antes de imprimir ou salvar.</div>
      <div class="section-picker">
        <label><input type="checkbox" id="chk-financeiro" checked onchange="toggleSection('sec-financeiro', this.checked)"> Resumo financeiro</label>
        <label><input type="checkbox" id="chk-itens" checked onchange="toggleSection('sec-itens', this.checked)"> Itens vendidos</label>
        <label><input type="checkbox" id="chk-equipe" checked onchange="toggleSection('sec-equipe', this.checked)"> Equipe</label>
        <label><input type="checkbox" id="chk-vendas-dia" checked onchange="toggleSection('sec-vendas-dia', this.checked)"> Vendas por dia</label>
        <label><input type="checkbox" id="chk-estoque" checked onchange="toggleSection('sec-estoque', this.checked)"> Estoque cr&iacute;tico</label>
      </div>
    </div>
    <div class="toolbar-actions">
      <button class="btn-print" onclick="window.print()">Imprimir / Salvar PDF</button>
      <button class="btn-neutral" onclick="selectAll(true)">Selecionar tudo</button>
      <button class="btn-neutral" onclick="selectAll(false)">Desmarcar</button>
      <button class="btn-neutral" onclick="window.close()">Fechar</button>
    </div>
  </div>
</div>

<main class="sheet">
  <header class="cover">
    <div class="brand-row">
      <div class="brand-main">
        <div class="brand-kicker">RestaurantePRO</div>
        <div class="brand-title">Relat&oacute;rio de Gest&atilde;o</div>
        <div class="brand-subtitle">An&aacute;lise operacional e financeira do per&iacute;odo selecionado.</div>
      </div>
      <div class="brand-meta">
        <div class="meta-card">
          <div class="meta-label">Per&iacute;odo</div>
          <div class="meta-value">{{ $inicio->format('d/m/Y') }} a {{ $fim->format('d/m/Y') }}</div>
          <div style="height:10px"></div>
          <div class="meta-label">Gerado em</div>
          <div class="meta-value">{{ now()->format('d/m/Y H:i') }}</div>
          <div style="height:10px"></div>
          <div class="meta-label">Respons&aacute;vel</div>
          <div class="meta-value">{{ Auth::user()?->name ?? 'Sistema' }}</div>
        </div>
      </div>
    </div>
  </header>

  <div class="content">
    <section class="section" id="sec-financeiro">
      <div class="section-title">
        <span>Resumo financeiro</span>
        <small>{{ $totalPedidos }} pedido(s)</small>
      </div>

      <div class="kpi-grid">
        <div class="kpi" style="--c:#22c55e">
          <div class="kpi-lbl">Faturamento</div>
          <div class="kpi-val">R$ {{ number_format($totalVendas,2,',','.') }}</div>
          <div class="kpi-lbl">{{ $totalPedidos }} pedido(s)</div>
        </div>
        <div class="kpi" style="--c:#3b82f6">
          <div class="kpi-lbl">Ticket m&eacute;dio</div>
          <div class="kpi-val">R$ {{ number_format($ticketMedio,2,',','.') }}</div>
          <div class="kpi-lbl">por pagamento</div>
        </div>
        <div class="kpi" style="--c:#ef4444">
          <div class="kpi-lbl">Custo de insumos</div>
          <div class="kpi-val">R$ {{ number_format($custoInsumos,2,',','.') }}</div>
          <div class="kpi-lbl">margem {{ $margemBruta }}%</div>
        </div>
        <div class="kpi" style="--c:{{ $lucro >= 0 ? '#22c55e' : '#ef4444' }}">
          <div class="kpi-lbl">Lucro estimado</div>
          <div class="kpi-val" style="color:{{ $lucro >= 0 ? '#15803d' : '#dc2626' }}">R$ {{ number_format($lucro,2,',','.') }}</div>
          <div class="kpi-lbl">vendas - custos - sangrias</div>
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
          @php $labels = ['dinheiro'=>'Dinheiro','pix'=>'Pix','cartao_debito'=>'Cartao de debito','cartao_credito'=>'Cartao de credito']; @endphp
          <div class="kpi" style="--c:#a855f7">
            <div class="kpi-lbl">{{ $labels[$metodo] ?? $metodo }}</div>
            <div class="kpi-val">R$ {{ number_format($dados['total'],2,',','.') }}</div>
            <div class="kpi-lbl">{{ $dados['qtd'] }} pagamento(s)</div>
          </div>
        @endforeach
      </div>
    </section>

    <div class="two-col">
      <section class="section" id="sec-itens">
        <div class="section-title">
          <span>Top itens vendidos</span>
          <small>ranking</small>
        </div>
        @if($itensMaisVendidos->isEmpty())
          <div class="empty-note">Nenhum item vendido no per&iacute;odo.</div>
        @else
          @php $maxI = $itensMaisVendidos->max('quantidade') ?: 1; @endphp
          <table>
            <thead><tr><th>#</th><th>Item</th><th>Qtd</th><th>Receita</th><th>Participa&ccedil;&atilde;o</th></tr></thead>
            <tbody>
              @foreach($itensMaisVendidos as $i => $item)
              <tr>
                <td class="rank">{{ $i+1 }}</td>
                <td><strong>{{ $item['nome'] }}</strong></td>
                <td class="num">{{ $item['quantidade'] }}x</td>
                <td class="money">R$ {{ number_format($item['receita'],2,',','.') }}</td>
                <td><div class="bar-wrap"><div class="bar-fill" style="width:{{ ($item['quantidade']/$maxI)*100 }}%"></div></div></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </section>

      <section class="section" id="sec-equipe">
        <div class="section-title">
          <span>Desempenho da equipe</span>
          <small>atendimento</small>
        </div>
        @if($desempenhoGarcom->isEmpty())
          <div class="empty-note">Nenhum pedido registrado no per&iacute;odo.</div>
        @else
          <table>
            <thead><tr><th>#</th><th>Funcion&aacute;rio</th><th>Pedidos</th><th>Total</th></tr></thead>
            <tbody>
              @foreach($desempenhoGarcom as $i => $g)
              <tr>
                <td class="rank">{{ $i+1 }}</td>
                <td><strong>{{ $g['nome'] }}</strong></td>
                <td class="num">{{ $g['pedidos'] }}</td>
                <td class="money">R$ {{ number_format($g['total'],2,',','.') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </section>
    </div>

    @if($vendasDia->isNotEmpty())
      <section class="section" id="sec-vendas-dia">
        <div class="section-title">
          <span>Vendas por dia</span>
          <small>evolu&ccedil;&atilde;o</small>
        </div>
        <table class="sales-days">
          <thead><tr>
            @foreach($vendasDia as $dia => $v)<th>{{ $dia }}</th>@endforeach
          </tr></thead>
          <tbody><tr>
            @foreach($vendasDia as $dia => $v)<td class="money">R$ {{ number_format($v,0,',','.') }}</td>@endforeach
          </tr></tbody>
        </table>
      </section>
    @endif

    @if($estoqueAlerta->isNotEmpty())
      <section class="section" id="sec-estoque">
        <div class="section-title">
          <span>Estoque cr&iacute;tico</span>
          <small>{{ $estoqueAlerta->count() }} item(ns)</small>
        </div>
        <table>
          <thead><tr><th>Produto</th><th>Atual</th><th>M&iacute;nimo</th><th>Unidade</th><th>Status</th></tr></thead>
          <tbody>
            @foreach($estoqueAlerta as $e)
            <tr>
              <td><strong>{{ $e->nome }}</strong></td>
              <td class="num" style="color:{{ $e->quantidade_atual <= 0 ? '#dc2626' : '#b45309' }}">{{ number_format($e->quantidade_atual,3,',','.') }}</td>
              <td class="num">{{ number_format($e->quantidade_minima,3,',','.') }}</td>
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
      </section>
    @endif
  </div>

  <footer class="footer">
    <span>RestaurantePRO - Sistema de Gest&atilde;o</span>
    <span>Relat&oacute;rio gerado em {{ now()->format('d/m/Y \a\s H:i:s') }}</span>
  </footer>
</main>

<script>
function toggleSection(id, visible) {
  const el = document.getElementById(id);
  if (el) el.style.display = visible ? '' : 'none';
}

function selectAll(val) {
  ['financeiro','itens','equipe','vendas-dia','estoque'].forEach(function(section) {
    const chk = document.getElementById('chk-' + section);
    if (chk) {
      chk.checked = val;
      toggleSection('sec-' + section, val);
    }
  });
}
</script>
</body>
</html>
