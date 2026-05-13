<?php
shell_exec('cd /app && php artisan migrate --force');
echo "Migrações executadas!";
?>