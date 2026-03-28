<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nombre'        => ['required', 'string', 'max:255'],
            'descripcion'   => ['nullable', 'string'],
            'precio'        => ['required', 'numeric', 'min:0'],
            'precio_oferta' => [
                $this->boolean('oferta') ? 'required' : 'nullable',
                'numeric',
                'min:0.01',
                'lt:precio',
            ],
            'oferta'        => ['boolean'],
            'activo'        => ['boolean'],
            'imagen'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'galeria'       => ['nullable', 'array', 'max:3'],
            'galeria.*'     => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'categorias'    => ['nullable', 'array'],
            'categorias.*'  => ['integer', 'exists:categorias,id'],
            'tallas'        => ['nullable', 'array'],
            'tallas.*'      => ['integer', 'exists:tallas,id'],
            'colores'       => ['nullable', 'array'],
            'colores.*'     => ['integer', 'exists:colores,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'        => 'El nombre del producto es obligatorio.',
            'nombre.max'             => 'El nombre no puede superar los 255 caracteres.',

            'precio.required'        => 'El precio es obligatorio.',
            'precio.numeric'         => 'El precio debe ser un número válido.',
            'precio.min'             => 'El precio no puede ser negativo.',

            'precio_oferta.required' => 'Si el producto está en oferta debes ingresar el precio de oferta.',
            'precio_oferta.numeric'  => 'El precio de oferta debe ser un número válido.',
            'precio_oferta.min'      => 'El precio de oferta debe ser mayor a cero.',
            'precio_oferta.lt'       => 'El precio de oferta debe ser menor al precio regular.',

            'imagen.image'           => 'El archivo seleccionado no es una imagen válida.',
            'imagen.mimes'           => 'La imagen debe ser JPG, PNG o WebP.',
            'imagen.max'             => 'La imagen no puede pesar más de 4 MB.',

            'galeria.max'            => 'Solo puedes subir hasta 3 imágenes en la galería.',
            'galeria.*.image'        => 'Uno de los archivos de galería no es una imagen válida.',
            'galeria.*.mimes'        => 'Las imágenes de galería deben ser JPG, PNG o WebP.',
            'galeria.*.max'          => 'Cada imagen de galería no puede pesar más de 4 MB.',

            'categorias.*.exists'    => 'Una de las categorías seleccionadas no es válida.',
            'tallas.*.exists'        => 'Una de las tallas seleccionadas no es válida.',
            'colores.*.exists'       => 'Uno de los colores seleccionados no es válido.',
        ];
    }
}
