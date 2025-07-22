# Dockerfile dla Laravel
FROM php:8.3-fpm

# Instalacja zależności systemowych
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        libzip-dev \
        npm \
        nodejs \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalacja Composera
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Ustaw katalog roboczy
WORKDIR /var/www

# Kopiuj pliki aplikacji
COPY . .

# Instalacja zależności PHP i JS
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install && npm run build

# Ustawienia uprawnień
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"] 