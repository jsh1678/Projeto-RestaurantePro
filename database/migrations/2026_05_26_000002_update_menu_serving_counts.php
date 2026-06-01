<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        foreach ($this->servingCounts() as $name => $serves) {
            DB::table('menu_items')
                ->where('nome', $name)
                ->update([
                    'serves_count' => $serves,
                    'updated_at' => $now,
                ]);
        }
    }

    public function down(): void
    {
        DB::table('menu_items')->update([
            'serves_count' => 1,
            'updated_at' => now(),
        ]);
    }

    private function servingCounts(): array
    {
        return [
            'Coca-Cola 1L' => 3,
            'Refrigerante' => 1,
            'Suco Natural' => 1,
            'Agua Mineral' => 1,
            'Água Mineral' => 1,
            'Cerveja' => 1,
            'Cafe Expresso' => 1,
            'Café Expresso' => 1,
            'Batata Frita' => 2,
            'Batata Frita Crocante' => 2,
            'Batata Cheddar e Bacon' => 3,
            'Frango a Passarinho' => 3,
            'Calabresa Acebolada' => 3,
            'Camarao Empanado' => 2,
            'Camarão Empanado' => 2,
            'Isca de Peixe' => 2,
            'Isca de Peixe com Molho Tartaro' => 2,
            'Dadinho de Tapioca' => 2,
            'Macaxeira Frita com Manteiga da Terra' => 2,
            'Bolinho de Bacalhau da Casa' => 2,
            'Mini Pasteis Mistos' => 3,
            'Lasanha Bolonhesa' => 1,
            'Penne Quatro Queijos' => 1,
            'Espaguete ao Alho e Oleo' => 1,
            'Espaguete ao Alho e Óleo' => 1,
            'Fettuccine Alfredo com Frango' => 1,
            'Nhoque ao Sugo' => 1,
            'Ravioli de Queijo ao Pomodoro' => 1,
            'Talharim com Camarao' => 1,
            'Talharim com Camarão' => 1,
            'Linguine ao Pesto' => 1,
            'Arroz Branco' => 1,
            'Arroz branco' => 1,
            'Pure de Batata' => 1,
            'Purê de Batata' => 1,
            'Farofa da Casa' => 1,
            'Farofa' => 1,
            'Macaxeira Frita' => 1,
            'Feijao Tropeiro' => 2,
            'Feijão Tropeiro' => 2,
            'Legumes Grelhados' => 1,
            'Arroz de Brocolis' => 1,
            'Arroz de Brócolis' => 1,
            'Salada Verde' => 1,
            'Picanha Grelhada' => 2,
            'File Mignon Grelhado' => 1,
            'Filé Mignon Grelhado' => 1,
            'Frango Grelhado' => 1,
            'Tilapia Grelhada' => 1,
            'Tilápia Grelhada' => 1,
            'Contra-File Acebolado' => 1,
            'Contra-Filé Acebolado' => 1,
            'Costela Suina Barbecue' => 2,
            'Costela Suína Barbecue' => 2,
            'Espeto Misto Premium' => 2,
            'Camarao na Brasa' => 2,
            'Camarão na Brasa' => 2,
            'Baiao de Dois' => 2,
            'Baião de Dois' => 2,
            'Parmegiana de Frango' => 1,
            'Feijoada Completa' => 2,
            'Strogonoff de Carne' => 1,
            'Strogonoff de Frango' => 1,
            'Risoto de Camarao' => 1,
            'Risoto de Camarão' => 1,
            'Moqueca de Tilapia' => 2,
            'Moqueca de Tilápia' => 2,
            'Carne de Sol com Macaxeira' => 2,
            'File a Oswaldo Aranha' => 1,
            'Filé à Oswaldo Aranha' => 1,
            'Galinhada da Casa' => 1,
            'Executivo de Picanha' => 1,
            'Tilapia a Belle Meuniere' => 1,
            'Tilápia à Belle Meunière' => 1,
        ];
    }
};
