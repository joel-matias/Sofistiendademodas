<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileInfoRequest;
use App\Http\Requests\UpdateProfilePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('perfil.index');
    }

    public function updateInfo(UpdateProfileInfoRequest $request): RedirectResponse
    {
        auth()->user()->update(['name' => $request->name]);

        return back()->with('success', 'Nombre actualizado correctamente.');
    }

    public function updatePassword(UpdateProfilePasswordRequest $request): RedirectResponse
    {
        auth()->user()->update(['password' => $request->password]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}
