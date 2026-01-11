@extends('layouts.app')

@section('title', 'Nosotros | Tienda')

@section('content')

    {{-- HERO / INTRO --}}
    <section class="card overflow-hidden">
        <div class="p-6 sm:p-10">
            <p class="text-xs tracking-[0.25em] uppercase text-gris">Sofis Tienda de Modas</p>

            <h1 class="mt-3 font-display text-3xl sm:text-4xl md:text-5xl leading-[1.05]">
                Moda, calzado y estilo<br class="hidden sm:block"> para cada día.
            </h1>

            <p class="mt-4 text-gris max-w-2xl text-base sm:text-lg leading-relaxed">
                Somos una tienda enfocada en ofrecer piezas con diseño, comodidad y excelente relación calidad/precio.
                Nuestra misión es que encuentres moda para tu estilo, sin complicarte.
            </p>

            <div class="mt-6 flex flex-wrap gap-2">
                <span class="badge">Ropa</span>
                <span class="badge">Calzado</span>
                <span class="badge">Accesorios</span>
                <span class="badge">Mixto</span>
            </div>
        </div>

        <div class="h-1 w-full bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600"></div>
    </section>

    {{-- SECCIÓN: MISIÓN / VISIÓN / VALORES --}}
    <section class="mt-10">
        <div class="flex items-end justify-between gap-6 flex-wrap">
            <div>
                <h2 class="font-display text-2xl sm:text-3xl">Lo que nos mueve</h2>
                <p class="mt-2 text-gris max-w-xl">
                    Nuestro enfoque está en una experiencia simple, una selección cuidada y atención cercana.
                </p>
            </div>

            {{-- <a href="{{ route('contacto') }}" class="btn-primary">
            Contáctanos
        </a> --}}
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Misión --}}
            <article class="card p-6">
                <div class="flex items-center gap-3">
                    <span class="badge">Misión</span>
                </div>

                <h3 class="mt-4 font-display text-xl">
                    Calidad y estilo accesible
                </h3>

                <p class="mt-3 text-sm text-gris leading-relaxed">
                    Ofrecer productos con excelente relación calidad/precio, cuidando el diseño y la comodidad en cada
                    pieza.
                </p>
            </article>

            {{-- Visión --}}
            <article class="card p-6">
                <div class="flex items-center gap-3">
                    <span class="badge">Visión</span>
                </div>

                <h3 class="mt-4 font-display text-xl">
                    Ser una marca reconocida
                </h3>

                <p class="mt-3 text-sm text-gris leading-relaxed">
                    Convertirnos en una tienda de referencia en moda y calzado, con una experiencia digital moderna y
                    cercana.
                </p>
            </article>

            {{-- Valores --}}
            <article class="card p-6">
                <div class="flex items-center gap-3">
                    <span class="badge">Valores</span>
                </div>

                <h3 class="mt-4 font-display text-xl">
                    Confianza y atención al cliente
                </h3>

                <p class="mt-3 text-sm text-gris leading-relaxed">
                    Calidad, honestidad, servicio y compromiso. Queremos que comprar aquí sea sencillo y agradable.
                </p>
            </article>
        </div>
    </section>

    {{-- SECCIÓN: DIFERENCIA / PROMESA --}}
    <section class="mt-10 card p-6 sm:p-10">
        <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
            <div>
                <h2 class="font-display text-2xl sm:text-3xl">
                    Nuestra promesa
                </h2>

                <p class="mt-3 text-gris leading-relaxed">
                    Seleccionamos prendas y calzado pensando en durabilidad, comodidad y estilo.
                    Estamos enfocados en que encuentres lo que necesitas con rapidez, desde tu móvil.
                </p>
                <li class="flex gap-3">
                    <span class="text-pink-500 font-bold">✓</span>
                    Moda mixta, calzado y accesorios.
                </li>
                <li class="flex gap-3">
                    <span class="text-pink-500 font-bold">✓</span>
                    Atención directa por WhatsApp.
                </li>
                </ul>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('catalogo') }}" class="btn-primary">Ver catálogo</a>
                    {{-- <a href="{{ route('contacto') }}" class="btn-ghost">Hablar con nosotros</a> --}}
                </div>
            </div>

            {{-- Imagen placeholder (puedes cambiarla) --}}
            <div class="card overflow-hidden">
                <img src="https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop"
                    alt="Moda Sofis Tienda" class="w-full h-[260px] sm:h-[320px] lg:h-[360px] object-cover" loading="lazy">
            </div>
        </div>
    </section>

@endsection
