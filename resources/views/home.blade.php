@extends('layouts.app')

@section('title', 'Sofis Tienda de Modas · Ropa, Calzado y Accesorios')

@section('content')

    @php
        $__covers = $covers ?? [];
        if (empty($__covers)) {
            $__covers = [[
                'titulo'      => 'Moda para tu estilo',
                'subtitulo'   => 'Ropa, calzado y accesorios con diseño y calidad accesible.',
                'texto_boton' => 'Ver catálogo',
                'url_boton'   => route('catalogo'),
                'imagen'      => null,
            ]];
        }
    @endphp

    <section class="w-full" aria-label="Carrusel de portada">
        <div id="hero-carousel" class="relative overflow-hidden bg-tinta min-h-[80vh] sm:min-h-[85vh]">

            {{-- Slides --}}
            @foreach($__covers as $i => $cover)
                <div class="hero-slide absolute inset-0 flex items-end transition-opacity duration-700 ease-in-out
                            {{ $i === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                    data-index="{{ $i }}">

                    @if(!empty($cover['imagen']))
                        <img src="{{ $cover['imagen'] }}" alt="{{ $cover['titulo'] }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-60"
                            loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                    @else
                        <img src="{{ asset('assets/img/hero.jpg') }}" alt="{{ $cover['titulo'] }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-60" loading="eager">
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-tinta/80 via-tinta/20 to-transparent"></div>

                    <div class="relative z-10 w-full px-6 sm:px-10 lg:px-16 pb-16 sm:pb-20">
                        <p class="text-[11px] tracking-[0.3em] uppercase text-moda/80 mb-3 font-medium">Sofis Tienda de Modas</p>
                        <h1 class="font-display text-4xl sm:text-5xl lg:text-7xl text-white leading-[1.05] max-w-3xl">
                            {!! nl2br(e($cover['titulo'])) !!}
                        </h1>
                        @if(!empty($cover['subtitulo']))
                            <p class="mt-4 text-white/70 max-w-md text-base sm:text-lg leading-relaxed">
                                {{ $cover['subtitulo'] }}
                            </p>
                        @endif
                        @if(!empty($cover['texto_boton']) && !empty($cover['url_boton']))
                            <div class="mt-8 flex flex-wrap gap-3">
                                <a href="{{ $cover['url_boton'] }}" class="btn-primary">
                                    {{ $cover['texto_boton'] }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            {{-- Navegación (solo si hay más de 1 slide) --}}
            @if(count($__covers) > 1)
                {{-- Flechas --}}
                <button onclick="heroCarousel.prev()" aria-label="Anterior"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/20 hover:bg-white/35 backdrop-blur-sm flex items-center justify-center transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="heroCarousel.next()" aria-label="Siguiente"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/20 hover:bg-white/35 backdrop-blur-sm flex items-center justify-center transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Dots --}}
                <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                    @foreach($__covers as $i => $cover)
                        <button onclick="heroCarousel.goTo({{ $i }})"
                            class="hero-dot w-2 h-2 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-white w-5' : 'bg-white/40' }}"
                            aria-label="Ir al slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>

        @if(count($__covers) > 1)
        <script>
            const heroCarousel = (() => {
                const slides = document.querySelectorAll('.hero-slide');
                const dots   = document.querySelectorAll('.hero-dot');
                let current  = 0;
                let timer;

                function show(index) {
                    slides[current].classList.replace('opacity-100', 'opacity-0');
                    slides[current].classList.replace('z-10', 'z-0');
                    dots[current].classList.remove('bg-white', 'w-5');
                    dots[current].classList.add('bg-white/40');

                    current = (index + slides.length) % slides.length;

                    slides[current].classList.replace('opacity-0', 'opacity-100');
                    slides[current].classList.replace('z-0', 'z-10');
                    dots[current].classList.remove('bg-white/40');
                    dots[current].classList.add('bg-white', 'w-5');
                }

                function next()         { show(current + 1); resetTimer(); }
                function prev()         { show(current - 1); resetTimer(); }
                function goTo(i)        { show(i);           resetTimer(); }
                function resetTimer()   { clearInterval(timer); timer = setInterval(next, 5000); }

                resetTimer();
                return { next, prev, goTo };
            })();
        </script>
        @endif
    </section>

    <section class="bg-white border-b border-borde">
        <div class="container-full py-3 sm:py-0 grid grid-cols-2 sm:grid-cols-4 sm:divide-x divide-borde text-center">
            @foreach ([
                ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'text' => 'Envíos rápidos'],
                ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'text' => 'Cambios fáciles'],
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'text' => 'Calidad garantizada'],
                ['icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z', 'text' => 'Atención personalizada']
            ] as $idx => $p)
                <div class="px-3 py-3 sm:py-4 flex flex-col items-center gap-1.5
                    {{ $idx === 1 || $idx === 3 ? 'border-l border-borde sm:border-0' : '' }}
                    {{ $idx >= 2 ? 'border-t border-borde sm:border-0' : '' }}">
                    <svg class="w-4 h-4 text-moda" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="relative overflow-hidden rounded-2xl bg-tinta min-h-[260px] sm:min-h-[320px] flex items-center">
            {{-- Decorative pattern background --}}
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;"></div>

            {{-- Subtle accent line --}}
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-moda rounded-l-2xl"></div>

            <div class="relative z-10 px-10 sm:px-16 py-14 w-full sm:w-auto">
                <p class="text-[10px] tracking-[0.35em] uppercase text-moda/90 mb-3 font-medium">Colección actual</p>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl text-white leading-tight max-w-xl">
                    Estilo que habla<br>por ti
                </h2>
                <p class="mt-3 text-white/50 text-sm max-w-xs hidden sm:block">Descubre las piezas que definen cada temporada.</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('catalogo', ['ofertas' => 1]) }}" class="btn-outline-white">
                        Ver ofertas especiales
                    </a>
                    <a href="{{ route('catalogo') }}" class="btn text-white/60 hover:text-white transition text-sm px-4 py-3">
                        Todo el catálogo →
                    </a>
                </div>
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
