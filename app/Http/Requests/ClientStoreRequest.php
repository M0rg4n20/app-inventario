<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'nombre' => 'required',
            //'rfc' => 'required',
            'email' => 'required|unique:clientes|email',
            //'telefono' => 'required',
            //'fecha_nacimiento' => 'required',
            //'tipo_cliente' => 'required',
            'casa_direccion' => 'required',
            'casa_colonia' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nombre es obligatorio.',
            'email.required' => 'Email es obligatorio.',
            'casa_direccion.required' => 'Dirección de casa es obligatorio.',
            'casa_colonia.required' => 'Dirección de colonia es obligatorio.',
        ];
    }
}
