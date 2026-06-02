<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class MenuItem extends Model
{
    protected $fillable = [
        'category_id', 'nome', 'descricao', 'preco', 'disponivel',
        'stock_item_id', 'serves_count', 'subtipo', 'imagem'
    ];

    protected $appends = ['imagem_url'];

    public function getImagemUrlAttribute(): ?string
    {
        if (!$this->imagem) {
            return null;
        }

        if (Str::startsWith($this->imagem, ['http://', 'https://', '//'])) {
            return $this->imagem;
        }

        $path = ltrim($this->imagem, '/');

        if (!File::exists(public_path($path))) {
            return null;
        }

        $basePath = rtrim(Request::getBasePath(), '/');

        return $basePath.'/'.str_replace('\\', '/', $path);
    }

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
