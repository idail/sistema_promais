<?php
// Definir cabeçalhos para resposta JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Iniciar sessão e configurações
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
session_start();

// Incluir configurações do banco de dados
require_once '../../config/database.php';

// Verificar sessão
if (!isset($_SESSION['user_id']) || !isset($_SESSION['empresa_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Sessão inválida ou expirada'
    ]);
    exit;
}

try {
    $pdo = getConnection();
    $pdo->exec("SET NAMES utf8mb4");

    // Validar parâmetro da clínica
    $clinicaId = isset($_GET['clinica_id']) ? intval($_GET['clinica_id']) : null;
    if (!$clinicaId) {
        throw new Exception("ID da clínica não fornecido");
    }

    // Log de debugging
    error_log("Buscando médicos para clínica ID: $clinicaId");
    error_log("Empresa ID na sessão: " . $_SESSION['empresa_id']);

    // Query para buscar médicos associados à clínica
    $query = "
        SELECT 
            m.id, 
            m.nome, 
            m.especialidade, 
            m.crm,
            m.pcmso,
            m.contato,
            m.empresa_id,
            mc.status as associacao_status
        FROM medicos m
        JOIN medicos_clinicas mc ON m.id = mc.medico_id
        WHERE 
            mc.clinica_id = :clinica_id 
            AND mc.status = 'Ativo'
            AND m.status = 'Ativo'
        ORDER BY m.nome
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
    $stmt->execute();
    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Log de debugging
    error_log("Número de médicos encontrados: " . count($medicos));
    if (count($medicos) === 0) {
        // Verificar se existem associações
        $checkQuery = "
            SELECT medico_id 
            FROM medicos_clinicas 
            WHERE clinica_id = :clinica_id
        ";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
        $checkStmt->execute();
        $associacoes = $checkStmt->fetchAll(PDO::FETCH_COLUMN);
        
        error_log("Associações encontradas: " . implode(', ', $associacoes));
    }

    // Preparar resposta
    $response = [
        'status' => 'success',
        'data' => [
            'clinica_id' => $clinicaId,
            'empresa_id' => $_SESSION['empresa_id'],
            'medicos' => $medicos
        ]
    ];

    // Retornar JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    // Log do erro para debug
    error_log("Erro ao listar médicos da clínica: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
