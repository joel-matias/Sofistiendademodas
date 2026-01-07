<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    protected $table = 'detalles_producto';

    protected $fillable = ['producto_id', 'texto', 'orden'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
