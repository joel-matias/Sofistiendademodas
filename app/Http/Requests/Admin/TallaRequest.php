<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TallaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $tallaId = $this->route('talla')?->id;

        return [
            'nombre'  => [
                'required', 'string', 'max:50',
                Rule::unique('tallas', 'nombre')->ignore($tallaId),
            ],
            'orden'   => ['nullable', 'integer', 'min:0', 'max:999'],
            'pecho'   => ['nullable', 'string', 'max:20'],
            'cintura' => ['nullable', 'string', 'max:20'],
            'cadera'  => ['nullable', 'string', 'max:20'],
            'largo'   => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la talla es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar los 50 caracteres.',
            'nombre.unique'   => 'Ya existe una talla con ese nombre.',
            'orden.integer'   => 'El orden debe ser un número entero.',
            'pecho.max'       => 'El valor de pecho no puede superar 20 caracteres.',
            'cintura.max'     => 'El valor de cintura no puede superar 20 caracteres.',
            'cadera.max'      => 'El valor de cadera no puede superar 20 caracteres.',
            'largo.max'       => 'El valor de largo no puede superar 20 caracteres.',
        ];
    }
}
