{{-- Sidebar de filtros — visible únicamente en desktop (lg+), posición sticky --}}

<aside class="hidden lg:block w-56 xl:w-60 flex-shrink-0 sticky top-24">

    {{-- ── Colección ─────────────────────────────────────────────────────── --}}
    <x-catalogo.filter-section
        id="coleccion"
        label="Colección"
        class="border-b border-borde pb-4 mb-4">
        <div class="space-y-1">
            <a
                href="{{ $url('nuevo', '1') }}"
                @class([
                    'flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition font-medium',
                    'bg-tinta text-crema'                          => $isActive('nuevo'),
                    'text-gris hover:bg-gray-100 hover:text-tinta' => ! $isActive('nuevo'),
                ])>
                <span class="text-moda text-xs">✦</span>
                Lo nuevo
                <span class="text-[10px] ml-auto font-normal
                    {{ $isActive('nuevo') ? 'text-crema/60' : 'text-gris/50' }}">
                    30 días
                </span>
            </a>
            <a
                href="{{ $url('ofertas', '1') }}"
                @class([
                    'flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition font-medium',
                    'bg-oferta text-white'           => $isActive('ofertas'),
                    'text-oferta hover:bg-oferta/10' => ! $isActive('ofertas'),
                ])>
                Ofertas
            </a>
        </div>
    </x-catalogo.filter-section>

    {{-- ── Ordenar ─────────────────────────────────────────────────────────── --}}
    <x-catalogo.filter-section
        id="ordenar"
        class="border-b border-borde pb-4 mb-4">

        {{-- Encabezado personalizado: incluye el punto indicador cuando hay orden activo --}}
        <x-slot:heading>
            <span class="text-[10px] tracking-[0.2em] uppercase text-gris
                         group-hover:text-tinta transition">
                Ordenar
                @if ($ordenActual !== '')
                    <span class="ml-1 w-1.5 h-1.5 rounded-full bg-tinta inline-block align-middle"></span>
                @endif
            </span>
        </x-slot:heading>

        <div class="space-y-0.5">
            @foreach ([
                ''             => 'Más nuevos',
                'precio_menor' => 'Precio: menor → mayor',
                'precio_mayor' => 'Precio: mayor → menor',
            ] as $val => $label)
                <a
                    href="{{ $ordenUrl($val) }}"
                    @class([
                        'flex items-center px-3 py-2 rounded-lg text-sm transition',
                        'bg-gray-100 font-semibold text-tinta'         => $ordenActual === $val,
                        'text-gris hover:bg-gray-100 hover:text-tinta' => $ordenActual !== $val,
                    ])>
                    {{ $label }}
                </a>
            @endforeach
        </div>

    </x-catalogo.filter-section>

    {{-- ── Talla ──────────────────────────────────────────────────────────── --}}
    @if ($todasLasTallas->isNotEmpty())
        <x-catalogo.filter-section
            id="talla"
            label="Talla"
            :dot="$isActive('talla')"
            class="border-b border-borde pb-4 mb-4">
            <div class="flex flex-wrap gap-1.5">
                @foreach ($todasLasTallas as $talla)
                    <a
                        href="{{ $url('talla', $talla->slug) }}"
                        @class([
                            'inline-flex items-center justify-center min-w-[2.5rem] h-9
                             px-2 rounded-lg text-xs font-semibold border transition',
                            'bg-tinta text-crema border-tinta'                           => $isActive('talla', $talla->slug),
                            'border-borde text-tinta hover:border-tinta hover:bg-gray-50' => ! $isActive('talla', $talla->slug),
                        ])>
                        {{ strtoupper($talla->nombre) }}
                    </a>
                @endforeach
            </div>
        </x-catalogo.filter-section>
    @endif

    {{-- ── Color ──────────────────────────────────────────────────────────── --}}
    @if ($todosLosColores->isNotEmpty())
        <x-catalogo.filter-section
            id="color"
            label="Color"
            :dot="$isActive('color')"
            class="{{ $filterCount > 0 ? 'border-b border-borde pb-4 mb-4' : 'pb-2' }}">
            <div class="flex flex-wrap gap-2">
                @foreach ($todosLosColores as $color)
                    <x-catalogo.color-swatch
                        :href="$url('color', $color->slug)"
                        :active="$isActive('color', $color->slug)"
                        :color="$color" />
                @endforeach
            </div>
        </x-catalogo.filter-section>
    @endif

    {{-- ── Limpiar filtros ────────────────────────────────────────────────── --}}
    @if ($filterCount > 0)
        <a
            href="{{ $clearAllUrl }}"
            class="flex items-center gap-1.5 text-xs text-gris hover:text-tinta transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Limpiar filtros ({{ $filterCount }})
        </a>
    @endif

</aside>
