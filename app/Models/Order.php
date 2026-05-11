<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'table_id',
        'user_id',
        'status',
        'total',
        'observacoes',
        'pedido_viagem',
        'horario_pedido',
        'horario_pronto',
        'horario_entrega',
        'horario_termino_preparo',
        'pago_em',           // ← timestamp do pagamento (soft hide)
    ];

    protected $casts = [
        'total'                   => 'float',
        'pedido_viagem'           => 'boolean',
        'horario_pedido'          => 'datetime',
        'horario_pronto'          => 'datetime',
        'horario_entrega'         => 'datetime',
        'horario_termino_preparo' => 'datetime',
        'pago_em'                 => 'datetime',
    ];

    // ── RELACIONAMENTOS ──────────────────────────────────────────────────────

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // ── SCOPES (soft hide) ───────────────────────────────────────────────────

    /**
     * Pedidos visíveis nas telas ativas (garçom, chef, mesas).
     * Exclui pagos e cancelados.
     */
    public function scopeAtivo($query)
    {
        return $query->whereNotIn('status', ['pago', 'cancelado']);
    }

    /**
     * Pedidos prontos para o garçom entregar.
     */
    public function scopeProntoEntrega($query)
    {
        return $query->where('status', 'pronto_entrega');
    }

    /**
     * Pedidos aguardando pagamento no caixa (garçom já entregou).
     */
    public function scopeAguardandoPagamento($query)
    {
        return $query->where('status', 'aguardando_pagamento');
    }

    // ── ACCESSORS ───────────────────────────────────────────────────────────

    /**
     * Retorna true se o pedido já saiu de todas as views ativas.
     */
    public function getEstaOcultoAttribute(): bool
    {
        return in_array($this->status, ['pago', 'cancelado']);
    }

    /**
     * Label amigável do status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aberto'               => 'Aberto',
            'em_preparo'           => 'Em Preparo',
            'pronto'               => 'Pronto',
            'pronto_entrega'       => 'Pronto p/ Entregar',
            'aguardando_pagamento' => 'Entregue',
            'pago'                 => 'Pago',
            'cancelado'            => 'Cancelado',
            default                => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}