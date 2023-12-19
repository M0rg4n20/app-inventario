<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('envio_historicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repartidor_id');
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('estado_id');
            $table->integer('puntos')->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();

            $table->foreign('repartidor_id')->references('id')->on('users');
            $table->foreign('pedido_id')->references('id')->on('envios');
            $table->foreign('estado_id')->references('id')->on('estado_de_pedidos');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_historicos');
    }
};
