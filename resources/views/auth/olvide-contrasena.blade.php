<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña · Sofis Tienda de Modas</title>
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
                <img src="{{ asset('assets/img/logo.png') }}" alt="Sofis"
                    class="h-14 mx-auto object-contain">
            </a>
            <p class="mt-2 text-[10px] tracking-[0.25em] uppercase text-gris/60">Tu tienda de moda</p>
        </div>

        <div class="card p-8">
            <div class="w-8 h-px bg-moda mx-auto mb-5"></div>
            <h1 class="font-display text-2xl text-center mb-1">Recuperar contraseña</h1>
            <p class="text-center text-sm text-gris mb-6 leading-relaxed">
                Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.
            </p>

            @if (session('status'))
                <div class="mb-5 p-4 rounded-xl bg-green-50 border border-green-100 text-sm text-green-700 text-center leading-relaxed">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs tracking-widest uppercase text-gris mb-1.5">Correo
                        electrónico</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="input @error('email') border-red-400 @enderror" placeholder="tu@correo.com">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full mt-1">Enviar enlace</button>
            </form>

            <p class="mt-5 text-center text-sm text-gris">
                <a href="{{ route('login') }}" class="text-tinta font-semibold hover:underline">← Volver al inicio de sesión</a>
            </p>
        </div>

        <p class="text-center mt-5 text-xs text-gris">
            <a href="{{ route('home') }}" class="hover:text-tinta transition">← Volver a la tienda</a>
        </p>

    </div>

</body>

</html>
