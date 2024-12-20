FROM phpdockerio/php:8.4-fpm

WORKDIR "/var/www"

COPY . /var/www

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.4-mysql \
        php8.4-xdebug \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
