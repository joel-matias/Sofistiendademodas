<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Información general del sitio
    |--------------------------------------------------------------------------
    | Valores globales usados en meta tags, Open Graph, Twitter Cards y JSON-LD.
    | Todos se configuran en el archivo .env para que el cliente pueda editarlos
    | sin tocar código.
    */

    'site_name'   => env('APP_NAME', 'Sofis Tienda de Modas'),
    'description' => env('SEO_DESCRIPTION', 'Ropa, calzado y accesorios. Moda y estilo para tu día a día.'),
    'keywords'    => env('SEO_KEYWORDS', 'moda femenina, tienda de ropa, calzado, accesorios'),

    // URL absoluta de la imagen por defecto al compartir en redes (1200×630 px recomendado)
    'og_image'    => env('SEO_OG_IMAGE', ''),

    /*
    |--------------------------------------------------------------------------
    | Información de contacto
    |--------------------------------------------------------------------------
    | Se usa en el footer, en los enlaces de WhatsApp y en el schema de Organización
    | que lee Google para mostrar datos en los resultados de búsqueda.
    */

    'phone'     => env('SEO_PHONE', ''),
    'whatsapp'  => env('SEO_WHATSAPP', ''),   // Solo números: 521234567890
    'email'     => env('SEO_EMAIL', ''),
    'address'   => env('SEO_ADDRESS', ''),

    /*
    |--------------------------------------------------------------------------
    | Redes sociales
    |--------------------------------------------------------------------------
    | URLs completas. Se usan en el footer y en el schema sameAs de Google para
    | vincular la entidad del negocio con sus perfiles en redes.
    */

    'instagram' => env('SEO_INSTAGRAM', ''),
    'facebook'  => env('SEO_FACEBOOK', ''),

];
