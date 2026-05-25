# Multi-stage build para optimizar la imagen final
FROM php:8.2-fpm-alpine as base

# Instalar dependencias del sistema y extensiones de PHP necesarias para Laravel
RUN apk add --no-cache \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip gd exif pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis

# Traer Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar archivos de configuración de dependencias
COPY composer.json composer.lock ./

# Instalar dependencias optimizando para producción
RUN composer install --no-scripts --no-autoloader --ansi --no-interaction

# Copiar el resto del código de la aplicación
COPY . .

# Optimizar el autoloader de Composer y caché de Laravel
RUN composer dump-autoload --optimize \
    && php artisan config:cache \
    && php artisan route:cache

# Ajustar permisos para el servidor web
RUN chown -y rw- R storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
