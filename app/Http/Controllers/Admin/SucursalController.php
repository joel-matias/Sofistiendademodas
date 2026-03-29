<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SucursalRequest;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Log;

class SucursalController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $sucursales = Sucursal::withCount('productos')->orderBy('nombre')->get();

        return view('admin.sucursales.index', compact('sucursales'));
    }

    public function create(): \Illuminate\View\View
    {
        return view('admin.sucursales.create');
    }

    public function store(SucursalRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['activa'] = $request->boolean('activa', true);

            Sucursal::create($data);

            return redirect()->route('admin.sucursales.index')
                ->with('success', 'Sucursal creada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear sucursal', ['error' => $e->getMessage(), 'usuario' => auth()->id()]);

            return back()->with('error', 'Ocurrió un error al guardar la sucursal. Por favor, intenta de nuevo.');
        }
    }

    public function edit(Sucursal $sucursal): \Illuminate\View\View
    {
        return view('admin.sucursales.edit', compact('sucursal'));
    }

    public function update(SucursalRequest $request, Sucursal $sucursal): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['activa'] = $request->boolean('activa');

            $sucursal->update($data);

            return redirect()->route('admin.sucursales.index')
                ->with('success', 'Sucursal actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar sucursal', ['sucursal' => $sucursal->id, 'error' => $e->getMessage()]);

            return back()->with('error', 'Ocurrió un error al guardar los cambios. Por favor, intenta de nuevo.');
        }
    }

    public function destroy(Sucursal $sucursal): \Illuminate\Http\RedirectResponse
    {
        try {
            $sucursal->delete();

            return back()->with('success', 'Sucursal eliminada.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar sucursal', ['sucursal' => $sucursal->id, 'error' => $e->getMessage()]);

            return back()->with('error', 'No se pudo eliminar la sucursal. Por favor, intenta de nuevo.');
        }
    }
}
