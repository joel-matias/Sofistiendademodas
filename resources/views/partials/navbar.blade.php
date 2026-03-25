<meta name="csrf-token" content="{{ csrf_token() }}">

<header id="siteHeader"
    class="sticky top-0 z-50 bg-crema/95 backdrop-blur-md border-b border-borde transition-transform duration-300 ease-in-out">

    <div class="w-full px-4 sm:px-6 lg:px-10 h-16 sm:h-20 flex items-center justify-between gap-4">

        <button type="button" onclick="toggleMenu()"
            class="p-2 rounded-lg hover:bg-white transition text-tinta border border-transparent hover:border-borde"
            aria-label="Abrir menú">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div class="absolute left-1/2 -translate-x-1/2">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/svg/logo-sofistiendademodas.svg') }}" alt="Sofis Tienda de Modas"
                    class="h-10 sm:h-12 object-contain">
            </a>
        </div>

        <div class="flex items-center gap-1">

            {{-- nav para escritorio --}}
            <nav class="hidden lg:flex items-center gap-5 mr-4 text-[12px] font-semibold tracking-[0.12em] uppercase">
                <a href="{{ route('catalogo', ['categoria' => 'lo-nuevo']) }}"
                    class="{{ request()->get('categoria') === 'lo-nuevo' ? 'text-tinta border-b border-tinta pb-0.5' : 'text-gris' }} hover:text-tinta transition">Lo nuevo</a>
                <a href="{{ route('catalogo', ['categoria' => 'ropa']) }}"
                    class="{{ request()->get('categoria') === 'ropa' ? 'text-tinta border-b border-tinta pb-0.5' : 'text-gris' }} hover:text-tinta transition">Ropa</a>
                <a href="{{ route('catalogo', ['categoria' => 'calzado']) }}"
                    class="{{ request()->get('categoria') === 'calzado' ? 'text-tinta border-b border-tinta pb-0.5' : 'text-gris' }} hover:text-tinta transition">Calzado</a>
                <a href="{{ route('catalogo', ['categoria' => 'accesorios']) }}"
                    class="{{ request()->get('categoria') === 'accesorios' ? 'text-tinta border-b border-tinta pb-0.5' : 'text-gris' }} hover:text-tinta transition">Accesorios</a>
                <a href="{{ route('catalogo', ['ofertas' => 1]) }}"
                    class="{{ request()->boolean('ofertas') ? 'text-oferta border-b border-oferta pb-0.5' : 'text-oferta/70' }} hover:text-oferta transition">Ofertas</a>
            </nav>

            <button type="button" onclick="toggleSearch()"
                class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white transition border border-transparent hover:border-borde"
                aria-label="Buscar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="hidden sm:flex items-center gap-1.5 ml-1 px-3 py-1.5 rounded-lg text-xs font-semibold tracking-wider uppercase bg-tinta text-crema hover:bg-tinta/85 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Panel
                    </a>
                @else
                    <a href="{{ route('favoritos.index') }}"
                        class="relative w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white transition border border-transparent hover:border-borde"
                        aria-label="Mis favoritos">
                        <svg class="w-5 h-5 text-tinta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        @php $favCount = count($favoritoIds ?? []); @endphp
                        <span id="favoritosCount"
                            class="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full bg-tinta text-crema text-[9px] font-bold flex items-center justify-center {{ $favCount === 0 ? 'hidden' : '' }}">
                            {{ $favCount }}
                        </span>
                    </a>
                @endif

                <div class="relative ml-1" id="userMenuWrapper">
                    <button type="button" onclick="toggleUserMenu()" id="userMenuBtn"
                        class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-white transition border border-transparent hover:border-borde">
                        <div
                            class="w-7 h-7 rounded-full bg-tinta text-crema text-xs font-semibold flex items-center justify-center flex-shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <svg class="w-3.5 h-3.5 text-gris hidden sm:block" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="userMenu"
                        class="absolute right-0 top-full mt-2 w-52 bg-white rounded-2xl border border-borde shadow-suave py-1.5 hidden z-50">
                        <div class="px-4 py-2.5 border-b border-borde">
                            <p class="text-sm font-semibold text-tinta truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gris truncate">{{ auth()->user()->email }}</p>
                        </div>

                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-tinta hover:bg-gray-50 transition">
                                <svg class="w-4 h-4 text-gris" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Panel de administración
                            </a>
                        @else
                            <a href="{{ route('favoritos.index') }}"
                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-tinta hover:bg-gray-50 transition">
                                <svg class="w-4 h-4 text-gris" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Mis favoritos
                                @if (count($favoritoIds ?? []) > 0)
                                    <span
                                        class="ml-auto bg-gray-100 text-gris text-xs px-1.5 py-0.5 rounded-full">{{ count($favoritoIds) }}</span>
                                @endif
                            </a>
                        @endif

                        <div class="border-t border-borde mt-1.5 pt-1.5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="hidden sm:flex items-center text-xs font-semibold tracking-wide text-gris hover:text-tinta transition px-2 py-1.5">
                    Iniciar sesión
                </a>
                <a href="{{ route('registro') }}"
                    class="hidden sm:flex items-center ml-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-tinta text-crema hover:bg-tinta/85 transition">
                    Registrarse
                </a>
                <a href="{{ route('login') }}"
                    class="sm:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white transition border border-transparent hover:border-borde"
                    aria-label="Iniciar sesión">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            @endauth

        </div>
    </div>
</header>

<div id="menuOverlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeMenu()"></div>
<div id="searchOverlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeSearch()"></div>

<aside id="drawerMenu"
    class="fixed top-0 left-0 h-full w-[300px] sm:w-[340px] bg-crema z-50 border-r border-borde shadow-xl
           -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">

    <div class="h-16 sm:h-20 flex items-center justify-between px-5 border-b border-borde">
        <a href="{{ route('home') }}" onclick="closeMenu()">
            <img src="{{ asset('assets/svg/logo-sofistiendademodas.svg') }}" alt="Sofis"
                class="h-9 object-contain">
        </a>
        <button type="button" onclick="closeMenu()"
            class="p-2 rounded-lg border border-borde hover:bg-white transition" aria-label="Cerrar">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="p-5 space-y-7">

        <div class="space-y-0.5">
            <p class="text-[10px] tracking-[0.2em] uppercase text-gris mb-3">Navegación</p>
            <a href="{{ route('home') }}" onclick="closeMenu()"
                class="flex items-center py-2.5 text-sm font-medium border-b border-borde/50 hover:text-gris transition">Inicio</a>
            <a href="{{ route('catalogo') }}" onclick="closeMenu()"
                class="flex items-center py-2.5 text-sm font-medium border-b border-borde/50 hover:text-gris transition">Catálogo
                completo</a>
            <a href="{{ route('nosotros') }}" onclick="closeMenu()"
                class="flex items-center py-2.5 text-sm font-medium border-b border-borde/50 hover:text-gris transition">Nosotros</a>
            <a href="{{ route('contacto') }}" onclick="closeMenu()"
                class="flex items-center py-2.5 text-sm font-medium hover:text-gris transition">Contacto</a>
        </div>

        <div>
            <p class="text-[10px] tracking-[0.2em] uppercase text-gris mb-3">Categorías</p>
            <div class="grid grid-cols-2 gap-2">
                @foreach ([['slug' => 'lo-nuevo', 'label' => 'Lo nuevo'], ['slug' => 'ropa', 'label' => 'Ropa'], ['slug' => 'calzado', 'label' => 'Calzado'], ['slug' => 'accesorios', 'label' => 'Accesorios']] as $item)
                    <a href="{{ route('catalogo', ['categoria' => $item['slug']]) }}" onclick="closeMenu()"
                        class="text-center py-3 px-2 text-xs font-semibold tracking-wider uppercase rounded-xl border border-borde hover:border-tinta hover:bg-white transition">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('catalogo', ['ofertas' => 1]) }}" onclick="closeMenu()"
                    class="col-span-2 text-center py-3 px-2 text-xs font-semibold tracking-wider uppercase rounded-xl border border-oferta/30 text-oferta hover:border-oferta hover:bg-oferta/5 transition">
                    Ofertas
                </a>
            </div>
        </div>

        <div class="border-t border-borde pt-5">
            @auth
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-9 h-9 rounded-full bg-tinta text-crema text-sm font-semibold flex items-center justify-center flex-shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gris truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" onclick="closeMenu()"
                        class="flex items-center gap-2 py-2.5 text-sm font-semibold text-tinta hover:text-gris transition mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Panel de administración
                    </a>
                @else
                    <a href="{{ route('favoritos.index') }}" onclick="closeMenu()"
                        class="flex items-center gap-2 py-2.5 text-sm font-medium hover:text-gris transition mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Mis favoritos
                        @if (count($favoritoIds ?? []) > 0)
                            <span
                                class="ml-auto text-xs bg-gray-100 text-gris px-1.5 py-0.5 rounded-full">{{ count($favoritoIds) }}</span>
                        @endif
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 py-2 text-sm text-red-600 hover:text-red-800 transition w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            @else
                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}" onclick="closeMenu()"
                        class="btn-ghost w-full text-center text-sm">Iniciar sesión</a>
                    <a href="{{ route('registro') }}" onclick="closeMenu()"
                        class="btn-primary w-full text-center text-sm">Crear cuenta</a>
                </div>
            @endauth
        </div>

    </div>
</aside>

<div id="drawerSearch"
    class="fixed top-0 left-0 right-0 z-50 bg-crema border-b border-borde shadow-xl hidden
           -translate-y-full transition-transform duration-300 ease-in-out">
    <div class="w-full px-4 sm:px-6 lg:px-10 py-4 sm:py-5">

        <div class="flex items-center justify-between mb-4">
            <p class="text-[10px] tracking-[0.2em] uppercase text-gris font-semibold">Buscar</p>
            <button onclick="closeSearch()"
                class="p-2 rounded-lg hover:bg-white transition border border-transparent hover:border-borde">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="formSearch" action="{{ route('catalogo') }}" method="GET" class="relative">
            <input id="searchInput" name="search" type="text" value="{{ request()->get('search') }}"
                placeholder="Buscar productos, tallas, estilos..." autocomplete="off"
                class="w-full h-12 rounded-xl border border-borde px-5 pr-14 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-tinta/20 transition">
            <button type="submit"
                class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-50 transition">
                <svg class="w-4 h-4 text-gris" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

            {{-- Panel de sugerencias rico --}}
            <div id="searchPanel"
                class="absolute left-0 right-0 mt-2 bg-white border border-borde rounded-2xl shadow-xl overflow-hidden hidden z-50 max-h-[70vh] overflow-y-auto">

                {{-- Loading --}}
                <div id="spLoading" class="hidden flex items-center gap-3 px-5 py-5 text-gris text-sm">
                    <svg class="w-4 h-4 animate-spin text-gris" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Buscando...
                </div>

                {{-- Sugerencias de texto --}}
                <div id="spTerms" class="hidden">
                    <p class="px-5 pt-4 pb-1.5 text-[10px] tracking-[0.2em] uppercase text-gris font-semibold">Sugerencias</p>
                    <div id="spTermsList"></div>
                </div>

                <div id="spDivider" class="hidden mx-5 border-t border-borde/60 my-1"></div>

                {{-- Productos --}}
                <div id="spProducts" class="hidden">
                    <p class="px-5 pt-3 pb-1.5 text-[10px] tracking-[0.2em] uppercase text-gris font-semibold">Productos</p>
                    <div id="spProductsList" class="divide-y divide-borde/40"></div>
                </div>

                {{-- Ver todos --}}
                <div id="spViewAll" class="hidden border-t border-borde">
                    <a id="spViewAllLink" href="#"
                        class="flex items-center justify-center gap-1.5 px-5 py-3.5 text-sm font-medium text-tinta hover:bg-gray-50 transition w-full">
                    </a>
                </div>

                {{-- Sin resultados --}}
                <div id="spEmpty" class="hidden px-5 py-10 text-center">
                    <svg class="w-10 h-10 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="text-sm text-gris">Sin resultados para "<span id="spEmptyQuery" class="text-tinta font-medium"></span>"</p>
                    <a href="{{ route('catalogo') }}" class="text-xs text-gris hover:text-tinta underline underline-offset-2 mt-2 inline-block">Ver todo el catálogo</a>
                </div>

            </div>
        </form>

        {{-- Explorar (estado inicial, sin texto) --}}
        <div id="searchQuickLinks" class="mt-5">
            <p class="text-[10px] tracking-[0.2em] uppercase text-gris font-semibold mb-3">Explorar</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('catalogo', ['categoria' => 'lo-nuevo']) }}" onclick="closeSearch()"
                    class="px-3.5 py-1.5 rounded-full text-xs font-medium border border-borde hover:border-tinta hover:bg-white transition text-tinta">Lo nuevo</a>
                <a href="{{ route('catalogo', ['categoria' => 'ropa']) }}" onclick="closeSearch()"
                    class="px-3.5 py-1.5 rounded-full text-xs font-medium border border-borde hover:border-tinta hover:bg-white transition text-tinta">Ropa</a>
                <a href="{{ route('catalogo', ['categoria' => 'calzado']) }}" onclick="closeSearch()"
                    class="px-3.5 py-1.5 rounded-full text-xs font-medium border border-borde hover:border-tinta hover:bg-white transition text-tinta">Calzado</a>
                <a href="{{ route('catalogo', ['categoria' => 'accesorios']) }}" onclick="closeSearch()"
                    class="px-3.5 py-1.5 rounded-full text-xs font-medium border border-borde hover:border-tinta hover:bg-white transition text-tinta">Accesorios</a>
                <a href="{{ route('catalogo', ['ofertas' => 1]) }}" onclick="closeSearch()"
                    class="px-3.5 py-1.5 rounded-full text-xs font-medium border border-oferta/25 text-oferta hover:bg-oferta/5 transition">Ofertas</a>
            </div>
        </div>

    </div>
</div>

<script>
    function toggleMenu() {
        closeSearch();
        closeUserMenu();
        const d = document.getElementById('drawerMenu'),
            o = document.getElementById('menuOverlay');
        if (d.classList.contains('-translate-x-full')) {
            d.classList.remove('-translate-x-full');
            o.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else closeMenu();
    }

    function closeMenu() {
        document.getElementById('drawerMenu').classList.add('-translate-x-full');
        document.getElementById('menuOverlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function toggleSearch() {
        closeMenu();
        closeUserMenu();
        const d = document.getElementById('drawerSearch'),
            o = document.getElementById('searchOverlay');
        if (d.classList.contains('hidden') || d.classList.contains('-translate-y-full')) {
            d.classList.remove('hidden');
            requestAnimationFrame(() => d.classList.remove('-translate-y-full'));
            o.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            // Ensure quick links visible & panel hidden on open
            document.getElementById('searchPanel')?.classList.add('hidden');
            document.getElementById('searchQuickLinks')?.classList.remove('hidden');
            setTimeout(() => {
                const si = document.getElementById('searchInput');
                if (si) { si.focus(); if (!si.value.trim()) si.value = ''; }
            }, 250);
        } else closeSearch();
    }

    function closeSearch() {
        const d = document.getElementById('drawerSearch'),
            o = document.getElementById('searchOverlay');
        d.classList.add('-translate-y-full');
        o.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        document.getElementById('searchPanel')?.classList.add('hidden');
        setTimeout(() => d.classList.add('hidden'), 300);
    }

    function toggleUserMenu() {
        const m = document.getElementById('userMenu');
        m?.classList.toggle('hidden');
    }

    function closeUserMenu() {
        document.getElementById('userMenu')?.classList.add('hidden');
    }
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('userMenuWrapper');
        if (wrapper && !wrapper.contains(e.target)) closeUserMenu();
    });

    // ── Search panel ────────────────────────────────────────────────────────
    const searchInput = document.getElementById('searchInput');
    const searchPanel = document.getElementById('searchPanel');
    const searchQuickLinks = document.getElementById('searchQuickLinks');
    let srDebounce = null, srActiveIdx = -1, srOptions = [];

    function srEscape(str) {
        return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function srHidePanel() {
        searchPanel?.classList.add('hidden');
        srActiveIdx = -1;
        srOptions = [];
    }

    function srShowPanel() {
        searchPanel?.classList.remove('hidden');
        searchQuickLinks?.classList.add('hidden');
    }

    function srShowQuickLinks() {
        searchQuickLinks?.classList.remove('hidden');
        srHidePanel();
    }

    function srSetLoading(on) {
        document.getElementById('spLoading')?.classList.toggle('hidden', !on);
        if (on) {
            ['spTerms','spDivider','spProducts','spViewAll','spEmpty'].forEach(id =>
                document.getElementById(id)?.classList.add('hidden'));
            srShowPanel();
        }
    }

    function srUpdateActive() {
        srOptions.forEach((el, i) => el.classList.toggle('bg-gray-50', i === srActiveIdx));
    }

    function srRender(data, query) {
        const { terminos = [], produtos, productos = produtos ?? [], total = 0 } = data;
        srSetLoading(false);
        document.getElementById('spLoading')?.classList.add('hidden');

        if (!terminos.length && !productos.length) {
            const el = document.getElementById('spEmpty');
            const q = document.getElementById('spEmptyQuery');
            if (q) q.textContent = query;
            el?.classList.remove('hidden');
            ['spTerms','spDivider','spProducts','spViewAll'].forEach(id =>
                document.getElementById(id)?.classList.add('hidden'));
            srShowPanel();
            srOptions = [];
            return;
        }

        document.getElementById('spEmpty')?.classList.add('hidden');
        srOptions = [];

        // — Términos —
        const termsList = document.getElementById('spTermsList');
        const termsEl   = document.getElementById('spTerms');
        if (terminos.length && termsList && termsEl) {
            termsList.innerHTML = '';
            terminos.forEach(term => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full flex items-center gap-3 px-5 py-2.5 hover:bg-gray-50 transition text-left group';
                btn.innerHTML =
                    `<svg class="w-3.5 h-3.5 flex-shrink-0" style="color:#716F6A" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="text-sm text-tinta flex-1 truncate">${srEscape(term)}</span>
                    <svg class="w-3 h-3 flex-shrink-0 opacity-0 group-hover:opacity-40 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/>
                    </svg>`;
                btn.addEventListener('click', () => {
                    searchInput.value = term;
                    srHidePanel();
                    document.getElementById('formSearch').submit();
                });
                termsList.appendChild(btn);
                srOptions.push(btn);
            });
            termsEl.classList.remove('hidden');
        } else {
            termsEl?.classList.add('hidden');
        }

        // — Divider —
        const divider = document.getElementById('spDivider');
        divider?.classList.toggle('hidden', !(terminos.length && productos.length));

        // — Productos —
        const prodList = document.getElementById('spProductsList');
        const prodEl   = document.getElementById('spProducts');
        if (productos.length && prodList && prodEl) {
            prodList.innerHTML = '';
            productos.forEach(p => {
                const a = document.createElement('a');
                a.href = p.url || '#';
                a.className = 'flex items-center gap-3.5 px-5 py-3 hover:bg-gray-50 transition';
                const price = p.oferta && p.precio_oferta ? p.precio_oferta : p.precio;
                const orig  = p.oferta && p.precio_oferta ? p.precio : null;
                const imgHtml = p.imagen
                    ? `<img src="${srEscape(p.imagen)}" alt="${srEscape(p.nombre)}" class="w-full h-full object-cover" loading="lazy">`
                    : `<svg class="w-4 h-4" style="color:#C8C4BE" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`;
                const ofertaBadge = p.oferta
                    ? `<span style="font-size:10px;background:#F4E6EA;color:#9B1D3A;border:1px solid #DFA8B4;padding:1px 7px;border-radius:999px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;flex-shrink:0">Sale</span>` : '';
                const origHtml = orig
                    ? `<span style="font-size:11px;color:#716F6A;text-decoration:line-through">$${Number(orig).toLocaleString()}</span>` : '';
                a.innerHTML =
                    `<div class="w-10 h-12 rounded-lg overflow-hidden border border-borde bg-gray-100 flex-shrink-0 flex items-center justify-center">${imgHtml}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-tinta truncate">${srEscape(p.nombre)}</p>
                        <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                            ${origHtml}
                            <span class="text-sm font-semibold text-tinta">$${Number(price).toLocaleString()}</span>
                            ${ofertaBadge}
                        </div>
                    </div>
                    <svg class="w-4 h-4 flex-shrink-0" style="color:#C8C4BE" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                    </svg>`;
                a.addEventListener('click', srHidePanel);
                prodList.appendChild(a);
                srOptions.push(a);
            });
            prodEl.classList.remove('hidden');
        } else {
            prodEl?.classList.add('hidden');
        }

        // — Ver todos —
        const viewAllEl   = document.getElementById('spViewAll');
        const viewAllLink = document.getElementById('spViewAllLink');
        if (total > 0 && viewAllEl && viewAllLink) {
            const url = `{{ route('catalogo') }}?search=${encodeURIComponent(query)}`;
            viewAllLink.href = url;
            viewAllLink.innerHTML =
                `Ver los <strong class="mx-1">${total}</strong> resultado${total === 1 ? '' : 's'} para "<em>${srEscape(query)}</em>"
                <svg class="w-4 h-4 ml-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>`;
            viewAllEl.classList.remove('hidden');
            srOptions.push(viewAllLink);
        } else {
            viewAllEl?.classList.add('hidden');
        }

        srShowPanel();
    }

    async function srFetch(q) {
        try {
            const r = await fetch(`{{ route('buscar.sugerencias') }}?q=${encodeURIComponent(q)}`,
                { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            return await r.json();
        } catch { return { terminos: [], productos: [], total: 0 }; }
    }

    searchInput?.addEventListener('input', function () {
        clearTimeout(srDebounce);
        const val = this.value.trim();
        if (!val) { srShowQuickLinks(); return; }
        if (val.length < 2) { srHidePanel(); return; }
        srSetLoading(true);
        srDebounce = setTimeout(async () => srRender(await srFetch(val), val), 220);
    });

    searchInput?.addEventListener('keydown', function (e) {
        if (searchPanel?.classList.contains('hidden')) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            srActiveIdx = Math.min(srActiveIdx + 1, srOptions.length - 1);
            srUpdateActive();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            srActiveIdx = Math.max(srActiveIdx - 1, 0);
            srUpdateActive();
        } else if (e.key === 'Enter' && srActiveIdx >= 0) {
            e.preventDefault();
            srOptions[srActiveIdx]?.click();
        } else if (e.key === 'Escape') {
            srHidePanel();
            this.blur();
        }
    });

    document.addEventListener('click', e => {
        if (searchPanel && searchInput &&
            !searchPanel.contains(e.target) && e.target !== searchInput) {
            srHidePanel();
        }
    });

    (function() {
        const h = document.getElementById('siteHeader');
        if (!h) return;
        let last = 0,
            ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    ticking = false;
                    const cur = window.scrollY,
                        delta = cur - last;
                    if (Math.abs(delta) < 8) return;
                    const anyOpen = !document.getElementById('menuOverlay')?.classList.contains(
                            'hidden') ||
                        !document.getElementById('searchOverlay')?.classList.contains('hidden');
                    if (!anyOpen) {
                        delta > 0 && cur > 80 ? h.classList.add('-translate-y-full') : delta < 0 &&
                            h.classList.remove('-translate-y-full');
                    }
                    last = cur <= 0 ? 0 : cur;
                });
                ticking = true;
            }
        }, {
            passive: true
        });
        window.addEventListener('resize', () => h.classList.remove('-translate-y-full'));
    })();
</script>
