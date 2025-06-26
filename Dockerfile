FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

# Instala dependencias necesarias
RUN apk add --no-cache libpq-dev oniguruma-dev

# Instala extensiones PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath opcache

# Copia composer.json y composer.lock primero
COPY composer.json composer.lock ./

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copia el resto de la aplicación
COPY . .

# Configura permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# El CMD por defecto de la imagen ya inicia Nginx y PHP-FPM
# No necesitas especificar CMD ni usar Supervisor