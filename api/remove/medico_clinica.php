<?php
// Definir cabeçalhos para resposta JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
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
    $pdo->beginTransaction();

    // Receber dados JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validar dados recebidos
    $requiredFields = ['medico_id', 'clinica_id'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            throw new Exception("Campo obrigatório '$field' não fornecido");
        }
    }

    $medicoId = $data['medico_id'];
    $clinicaId = $data['clinica_id'];
    $empresaId = $_SESSION['empresa_id'];

    // Remover associação do médico com a clínica
    $removeQuery = "
        UPDATE medicos_clinicas 
        SET status = 'Inativo' 
        WHERE 
            medico_id = :medico_id 
            AND clinica_id = :clinica_id 
            AND empresa_id = :empresa_id
    ";
    $removeStmt = $pdo->prepare($removeQuery);
    $removeStmt->bindParam(':medico_id', $medicoId, PDO::PARAM_INT);
    $removeStmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
    $removeStmt->bindParam(':empresa_id', $empresaId, PDO::PARAM_INT);
    $removeStmt->execute();

    $affectedRows = $removeStmt->rowCount();

    $pdo->commit();

    // Preparar resposta
    $response = [
        'status' => 'success',
        'message' => 'Médico desassociado da clínica com sucesso',
        'data' => [
            'empresa_id' => $empresaId,
            'clinica_id' => $clinicaId,
            'medico_id' => $medicoId,
            'linhas_afetadas' => $affectedRows
        ]
    ];

    // Retornar JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Log do erro para debug
    error_log("Erro ao desassociar médico da clínica: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
