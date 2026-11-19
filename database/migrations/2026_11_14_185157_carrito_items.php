<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            //Si se elimina el carrito, se elimina el registro de los items
            $table->foreignId('carrito_id')->constrained('carritos')->cascadeOnDelete();
            //Si se elimina el producto, se elimina todos los registros de este
            $table->foreignId('variante_id')->constrained('variantes_productos')->cascadeOnDelete();
            $table->unique(['carrito_id','variante_id']);
            $table->integer('cantidad')->default(1);                 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};
