<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $categoryId = DB::table('categories')->where('nome', 'Petiscos')->value('id');

        if (!$categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'nome' => 'Petiscos',
                'descricao' => 'Porcoes e entradas para compartilhar.',
                'tipo_principal' => 'entrada',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($this->petiscos() as $item) {
            $existingId = DB::table('menu_items')->where('nome', $item['nome'])->value('id');

            $data = [
                'category_id' => $categoryId,
                'stock_item_id' => null,
                'descricao' => $item['descricao'],
                'preco' => $item['preco'],
                'disponivel' => $item['disponivel'],
                'serves_count' => $item['serves_count'],
                'subtipo' => $item['subtipo'],
                'updated_at' => $now,
            ];

            if ($existingId) {
                DB::table('menu_items')->where('id', $existingId)->update($data);
                continue;
            }

            DB::table('menu_items')->insert(array_merge($data, [
                'nome' => $item['nome'],
                'created_at' => $now,
            ]));
        }
    }

    public function down(): void
    {
        DB::table('menu_items')
            ->whereIn('nome', array_column($this->petiscos(), 'nome'))
            ->delete();
    }

    private function petiscos(): array
    {
        return [
            [
                'nome' => 'Batata Frita Crocante',
                'descricao' => 'Batatas palito sequinhas, finalizadas com flor de sal e maionese da casa.',
                'preco' => 24.90,
                'disponivel' => true,
                'serves_count' => 2,
                'subtipo' => 'Porcao',
            ],
            [
                'nome' => 'Batata Cheddar e Bacon',
                'descricao' => 'Batata frita coberta com cheddar cremoso, bacon crocante e cebolinha.',
                'preco' => 32.90,
                'disponivel' => true,
                'serves_count' => 3,
                'subtipo' => 'Porcao',
            ],
            [
                'nome' => 'Frango a Passarinho',
                'descricao' => 'Pedacos de frango temperados, fritos e finalizados com alho dourado.',
                'preco' => 39.90,
                'disponivel' => true,
                'serves_count' => 3,
                'subtipo' => 'Frango',
            ],
            [
                'nome' => 'Calabresa Acebolada',
                'descricao' => 'Calabresa defumada na chapa com cebola caramelizada e cheiro-verde.',
                'preco' => 34.90,
                'disponivel' => true,
                'serves_count' => 3,
                'subtipo' => 'Chapa',
            ],
            [
                'nome' => 'Camarao Empanado',
                'descricao' => 'Camaroes empanados em farinha crocante servidos com molho especial.',
                'preco' => 54.90,
                'disponivel' => true,
                'serves_count' => 2,
                'subtipo' => 'Frutos do Mar',
            ],
            [
                'nome' => 'Isca de Peixe com Molho Tartaro',
                'descricao' => 'Iscas de tilapia empanadas, douradas e servidas com molho tartaro.',
                'preco' => 42.90,
                'disponivel' => true,
                'serves_count' => 2,
                'subtipo' => 'Peixe',
            ],
            [
                'nome' => 'Dadinho de Tapioca',
                'descricao' => 'Cubos de tapioca com queijo coalho acompanhados de geleia agridoce.',
                'preco' => 31.90,
                'disponivel' => true,
                'serves_count' => 2,
                'subtipo' => 'Vegetariano',
            ],
            [
                'nome' => 'Macaxeira Frita com Manteiga da Terra',
                'descricao' => 'Macaxeira cozida e frita, servida com manteiga da terra e ervas.',
                'preco' => 26.90,
                'disponivel' => true,
                'serves_count' => 2,
                'subtipo' => 'Regional',
            ],
            [
                'nome' => 'Bolinho de Bacalhau da Casa',
                'descricao' => 'Bolinho cremoso por dentro, dourado por fora e temperado com ervas frescas.',
                'preco' => 38.90,
                'disponivel' => true,
                'serves_count' => 2,
                'subtipo' => 'Porcao',
            ],
            [
                'nome' => 'Mini Pasteis Mistos',
                'descricao' => 'Pasteis pequenos com recheios de carne, queijo e frango.',
                'preco' => 35.90,
                'disponivel' => true,
                'serves_count' => 3,
                'subtipo' => 'Porcao',
            ],
        ];
    }
};
