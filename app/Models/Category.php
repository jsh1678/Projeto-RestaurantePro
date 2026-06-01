<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['nome', 'descricao', 'tipo_principal'];

    public function menuItems(): HasMany
    {
<<<<<<< HEAD
        return $this->hasMany(MenuItem::class)
            ->where('disponivel', true)
            ->orderBy('nome');
=======
        return $this->hasMany(MenuItem::class);
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    }
}
