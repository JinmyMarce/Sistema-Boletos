FROM php:8.2-apache

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath

# Habilita mod_rewrite de Apache (necesario para Laravel)
RUN a2enmod rewrite

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html

# Da permisos a las carpetas necesarias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copia el archivo .htaccess de Laravel (debe estar en public/)
COPY public/.htaccess /var/www/html/public/.htaccess

# Establece el DocumentRoot en la carpeta public de Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

EXPOSE 80