<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Talla;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:50|unique:tallas,nombre',
        ]);
        $data['slug'] = Str::slug($data['nombre']);
        Talla::create($data);
        return redirect()->route('admin.tallas.index')->with('success', 'Talla creada.');
    }

    public function edit(Talla $talla)
    {
        return view('admin.tallas.edit', compact('talla'));
    }

    public function update(Request $request, Talla $talla)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:50|unique:tallas,nombre,' . $talla->id,
        ]);
        $data['slug'] = Str::slug($data['nombre']);
        $talla->update($data);
        return redirect()->route('admin.tallas.index')->with('success', 'Talla actualizada.');
    }

    public function destroy(Talla $talla)
    {
        $talla->delete();
        return back()->with('success', 'Talla eliminada.');
    }
}
