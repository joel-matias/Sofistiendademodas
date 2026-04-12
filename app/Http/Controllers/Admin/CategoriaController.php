<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoriaRequest;
use App\Models\Categoria;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $categorias = Categoria::withCount('productos')->orderBy('nombre')->get();

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(CategoriaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['nombre']);

            if ($request->hasFile('imagen')) {
                $data['imagen'] = $this->imageService->store($request->file('imagen'), 'categorias', 800);
            }

            Categoria::create($data); // CategoriaObserver invalida el caché automáticamente.

            return redirect()->route('admin.categorias.index')
                ->with('success', 'Categoría creada correctamente.');

        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error al crear categoría', ['error' => $e->getMessage(), 'usuario' => auth()->id()]);

            return back()->with('error', 'Ocurrió un error al guardar la categoría. Por favor, intenta de nuevo.');
        }
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['nombre']);

            if ($request->hasFile('imagen')) {
                if ($categoria->imagen && ! str_starts_with($categoria->imagen, 'http')) {
                    Storage::disk('public')->delete($categoria->imagen);
                }
                $data['imagen'] = $this->imageService->store($request->file('imagen'), 'categorias', 800);
            }

            $categoria->update($data); // CategoriaObserver invalida el caché automáticamente.

            return redirect()->route('admin.categorias.index')
                ->with('success', 'Categoría actualizada correctamente.');

        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error al actualizar categoría', [
                'categoria' => $categoria->id,
                'error' => $e->getMessage(),
                'usuario' => auth()->id(),
            ]);

            return back()->with('error', 'Ocurrió un error al guardar los cambios. Por favor, intenta de nuevo.');
        }
    }

    public function destroy(Categoria $categoria)
    {
        try {
            if ($categoria->imagen && ! str_starts_with($categoria->imagen, 'http')) {
                Storage::disk('public')->delete($categoria->imagen);
            }
            $categoria->delete(); // CategoriaObserver invalida el caché automáticamente.

            return back()->with('success', 'Categoría eliminada.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría', ['categoria' => $categoria->id, 'error' => $e->getMessage()]);

            return back()->with('error', 'No se pudo eliminar la categoría. Por favor, intenta de nuevo.');
        }
    }
}
