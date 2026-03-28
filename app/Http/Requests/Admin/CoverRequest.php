<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CoverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'titulo'      => ['required', 'string', 'max:150'],
            'subtitulo'   => ['nullable', 'string', 'max:255'],
            'texto_boton' => ['nullable', 'string', 'max:80'],
            'url_boton'   => ['nullable', 'string', 'max:255'],
            'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'orden'       => ['required', 'integer', 'min:0'],
            'activo'      => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'  => 'El título del cover es obligatorio.',
            'titulo.max'       => 'El título no puede superar los 150 caracteres.',
            'subtitulo.max'    => 'El subtítulo no puede superar los 255 caracteres.',
            'texto_boton.max'  => 'El texto del botón no puede superar los 80 caracteres.',
            'url_boton.max'    => 'La URL del botón no puede superar los 255 caracteres.',

            'imagen.image'     => 'El archivo seleccionado no es una imagen válida.',
            'imagen.mimes'     => 'La imagen debe ser JPG, PNG o WebP.',
            'imagen.max'       => 'La imagen no puede pesar más de 4 MB.',

            'orden.required'   => 'El orden es obligatorio.',
            'orden.integer'    => 'El orden debe ser un número entero.',
            'orden.min'        => 'El orden no puede ser negativo.',
        ];
    }
}
