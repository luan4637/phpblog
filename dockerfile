FROM php:8.3-fpm-alpine

RUN apk update && \
    apk add --no-cache git && \
    apk add --no-cache zip && \
    apk add --no-cache curl && \
    apk add --no-cache curl-dev && \
    apk add --no-cache icu-dev && \
    apk add --no-cache oniguruma-dev && \
    apk add --no-cache libxml2-dev && \
    apk add --no-cache \
        freetype-dev \
        libpng-dev \
        jpeg-dev \
        libjpeg-turbo-dev

RUN docker-php-ext-install curl gd intl mbstring mysqli pdo pdo_mysql xml
