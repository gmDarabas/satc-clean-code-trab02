FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    zip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_pgsql

COPY php.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/html
