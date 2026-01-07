<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

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

    /**
     * ✅ Un producto puede tener varias categorías (many-to-many).
     */
    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Categoria::class,
            'categoria_producto',     // ✅ tu pivote real
            'producto_id',
            'categoria_id'
        )
            ->withTimestamps();
    }

    /**
     * Imágenes del producto.
     */
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenProducto::class, 'producto_id')
            ->orderBy('orden');
    }

    /**
     * Usuarios que marcaron este producto como favorito.
     */
    public function favoritosUsuarios(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'favoritos', 'producto_id', 'user_id')
            ->withTimestamps();
    }
}
