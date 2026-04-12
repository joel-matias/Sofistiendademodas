<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') · Sofis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-crema font-sans text-tinta">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-tinta text-crema z-40 flex flex-col
               -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

        {{-- Logo área --}}
        <div class="h-16 flex items-center px-6 border-b border-white/10 flex-shrink-0">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Sofis"
                    class="h-8 object-contain brightness-0 invert">
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">

            <p class="px-3 mb-2 text-[10px] tracking-[0.2em] uppercase text-white/40">Principal</p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                       {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <p class="px-3 mt-6 mb-2 text-[10px] tracking-[0.2em] uppercase text-white/40">Catálogo</p>

            <a href="{{ route('admin.productos.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                       {{ request()->routeIs('admin.productos*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Productos
            </a>

            <a href="{{ route('admin.categorias.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                       {{ request()->routeIs('admin.categorias*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Categorías
            </a>

            <a href="{{ route('admin.tallas.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                       {{ request()->routeIs('admin.tallas*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                </svg>
                Tallas
            </a>

            <a href="{{ route('admin.colores.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                       {{ request()->routeIs('admin.colores*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
                Colores
            </a>

            <a href="{{ route('admin.sucursales.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                       {{ request()->routeIs('admin.sucursales*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Sucursales
            </a>

            <p class="px-3 mt-6 mb-2 text-[10px] tracking-[0.2em] uppercase text-white/40">Portada</p>

            <a href="{{ route('admin.covers.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                       {{ request()->routeIs('admin.covers*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Covers del Hero
            </a>

            <p class="px-3 mt-6 mb-2 text-[10px] tracking-[0.2em] uppercase text-white/40">Usuarios</p>

            <a href="{{ route('admin.usuarios.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                       {{ request()->routeIs('admin.usuarios*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Permisos de usuarios
            </a>


        </nav>

        {{-- Footer sidebar --}}
        <div class="flex-shrink-0 p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3 px-2">
                <div
                    class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-sm font-semibold flex-shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-white/50 truncate">Administrador</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-white/70 hover:bg-white/10 hover:text-white transition">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- OVERLAY móvil --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

    {{-- MAIN --}}
    <div class="lg:ml-64 min-h-screen flex flex-col">

        {{-- Top bar --}}
        <header
            class="h-16 bg-white border-b border-borde flex items-center justify-between px-4 sm:px-6 sticky top-0 z-20">
            <div class="flex items-center gap-3">
                {{-- Hamburger móvil --}}
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition"
                    aria-label="Menú">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-sm font-semibold text-tinta">@yield('page_title', 'Panel de administración')</h1>
                    <p class="text-xs text-gris hidden sm:block">@yield('page_subtitle', 'Sofis Tienda de Modas')</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank"
                    class="hidden sm:flex items-center gap-1.5 text-xs text-gris hover:text-tinta transition px-3 py-2 rounded-lg hover:bg-gray-50 border border-borde">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Ver tienda
                </a>
            </div>
        </header>

        {{-- Flash messages vía SweetAlert --}}
        @if (session('success') || session('error') || $errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    @if (session('success'))
                        window.SofisAlert?.success(@json(session('success')));
                    @elseif (session('error'))
                        window.SofisAlert?.error(@json(session('error')));
                    @endif
                    @if ($errors->any())
                        window.SofisAlert?.error('Revisa los campos del formulario antes de continuar.');
                    @endif
                });
            </script>
        @endif

        {{-- Content --}}
        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
        </main>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
        // Close sidebar on navigation (mobile UX)
        document.querySelectorAll('#sidebar a').forEach(a => {
            a.addEventListener('click', () => {
                if (window.innerWidth < 1024) closeSidebar();
            });
        });
    </script>
    <script>
        const MAX_FILE_MB = 10;
        const MAX_FILE_BYTES = MAX_FILE_MB * 1024 * 1024;
        const MAX_TOTAL_MB = 25;
        const MAX_TOTAL_BYTES = MAX_TOTAL_MB * 1024 * 1024;

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="file"]').forEach(function (input) {
                const errorEl = document.createElement('p');
                errorEl.className = 'mt-1 text-xs text-red-600 hidden';
                errorEl.innerHTML = 'Una o más imágenes superan los ' + MAX_FILE_MB + ' MB. Puedes reducirlas gratis en <a href="https://squoosh.app" target="_blank" class="underline font-medium">squoosh.app</a> antes de subirlas.';
                input.insertAdjacentElement('afterend', errorEl);

                input.addEventListener('change', function () {
                    const form = this.closest('form');
                    const submitBtn = form ? form.querySelector('[type="submit"]') : null;
                    const files = Array.from(this.files);

                    // Verificar dimensiones de cada imagen
                    files.forEach(function (file) {
                        const img = new Image();
                        const url = URL.createObjectURL(file);
                        img.onload = function () {
                            URL.revokeObjectURL(url);
                            if (img.naturalWidth > 6000 || img.naturalHeight > 6000) {
                                errorEl.classList.remove('hidden');
                                errorEl.innerHTML = '"' + file.name + '" tiene dimensiones demasiado grandes (' + img.naturalWidth + '×' + img.naturalHeight + ' px). El máximo es 6000×6000 px. Puedes reducirla en <a href="https://squoosh.app" target="_blank" class="underline font-medium">squoosh.app</a>.';
                                if (submitBtn) submitBtn.disabled = true;
                            }
                        };
                        img.src = url;
                    });

                    // Verificar por archivo individual
                    const archivosGrandes = files.filter(f => f.size > MAX_FILE_BYTES);

                    // Verificar total del formulario completo
                    const totalBytes = Array.from(form.querySelectorAll('input[type="file"]'))
                        .flatMap(i => Array.from(i.files))
                        .reduce((sum, f) => sum + f.size, 0);
                    const totalExcedido = totalBytes > MAX_TOTAL_BYTES;

                    if (archivosGrandes.length > 0) {
                        const nombres = archivosGrandes.map(f =>
                            '"' + f.name + '" (' + (f.size / 1024 / 1024).toFixed(1) + ' MB)'
                        ).join(', ');
                        errorEl.classList.remove('hidden');
                        errorEl.innerHTML = (archivosGrandes.length === 1
                            ? 'La imagen ' + nombres + ' supera los ' + MAX_FILE_MB + ' MB.'
                            : 'Las imágenes ' + nombres + ' superan los ' + MAX_FILE_MB + ' MB.'
                        ) + ' Puedes reducirlas gratis en <a href="https://squoosh.app" target="_blank" class="underline font-medium">squoosh.app</a>.';
                    } else if (totalExcedido) {
                        errorEl.classList.remove('hidden');
                        errorEl.innerHTML = 'El total de imágenes supera los ' + MAX_TOTAL_MB + ' MB. Reduce el tamaño de algunas en <a href="https://squoosh.app" target="_blank" class="underline font-medium">squoosh.app</a>.';
                    } else {
                        errorEl.classList.add('hidden');
                    }

                    if (submitBtn) submitBtn.disabled = archivosGrandes.length > 0 || totalExcedido;
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
