<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'imagen',
    ];

    /**
     * ✅ Una categoría puede tener muchos productos (many-to-many).
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,
            'categoria_producto',   // ✅ tu pivote real
            'categoria_id',
            'producto_id'
        )
            ->withTimestamps();
    }
}
