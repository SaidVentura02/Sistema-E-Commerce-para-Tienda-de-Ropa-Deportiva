<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compra_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->cascadeOnDelete();
            $table->foreignId('variante_id')->constrained('variantes_productos')->restrictOnDelete();
            $table->integer('cantidad');
            $table->decimal('costo_unitario', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['compra_id', 'variante_id'], 'uq_compra_detalles');
        });

        DB::statement('ALTER TABLE compra_detalles ADD CONSTRAINT chk_cd_cantidad CHECK (cantidad > 0)');
        DB::statement('ALTER TABLE compra_detalles ADD CONSTRAINT chk_cd_costo CHECK (costo_unitario >= 0)');
        DB::statement('ALTER TABLE compra_detalles ADD CONSTRAINT chk_cd_descuento CHECK (descuento >= 0 AND descuento <= cantidad * costo_unitario)');
    }

    public function down(): void
    {
        Schema::dropIfExists('compra_detalles');
    }
};