FROM php:8.1.0RC6-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libsqlite3-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libcurl4-openssl-dev \
        libxml2-dev \
        libicu-dev \
        libonig-dev \
        libssl-dev \
        locales \
        msmtp \
        && apt-get clean \
        && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install "-j$(nproc)" mbstring curl pdo pdo_mysql intl gd

RUN a2enmod rewrite

