<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adiciona horario_pronto na tabela orders se ainda não existir
        if (!Schema::hasColumn('orders', 'horario_pronto')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp('horario_pronto')
                    ->nullable()
                    ->after('horario_pedido')
                    ->comment('Momento em que todos os itens do pedido foram marcados como prontos pelo chef');
            });
        }

        // Adiciona horario_pronto na tabela order_items se ainda não existir
        if (!Schema::hasColumn('order_items', 'horario_pronto')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->timestamp('horario_pronto')
                    ->nullable()
                    ->after('status')
                    ->comment('Momento em que o item individual foi marcado como pronto pelo chef');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('horario_pronto');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('horario_pronto');
        });
    }
};
