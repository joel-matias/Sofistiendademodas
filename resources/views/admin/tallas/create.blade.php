@extends('admin.layouts.app')
@section('title', 'Nueva talla')
@section('page_title', 'Nueva talla')

@section('content')
    <div class="max-w-sm">
        <a href="{{ route('admin.tallas.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver
        </a>
        <form method="POST" action="{{ route('admin.tallas.store') }}" class="card p-6 space-y-5">
            @csrf
            <h2 class="font-display text-lg border-b border-borde pb-3">Nueva talla</h2>
            <div>
                <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                    class="input @error('nombre') border-red-400 @enderror" placeholder="Ej: M, G, XL, 36...">
                @error('nombre')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Crear talla</button>
                <a href="{{ route('admin.tallas.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
