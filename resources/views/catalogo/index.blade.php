@extends('layouts.app')

@section('title', isset($categoriaSeleccionada) ? $categoriaSeleccionada['nombre'] . ' · Catálogo | Sofis' : 'Catálogo |
    Sofis')

@section('content')

    <div class="container-full pt-8 sm:pt-12 pb-10">

        {{-- Header --}}
        <div class="mb-8">
            @if (!empty($categoriaSeleccionada))
                <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Categoría</p>
                <h1 class="section-title">{{ $categoriaSeleccionada['nombre'] }}</h1>
            @else
                <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Tienda</p>
                <h1 class="section-title">Catálogo</h1>
            @endif
        </div>

        {{-- Filters --}}
        <form id="filtersForm" method="GET" action="{{ route('catalogo') }}" class="mb-8">
            <input type="hidden" name="categoria" value="{{ request('categoria') }}">

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
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <p class="text-gris">No se encontraron productos con esos filtros.</p>
                    <a href="{{ route('catalogo') }}" class="btn-ghost text-sm mt-4 inline-flex">Ver todo el catálogo</a>
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
