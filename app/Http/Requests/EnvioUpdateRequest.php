<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnvioUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'ruta_id' => 'required',
            'repartidor_id'=>"required",
            'fecha' => 'required',
            'estado' => 'required',
            'telefono'=>"required"
        ];
    }
    public function messages()
    {
        return [
           'ruta_id.required' => 'Este campo es obligatorio.',
           'repartidor_id.required' => 'Este campo es obligatorio.',
           'telefono.required' => 'Este campo es obligatorio.',
           'estado.required' => 'Este campo es obligatorio.',
           'fecha.required' => 'Este campo es obligatorio.',


        ];
    }
}
