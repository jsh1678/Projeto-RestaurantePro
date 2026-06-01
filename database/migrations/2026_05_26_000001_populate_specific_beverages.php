<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $categoryId = DB::table('categories')->where('nome', 'Bebidas')->value('id');

        if (!$categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'nome' => 'Bebidas',
                'descricao' => 'Bebidas geladas, sucos naturais e opcoes para acompanhar a refeicao.',
                'tipo_principal' => 'bebida',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('menu_items')
            ->whereIn('nome', [
                'Refrigerante',
                'Suco Natural',
                'Agua Mineral',
                'Água Mineral',
                'µgua Mineral',
                'Cerveja',
                'Cafe Expresso',
                'Café Expresso',
                'Caf‚ Expresso',
            ])
            ->update([
                'disponivel' => false,
                'updated_at' => $now,
            ]);

        foreach ($this->beverages() as $item) {
            $existingId = DB::table('menu_items')->where('nome', $item['nome'])->value('id');

            $data = [
                'category_id' => $categoryId,
                'stock_item_id' => null,
                'descricao' => $item['descricao'],
                'preco' => $item['preco'],
                'disponivel' => true,
                'serves_count' => 1,
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
            ->whereIn('nome', array_column($this->beverages(), 'nome'))
            ->delete();

        DB::table('menu_items')
            ->whereIn('nome', [
                'Refrigerante',
                'Suco Natural',
                'Agua Mineral',
                'Água Mineral',
                'µgua Mineral',
                'Cerveja',
                'Cafe Expresso',
                'Café Expresso',
                'Caf‚ Expresso',
            ])
            ->update([
                'disponivel' => true,
                'updated_at' => now(),
            ]);
    }

    private function beverages(): array
    {
        return [
            ['nome' => 'Coca-Cola Lata', 'descricao' => 'Coca-Cola tradicional 350ml servida bem gelada', 'preco' => 7.90, 'subtipo' => 'Refrigerante'],
            ['nome' => 'Coca-Cola 1L', 'descricao' => 'Garrafa de Coca-Cola 1 litro para compartilhar', 'preco' => 13.90, 'subtipo' => 'Refrigerante'],
            ['nome' => 'Guarana Antarctica Lata', 'descricao' => 'Guarana Antarctica 350ml com sabor brasileiro', 'preco' => 7.50, 'subtipo' => 'Refrigerante'],
            ['nome' => 'Fanta Laranja Lata', 'descricao' => 'Refrigerante de laranja 350ml', 'preco' => 7.50, 'subtipo' => 'Refrigerante'],
            ['nome' => 'Sprite Lata', 'descricao' => 'Refrigerante citrus 350ml leve e refrescante', 'preco' => 7.50, 'subtipo' => 'Refrigerante'],
            ['nome' => 'Suco de Laranja Natural', 'descricao' => 'Suco natural de laranja espremido na hora', 'preco' => 11.90, 'subtipo' => 'Suco'],
            ['nome' => 'Suco de Maracuja', 'descricao' => 'Suco natural de maracuja com equilibrio entre acidez e frescor', 'preco' => 12.90, 'subtipo' => 'Suco'],
            ['nome' => 'Agua Mineral Sem Gas', 'descricao' => 'Agua mineral sem gas 500ml', 'preco' => 4.90, 'subtipo' => 'Agua'],
            ['nome' => 'Agua Mineral Com Gas', 'descricao' => 'Agua mineral com gas 500ml', 'preco' => 5.50, 'subtipo' => 'Agua'],
            ['nome' => 'Cha Gelado de Limao', 'descricao' => 'Cha preto gelado com limao', 'preco' => 8.90, 'subtipo' => 'Cha'],
        ];
    }
};
