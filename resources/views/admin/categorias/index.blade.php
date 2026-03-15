@extends('admin.layouts.app')
@section('title', 'Categorías')
@section('page_title', 'Categorías')
@section('page_subtitle', 'Gestión de categorías del catálogo')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gris">{{ $categorias->count() }} {{ $categorias->count() === 1 ? 'categoría' : 'categorías' }}
        </p>
        <a href="{{ route('admin.categorias.create') }}" class="btn-primary text-sm">+ Nueva categoría</a>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-borde bg-gray-50">
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium w-16"></th>
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Nombre</th>
                    <th
                        class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden sm:table-cell">
                        Slug</th>
                    <th
                        class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden md:table-cell">
                        Productos</th>
                    <th class="px-5 py-3 text-right text-xs uppercase tracking-widest text-gris font-medium">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-borde">
                @forelse($categorias as $cat)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3">
                            @if ($cat->imagen)
                                <img src="{{ str_starts_with($cat->imagen, 'http') ? $cat->imagen : \Illuminate\Support\Facades\Storage::url($cat->imagen) }}"
                                    class="w-10 h-10 object-cover rounded-lg border border-borde">
                            @else
                                <div
                                    class="w-10 h-10 bg-gray-100 rounded-lg border border-borde flex items-center justify-center text-gris">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-medium">{{ $cat->nombre }}</td>
                        <td class="px-5 py-3 text-gris hidden sm:table-cell font-mono text-xs">{{ $cat->slug }}</td>
                        <td class="px-5 py-3 text-gris hidden md:table-cell">{{ $cat->productos_count }}</td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.categorias.edit', $cat) }}"
                                    class="text-xs text-gris hover:text-tinta transition font-medium">Editar</a>
                                <form method="POST" action="{{ route('admin.categorias.destroy', $cat) }}"
                                    onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-red-500 hover:text-red-700 transition font-medium">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gris">No hay categorías. <a
                                href="{{ route('admin.categorias.create') }}"
                                class="text-tinta underline underline-offset-2">Crear una</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
