@extends('layouts.app')

@section('title', 'Nosotros | Sofis Tienda de Modas')

@section('content')

    <section class="w-full bg-tinta text-crema">
        <div class="container-full pt-16 sm:pt-24 pb-16 sm:pb-20 grid lg:grid-cols-2 gap-10 items-center">
            <div>
                <p class="text-[11px] tracking-[0.2em] uppercase text-white/50 mb-4">Sobre nosotros</p>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl leading-tight">
                    Somos Sofis<br>
                    <em class="not-italic text-white/70">Tienda de Modas</em>
                </h1>
                <p class="mt-6 text-white/70 text-base sm:text-lg leading-relaxed max-w-lg">
                    Desde nuestra apertura, hemos sido el destino favorito para quienes buscan moda accesible, calidad y
                    estilo en un solo lugar.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <span class="badge border-white/20 text-white/70">Ropa</span>
                    <span class="badge border-white/20 text-white/70">Calzado</span>
                    <span class="badge border-white/20 text-white/70">Accesorios</span>
                    <span class="badge border-white/20 text-white/70">Mixto</span>
                </div>
            </div>
            <div class="hidden lg:block h-[320px] rounded-2xl overflow-hidden border border-white/10">
                <img src="{{ asset('assets/img/hero.jpg') }}" alt="Sofis Tienda de Modas"
                    class="w-full h-full object-cover opacity-80">
            </div>
        </div>
    </section>

    <section class="container-full mt-16 sm:mt-20">
        <div class="text-center mb-10">
            <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-2">Nuestra esencia</p>
            <h2 class="section-title">Lo que nos mueve</h2>
        </div>
        <div class="grid sm:grid-cols-3 gap-5">
            @foreach ([['title' => 'Misión', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'body' => 'Ofrecer ropa, calzado y accesorios de calidad a precios accesibles para que cada persona exprese su estilo sin límites.'], ['title' => 'Visión', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'body' => 'Ser la marca de moda de referencia en nuestra región, reconocida por su calidad, atención y compromiso con nuestros clientes.'], ['title' => 'Valores', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'body' => 'Confianza, honestidad y atención personalizada. Cada cliente es único y merece una experiencia de compra excepcional.']] as $item)
                <div class="card p-7">
                    <div class="w-10 h-10 rounded-xl bg-tinta flex items-center justify-center mb-5">
                        <svg class="w-5 h-5 text-crema" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3">{{ $item['title'] }}</h3>
                    <p class="text-gris text-sm leading-relaxed">{{ $item['body'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container-full mt-16 sm:mt-20 mb-6">
        <div class="card overflow-hidden">
            <div class="grid lg:grid-cols-2">
                <div class="p-8 sm:p-12 flex flex-col justify-center">
                    <p class="text-[11px] tracking-[0.2em] uppercase text-gris mb-3">Nuestra promesa</p>
                    <h2 class="font-display text-3xl sm:text-4xl leading-tight">Calidad que puedes sentir</h2>
                    <p class="mt-4 text-gris leading-relaxed">
                        Cada pieza en nuestro catálogo pasa por una selección cuidadosa para asegurarte el mejor diseño y
                        durabilidad. Tu satisfacción es nuestra mayor recompensa.
                    </p>
                    <a href="{{ route('catalogo') }}" class="btn-primary mt-8 self-start">Explorar catálogo</a>
                </div>
                <div class="h-64 lg:h-auto bg-gray-100">
                    <img src="{{ asset('assets/img/hero.jpg') }}" alt="Calidad" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

@endsection
