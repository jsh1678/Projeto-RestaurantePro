<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // Quantas pessoas o prato serve
            $table->unsignedTinyInteger('serves_count')->default(1)->after('disponivel');
            // Subtipo (ex: Carne, Frango, Peixe, Vegano)
            $table->string('subtipo')->nullable()->after('serves_count');
        });

        Schema::table('categories', function (Blueprint $table) {
            // Tipo principal para filtros (prato_principal, entrada, sobremesa, bebida)
            $table->string('tipo_principal')->nullable()->after('nome');
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['serves_count', 'subtipo']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('tipo_principal');
        });
    }
};