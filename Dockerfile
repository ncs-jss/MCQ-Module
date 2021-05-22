FROM php:7.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add shadow && usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN chown -R www-data:www-data /var/www/html
