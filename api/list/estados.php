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

    // Preparar a consulta base
    $query = "
        SELECT 
            id, 
            nome, 
            uf,
            status
        FROM estados
        WHERE 1=1
    ";

    // Verificar se foi solicitado um estado específico
    $params = [];
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $query .= " AND id = :id";
        $params[':id'] = $_GET['id'];
    }

    // Adicionar filtro de status ativo, se não especificado de outra forma
    if (!isset($_GET['incluir_inativos']) || $_GET['incluir_inativos'] != true) {
        $query .= " AND status = 'Ativo'";
    }

    // Ordenar por nome
    $query .= " ORDER BY nome";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formatar a resposta
    $response = [
        'status' => 'success',
        'data' => [
            'estados' => $estados,
            'total' => count($estados)
        ]
    ];

    // Enviar resposta
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    // Tratamento de erro detalhado
    $response = [
        'status' => 'error',
        'message' => 'Erro ao buscar estados',
        'error_details' => $e->getMessage()
    ];
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
