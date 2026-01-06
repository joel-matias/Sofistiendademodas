<header class="sticky top-0 z-50 bg-crema/95 backdrop-blur border-b border-borde">
    {{-- FILA 1 --}}
    <div class="container-base h-25 flex items-center justify-between gap-3">

        {{-- IZQUIERDA --}}
        <div class="flex items-center gap-2 sm:hidden">
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
                    class="h-20 sm:h-20 md:h-20 object-contain
                           scale-[1.35] sm:scale-[1.5] origin-left">
            </a>
        </div>

        {{-- BARRA DE NAVEGACION --}}
        <nav
            class="hidden md:flex container-base h-12 items-center justify-center gap-6 text-[13px] font-semibold tracking-widest uppercase">
            <a href="{{ route('catalogo') }}"
                class="hover:text-tinta transition {{ request()->routeIs('catalogo') ? 'text-tinta' : 'text-gris' }}">Lo
                nuevo</a>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition text-gris">Ropa</a>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition text-gris">Calzado</a>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition text-gris">Accesorios</a>
            <a href="{{ route('catalogo') }}" class="hover:text-tinta transition text-gris">Ofertas</a>
        </nav>

        {{-- ICONOS --}}
        <div class="flex items-center gap-1.5 sm:gap-2">

            {{-- BUSCAR --}}
            <a href="#"
                class="w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center
              rounded-lg hover:bg-white transition"
                aria-label="Buscar">
                <img src="{{ asset('assets/svg/searching.svg') }}" alt="botón de búsqueda"
                    class="w-6 h-6 sm:w-7 sm:h-7 object-contain">
            </a>

        </div>

    </div>

    {{-- MENÚ MÓVIL --}}
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
