<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('ruta', 255);
            $table->boolean('es_principal')->default(false);
            $table->smallInteger('orden')->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE imagenes_producto ADD CONSTRAINT chk_imagenes_orden CHECK (orden >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_producto');
    }
};