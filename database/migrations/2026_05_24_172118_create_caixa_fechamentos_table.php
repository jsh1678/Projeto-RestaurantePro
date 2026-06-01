<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caixa_fechamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('reaberto_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('fechado_em');
            $table->timestamp('reaberto_em')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();

            $table->index(['fechado_em', 'reaberto_em']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixa_fechamentos');
    }
};
