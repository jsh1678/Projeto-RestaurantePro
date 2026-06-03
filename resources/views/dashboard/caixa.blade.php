@extends('layouts.app')
@section('page-title', 'Caixa')
@section('breadcrumb', 'Controle financeiro do dia')

@section('styles')
<style>
.caixa-stats {
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}
.caixa-stats .stat-card {
    min-height: 142px;
    padding: 18px 20px;
}
.caixa-stats .stat-card::before,
.caixa-stats .stat-card::after {
    background: var(--card-color, var(--red));
}
.caixa-stats .sc-header {
    align-items: center;
    margin-bottom: 16px;
}
.caixa-stats .sc-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.caixa-stats .sc-value {
    font-size: clamp(18px, 2vw, 22px);
    line-height: 1.15;
    overflow-wrap: anywhere;
}
.caixa-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr);
    gap: 24px;
    align-items: start;
}
.caixa-layout > * {
    min-width: 0;
}
.caixa-stack {
    display: grid;
    gap: 20px;
    min-width: 0;
}
.caixa-panel {
    margin-bottom: 0;
}
.caixa-panel .panel-header,
.caixa-history .table-header {
    gap: 12px;
}
.payment-list {
    display: grid;
    gap: 12px;
}
.payment-card {
    background: rgba(249,115,22,.055);
    border: 1px solid rgba(250,178,105,.2);
    border-radius: 14px;
    padding: 14px;
    transition: var(--transition);
}
.payment-card:hover {
    border-color: rgba(249,115,22,.34);
    background: rgba(249,115,22,.08);
    box-shadow: none;
}
.payment-card-head {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 14px;
    align-items: center;
    margin-bottom: 12px;
}
.payment-title {
    font-weight: 800;
    color: #fff;
    line-height: 1.25;
    font-size: 19px;
}
.payment-meta {
    margin-top: 3px;
    font-size: 12px;
    color: var(--muted);
}
.payment-total {
    color: var(--accent);
    font-family: monospace;
    font-size: 26px;
    font-weight: 900;
    white-space: nowrap;
    text-align: right;
}
.payment-status-strong {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 34px;
    padding: 0 12px;
    border-radius: 999px;
    background: rgba(249,115,22,.14);
    border: 1px solid rgba(249,115,22,.32);
    color: #fdba74;
    font-size: 11px;
    font-weight: 900;
    text-transform: uppercase;
}
.cash-summary {
    grid-column: 1 / -1;
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 10px 12px;
    background: var(--bg);
}
.cash-summary-line {
    display: block;
    border-right: 1px solid var(--border);
    padding: 0 12px;
    color: var(--muted);
    font-size: 12px;
}
.cash-summary-line:first-child { padding-left: 0; }
.cash-summary-line strong {
    color: #fff;
    display: block;
    font-size: 15px;
    margin-top: 3px;
    font-family: monospace;
}
.cash-summary-line.total {
    border-top: 0;
    border-right: 0;
    padding-top: 0;
    color: #fff;
    font-weight: 900;
}
.cash-summary-line.total strong {
    color: var(--accent);
    font-size: 17px;
}
.pagamento-form {
    display: grid;
    grid-template-columns: minmax(0, 3fr) minmax(260px, 2fr);
    gap: 14px;
    align-items: start;
}
.pagamento-form:not(.has-pix) {
    grid-template-columns: minmax(0, 1fr);
}
.pagamento-form > .form-select {
    display: none;
}
.pagamento-form .btn {
    min-height: 44px;
    justify-content: center;
    white-space: nowrap;
}
.cash-method-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 8px;
}
.cash-method-btn {
    min-height: 46px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--bg);
    color: #fff;
    font-weight: 900;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 13px;
    padding: 0 10px;
}
.cash-method-btn i { font-size: 14px; }
.cash-method-btn.active {
    border-color: var(--accent);
    background: rgba(249,115,22,.14);
    color: var(--accent);
}
.payment-extra {
    grid-column: 1 / -1;
    width: 100%;
    border-radius: 12px;
    padding: 10px;
}
.pagamento-form .form-control,
.pagamento-form .form-select {
    min-height: 38px;
    padding-top: 7px;
    padding-bottom: 7px;
}
.payment-extra label {
    display: block;
    margin-bottom: 7px;
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
}
.payment-extra-credit {
    background: rgba(168,85,247,.08);
    border: 1px solid rgba(168,85,247,.24);
}
.payment-extra-pix {
    background: rgba(59,130,246,.08);
    border: 1px solid rgba(59,130,246,.24);
    text-align: left;
    display: grid;
    grid-template-columns: auto minmax(0, 1fr);
    gap: 12px;
    align-items: center;
    align-self: start;
}
.pix-qr {
    width: 142px;
    height: 142px;
    background: #fff;
    border-radius: 8px;
    padding: 7px;
    margin: 0;
}
.pix-copy-btn {
    min-height: 34px !important;
    margin-top: 8px;
    width: max-content;
}
.money-input-wrap {
    display: grid;
    gap: 6px;
    max-width: 500px;
}
.money-input-wrap label,
.payment-method-label {
    color: var(--muted);
    font-size: 12px;
    font-weight: 900;
    letter-spacing: .6px;
    text-transform: uppercase;
}
.money-input-shell {
    min-height: 48px;
    display: grid;
    grid-template-columns: 64px minmax(0, 1fr);
    border: 1px solid var(--accent);
    border-radius: 12px;
    overflow: hidden;
    background: var(--bg);
}
.money-prefix {
    display: grid;
    place-items: center;
    border-right: 1px solid var(--border);
    color: #fff;
    font: 900 19px monospace;
}
.money-input-shell input {
    width: 100%;
    border: 0 !important;
    background: transparent !important;
    color: #fff !important;
    font: 900 20px monospace !important;
    padding: 0 16px !important;
    outline: none !important;
}
.cash-shortcuts {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.cash-shortcuts button {
    min-height: 32px;
    padding: 0 10px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: var(--bg);
    color: var(--muted);
    font-weight: 800;
    cursor: pointer;
}
.cash-shortcuts button:hover {
    color: #fff;
    border-color: var(--accent);
}
.cash-change-box {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
    padding: 9px 10px;
    border: 1px solid rgba(34,197,94,.24);
    border-radius: 12px;
    background: rgba(34,197,94,.06);
}
.cash-change-box:not(.active) .cash-change-item.change {
    opacity: .45;
}
.cash-change-item span {
    display: block;
    color: var(--muted);
    font-size: 12px;
}
.cash-change-item strong {
    display: block;
    color: #fff;
    font-family: monospace;
    font-size: 14px;
    margin-top: 4px;
}
.cash-change-item.change strong {
    color: #4ade80;
    font-size: 17px;
}
.service-card {
    display: flex !important;
    align-items: center;
    gap: 10px !important;
    border: 0;
    border-radius: 0;
    background: transparent;
    padding: 0 !important;
    color: var(--muted);
    font-size: 13px !important;
    cursor: pointer;
}
.service-card input {
    width: 18px;
    height: 18px;
    accent-color: var(--accent);
}
.payment-left {
    display: grid;
    gap: 9px;
    min-width: 0;
}
.payment-right {
    min-width: 0;
    display: none;
}
.pagamento-form.has-pix .payment-right {
    display: block;
}
.payment-right .payment-extra-pix {
    height: 100%;
}
.pay-submit-main {
    width: 100%;
    min-height: 48px !important;
    font-size: 14px;
    font-weight: 900;
}
.pix-code {
    max-height: 54px;
    min-height: 38px;
    overflow: auto;
    color: var(--muted);
    font-size: 11px;
    line-height: 1.4;
    word-break: break-all;
}
.pix-info {
    min-width: 0;
}
.pix-info-title {
    display: block;
    color: #fff;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 900;
}
.pix-status {
    margin-top: 7px;
    color: #4ade80;
    font-size: 12px;
    font-weight: 800;
}
.cash-consumption-toggle {
    min-height: 34px;
    justify-content: center;
}
.cash-consumption {
    display: none;
    grid-column: 1 / -1;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px;
    background: var(--bg);
}
@media (max-width: 780px) {
    .pagamento-form {
        grid-template-columns: 1fr;
    }
    .payment-extra-pix {
        grid-template-columns: 1fr;
        text-align: center;
        justify-items: center;
    }
    .pix-copy-btn {
        width: 100%;
    }
}
.cash-consumption.open {
    display: grid;
    gap: 5px;
}
.cash-consumption-row {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    color: var(--muted);
    font-size: 12px;
}
.cash-consumption-row strong {
    color: #fff;
}
.sangria-form {
    display: grid;
    grid-template-columns: minmax(110px, .8fr) minmax(180px, 1.4fr) auto;
    gap: 12px;
    align-items: end;
}
.sangria-form .form-group {
    margin: 0;
}
.sangria-form .btn {
    min-height: 44px;
    justify-content: center;
}
.sangria-history {
    margin-top: 18px;
    border-top: 1px solid var(--border);
    padding-top: 14px;
    overflow-x: auto;
}
.section-kicker {
    font-size: 11px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}
.caixa-history {
    min-width: 0;
}
.caixa-history table {
    min-width: 560px;
}
.caixa-history table th,
.caixa-history table td,
.sangria-history table th,
.sangria-history table td {
    vertical-align: middle;
}
.caixa-history tbody tr {
    transition: background .15s;
}
.caixa-history tbody tr:hover {
    background: rgba(250,178,105,.035);
}
.method-installments {
    color: var(--muted);
    font-size: 12px;
    white-space: nowrap;
}
.money-positive {
    color: #4ade80;
    font-weight: 700;
}
.money-negative {
    color: #f87171;
    font-weight: 700;
}
.empty-state.compact-empty {
    padding: 32px 20px;
}
.form-select:disabled {
    opacity: .58;
    cursor: not-allowed;
}
@media (min-width: 1500px) {
    .caixa-layout {
        grid-template-columns: minmax(0, .95fr) minmax(0, 1.25fr);
    }
}
@media (max-width: 640px) {
    .caixa-stats {
        grid-template-columns: 1fr;
    }
    .payment-card-head,
    .pagamento-form,
    .sangria-form {
        grid-template-columns: 1fr;
    }
    .payment-total {
        justify-self: start;
    }
    .pagamento-form .btn,
    .sangria-form .btn {
        width: 100%;
    }
}
</style>
@endsection

@section('content')

<div class="cards-grid caixa-stats">
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon">↗</div><span class="sc-badge">Hoje</span></div>
        <div class="sc-value" style="font-size:22px">R$ {{ number_format($vendaHoje,2,',','.') }}</div>
        <div class="sc-label">Entradas do dia</div>
    </div>
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon">📈</div><span class="sc-badge">Mês</span></div>
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
        <div class="sc-header"><div class="sc-icon">↘</div><span class="sc-badge">Saídas</span></div>
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

<div class="caixa-layout">

    <div class="caixa-stack">
        <div class="panel caixa-panel">
            <div class="panel-header">
                <div class="panel-title">🕐 Aguardando Pagamento</div>
                <span class="badge badge-warning">{{ $pedidosProntosPagamento->count() }}</span>
            </div>
            @if($pedidosProntosPagamento->isEmpty())
                <div class="empty-state compact-empty">✅<p>Sem pendências</p></div>
            @else
                <div class="payment-list">
                @foreach($pedidosProntosPagamento as $p)
                <div class="payment-card">
                    @php
                        $totalPedido = $p->items->sum('subtotal');
                        $totalPagoPedido = $p->payments->where('status', 'confirmado')->sum('valor_final');
                        $taxaPedido = $p->payments->where('status', 'confirmado')->sum('taxa');
                        $saldoPedido = max(0, ($totalPedido + $taxaPedido) - $totalPagoPedido);
                        $abertoHa = $p->created_at ? $p->created_at->diffForHumans(null, true) : 'agora';
                    @endphp
                    <div class="payment-card-head">
                        <div>
                            <div class="payment-title">Mesa {{ str_pad($p->table->numero ?? 0, 2, '0', STR_PAD_LEFT) }}</div>
                            <div class="payment-meta">Aberta ha {{ $abertoHa }} · Garcom {{ $p->user->name ?? 'Nao informado' }} · {{ $p->items->count() }} itens</div>
                        </div>
                        <div class="payment-total"><span style="display:block;color:var(--muted);font-size:12px;text-align:right;text-transform:uppercase">Total da conta</span>R$ {{ number_format($saldoPedido > 0 ? $saldoPedido : $totalPedido,2,',','.') }}</div>
                    </div>
                    @if(Auth::user()?->role === 'caixa')
                    <form method="POST" action="{{ route('caixa.pagamento', $p) }}" class="pagamento-form" data-total="{{ $saldoPedido > 0 ? $saldoPedido : $totalPedido }}" data-base-total="{{ $totalPedido }}" data-pedido="{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}" data-pix-payload="{{ e(\App\Support\PixPayload::make((float) ($saldoPedido > 0 ? $saldoPedido : $totalPedido), 'PED' . str_pad($p->id,4,'0',STR_PAD_LEFT))) }}">
                        @csrf
                        <div class="payment-left">
                        <div class="cash-summary">
                            <div class="cash-summary-line"><span>Subtotal</span><strong>R$ {{ number_format($totalPedido,2,',','.') }}</strong></div>
                            <div class="cash-summary-line"><span>Taxa de Servico</span><strong class="js-service-value">R$ {{ number_format($taxaPedido,2,',','.') }}</strong></div>
                            <div class="cash-summary-line"><span>Descontos</span><strong>R$ 0,00</strong></div>
                            <div class="cash-summary-line total"><span>Total</span><strong class="js-payment-total">R$ {{ number_format($saldoPedido > 0 ? $saldoPedido : $totalPedido,2,',','.') }}</strong></div>
                        </div>
                        <div class="payment-method-label">Forma de pagamento</div>
                        <select name="metodo" class="form-select js-metodo-pagamento" required>
                            <option value="">Pagamento...</option>
                            <option value="dinheiro">💵 Dinheiro</option>
                            <option value="cartao_credito">💳 Crédito</option>
                            <option value="cartao_debito">💳 Débito</option>
                            <option value="pix" selected>📱 PIX</option>
                        </select>
                        <div class="money-input-wrap">
                            <label>Valor recebido</label>
                            <div class="money-input-shell">
                                <span class="money-prefix">R$</span>
                                <input type="text" name="valor_pago" inputmode="decimal" class="js-money-input"
                                       value="{{ number_format($saldoPedido > 0 ? $saldoPedido : $totalPedido,2,',','.') }}" title="Valor recebido">
                            </div>
                        </div>
                        <div class="cash-shortcuts">
                            <button type="button" data-add-value="10">+10</button>
                            <button type="button" data-add-value="20">+20</button>
                            <button type="button" data-add-value="50">+50</button>
                            <button type="button" data-add-value="100">+100</button>
                            <button type="button" data-exact-value="1">Valor Exato</button>
                        </div>
                        <div class="cash-change-box js-cash-change">
                            <div class="cash-change-item"><span>Valor recebido</span><strong class="js-received-label">R$ 0,00</strong></div>
                            <div class="cash-change-item"><span>Total</span><strong class="js-total-label">R$ {{ number_format($saldoPedido > 0 ? $saldoPedido : $totalPedido,2,',','.') }}</strong></div>
                            <div class="cash-change-item change"><span>Troco</span><strong class="js-change-label">R$ 0,00</strong></div>
                        </div>
                        <button type="submit" class="btn btn-success pay-submit-main"><i class="fas fa-check-circle"></i> Confirmar Pagamento</button>
                        <label class="payment-extra service-card">
                            <input type="checkbox" name="taxa_garcom" value="1">
                            <span><strong style="color:#fff">Adicionar 10% do Garcom</strong><br><small>Atualiza o total da conta automaticamente</small></span>
                        </label>
                        <div class="payment-extra payment-extra-credit js-credito-extra" style="display:none">
                            <label>Parcelas no crédito</label>
                            <select name="parcelas" class="form-select js-parcelas" disabled>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}x</option>
                                @endfor
                            </select>
                            <div class="js-parcela-info payment-meta"></div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm cash-consumption-toggle js-cash-consumption-toggle">
                            Ver nota do pedido ({{ $p->items->count() }} item(ns))
                        </button>
                        <div class="cash-consumption js-cash-consumption">
                            @foreach($p->items as $item)
                            <div class="cash-consumption-row">
                                <span>{{ $item->quantidade }}x {{ $item->menuItem->nome ?? 'Item' }}</span>
                                <strong>R$ {{ number_format($item->subtotal,2,',','.') }}</strong>
                            </div>
                            @endforeach
                            @if($p->observacoes)
                            <div class="cash-consumption-row" style="border-top:1px solid var(--border);padding-top:6px">
                                <span>Observacao</span>
                                <strong>{{ $p->observacoes }}</strong>
                            </div>
                            @endif
                        </div>
                        </div>
                        <div class="payment-right">
                        <div class="payment-extra payment-extra-pix js-pix-extra" style="display:none">
                            <img class="js-pix-qr pix-qr" alt="QR Code PIX" width="156" height="156">
                            <div class="pix-info">
                                <strong class="pix-info-title">Codigo Pix Copia e Cola</strong>
                                <div class="js-pix-code td-mono pix-code"></div>
                                <div class="js-pix-fallback payment-meta" style="display:none;color:#fbbf24">Nao foi possivel carregar a imagem do QR Code. Use o codigo copia e cola.</div>
                                <button type="button" class="btn btn-secondary btn-sm pix-copy-btn js-copy-pix"><i class="fas fa-copy"></i> Copiar Codigo</button>
                                <div class="pix-status">Aguardando confirmacao do pagamento</div>
                            </div>
                        </div>
                        </div>
                    </form>
                    @else
                    <div class="cash-summary" style="margin-top:12px">
                        <div class="cash-summary-line"><span>Subtotal</span><strong>R$ {{ number_format($totalPedido,2,',','.') }}</strong></div>
                        <div class="cash-summary-line"><span>Taxa de Servico</span><strong>R$ {{ number_format($taxaPedido,2,',','.') }}</strong></div>
                        <div class="cash-summary-line total"><span>Total em aberto</span><strong>R$ {{ number_format($saldoPedido > 0 ? $saldoPedido : $totalPedido,2,',','.') }}</strong></div>
                    </div>
                    <div class="alert alert-info" style="margin-top:12px">
                        <i class="fa-solid fa-eye"></i> Consulta do gerente. Pagamentos sao operados pelo caixa.
                    </div>
                    @endif
                </div>
                @endforeach
                </div>
            @endif
        </div>

        <div class="panel caixa-panel">
            <div class="panel-header">
                <div class="panel-title">💸 Registrar Sangria</div>
                @if($sangriasHoje > 0)
                <span class="badge badge-danger">Hoje: R$ {{ number_format($sangriasHoje,2,',','.') }}</span>
                @endif
            </div>
            @if(Auth::user()?->role === 'caixa')
            <form method="POST" action="{{ route('caixa.sangria') }}" class="sangria-form">
                @csrf
                <div class="form-group">
                    <label>Valor (R$)</label>
                    <input type="number" name="valor" step="0.01" min="0.01" max="999999" class="form-control" placeholder="0,00" required>
                </div>
                <div class="form-group">
                    <label>Motivo</label>
                    <input type="text" name="motivo" class="form-control" placeholder="Ex: Troco, Retirada...">
                </div>
                <button type="submit" class="btn btn-danger">💸 Registrar</button>
            </form>
            @else
            <div class="alert alert-info">
                <i class="fa-solid fa-eye"></i> Consulta do gerente. Sangrias sao registradas pelo caixa.
            </div>
            @endif

            @if($historicoSangrias->isNotEmpty())
            <div class="sangria-history">
                <div class="section-kicker">Histórico de Sangrias</div>
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
                        <td class="td-mono money-negative" style="padding:8px 0; text-align:right">- R$ {{ number_format($s->valor,2,',','.') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <div class="table-wrap caixa-history">
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
                    @if($pg->metodo === 'cartao_credito' && ($pg->parcelas ?? 1) > 1)
                        <span class="method-installments">({{ $pg->parcelas }}x)</span>
                    @endif
                </td>
                <td class="td-mono money-positive">R$ {{ number_format($pg->valor_final,2,',','.') }}</td>
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
document.querySelectorAll('.pagamento-form').forEach((form) => {
    const metodo = form.querySelector('.js-metodo-pagamento');
    const creditoExtra = form.querySelector('.js-credito-extra');
    const pixExtra = form.querySelector('.js-pix-extra');
    const parcelas = form.querySelector('.js-parcelas');
    const parcelaInfo = form.querySelector('.js-parcela-info');
    const pixQr = form.querySelector('.js-pix-qr');
    const pixCode = form.querySelector('.js-pix-code');
    const pixFallback = form.querySelector('.js-pix-fallback');
    const copyPix = form.querySelector('.js-copy-pix');
    const consumptionToggle = form.querySelector('.js-cash-consumption-toggle');
    const consumption = form.querySelector('.js-cash-consumption');
    let total = Number(form.dataset.total || 0);
    const baseTotal = Number(form.dataset.baseTotal || 0);
    const valorInput = form.querySelector('input[name="valor_pago"]');
    const taxaCheckbox = form.querySelector('input[name="taxa_garcom"]');
    const pedido = form.dataset.pedido || '';
    const methodButtons = form.querySelectorAll('.cash-method-btn');
    const paymentTotal = form.querySelector('.js-payment-total');
    const serviceValue = form.querySelector('.js-service-value');
    const cashChange = form.querySelector('.js-cash-change');
    const receivedLabel = form.querySelector('.js-received-label');
    const totalLabel = form.querySelector('.js-total-label');
    const changeLabel = form.querySelector('.js-change-label');

    const formatMoney = (value) => value.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
    const formatInputMoney = (value) => Number(value || 0).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    const digitsToMoney = (digits) => {
        const cents = Number(String(digits || '').replace(/\D/g, '') || 0);
        return cents / 100;
    };
    const parseMoney = (value) => {
        const normalized = String(value || '0').replace(/\./g, '').replace(',', '.').replace(/[^\d.]/g, '');
        return Number(normalized || 0);
    };
    const syncMoneyInput = (value) => {
        if (!valorInput) return;
        valorInput.value = formatInputMoney(Math.min(Number(value || 0), total));
    };
    const updateTroco = () => {
        const recebido = Math.min(parseMoney(valorInput?.value), total);
        if (receivedLabel) receivedLabel.textContent = formatMoney(recebido);
        if (totalLabel) totalLabel.textContent = formatMoney(total);
        if (changeLabel) changeLabel.textContent = formatMoney(Math.max(0, recebido - total));
    };

    const updateParcelas = () => {
        const qtd = Number(parcelas.value || 1);
        parcelaInfo.textContent = `${qtd}x de ${formatMoney(total / qtd)} sem juros`;
    };

    const clampValor = () => {
        if (!valorInput) return;

        const valor = parseMoney(valorInput.value);
        valorInput.value = valor.toFixed(2);
    };

    const updateTaxaGarcom = () => {
        if (!taxaCheckbox) return;

        total = Number(form.dataset.total || 0) + (taxaCheckbox.checked ? baseTotal * 0.10 : 0);
        syncMoneyInput(total);
        if (paymentTotal) paymentTotal.textContent = formatMoney(total);
        if (serviceValue) serviceValue.textContent = taxaCheckbox.checked ? formatMoney(baseTotal * 0.10) : formatMoney(0);
        updateTroco();
        if (metodo.value === 'cartao_credito') updateParcelas();
    };

    const updatePaymentExtras = () => {
        const isCredito = metodo.value === 'cartao_credito';
        const isPix = metodo.value === 'pix';
        const isDinheiro = metodo.value === 'dinheiro';

        form.classList.toggle('has-pix', isPix);
        creditoExtra.style.display = isCredito ? 'block' : 'none';
        pixExtra.style.display = isPix ? 'grid' : 'none';
        if (cashChange) cashChange.classList.toggle('active', isDinheiro);
        parcelas.disabled = !isCredito;

        if (isCredito) {
            updateParcelas();
        }

        if (isPix) {
            const payload = form.dataset.pixPayload || '';
            pixCode.textContent = payload;
            if (pixFallback) pixFallback.style.display = 'none';
            if (pixQr) {
                pixQr.style.display = payload ? 'block' : 'none';
                pixQr.onerror = () => {
                    pixQr.style.display = 'none';
                    if (pixFallback) pixFallback.style.display = 'block';
                };
                pixQr.src = payload ? `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(payload)}` : '';
            }
        }
    };

    metodo.addEventListener('change', updatePaymentExtras);
    if (copyPix) {
        copyPix.addEventListener('click', async () => {
            const code = pixCode?.textContent || '';
            if (!code) return;
            try {
                await navigator.clipboard.writeText(code);
                copyPix.innerHTML = '<i class="fas fa-check"></i> Copiado';
                setTimeout(() => copyPix.innerHTML = '<i class="fas fa-copy"></i> Copiar Codigo', 1800);
            } catch (error) {
                alert('Nao foi possivel copiar o codigo PIX.');
            }
        });
    }
    if (consumptionToggle && consumption) {
        consumptionToggle.addEventListener('click', () => {
            consumption.classList.toggle('open');
        });
    }
    methodButtons.forEach((button) => {
        button.addEventListener('click', () => {
            metodo.value = button.dataset.method;
            methodButtons.forEach((item) => item.classList.toggle('active', item === button));
            updatePaymentExtras();
        });
    });
    parcelas.addEventListener('change', updateParcelas);
    if (valorInput) {
        valorInput.setAttribute('autocomplete', 'off');
        valorInput.addEventListener('keydown', (event) => {
            const allowed = ['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight', 'Home', 'End'];
            if (allowed.includes(event.key) || event.ctrlKey || event.metaKey) return;
            if (!/^\d$/.test(event.key)) event.preventDefault();
        });
        valorInput.addEventListener('focus', () => {
            if (!valorInput.value.trim()) syncMoneyInput(0);
            valorInput.select();
        });
        valorInput.addEventListener('input', () => {
            syncMoneyInput(Math.min(digitsToMoney(valorInput.value), total));
            updateTroco();
            requestAnimationFrame(() => {
                valorInput.selectionStart = valorInput.value.length;
                valorInput.selectionEnd = valorInput.value.length;
            });
        });
        valorInput.addEventListener('blur', () => {
            syncMoneyInput(parseMoney(valorInput.value));
            updateTroco();
        });
    }
    form.querySelectorAll('[data-add-value]').forEach((button) => {
        button.addEventListener('click', () => {
            syncMoneyInput(Math.min(parseMoney(valorInput.value) + Number(button.dataset.addValue || 0), total));
            updateTroco();
        });
    });
    form.querySelector('[data-exact-value]')?.addEventListener('click', () => {
        syncMoneyInput(total);
        updateTroco();
    });
    form.addEventListener('submit', () => {
        if (valorInput) valorInput.value = Math.min(parseMoney(valorInput.value), total).toFixed(2);
    });
    if (taxaCheckbox) taxaCheckbox.addEventListener('change', updateTaxaGarcom);
    syncMoneyInput(parseMoney(valorInput?.value) || total);
    updateTroco();
    if (!metodo.value) metodo.value = 'pix';
    updatePaymentExtras();
});
</script>
@endsection
