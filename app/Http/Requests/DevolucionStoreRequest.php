<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DevolucionStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'producto_id' => 'required',
            'user_id'=>"required",
            'tipo'=>"required",
            'cantidad'=>"required",
            'ticket'=>"required",
        ];
    }
    public function messages()
    {
        return [
           'producto_id.required' => 'Este campo es obligatorio.',
           'user_id.required' => 'Este campo es obligatorio.',
           'tipo.required' => 'Este campo es obligatorio.',
           'cantidad.required' => 'Este campo es obligatorio.',
           'ticket.required' => 'Este campo es obligatorio.',


        ];
    }
}
