FROM php:8.3-fpm

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libpq-dev \
    zip \
 && docker-php-ext-install zip pdo_pgsql

WORKDIR /app
