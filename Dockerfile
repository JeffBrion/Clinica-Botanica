# Etapa 1: Instalar dependencias PHP con Composer
FROM composer:2 AS build
WORKDIR /app
COPY composer.json composer.lock ./
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --no-scripts
COPY . .

# Etapa 2: Servidor PHP con Apache
FROM php:8.3-apache
WORKDIR /var/www/html

# Instalar extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip \
    && a2enmod rewrite

# Copiar archivos desde la etapa de build
COPY --from=build /app /var/www/html

# Permisos de escritura para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar DocumentRoot a /public (Laravel)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!Directory /var/www/!Directory /var/www/html/public!g' /etc/apache2/apache2.conf

# Exponer puerto
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
