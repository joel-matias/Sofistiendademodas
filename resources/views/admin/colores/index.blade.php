@extends('admin.layouts.app')
@section('title', 'Colores')
@section('page_title', 'Colores')
@section('page_subtitle', 'Gestión de colores del catálogo')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gris">{{ $colores->count() }} colores</p>
        <a href="{{ route('admin.colores.create') }}" class="btn-primary text-sm">+ Nuevo color</a>
    </div>

    {{-- Cards en móvil --}}
    <div class="grid grid-cols-2 gap-2.5 sm:hidden">
        @forelse($colores as $color)
            <div class="card p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-6 h-6 rounded-full border border-borde shadow-sm flex-shrink-0"
                          style="background: {{ $color->hex ?: '#e5e7eb' }}"></span>
                    <p class="font-semibold text-sm truncate">{{ $color->nombre }}</p>
                </div>
                <p class="text-xs text-gris font-mono mb-3">{{ $color->hex ?: '—' }}</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.colores.edit', $color) }}"
                       class="flex-1 text-center px-2 py-1.5 rounded-lg text-xs font-medium text-gris hover:text-tinta hover:bg-gray-100 transition border border-borde">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.colores.destroy', $color) }}"
                          data-confirm="¿Eliminar este color?" data-confirm-danger>
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-2 py-1.5 rounded-lg text-xs font-medium text-red-400 hover:text-red-600 hover:bg-red-50 transition border border-red-100">
                            ✕
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-2 card p-8 text-center text-gris">
                No hay colores.
                <a href="{{ route('admin.colores.create') }}" class="text-tinta underline ml-1">Crear uno</a>
            </div>
        @endforelse
    </div>

    {{-- Tabla en desktop --}}
    <div class="card overflow-hidden hidden sm:block">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-borde bg-gray-50">
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium w-12">Color</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Nombre</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden md:table-cell">Hex</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden lg:table-cell">Productos</th>
                        <th class="px-5 py-3 text-right text-xs uppercase tracking-widest text-gris font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-borde">
                    @forelse($colores as $color)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3">
                                <span class="w-7 h-7 rounded-full border border-borde inline-block shadow-sm"
                                      style="background: {{ $color->hex ?: '#e5e7eb' }}"></span>
                            </td>
                            <td class="px-5 py-3 font-medium">{{ $color->nombre }}</td>
                            <td class="px-5 py-3 text-gris hidden md:table-cell font-mono text-xs">{{ $color->hex ?: '—' }}</td>
                            <td class="px-5 py-3 text-gris hidden lg:table-cell">{{ $color->productos_count }}</td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.colores.edit', $color) }}"
                                       class="text-xs text-gris hover:text-tinta transition font-medium">Editar</a>
                                    <form method="POST" action="{{ route('admin.colores.destroy', $color) }}"
                                          data-confirm="¿Eliminar este color?" data-confirm-danger>
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-500 hover:text-red-700 transition font-medium">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gris">
                                No hay colores.
                                <a href="{{ route('admin.colores.create') }}" class="text-tinta underline">Crear uno</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
