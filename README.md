# Sofis Tienda de Modas

> Plataforma de moda boutique con catálogo público y panel de administración — construida con Laravel 12.

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-38BDF8?style=flat-square&logo=tailwindcss&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Tests](https://img.shields.io/badge/Tests-43%20passing-22c55e?style=flat-square&logo=pestphp&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## Tabla de Contenidos

- [Descripción](#descripción)
- [Características](#características)
- [Tech Stack](#tech-stack)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Modelo de Datos](#modelo-de-datos)
- [Rutas](#rutas)
- [Instalación Local](#instalación-local)
- [Variables de Entorno](#variables-de-entorno)
- [Docker (Opcional)](#docker-opcional)
- [Cuentas Demo](#cuentas-demo)
- [Testing](#testing)
- [Despliegue en Producción](#despliegue-en-producción)
- [Licencia](#licencia)

---

## Descripción

**Sofis Tienda de Modas** es una aplicación web de comercio de moda boutique que combina un catálogo público para clientes con un panel de administración interno para gestión de inventario, catálogo y personal.

Diseñada para tiendas boutique, marcas de moda curadas y retailers locales que buscan una presencia digital profesional. Es una base sólida y lista para personalizar, extender y desplegar como producto comercial.

---

## Características

### Tienda Pública

- Página de inicio con carrusel hero accesible, categorías destacadas y productos en vitrina
- Catálogo con filtros por categoría, búsqueda en tiempo real con debouncing y sugerencias, ofertas y ordenamiento
- Página de detalle de producto con galería, variantes de talla y color, detalles y sugerencias relacionadas
- Buscador con sugerencias en tiempo real y previsualización de productos
- Botón de contacto por WhatsApp configurable desde variables de entorno
- Página de "Nosotros"
- Registro, inicio de sesión, verificación de email y cierre de sesión de clientes
- Sistema de favoritos para usuarios verificados con sincronización optimista en UI
- Perfil de usuario: editar nombre y cambiar contraseña con validación en tiempo real
- Alertas y notificaciones con SweetAlert2 con tema de marca personalizado

### Panel de Administración (`/admin`)

- Autenticación independiente del flujo público con rate limiting estricto
- Dashboard con estadísticas del catálogo
- CRUD completo para: Productos, Categorías, Tallas, Colores, Sucursales y Covers del Hero
- Galería de imágenes de producto con previsualización y eliminación individual
- Eliminación suave (*soft delete*) con opción de restaurar productos
- Gestión de covers del carrusel de portada con reordenamiento
- Gestión de sucursales vinculadas a productos
- Gestión de permisos de usuarios (promover / degradar roles con protección del último admin)
- Generación de descripciones de producto con IA (Google Gemini) a partir del nombre, categorías e imagen
- Registro de auditoría de cambios en el catálogo (`activity_logs`) almacenado en base de datos

---

## Tech Stack

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.4, Laravel 12 |
| Vistas | Blade Templates + Componentes Blade |
| Estilos | Tailwind CSS 3 (fuentes: Playfair Display + Inter) |
| Alertas | SweetAlert2 con tema de marca personalizado |
| Build | Vite 7 |
| Base de datos | MySQL 8.0 |
| Testing | Pest 4 / PHPUnit 12 |
| IA | Google Gemini API (`gemini-1.5-flash`) |
| Dev tools | Laravel Sail, Pint, Pail |

**Paleta de colores de marca:**

| Token | Color | Uso |
|---|---|---|
| `tinta` | `#1A1A18` | Texto principal, fondos oscuros |
| `crema` | `#F6F4F1` | Fondo base de la tienda |
| `gris` | `#716F6A` | Texto secundario, iconos |
| `borde` | `#E2DED9` | Divisores, bordes de tarjetas |
| `moda` | `#B8936A` | Acento dorado, detalles de marca |
| `oferta` | `#9B1D3A` | Badges de oferta, precios especiales |

---

## Estructura del Proyecto

```
Sofistiendademodas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Controladores del panel admin
│   │   │   │   ├── ActivityLogController.php
│   │   │   │   ├── AiController.php
│   │   │   │   ├── CategoriaController.php
│   │   │   │   ├── ColorController.php
│   │   │   │   ├── CoverController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProductoController.php
│   │   │   │   ├── SucursalController.php
│   │   │   │   ├── TallaController.php
│   │   │   │   └── UsuarioController.php
│   │   │   ├── Auth/               # LoginController (admin), PublicAuthController
│   │   │   ├── CatalogoController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── SitemapController.php
│   │   │   └── WishlistController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── SecurityHeaders.php
│   │   │   └── ShareViewData.php
│   │   └── Requests/
│   │       ├── Admin/              # Form Requests del panel admin
│   │       ├── UpdateProfileInfoRequest.php
│   │       └── UpdateProfilePasswordRequest.php
│   ├── Models/
│   │   ├── ActivityLog.php
│   │   ├── Categoria.php
│   │   ├── Color.php
│   │   ├── Cover.php
│   │   ├── DetalleProducto.php
│   │   ├── Favorito.php
│   │   ├── ImagenProducto.php
│   │   ├── Producto.php
│   │   ├── Sucursal.php
│   │   ├── Talla.php
│   │   └── User.php
│   ├── Observers/                  # Invalidan caché y registran auditoría automáticamente
│   ├── Services/
│   │   ├── GeminiService.php       # Integración con Google Gemini API
│   │   └── ImageService.php        # Redimensionado y almacenamiento de imágenes
│   └── Support/
│       └── CacheKeys.php           # Constantes centralizadas de claves de caché
├── database/
│   ├── factories/                  # UserFactory, ProductoFactory
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/app.css                 # Estilos globales + customización SweetAlert2
│   ├── js/
│   │   ├── app.js
│   │   └── sofis-alerts.js         # Configuración de SweetAlert2 con tema de marca
│   └── views/
│       ├── admin/                  # Vistas del panel de administración
│       ├── auth/                   # Vistas de autenticación
│       ├── catalogo/               # Catálogo y detalle de producto
│       ├── components/             # Componentes Blade reutilizables
│       ├── favoritos/
│       ├── layouts/                # Layouts base (público y admin)
│       ├── partials/               # Navbar, footer, partials
│       └── perfil/                 # Perfil de usuario
├── routes/web.php
├── tailwind.config.js
└── vite.config.js
```

---

## Modelo de Datos

### Entidades principales

| Modelo | Descripción |
|---|---|
| `User` | Rol `admin` / `user`, método `isAdmin()`, implementa `MustVerifyEmail` |
| `Producto` | `SoftDeletes`, slugs auto-generados, relaciones múltiples |
| `Categoria` | Agrupación de productos (many-to-many) |
| `Talla` | Variante de talla (many-to-many) |
| `Color` | Variante de color (many-to-many) |
| `Sucursal` | Punto de venta vinculado a productos |
| `Cover` | Slides del carrusel hero con imagen, título y CTA |
| `ImagenProducto` | Galería de imágenes ordenadas por producto |
| `DetalleProducto` | Items descriptivos ordenados por producto |
| `Favorito` | Pivot `user_id` / `producto_id` con constraint `UNIQUE` |
| `ActivityLog` | Registro inmutable de creación, edición, eliminación y restauración de productos |

### Relaciones clave

- Un producto pertenece a múltiples categorías, tallas, colores y sucursales (many-to-many)
- Un producto tiene múltiples imágenes de galería y detalles descriptivos (one-to-many)
- Un usuario puede guardar múltiples productos como favoritos (many-to-many con pivot único)
- Los cambios en Producto, Categoria, Talla, Color y Cover son interceptados por Observers que invalidan caché y registran auditoría

---

## Rutas

### Tienda pública

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/` | Página de inicio |
| GET | `/catalogo` | Catálogo de productos con filtros |
| GET | `/producto/{slug}` | Detalle de producto |
| GET | `/buscar/sugerencias` | Sugerencias de búsqueda (AJAX, throttle 60/min) |
| GET | `/nosotros` | Página de la marca |
| GET | `/sitemap.xml` | Sitemap SEO |

### Autenticación pública

| Método | Ruta | Descripción |
|---|---|---|
| GET/POST | `/login` | Login de cliente |
| GET/POST | `/registro` | Registro de cliente |
| POST | `/logout` | Cierre de sesión |
| GET | `/email/verify` | Aviso de verificación |
| GET | `/email/verify/{id}/{hash}` | Confirmación de email |
| POST | `/email/resend` | Reenviar verificación |

### Área de cliente (requiere auth + email verificado)

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/mis-favoritos` | Lista de favoritos |
| POST | `/favoritos/{producto}` | Toggle favorito |
| GET | `/mi-cuenta` | Perfil del usuario |
| PATCH | `/mi-cuenta/info` | Actualizar nombre |
| PATCH | `/mi-cuenta/password` | Cambiar contraseña |

### Panel de administración (`/admin`)

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/admin` | Dashboard |
| GET/POST | `/admin/login` | Autenticación admin (throttle 3/min) |
| CRUD | `/admin/productos` | Gestión de productos |
| CRUD | `/admin/categorias` | Gestión de categorías |
| CRUD | `/admin/tallas` | Gestión de tallas |
| CRUD | `/admin/colores` | Gestión de colores |
| CRUD | `/admin/sucursales` | Gestión de sucursales |
| CRUD | `/admin/covers` | Gestión del carrusel hero |
| GET/PATCH | `/admin/usuarios` | Gestión de roles de usuarios |
| POST | `/admin/ai/descripcion` | Generar descripción con IA (throttle 20/min) |

---

## Instalación Local

### Requisitos previos

- PHP 8.4+
- Composer
- Node.js 18+ / npm
- MySQL 8.0+

### Paso a paso

**1. Clonar el repositorio**

```bash
git clone <url-del-repositorio>
cd Sofistiendademodas
```

**2. Instalar dependencias**

```bash
composer install
npm install
```

**3. Configurar el entorno**

```bash
cp .env.example .env
```

Editar `.env` con los valores del proyecto (ver sección [Variables de Entorno](#variables-de-entorno)).

**4. Generar la clave de aplicación**

```bash
php artisan key:generate
```

**5. Ejecutar migraciones y seeders**

```bash
php artisan migrate --seed
```

**6. Crear el enlace de almacenamiento**

```bash
php artisan storage:link
```

**7. Iniciar la aplicación**

Modo desarrollo completo (servidor + frontend + logs + queue en paralelo):

```bash
composer run dev
```

O por separado:

```bash
php artisan serve
npm run dev
```

La aplicación estará disponible en: `http://127.0.0.1:8000`

---

## Variables de Entorno

Referencia de las variables más relevantes del proyecto:

```env
# Aplicación
APP_NAME="Sofis Tienda de Modas"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sofistiendademodas
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

# Correo (verificación de email)
MAIL_MAILER=smtp
MAIL_HOST=smtp.ejemplo.com
MAIL_PORT=587
MAIL_USERNAME=tu@correo.com
MAIL_PASSWORD=tu_app_password
MAIL_FROM_ADDRESS=noreply@sofis.com
MAIL_FROM_NAME="Sofis Tienda de Modas"

# SEO y configuración pública
SEO_WHATSAPP=521234567890       # Número para botón WhatsApp (sin +)
SEO_OG_IMAGE=                   # URL absoluta de imagen Open Graph (1200×630 px)

# Inteligencia Artificial (opcional)
GEMINI_API_KEY=                 # API key de Google AI Studio para generación de descripciones
```

> `GEMINI_API_KEY` es opcional. Si no se configura, el botón de IA en el panel admin muestra un aviso amigable y la tienda funciona con normalidad.

---

## Docker (Opcional)

El proyecto incluye `docker-compose.yml` con MySQL 8.0 y phpMyAdmin para desarrollo local sin instalar MySQL directamente.

**Iniciar los servicios:**

```bash
docker compose up -d
```

| Servicio | Puerto local |
|---|---|
| MySQL | `3316` |
| phpMyAdmin | `http://localhost:8086` |

Configurar `.env` apuntando al contenedor:

```env
DB_HOST=127.0.0.1
DB_PORT=3316
DB_DATABASE=sofistiendademodas
```

---

## Cuentas Demo

Los seeders crean las siguientes cuentas para desarrollo y demo local:

| Rol | Email | Contraseña |
|---|---|---|
| Administrador | `admin@sofis.com` | `admin123` |
| Cliente demo | *(seeders)* | `password` |

> Estas credenciales son exclusivas para entornos locales o de demo. No usar en producción.

---

## Testing

El proyecto tiene una suite de tests de feature que cubre las rutas y flujos críticos.

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar solo los tests nuevos
php artisan test tests/Feature/AdminLoginTest.php
php artisan test tests/Feature/RegistroTest.php
php artisan test tests/Feature/FavoritosTest.php
php artisan test tests/Feature/Admin/ProductoTest.php

# O con el alias de composer
composer test
```

### Cobertura actual

| Archivo | Tests | Qué verifica |
|---|---|---|
| `AdminLoginTest` | 9 | Acceso al panel, login de admin, rechazo de no-admins, validaciones, logout |
| `RegistroTest` | 8 | Registro exitoso, rol asignado, validaciones de email, contraseña y duplicados |
| `FavoritosTest` | 10 | Control de acceso por rol y verificación, toggle add/remove, contadores, sin duplicados |
| `Admin/ProductoTest` | 15 | CRUD completo, validaciones de precio y oferta, slug auto-generado, soft delete y restore |

Los tests usan SQLite en memoria (`DB_CONNECTION=sqlite`, `:memory:`) — no tocan la base de datos de desarrollo.

---

## Despliegue en Producción

### Checklist antes de publicar

```bash
# 1. Variables de entorno de producción
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# 2. Instalar dependencias sin paquetes de desarrollo
composer install --no-dev --optimize-autoloader

# 3. Compilar assets
npm run build

# 4. Migraciones y optimización
php artisan migrate --force
php artisan storage:link
php artisan optimize
```

### Consideraciones adicionales

- **API Keys:** Generar nuevas claves de Gemini (y app password de Gmail si se usa) antes de deployar — no reutilizar las del entorno de desarrollo
- **SEO:** Configurar `SEO_OG_IMAGE` con una imagen real de 1200×630 px alojada en el dominio de producción
- **WhatsApp:** Actualizar `SEO_WHATSAPP` con el número real del negocio
- **HSTS:** Activar la cabecera HSTS en `SecurityHeaders.php` una vez que el certificado SSL esté configurado
- **Correo:** Verificar que el servicio de mail esté operativo antes de habilitar registros públicos
- **Auditoría:** La tabla `activity_logs` crece con el uso; planificar una política de retención o purgado periódico
- **Contenido demo:** Reemplazar seeders de catálogo de ejemplo, imágenes placeholder y datos de demostración
- **Backups:** Configurar backups automáticos de la base de datos y del disco de almacenamiento (`storage/app/public`)

---

## Licencia

Este proyecto está bajo la [Licencia MIT](LICENSE).

Puedes usar, modificar y distribuir el código fuente bajo los términos de la licencia MIT. El contenido demo, datos del catálogo de ejemplo, branding y configuración de despliegue deben revisarse y adaptarse antes de cualquier lanzamiento comercial.
