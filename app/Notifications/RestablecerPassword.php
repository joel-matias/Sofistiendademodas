<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class RestablecerPassword extends ResetPassword
{
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('Restablece tu contraseña — Sofis Tienda de Modas')
            ->greeting('¡Hola!')
            ->line('Recibimos una solicitud para restablecer la contraseña de tu cuenta.')
            ->line('Haz clic en el botón de abajo para crear una nueva contraseña.')
            ->action('Restablecer contraseña', $url)
            ->line('Este enlace expirará en **60 minutos**.')
            ->line('Si no solicitaste restablecer tu contraseña, puedes ignorar este mensaje. Tu contraseña no cambiará.')
            ->salutation('Con cariño, el equipo de Sofis Tienda de Modas ✦');
    }
}
