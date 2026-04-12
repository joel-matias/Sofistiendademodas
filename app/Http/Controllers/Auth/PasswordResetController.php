<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    public function showForgotForm(): View
    {
        return view('auth.olvide-contrasena');
    }

    public function sendResetLink(ForgotPasswordRequest $request): RedirectResponse
    {
        // Siempre muestra el mismo mensaje, independientemente de si el correo existe.
        // Esto previene la enumeración de usuarios (no revela si un email está registrado).
        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Si existe una cuenta con ese correo, recibirás un enlace para restablecer tu contraseña en breve.');
    }

    public function showResetForm(string $token): View
    {
        return view('auth.restablecer-contrasena', ['token' => $token]);
    }

    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => $password])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', '¡Contraseña restablecida! Ya puedes iniciar sesión.');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
