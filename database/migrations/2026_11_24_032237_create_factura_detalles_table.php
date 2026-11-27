<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factura_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained('facturas')->restrictOnDelete();
            $table->foreignId('variante_id')->nullable()->constrained('variantes_productos')->restrictOnDelete();
            $table->string('descripcion', 200);
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE factura_detalles ADD CONSTRAINT chk_fd_cantidad CHECK (cantidad > 0)');
        DB::statement('ALTER TABLE factura_detalles ADD CONSTRAINT chk_fd_precio CHECK (precio_unitario >= 0)');
        DB::statement('ALTER TABLE factura_detalles ADD CONSTRAINT chk_fd_descuento CHECK (descuento >= 0 AND descuento <= cantidad * precio_unitario)');
    }

    public function down(): void
    {
        Schema::dropIfExists('factura_detalles');
    }
};