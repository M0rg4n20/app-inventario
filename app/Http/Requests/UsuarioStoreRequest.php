<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            //'email' => 'required|unique:users|email',
            'name' => 'required',
            'perfil' => 'required',
            'username' => 'required|unique:users|alpha_num:ascii',
            //'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{10,}$/',
            'password'=>'required|min:10',
            'photo' => 'image|max:2048|nullable'
            //'password2' => 'required|same:password',

        ];
    }
    public function messages()
    {
        return [
            //'email.required' => 'Email es obligatorio.',
            //'email.unique' => 'email es ya existe',
            'name.required' => 'Nombre es obligatorio.',
            'username.required' => 'Usuario es obligatorio.',
            'password.required' => 'Contraseña es obligatorio.',
            'perfil.required' => 'Perfil es obligatorio.',
            'photo.image' => 'Foto debe ser una imagen.',
        ];
    }
}
