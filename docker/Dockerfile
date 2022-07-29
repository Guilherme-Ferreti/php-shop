FROM php:8.1.8-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libicu-dev \
    g++

RUN docker-php-ext-configure intl

RUN docker-php-ext-install pdo pdo_mysql opcache intl

COPY php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www
