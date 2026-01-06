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
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 items-center">

                    {{-- Buscador (opcional) --}}
                    <input type="text" class="input" placeholder="Buscar producto...">

                    {{-- Ordenar --}}
                    <select class="input">
                        <option>Ordenar por</option>
                        <option>Más nuevos</option>
                        <option>Precio: menor a mayor</option>
                        <option>Precio: mayor a menor</option>
                    </select>

                    {{-- Talla / filtro ejemplo --}}
                    <select class="input">
                        <option>Talla</option>
                        <option>CH</option>
                        <option>M</option>
                        <option>G</option>
                        <option>EG</option>
                        <option>2XL</option>
                    </select>

                    {{-- Botón limpiar (placeholder) --}}
                    <button class="btn-ghost w-full">
                        Limpiar filtros
                    </button>
                </div>
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
