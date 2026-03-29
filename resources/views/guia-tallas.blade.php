@extends('layouts.app')

@section('title', 'Guía de Tallas | ' . config('seo.site_name'))
@section('description', 'Consulta nuestra guía de tallas para encontrar la medida perfecta. Pecho, cintura, cadera y largo en centímetros.')
@section('canonical', route('guia-tallas'))

@section('content')
<div class="container-full pt-8 sm:pt-12 pb-16">

    {{-- Encabezado --}}
    <div class="max-w-2xl mb-10">
        <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-2">Ayuda</p>
        <h1 class="section-title mb-3">Guía de tallas</h1>
        <p class="text-gris text-sm sm:text-base leading-relaxed">
            Todas las medidas están en centímetros (cm). Para una mejor experiencia,
            mídete con una cinta métrica flexible y compara con la tabla.
        </p>
    </div>

    {{-- Cómo medirte --}}
    <div class="grid sm:grid-cols-3 gap-4 mb-12">
        @foreach ([
            ['svg' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'titulo' => 'Pecho', 'desc' => 'Mide la parte más ancha del pecho, pasando la cinta por encima de los senos.'],
            ['svg' => 'M4 6h16M4 12h16M4 18h16', 'titulo' => 'Cintura', 'desc' => 'Mide la parte más estrecha de tu torso, generalmente encima del ombligo.'],
            ['svg' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'titulo' => 'Cadera', 'desc' => 'Mide la parte más ancha de tus caderas, a unos 20 cm por debajo de la cintura.'],
        ] as $paso)
            <div class="flex gap-4 p-4 rounded-2xl border border-borde bg-white">
                <div class="w-10 h-10 rounded-xl bg-tinta/5 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-tinta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5" d="{{ $paso['svg'] }}" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-sm text-tinta mb-0.5">{{ $paso['titulo'] }}</p>
                    <p class="text-xs text-gris leading-relaxed">{{ $paso['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Tabla de medidas --}}
    @if ($tallas->isEmpty())

        {{-- Estado vacío: admin aún no ha cargado medidas --}}
        <div class="max-w-md mx-auto text-center py-16 px-6 rounded-2xl border border-borde bg-white">
            <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-tinta font-medium mb-1">Guía en preparación</p>
            <p class="text-sm text-gris mb-5">
                Estamos cargando la información de tallas. Mientras tanto, escríbenos y con gusto te asesoramos.
            </p>
            @if (config('seo.whatsapp'))
                <a href="https://wa.me/{{ config('seo.whatsapp') }}?text={{ urlencode('Hola, necesito ayuda con las tallas.') }}"
                    target="_blank" rel="noopener"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#25D366]
                           text-white text-sm font-medium hover:bg-[#1ebe5d] transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Consultar por WhatsApp
                </a>
            @endif
        </div>

    @else

        {{-- Tabla desktop --}}
        <div class="hidden sm:block overflow-x-auto rounded-2xl border border-borde shadow-suave">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-tinta text-crema">
                        <th class="px-6 py-4 text-left text-[11px] tracking-[0.15em] uppercase font-semibold">
                            Talla
                        </th>
                        <th class="px-6 py-4 text-center text-[11px] tracking-[0.15em] uppercase font-semibold">
                            Pecho (cm)
                        </th>
                        <th class="px-6 py-4 text-center text-[11px] tracking-[0.15em] uppercase font-semibold">
                            Cintura (cm)
                        </th>
                        <th class="px-6 py-4 text-center text-[11px] tracking-[0.15em] uppercase font-semibold">
                            Cadera (cm)
                        </th>
                        @if ($mostrarLargo)
                            <th class="px-6 py-4 text-center text-[11px] tracking-[0.15em] uppercase font-semibold">
                                Largo (cm)
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-borde bg-white">
                    @foreach ($tallas as $talla)
                        <tr class="hover:bg-crema transition">
                            <td class="px-6 py-4 font-bold text-tinta text-base">
                                {{ strtoupper($talla->nombre) }}
                            </td>
                            <td class="px-6 py-4 text-center text-gris">
                                {{ $talla->pecho ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-center text-gris">
                                {{ $talla->cintura ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-center text-gris">
                                {{ $talla->cadera ?? '—' }}
                            </td>
                            @if ($mostrarLargo)
                                <td class="px-6 py-4 text-center text-gris">
                                    {{ $talla->largo ?? '—' }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Cards mobile --}}
        <div class="sm:hidden space-y-3">
            @foreach ($tallas as $talla)
                <div class="rounded-2xl border border-borde bg-white p-4">
                    <p class="font-bold text-tinta text-lg mb-3">{{ strtoupper($talla->nombre) }}</p>
                    <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-sm">
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-gris block mb-0.5">Pecho</span>
                            <span class="font-medium">{{ $talla->pecho ?? '—' }} cm</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-gris block mb-0.5">Cintura</span>
                            <span class="font-medium">{{ $talla->cintura ?? '—' }} cm</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-gris block mb-0.5">Cadera</span>
                            <span class="font-medium">{{ $talla->cadera ?? '—' }} cm</span>
                        </div>
                        @if ($mostrarLargo)
                            <div>
                                <span class="text-[10px] uppercase tracking-widest text-gris block mb-0.5">Largo</span>
                                <span class="font-medium">{{ $talla->largo ?? '—' }} cm</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Nota de consulta --}}
        @if (config('seo.whatsapp'))
            <div class="mt-8 flex flex-col sm:flex-row items-start sm:items-center gap-4
                        p-5 rounded-2xl bg-tinta/5 border border-borde">
                <div class="flex-1">
                    <p class="text-sm font-medium text-tinta mb-0.5">¿Tienes dudas con tu talla?</p>
                    <p class="text-xs text-gris">Escríbenos por WhatsApp y te ayudamos a elegir la talla perfecta.</p>
                </div>
                <a href="https://wa.me/{{ config('seo.whatsapp') }}?text={{ urlencode('Hola, necesito ayuda para elegir mi talla.') }}"
                    target="_blank" rel="noopener"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#25D366]
                           text-white text-sm font-medium hover:bg-[#1ebe5d] transition whitespace-nowrap">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Consultar por WhatsApp
                </a>
            </div>
        @endif

    @endif

</div>
@endsection
