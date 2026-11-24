<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tallas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->string('tipo', 20);
            $table->smallInteger('orden')->default(0);
            $table->integer('stock_minimo')->default(3);
            $table->timestamps();

            $table->unique(['nombre', 'tipo'], 'uq_tallas_nombre_tipo');
        });

        DB::statement('ALTER TABLE tallas ADD CONSTRAINT chk_tallas_orden CHECK (orden >= 0)');
        DB::statement('ALTER TABLE tallas ADD CONSTRAINT chk_tallas_stock_minimo CHECK (stock_minimo >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('tallas');
    }
};