<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('municipio_id')->constrained('municipios')->restrictOnDelete();
            $table->string('alias', 60);
            $table->string('direccion_detalle', 255);
            $table->string('referencia', 255)->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->boolean('es_principal')->default(false);
            $table->timestamps();
        });

        DB::statement("
            ALTER TABLE direcciones ADD CONSTRAINT chk_direcciones_gps CHECK (
                (latitud IS NULL AND longitud IS NULL)
                OR (latitud IS NOT NULL AND longitud IS NOT NULL
                    AND latitud BETWEEN -90 AND 90 AND longitud BETWEEN -180 AND 180)
            )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};