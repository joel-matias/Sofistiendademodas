<?php

namespace App\Listeners;

use App\Mail\EmailVerificado;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class EnviarEmailVerificado
{
    /**
     * Escucha el evento Verified que Laravel dispara automáticamente cuando el usuario
     * hace clic en el enlace de verificación y llama a $request->fulfill().
     * Envía un correo de confirmación/bienvenida en español.
     */
    public function handle(Verified $event): void
    {
        Mail::to($event->user->email)
            ->send(new EmailVerificado($event->user));
    }
}
