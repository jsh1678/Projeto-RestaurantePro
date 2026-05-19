<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Marca se este item já foi "enviado" para a fila da cozinha.
            // false  = novo, a cozinha ainda não viu
            // true   = cozinha já recebeu / já estava na fila quando o pedido chegou
            $table->boolean('enviado_cozinha')->default(false)->after('status');

            // Momento exato em que o item entrou na fila da cozinha
            $table->timestamp('enviado_cozinha_em')->nullable()->after('enviado_cozinha');
        });

        // Itens existentes que já estão em algum status ativo =
        // considerados como já enviados para evitar falso-positivo.
        DB::table('order_items')
            ->whereIn('status', ['em_preparo', 'pronto', 'entregue'])
            ->update([
                'enviado_cozinha'    => true,
                'enviado_cozinha_em' => DB::raw('created_at'),
            ]);

        // Itens 'pendente' de pedidos já em preparo também foram enviados
        DB::table('order_items')
            ->where('status', 'pendente')
            ->whereIn('order_id', function ($q) {
                $q->select('id')
                  ->from('orders')
                  ->whereNotIn('status', ['aberto', 'cancelado', 'pago']);
            })
            ->update([
                'enviado_cozinha'    => true,
                'enviado_cozinha_em' => DB::raw('created_at'),
            ]);
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['enviado_cozinha', 'enviado_cozinha_em']);
        });
    }
};
