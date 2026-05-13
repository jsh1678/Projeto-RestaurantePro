<?php
system('php artisan config:clear');
system('php artisan cache:clear');
system('php artisan view:clear');
echo "Cache limpo!";
?>
