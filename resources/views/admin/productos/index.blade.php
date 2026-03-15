@extends('admin.layouts.app')

@section('title', 'Productos')
@section('page_title', 'Productos')
@section('page_subtitle', 'Gestión del catálogo de productos')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <form method="GET" action="{{ route('admin.productos.index') }}" class="flex gap-2 flex-1 max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..."
                class="input text-sm flex-1">
            <select name="estado" onchange="this.form.submit()" class="input text-sm w-auto">
                <option value="">Todos</option>
                <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activos</option>
                <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                <option value="eliminado" {{ request('estado') === 'eliminado' ? 'selected' : '' }}>Eliminados</option>
            </select>
            <button type="submit" class="btn-ghost text-sm px-3">Buscar</button>
        </form>
        <a href="{{ route('admin.productos.create') }}" class="btn-primary text-sm flex-shrink-0">
            + Nuevo producto
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-borde bg-gray-50">
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium w-16"></th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Nombre</th>
                        <th
                            class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden lg:table-cell">
                            Categorías</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Precio</th>
                        <th
                            class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden sm:table-cell">
                            Estado</th>
                        <th class="px-5 py-3 text-right text-xs uppercase tracking-widest text-gris font-medium">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-borde">
                    @forelse($productos as $producto)
                        <tr class="hover:bg-gray-50 transition {{ $producto->trashed() ? 'opacity-50' : '' }}">
                            <td class="px-5 py-3">
                                @if ($producto->imagen)
                                    <img src="{{ str_starts_with($producto->imagen, 'http') ? $producto->imagen : \Illuminate\Support\Facades\Storage::url($producto->imagen) }}"
                                        class="w-10 h-12 object-cover rounded-lg border border-borde bg-gray-100">
                                @else
                                    <div
                                        class="w-10 h-12 bg-gray-100 rounded-lg border border-borde flex items-center justify-center text-gris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-medium">{{ $producto->nombre }}</p>
                                @if ($producto->oferta)
                                    <span
                                        class="text-[10px] bg-amber-100 text-amber-700 border border-amber-200 px-1.5 py-0.5 rounded-full">Oferta</span>
                                @endif
                                @if ($producto->trashed())
                                    <span
                                        class="text-[10px] bg-red-100 text-red-700 border border-red-200 px-1.5 py-0.5 rounded-full">Eliminado</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gris hidden lg:table-cell">
                                {{ $producto->categorias->pluck('nombre')->implode(', ') ?: '—' }}
                            </td>
                            <td class="px-5 py-3">
                                @if ($producto->oferta && $producto->precio_oferta)
                                    <p class="text-xs text-gris line-through">${{ number_format($producto->precio, 0) }}
                                    </p>
                                    <p class="font-semibold">${{ number_format($producto->precio_oferta, 0) }}</p>
                                @else
                                    <p class="font-semibold">${{ number_format($producto->precio, 0) }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-3 hidden sm:table-cell">
                                @if ($producto->trashed())
                                    <span
                                        class="inline-flex items-center gap-1 text-xs text-red-700 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">Eliminado</span>
                                @elseif($producto->activo)
                                    <span
                                        class="inline-flex items-center gap-1 text-xs text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full"><span
                                            class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Activo</span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 text-xs text-gray-600 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-full"><span
                                            class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Inactivo</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($producto->trashed())
                                        <form method="POST"
                                            action="{{ route('admin.productos.restore', $producto->id) }}">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs text-green-600 hover:text-green-800 transition font-medium">Restaurar</button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.productos.edit', $producto) }}"
                                            class="text-xs text-gris hover:text-tinta transition font-medium">Editar</a>
                                        <form method="POST" action="{{ route('admin.productos.destroy', $producto) }}"
                                            onsubmit="return confirm('¿Eliminar este producto?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-xs text-red-500 hover:text-red-700 transition font-medium">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-gris">
                                No hay productos.
                                <a href="{{ route('admin.productos.create') }}"
                                    class="text-tinta underline underline-offset-2">Crear uno</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($productos->hasPages())
            <div class="px-5 py-4 border-t border-borde">
                {{ $productos->links() }}
            </div>
        @endif
    </div>

@endsection
