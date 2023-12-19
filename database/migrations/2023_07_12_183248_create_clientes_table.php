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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('rfc')->nullable();
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->string('casa_direccion')->nullable();
            $table->string('casa_colonia')->nullable();
            $table->string('oficina_direccion')->nullable();
            $table->string('oficina_colonia')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('tipo_cliente')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
