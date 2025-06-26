# Usa una imagen base de PHP-FPM (FastCGI Process Manager) con Nginx
FROM richarvey/nginx-php-fpm:latest

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Instala las dependencias del sistema necesarias para las extensiones PHP
# 'libpq-dev' es crucial para pdo_pgsql
# 'oniguruma-dev' es necesario para la extensión mbstring
RUN apk add --no-cache libpq-dev oniguruma-dev

# Instala extensiones PHP comunes que Laravel suele necesitar.
# 'pdo_pgsql' es para PostgreSQL.
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath opcache

# Si necesitas la extensión GD (para manipulación de imágenes), descomenta las siguientes líneas
# después de verificar los nombres correctos de los paquetes Alpine para libpng, libjpeg, libfreetype
# y el RUN apk add --no-cache libpng-dev libjpeg-turbo-dev libfreetype-dev
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
#    && docker-php-ext-install -j$(nproc) gd

# Copia composer.json y composer.lock primero.
COPY composer.json composer.lock ./

# Instala las dependencias de Composer.
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copia el resto de tu aplicación Laravel al contenedor.
COPY . .

# Copia el archivo de configuración de Supervisor a /etc/supervisor/conf.d/
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Genera la APP_KEY si no está en el .env de Render. (Esto es opcional si ya la tienes en Render)
# RUN php artisan key:generate --ansi

# Configura los permisos de los directorios 'storage' y 'bootstrap/cache'.
RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Expone el puerto 80, que es donde Nginx escuchará las peticiones HTTP.
EXPOSE 80

# Comando para iniciar Nginx y PHP-FPM usando Supervisor.
# Mantenemos el CMD original ya que el Supervisor de la imagen base debería escanear conf.d
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]

# Opcional: Si quieres limpiar la caché de configuración, rutas o vistas durante el build.
# RUN php artisan config:cache
# RUN php artisan route:cache
# RUN php artisan view:cache