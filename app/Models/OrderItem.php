<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
<<<<<<< HEAD
    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantidade',
        'preco_unitario',
        'subtotal',
        'observacoes',
        'status',
        'horario_pronto',
        'enviado_cozinha',
        'enviado_cozinha_em',
    ];

    protected $casts = [
        'horario_pronto'      => 'datetime',
        'enviado_cozinha'     => 'boolean',
        'enviado_cozinha_em'  => 'datetime',
    ];

    protected $attributes = [
        'status'          => 'pendente',
        'enviado_cozinha' => false,
=======
    protected $fillable = ['order_id', 'menu_item_id', 'quantidade', 'preco_unitario', 'subtotal', 'observacoes', 'status', 'horario_pronto'];

    protected $casts = [
        'horario_pronto' => 'datetime',
    ];

    // Status padrão ao criar um item
    protected $attributes = [
        'status' => 'pendente',
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
