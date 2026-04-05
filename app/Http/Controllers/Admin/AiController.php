<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    public function __construct(private GeminiService $gemini) {}

    public function generarDescripcion(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'categorias' => ['nullable', 'array'],
            'categorias.*' => ['string'],
            'tallas' => ['nullable', 'array'],
            'tallas.*' => ['string'],
            'colores' => ['nullable', 'array'],
            'colores.*' => ['string'],
            'imagen_base64' => ['nullable', 'string'],
            'imagen_mime' => ['nullable', 'string', 'in:image/jpeg,image/png,image/webp,image/gif'],
            'imagen_url' => ['nullable', 'url', 'max:2048'],
        ]);

        if (! $this->gemini->isConfigured()) {
            return response()->json([
                'error' => 'La generación con IA no está configurada. Agrega tu GEMINI_API_KEY en el archivo .env.',
            ], 503);
        }

        try {
            $descripcion = $this->gemini->generarDescripcionProducto([
                'nombre' => $request->input('nombre'),
                'categorias' => $request->input('categorias', []),
                'tallas' => $request->input('tallas', []),
                'colores' => $request->input('colores', []),
                'imagen_base64' => $request->input('imagen_base64'),
                'imagen_mime' => $request->input('imagen_mime', 'image/jpeg'),
                'imagen_url' => $request->input('imagen_url'),
            ]);

            return response()->json(['descripcion' => $descripcion]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            Log::error('Error al generar descripción con IA', [
                'mensaje' => $e->getMessage(),
                'usuario' => auth()->id(),
            ]);

            return response()->json(['error' => 'Ocurrió un error inesperado. Intenta de nuevo.'], 500);
        }
    }
}
