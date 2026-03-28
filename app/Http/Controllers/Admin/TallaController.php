<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TallaRequest;
use App\Models\Talla;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TallaController extends Controller
{
    public function index()
    {
        $tallas = Talla::withCount('productos')->orderBy('nombre')->get();
        return view('admin.tallas.index', compact('tallas'));
    }

    public function create()
    {
        return view('admin.tallas.create');
    }

    public function store(TallaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['nombre']);
            Talla::create($data);
            return redirect()->route('admin.tallas.index')->with('success', 'Talla creada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear talla', ['error' => $e->getMessage(), 'usuario' => auth()->id()]);
            return back()->with('error', 'Ocurrió un error al guardar la talla. Por favor, intenta de nuevo.');
        }
    }

    public function edit(Talla $talla)
    {
        return view('admin.tallas.edit', compact('talla'));
    }

    public function update(TallaRequest $request, Talla $talla)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['nombre']);
            $talla->update($data);
            return redirect()->route('admin.tallas.index')->with('success', 'Talla actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar talla', [
                'talla'   => $talla->id,
                'error'   => $e->getMessage(),
                'usuario' => auth()->id(),
            ]);
            return back()->with('error', 'Ocurrió un error al guardar los cambios. Por favor, intenta de nuevo.');
        }
    }

    public function destroy(Talla $talla)
    {
        try {
            $talla->delete();
            return back()->with('success', 'Talla eliminada.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar talla', ['talla' => $talla->id, 'error' => $e->getMessage()]);
            return back()->with('error', 'No se pudo eliminar la talla. Por favor, intenta de nuevo.');
        }
    }
}
