<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaixaFechamento extends Model
{
    protected $fillable = [
        'user_id',
        'reaberto_por',
        'fechado_em',
        'periodo_inicio',
        'periodo_fim',
        'reaberto_em',
        'total',
        'total_dinheiro',
        'total_pix',
        'total_cartao_debito',
        'total_cartao_credito',
        'total_compras',
        'total_sangrias',
        'valor_esperado_caixa',
        'total_pagamentos',
        'total_comandas_abertas',
        'relatorio',
    ];

    protected $casts = [
        'fechado_em'             => 'datetime',
        'periodo_inicio'         => 'datetime',
        'periodo_fim'            => 'datetime',
        'reaberto_em'            => 'datetime',
        'total'                  => 'float',
        'total_dinheiro'         => 'float',
        'total_pix'              => 'float',
        'total_cartao_debito'    => 'float',
        'total_cartao_credito'   => 'float',
        'total_compras'          => 'float',
        'total_sangrias'         => 'float',
        'valor_esperado_caixa'   => 'float',
        'total_pagamentos'       => 'integer',
        'total_comandas_abertas' => 'integer',
        'relatorio'              => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reabertoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reaberto_por');
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reabreEm(): Carbon
    {
        return $this->fechado_em->copy()->addDay()->setTime(10, 0, 0);
    }

    public static function fechadoAtual(): ?self
    {
        $fechamento = self::whereNull('reaberto_em')
            ->orderByDesc('fechado_em')
            ->first();

        if (!$fechamento) {
            return null;
        }

        $reabreEm = $fechamento->reabreEm();

        if (now()->greaterThanOrEqualTo($reabreEm)) {
            $fechamento->update(['reaberto_em' => $reabreEm]);
            return null;
        }

        return $fechamento;
    }
}
