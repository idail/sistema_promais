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

    // Parâmetros de busca
    $searchTerm = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : null;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $associarClinica = isset($_GET['associar_clinica']) ? boolval($_GET['associar_clinica']) : false;

    // Verificar se o ID da clínica atual está na sessão
    $clinicaId = $_SESSION['current_clinica_id'] ?? null;

    // Filtrar médicos para associação de clínica
    if ($associarClinica) {
        $clinicaId = isset($_GET['clinica_id']) ? intval($_GET['clinica_id']) : null;
        
        if (!$clinicaId) {
            // Tentar obter o ID da clínica da sessão
            $clinicaId = $_SESSION['current_clinica_id'] ?? null;
        }

        if (!$clinicaId) {
            // Resposta de erro mais amigável
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'ID da clínica não especificado. Por favor, selecione uma clínica primeiro.',
                'data' => []
            ]);
            exit;
        }

        // Subconsulta para encontrar médicos não associados à clínica
        $query = "
            SELECT 
                m.id, 
                m.nome, 
                m.crm, 
                m.especialidade,
                m.pcmso,
                m.contato,
                m.empresa_id,
                (
                    SELECT COUNT(*)
                    FROM medicos_clinicas mc
                    WHERE mc.medico_id = m.id
                ) as clinicas_associadas
            FROM medicos m
            WHERE 
                m.status = 'Ativo' 
                AND (
                    m.empresa_id IS NULL 
                    OR m.empresa_id = :empresa_id
                )
                AND m.id NOT IN (
                    SELECT medico_id 
                    FROM medicos_clinicas 
                    WHERE 
                        clinica_id = :clinica_id 
                        AND status = 'Ativo'
                )
                " . ($searchTerm ? "AND m.nome LIKE :search_term" : "") . "
            GROUP BY 
                m.id, m.nome, m.crm, m.especialidade, m.pcmso, m.contato, m.empresa_id
            ORDER BY 
                clinicas_associadas, m.nome
            LIMIT :limit
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':empresa_id', $_SESSION['empresa_id'], PDO::PARAM_INT);
        $stmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        
        if ($searchTerm) {
            $searchTermParam = "%{$searchTerm}%";
            $stmt->bindParam(':search_term', $searchTermParam, PDO::PARAM_STR);
        }
    } else {
        // Query para buscar médicos com lógica complexa de associação
        $query = "
            SELECT 
                m.id, 
                m.nome, 
                m.especialidade, 
                m.crm,
                m.pcmso,
                m.contato,
                m.empresa_id,
                (
                    SELECT COUNT(*)
                    FROM medicos_clinicas mc
                    WHERE mc.medico_id = m.id
                ) as clinicas_associadas
            FROM medicos m
            WHERE 
                m.status = 'Ativo' 
                AND (
                    m.empresa_id IS NULL 
                    OR m.empresa_id = :empresa_id
                )
                " . ($searchTerm ? "AND m.nome LIKE :search_term" : "") . "
            GROUP BY 
                m.id, m.nome, m.especialidade, m.crm, m.pcmso, m.contato, m.empresa_id
            ORDER BY 
                clinicas_associadas, m.nome
            LIMIT :limit
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':empresa_id', $_SESSION['empresa_id'], PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        
        if ($searchTerm) {
            $stmt->bindParam(':search_term', $searchTerm, PDO::PARAM_STR);
        }
    }

    $stmt->execute();
    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Log para depuração detalhada
    error_log("Busca de médicos - Detalhes:" . json_encode([
        'Termo de Busca' => $searchTerm,
        'Empresa ID' => $_SESSION['empresa_id'],
        'Clínica ID' => $clinicaId,
        'Associar Clínica' => $associarClinica,
        'Total de Resultados' => count($medicos),
        'Query' => $query
    ], JSON_PRETTY_PRINT));

    // Preparar resposta com informações adicionais
    $response = [
        'status' => 'success',
        'data' => [
            'empresa_id' => $_SESSION['empresa_id'],
            'clinica_id' => $clinicaId,
            'empresa_nome' => $_SESSION['empresa_nome'],
            'search_term' => $searchTerm,
            'medicos' => array_map(function($medico) {
                // Adicionar informação se o médico pode ser associado
                $medico['pode_associar'] = (
                    $medico['empresa_id'] === null || 
                    $medico['empresa_id'] == $_SESSION['empresa_id']
                );
                return $medico;
            }, $medicos)
        ]
    ];

    // Retornar JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    // Log do erro para debug
    error_log("Erro ao buscar médicos: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao buscar médicos: ' . $e->getMessage()
    ]);
}
?>
