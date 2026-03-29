<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductoRequest;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\ImagenProducto;
use App\Models\Producto;
use App\Models\Talla;
use App\Services\ImageService;
use App\Support\CacheKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request)
    {
        $query = Producto::with('categorias')->withTrashed();

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'activo') {
                $query->where('activo', true)->whereNull('deleted_at');
            } elseif ($request->estado === 'inactivo') {
                $query->where('activo', false)->whereNull('deleted_at');
            } elseif ($request->estado === 'eliminado') {
                $query->onlyTrashed();
            }
        }

        $productos = $query->latest()->paginate(20)->withQueryString();

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $tallas = Talla::orderBy('nombre')->get();
        $colores = Color::orderBy('nombre')->get();

        return view('admin.productos.create', compact('categorias', 'tallas', 'colores'));
    }

    public function store(ProductoRequest $request)
    {
        try {
            $data = $request->validated();

            $data['slug'] = Str::slug($data['nombre']).'-'.Str::random(5);
            $data['oferta'] = $request->boolean('oferta');
            $data['activo'] = $request->boolean('activo', true);

            if ($request->hasFile('imagen')) {
                $data['imagen'] = $this->imageService->store($request->file('imagen'), 'productos', 800);
            }

            unset($data['galeria'], $data['categorias'], $data['tallas'], $data['colores']);

            $producto = Producto::create($data);

            if ($request->hasFile('galeria')) {
                foreach (array_slice($request->file('galeria'), 0, 3) as $idx => $img) {
                    $url = $this->imageService->store($img, 'productos', 800);
                    $producto->imagenes()->create([
                        'url' => $url,
                        'orden' => $idx + 1,
                        'principal' => false,
                    ]);
                }
            }

            $producto->categorias()->sync($request->input('categorias', []));
            $producto->tallas()->sync($request->input('tallas', []));
            $producto->colores()->sync($request->input('colores', []));

            // La invalidación de caché la maneja ProductoObserver automáticamente.

            return redirect()->route('admin.productos.index')
                ->with('success', 'Producto creado correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al crear producto', [
                'error' => $e->getMessage(),
                'usuario' => auth()->id(),
            ]);

            return back()->with('error', 'Ocurrió un error al guardar el producto. Por favor, intenta de nuevo.');
        }
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $tallas = Talla::orderBy('nombre')->get();
        $colores = Color::orderBy('nombre')->get();
        $categoriasSeleccionadas = $producto->categorias->pluck('id')->toArray();
        $tallasSeleccionadas = $producto->tallas->pluck('id')->toArray();
        $coloresSeleccionados = $producto->colores->pluck('id')->toArray();
        $imagenes = $producto->imagenes()->orderBy('orden')->get();

        return view('admin.productos.edit', compact(
            'producto', 'categorias', 'tallas', 'colores',
            'categoriasSeleccionadas', 'tallasSeleccionadas', 'coloresSeleccionados',
            'imagenes'
        ));
    }

    public function update(ProductoRequest $request, Producto $producto)
    {
        try {
            $data = $request->validated();

            $data['oferta'] = $request->boolean('oferta');
            $data['activo'] = $request->boolean('activo');

            if ($request->hasFile('imagen')) {
                if ($producto->imagen && ! str_starts_with($producto->imagen, 'http')) {
                    Storage::disk('public')->delete($producto->imagen);
                }
                $data['imagen'] = $this->imageService->store($request->file('imagen'), 'productos', 800);
            }

            unset($data['galeria'], $data['categorias'], $data['tallas'], $data['colores']);

            $producto->update($data);

            if ($request->hasFile('galeria')) {
                $existentes = $producto->imagenes()->count();
                $disponibles = max(0, 3 - $existentes);
                foreach (array_slice($request->file('galeria'), 0, $disponibles) as $idx => $img) {
                    $url = $this->imageService->store($img, 'productos', 800);
                    $producto->imagenes()->create([
                        'url' => $url,
                        'orden' => $existentes + $idx + 1,
                        'principal' => false,
                    ]);
                }
            }

            $producto->categorias()->sync($request->input('categorias', []));
            $producto->tallas()->sync($request->input('tallas', []));
            $producto->colores()->sync($request->input('colores', []));

            // La invalidación de caché la maneja ProductoObserver automáticamente.

            return redirect()->route('admin.productos.index')
                ->with('success', 'Producto actualizado correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al actualizar producto', [
                'producto' => $producto->id,
                'error' => $e->getMessage(),
                'usuario' => auth()->id(),
            ]);

            return back()->with('error', 'Ocurrió un error al guardar los cambios. Por favor, intenta de nuevo.');
        }
    }

    public function destroy(Producto $producto)
    {
        try {
            $producto->delete(); // ProductoObserver::deleted invalida el caché automáticamente.

            return back()->with('success', 'Producto eliminado.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar producto', [
                'producto' => $producto->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'No se pudo eliminar el producto. Por favor, intenta de nuevo.');
        }
    }

    public function restore($id)
    {
        try {
            Producto::withTrashed()->findOrFail($id)->restore();

            return back()->with('success', 'Producto restaurado.');
        } catch (\Exception $e) {
            Log::error('Error al restaurar producto', ['id' => $id, 'error' => $e->getMessage()]);

            return back()->with('error', 'No se pudo restaurar el producto. Por favor, intenta de nuevo.');
        }
    }

    public function destroyImagen(Producto $producto, ImagenProducto $imagen)
    {
        abort_if($imagen->producto_id !== $producto->id, 403);

        try {
            if ($imagen->url && ! str_starts_with($imagen->url, 'http')) {
                Storage::disk('public')->delete($imagen->url);
            }
            $imagen->delete();
            // Eliminar una imagen de galería no dispara el ProductoObserver,
            // así que invalidamos manualmente la caché del producto.
            Cache::forget(CacheKeys::producto($producto->slug));

            return back()->with('success', 'Imagen eliminada de la galería.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar imagen de galería', [
                'imagen' => $imagen->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'No se pudo eliminar la imagen. Por favor, intenta de nuevo.');
        }
    }
}
