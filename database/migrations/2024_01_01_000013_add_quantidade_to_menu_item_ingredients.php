<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_item_ingredients', function (Blueprint $table) {
            if (!Schema::hasColumn('menu_item_ingredients', 'quantidade')) {
                $table->decimal('quantidade', 10, 3)->default(1)->after('stock_item_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('menu_item_ingredients', function (Blueprint $table) {
            $table->dropColumn('quantidade');
        });
    }
};
