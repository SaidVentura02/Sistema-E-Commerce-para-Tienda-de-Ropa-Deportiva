<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variantes_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->foreignId('talla_id')->constrained('tallas')->restrictOnDelete();
            $table->foreignId('color_id')->constrained('colores')->restrictOnDelete();
            $table->string('sku', 60)->unique();
            $table->string('codigo_barras', 80)->nullable()->unique();
            $table->integer('stock')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['producto_id', 'talla_id', 'color_id'], 'uq_variante_producto_talla_color');
        });

        DB::statement('ALTER TABLE variantes_productos ADD CONSTRAINT chk_variantes_stock CHECK (stock >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('variantes_productos');
    }
};