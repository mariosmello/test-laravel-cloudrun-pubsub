FROM php:8.2-apache

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_mysql zip exif pcntl gd memcached

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    nginx

# Enable Apache modules
RUN a2enmod rewrite expires headers

# Change default document_root to /var/www/html/public because it's a Laravel project
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf &&\
sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ARG COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html
COPY .env.example /var/www/html/.env

RUN chown -R www-data: /var/www/html/storage

WORKDIR /var/www/html
RUN composer install
RUN php artisan key:generate

EXPOSE 80
CMD ["apache2ctl", "-D", "FOREGROUND"]
