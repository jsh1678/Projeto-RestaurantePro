<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
<<<<<<< HEAD
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
=======
    protected $fillable = ['order_id', 'metodo', 'valor', 'taxa', 'valor_final', 'status', 'data_pagamento'];
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
<<<<<<< HEAD

    public function caixaFechamento(): BelongsTo
    {
        return $this->belongsTo(CaixaFechamento::class);
    }
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
}
