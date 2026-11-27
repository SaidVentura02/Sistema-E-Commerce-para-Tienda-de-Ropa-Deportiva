<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reclamos_garantia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_detalle_id')->constrained('factura_detalles')->restrictOnDelete();
            $table->foreignId('variante_reemplazo_id')->constrained('variantes_productos')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->integer('cantidad')->default(1);
            $table->string('motivo', 255);
            $table->string('estado', 20)->default('PENDIENTE');
            $table->timestamp('fecha_reclamo')->default(DB::raw("(now() AT TIME ZONE 'America/Tegucigalpa')"));
            $table->timestamp('fecha_resolucion')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE reclamos_garantia ADD CONSTRAINT chk_reclamos_cantidad CHECK (cantidad > 0)');
        DB::statement("ALTER TABLE reclamos_garantia ADD CONSTRAINT chk_reclamos_estado CHECK (estado IN ('PENDIENTE','APROBADO','RECHAZADO','ENTREGADO'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('reclamos_garantia');
    }
};