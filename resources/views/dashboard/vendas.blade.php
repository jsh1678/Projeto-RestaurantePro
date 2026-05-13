@extends('layouts.app')
@section('page-title', 'Vendas')
@section('breadcrumb', 'Relatório de vendas do mês')

@section('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  darkMode: ['attribute', '[data-theme="dark"]'],
  corePlugins: { preflight: false },
  important: true,
}
</script>
<style>
.pico-row td:first-child::before { content: ''; }
@keyframes growUp {
  from { transform: scaleY(0); transform-origin: bottom; }
  to   { transform: scaleY(1); transform-origin: bottom; }
}
.bar { animation: growUp 0.45s ease forwards; }
@keyframes bncIcon { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(-3px)} }
.pico-icon { animation: bncIcon 1.2s ease infinite; }
</style>
@endsection

@section('content')

{{-- KPIs --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <div class="stat-card" style="--card-color:#22c55e">
    <div class="sc-header"><div class="sc-icon">💰</div><span class="sc-badge">Hoje</span></div>
    <div class="sc-value" style="color:#4ade80">R$&nbsp;{{ number_format($totalHoje,2,',','.') }}</div>
    <div class="sc-label">Total de hoje</div>
  </div>
  <div class="stat-card" style="--card-color:#3b82f6">
    <div class="sc-header"><div class="sc-icon">📅</div><span class="sc-badge">Mês</span></div>
    <div class="sc-value">R$&nbsp;{{ number_format($totalMes,2,',','.') }}</div>
    <div class="sc-label">Total do mês</div>
  </div>
  <div class="stat-card" style="--card-color:#f97316">
    <div class="sc-header"><div class="sc-icon">🏆</div><span class="sc-badge">Melhor dia</span></div>
    @php $melhor = $topDias->first(); @endphp
    <div class="sc-value" style="font-size:18px;color:#f97316">
      {{ $melhor ? \Carbon\Carbon::parse($melhor->dia)->format('d/m') : '—' }}
    </div>
    <div class="sc-label">R$&nbsp;{{ $melhor ? number_format($melhor->total,2,',','.') : '0,00' }}</div>
  </div>
  <div class="stat-card" style="--card-color:#a855f7">
    <div class="sc-header"><div class="sc-icon">📊</div><span class="sc-badge">Dias</span></div>
    <div class="sc-value" style="color:#c084fc">{{ $vendasGrafico->count() }}</div>
    <div class="sc-label">dias com vendas</div>
  </div>
</div>

{{-- Gráfico de barras --}}
@if($vendasGrafico->isNotEmpty())
<div class="panel mb-5">
  <div class="panel-header">
    <div class="panel-title">📈 Vendas por dia — {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
    <div style="display:flex;gap:16px;font-size:12px;color:var(--muted);align-items:center">
      <span style="display:flex;align-items:center;gap:5px">
        <span style="width:12px;height:12px;background:#f97316;border-radius:3px;display:inline-block"></span> Pico de vendas
      </span>
      <span style="display:flex;align-items:center;gap:5px">
        <span style="width:12px;height:12px;background:#3b82f6;border-radius:3px;display:inline-block"></span> Dia normal
      </span>
    </div>
  </div>
  @php $maxVal = $vendasGrafico->max('total') ?: 1; @endphp
  <div style="overflow-x:auto">
    <div style="display:flex;align-items:flex-end;gap:5px;height:190px;padding-bottom:28px;min-width:{{ max(600, $vendasGrafico->count()*34) }}px;position:relative;padding-top:26px;">
      @foreach($vendasGrafico as $dv)
        @php
          $isPico = in_array($dv->dia, $topDiasIds);
          $h      = max(4, round(($dv->total / $maxVal) * 140));
          $rank   = array_search($dv->dia, $topDiasIds);
          $medals = ['🥇','🥈','🥉'];
        @endphp
        <div style="flex:1;min-width:26px;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;position:relative;cursor:default;"
             title="{{ \Carbon\Carbon::parse($dv->dia)->format('d/m') }}: R$ {{ number_format($dv->total,2,',','.') }}">

          @if($isPico && $rank !== false)
            <div class="pico-icon" style="position:absolute;top:0;left:50%;font-size:14px;line-height:1;">
              {{ $medals[$rank] ?? '🏅' }}
            </div>
          @endif

          <div class="bar" style="
            width:100%;
            height:{{ $h }}px;
            background:{{ $isPico ? '#f97316' : '#3b82f6' }};
            border-radius:3px 3px 0 0;
            {{ $isPico ? 'box-shadow:0 0 12px rgba(249,115,22,.35)' : '' }};
            transition:opacity .15s;
          "></div>

          <div style="position:absolute;bottom:-20px;font-size:10px;color:var(--muted);white-space:nowrap;">
            {{ \Carbon\Carbon::parse($dv->dia)->format('d') }}
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- Top 3 picos --}}
@if($topDias->isNotEmpty())
<div class="panel mb-5">
  <div class="panel-header">
    <div class="panel-title">🏆 Top dias do mês</div>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px;">
    @foreach($topDias as $idx => $td)
      @php
        $medals  = ['🥇','🥈','🥉'];
        $bgList  = ['rgba(234,179,8,.1)','rgba(148,163,184,.08)','rgba(180,83,9,.08)'];
        $bdList  = ['rgba(234,179,8,.3)','rgba(148,163,184,.2)','rgba(180,83,9,.2)'];
        $txList  = ['#facc15','#94a3b8','#f97316'];
      @endphp
      <div style="border-radius:12px;padding:14px 16px;display:flex;align-items:center;gap:12px;
                  background:{{ $bgList[$idx]??'var(--bg3)' }};border:1px solid {{ $bdList[$idx]??'var(--border)' }}">
        <div style="font-size:28px;line-height:1">{{ $medals[$idx] ?? '🏅' }}</div>
        <div>
          <div style="font-size:12px;color:var(--muted)">{{ \Carbon\Carbon::parse($td->dia)->translatedFormat('l') }}</div>
          <div style="font-size:13px;font-weight:700;color:var(--text)">{{ \Carbon\Carbon::parse($td->dia)->format('d/m/Y') }}</div>
          <div style="font-size:18px;font-weight:900;color:{{ $txList[$idx]??'var(--accent)' }}">
            R$ {{ number_format($td->total,2,',','.') }}
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endif

{{-- Tabela --}}
<div class="table-wrap">
  <div class="table-header">
    <h2>📋 Vendas do Mês ({{ $vendas->count() }})</h2>
    <input type="text" id="search-v" placeholder="Buscar..." class="form-control"
           style="width:200px;padding:6px 12px;font-size:13px" oninput="filtrar(this.value)">
  </div>
  @if($vendas->isEmpty())
    <div class="empty-state"><span class="es-icon">📈</span><p>Nenhuma venda este mês</p></div>
  @else
  <table id="tv">
    <thead>
      <tr>
        <th>Data</th><th>Pedido</th><th>Mesa</th><th>Método</th><th>Valor</th><th>Status</th>
      </tr>
    </thead>
    <tbody>
    @foreach($vendas as $v)
      @php
        $isPicoRow = in_array($v->created_at->toDateString(), $topDiasIds);
        $icones = ['dinheiro'=>'💵','cartao_credito'=>'💳','cartao_debito'=>'💳','pix'=>'📱'];
      @endphp
      <tr>
        <td style="font-size:12px;color:var(--muted)">
          {{ $v->created_at->format('d/m/Y H:i') }}
          @if($isPicoRow)
            <span class="badge badge-primary" style="font-size:9px;padding:1px 5px;margin-left:4px;">pico</span>
          @endif
        </td>
        <td class="td-mono td-primary">#{{ str_pad($v->order_id,4,'0',STR_PAD_LEFT) }}</td>
        <td style="font-size:12px;color:var(--muted)">
          {{ $v->order?->table?->numero ? 'Mesa '.$v->order->table->numero : 'Delivery' }}
        </td>
        <td>{{ ($icones[$v->metodo] ?? '') }} {{ ucfirst(str_replace('_',' ',$v->metodo)) }}</td>
        <td class="td-mono" style="color:#4ade80;font-weight:700">R$ {{ number_format($v->valor_final,2,',','.') }}</td>
        <td><span class="badge badge-{{ $v->status==='confirmado'?'success':'warning' }}">{{ ucfirst($v->status) }}</span></td>
      </tr>
    @endforeach
    </tbody>
  </table>
  @endif
</div>

@endsection

@section('scripts')
<script>
function filtrar(q){
  document.querySelectorAll('#tv tbody tr').forEach(r=>{
    r.style.display = r.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
  });
}
</script>
@endsection
