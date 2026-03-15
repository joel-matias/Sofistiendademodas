<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // listado de imagenes
        $imagenes = [
            'blusas'     => [
                'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1515886657613-9a6b4c6b2b8f?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1554568218-0f1715e72254?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1485462537746-965f33f7f6a7?w=800&q=80&fit=crop&auto=format',
            ],
            'vestidos'   => [
                'https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1539109136881-a6ef4f6d2f0b?w=800&q=80&fit=crop&auto=format',
            ],
            'jeans'      => [
                'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1475178626620-a4d074967452?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1555689502-c4b22d76c56f?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=800&q=80&fit=crop&auto=format',
            ],
            'faldas'     => [
                'https://images.unsplash.com/photo-1583496661160-fb5218cbc86f?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1529682628567-c4ab7b5e8e9a?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1601412436009-d964bd02edbc?w=800&q=80&fit=crop&auto=format',
            ],
            'tops'       => [
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1583744946564-b52ac1c389c8?w=800&q=80&fit=crop&auto=format',
            ],
            'abrigos'    => [
                'https://images.unsplash.com/photo-1539533018257-c4d9f476cfe8?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1519659528534-7fd733a832a0?w=800&q=80&fit=crop&auto=format',
            ],
            'calzado'    => [
                'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=800&q=80&fit=crop&auto=format',
            ],
            'accesorios' => [
                'https://images.unsplash.com/photo-1611085583191-a3b181a88401?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1590664216915-f5c8ea890f95?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1492707892479-7bc8d5a4ee93?w=800&q=80&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800&q=80&fit=crop&auto=format',
            ],
        ];

        // 50 prductos de pryueba en diferentes categorias
        $productos = [
            // ── BLUSAS ────────────────────────────────────────────────────
            ['nombre' => 'Blusa de lino beige',        'precio' => 429,  'categorias' => ['Blusas', 'Lo nuevo'],   'img' => $imagenes['blusas'][0],     'oferta' => false, 'tallas' => ['XS','S','M','L'],          'colores' => ['Beige','Blanco'],           'desc' => 'Blusa confeccionada en lino natural, fresca y cómoda para el día a día.'],
            ['nombre' => 'Blusa floral manga corta',   'precio' => 389,  'categorias' => ['Blusas'],               'img' => $imagenes['blusas'][1],     'oferta' => true,  'precio_oferta' => 299, 'tallas' => ['S','M','L','XL'],          'colores' => ['Rosa','Coral'],            'desc' => 'Estampado floral delicado, perfecta para días soleados.'],
            ['nombre' => 'Blusa satinada negra',       'precio' => 549,  'categorias' => ['Blusas'],               'img' => $imagenes['blusas'][2],     'oferta' => false, 'tallas' => ['XS','S','M'],              'colores' => ['Negro','Burdeos'],          'desc' => 'Blusa de tejido satinado con acabado brillante para looks elegantes.'],
            ['nombre' => 'Blusa off-shoulder blanca',  'precio' => 469,  'categorias' => ['Blusas', 'Lo nuevo'],   'img' => $imagenes['blusas'][3],     'oferta' => false, 'tallas' => ['S','M','L'],               'colores' => ['Blanco','Crema'],           'desc' => 'Diseño off-shoulder atemporal, ideal para combinar con cualquier bottom.'],
            ['nombre' => 'Blusa estampado tropical',   'precio' => 399,  'categorias' => ['Blusas'],               'img' => $imagenes['blusas'][4],     'oferta' => true,  'precio_oferta' => 320, 'tallas' => ['S','M','L','XL'],          'colores' => ['Verde','Mostaza'],         'desc' => 'Estampado tropical vibrante con silueta suelta y cómoda.'],

            // ── VESTIDOS ──────────────────────────────────────────────────
            ['nombre' => 'Vestido midi floral',        'precio' => 1199, 'categorias' => ['Vestidos', 'Lo nuevo'], 'img' => $imagenes['vestidos'][0],   'oferta' => false, 'tallas' => ['XS','S','M','L'],          'colores' => ['Rosa palo','Crema'],        'desc' => 'Vestido midi con estampado floral, perfecto para ocasiones especiales.'],
            ['nombre' => 'Vestido negro cóctel',       'precio' => 1499, 'categorias' => ['Vestidos'],             'img' => $imagenes['vestidos'][1],   'oferta' => false, 'tallas' => ['XS','S','M'],              'colores' => ['Negro'],                   'desc' => 'El clásico vestido negro que toda mujer necesita en su guardarropa.'],
            ['nombre' => 'Vestido de playa lino',      'precio' => 899,  'categorias' => ['Vestidos'],             'img' => $imagenes['vestidos'][2],   'oferta' => true,  'precio_oferta' => 699, 'tallas' => ['S','M','L','XL'],          'colores' => ['Blanco','Beige','Azul cielo'], 'desc' => 'Vestido largo de lino, ligero y fresco para la playa o el resort.'],
            ['nombre' => 'Vestido envolvente terracota','precio' => 1099,'categorias' => ['Vestidos'],             'img' => $imagenes['vestidos'][3],   'oferta' => false, 'tallas' => ['S','M','L'],               'colores' => ['Terracota','Café'],         'desc' => 'Corte envolvente que favorece la figura con tono terracota tendencia.'],
            ['nombre' => 'Vestido mini satinado',      'precio' => 1299, 'categorias' => ['Vestidos', 'Lo nuevo'], 'img' => $imagenes['vestidos'][4],   'oferta' => false, 'tallas' => ['XS','S','M'],              'colores' => ['Champagne','Negro'],       'desc' => 'Mini vestido de tela satinada, elegante y versátil para noche.'],

            // ── JEANS ─────────────────────────────────────────────────────
            ['nombre' => 'Jeans skinny azul oscuro',   'precio' => 799,  'categorias' => ['Jeans', 'Ropa'],        'img' => $imagenes['jeans'][0],      'oferta' => false, 'tallas' => ['XS','S','M','L','XL'],    'colores' => ['Azul marino'],             'desc' => 'Jeans skinny de corte ajustado en denim azul oscuro de alta calidad.'],
            ['nombre' => 'Jeans mom fit beige',        'precio' => 849,  'categorias' => ['Jeans', 'Lo nuevo'],    'img' => $imagenes['jeans'][1],      'oferta' => false, 'tallas' => ['S','M','L','XL'],          'colores' => ['Beige','Crema'],           'desc' => 'Jeans mom fit en tono beige, cómodos y tendencia esta temporada.'],
            ['nombre' => 'Jeans wide leg negro',       'precio' => 899,  'categorias' => ['Jeans'],                'img' => $imagenes['jeans'][2],      'oferta' => true,  'precio_oferta' => 699, 'tallas' => ['S','M','L'],               'colores' => ['Negro','Antracita'],       'desc' => 'Jeans de pierna ancha en negro, el corte más cómodo de la temporada.'],
            ['nombre' => 'Jeans rotos efecto desgaste','precio' => 749,  'categorias' => ['Jeans'],                'img' => $imagenes['jeans'][3],      'oferta' => false, 'tallas' => ['XS','S','M','L'],          'colores' => ['Azul'],                   'desc' => 'Efecto desgaste natural con rotos en rodillas, look urbano y casual.'],

            // ── FALDAS ────────────────────────────────────────────────────
            ['nombre' => 'Falda midi plisada beis',    'precio' => 699,  'categorias' => ['Faldas', 'Lo nuevo'],   'img' => $imagenes['faldas'][0],     'oferta' => false, 'tallas' => ['XS','S','M','L'],          'colores' => ['Beige','Crema','Camel'],   'desc' => 'Falda midi plisada de caída elegante, perfecta para la oficina.'],
            ['nombre' => 'Falda mini cuadros',         'precio' => 599,  'categorias' => ['Faldas'],               'img' => $imagenes['faldas'][1],     'oferta' => true,  'precio_oferta' => 449, 'tallas' => ['XS','S','M'],              'colores' => ['Negro','Blanco'],          'desc' => 'Clásico estampado de cuadros en falda mini de corte recto.'],
            ['nombre' => 'Falda larga bohemia',        'precio' => 799,  'categorias' => ['Faldas'],               'img' => $imagenes['faldas'][2],     'oferta' => false, 'tallas' => ['S','M','L','XL'],          'colores' => ['Terracota','Mostaza'],     'desc' => 'Falda maxi con vuelo y detalles bordados, estilo boho-chic.'],

            // ── TOPS ──────────────────────────────────────────────────────
            ['nombre' => 'Top ribana sin mangas',      'precio' => 299,  'categorias' => ['Tops', 'Lo nuevo'],     'img' => $imagenes['tops'][0],       'oferta' => false, 'tallas' => ['XS','S','M','L','XL'],    'colores' => ['Negro','Blanco','Burdeos'],'desc' => 'Top de ribana ajustado, básico imprescindible en cualquier temporada.'],
            ['nombre' => 'Crop top canalé',            'precio' => 349,  'categorias' => ['Tops'],                 'img' => $imagenes['tops'][1],       'oferta' => true,  'precio_oferta' => 249, 'tallas' => ['XS','S','M'],              'colores' => ['Beige','Rosa','Lavanda'],  'desc' => 'Crop top de tejido canalé elástico, ideal para combinar con faldas o jeans.'],
            ['nombre' => 'Top drapeado frontal',       'precio' => 449,  'categorias' => ['Tops'],                 'img' => $imagenes['tops'][2],       'oferta' => false, 'tallas' => ['S','M','L'],               'colores' => ['Crema','Terracota'],       'desc' => 'Top con detalle de drapeado frontal que estiliza la figura.'],

            // ── ABRIGOS ───────────────────────────────────────────────────
            ['nombre' => 'Gabardina camel clásica',    'precio' => 2499, 'categorias' => ['Abrigos', 'Lo nuevo'],  'img' => $imagenes['abrigos'][0],    'oferta' => false, 'tallas' => ['XS','S','M','L','XL'],    'colores' => ['Camel'],                   'desc' => 'Gabardina de corte clásico en tono camel, el básico de temporada.'],
            ['nombre' => 'Chaqueta oversized gris',    'precio' => 1599, 'categorias' => ['Abrigos'],              'img' => $imagenes['abrigos'][1],    'oferta' => true,  'precio_oferta' => 1199,'tallas' => ['S','M','L'],               'colores' => ['Gris','Antracita'],        'desc' => 'Blazer oversize en gris jaspeado, tendencia street style.'],
            ['nombre' => 'Abrigo lana negro',          'precio' => 2199, 'categorias' => ['Abrigos'],              'img' => $imagenes['abrigos'][2],    'oferta' => false, 'tallas' => ['XS','S','M','L'],          'colores' => ['Negro'],                   'desc' => 'Abrigo largo de lana pura, cálido y elegante para el invierno.'],
            ['nombre' => 'Blazer estructurado crema',  'precio' => 1299, 'categorias' => ['Abrigos', 'Lo nuevo'],  'img' => $imagenes['abrigos'][3],    'oferta' => false, 'tallas' => ['XS','S','M','L'],          'colores' => ['Crema','Beige'],           'desc' => 'Blazer de corte estructurado, perfecto para el look business casual.'],

            // ── CALZADO ───────────────────────────────────────────────────
            ['nombre' => 'Mules de punta fina beige',  'precio' => 999,  'categorias' => ['Calzado', 'Lo nuevo'],  'img' => $imagenes['calzado'][0],    'oferta' => false, 'tallas' => ['35','36','37','38','39'], 'colores' => ['Beige','Negro'],           'desc' => 'Mules de punta fina con tacón bajo, elegantes y cómodas.'],
            ['nombre' => 'Tenis chunky blanco',        'precio' => 1399, 'categorias' => ['Calzado'],              'img' => $imagenes['calzado'][1],    'oferta' => false, 'tallas' => ['35','36','37','38','39','40'], 'colores' => ['Blanco'],            'desc' => 'Tenis de suela gruesa (chunky), tendencia streetwear de la temporada.'],
            ['nombre' => 'Sandalias strappy nude',     'precio' => 849,  'categorias' => ['Calzado'],              'img' => $imagenes['calzado'][2],    'oferta' => true,  'precio_oferta' => 649, 'tallas' => ['35','36','37','38'],       'colores' => ['Beige','Negro'],           'desc' => 'Sandalias de tiras cruzadas en tono nude, ideales para verano.'],
            ['nombre' => 'Botines Chelsea negros',     'precio' => 1599, 'categorias' => ['Calzado'],              'img' => $imagenes['calzado'][3],    'oferta' => false, 'tallas' => ['35','36','37','38','39'], 'colores' => ['Negro'],                   'desc' => 'Botines Chelsea de cuero genuino con elástico lateral.'],
            ['nombre' => 'Zapatillas slip-on',         'precio' => 699,  'categorias' => ['Calzado'],              'img' => $imagenes['calzado'][4],    'oferta' => true,  'precio_oferta' => 549, 'tallas' => ['35','36','37','38','39','40'], 'colores' => ['Negro','Gris claro'],  'desc' => 'Zapatillas sin cordones, cómodas y minimalistas para el uso diario.'],
            ['nombre' => 'Tacones bloque nude',        'precio' => 1199, 'categorias' => ['Calzado'],              'img' => $imagenes['calzado'][0],    'oferta' => false, 'tallas' => ['35','36','37','38','39'], 'colores' => ['Beige','Camel'],           'desc' => 'Tacón bloque que ofrece comodidad sin sacrificar la elegancia.'],
            ['nombre' => 'Sneakers retro blanco roto', 'precio' => 1099, 'categorias' => ['Calzado', 'Lo nuevo'],  'img' => $imagenes['calzado'][1],    'oferta' => false, 'tallas' => ['35','36','37','38','39','40'], 'colores' => ['Crema','Blanco'],      'desc' => 'Sneakers de corte retro en blanco roto, básico del guardarropa.'],

            // ── ACCESORIOS ────────────────────────────────────────────────
            ['nombre' => 'Bolso tote canvas negro',    'precio' => 599,  'categorias' => ['Accesorios'],           'img' => $imagenes['accesorios'][0], 'oferta' => false, 'tallas' => [],                          'colores' => ['Negro','Crema'],           'desc' => 'Tote bag de canvas resistente, espacioso y elegante.'],
            ['nombre' => 'Cartera piel sintética',     'precio' => 449,  'categorias' => ['Accesorios'],           'img' => $imagenes['accesorios'][1], 'oferta' => true,  'precio_oferta' => 349, 'tallas' => [],  'colores' => ['Negro','Café','Camel'],    'desc' => 'Cartera compacta de piel sintética con múltiples compartimentos.'],
            ['nombre' => 'Cinturón trenzado camel',    'precio' => 349,  'categorias' => ['Accesorios'],           'img' => $imagenes['accesorios'][2], 'oferta' => false, 'tallas' => [],                          'colores' => ['Camel','Negro'],           'desc' => 'Cinturón trenzado de cuero, detalle que transforma cualquier look.'],
            ['nombre' => 'Pañuelo seda estampado',     'precio' => 299,  'categorias' => ['Accesorios', 'Lo nuevo'],'img' => $imagenes['accesorios'][3],'oferta' => false, 'tallas' => [],                          'colores' => ['Rosa','Azul cielo','Beige'],'desc' => 'Pañuelo de seda con estampado geométrico, mil usos y mucho estilo.'],
            ['nombre' => 'Sombrero ala ancha beige',   'precio' => 499,  'categorias' => ['Accesorios'],           'img' => $imagenes['accesorios'][0], 'oferta' => false, 'tallas' => [],                          'colores' => ['Beige','Negro'],           'desc' => 'Sombrero de ala ancha en paja natural, perfecto para playa o festival.'],
            ['nombre' => 'Gafas de sol cat-eye',       'precio' => 399,  'categorias' => ['Accesorios'],           'img' => $imagenes['accesorios'][1], 'oferta' => true,  'precio_oferta' => 299, 'tallas' => [],  'colores' => ['Negro','Café'],            'desc' => 'Gafas de sol cat-eye de acetato, icónicas y atemporales.'],

            // ── ROPA ────────────────────────────────────────────────
            ['nombre' => 'Conjunto lino pantalón-blusa','precio' => 1299,'categorias' => ['Ropa', 'Lo nuevo'],     'img' => $imagenes['blusas'][0],     'oferta' => false, 'tallas' => ['S','M','L'],               'colores' => ['Beige','Blanco'],          'desc' => 'Conjunto de dos piezas en lino: pantalón palazzo y blusa suelta.'],
            ['nombre' => 'Jumpsuit negro manga larga',  'precio' => 1199,'categorias' => ['Ropa'],                 'img' => $imagenes['vestidos'][1],   'oferta' => true,  'precio_oferta' => 949, 'tallas' => ['XS','S','M','L'],          'colores' => ['Negro'],                   'desc' => 'Mono largo de manga larga, elegante y práctico para cualquier ocasión.'],
            ['nombre' => 'Mameluco casual denim',      'precio' => 999,  'categorias' => ['Ropa'],                 'img' => $imagenes['jeans'][0],      'oferta' => false, 'tallas' => ['XS','S','M','L'],          'colores' => ['Azul','Azul marino'],      'desc' => 'Mameluco de denim versátil, look completo en una sola prenda.'],
            ['nombre' => 'Conjunto deportivo verde',   'precio' => 1099, 'categorias' => ['Ropa'],                 'img' => $imagenes['tops'][0],       'oferta' => true,  'precio_oferta' => 849, 'tallas' => ['XS','S','M','L','XL'],    'colores' => ['Verde','Verde militar'],   'desc' => 'Set deportivo de legging y top combinados, cómodo y estilizado.'],
            ['nombre' => 'Camisa de rayas marineras',  'precio' => 649,  'categorias' => ['Ropa', 'Lo nuevo'],     'img' => $imagenes['blusas'][2],     'oferta' => false, 'tallas' => ['XS','S','M','L','XL'],    'colores' => ['Azul marino','Blanco'],    'desc' => 'Camisa de rayas marineras clásica en algodón de alta calidad.'],
            ['nombre' => 'Cardigan tejido café',       'precio' => 899,  'categorias' => ['Ropa'],                 'img' => $imagenes['abrigos'][1],    'oferta' => false, 'tallas' => ['XS','S','M','L','XL'],    'colores' => ['Café','Camel','Beige'],    'desc' => 'Cardigan de punto grueso, cálido y perfecto para el entretiempo.'],
            ['nombre' => 'Suéter oversize crema',      'precio' => 799,  'categorias' => ['Ropa'],                 'img' => $imagenes['abrigos'][3],    'oferta' => true,  'precio_oferta' => 629, 'tallas' => ['XS','S','M','L'],          'colores' => ['Crema','Gris claro'],      'desc' => 'Suéter oversize de tejido suave, estilo relajado y muy cómodo.'],
            ['nombre' => 'Pantalón palazzo negro',     'precio' => 849,  'categorias' => ['Ropa', 'Lo nuevo'],     'img' => $imagenes['faldas'][0],     'oferta' => false, 'tallas' => ['XS','S','M','L','XL'],    'colores' => ['Negro'],                   'desc' => 'Pantalón de pierna ancha tipo palazzo, fluido y elegante.'],
            ['nombre' => 'Short denim desgastado',     'precio' => 499,  'categorias' => ['Ropa', 'Jeans'],        'img' => $imagenes['jeans'][3],      'oferta' => true,  'precio_oferta' => 369, 'tallas' => ['XS','S','M','L'],          'colores' => ['Azul','Azul marino'],      'desc' => 'Short de denim con efecto desgastado, casual y fresco para el verano.'],
            ['nombre' => 'Chaleco acolchado camel',    'precio' => 999,  'categorias' => ['Ropa', 'Lo nuevo'],     'img' => $imagenes['abrigos'][0],    'oferta' => false, 'tallas' => ['XS','S','M','L','XL'],    'colores' => ['Camel','Negro'],           'desc' => 'Chaleco acolchado sin mangas, ligero y abrigador para el otoño.'],
            ['nombre' => 'Legging sport negro',        'precio' => 499,  'categorias' => ['Ropa'],                 'img' => $imagenes['jeans'][2],      'oferta' => false, 'tallas' => ['XS','S','M','L','XL','XXL'],'colores' => ['Negro'],                'desc' => 'Legging deportivo de alto rendimiento con tejido compresivo.'],
            ['nombre' => 'Camiseta básica algodón',    'precio' => 249,  'categorias' => ['Tops', 'Ropa'],         'img' => $imagenes['tops'][2],       'oferta' => false, 'tallas' => ['XS','S','M','L','XL','XXL'],'colores' => ['Negro','Blanco','Gris','Burdeos','Azul marino'], 'desc' => 'Camiseta básica de algodón pima, suave y duradera.'],
        ];

        // IDs
        $catMap   = DB::table('categorias')->pluck('id', 'nombre')->toArray();
        $tallaMap = DB::table('tallas')->pluck('id', 'nombre')->toArray();
        $colorMap = DB::table('colores')->pluck('id', 'nombre')->toArray();

        foreach ($productos as $p) {
            $slug = Str::slug($p['nombre']) . '-' . Str::random(4);

            // Insertar o actualizar producto
            DB::table('productos')->updateOrInsert(
                ['nombre' => $p['nombre']],
                [
                    'nombre'        => $p['nombre'],
                    'slug'          => $slug,
                    'descripcion'   => $p['desc'] ?? ($p['nombre'] . ' — producto de alta calidad.'),
                    'precio'        => $p['precio'],
                    'oferta'        => $p['oferta'] ?? false,
                    'precio_oferta' => $p['precio_oferta'] ?? null,
                    'imagen'        => $p['img'] ?? null,
                    'activo'        => true,
                    'created_at'    => now()->subDays(rand(0, 120)),
                    'updated_at'    => now(),
                ]
            );

            $productoId = DB::table('productos')->where('nombre', $p['nombre'])->value('id');

            // Categorías
            foreach (($p['categorias'] ?? []) as $catNombre) {
                $catId = $catMap[$catNombre] ?? null;
                if ($catId) {
                    DB::table('categoria_producto')->updateOrInsert(
                        ['producto_id' => $productoId, 'categoria_id' => $catId],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }

            // Tallas
            foreach (($p['tallas'] ?? []) as $tallaNombre) {
                $tallaId = $tallaMap[$tallaNombre] ?? null;
                if ($tallaId) {
                    DB::table('producto_talla')->updateOrInsert(
                        ['producto_id' => $productoId, 'talla_id' => $tallaId],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }

            // Colores
            foreach (($p['colores'] ?? []) as $colorNombre) {
                $colorId = $colorMap[$colorNombre] ?? null;
                if ($colorId) {
                    DB::table('color_producto')->updateOrInsert(
                        ['producto_id' => $productoId, 'color_id' => $colorId],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }
        }

        $this->command->info('✓ 50 productos creados con imágenes, tallas y colores');
    }
}