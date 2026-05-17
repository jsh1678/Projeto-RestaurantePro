#!/bin/bash
set -e

cd /app

echo "Iniciando Sistema de Gestao Restaurante"

if [ -z "$APP_KEY" ]; then
    echo "ERRO: APP_KEY nao definida!"
    exit 1
fi

echo "[1/5] Limpando caches..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear  2>/dev/null || true
php artisan view:clear   2>/dev/null || true
php artisan route:clear  2>/dev/null || true

echo "[2/5] Storage link..."
php artisan storage:link --force 2>/dev/null || true

echo "[3/5] Migrations..."
php artisan migrate --force

echo "[4/5] Cache de producao..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[5/5] Subindo servidor na porta ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}