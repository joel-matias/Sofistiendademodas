{{-- Barra de herramientas mobile: botón de filtros + selector de ordenamiento --}}

<div class="flex items-center gap-2 mb-4 lg:hidden">

    {{-- Botón para abrir/cerrar el panel lateral de filtros --}}
    <button
        id="btnFiltrosMobile"
        onclick="toggleFiltrosMobile()"
        aria-expanded="false"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-borde
               bg-white text-sm font-medium hover:border-tinta transition">

        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707
                   L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586
                   L3.293 6.707A1 1 0 013 6V4z" />
        </svg>

        Filtros

        @if ($filterCount > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full
                         bg-tinta text-crema text-[10px] font-bold">
                {{ $filterCount }}
            </span>
        @endif

    </button>

    {{-- Selector de ordenamiento + conteo de prendas --}}
    <div class="ml-auto flex items-center gap-3">

        <div class="relative">
            <select
                onchange="window.location.href = this.value"
                class="appearance-none pl-3 pr-8 py-2.5 rounded-xl border border-borde
                       bg-white text-sm outline-none focus:ring-2 focus:ring-tinta/20
                       transition cursor-pointer">
                <option
                    value="{{ $ordenUrl('') }}"
                    {{ $ordenActual === '' ? 'selected' : '' }}>
                    Más nuevos
                </option>
                <option
                    value="{{ $ordenUrl('precio_menor') }}"
                    {{ $ordenActual === 'precio_menor' ? 'selected' : '' }}>
                    Precio ↑
                </option>
                <option
                    value="{{ $ordenUrl('precio_mayor') }}"
                    {{ $ordenActual === 'precio_mayor' ? 'selected' : '' }}>
                    Precio ↓
                </option>
            </select>

            <svg
                class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2
                       w-3.5 h-3.5 text-gris"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <span class="text-xs text-gris whitespace-nowrap">
            {{ $productos->total() }} prendas
        </span>

    </div>

</div>
