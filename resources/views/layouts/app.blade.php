<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sofis Tienda de Modas')</title>
    <meta name="description" content="@yield('description', 'Ropa, calzado y accesorios. Moda y estilo para tu día a día.')">

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
