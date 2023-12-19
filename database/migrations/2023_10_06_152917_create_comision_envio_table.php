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
        Schema::create('comision_envio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estado_id');
            $table->integer('puntos');
            $table->timestamps();

            $table->foreign('estado_id')->references('id')->on('estado_de_pedidos');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comision_envio');
    }
};
