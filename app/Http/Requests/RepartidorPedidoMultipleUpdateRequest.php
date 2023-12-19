<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepartidorPedidoMultipleUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'ruta_id' => 'required',
            'repartidor_id'=>"required"
        ];
    }
    public function messages()
    {
        return [
           'ruta_id.required' => 'Este campo es obligatorio.',
           'repartidor_id.required' => 'Este campo es obligatorio.',


        ];
    }
}
