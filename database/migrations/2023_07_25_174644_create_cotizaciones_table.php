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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->float('impuesto',8,2)->nullable();
            $table->float('porcentaje_descuento',8,2)->nullable();
            $table->float('descuento',8,2)->nullable();
            $table->float('neto',8,2)->nullable();
            $table->float('abono',8,2)->nullable();
            $table->float('total',8,2)->nullable();
            $table->string('tipo_venta')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null')
            ->onUpdate('set null');

            $table->foreign('cliente_id')
            ->references('id')
            ->on('clientes')
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
        Schema::dropIfExists('cotizaciones');
    }
};
