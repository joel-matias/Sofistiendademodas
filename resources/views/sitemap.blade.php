<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- ── Páginas estáticas ─────────────────────────────────────────────── --}}

    <url>
        <loc>{{ route('home') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{{ route('catalogo') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>{{ route('nosotros') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    {{-- ── Páginas de categoría ──────────────────────────────────────────── --}}

    @foreach ($categorias as $categoria)
    <url>
        <loc>{{ route('catalogo', ['categoria' => $categoria->slug]) }}</loc>
        <lastmod>{{ $categoria->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- ── Productos ─────────────────────────────────────────────────────── --}}

    @foreach ($productos as $producto)
    <url>
        <loc>{{ route('producto', $producto->slug) }}</loc>
        <lastmod>{{ $producto->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

</urlset>
