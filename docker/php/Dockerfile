FROM php:8.0.3-fpm-alpine3.13

RUN apk update \
    && apk add --no-cache --virtual \
        .build-deps $PHPIZE_DEPS \
    && apk add --no-cache \
        icu-dev \
    && docker-php-ext-configure \
        intl \
    && docker-php-ext-install \
        opcache \
        pdo_mysql \
        bcmath \
        intl \
    && docker-php-ext-enable \
        opcache \
        intl \
    && apk del .build-deps

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./docker/php/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini
COPY ./nowme-backend /var/www/symfony

WORKDIR /var/www/symfony