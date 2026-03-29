@extends('admin.layouts.app')
@section('title', 'Nueva talla')
@section('page_title', 'Nueva talla')

@section('content')
    <div class="max-w-lg">
        <a href="{{ route('admin.tallas.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver
        </a>

        <form method="POST" action="{{ route('admin.tallas.store') }}" class="card p-6 space-y-6">
            @csrf

            {{-- ── Identificación ──────────────────────────────────────────── --}}
            <div>
                <h2 class="font-display text-lg border-b border-borde pb-3 mb-4">Identificación</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">
                            Nombre *
                        </label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required
                            class="input @error('nombre') border-red-400 @enderror"
                            placeholder="Ej: M, G, XL, 36…">
                        @error('nombre')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">
                            Orden en guía
                        </label>
                        <input type="number" name="orden" value="{{ old('orden', 0) }}"
                            min="0" max="999"
                            class="input @error('orden') border-red-400 @enderror">
                        <p class="mt-1 text-xs text-gris/70">Número más bajo aparece primero en la guía.</p>
                        @error('orden')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── Medidas para la guía de tallas ──────────────────────────── --}}
            <div>
                <h2 class="font-display text-lg border-b border-borde pb-3 mb-1">
                    Medidas para la guía de tallas
                </h2>
                <p class="text-xs text-gris mb-4">
                    Valores simples (<code class="bg-gray-100 px-1 rounded">86</code>) o rangos
                    (<code class="bg-gray-100 px-1 rounded">86-90</code>), todos en cm.
                    Dejar vacío si no aplica.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">
                            Pecho (cm)
                        </label>
                        <input type="text" name="pecho" value="{{ old('pecho') }}"
                            class="input @error('pecho') border-red-400 @enderror"
                            placeholder="Ej: 86-90">
                        @error('pecho') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">
                            Cintura (cm)
                        </label>
                        <input type="text" name="cintura" value="{{ old('cintura') }}"
                            class="input @error('cintura') border-red-400 @enderror"
                            placeholder="Ej: 68-72">
                        @error('cintura') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">
                            Cadera (cm)
                        </label>
                        <input type="text" name="cadera" value="{{ old('cadera') }}"
                            class="input @error('cadera') border-red-400 @enderror"
                            placeholder="Ej: 93-97">
                        @error('cadera') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">
                            Largo (cm)
                        </label>
                        <input type="text" name="largo" value="{{ old('largo') }}"
                            class="input @error('largo') border-red-400 @enderror"
                            placeholder="Ej: 95-100">
                        @error('largo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Crear talla</button>
                <a href="{{ route('admin.tallas.index') }}" class="btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
