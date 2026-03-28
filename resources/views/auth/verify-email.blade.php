<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo · Sofis Tienda de Modas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-crema flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-sm">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/svg/logo-sofistiendademodas.svg') }}" alt="Sofis"
                    class="h-14 mx-auto object-contain">
            </a>
            <p class="mt-2 text-[10px] tracking-[0.25em] uppercase text-gris/60">Tu tienda de moda</p>
        </div>

        <div class="card p-8 text-center">
            <div class="w-8 h-px bg-moda mx-auto mb-5"></div>

            {{-- Ícono correo --}}
            <div class="w-14 h-14 rounded-full bg-moda/10 flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-moda" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <h1 class="font-display text-2xl mb-2">Verifica tu correo</h1>
            <p class="text-sm text-gris mb-6 leading-relaxed">
                Te enviamos un enlace de verificación a <span class="font-medium text-tinta">{{ auth()->user()->email }}</span>.
                Revisa tu bandeja de entrada (y la carpeta de spam).
            </p>

            @if (session('resent'))
                <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700">
                    Correo reenviado. Revisa tu bandeja de entrada.
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full">
                    Reenviar correo de verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-sm text-gris hover:text-tinta transition underline underline-offset-2">
                    Cerrar sesión
                </button>
            </form>
        </div>

        <p class="text-center mt-5 text-xs text-gris">
            <a href="{{ route('home') }}" class="hover:text-tinta transition">← Volver a la tienda</a>
        </p>

    </div>
</body>

</html>
