@props(['producto'])

@php
    $esFavorito =
        auth()->check() && !auth()->user()->isAdmin() && in_array($producto['id'] ?? null, $favoritoIds ?? []);
@endphp

<article class="group relative" data-product-card data-producto-id="{{ $producto['id'] ?? '' }}">
    <a href="{{ route('producto', $producto['slug']) }}" class="block">
        <div class="overflow-hidden rounded-2xl bg-gray-100 border border-borde relative">
            <div class="aspect-[3/4] overflow-hidden">
                @if (!empty($producto['imagen']))
                    <img src="{{ $producto['imagen'] }}" alt="{{ $producto['nombre'] }}"
                        class="w-full h-full object-cover transition duration-700 ease-out group-hover:scale-[1.06]"
                        loading="lazy">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Badge oferta --}}
            @if (!empty($producto['oferta']))
                <div class="absolute top-3 left-3">
                    <span
                        class="inline-flex items-center bg-oferta text-white text-[10px] font-semibold tracking-widest uppercase px-2.5 py-1 rounded-lg shadow-sm">
                        Sale
                    </span>
                </div>
            @endif

            {{-- Hover overlay CTA --}}
            <div class="absolute inset-0 bg-tinta/0 group-hover:bg-tinta/10 transition-all duration-300 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100 pointer-events-none">
                <span class="text-[10px] tracking-[0.2em] uppercase font-semibold text-white bg-tinta/80 backdrop-blur-sm px-3 py-1.5 rounded-full">
                    Ver detalle
                </span>
            </div>
        </div>
    </a>

    {{-- Heart button --}}
    @auth
        @if (!auth()->user()->isAdmin() && !empty($producto['id']))
            <button type="button" onclick="toggleFavorito(this, {{ $producto['id'] }})"
                data-favorito="{{ $esFavorito ? 'true' : 'false' }}"
                class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm shadow-sm border border-borde/50 flex items-center justify-center transition hover:scale-110 active:scale-95"
                aria-label="{{ $esFavorito ? 'Quitar de favoritos' : 'Guardar en favoritos' }}">
                <svg class="w-4 h-4 transition-all" fill="{{ $esFavorito ? 'currentColor' : 'none' }}" stroke="currentColor"
                    viewBox="0 0 24 24" style="color: {{ $esFavorito ? '#ef4444' : '#716F6A' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>
        @endif
    @endauth

    {{-- Info --}}
    <div class="mt-3 px-0.5">
        @if (!empty($producto['categoria']))
            <p class="text-[10px] uppercase tracking-[0.15em] text-gris font-medium">{{ $producto['categoria'] }}</p>
        @endif

        <h3 class="mt-1 font-medium text-sm sm:text-[15px] leading-snug line-clamp-2 text-tinta">
            <a href="{{ route('producto', $producto['slug']) }}" class="hover:text-gris transition">
                {{ $producto['nombre'] }}
            </a>
        </h3>

        <div class="mt-1.5 flex items-baseline gap-2">
            @if (!empty($producto['oferta']) && !empty($producto['precio_oferta']))
                <span class="text-sm font-semibold text-oferta">${{ number_format($producto['precio_oferta'], 0) }}
                    <span class="text-xs font-normal text-gris">MXN</span></span>
                <span class="text-xs text-gris/70 line-through">${{ number_format($producto['precio'], 0) }}</span>
            @else
                <span class="text-sm font-semibold text-tinta">${{ number_format($producto['precio'] ?? 0, 0) }}
                    <span class="text-xs font-normal text-gris">MXN</span></span>
            @endif
        </div>
    </div>
</article>

@once
    @push('scripts')
        <script>
            async function toggleFavorito(btn, productoId) {
                const svg = btn.querySelector('svg');
                const esFav = btn.dataset.favorito === 'true';

                // Optimistic UI
                btn.dataset.favorito = esFav ? 'false' : 'true';
                svg.setAttribute('fill', esFav ? 'none' : 'currentColor');
                svg.style.color = esFav ? '#716F6A' : '#ef4444';
                btn.setAttribute('aria-label', esFav ? 'Guardar en favoritos' : 'Quitar de favoritos');

                try {
                    const res = await fetch(`/favoritos/${productoId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                                '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    if (!res.ok) throw new Error('Error');

                    const data = await res.json();

                    // Sync UI with the backend response in case the local state was stale.
                    btn.dataset.favorito = data.favorito ? 'true' : 'false';
                    svg.setAttribute('fill', data.favorito ? 'currentColor' : 'none');
                    svg.style.color = data.favorito ? '#ef4444' : '#716F6A';
                    btn.setAttribute('aria-label', data.favorito ? 'Quitar de favoritos' : 'Guardar en favoritos');

                    // Actualizar contador en navbar si existe
                    const counter = document.getElementById('favoritosCount');
                    if (counter) {
                        counter.textContent = data.count;
                        counter.classList.toggle('hidden', data.count === 0);
                    }

                    const favoritosCountLabel = document.getElementById('favoritosPageCount');
                    if (favoritosCountLabel) {
                        favoritosCountLabel.textContent = `(${data.count})`;
                    }

                    // En la vista de favoritos, quitar la card al remover el producto.
                    if (!data.favorito) {
                        const favoritosGrid = btn.closest('[data-favoritos-grid]');
                        const card = btn.closest('[data-product-card]');

                        if (favoritosGrid && card) {
                            card.remove();

                            if (!favoritosGrid.querySelector('[data-product-card]')) {
                                window.location.reload();
                            }
                        }
                    }
                } catch {
                    // Revert on error
                    btn.dataset.favorito = esFav ? 'true' : 'false';
                    svg.setAttribute('fill', esFav ? 'currentColor' : 'none');
                    svg.style.color = esFav ? '#ef4444' : '#716F6A';
                }
            }
        </script>
    @endpush
@endonce
