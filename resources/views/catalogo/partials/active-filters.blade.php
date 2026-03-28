{{-- Chips de filtros activos + conteo de productos — visible únicamente en desktop (lg+) --}}

<div class="hidden lg:flex items-center gap-3 flex-wrap mb-5 pb-4 border-b border-borde min-h-[2.5rem]">

    <p class="text-sm text-gris">
        {{ $productos->total() }} {{ $productos->total() === 1 ? 'producto' : 'productos' }}
    </p>

    @if ($isActive('nuevo'))
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                     bg-tinta/5 border border-borde text-xs text-tinta">
            ✦ Lo nuevo
            <a href="{{ $url('nuevo', '1') }}" class="hover:text-oferta ml-0.5 transition">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </span>
    @endif

    @if ($isActive('ofertas'))
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                     bg-oferta/5 border border-oferta/20 text-xs text-oferta">
            Ofertas
            <a href="{{ $url('ofertas', '1') }}" class="hover:text-tinta ml-0.5 transition">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </span>
    @endif

    @if ($isActive('talla'))
        @php $tallaActiva = $todasLasTallas->firstWhere('slug', $params['talla'] ?? ''); @endphp
        @if ($tallaActiva)
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                         bg-tinta/5 border border-borde text-xs text-tinta">
                Talla: {{ strtoupper($tallaActiva->nombre) }}
                <a href="{{ $url('talla', $tallaActiva->slug) }}" class="hover:text-oferta ml-0.5 transition">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </span>
        @endif
    @endif

    @if ($isActive('color'))
        @php $colorActivo = $todosLosColores->firstWhere('slug', $params['color'] ?? ''); @endphp
        @if ($colorActivo)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full
                         bg-tinta/5 border border-borde text-xs text-tinta">
                <span
                    class="w-3 h-3 rounded-full flex-shrink-0 border border-borde/50"
                    style="background-color: {{ $colorActivo->hex ?? '#ccc' }}">
                </span>
                {{ $colorActivo->nombre }}
                <a href="{{ $url('color', $colorActivo->slug) }}" class="hover:text-oferta ml-0.5 transition">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </span>
        @endif
    @endif

</div>
