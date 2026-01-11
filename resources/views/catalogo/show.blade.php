@extends('layouts.app')

@section('title', $producto['nombre'] . ' | Tienda')

@section('content')

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
                    <img id="imagenPrincipal" src="{{ $producto['imagenes'][0] ?? $producto['imagen'] }}"
                        alt="{{ $producto['nombre'] }}" class="w-full h-full object-cover" loading="lazy">
                </div>
            </div>

            @if (!empty($producto['imagenes']) && count($producto['imagenes']) > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach ($producto['imagenes'] as $index => $img)
                        <button type="button" onclick="seleccionarImagen('{{ $img }}', {{ $index }})"
                            class="card overflow-hidden border transition imagen-miniatura {{ $index === 0 ? 'border-tinta ring-2 ring-tinta/20' : 'border-borde hover:border-tinta' }}"
                            data-index="{{ $index }}" aria-label="Seleccionar imagen {{ $index + 1 }}">
                            <div class="aspect-square bg-gray-100 overflow-hidden">
                                <img src="{{ $img }}" class="w-full h-full object-cover" loading="lazy"
                                    alt="Miniatura {{ $index + 1 }}">
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- COLUMNA DERECHA: INFO --}}
        <div class="card p-6 sm:p-8">

            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="badge">
                        {{ $producto['categoria'] }}
                    </p>

                    <h1 class="mt-3 font-display text-3xl sm:text-4xl leading-tight">
                        {{ $producto['nombre'] }}
                    </h1>
                </div>
            </div>

            <div class="mt-4 flex items-end gap-3 flex-wrap">
                @if (!empty($producto['oferta']) && !empty($producto['precio_oferta']))
                    <p class="text-lg text-gris line-through">
                        ${{ number_format($producto['precio'], 0) }}
                    </p>

                    <p class="text-2xl font-semibold tracking-wide text-tinta">
                        ${{ number_format($producto['precio_oferta'], 0) }}
                        <span class="text-base text-gris font-normal">MXN</span>
                    </p>
                @else
                    <p class="text-2xl font-semibold tracking-wide">
                        ${{ number_format($producto['precio'], 0) }}
                        <span class="text-base text-gris font-normal">MXN</span>
                    </p>
                @endif
            </div>

            <p class="mt-4 text-gris leading-relaxed">
                {{ $producto['descripcion'] }}
            </p>

            @if (!empty($producto['tallas']))
                <div class="mt-6">
                    <p class="text-xs tracking-widest uppercase text-gris">Tallas disponibles</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($producto['tallas'] as $talla)
                            <span class="px-4 py-2 rounded-xl border border-borde bg-white text-sm font-semibold">
                                {{ $talla }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (!empty($producto['colores']))
                <div class="mt-6">
                    <p class="text-xs tracking-widest uppercase text-gris">Colores disponibles</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($producto['colores'] as $color)
                            <span
                                class="px-4 py-2 rounded-xl border border-borde bg-white text-sm font-semibold inline-flex items-center gap-2">
                                @if (!empty($color['hex']))
                                    <span class="w-4 h-4 rounded-md border border-borde"
                                        style="background: {{ $color['hex'] }}"></span>
                                @endif
                                {{ $color['nombre'] }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

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

            <div class="hidden lg:block mt-10 border-t border-borde pt-8 space-y-6">

                {{-- Detalles reales --}}
                <div>
                    <h2 class="font-display text-2xl">Detalles</h2>

                    @if (!empty($producto['detalles']))
                        <ul class="mt-4 space-y-3 text-sm text-gris leading-relaxed">
                            @foreach ($producto['detalles'] as $d)
                                <li>• {{ $d }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mt-4 text-sm text-gris">No hay detalles agregados para este producto.</p>
                    @endif
                </div>

                {{-- Envíos --}}
                {{-- <div class="pt-6 border-t border-borde">
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
                </div> --}}

            </div>

        </div>
    </section>

    <section class="mt-10 grid gap-6 lg:hidden">
        <div class="card p-6 sm:p-8">
            <h2 class="font-display text-2xl">Detalles</h2>

            @if (!empty($producto['detalles']))
                <ul class="mt-4 space-y-3 text-sm text-gris leading-relaxed">
                    @foreach ($producto['detalles'] as $d)
                        <li>• {{ $d }}</li>
                    @endforeach
                </ul>
            @else
                <p class="mt-4 text-sm text-gris">No hay detalles agregados para este producto.</p>
            @endif
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

    <section class="mt-12">
        <div class="flex items-end justify-between gap-6 flex-wrap">
            <div>
                <h2 class="font-display text-2xl sm:text-3xl">También te puede gustar</h2>
                <p class="mt-2 text-gris">Sugerencias basadas en categorías similares.</p>
            </div>
            <a href="{{ route('catalogo') }}"
                class="text-sm font-semibold text-tinta underline underline-offset-4 hover:opacity-70 transition">
                Ver más
            </a>
        </div>

        <div class="mt-6 grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
            @forelse($recomendados as $rp)
                <article class="group">
                    <div class="overflow-hidden rounded-xl2 border border-borde bg-white">
                        <a href="{{ route('producto', $rp['slug']) }}"
                            class="block aspect-[3/4] bg-gray-100 overflow-hidden">
                            <img src="{{ $rp['imagen'] }}" alt="{{ $rp['nombre'] }}"
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.05]"
                                loading="lazy">
                        </a>
                    </div>

                    <div class="mt-3">
                        <p class="text-[11px] uppercase tracking-widest text-gris">
                            {{ $rp['categorias'] ?? $rp['categoria'] }}
                        </p>

                        <h3 class="mt-1 font-medium text-sm sm:text-base leading-tight">
                            {{ $rp['nombre'] }}
                        </h3>

                        {{-- Precio con oferta --}}
                        <div class="mt-1 flex items-end gap-2">
                            @if (!empty($rp['oferta']) && !empty($rp['precio_oferta']))
                                <p class="text-sm text-gris line-through">
                                    ${{ number_format($rp['precio'], 0) }}
                                </p>
                                <p class="text-base font-semibold">
                                    ${{ number_format($rp['precio_oferta'], 0) }}
                                    <span class="text-sm text-gris font-normal">MXN</span>
                                </p>
                            @else
                                <p class="text-base font-semibold">
                                    ${{ number_format($rp['precio'], 0) }}
                                    <span class="text-sm text-gris font-normal">MXN</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-gris mt-6">No hay recomendaciones disponibles por ahora.</p>
            @endforelse
        </div>
    </section>

    <script>
        function seleccionarImagen(url, index) {
            const principal = document.getElementById('imagenPrincipal');
            principal.src = url;

            document.querySelectorAll('.imagen-miniatura').forEach(btn => {
                btn.classList.remove('border-tinta', 'ring-2', 'ring-tinta/20');
                btn.classList.add('border-borde');
            });

            const selected = document.querySelector(`.imagen-miniatura[data-index="${index}"]`);
            if (selected) {
                selected.classList.remove('border-borde');
                selected.classList.add('border-tinta', 'ring-2', 'ring-tinta/20');
            }
        }
    </script>

@endsection
