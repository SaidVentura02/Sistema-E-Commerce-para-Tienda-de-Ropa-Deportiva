<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->restrictOnDelete();
            $table->string('metodo', 20);
            $table->decimal('monto', 10, 2);
            $table->string('estado', 20)->default('pendiente');
            $table->string('referencia', 100)->nullable();
            $table->dateTime('fecha_pago')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE pagos ADD CONSTRAINT chk_pagos_metodo CHECK (metodo IN ('tarjeta', 'transferencia', 'contra_entrega'))");
        DB::statement("ALTER TABLE pagos ADD CONSTRAINT chk_pagos_estado CHECK (estado IN ('pendiente', 'aprobado', 'rechazado'))");
        DB::statement("ALTER TABLE pagos ADD CONSTRAINT chk_pagos_monto CHECK (monto >= 0)");
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
