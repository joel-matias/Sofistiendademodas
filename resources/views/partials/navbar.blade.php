<header class="sticky top-0 z-50 bg-crema/95 backdrop-blur border-b border-borde">
    {{-- FILA 1 --}}
    <div class="w-full px-4 sm:px-6 lg:px-10 h-25 flex items-center justify-between gap-3">

        {{-- ✅ IZQUIERDA (hamburguesa SIEMPRE visible, también en desktop) --}}
        <div class="flex items-center gap-2">
            <button class="p-2.5 rounded-lg border border-borde hover:bg-white transition text-lg" aria-label="Abrir menú"
                onclick="toggleMenu()">
                <img src="{{ asset('assets/svg/burger-menu.svg') }}" alt="icono del menu desplegable"
                    class="w-6 h-6 sm:w-7 sm:h-7 object-contain">
            </button>
        </div>

        {{-- LOGO --}}
        <div class="flex-1 sm:flex-none flex justify-center sm:justify-start min-w-[200px]">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('assets/svg/logo-sofistiendademodas.svg') }}" alt="logo de sofis tienda de modas"
                    class="h-20 sm:h-20 md:h-20 object-contain scale-[1.35] sm:scale-[1.5] origin-left">
            </a>
        </div>

        {{-- BARRA DE NAVEGACIÓN (DESKTOP) --}}
        <nav
            class="hidden md:flex h-12 items-center justify-center gap-6 text-[13px] font-semibold tracking-widest uppercase">

            {{-- ✅ Todos por categoría --}}
            <a href="{{ route('catalogo', ['categoria' => 'lo-nuevo']) }}"
                class="hover:text-tinta transition {{ request()->get('categoria') === 'lo-nuevo' ? 'text-tinta' : 'text-gris' }}">
                Lo nuevo
            </a>

            <a href="{{ route('catalogo', ['categoria' => 'ropa']) }}"
                class="hover:text-tinta transition {{ request()->get('categoria') === 'ropa' ? 'text-tinta' : 'text-gris' }}">
                Ropa
            </a>

            <a href="{{ route('catalogo', ['categoria' => 'calzado']) }}"
                class="hover:text-tinta transition {{ request()->get('categoria') === 'calzado' ? 'text-tinta' : 'text-gris' }}">
                Calzado
            </a>

            <a href="{{ route('catalogo', ['categoria' => 'accesorios']) }}"
                class="hover:text-tinta transition {{ request()->get('categoria') === 'accesorios' ? 'text-tinta' : 'text-gris' }}">
                Accesorios
            </a>

            {{-- ✅ Ofertas por bandera, no por categoría --}}
            <a href="{{ route('catalogo', ['ofertas' => 1]) }}"
                class="hover:text-tinta transition {{ request()->boolean('ofertas') ? 'text-tinta' : 'text-gris' }}">
                Ofertas
            </a>
        </nav>

        {{-- ICONOS --}}
        <div class="flex items-center gap-1.5 sm:gap-2">
            {{-- BUSCAR --}}
            <a href="#"
                class="w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center rounded-lg hover:bg-white transition"
                aria-label="Buscar">
                <img src="{{ asset('assets/svg/searching.svg') }}" alt="botón de búsqueda"
                    class="w-6 h-6 sm:w-7 sm:h-7 object-contain">
            </a>
        </div>
    </div>
</header>

{{-- ✅ OVERLAY --}}
<div id="menuOverlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeMenu()">
</div>

{{-- ✅ DRAWER LATERAL --}}
<aside id="drawerMenu"
    class="fixed top-0 left-0 h-full w-[320px] sm:w-[360px] bg-crema z-50 border-r border-borde shadow-xl
           -translate-x-full transition-transform duration-300 ease-in-out">

    {{-- Header del drawer --}}
    <div class="h-25 flex items-center justify-between px-4 sm:px-6 border-b border-borde">
        <p class="font-semibold tracking-widest uppercase text-sm text-tinta">Menú</p>

        <button onclick="closeMenu()" class="p-2.5 rounded-lg border border-borde hover:bg-white transition"
            aria-label="Cerrar menú">
            ✕
        </button>
    </div>

    <div class="p-4 sm:p-6 flex flex-col gap-6">

        {{-- ✅ Enlaces básicos (siempre) --}}
        <div class="flex flex-col gap-3">
            <a href="{{ route('home') }}" class="link-nav" onclick="closeMenu()">Inicio</a>
            <a href="{{ route('catalogo') }}" class="link-nav" onclick="closeMenu()">Catálogo</a>
            <a href="{{ route('nosotros') }}" class="link-nav" onclick="closeMenu()">Nosotros</a>
            <a href="{{ route('contacto') }}" class="link-nav" onclick="closeMenu()">Contacto</a>
        </div>

        {{-- ✅ Categorías SOLO EN MÓVIL --}}
        <div class="pt-4 border-t border-borde sm:hidden">
            <p class="text-xs tracking-widest uppercase text-gris mb-3">Categorías</p>

            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('catalogo', ['categoria' => 'lo-nuevo']) }}" class="badge justify-center py-3"
                    onclick="closeMenu()">
                    Lo nuevo
                </a>
                <a href="{{ route('catalogo', ['categoria' => 'ropa']) }}" class="badge justify-center py-3"
                    onclick="closeMenu()">
                    Ropa
                </a>
                <a href="{{ route('catalogo', ['categoria' => 'calzado']) }}" class="badge justify-center py-3"
                    onclick="closeMenu()">
                    Calzado
                </a>
                <a href="{{ route('catalogo', ['categoria' => 'accesorios']) }}" class="badge justify-center py-3"
                    onclick="closeMenu()">
                    Accesorios
                </a>

                {{-- ✅ Ofertas por bandera --}}
                <a href="{{ route('catalogo', ['ofertas' => 1]) }}" class="badge justify-center py-3 col-span-2"
                    onclick="closeMenu()">
                    Ofertas
                </a>
            </div>
        </div>

        {{-- ✅ En desktop NO mostramos categorías aquí --}}
    </div>
</aside>

<script>
    function toggleMenu() {
        const drawer = document.getElementById('drawerMenu');
        const overlay = document.getElementById('menuOverlay');

        const isOpen = !drawer.classList.contains('-translate-x-full');

        if (isOpen) {
            closeMenu();
        } else {
            drawer.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // evita scroll del fondo
        }
    }

    function closeMenu() {
        const drawer = document.getElementById('drawerMenu');
        const overlay = document.getElementById('menuOverlay');

        drawer.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // ✅ Cerrar con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMenu();
        }
    });
</script>
