<header class="sticky top-0 z-50 bg-crema/95 backdrop-blur border-b border-borde">
    {{-- FILA 1 (Móvil y Desktop): Logo + Iconos --}}
    <div class="container-base h-25 flex items-center justify-between gap-3">

        {{-- IZQUIERDA (Móvil): hamburguesa --}}
        <div class="flex items-center gap-2 sm:hidden">
            <button
                class="p-2.5 rounded-lg border border-borde hover:bg-white transition text-lg"
                aria-label="Abrir menú"
                onclick="toggleMenu()">
                ☰
            </button>
        </div>

        {{-- LOGO (Móvil centrado / Desktop izquierda) --}}
        <div class="flex-1 sm:flex-none flex justify-center sm:justify-start min-w-[200px]">
            <a href="{{ route('home') }}" class="flex items-center">
                <img
                    src="{{ asset('assets/svg/logo-sofistiendademodas.svg') }}"
                    alt="logo de sofis tienda de modas"
                    class="h-20 sm:h-20 md:h-20 object-contain
                           scale-[1.35] sm:scale-[1.5] origin-left"
                >
            </a>
        </div>

        {{-- ICONOS (Móvil y Desktop) --}}
        <div class="flex items-center gap-1.5 sm:gap-2">

            <a href="#" class="p-2.5 sm:p-3 rounded-lg hover:bg-white transition text-lg sm:text-xl" aria-label="Buscar">
                🔍
            </a>

            <a href="#" class="p-2.5 sm:p-3 rounded-lg hover:bg-white transition hidden sm:inline-flex text-lg sm:text-xl" aria-label="Favoritos">
                ♡
            </a>

            <a href="#" class="p-2.5 sm:p-3 rounded-lg hover:bg-white transition hidden sm:inline-flex text-lg sm:text-xl" aria-label="Ubicaciones">
                ⌖
            </a>

            <a href="#" class="p-2.5 sm:p-3 rounded-lg hover:bg-white transition hidden sm:inline-flex text-lg sm:text-xl" aria-label="Cuenta">
                👤
            </a>

            <a href="#" class="p-2.5 sm:p-3 rounded-lg hover:bg-white transition text-lg sm:text-xl" aria-label="Carrito">
                🛒
            </a>

            <button
                class="sm:hidden p-2.5 rounded-lg hover:bg-white transition text-lg"
                aria-label="Abrir menú"
                onclick="toggleMenu()">
                ⋮
            </button>
        </div>
    </div>

    {{-- FILA 2 (Solo Desktop): Menú centrado como Vértiche --}}
    <div class="hidden sm:block border-t border-borde">
        <nav class="container-base h-12 flex items-center justify-center gap-6 text-[13px] font-semibold tracking-widest uppercase">
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition {{ request()->routeIs('catalogo') ? 'text-tinta' : 'text-gris' }}">Lo nuevo</a>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition text-gris">Ropa</a>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition text-gris">Calzado</a>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition text-gris">Accesorios</a>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition text-gris">Ofertas</a>
        </nav>
    </div>

    {{-- MENÚ MÓVIL desplegable (como los segundos) --}}
    <nav id="navbarMenuMobile" class="sm:hidden hidden border-t border-borde bg-crema">
        <div class="container-base py-4 flex flex-col gap-4">

            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="link-nav">Inicio</a>
                <a href="{{ route('catalogo') }}" class="link-nav">Catálogo</a>
                <a href="{{ route('nosotros') }}" class="link-nav">Nosotros</a>
                <a href="{{ route('contacto') }}" class="link-nav">Contacto</a>
            </div>

            <div class="pt-4 border-t border-borde">
                <p class="text-xs tracking-widest uppercase text-gris mb-3">Categorías</p>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('catalogo') }}" class="badge justify-center py-3">Lo nuevo</a>
                    <a href="{{ route('catalogo') }}" class="badge justify-center py-3">Ropa</a>
                    <a href="{{ route('catalogo') }}" class="badge justify-center py-3">Calzado</a>
                    <a href="{{ route('catalogo') }}" class="badge justify-center py-3">Accesorios</a>
                    <a href="{{ route('catalogo') }}" class="badge justify-center py-3 col-span-2">Ofertas</a>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    function toggleMenu() {
        const mobile = document.getElementById('navbarMenuMobile');
        mobile.classList.toggle('hidden');
    }
</script>
