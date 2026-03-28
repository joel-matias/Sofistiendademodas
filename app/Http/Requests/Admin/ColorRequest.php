<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $colorId = $this->route('color')?->id;

        return [
            'nombre' => [
                'required', 'string', 'max:100',
                Rule::unique('colores', 'nombre')->ignore($colorId),
            ],
            'hex' => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del color es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar los 100 caracteres.',
            'nombre.unique'   => 'Ya existe un color con ese nombre.',

            'hex.regex'       => 'El código de color no es válido. Debe tener el formato #000000.',
        ];
    }
}
