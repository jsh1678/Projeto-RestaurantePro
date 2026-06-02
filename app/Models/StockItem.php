<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockItem extends Model
{
    protected $fillable = ['nome', 'descricao', 'unidade', 'quantidade_atual', 'quantidade_minima', 'preco_unitario', 'unidade_original', 'usa_gramas'];

    public function movimentos(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function ingredientes(): HasMany
    {
        return $this->hasMany(MenuItemIngredient::class);
    }

    // ── [FIX #5] Lógica de negócio movida do @php no Blade para o Model ──────

    /**
     * Retorna true se a unidade é baseada em peso (kg ou variações de grama).
     */
    public function getIsPesoAttribute(): bool
    {
        $u = strtolower($this->unidade ?? '');
        return in_array($u, ['kg', 'g', 'gramas', 'grama']);
    }

    /**
     * Retorna a quantidade formatada com unidade legível.
     * Ex: 1.500 → "1,500 kg" | 750 → "750 g" | 3 → "3 un"
     */
    public function getQuantidadeFormatadaAttribute(): string
    {
        $qtd = $this->quantidade_atual ?? 0;
        $u   = strtolower($this->unidade ?? '');

        if (in_array($u, ['kg', 'g', 'gramas', 'grama'])) {
            if ($qtd >= 1000 && $u === 'g') {
                return number_format($qtd / 1000, 3, ',', '.') . ' kg';
            }
            return number_format($qtd, 3, ',', '.') . ' ' . $u;
        }

        return number_format($qtd, 2, ',', '.') . ' ' . ($this->unidade ?? 'un');
    }

    /**
     * Retorna true se o estoque está abaixo do mínimo.
     */
    public function getEstoqueBaixoAttribute(): bool
    {
        return ($this->quantidade_atual ?? 0) <= ($this->quantidade_minima ?? 0);
    }

    /**
     * Retorna a label da situação do estoque para exibição em badge.
     * Retorna: 'success' | 'warning' | 'danger'
     */
    public function getSituacaoEstoqueAttribute(): string
    {
        $atual = $this->quantidade_atual ?? 0;
        $min   = $this->quantidade_minima ?? 0;

        if ($atual <= 0)        return 'danger';
        if ($atual <= $min)     return 'warning';
        return 'success';
    }
}
