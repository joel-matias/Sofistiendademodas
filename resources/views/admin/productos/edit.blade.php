@extends('admin.layouts.app')

@section('title', 'Editar producto')
@section('page_title', 'Editar producto')
@section('page_subtitle', $producto->nombre)

@section('content')

    <div class="max-w-3xl">
        <a href="{{ route('admin.productos.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a productos
        </a>

        <form method="POST" action="{{ route('admin.productos.update', $producto) }}" enctype="multipart/form-data"
            class="space-y-6">
            @csrf @method('PUT')

            <div class="card p-6 space-y-5">
                <h2 class="font-display text-lg border-b border-borde pb-3">Información básica</h2>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nombre *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                            class="input @error('nombre') border-red-400 @enderror">
                        @error('nombre')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Descripción</label>
                        <textarea id="descripcionTextarea" name="descripcion" rows="3"
                            class="input resize-none">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @include('admin.partials.ai-descripcion')
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Precio (MXN) *</label>
                        <input type="number" name="precio" value="{{ old('precio', $producto->precio) }}" required
                            min="0" step="0.01" class="input">
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Precio oferta (MXN)</label>
                        <input type="number" name="precio_oferta"
                            value="{{ old('precio_oferta', $producto->precio_oferta) }}" min="0" step="0.01"
                            class="input @error('precio_oferta') border-red-400 @enderror">
                        @error('precio_oferta')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="oferta" value="0">
                        <input type="checkbox" name="oferta" value="1"
                            {{ old('oferta', $producto->oferta) ? 'checked' : '' }} class="w-4 h-4 rounded border-borde">
                        <span class="text-sm">En oferta</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" name="activo" value="1"
                            {{ old('activo', $producto->activo) ? 'checked' : '' }} class="w-4 h-4 rounded border-borde">
                        <span class="text-sm">Producto activo</span>
                    </label>
                </div>
            </div>

            {{-- Imagen principal --}}
            <div class="card p-6">
                <h2 class="font-display text-lg border-b border-borde pb-3 mb-5">Imagen principal</h2>
                @if ($producto->imagen)
                    <div class="mb-4 flex items-start gap-4">
                        <img id="imagenActualSrc"
                            src="{{ str_starts_with($producto->imagen, 'http') ? $producto->imagen : \Illuminate\Support\Facades\Storage::url($producto->imagen) }}"
                            class="w-24 h-32 object-cover rounded-xl border border-borde flex-shrink-0">
                        <div>
                            <p class="text-xs font-medium text-tinta mb-1">Imagen actual</p>
                            <p class="text-xs text-gris">Sube una nueva para reemplazarla.</p>
                        </div>
                    </div>
                @endif
                <input type="file" name="imagen" accept="image/*" id="imagenPrincipalInput"
                    class="block w-full text-sm text-gris file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border file:border-borde file:bg-white file:text-sm file:font-medium hover:file:bg-gray-50 transition @error('imagen') ring-1 ring-red-400 rounded-xl @enderror">
                @error('imagen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <div id="imagenPrincipalPreview" class="hidden mt-3">
                    <p class="text-xs text-gris mb-1.5">Vista previa nueva:</p>
                    <div class="relative inline-block group/principal">
                        <img id="imagenPrincipalPreviewImg" src="" class="w-24 h-32 object-cover rounded-xl border border-borde">
                        <button type="button" id="imagenPrincipalQuitar"
                            class="absolute top-1 right-1 w-6 h-6 bg-white rounded-full shadow-sm border border-borde
                                   flex items-center justify-center text-gris hover:text-red-500 hover:border-red-300
                                   transition opacity-0 group-hover/principal:opacity-100 text-xs font-bold leading-none">✕</button>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gris">JPG, PNG o WebP. Máx. 4 MB.</p>
            </div>

            {{-- Galería --}}
            <div class="card p-6">
                <h2 class="font-display text-lg border-b border-borde pb-3 mb-1">Galería de imágenes</h2>
                <p class="text-xs text-gris mb-5">Hasta 3 imágenes adicionales. Se muestran en el detalle del producto y en el hover de las tarjetas del catálogo.</p>

                @if ($imagenes->isNotEmpty())
                    <p class="text-xs text-gris mb-3">Arrastra las imágenes para cambiar el orden.</p>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-5" id="galeriaExistente"
                        data-reorder-url="{{ route('admin.productos.imagenes.reorder', $producto) }}"
                        data-token="{{ csrf_token() }}">
                        @foreach ($imagenes as $img)
                            <div class="relative group/img cursor-grab active:cursor-grabbing" draggable="true" data-id="{{ $img->id }}">
                                <div class="aspect-[3/4] overflow-hidden rounded-xl border border-borde bg-gray-50">
                                    <img src="{{ str_starts_with($img->url, 'http') ? $img->url : \Illuminate\Support\Facades\Storage::url($img->url) }}"
                                        class="w-full h-full object-cover pointer-events-none">
                                </div>
                                <button type="button"
                                    data-url="{{ route('admin.productos.imagenes.destroy', [$producto, $img]) }}"
                                    data-token="{{ csrf_token() }}"
                                    onclick="deleteGalleryImage(this)"
                                    class="absolute top-1.5 right-1.5 w-6 h-6 bg-white rounded-full shadow-sm border border-borde flex items-center justify-center text-gris hover:text-red-500 hover:border-red-300 transition opacity-0 group-hover/img:opacity-100 text-xs font-bold leading-none">
                                    ✕
                                </button>
                                <p class="mt-1 text-center text-[10px] text-gris orden-label">#{{ $loop->iteration }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @php $disponibles = 3 - $imagenes->count(); @endphp

                @if ($disponibles > 0)
                    <div id="galeriaPreview" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4 hidden"></div>
                    <input type="file" name="galeria[]" accept="image/*" multiple id="galeriaInput"
                        class="block w-full text-sm text-gris file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border file:border-borde file:bg-white file:text-sm file:font-medium hover:file:bg-gray-50 transition">
                    @error('galeria')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    @error('galeria.*')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gris">
                        Puedes agregar hasta <strong>{{ $disponibles }}</strong> imagen{{ $disponibles > 1 ? 'es' : '' }} más.
                        La primera imagen de la galería se usa en el hover de las tarjetas.
                    </p>
                @else
                    <p class="text-sm text-gris bg-gray-50 rounded-xl px-4 py-3 border border-borde">
                        Galería completa (3/3). Elimina alguna para agregar nuevas.
                    </p>
                @endif
            </div>

            <div class="card p-6 space-y-5">
                <h2 class="font-display text-lg border-b border-borde pb-3">Categorías, tallas y colores</h2>

                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-2">Categorías</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($categorias as $cat)
                            <label
                                class="flex items-center gap-1.5 cursor-pointer text-sm px-3 py-1.5 rounded-xl border border-borde hover:border-tinta transition has-[:checked]:bg-tinta has-[:checked]:text-crema has-[:checked]:border-tinta">
                                <input type="checkbox" name="categorias[]" value="{{ $cat->id }}" class="sr-only"
                                    {{ in_array($cat->id, old('categorias', $categoriasSeleccionadas)) ? 'checked' : '' }}>
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
                                    {{ in_array($talla->id, old('tallas', $tallasSeleccionadas)) ? 'checked' : '' }}>
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
                                    {{ in_array($color->id, old('colores', $coloresSeleccionados)) ? 'checked' : '' }}>
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
                                    {{ in_array($sucursal->id, old('sucursales', $sucursalesSeleccionadas)) ? 'checked' : '' }}>
                                {{ $sucursal->nombre }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Actualizar producto</button>
                <a href="{{ route('admin.productos.index') }}" class="btn-ghost">Cancelar</a>
            </div>

        </form>
    </div>

    <script>
        // ── Eliminar imagen de galería existente ────────────────────────────
        function deleteGalleryImage(btn) {
            window.SofisAlert.confirm('¿Eliminar esta imagen de la galería?').then(({ isConfirmed }) => {
                if (!isConfirmed) { return; }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = btn.dataset.url;
                form.innerHTML =
                    '<input type="hidden" name="_token" value="' + btn.dataset.token + '">' +
                    '<input type="hidden" name="_method" value="DELETE">';
                document.body.appendChild(form);
                form.submit();
            });
        }

        // ── Imagen principal ─────────────────────────────────────────────────
        const principalInput     = document.getElementById('imagenPrincipalInput');
        const principalPreview   = document.getElementById('imagenPrincipalPreview');
        const principalImg       = document.getElementById('imagenPrincipalPreviewImg');
        const principalQuitarBtn = document.getElementById('imagenPrincipalQuitar');

        principalInput?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                principalImg.src = e.target.result;
                principalPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });

        principalQuitarBtn?.addEventListener('click', function () {
            principalInput.value = '';
            principalPreview.classList.add('hidden');
            principalImg.src = '';
        });

        // ── Galería: nuevas imágenes (con X y drag & drop) ───────────────────
        const galeriaInput   = document.getElementById('galeriaInput');
        const galeriaPreview = document.getElementById('galeriaPreview');
        let galeriaFiles     = [];

        galeriaInput?.addEventListener('change', function () {
            const existentes  = document.getElementById('galeriaExistente')?.querySelectorAll('[data-id]').length ?? 0;
            const disponibles = 3 - existentes - galeriaFiles.length;
            Array.from(this.files).slice(0, disponibles).forEach(f => galeriaFiles.push(f));
            this.value = '';
            renderGaleria();
        });

        function renderGaleria() {
            if (!galeriaPreview) return;
            galeriaPreview.innerHTML = '';
            if (galeriaFiles.length === 0) { galeriaPreview.classList.add('hidden'); return; }
            galeriaPreview.classList.remove('hidden');

            galeriaFiles.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const wrap = document.createElement('div');
                    wrap.className = 'relative group/img cursor-grab active:cursor-grabbing';
                    wrap.draggable = true;
                    wrap.dataset.idx = idx;
                    wrap.innerHTML = `
                        <div class="aspect-[3/4] overflow-hidden rounded-xl border border-borde bg-gray-50">
                            <img src="${e.target.result}" class="w-full h-full object-cover pointer-events-none">
                        </div>
                        <button type="button" onclick="quitarGaleriaFile(${idx})"
                            class="absolute top-1.5 right-1.5 w-6 h-6 bg-white rounded-full shadow-sm border border-borde
                                   flex items-center justify-center text-gris hover:text-red-500 hover:border-red-300
                                   transition opacity-0 group-hover/img:opacity-100 text-xs font-bold leading-none">✕</button>
                        <p class="mt-1 text-center text-[10px] text-gris">#${idx + 1}</p>`;
                    galeriaPreview.appendChild(wrap);
                    iniciarDragNueva(wrap);
                };
                reader.readAsDataURL(file);
            });

            sincronizarInputGaleria();
        }

        function quitarGaleriaFile(idx) {
            galeriaFiles.splice(idx, 1);
            renderGaleria();
        }

        function sincronizarInputGaleria() {
            if (!galeriaInput) return;
            const dt = new DataTransfer();
            galeriaFiles.forEach(f => dt.items.add(f));
            galeriaInput.files = dt.files;
        }

        // Drag & drop para nuevas imágenes
        let dragIdxNueva = null;

        function iniciarDragNueva(el) {
            el.addEventListener('dragstart', () => { dragIdxNueva = parseInt(el.dataset.idx); el.classList.add('opacity-50'); });
            el.addEventListener('dragend',   () => el.classList.remove('opacity-50'));
            el.addEventListener('dragover',  e => e.preventDefault());
            el.addEventListener('drop', () => {
                const overIdx = parseInt(el.dataset.idx);
                if (dragIdxNueva === null || dragIdxNueva === overIdx) return;
                const moved = galeriaFiles.splice(dragIdxNueva, 1)[0];
                galeriaFiles.splice(overIdx, 0, moved);
                dragIdxNueva = null;
                renderGaleria();
            });
        }

        // ── Drag & drop para imágenes existentes (AJAX reorder) ──────────────
        const galeriaExistente = document.getElementById('galeriaExistente');

        if (galeriaExistente) {
            let dragEl   = null;
            let dragOver = null;

            galeriaExistente.querySelectorAll('[draggable]').forEach(el => {
                el.addEventListener('dragstart', () => {
                    dragEl = el;
                    el.classList.add('opacity-50');
                });
                el.addEventListener('dragend', () => {
                    el.classList.remove('opacity-50');
                    dragEl = null;
                    dragOver = null;
                });
                el.addEventListener('dragover', e => {
                    e.preventDefault();
                    if (dragOver && dragOver !== el) dragOver.classList.remove('ring-2', 'ring-tinta');
                    dragOver = el;
                    el.classList.add('ring-2', 'ring-tinta');
                });
                el.addEventListener('drop', () => {
                    el.classList.remove('ring-2', 'ring-tinta');
                    if (!dragEl || dragEl === el) return;

                    // Reorder DOM
                    const items   = [...galeriaExistente.querySelectorAll('[data-id]')];
                    const fromIdx = items.indexOf(dragEl);
                    const toIdx   = items.indexOf(el);
                    if (fromIdx < toIdx) {
                        el.after(dragEl);
                    } else {
                        el.before(dragEl);
                    }

                    // Update order labels
                    galeriaExistente.querySelectorAll('.orden-label').forEach((lbl, i) => {
                        lbl.textContent = '#' + (i + 1);
                    });

                    // AJAX persist
                    const ids = [...galeriaExistente.querySelectorAll('[data-id]')].map(n => n.dataset.id);
                    fetch(galeriaExistente.dataset.reorderUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': galeriaExistente.dataset.token,
                        },
                        body: JSON.stringify({ ids }),
                    });
                });
            });
        }
    </script>

@endsection
