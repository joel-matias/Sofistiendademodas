<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerificarEmail extends VerifyEmail
{
    /**
     * Sobreescribe el mensaje de correo de verificación con contenido en español.
     * Se llama desde User::sendEmailVerificationNotification() al registrar un nuevo usuario.
     */
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifica tu correo electrónico — Sofis Tienda de Modas')
            ->greeting('¡Hola!')
            ->line('Gracias por registrarte en **Sofis Tienda de Modas**.')
            ->line('Haz clic en el botón de abajo para verificar tu dirección de correo electrónico.')
            ->action('Verificar correo', $url)
            ->line('Este enlace de verificación expirará en **60 minutos**.')
            ->line('Si no creaste una cuenta en Sofis, puedes ignorar este mensaje.')
            ->salutation('Con cariño, el equipo de Sofis Tienda de Modas ✦');
    }
}
