@extends('admin.layouts.app')
@section('title', 'Editar categoría')
@section('page_title', 'Editar categoría')
@section('page_subtitle', $categoria->nombre)

@section('content')
    <div class="max-w-lg">
        <a href="{{ route('admin.categorias.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver
        </a>
        <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}" enctype="multipart/form-data"
            class="card p-6 space-y-5">
            @csrf @method('PUT')
            <h2 class="font-display text-lg border-b border-borde pb-3">Datos de la categoría</h2>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required
                    class="input @error('nombre') border-red-400 @enderror">
                @error('nombre')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Descripción</label>
                <textarea name="descripcion" rows="3" class="input resize-none">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            </div>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Imagen</label>
                @if ($categoria->imagen)
                    <div class="mb-3">
                        <img src="{{ str_starts_with($categoria->imagen, 'http') ? $categoria->imagen : \Illuminate\Support\Facades\Storage::url($categoria->imagen) }}"
                            class="w-20 h-20 object-cover rounded-xl border border-borde">
                    </div>
                @endif
                <input type="file" name="imagen" accept="image/*"
                    class="block w-full text-sm text-gris file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border file:border-borde file:bg-white file:text-sm file:font-medium hover:file:bg-gray-50 transition">
                @error('imagen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Actualizar</button>
                <a href="{{ route('admin.categorias.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
