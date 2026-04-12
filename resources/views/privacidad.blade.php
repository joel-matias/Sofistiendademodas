@extends('layouts.app')

@section('title', 'Política de Privacidad | ' . config('seo.site_name'))

@section('content')

    {{-- Hero --}}
    <section class="w-full bg-tinta text-crema">
        <div class="container-full pt-16 sm:pt-20 pb-12 sm:pb-16">
            <p class="text-[11px] tracking-[0.3em] uppercase text-moda/80 mb-4 font-medium">Legal</p>
            <h1 class="font-display text-4xl sm:text-5xl leading-tight">Política de Privacidad</h1>
            <p class="mt-4 text-white/60 text-sm">Última actualización: {{ date('d \d\e F \d\e Y') }}</p>
        </div>
    </section>

    {{-- Contenido --}}
    <section class="container-full mt-12 mb-16">
        <div class="max-w-3xl mx-auto">
            <div class="card p-8 sm:p-10 space-y-8 text-gris leading-relaxed text-sm">

                {{-- Intro --}}
                <div>
                    <p>
                        En <strong class="text-tinta">{{ config('seo.site_name') }}</strong> valoramos y respetamos tu
                        privacidad. Esta Política de Privacidad describe cómo recopilamos, usamos y protegemos tu
                        información personal de conformidad con la
                        <em>Ley Federal de Protección de Datos Personales en Posesión de los Particulares (LFPDPPP)</em>
                        y demás legislación aplicable.
                    </p>
                    <p class="mt-3">
                        Al utilizar nuestro sitio y crear una cuenta, aceptas las prácticas descritas en esta política.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 1. Responsable --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">1. Responsable del tratamiento</h2>
                    <p>
                        El responsable del tratamiento de tus datos personales es
                        <strong class="text-tinta">{{ config('seo.site_name') }}</strong>.
                        @if (config('seo.email'))
                            Para cualquier asunto relacionado con tus datos, puedes contactarnos en:
                            <a href="mailto:{{ config('seo.email') }}"
                                class="text-tinta font-medium hover:underline">{{ config('seo.email') }}</a>.
                        @endif
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 2. Datos que recopilamos --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">2. Datos que recopilamos</h2>
                    <p>Recopilamos los siguientes datos personales cuando creas una cuenta o utilizas nuestros servicios:</p>
                    <ul class="mt-3 space-y-2 list-none">
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            <span><strong class="text-tinta">Nombre completo</strong> — para identificarte en tu cuenta.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            <span><strong class="text-tinta">Correo electrónico</strong> — para gestionar tu cuenta y
                                enviarte notificaciones relacionadas con el servicio.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            <span><strong class="text-tinta">Contraseña</strong> — almacenada de forma segura mediante
                                cifrado (hash bcrypt). Nunca accedemos a tu contraseña en texto plano.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            <span><strong class="text-tinta">Fecha de aceptación</strong> — registro de cuándo aceptaste
                                estos términos y la política de privacidad.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            <span><strong class="text-tinta">Datos de navegación</strong> — dirección IP, tipo de
                                navegador y páginas visitadas, recopilados automáticamente para mejorar el servicio.</span>
                        </li>
                    </ul>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 3. Finalidad --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">3. Finalidad del tratamiento</h2>
                    <p>Utilizamos tus datos personales para:</p>
                    <ul class="mt-3 space-y-2 list-none">
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Crear y gestionar tu cuenta de usuario.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Verificar tu identidad y proteger la seguridad de la plataforma.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Enviarte notificaciones del servicio (verificación de correo, cambios en tu cuenta).
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Guardar tus productos favoritos y preferencias de navegación.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Mejorar nuestros productos, servicios y la experiencia del usuario.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Cumplir con obligaciones legales y regulatorias aplicables.
                        </li>
                    </ul>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 4. Compartición --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">4. Compartición de datos</h2>
                    <p>
                        <strong class="text-tinta">No vendemos ni compartimos tus datos personales con terceros</strong>
                        con fines comerciales. Únicamente podremos compartirlos en los siguientes casos:
                    </p>
                    <ul class="mt-3 space-y-2 list-none">
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Proveedores de servicios técnicos (hosting, correo electrónico) que actúan como
                            encargados del tratamiento bajo acuerdos de confidencialidad.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Autoridades competentes cuando sea requerido por ley o resolución judicial.
                        </li>
                    </ul>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 5. Seguridad --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">5. Seguridad de los datos</h2>
                    <p>
                        Implementamos medidas técnicas y organizativas adecuadas para proteger tus datos personales
                        contra acceso no autorizado, pérdida, alteración o divulgación. Entre estas medidas se
                        incluyen:
                    </p>
                    <ul class="mt-3 space-y-2 list-none">
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Cifrado de contraseñas mediante algoritmos seguros (bcrypt).
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Transmisión de datos mediante conexiones HTTPS cifradas.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Verificación de correo electrónico para validar la identidad del usuario.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Limitación de intentos de acceso para prevenir ataques de fuerza bruta.
                        </li>
                    </ul>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 6. Derechos ARCO --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">6. Tus derechos (ARCO)</h2>
                    <p>
                        De conformidad con la LFPDPPP, tienes derecho a <strong class="text-tinta">Acceder</strong>,
                        <strong class="text-tinta">Rectificar</strong>, <strong class="text-tinta">Cancelar</strong>
                        u <strong class="text-tinta">Oponerte</strong> al tratamiento de tus datos personales
                        (derechos ARCO).
                    </p>
                    <p class="mt-3">Para ejercer estos derechos puedes:</p>
                    <ul class="mt-3 space-y-2 list-none">
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Actualizar tu nombre directamente desde tu perfil en <a href="{{ route('perfil.show') }}"
                                class="text-tinta font-medium hover:underline">Mi cuenta</a>.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                            Solicitar la eliminación o rectificación de tus datos escribiéndonos a
                            @if (config('seo.email'))
                                <a href="mailto:{{ config('seo.email') }}"
                                    class="text-tinta font-medium hover:underline">{{ config('seo.email') }}</a>.
                            @else
                                nuestro correo de contacto.
                            @endif
                        </li>
                    </ul>
                    <p class="mt-3">
                        Responderemos tu solicitud en un plazo máximo de 20 días hábiles conforme a lo establecido
                        por la ley.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 7. Cookies --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">7. Uso de cookies</h2>
                    <p>
                        Este sitio utiliza cookies propias esenciales para su funcionamiento (sesión, seguridad CSRF,
                        preferencias de idioma). No utilizamos cookies de seguimiento de terceros con fines publicitarios.
                    </p>
                    <p class="mt-3">
                        Puedes configurar tu navegador para rechazar cookies; sin embargo, esto puede afectar el
                        funcionamiento del sitio (por ejemplo, no podrás iniciar sesión).
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 8. Retención --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">8. Retención de datos</h2>
                    <p>
                        Conservamos tus datos personales mientras tu cuenta esté activa o mientras sean necesarios
                        para prestarte el servicio. Si solicitas la eliminación de tu cuenta, procederemos a borrar
                        o anonimizar tus datos, salvo cuando debamos conservarlos por obligación legal.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 9. Cambios --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">9. Cambios en esta política</h2>
                    <p>
                        Podemos actualizar esta Política de Privacidad periódicamente. Cuando realicemos cambios
                        materiales, te notificaremos mediante un aviso visible en el sitio o a través del correo
                        electrónico asociado a tu cuenta. Te recomendamos revisar esta página con regularidad.
                    </p>
                </div>

                <div class="w-full h-px bg-borde"></div>

                {{-- 10. Contacto --}}
                <div>
                    <h2 class="font-display text-xl text-tinta mb-3">10. Contacto</h2>
                    <p>
                        Si tienes preguntas, comentarios o solicitudes relacionadas con esta Política de Privacidad,
                        comunícate con nosotros:
                    </p>
                    <ul class="mt-3 space-y-1.5 list-none">
                        @if (config('seo.email'))
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-moda flex-shrink-0"></span>
                                Correo:
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
                <a href="{{ route('terminos') }}" class="btn text-sm">Ver Términos y Condiciones</a>
                <a href="{{ route('home') }}" class="btn text-sm">Volver a la tienda</a>
            </div>
        </div>
    </section>

@endsection
