<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoverController extends Controller
{
    public function index()
    {
        $covers = Cover::orderBy('orden')->get();
        return view('admin.covers.index', compact('covers'));
    }

    public function create()
    {
        return view('admin.covers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:150',
            'subtitulo'   => 'nullable|string|max:255',
            'texto_boton' => 'nullable|string|max:80',
            'url_boton'   => 'nullable|string|max:255',
            'imagen'      => 'nullable|image|max:4096',
            'orden'       => 'required|integer|min:0',
            'activo'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('covers', 'public');
        }

        $data['activo'] = $request->boolean('activo');

        Cover::create($data);

        return redirect()->route('admin.covers.index')->with('success', 'Cover creado.');
    }

    public function edit(Cover $cover)
    {
        return view('admin.covers.edit', compact('cover'));
    }

    public function update(Request $request, Cover $cover)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:150',
            'subtitulo'   => 'nullable|string|max:255',
            'texto_boton' => 'nullable|string|max:80',
            'url_boton'   => 'nullable|string|max:255',
            'imagen'      => 'nullable|image|max:4096',
            'orden'       => 'required|integer|min:0',
            'activo'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            if ($cover->imagen && !str_starts_with($cover->imagen, 'http')) {
                Storage::disk('public')->delete($cover->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('covers', 'public');
        }

        $data['activo'] = $request->boolean('activo');

        $cover->update($data);

        return redirect()->route('admin.covers.index')->with('success', 'Cover actualizado.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orden'         => 'required|array',
            'orden.*.id'    => 'required|integer|exists:covers,id',
            'orden.*.orden' => 'required|integer|min:0',
        ]);

        foreach ($request->input('orden') as $item) {
            Cover::where('id', $item['id'])->update(['orden' => $item['orden']]);
        }

        return response()->json(['ok' => true]);
    }

    public function destroy(Cover $cover)
    {
        if ($cover->imagen && !str_starts_with($cover->imagen, 'http')) {
            Storage::disk('public')->delete($cover->imagen);
        }
        $cover->delete();

        return back()->with('success', 'Cover eliminado.');
    }
}
