<?php

namespace App\Http\Controllers;


use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Http\Resources\UsuarioCollection;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class UsuarioController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-usuarios'])->only('index');
        //$this->middleware(['auth', 'permission:crear-usuarios'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-usuarios'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-usuarios'])->only(['destroy']);
    }

    public function index()
    {

        $rol = auth()->user()->roles->pluck('name')[0];

        $roles=Role::where("id","!=",1)->get();
        $lista_roles = [];
        foreach ($roles as $value) {
            array_push($lista_roles, [
                'value' => $value->id,
                'label' =>  $value->name,
            ]);
        }

        if($rol=="Super Administrador"){
            return Inertia::render('Usuarios/Index', [
                //'filters' => Request::all('search'),
                'lista_roles'=>$lista_roles,
                'usuarios' => new UsuarioCollection(
                    User::orderBy('id', 'ASC')
                    ->get())]);
        }else{
            return Inertia::render('Usuarios/Index', [
                //'filters' => Request::all('search'),
                'lista_roles'=>$lista_roles,
                'usuarios' => new UsuarioCollection(
                    User:: where('id','!=',1)->
                    orderBy('id', 'ASC')
                    ->filter(Request::only('search'))
                    ->get())
            ]);
        }


    }

    public function store(UsuarioStoreRequest $request)
    {

        $rol=Role::where('id',$request->perfil)->first();

        $user = new User();
        $user->name     = $request->input('name');
        $user->username     = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        if ($request->hasFile('photo')) {
            $fileName = time().'.'.$request->photo->extension();
            $user->update([
                'photo'=>"/images/usuarios/".$fileName
            ]);
            $request->photo->move(public_path('images/usuarios'), $fileName);
        }else{
            $user->update([
                'photo'=>"/images/usuarios/user.png"
            ]);
        }


        $user->assignRole($rol->name);

    }

    public function update(UsuarioUpdateRequest $request, $id)
    {
        $user=User::find($id);
        $rol=Role::where('id',$request->perfil)->first();
        $old_photo=$user->photo;
        $user->name     = $request->input('name');
        $user->username     = $request->input('username');

        if($request->input('password')){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        if ($request->hasFile('photo')) {
            $fileName = time().'.'.$request->photo->extension();
            $url_save = public_path() . $old_photo;

        //eliminar pdf si existe
        if (file_exists($url_save )&& $old_photo!="/images/usuarios/user.png") {
            unlink($url_save);
        }
            $user->update([
                'photo'=>"/images/usuarios/".$fileName
            ]);
            $request->photo->move(public_path('images/usuarios'), $fileName);
        }else{
            /*$user->update([
                'photo'=>"/images/usuarios/user.png"
            ]);*/
        }
        $user->syncRoles($rol->name);
        return Redirect::route('usuarios.index');

    }


    public function destroy($id)
    {
        $user=User::find($id);
        $old_photo=$user->photo;
        $url_save = public_path() . $old_photo;

        //eliminar pdf si existe
        if (file_exists($url_save )&& $old_photo!="/images/usuarios/user.png") {
            unlink($url_save);
        }
        $user->delete();
        //$usuario = auth()->user()->name;
        //Log::alert('Administrador: ' . $client->name . ' ha sido eliminado por ' . $usuario);
        //return redirect('admins');
    }

    public function status($id,$status){
        $usuario=User::find($id);
        $usuario->update([
        'status'=>$status
        ]);
    }

}
