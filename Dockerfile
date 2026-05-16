FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    libpq-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN chmod -R 777 storage bootstrap/cache || true

RUN php artisan key:generate --force || true

RUN php artisan config:clear || true
RUN php artisan config:cache || true

EXPOSE 8000

# CORRIGIDO: usa PHP server ao invés de artisan serve
CMD php -S 0.0.0.0:${PORT:-8000} -t public
