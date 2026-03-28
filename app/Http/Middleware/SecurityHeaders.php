<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Previene clickjacking (iframes de otros orígenes)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Previene que el navegador adivine el MIME type (MIME sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Protección XSS básica en navegadores legacy
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Controla cuánto referrer se envía en navegación externa
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Desactiva APIs de hardware sensibles no usadas en este proyecto
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Fuerza HTTPS en el navegador (habilitar solo cuando el sitio esté en producción con HTTPS)
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        return $response;
    }
}
