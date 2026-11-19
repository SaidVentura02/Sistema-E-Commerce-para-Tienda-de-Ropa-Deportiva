<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained('carritos')->cascadeOnDelete();
            $table->foreignId('variante_id')->constrained('variantes_producto')->restrictOnDelete();
            $table->integer('cantidad')->default(1);
            $table->timestamps();
            $table->unique(['carrito_id', 'variante_id'], 'uq_carrito_variante');
        });
        DB::statement("ALTER TABLE carrito_items ADD CONSTRAINT chk_carrito_items_cantidad CHECK (cantidad > 0)");
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};
