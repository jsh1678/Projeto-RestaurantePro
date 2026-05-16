FROM php:8.2-cli

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar arquivos do projeto
COPY . .

# Criar .env a partir do .env.example (SE não existir)
RUN if [ ! -f .env ]; then \
        cp .env.example .env; \
    fi

# Instalar dependências
RUN composer install --no-interaction --no-progress

# Gerar APP_KEY (vai gerar uma nova, mas a do Railway vai sobrescrever)
RUN php artisan key:generate --force

# Limpar e cachear configurações
RUN php artisan config:cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000