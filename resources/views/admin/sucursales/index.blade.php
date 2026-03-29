@extends('admin.layouts.app')
@section('title', 'Sucursales')
@section('page_title', 'Sucursales')
@section('page_subtitle', 'Gestión de sucursales de la tienda')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gris">{{ $sucursales->count() }} {{ $sucursales->count() === 1 ? 'sucursal' : 'sucursales' }}</p>
        <a href="{{ route('admin.sucursales.create') }}" class="btn-primary text-sm">+ Nueva sucursal</a>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- Cards en móvil --}}
    <div class="grid gap-3 sm:hidden">
        @forelse($sucursales as $sucursal)
            <div class="card p-4">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <p class="font-semibold">{{ $sucursal->nombre }}</p>
                    <span class="flex-shrink-0 text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full
                        {{ $sucursal->activa ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gris' }}">
                        {{ $sucursal->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
                @if ($sucursal->direccion)
                    <p class="text-xs text-gris mb-0.5">{{ $sucursal->direccion }}</p>
                @endif
                @if ($sucursal->horario)
                    <p class="text-xs text-gris mb-0.5">{{ $sucursal->horario }}</p>
                @endif
                <p class="text-xs text-gris mb-3">{{ $sucursal->productos_count }} productos asignados</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.sucursales.edit', $sucursal) }}"
                       class="flex-1 text-center px-2 py-1.5 rounded-lg text-xs font-medium text-gris hover:text-tinta hover:bg-gray-100 transition border border-borde">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.sucursales.destroy', $sucursal) }}"
                          onsubmit="return confirm('¿Eliminar la sucursal {{ $sucursal->nombre }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-2 py-1.5 rounded-lg text-xs font-medium text-red-400 hover:text-red-600 hover:bg-red-50 transition border border-red-100">
                            ✕
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gris">
                No hay sucursales.
                <a href="{{ route('admin.sucursales.create') }}" class="text-tinta underline ml-1">Crear una</a>
            </div>
        @endforelse
    </div>

    {{-- Tabla en desktop --}}
    <div class="card overflow-hidden hidden sm:block">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-borde bg-gray-50">
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Nombre</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden md:table-cell">Dirección</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden lg:table-cell">Horario</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden lg:table-cell">Productos</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Estado</th>
                        <th class="px-5 py-3 text-right text-xs uppercase tracking-widest text-gris font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-borde">
                    @forelse($sucursales as $sucursal)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium">{{ $sucursal->nombre }}</td>
                            <td class="px-5 py-3 text-gris hidden md:table-cell">{{ $sucursal->direccion ?? '—' }}</td>
                            <td class="px-5 py-3 text-gris hidden lg:table-cell">{{ $sucursal->horario ?? '—' }}</td>
                            <td class="px-5 py-3 text-gris hidden lg:table-cell">{{ $sucursal->productos_count }}</td>
                            <td class="px-5 py-3">
                                <span class="text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full
                                    {{ $sucursal->activa ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gris' }}">
                                    {{ $sucursal->activa ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.sucursales.edit', $sucursal) }}"
                                       class="text-xs text-gris hover:text-tinta transition font-medium">Editar</a>
                                    <form method="POST" action="{{ route('admin.sucursales.destroy', $sucursal) }}"
                                          onsubmit="return confirm('¿Eliminar la sucursal {{ $sucursal->nombre }}?')">
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
                                No hay sucursales.
                                <a href="{{ route('admin.sucursales.create') }}" class="text-tinta underline">Crear una</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
