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
        Schema::table('caixa_fechamentos', function (Blueprint $table) {
            $table->timestamp('periodo_inicio')->nullable()->after('fechado_em');
            $table->timestamp('periodo_fim')->nullable()->after('periodo_inicio');
            $table->decimal('total_dinheiro', 15, 2)->default(0)->after('total');
            $table->decimal('total_pix', 15, 2)->default(0)->after('total_dinheiro');
            $table->decimal('total_cartao_debito', 15, 2)->default(0)->after('total_pix');
            $table->decimal('total_cartao_credito', 15, 2)->default(0)->after('total_cartao_debito');
            $table->decimal('total_compras', 15, 2)->default(0)->after('total_cartao_credito');
            $table->decimal('total_sangrias', 15, 2)->default(0)->after('total_compras');
            $table->decimal('valor_esperado_caixa', 15, 2)->default(0)->after('total_sangrias');
            $table->unsignedInteger('total_pagamentos')->default(0)->after('valor_esperado_caixa');
            $table->unsignedInteger('total_comandas_abertas')->default(0)->after('total_pagamentos');
            $table->json('relatorio')->nullable()->after('total_comandas_abertas');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('caixa_fechamento_id')
                ->nullable()
                ->after('order_id')
                ->constrained('caixa_fechamentos')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('caixa_fechamento_id');
        });

        Schema::table('caixa_fechamentos', function (Blueprint $table) {
            $table->dropColumn([
                'periodo_inicio',
                'periodo_fim',
                'total_dinheiro',
                'total_pix',
                'total_cartao_debito',
                'total_cartao_credito',
                'total_compras',
                'total_sangrias',
                'valor_esperado_caixa',
                'total_pagamentos',
                'total_comandas_abertas',
                'relatorio',
            ]);
        });
    }
};
