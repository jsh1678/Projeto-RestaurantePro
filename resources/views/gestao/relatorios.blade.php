@extends('layouts.app')
@section('page-title', 'Relatórios de Gestão')
@section('breadcrumb', 'Análise completa do negócio')

@section('styles')
<style>
.rel-kpi { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:14px; margin-bottom:22px; }
.kpi-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:16px; position:relative; overflow:hidden; }
.kpi-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--kc,var(--accent)); }
.kpi-val  { font-size:22px; font-weight:900; color:#fff; margin:4px 0; }
.kpi-lbl  { font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:.5px; }
.kpi-sub  { font-size:11px; color:var(--muted); margin-top:2px; }
.rank-bar-bg { height:6px; background:rgba(255,255,255,.06); border-radius:3px; margin-top:5px; }
.rank-bar    { height:100%; background:var(--accent); border-radius:3px; }
.sec-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:18px; }
.chart-bars { display:flex; align-items:flex-end; gap:3px; height:80px; margin-top:10px; }
.chart-bar-c { flex:1; display:flex; flex-direction:column; align-items:center; gap:3px; }
.chart-bar-c .bar { width:100%; border-radius:3px 3px 0 0; min-height:3px; }
.chart-bar-c .lbl { font-size:8px; color:var(--muted); }
.abc-a { color:#4ade80; } .abc-b { color:#fbbf24; } .abc-c { color:#f87171; }
.tab-btns { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:18px; }
.tab-btn  { padding:6px 14px; border-radius:8px; border:1px solid var(--border); background:var(--bg2); color:var(--muted); font-size:12px; font-weight:700; cursor:pointer; transition:.15s; }
.tab-btn.on { background:rgba(249,115,22,.12); color:var(--accent); border-color:rgba(249,115,22,.3); }
.tab-sec { display:none; } .tab-sec.on { display:block; }
</style>
@endsection

@section('content')
{{-- Filtro --}}
<div class="panel" style="margin-bottom:20px">
    <form method="GET" style="display:flex;gap:14px;align-items:flex-end;flex-wrap:wrap">
        <div class="form-group" style="margin:0;flex:1;min-width:150px"><label>Início</label><input type="date" name="data_inicio" class="form-control" value="{{ $di->format('Y-m-d') }}" max="2026-12-31" oninput="limitarAno(this)"></div>
        <div class="form-group" style="margin:0;flex:1;min-width:150px"><label>Fim</label><input type="date" name="data_fim" class="form-control" value="{{ $df->format('Y-m-d') }}" max="2026-12-31" oninput="limitarAno(this)"></div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrar</button>
        <a href="{{ route('gestao.relatorios') }}" class="btn btn-secondary">Últimos 30 dias</a>
        <a href="{{ route('gestao.relatorios.pdf', ['inicio' => $di->format('Y-m-d'), 'fim' => $df->format('Y-m-d')]) }}"
           target="_blank" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </form>
</div>

{{-- KPIs --}}
<div class="rel-kpi">
    <div class="kpi-card" style="--kc:#22c55e"><div class="kpi-lbl">💰 Faturamento</div><div class="kpi-val">R$ {{ number_format($totalVendas,2,',','.') }}</div><div class="kpi-sub">Período selecionado</div></div>
    <div class="kpi-card" style="--kc:#ef4444"><div class="kpi-lbl">🛒 Custos</div><div class="kpi-val">R$ {{ number_format($totalCompras,2,',','.') }}</div><div class="kpi-sub">Compras de insumos</div></div>
    <div class="kpi-card" style="--kc:{{ $lucro>=0?'#4ade80':'#f87171' }}"><div class="kpi-lbl">📈 Lucro Est.</div><div class="kpi-val" style="color:{{ $lucro>=0?'#4ade80':'#f87171' }}">R$ {{ number_format($lucro,2,',','.') }}</div><div class="kpi-sub">Vendas − custos − sangrias</div></div>
    <div class="kpi-card" style="--kc:#a855f7"><div class="kpi-lbl">🎯 Ticket Médio</div><div class="kpi-val">R$ {{ number_format($ticketMedio,2,',','.') }}</div><div class="kpi-sub">Por pagamento</div></div>
    <div class="kpi-card" style="--kc:#3b82f6"><div class="kpi-lbl">🧾 Pedidos</div><div class="kpi-val">{{ $totalPedidos }}</div><div class="kpi-sub">{{ $totalCancelados }} cancelado(s)</div></div>
    <div class="kpi-card" style="--kc:#f97316"><div class="kpi-lbl">⏱️ Tempo Médio</div><div class="kpi-val">{{ $tempoMedio }}min</div><div class="kpi-sub">Min: {{ $tempoMin }}m · Max: {{ $tempoMax }}m</div></div>
    <div class="kpi-card" style="--kc:#22c55e"><div class="kpi-lbl">😊 Satisfação</div><div class="kpi-val">{{ $satisfacao }}%</div><div class="kpi-sub">{{ $pedidosEntregues }} pedidos pagos</div></div>
    <div class="kpi-card" style="--kc:#ef4444"><div class="kpi-lbl">❌ Cancelamentos</div><div class="kpi-val">{{ $taxaCancelamento }}%</div><div class="kpi-sub">{{ $totalCancelados }} de {{ $totalPedidos }}</div></div>
</div>

{{-- Tabs de relatórios --}}
<div class="tab-btns">
    <button class="tab-btn on" onclick="showTab('vendas',this)">📈 Vendas</button>
    <button class="tab-btn" onclick="showTab('desempenho',this)">👨‍🍳 Desempenho</button>
    <button class="tab-btn" onclick="showTab('itens',this)">🏆 Itens Vendidos</button>
    <button class="tab-btn" onclick="showTab('picos',this)">⏰ Picos de Venda</button>
    <button class="tab-btn" onclick="showTab('custos',this)">💸 Custo Insumos</button>
    <button class="tab-btn" onclick="showTab('desperdicio',this)">🗑️ Desperdício</button>
    <button class="tab-btn" onclick="showTab('abc',this)">📦 Estoque ABC</button>
    <button class="tab-btn" onclick="showTab('previsao',this)">🤖 Previsão</button>
</div>

{{-- Vendas por dia --}}
<div class="tab-sec on" id="tab-vendas">
    <div class="panel">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-chart-bar"></i> Vendas por Dia</div><span style="font-size:12px;color:var(--muted)">R$ {{ number_format($totalVendas,2,',','.') }} total</span></div>
        @if($vendasPorDia->isEmpty()) <div class="empty-state"><p>Sem dados</p></div>
        @else
        @php $maxV = $vendasPorDia->max('total') ?: 1; @endphp
        <div class="chart-bars">
            @foreach($vendasPorDia as $dia => $d)
            <div class="chart-bar-c">
                <div class="bar" style="height:{{ ($d['total']/$maxV)*70 }}px;background:rgba(249,115,22,.6)" title="{{ $dia }}: R$ {{ number_format($d['total'],2,',','.') }}"></div>
                <div class="lbl">{{ $dia }}</div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:16px">
        <table><thead><tr><th>Dia</th><th>Faturamento</th><th>Qtd Pagamentos</th></tr></thead><tbody>
        @foreach($vendasPorDia->sortKeysDesc() as $dia => $d)
        <tr><td class="td-mono">{{ $dia }}</td><td class="td-mono" style="color:#4ade80;font-weight:700">R$ {{ number_format($d['total'],2,',','.') }}</td><td style="color:var(--muted)">{{ $d['qtd'] }}</td></tr>
        @endforeach
        </tbody></table>
        </div>
        @endif
    </div>
</div>

{{-- Desempenho garçons --}}
<div class="tab-sec" id="tab-desempenho">
    <div class="panel">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-users"></i> Desempenho por Garçom</div></div>
        @if($desempenhoGarcom->isEmpty()) <div class="empty-state"><p>Sem dados</p></div>
        @else
        @php $maxG = $desempenhoGarcom->max('total') ?: 1; @endphp
        <table><thead><tr><th>Garçom</th><th>Pedidos</th><th>Faturamento</th><th>Distribuição</th></tr></thead><tbody>
        @foreach($desempenhoGarcom as $g)
        <tr>
            <td class="td-primary">{{ $g['nome'] }}</td>
            <td style="color:var(--muted)">{{ $g['pedidos'] }}</td>
            <td class="td-mono" style="color:#4ade80;font-weight:700">R$ {{ number_format($g['total'],2,',','.') }}</td>
            <td style="min-width:120px"><div class="rank-bar-bg"><div class="rank-bar" style="width:{{ ($g['total']/$maxG)*100 }}%"></div></div></td>
        </tr>
        @endforeach
        </tbody></table>
        @endif
    </div>
</div>

{{-- Itens mais vendidos --}}
<div class="tab-sec" id="tab-itens">
    <div class="panel">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-trophy"></i> Itens Mais Vendidos</div></div>
        @if($itensMaisVendidos->isEmpty()) <div class="empty-state"><p>Sem dados</p></div>
        @else
        @php $maxI = $itensMaisVendidos->max('qtd') ?: 1; @endphp
        <table><thead><tr><th>#</th><th>Item</th><th>Qtd Vendida</th><th>Receita</th><th>Distribuição</th></tr></thead><tbody>
        @foreach($itensMaisVendidos as $i => $item)
        <tr>
            <td class="td-mono" style="color:var(--accent)">{{ $i+1 }}</td>
            <td class="td-primary">{{ $item['nome'] }}</td>
            <td class="td-mono" style="font-weight:700">{{ $item['qtd'] }}×</td>
            <td class="td-mono" style="color:#4ade80">R$ {{ number_format($item['receita'],2,',','.') }}</td>
            <td style="min-width:120px"><div class="rank-bar-bg"><div class="rank-bar" style="width:{{ ($item['qtd']/$maxI)*100 }}%"></div></div></td>
        </tr>
        @endforeach
        </tbody></table>
        @endif
    </div>
</div>

{{-- Picos de venda por hora --}}
<div class="tab-sec" id="tab-picos">
    <div class="panel">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-clock"></i> Picos de Venda por Hora</div></div>
        @if($picosPorHora->isEmpty()) <div class="empty-state"><p>Sem dados</p></div>
        @else
        @php $maxP = $picosPorHora->max('total') ?: 1; @endphp
        <div class="chart-bars" style="height:100px">
            @foreach($picosPorHora as $hora => $d)
            <div class="chart-bar-c">
                <div class="bar" style="height:{{ ($d['total']/$maxP)*90 }}px;background:rgba(59,130,246,.6)" title="{{ $hora }}: R$ {{ number_format($d['total'],2,',','.') }}"></div>
                <div class="lbl">{{ $hora }}</div>
            </div>
            @endforeach
        </div>
        <table style="margin-top:16px"><thead><tr><th>Hora</th><th>Faturamento</th><th>Qtd</th></tr></thead><tbody>
        @foreach($picosPorHora->sortByDesc('total')->take(5) as $hora => $d)
        <tr><td class="td-mono" style="color:var(--accent)">{{ $hora }}</td><td class="td-mono" style="color:#4ade80;font-weight:700">R$ {{ number_format($d['total'],2,',','.') }}</td><td style="color:var(--muted)">{{ $d['qtd'] }}</td></tr>
        @endforeach
        </tbody></table>
        @endif
    </div>
</div>

{{-- Custo de insumos --}}
<div class="tab-sec" id="tab-custos">
    <div class="panel">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-coins"></i> Custo de Insumos (Compras)</div><span style="font-size:12px;color:var(--muted)">Total: R$ {{ number_format($totalCompras,2,',','.') }}</span></div>
        @if($custoInsumos->isEmpty()) <div class="empty-state"><p>Sem compras no período</p></div>
        @else
        <table><thead><tr><th>Insumo</th><th>Qtd Comprada</th><th>Custo Total</th><th>% do Custo</th></tr></thead><tbody>
        @foreach($custoInsumos as $c)
        @php $pct = $totalCompras > 0 ? round($c['total']/$totalCompras*100,1) : 0; @endphp
        <tr>
            <td class="td-primary">{{ $c['nome'] }}</td>
            <td class="td-mono" style="color:var(--muted)">{{ number_format($c['qtd'],3,',','.') }}</td>
            <td class="td-mono" style="color:#f87171;font-weight:700">R$ {{ number_format($c['total'],2,',','.') }}</td>
            <td><div style="display:flex;align-items:center;gap:8px"><div class="rank-bar-bg" style="flex:1"><div class="rank-bar" style="width:{{ $pct }}%;background:#ef4444"></div></div><span style="font-size:11px;color:var(--muted)">{{ $pct }}%</span></div></td>
        </tr>
        @endforeach
        </tbody></table>
        @endif
    </div>
</div>

{{-- Desperdício --}}
<div class="tab-sec" id="tab-desperdicio">
    <div class="panel">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-trash-alt"></i> Desperdício (Pedidos Cancelados)</div><span class="badge badge-danger">{{ $totalCancelados }} pedido(s)</span></div>
        @if($itensCancelados->isEmpty()) <div class="empty-state" style="padding:30px"><p>Nenhum cancelamento no período 👍</p></div>
        @else
        <table><thead><tr><th>Item</th><th>Qtd Cancelada</th><th>Valor Perdido</th></tr></thead><tbody>
        @foreach($itensCancelados as $ic)
        <tr>
            <td class="td-primary">{{ $ic['nome'] }}</td>
            <td class="td-mono" style="color:#fbbf24">{{ $ic['qtd'] }}×</td>
            <td class="td-mono" style="color:#f87171;font-weight:700">R$ {{ number_format($ic['valor'],2,',','.') }}</td>
        </tr>
        @endforeach
        </tbody></table>
        @endif
    </div>
</div>

{{-- Estoque ABC --}}
<div class="tab-sec" id="tab-abc">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-layer-group"></i> Classificação ABC do Estoque</div>
            <div style="display:flex;gap:10px;font-size:12px">
                <span class="abc-a">● A (80% valor)</span>
                <span class="abc-b">● B (15% valor)</span>
                <span class="abc-c">● C (5% valor)</span>
            </div>
        </div>
        <div style="font-size:12px;color:var(--muted);margin-bottom:14px">Valor total em estoque: <strong style="color:#fff">R$ {{ number_format($totalValorEstoque,2,',','.') }}</strong></div>
        <table><thead><tr><th>Classe</th><th>Item</th><th>Qtd</th><th>Valor em Estoque</th><th>% do Total</th><th>Status</th></tr></thead><tbody>
        @foreach($estoqueABC as $e)
        <tr>
            <td><span class="abc-{{ strtolower($e['classe']) }}" style="font-weight:900;font-size:16px">{{ $e['classe'] }}</span></td>
            <td class="td-primary">{{ $e['nome'] }}</td>
            <td class="td-mono" style="color:var(--muted)">{{ number_format($e['qtd'],3,',','.') }} {{ $e['unidade'] }}</td>
            <td class="td-mono" style="font-weight:700">R$ {{ number_format($e['valor'],2,',','.') }}</td>
            <td style="color:var(--muted)">{{ $e['pct_valor'] }}%</td>
            <td>
                @if($e['status']==='esgotado') <span class="badge badge-danger">Esgotado</span>
                @elseif($e['status']==='critico') <span class="badge badge-warning">Crítico</span>
                @else <span class="badge badge-success">OK</span>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody></table>
    </div>
</div>

{{-- Previsão ML --}}
<div class="tab-sec" id="tab-previsao">
    <div class="sec-grid">
        <div class="panel">
            <div class="panel-header"><div class="panel-title"><i class="fas fa-robot"></i> Previsão de Vendas</div></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px">
                <div style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);border-radius:10px;padding:14px;text-align:center">
                    <div style="font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px">Amanhã</div>
                    <div style="font-size:22px;font-weight:900;color:#4ade80;margin:6px 0">R$ {{ number_format($previsaoAmanha,2,',','.') }}</div>
                    <div style="font-size:11px;color:var(--muted)">Média 7d + 5% tendência</div>
                </div>
                <div style="background:rgba(59,130,246,.08);border:1px solid rgba(59,130,246,.2);border-radius:10px;padding:14px;text-align:center">
                    <div style="font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px">Próxima Semana</div>
                    <div style="font-size:22px;font-weight:900;color:#60a5fa;margin:6px 0">R$ {{ number_format($previsaoSemana,2,',','.') }}</div>
                    <div style="font-size:11px;color:var(--muted)">Baseado na média móvel</div>
                </div>
            </div>
            <div style="font-size:11px;color:var(--muted);background:rgba(255,255,255,.03);border-radius:8px;padding:10px;line-height:1.6">
                <i class="fas fa-info-circle" style="color:var(--accent)"></i>
                Previsão baseada em <strong style="color:#fff">média móvel dos últimos 7 dias</strong> com fator de tendência de +5%. Quanto mais dados históricos, maior a precisão.
            </div>
        </div>
        <div class="panel">
            <div class="panel-header"><div class="panel-title"><i class="fas fa-chart-line"></i> Histórico 14 Dias</div></div>
            @php $maxH = $ultimos14->max('valor') ?: 1; @endphp
            <div class="chart-bars" style="height:100px">
                @foreach($ultimos14 as $d)
                <div class="chart-bar-c">
                    <div class="bar" style="height:{{ ($d['valor']/$maxH)*90 }}px;background:{{ $d['valor']>0?'rgba(34,197,94,.6)':'rgba(255,255,255,.05)' }}" title="{{ $d['dia'] }}: R$ {{ number_format($d['valor'],2,',','.') }}"></div>
                    <div class="lbl">{{ $d['dia'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function limitarAno(input) {
    if (!input.value) return;
    const parts = input.value.split('-');
    if (parts[0] && parseInt(parts[0]) > 2026) {
        parts[0] = '2026';
        input.value = parts.join('-');
    }
}

function showTab(id, btn) {
    document.querySelectorAll('.tab-sec').forEach(s => s.classList.remove('on'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('on'));
    document.getElementById('tab-' + id).classList.add('on');
    btn.classList.add('on');
}
</script>
@endsection
