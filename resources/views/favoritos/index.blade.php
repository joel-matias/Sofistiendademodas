@extends('layouts.app')

@section('title', 'Mis favoritos · Sofis Tienda de Modas')

@section('content')

    <div class="container-full pt-8 sm:pt-12 pb-10">

        <div class="mb-8">
            <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-1">Mi cuenta</p>
            <h1 class="section-title flex items-center gap-3">
                Mis favoritos
                @if (count($productos) > 0)
                    <span class="text-base font-normal text-gris">({{ count($productos) }})</span>
                @endif
            </h1>
        </div>

        @if (session('success'))
            <div class="mb-6 p-3 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (count($productos) > 0)
            <div class="grid gap-x-4 gap-y-8 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($productos as $producto)
                    <x-product-card :producto="$producto" />
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('catalogo') }}" class="btn-ghost">Seguir explorando</a>
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <p class="font-display text-xl mb-2">Aún no tienes favoritos</p>
                <p class="text-gris text-sm mb-6">Explora el catálogo y guarda los productos que más te gusten.</p>
                <a href="{{ route('catalogo') }}" class="btn-primary">Explorar catálogo</a>
            </div>
        @endif

    </div>

@endsection
