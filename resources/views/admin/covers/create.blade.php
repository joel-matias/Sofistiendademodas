@extends('admin.layouts.app')
@section('title', 'Nuevo cover')
@section('page_title', 'Nuevo cover')

@section('content')
    <div class="max-w-xl">
        <a href="{{ route('admin.covers.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver
        </a>

        <form method="POST" action="{{ route('admin.covers.store') }}" enctype="multipart/form-data"
            class="card p-6 space-y-5">
            @csrf
            <h2 class="font-display text-lg border-b border-borde pb-3">Nuevo cover</h2>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Título *</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}" required
                    class="input @error('titulo') border-red-400 @enderror" placeholder="Ej: Nueva colección">
                @error('titulo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Subtítulo</label>
                <input type="text" name="subtitulo" value="{{ old('subtitulo') }}"
                    class="input @error('subtitulo') border-red-400 @enderror"
                    placeholder="Ej: Descubre las últimas tendencias">
                @error('subtitulo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Texto del botón</label>
                    <input type="text" name="texto_boton" value="{{ old('texto_boton') }}"
                        class="input @error('texto_boton') border-red-400 @enderror" placeholder="Ej: Ver catálogo">
                    @error('texto_boton')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">URL del botón</label>
                    <input type="text" name="url_boton" value="{{ old('url_boton') }}"
                        class="input @error('url_boton') border-red-400 @enderror" placeholder="Ej: /catalogo">
                    @error('url_boton')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Imagen</label>
                <p class="text-xs text-gris mb-2">Sube una imagen o deja en blanco para usar la imagen por defecto del hero.</p>
                <input type="file" name="imagen" accept="image/*"
                    class="block w-full text-sm text-gris file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-tinta file:text-white hover:file:opacity-90 cursor-pointer">
                @error('imagen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Orden</label>
                    <input type="number" name="orden" value="{{ old('orden', 0) }}" min="0"
                        class="input @error('orden') border-red-400 @enderror">
                    @error('orden')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-end pb-0.5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="activo" value="1"
                            {{ old('activo', '1') ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-borde text-tinta">
                        <span class="text-sm font-medium">Activo</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Crear cover</button>
                <a href="{{ route('admin.covers.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
