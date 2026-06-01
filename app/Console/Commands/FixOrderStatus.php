<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixOrderStatus extends Command
{
    protected $signature = 'fix:order-status';
    protected $description = 'Adiciona status aguardando_pagamento ao ENUM';

    public function handle()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM(
            'aberto', 'em_preparo', 'pronto', 'pronto_entrega', 
            'entregue', 'aguardando_pagamento', 'pago', 'cancelado'
        ) NOT NULL DEFAULT 'aberto'");
        
        $this->info('✅ Status aguardando_pagamento adicionado com sucesso!');
    }
}