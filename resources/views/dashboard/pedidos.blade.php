@extends('layouts.app')
@section('page-title', 'Pedidos')
@section('breadcrumb', 'Histórico e gestão de pedidos')
@section('content')

<div class="table-wrap">
    <div class="table-header">
        <h2>🧾 Todos os Pedidos</h2>
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap">
            <select id="filter-status" class="form-select" style="width:180px; font-size:13px; padding:7px 12px">
                <option value="">Todos os status</option>
                <option value="em_preparo">Em Preparo</option>
                <option value="pronto_entrega">Pronto p/ Entrega</option>
                <option value="entregue">Entregue</option>
                <option value="pago">Pago</option>
                <option value="cancelado">Cancelado</option>
            </select>
            <button id="btn-mostrar-todos" class="btn btn-secondary btn-sm" onclick="mostrarTodos()" style="display:none">
                <i class="fas fa-list"></i> Todos os Pedidos
            </button>
            @if(Auth::user()->role === 'garcom')
            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">➕ Novo</a>
            @endif
        </div>
    </div>
    @if($pedidos->isEmpty())
        <div class="empty-state">🧾<p>Nenhum pedido encontrado</p></div>
    @else
    <table>
        <thead>
            <tr><th>#</th><th>Mesa</th><th>Garçom</th><th>Itens</th><th>Total</th><th>Status</th><th>Horário</th><th></th></tr>
        </thead>
        <tbody id="pedidos-table">
        @foreach($pedidos as $p)
        @php $cores = ['em_preparo'=>'warning','pronto_entrega'=>'success','pago'=>'info','cancelado'=>'danger','entregue'=>'secondary','aberto'=>'primary']; @endphp
        <tr class="pedido-row" data-status="{{ $p->status }}" onclick="window.location='{{ route('orders.show', $p) }}'" style="cursor:pointer">
            <td class="td-mono td-primary">#{{ str_pad($p->id,4,'0',STR_PAD_LEFT) }}</td>
            <td>Mesa {{ $p->table->numero ?? '—' }}</td>
            <td style="color:var(--muted)">{{ $p->user->name ?? '—' }}</td>
            <td><span class="badge badge-secondary">{{ $p->items->count() }}</span></td>
            <td class="td-mono">R$ {{ number_format($p->total,2,',','.') }}</td>
            <td><span class="badge badge-{{ $cores[$p->status] ?? 'secondary' }}">{{ str_replace('_',' ',ucfirst($p->status)) }}</span></td>
            <td style="color:var(--muted); font-size:12px">{{ $p->created_at->format('d/m H:i') }}</td>
            <td onclick="event.stopPropagation()">
                <a href="{{ route('orders.show', $p) }}" class="btn btn-secondary btn-sm btn-icon">👁</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
@section('scripts')
<script>
document.getElementById('filter-status').addEventListener('change', function() {
    const v = this.value;
    document.querySelectorAll('.pedido-row').forEach(row => {
        row.style.display = !v || row.dataset.status === v ? '' : 'none';
    });
    document.getElementById('btn-mostrar-todos').style.display = v ? '' : 'none';
});

function mostrarTodos() {
    document.getElementById('filter-status').value = '';
    document.querySelectorAll('.pedido-row').forEach(row => row.style.display = '');
    document.getElementById('btn-mostrar-todos').style.display = 'none';
}
</script>
@endsection
