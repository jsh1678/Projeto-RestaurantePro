<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'caixa_fechamento_id',
        'metodo',
        'parcelas',
        'valor',
        'taxa',
        'valor_final',
        'status',
        'data_pagamento',
    ];

    protected $casts = [
        'data_pagamento' => 'datetime',
        'parcelas'       => 'integer',
        'valor'          => 'float',
        'taxa'           => 'float',
        'valor_final'    => 'float',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function caixaFechamento(): BelongsTo
    {
        return $this->belongsTo(CaixaFechamento::class);
    }
}
