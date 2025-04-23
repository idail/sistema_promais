<?php
// Definir cabeçalhos para resposta JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Iniciar sessão e configurações
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
session_start();

// Incluir configurações do banco de dados
require_once '../../config/database.php';

// Verificar sessão e permissões
if (!isset($_SESSION['user_id']) || $_SESSION['user_access_level'] !== 'admin') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Acesso não autorizado'
    ]);
    exit;
}

// Receber IDs para exclusão
$input = json_decode(file_get_contents('php://input'), true);
$clinica_ids = $input['ids'] ?? [];

if (empty($clinica_ids)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Nenhum ID de clínica fornecido'
    ]);
    exit;
}

try {
    $pdo = getConnection();
    $pdo->beginTransaction();

    // Preparar query de exclusão
    $placeholders = implode(',', array_fill(0, count($clinica_ids), '?'));
    $query = "
        DELETE FROM clinicas 
        WHERE id IN ($placeholders) 
        AND empresa_id = ?
    ";

    $params = array_merge($clinica_ids, [$_SESSION['empresa_id']]);

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    $deletedCount = $stmt->rowCount();

    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'message' => "Clínicas excluídas com sucesso: {$deletedCount}"
    ]);

} catch (PDOException $e) {
    $pdo->rollBack();
    
    // Log do erro para debug
    error_log("Erro ao excluir clínicas: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao excluir clínicas: ' . $e->getMessage()
    ]);
}
?>
