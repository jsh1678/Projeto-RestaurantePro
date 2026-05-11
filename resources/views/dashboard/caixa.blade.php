@extends('layouts.app')
@section('page-title', 'Caixa')
@section('breadcrumb', 'Controle financeiro do dia')
@section('content')

<div class="cards-grid">
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon"></div><span class="sc-badge">Hoje</span></div>
        <div class="sc-value" style="font-size:22px">R$ {{ number_format($vendaHoje,2,',','.') }}</div>
        <div class="sc-label">Entradas do dia</div>
    </div>
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon"></div><span class="sc-badge">Mês</span></div>
        <div class="sc-value" style="font-size:22px">R$ {{ number_format($vendaDoMes,2,',','.') }}</div>
        <div class="sc-label">Vendas do mês</div>
    </div>
    <div class="stat-card" style="--card-color:#a855f7">
        <div class="sc-header"><div class="sc-icon">💳</div><span class="sc-badge">Cartão</span></div>
        <div class="sc-value" style="font-size:22px">R$ {{ number_format($pagamentosCartao,2,',','.') }}</div>
        <div class="sc-label">Pagamentos cartão</div>
    </div>
    <div class="stat-card" style="--card-color:#f97316">
        <div class="sc-header"><div class="sc-icon">💵</div><span class="sc-badge">Dinheiro</span></div>
        <div class="sc-value" style="font-size:22px">R$ {{ number_format($pagamentosNumerario,2,',','.') }}</div>
        <div class="sc-label">Pagamentos em dinheiro</div>
    </div>
    <div class="stat-card" style="--card-color:#ef4444">
        <div class="sc-header"><div class="sc-icon"></div><span class="sc-badge">Saídas</span></div>
        <div class="sc-value" style="font-size:22px">R$ {{ number_format($comprasHoje,2,',','.') }}</div>
        <div class="sc-label">Compras hoje</div>
    </div>
    <div class="stat-card" style="--card-color:{{ $saldoHoje >= 0 ? '#22c55e' : '#ef4444' }}">
        <div class="sc-header"><div class="sc-icon">💰</div><span class="sc-badge">Líquido</span></div>
        <div class="sc-value" style="font-size:22px; color:{{ $saldoHoje >= 0 ? '#4ade80' : '#f87171' }}">R$ {{ number_format($saldoHoje,2,',','.') }}</div>
        <div class="sc-label">Vendas − Compras − Sangrias</div>
    </div>
    <div class="stat-card" style="--card-color:#ef4444">
        <div class="sc-header"><div class="sc-icon">💸</div><span class="sc-badge">Sangrias</span></div>
        <div class="sc-value" style="font-size:22px; color:#f87171">R$ {{ number_format($sangriasHoje,2,',','.') }}</div>
        <div class="sc-label">Retiradas hoje</div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 1.2fr; gap:24px">

    <div>
        <div class="panel" style="margin-bottom:20px">
            <div class="panel-header">
                <div class="panel-title">🕐 Aguardando Pagamento</div>
                <span class="badge badge-warning">{{ $pedidosProntosPagamento->count() }}</span>
            </div>
            @if($pedidosProntosPagamento->isEmpty())
                <div class="empty-state" style="padding:28px">✅<p>Sem pendências</p></div>
            @else
                @foreach($pedidosProntosPagamento as $p)
                <div style="background:rgba(249,115,22,.06); border:1px solid rgba(249,115,22,.2); border-radius:12px; padding:16px; margin-bottom:12px">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
                        <div>
                            <div style="font-weight:800; color:#fff">Pedido <span style="color:var(--accent); font-family:monospace">#{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}</span></div>
                            <div style="font-size:12px; color:var(--muted)">Mesa {{ $p->table->numero ?? '—' }} · {{ $p->items->count() }} itens</div>
                        </div>
                        <div style="font-size:18px; font-weight:800; color:#fff">R$ {{ number_format($p->items->sum('subtotal'),2,',','.') }}</div>
                    </div>
                    <form method="POST" action="{{ route('caixa.pagamento', $p) }}" style="display:flex; gap:8px">
                        @csrf
                        <select name="metodo" class="form-select" style="flex:1; font-size:13px" required>
                            <option value="">Pagamento...</option>
                            <option value="dinheiro">💵 Dinheiro</option>
                            <option value="cartao_credito">💳 Crédito</option>
                            <option value="cartao_debito">💳 Débito</option>
                            <option value="pix">📱 PIX</option>
                        </select>
                        <input type="hidden" name="valor_pago" value="{{ $p->items->sum('subtotal') }}">
                        <button type="submit" class="btn btn-success btn-sm">✓ Pagar</button>
                    </form>
                </div>
                @endforeach
            @endif
        </div>

        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">💸 Registrar Sangria</div>
                @if($sangriasHoje > 0)
                <span class="badge badge-danger">Hoje: R$ {{ number_format($sangriasHoje,2,',','.') }}</span>
                @endif
            </div>
            <form method="POST" action="{{ route('caixa.sangria') }}" style="display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap">
                @csrf
                <div class="form-group" style="flex:1; min-width:120px; margin:0">
                    <label>Valor (R$)</label>
                    <input type="number" name="valor" step="0.01" min="0.01" max="999999" class="form-control" placeholder="0,00" required>
                </div>
                <div class="form-group" style="flex:2; min-width:180px; margin:0">
                    <label>Motivo</label>
                    <input type="text" name="motivo" class="form-control" placeholder="Ex: Troco, Retirada...">
                </div>
                <button type="submit" class="btn btn-danger">💸 Registrar</button>
            </form>

            @if($historicoSangrias->isNotEmpty())
            <div style="margin-top:18px; border-top:1px solid var(--border); padding-top:14px">
                <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:10px">Histórico de Sangrias</div>
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:left; font-size:11px; color:var(--muted); padding:6px 0; font-weight:600">Data/Hora</th>
                            <th style="text-align:left; font-size:11px; color:var(--muted); padding:6px 0; font-weight:600">Motivo</th>
                            <th style="text-align:left; font-size:11px; color:var(--muted); padding:6px 0; font-weight:600">Registrado por</th>
                            <th style="text-align:right; font-size:11px; color:var(--muted); padding:6px 0; font-weight:600">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($historicoSangrias as $s)
                    <tr style="border-top:1px solid rgba(255,255,255,.04)">
                        <td style="padding:8px 0; font-size:12px; color:var(--muted)">{{ $s->created_at->format('d/m H:i') }}</td>
                        <td style="padding:8px 0; font-size:13px">{{ $s->motivo ?: '—' }}</td>
                        <td style="padding:8px 0; font-size:12px; color:var(--muted)">{{ $s->user->name ?? '—' }}</td>
                        <td style="padding:8px 0; text-align:right; font-weight:700; color:#f87171; font-family:monospace">- R$ {{ number_format($s->valor,2,',','.') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2>🕐 Pagamentos de Hoje</h2>
            <span class="badge badge-secondary">{{ $pagamentosHoje->count() }}</span>
        </div>
        @if($pagamentosHoje->isEmpty())
            <div class="empty-state">🧾<p>Nenhum pagamento hoje</p></div>
        @else
        <table>
            <thead><tr><th>Pedido</th><th>Hora</th><th>Método</th><th>Valor</th></tr></thead>
            <tbody>
            @foreach($pagamentosHoje as $pg)
            <tr>
                <td class="td-mono td-primary">#{{ str_pad($pg->order_id,4,'0',STR_PAD_LEFT) }}</td>
                <td style="color:var(--muted); font-size:12px">{{ $pg->created_at->format('H:i') }}</td>
                <td>
                    @php $metodoIcons = ['dinheiro'=>'💵','cartao_credito'=>'💳','cartao_debito'=>'💳','pix'=>'📱']; @endphp
                    {{ $metodoIcons[$pg->metodo] ?? '' }} {{ str_replace('_',' ',ucfirst($pg->metodo)) }}
                </td>
                <td class="td-mono" style="color:#4ade80; font-weight:700">R$ {{ number_format($pg->valor_final,2,',','.') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
