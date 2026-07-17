FROM composer:2.8 AS composer_base

# Используем тот же базовый образ php-fpm на alpine
FROM php:8.3-fpm-alpine

# Копируем бинарник composer из официального образа
COPY --from=composer_base /usr/bin/composer /usr/local/bin/composer

# Установка необходимых пакетов (библиотеки для компиляции расширений)
RUN apk update && apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    zlib-dev \
    libxml2-dev \
    oniguruma-dev \
    npm \
    bash \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    autoconf \
    g++ \
    make \    
    linux-headers \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-xpm \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && pecl install xdebug && docker-php-ext-enable xdebug

# Настройка Xdebug
RUN echo "xdebug.mode=debug" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=false" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www

COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]