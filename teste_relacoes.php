<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'promais';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar tabelas
$tables = ['medicos', 'medicos_clinicas', 'cidades', 'clinicas'];
foreach ($tables as $table) {
    echo "\nDescrição da tabela $table:\n";
    $result = $conn->query("DESCRIBE $table");
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
}

// Contar registros em cada tabela
foreach ($tables as $table) {
    $result = $conn->query("SELECT COUNT(*) as count FROM $table");
    $row = $result->fetch_assoc();
    echo "\nTotal de registros em $table: " . $row['count'];
}

// Verificar chaves estrangeiras
$queries = [
    "Médicos por Clínica" => "
        SELECT 
            c.nome_fantasia AS clinica, 
            COUNT(mc.medico_id) AS total_medicos
        FROM 
            clinicas c
        LEFT JOIN 
            medicos_clinicas mc ON c.id = mc.clinica_id
        GROUP BY 
            c.id
        LIMIT 10
    ",
    "Clínicas por Cidade" => "
        SELECT 
            ci.nome AS cidade, 
            COUNT(c.id) AS total_clinicas
        FROM 
            cidades ci
        LEFT JOIN 
            clinicas c ON ci.id = c.cidade_id
        GROUP BY 
            ci.id
        LIMIT 10
    "
];

foreach ($queries as $title => $query) {
    echo "\n\n$title:\n";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
}

$conn->close();
?>
