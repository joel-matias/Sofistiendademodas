@props(['producto'])

<article class="group">
    <div class="relative overflow-hidden rounded-xl2 border border-borde bg-white">

        {{-- Badge (ejemplo Oferta) --}}
        @if (!empty($producto['oferta']))
            <div class="absolute top-3 left-3 z-10">
                <span
                    class="bg-pink-600 text-white text-[10px] font-bold px-3 py-1 rounded-full tracking-widest uppercase">
                    Oferta
                </span>
            </div>
        @endif

        {{-- Imagen --}}
        <a href="{{ route('producto', $producto['slug']) }}" class="block aspect-[3/4] overflow-hidden bg-gray-100">
            <img src="{{ $producto['imagen'] }}" alt="{{ $producto['nombre'] }}"
                class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.05]" loading="lazy" />
        </a>
    </div>

    {{-- Info --}}
    <div class="mt-3">
        <p class="text-[11px] uppercase tracking-widest text-gris">
            {{ $producto['categoria'] }}
        </p>

        <h3 class="mt-1 font-medium text-sm sm:text-base leading-tight">
            {{ $producto['nombre'] }}
        </h3>

        <p class="mt-1 text-base font-semibold">
            ${{ number_format($producto['precio'], 0) }}
            <span class="text-sm text-gris font-normal">MXN</span>
        </p>
    </div>
</article>
