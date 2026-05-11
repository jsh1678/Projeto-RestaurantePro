    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {

        public function up(): void
        {
            Schema::table('orders', function (Blueprint $table) {
                // Timestamp de quando o pagamento foi confirmado
                $table->timestamp('pago_em')->nullable()->after('horario_entrega');
            });
        }

        public function down(): void
        {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('pago_em');
            });
        }
    };