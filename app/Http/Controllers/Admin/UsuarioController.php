<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('name')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function updateRole(Request $request, User $usuario)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        // No permite que un admin se quite sus propios permisos
        if ($usuario->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'No puedes quitarte los permisos de administrador.');
        }

        $usuario->update(['role' => $request->role]);

        $label = $request->role === 'admin' ? 'ascendido a administrador' : 'removido del rol de administrador';
        return back()->with('success', "Usuario {$usuario->name} {$label}.");
    }
}
