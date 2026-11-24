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
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('empresa_envio_id')->constrained('empresas_envio')->restrictOnDelete();
            $table->string('estado', 20)->default('PENDIENTE');
            $table->string('numero_guia', 20)->nullable();
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamps();

            $table->unique(['empresa_envio_id', 'numero_guia'], 'uq_envios_empresa_guia');
        });

        DB::statement("ALTER TABLE envios ADD CONSTRAINT chk_envios_estado CHECK (estado IN ('PENDIENTE','DESPACHADO','ENTREGADO','CANCELADO'))");
        DB::statement("ALTER TABLE envios ADD CONSTRAINT chk_envios_guia CHECK (estado IN ('PENDIENTE','CANCELADO') OR numero_guia IS NOT NULL)");
    }

    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};