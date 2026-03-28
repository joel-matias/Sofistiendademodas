<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Se envía automáticamente cuando el usuario hace clic en el enlace de verificación.
     * El listener EnviarEmailVerificado escucha el evento Verified y dispara este correo.
     */
    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Tu cuenta está lista! — Sofis Tienda de Modas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email-verificado',
        );
    }
}
