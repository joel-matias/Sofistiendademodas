<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'precio',
        'oferta',
        'precio_oferta',
        'imagen',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'precio_oferta' => 'decimal:2',
        'oferta' => 'boolean',
        'activo' => 'boolean',
    ];

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto', 'producto_id', 'categoria_id')
            ->withTimestamps();
    }

    public function tallas(): BelongsToMany
    {
        return $this->belongsToMany(Talla::class, 'producto_talla', 'producto_id', 'talla_id')
            ->withTimestamps();
    }

    public function colores(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'color_producto', 'producto_id', 'color_id')
            ->withTimestamps();
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleProducto::class, 'producto_id')
            ->orderBy('orden');
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenProducto::class, 'producto_id')
            ->orderBy('orden');
    }

    public function sucursales(): BelongsToMany
    {
        return $this->belongsToMany(Sucursal::class, 'producto_sucursal')
            ->withTimestamps();
    }
}
