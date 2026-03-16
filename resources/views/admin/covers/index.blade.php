@extends('admin.layouts.app')
@section('title', 'Covers del Hero')
@section('page_title', 'Covers del Hero')
@section('page_subtitle', 'Carrusel de la portada')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gris">{{ $covers->count() }} covers</p>
        <a href="{{ route('admin.covers.create') }}" class="btn-primary text-sm">+ Nuevo cover</a>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-borde bg-gray-50">
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Imagen</th>
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Título</th>
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden sm:table-cell">Subtítulo</th>
                    <th class="text-center px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden md:table-cell">Orden</th>
                    <th class="text-center px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden md:table-cell">Estado</th>
                    <th class="px-5 py-3 text-right text-xs uppercase tracking-widest text-gris font-medium">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-borde">
                @forelse($covers as $cover)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3">
                            @if($cover->imagen)
                                <img src="{{ str_starts_with($cover->imagen, 'http') ? $cover->imagen : Storage::url($cover->imagen) }}"
                                    alt="{{ $cover->titulo }}"
                                    class="w-16 h-10 object-cover rounded-lg border border-borde">
                            @else
                                <div class="w-16 h-10 rounded-lg bg-gray-100 border border-borde flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gris" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-medium">{{ $cover->titulo }}</td>
                        <td class="px-5 py-3 text-gris hidden sm:table-cell text-xs max-w-xs truncate">{{ $cover->subtitulo }}</td>
                        <td class="px-5 py-3 text-center text-gris hidden md:table-cell">{{ $cover->orden }}</td>
                        <td class="px-5 py-3 text-center hidden md:table-cell">
                            @if($cover->activo)
                                <span class="badge">Activo</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-gray-100 text-gris">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.covers.edit', $cover) }}"
                                    class="text-xs text-gris hover:text-tinta transition font-medium">Editar</a>
                                <form method="POST" action="{{ route('admin.covers.destroy', $cover) }}"
                                    onsubmit="return confirm('¿Eliminar este cover?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-red-500 hover:text-red-700 transition font-medium">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gris">
                            No hay covers. <a href="{{ route('admin.covers.create') }}" class="text-tinta underline">Crear uno</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
