@extends('layouts.app')
@section('page-title', 'Pagar Mesa')
@section('breadcrumb', 'Selecione a mesa para processar pagamento')
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
                        <option value="dinheiro">💵 Dinheiro</option>
                        <option value="cartao_credito">💳 Crédito</option>
                        <option value="cartao_debito">💳 Débito</option>
                        <option value="pix">📱 PIX</option>
                    </select>
                    <input type="hidden" name="valor_pago" value="{{ $p->total }}">
                    <button type="submit" class="btn btn-success btn-sm" style="width:100%; justify-content:center">✓ Confirmar Pag.</button>
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
