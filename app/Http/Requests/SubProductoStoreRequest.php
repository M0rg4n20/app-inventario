<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubProductoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'nombre' => 'required|unique:subproductos',
        ];
    }
    public function messages()
    {
        return [
           // 'name.required' => 'Nombre es obligatorio.',

        ];
    }
}
