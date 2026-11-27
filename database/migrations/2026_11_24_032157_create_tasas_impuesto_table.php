<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasas_impuesto', function (Blueprint $table) {
            $table->id();
            $table->decimal('porcentaje', 5, 2);
            $table->date('vigente_desde')->unique();
            $table->date('vigente_hasta')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE tasas_impuesto ADD CONSTRAINT chk_tasas_porcentaje CHECK (porcentaje >= 0 AND porcentaje <= 100)');
        DB::statement('ALTER TABLE tasas_impuesto ADD CONSTRAINT chk_tasas_vigencia CHECK (vigente_hasta IS NULL OR vigente_hasta >= vigente_desde)');
    }

    public function down(): void
    {
        Schema::dropIfExists('tasas_impuesto');
    }
};