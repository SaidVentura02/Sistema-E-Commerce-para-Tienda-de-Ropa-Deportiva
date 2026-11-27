<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipio_id')->nullable()->constrained('municipios')->restrictOnDelete();
            $table->string('nombre', 100)->unique();
            $table->string('razon_social', 150)->nullable();
            $table->string('rtn', 20)->unique();
            $table->char('codigo_establecimiento', 3)->default('000');
            $table->text('direccion');
            $table->string('telefono', 20)->nullable();
            $table->string('correo', 150)->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE tiendas ADD CONSTRAINT chk_tiendas_establecimiento CHECK (codigo_establecimiento ~ '^[0-9]{3}$')");
    }

    public function down(): void
    {
        Schema::dropIfExists('tiendas');
    }
};