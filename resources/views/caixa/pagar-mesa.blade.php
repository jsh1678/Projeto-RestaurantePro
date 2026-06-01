@extends('layouts.app')
@section('page-title', 'Pagar Mesa')
@section('breadcrumb', 'Selecione a mesa para processar pagamento')
<<<<<<< HEAD

@section('styles')
<style>
.pay-mesas-grid {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 22px;
    align-items: start;
}
.pay-mesa-card {
    padding: 24px;
    cursor: default;
    overflow: visible;
}
.pay-mesa-card .mc-number {
    font-size: 38px;
}
.pay-mesa-card .mc-seats {
    margin-bottom: 12px;
}
.pay-order-card {
    margin-top: 14px;
    background: rgba(250,178,105,.055);
    border: 1px solid rgba(250,178,105,.12);
    border-radius: 18px;
    padding: 14px;
    text-align: left;
}
.pay-order-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 10px;
}
.pay-order-id {
    color: var(--gold);
    font-weight: 800;
}
.pay-order-total {
    color: var(--cream);
    font-family: monospace;
    font-size: 16px;
    font-weight: 800;
    line-height: 1.25;
    text-align: right;
    white-space: nowrap;
}
.pay-status {
    margin-bottom: 12px;
}
.pay-form {
    display: grid;
    gap: 10px;
    margin-top: 12px;
}
.pay-form .form-select {
    min-height: 42px;
    font-size: 14px;
}
.pay-extra {
    border-radius: 16px;
    padding: 12px;
}
.pay-credit {
    background: rgba(168,85,247,.08);
    border: 1px solid rgba(168,85,247,.24);
}
.pay-pix {
    background: rgba(59,130,246,.08);
    border: 1px solid rgba(59,130,246,.24);
    text-align: center;
}
.pay-extra label {
    display: block;
    margin-bottom: 8px;
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
}
.pay-pix-qr {
    display: block;
    width: min(168px, 100%);
    height: auto;
    aspect-ratio: 1;
    margin: 0 auto 10px;
    padding: 8px;
    background: #fff;
    border-radius: 12px;
}
.pay-pix-code {
    max-width: 100%;
    max-height: 56px;
    overflow: auto;
    padding: 8px;
    background: rgba(0,0,0,.12);
    border-radius: 10px;
    color: var(--muted);
    font-size: 10px;
    line-height: 1.45;
    text-align: left;
    word-break: break-all;
}
.pay-confirm {
    width: 100%;
    justify-content: center;
}
@media (max-width: 640px) {
    .pay-mesas-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .pay-mesa-card {
        padding: 16px;
        border-radius: 12px;
    }

    .pay-mesa-card .mc-number {
        font-size: 32px;
    }

    .pay-order-card {
        border-radius: 12px;
        padding: 12px;
    }

    .pay-order-head {
        align-items: center;
    }

    .pay-form .form-select,
    .pay-confirm {
        min-height: 50px;
        font-size: 16px;
    }

    .pay-pix-qr {
        width: min(220px, 100%);
    }
}
</style>
@endsection

@section('content')
<div class="mesas-grid pay-mesas-grid">
    @forelse($mesas as $mesa)
    @php $pedidos = $mesa->orders; @endphp
    <div class="mesa-card pay-mesa-card {{ $pedidos->isNotEmpty() ? 'ocupada' : 'disponivel' }}">
        <div class="mc-number">{{ $mesa->numero }}</div>
        <div class="mc-seats">{{ $mesa->assentos }} lugares</div>

        @if($pedidos->isNotEmpty())
            <span class="badge badge-danger" style="margin:6px 0">{{ $pedidos->count() }} pedido(s)</span>

            @foreach($pedidos as $p)
            <div class="pay-order-card">
                <div class="pay-order-head">
                    <span class="td-mono pay-order-id">#{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}</span>
                    <strong class="pay-order-total">R$ {{ number_format($p->total,2,',','.') }}</strong>
                </div>

                <div class="pay-status">
                    <span class="badge badge-warning">{{ $p->status === 'aguardando_pagamento' ? 'Aguardando pagamento' : str_replace('_',' ',ucfirst($p->status)) }}</span>
                </div>

                @if($p->status === 'aguardando_pagamento')
                <form method="POST" action="{{ route('caixa.pagamento', $p) }}" class="pagamento-form pay-form" data-total="{{ $p->total }}" data-pedido="{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}" data-pix-payload="{{ e(\App\Support\PixPayload::make((float) $p->total, 'PED' . str_pad($p->id,4,'0',STR_PAD_LEFT))) }}">
                    @csrf
                    <select name="metodo" class="form-select js-metodo-pagamento" required>
=======
@section('content')
<div class="mesas-grid">
    @forelse($mesas as $mesa)
    @php $pedidos = $mesa->orders; @endphp
    <div class="mesa-card {{ $pedidos->isNotEmpty() ? 'ocupada' : 'disponivel' }}" style="cursor:default">
        <div class="mc-number">{{ $mesa->numero }}</div>
        <div class="mc-seats">{{ $mesa->assentos }} lugares</div>
        @if($pedidos->isNotEmpty())
            <span class="badge badge-danger" style="margin:6px 0">{{ $pedidos->count() }} pedido(s)</span>
            @foreach($pedidos as $p)
            <div style="margin-top:8px; background:var(--bg3); border-radius:10px; padding:12px; font-size:13px; text-align:left">
                <div style="display:flex; justify-content:space-between; margin-bottom:6px">
                    <span class="td-mono" style="color:var(--accent); font-weight:700">#{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}</span>
                    <strong>R$ {{ number_format($p->total,2,',','.') }}</strong>
                </div>
                <span class="badge badge-{{ $p->status==='pronto_entrega'?'success':'warning' }}">{{ str_replace('_',' ',ucfirst($p->status)) }}</span>
                @if($p->status==='pronto_entrega')
                <form method="POST" action="{{ route('caixa.pagamento',$p) }}" style="margin-top:10px">
                    @csrf
                    <select name="metodo" class="form-select" style="font-size:12px; padding:6px; margin-bottom:8px" required>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
                        <option value="dinheiro">💵 Dinheiro</option>
                        <option value="cartao_credito">💳 Crédito</option>
                        <option value="cartao_debito">💳 Débito</option>
                        <option value="pix">📱 PIX</option>
                    </select>
<<<<<<< HEAD

                    <div class="pay-extra pay-credit js-credito-extra" style="display:none">
                        <label>Parcelas no crédito</label>
                        <select name="parcelas" class="form-select js-parcelas" disabled>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }}x</option>
                            @endfor
                        </select>
                        <div class="js-parcela-info" style="font-size:12px; color:var(--muted); margin-top:6px"></div>
                    </div>

                    <div class="pay-extra pay-pix js-pix-extra" style="display:none">
                        <img class="js-pix-qr pay-pix-qr" alt="QR Code PIX" width="168" height="168">
                        <div class="js-pix-code td-mono pay-pix-code"></div>
                    </div>

                    <input type="hidden" name="valor_pago" value="{{ $p->total }}">
                    <button type="submit" class="btn btn-success btn-sm pay-confirm">✓ Confirmar Pag.</button>
=======
                    <input type="hidden" name="valor_pago" value="{{ $p->total }}">
                    <button type="submit" class="btn btn-success btn-sm" style="width:100%; justify-content:center">✓ Confirmar Pag.</button>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
                </form>
                @endif
            </div>
            @endforeach
        @else
            <span class="badge badge-success" style="margin-top:8px">Livre</span>
        @endif
    </div>
    @empty
    <div class="empty-state" style="grid-column:1/-1">🪑<p>Nenhuma mesa cadastrada</p></div>
    @endforelse
</div>
@endsection
<<<<<<< HEAD

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
    const total = Number(form.dataset.total || 0);

    const formatMoney = (value) => value.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

    const updateParcelas = () => {
        const qtd = Number(parcelas.value || 1);
        parcelaInfo.textContent = `${qtd}x de ${formatMoney(total / qtd)} sem juros`;
    };

    const updatePaymentExtras = () => {
        const isCredito = metodo.value === 'cartao_credito';
        const isPix = metodo.value === 'pix';

        creditoExtra.style.display = isCredito ? 'block' : 'none';
        pixExtra.style.display = isPix ? 'block' : 'none';
        parcelas.disabled = !isCredito;

        if (isCredito) {
            updateParcelas();
        }

        if (isPix) {
            const payload = form.dataset.pixPayload || '';
            pixCode.textContent = payload;
            pixQr.src = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(payload)}`;
        }
    };

    metodo.addEventListener('change', updatePaymentExtras);
    parcelas.addEventListener('change', updateParcelas);
    updatePaymentExtras();
});
</script>
@endsection
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
