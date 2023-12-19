<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class PesoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'nombre' => 'required',Rule::unique('pesos')->ignore($id),
            'codigo' => 'required|max:3',Rule::unique('pesos')->ignore($id),

        ];
    }
    public function messages()
    {
        return [
           // 'name.required' => 'Nombre es obligatorio.',

        ];
    }
}
