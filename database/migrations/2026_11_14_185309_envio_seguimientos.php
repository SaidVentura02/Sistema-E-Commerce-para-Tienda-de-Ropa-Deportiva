<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('envio_seguimientos', function (Blueprint $table) {
            $table->id();
            //Si se elimina el envio, se eliminan los detalles del envio
            $table->foreignId('envio_id')->constrained('envios')->cascadeOnDelete(); 
            $table->string('estado',20);               
            $table->string('comentario',255)->nullable(); 
            $table->dateTime('fecha');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_seguimientos');
    }
};
