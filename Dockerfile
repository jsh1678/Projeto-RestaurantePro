FROM php:8.2-cli

# Instalar extensões necessárias
RUN docker-php-ext-install pdo_mysql

# Instalar Composer como usuário não-root
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Criar diretório de trabalho
WORKDIR /app

# Copiar arquivos do projeto
COPY . .

# Instalar dependências do Laravel (CORRIGIDO)
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-zip

# Gerar APP_KEY se não existir
RUN php artisan key:generate --force

# Limpar e cachear configurações
RUN php artisan config:cache

# Expor porta
EXPOSE 8000

# Iniciar o servidor
CMD php artisan serve --host=0.0.0.0 --port=8000