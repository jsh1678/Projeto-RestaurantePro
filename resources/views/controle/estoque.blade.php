@extends('layouts.app')
@section('page-title', 'Controle de Estoque')
@section('breadcrumb', 'Entradas, saídas e inventário')

@section('styles')
<style>
.est-tabs{display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap}
.est-tab{padding:7px 16px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;border:1px solid var(--border);background:var(--bg2);color:var(--muted);transition:.15s}
.est-tab.on{background:rgba(249,115,22,.12);color:var(--accent);border-color:rgba(249,115,22,.3)}
.est-sec{display:none}.est-sec.on{display:block}
.mov-entrada{color:#4ade80}.mov-saida{color:#f87171}.mov-ajuste{color:#fbbf24}
.ajuste-diff-pos{color:#4ade80;font-weight:700}
.ajuste-diff-neg{color:#f87171;font-weight:700}
.ajuste-diff-zero{color:var(--muted)}
.inventario-badge{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:2px 8px;border-radius:20px;background:rgba(251,191,36,.12);color:#fbbf24}

/* Unidade inteligente */
.unit-toggle-wrap{display:flex;gap:0;border-radius:9px;overflow:hidden;border:1px solid var(--border)}
.unit-toggle-wrap input{border:none;border-radius:0;flex:1;min-width:0}
.unit-toggle-wrap input:focus{box-shadow:none;border-color:transparent}
.unit-badge{
  display:flex;align-items:center;justify-content:center;
  padding:0 12px;background:rgba(249,115,22,.1);color:var(--accent);
  font-size:12px;font-weight:700;border-left:1px solid var(--border);
  min-width:44px;cursor:default;
  user-select:none;
}
.unit-hint{font-size:11px;color:#fbbf24;margin-top:4px;display:none;padding:4px 8px;background:rgba(251,191,36,.07);border-radius:6px}

/* Botões de ação melhorados */
.btn-edit{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 12px;border-radius:7px;border:1px solid rgba(59,130,246,.3);
  background:rgba(59,130,246,.1);color:#60a5fa;
  font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;
  transition:all .15s;white-space:nowrap;
}
.btn-edit:hover{background:rgba(59,130,246,.2);border-color:rgba(59,130,246,.5)}
.btn-del{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 12px;border-radius:7px;border:1px solid rgba(239,68,68,.3);
  background:rgba(239,68,68,.1);color:#f87171;
  font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;
  transition:all .15s;white-space:nowrap;
}
.btn-del:hover{background:rgba(239,68,68,.2);border-color:rgba(239,68,68,.5)}

@media(max-width:768px){
  .est-forms-grid{grid-template-columns:1fr!important}
  .inv-grid{grid-template-columns:1fr!important}
}
</style>
@endsection

@section('content')
{{-- Filtro --}}
<div class="panel" style="margin-bottom:20px">
    <form method="GET" style="display:flex;gap:14px;align-items:flex-end;flex-wrap:wrap">
        <div class="form-group" style="margin:0;flex:1;min-width:140px"><label>Início</label><input type="date" name="data_inicio" class="form-control" value="{{ $di->format('Y-m-d') }}"></div>
        <div class="form-group" style="margin:0;flex:1;min-width:140px"><label>Fim</label><input type="date" name="data_fim" class="form-control" value="{{ $df->format('Y-m-d') }}"></div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrar</button>
        <a href="{{ route('controle.estoque') }}" class="btn btn-secondary">Últimos 30 dias</a>
    </form>
</div>

{{-- KPIs --}}
<div class="cards-grid" style="grid-template-columns:repeat(auto-fill,minmax(180px,1fr));margin-bottom:22px">
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon"><i class="fas fa-arrow-down"></i></div><span class="sc-badge">Período</span></div>
        <div class="sc-value" style="font-size:20px;color:#4ade80">{{ number_format($totalEntradas,3,',','.') }}</div>
        <div class="sc-label">Total de Entradas</div>
    </div>
    <div class="stat-card" style="--card-color:#ef4444">
        <div class="sc-header"><div class="sc-icon"><i class="fas fa-arrow-up"></i></div><span class="sc-badge">Período</span></div>
        <div class="sc-value" style="font-size:20px;color:#f87171">{{ number_format($totalSaidas,3,',','.') }}</div>
        <div class="sc-label">Total de Saídas</div>
    </div>
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon"><i class="fas fa-boxes"></i></div><span class="sc-badge">Atual</span></div>
        <div class="sc-value" style="font-size:18px">R$ {{ number_format($valorEstoque,2,',','.') }}</div>
        <div class="sc-label">Valor em Estoque</div>
    </div>
    <div class="stat-card" style="--card-color:#a855f7">
        <div class="sc-header"><div class="sc-icon"><i class="fas fa-box"></i></div><span class="sc-badge">Total</span></div>
        <div class="sc-value">{{ $itens->count() }}</div>
        <div class="sc-label">Produtos Cadastrados</div>
    </div>
</div>

{{-- Formulários --}}
<div class="est-forms-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:22px">

    {{-- ENTRADA --}}
    <div class="panel">
        <div class="panel-header"><div class="panel-title" style="color:#4ade80"><i class="fas fa-arrow-down"></i> Registrar Entrada</div></div>
        <form method="POST" action="{{ route('controle.estoque.entrada') }}">
            @csrf
            <div class="form-group">
                <label>Produto</label>
                <select name="stock_item_id" id="sel-entrada" class="form-select" required onchange="onProdutoChange(this,'entrada')">
                    <option value="">— Selecione —</option>
                    @foreach($itens as $item)
                    <option value="{{ $item->id }}" data-unit="{{ $item->unidade }}" data-atual="{{ $item->quantidade_atual }}">{{ $item->nome }} ({{ $item->unidade }}) — Atual: {{ number_format($item->quantidade_atual,3,',','.') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Quantidade <span id="entrada-unit-label" style="color:var(--accent);font-weight:700"></span></label>
                <div class="unit-toggle-wrap">
                    <input type="number" name="quantidade" id="entrada-qty" step="0.001" min="0.001" max="9999999"
                           class="form-control" placeholder="0,000" required oninput="onQtyInput(this,'entrada')">
                    <div class="unit-badge" id="entrada-badge">—</div>
                </div>
                <div class="unit-hint" id="entrada-hint"></div>
            </div>
            <button type="submit" class="btn btn-success" style="width:100%;justify-content:center">
                <i class="fas fa-plus-circle"></i> Registrar Entrada
            </button>
        </form>
    </div>

    {{-- SAÍDA --}}
    <div class="panel">
        <div class="panel-header"><div class="panel-title" style="color:#f87171"><i class="fas fa-arrow-up"></i> Registrar Saída</div></div>
        <form method="POST" action="{{ route('controle.estoque.saida') }}">
            @csrf
            <div class="form-group">
                <label>Produto</label>
                <select name="stock_item_id" id="sel-saida" class="form-select" required onchange="onProdutoChange(this,'saida')">
                    <option value="">— Selecione —</option>
                    @foreach($itens as $item)
                    <option value="{{ $item->id }}" data-unit="{{ $item->unidade }}" data-atual="{{ $item->quantidade_atual }}">{{ $item->nome }} ({{ $item->unidade }}) — Atual: {{ number_format($item->quantidade_atual,3,',','.') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Quantidade <span id="saida-unit-label" style="color:var(--accent);font-weight:700"></span></label>
                <div class="unit-toggle-wrap">
                    <input type="number" name="quantidade" id="saida-qty" step="0.001" min="0.001" max="9999999"
                           class="form-control" placeholder="0,000" required oninput="onQtyInput(this,'saida')">
                    <div class="unit-badge" id="saida-badge">—</div>
                </div>
                <div class="unit-hint" id="saida-hint"></div>
            </div>
            <div class="form-group">
                <label>Motivo da Saída</label>
                <input type="text" name="motivo" class="form-control" placeholder="Ex: Vencimento, Quebra, Uso..." required>
            </div>
            <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center">
                <i class="fas fa-minus-circle"></i> Registrar Saída
            </button>
        </form>
    </div>
</div>

{{-- Tabs: sem Ajustar, apenas Saldo, Entradas e Saídas --}}
<div class="est-tabs">
    <button class="est-tab on" onclick="showEst('saldo',this)">📊 Saldo Atual</button>
    <button class="est-tab" onclick="showEst('entradas',this)">➕ Entradas</button>
    <button class="est-tab" onclick="showEst('saidas',this)">➖ Saídas</button>
</div>

{{-- Saldo --}}
<div class="est-sec on" id="est-saldo">
    <div class="table-wrap">
        <div class="table-header"><h2><i class="fas fa-balance-scale"></i> Saldo de Estoque por Produto</h2></div>
        <table>
            <thead><tr><th>Produto</th><th>Unidade</th><th>Entradas</th><th>Saídas</th><th>Saldo Atual</th><th>Valor</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($saldo as $s)
            @php $alerta = $s['item']->quantidade_atual <= $s['item']->quantidade_minima; @endphp
            <tr>
                <td class="td-primary">{{ $s['item']->nome }}</td>
                <td><span style="background:rgba(99,102,241,.12);color:#818cf8;padding:2px 8px;border-radius:6px;font-size:11px;font-weight:700">{{ $s['item']->unidade }}</span></td>
                <td class="td-mono mov-entrada">+{{ number_format($s['entradas'],3,',','.') }}</td>
                <td class="td-mono mov-saida">-{{ number_format($s['saidas'],3,',','.') }}</td>
                <td class="td-mono" style="color:{{ $alerta?'#f87171':'#4ade80' }};font-weight:800;font-size:15px">{{ number_format($s['saldo'],3,',','.') }}</td>
                <td class="td-mono" style="color:var(--muted)">R$ {{ number_format($s['valor'],2,',','.') }}</td>
                <td>
                    @if($s['item']->quantidade_atual <= 0)<span class="badge badge-danger">Esgotado</span>
                    @elseif($alerta)<span class="badge badge-warning">Baixo</span>
                    @else<span class="badge badge-success">OK</span>@endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Entradas --}}
<div class="est-sec" id="est-entradas">
    <div class="table-wrap">
        <div class="table-header"><h2><i class="fas fa-arrow-down"></i> Histórico de Entradas ({{ $entradas->count() }})</h2></div>
        @if($entradas->isEmpty())<div class="empty-state"><p>Sem entradas no período</p></div>
        @else
        <table>
            <thead><tr><th>Data/Hora</th><th>Produto</th><th>Quantidade</th><th>Antes</th><th>Depois</th><th>Usuário</th></tr></thead>
            <tbody>
            @foreach($entradas as $m)
            <tr>
                <td style="font-size:12px;color:var(--muted)">{{ $m->created_at->format('d/m H:i') }}</td>
                <td class="td-primary">{{ $m->stockItem->nome ?? '—' }}</td>
                <td class="td-mono mov-entrada" style="font-weight:700">+{{ number_format($m->quantidade,3,',','.') }}</td>
                <td class="td-mono" style="color:var(--muted)">{{ number_format($m->quantidade_anterior,3,',','.') }}</td>
                <td class="td-mono" style="color:#4ade80">{{ number_format($m->quantidade_nova,3,',','.') }}</td>
                <td style="font-size:12px;color:var(--muted)">{{ $m->user->name ?? '—' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- Saídas --}}
<div class="est-sec" id="est-saidas">
    <div class="table-wrap">
        <div class="table-header"><h2><i class="fas fa-arrow-up"></i> Histórico de Saídas ({{ $saidas->count() }})</h2></div>
        @if($saidas->isEmpty())<div class="empty-state"><p>Sem saídas no período</p></div>
        @else
        <table>
            <thead><tr><th>Data/Hora</th><th>Produto</th><th>Quantidade</th><th>Antes</th><th>Depois</th><th>Motivo</th><th>Usuário</th></tr></thead>
            <tbody>
            @foreach($saidas as $m)
            <tr>
                <td style="font-size:12px;color:var(--muted)">{{ $m->created_at->format('d/m H:i') }}</td>
                <td class="td-primary">{{ $m->stockItem->nome ?? '—' }}</td>
                <td class="td-mono mov-saida" style="font-weight:700">-{{ number_format($m->quantidade,3,',','.') }}</td>
                <td class="td-mono" style="color:var(--muted)">{{ number_format($m->quantidade_anterior,3,',','.') }}</td>
                <td class="td-mono" style="color:#f87171">{{ number_format($m->quantidade_nova,3,',','.') }}</td>
                <td style="font-size:12px;color:var(--muted)">{{ $m->motivo ?? '—' }}</td>
                <td style="font-size:12px;color:var(--muted)">{{ $m->user->name ?? '—' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>


@endsection

@section('scripts')
<script>
// Unidade de cada campo
const unitData = {};

function showEst(id, btn){
    document.querySelectorAll('.est-sec').forEach(s=>s.classList.remove('on'));
    document.querySelectorAll('.est-tab').forEach(b=>b.classList.remove('on'));
    document.getElementById('est-'+id).classList.add('on');
    btn.classList.add('on');
}

// Quando seleciona produto em entrada ou saída
function onProdutoChange(sel, tipo){
    const opt = sel.options[sel.selectedIndex];
    if(!opt || !opt.value){ return; }
    const unit = opt.dataset.unit || 'un';
    unitData[tipo] = { unit, atual: parseFloat(opt.dataset.atual)||0 };
    document.getElementById(tipo+'-badge').textContent = unit;
    document.getElementById(tipo+'-hint').style.display = 'none';
    document.getElementById(tipo+'-qty').value = '';
    // Label descritivo
    const lbl = document.getElementById(tipo+'-unit-label');
    if(lbl) lbl.textContent = '(' + unit + ')';
}

// Preview de conversão automática em tempo real
function onQtyInput(input, tipo){
    const hint = document.getElementById(tipo+'-hint');
    const badge = document.getElementById(tipo+'-badge');
    const data = unitData[tipo];
    if(!data){ hint.style.display='none'; return; }

    const val = parseFloat(input.value);
    if(!val || val <= 0){ hint.style.display='none'; return; }

    const {unit} = data;

    // Automação: g → kg e ml → L
    if(unit === 'g' && val >= 1000){
        const kg = (val/1000).toFixed(3).replace(/\.?0+$/,'');
        hint.textContent = `⚡ ${val.toLocaleString('pt-BR')}g = ${kg} kg — será salvo em kg`;
        hint.style.display = 'block';
        badge.textContent = 'g→kg';
    } else if(unit === 'kg' && val < 1 && val > 0){
        const gramas = Math.round(val * 1000);
        hint.textContent = `⚡ ${val} kg = ${gramas.toLocaleString('pt-BR')} g`;
        hint.style.display = 'block';
        badge.textContent = 'kg';
    } else if(unit === 'ml' && val >= 1000){
        const L = (val/1000).toFixed(3).replace(/\.?0+$/,'');
        hint.textContent = `⚡ ${val.toLocaleString('pt-BR')}ml = ${L} L — será salvo em L`;
        hint.style.display = 'block';
        badge.textContent = 'ml→L';
    } else {
        hint.style.display = 'none';
        badge.textContent = unit;
    }
}

// Inventário físico
function onAjusteProduto(sel){
    const opt = sel.options[sel.selectedIndex];
    const info = document.getElementById('ajuste-saldo-info');
    const prev = document.getElementById('ajuste-preview');
    const badge = document.getElementById('ajuste-badge');
    const lbl = document.getElementById('ajuste-unit-lbl');
    document.getElementById('ajuste-qty').value = '';
    prev.style.display = 'none';
    if(opt && opt.value){
        const unit = opt.dataset.unit || 'un';
        const atual = parseFloat(opt.dataset.atual)||0;
        unitData.ajuste = {unit, atual};
        document.getElementById('ajuste-saldo-val').textContent = atual.toFixed(3).replace('.',',') + ' ' + unit;
        info.style.display = 'block';
        badge.textContent = unit;
        if(lbl) lbl.textContent = '(' + unit + ')';
    } else {
        info.style.display = 'none';
        badge.textContent = '—';
    }
}

function previewAjuste(input){
    const prev = document.getElementById('ajuste-preview');
    const data = unitData.ajuste;
    if(!data){ prev.style.display='none'; return; }
    const {unit, atual} = data;
    const contado = parseFloat(input.value);
    if(isNaN(contado)||input.value===''){prev.style.display='none';return;}
    const diff = contado - atual;
    if(diff > 0){
        prev.innerHTML = `✅ Saldo vai <strong style="color:#4ade80">aumentar ${Math.abs(diff).toFixed(3)} ${unit}</strong>`;
        prev.style.color='#4ade80';
    } else if(diff < 0){
        prev.innerHTML = `⚠️ Saldo vai <strong style="color:#f87171">diminuir ${Math.abs(diff).toFixed(3)} ${unit}</strong>`;
        prev.style.color='#f87171';
    } else {
        prev.innerHTML = `✔️ <span style="color:var(--muted)">Sem diferença — saldo permanece ${atual.toFixed(3)} ${unit}</span>`;
    }
    prev.style.display = 'block';
}
</script>
@endsection
