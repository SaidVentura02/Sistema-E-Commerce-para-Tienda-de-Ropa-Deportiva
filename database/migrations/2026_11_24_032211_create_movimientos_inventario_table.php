<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variante_id')->constrained('variantes_productos')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('tipo', 20);
            $table->integer('cantidad');
            $table->string('motivo', 150)->nullable();
            $table->timestamp('created_at')->nullable()->default(DB::raw("(now() AT TIME ZONE 'America/Tegucigalpa')"));
            $table->timestamp('updated_at')->nullable();
        });

        DB::statement("ALTER TABLE movimientos_inventario ADD CONSTRAINT chk_mov_tipo CHECK (tipo IN ('COMPRA','VENTA','GARANTIA','AJUSTE'))");
        DB::statement("
            ALTER TABLE movimientos_inventario ADD CONSTRAINT chk_mov_signo CHECK (
                (tipo = 'COMPRA' AND cantidad > 0)
                OR (tipo IN ('VENTA','GARANTIA') AND cantidad < 0)
                OR (tipo = 'AJUSTE' AND cantidad <> 0)
            )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};