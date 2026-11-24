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
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('metodo_pago_id')->constrained('metodos_pago')->restrictOnDelete();
            $table->decimal('monto', 10, 2);
            $table->string('estado', 30)->default('PENDIENTE');
            $table->string('referencia', 255)->nullable();
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE pagos ADD CONSTRAINT chk_pagos_monto CHECK (monto > 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};