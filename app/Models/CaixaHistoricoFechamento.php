<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * BUG-13 FIX: Modelo para auditoria de histórico de fechamentos
 * Mantém registro persistente de todos os fechamentos do caixa
 */
class CaixaHistoricoFechamento extends Model
{
    protected $table = 'caixa_historico_fechamentos';

    protected $fillable = [
        'usuario_id',
        'fechado_em',
        'total_entrada',
        'total_saida',
        'observacoes',
    ];

    protected $casts = [
        'fechado_em' => 'datetime',
        'total_entrada' => 'decimal:2',
        'total_saida' => 'decimal:2',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
