<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva contraseña · Sofis Tienda de Modas</title>
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
            <h1 class="font-display text-2xl text-center mb-1">Nueva contraseña</h1>
            <p class="text-center text-sm text-gris mb-6">Elige una contraseña segura para tu cuenta.</p>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4" id="formReset">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-xs tracking-widest uppercase text-gris mb-1.5">Correo
                        electrónico</label>
                    <input id="email" name="email" type="email" value="{{ old('email', request('email')) }}" required
                        autofocus class="input @error('email') border-red-400 @enderror" placeholder="tu@correo.com">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nueva
                        contraseña</label>
                    <input id="password" name="password" type="password" required
                        class="input @error('password') border-red-400 @enderror"
                        placeholder="Mínimo 8 caracteres"
                        oninput="validarPasswords()">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation"
                        class="block text-xs tracking-widest uppercase text-gris mb-1.5">Confirmar
                        contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="input" placeholder="Repite la nueva contraseña"
                        oninput="validarPasswords()">
                    <p id="errorConfirmacion" class="mt-1 text-xs text-red-600 hidden">Las contraseñas no coinciden.</p>
                </div>

                <button type="submit" class="btn-primary w-full mt-1">Restablecer contraseña</button>
            </form>
        </div>

        <p class="text-center mt-5 text-xs text-gris">
            <a href="{{ route('home') }}" class="hover:text-tinta transition">← Volver a la tienda</a>
        </p>

    </div>

    <script>
        function validarPasswords() {
            const password = document.getElementById('password').value;
            const confirmacion = document.getElementById('password_confirmation').value;
            const error = document.getElementById('errorConfirmacion');
            const inputConfirm = document.getElementById('password_confirmation');

            if (confirmacion.length === 0) {
                error.classList.add('hidden');
                inputConfirm.classList.remove('border-red-400');
                return;
            }

            if (password !== confirmacion) {
                error.classList.remove('hidden');
                inputConfirm.classList.add('border-red-400');
            } else {
                error.classList.add('hidden');
                inputConfirm.classList.remove('border-red-400');
            }
        }

        document.getElementById('formReset').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirmacion = document.getElementById('password_confirmation').value;

            if (password !== confirmacion) {
                e.preventDefault();
                document.getElementById('errorConfirmacion').classList.remove('hidden');
                document.getElementById('password_confirmation').classList.add('border-red-400');
                document.getElementById('password_confirmation').focus();
            }
        });
    </script>

</body>

</html>
