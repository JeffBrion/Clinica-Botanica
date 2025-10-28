
FROM composer:2 AS build
WORKDIR /app
## Etapa 1: Dependencias de PHP con Composer
FROM composer:2 AS vendor
WORKDIR /app

# Instalar dependencias de PHP (cache-friendly)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction

# Copiar el resto del código y optimizar autoloader
COPY . .
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader


## Etapa 2: Compilar assets con Vite
FROM node:20-alpine AS assets
WORKDIR /app

COPY package.json package-lock.json* yarn.lock* pnpm-lock.yaml* ./
RUN if [ -f package-lock.json ]; then npm ci; \
	elif [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
	else npm install; fi

COPY . .
RUN npm run build


## Etapa 3: Imagen final con PHP + Apache
FROM php:8.3-apache
WORKDIR /var/www/html

# Paquetes del sistema y extensiones necesarias (Laravel + PhpSpreadsheet)
RUN apt-get update && apt-get install -y \
	libpng-dev \
	libjpeg-dev \
	libwebp-dev \
	libzip-dev \
	unzip \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-configure gd --with-jpeg --with-webp \
 && docker-php-ext-install pdo pdo_mysql gd zip \
 && a2enmod rewrite

# Configurar DocumentRoot a /public (Laravel)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!Directory /var/www/!Directory /var/www/html/public!g' /etc/apache2/apache2.conf

# Copiar la aplicación y assets compilados
COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build

# Permisos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer el puerto 80 (Render lo asigna automáticamente)
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
