<header class="sticky top-0 z-50 bg-crema/95 backdrop-blur border-b border-borde">
    {{-- FILA 1 --}}
    <div class="w-full px-4 sm:px-6 lg:px-10 h-25 flex items-center justify-between gap-3">

        {{-- IZQUIERDA --}}
        <div class="flex items-center gap-2">
            <button type="button" class="p-2.5 rounded-lg border border-borde hover:bg-white transition text-lg"
                aria-label="Abrir menú" onclick="toggleMenu()">
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

            <a href="{{ route('catalogo', ['ofertas' => 1]) }}"
                class="hover:text-tinta transition {{ request()->boolean('ofertas') ? 'text-tinta' : 'text-gris' }}">
                Ofertas
            </a>
        </nav>

        {{-- ICONOS --}}
        <div class="flex items-center gap-1.5 sm:gap-2">
            {{-- BUSCAR (toggle real) --}}
            <button type="button"
                class="w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center rounded-lg hover:bg-white transition"
                aria-label="Buscar" onclick="toggleSearch()">
                <img src="{{ asset('assets/svg/searching.svg') }}" alt="botón de búsqueda"
                    class="w-6 h-6 sm:w-7 sm:h-7 object-contain">
            </button>
        </div>
    </div>
</header>

{{-- OVERLAY MENÚ --}}
<div id="menuOverlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeMenu()"></div>

{{-- OVERLAY SEARCH --}}
<div id="searchOverlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeSearch()"></div>

{{-- DRAWER MENÚ LATERAL --}}
<aside id="drawerMenu"
    class="fixed top-0 left-0 h-full w-[320px] sm:w-[360px] bg-crema z-50 border-r border-borde shadow-xl
           -translate-x-full transition-transform duration-300 ease-in-out">

    <div class="h-25 flex items-center justify-between px-4 sm:px-6 border-b border-borde">
        <p class="font-semibold tracking-widest uppercase text-sm text-tinta">Menú</p>

        <button type="button" onclick="closeMenu()"
            class="p-2.5 rounded-lg border border-borde hover:bg-white transition" aria-label="Cerrar menú">
            ✕
        </button>
    </div>

    <div class="p-4 sm:p-6 flex flex-col gap-6">

        <div class="flex flex-col gap-3">
            <a href="{{ route('home') }}" class="link-nav" onclick="closeMenu()">Inicio</a>
            <a href="{{ route('catalogo') }}" class="link-nav" onclick="closeMenu()">Catálogo</a>
            <a href="{{ route('nosotros') }}" class="link-nav" onclick="closeMenu()">Nosotros</a>
            {{-- <a href="{{ route('contacto') }}" class="link-nav" onclick="closeMenu()">Contacto</a> --}}
        </div>

        {{-- Categorías SOLO EN MÓVIL --}}
        <div class="pt-4 border-t border-borde sm:hidden">
            <p class="text-xs tracking-widest uppercase text-gris mb-3">Categorías</p>

            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('catalogo', ['categoria' => 'lo-nuevo']) }}" class="badge justify-center py-3"
                    onclick="closeMenu()">Lo nuevo</a>
                <a href="{{ route('catalogo', ['categoria' => 'ropa']) }}" class="badge justify-center py-3"
                    onclick="closeMenu()">Ropa</a>
                <a href="{{ route('catalogo', ['categoria' => 'calzado']) }}" class="badge justify-center py-3"
                    onclick="closeMenu()">Calzado</a>
                <a href="{{ route('catalogo', ['categoria' => 'accesorios']) }}" class="badge justify-center py-3"
                    onclick="closeMenu()">Accesorios</a>
                <a href="{{ route('catalogo', ['ofertas' => 1]) }}" class="badge justify-center py-3 col-span-2"
                    onclick="closeMenu()">Ofertas</a>
            </div>
        </div>
    </div>
</aside>

{{-- DRAWER SEARCH SUPERIOR (FULL WIDTH REAL) --}}
<div id="drawerSearch"
    class="fixed top-0 left-0 right-0 z-50 bg-crema border-b border-borde shadow-xl hidden
           -translate-y-full transition-transform duration-300 ease-in-out">

    {{-- Ocupa todo el ancho, no solo un cuadrito --}}
    <div class="w-full px-4 sm:px-6 lg:px-10 py-5">
        <p class="font-semibold tracking-widest uppercase text-sm text-tinta">Buscar</p>

        <form id="formSearch" action="{{ route('catalogo') }}" method="GET" class="mt-4 relative">
            <input id="searchInput" name="search" type="text" value="{{ request()->get('search') }}"
                placeholder="Buscar productos..." autocomplete="off"
                class="w-full h-12 rounded-xl border border-borde px-4 pr-14 bg-white focus:outline-none focus:ring-2 focus:ring-tinta/20">

            {{-- BOTÓN ICONO (igual al del navbar) --}}
            <button type="submit"
                class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-50 transition"
                aria-label="Buscar">
                <img src="{{ asset('assets/svg/searching.svg') }}" alt="botón de búsqueda"
                    class="w-5 h-5 object-contain">
            </button>

            {{-- Sugerencias --}}
            <div id="searchSuggestions"
                class="absolute left-0 right-0 mt-2 bg-white border border-borde rounded-xl2 shadow-lg overflow-hidden hidden z-50">
                <div id="suggestionsList" class="divide-y divide-borde"></div>
            </div>
        </form>
    </div>
</div>

<script>
    // =============================
    // MENÚ LATERAL
    // =============================
    function toggleMenu() {
        closeSearch();
        const drawer = document.getElementById('drawerMenu');
        const overlay = document.getElementById('menuOverlay');

        const isOpen = !drawer.classList.contains('-translate-x-full');
        if (isOpen) closeMenu();
        else {
            drawer.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeMenu() {
        const drawer = document.getElementById('drawerMenu');
        const overlay = document.getElementById('menuOverlay');
        drawer.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // =============================
    //  SEARCH TOGGLE (FIJO)
    // =============================
    function toggleSearch() {
        closeMenu();

        const drawer = document.getElementById('drawerSearch');
        const overlay = document.getElementById('searchOverlay');

        const isOpen = !drawer.classList.contains('-translate-y-full');

        if (isOpen) {
            closeSearch();
        } else {
            drawer.classList.remove('hidden');
            requestAnimationFrame(() => {
                drawer.classList.remove('-translate-y-full');
            });

            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            setTimeout(() => {
                const input = document.getElementById('searchInput');
                input?.focus();
                input?.select();
            }, 250);
        }
    }

    function closeSearch() {
        const drawer = document.getElementById('drawerSearch');
        const overlay = document.getElementById('searchOverlay');

        drawer.classList.add('-translate-y-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        hideSuggestions();

        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    }

    // =============================
    // AUTOCOMPLETE
    // =============================
    const input = document.getElementById('searchInput');
    const box = document.getElementById('searchSuggestions');
    const list = document.getElementById('suggestionsList');

    let debounceTimer = null;
    let activeIndex = -1;

    function safeImageUrl(url) {
        if (!url) return null;
        try {
            if (url.startsWith('/')) return url;
            const parsed = new URL(url, window.location.origin);
            if (parsed.protocol === 'http:' || parsed.protocol === 'https:') {
                return parsed.href;
            }
        } catch (e) {
            /* invalid URL */
        }
        return null;
    }

    function hideSuggestions() {
        if (!box || !list) return;
        list.innerHTML = '';
        box.classList.add('hidden');
        box.setAttribute('aria-hidden', 'true');
        input.removeAttribute('aria-activedescendant');
        input.setAttribute('aria-expanded', 'false');
        activeIndex = -1;
    }

    function openSuggestions() {
        if (!box) return;
        box.classList.remove('hidden');
        box.setAttribute('aria-hidden', 'false');
        input.setAttribute('aria-expanded', 'true');
    }

    function focusOption(index) {
        const options = list.querySelectorAll('[role="option"]');
        if (!options || options.length === 0) return;
        if (index < 0) index = 0;
        if (index >= options.length) index = options.length - 1;
        options.forEach(opt => opt.classList.remove('bg-gray-100', 'ring-2', 'ring-tinta/20'));
        const option = options[index];
        if (option) {
            option.classList.add('bg-gray-100', 'ring-2', 'ring-tinta/20');
            option.scrollIntoView({
                block: 'nearest'
            });
            input.setAttribute('aria-activedescendant', option.id);
            activeIndex = index;
        }
    }

    function renderSuggestions(items) {
        if (!items || items.length === 0) {
            hideSuggestions();
            return;
        }

        list.innerHTML = '';
        activeIndex = -1;
        box.setAttribute('role', 'listbox');
        box.setAttribute('aria-hidden', 'false');

        items.forEach((item, i) => {
            const a = document.createElement('a');
            a.href = item.url || '#';
            a.className = 'flex items-center gap-3 p-3 hover:bg-gray-50 transition';
            a.setAttribute('role', 'option');
            a.id = `search-suggestion-${i}`;
            a.tabIndex = -1;

            const img = document.createElement('img');
            const sUrl = safeImageUrl(item.imagen);
            img.src = sUrl ?? '{{ asset('assets/img/placeholder-category.jpg') }}';
            img.alt = (typeof item.nombre === 'string' ? item.nombre : 'Imagen');
            img.className = 'w-12 h-12 object-cover rounded-lg border border-borde bg-gray-100';
            img.loading = 'lazy';

            const div = document.createElement('div');
            div.className = 'flex-1';

            const pName = document.createElement('p');
            pName.className = 'text-sm font-semibold text-tinta';
            pName.textContent = (typeof item.nombre === 'string' ? item.nombre : 'Producto');

            const pPrice = document.createElement('p');
            pPrice.className = 'text-xs text-gris';
            const precioFinal = item.oferta && item.precio_oferta ? item.precio_oferta : item.precio;
            pPrice.textContent = `$${(Number(precioFinal) || 0).toLocaleString()} MXN`;

            div.appendChild(pName);
            div.appendChild(pPrice);
            a.appendChild(img);
            a.appendChild(div);

            a.addEventListener('click', () => hideSuggestions());

            list.appendChild(a);
        });

        openSuggestions();
    }

    async function fetchSuggestions(query) {
        if (!query || query.length < 2) return [];
        const url = `{{ route('buscar.sugerencias') }}?q=${encodeURIComponent(query)}`;
        try {
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) return [];
            const data = await res.json();
            return Array.isArray(data) ? data : [];
        } catch (e) {
            return [];
        }
    }

    input?.addEventListener('input', function() {
        const q = this.value.trim();
        if (q.length < 2) {
            hideSuggestions();
            return;
        }
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(async () => {
            const items = await fetchSuggestions(q);
            renderSuggestions(items);
        }, 220);
    });

    input?.addEventListener('keydown', function(e) {
        const options = list.querySelectorAll('[role="option"]');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (options.length === 0) return;
            const next = (activeIndex + 1) || 0;
            focusOption(Math.min(next, options.length - 1));
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (options.length === 0) return;
            focusOption(Math.max(activeIndex - 1, 0));
        } else if (e.key === 'Enter') {
            if (activeIndex >= 0) {
                const opt = options[activeIndex];
                if (opt && opt.href) {
                    window.location.href = opt.href;
                    hideSuggestions();
                    e.preventDefault();
                }
            }
        } else if (e.key === 'Escape') {
            hideSuggestions();
            this.blur();
        }
    });

    document.addEventListener('click', function(e) {
        if (!box || !input) return;
        if (!box.contains(e.target) && e.target !== input) {
            hideSuggestions();
        }
    });

    // Esc global
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideSuggestions();
        }
    });
</script>
