FROM php:8.4-fpm

# ARGs devem vir antes do uso
ARG DOCKER_USER_ID
ARG DOCKER_GROUP_ID

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip curl git \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

# Cria grupo e usuário com os mesmos UID e GID do host
RUN addgroup --gid ${DOCKER_GROUP_ID} appgroup \
 && adduser --uid ${DOCKER_USER_ID} --gid ${DOCKER_GROUP_ID} --disabled-password --gecos "" appuser

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

USER appuser
