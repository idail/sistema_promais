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
    $requiredFields = ['medicos', 'clinica_id'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            throw new Exception("Campo obrigatório '$field' não fornecido");
        }
    }

    // Preparar lista de médicos para associação
    $medicos = $data['medicos'];
    $clinicaId = $data['clinica_id'];
    $empresaId = $_SESSION['empresa_id'];

    // Preparar statement para inserção
    $insertQuery = "
        INSERT INTO medicos_clinicas 
        (empresa_id, medico_id, clinica_id, status, data_associacao) 
        VALUES 
        (:empresa_id, :medico_id, :clinica_id, 'Ativo', NOW())
        ON DUPLICATE KEY UPDATE 
        status = 'Ativo', 
        data_associacao = NOW()
    ";
    $insertStmt = $pdo->prepare($insertQuery);

    // Variáveis para tracking
    $associados = [];
    $jaAssociados = [];

    // Processar cada médico
    foreach ($medicos as $medicoId) {
        // Verificar se já está associado
        $checkQuery = "
            SELECT id FROM medicos_clinicas 
            WHERE medico_id = :medico_id 
            AND clinica_id = :clinica_id 
            AND status = 'Ativo'
        ";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':medico_id', $medicoId, PDO::PARAM_INT);
        $checkStmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $jaAssociados[] = $medicoId;
            continue;
        }

        // Associar médico
        $insertStmt->bindParam(':empresa_id', $empresaId, PDO::PARAM_INT);
        $insertStmt->bindParam(':medico_id', $medicoId, PDO::PARAM_INT);
        $insertStmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
        $insertStmt->execute();
        
        $associados[] = $medicoId;
    }

    $pdo->commit();

    // Preparar resposta
    $response = [
        'status' => 'success',
        'message' => 'Médicos associados à clínica com sucesso',
        'data' => [
            'empresa_id' => $empresaId,
            'clinica_id' => $clinicaId,
            'medicos_associados' => $associados,
            'medicos_ja_associados' => $jaAssociados
        ]
    ];

    // Retornar JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Log do erro para debug
    error_log("Erro ao associar médicos à clínica: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
