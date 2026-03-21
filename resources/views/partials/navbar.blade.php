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
                    class="{{ request()->boolean('ofertas') ? 'text-moda border-b border-moda pb-0.5' : 'text-moda/70' }} hover:text-moda transition">Ofertas</a>
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
                    class="col-span-2 text-center py-3 px-2 text-xs font-semibold tracking-wider uppercase rounded-xl border border-moda/40 text-moda hover:border-moda hover:bg-moda/5 transition">
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
            <p class="text-xs tracking-[0.2em] uppercase text-gris font-semibold">Buscar</p>
            <button onclick="closeSearch()"
                class="p-2 rounded-lg hover:bg-white transition border border-transparent hover:border-borde">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="formSearch" action="{{ route('catalogo') }}" method="GET" class="relative">
            <input id="searchInput" name="search" type="text" value="{{ request()->get('search') }}"
                placeholder="Buscar productos..." autocomplete="off"
                class="w-full h-12 rounded-xl border border-borde px-5 pr-14 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-tinta/20 transition">
            <button type="submit"
                class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-50 transition">
                <svg class="w-4 h-4 text-gris" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
            <div id="searchSuggestions"
                class="absolute left-0 right-0 mt-2 bg-white border border-borde rounded-2xl shadow-suave overflow-hidden hidden z-50">
                <div id="suggestionsList" class="divide-y divide-borde"></div>
            </div>
        </form>
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
            setTimeout(() => document.getElementById('searchInput')?.focus(), 250);
        } else closeSearch();
    }

    function closeSearch() {
        const d = document.getElementById('drawerSearch'),
            o = document.getElementById('searchOverlay');
        d.classList.add('-translate-y-full');
        o.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        hideSuggestions();
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

    const input = document.getElementById('searchInput');
    const box = document.getElementById('searchSuggestions');
    const list = document.getElementById('suggestionsList');
    let debounce = null,
        activeIdx = -1;

    function hideSuggestions() {
        if (list) list.innerHTML = '';
        box?.classList.add('hidden');
        activeIdx = -1;
    }

    function renderSuggestions(items) {
        if (!items?.length) {
            hideSuggestions();
            return;
        }
        list.innerHTML = '';
        activeIdx = -1;
        items.forEach((item, i) => {
            const a = document.createElement('a');
            a.href = item.url || '#';
            a.className = 'flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition';
            a.setAttribute('role', 'option');
            const img = document.createElement('img');
            img.src = item.imagen ?? '{{ asset('assets/img/placeholder-category.jpg') }}';
            img.className = 'w-11 h-14 object-cover rounded-lg border border-borde bg-gray-100 flex-shrink-0';
            img.loading = 'lazy';
            const div = document.createElement('div');
            div.className = 'flex-1 min-w-0';
            const pN = document.createElement('p');
            pN.className = 'text-sm font-medium text-tinta truncate';
            pN.textContent = item.nombre ?? '';
            const pP = document.createElement('p');
            pP.className = 'text-xs text-gris mt-0.5';
            const price = item.oferta && item.precio_oferta ? item.precio_oferta : item.precio;
            pP.textContent = `$${Number(price || 0).toLocaleString()} MXN`;
            div.append(pN, pP);
            a.append(img, div);
            a.addEventListener('click', hideSuggestions);
            list.appendChild(a);
        });
        box?.classList.remove('hidden');
    }
    async function fetchSuggestions(q) {
        if (!q || q.length < 2) return [];
        try {
            const r = await fetch(`/buscar/sugerencias?q=${encodeURIComponent(q)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            return await r.json();
        } catch {
            return [];
        }
    }
    input?.addEventListener('input', function() {
        clearTimeout(debounce);
        if (this.value.trim().length < 2) {
            hideSuggestions();
            return;
        }
        debounce = setTimeout(async () => renderSuggestions(await fetchSuggestions(this.value.trim())), 220);
    });
    input?.addEventListener('keydown', function(e) {
        const opts = list?.querySelectorAll('[role=option]') ?? [];
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIdx = Math.min(activeIdx + 1, opts.length - 1);
            opts.forEach((o, i) => o.classList.toggle('bg-gray-100', i === activeIdx));
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIdx = Math.max(activeIdx - 1, 0);
            opts.forEach((o, i) => o.classList.toggle('bg-gray-100', i === activeIdx));
        } else if (e.key === 'Enter' && activeIdx >= 0) {
            e.preventDefault();
            opts[activeIdx]?.click();
        } else if (e.key === 'Escape') {
            hideSuggestions();
            this.blur();
        }
    });
    document.addEventListener('click', e => {
        if (box && input && !box.contains(e.target) && e.target !== input) hideSuggestions();
    });

    (function() {
        const h = document.getElementById('siteHeader');
        if (!h) return;
        let last = 0,
            ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
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
                    ticking = false;
                });
                ticking = true;
            }
        }, {
            passive: true
        });
        window.addEventListener('resize', () => h.classList.remove('-translate-y-full'));
    })();
</script>
