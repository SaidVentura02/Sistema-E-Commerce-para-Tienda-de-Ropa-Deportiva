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
        Schema::create('pedidos_detalles', function (Blueprint $table) {
            $table->id();
            //Si se elimina el pedido o la variante del producto, se eliminan los detalles del pedido
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('variante_id')->constrained('variantes_productos')->cascadeOnDelete(); 
            $table->integer('cantidad')->default(1);               
            $table->decimal('precio_unitario',10,2); 
            $table->decimal('subtotal',10,2);   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_detalles');
    }
};
