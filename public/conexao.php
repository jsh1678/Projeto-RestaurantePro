<?php
echo "<h1>Teste de Conexão com o Banco</h1>";

$host = 'yamabiko.proxy.rlwy.net';
$port = '22170';
$db = 'railway';
$user = 'root';
$pass = 'nCBsYgEIidvIUfcCMtRhytPXcRBSPhcu';

echo "<p>Conectando a: $host:$port/$db</p>";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✅ Conectado com sucesso ao banco de dados!</p>";

    $result = $pdo->query("SELECT NOW() as data_hora");
    $row = $result->fetch();
    echo "<p>Data/Hora do servidor: " . $row['data_hora'] . "</p>";

} catch(PDOException $e) {
    echo "<p style='color:red'>❌ Erro: " . $e->getMessage() . "</p>";
}
?>
