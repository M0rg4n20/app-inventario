<?php

use App\Http\Controllers\AbonoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CurvaController;
use App\Http\Controllers\DiferenciadorController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LongitudController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PesoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SubProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\CorteCajaController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ReporteVentaController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\SolicitarRetiroController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return Inertia::render('Auth/Login');
});
/*Route::get('/template', function () {
    return Inertia::render('Template/Index');
});*/

Route::get('/', [InicioController::class, 'index'])->name('inicio')->middleware(['auth', 'verified']);

Route::controller(RoleController::class)->group(function () {
    Route::get('/roles/{id}', 'edit')->name('roles.edit')->middleware('auth');
    Route::post('/roles/{id}', 'update')->name('roles.update')->middleware('auth');
    Route::get('/roles', 'index')->name('roles.index')->middleware('auth');

});

Route::controller(UsuarioController::class)->group(function () {
    Route::post('/usuario/update/{id}', 'update')->name('usuarios.update')->middleware('auth');
    Route::get('/usuario', 'index')->name('usuarios.index')->middleware('auth');
    Route::post('/usuario/store', 'store')->name('usuarios.store')->middleware('auth');
    Route::get('/usuario/status/{id}/{status}' , 'status')->name('usuarios.status')->middleware('auth');
    Route::delete('/usuario/{id}', 'destroy')->name('usuarios.destroy')->middleware('auth');
});


Route::controller(ClienteController::class)->group(function () {
    Route::post('/cliente/update/{id}', 'update')->name('clientes.update')->middleware('auth');
    Route::get('/cliente', 'index')->name('clientes.index')->middleware('auth');
    Route::get('/cliente/{id}', 'show')->name('clientes.show')->middleware('auth');
    Route::post('/cliente/store', 'store')->name('clientes.store')->middleware('auth');
    Route::delete('/cliente/{id}', 'destroy')->name('clientes.destroy')->middleware('auth');
});


Route::controller(CategoriaController::class)->group(function () {
    Route::post('/categorias/update/{id}', 'update')->name('categorias.update')->middleware('auth');
    Route::get('/categorias', 'index')->name('categorias.index')->middleware('auth');
    Route::get('/categorias/{id}', 'show')->name('categorias.show')->middleware('auth');
    Route::post('/categorias/store', 'store')->name('categorias.store')->middleware('auth');
    Route::delete('/categorias/{id}', 'destroy')->name('categorias.destroy')->middleware('auth');
});

Route::controller(FamiliaController::class)->group(function () {
    Route::post('/familias/update/{id}', 'update')->name('familias.update')->middleware('auth');
    Route::get('/familias', 'index')->name('familias.index')->middleware('auth');
    Route::get('/familias/{id}', 'show')->name('familias.show')->middleware('auth');
    Route::get('/familias/search/{text}/{orden}', 'ordenBy')->name('familias.search')->middleware('auth');
    Route::post('/familias/store', 'store')->name('familias.store')->middleware('auth');
    Route::delete('/familias/{id}', 'destroy')->name('familias.destroy')->middleware('auth');
});

Route::controller(SubProductoController::class)->group(function () {
    Route::post('/subproductos/update/{id}', 'update')->name('subproductos.update')->middleware('auth');
    Route::get('/subproductos', 'index')->name('subproductos.index')->middleware('auth');
    Route::get('/subproductos/{id}', 'show')->name('subproductos.show')->middleware('auth');
    Route::get('/subproductos/search/{text}/{orden}', 'ordenBy')->name('subproductos.search')->middleware('auth');
    Route::post('/subproductos/store', 'store')->name('subproductos.store')->middleware('auth');
    Route::delete('/subproductos/{id}', 'destroy')->name('subproductos.destroy')->middleware('auth');
});


Route::controller(MarcaController::class)->group(function () {
    Route::post('/marcas/update/{id}', 'update')->name('marcas.update')->middleware('auth');
    Route::get('/marcas', 'index')->name('marcas.index')->middleware('auth');
    Route::get('/marcas/{id}', 'show')->name('marcas.show')->middleware('auth');
    Route::get('/marcas/search/{text}/{orden}', 'ordenBy')->name('marcas.search')->middleware('auth');
    Route::post('/marcas/store', 'store')->name('marcas.store')->middleware('auth');
    Route::delete('/marcas/{id}', 'destroy')->name('marcas.destroy')->middleware('auth');
});

Route::controller(PesoController::class)->group(function () {
    Route::post('/pesos/update/{id}', 'update')->name('pesos.update')->middleware('auth');
    Route::get('/pesos', 'index')->name('pesos.index')->middleware('auth');
    Route::get('/pesos/{id}', 'show')->name('pesos.show')->middleware('auth');
    Route::get('/pesos/search/{text}/{orden}', 'ordenBy')->name('pesos.search')->middleware('auth');
    Route::post('/pesos/store', 'store')->name('pesos.store')->middleware('auth');
    Route::delete('/pesos/{id}', 'destroy')->name('pesos.destroy')->middleware('auth');
});

Route::controller(LongitudController::class)->group(function () {
    Route::post('/longitudes/update/{id}', 'update')->name('longitudes.update')->middleware('auth');
    Route::get('/longitudes', 'index')->name('longitudes.index')->middleware('auth');
    Route::get('/longitudes/{id}', 'show')->name('longitudes.show')->middleware('auth');
    Route::get('/longitudes/search/{text}/{orden}', 'ordenBy')->name('longitudes.search')->middleware('auth');
    Route::post('/longitudes/store', 'store')->name('longitudes.store')->middleware('auth');
    Route::delete('/longitudes/{id}', 'destroy')->name('longitudes.destroy')->middleware('auth');
});

Route::controller(CurvaController::class)->group(function () {
    Route::post('/curvas/update/{id}', 'update')->name('curvas.update')->middleware('auth');
    Route::get('/curvas', 'index')->name('curvas.index')->middleware('auth');
    Route::get('/curvas/{id}', 'show')->name('curvas.show')->middleware('auth');
    Route::get('/curvas/search/{text}/{orden}', 'ordenBy')->name('curvas.search')->middleware('auth');
    Route::post('/curvas/store', 'store')->name('curvas.store')->middleware('auth');
    Route::delete('/curvas/{id}', 'destroy')->name('curvas.destroy')->middleware('auth');
});
Route::controller(ColorController::class)->group(function () {
    Route::post('/colores/update/{id}', 'update')->name('colores.update')->middleware('auth');
    Route::get('/colores', 'index')->name('colores.index')->middleware('auth');
    Route::get('/colores/{id}', 'show')->name('colores.show')->middleware('auth');
    Route::get('/colores/search/{text}/{orden}', 'ordenBy')->name('colores.search')->middleware('auth');
    Route::post('/colores/store', 'store')->name('colores.store')->middleware('auth');
    Route::delete('/colores/{id}', 'destroy')->name('colores.destroy')->middleware('auth');
});
Route::controller(DiferenciadorController::class)->group(function () {
    Route::post('/diferenciadores/update/{id}', 'update')->name('diferenciadores.update')->middleware('auth');
    Route::get('/diferenciadores', 'index')->name('diferenciadores.index')->middleware('auth');
    Route::get('/diferenciadores/{id}', 'show')->name('diferenciadores.show')->middleware('auth');
    Route::get('/diferenciadores/search/{text}/{orden}', 'ordenBy')->name('diferenciadores.search')->middleware('auth');
    Route::post('/diferenciadores/store', 'store')->name('diferenciadores.store')->middleware('auth');
    Route::delete('/diferenciadores/{id}', 'destroy')->name('diferenciadores.destroy')->middleware('auth');
});

Route::controller(ProductoController::class)->group(function () {
    //Route::get('/productos/descargaurl/', 'descargar')->name('productos.descargar')->middleware('auth');
    Route::post('/productos/update/{id}', 'update')->name('productos.update')->middleware('auth');
    Route::get('/productos', 'index')->name('productos.index')->middleware('auth');
    Route::get('/productos/{id}', 'show')->name('productos.show')->middleware('auth');
    Route::post('/productos/store', 'store')->name('productos.store')->middleware('auth');
    Route::delete('/productos/{id}', 'destroy')->name('productos.destroy')->middleware('auth');
});

Route::controller(VentaController::class)->group(function () {
    Route::get('/ventas/ticket/{id}', 'generarTicket')->name('ventas.generar_ticket')->middleware('auth');
    Route::post('/ventas/update/{id}', 'update')->name('ventas.update')->middleware('auth');
    Route::get('/ventas/create', 'create')->name('ventas.create')->middleware('auth');
    Route::get('/ventas', 'index')->name('ventas.index')->middleware('auth');
    Route::get('/ventas/{id}', 'edit')->name('ventas.edit')->middleware('auth');
    Route::post('/ventas/store', 'store')->name('ventas.store')->middleware('auth');
    Route::delete('/ventas/{id}', 'destroy')->name('ventas.destroy')->middleware('auth');
    Route::post('/ventas/descuento', 'descuento')->name('ventas.descuento')->middleware('auth');
    Route::get('/ventas/generar_venta/{id}', 'generar')->name('ventas.generar')->middleware('auth');
});
Route::controller(CotizacionController::class)->group(function () {
    Route::get('/cotizaciones/ticket/{id}', 'generarTicket')->name('cotizaciones.generar_ticket')->middleware('auth');
    Route::post('/cotizaciones/update/{id}', 'update')->name('cotizaciones.update')->middleware('auth');
    Route::get('/cotizaciones/create', 'create')->name('cotizaciones.create')->middleware('auth');
    Route::get('/cotizaciones', 'index')->name('cotizaciones.index')->middleware('auth');
    Route::get('/cotizaciones/{id}', 'edit')->name('cotizaciones.edit')->middleware('auth');
    Route::post('/cotizaciones/store', 'store')->name('cotizaciones.store')->middleware('auth');
    Route::delete('/cotizaciones/{id}', 'destroy')->name('cotizaciones.destroy')->middleware('auth');
    Route::post('/cotizaciones/descuento', 'descuento')->name('cotizaciones.descuento')->middleware('auth');
});
Route::controller( ConfiguracionController::class)->group(function () {
    Route::get('/configuraciones', 'index')->name('configuraciones.index')->middleware('auth');
    Route::post('/configuraciones/update/{id}', 'update')->name('configuraciones.update')->middleware('auth');
});
Route::controller( CorteCajaController::class)->group(function () {
    Route::get('/cortecaja', 'index')->name('cortecaja.index')->middleware('auth');

});
Route::controller(AbonoController::class)->group(function () {
    Route::post('/abonos/store', 'store')->name('abonos.store')->middleware('auth');
    Route::get('/abonos', 'index')->name('abonos.index')->middleware('auth');
    Route::get('/abonos/ticket/{id}', 'generarTicket')->name('abonos.generar_ticket')->middleware('auth');
});

Route::controller(SolicitarRetiroController::class)->group(function () {
    Route::get('/solicitar/retiro', 'index')->name('retiros.index')->middleware('auth');
    Route::post('/solicitar/retiro', 'update')->name('retiros.update')->middleware('auth');
});

Route::controller(PedidoController::class)->group(function () {
    Route::get('/pedidos', 'index')->name('pedidos.index')->middleware('auth');
    Route::get('/pedidos/asignar/{id?}', 'asignar')->name('pedidos.asignar')->middleware('auth');
    Route::get('/pedidos/asignarrm', 'asignarrm')->name('pedidos.asignarrm')->middleware('auth');     
    Route::get('/pedidos/asignarindividual/{id?}', 'asignarindividual')->name('pedidos.asignarindividual')->middleware('auth');
     
    Route::post('/pedidos/update/{id}', 'update')->name('pedidos.update')->middleware('auth');
    Route::post('/pedidos/updateMultiple', 'updateMultiple')->name('pedidos.update-multiple')->middleware('auth');
    Route::post('/pedidos/updateMultipleRepartidor', 'updateMultipleRepartidor')->name('pedidos.update-multipleRepartidor')->middleware('auth');

    
    Route::post('/pedidos/updatepedido/{id}', 'updatePedido')->name('pedidos.updatepedido')->middleware('auth');
    Route::get('/pedidos/{id}', 'show')->name('pedidos.show')->middleware('auth');

});

Route::controller(RutaController::class)->group(function () {
    Route::post('/rutas/store', 'store')->name('rutas.store')->middleware('auth');
    Route::get('/rutas', 'index')->name('rutas.index')->middleware('auth');
    Route::get('/rutas/test', 'test')->name('rutas.test')->middleware('auth');
    Route::delete('/rutas/{id}', 'destroy')->name('rutas.destroy')->middleware('auth');
    //colonias ventas
    Route::get('/rutas/colonias', 'colonias')->name('rutas.colonias')->middleware('auth');

});

Route::controller(KardexController::class)->group(function () {
    Route::post('/rutas/guardarEntrada', 'guardarEntrada')->name('kardex.guardar_entrada')->middleware('auth');
    Route::post('/rutas/guardarDevolucion', 'guardarDevolucion')->name('kardex.guardar_devolucion')->middleware('auth');
    Route::get('/kardex/entrada', 'entrada')->name('kardex.entrada')->middleware('auth');
    Route::get('/kardex/devolucion', 'devolucion')->name('kardex.devolucion')->middleware('auth');
    Route::get('/kardex', 'index')->name('kardex.index')->middleware('auth');


});

Route::controller(EnvioController::class)->group(function () {
    Route::get('/envios', 'index')->name('envios.index')->middleware('auth');
    Route::get('/envios/{id}', 'show')->name('envios.show')->middleware('auth');
    Route::get('/envios/asignar/{id}', 'asignar')->name('envios.asignar')->middleware('auth');
    Route::post('/envios/update/{id}', 'update')->name('envios.update')->middleware('auth');
    Route::post('/envios/save-order', 'saveOrder')->name('envios.save-order')->middleware('auth');
});

Route::controller(ReporteVentaController::class)->group(function () {
    Route::get('/reportes', 'index')->name('reportes.index')->middleware('auth');

});
Route::controller(NotificacionController::class)->group(function () {
    Route::get('/notificaciones/marcar-pedido-leido/{id}/{tipo}', 'marcarPedidoLeido')->name('notificaciones.marcar-pedido-leido')->middleware('auth');

});

require __DIR__.'/auth.php';
