<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta · Sofis Tienda de Modas</title>
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
            <h1 class="font-display text-2xl text-center mb-1">Crear cuenta</h1>
            <p class="text-center text-sm text-gris mb-6">Únete a Sofis y guarda tus favoritos</p>

            <form method="POST" action="{{ route('registro.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="input @error('name') border-red-400 @enderror" placeholder="Tu nombre">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="input @error('email') border-red-400 @enderror" placeholder="tu@correo.com">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Contraseña</label>
                    <input type="password" name="password" required
                        class="input @error('password') border-red-400 @enderror" placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" required class="input"
                        placeholder="Repite tu contraseña">
                </div>

                <button type="submit" class="btn-primary w-full mt-1">Crear mi cuenta</button>
            </form>

            <p class="mt-5 text-center text-sm text-gris">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-tinta font-semibold hover:underline">Inicia sesión</a>
            </p>
        </div>

        <p class="text-center mt-5 text-xs text-gris">
            <a href="{{ route('home') }}" class="hover:text-tinta transition">← Volver a la tienda</a>
        </p>

    </div>
</body>

</html>
