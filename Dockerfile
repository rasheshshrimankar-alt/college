# Build PHP dependencies with the same PHP version used at runtime.
FROM php:8.3-cli-bookworm AS php-build

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libpq-dev libzip-dev libicu-dev libpng-dev libjpeg62-turbo-dev \
    libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd intl zip opcache \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . .
RUN mkdir -p bootstrap/cache storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# Build Vite assets. This repository has no package-lock.json, so npm install
# is used instead of npm ci.
FROM node:22-bookworm-slim AS frontend-build
WORKDIR /app
COPY . .
RUN npm install --no-audit --no-fund && npm run build

# Production web image.
FROM php:8.3-apache-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev libzip-dev libicu-dev libpng-dev libjpeg62-turbo-dev \
    libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd intl zip opcache \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY --from=php-build /app /var/www/html
COPY --from=frontend-build /app/public/build /var/www/html/public/build
COPY docker/apache-render.conf /etc/apache2/sites-available/000-default.conf
COPY docker/ports.conf /etc/apache2/ports.conf
COPY docker-entrypoint.sh /usr/local/bin/college-entrypoint

RUN chmod +x /usr/local/bin/college-entrypoint \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

ENV APACHE_RUN_DIR=/var/run/apache2 \
    APACHE_PID_FILE=/var/run/apache2/apache2.pid \
    APACHE_LOCK_DIR=/var/lock/apache2 \
    APACHE_LOG_DIR=/var/log/apache2

EXPOSE 10000
ENTRYPOINT ["college-entrypoint"]
CMD ["apache2-foreground"]
