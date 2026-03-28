{{--
    Componente: Sección colapsable de filtro
    ────────────────────────────────────────
    Props:
      id    — identificador único; el JS lo usa como "fs-{id}" (contenido) y "fc-{id}" (chevron)
      label — texto del encabezado. Si se requiere HTML complejo, usar el slot <x-slot:heading>
      size  — 'desktop' (default) | 'mobile'  Ajusta padding y tamaño de icono según el contexto
      dot   — boolean; muestra un punto indicador cuando el filtro tiene un valor activo
--}}
@props([
    'id',
    'label' => '',
    'size'  => 'desktop',
    'dot'   => false,
])

@php $isDesktop = $size === 'desktop'; @endphp

<div {{ $attributes }}>

    <button
        onclick="toggleSection('{{ $id }}')"
        @class([
            'w-full flex items-center justify-between mb-3 group' => $isDesktop,
            'w-full flex items-center justify-between px-4 py-3 text-left' => ! $isDesktop,
        ])>

        {{-- Encabezado: slot nombrado para casos complejos, label simple como fallback --}}
        @if (isset($heading))
            {{ $heading }}
        @else
            <span @class([
                'text-[10px] tracking-[0.2em] uppercase text-gris transition' => true,
                'group-hover:text-tinta'                                       => $isDesktop,
                'font-semibold'                                                => ! $isDesktop,
            ])>
                {{ $label }}
                @if ($dot)
                    <span class="ml-1 w-1.5 h-1.5 rounded-full bg-tinta inline-block align-middle"></span>
                @endif
            </span>
        @endif

        {{-- Chevron rotado -90° indica estado colapsado por defecto --}}
        <svg
            id="fc-{{ $id }}"
            @class([
                'text-gris transition-transform duration-200',
                'w-3 h-3'     => $isDesktop,
                'w-3.5 h-3.5' => ! $isDesktop,
            ])
            style="transform: rotate(-90deg)"
            fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>

    </button>

    {{-- Contenido del filtro: oculto por defecto; toggleSection() alterna la clase "hidden" --}}
    <div id="fs-{{ $id }}" class="hidden">
        {{ $slot }}
    </div>

</div>
