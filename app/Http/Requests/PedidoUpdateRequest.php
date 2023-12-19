<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'fecha' => 'required',
            'telefono'=>"required"
        ];
    }
    public function messages()
    {
        return [
           'telefono.required' => 'Este campo es obligatorio.',
           'fecha.required' => 'Este campo es obligatorio.',


        ];
    }
}
