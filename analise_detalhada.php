<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'promais';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Análise detalhada de médicos e suas clínicas
$query_medicos_detalhado = "
SELECT 
    m.id AS medico_id,
    m.nome AS medico_nome,
    m.especialidade,
    m.crm,
    m.status AS medico_status,
    c.id AS clinica_id,
    c.nome_fantasia AS clinica_nome,
    ci.nome AS cidade_clinica,
    ci.estado AS estado_clinica,
    mc.status AS associacao_status,
    mc.data_associacao
FROM 
    medicos m
JOIN 
    medicos_clinicas mc ON m.id = mc.medico_id
JOIN 
    clinicas c ON mc.clinica_id = c.id
JOIN 
    cidades ci ON c.cidade_id = ci.id
ORDER BY 
    m.nome, c.nome_fantasia
";

echo "Análise Detalhada de Médicos e Clínicas:\n";
$result = $conn->query($query_medicos_detalhado);
$medicos_detalhados = [];

while ($row = $result->fetch_assoc()) {
    $medico_id = $row['medico_id'];
    if (!isset($medicos_detalhados[$medico_id])) {
        $medicos_detalhados[$medico_id] = [
            'nome' => $row['medico_nome'],
            'especialidade' => $row['especialidade'],
            'crm' => $row['crm'],
            'status' => $row['medico_status'],
            'clinicas' => []
        ];
    }
    
    $medicos_detalhados[$medico_id]['clinicas'][] = [
        'nome' => $row['clinica_nome'],
        'cidade' => $row['cidade_clinica'],
        'estado' => $row['estado_clinica'],
        'status_associacao' => $row['associacao_status'],
        'data_associacao' => $row['data_associacao']
    ];
}

// Imprimir resultados formatados
foreach ($medicos_detalhados as $medico) {
    echo "\nMédico: {$medico['nome']}\n";
    echo "Especialidade: {$medico['especialidade']}\n";
    echo "CRM: {$medico['crm']}\n";
    echo "Status: {$medico['status']}\n";
    echo "Clínicas:\n";
    
    foreach ($medico['clinicas'] as $clinica) {
        echo "  - {$clinica['nome']} ({$clinica['cidade']} - {$clinica['estado']})\n";
        echo "    Status Associação: {$clinica['status_associacao']}\n";
        echo "    Data Associação: {$clinica['data_associacao']}\n";
    }
    echo str_repeat('-', 50) . "\n";
}

// Análise de distribuição de médicos
$query_distribuicao = "
SELECT 
    c.nome_fantasia AS clinica,
    ci.nome AS cidade,
    ci.estado,
    COUNT(DISTINCT m.id) AS total_medicos,
    GROUP_CONCAT(DISTINCT m.especialidade) AS especialidades
FROM 
    clinicas c
LEFT JOIN 
    medicos_clinicas mc ON c.id = mc.clinica_id
LEFT JOIN 
    medicos m ON mc.medico_id = m.id
LEFT JOIN 
    cidades ci ON c.cidade_id = ci.id
GROUP BY 
    c.id
ORDER BY 
    total_medicos DESC
";

echo "\n\nDistribuição de Médicos por Clínica:\n";
$result = $conn->query($query_distribuicao);
while ($row = $result->fetch_assoc()) {
    echo "Clínica: {$row['clinica']} ({$row['cidade']} - {$row['estado']})\n";
    echo "Total de Médicos: {$row['total_medicos']}\n";
    echo "Especialidades: {$row['especialidades']}\n";
    echo str_repeat('-', 50) . "\n";
}

$conn->close();
?>
