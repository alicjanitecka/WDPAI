# FROM php:8.2.11-fpm-alpine3.18

# # Copy the application code
# COPY . /app

# VOLUME ["/app"]

FROM php:8.2.11-fpm-alpine3.18

ENV RUN_DEPS \
    zlib \
    libzip \
    libpng \
    libjpeg-turbo \
    postgresql-libs

ENV BUILD_DEPS \
    zlib-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    postgresql-dev

ENV PHP_EXTENSIONS \
    opcache \
    zip \
    gd \
    bcmath \
    pgsql \
    pdo_pgsql

RUN apk add --no-cache --virtual .build-deps $BUILD_DEPS \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j "$(nproc)" $PHP_EXTENSIONS \
    && apk del .build-deps

RUN apk add --no-cache --virtual .run-deps $RUN_DEPS

RUN echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini; 



#dodane
RUN apk add --no-cache postgresql-dev

# Install and enable PostgreSQL extensions
RUN docker-php-ext-install pdo pdo_pgsql
#koniec

# Copy the application code
COPY . /app

VOLUME ["/app"]
