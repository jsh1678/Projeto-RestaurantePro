#!/bin/bash
#!/bin/bash
set -e

cd /app

echo "=== ARQUIVOS EM PUBLIC ==="
ls -la /app/public/
echo "=========================="

# ... resto do arquivo continua igual
set -e

cd /app

echo "========================================"
echo " Iniciando Sistema de Gestão Restaurante"
echo "========================================"

# Verificar variáveis obrigatórias
if [ -z "$APP_KEY" ]; then
    echo "ERRO: APP_KEY não definida! Configure nas variáveis do Railway."
    exit 1
fi

if [ -z "$DB_HOST" ] && [ -z "$DATABASE_URL" ]; then
    echo "ERRO: Banco de dados não configurado! Defina DB_HOST ou DATABASE_URL."
    exit 1
fi

echo "[1/5] Limpando caches antigos..."
php artisan config:clear  2>/dev/null || true
php artisan cache:clear   2>/dev/null || true
php artisan view:clear    2>/dev/null || true
php artisan route:clear   2>/dev/null || true

echo "[2/5] Criando symlink do storage..."
php artisan storage:link --force 2>/dev/null || true

echo "[3/5] Rodando migrations..."
php artisan migrate --force

echo "[4/5] Gerando caches de produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[5/5] Subindo servidor na porta ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
