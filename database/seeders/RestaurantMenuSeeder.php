<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\StockItem;
use Illuminate\Database\Seeder;

class RestaurantMenuSeeder extends Seeder
{
    public function run(): void
    {
        $faker = fake('pt_BR');

        $categories = $this->categories();
        $stock = $this->stockItems();

        foreach ($categories as $name => $data) {
            $categories[$name]['model'] = Category::updateOrCreate(
                ['nome' => $name],
                [
                    'descricao' => $data['descricao'],
                    'tipo_principal' => $data['tipo_principal'],
                ]
            );
        }

        $stockModels = [];
        foreach ($stock as $item) {
            $stockModels[$item['nome']] = StockItem::updateOrCreate(
                ['nome' => $item['nome']],
                [
                    'descricao' => $item['descricao'],
                    'unidade' => $item['unidade'],
                    'unidade_original' => $item['unidade'],
                    'usa_gramas' => in_array($item['unidade'], ['kg', 'g'], true),
                    'quantidade_atual' => $item['quantidade_atual'],
                    'quantidade_minima' => $item['quantidade_minima'],
                    'preco_unitario' => $item['preco_unitario'],
                ]
            );
        }

        $this->hideLegacyGenericItems();

        foreach ($this->menuItems() as $item) {
            $category = $categories[$item['categoria']]['model'];
            $mainStockName = $item['ingredientes'][0][0] ?? null;
            $mainStock = $mainStockName ? ($stockModels[$mainStockName] ?? null) : null;

            $descricao = $this->buildDescription($item, $faker->randomElement([
                'preparo artesanal',
                'finalizacao da casa',
                'ingredientes selecionados',
                'padrao executivo',
            ]));

            $menuItem = MenuItem::updateOrCreate(
                ['nome' => $item['nome']],
                [
                    'category_id' => $category->id,
                    'stock_item_id' => $mainStock?->id,
                    'descricao' => $descricao,
                    'preco' => $item['preco'],
                    'disponivel' => $item['disponivel'],
                    'serves_count' => $item['serve'] ?? $this->servingByName($item['nome']),
                    'subtipo' => $item['subtipo'] ?? null,
                ]
            );

            $menuItem->ingredients()->delete();

            foreach ($item['ingredientes'] as [$stockName, $quantity]) {
                if (!isset($stockModels[$stockName])) {
                    continue;
                }

                $menuItem->ingredients()->create([
                    'stock_item_id' => $stockModels[$stockName]->id,
                    'quantidade' => $quantity,
                    'quantidade_gramas' => $this->quantityInGrams($stockModels[$stockName]->unidade, $quantity),
                ]);
            }
        }
    }

    private function buildDescription(array $item, string $detail): string
    {
        $tags = [];

        if (!empty($item['destaque'])) {
            $tags[] = 'Destaque da casa';
        }

        if (!empty($item['mais_vendido'])) {
            $tags[] = 'Mais vendido';
        }

        if (empty($item['disponivel'])) {
            $tags[] = 'Temporariamente indisponivel';
        }

        $optional = empty($item['adicionais'])
            ? ''
            : ' Opcionais: ' . implode(', ', $item['adicionais']) . '.';

        return sprintf(
            '%s %s. Tempo medio de preparo: %d min. Imagem: %s.%s%s',
            $item['descricao'],
            ucfirst($detail),
            $item['tempo'],
            $item['imagem'],
            $optional,
            $tags ? ' ' . implode(' | ', $tags) . '.' : ''
        );
    }

    private function quantityInGrams(string $unit, float $quantity): float
    {
        return match ($unit) {
            'kg' => $quantity * 1000,
            'g' => $quantity,
            default => 0,
        };
    }

    private function hideLegacyGenericItems(): void
    {
        MenuItem::whereIn('nome', [
            'Refrigerante',
            'Suco Natural',
            'Agua Mineral',
            'Água Mineral',
            'Cerveja',
            'Cafe Expresso',
            'Café Expresso',
        ])->update(['disponivel' => false]);
    }

    private function servingByName(string $name): int
    {
        return $this->servingMap()[$name] ?? 1;
    }

    private function servingMap(): array
    {
        return [
            'Coca-Cola 1L' => 3,
            'Batata Frita Crocante' => 2,
            'Batata Cheddar e Bacon' => 3,
            'Frango a Passarinho' => 3,
            'Calabresa Acebolada' => 3,
            'Camarao Empanado' => 2,
            'Isca de Peixe com Molho Tartaro' => 2,
            'Dadinho de Tapioca' => 2,
            'Macaxeira Frita com Manteiga da Terra' => 2,
            'Bolinho de Bacalhau da Casa' => 2,
            'Mini Pasteis Mistos' => 3,
            'Lasanha Bolonhesa' => 2,
            'Talharim com Camarao' => 2,
            'Farofa da Casa' => 2,
            'Macaxeira Frita' => 2,
            'Feijao Tropeiro' => 2,
            'Picanha Grelhada' => 2,
            'Contra-File Acebolado' => 2,
            'Costela Suina Barbecue' => 3,
            'Espeto Misto Premium' => 2,
            'Camarao na Brasa' => 2,
            'Baiao de Dois' => 2,
            'Feijoada Completa' => 2,
            'Moqueca de Tilapia' => 2,
            'Carne de Sol com Macaxeira' => 2,
            'Galinhada da Casa' => 2,
        ];
    }

    private function categories(): array
    {
        return [
            'Bebidas' => [
                'descricao' => 'Bebidas geladas, sucos naturais e opcoes para acompanhar a refeicao.',
                'tipo_principal' => 'bebida',
            ],
            'Petiscos' => [
                'descricao' => 'Porcoes e entradas para compartilhar.',
                'tipo_principal' => 'entrada',
            ],
            'Massas' => [
                'descricao' => 'Massas classicas com molhos da casa.',
                'tipo_principal' => 'prato_principal',
            ],
            'Acompanhamentos' => [
                'descricao' => 'Guarnicoes individuais para complementar os pratos.',
                'tipo_principal' => 'acompanhamento',
            ],
            'Grelhados' => [
                'descricao' => 'Carnes, aves e peixes preparados na grelha.',
                'tipo_principal' => 'prato_principal',
            ],
            'Pratos Principais' => [
                'descricao' => 'Pratos completos de cozinha brasileira e contemporanea.',
                'tipo_principal' => 'prato_principal',
            ],
        ];
    }

    private function stockItems(): array
    {
        return [
            ['nome' => 'Refrigerante Lata', 'descricao' => 'Refrigerantes em lata 350ml', 'unidade' => 'un', 'quantidade_atual' => 180, 'quantidade_minima' => 30, 'preco_unitario' => 3.2],
            ['nome' => 'Refrigerante 1L', 'descricao' => 'Refrigerantes garrafa 1 litro', 'unidade' => 'un', 'quantidade_atual' => 70, 'quantidade_minima' => 15, 'preco_unitario' => 6.4],
            ['nome' => 'Agua Mineral', 'descricao' => 'Agua mineral com e sem gas', 'unidade' => 'un', 'quantidade_atual' => 160, 'quantidade_minima' => 40, 'preco_unitario' => 1.6],
            ['nome' => 'Suco Natural', 'descricao' => 'Polpas e frutas para sucos naturais', 'unidade' => 'un', 'quantidade_atual' => 90, 'quantidade_minima' => 20, 'preco_unitario' => 4.5],
            ['nome' => 'Cha Gelado', 'descricao' => 'Cha pronto gelado', 'unidade' => 'un', 'quantidade_atual' => 55, 'quantidade_minima' => 12, 'preco_unitario' => 3.8],
            ['nome' => 'Batata', 'descricao' => 'Batata inglesa selecionada', 'unidade' => 'kg', 'quantidade_atual' => 75, 'quantidade_minima' => 15, 'preco_unitario' => 4.2],
            ['nome' => 'Frango', 'descricao' => 'Cortes de frango resfriado', 'unidade' => 'kg', 'quantidade_atual' => 55, 'quantidade_minima' => 12, 'preco_unitario' => 13.9],
            ['nome' => 'Calabresa', 'descricao' => 'Linguica calabresa defumada', 'unidade' => 'kg', 'quantidade_atual' => 30, 'quantidade_minima' => 6, 'preco_unitario' => 21.5],
            ['nome' => 'Camarao', 'descricao' => 'Camarao limpo medio', 'unidade' => 'kg', 'quantidade_atual' => 22, 'quantidade_minima' => 5, 'preco_unitario' => 58.0],
            ['nome' => 'Queijo', 'descricao' => 'Mix de queijos e mussarela', 'unidade' => 'kg', 'quantidade_atual' => 28, 'quantidade_minima' => 6, 'preco_unitario' => 34.0],
            ['nome' => 'Bacon', 'descricao' => 'Bacon em cubos', 'unidade' => 'kg', 'quantidade_atual' => 18, 'quantidade_minima' => 4, 'preco_unitario' => 31.0],
            ['nome' => 'Mandioca', 'descricao' => 'Macaxeira descascada', 'unidade' => 'kg', 'quantidade_atual' => 40, 'quantidade_minima' => 8, 'preco_unitario' => 6.5],
            ['nome' => 'Massa Seca', 'descricao' => 'Massas secas variadas', 'unidade' => 'kg', 'quantidade_atual' => 45, 'quantidade_minima' => 10, 'preco_unitario' => 8.8],
            ['nome' => 'Molho de Tomate', 'descricao' => 'Base de tomate para molhos', 'unidade' => 'kg', 'quantidade_atual' => 35, 'quantidade_minima' => 8, 'preco_unitario' => 7.2],
            ['nome' => 'Creme de Leite', 'descricao' => 'Creme culinario', 'unidade' => 'kg', 'quantidade_atual' => 18, 'quantidade_minima' => 5, 'preco_unitario' => 14.0],
            ['nome' => 'Arroz', 'descricao' => 'Arroz branco tipo 1', 'unidade' => 'kg', 'quantidade_atual' => 95, 'quantidade_minima' => 20, 'preco_unitario' => 5.9],
            ['nome' => 'Feijao', 'descricao' => 'Feijao carioca e preto', 'unidade' => 'kg', 'quantidade_atual' => 55, 'quantidade_minima' => 12, 'preco_unitario' => 8.4],
            ['nome' => 'Farinha', 'descricao' => 'Farinha de mandioca torrada', 'unidade' => 'kg', 'quantidade_atual' => 35, 'quantidade_minima' => 7, 'preco_unitario' => 6.2],
            ['nome' => 'Carne Vermelha', 'descricao' => 'Cortes bovinos para chapa e grelha', 'unidade' => 'kg', 'quantidade_atual' => 48, 'quantidade_minima' => 10, 'preco_unitario' => 42.0],
            ['nome' => 'File Mignon', 'descricao' => 'File mignon bovino limpo', 'unidade' => 'kg', 'quantidade_atual' => 24, 'quantidade_minima' => 5, 'preco_unitario' => 72.0],
            ['nome' => 'Picanha', 'descricao' => 'Picanha bovina premium', 'unidade' => 'kg', 'quantidade_atual' => 26, 'quantidade_minima' => 5, 'preco_unitario' => 78.0],
            ['nome' => 'Peixe Tilapia', 'descricao' => 'File de tilapia fresco', 'unidade' => 'kg', 'quantidade_atual' => 28, 'quantidade_minima' => 6, 'preco_unitario' => 32.0],
            ['nome' => 'Costela Suina', 'descricao' => 'Costela suina temperada', 'unidade' => 'kg', 'quantidade_atual' => 24, 'quantidade_minima' => 5, 'preco_unitario' => 28.0],
            ['nome' => 'Legumes', 'descricao' => 'Legumes frescos variados', 'unidade' => 'kg', 'quantidade_atual' => 45, 'quantidade_minima' => 10, 'preco_unitario' => 9.5],
        ];
    }

    private function menuItems(): array
    {
        $img = fn (string $slug) => "https://placehold.co/800x600?text={$slug}";

        return [
            ['categoria' => 'Bebidas', 'nome' => 'Coca-Cola Lata', 'descricao' => 'Coca-Cola tradicional 350ml servida bem gelada', 'preco' => 7.9, 'tempo' => 2, 'imagem' => $img('coca-cola-lata'), 'disponivel' => true, 'subtipo' => 'Refrigerante', 'destaque' => true, 'mais_vendido' => true, 'ingredientes' => [['Refrigerante Lata', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Coca-Cola 1L', 'descricao' => 'Garrafa de Coca-Cola 1 litro para compartilhar', 'preco' => 13.9, 'tempo' => 2, 'imagem' => $img('coca-cola-1l'), 'disponivel' => true, 'subtipo' => 'Refrigerante', 'mais_vendido' => true, 'ingredientes' => [['Refrigerante 1L', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Guarana Antarctica Lata', 'descricao' => 'Guarana Antarctica 350ml com sabor brasileiro', 'preco' => 7.5, 'tempo' => 2, 'imagem' => $img('guarana-antarctica'), 'disponivel' => true, 'subtipo' => 'Refrigerante', 'ingredientes' => [['Refrigerante Lata', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Fanta Laranja Lata', 'descricao' => 'Refrigerante de laranja 350ml', 'preco' => 7.5, 'tempo' => 2, 'imagem' => $img('fanta-laranja'), 'disponivel' => true, 'subtipo' => 'Refrigerante', 'ingredientes' => [['Refrigerante Lata', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Sprite Lata', 'descricao' => 'Refrigerante citrus 350ml leve e refrescante', 'preco' => 7.5, 'tempo' => 2, 'imagem' => $img('sprite-lata'), 'disponivel' => true, 'subtipo' => 'Refrigerante', 'ingredientes' => [['Refrigerante Lata', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Suco de Laranja Natural', 'descricao' => 'Suco natural de laranja espremido na hora', 'preco' => 11.9, 'tempo' => 6, 'imagem' => $img('suco-laranja'), 'disponivel' => true, 'subtipo' => 'Suco', 'destaque' => true, 'ingredientes' => [['Suco Natural', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Suco de Maracuja', 'descricao' => 'Suco natural de maracuja com equilibrio entre acidez e frescor', 'preco' => 12.9, 'tempo' => 6, 'imagem' => $img('suco-maracuja'), 'disponivel' => true, 'subtipo' => 'Suco', 'ingredientes' => [['Suco Natural', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Agua Mineral Sem Gas', 'descricao' => 'Agua mineral 500ml', 'preco' => 4.9, 'tempo' => 1, 'imagem' => $img('agua-sem-gas'), 'disponivel' => true, 'subtipo' => 'Agua', 'ingredientes' => [['Agua Mineral', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Agua Mineral Com Gas', 'descricao' => 'Agua mineral com gas 500ml', 'preco' => 5.5, 'tempo' => 1, 'imagem' => $img('agua-com-gas'), 'disponivel' => false, 'subtipo' => 'Agua', 'ingredientes' => [['Agua Mineral', 1]]],
            ['categoria' => 'Bebidas', 'nome' => 'Cha Gelado de Limao', 'descricao' => 'Cha preto gelado com limao', 'preco' => 8.9, 'tempo' => 2, 'imagem' => $img('cha-gelado-limao'), 'disponivel' => true, 'subtipo' => 'Cha', 'ingredientes' => [['Cha Gelado', 1]]],

            ['categoria' => 'Petiscos', 'nome' => 'Batata Frita Crocante', 'descricao' => 'Batatas palito fritas, sequinhas e finalizadas com flor de sal', 'preco' => 24.9, 'tempo' => 14, 'imagem' => $img('batata-frita'), 'disponivel' => true, 'subtipo' => 'Porcao', 'mais_vendido' => true, 'adicionais' => ['cheddar', 'bacon', 'maionese da casa'], 'ingredientes' => [['Batata', 0.45]]],
            ['categoria' => 'Petiscos', 'nome' => 'Batata Cheddar e Bacon', 'descricao' => 'Batata frita coberta com cheddar cremoso e bacon crocante', 'preco' => 32.9, 'tempo' => 16, 'imagem' => $img('batata-cheddar-bacon'), 'disponivel' => true, 'subtipo' => 'Porcao', 'destaque' => true, 'mais_vendido' => true, 'adicionais' => ['catupiry', 'cebolinha', 'molho barbecue'], 'ingredientes' => [['Batata', 0.5], ['Queijo', 0.12], ['Bacon', 0.08]]],
            ['categoria' => 'Petiscos', 'nome' => 'Frango a Passarinho', 'descricao' => 'Pedacos de frango temperados, fritos e finalizados com alho dourado', 'preco' => 39.9, 'tempo' => 24, 'imagem' => $img('frango-passarinho'), 'disponivel' => true, 'subtipo' => 'Frango', 'ingredientes' => [['Frango', 0.6]]],
            ['categoria' => 'Petiscos', 'nome' => 'Calabresa Acebolada', 'descricao' => 'Calabresa na chapa com cebola caramelizada e cheiro-verde', 'preco' => 34.9, 'tempo' => 18, 'imagem' => $img('calabresa-acebolada'), 'disponivel' => true, 'subtipo' => 'Chapa', 'ingredientes' => [['Calabresa', 0.45]]],
            ['categoria' => 'Petiscos', 'nome' => 'Camarao Empanado', 'descricao' => 'Camaroes empanados em farinha crocante com molho especial', 'preco' => 54.9, 'tempo' => 22, 'imagem' => $img('camarao-empanado'), 'disponivel' => true, 'subtipo' => 'Frutos do Mar', 'destaque' => true, 'ingredientes' => [['Camarao', 0.32]]],
            ['categoria' => 'Petiscos', 'nome' => 'Isca de Peixe com Molho Tartaro', 'descricao' => 'Iscas de tilapia empanadas servidas com molho tartaro', 'preco' => 42.9, 'tempo' => 20, 'imagem' => $img('isca-peixe'), 'disponivel' => true, 'subtipo' => 'Peixe', 'ingredientes' => [['Peixe Tilapia', 0.4]]],
            ['categoria' => 'Petiscos', 'nome' => 'Dadinho de Tapioca', 'descricao' => 'Cubos de tapioca com queijo coalho e geleia agridoce', 'preco' => 31.9, 'tempo' => 18, 'imagem' => $img('dadinho-tapioca'), 'disponivel' => true, 'subtipo' => 'Vegetariano', 'ingredientes' => [['Queijo', 0.16], ['Farinha', 0.12]]],
            ['categoria' => 'Petiscos', 'nome' => 'Macaxeira Frita com Manteiga da Terra', 'descricao' => 'Macaxeira cozida e frita, servida com manteiga da terra', 'preco' => 26.9, 'tempo' => 17, 'imagem' => $img('macaxeira-frita'), 'disponivel' => false, 'subtipo' => 'Regional', 'ingredientes' => [['Mandioca', 0.5]]],
            ['categoria' => 'Petiscos', 'nome' => 'Bolinho de Bacalhau da Casa', 'descricao' => 'Bolinho cremoso e dourado com tempero fresco', 'preco' => 38.9, 'tempo' => 20, 'imagem' => $img('bolinho-bacalhau'), 'disponivel' => true, 'subtipo' => 'Porcao', 'ingredientes' => [['Peixe Tilapia', 0.2], ['Batata', 0.2]]],
            ['categoria' => 'Petiscos', 'nome' => 'Mini Pasteis Mistos', 'descricao' => 'Pasteis pequenos recheados com carne, queijo e frango', 'preco' => 35.9, 'tempo' => 19, 'imagem' => $img('mini-pasteis'), 'disponivel' => true, 'subtipo' => 'Porcao', 'ingredientes' => [['Massa Seca', 0.25], ['Carne Vermelha', 0.18], ['Queijo', 0.08]]],

            ['categoria' => 'Massas', 'nome' => 'Lasanha Bolonhesa', 'descricao' => 'Lasanha em camadas com ragu bolonhesa, bechamel e queijo gratinado', 'preco' => 43.9, 'tempo' => 32, 'imagem' => $img('lasanha-bolonhesa'), 'disponivel' => true, 'subtipo' => 'Carne', 'destaque' => true, 'ingredientes' => [['Massa Seca', 0.22], ['Carne Vermelha', 0.18], ['Molho de Tomate', 0.18], ['Queijo', 0.1]]],
            ['categoria' => 'Massas', 'nome' => 'Penne Quatro Queijos', 'descricao' => 'Penne envolto em molho cremoso de quatro queijos', 'preco' => 39.9, 'tempo' => 24, 'imagem' => $img('penne-quatro-queijos'), 'disponivel' => true, 'subtipo' => 'Vegetariano', 'adicionais' => ['frango grelhado', 'bacon crocante'], 'ingredientes' => [['Massa Seca', 0.2], ['Queijo', 0.18], ['Creme de Leite', 0.12]]],
            ['categoria' => 'Massas', 'nome' => 'Espaguete ao Alho e Oleo', 'descricao' => 'Espaguete al dente com alho dourado, azeite e salsa fresca', 'preco' => 31.9, 'tempo' => 18, 'imagem' => $img('espaguete-alho-oleo'), 'disponivel' => true, 'subtipo' => 'Vegetariano', 'ingredientes' => [['Massa Seca', 0.22]]],
            ['categoria' => 'Massas', 'nome' => 'Fettuccine Alfredo com Frango', 'descricao' => 'Fettuccine em molho Alfredo com tiras de frango grelhado', 'preco' => 42.9, 'tempo' => 26, 'imagem' => $img('fettuccine-alfredo'), 'disponivel' => true, 'subtipo' => 'Frango', 'mais_vendido' => true, 'ingredientes' => [['Massa Seca', 0.2], ['Frango', 0.18], ['Creme de Leite', 0.12], ['Queijo', 0.08]]],
            ['categoria' => 'Massas', 'nome' => 'Nhoque ao Sugo', 'descricao' => 'Nhoque macio com molho de tomate rustico e parmesao', 'preco' => 36.9, 'tempo' => 24, 'imagem' => $img('nhoque-sugo'), 'disponivel' => true, 'subtipo' => 'Vegetariano', 'ingredientes' => [['Batata', 0.28], ['Molho de Tomate', 0.18], ['Queijo', 0.05]]],
            ['categoria' => 'Massas', 'nome' => 'Ravioli de Queijo ao Pomodoro', 'descricao' => 'Ravioli recheado de queijo com molho pomodoro fresco', 'preco' => 44.9, 'tempo' => 28, 'imagem' => $img('ravioli-queijo'), 'disponivel' => false, 'subtipo' => 'Vegetariano', 'ingredientes' => [['Massa Seca', 0.22], ['Queijo', 0.16], ['Molho de Tomate', 0.16]]],
            ['categoria' => 'Massas', 'nome' => 'Talharim com Camarao', 'descricao' => 'Talharim ao molho cremoso com camaroes salteados', 'preco' => 58.9, 'tempo' => 30, 'imagem' => $img('talharim-camarao'), 'disponivel' => true, 'subtipo' => 'Frutos do Mar', 'destaque' => true, 'ingredientes' => [['Massa Seca', 0.2], ['Camarao', 0.22], ['Creme de Leite', 0.1]]],
            ['categoria' => 'Massas', 'nome' => 'Linguine ao Pesto', 'descricao' => 'Linguine com pesto de manjericao, castanhas e parmesao', 'preco' => 38.9, 'tempo' => 22, 'imagem' => $img('linguine-pesto'), 'disponivel' => true, 'subtipo' => 'Vegetariano', 'ingredientes' => [['Massa Seca', 0.22], ['Queijo', 0.06]]],

            ['categoria' => 'Acompanhamentos', 'nome' => 'Arroz Branco', 'descricao' => 'Arroz branco soltinho preparado diariamente', 'preco' => 9.9, 'tempo' => 8, 'imagem' => $img('arroz-branco'), 'disponivel' => true, 'subtipo' => 'Guarnicao', 'ingredientes' => [['Arroz', 0.16]]],
            ['categoria' => 'Acompanhamentos', 'nome' => 'Pure de Batata', 'descricao' => 'Pure de batata cremoso com toque de manteiga', 'preco' => 13.9, 'tempo' => 10, 'imagem' => $img('pure-batata'), 'disponivel' => true, 'subtipo' => 'Guarnicao', 'ingredientes' => [['Batata', 0.25], ['Creme de Leite', 0.04]]],
            ['categoria' => 'Acompanhamentos', 'nome' => 'Farofa da Casa', 'descricao' => 'Farofa crocante com manteiga, cebola e ervas', 'preco' => 11.9, 'tempo' => 7, 'imagem' => $img('farofa-casa'), 'disponivel' => true, 'subtipo' => 'Guarnicao', 'ingredientes' => [['Farinha', 0.12]]],
            ['categoria' => 'Acompanhamentos', 'nome' => 'Macaxeira Frita', 'descricao' => 'Macaxeira frita dourada por fora e macia por dentro', 'preco' => 16.9, 'tempo' => 14, 'imagem' => $img('macaxeira-frita-acomp'), 'disponivel' => true, 'subtipo' => 'Regional', 'ingredientes' => [['Mandioca', 0.28]]],
            ['categoria' => 'Acompanhamentos', 'nome' => 'Feijao Tropeiro', 'descricao' => 'Feijao com farinha, bacon e temperos frescos', 'preco' => 18.9, 'tempo' => 16, 'imagem' => $img('feijao-tropeiro'), 'disponivel' => true, 'subtipo' => 'Regional', 'mais_vendido' => true, 'ingredientes' => [['Feijao', 0.16], ['Farinha', 0.08], ['Bacon', 0.05]]],
            ['categoria' => 'Acompanhamentos', 'nome' => 'Legumes Grelhados', 'descricao' => 'Legumes da estacao grelhados com azeite e ervas', 'preco' => 17.9, 'tempo' => 13, 'imagem' => $img('legumes-grelhados'), 'disponivel' => true, 'subtipo' => 'Vegetariano', 'ingredientes' => [['Legumes', 0.25]]],
            ['categoria' => 'Acompanhamentos', 'nome' => 'Arroz de Brocolis', 'descricao' => 'Arroz branco salteado com brocolis e alho', 'preco' => 14.9, 'tempo' => 10, 'imagem' => $img('arroz-brocolis'), 'disponivel' => false, 'subtipo' => 'Guarnicao', 'ingredientes' => [['Arroz', 0.14], ['Legumes', 0.08]]],
            ['categoria' => 'Acompanhamentos', 'nome' => 'Salada Verde', 'descricao' => 'Mix de folhas, tomate e vinagrete leve', 'preco' => 15.9, 'tempo' => 9, 'imagem' => $img('salada-verde'), 'disponivel' => true, 'subtipo' => 'Salada', 'ingredientes' => [['Legumes', 0.18]]],

            ['categoria' => 'Grelhados', 'nome' => 'Picanha Grelhada', 'descricao' => 'Picanha grelhada no ponto escolhido com alho confitado', 'preco' => 76.9, 'tempo' => 30, 'imagem' => $img('picanha-grelhada'), 'disponivel' => true, 'subtipo' => 'Carne', 'destaque' => true, 'mais_vendido' => true, 'adicionais' => ['arroz', 'farofa', 'vinagrete'], 'ingredientes' => [['Picanha', 0.32]]],
            ['categoria' => 'Grelhados', 'nome' => 'File Mignon Grelhado', 'descricao' => 'Medalhao de file mignon grelhado com molho roti', 'preco' => 79.9, 'tempo' => 28, 'imagem' => $img('file-mignon'), 'disponivel' => true, 'subtipo' => 'Carne', 'ingredientes' => [['File Mignon', 0.28]]],
            ['categoria' => 'Grelhados', 'nome' => 'Frango Grelhado', 'descricao' => 'Peito de frango marinado e grelhado com ervas', 'preco' => 38.9, 'tempo' => 22, 'imagem' => $img('frango-grelhado'), 'disponivel' => true, 'subtipo' => 'Frango', 'mais_vendido' => true, 'ingredientes' => [['Frango', 0.28]]],
            ['categoria' => 'Grelhados', 'nome' => 'Tilapia Grelhada', 'descricao' => 'File de tilapia grelhado com limao siciliano', 'preco' => 49.9, 'tempo' => 24, 'imagem' => $img('tilapia-grelhada'), 'disponivel' => true, 'subtipo' => 'Peixe', 'ingredientes' => [['Peixe Tilapia', 0.28]]],
            ['categoria' => 'Grelhados', 'nome' => 'Contra-File Acebolado', 'descricao' => 'Contra-file na grelha com cebola dourada', 'preco' => 58.9, 'tempo' => 26, 'imagem' => $img('contra-file'), 'disponivel' => true, 'subtipo' => 'Carne', 'ingredientes' => [['Carne Vermelha', 0.3]]],
            ['categoria' => 'Grelhados', 'nome' => 'Costela Suina Barbecue', 'descricao' => 'Costela suina grelhada com molho barbecue artesanal', 'preco' => 62.9, 'tempo' => 35, 'imagem' => $img('costela-barbecue'), 'disponivel' => false, 'subtipo' => 'Suino', 'ingredientes' => [['Costela Suina', 0.42]]],
            ['categoria' => 'Grelhados', 'nome' => 'Espeto Misto Premium', 'descricao' => 'Espeto de carne, frango, calabresa e legumes', 'preco' => 46.9, 'tempo' => 25, 'imagem' => $img('espeto-misto'), 'disponivel' => true, 'subtipo' => 'Misto', 'ingredientes' => [['Carne Vermelha', 0.15], ['Frango', 0.12], ['Calabresa', 0.08], ['Legumes', 0.08]]],
            ['categoria' => 'Grelhados', 'nome' => 'Camarao na Brasa', 'descricao' => 'Camaroes grelhados com manteiga de ervas', 'preco' => 72.9, 'tempo' => 27, 'imagem' => $img('camarao-brasa'), 'disponivel' => true, 'subtipo' => 'Frutos do Mar', 'destaque' => true, 'ingredientes' => [['Camarao', 0.32]]],

            ['categoria' => 'Pratos Principais', 'nome' => 'Baiao de Dois', 'descricao' => 'Arroz e feijao verde com queijo coalho, carne de sol e manteiga da terra', 'preco' => 46.9, 'tempo' => 28, 'imagem' => $img('baiao-de-dois'), 'disponivel' => true, 'subtipo' => 'Regional', 'destaque' => true, 'mais_vendido' => true, 'ingredientes' => [['Arroz', 0.14], ['Feijao', 0.14], ['Queijo', 0.08], ['Carne Vermelha', 0.16]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Parmegiana de Frango', 'descricao' => 'File de frango empanado com molho de tomate e queijo gratinado', 'preco' => 48.9, 'tempo' => 30, 'imagem' => $img('parmegiana-frango'), 'disponivel' => true, 'subtipo' => 'Frango', 'mais_vendido' => true, 'adicionais' => ['arroz branco', 'batata frita', 'pure de batata'], 'ingredientes' => [['Frango', 0.28], ['Molho de Tomate', 0.14], ['Queijo', 0.1]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Feijoada Completa', 'descricao' => 'Feijoada com arroz, farofa, couve, laranja e torresmo', 'preco' => 54.9, 'tempo' => 35, 'imagem' => $img('feijoada-completa'), 'disponivel' => true, 'subtipo' => 'Brasileiro', 'destaque' => true, 'ingredientes' => [['Feijao', 0.22], ['Arroz', 0.12], ['Farinha', 0.05], ['Bacon', 0.05]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Strogonoff de Carne', 'descricao' => 'Tiras de carne em molho cremoso com arroz e batata palha', 'preco' => 47.9, 'tempo' => 26, 'imagem' => $img('strogonoff-carne'), 'disponivel' => true, 'subtipo' => 'Carne', 'ingredientes' => [['Carne Vermelha', 0.24], ['Creme de Leite', 0.12], ['Arroz', 0.12]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Strogonoff de Frango', 'descricao' => 'Cubos de frango ao molho cremoso com arroz branco', 'preco' => 42.9, 'tempo' => 25, 'imagem' => $img('strogonoff-frango'), 'disponivel' => true, 'subtipo' => 'Frango', 'mais_vendido' => true, 'ingredientes' => [['Frango', 0.24], ['Creme de Leite', 0.12], ['Arroz', 0.12]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Risoto de Camarao', 'descricao' => 'Arroz cremoso com camaroes salteados e toque de limao', 'preco' => 68.9, 'tempo' => 32, 'imagem' => $img('risoto-camarao'), 'disponivel' => true, 'subtipo' => 'Frutos do Mar', 'destaque' => true, 'ingredientes' => [['Camarao', 0.26], ['Arroz', 0.16], ['Queijo', 0.05]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Moqueca de Tilapia', 'descricao' => 'Tilapia ao molho de leite de coco com arroz e farofa', 'preco' => 59.9, 'tempo' => 34, 'imagem' => $img('moqueca-tilapia'), 'disponivel' => true, 'subtipo' => 'Peixe', 'ingredientes' => [['Peixe Tilapia', 0.32], ['Arroz', 0.12], ['Farinha', 0.05]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Carne de Sol com Macaxeira', 'descricao' => 'Carne de sol acebolada com macaxeira frita e manteiga da terra', 'preco' => 56.9, 'tempo' => 29, 'imagem' => $img('carne-sol-macaxeira'), 'disponivel' => true, 'subtipo' => 'Regional', 'ingredientes' => [['Carne Vermelha', 0.28], ['Mandioca', 0.22]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'File a Oswaldo Aranha', 'descricao' => 'File mignon com alho frito, arroz, farofa e batata portuguesa', 'preco' => 74.9, 'tempo' => 31, 'imagem' => $img('file-oswaldo-aranha'), 'disponivel' => false, 'subtipo' => 'Carne', 'ingredientes' => [['File Mignon', 0.3], ['Arroz', 0.12], ['Farinha', 0.06], ['Batata', 0.18]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Galinhada da Casa', 'descricao' => 'Arroz temperado com frango, legumes e cheiro-verde', 'preco' => 39.9, 'tempo' => 27, 'imagem' => $img('galinhada-casa'), 'disponivel' => true, 'subtipo' => 'Frango', 'ingredientes' => [['Frango', 0.22], ['Arroz', 0.16], ['Legumes', 0.08]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Executivo de Picanha', 'descricao' => 'Picanha fatiada com arroz, feijao, farofa e salada', 'preco' => 64.9, 'tempo' => 28, 'imagem' => $img('executivo-picanha'), 'disponivel' => true, 'subtipo' => 'Carne', 'mais_vendido' => true, 'ingredientes' => [['Picanha', 0.24], ['Arroz', 0.12], ['Feijao', 0.1], ['Farinha', 0.04]]],
            ['categoria' => 'Pratos Principais', 'nome' => 'Tilapia a Belle Meuniere', 'descricao' => 'Tilapia com molho de manteiga, alcaparras, camarao e arroz', 'preco' => 66.9, 'tempo' => 33, 'imagem' => $img('tilapia-belle-meuniere'), 'disponivel' => true, 'subtipo' => 'Peixe', 'ingredientes' => [['Peixe Tilapia', 0.26], ['Camarao', 0.12], ['Arroz', 0.12]]],
        ];
    }
}
