<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ClienteUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'nombre' => 'required',
            'rfc' => 'required',
            'email' => 'required|email',Rule::unique('clientes')->ignore($id),
            'telefono' => 'required',
            'fecha_nacimiento' => 'required',
            'tipo_cliente' => 'required',
            'casa_direccion' => 'required',
            'casa_colonia' => 'required',

        ];
    }
    public function messages()
    {
        return [
           // 'name.required' => 'Nombre es obligatorio.',

        ];
    }
}
