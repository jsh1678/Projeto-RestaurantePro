<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'category_id', 'nome', 'descricao', 'preco', 'disponivel',
        'stock_item_id', 'serves_count', 'subtipo', 'imagem', 'imagem_dados', 'imagem_mime', 'arquivado_em'
    ];

    protected $casts = [
        'disponivel' => 'boolean',
        'arquivado_em' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function stockItem(): BelongsTo
    {
        return $this->belongsTo(StockItem::class);
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(MenuItemIngredient::class);
    }
}
