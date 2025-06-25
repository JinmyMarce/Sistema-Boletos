# Usa una imagen base de PHP-FPM (FastCGI Process Manager) con Nginx
# Esta imagen es popular y ya tiene Nginx configurado para servir PHP.
FROM richarvey/nginx-php-fpm:latest

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Instala extensiones PHP comunes que Laravel suele necesitar.
# Puedes añadir o quitar según las dependencias de tu Laravel.
# `pdo_pgsql` es para PostgreSQL, `mbstring` para manejo de cadenas, etc.
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath opcache

# Copia composer.json y composer.lock primero.
# Esto es una optimización de Docker para usar el caché de capas.
COPY composer.json composer.lock ./

# Instala las dependencias de Composer.
# `--no-dev`: Evita instalar dependencias de desarrollo (para un build más ligero).
# `--optimize-autoloader`: Optimiza el autoloader de Composer para mayor velocidad.
# `--no-scripts`: Evita ejecutar scripts de Composer durante la instalación.
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copia el resto de tu aplicación Laravel al contenedor.
COPY . .

# Configura los permisos de los directorios 'storage' y 'bootstrap/cache'.
# Esto es CRÍTICO para que Laravel pueda escribir logs, caché, etc.
# 'www-data' es el usuario que usa Nginx/PHP-FPM en esta imagen base.
RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Expone el puerto 80, que es donde Nginx escuchará las peticiones HTTP.
EXPOSE 80

# Comando para iniciar Nginx y PHP-FPM usando Supervisor.
# Este comando es específico de la imagen 'richarvey/nginx-php-fpm'.
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]

# Opcional: Si quieres limpiar la caché de configuración, rutas o vistas durante el build.
# RUN php artisan config:cache
# RUN php artisan route:cache
# RUN php artisan view:cache
# Usa una imagen oficial de PHP con extensiones necesarias
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Instala Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos del proyecto
COPY . .

# Instala dependencias de PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Da permisos a la carpeta de almacenamiento y caché
RUN chown -R www-data:www-data storage bootstrap/cache

# Expone el puerto 8000
EXPOSE 8000

# Comando para iniciar el servidor
CMD php artisan serve --host=0.0.0.0 --port=8000