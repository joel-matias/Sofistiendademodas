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

    public function destroy(User $usuario): \Illuminate\Http\RedirectResponse
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        if ($usuario->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'No puedes eliminar el único administrador del sistema.');
        }

        $nombre = $usuario->name;
        $usuario->delete();

        return back()->with('success', "Usuario {$nombre} eliminado correctamente.");
    }

    public function updateRole(Request $request, User $usuario)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $estaDemotando = $request->role === 'user' && $usuario->isAdmin();

        // No permite dejar la tienda sin ningún administrador
        if ($estaDemotando && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'No puedes eliminar el único administrador del sistema. Asigna otro administrador primero.');
        }

        $usuario->update(['role' => $request->role]);

        $label = $request->role === 'admin' ? 'ascendido a administrador' : 'removido del rol de administrador';

        return back()->with('success', "Usuario {$usuario->name} {$label}.");
    }
}
