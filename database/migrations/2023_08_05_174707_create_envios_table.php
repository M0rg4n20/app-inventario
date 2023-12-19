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
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->string('estado')->nullable();
            $table->text('comentario')->nullable();
            $table->string('direccion')->nullable();
            $table->string('colonia')->nullable();
            $table->string('telefono')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->integer('orden')->nullable();
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->unsignedBigInteger('repartidor_id')->nullable();
            $table->unsignedBigInteger('ruta_id')->nullable();
            $table->timestamps();

            $table->foreign('venta_id')
            ->references('id')
            ->on('ventas')
            ->onDelete('set null')
            ->onUpdate('set null');

            $table->foreign('responsable_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null')
            ->onUpdate('set null');

            $table->foreign('repartidor_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null')
            ->onUpdate('set null');

            $table->foreign('ruta_id')
            ->references('id')
            ->on('rutas')
            ->onDelete('set null')
            ->onUpdate('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
