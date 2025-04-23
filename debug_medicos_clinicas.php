<?php
// Debug script for medicos_clinicas relationships
require_once 'config/database.php';
require_once 'config/seguranca.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, 
        DB_USER, 
        DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query para verificar relacionamentos
    $query = "
        SELECT 
            m.id as medico_id, 
            m.nome as medico_nome, 
            m.crm,
            c.id as clinica_id, 
            c.nome_fantasia as clinica_nome,
            mc.status as associacao_status
        FROM medicos m
        LEFT JOIN medicos_clinicas mc ON m.id = mc.medico_id
        LEFT JOIN clinicas c ON mc.clinica_id = c.id
        WHERE m.empresa_id = :empresa_id
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':empresa_id' => $_SESSION['empresa_id']]);
    
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($resultados);
    echo "</pre>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
