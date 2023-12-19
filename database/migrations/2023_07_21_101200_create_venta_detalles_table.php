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
        Schema::create('venta_detalles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('venta_id')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->float('precio',8,2)->default(0);
            $table->float('cantidad',8,2)->default(0);
            $table->float('total',8,2)->default(0);

            $table->foreign('venta_id')
            ->references('id')
            ->on('ventas')
            ->onDelete('cascade');

            $table->foreign('producto_id')
            ->references('id')
            ->on('productos')
            ->onDelete('cascade');
            //->onUpdate('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
