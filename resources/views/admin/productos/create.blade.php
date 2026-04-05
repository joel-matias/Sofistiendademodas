@extends('admin.layouts.app')

@section('title', 'Nuevo producto')
@section('page_title', 'Nuevo producto')
@section('page_subtitle', 'Agregar un producto al catálogo')

@section('content')

    <div class="max-w-3xl">
        <a href="{{ route('admin.productos.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a productos
        </a>

        <form method="POST" action="{{ route('admin.productos.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Info básica --}}
            <div class="card p-6 space-y-5">
                <h2 class="font-display text-lg border-b border-borde pb-3">Información básica</h2>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nombre *</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required
                            class="input @error('nombre') border-red-400 @enderror"
                            placeholder="Ej: Blusa floral manga larga">
                        @error('nombre')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Descripción</label>
                        <textarea id="descripcionTextarea" name="descripcion" rows="3"
                            class="input resize-none @error('descripcion') border-red-400 @enderror"
                            placeholder="Describe el producto...">{{ old('descripcion') }}</textarea>
                        @include('admin.partials.ai-descripcion')
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Precio (MXN) *</label>
                        <input type="number" name="precio" value="{{ old('precio') }}" required min="0"
                            step="0.01" class="input @error('precio') border-red-400 @enderror" placeholder="0.00">
                        @error('precio')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Precio oferta (MXN)</label>
                        <input type="number" name="precio_oferta" value="{{ old('precio_oferta') }}" min="0"
                            step="0.01" class="input @error('precio_oferta') border-red-400 @enderror" placeholder="0.00">
                        @error('precio_oferta')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="oferta" value="0">
                        <input type="checkbox" name="oferta" value="1" {{ old('oferta') ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-borde text-tinta">
                        <span class="text-sm">En oferta</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-borde text-tinta">
                        <span class="text-sm">Producto activo (visible en catálogo)</span>
                    </label>
                </div>
            </div>

            {{-- Imagen principal --}}
            <div class="card p-6">
                <h2 class="font-display text-lg border-b border-borde pb-3 mb-5">Imagen principal</h2>
                <input type="file" name="imagen" accept="image/*" id="imagenPrincipalInput"
                    class="block w-full text-sm text-gris file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border file:border-borde file:bg-white file:text-sm file:font-medium hover:file:bg-gray-50 transition @error('imagen') ring-1 ring-red-400 rounded-xl @enderror">
                @error('imagen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <div id="imagenPrincipalPreview" class="hidden mt-3">
                    <p class="text-xs text-gris mb-1.5">Vista previa:</p>
                    <img id="imagenPrincipalPreviewImg" src="" class="w-24 h-32 object-cover rounded-xl border border-borde">
                </div>
                <p class="mt-2 text-xs text-gris">JPG, PNG o WebP. Máx. 4 MB.</p>
            </div>

            {{-- Galería --}}
            <div class="card p-6">
                <h2 class="font-display text-lg border-b border-borde pb-3 mb-1">Galería de imágenes</h2>
                <p class="text-xs text-gris mb-5">Hasta 3 imágenes adicionales. La primera se usa en el hover de las tarjetas del catálogo; todas se muestran en el detalle del producto.</p>
                <div id="galeriaPreview" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4 hidden"></div>
                <input type="file" name="galeria[]" accept="image/*" multiple id="galeriaInput"
                    class="block w-full text-sm text-gris file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border file:border-borde file:bg-white file:text-sm file:font-medium hover:file:bg-gray-50 transition">
                @error('galeria')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                @error('galeria.*')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gris">Hasta 3 imágenes. JPG, PNG o WebP. Máx. 4 MB cada una.</p>
            </div>

            {{-- Relaciones --}}
            <div class="card p-6 space-y-5">
                <h2 class="font-display text-lg border-b border-borde pb-3">Categorías, tallas y colores</h2>

                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-2">Categorías</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($categorias as $cat)
                            <label
                                class="flex items-center gap-1.5 cursor-pointer text-sm px-3 py-1.5 rounded-xl border border-borde hover:border-tinta transition has-[:checked]:bg-tinta has-[:checked]:text-crema has-[:checked]:border-tinta">
                                <input type="checkbox" name="categorias[]" value="{{ $cat->id }}" class="sr-only"
                                    {{ in_array($cat->id, old('categorias', [])) ? 'checked' : '' }}>
                                {{ $cat->nombre }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-2">Tallas</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tallas as $talla)
                            <label
                                class="flex items-center gap-1.5 cursor-pointer text-sm px-3 py-1.5 rounded-xl border border-borde hover:border-tinta transition has-[:checked]:bg-tinta has-[:checked]:text-crema has-[:checked]:border-tinta">
                                <input type="checkbox" name="tallas[]" value="{{ $talla->id }}" class="sr-only"
                                    {{ in_array($talla->id, old('tallas', [])) ? 'checked' : '' }}>
                                {{ $talla->nombre }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-2">Colores</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($colores as $color)
                            <label
                                class="flex items-center gap-2 cursor-pointer text-sm px-3 py-1.5 rounded-xl border border-borde hover:border-tinta transition has-[:checked]:bg-tinta has-[:checked]:text-crema has-[:checked]:border-tinta">
                                <input type="checkbox" name="colores[]" value="{{ $color->id }}" class="sr-only"
                                    {{ in_array($color->id, old('colores', [])) ? 'checked' : '' }}>
                                @if ($color->hex)
                                    <span class="w-3 h-3 rounded-full border border-white/30 flex-shrink-0"
                                        style="background:{{ $color->hex }}"></span>
                                @endif
                                {{ $color->nombre }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sucursales --}}
            @if ($sucursales->isNotEmpty())
                <div class="card p-6 space-y-3">
                    <h2 class="font-display text-lg border-b border-borde pb-3">Disponibilidad en sucursales</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($sucursales as $sucursal)
                            <label
                                class="flex items-center gap-1.5 cursor-pointer text-sm px-3 py-1.5 rounded-xl border border-borde hover:border-tinta transition has-[:checked]:bg-tinta has-[:checked]:text-crema has-[:checked]:border-tinta">
                                <input type="checkbox" name="sucursales[]" value="{{ $sucursal->id }}" class="sr-only"
                                    {{ in_array($sucursal->id, old('sucursales', [])) ? 'checked' : '' }}>
                                {{ $sucursal->nombre }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Guardar producto</button>
                <a href="{{ route('admin.productos.index') }}" class="btn-ghost">Cancelar</a>
            </div>

        </form>
    </div>

    <script>
        // Preview imagen principal
        document.getElementById('imagenPrincipalInput')?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('imagenPrincipalPreviewImg').src = e.target.result;
                document.getElementById('imagenPrincipalPreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });

        // Preview galería
        document.getElementById('galeriaInput')?.addEventListener('change', function () {
            const preview = document.getElementById('galeriaPreview');
            preview.innerHTML = '';
            const files = Array.from(this.files).slice(0, 3);
            if (files.length === 0) { preview.classList.add('hidden'); return; }
            preview.classList.remove('hidden');
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'aspect-[3/4] overflow-hidden rounded-xl border border-borde bg-gray-50';
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>

@endsection
