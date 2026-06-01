<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('aberto', 'em_preparo', 'pronto', 'pronto_entrega', 'entregue', 'pago', 'cancelado', 'aguardando_pagamento') NOT NULL DEFAULT 'em_preparo'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('aberto', 'em_preparo', 'pronto', 'pronto_entrega', 'entregue', 'pago', 'cancelado') NOT NULL DEFAULT 'em_preparo'");
    }
};
