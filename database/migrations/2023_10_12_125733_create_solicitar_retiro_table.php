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
        Schema::create('solicitar_retiro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repartidor_id');
            $table->decimal('monto', 10, 2);
            $table->string('estado'); // Por ejemplo, 'pendiente', 'aprobado', 'denegado'
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitar_retiro');
    }
};
