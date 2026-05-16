FROM php:8.2-cli

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

RUN php artisan key:generate

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000