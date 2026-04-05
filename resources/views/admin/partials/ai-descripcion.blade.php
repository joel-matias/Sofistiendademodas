{{--
    Botón "Generar con IA" para el textarea de descripción en los formularios de producto.
    Requiere que en la misma vista existan:
      - input[name="nombre"]
      - textarea[name="descripcion"]  (con id="descripcionTextarea")
      - checkboxes name="categorias[]", name="tallas[]", name="colores[]"
      - (opcional) input[type="file" id="imagenPrincipalInput"] y/o img[id="imagenActualSrc"]
--}}
<div id="aiDescripcionWrapper" class="mt-2 flex items-center gap-3">

    <button type="button" id="btnGenerarDescripcion"
        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium
               border border-borde bg-white text-gris hover:text-tinta hover:border-tinta
               transition disabled:opacity-50 disabled:cursor-not-allowed">
        {{-- Ícono reposo: chispa IA --}}
        <svg id="aiIcono" class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
        </svg>
        {{-- Spinner cargando --}}
        <svg id="aiSpinner" class="w-3.5 h-3.5 flex-shrink-0 hidden animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        <span id="aiTextoBtn">Generar con IA</span>
    </button>

    <span id="aiMensaje" class="text-xs hidden"></span>
</div>

@once
    @push('scripts')
    <script>
    (function () {
        const btn        = document.getElementById('btnGenerarDescripcion');
        const textarea   = document.getElementById('descripcionTextarea');
        const icono      = document.getElementById('aiIcono');
        const spinner    = document.getElementById('aiSpinner');
        const textoBtn   = document.getElementById('aiTextoBtn');
        const mensaje    = document.getElementById('aiMensaje');

        if (!btn || !textarea) return;

        btn.addEventListener('click', async () => {
            const nombre = document.querySelector('input[name="nombre"]')?.value?.trim();

            if (!nombre) {
                mostrarMensaje('Escribe primero el nombre del producto.', 'error');
                return;
            }

            // Recoger checkboxes marcados
            const categorias = [...document.querySelectorAll('input[name="categorias[]"]:checked')]
                .map(el => el.closest('label')?.textContent?.trim()).filter(Boolean);

            const tallas = [...document.querySelectorAll('input[name="tallas[]"]:checked')]
                .map(el => el.closest('label')?.textContent?.trim()).filter(Boolean);

            const colores = [...document.querySelectorAll('input[name="colores[]"]:checked')]
                .map(el => el.closest('label')?.textContent?.trim()).filter(Boolean);

            setLoading(true);
            ocultarMensaje();

            // Obtener imagen: primero del file input, si no hay usar la imagen actual del formulario de edición
            let imagen_base64 = null;
            let imagen_mime   = null;
            let imagen_url    = null;

            const fileInput = document.getElementById('imagenPrincipalInput');

            if (fileInput?.files?.[0]) {
                try {
                    const resultado = await redimensionarImagen(fileInput.files[0], 800);
                    imagen_base64 = resultado.base64;
                    imagen_mime   = resultado.mime;
                } catch { /* ignorar, generamos sin imagen */ }
            } else {
                // En el formulario de edición existe una img ya cargada con la imagen actual del producto.
                // La convertimos a base64 desde el elemento <img> (sin fetch, evita problemas con URLs locales).
                const imgActual = document.getElementById('imagenActualSrc');
                if (imgActual?.complete && imgActual.naturalWidth > 0) {
                    try {
                        const resultado = await imagenElementoABase64(imgActual, 800);
                        imagen_base64 = resultado.base64;
                        imagen_mime   = resultado.mime;
                    } catch { /* ignorar, generamos sin imagen */ }
                }
            }

            try {
                const res = await fetch('{{ route('admin.ai.descripcion') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ nombre, categorias, tallas, colores, imagen_base64, imagen_mime, imagen_url }),
                });

                const data = await res.json();

                if (!res.ok || data.error) {
                    mostrarMensaje(data.error || 'Error al generar. Intenta de nuevo.', 'error');
                    return;
                }

                textarea.value = data.descripcion;
                textarea.dispatchEvent(new Event('input'));
                mostrarMensaje('¡Descripción generada!', 'ok');

            } catch {
                mostrarMensaje('Sin conexión. Verifica tu red.', 'error');
            } finally {
                setLoading(false);
            }
        });

        function setLoading(loading) {
            btn.disabled   = loading;
            icono.classList.toggle('hidden', loading);
            spinner.classList.toggle('hidden', !loading);
            textoBtn.textContent = loading ? 'Generando…' : 'Generar con IA';
        }

        function mostrarMensaje(texto, tipo) {
            mensaje.textContent  = texto;
            mensaje.className    = 'text-xs ' + (tipo === 'ok' ? 'text-green-600' : 'text-red-500');
            mensaje.classList.remove('hidden');
            setTimeout(ocultarMensaje, 5000);
        }

        function ocultarMensaje() {
            mensaje.classList.add('hidden');
        }

        /**
         * Convierte un elemento <img> ya cargado a base64 redimensionado.
         * Evita hacer fetch a la URL (que puede ser localhost inaccesible desde APIs externas).
         */
        function imagenElementoABase64(imgEl, maxPx) {
            return new Promise((resolve, reject) => {
                try {
                    const ratio  = Math.min(maxPx / imgEl.naturalWidth, maxPx / imgEl.naturalHeight, 1);
                    const canvas = document.createElement('canvas');
                    canvas.width  = Math.round(imgEl.naturalWidth  * ratio);
                    canvas.height = Math.round(imgEl.naturalHeight * ratio);
                    canvas.getContext('2d').drawImage(imgEl, 0, 0, canvas.width, canvas.height);
                    const mime = 'image/jpeg';
                    const data = canvas.toDataURL(mime, 0.85);
                    resolve({ base64: data.split(',')[1], mime });
                } catch (e) {
                    reject(e);
                }
            });
        }

        /**
         * Redimensiona un File a máx. maxPx en el lado más largo,
         * devuelve { base64, mime } listos para enviar al backend.
         */
        function redimensionarImagen(file, maxPx) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onerror = reject;
                reader.onload = e => {
                    const img = new Image();
                    img.onerror = reject;
                    img.onload = () => {
                        const ratio = Math.min(maxPx / img.width, maxPx / img.height, 1);
                        const canvas = document.createElement('canvas');
                        canvas.width  = Math.round(img.width  * ratio);
                        canvas.height = Math.round(img.height * ratio);
                        canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);
                        const mime   = file.type || 'image/jpeg';
                        const data   = canvas.toDataURL(mime, 0.85);
                        // data es "data:image/jpeg;base64,..."
                        resolve({ base64: data.split(',')[1], mime });
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }
    })();
    </script>
    @endpush
@endonce
