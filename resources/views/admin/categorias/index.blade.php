@extends('admin.layouts.app')
@section('title', 'Categorías')
@section('page_title', 'Categorías')
@section('page_subtitle', 'Gestión de categorías del catálogo')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gris">
            {{ $categorias->count() }} {{ $categorias->count() === 1 ? 'categoría' : 'categorías' }}
        </p>
        <a href="{{ route('admin.categorias.create') }}" class="btn-primary text-sm">+ Nueva categoría</a>
    </div>

    {{-- Cards en móvil --}}
    <div class="space-y-2.5 sm:hidden">
        @forelse($categorias as $cat)
            <div class="card p-4 flex items-center gap-3">
                <div class="flex-shrink-0">
                    @if ($cat->imagen)
                        <img src="{{ str_starts_with($cat->imagen, 'http') ? $cat->imagen : \Illuminate\Support\Facades\Storage::url($cat->imagen) }}"
                             class="w-12 h-12 object-cover rounded-xl border border-borde">
                    @else
                        <div class="w-12 h-12 bg-gray-100 rounded-xl border border-borde flex items-center justify-center text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm truncate">{{ $cat->nombre }}</p>
                    <p class="text-xs text-gris">{{ $cat->productos_count }} productos</p>
                </div>
                <div class="flex items-center gap-1 flex-shrink-0">
                    <a href="{{ route('admin.categorias.edit', $cat) }}"
                       class="px-2.5 py-1.5 rounded-lg text-xs font-medium text-gris hover:text-tinta hover:bg-gray-100 transition">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.categorias.destroy', $cat) }}"
                          data-confirm="¿Eliminar esta categoría? Los productos asociados perderán esta categoría." data-confirm-danger>
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-2.5 py-1.5 rounded-lg text-xs font-medium text-red-400 hover:text-red-600 hover:bg-red-50 transition">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gris">
                No hay categorías.
                <a href="{{ route('admin.categorias.create') }}" class="text-tinta underline ml-1">Crear una</a>
            </div>
        @endforelse
    </div>

    {{-- Tabla en desktop --}}
    <div class="card overflow-hidden hidden sm:block">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-borde bg-gray-50">
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium w-16"></th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Nombre</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden md:table-cell">Slug</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden lg:table-cell">Productos</th>
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
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg border border-borde flex items-center justify-center text-gris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-medium">{{ $cat->nombre }}</td>
                            <td class="px-5 py-3 text-gris hidden md:table-cell font-mono text-xs">{{ $cat->slug }}</td>
                            <td class="px-5 py-3 text-gris hidden lg:table-cell">{{ $cat->productos_count }}</td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.categorias.edit', $cat) }}"
                                       class="text-xs text-gris hover:text-tinta transition font-medium">Editar</a>
                                    <form method="POST" action="{{ route('admin.categorias.destroy', $cat) }}"
                                          data-confirm="¿Eliminar esta categoría? Los productos asociados perderán esta categoría." data-confirm-danger>
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
                                No hay categorías.
                                <a href="{{ route('admin.categorias.create') }}" class="text-tinta underline underline-offset-2">Crear una</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
