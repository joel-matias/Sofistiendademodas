@extends('layouts.app')

@section('title', 'Mi cuenta · Sofis Tienda de Modas')

@section('content')
    <div class="min-h-screen bg-crema">

        {{-- Hero encabezado --}}
        <div class="bg-white border-b border-borde">
            <div class="max-w-2xl mx-auto px-4 py-10 flex flex-col sm:flex-row items-center gap-5">
                <div
                    class="w-16 h-16 rounded-full bg-tinta text-crema text-2xl font-semibold flex items-center justify-center flex-shrink-0 shadow-md">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-[10px] tracking-[0.25em] uppercase text-gris mb-1">Mi cuenta</p>
                    <h1 class="font-display text-2xl sm:text-3xl text-tinta leading-tight">
                        {{ auth()->user()->name }}
                    </h1>
                    <p class="text-sm text-gris mt-0.5">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <div class="max-w-2xl mx-auto px-4 py-8 space-y-5">

            {{-- Información personal --}}
            <div class="card overflow-hidden">
                <div class="flex items-center gap-3 px-7 py-4 border-b border-borde bg-white/60">
                    <div class="w-7 h-7 rounded-lg bg-tinta/8 flex items-center justify-center">
                        <svg class="w-4 h-4 text-tinta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-xs tracking-[0.2em] uppercase text-tinta font-semibold">Información personal</h2>
                </div>

                <div class="p-7">
                    <form method="POST" action="{{ route('perfil.update.info') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nombre completo</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                class="input @error('name') border-red-400 @enderror" placeholder="Tu nombre">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Correo
                                electrónico</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled
                                class="input bg-borde/30 text-gris/70 cursor-not-allowed select-none">
                            <p class="mt-1.5 text-xs text-gris/55 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                El correo electrónico no puede modificarse.
                            </p>
                        </div>

                        <div class="pt-1">
                            <button type="submit" class="btn-primary">
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Cambiar contraseña --}}
            <div class="card overflow-hidden">
                <div class="flex items-center gap-3 px-7 py-4 border-b border-borde bg-white/60">
                    <div class="w-7 h-7 rounded-lg bg-tinta/8 flex items-center justify-center">
                        <svg class="w-4 h-4 text-tinta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h2 class="text-xs tracking-[0.2em] uppercase text-tinta font-semibold">Cambiar contraseña</h2>
                </div>

                <div class="p-7">
                    <form method="POST" action="{{ route('perfil.update.password') }}" class="space-y-4"
                        id="formPassword">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Contraseña
                                actual</label>
                            <input type="password" name="current_password" id="current_password" required
                                class="input @error('current_password') border-red-400 @enderror"
                                placeholder="Tu contraseña actual">
                            @error('current_password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Nueva
                                contraseña</label>
                            <input type="password" name="password" id="password" required
                                class="input @error('password') border-red-400 @enderror"
                                placeholder="Mínimo 8 caracteres"
                                oninput="validarPasswordsIguales()">
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs tracking-widest uppercase text-gris mb-1.5">Confirmar nueva
                                contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="input" placeholder="Repite la nueva contraseña"
                                oninput="validarPasswordsIguales()">
                            <p id="errorConfirmacion"
                                class="mt-1 text-xs text-red-600 hidden">Las contraseñas no coinciden.</p>
                        </div>

                        <div class="pt-1">
                            <button type="submit" class="btn-primary">
                                Actualizar contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Volver al catálogo --}}
            <div class="text-center pb-4">
                <a href="{{ route('catalogo') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-gris hover:text-tinta transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al catálogo
                </a>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function validarPasswordsIguales() {
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

        document.getElementById('formPassword').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmacion = document.getElementById('password_confirmation').value;

            if (password !== confirmacion) {
                e.preventDefault();
                const error = document.getElementById('errorConfirmacion');
                const inputConfirm = document.getElementById('password_confirmation');
                error.classList.remove('hidden');
                inputConfirm.classList.add('border-red-400');
                inputConfirm.focus();
            }
        });
    </script>
@endpush
