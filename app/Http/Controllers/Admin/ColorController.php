<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ColorRequest;
use App\Models\Color;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ColorController extends Controller
{
    public function index()
    {
        $colores = Color::withCount('productos')->orderBy('nombre')->get();
        return view('admin.colores.index', compact('colores'));
    }

    public function create()
    {
        return view('admin.colores.create');
    }

    public function store(ColorRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['nombre']);
            Color::create($data);
            return redirect()->route('admin.colores.index')->with('success', 'Color creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear color', ['error' => $e->getMessage(), 'usuario' => auth()->id()]);
            return back()->with('error', 'Ocurrió un error al guardar el color. Por favor, intenta de nuevo.');
        }
    }

    public function edit(Color $color)
    {
        return view('admin.colores.edit', compact('color'));
    }

    public function update(ColorRequest $request, Color $color)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['nombre']);
            $color->update($data);
            return redirect()->route('admin.colores.index')->with('success', 'Color actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar color', [
                'color'   => $color->id,
                'error'   => $e->getMessage(),
                'usuario' => auth()->id(),
            ]);
            return back()->with('error', 'Ocurrió un error al guardar los cambios. Por favor, intenta de nuevo.');
        }
    }

    public function destroy(Color $color)
    {
        try {
            $color->delete();
            return back()->with('success', 'Color eliminado.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar color', ['color' => $color->id, 'error' => $e->getMessage()]);
            return back()->with('error', 'No se pudo eliminar el color. Por favor, intenta de nuevo.');
        }
    }
}
