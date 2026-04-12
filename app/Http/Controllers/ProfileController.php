<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileInfoRequest;
use App\Http\Requests\UpdateProfilePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $sesiones = DB::table('sessions')
            ->where('user_id', auth()->id())
            ->orderByDesc('last_activity')
            ->get()
            ->map(function ($sesion) {
                return (object) [
                    'id' => $sesion->id,
                    'ip' => $sesion->ip_address ?? 'Desconocida',
                    'dispositivo' => $this->parsearUserAgent($sesion->user_agent ?? ''),
                    'ultima_vez' => \Carbon\Carbon::createFromTimestamp($sesion->last_activity)->diffForHumans(),
                    'es_actual' => $sesion->id === session()->getId(),
                ];
            });

        return view('perfil.index', compact('sesiones'));
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

    public function destroySession(string $sessionId): RedirectResponse
    {
        $deleted = DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', auth()->id())
            ->where('id', '!=', session()->getId())
            ->delete();

        if ($deleted) {
            // Rotar el remember_token para invalidar las cookies "Recordarme"
            // del dispositivo cerrado. Sin esto, Laravel recrearía la sesión
            // automáticamente usando la cookie remember_me aunque la sesión
            // haya sido eliminada de la base de datos.
            auth()->user()->forceFill(['remember_token' => Str::random(60)])->save();
        }

        return back()->with('success', 'Sesión cerrada correctamente.');
    }

    private function parsearUserAgent(string $ua): string
    {
        $os = 'Dispositivo desconocido';

        if (str_contains($ua, 'iPhone')) {
            $os = 'iPhone';
        } elseif (str_contains($ua, 'iPad')) {
            $os = 'iPad';
        } elseif (str_contains($ua, 'Android')) {
            $os = 'Android';
        } elseif (str_contains($ua, 'Windows')) {
            $os = 'Windows';
        } elseif (str_contains($ua, 'Macintosh') || str_contains($ua, 'Mac OS')) {
            $os = 'Mac';
        } elseif (str_contains($ua, 'Linux')) {
            $os = 'Linux';
        }

        $browser = '';

        if (str_contains($ua, 'Edg/')) {
            $browser = 'Edge';
        } elseif (str_contains($ua, 'OPR/') || str_contains($ua, 'Opera')) {
            $browser = 'Opera';
        } elseif (str_contains($ua, 'Chrome/')) {
            $browser = 'Chrome';
        } elseif (str_contains($ua, 'Firefox/')) {
            $browser = 'Firefox';
        } elseif (str_contains($ua, 'Safari/')) {
            $browser = 'Safari';
        }

        return $browser ? "{$os} · {$browser}" : $os;
    }
}
