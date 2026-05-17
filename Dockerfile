FROM php:8.2-cli

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar arquivos
COPY . .

# Instalar dependências PHP
RUN composer install --no-interaction --no-progress

# Instalar dependências Node e compilar React
RUN npm install || true
RUN npm run build || true

# Configurar Laravel (sem .env)
RUN php artisan key:generate --force || true

EXPOSE 8000

# Usar seu start.sh
RUN chmod +x start.sh
CMD ["./start.sh"]