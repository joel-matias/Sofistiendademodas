@extends('admin.layouts.app')
@section('title', 'Covers del Hero')
@section('page_title', 'Covers del Hero')
@section('page_subtitle', 'Carrusel de la portada')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div>
            <p class="text-sm text-gris">
                {{ $covers->count() }} {{ $covers->count() === 1 ? 'cover' : 'covers' }}
                @if($covers->count() > 1)
                    · <span class="text-tinta font-medium">Arrastra para reordenar</span>
                @endif
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span id="sortStatus" class="hidden text-xs font-medium transition"></span>
            <a href="{{ route('admin.covers.create') }}" class="btn-primary text-sm">+ Nuevo cover</a>
        </div>
    </div>

    @if($covers->isEmpty())
        <div class="card p-10 text-center text-gris">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="mb-3">No hay covers.</p>
            <a href="{{ route('admin.covers.create') }}" class="btn-primary text-sm">Crear el primero</a>
        </div>
    @else
        <div id="sortableCovers" class="space-y-2.5">
            @foreach($covers as $cover)
                <div class="card p-3 sm:p-4 flex items-center gap-3 select-none transition-shadow"
                     data-id="{{ $cover->id }}">

                    {{-- Drag handle --}}
                    <div class="drag-handle flex-shrink-0 p-1.5 rounded-lg cursor-grab active:cursor-grabbing
                                text-gray-300 hover:text-gris hover:bg-gray-100 transition touch-manipulation"
                         title="Arrastrar para reordenar">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM13 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7 8a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM13 8a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7 14a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM13 14a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                        </svg>
                    </div>

                    {{-- Thumbnail --}}
                    <div class="flex-shrink-0">
                        @if($cover->imagen)
                            <img src="{{ str_starts_with($cover->imagen, 'http') ? $cover->imagen : Storage::url($cover->imagen) }}"
                                 alt="{{ $cover->titulo }}"
                                 class="w-16 h-10 sm:w-24 sm:h-14 object-cover rounded-lg border border-borde bg-gray-100">
                        @else
                            <div class="w-16 h-10 sm:w-24 sm:h-14 rounded-lg bg-gray-100 border border-borde
                                        flex items-center justify-center text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-tinta truncate">{{ $cover->titulo }}</p>
                        @if($cover->subtitulo)
                            <p class="text-xs text-gris truncate hidden sm:block mt-0.5">{{ $cover->subtitulo }}</p>
                        @endif
                        @if($cover->texto_boton)
                            <p class="text-[10px] text-gris/60 hidden md:block mt-0.5">
                                Botón: "{{ $cover->texto_boton }}"
                            </p>
                        @endif
                    </div>

                    {{-- Status + order --}}
                    <div class="hidden sm:flex items-center gap-2 flex-shrink-0">
                        <span class="order-num text-[10px] font-mono text-gris bg-gray-100 px-2 py-0.5 rounded">
                            #{{ $loop->iteration }}
                        </span>
                        <span class="text-[11px] font-medium px-2.5 py-0.5 rounded-full
                            {{ $cover->activo
                                ? 'text-green-700 bg-green-50 border border-green-200'
                                : 'text-gray-500 bg-gray-100 border border-gray-200' }}">
                            {{ $cover->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-1 flex-shrink-0">
                        {{-- Mobile: status dot --}}
                        <span class="sm:hidden w-2 h-2 rounded-full flex-shrink-0
                            {{ $cover->activo ? 'bg-green-500' : 'bg-gray-300' }}"
                              title="{{ $cover->activo ? 'Activo' : 'Inactivo' }}"></span>

                        <a href="{{ route('admin.covers.edit', $cover) }}"
                           class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                  text-gris hover:text-tinta hover:bg-gray-100 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span class="hidden sm:inline">Editar</span>
                        </a>

                        <form method="POST" action="{{ route('admin.covers.destroy', $cover) }}"
                              onsubmit="return confirm('¿Eliminar este cover?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                           text-red-400 hover:text-red-600 hover:bg-red-50 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span class="hidden sm:inline">Eliminar</span>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        @if($covers->count() > 1)
            <p class="mt-3 text-xs text-gris text-center">
                Arrastra los covers para cambiar el orden en que aparecen en el carrusel.
            </p>
        @endif
    @endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
(function () {
    const container = document.getElementById('sortableCovers');
    const statusEl  = document.getElementById('sortStatus');
    if (!container || !statusEl) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    function showStatus(msg, color) {
        statusEl.textContent = msg;
        statusEl.className   = `text-xs font-medium transition ${color}`;
        statusEl.classList.remove('hidden');
    }

    function hideStatus() {
        statusEl.classList.add('hidden');
    }

    new Sortable(container, {
        handle:     '.drag-handle',
        animation:  200,
        ghostClass: 'opacity-40',
        dragClass:  'shadow-lg',

        onEnd() {
            // Collect new order
            const items = [...container.querySelectorAll('[data-id]')].map((el, idx) => ({
                id:    parseInt(el.dataset.id),
                orden: idx,
            }));

            // Update visual order indicators
            container.querySelectorAll('.order-num').forEach((el, i) => {
                el.textContent = `#${i + 1}`;
            });

            showStatus('Guardando…', 'text-gris');

            fetch('{{ route('admin.covers.reorder') }}', {
                method:  'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                },
                body: JSON.stringify({ orden: items }),
            })
            .then(r => {
                if (!r.ok) throw new Error();
                showStatus('Orden guardado ✓', 'text-green-600');
                setTimeout(hideStatus, 2500);
            })
            .catch(() => {
                showStatus('Error al guardar', 'text-red-500');
            });
        },
    });
})();
</script>
@endpush
