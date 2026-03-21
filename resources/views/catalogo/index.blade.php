@extends('layouts.app')

@section('title', isset($categoriaSeleccionada) ? $categoriaSeleccionada['nombre'] . ' · Catálogo | Sofis' : 'Catálogo |
    Sofis')

@section('content')

    <div class="container-full pt-8 sm:pt-12 pb-10">

        {{-- Header --}}
        @if (request('search'))
            <div class="mb-8">
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
        @elseif (!empty($categoriaSeleccionada))
            <div class="mb-8">
                <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Categoría</p>
                <h1 class="section-title">{{ $categoriaSeleccionada['nombre'] }}</h1>
            </div>
        @else
            <div class="mb-8">
                <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Tienda</p>
                <h1 class="section-title">Catálogo</h1>
            </div>
        @endif

        {{-- Filters --}}
        <form id="filtersForm" method="GET" action="{{ route('catalogo') }}" class="mb-8">
            <input type="hidden" name="categoria" value="{{ request('categoria') }}">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-2.5">
                <select name="orden" onchange="document.getElementById('filtersForm').submit()"
                    class="input text-sm w-full sm:w-auto sm:min-w-[160px]">
                    <option value="">Ordenar</option>
                    <option value="nuevos" {{ request('orden') === 'nuevos' ? 'selected' : '' }}>Más nuevos</option>
                    <option value="precio_menor" {{ request('orden') === 'precio_menor' ? 'selected' : '' }}>Precio: menor → mayor</option>
                    <option value="precio_mayor" {{ request('orden') === 'precio_mayor' ? 'selected' : '' }}>Precio: mayor → menor</option>
                </select>

                <select name="talla" onchange="document.getElementById('filtersForm').submit()" class="input text-sm w-full sm:w-auto">
                    <option value="">Talla</option>
                    @if (!empty($availableTallas))
                        @foreach ($availableTallas as $t)
                            <option value="{{ $t }}" {{ request('talla') === $t ? 'selected' : '' }}>{{ strtoupper($t) }}</option>
                        @endforeach
                    @else
                        @foreach (['CH', 'S', 'M', 'G', 'XL', '2XL'] as $t)
                            <option value="{{ $t }}" {{ request('talla') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    @endif
                </select>

                @if (request()->hasAny(['orden', 'talla', 'search']))
                    <a href="{{ route('catalogo', array_filter(['categoria' => request('categoria')])) }}"
                        class="btn-ghost text-sm py-2.5 w-full sm:w-auto text-center">
                        Limpiar filtros
                    </a>
                @endif

                {{-- Product count --}}
                <p class="text-sm text-gris sm:ml-auto">
                    {{ $productos->total() }} {{ $productos->total() === 1 ? 'producto' : 'productos' }}
                </p>
            </div>
        </form>

        {{-- Grid --}}
        <div class="grid gap-x-4 gap-y-8 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @forelse($productos as $producto)
                <x-product-card :producto="$producto" />
            @empty
                <div class="col-span-full py-20 text-center">
                    @if (request('search'))
                        <div class="max-w-sm mx-auto">
                            <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="text-tinta font-medium mb-1">Sin resultados para "{{ request('search') }}"</p>
                            <p class="text-sm text-gris mb-7">Intenta con otro término o explora nuestras categorías</p>
                            <div class="flex flex-wrap gap-2 justify-center">
                                @foreach([['slug'=>'lo-nuevo','label'=>'Lo nuevo'],['slug'=>'ropa','label'=>'Ropa'],['slug'=>'calzado','label'=>'Calzado'],['slug'=>'accesorios','label'=>'Accesorios']] as $cat)
                                    <a href="{{ route('catalogo', ['categoria' => $cat['slug']]) }}"
                                        class="px-4 py-2 rounded-full text-sm border border-borde hover:border-tinta hover:bg-white transition text-tinta">
                                        {{ $cat['label'] }}
                                    </a>
                                @endforeach
                                <a href="{{ route('catalogo', ['ofertas' => 1]) }}"
                                    class="px-4 py-2 rounded-full text-sm border border-amber-200 text-amber-600 hover:bg-amber-50 transition">
                                    Ofertas
                                </a>
                            </div>
                        </div>
                    @else
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-gris">No se encontraron productos con esos filtros.</p>
                        <a href="{{ route('catalogo') }}" class="btn-ghost text-sm mt-4 inline-flex">Ver todo el catálogo</a>
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

@endsection
