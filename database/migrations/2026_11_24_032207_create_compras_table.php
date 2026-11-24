<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->restrictOnDelete();
            $table->foreignId('tienda_id')->constrained('tiendas')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('numero_factura_proveedor', 25);
            $table->date('fecha_compra');
            $table->string('estado', 20)->default('BORRADOR');
            $table->timestamps();

            $table->unique(['proveedor_id', 'numero_factura_proveedor'], 'uq_compras_proveedor_factura');
        });

        DB::statement("ALTER TABLE compras ADD CONSTRAINT chk_compras_estado CHECK (estado IN ('BORRADOR','RECIBIDA','ANULADA'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};