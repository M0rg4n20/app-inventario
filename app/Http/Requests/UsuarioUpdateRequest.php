<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UsuarioUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [

            'name' => 'required',
            'perfil' => 'required',
            'username' => 'required|alpha_num:ascii',Rule::unique('users')->ignore($id),
            'password'=>'nullable|min:10',
            'photo' => 'image|max:2048|nullable'

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nombre es obligatorio.',
            'username.required' => 'Usuario es obligatorio.',
            'password.required' => 'Contraseña es obligatorio.',
            'perfil.required' => 'Perfil es obligatorio.',
            'photo.image' => 'Foto debe ser una imagen.'
        ];
    }
}
