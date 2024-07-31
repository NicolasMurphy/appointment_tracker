FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock api/ ./

COPY .env /var/www/html/

RUN composer install --no-scripts --no-autoloader

RUN composer dump-autoload --optimize

EXPOSE 80

CMD ["apache2-foreground"]
