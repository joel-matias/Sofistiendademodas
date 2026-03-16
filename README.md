# Sofis Tienda de Modas

> Plataforma de moda boutique con catálogo público y panel de administración — construida con Laravel 12.

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-38BDF8?style=flat-square&logo=tailwindcss&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)
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
- [Docker (Opcional)](#docker-opcional)
- [Cuentas Demo](#cuentas-demo)
- [Testing](#testing)
- [Despliegue en Producción](#despliegue-en-producción)
- [Licencia](#licencia)

---

## Descripción

**Sofis Tienda de Modas** es una aplicación web de comercio de moda boutique que combina un catálogo público para clientes con un panel de administración interno para gestión de inventario y catálogo.

Diseñada para tiendas boutique, marcas de moda curadas y retailers locales que buscan una presencia digital profesional. Es una base sólida y lista para personalizar, extender y desplegar como producto comercial.

---

## Características

### Tienda Pública
- Página de inicio con hero, categorías destacadas y productos en vitrina
- Catálogo con filtros por categoría, búsqueda, ofertas y ordenamiento
- Página de detalle de producto con galería, variantes, detalles y sugerencias relacionadas
- Buscador con sugerencias en tiempo real y previsualización de productos
- Registro, inicio de sesión y cierre de sesión de clientes
- Sistema de favoritos para usuarios autenticados
- Páginas de "Nosotros" y "Contacto"

### Panel de Administración (`/admin`)
- Autenticación independiente del flujo público
- Dashboard con estadísticas del catálogo
- CRUD completo para: Productos, Categorías, Tallas, Colores
- Soporte de eliminación suave (*soft delete*) con opción de restaurar productos
- Gestión de imágenes de galería y detalles de producto

---

## Tech Stack

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Vistas | Blade Templates |
| Estilos | Tailwind CSS 3 (fuentes: Playfair Display + Inter) |
| Build | Vite 7 |
| Base de datos | MySQL 8.0 |
| Testing | Pest / PHPUnit |
| Dev tools | Laravel Sail, Pint, Pail |

**Paleta de colores custom:**

| Token | Color |
|---|---|
| `tinta` | `#111111` |
| `crema` | `#FAFAF7` |
| `gris` | `#6B7280` |
| `borde` | `#E5E7EB` |

---

## Estructura del Proyecto

```
Sofistiendademodas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controladores del panel admin
│   │   │   ├── Auth/           # Controladores de autenticación
│   │   │   ├── CatalogoController.php
│   │   │   └── WishlistController.php
│   │   └── Middleware/
│   └── Models/                 # Producto, Categoria, Talla, Color, User...
├── database/
│   ├── migrations/             # Definiciones del esquema
│   └── seeders/                # Datos demo y catálogo inicial
├── resources/
│   └── views/
│       ├── admin/              # Vistas del panel de administración
│       ├── auth/               # Vistas de autenticación
│       ├── catalogo/           # Vistas del catálogo público
│       ├── layouts/            # Layouts base
│       └── partials/           # Componentes reutilizables
├── routes/
│   └── web.php                 # Rutas web: tienda, auth, favoritos, admin
├── public/                     # Assets públicos y salida de Vite
├── tailwind.config.js
└── vite.config.js
```

---

## Modelo de Datos

### Entidades principales

| Modelo | Descripción |
|---|---|
| `User` | Rol `admin` / `user`, método `isAdmin()` |
| `Producto` | SoftDeletes, slugs, relaciones múltiples |
| `Categoria` | Agrupación de productos |
| `Talla` | Variante de talla por producto |
| `Color` | Variante de color por producto |
| `ImagenProducto` | Galería de imágenes por producto |
| `DetalleProducto` | Items descriptivos por producto |

### Relaciones clave

- Un producto pertenece a múltiples categorías, tallas y colores
- Un producto tiene múltiples imágenes de galería y detalles descriptivos
- Un usuario puede guardar múltiples productos como favoritos

---

## Rutas

### Tienda pública

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/` | Página de inicio |
| GET | `/catalogo` | Catálogo de productos |
| GET | `/producto/{slug}` | Detalle de producto |
| GET | `/buscar/sugerencias` | Sugerencias de búsqueda (AJAX) |
| GET | `/nosotros` | Página de la marca |
| GET | `/contacto` | Contacto |
| GET | `/login` | Login de cliente |
| GET | `/registro` | Registro de cliente |
| GET | `/mis-favoritos` | Favoritos del cliente (auth) |

### Panel de administración

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/admin` | Dashboard |
| GET/POST | `/admin/login` | Autenticación admin |
| GET/POST/PUT/DELETE | `/admin/productos` | CRUD Productos |
| GET/POST/PUT/DELETE | `/admin/categorias` | CRUD Categorías |
| GET/POST/PUT/DELETE | `/admin/tallas` | CRUD Tallas |
| GET/POST/PUT/DELETE | `/admin/colores` | CRUD Colores |

---

## Instalación Local

### Requisitos previos

- PHP 8.2+
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

Editar `.env` con los valores del proyecto:

```env
APP_NAME="Sofis Tienda de Modas"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sofistiendademodas
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

**4. Generar la clave de aplicación**

```bash
php artisan key:generate
```

**5. Ejecutar migraciones y seeders**

```bash
php artisan migrate --seed
```

**6. Crear el enlace de almacenamiento**

Necesario para que las imágenes subidas localmente sean accesibles públicamente:

```bash
php artisan storage:link
```

**7. Iniciar la aplicación**

Modo desarrollo completo (backend + frontend + logs + queue en paralelo):

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

```bash
php artisan test
# o
composer test
```

---

## Despliegue en Producción

Checklist mínimo antes de publicar:

```bash
# Variables de entorno
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Optimización
php artisan optimize
php artisan migrate --force
php artisan storage:link
npm run build

# Limpieza de caché si hay cambios de configuración
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
```

**Consideraciones adicionales:**
- Reemplazar contenido demo, assets de placeholder y catálogo de ejemplo del seeder
- Configurar servicios de mail, queue, caché y logging para producción
- Verificar configuración de proxy/CDN para detección de HTTPS
- Revisar credenciales, backups y monitoreo operacional

---

## Licencia

Este proyecto está bajo la [Licencia MIT](LICENSE).

Puedes usar, modificar y distribuir el código fuente bajo los términos de la licencia MIT. El contenido demo, datos del catálogo de ejemplo, branding y configuración de despliegue deben revisarse y adaptarse antes de cualquier lanzamiento comercial.
