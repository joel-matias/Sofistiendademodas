@extends('admin.layouts.app')
@section('title', 'Nueva sucursal')
@section('page_title', 'Nueva sucursal')
@section('page_subtitle', 'Agregar una nueva sucursal')

@section('content')
    <div class="max-w-lg">
        <a href="{{ route('admin.sucursales.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver
        </a>

        <form method="POST" action="{{ route('admin.sucursales.store') }}" class="card p-6 space-y-5">
            @csrf

            <h2 class="font-display text-lg border-b border-borde pb-3">Información de la sucursal</h2>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                    class="input @error('nombre') border-red-400 @enderror"
                    placeholder="Ej: Sucursal Centro">
                @error('nombre')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Dirección</label>
                <input type="text" name="direccion" value="{{ old('direccion') }}"
                    class="input @error('direccion') border-red-400 @enderror"
                    placeholder="Ej: Av. Juárez 123, Col. Centro">
                @error('direccion')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                        class="input @error('telefono') border-red-400 @enderror"
                        placeholder="Ej: 312-123-4567">
                    @error('telefono')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Horario</label>
                    <input type="text" name="horario" value="{{ old('horario') }}"
                        class="input @error('horario') border-red-400 @enderror"
                        placeholder="Ej: Lun–Sáb 10:00–20:00">
                    @error('horario')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="activa" value="0">
                <input type="checkbox" name="activa" value="1" {{ old('activa', true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-borde text-tinta">
                <span class="text-sm">Sucursal activa (visible en los productos)</span>
            </label>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Crear sucursal</button>
                <a href="{{ route('admin.sucursales.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
