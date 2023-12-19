<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepartidorPedidoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'colonia' => 'required',
            'repartidor_id'=>"required"
        ];
    }
    public function messages()
    {
        return [
           'colonia.required' => 'Este campo es obligatorio.',
           'repartidor_id.required' => 'Este campo es obligatorio.',


        ];
    }
}
