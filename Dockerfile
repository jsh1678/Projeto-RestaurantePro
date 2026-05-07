FROM php:8.4-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --optimize-autoloader --no-dev

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
