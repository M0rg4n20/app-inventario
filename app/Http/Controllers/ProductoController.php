<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoStoreRequest;
use App\Http\Requests\ProductoUpdateRequest;
use App\Http\Resources\ProductoCollection;
use App\Http\Resources\ProductoResource;
use Illuminate\Support\Facades\Storage;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Curva;
use App\Models\Diferenciador;
use App\Models\Familia;
use App\Models\Longitud;
use App\Models\Marca;
use App\Models\Peso;
use App\Models\Producto;
use App\Models\SubProducto;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


class ProductoController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        $this->middleware(['auth', 'permission:lista-productos'])->only('index');
        $this->middleware(['auth', 'permission:crear-productos'])->only(['store']);
        $this->middleware(['auth', 'permission:editar-productos'])->only(['update']);
        $this->middleware(['auth', 'permission:eliminar-productos'])->only(['destroy']);
    }

    public function index()
    {

        $rol = auth()->user()->roles->pluck('name')[0];

        $roles = Role::where("id", "!=", 1)->get();
        $lista_roles = [];
        foreach ($roles as $value) {
            array_push($lista_roles, [
                'value' => $value->id,
                'label' =>  $value->name,
            ]);
        }

        $categoria_lista = Categoria::get();
        $familia_lista = Familia::get();
        $subproducto_lista = SubProducto::get();
        $marca_lista = Marca::get();
        $peso_lista = Peso::get();
        $longitud_lista = Longitud::get();
        $curva_lista = Curva::get();
        $color_lista = Color::get();
        $diferenciador_lista = Diferenciador::get();

        $categorias = [];
        $familias = [];
        $subproductos = [];
        $marcas = [];
        $pesos = [];
        $longitudes = [];
        $curvas = [];
        $colores = [];
        $diferenciadores = [];

        foreach ($categoria_lista as $value) {
            array_push($categorias, [
                'value' => $value->id,
                'label' =>  $value->nombre,
            ]);
        }
        foreach ($familia_lista as $value) {
            array_push($familias, [
                'value' => $value->id,
                'label' =>  $value->id . " | " . $value->nombre,
            ]);
        }
        foreach ($subproducto_lista as $value) {
            array_push($subproductos, [
                'value' => $value->id,
                'label' =>  $value->id . " | " . $value->nombre,
            ]);
        }
        foreach ($marca_lista as $value) {
            array_push($marcas, [
                'value' => $value->id,
                'label' =>  $value->id . "|" . $value->nombre,
            ]);
        }
        //relacionar con pesos
        foreach ($peso_lista as $value) {
            array_push($pesos, [
                'value' => $value->codigo,
                'label' =>  $value->codigo . " | " . $value->nombre,
            ]);
        }
        //relacionar con longitudes
        foreach ($longitud_lista as $value) {
            array_push($longitudes, [
                'value' => $value->codigo,
                'label' =>  $value->codigo . " | " . $value->nombre,
            ]);
        }
        foreach ($curva_lista as $value) {
            array_push($curvas, [
                'value' => $value->id,
                'label' =>  $value->id . " | " . $value->nombre,
            ]);
        }
        foreach ($color_lista as $value) {
            array_push($colores, [
                'value' => $value->id,
                'label' =>  $value->id . " | " . $value->nombre,
            ]);
        }
        foreach ($diferenciador_lista as $value) {
            array_push($diferenciadores, [
                'value' => $value->id,
                'label' =>  $value->id . " | " . $value->nombre,
            ]);
        }

        return Inertia::render('Producto/Index', [

            'lista_roles' => $lista_roles,
            'categorias' => $categorias,
            'familias' => $familias,
            'subproductos' => $subproductos,
            'marcas' => $marcas,
            'pesos' => $pesos,
            'longitudes' => $longitudes,
            'curvas' => $curvas,
            'colores' => $colores,
            'diferenciadores' => $diferenciadores,
            'productos' => new ProductoCollection(
                Producto::orderBy('id', 'ASC')
                    ->get()
            )
        ]);
    }

    public function store(ProductoStoreRequest $request)
    {
        $new_peso_id = Peso::where('codigo', '=', $request->peso_id)->get();
        $new_longitud_id = Longitud::where('codigo', '=', $request->longitud_id)->get();

        $request->merge([
            "peso_id" => $new_peso_id[0]->id,
            "longitud_id" => $new_longitud_id[0]->id,
        ]);


        $producto = Producto::create($request->input());
        //imagen1
        if ($request->hasFile('photo_1')) {
            sleep(1);
            $fileName = time() . '.' . $request->photo_1->extension();
            $producto->update([
                'imagen_1' => "/images/productos/" . $fileName
            ]);
            $request->photo_1->move(public_path('images/productos'), $fileName);
        } else if ($request->filled('image_url_1')) {

            $url =$request->input('image_url_1');
            sleep(1);
            $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $fileNameUrl = "/images/productos/".time() . '.' . $extension;
            Storage::disk('public')->put($fileNameUrl, $contents);
            $producto->update([
                'imagen_1' =>  $fileNameUrl
            ]);
        } else {
            $producto->update([
                'imagen_1' => "/images/productos/temp_producto.png"
            ]);
        }


        //imagen2
        if ($request->hasFile('photo_2')) {
            sleep(1);
            $fileName = time() . '.' . $request->photo_2->extension();
            $producto->update([
                'imagen_2' => "/images/productos/" . $fileName
            ]);
            $request->photo_2->move(public_path('images/productos'), $fileName);
        } elseif ($request->filled('image_url_2')) {

            $url =$request->input('image_url_2');
            sleep(1);
            $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $fileNameUrl = "/images/productos/".time() . '.' . $extension;
            Storage::disk('public')->put($fileNameUrl, $contents);
            $producto->update([
                'imagen_2' =>  $fileNameUrl
            ]);
        } else {
            $producto->update([
                'imagen_2' => "/images/productos/temp_producto.png"
            ]);
        }

        return Redirect::route('productos.index');
    }

    public function update(ProductoUpdateRequest $request, $id)
    {
        $producto = Producto::find($id);
        $old_photo1 = $producto->imagen_1;
        $old_photo2 = $producto->imagen_2;

        $producto->nombre     = $request->input('nombre');
        $producto->descripcion     = $request->input('descripcion');
        $producto->codigo_barra     = $request->input('codigo_barra');
        $producto->precio_compra     = $request->input('precio_compra');
        $producto->precio_venta     = $request->input('precio_venta');
        $producto->precio_mayorista     = $request->input('precio_mayorista');
        $producto->porcentaje_mayorista     = $request->input('porcentaje_mayorista');
        $producto->porcentaje_venta     = $request->input('porcentaje_venta');
        $producto->check_mayorista     = $request->input('check_mayorista');
        $producto->check_venta     = $request->input('check_venta');

        $producto->save();

           //imagen1
           if ($request->hasFile('photo_1')) {
            sleep(1);
            $url_save = public_path() . $old_photo1;
            $fileName = time() . '.' . $request->photo_1->extension();

                //eliminar pdf si existe
                if (file_exists($url_save) && $old_photo1 != "/images/productos/temp_producto.png") {
                    unlink($url_save);
                }
            $producto->update([
                'imagen_1' => "/images/productos/" . $fileName
            ]);
            $request->photo_1->move(public_path('images/productos'), $fileName);

        } else if ($request->filled('image_url_1')) {

            $url =$request->input('image_url_1');
            sleep(1);
            $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $fileNameUrl = "/images/productos/".time() . '.' . $extension;
            Storage::disk('public')->put($fileNameUrl, $contents);
            $producto->update([
                'imagen_1' =>  $fileNameUrl
            ]);
        } else {
            /*$producto->update([
                'imagen_1' => "/images/productos/temp_producto.png"
            ]);*/
        }

           //imagen2
           if ($request->hasFile('photo_2')) {
            sleep(1);
            $url_save = public_path() . $old_photo2;
            $fileName = time() . '.' . $request->photo_2->extension();

                //eliminar pdf si existe
                if (file_exists($url_save) && $old_photo2 != "/images/productos/temp_producto.png") {
                    unlink($url_save);
                }
            $producto->update([
                'imagen_2' => "/images/productos/" . $fileName
            ]);
            $request->photo_2->move(public_path('images/productos'), $fileName);

        } else if ($request->filled('image_url_2')) {

            $url =$request->input('image_url_2');
            sleep(1);
            $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $fileNameUrl = "/images/productos/".time() . '.' . $extension;
            Storage::disk('public')->put($fileNameUrl, $contents);
            $producto->update([
                'imagen_2' =>  $fileNameUrl
            ]);
        }


        return Redirect::route('productos.index');
    }


    public function destroy($id)
    {
        $producto = Producto::find($id);
        $old_photo1 = $producto->imagen_1;
        $old_photo2 = $producto->imagen_2;
        $url_save = public_path() . $old_photo1;
        $url_save2 = public_path() . $old_photo2;

        //eliminar imagen si existe
        if (file_exists($url_save) && $old_photo1 != "/images/productos/temp_producto.png") {
            unlink($url_save);
        }
        //eliminar imagen si existe
        if (file_exists($url_save2) && $old_photo2 != "/images/productos/temp_producto.png") {
            unlink($url_save2);
        }
        $producto->delete();
    }

    public function show($id)
    {
        /*$producto = Producto::findOrFail($id);
        return response()->json([
            "data" => $producto
        ]);*/


        $producto = new ProductoResource(Producto::findOrFail($id));
        return $producto;
        //dd($producto);
    }

    public function descargar()
    {

    /*$url = "https://naxon.dev/storage/media/urluploadedfile-16037135239s07K.jpg";
    $contents = file_get_contents($url);
    $name = substr($url, strrpos($url, '/') + 1);
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    $fileName = "/images/productos/".time() . '.' . $extension;
    Storage::disk('public')->put($fileName, $contents);*/

    }
}
