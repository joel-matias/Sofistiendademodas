@extends('layouts.app')

@section('title', $producto['nombre'] . ' | ' . config('seo.site_name'))
@section('og_type', 'product')
@section('canonical', route('producto', $producto['slug']))
@section('description',
    $producto['descripcion']
        ? mb_strimwidth(strip_tags($producto['descripcion']), 0, 160, '…')
        : 'Descubre ' . $producto['nombre'] . ' en ' . config('seo.site_name') . '. Moda y estilo a tu alcance.'
)
@if ($producto['imagen'])
    @section('og_image', $producto['imagen'])
@endif

@push('head')
{{-- ── JSON-LD: Producto ──────────────────────────────────────────────────── --}}
{{-- Permite a Google mostrar precio y disponibilidad como rich snippets     --}}
@php
    $precioFinal = ($producto['oferta'] && $producto['precio_oferta'])
        ? $producto['precio_oferta']
        : $producto['precio'];

    $ldProduct = [
        '@context' => 'https://schema.org',
        '@type'    => 'Product',
        'name'     => $producto['nombre'],
        'url'      => route('producto', $producto['slug']),
        'image'    => $producto['imagenes'] ?: [$producto['imagen']],
        'brand'    => ['@type' => 'Brand', 'name' => config('seo.site_name')],
        'offers'   => [
            '@type'         => 'Offer',
            'priceCurrency' => 'MXN',
            'price'         => number_format((float) $precioFinal, 2, '.', ''),
            'availability'  => 'https://schema.org/InStock',
            'url'           => route('producto', $producto['slug']),
            'seller'        => ['@type' => 'Organization', 'name' => config('seo.site_name')],
        ],
    ];
    if (!empty($producto['descripcion'])) $ldProduct['description'] = $producto['descripcion'];
    if (!empty($producto['categoria']))   $ldProduct['category']    = $producto['categoria'];
@endphp
<script type="application/ld+json">
{!! json_encode($ldProduct, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

{{-- ── JSON-LD: BreadcrumbList ───────────────────────────────────────────── --}}
<script type="application/ld+json">
{!! json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio',   'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Catálogo', 'item' => route('catalogo')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $producto['nombre']],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')

    <div class="container-full pt-6 sm:pt-8 pb-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gris mb-8">
            <a href="{{ route('home') }}" class="hover:text-tinta transition">Inicio</a>
            <svg class="w-3.5 h-3.5 text-borde" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition">Catálogo</a>
            <svg class="w-3.5 h-3.5 text-borde" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-tinta line-clamp-1">{{ $producto['nombre'] }}</span>
        </nav>

        {{-- Product detail --}}
        <div class="grid gap-8 lg:gap-14 lg:grid-cols-[1fr_420px] xl:grid-cols-[1fr_480px] lg:items-start">

            {{-- IMAGES --}}
            <div class="space-y-3">
                <div class="overflow-hidden rounded-2xl border border-borde bg-gray-100">
                    <div class="aspect-[4/5] overflow-hidden">
                        <img id="imagenPrincipal" src="{{ $producto['imagenes'][0] ?? $producto['imagen'] }}"
                            alt="{{ $producto['nombre'] }}" class="w-full h-full object-cover transition duration-500"
                            loading="eager">
                    </div>
                </div>

                @if (!empty($producto['imagenes']) && count($producto['imagenes']) > 1)
                    <div class="grid grid-cols-4 gap-2 sm:gap-3">
                        @foreach ($producto['imagenes'] as $idx => $img)
                            <button type="button" onclick="selectImg('{{ $img }}', {{ $idx }})"
                                class="overflow-hidden rounded-xl border-2 transition imagen-miniatura {{ $idx === 0 ? 'border-tinta' : 'border-borde hover:border-gray-400' }}"
                                data-index="{{ $idx }}" aria-label="Ver imagen {{ $idx + 1 }}">
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    <img src="{{ $img }}" class="w-full h-full object-cover" loading="lazy"
                                        alt="Imagen {{ $idx + 1 }}">
                                </div>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="lg:sticky lg:top-24">

                @if (!empty($producto['categoria']))
                    <span class="badge">{{ $producto['categoria'] }}</span>
                @endif

                <h1 class="mt-3 font-display text-3xl sm:text-4xl leading-tight">
                    {{ $producto['nombre'] }}
                </h1>

                {{-- Price --}}
                <div class="mt-5">
                    @if (!empty($producto['oferta']) && !empty($producto['precio_oferta']))
                        @php
                            $pct = round((1 - $producto['precio_oferta'] / $producto['precio']) * 100);
                        @endphp
                        <div class="flex items-baseline gap-3 flex-wrap">
                            <span class="text-3xl font-bold text-oferta">${{ number_format($producto['precio_oferta'], 0) }}</span>
                            <span class="text-base text-gris font-normal">MXN</span>
                            <span class="text-base text-gris/60 line-through">${{ number_format($producto['precio'], 0) }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="badge-oferta">Oferta −{{ $pct }}%</span>
                        </div>
                    @else
                        <div class="flex items-baseline gap-3">
                            <span class="text-3xl font-bold text-tinta">${{ number_format($producto['precio'], 0) }}</span>
                            <span class="text-base text-gris font-normal">MXN</span>
                        </div>
                    @endif
                </div>

                @if (!empty($producto['descripcion']))
                    <p class="mt-4 text-gris leading-relaxed text-sm sm:text-base">{{ $producto['descripcion'] }}</p>
                @endif

                @if (!empty($producto['tallas']))
                    <div class="mt-6">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[11px] tracking-[0.15em] uppercase text-gris">Tallas disponibles</p>
                            <a href="{{ route('guia-tallas') }}"
                                class="text-[11px] tracking-[0.1em] uppercase text-gris/70 hover:text-tinta underline underline-offset-2 transition">
                                Ver guía de tallas
                            </a>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($producto['tallas'] as $talla)
                                <span
                                    class="w-12 h-12 flex items-center justify-center rounded-xl border border-borde bg-white text-sm font-semibold hover:border-tinta transition cursor-default">
                                    {{ $talla }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (!empty($producto['colores']))
                    <div class="mt-6">
                        <p class="text-[11px] tracking-[0.15em] uppercase text-gris mb-3">Colores disponibles</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($producto['colores'] as $color)
                                <span
                                    class="flex items-center gap-2 px-3 py-2 rounded-xl border border-borde bg-white text-sm">
                                    @if (!empty($color['hex']))
                                        <span class="w-4 h-4 rounded-full border border-borde/50 flex-shrink-0"
                                            style="background:{{ $color['hex'] }}"></span>
                                    @endif
                                    {{ $color['nombre'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- CTA --}}
                <div class="mt-8 space-y-3">
                    <a href="https://wa.me/{{ config('seo.whatsapp') }}?text={{ urlencode('Hola, me interesa el producto: ' . $producto['nombre'] . ' ($' . number_format($producto['precio_oferta'] ?? $producto['precio'], 0) . ' MXN) — ' . url()->current()) }}"
                        target="_blank" rel="noopener"
                        class="btn w-full text-center flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#1ebe5d] text-white active:scale-[0.98]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        Preguntar por WhatsApp
                    </a>

                    @auth
                        @if (!auth()->user()->isAdmin())
                            @php $esFav = in_array($producto['id'] ?? null, $favoritoIds ?? []); @endphp
                            <button type="button" id="btnFavShow" onclick="toggleFavShow(this, {{ $producto['id'] ?? 0 }})"
                                data-favorito="{{ $esFav ? 'true' : 'false' }}"
                                class="w-full flex items-center justify-center gap-2 btn-ghost transition-all">
                                <svg id="heartShow" class="w-5 h-5 transition-all"
                                    fill="{{ $esFav ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"
                                    style="color: {{ $esFav ? '#ef4444' : '#716F6A' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span id="favShowText">{{ $esFav ? 'Quitar de favoritos' : 'Guardar en favoritos' }}</span>
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 btn-ghost">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Guardar en favoritos
                        </a>
                    @endauth

                    <a href="{{ route('catalogo') }}" class="btn-ghost w-full text-center">← Volver al catálogo</a>
                </div>

                {{-- Perks --}}
                <div class="mt-6 pt-6 border-t border-borde grid grid-cols-2 gap-4">
                    @foreach ([['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'txt' => 'Envíos rápidos y seguros'], ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'txt' => 'Cambios fáciles']] as $perk)
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 mt-0.5 text-moda flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="{{ $perk['icon'] }}" />
                            </svg>
                            <p class="text-xs text-gris leading-relaxed">{{ $perk['txt'] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Detalles desktop --}}
                @if (!empty($producto['detalles']))
                    <div class="mt-6 pt-6 border-t border-borde">
                        <p class="text-[11px] tracking-[0.15em] uppercase text-gris mb-3">Detalles</p>
                        <ul class="space-y-2">
                            @foreach ($producto['detalles'] as $d)
                                <li class="flex items-start gap-2 text-sm text-gris">
                                    <span class="mt-1.5 w-1 h-1 rounded-full bg-gris flex-shrink-0"></span>
                                    {{ $d }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>

        {{-- TAMBIÉN TE PUEDE GUSTAR --}}
        @if (!empty($recomendados))
            <section class="mt-20 sm:mt-24">
                <div class="flex items-end justify-between gap-4 mb-8">
                    <div>
                        <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Sugerencias</p>
                        <h2 class="section-title">También te puede gustar</h2>
                    </div>
                    <a href="{{ route('catalogo') }}"
                        class="hidden sm:inline text-sm font-semibold text-gris hover:text-tinta transition underline underline-offset-4">Ver
                        más</a>
                </div>
                <div class="grid gap-x-4 gap-y-8 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($recomendados as $rp)
                        <x-product-card :producto="$rp" />
                    @endforeach
                </div>
            </section>
        @endif

    </div>

    <script>
        function selectImg(url, idx) {
            document.getElementById('imagenPrincipal').src = url;
            document.querySelectorAll('.imagen-miniatura').forEach((btn, i) => {
                btn.classList.toggle('border-tinta', i === idx);
                btn.classList.toggle('border-2', i === idx);
                btn.classList.toggle('border-borde', i !== idx);
            });
        }

        async function toggleFavShow(btn, productoId) {
            if (!productoId) return;
            const svg = document.getElementById('heartShow');
            const text = document.getElementById('favShowText');
            const esFav = btn.dataset.favorito === 'true';

            // Optimistic UI
            btn.dataset.favorito = esFav ? 'false' : 'true';
            svg.setAttribute('fill', esFav ? 'none' : 'currentColor');
            svg.style.color = esFav ? '#716F6A' : '#ef4444';
            text.textContent = esFav ? 'Guardar en favoritos' : 'Quitar de favoritos';

            try {
                const res = await fetch(`/favoritos/${productoId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                if (!res.ok) throw new Error();
                const data = await res.json();
                const counter = document.getElementById('favoritosCount');
                if (counter) {
                    counter.textContent = data.count;
                    counter.classList.toggle('hidden', data.count === 0);
                }
            } catch {
                // Revert
                btn.dataset.favorito = esFav ? 'true' : 'false';
                svg.setAttribute('fill', esFav ? 'currentColor' : 'none');
                svg.style.color = esFav ? '#ef4444' : '#716F6A';
                text.textContent = esFav ? 'Quitar de favoritos' : 'Guardar en favoritos';
            }
        }
    </script>

@endsection
