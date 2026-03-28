{{--
    Componente: Círculo de color para el filtro de colores
    ───────────────────────────────────────────────────────
    Props:
      href   — URL destino al hacer clic (toggle del filtro)
      active — boolean; indica si este color es el filtro actualmente activo
      color  — objeto Color (propiedades: nombre, hex)
--}}
@props([
    'href',
    'active' => false,
    'color',
])

@php
    $hex     = $color->hex ?? '#ccc';
    // Determina si el color de fondo es claro u oscuro para el ícono de check
    $isLight = $color->hex
        ? hexdec(substr(ltrim($color->hex, '#'), 0, 6)) > 0x888888
        : false;
@endphp

<a
    href="{{ $href }}"
    title="{{ $color->nombre }}"
    @class([
        'w-8 h-8 rounded-full border-2 transition hover:scale-110 flex items-center justify-center',
        'border-tinta ring-2 ring-tinta ring-offset-1' => $active,
        'border-white shadow-sm hover:border-gray-300'  => ! $active,
    ])
    style="background-color: {{ $hex }}">

    @if ($active)
        <svg
            class="w-3 h-3 {{ $isLight ? 'text-tinta' : 'text-white' }}"
            fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                d="M5 13l4 4L19 7" />
        </svg>
    @endif

</a>
