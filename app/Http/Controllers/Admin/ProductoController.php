<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\ImagenProducto;
use App\Models\Producto;
use App\Models\Talla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with('categorias')->withTrashed();

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'activo') $query->where('activo', true)->whereNull('deleted_at');
            elseif ($request->estado === 'inactivo') $query->where('activo', false)->whereNull('deleted_at');
            elseif ($request->estado === 'eliminado') $query->onlyTrashed();
        }

        $productos = $query->latest()->paginate(20)->withQueryString();

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $tallas     = Talla::orderBy('nombre')->get();
        $colores    = Color::orderBy('nombre')->get();

        return view('admin.productos.create', compact('categorias', 'tallas', 'colores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'precio'        => 'required|numeric|min:0',
            'oferta'        => 'boolean',
            'precio_oferta' => 'nullable|numeric|min:0',
            'activo'        => 'boolean',
            'imagen'        => 'nullable|image|max:4096',
            'galeria.*'     => 'nullable|image|max:4096',
            'categorias'    => 'nullable|array',
            'tallas'        => 'nullable|array',
            'colores'       => 'nullable|array',
        ]);

        $data['slug']   = Str::slug($data['nombre']) . '-' . Str::random(5);
        $data['oferta'] = $request->boolean('oferta');
        $data['activo'] = $request->boolean('activo', true);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        // Galería solo se guarda en imagenes_producto, no en $data
        unset($data['galeria']);

        $producto = Producto::create($data);

        // Galería: hasta 3 imágenes adicionales
        if ($request->hasFile('galeria')) {
            foreach (array_slice($request->file('galeria'), 0, 3) as $idx => $img) {
                $url = $img->store('productos', 'public');
                $producto->imagenes()->create([
                    'url'       => $url,
                    'orden'     => $idx + 1,
                    'principal' => false,
                ]);
            }
        }

        if ($request->filled('categorias')) {
            $producto->categorias()->sync($request->categorias);
        }
        if ($request->filled('tallas')) {
            $producto->tallas()->sync($request->tallas);
        }
        if ($request->filled('colores')) {
            $producto->colores()->sync($request->colores);
        }

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias          = Categoria::orderBy('nombre')->get();
        $tallas              = Talla::orderBy('nombre')->get();
        $colores             = Color::orderBy('nombre')->get();
        $categoriasSeleccionadas = $producto->categorias->pluck('id')->toArray();
        $tallasSeleccionadas     = $producto->tallas->pluck('id')->toArray();
        $coloresSeleccionados    = $producto->colores->pluck('id')->toArray();
        $imagenes            = $producto->imagenes()->orderBy('orden')->get();

        return view('admin.productos.edit', compact(
            'producto', 'categorias', 'tallas', 'colores',
            'categoriasSeleccionadas', 'tallasSeleccionadas', 'coloresSeleccionados',
            'imagenes'
        ));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'precio'        => 'required|numeric|min:0',
            'oferta'        => 'boolean',
            'precio_oferta' => 'nullable|numeric|min:0',
            'activo'        => 'boolean',
            'imagen'        => 'nullable|image|max:4096',
            'galeria.*'     => 'nullable|image|max:4096',
            'categorias'    => 'nullable|array',
            'tallas'        => 'nullable|array',
            'colores'       => 'nullable|array',
        ]);

        $data['oferta'] = $request->boolean('oferta');
        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && !str_starts_with($producto->imagen, 'http')) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        unset($data['galeria']);
        $producto->update($data);

        // Galería: agregar nuevas (hasta completar 3 en total)
        if ($request->hasFile('galeria')) {
            $existentes = $producto->imagenes()->count();
            $disponibles = max(0, 3 - $existentes);
            foreach (array_slice($request->file('galeria'), 0, $disponibles) as $idx => $img) {
                $url = $img->store('productos', 'public');
                $producto->imagenes()->create([
                    'url'       => $url,
                    'orden'     => $existentes + $idx + 1,
                    'principal' => false,
                ]);
            }
        }

        $producto->categorias()->sync($request->input('categorias', []));
        $producto->tallas()->sync($request->input('tallas', []));
        $producto->colores()->sync($request->input('colores', []));

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return back()->with('success', 'Producto eliminado.');
    }

    public function restore($id)
    {
        Producto::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Producto restaurado.');
    }

    public function destroyImagen(Producto $producto, ImagenProducto $imagen)
    {
        abort_if($imagen->producto_id !== $producto->id, 403);

        if ($imagen->url && !str_starts_with($imagen->url, 'http')) {
            Storage::disk('public')->delete($imagen->url);
        }

        $imagen->delete();

        return back()->with('success', 'Imagen de galería eliminada.');
    }
}
