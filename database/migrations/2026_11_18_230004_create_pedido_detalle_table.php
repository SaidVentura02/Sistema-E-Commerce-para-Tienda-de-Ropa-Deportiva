<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->restrictOnDelete();
            $table->foreignId('variante_id')->constrained('variantes_producto')->restrictOnDelete();
            $table->string('nombre_producto', 150);
            $table->string('sku_producto', 60);
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
        DB::statement("ALTER TABLE pedido_detalle ADD CONSTRAINT chk_pedido_detalle_cantidad CHECK (cantidad > 0)");
        DB::statement("ALTER TABLE pedido_detalle ADD CONSTRAINT chk_pedido_detalle_montos CHECK (precio_unitario >= 0 AND subtotal >= 0)");
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_detalle');
    }
};
