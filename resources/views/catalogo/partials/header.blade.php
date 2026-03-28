{{-- Encabezado de página: varía según el contexto de navegación activo --}}

@if (request('search'))

    <div class="mb-6">
        <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-2">
            Resultados de búsqueda
        </p>
        <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
            <h1 class="section-title">"{{ request('search') }}"</h1>
            <span class="text-gris text-base font-light">
                {{ $productos->total() }}
                {{ $productos->total() === 1 ? 'resultado' : 'resultados' }}
            </span>
        </div>
        <a
            href="{{ route('catalogo', array_filter(['categoria' => request('categoria')])) }}"
            class="mt-2 inline-flex items-center gap-1.5 text-xs text-gris hover:text-tinta transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Limpiar búsqueda
        </a>
    </div>

@elseif (request()->boolean('nuevo'))

    <div class="mb-6">
        <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Colección</p>
        <h1 class="section-title">Lo Nuevo</h1>
        <p class="mt-1 text-sm text-gris">Productos de los últimos 30 días</p>
    </div>

@elseif (! empty($categoriaSeleccionada))

    <div class="mb-6">
        <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Categoría</p>
        <h1 class="section-title">{{ $categoriaSeleccionada['nombre'] }}</h1>
    </div>

@else

    <div class="mb-6">
        <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Tienda</p>
        <h1 class="section-title">Catálogo</h1>
    </div>

@endif
