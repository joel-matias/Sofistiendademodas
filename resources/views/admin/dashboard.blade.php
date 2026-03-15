@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Resumen general del catálogo')

@section('content')

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">

        @php
            $statCards = [
                [
                    'label' => 'Total productos',
                    'value' => $stats['productos'],
                    'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                    'color' => 'bg-tinta text-crema',
                ],
                [
                    'label' => 'Activos',
                    'value' => $stats['activos'],
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => 'bg-green-600 text-white',
                ],
                [
                    'label' => 'En oferta',
                    'value' => $stats['enOferta'],
                    'icon' =>
                        'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                    'color' => 'bg-amber-500 text-white',
                ],
                [
                    'label' => 'Categorías',
                    'value' => $stats['categorias'],
                    'icon' =>
                        'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
                    'color' => 'bg-purple-600 text-white',
                ],
                [
                    'label' => 'Tallas',
                    'value' => $stats['tallas'],
                    'icon' =>
                        'M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7',
                    'color' => 'bg-blue-600 text-white',
                ],
                [
                    'label' => 'Colores',
                    'value' => $stats['colores'],
                    'icon' =>
                        'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                    'color' => 'bg-rose-500 text-white',
                ],
            ];
        @endphp

        @foreach ($statCards as $card)
            <div class="card p-5">
                <div class="w-9 h-9 rounded-xl {{ $card['color'] }} flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}" />
                    </svg>
                </div>
                <p class="text-2xl font-bold text-tinta">{{ $card['value'] }}</p>
                <p class="text-xs text-gris mt-0.5">{{ $card['label'] }}</p>
            </div>
        @endforeach

    </div>

    {{-- acciones --}}
    <div class="mb-8">
        <h2 class="font-display text-xl mb-4">Acciones rápidas</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.productos.create') }}" class="btn-primary text-sm">
                + Nuevo producto
            </a>
            <a href="{{ route('admin.categorias.create') }}" class="btn-ghost text-sm">
                + Nueva categoría
            </a>
            <a href="{{ route('admin.tallas.create') }}" class="btn-ghost text-sm">
                + Nueva talla
            </a>
            <a href="{{ route('admin.colores.create') }}" class="btn-ghost text-sm">
                + Nuevo color
            </a>
        </div>
    </div>

    {{-- Últimos productos --}}
    <div class="card overflow-hidden">
        <div class="px-5 py-4 border-b border-borde flex items-center justify-between">
            <h2 class="font-display text-lg">Últimos productos</h2>
            <a href="{{ route('admin.productos.index') }}"
                class="text-xs text-gris hover:text-tinta transition underline underline-offset-2">
                Ver todos
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-borde bg-gray-50">
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium w-16">Foto
                        </th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Nombre</th>
                        <th
                            class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden sm:table-cell">
                            Categorías</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Precio</th>
                        <th
                            class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden md:table-cell">
                            Estado</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-borde">
                    @forelse($stats['ultimosProductos'] as $producto)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3">
                                @if ($producto->imagen)
                                    <img src="{{ str_starts_with($producto->imagen, 'http') ? $producto->imagen : Storage::url($producto->imagen) }}"
                                        alt="{{ $producto->nombre }}"
                                        class="w-10 h-10 object-cover rounded-lg border border-borde">
                                @else
                                    <div
                                        class="w-10 h-10 bg-gray-100 rounded-lg border border-borde flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gris" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-medium">{{ $producto->nombre }}</td>
                            <td class="px-5 py-3 text-gris hidden sm:table-cell">
                                {{ $producto->categorias->pluck('nombre')->implode(', ') ?: '—' }}
                            </td>
                            <td class="px-5 py-3">
                                @if ($producto->oferta && $producto->precio_oferta)
                                    <span
                                        class="text-gris line-through text-xs">${{ number_format($producto->precio, 0) }}</span>
                                    <span class="font-semibold">${{ number_format($producto->precio_oferta, 0) }}</span>
                                @else
                                    <span class="font-semibold">${{ number_format($producto->precio, 0) }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 hidden md:table-cell">
                                @if ($producto->activo)
                                    <span
                                        class="inline-flex items-center gap-1 text-xs text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Activo
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 text-xs text-gray-600 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.productos.edit', $producto) }}"
                                    class="text-xs text-gris hover:text-tinta transition underline underline-offset-2">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gris">
                                No hay productos aún.
                                <a href="{{ route('admin.productos.create') }}"
                                    class="text-tinta underline underline-offset-2 hover:opacity-70">Crear uno</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
