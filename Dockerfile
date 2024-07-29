FROM node:16 AS frontend-builder

WORKDIR /app

COPY src/appointment-tracker-frontend/package*.json ./
RUN npm install
COPY src/appointment-tracker-frontend ./

RUN npm run build

FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY src/api /var/www/html/
COPY composer.json composer.lock /var/www/html/

RUN composer install --no-scripts --no-autoloader
RUN composer dump-autoload --optimize

COPY --from=frontend-builder /app/dist /var/www/html/frontend

COPY .env /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]
