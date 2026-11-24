<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas_envio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('url_rastreo', 255)->nullable();
            $table->string('prefijo_guia', 5)->unique();
            $table->integer('numero_actual_guia')->default(0);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE empresas_envio ADD CONSTRAINT chk_empresas_prefijo CHECK (prefijo_guia ~ '^[A-Z0-9]{2,5}$')");
        DB::statement('ALTER TABLE empresas_envio ADD CONSTRAINT chk_empresas_num_guia CHECK (numero_actual_guia BETWEEN 0 AND 99999999)');
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas_envio');
    }
};