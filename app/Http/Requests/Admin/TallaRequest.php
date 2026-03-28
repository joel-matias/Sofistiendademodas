<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TallaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tallaId = $this->route('talla')?->id;

        return [
            'nombre' => [
                'required', 'string', 'max:50',
                Rule::unique('tallas', 'nombre')->ignore($tallaId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la talla es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar los 50 caracteres.',
            'nombre.unique'   => 'Ya existe una talla con ese nombre.',
        ];
    }
}
