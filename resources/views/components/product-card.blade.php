@props(['producto'])

<article class="card overflow-hidden group">
    <a href="{{ route('producto', $producto['slug']) }}" class="block aspect-[4/5] overflow-hidden">
        <img
            src="{{ $producto['imagen'] }}"
            alt="{{ $producto['nombre'] }}"
            class="w-full h-full object-cover transition duration-300 group-hover:scale-[1.03]"
            loading="lazy"
        />
    </a>

    <div class="p-4 grid gap-2">
        <p class="text-xs uppercase tracking-widest text-gris">
            {{ $producto['categoria'] }}
        </p>

        <h3 class="font-display text-lg leading-tight">
            {{ $producto['nombre'] }}
        </h3>

        <p class="text-base font-semibold tracking-wide">
            ${{ number_format($producto['precio'], 0) }}
            <span class="text-sm text-gris font-normal">MXN</span>
        </p>

        <a href="{{ route('producto', $producto['slug']) }}" class="btn-primary mt-2">
            Ver detalle
        </a>
    </div>
</article>
