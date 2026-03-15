@extends('admin.layouts.app')
@section('title', 'Tallas')
@section('page_title', 'Tallas')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gris">{{ $tallas->count() }} tallas</p>
        <a href="{{ route('admin.tallas.create') }}" class="btn-primary text-sm">+ Nueva talla</a>
    </div>
    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-borde bg-gray-50">
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
                @forelse($tallas as $talla)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 font-medium">{{ $talla->nombre }}</td>
                        <td class="px-5 py-3 text-gris hidden sm:table-cell font-mono text-xs">{{ $talla->slug }}</td>
                        <td class="px-5 py-3 text-gris hidden md:table-cell">{{ $talla->productos_count }}</td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.tallas.edit', $talla) }}"
                                    class="text-xs text-gris hover:text-tinta transition font-medium">Editar</a>
                                <form method="POST" action="{{ route('admin.tallas.destroy', $talla) }}"
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
                        <td colspan="4" class="px-5 py-10 text-center text-gris">No hay tallas. <a
                                href="{{ route('admin.tallas.create') }}" class="text-tinta underline">Crear una</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
