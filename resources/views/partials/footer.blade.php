<footer class="mt-16 border-t border-borde bg-white">
    <div class="container-base py-12">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Columna 1 --}}
            <div>
                <h3 class="font-display text-lg tracking-wide">Conoce Sofis</h3>
                <ul class="mt-4 space-y-2 text-sm text-gris">
                    <li><a href="{{ route('nosotros') }}" class="hover:text-tinta transition">Nuestra historia</a></li>
                    <li><a href="#" class="hover:text-tinta transition">Nuestras tiendas</a></li>
                    <li><a href="#" class="hover:text-tinta transition">Bolsa de trabajo</a></li>
                    {{-- <li><a href="{{ route('contacto') }}" class="hover:text-tinta transition">Contacto</a></li> --}}
                </ul>
            </div>

            {{-- Columna 2 --}}
            <div>
                <h3 class="font-display text-lg tracking-wide">Guía de compra</h3>
                <ul class="mt-4 space-y-2 text-sm text-gris">
                    <li><a href="#" class="hover:text-tinta transition">Preguntas frecuentes</a></li>
                    <li><a href="#" class="hover:text-tinta transition">Cambios y devoluciones</a></li>
                    <li><a href="#" class="hover:text-tinta transition">Métodos de pago</a></li>
                    <li><a href="#" class="hover:text-tinta transition">Política de privacidad</a></li>
                </ul>
            </div>

            {{-- Columna 3 --}}
            <div>
                <h3 class="font-display text-lg tracking-wide">Atención al cliente</h3>
                <div class="mt-4 space-y-2 text-sm text-gris">
                    <p><span class="text-tinta font-medium">Tel:</span> 55 0000 0000</p>
                    <p><span class="text-tinta font-medium">Correo:</span> contacto@sofistienda.com</p>
                    <p>
                        <a href="#" class="text-tinta underline underline-offset-4 hover:opacity-80 transition">
                            Comunícate vía WhatsApp
                        </a>
                    </p>

                    <div class="pt-3">
                        <p class="text-xs uppercase tracking-widest text-gris">Horarios</p>
                        <p class="mt-2">Lun - Sáb: 9:00 a 20:00</p>
                        <p>Dom: 10:00 a 18:00</p>
                    </div>
                </div>
            </div>

            {{-- Columna 4: Newsletter + redes --}}
            <div>
                <h3 class="font-display text-lg tracking-wide">Suscríbete</h3>
                <p class="mt-4 text-sm text-gris">
                    Entérate primero de lanzamientos, rebajas y novedades.
                </p>

                <form class="mt-4 flex gap-2">
                    <input type="email" class="input" placeholder="Tu correo">
                    <button type="submit" class="btn-primary whitespace-nowrap">
                        Suscribirme
                    </button>
                </form>

                <div class="mt-6">
                    <p class="text-xs uppercase tracking-widest text-gris">Síguenos</p>
                    <div class="mt-3 flex items-center gap-3 text-xl">
                        {{-- Reemplaza con íconos reales --}}
                        <a href="#" class="hover:opacity-70 transition" aria-label="Facebook">📘</a>
                        <a href="#" class="hover:opacity-70 transition" aria-label="Instagram">📸</a>
                        <a href="#" class="hover:opacity-70 transition" aria-label="TikTok">🎵</a>
                        <a href="#" class="hover:opacity-70 transition" aria-label="YouTube">▶️</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Línea separadora --}}
        <div
            class="mt-10 border-t border-borde pt-6 text-xs text-gris flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>© {{ date('Y') }} Sofis Tienda de Modas. Todos los derechos reservados.</p>

            <div class="flex flex-wrap gap-4">
                <a href="#" class="hover:text-tinta transition">Términos de uso</a>
                <a href="#" class="hover:text-tinta transition">Aviso de privacidad</a>
                <a href="#" class="hover:text-tinta transition">Políticas</a>
            </div>
        </div>
    </div>
</footer>
