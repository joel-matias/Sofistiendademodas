<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $categoriaId = $this->route('categoria')?->id;

        return [
            'nombre'      => [
                'required', 'string', 'max:255',
                Rule::unique('categorias', 'nombre')->ignore($categoriaId),
            ],
            'descripcion' => ['nullable', 'string'],
            'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar los 255 caracteres.',
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.',

            'imagen.image'    => 'El archivo seleccionado no es una imagen válida.',
            'imagen.mimes'    => 'La imagen debe ser JPG, PNG o WebP.',
            'imagen.max'      => 'La imagen no puede pesar más de 10 MB.',
        ];
    }
}
