@extends('layouts.app')

@section('title', 'Inicio | Tienda')

@section('content')
    {{-- NOTA: quitamos el container-base aquí porque queremos full width --}}

    {{-- HERO FULL WIDTH --}}
    <section class="w-full">
        <div class="card overflow-hidden">
            <div class="grid lg:grid-cols-2">
                <div class="p-6 sm:p-10 flex flex-col justify-center">
                    <p class="text-xs tracking-[0.25em] uppercase text-gris">Sofis Tienda de Modas</p>

                    <h1 class="mt-3 font-display text-4xl sm:text-5xl md:text-6xl leading-[1.05]">
                        Moda y calzado<br class="hidden sm:block">
                        para tu día a día
                    </h1>

                    <p class="mt-4 text-gris max-w-xl text-base sm:text-lg leading-relaxed">
                        Explora nuestro catálogo mixto con ropa, calzado y accesorios.
                        Diseño premium, rápido y optimizado para móvil.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('catalogo') }}" class="btn-primary">Ver catálogo</a>
                        <a href="{{ route('contacto') }}" class="btn-ghost">Contacto</a>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{ asset('assets/img/hero.jpg') }}" alt="Moda"
                        class="w-full h-[320px] sm:h-[420px] lg:h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-transparent"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ✅ CATEGORÍAS CON IMAGEN (mejorado con JS) --}}
    <section class="mt-10 w-full p-100">
        <section class="mt-10 w-full">
            <div class="container-full">

                {{-- ✅ Título del apartado --}}
                <div class="flex items-end justify-between gap-6 flex-wrap">
                    <div>
                        <h2 class="font-display text-2xl sm:text-3xl">Explora nuestras categorías</h2>
                        <p class="mt-2 text-gris">Encuentra lo que buscas más rápido.</p>
                    </div>
                </div>

                @php
                    // ✅ Fallback por si no se pasaron categorías desde el controlador
                    $__categorias = $categorias ?? [
                        [
                            'titulo' => 'BLUSAS',
                            'img' =>
                                'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop',
                            'slug' => 'blusas',
                        ],
                        [
                            'titulo' => 'JEANS',
                            'img' =>
                                'https://images.unsplash.com/photo-1520975682071-ae22e7d0f4aa?q=80&w=1200&auto=format&fit=crop',
                            'slug' => 'jeans',
                        ],
                        [
                            'titulo' => 'VESTIDOS',
                            'img' =>
                                'https://images.unsplash.com/photo-1520975957475-5ceea250c40d?q=80&w=1200&auto=format&fit=crop',
                            'slug' => 'vestidos',
                        ],
                        [
                            'titulo' => 'ZAPATOS',
                            'img' =>
                                'https://images.unsplash.com/photo-1528701800489-20be3c2a3ba7?q=80&w=1200&auto=format&fit=crop',
                            'slug' => 'zapatos',
                        ],
                    ];

                    $__categoriasConImagen = collect($__categorias)
                        ->filter(fn($cat) => !empty($cat['img'] ?? ($cat['imagen'] ?? null)))
                        ->values();

                    $limite = 4;
                    $categoriasIniciales = $__categoriasConImagen->take($limite);
                    $categoriasRestantes = $__categoriasConImagen->slice($limite);
                @endphp

                {{-- ✅ GRID INICIAL (solo 4) --}}
                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($categoriasIniciales as $cat)
                        <a href="{{ route('catalogo', ['categoria' => $cat['slug'] ?? \Illuminate\Support\Str::slug($cat['nombre'] ?? $cat['titulo'])]) }}"
                            class="relative overflow-hidden rounded-xl2 border border-borde bg-gray-100 group h-[340px] sm:h-[420px]">

                            <img src="{{ $cat['img'] ?? ($cat['imagen'] ?? asset('assets/img/placeholder-category.jpg')) }}"
                                alt="{{ $cat['titulo'] ?? ($cat['nombre'] ?? 'Categoria') }}"
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.05]"
                                loading="lazy">

                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition"></div>

                            <div class="absolute bottom-6 left-6 right-6">
                                <p class="text-white font-display text-3xl tracking-wide">
                                    {{ strtoupper($cat['titulo'] ?? ($cat['nombre'] ?? '')) }}
                                </p>
                                <p class="mt-1 text-white/90 text-sm">
                                    Explorar →
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- ✅ GRID RESTANTE (oculto inicialmente) --}}
                @if ($categoriasRestantes->count() > 0)
                    <div id="categoriasExtra"
                        class="hidden opacity-0 translate-y-3 transition-all duration-300 ease-out mt-6">

                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach ($categoriasRestantes as $cat)
                                <a href="{{ route('catalogo', ['categoria' => $cat['slug'] ?? \Illuminate\Support\Str::slug($cat['nombre'] ?? $cat['titulo'])]) }}"
                                    class="relative overflow-hidden rounded-xl2 border border-borde bg-gray-100 group h-[340px] sm:h-[420px]">

                                    <img src="{{ $cat['img'] ?? ($cat['imagen'] ?? asset('assets/img/placeholder-category.jpg')) }}"
                                        alt="{{ $cat['titulo'] ?? ($cat['nombre'] ?? 'Categoria') }}"
                                        class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.05]"
                                        loading="lazy">

                                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition"></div>

                                    <div class="absolute bottom-6 left-6 right-6">
                                        <p class="text-white font-display text-3xl tracking-wide">
                                            {{ strtoupper($cat['titulo'] ?? ($cat['nombre'] ?? '')) }}
                                        </p>
                                        <p class="mt-1 text-white/90 text-sm">
                                            Explorar →
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- ✅ BOTÓN (siempre abajo de todas las categorías) --}}
                    <div class="mt-8 flex justify-center">
                        <button type="button" id="btnToggleCategorias" onclick="toggleCategorias()"
                            class="btn-primary text-center">
                            Mostrar todas las categorías
                        </button>
                    </div>

                    <script>
                        function toggleCategorias() {
                            const extra = document.getElementById('categoriasExtra');
                            const btn = document.getElementById('btnToggleCategorias');

                            const isClosed = extra.classList.contains('hidden');

                            if (isClosed) {
                                // abrir
                                extra.classList.remove('hidden');
                                requestAnimationFrame(() => {
                                    extra.classList.remove('opacity-0', 'translate-y-3');
                                });

                                btn.textContent = 'Ocultar categorías';

                                setTimeout(() => {
                                    btn.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'center'
                                    });
                                }, 250);
                            } else {
                                // cerrar
                                extra.classList.add('opacity-0', 'translate-y-3');

                                setTimeout(() => {
                                    extra.classList.add('hidden');
                                }, 250);

                                btn.textContent = 'Mostrar todas las categorías';
                            }
                        }
                    </script>
                @endif
            </div>
        </section>
    </section>

    {{-- SECCIÓN DESTACADOS FULL WIDTH (productos desde BD) --}}
    <section class="mt-14 w-full">
        <div class="container-full">
            <div class="text-center">
                <h2 class="font-display text-3xl sm:text-4xl">Destacados</h2>
                <p class="mt-2 text-gris">Lo más populares de esta semana</p>
            </div>

            <div class="mt-8 grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5">
                @php
                    // Fallback: si no vienen destacados, intentamos usar $productos o un array vacío
                    $__destacados = $destacados ?? ($productos ?? []);
                @endphp

                @forelse($__destacados as $producto)
                    {{-- Si el componente espera array, aseguramos que sea array --}}
                    @if (is_object($producto))
                        @php
                            $producto = [
                                'nombre' => $producto->nombre ?? '',
                                'precio' => $producto->precio ?? 0,
                                'slug' => $producto->slug ?? '',
                                'imagen' => $producto->imagen ?? '',
                                'categoria' => $producto->categoria->nombre ?? ($producto->categoria ?? ''),
                                'oferta' => $producto->oferta ?? false,
                                'precio_oferta' => $producto->precio_oferta ?? null,
                            ];
                        @endphp
                    @endif

                    <x-product-card :producto="$producto" />
                @empty
                    {{-- Si no hay productos, mostramos placeholders similares al diseño original --}}
                    @foreach (range(1, 10) as $i)
                        <article class="group">
                            <div class="overflow-hidden rounded-xl2 bg-gray-100 border border-borde">
                                <div class="aspect-[3/4] overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop"
                                        alt="Producto {{ $i }}"
                                        class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.05]"
                                        loading="lazy">
                                </div>
                            </div>

                            <div class="mt-3">
                                <p class="text-xs uppercase tracking-widest text-gris">Moda</p>
                                <h3 class="mt-1 font-medium text-sm sm:text-base leading-tight">
                                    Producto {{ $i }}
                                </h3>
                                <p class="mt-1 text-base font-semibold">
                                    $499 <span class="text-sm text-gris font-normal">MXN</span>
                                </p>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>

            <div class="mt-10 flex justify-center">
                <a href="{{ route('catalogo') }}" class="btn-primary">Ver todo el catálogo</a>
            </div>
        </div>
    </section>
@endsection
