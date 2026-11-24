<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('tienda_id')->constrained('tiendas')->restrictOnDelete();
            $table->foreignId('direccion_id')->nullable()->constrained('direcciones')->restrictOnDelete();
            $table->string('numero_pedido', 30)->unique();
            $table->string('tipo_entrega', 20);
            $table->string('estado', 30)->default('PENDIENTE');
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->timestamp('fecha_pedido');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE pedidos ADD CONSTRAINT chk_pedidos_tipo_entrega CHECK (tipo_entrega IN ('DOMICILIO','RETIRO_TIENDA'))");
        DB::statement('ALTER TABLE pedidos ADD CONSTRAINT chk_pedidos_costo_envio CHECK (costo_envio >= 0)');
        DB::statement("ALTER TABLE pedidos ADD CONSTRAINT chk_pedidos_direccion CHECK (tipo_entrega <> 'DOMICILIO' OR direccion_id IS NOT NULL)");
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};