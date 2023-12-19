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
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            $table->string('ticket')->nullable();
            $table->text('comentario')->nullable();
            $table->float('cantidad',8,2)->nullable();
            $table->string('codigo')->nullable();
            $table->string('proveedor')->nullable();
            $table->string('tipo')->nullable();
            $table->string('stock_anterior')->nullable();
            $table->string('stock_final')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('producto_id')
            ->references('id')
            ->on('productos')
            ->onDelete('set null')
            ->onUpdate('set null');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null')
            ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardex');
    }
};
