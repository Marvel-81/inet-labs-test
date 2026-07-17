FROM composer:2.8 AS composer_base

FROM php:8.3-cli-alpine

# Копируем бинарник composer
COPY --from=composer_base /usr/bin/composer /usr/local/bin/composer

# Установка необходимых пакетов (минимальный набор для worker)
RUN apk update && apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    zlib-dev \
    libxml2-dev \
    oniguruma-dev \
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

# Устанавливаем Supervisor
RUN apk add --no-cache supervisor

# Создаем необходимые директории
RUN mkdir -p /var/log/supervisor \
    && mkdir -p /var/run/supervisor \
    && mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/bootstrap/cache

# Настройка PHP для CLI (увеличиваем память и время выполнения)
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/worker.ini \
    && echo "max_execution_time=0" >> /usr/local/etc/php/conf.d/worker.ini

WORKDIR /var/www

# Копируем entrypoint для worker
COPY worker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/worker-entrypoint.sh

# Копируем конфигурацию supervisor
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Создаем пользователя для supervisor (опционально, для безопасности)
# RUN adduser -D -u 1000 worker

# Worker будет запускаться через supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]