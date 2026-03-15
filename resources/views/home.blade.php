@extends('layouts.app')

@section('title', 'Sofis Tienda de Modas · Ropa, Calzado y Accesorios')

@section('content')

    <section class="w-full">
        <div class="relative overflow-hidden bg-tinta min-h-[80vh] sm:min-h-[85vh] flex items-end">

            <img src="{{ asset('assets/img/hero.jpg') }}" alt="Sofis Tienda de Modas"
                class="absolute inset-0 w-full h-full object-cover opacity-60" loading="eager">

            <div class="absolute inset-0 bg-gradient-to-t from-tinta/80 via-tinta/20 to-transparent"></div>

            <div class="relative z-10 w-full px-6 sm:px-10 lg:px-16 pb-16 sm:pb-20">
                <p class="text-[11px] tracking-[0.3em] uppercase text-white/60 mb-3">Sofis Tienda de Modas</p>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-7xl text-white leading-[1.05] max-w-3xl">
                    Moda para<br>
                    <em class="not-italic text-white/80">tu estilo</em>
                </h1>
                <p class="mt-4 text-white/70 max-w-md text-base sm:text-lg leading-relaxed">
                    Ropa, calzado y accesorios con diseño y calidad accesible.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('catalogo') }}" class="btn-primary">
                        Ver catálogo
                    </a>
                    <a href="{{ route('catalogo', ['ofertas' => 1]) }}" class="btn-outline-white">
                        Ver ofertas
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white border-b border-borde">
        <div class="container-full py-4 grid grid-cols-2 sm:grid-cols-4 divide-x divide-borde text-center">
            @foreach ([['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'text' => 'Envíos rápidos'], ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'text' => 'Cambios fáciles'], ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'text' => 'Calidad garantizada'], ['icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z', 'text' => 'Atención personalizada']] as $p)
                <div class="px-3 py-3 flex flex-col items-center gap-1.5">
                    <svg class="w-5 h-5 text-tinta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $p['icon'] }}" />
                    </svg>
                    <p class="text-[11px] sm:text-xs font-semibold tracking-wide text-tinta">{{ $p['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-16 sm:mt-20 container-full">
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Explorar</p>
                <h2 class="section-title">Nuestras categorías</h2>
            </div>
            <a href="{{ route('catalogo') }}"
                class="hidden sm:inline-flex text-sm font-semibold text-gris hover:text-tinta transition underline underline-offset-4">
                Ver todo
            </a>
        </div>

        @php
            $__categorias = $categorias ?? [
                [
                    'titulo' => 'BLUSAS',
                    'img' =>
                        'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=800&auto=format&fit=crop',
                    'slug' => 'blusas',
                ],
                [
                    'titulo' => 'JEANS',
                    'img' =>
                        'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=800&auto=format&fit=crop',
                    'slug' => 'jeans',
                ],
                [
                    'titulo' => 'VESTIDOS',
                    'img' =>
                        'https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=800&auto=format&fit=crop',
                    'slug' => 'vestidos',
                ],
                [
                    'titulo' => 'ZAPATOS',
                    'img' =>
                        'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=800&auto=format&fit=crop',
                    'slug' => 'zapatos',
                ],
            ];
            $__categoriasConImg = collect($__categorias)
                ->filter(fn($c) => !empty($c['img'] ?? ($c['imagen'] ?? null)))
                ->values();
            $iniciales = $__categoriasConImg->take(4);
            $restantes = $__categoriasConImg->slice(4);
        @endphp

        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($iniciales as $cat)
                <a href="{{ route('catalogo', ['categoria' => $cat['slug'] ?? \Illuminate\Support\Str::slug($cat['nombre'] ?? $cat['titulo'])]) }}"
                    class="group relative overflow-hidden rounded-2xl bg-gray-100 block h-[380px] sm:h-[460px]">

                    <img src="{{ $cat['img'] ?? ($cat['imagen'] ?? '') }}"
                        alt="{{ $cat['titulo'] ?? ($cat['nombre'] ?? '') }}"
                        class="w-full h-full object-cover transition duration-700 ease-out group-hover:scale-[1.05]"
                        loading="lazy">

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-tinta/70 via-tinta/10 to-transparent group-hover:from-tinta/80 transition duration-300">
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <p class="text-white font-display text-2xl sm:text-3xl tracking-wide">
                            {{ $cat['titulo'] ?? ($cat['nombre'] ?? '') }}
                        </p>
                        <p class="mt-1 text-white/70 text-sm flex items-center gap-1.5 group-hover:text-white transition">
                            Explorar
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        @if ($restantes->count() > 0)
            <div id="categoriasExtra" class="hidden mt-3">
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($restantes as $cat)
                        <a href="{{ route('catalogo', ['categoria' => $cat['slug'] ?? \Illuminate\Support\Str::slug($cat['nombre'] ?? $cat['titulo'])]) }}"
                            class="group relative overflow-hidden rounded-2xl bg-gray-100 block h-[380px] sm:h-[460px]">
                            <img src="{{ $cat['img'] ?? ($cat['imagen'] ?? '') }}" alt="{{ $cat['titulo'] ?? '' }}"
                                class="w-full h-full object-cover transition duration-700 group-hover:scale-[1.05]"
                                loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-tinta/70 via-tinta/10 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <p class="text-white font-display text-2xl sm:text-3xl tracking-wide">
                                    {{ $cat['titulo'] ?? ($cat['nombre'] ?? '') }}</p>
                                <p class="mt-1 text-white/70 text-sm">Explorar →</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="mt-6 text-center">
                <button id="btnToggleCats" onclick="toggleCats()" class="btn-ghost text-sm">
                    Mostrar todas las categorías
                </button>
            </div>
            <script>
                function toggleCats() {
                    const el = document.getElementById('categoriasExtra');
                    const btn = document.getElementById('btnToggleCats');
                    const hidden = el.classList.contains('hidden');
                    el.classList.toggle('hidden', !hidden);
                    btn.textContent = hidden ? 'Ocultar categorías' : 'Mostrar todas las categorías';
                }
            </script>
        @endif
    </section>

    <section class="mt-20 sm:mt-24 container-full">
        <div class="relative overflow-hidden rounded-2xl bg-tinta min-h-[240px] sm:min-h-[300px] flex items-center">
            <div class="relative z-10 px-8 sm:px-14 py-12">
                <p class="text-[11px] tracking-[0.2em] uppercase text-white/50 mb-3">Colección actual</p>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl text-white leading-tight max-w-xl">
                    Estilo que habla<br>por ti
                </h2>
                <a href="{{ route('catalogo', ['ofertas' => 1]) }}" class="btn-outline-white mt-6 inline-flex">
                    Ver ofertas especiales
                </a>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/2 hidden sm:block">
                <div class="h-full bg-gradient-to-l from-transparent via-transparent to-tinta absolute inset-0 z-10"></div>
            </div>
        </div>
    </section>

    <section class="mt-20 sm:mt-24 container-full">
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Selección</p>
                <h2 class="section-title">Destacados</h2>
            </div>
            <a href="{{ route('catalogo') }}"
                class="hidden sm:inline-flex text-sm font-semibold text-gris hover:text-tinta transition underline underline-offset-4">
                Ver todo
            </a>
        </div>

        @php
            $__destacados = $destacados ?? ($productos ?? []);
        @endphp

        <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5">
            @forelse($__destacados as $producto)
                @if (is_object($producto))
                    @php $producto = ['nombre' => $producto->nombre, 'precio' => $producto->precio, 'slug' => $producto->slug, 'imagen' => $producto->imagen ?? '', 'categoria' => $producto->categorias->first()->nombre ?? '', 'oferta' => (bool)$producto->oferta, 'precio_oferta' => $producto->precio_oferta]; @endphp
                @endif
                <x-product-card :producto="$producto" />
            @empty
                @for ($i = 1; $i <= 10; $i++)
                    <article class="group">
                        <div class="overflow-hidden rounded-2xl bg-gray-100 border border-borde aspect-[3/4]"></div>
                        <div class="mt-3">
                            <div class="h-2.5 bg-gray-100 rounded w-2/3 mb-2"></div>
                            <div class="h-3 bg-gray-200 rounded w-full mb-1.5"></div>
                            <div class="h-2.5 bg-gray-100 rounded w-1/3"></div>
                        </div>
                    </article>
                @endfor
            @endforelse
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('catalogo') }}" class="btn-primary">Ver todo el catálogo</a>
        </div>
    </section>

    <div class="pb-6"></div>

@endsection
