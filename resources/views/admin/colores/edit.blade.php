@extends('admin.layouts.app')
@section('title', 'Editar color')
@section('page_title', 'Editar color')
@section('page_subtitle', $color->nombre)

@section('content')
    <div class="max-w-sm">
        <a href="{{ route('admin.colores.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver
        </a>
        <form method="POST" action="{{ route('admin.colores.update', $color) }}" class="card p-6 space-y-5">
            @csrf @method('PUT')
            <h2 class="font-display text-lg border-b border-borde pb-3">Editar color</h2>
            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre', $color->nombre) }}" required
                    class="input @error('nombre') border-red-400 @enderror">
                @error('nombre')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Color HEX</label>
                <div class="flex gap-3 items-center">
                    <input type="color" name="hex_picker" value="{{ old('hex', $color->hex ?? '#000000') }}"
                        oninput="document.getElementById('hex_input_edit').value = this.value"
                        class="w-10 h-10 rounded-lg border border-borde cursor-pointer p-1">
                    <input type="text" name="hex" id="hex_input_edit" value="{{ old('hex', $color->hex) }}"
                        placeholder="#000000" maxlength="7"
                        class="input flex-1 font-mono text-sm @error('hex') border-red-400 @enderror"
                        oninput="if(this.value.match(/^#[0-9a-fA-F]{6}$/)) document.querySelector('input[name=hex_picker]').value = this.value">
                </div>
                @error('hex')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Actualizar</button>
                <a href="{{ route('admin.colores.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
