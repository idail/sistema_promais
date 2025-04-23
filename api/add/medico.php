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
    $requiredFields = ['nome', 'crm', 'especialidade'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            throw new Exception("Campo obrigatório '$field' não fornecido");
        }
    }

    // Verificar se o CRM já existe
    $checkQuery = "
        SELECT id FROM medicos 
        WHERE crm = :crm AND status = 'Ativo'
    ";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':crm', $data['crm'], PDO::PARAM_STR);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        throw new Exception("Médico com este CRM já cadastrado");
    }

    // Preparar dados opcionais
    $pcmso = $data['pcmso'] ?? null;
    $contato = $data['contato'] ?? null;

    // Inserir médico
    $insertQuery = "
        INSERT INTO medicos 
        (empresa_id, nome, especialidade, crm, pcmso, contato, status) 
        VALUES 
        (:empresa_id, :nome, :especialidade, :crm, :pcmso, :contato, 'Ativo')
    ";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindParam(':empresa_id', $_SESSION['empresa_id'], PDO::PARAM_INT);
    $insertStmt->bindParam(':nome', $data['nome'], PDO::PARAM_STR);
    $insertStmt->bindParam(':especialidade', $data['especialidade'], PDO::PARAM_STR);
    $insertStmt->bindParam(':crm', $data['crm'], PDO::PARAM_STR);
    $insertStmt->bindParam(':pcmso', $pcmso, PDO::PARAM_STR);
    $insertStmt->bindParam(':contato', $contato, PDO::PARAM_STR);
    $insertStmt->execute();

    $medicoId = $pdo->lastInsertId();

    // Associar médico à clínica, se clinica_id for fornecido
    if (isset($data['clinica_id']) && !empty($data['clinica_id'])) {
        $associateQuery = "
            INSERT INTO medicos_clinicas 
            (empresa_id, medico_id, clinica_id, status) 
            VALUES 
            (:empresa_id, :medico_id, :clinica_id, 'Ativo')
        ";
        $associateStmt = $pdo->prepare($associateQuery);
        $associateStmt->bindParam(':empresa_id', $_SESSION['empresa_id'], PDO::PARAM_INT);
        $associateStmt->bindParam(':medico_id', $medicoId, PDO::PARAM_INT);
        $associateStmt->bindParam(':clinica_id', $data['clinica_id'], PDO::PARAM_INT);
        $associateStmt->execute();
    }

    $pdo->commit();

    // Preparar resposta
    $response = [
        'status' => 'success',
        'message' => 'Médico cadastrado com sucesso',
        'data' => [
            'empresa_id' => $_SESSION['empresa_id'],
            'medico_id' => $medicoId,
            'nome' => $data['nome'],
            'crm' => $data['crm'],
            'especialidade' => $data['especialidade']
        ]
    ];

    // Retornar JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Log do erro para debug
    error_log("Erro ao cadastrar médico: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
