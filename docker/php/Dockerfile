FROM php:8.3-fpm-alpine

ARG USER_ID
ARG GROUP_ID

RUN apk update && apk add --no-cache \
    bash \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    linux-headers \
    unixodbc-dev \
    autoconf \
    g++ \
    make \
    imagemagick \
    imagemagick-dev \
    postgresql-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets pdo_pgsql pgsql

RUN pecl install imagick \
    && docker-php-ext-enable imagick

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/html

COPY --from=composer:2.8.2 /usr/bin/composer /usr/bin/composer
COPY /docker/php/php.ini /usr/local/etc/php/
COPY --chown=www-data:www-data . .

RUN composer install --no-interaction --prefer-dist
RUN mv ./vendor/ /var/www/vendor/

RUN addgroup -g ${GROUP_ID} customgroup && \
    adduser -D -u ${USER_ID} -G customgroup laravel_app

USER laravel_app

EXPOSE 9000

CMD ["php-fpm"]
