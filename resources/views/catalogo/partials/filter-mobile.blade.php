{{-- Panel colapsable de filtros — visible únicamente en mobile (oculto en lg+) --}}

<div
    id="panelFiltrosMobile"
    class="lg:hidden hidden mb-5 bg-white rounded-2xl border border-borde
           shadow-suave overflow-hidden">

    {{-- ── Colección ─────────────────────────────────────────────────────── --}}
    <x-catalogo.filter-section
        id="m-coleccion"
        label="Colección"
        size="mobile"
        class="border-b border-borde">
        <div class="px-4 pb-4 flex flex-wrap gap-2">
            <a
                href="{{ $url('nuevo', '1') }}"
                @class([
                    'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                     text-xs font-semibold border transition',
                    'bg-tinta text-crema border-tinta'                         => $isActive('nuevo'),
                    'border-borde text-gris hover:border-tinta hover:text-tinta' => ! $isActive('nuevo'),
                ])>
                ✦ Lo nuevo
            </a>
            <a
                href="{{ $url('ofertas', '1') }}"
                @class([
                    'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                     text-xs font-semibold border transition',
                    'bg-oferta text-white border-oferta'            => $isActive('ofertas'),
                    'border-oferta/30 text-oferta hover:border-oferta' => ! $isActive('ofertas'),
                ])>
                Ofertas
            </a>
        </div>
    </x-catalogo.filter-section>

    {{-- ── Talla ──────────────────────────────────────────────────────────── --}}
    @if ($todasLasTallas->isNotEmpty())
        <x-catalogo.filter-section
            id="m-talla"
            size="mobile"
            class="border-b border-borde">

            {{-- Slot de encabezado personalizado: muestra la talla activa junto al label --}}
            <x-slot:heading>
                <span class="text-[10px] tracking-[0.2em] uppercase text-gris font-semibold">
                    Talla
                    @if ($isActive('talla'))
                        <span class="ml-1 text-tinta normal-case tracking-normal font-bold">
                            · {{ strtoupper($todasLasTallas->firstWhere('slug', $params['talla'] ?? '')?->nombre ?? '') }}
                        </span>
                    @endif
                </span>
            </x-slot:heading>

            <div class="px-4 pb-4 flex flex-wrap gap-1.5">
                @foreach ($todasLasTallas as $talla)
                    <a
                        href="{{ $url('talla', $talla->slug) }}"
                        @class([
                            'inline-flex items-center justify-center min-w-[2.5rem] h-9
                             px-2 rounded-lg text-xs font-semibold border transition',
                            'bg-tinta text-crema border-tinta'           => $isActive('talla', $talla->slug),
                            'border-borde text-tinta hover:border-tinta' => ! $isActive('talla', $talla->slug),
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
            id="m-color"
            label="Color"
            size="mobile"
            class="{{ $filterCount > 0 ? 'border-b border-borde' : '' }}">
            <div class="px-4 pb-4 flex flex-wrap gap-2">
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
        <div class="px-4 py-3">
            <a
                href="{{ $clearAllUrl }}"
                class="text-xs text-gris hover:text-tinta transition underline underline-offset-2">
                Limpiar todos los filtros ({{ $filterCount }})
            </a>
        </div>
    @endif

</div>
