FROM php:8.3-cli-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        libsqlite3-dev \
        libzip-dev \
        nodejs \
        npm \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts --optimize-autoloader

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build \
    && composer dump-autoload --optimize \
    && php artisan package:discover --ansi \
    && chmod +x docker/start.sh

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/var/www/html/database/database.sqlite \
    SESSION_DRIVER=file \
    CACHE_STORE=file \
    QUEUE_CONNECTION=sync \
    APP_LOCALE=ar \
    APP_FALLBACK_LOCALE=ar

EXPOSE 8000

CMD ["docker/start.sh"]
