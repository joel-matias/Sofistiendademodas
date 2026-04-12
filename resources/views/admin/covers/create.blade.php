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
                        list="url-sugerencias"
                        class="input @error('url_boton') border-red-400 @enderror" placeholder="Ej: /catalogo">
                    <datalist id="url-sugerencias">
                        <option value="/catalogo">Catálogo completo</option>
                        <option value="/catalogo?nuevo=1">Lo nuevo</option>
                        <option value="/catalogo?ofertas=1">Ofertas</option>
                        <option value="/">Inicio</option>
                        <option value="/nosotros">Nosotros</option>
                        <option value="/guia-de-tallas">Guía de tallas</option>
                    </datalist>
                    @error('url_boton')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Imagen</label>
                <p class="text-xs text-gris mb-2">Sube una imagen o deja en blanco para usar la imagen por defecto del hero.</p>
                <input type="file" name="imagen" accept="image/*" id="coverImagenInput"
                    class="block w-full text-sm text-gris file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-tinta file:text-white hover:file:opacity-90 cursor-pointer @error('imagen') ring-1 ring-red-400 rounded-xl @enderror">
                @error('imagen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <div id="coverImagenPreview" class="hidden mt-3">
                    <p class="text-xs text-gris mb-1.5">Vista previa:</p>
                    <div class="relative inline-block group/cover">
                        <img id="coverImagenPreviewImg" src="" class="h-24 w-auto rounded-lg object-cover border border-borde">
                        <button type="button" id="coverImagenQuitar"
                            class="absolute top-1 right-1 w-6 h-6 bg-white rounded-full shadow-sm border border-borde
                                   flex items-center justify-center text-gris hover:text-red-500 hover:border-red-300
                                   transition opacity-0 group-hover/cover:opacity-100 text-xs font-bold leading-none">✕</button>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gris">JPG, PNG o WebP. Máx. 10 MB.</p>
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

    <script>
        const coverInput     = document.getElementById('coverImagenInput');
        const coverPreview   = document.getElementById('coverImagenPreview');
        const coverImg       = document.getElementById('coverImagenPreviewImg');
        const coverQuitarBtn = document.getElementById('coverImagenQuitar');

        coverInput?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                coverImg.src = e.target.result;
                coverPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });

        coverQuitarBtn?.addEventListener('click', function () {
            coverInput.value = '';
            coverPreview.classList.add('hidden');
            coverImg.src = '';
        });
    </script>
@endsection
