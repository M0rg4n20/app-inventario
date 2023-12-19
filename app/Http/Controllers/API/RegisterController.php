<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken($user->name)->plainTextToken;
        $success['name'] =  $user->name;
        $success['id '] =  $user->id;

        return $this->sendResponse($success, 'Registro de usuario correctamente.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            $user = Auth::user();
            $user->tokens()->delete();
            $success['token'] =  $user->createToken($user->name)->plainTextToken;
            $success['name'] =  $user->name;
            $success['id'] =  $user->id;

            return $this->sendResponse($success, 'Inicio de sesión de usuario correctamente.');
        }
        else{
            return $this->sendError('No autorizado', ['error'=>'No autorizado']);
        }
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['token' => $user->createToken($user->name)->plainTextToken]);
    }
}
