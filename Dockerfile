FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl unzip zip libpng-dev libonig-dev \
    libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN rm -rf vendor \
    && rm -f add_more_dishes.php add_stock.php \
    public/clear-cache.php public/conexao.php \
    public/migrar.php public/rodar_seeder.php .router.php

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN mkdir -p storage/framework/sessions storage/framework/views \
    storage/framework/cache/data storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8000
