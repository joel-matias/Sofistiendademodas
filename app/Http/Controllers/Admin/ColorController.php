<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100|unique:colores,nombre',
            'hex'    => 'nullable|string|max:10',
        ]);
        $data['slug'] = Str::slug($data['nombre']);
        Color::create($data);
        return redirect()->route('admin.colores.index')->with('success', 'Color creado.');
    }

    public function edit(Color $color)
    {
        return view('admin.colores.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100|unique:colores,nombre,' . $color->id,
            'hex'    => 'nullable|string|max:10',
        ]);
        $data['slug'] = Str::slug($data['nombre']);
        $color->update($data);
        return redirect()->route('admin.colores.index')->with('success', 'Color actualizado.');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return back()->with('success', 'Color eliminado.');
    }
}
