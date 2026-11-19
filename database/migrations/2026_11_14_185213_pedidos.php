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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            //Si se elimina el usuario, se elimina el registro de sus pedidos
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            //Si se elimina la tienda, se elimina el registro de los pedidos en dicha tienda
            $table->foreignId('tienda_id')->constrained('tiendas')->cascadeOnDelete();
            //Si se elimina la ubicación, se elimina el pedido asociado
            $table->foreignId('direccion_id')->constrained('direcciones')->cascadeOnDelete(); 
            $table->string('numero_pedido',30)->unique();               
            $table->string('tipo_entrega'); 
            $table->string('estado')->default('PENDIENTE');
            $table->decimal('subtotal',10,2)->default(0.00);
            $table->decimal('costo_envio',10,2)->default(0.00);
            $table->decimal('isv',10,2)->default(0.00);
            $table->decimal('total',10,2)->default(0.00);
            $table->dateTime('fecha_pedido');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
