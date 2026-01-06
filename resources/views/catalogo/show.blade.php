@extends('layouts.app')

@section('title', $producto['nombre'] . ' | Tienda')

@section('content')

{{-- BREADCRUMBS --}}
<div class="text-sm text-gris mb-4">
    <a href="{{ route('home') }}" class="hover:text-tinta transition">Inicio</a>
    <span class="mx-2">/</span>
    <a href="{{ route('catalogo') }}" class="hover:text-tinta transition">Catálogo</a>
    <span class="mx-2">/</span>
    <span class="text-tinta">{{ $producto['nombre'] }}</span>
</div>

<section class="grid gap-8 lg:grid-cols-2 lg:items-start">

    {{-- COLUMNA IZQUIERDA: IMÁGENES --}}
    <div class="space-y-3">
        <div class="card overflow-hidden">
            <div class="aspect-[3/4] bg-gray-100 overflow-hidden">
                <img
                    src="{{ $producto['imagen'] }}"
                    alt="{{ $producto['nombre'] }}"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            </div>
        </div>

        {{-- Miniaturas (placeholder) --}}
        <div class="grid grid-cols-4 gap-3">
            @foreach(range(1,4) as $i)
                <button class="card overflow-hidden border border-borde hover:border-tinta transition">
                    <div class="aspect-square bg-gray-100"></div>
                </button>
            @endforeach
        </div>
    </div>

    {{-- COLUMNA DERECHA: INFO + DETALLES ABAJO DE DESCRIPCIÓN (SOLO DESKTOP) --}}
    <div class="card p-6 sm:p-8">

        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="badge">{{ $producto['categoria'] }}</p>
                <h1 class="mt-3 font-display text-3xl sm:text-4xl leading-tight">
                    {{ $producto['nombre'] }}
                </h1>
            </div>

            {{-- Wishlist placeholder --}}
            <button class="p-3 rounded-xl border border-borde hover:bg-white transition" aria-label="Favorito">
                ♡
            </button>
        </div>

        <p class="mt-4 text-2xl font-semibold tracking-wide">
            ${{ number_format($producto['precio'], 0) }}
            <span class="text-base text-gris font-normal">MXN</span>
        </p>

        <p class="mt-4 text-gris leading-relaxed">
            {{ $producto['descripcion'] }}
        </p>

        {{-- Selección de talla (placeholder) --}}
        <div class="mt-6">
            <p class="text-xs tracking-widest uppercase text-gris">Talla</p>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach(['CH','M','G','EG','2XL'] as $talla)
                    <button class="px-4 py-2 rounded-xl border border-borde hover:border-tinta hover:bg-white transition text-sm font-semibold">
                        {{ $talla }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Acciones --}}
        <div class="mt-8 grid gap-3 sm:grid-cols-2">
            <a href="{{ route('catalogo') }}" class="btn-ghost w-full text-center">
                ← Volver
            </a>

            {{-- WhatsApp (placeholder) --}}
            <a href="#" class="btn-primary w-full text-center">
                Preguntar por WhatsApp
            </a>
        </div>

        {{-- Info rápida --}}
        <div class="mt-8 grid gap-4 sm:grid-cols-2 text-sm text-gris">
            <div class="flex gap-3">
                <span class="text-pink-600 font-bold">✓</span>
                <p><span class="text-tinta font-semibold">Envíos</span><br>Rápidos y seguros</p>
            </div>
            <div class="flex gap-3">
                <span class="text-pink-600 font-bold">✓</span>
                <p><span class="text-tinta font-semibold">Cambios</span><br>Fáciles y rápidos</p>
            </div>
        </div>

        {{-- ✅ DETALLES + ENVÍOS ABAJO DE LA DESCRIPCIÓN (SOLO DESKTOP) --}}
        <div class="hidden lg:block mt-10 border-t border-borde pt-8 space-y-6">

            {{-- Detalles --}}
            <div>
                <h2 class="font-display text-2xl">Detalles</h2>
                <ul class="mt-4 space-y-3 text-sm text-gris leading-relaxed">
                    <li>• Materiales de buena calidad (editable).</li>
                    <li>• Corte cómodo y moderno.</li>
                    <li>• Recomendación: revisar guía de tallas.</li>
                    <li>• Ideal para uso diario.</li>
                </ul>
            </div>

            {{-- Envíos --}}
            <div class="pt-6 border-t border-borde">
                <h2 class="font-display text-2xl">Envíos & devoluciones</h2>
                <p class="mt-4 text-sm text-gris leading-relaxed">
                    Envíos a todo México (editable). Cambios disponibles dentro de un periodo determinado.
                    Para dudas, contáctanos por WhatsApp.
                </p>

                <div class="mt-6">
                    <a href="{{ route('contacto') }}" class="btn-ghost">
                        Ver información de contacto
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ✅ DETALLES + ENVÍOS (SOLO MÓVIL/TABLET) --}}
<section class="mt-10 grid gap-6 lg:hidden">
    <div class="card p-6 sm:p-8">
        <h2 class="font-display text-2xl">Detalles</h2>
        <ul class="mt-4 space-y-3 text-sm text-gris leading-relaxed">
            <li>• Materiales de buena calidad (editable).</li>
            <li>• Corte cómodo y moderno.</li>
            <li>• Recomendación: revisar guía de tallas.</li>
            <li>• Ideal para uso diario.</li>
        </ul>
    </div>

    <div class="card p-6 sm:p-8">
        <h2 class="font-display text-2xl">Envíos & devoluciones</h2>
        <p class="mt-4 text-sm text-gris leading-relaxed">
            Envíos a todo México (editable). Cambios disponibles dentro de un periodo determinado.
            Para dudas, contáctanos por WhatsApp.
        </p>

        <div class="mt-6">
            <a href="{{ route('contacto') }}" class="btn-ghost">
                Ver información de contacto
            </a>
        </div>
    </div>
</section>

{{-- RECOMENDADOS (mock por ahora) --}}
<section class="mt-12">
    <div class="flex items-end justify-between gap-6 flex-wrap">
        <div>
            <h2 class="font-display text-2xl sm:text-3xl">También te puede gustar</h2>
            <p class="mt-2 text-gris">Sugerencias basadas en tu selección.</p>
        </div>
        <a href="{{ route('catalogo') }}" class="text-sm font-semibold text-tinta underline underline-offset-4 hover:opacity-70 transition">
            Ver más
        </a>
    </div>

    <div class="mt-6 grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
        @foreach(range(1,4) as $i)
            <article class="group">
                <div class="overflow-hidden rounded-xl2 border border-borde bg-white">
                    <div class="aspect-[3/4] bg-gray-100 overflow-hidden">
                        <img
                            src="https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop"
                            alt="Recomendado {{ $i }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.05]"
                            loading="lazy"
                        >
                    </div>
                </div>

                <div class="mt-3">
                    <p class="text-[11px] uppercase tracking-widest text-gris">Moda</p>
                    <h3 class="mt-1 font-medium text-sm sm:text-base leading-tight">
                        Producto recomendado {{ $i }}
                    </h3>
                    <p class="mt-1 text-base font-semibold">
                        $499 <span class="text-sm text-gris font-normal">MXN</span>
                    </p>
                </div>
            </article>
        @endforeach
    </div>
</section>

@endsection
