<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'promais';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Descrição da tabela
echo "Descrição da tabela clinicas:\n";
$result = $conn->query("DESCRIBE clinicas");
while ($row = $result->fetch_assoc()) {
    print_r($row);
}

echo "\n\nPrimeiros 5 registros da tabela clinicas:\n";
$result = $conn->query("SELECT * FROM clinicas LIMIT 5");
while ($row = $result->fetch_assoc()) {
    print_r($row);
}

$conn->close();
?>
