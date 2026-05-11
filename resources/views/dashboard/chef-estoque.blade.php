@extends('layouts.app')
@section('page-title', 'Estoque — Chef')
@section('breadcrumb', 'Visão de ingredientes disponíveis')
@section('content')
<div class="table-wrap">
    <div class="table-header"><h2>📦 Ingredientes em Estoque</h2></div>
    <table>
        <thead><tr><th>Item</th><th>Disponível</th><th>Mínimo</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($itens as $item)
        @php
            $unidadesPeso   = ['kg','g','gramas','grama'];
            $unidadesVolume = ['l','ml','litro','litros'];
            $u = strtolower($item->unidade);
            $isPeso   = in_array($u, $unidadesPeso);
            $isVolume = in_array($u, $unidadesVolume);

            if ($isPeso) {
                $qtd = $item->quantidade_atual >= 1
                    ? number_format($item->quantidade_atual, 3, ',', '.') . ' kg'
                    : number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' g';
                $min = $item->quantidade_minima >= 1
                    ? number_format($item->quantidade_minima, 3, ',', '.') . ' kg'
                    : number_format($item->quantidade_minima * 1000, 0, ',', '.') . ' g';
            } elseif ($isVolume) {
                $qtd = $item->quantidade_atual >= 1
                    ? number_format($item->quantidade_atual, 2, ',', '.') . ' L'
                    : number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' mL';
                $min = $item->quantidade_minima >= 1
                    ? number_format($item->quantidade_minima, 2, ',', '.') . ' L'
                    : number_format($item->quantidade_minima * 1000, 0, ',', '.') . ' mL';
            } else {
                $qtd = number_format($item->quantidade_atual, 0, ',', '.') . ' un';
                $min = number_format($item->quantidade_minima, 0, ',', '.') . ' un';
            }
            $alerta = $item->quantidade_atual <= $item->quantidade_minima;
        @endphp
        <tr>
            <td><div class="td-primary">{{ $item->nome }}</div></td>
            <td>
                <span style="font-family:monospace; font-weight:800; font-size:15px; color:{{ $alerta ? '#f87171' : '#4ade80' }}">
                    {{ $qtd }}
                </span>
            </td>
            <td class="td-mono" style="color:var(--muted)">{{ $min }}</td>
            <td>
                @if($item->quantidade_atual <= 0)
                    <span class="badge badge-danger">Esgotado</span>
                @elseif($alerta)
                    <span class="badge badge-warning">Estoque baixo</span>
                @else
                    <span class="badge badge-success">OK</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="4"><div class="empty-state">📦<p>Sem itens</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
