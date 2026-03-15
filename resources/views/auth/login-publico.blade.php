<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión · Sofis Tienda de Modas</title>
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
        </div>

        <div class="card p-8">
            <h1 class="font-display text-2xl text-center mb-1">Bienvenida/o</h1>
            <p class="text-center text-sm text-gris mb-6">Inicia sesión en tu cuenta</p>

            @if (session('error'))
                <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    {{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
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

                <div>
                    <label for="password"
                        class="block text-xs tracking-widest uppercase text-gris mb-1.5">Contraseña</label>
                    <input id="password" name="password" type="password" required class="input"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer text-sm text-gris">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-borde">
                        Recordarme
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full mt-1">Iniciar sesión</button>
            </form>

            <p class="mt-5 text-center text-sm text-gris">
                ¿No tienes cuenta?
                <a href="{{ route('registro') }}" class="text-tinta font-semibold hover:underline">Regístrate gratis</a>
            </p>
        </div>

        <p class="text-center mt-5 text-xs text-gris">
            <a href="{{ route('home') }}" class="hover:text-tinta transition">← Volver a la tienda</a>
        </p>

    </div>
</body>

</html>
