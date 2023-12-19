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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->float('monto_efectivo',8,2)->nullable();
            $table->float('monto_tarjeta',8,2)->nullable();
            $table->float('saldo',8,2)->nullable();
            $table->string('num_tarjeta')->nullable();
            $table->string('metodo_pago')->nullable();
            $table->string('tipo_pago')->nullable();
            $table->string('forma_entrega')->nullable();
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('metodo_pago_id')->nullable();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null')
            ->onUpdate('set null');

            $table->foreign('venta_id')
            ->references('id')
            ->on('ventas')
            ->onDelete('set null')
            ->onUpdate('set null');

            $table->foreign('metodo_pago_id')
            ->references('id')
            ->on('metodos_pagos')
            ->onDelete('set null')
            ->onUpdate('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
