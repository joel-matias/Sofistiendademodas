{{-- Grid de productos con estado vacío diferenciado según el contexto --}}

<div class="grid gap-x-4 gap-y-8 grid-cols-2 sm:grid-cols-3 xl:grid-cols-4">

    @forelse ($productos as $producto)

        <x-product-card :producto="$producto" />

    @empty

        <div class="col-span-full py-20 text-center">

            @if (request('search'))
                <div class="max-w-sm mx-auto">
                    <svg class="w-12 h-12 mx-auto text-gray-200 mb-4"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="text-tinta font-medium mb-1">
                        Sin resultados para "{{ request('search') }}"
                    </p>
                    <p class="text-sm text-gris mb-6">
                        Intenta con otro término o explora el catálogo
                    </p>
                    <a href="{{ route('catalogo') }}" class="btn-ghost text-sm">
                        Ver todo el catálogo
                    </a>
                </div>
            @else
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="text-gris mb-1">No hay productos con esos filtros.</p>
                <a href="{{ $clearAllUrl }}" class="btn-ghost text-sm mt-4 inline-flex">
                    Limpiar filtros
                </a>
            @endif

        </div>

    @endforelse

</div>

{{-- Paginación --}}
@if ($productos->hasPages())
    <div class="mt-12 flex justify-center">
        {{ $productos->links() }}
    </div>
@endif
