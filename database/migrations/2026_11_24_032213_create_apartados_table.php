<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('variante_id')->constrained('variantes_productos')->restrictOnDelete();
            $table->integer('cantidad')->default(1);
            $table->timestamp('fecha_apartado');
            $table->timestamp('fecha_expiracion');
            $table->string('estado', 20)->default('ACTIVO');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE apartados ADD CONSTRAINT chk_apartados_cantidad CHECK (cantidad > 0)');
        DB::statement('ALTER TABLE apartados ADD CONSTRAINT chk_apartados_fechas CHECK (fecha_expiracion > fecha_apartado)');
    }

    public function down(): void
    {
        Schema::dropIfExists('apartados');
    }
};