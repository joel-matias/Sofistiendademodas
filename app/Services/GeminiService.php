<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiService
{
    private string $provider;

    private string $apiKey;

    private string $model;

    private string $visionModel;

    public function __construct()
    {
        $this->provider = config('services.ai.provider', 'groq');

        if ($this->provider === 'groq') {
            $this->apiKey = config('services.ai.groq_key', '');
            $this->model = config('services.ai.groq_model', 'llama-3.3-70b-versatile');
            $this->visionModel = config('services.ai.groq_vision_model', 'meta-llama/llama-4-scout-17b-16e-instruct');
        } else {
            $this->apiKey = config('services.gemini.key', '');
            $this->model = config('services.gemini.model', 'gemini-2.0-flash');
            $this->visionModel = config('services.gemini.model', 'gemini-2.0-flash');
        }
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiKey);
    }

    /**
     * Genera una descripción de producto para una tienda de moda.
     *
     * @param  array{nombre: string, categorias?: string[], tallas?: string[], colores?: string[], imagen_base64?: string|null, imagen_mime?: string, imagen_url?: string|null}  $datos
     *
     * @throws RuntimeException
     */
    public function generarDescripcionProducto(array $datos): string
    {
        $prompt = $this->construirPromptDescripcion($datos);
        $imagenBase64 = $datos['imagen_base64'] ?? null;
        $imagenMime = $datos['imagen_mime'] ?? 'image/jpeg';
        $imagenUrl = $datos['imagen_url'] ?? null;

        return $this->generarConImagen($prompt, $imagenBase64, $imagenMime, $imagenUrl);
    }

    /**
     * Envía un prompt (con imagen opcional) al proveedor configurado y devuelve el texto generado.
     *
     * @throws RuntimeException
     */
    public function generarConImagen(string $prompt, ?string $imagenBase64 = null, string $imagenMime = 'image/jpeg', ?string $imagenUrl = null): string
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('La clave de API de IA no está configurada. Revisa el archivo .env.');
        }

        return $this->provider === 'groq'
            ? $this->llamarGroq($prompt, $imagenBase64, $imagenMime, $imagenUrl)
            : $this->llamarGemini($prompt, $imagenBase64, $imagenMime, $imagenUrl);
    }

    /**
     * Envía un prompt de solo texto al proveedor configurado y devuelve el texto generado.
     *
     * @throws RuntimeException
     */
    public function generar(string $prompt): string
    {
        return $this->generarConImagen($prompt);
    }

    // ─── Proveedores ──────────────────────────────────────────────────────────

    private function llamarGroq(string $prompt, ?string $imagenBase64 = null, string $imagenMime = 'image/jpeg', ?string $imagenUrl = null): string
    {
        // Solo aceptar URLs públicas (https) para evitar intentos de conexión a localhost
        $urlPublica = ($imagenUrl !== null && str_starts_with($imagenUrl, 'https://')) ? $imagenUrl : null;
        $tieneImagen = $imagenBase64 !== null || $urlPublica !== null;

        if ($tieneImagen) {
            $contenidoTexto = ['type' => 'text', 'text' => $prompt];

            if ($imagenBase64 !== null) {
                $contenidoImagen = ['type' => 'image_url', 'image_url' => ['url' => "data:{$imagenMime};base64,{$imagenBase64}"]];
            } else {
                $contenidoImagen = ['type' => 'image_url', 'image_url' => ['url' => $urlPublica]];
            }

            $content = [$contenidoImagen, $contenidoTexto];
            $model = $this->visionModel;
        } else {
            $content = $prompt;
            $model = $this->model;
        }

        try {
            $response = Http::timeout(30)
                ->withToken($this->apiKey)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => $model,
                    'temperature' => 0.7,
                    'max_tokens' => 300,
                    'messages' => [
                        ['role' => 'user', 'content' => $content],
                    ],
                ]);
        } catch (ConnectionException) {
            throw new RuntimeException('No se pudo conectar con la API de Groq. Verifica tu conexión.');
        }

        if ($response->failed()) {
            $error = $response->json('error.message', 'Error desconocido');
            throw new RuntimeException("Error de la API de Groq: {$error}");
        }

        $texto = $response->json('choices.0.message.content');

        if (empty($texto)) {
            throw new RuntimeException('La API no devolvió texto. Intenta de nuevo.');
        }

        return trim($texto);
    }

    private function llamarGemini(string $prompt, ?string $imagenBase64 = null, string $imagenMime = 'image/jpeg', ?string $imagenUrl = null): string
    {
        $base = 'https://generativelanguage.googleapis.com/v1beta/models';

        $parts = [];
        $urlPublica = ($imagenUrl !== null && str_starts_with($imagenUrl, 'https://')) ? $imagenUrl : null;

        if ($imagenBase64 !== null) {
            $parts[] = ['inlineData' => ['mimeType' => $imagenMime, 'data' => $imagenBase64]];
        } elseif ($urlPublica !== null) {
            $parts[] = ['fileData' => ['mimeType' => $imagenMime, 'fileUri' => $urlPublica]];
        }

        $parts[] = ['text' => $prompt];

        try {
            $response = Http::timeout(30)
                ->post("{$base}/{$this->model}:generateContent?key={$this->apiKey}", [
                    'contents' => [['parts' => $parts]],
                    'generationConfig' => ['temperature' => 0.7, 'maxOutputTokens' => 300],
                    'safetySettings' => [
                        ['category' => 'HARM_CATEGORY_HARASSMENT',        'threshold' => 'BLOCK_NONE'],
                        ['category' => 'HARM_CATEGORY_HATE_SPEECH',       'threshold' => 'BLOCK_NONE'],
                        ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_NONE'],
                        ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_NONE'],
                    ],
                ]);
        } catch (ConnectionException) {
            throw new RuntimeException('No se pudo conectar con la API de Gemini. Verifica tu conexión.');
        }

        if ($response->failed()) {
            $error = $response->json('error.message', 'Error desconocido');
            throw new RuntimeException("Error de la API de Gemini: {$error}");
        }

        $texto = $response->json('candidates.0.content.parts.0.text');

        if (empty($texto)) {
            throw new RuntimeException('La API no devolvió texto. Intenta de nuevo.');
        }

        return trim($texto);
    }

    // ─── Prompt ───────────────────────────────────────────────────────────────

    private function construirPromptDescripcion(array $datos): string
    {
        $nombre = $datos['nombre'] ?? '';
        $cats = implode(', ', $datos['categorias'] ?? []);
        $tallas = implode(', ', $datos['tallas'] ?? []);
        $colores = implode(', ', $datos['colores'] ?? []);
        $tieneImagen = ! empty($datos['imagen_base64']) || ! empty($datos['imagen_url']);

        $contexto = collect([
            $cats ? "Categorías: {$cats}" : null,
            $tallas ? "Tallas disponibles: {$tallas}" : null,
            $colores ? "Colores disponibles: {$colores}" : null,
        ])->filter()->implode("\n");

        $instruccionImagen = $tieneImagen
            ? 'Se te proporciona también una imagen de la prenda — úsala para enriquecer la descripción con detalles visuales concretos (silueta, tejido aparente, estampado, acabados, etc.) de ser posiible basate mas en la imagen y el titulo.'
            : '';

        return <<<PROMPT
        Eres el copywriter de "Sofis Tienda de Modas", una boutique de moda femenina con estilo sofisticado y accesible.

        Tu tarea es escribir la descripción que aparecerá en la página de detalle del producto dentro del catálogo en línea de la tienda. La descripción debe ayudar a la clienta a imaginarse usando la prenda: cómo le queda, para qué ocasión sirve y por qué la querrá.

        {$instruccionImagen}

        Datos de la prenda:
        Nombre: {$nombre}
        {$contexto}

        Reglas estrictas:
        - Máximo 1 oraciones, fluidas y naturales
        - Tono cálido, elegante y femenino, sin exagerar
        - Resalta el estilo, la comodidad o la versatilidad según corresponda
        - No uses emojis, asteriscos ni formato markdown
        - No menciones precio ni tallas en la descripción
        - Devuelve SOLO el texto de la descripción, sin comillas ni explicaciones adicionales

        Descripción:
        PROMPT;
    }
}
