FROM php:7.4-fpm-alpine
# lumen packages
#RUN docker-php-ext-install mbstring tokenizer mysqli pdo_mysql
RUN docker-php-ext-install tokenizer mysqli pdo_mysql
RUN apk update
RUN apk add composer

