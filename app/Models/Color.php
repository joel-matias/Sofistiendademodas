<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colores';

    protected $fillable = ['nombre', 'slug', 'hex'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'color_producto', 'color_id', 'producto_id')
            ->withTimestamps();
    }
}
