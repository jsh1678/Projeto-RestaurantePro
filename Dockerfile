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

# Criar .env se não existir
RUN if [ ! -f .env ] && [ -f .env.example ]; then cp .env.example .env; fi
RUN if [ ! -f .env ]; then echo "APP_KEY=" > .env; fi

# Instalar dependências
RUN composer install --no-interaction --no-progress
RUN npm install
RUN npm run build

# Configurar Laravel
RUN php artisan key:generate --force
RUN php artisan config:cache

# DAR PERMISSÃO DE EXECUÇÃO AO START.SH (CORREÇÃO)
RUN chmod +x start.sh

EXPOSE 8000

# Executar o start.sh
CMD ["./start.sh"]