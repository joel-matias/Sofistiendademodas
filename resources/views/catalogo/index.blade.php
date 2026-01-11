@extends('layouts.app')

@section('title', 'Catálogo | Tienda')
@section('main_class', 'w-full')

@section('content')

    <section class="w-full">
        <div class="container-full">

            {{-- ENCABEZADO --}}
            <div class="text-center pt-6 sm:pt-10">
                <h1 class="font-display text-3xl sm:text-4xl md:text-5xl">
                    Catálogo
                </h1>
                <p class="mt-2 text-gris max-w-2xl mx-auto">
                    Explora ropa, calzado y accesorios. Optimizado para móvil.
                </p>
            </div>

            @if (!empty($categoriaSeleccionada))
                <div class="text-center mt-2">
                    <p class="text-gris">Mostrando categoría: <span
                            class="font-medium">{{ $categoriaSeleccionada['nombre'] }}</span></p>
                </div>
            @endif

            {{-- FILTROS --}}
            <div class="mt-8 card p-4 sm:p-5">
                <form id="filtersForm" method="GET" action="{{ route('catalogo') }}">
                    {{-- preservamos la categoria --}}
                    <input type="hidden" name="categoria" value="{{ request('categoria') }}">

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 items-center">

                        {{-- Ordenar --}}
                        <select name="orden" class="input" onchange="document.getElementById('filtersForm').submit()">
                            <option value="">Ordenar por</option>
                            <option value="nuevos" {{ request('orden') === 'nuevos' ? 'selected' : '' }}>Más nuevos</option>
                            <option value="precio_menor" {{ request('orden') === 'precio_menor' ? 'selected' : '' }}>Precio:
                                menor a mayor</option>
                            <option value="precio_mayor" {{ request('orden') === 'precio_mayor' ? 'selected' : '' }}>Precio:
                                mayor a menor</option>
                        </select>

                        {{-- Talla --}}
                        <select name="talla" class="input" onchange="document.getElementById('filtersForm').submit()">
                            <option value="">{{ __('Talla') }}</option>

                            @if (!empty($availableTallas) && count($availableTallas))
                                @foreach ($availableTallas as $t)
                                    <option value="{{ $t }}" {{ request('talla') === $t ? 'selected' : '' }}>
                                        {{ strtoupper($t) }}
                                    </option>
                                @endforeach
                            @else
                                {{-- fallback estático --}}
                                <option value="CH" {{ request('talla') === 'CH' ? 'selected' : '' }}>CH</option>
                                <option value="M" {{ request('talla') === 'M' ? 'selected' : '' }}>M</option>
                                <option value="G" {{ request('talla') === 'G' ? 'selected' : '' }}>G</option>
                                <option value="EG" {{ request('talla') === 'EG' ? 'selected' : '' }}>EG</option>
                                <option value="2XL"{{ request('talla') === '2XL' ? 'selected' : '' }}>2XL</option>
                            @endif
                        </select>

                        {{-- Botón limpiar --}}
                        <a href="{{ route('catalogo', ['categoria' => request('categoria')]) }}" class="btn-ghost w-full">
                            Limpiar filtros
                        </a>
                    </div>
                </form>
            </div>

            {{-- GRID DE PRODUCTOS FULL WIDTH --}}
            <div class="mt-10 grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
                @foreach ($productos as $producto)
                    <x-product-card :producto="$producto" />
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $productos->links() }}
            </div>

        </div>
    </section>

@endsection
