<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoverRequest;
use App\Models\Cover;
use App\Services\ImageService;
use App\Support\CacheKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CoverController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $covers = Cover::orderBy('orden')->get();

        return view('admin.covers.index', compact('covers'));
    }

    public function create()
    {
        return view('admin.covers.create');
    }

    public function store(CoverRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('imagen')) {
                // Los covers son imágenes hero de ancho completo → 1400 px máximo
                $data['imagen'] = $this->imageService->store($request->file('imagen'), 'covers', 1400);
            }

            $data['activo'] = $request->boolean('activo');

            Cover::create($data); // CoverObserver invalida el caché automáticamente.

            return redirect()->route('admin.covers.index')->with('success', 'Cover creado correctamente.');

        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error al crear cover', ['error' => $e->getMessage(), 'usuario' => auth()->id()]);

            return back()->with('error', 'Ocurrió un error al guardar el cover. Por favor, intenta de nuevo.');
        }
    }

    public function edit(Cover $cover)
    {
        return view('admin.covers.edit', compact('cover'));
    }

    public function update(CoverRequest $request, Cover $cover)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('imagen')) {
                if ($cover->imagen && ! str_starts_with($cover->imagen, 'http')) {
                    Storage::disk('public')->delete($cover->imagen);
                }
                $data['imagen'] = $this->imageService->store($request->file('imagen'), 'covers', 1400);
            }

            $data['activo'] = $request->boolean('activo');

            $cover->update($data); // CoverObserver invalida el caché automáticamente.

            return redirect()->route('admin.covers.index')->with('success', 'Cover actualizado correctamente.');

        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error al actualizar cover', [
                'cover' => $cover->id,
                'error' => $e->getMessage(),
                'usuario' => auth()->id(),
            ]);

            return back()->with('error', 'Ocurrió un error al guardar los cambios. Por favor, intenta de nuevo.');
        }
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orden' => 'required|array',
            'orden.*.id' => 'required|integer|exists:covers,id',
            'orden.*.orden' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->input('orden') as $item) {
                Cover::where('id', $item['id'])->update(['orden' => $item['orden']]);
            }
            // reorder usa query builder (no dispara el observer), invalidamos manualmente.
            Cache::forget(CacheKeys::HOME_COVERS);

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('Error al reordenar covers', ['error' => $e->getMessage(), 'usuario' => auth()->id()]);

            return response()->json(['ok' => false, 'mensaje' => 'Error al guardar el orden.'], 500);
        }
    }

    public function destroy(Cover $cover)
    {
        try {
            if ($cover->imagen && ! str_starts_with($cover->imagen, 'http')) {
                Storage::disk('public')->delete($cover->imagen);
            }
            $cover->delete(); // CoverObserver invalida el caché automáticamente.

            return back()->with('success', 'Cover eliminado.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar cover', ['cover' => $cover->id, 'error' => $e->getMessage()]);

            return back()->with('error', 'No se pudo eliminar el cover. Por favor, intenta de nuevo.');
        }
    }
}
