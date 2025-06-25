# Sistema de Gestión de Eventos - EventSystem

Sistema de gestión de eventos para Cusco, Perú, desarrollado con Laravel y Tailwind CSS.

## Requisitos Previos

- PHP >= 8.1
- Composer
- Node.js y NPM
- MySQL
- Servidor web (Apache/Nginx)

## Instalación

Sigue estos pasos para instalar y configurar el proyecto:

1. **Clonar el repositorio** (si estás usando Git):
```bash
git clone <url-del-repositorio>
cd ticket
```

2. **Instalar dependencias de PHP**:
```bash
composer install
```

3. **Configurar el entorno**:
```bash
# Copiar el archivo de ejemplo de configuración
cp .env.example .env

# Generar la clave de la aplicación
php artisan key:generate
```

4. **Configurar la base de datos**:
Edita el archivo `.env` y configura las siguientes variables:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticket
DB_USERNAME=root
DB_PASSWORD=
```

5. **Instalar dependencias de Node.js**:
```bash
npm install
```

6. **Compilar assets**:
```bash
npm run build
```

7. **Crear enlace simbólico para el almacenamiento**:
```bash
php artisan storage:link
```

8. **Ejecutar migraciones**:
```bash
php artisan migrate
```

## Ejecución

Para ejecutar el proyecto en desarrollo:

1. **Iniciar el servidor de Laravel**:
```bash
php artisan serve
```

2. **En otra terminal, iniciar Vite para el desarrollo (opcional)**:
```bash
npm run dev
```

El proyecto estará disponible en `http://localhost:8000`

## Características

- Gestión de eventos
- Categorización de eventos
- Sistema de autenticación
- Gestión de perfiles de usuario
- Carga de imágenes
- Interfaz responsiva

## Estructura de Archivos Importantes

- `resources/views/` - Vistas Blade
- `resources/css/` - Archivos CSS
- `app/Http/Controllers/` - Controladores
- `routes/web.php` - Definición de rutas
- `database/migrations/` - Migraciones de base de datos

## Personalización

- Estilos: Modifica `tailwind.config.js` y `resources/css/app.css`
- Vistas: Edita los archivos en `resources/views/`
- Componentes: Encuentra los componentes en `resources/views/components/`

## Solución de Problemas

Si encuentras algún error, intenta:

1. Limpiar la caché:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

2. Regenerar el autoload:
```bash
composer dump-autoload
```

3. Verificar permisos de almacenamiento:
```bash
chmod -R 775 storage bootstrap/cache
```
