<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->unique()->constrained('pedidos')->restrictOnDelete();
            $table->string('estado', 20)->default('pendiente');
            $table->string('numero_guia', 50)->nullable();
            $table->dateTime('fecha_envio')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE envios ADD CONSTRAINT chk_envios_estado CHECK (estado IN ('pendiente', 'enviado', 'en_ruta', 'entregado'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
