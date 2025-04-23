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

// Verificar sessão
if (!isset($_SESSION['user_id']) || !isset($_SESSION['empresa_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Sessão inválida ou expirada'
    ]);
    exit;
}

try {
    // Receber dados JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validar e definir variáveis de sessão
    if (isset($data['current_clinica_id'])) {
        $_SESSION['current_clinica_id'] = intval($data['current_clinica_id']);
    }

    // Preparar resposta
    $response = [
        'status' => 'success',
        'message' => 'Variáveis de sessão definidas',
        'data' => [
            'current_clinica_id' => $_SESSION['current_clinica_id'] ?? null
        ]
    ];

    // Retornar JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    // Log do erro para debug
    error_log("Erro ao definir variáveis de sessão: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
