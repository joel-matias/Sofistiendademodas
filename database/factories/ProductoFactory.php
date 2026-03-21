<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    // Pool of fashion Unsplash images for generated products
    private static array $fashionImages = [
        'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1485462537746-965f33f7f6a7?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1554568218-0f1715e72254?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1515886657613-9a6b4c6b2b8f?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1475178626620-a4d074967452?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1583496661160-fb5218cbc86f?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1583744946564-b52ac1c389c8?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1539533018257-c4d9f476cfe8?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=800&q=80&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800&q=80&fit=crop&auto=format',
    ];

    private static array $nombresBase = [
        'Blusa', 'Vestido', 'Falda', 'Top', 'Blazer', 'Abrigo', 'Cardigan',
        'Pantalón', 'Jeans', 'Jumpsuit', 'Conjunto', 'Suéter', 'Camisa',
    ];

    private static array $adjetivos = [
        'elegante', 'clásico', 'oversize', 'midi', 'mini', 'satinado', 'estructurado',
        'fluido', 'plisado', 'bordado', 'drapeado', 'asimétrico', 'ajustado',
    ];

    private static array $coloresNombre = [
        'negro', 'blanco', 'beige', 'camel', 'crema', 'gris', 'terracota',
        'burdeos', 'azul marino', 'verde oliva', 'mostaza',
    ];

    public function definition(): array
    {
        $nombre = $this->faker->randomElement(self::$nombresBase)
            . ' '
            . $this->faker->randomElement(self::$adjetivos)
            . ' '
            . $this->faker->randomElement(self::$coloresNombre);

        $precio = $this->faker->numberBetween(249, 2499);
        $esOferta = $this->faker->boolean(25);

        return [
            'nombre'        => ucfirst($nombre),
            'slug'          => Str::slug($nombre) . '-' . Str::random(4),
            'descripcion'   => $this->faker->sentence(rand(10, 18)),
            'precio'        => $precio,
            'oferta'        => $esOferta,
            'precio_oferta' => $esOferta
                ? (int) round($precio * $this->faker->randomFloat(2, 0.55, 0.80))
                : null,
            'imagen'        => $this->faker->randomElement(self::$fashionImages),
            'activo'        => true,
        ];
    }

    public function enOferta(): static
    {
        return $this->state(function (array $attributes) {
            $precio = $attributes['precio'];

            return [
                'oferta'        => true,
                'precio_oferta' => (int) round($precio * $this->faker->randomFloat(2, 0.55, 0.75)),
            ];
        });
    }

    public function inactivo(): static
    {
        return $this->state(['activo' => false]);
    }
}
