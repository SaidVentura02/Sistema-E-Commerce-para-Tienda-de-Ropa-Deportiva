<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cai_rangos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tienda_id')->constrained('tiendas')->restrictOnDelete();
            $table->string('cai', 50)->unique();
            $table->char('punto_emision', 3)->default('001');
            $table->char('tipo_documento', 2)->default('01');
            $table->integer('rango_inicial');
            $table->integer('rango_final');
            $table->integer('numero_actual');
            $table->date('fecha_limite_emision');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE cai_rangos ADD CONSTRAINT chk_cai_rango CHECK (rango_inicial >= 1 AND rango_final <= 99999999 AND rango_inicial <= rango_final)');
        DB::statement('ALTER TABLE cai_rangos ADD CONSTRAINT chk_cai_numero_actual CHECK (numero_actual + 1 >= rango_inicial AND numero_actual <= rango_final)');
        DB::statement("ALTER TABLE cai_rangos ADD CONSTRAINT chk_cai_codigos CHECK (punto_emision ~ '^[0-9]{3}$' AND tipo_documento ~ '^[0-9]{2}$')");
    }

    public function down(): void
    {
        Schema::dropIfExists('cai_rangos');
    }
};