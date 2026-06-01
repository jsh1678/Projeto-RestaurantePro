<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->longText('imagem_dados')->nullable()->after('imagem');
            $table->string('imagem_mime', 100)->nullable()->after('imagem_dados');
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['imagem_dados', 'imagem_mime']);
        });
    }
};
