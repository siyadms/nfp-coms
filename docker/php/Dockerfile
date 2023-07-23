FROM php:fpm-alpine
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install opcache
COPY docker/php/prod/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./api/ /var/www/html/
