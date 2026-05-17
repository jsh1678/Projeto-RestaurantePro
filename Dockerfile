FROM php:8.2-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar arquivos do projeto
COPY . .

# Remover arquivos desnecessários para produção
RUN rm -f \
    add_more_dishes.php \
    add_stock.php \
    public/clear-cache.php \
    public/conexao.php \
    public/migrar.php \
    public/rodar_seeder.php \
    .router.php

# Instalar dependências PHP (sem dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Criar estrutura de diretórios necessária
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache/data \
    storage/logs \
    bootstrap/cache

# Permissões de escrita
RUN chmod -R 775 storage bootstrap/cache

# Copiar e habilitar script de inicialização
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8000
