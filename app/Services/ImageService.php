<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

/**
 * Servicio centralizado de almacenamiento de imágenes.
 *
 * Toda imagen que pase por aquí:
 *  - Se convierte a WebP (25-35 % más ligero que JPG a calidad equivalente)
 *  - Se redimensiona hacia abajo si supera el ancho máximo indicado
 *  - Se guarda en storage/app/public/{directorio}/{uuid}.webp
 *
 * Si la conversión falla por cualquier motivo, se lanza la excepción para
 * que el controller la capture en su try/catch habitual y muestre un error
 * al usuario. Nunca se guarda silenciosamente una imagen corrupta.
 */
class ImageService
{
    // Calidad WebP. 85 es el punto óptimo: imperceptible vs. 100 y mucho más ligero.
    private const QUALITY = 85;

    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver);
    }

    /**
     * Almacena un UploadedFile como WebP en el disco público.
     *
     * @param  UploadedFile  $file  Archivo subido por el usuario.
     * @param  string  $directory  Subdirectorio en storage/app/public (ej. 'productos').
     * @param  int  $maxWidth  Ancho máximo en píxeles. No agranda si ya es menor.
     * @return string Ruta relativa lista para guardar en BD (ej. 'productos/uuid.webp').
     */
    public function store(UploadedFile $file, string $directory, int $maxWidth = 1200): string
    {
        $filename = Str::uuid().'.webp';
        $relativePath = $directory.'/'.$filename;
        $absolutePath = Storage::disk('public')->path($relativePath);

        // Garantizamos que el directorio existe antes de escribir
        Storage::disk('public')->makeDirectory($directory);

        $this->manager
            ->decodePath($file->getPathname())
            ->scaleDown(width: $maxWidth)   // no-op si la imagen ya es más pequeña
            ->encode(new WebpEncoder(quality: self::QUALITY))
            ->save($absolutePath);

        return $relativePath;
    }

    /**
     * Descarga una imagen desde una URL remota y la almacena como WebP.
     * Útil en seeders y scripts de importación de catálogo.
     *
     * @param  string  $url  URL pública de la imagen.
     * @param  string  $directory  Subdirectorio en storage/app/public.
     * @param  int  $maxWidth  Ancho máximo en píxeles.
     * @return string Ruta relativa lista para guardar en BD.
     */
    public function storeFromUrl(string $url, string $directory, int $maxWidth = 1200): string
    {
        $filename = Str::uuid().'.webp';
        $relativePath = $directory.'/'.$filename;
        $absolutePath = Storage::disk('public')->path($relativePath);

        Storage::disk('public')->makeDirectory($directory);

        // Descargamos el contenido en memoria y lo decodificamos directamente
        $content = file_get_contents($url, false, stream_context_create([
            'http' => ['timeout' => 15],
            'ssl' => ['verify_peer' => true],
        ]));

        if ($content === false) {
            throw new \RuntimeException("No se pudo descargar la imagen desde: {$url}");
        }

        $this->manager
            ->decode($content)
            ->scaleDown(width: $maxWidth)
            ->encode(new WebpEncoder(quality: self::QUALITY))
            ->save($absolutePath);

        return $relativePath;
    }
}
