FROM php:8.3-fpm-alpine

RUN apk update && \
    apk add --no-cache zip && \
    apk add --no-cache curl && \
    apk add --no-cache curl-dev && \
    apk add --no-cache icu-dev && \
    apk add --no-cache oniguruma-dev && \
    apk add --no-cache libxml2-dev && \
    apk add --no-cache php-memcached && \
    apk add --no-cache \
        freetype-dev \
        libpng-dev \
        jpeg-dev \
        libjpeg-turbo-dev

RUN docker-php-ext-install curl gd intl mbstring mysqli pdo pdo_mysql xml

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \ 
    && apk --no-cache add libmemcached-dev zlib-dev \
    && yes '' | pecl install memcached \
    && docker-php-ext-enable memcached \
    && apk del pcre-dev ${PHPIZE_DEPS}
