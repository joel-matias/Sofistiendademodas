<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · Sofis Tienda de Modas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-crema flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Sofis Tienda de Modas"
                    class="h-16 mx-auto object-contain">
            </a>
            <p class="mt-3 text-xs tracking-[0.25em] uppercase text-gris">Panel de Administración</p>
        </div>

        {{-- Card --}}
        <div class="card p-8">
            <h1 class="font-display text-2xl text-center mb-6">Iniciar sesión</h1>

            @if (session('error'))
                <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs tracking-widest uppercase text-gris mb-1.5">Correo
                        electrónico</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="input @error('email') border-red-400 @enderror" placeholder="admin@ejemplo.com">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password"
                        class="block text-xs tracking-widest uppercase text-gris mb-1.5">Contraseña</label>
                    <input id="password" name="password" type="password" required
                        class="input @error('password') border-red-400 @enderror" placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox"
                        class="w-4 h-4 rounded border-borde text-tinta">
                    <label for="remember" class="text-sm text-gris">Recordarme</label>
                </div>

                <button type="submit" class="btn-primary w-full mt-2">
                    Entrar al panel
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-xs text-gris">
            <a href="{{ route('home') }}" class="hover:text-tinta transition">← Volver a la tienda</a>
        </p>

    </div>
</body>

</html>
