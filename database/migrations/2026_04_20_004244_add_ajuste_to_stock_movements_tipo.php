<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_add_ajuste_to_stock_movements_tipo.php
public function up()
{
    DB::statement("ALTER TABLE stock_movements MODIFY tipo ENUM('entrada', 'saida', 'ajuste', 'venda', 'devolucao', 'inventario') NOT NULL");
}

public function down()
{
    DB::statement("ALTER TABLE stock_movements MODIFY tipo ENUM('entrada', 'saida', 'venda', 'devolucao') NOT NULL");
}
};
