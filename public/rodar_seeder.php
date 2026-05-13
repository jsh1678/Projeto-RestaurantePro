<?php
echo "<pre>";
exec('cd /app && php artisan db:seed --force 2>&1', $output, $return);
foreach($output as $line) {
    echo htmlspecialchars($line) . "\n";
}
echo "</pre>";

if ($return === 0) {
    echo "<h2 style='color:green'>✅ Seeders executados com sucesso!</h2>";
    echo "<a href='/login' style='font-size:18px'>🔐 Ir para o login</a>";
} else {
    echo "<h2 style='color:red'>❌ Erro ao executar seeders</h2>";
}
?>