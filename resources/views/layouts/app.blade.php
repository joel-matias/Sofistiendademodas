<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $metaTitle     = trim($__env->yieldContent('title'))       ?: config('seo.site_name');
        $metaDesc      = trim($__env->yieldContent('description')) ?: config('seo.description');
        $metaImage     = trim($__env->yieldContent('og_image'))    ?: config('seo.og_image', '');
        $metaType      = trim($__env->yieldContent('og_type'))     ?: 'website';
        $metaCanonical = trim($__env->yieldContent('canonical'))   ?: url()->current();
        $metaRobots    = trim($__env->yieldContent('robots'))      ?: 'index, follow';
    @endphp

    {{-- ── Primary Meta ────────────────────────────────────────────────────── --}}
    <title>{{ $metaTitle }}</title>
    <meta name="description"  content="{{ $metaDesc }}">
    <meta name="keywords"     content="{{ config('seo.keywords') }}">
    <meta name="robots"       content="{{ $metaRobots }}">
    <link rel="canonical"     href="{{ $metaCanonical }}">

    {{-- ── Open Graph (Facebook, WhatsApp, LinkedIn…) ─────────────────────── --}}
    <meta property="og:type"        content="{{ $metaType }}">
    <meta property="og:site_name"   content="{{ config('seo.site_name') }}">
    <meta property="og:locale"      content="es_MX">
    <meta property="og:title"       content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:url"         content="{{ $metaCanonical }}">
    @if ($metaImage)
        <meta property="og:image"        content="{{ $metaImage }}">
        <meta property="og:image:width"  content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt"    content="{{ $metaTitle }}">
    @endif

    {{-- ── Twitter / X Card ───────────────────────────────────────────────── --}}
    <meta name="twitter:card"        content="{{ $metaImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title"       content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    @if ($metaImage)
        <meta name="twitter:image" content="{{ $metaImage }}">
    @endif

    {{-- ── JSON-LD: Organización ──────────────────────────────────────────── --}}
    {{-- Le dice a Google quién es la empresa, su teléfono y sus redes sociales --}}
    @php
        $ldOrg = ['@context' => 'https://schema.org', '@type' => 'Organization',
                  'name' => config('seo.site_name'), 'url' => config('app.url')];
        if (config('seo.phone'))     $ldOrg['telephone'] = config('seo.phone');
        if (config('seo.email'))     $ldOrg['email']     = config('seo.email');
        if (config('seo.address'))   $ldOrg['address']   = config('seo.address');
        $redes = array_values(array_filter([config('seo.instagram'), config('seo.facebook')]));
        if ($redes) $ldOrg['sameAs'] = $redes;
    @endphp
    <script type="application/ld+json">
        {!! json_encode($ldOrg, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- ── JSON-LD: WebSite con SearchAction ─────────────────────────────── --}}
    {{-- Permite a Google mostrar un cuadro de búsqueda directamente en los resultados --}}
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => config('seo.site_name'),
            'url'      => config('app.url'),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => route('catalogo') . '?search={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

    {{-- ── Fuentes ─────────────────────────────────────────────────────────── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="min-h-screen flex flex-col bg-crema text-tinta antialiased">

    <a href="#main-content"
        class="sr-only focus:not-sr-only fixed top-4 left-4 z-[100] px-4 py-2 bg-tinta text-crema text-sm rounded-lg">
        Saltar al contenido
    </a>

    @include('partials.navbar')

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>

</html>
