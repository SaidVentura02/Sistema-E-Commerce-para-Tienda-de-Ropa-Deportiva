<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('variante_id')->constrained('variantes_productos')->restrictOnDelete();
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE pedidos_detalles ADD CONSTRAINT chk_pd_cantidad CHECK (cantidad > 0)');
        DB::statement('ALTER TABLE pedidos_detalles ADD CONSTRAINT chk_pd_precio CHECK (precio_unitario >= 0)');
        DB::statement('ALTER TABLE pedidos_detalles ADD CONSTRAINT chk_pd_descuento CHECK (descuento >= 0 AND descuento <= cantidad * precio_unitario)');
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos_detalles');
    }
};