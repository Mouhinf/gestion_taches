# ============================================================
# Stage 1 : build — installation des dépendances PHP (composer)
# ============================================================
FROM composer:2 AS build
WORKDIR /app

# Copie des manifests d'abord pour profiter du cache Docker
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

# Copie du code source puis installation complète + autoload optimisé
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs \
    && composer dump-autoload --optimize --no-dev

# ============================================================
# Stage 2 : runtime — PHP 8.2 CLI (Render ne fournit pas de
# runtime PHP natif, on embarque notre propre image)
# ============================================================
FROM php:8.2-cli

# Extensions nécessaires : pdo_pgsql (PostgreSQL), gd (DOMPDF),
# mbstring, zip, bcmath, opcache
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libzip-dev \
        libonig-dev \
        zip \
        unzip \
        git \
        curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pgsql \
        gd \
        mbstring \
        zip \
        bcmath \
        opcache \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copie de l'application compilée depuis le stage build
COPY --from=build /app /var/www/html
COPY --from=build /usr/bin/composer /usr/bin/composer

# Permissions pour storage/ et bootstrap/cache/
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Render injecte la variable $PORT ; on écoute dessus
CMD ["sh", "-c", "php artisan serve --host 0.0.0.0 --port ${PORT:-10000}"]