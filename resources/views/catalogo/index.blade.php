@extends('layouts.app')

@section('title', isset($categoriaSeleccionada)
    ? $categoriaSeleccionada['nombre'] . ' · Catálogo | Sofis'
    : (request()->boolean('nuevo') ? 'Lo Nuevo · Catálogo | Sofis' : 'Catálogo | Sofis'))

@section('content')

@php
    $params = array_filter(
        request()->only(['categoria', 'search', 'orden', 'nuevo', 'ofertas', 'talla', 'color']),
        fn($v) => $v !== '' && $v !== null
    );

    $url = function (string $key, string $value) use ($params): string {
        $p = $params;
        if (isset($p[$key]) && (string) $p[$key] === $value) {
            unset($p[$key]);
        } else {
            $p[$key] = $value;
        }
        return route('catalogo') . ($p ? '?' . http_build_query($p) : '');
    };

    $isActive = fn(string $key, string $value = ''): bool =>
        $value === '' ? ! empty($params[$key]) : (string) ($params[$key] ?? '') === $value;

    $filterCount = collect(['nuevo', 'ofertas', 'talla', 'color', 'categoria'])
        ->filter(fn($k) => ! empty($params[$k]))
        ->count();

    $clearAllUrl = route('catalogo', array_filter(['search' => request('search')]));

    $ordenUrl = function (string $val) use ($params): string {
        $p = $params;
        if ($val === '') {
            unset($p['orden']);
        } else {
            $p['orden'] = $val;
        }
        return route('catalogo') . ($p ? '?' . http_build_query($p) : '');
    };

    $ordenActual = request('orden', '');
@endphp

<div class="container-full pt-8 sm:pt-10 pb-14">

    {{-- ── HEADER ─────────────────────────────────────────────────────────── --}}
    @if (request('search'))
        <div class="mb-6">
            <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-2">Resultados de búsqueda</p>
            <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                <h1 class="section-title">"{{ request('search') }}"</h1>
                <span class="text-gris text-base font-light">
                    {{ $productos->total() }} {{ $productos->total() === 1 ? 'resultado' : 'resultados' }}
                </span>
            </div>
            <a href="{{ route('catalogo', array_filter(['categoria' => request('categoria')])) }}"
                class="mt-2 inline-flex items-center gap-1.5 text-xs text-gris hover:text-tinta transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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

    {{-- ── BARRA MOBILE: botón filtros + ordenar ───────────────────────────── --}}
    <div class="flex items-center gap-2 mb-4 lg:hidden">
        <button id="btnFiltrosMobile" onclick="toggleFiltrosMobile()" aria-expanded="false"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-borde bg-white text-sm font-medium hover:border-tinta transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
            </svg>
            Filtros
            @if ($filterCount > 0)
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-tinta text-crema text-[10px] font-bold">
                    {{ $filterCount }}
                </span>
            @endif
        </button>

        <div class="ml-auto flex items-center gap-3">
            <div class="relative">
                <select onchange="window.location.href=this.value"
                    class="appearance-none pl-3 pr-8 py-2.5 rounded-xl border border-borde bg-white text-sm outline-none focus:ring-2 focus:ring-tinta/20 transition cursor-pointer">
                    <option value="{{ $ordenUrl('') }}"           {{ $ordenActual === '' ? 'selected' : '' }}>Más nuevos</option>
                    <option value="{{ $ordenUrl('precio_menor') }}" {{ $ordenActual === 'precio_menor' ? 'selected' : '' }}>Precio ↑</option>
                    <option value="{{ $ordenUrl('precio_mayor') }}" {{ $ordenActual === 'precio_mayor' ? 'selected' : '' }}>Precio ↓</option>
                </select>
                <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gris" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <span class="text-xs text-gris whitespace-nowrap">{{ $productos->total() }} prendas</span>
        </div>
    </div>

    {{-- ── PANEL DE FILTROS MOBILE (colapsable) ────────────────────────────── --}}
    <div id="panelFiltrosMobile"
        class="lg:hidden hidden mb-5 bg-white rounded-2xl border border-borde shadow-suave overflow-hidden">

        {{-- Colección --}}
        <div class="border-b border-borde">
            <button onclick="toggleSection('m-coleccion')"
                class="w-full flex items-center justify-between px-4 py-3 text-left">
                <span class="text-[10px] tracking-[0.2em] uppercase text-gris font-semibold">Colección</span>
                <svg id="fc-m-coleccion" class="w-3.5 h-3.5 text-gris transition-transform duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="fs-m-coleccion" class="px-4 pb-4 flex flex-wrap gap-2">
                <a href="{{ $url('nuevo', '1') }}"
                    @class([
                        'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border transition',
                        'bg-tinta text-crema border-tinta' => $isActive('nuevo'),
                        'border-borde text-gris hover:border-tinta hover:text-tinta' => ! $isActive('nuevo'),
                    ])>
                    ✦ Lo nuevo
                </a>
                <a href="{{ $url('ofertas', '1') }}"
                    @class([
                        'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border transition',
                        'bg-oferta text-white border-oferta' => $isActive('ofertas'),
                        'border-oferta/30 text-oferta hover:border-oferta' => ! $isActive('ofertas'),
                    ])>
                    Ofertas
                </a>
            </div>
        </div>

        {{-- Tallas (mobile) --}}
        @if ($todasLasTallas->isNotEmpty())
            <div class="border-b border-borde">
                <button onclick="toggleSection('m-talla')"
                    class="w-full flex items-center justify-between px-4 py-3 text-left">
                    <span class="text-[10px] tracking-[0.2em] uppercase text-gris font-semibold">
                        Talla
                        @if ($isActive('talla'))
                            <span class="ml-1 text-tinta normal-case tracking-normal font-bold">
                                · {{ strtoupper($todasLasTallas->firstWhere('slug', $params['talla'] ?? '')?->nombre ?? '') }}
                            </span>
                        @endif
                    </span>
                    <svg id="fc-m-talla" class="w-3.5 h-3.5 text-gris transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="fs-m-talla" class="px-4 pb-4 flex flex-wrap gap-1.5">
                    @foreach ($todasLasTallas as $talla)
                        <a href="{{ $url('talla', $talla->slug) }}"
                            @class([
                                'inline-flex items-center justify-center min-w-[2.5rem] h-9 px-2 rounded-lg text-xs font-semibold border transition',
                                'bg-tinta text-crema border-tinta' => $isActive('talla', $talla->slug),
                                'border-borde text-tinta hover:border-tinta' => ! $isActive('talla', $talla->slug),
                            ])>
                            {{ strtoupper($talla->nombre) }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Colores (mobile) --}}
        @if ($todosLosColores->isNotEmpty())
            <div class="{{ $filterCount > 0 ? 'border-b border-borde' : '' }}">
                <button onclick="toggleSection('m-color')"
                    class="w-full flex items-center justify-between px-4 py-3 text-left">
                    <span class="text-[10px] tracking-[0.2em] uppercase text-gris font-semibold">Color</span>
                    <svg id="fc-m-color" class="w-3.5 h-3.5 text-gris transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="fs-m-color" class="px-4 pb-4 flex flex-wrap gap-2">
                    @foreach ($todosLosColores as $color)
                        <a href="{{ $url('color', $color->slug) }}" title="{{ $color->nombre }}"
                            @class([
                                'w-8 h-8 rounded-full border-2 transition hover:scale-110 flex items-center justify-center',
                                'border-tinta ring-2 ring-tinta ring-offset-1' => $isActive('color', $color->slug),
                                'border-white shadow-sm hover:border-gray-300' => ! $isActive('color', $color->slug),
                            ])
                            style="background-color: {{ $color->hex ?? '#ccc' }}">
                            @if ($isActive('color', $color->slug))
                                <svg class="w-3 h-3 {{ $color->hex && hexdec(substr(ltrim($color->hex,'#'), 0, 6)) > 0x888888 ? 'text-tinta' : 'text-white' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Limpiar mobile --}}
        @if ($filterCount > 0)
            <div class="px-4 py-3">
                <a href="{{ $clearAllUrl }}" class="text-xs text-gris hover:text-tinta transition underline underline-offset-2">
                    Limpiar todos los filtros ({{ $filterCount }})
                </a>
            </div>
        @endif
    </div>

    {{-- ── LAYOUT: sidebar + grid ─────────────────────────────────────────── --}}
    <div class="lg:flex lg:gap-8 lg:items-start">

        {{-- ── SIDEBAR (desktop) ──────────────────────────────────────────── --}}
        <aside class="hidden lg:block w-56 xl:w-60 flex-shrink-0 sticky top-24">

            {{-- Sección: Colección --}}
            <div class="border-b border-borde pb-4 mb-4">
                <button onclick="toggleSection('coleccion')"
                    class="w-full flex items-center justify-between mb-3 group">
                    <span class="text-[10px] tracking-[0.2em] uppercase text-gris group-hover:text-tinta transition">Colección</span>
                    <svg id="fc-coleccion" class="w-3 h-3 text-gris transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="fs-coleccion" class="space-y-1">
                    <a href="{{ $url('nuevo', '1') }}"
                        @class([
                            'flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition font-medium',
                            'bg-tinta text-crema' => $isActive('nuevo'),
                            'text-gris hover:bg-gray-100 hover:text-tinta' => ! $isActive('nuevo'),
                        ])>
                        <span class="text-moda text-xs">✦</span>
                        Lo nuevo
                        <span class="text-[10px] {{ $isActive('nuevo') ? 'text-crema/60' : 'text-gris/50' }} ml-auto font-normal">30 días</span>
                    </a>
                    <a href="{{ $url('ofertas', '1') }}"
                        @class([
                            'flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition font-medium',
                            'bg-oferta text-white' => $isActive('ofertas'),
                            'text-oferta hover:bg-oferta/10' => ! $isActive('ofertas'),
                        ])>
                        Ofertas
                    </a>
                </div>
            </div>

            {{-- Sección: Ordenar --}}
            <div class="border-b border-borde pb-4 mb-4">
                <button onclick="toggleSection('ordenar')"
                    class="w-full flex items-center justify-between mb-3 group">
                    <span class="text-[10px] tracking-[0.2em] uppercase text-gris group-hover:text-tinta transition">
                        Ordenar
                        @if ($ordenActual !== '')
                            <span class="ml-1 w-1.5 h-1.5 rounded-full bg-tinta inline-block align-middle"></span>
                        @endif
                    </span>
                    <svg id="fc-ordenar" class="w-3 h-3 text-gris transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="fs-ordenar" class="space-y-0.5">
                    @foreach (['' => 'Más nuevos', 'precio_menor' => 'Precio: menor → mayor', 'precio_mayor' => 'Precio: mayor → menor'] as $val => $label)
                        <a href="{{ $ordenUrl($val) }}"
                            @class([
                                'flex items-center px-3 py-2 rounded-lg text-sm transition',
                                'bg-gray-100 font-semibold text-tinta' => $ordenActual === $val,
                                'text-gris hover:bg-gray-100 hover:text-tinta' => $ordenActual !== $val,
                            ])>
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Sección: Talla --}}
            @if ($todasLasTallas->isNotEmpty())
                <div class="border-b border-borde pb-4 mb-4">
                    <button onclick="toggleSection('talla')"
                        class="w-full flex items-center justify-between mb-3 group">
                        <span class="text-[10px] tracking-[0.2em] uppercase text-gris group-hover:text-tinta transition">
                            Talla
                            @if ($isActive('talla'))
                                <span class="ml-1 w-1.5 h-1.5 rounded-full bg-tinta inline-block align-middle"></span>
                            @endif
                        </span>
                        <svg id="fc-talla" class="w-3 h-3 text-gris transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="fs-talla" class="flex flex-wrap gap-1.5">
                        @foreach ($todasLasTallas as $talla)
                            <a href="{{ $url('talla', $talla->slug) }}"
                                @class([
                                    'inline-flex items-center justify-center min-w-[2.5rem] h-9 px-2 rounded-lg text-xs font-semibold border transition',
                                    'bg-tinta text-crema border-tinta' => $isActive('talla', $talla->slug),
                                    'border-borde text-tinta hover:border-tinta hover:bg-gray-50' => ! $isActive('talla', $talla->slug),
                                ])>
                                {{ strtoupper($talla->nombre) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Sección: Color --}}
            @if ($todosLosColores->isNotEmpty())
                <div class="{{ $filterCount > 0 ? 'border-b border-borde pb-4 mb-4' : 'pb-2' }}">
                    <button onclick="toggleSection('color')"
                        class="w-full flex items-center justify-between mb-3 group">
                        <span class="text-[10px] tracking-[0.2em] uppercase text-gris group-hover:text-tinta transition">
                            Color
                            @if ($isActive('color'))
                                <span class="ml-1 w-1.5 h-1.5 rounded-full bg-tinta inline-block align-middle"></span>
                            @endif
                        </span>
                        <svg id="fc-color" class="w-3 h-3 text-gris transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="fs-color" class="flex flex-wrap gap-2">
                        @foreach ($todosLosColores as $color)
                            <a href="{{ $url('color', $color->slug) }}" title="{{ $color->nombre }}"
                                @class([
                                    'w-8 h-8 rounded-full border-2 transition hover:scale-110 flex items-center justify-center',
                                    'border-tinta ring-2 ring-tinta ring-offset-1' => $isActive('color', $color->slug),
                                    'border-white shadow-sm hover:border-gray-300' => ! $isActive('color', $color->slug),
                                ])
                                style="background-color: {{ $color->hex ?? '#ccc' }}">
                                @if ($isActive('color', $color->slug))
                                    <svg class="w-3 h-3 {{ $color->hex && hexdec(substr(ltrim($color->hex,'#'), 0, 6)) > 0x888888 ? 'text-tinta' : 'text-white' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Limpiar filtros --}}
            @if ($filterCount > 0)
                <a href="{{ $clearAllUrl }}"
                    class="flex items-center gap-1.5 text-xs text-gris hover:text-tinta transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Limpiar filtros ({{ $filterCount }})
                </a>
            @endif

        </aside>

        {{-- ── COLUMNA PRINCIPAL ───────────────────────────────────────────── --}}
        <div class="flex-1 min-w-0">

            {{-- Barra info: conteo + chips de filtros activos (desktop) --}}
            <div class="hidden lg:flex items-center gap-3 flex-wrap mb-5 pb-4 border-b border-borde min-h-[2.5rem]">
                <p class="text-sm text-gris">
                    {{ $productos->total() }} {{ $productos->total() === 1 ? 'producto' : 'productos' }}
                </p>

                @if ($isActive('nuevo'))
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tinta/5 border border-borde text-xs text-tinta">
                        ✦ Lo nuevo
                        <a href="{{ $url('nuevo', '1') }}" class="hover:text-oferta ml-0.5 transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    </span>
                @endif
                @if ($isActive('ofertas'))
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-oferta/5 border border-oferta/20 text-xs text-oferta">
                        Ofertas
                        <a href="{{ $url('ofertas', '1') }}" class="hover:text-tinta ml-0.5 transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    </span>
                @endif
                @if ($isActive('talla'))
                    @php $tallaActiva = $todasLasTallas->firstWhere('slug', $params['talla'] ?? ''); @endphp
                    @if ($tallaActiva)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tinta/5 border border-borde text-xs text-tinta">
                            Talla: {{ strtoupper($tallaActiva->nombre) }}
                            <a href="{{ $url('talla', $tallaActiva->slug) }}" class="hover:text-oferta ml-0.5 transition">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        </span>
                    @endif
                @endif
                @if ($isActive('color'))
                    @php $colorActivo = $todosLosColores->firstWhere('slug', $params['color'] ?? ''); @endphp
                    @if ($colorActivo)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-tinta/5 border border-borde text-xs text-tinta">
                            <span class="w-3 h-3 rounded-full flex-shrink-0 border border-borde/50"
                                style="background-color: {{ $colorActivo->hex ?? '#ccc' }}"></span>
                            {{ $colorActivo->nombre }}
                            <a href="{{ $url('color', $colorActivo->slug) }}" class="hover:text-oferta ml-0.5 transition">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        </span>
                    @endif
                @endif
            </div>

            {{-- Grid de productos --}}
            <div class="grid gap-x-4 gap-y-8 grid-cols-2 sm:grid-cols-3 xl:grid-cols-4">
                @forelse ($productos as $producto)
                    <x-product-card :producto="$producto" />
                @empty
                    <div class="col-span-full py-20 text-center">
                        @if (request('search'))
                            <div class="max-w-sm mx-auto">
                                <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <p class="text-tinta font-medium mb-1">Sin resultados para "{{ request('search') }}"</p>
                                <p class="text-sm text-gris mb-6">Intenta con otro término o explora el catálogo</p>
                                <a href="{{ route('catalogo') }}" class="btn-ghost text-sm">Ver todo el catálogo</a>
                            </div>
                        @else
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-gris mb-1">No hay productos con esos filtros.</p>
                            <a href="{{ $clearAllUrl }}" class="btn-ghost text-sm mt-4 inline-flex">Limpiar filtros</a>
                        @endif
                    </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if ($productos->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $productos->links() }}
                </div>
            @endif

        </div>
    </div>

</div>

@push('scripts')
<script>
function toggleFiltrosMobile() {
    const panel = document.getElementById('panelFiltrosMobile');
    const btn   = document.getElementById('btnFiltrosMobile');
    const open  = panel.classList.toggle('hidden') === false;
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
}

// Colapsa/expande una sección de filtro (sidebar y panel mobile)
function toggleSection(id) {
    const content = document.getElementById('fs-' + id);
    const chevron = document.getElementById('fc-' + id);
    if (!content) return;
    const collapsed = content.classList.toggle('hidden');
    if (chevron) chevron.style.transform = collapsed ? 'rotate(-90deg)' : '';
}
</script>
@endpush

@endsection
