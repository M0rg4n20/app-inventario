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
        Schema::create('venta_metodopago', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('metodo_pago_id');
            $table->float('monto',8,2)->default(0);
            $table->integer('tarjeta')->nullable();

            $table->foreign('venta_id')
            ->references('id')
            ->on('ventas')
            ->onDelete('cascade');

            $table->foreign('metodo_pago_id')
            ->references('id')
            ->on('metodos_pagos');
            //->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_metodopago');
    }
};
