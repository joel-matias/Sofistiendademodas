@extends('layouts.app')

@section('title', 'Términos y Condiciones | ' . config('seo.site_name'))

@section('content')

    {{-- Hero --}}
    <section class="w-full bg-tinta text-crema">
        <div class="container-full pt-16 sm:pt-20 pb-12 sm:pb-16">
            <p class="text-[11px] tracking-[0.3em] uppercase text-moda/80 mb-4 font-medium">Legal</p>
            <h1 class="font-display text-4xl sm:text-5xl leading-tight">Términos y Condiciones</h1>
            <p class="mt-4 text-white/60 text-sm">Última actualización: {{ date('d \d\e F \d\e Y') }}</p>
        </div>
    </section>

    {{-- Contenido --}}
    <section class="container-full mt-12 mb-16">
        <div class="max-w-3xl mx-auto">
            <div class="card p-8 sm:p-10 space-y-8 text-gris leading-relaxed text-sm">

                {{-- 1. Aceptación --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">1. Aceptación de los términos</h2>
                    <p>
                        Al acceder y utilizar el sitio web de <strong class="text-tinta">{{ config('seo.site_name') }}</strong>
                        ("la Tienda"), el usuario acepta estos Términos y Condiciones en su totalidad. Si no está de
                        acuerdo con alguna de las condiciones aquí descritas, le pedimos que no utilice nuestro sitio.
                    </p>
                    <p class="mt-3">
                        Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones
                        entrarán en vigor desde su publicación en este sitio. El uso continuado del sitio implica la
                        aceptación de los términos actualizados.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 2. Descripción del servicio --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">2. Descripción del servicio</h2>
                    <p>
                        {{ config('seo.site_name') }} es una tienda de moda que ofrece ropa, calzado y accesorios a
                        través de su plataforma en línea. El sitio permite a los usuarios explorar nuestro catálogo,
                        guardar artículos en favoritos y obtener información de contacto para realizar compras.
                    </p>
                    <p class="mt-3">
                        Nos reservamos el derecho de modificar, suspender o discontinuar cualquier aspecto del servicio
                        en cualquier momento sin previo aviso.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 3. Cuentas de usuario --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">3. Cuentas de usuario</h2>
                    <p>Para acceder a ciertas funciones (como guardar favoritos), deberás crear una cuenta. Al registrarte:</p>
                    <ul class="mt-3 space-y-2 list-none">
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Debes proporcionar información veraz, completa y actualizada.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Eres responsable de mantener la confidencialidad de tu contraseña.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Eres responsable de toda la actividad que ocurra bajo tu cuenta.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Debes notificarnos de inmediato sobre cualquier uso no autorizado de tu cuenta.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Debes ser mayor de 18 años o contar con autorización de un tutor legal.
                        </li>
                    </ul>
                    <p class="mt-3">
                        Nos reservamos el derecho de cancelar o suspender cuentas que violen estos términos.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 4. Propiedad intelectual --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">4. Propiedad intelectual</h2>
                    <p>
                        Todo el contenido de este sitio —incluyendo textos, imágenes, logotipos, diseños y código— es
                        propiedad de {{ config('seo.site_name') }} o de sus respectivos titulares, y está protegido por
                        las leyes aplicables de propiedad intelectual.
                    </p>
                    <p class="mt-3">
                        Queda prohibida la reproducción, distribución o modificación de cualquier material sin
                        autorización expresa y por escrito de {{ config('seo.site_name') }}.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 5. Uso aceptable --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">5. Uso aceptable</h2>
                    <p>Al utilizar este sitio, el usuario se compromete a no:</p>
                    <ul class="mt-3 space-y-2 list-none">
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Usar el sitio con fines ilegales o no autorizados.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Intentar acceder sin autorización a sistemas, datos o cuentas ajenas.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Transmitir virus, malware u otro código malicioso.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Realizar actividades que interfieran con el funcionamiento del sitio.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Suplantar la identidad de otra persona o entidad.
                        </li>
                    </ul>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 6. Precios y disponibilidad --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">6. Precios y disponibilidad</h2>
                    <p>
                        Los precios y la disponibilidad de los productos mostrados en el sitio están sujetos a cambios
                        sin previo aviso. {{ config('seo.site_name') }} se reserva el derecho de corregir errores de
                        precio en cualquier momento.
                    </p>
                    <p class="mt-3">
                        Las imágenes de los productos son de referencia. Los colores reales pueden variar ligeramente
                        según la pantalla del dispositivo del usuario.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 7. Limitación de responsabilidad --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">7. Limitación de responsabilidad</h2>
                    <p>
                        {{ config('seo.site_name') }} no será responsable por daños indirectos, incidentales, especiales
                        o consecuentes derivados del uso o la imposibilidad de uso del sitio, incluso si se ha advertido
                        de la posibilidad de dichos daños.
                    </p>
                    <p class="mt-3">
                        No garantizamos que el sitio esté libre de errores, interrupciones o virus. El uso del sitio
                        es bajo el propio riesgo del usuario.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 8. Legislación aplicable --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">8. Legislación aplicable</h2>
                    <p>
                        Estos Términos y Condiciones se rigen por las leyes de la República Mexicana. Cualquier
                        controversia derivada de su interpretación o ejecución será sometida a los tribunales
                        competentes del domicilio de {{ config('seo.site_name') }}.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 9. Contacto --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">9. Contacto</h2>
                    <p>
                        Si tienes dudas sobre estos Términos y Condiciones, puedes contactarnos a través de:
                    </p>
                    <ul class="mt-3 space-y-1.5 list-none">
                        @if (config('seo.email'))
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                                Correo electrónico:
                                <a href="mailto:{{ config('seo.email') }}"
                                    class="text-tinta font-medium hover:underline">{{ config('seo.email') }}</a>
                            </li>
                        @endif
                        @if (config('seo.whatsapp'))
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                                WhatsApp:
                                <a href="https://wa.me/{{ config('seo.whatsapp') }}" target="_blank"
                                    class="text-tinta font-medium hover:underline">{{ config('seo.whatsapp') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>

            {{-- Links rápidos --}}
            <div class="mt-8 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('privacidad') }}" class="btn text-sm">Ver Política de Privacidad</a>
                <a href="{{ route('home') }}" class="btn text-sm">Volver a la tienda</a>
            </div>
        </div>
    </section>

@endsection
