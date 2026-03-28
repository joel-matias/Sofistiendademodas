@extends('layouts.app')

@section('title', isset($categoriaSeleccionada)
    ? $categoriaSeleccionada['nombre'] . ' · Catálogo | Sofis'
    : (request()->boolean('nuevo') ? 'Lo Nuevo · Catálogo | Sofis' : 'Catálogo | Sofis'))

@section('content')

@php
    // Parámetros activos de la URL; excluye valores vacíos o nulos
    $params = array_filter(
        request()->only(['categoria', 'search', 'orden', 'nuevo', 'ofertas', 'talla', 'color']),
        fn($v) => $v !== '' && $v !== null
    );

    // Genera una URL que activa o desactiva un filtro (comportamiento toggle)
    $url = function (string $key, string $value) use ($params): string {
        $p = $params;
        if (isset($p[$key]) && (string) $p[$key] === $value) {
            unset($p[$key]);
        } else {
            $p[$key] = $value;
        }
        return route('catalogo') . ($p ? '?' . http_build_query($p) : '');
    };

    // Comprueba si un filtro o valor concreto está activo en la URL actual
    $isActive = fn(string $key, string $value = ''): bool =>
        $value === ''
            ? ! empty($params[$key])
            : (string) ($params[$key] ?? '') === $value;

    // Cuenta los filtros activos (excluye búsqueda y orden)
    $filterCount = collect(['nuevo', 'ofertas', 'talla', 'color', 'categoria'])
        ->filter(fn($k) => ! empty($params[$k]))
        ->count();

    // URL para limpiar todos los filtros manteniendo la búsqueda activa
    $clearAllUrl = route('catalogo', array_filter(['search' => request('search')]));

    // Genera URL de ordenamiento; si $val es vacío, elimina el parámetro 'orden'
    $ordenUrl = function (string $val) use ($params): string {
        $p = $params;
        if ($val === '') {
            unset($p['orden']);
        } else {
            $p['orden'] = $val;
        }
        return route('catalogo') . ($p ? '?' . http_build_query($p) : '');
    };

    $ordenActual = request('orden', '');
@endphp

<div class="container-full pt-8 sm:pt-10 pb-14">

    @include('catalogo.partials.header')

    @include('catalogo.partials.mobile-toolbar')

    @include('catalogo.partials.filter-mobile')

    <div class="lg:flex lg:gap-8 lg:items-start">

        @include('catalogo.partials.filter-sidebar')

        <div class="flex-1 min-w-0">

            @include('catalogo.partials.active-filters')

            @include('catalogo.partials.product-grid')

        </div>

    </div>

</div>

@push('scripts')
<script>
// Abre/cierra el panel de filtros en mobile y actualiza aria-expanded
function toggleFiltrosMobile() {
    const panel = document.getElementById('panelFiltrosMobile');
    const btn   = document.getElementById('btnFiltrosMobile');
    const open  = panel.classList.toggle('hidden') === false;
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
}

// Colapsa o expande cualquier sección de filtro identificada por su `id`
// Alterna la clase "hidden" en el contenido y rota el chevron
function toggleSection(id) {
    const content = document.getElementById('fs-' + id);
    const chevron = document.getElementById('fc-' + id);
    if (!content) return;
    const collapsed = content.classList.toggle('hidden');
    if (chevron) chevron.style.transform = collapsed ? 'rotate(-90deg)' : '';
}
</script>
@endpush

@endsection
