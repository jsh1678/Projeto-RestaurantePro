@extends('layouts.app')
@section('page-title', 'Diária')
@section('breadcrumb', 'Conciliação e fechamento de caixa')

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
  @keyframes pulseRing { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,.4)} 50%{box-shadow:0 0 0 10px rgba(239,68,68,0)} }
  .caixa-fechado-badge { animation: pulseRing 2s ease infinite; }
  @keyframes countup { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:none} }
  .stat-card { animation: countup .4s ease both; }
  .metodo-row { transition: background .15s; }
  .metodo-row:hover { background: var(--card-hover); }
  #countdown { font-variant-numeric: tabular-nums; }
</style>
@endsection

@section('content')

{{-- Banner caixa fechado --}}
@if(!$caixaAberto)
<div class="alert alert-error mb-6 caixa-fechado-badge" style="border-radius:12px;padding:18px 20px;">
  🔒 <strong>Caixa fechado</strong> —
  Fechado {{ $caixaFechadoEm ? \Carbon\Carbon::parse($caixaFechadoEm)->format('d/m/Y \à\s H:i') : '' }}.
  Reabre automaticamente amanhã às <strong>10h00</strong>.
  <span id="countdown" class="ml-2 font-mono text-sm opacity-80"></span>
  @if(Auth::user()->role === 'gerente')
  <form method="POST" action="{{ route('caixa.abrir') }}" class="ml-auto" style="margin-left:auto">
    @csrf
    <button type="submit" class="btn btn-success btn-sm">🔓 Reabrir agora</button>
  </form>
  @endif
</div>
@endif

{{-- KPIs do dia --}}
<div class="cards-grid mb-5" style="grid-template-columns:repeat(auto-fit,minmax(170px,1fr))">
  <div class="stat-card" style="--card-color:#22c55e;animation-delay:.0s">
    <div class="sc-header"><div class="sc-icon">💰</div><span class="sc-badge">Hoje</span></div>
    <div class="sc-value" style="color:#4ade80">R$&nbsp;{{ number_format($totalDia,2,',','.') }}</div>
    <div class="sc-label">Total arrecadado</div>
  </div>
  <div class="stat-card" style="--card-color:#3b82f6;animation-delay:.07s">
    <div class="sc-header"><div class="sc-icon">🧾</div><span class="sc-badge">Pedidos</span></div>
    <div class="sc-value" style="color:#60a5fa">{{ $totalPedidos }}</div>
    <div class="sc-label">pagamentos confirmados</div>
  </div>
  <div class="stat-card" style="--card-color:#ef4444;animation-delay:.14s">
    <div class="sc-header"><div class="sc-icon">❌</div><span class="sc-badge">Cancelados</span></div>
    <div class="sc-value" style="color:#f87171">{{ $totalCancelados }}</div>
    <div class="sc-label">pedidos cancelados</div>
  </div>
  <div class="stat-card" style="--card-color:#a855f7;animation-delay:.21s">
    <div class="sc-header"><div class="sc-icon">📅</div><span class="sc-badge">Data</span></div>
    <div class="sc-value" style="font-size:16px;color:#c084fc">{{ $dataHoje->format('d/m/Y') }}</div>
    <div class="sc-label">{{ $dataHoje->translatedFormat('l') }}</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start;"
     class="diaria-grid">

  {{-- Conciliação por método --}}
  <div class="panel">
    <div class="panel-header">
      <div class="panel-title">💳 Conciliação de pagamentos — {{ $dataHoje->format('d/m/Y') }}</div>
    </div>

    @php
      $metIcones = [
        'pix'             => ['icon'=>'📱','cor'=>'rgba(59,130,246,.12)','tx'=>'#60a5fa','label'=>'PIX'],
        'cartao_debito'   => ['icon'=>'💳','cor'=>'rgba(34,197,94,.12)','tx'=>'#4ade80','label'=>'Cartão Débito'],
        'cartao_credito'  => ['icon'=>'💳','cor'=>'rgba(168,85,247,.12)','tx'=>'#c084fc','label'=>'Cartão Crédito'],
        'dinheiro'        => ['icon'=>'💵','cor'=>'rgba(234,179,8,.12)','tx'=>'#facc15','label'=>'Dinheiro'],
      ];
    @endphp

    <div style="display:flex;flex-direction:column;gap:2px;">
      @foreach($conciliacao as $c)
        @php $cfg = $metIcones[$c['metodo']] ?? ['icon'=>'💰','cor'=>'var(--bg3)','tx'=>'var(--text)','label'=>ucfirst($c['metodo'])]; @endphp
        <div class="metodo-row" style="display:flex;align-items:center;gap:14px;padding:14px 12px;border-radius:10px;">
          <div style="width:44px;height:44px;border-radius:10px;background:{{ $cfg['cor'] }};display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">
            {{ $cfg['icon'] }}
          </div>
          <div style="flex:1;">
            <div style="font-size:14px;font-weight:700;color:var(--text)">{{ $cfg['label'] }}</div>
            <div style="font-size:12px;color:var(--muted)">{{ $c['quantidade'] }} transaç{{ $c['quantidade']==1?'ão':'ões' }}</div>
          </div>
          <div style="text-align:right;">
            <div style="font-size:18px;font-weight:900;color:{{ $cfg['tx'] }}">
              R$ {{ number_format($c['total'],2,',','.') }}
            </div>
            @if($totalDia > 0)
            <div style="font-size:11px;color:var(--muted)">
              {{ number_format(($c['total']/$totalDia)*100,1) }}%
            </div>
            @endif
          </div>
        </div>
        @if(!$loop->last)
          <div style="border-top:1px solid var(--border);margin:0 12px;"></div>
        @endif
      @endforeach
    </div>

    {{-- Total --}}
    <div style="margin-top:16px;padding:16px;background:rgba(34,197,94,.07);border:1px solid rgba(34,197,94,.2);border-radius:12px;display:flex;justify-content:space-between;align-items:center;">
      <span style="font-size:15px;font-weight:700;color:var(--text)">Total do dia</span>
      <span style="font-size:24px;font-weight:900;color:#4ade80">R$ {{ number_format($totalDia,2,',','.') }}</span>
    </div>

    {{-- Barra visual de distribuição --}}
    @if($totalDia > 0)
    <div style="margin-top:16px;">
      <div style="font-size:12px;color:var(--muted);margin-bottom:6px;">Distribuição por forma de pagamento</div>
      <div style="display:flex;height:10px;border-radius:100px;overflow:hidden;gap:2px;">
        @php $cores = ['pix'=>'#3b82f6','cartao_debito'=>'#22c55e','cartao_credito'=>'#a855f7','dinheiro'=>'#eab308']; @endphp
        @foreach($conciliacao as $c)
          @if($c['total'] > 0)
          <div style="flex:{{ $c['total'] }};background:{{ $cores[$c['metodo']]??'var(--muted)' }};transition:flex .5s ease;" title="{{ ucfirst(str_replace('_',' ',$c['metodo'])) }}: R$ {{ number_format($c['total'],2,',','.') }}"></div>
          @endif
        @endforeach
      </div>
    </div>
    @endif
  </div>

  {{-- Painel fechar caixa --}}
  <div>
    <div class="panel" style="border-color:{{ $caixaAberto ? 'rgba(239,68,68,.3)' : 'rgba(34,197,94,.3)' }}">
      <div class="panel-header">
        <div class="panel-title" style="color:{{ $caixaAberto ? '#f87171' : '#4ade80' }}">
          {{ $caixaAberto ? '🟢 Caixa aberto' : '🔴 Caixa fechado' }}
        </div>
      </div>

      @if($caixaAberto)
        <p style="font-size:13px;color:var(--muted);margin-bottom:16px;line-height:1.6;">
          Ao fechar o caixa, <strong style="color:var(--text)">nenhum pedido ou pagamento</strong>
          poderá ser realizado até amanhã às <strong style="color:var(--text)">10h00</strong>, quando
          o caixa reabre automaticamente.
        </p>

        <div style="background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.2);border-radius:10px;padding:14px;margin-bottom:16px;font-size:13px;">
          <div style="color:#f87171;font-weight:700;margin-bottom:8px;">⚠️ Antes de fechar, confirme:</div>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-bottom:6px;">
            <input type="checkbox" id="chk1" onchange="checkFechar()"> Conferiu todos os pagamentos?
          </label>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
            <input type="checkbox" id="chk2" onchange="checkFechar()"> Não há pedidos pendentes?
          </label>
        </div>

        <form method="POST" action="{{ route('caixa.fechar') }}">
          @csrf
          <button type="submit" id="btn-fechar" class="btn btn-danger" style="width:100%;justify-content:center;opacity:.4;pointer-events:none;" disabled>
            🔒 Fechar caixa agora
          </button>
        </form>

        <div style="margin-top:10px;text-align:center;font-size:11px;color:var(--muted);">
          Reabertura automática às 10h do próximo dia
        </div>

      @else
        <div style="text-align:center;padding:16px 0;">
          <div style="font-size:40px;margin-bottom:10px;">🔒</div>
          <div style="font-size:13px;color:var(--muted);line-height:1.7;">
            Fechado em: <strong style="color:var(--text)">{{ $caixaFechadoEm ? \Carbon\Carbon::parse($caixaFechadoEm)->format('d/m/Y H:i') : '—' }}</strong><br>
            Reabre: <strong style="color:#4ade80">amanhã às 10h00</strong>
          </div>
          <div id="countdown-big" class="font-mono mt-3" style="font-size:22px;font-weight:900;color:#f87171;letter-spacing:2px;"></div>
        </div>

        @if(Auth::user()->role === 'gerente')
        <form method="POST" action="{{ route('caixa.abrir') }}" class="mt-4">
          @csrf
          <button type="submit" class="btn btn-success" style="width:100%;justify-content:center;">
            🔓 Reabrir caixa (gerente)
          </button>
        </form>
        @endif
      @endif
    </div>

    {{-- Histórico de fechamentos --}}
    @if(!empty($fechamentos))
    <div class="panel mt-4">
      <div class="panel-header">
        <div class="panel-title" style="font-size:13px;">📋 Últimos fechamentos</div>
      </div>
      @foreach(array_reverse($fechamentos) as $f)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border);font-size:12px;">
        <div>
          <div style="color:var(--text);font-weight:600">{{ $f['fechado_em'] }}</div>
          <div style="color:var(--muted)">{{ $f['usuario'] }}</div>
        </div>
        <div style="font-weight:700;color:#4ade80">R$ {{ number_format($f['total'],2,',','.') }}</div>
      </div>
      @endforeach
    </div>
    @endif
  </div>

</div>

@endsection

@section('scripts')
<script>
// Countdown até reabertura
function calcCountdown() {
  const now = new Date();
  const amanha = new Date(now);
  amanha.setDate(amanha.getDate() + 1);
  amanha.setHours(10, 0, 0, 0);
  const diff = Math.max(0, Math.floor((amanha - now) / 1000));
  const h = String(Math.floor(diff / 3600)).padStart(2, '0');
  const m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
  const s = String(diff % 60).padStart(2, '0');
  const txt = h + ':' + m + ':' + s;
  const el1 = document.getElementById('countdown');
  const el2 = document.getElementById('countdown-big');
  if (el1) el1.textContent = '(' + txt + ')';
  if (el2) el2.textContent = txt;
}
calcCountdown();
setInterval(calcCountdown, 1000);

// Habilita botão fechar caixa só quando ambos checkboxes marcados
function checkFechar() {
  const c1 = document.getElementById('chk1');
  const c2 = document.getElementById('chk2');
  const btn = document.getElementById('btn-fechar');
  if (!btn) return;
  const ok = c1 && c2 && c1.checked && c2.checked;
  btn.disabled = !ok;
  btn.style.opacity = ok ? '1' : '.4';
  btn.style.pointerEvents = ok ? 'auto' : 'none';
}

// Bloquear ações se caixa fechado
@if(!$caixaAberto)
document.addEventListener('DOMContentLoaded', function() {
  // Desabilitar forms de pagamento na mesma sessão
  document.querySelectorAll('form:not([action*="caixa"])').forEach(function(f) {
    f.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('❌ O caixa está fechado. Nenhum pedido ou pagamento pode ser realizado.');
    });
  });
});
@endif
</script>
@endsection
