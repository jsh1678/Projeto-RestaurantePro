<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Adiciona o valor 'cancelado' ao enum status de order_items.
     * Necessário para distinguir itens cancelados de itens entregues.
     */
    public function up(): void
    {
        // MySQL: altera o enum diretamente
        DB::statement("ALTER TABLE order_items MODIFY COLUMN status ENUM('pendente','em_preparo','pronto','entregue','cancelado') NOT NULL DEFAULT 'pendente'");
    }

    public function down(): void
    {
        // Reverte itens cancelados para 'entregue' antes de remover o valor do enum
        DB::statement("UPDATE order_items SET status = 'entregue' WHERE status = 'cancelado'");
        DB::statement("ALTER TABLE order_items MODIFY COLUMN status ENUM('pendente','em_preparo','pronto','entregue') NOT NULL DEFAULT 'pendente'");
    }
};