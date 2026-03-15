@extends('admin.layouts.app')
@section('title', 'Colores')
@section('page_title', 'Colores')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gris">{{ $colores->count() }} colores</p>
        <a href="{{ route('admin.colores.create') }}" class="btn-primary text-sm">+ Nuevo color</a>
    </div>
    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-borde bg-gray-50">
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium w-12">Color</th>
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Nombre</th>
                    <th
                        class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden sm:table-cell">
                        Hex</th>
                    <th
                        class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden md:table-cell">
                        Productos</th>
                    <th class="px-5 py-3 text-right text-xs uppercase tracking-widest text-gris font-medium">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-borde">
                @forelse($colores as $color)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3">
                            @if ($color->hex)
                                <span class="w-7 h-7 rounded-full border border-borde inline-block shadow-sm"
                                    style="background:{{ $color->hex }}"></span>
                            @else
                                <span class="w-7 h-7 rounded-full border border-borde inline-block bg-gray-200"></span>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-medium">{{ $color->nombre }}</td>
                        <td class="px-5 py-3 text-gris hidden sm:table-cell font-mono text-xs">{{ $color->hex ?: '—' }}</td>
                        <td class="px-5 py-3 text-gris hidden md:table-cell">{{ $color->productos_count }}</td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.colores.edit', $color) }}"
                                    class="text-xs text-gris hover:text-tinta transition font-medium">Editar</a>
                                <form method="POST" action="{{ route('admin.colores.destroy', $color) }}"
                                    onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-red-500 hover:text-red-700 transition font-medium">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gris">No hay colores. <a
                                href="{{ route('admin.colores.create') }}" class="text-tinta underline">Crear uno</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
