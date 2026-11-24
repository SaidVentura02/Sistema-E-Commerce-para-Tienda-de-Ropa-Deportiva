<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tienda_id')->constrained('tiendas')->restrictOnDelete();
            $table->foreignId('marca_id')->constrained('marcas')->restrictOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias')->restrictOnDelete();
            $table->foreignId('disciplina_id')->constrained('disciplinas')->restrictOnDelete();
            $table->string('nombre', 150)->index('productos_nombre_index');
            $table->string('slug', 180)->unique();
            $table->text('descripcion')->nullable();
            $table->string('genero', 20);
            $table->decimal('precio', 10, 2);
            $table->decimal('precio_oferta', 10, 2)->nullable();
            $table->boolean('destacado')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE productos ADD CONSTRAINT chk_productos_precio CHECK (precio >= 0)');
        DB::statement('ALTER TABLE productos ADD CONSTRAINT chk_productos_oferta CHECK (precio_oferta IS NULL OR (precio_oferta >= 0 AND precio_oferta <= precio))');
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};