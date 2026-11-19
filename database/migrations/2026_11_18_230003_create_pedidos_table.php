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
            $table->string('codigo_compra', 30);
            $table->string('numero_pedido', 30)->unique();
            $table->string('tipo_entrega', 20);
            $table->string('estado', 20)->default('pendiente');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->decimal('isv', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->dateTime('fecha_pedido');
            $table->timestamps();
            $table->index('codigo_compra', 'idx_pedidos_codigo_compra');
            $table->index('fecha_pedido', 'idx_pedidos_fecha');
        });
        DB::statement("ALTER TABLE pedidos ADD CONSTRAINT chk_pedidos_tipo_entrega CHECK (tipo_entrega IN ('envio', 'retiro_tienda'))");
        DB::statement("ALTER TABLE pedidos ADD CONSTRAINT chk_pedidos_estado CHECK (estado IN ('pendiente', 'pagado', 'preparando', 'listo', 'enviado', 'entregado', 'cancelado'))");
        DB::statement("ALTER TABLE pedidos ADD CONSTRAINT chk_pedidos_montos CHECK (subtotal >= 0 AND costo_envio >= 0 AND isv >= 0 AND total >= 0)");
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
