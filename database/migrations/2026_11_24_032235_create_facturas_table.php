<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->unique()->constrained('pedidos')->restrictOnDelete();
            $table->foreignId('cai_rango_id')->constrained('cai_rangos')->restrictOnDelete();
            $table->integer('correlativo')->nullable();
            $table->timestamp('fecha_emision')->nullable();
            $table->string('rtn_cliente', 20)->nullable();
            $table->string('nombre_cliente', 150)->default('CONSUMIDOR FINAL');
            $table->foreignId('tasa_impuesto_id')->nullable()->constrained('tasas_impuesto')->restrictOnDelete();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuentos', 12, 2)->default(0);
            $table->decimal('isv', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('estado', 20)->default('BORRADOR');
            $table->timestamps();

            $table->unique(['cai_rango_id', 'correlativo'], 'uq_facturas_cai_correlativo');
        });

        DB::statement("ALTER TABLE facturas ADD CONSTRAINT chk_facturas_estado CHECK (estado IN ('BORRADOR','EMITIDA','ANULADA'))");
        DB::statement("
            ALTER TABLE facturas ADD CONSTRAINT chk_facturas_numerada CHECK (
                estado = 'BORRADOR'
                OR (correlativo IS NOT NULL AND fecha_emision IS NOT NULL AND tasa_impuesto_id IS NOT NULL)
            )
        ");
        DB::statement('ALTER TABLE facturas ADD CONSTRAINT chk_facturas_montos CHECK (subtotal >= 0 AND descuentos >= 0 AND descuentos <= subtotal AND isv >= 0)');
        DB::statement('ALTER TABLE facturas ADD CONSTRAINT chk_facturas_total CHECK (total = subtotal - descuentos + isv)');
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};