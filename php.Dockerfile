FROM php:7.3-fpm-alpine
 
# install mysql pdo driver
RUN docker-php-ext-install pdo_mysql