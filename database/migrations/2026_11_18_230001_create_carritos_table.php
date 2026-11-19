<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('estado', 20)->default('activo');
            $table->timestamps();
            $table->index(['user_id', 'estado'], 'idx_carritos_user_estado');
        });
        DB::statement("ALTER TABLE carritos ADD CONSTRAINT chk_carritos_estado CHECK (estado IN ('activo', 'convertido', 'abandonado'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
