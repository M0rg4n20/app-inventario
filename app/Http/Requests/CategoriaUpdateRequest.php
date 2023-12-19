<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CategoriaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'nombre' => 'required',Rule::unique('categorias')->ignore($id),

        ];
    }
    public function messages()
    {
        return [
           // 'name.required' => 'Nombre es obligatorio.',

        ];
    }
}
