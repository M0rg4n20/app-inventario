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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('codigo')->nullable();
            $table->string('codigo_barra')->nullable();
            $table->string('imagen_1')->nullable();
            $table->string('imagen_2')->nullable();
            $table->integer('stock')->default(0);
            $table->float('precio_compra',8,2)->default(0);
            $table->float('precio_venta',8,2)->default(0);
            $table->float('precio_mayorista',8,2)->default(0);
            $table->float('porcentaje_venta',8,2)->nullable()->default(0);
            $table->float('porcentaje_mayorista',8,2)->nullable()->default(0);
            $table->boolean('check_mayorista')->default(0)->nullable();
            $table->boolean('check_venta')->default(0)->nullable();
            $table->float('ventas',8,2)->nullable();

            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->string('familia_id')->nullable();
            $table->string('subproducto_id')->nullable();
            $table->string('marca_id')->nullable();
            $table->unsignedBigInteger('peso_id')->nullable();
            $table->unsignedBigInteger('longitud_id')->nullable();
            $table->string('curva_id')->nullable();
            $table->string('color_id')->nullable();
            $table->string('diferenciador_id')->nullable();


            $table->foreign('categoria_id')->references('id')->on('categorias');
/*            $table->foreign('vendor_id')
            ->references('id')
            ->on('vendors')
            ->onDelete('set null')
            ->onUpdate('set null');*/
            $table->foreign('familia_id')->references('id')->on('familias');
            $table->foreign('subproducto_id')->references('id')->on('subproductos');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('peso_id')->references('id')->on('pesos');
            $table->foreign('longitud_id')->references('id')->on('longitudes');
            $table->foreign('curva_id')->references('id')->on('curvas');
            $table->foreign('color_id')->references('id')->on('colores');
            $table->foreign('diferenciador_id')->references('id')->on('diferenciadores');




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
