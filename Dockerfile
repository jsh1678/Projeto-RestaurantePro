FROM php:8.2-cli

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    nodejs \
    npm \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Instalar Vite globalmente
RUN npm install -g vite

WORKDIR /app

# Copiar arquivos
COPY . .

# CRIAR .env a partir do .env.example (CORREÇÃO AQUI!)
RUN if [ ! -f .env ] && [ -f .env.example ]; then cp .env.example .env; fi
RUN if [ ! -f .env ]; then echo "APP_KEY=" > .env; fi

# Instalar dependências PHP
RUN composer install --no-interaction --no-progress

# Instalar dependências Node e compilar React
RUN npm install
RUN npm run build

# Configurar Laravel (agora com .env existente)
RUN php artisan key:generate --force
RUN php artisan config:cache

EXPOSE 8000

# Script de start
RUN echo '#!/bin/bash\n\
echo "=== Iniciando Servidor ==="\n\
php artisan migrate --force\n\
php artisan config:clear\n\
php artisan config:cache\n\
php artisan serve --host=0.0.0.0 --port=8000' > /start.sh && chmod +x /start.sh

CMD ["./start.sh"]