FROM php:8.1-fpm

RUN apt-get update && apt-get install -y unzip

RUN apt-get update && apt-get install -y libpq-dev zlib1g-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer

WORKDIR /var/www/toolkit

RUN curl -sS https://get.symfony.com/cli/installer | bash
