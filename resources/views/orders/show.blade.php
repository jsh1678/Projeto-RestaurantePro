@extends('layouts.app')
@section('page-title')
Pedido #{{ str_pad($pedido->id, 4, '0', STR_PAD_LEFT) }}
@endsection
@section('breadcrumb', 'Detalhes do pedido')
@section('content')
<div style="display:grid; grid-template-columns: 1.2fr 1fr; gap:24px">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">🧾 Pedido <span style="color:var(--accent); font-family:monospace">#{{ str_pad($pedido->id,4,'0',STR_PAD_LEFT) }}</span></div>
            @php $cores=['em_preparo'=>'warning','pronto_entrega'=>'success','pago'=>'info','cancelado'=>'danger','entregue'=>'secondary']; @endphp
            <span class="badge badge-{{ $cores[$pedido->status]??'secondary' }}" style="font-size:13px; padding:6px 14px">{{ str_replace('_',' ',ucfirst($pedido->status)) }}</span>
        </div>
        <div style="display:grid; gap:0; margin-bottom:20px">
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border)"><span style="color:var(--muted)">Mesa</span><strong>{{ $pedido->table->numero ?? '—' }}</strong></div>
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border)"><span style="color:var(--muted)">Garçom</span><strong>{{ $pedido->user->name ?? '—' }}</strong></div>
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border)"><span style="color:var(--muted)">Horário</span><strong>{{ $pedido->horario_pedido ? $pedido->horario_pedido->format('d/m/Y H:i') : $pedido->created_at->format('d/m/Y H:i') }}</strong></div>
            @if($pedido->observacoes)
            <div style="padding:12px 0; border-bottom:1px solid var(--border)">
                <div style="color:var(--muted); margin-bottom:6px">Observações</div>
                <div style="background:rgba(234,179,8,.08); border:1px solid rgba(234,179,8,.2); border-radius:8px; padding:10px 14px; color:#facc15; font-size:13px"> {{ $pedido->observacoes }}</div>
            </div>
            @endif
        </div>
        <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:20px">
            @foreach($pedido->items as $item)
            @php $ic=['pendente'=>'secondary','em_preparo'=>'warning','pronto'=>'success','entregue'=>'info']; @endphp
            <div style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06); border-radius:10px; padding:14px 16px">
                <div style="display:flex; align-items:center; gap:12px">
                    <div style="width:30px; height:30px; border-radius:8px; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center; font-weight:800; color:#fff">{{ $item->quantidade }}</div>
                    <div>
                        <div style="font-weight:600; color:#fff">{{ $item->menuItem->nome ?? 'Item' }}</div>
                        <div style="font-size:12px; color:var(--muted)">R$ {{ number_format($item->preco_unitario,2,',','.') }} cada</div>
                    </div>
                </div>
                <div style="text-align:right">
                    <div style="font-weight:800; color:#fff; font-family:monospace">R$ {{ number_format($item->subtotal,2,',','.') }}</div>
                    <span class="badge badge-{{ $ic[$item->status]??'secondary' }}" style="margin-top:4px">{{ str_replace('_',' ',ucfirst($item->status)) }}</span>
                </div>
            </div>
            @endforeach
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 0; border-top:2px solid var(--border)">
            <span style="font-size:16px; font-weight:600; color:var(--muted)">Total do Pedido</span>
            <span style="font-size:24px; font-weight:800; color:var(--accent); font-family:monospace">R$ {{ number_format($pedido->total,2,',','.') }}</span>
        </div>
    </div>

    <div>
        @if($pedido->payment)
        <div class="panel" style="border-color:rgba(34,197,94,.3); background:rgba(34,197,94,.04); margin-bottom:20px">
            <div class="panel-header"><div class="panel-title" style="color:#4ade80">✅ Pagamento Confirmado</div></div>
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid var(--border)"><span style="color:var(--muted)">Método</span><strong>{{ str_replace('_',' ',ucfirst($pedido->payment->metodo)) }}</strong></div>
            <div style="display:flex; justify-content:space-between; padding:10px 0"><span style="color:var(--muted)">Valor Pago</span><strong style="color:#4ade80; font-size:18px; font-family:monospace">R$ {{ number_format($pedido->payment->valor_final,2,',','.') }}</strong></div>
        </div>
        @endif

        @if(Auth::user()->role==='garcom' && !in_array($pedido->status,['pago','cancelado']))
        <div class="panel" style="margin-bottom:20px">
            <div class="panel-header"><div class="panel-title">✏️ Atualizar Status</div></div>
            <form method="POST" action="{{ route('orders.updateStatus',$pedido) }}">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label>Novo Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['aberto','em_preparo','pronto_entrega','entregue','cancelado'] as $s)
                        <option value="{{ $s }}" {{ $pedido->status===$s?'selected':'' }}>{{ str_replace('_',' ',ucfirst($s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center">💾 Atualizar</button>
            </form>
        </div>
        @endif

        <a href="{{ route('dashboard.pedidos') }}" class="btn btn-secondary">← Voltar aos Pedidos</a>
    </div>
</div>
@endsection
