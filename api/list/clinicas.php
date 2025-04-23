<?php
// Definir codificação e headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Iniciar sessão e definir codificação
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
session_start();

// Incluir configurações do banco de dados
require_once '../../config/database.php';

// Validar todas as sessões necessárias
$required_sessions = [
    'user_id',
    'user_name',
    'user_plan',
    'user_expire',
    'user_access_level',
    'empresa_id',
    'empresa_nome',
    'empresa_cnpj'
];

// Log para debug
error_log("DEBUG - Sessão atual: " . print_r($_SESSION, true));
error_log("DEBUG - empresa_id na sessão: " . (isset($_SESSION['empresa_id']) ? $_SESSION['empresa_id'] : 'não definido'));

$missing_sessions = array_filter($required_sessions, fn($session) => !isset($_SESSION[$session]));

if (!empty($missing_sessions)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Sessao invalida ou expirada. Por favor, faca login novamente.',
        'missing' => $missing_sessions
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

// Validar se o plano está ativo
$user_expire = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['user_expire']);
$now = new DateTime();

if ($user_expire < $now) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Seu plano expirou. Por favor, renove sua assinatura.'
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$empresa_id = $_SESSION['empresa_id'];

// Parâmetros de filtro
$filtros = [];
$params = ['empresa_id' => $empresa_id];

// Filtro por status
if (isset($_GET['status']) && in_array($_GET['status'], ['Ativo', 'Inativo'])) {
    $filtros[] = "c.status = :status";
    $params['status'] = $_GET['status'];
}

// Filtro por cidade
if (isset($_GET['cidade_id']) && is_numeric($_GET['cidade_id'])) {
    $filtros[] = "c.cidade_id = :cidade_id";
    $params['cidade_id'] = $_GET['cidade_id'];
}

// Busca por nome, razão social ou CNPJ
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $busca = $_GET['busca'];
    $filtros[] = "(c.nome_fantasia LIKE :busca OR c.razao_social LIKE :busca OR c.cnpj LIKE :busca)";
    $params['busca'] = "%{$busca}%";
}

try {
    $pdo = getConnection();
    $pdo->exec("SET NAMES utf8mb4");

    // Log para debug da query e parâmetros
    error_log("DEBUG - empresa_id usado na query: " . $empresa_id);
    error_log("DEBUG - Parâmetros da query: " . print_r($params, true));

    // Primeiro, contar o total de registros
    $count_query = "
        SELECT COUNT(DISTINCT c.id) as total 
        FROM clinicas c
        WHERE c.empresa_id = :empresa_id
    ";

    if (!empty($filtros)) {
        $count_query .= " AND " . implode(" AND ", $filtros);
    }

    $stmt_count = $pdo->prepare($count_query);
    $stmt_count->execute($params);
    $total_registros = (int)$stmt_count->fetchColumn();

    // Paginação
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $per_page = isset($_GET['per_page']) ? max(1, min(100, intval($_GET['per_page']))) : 20;
    $offset = ($page - 1) * $per_page;

    // Query para buscar clínicas com informações da cidade
    $query = "
        SELECT 
            c.id, 
            c.empresa_id, 
            c.codigo, 
            c.nome_fantasia, 
            c.razao_social, 
            c.cnpj, 
            c.endereco, 
            c.numero, 
            c.complemento, 
            c.bairro, 
            c.cidade_id, 
            cid.nome AS cidade_nome, 
            cid.estado AS cidade_estado,
            c.cep, 
            c.email, 
            c.telefone, 
            c.status
        FROM clinicas c
        LEFT JOIN cidades cid ON c.cidade_id = cid.id
        WHERE c.empresa_id = :empresa_id
    ";

    if (!empty($filtros)) {
        $query .= " AND " . implode(" AND ", $filtros);
    }

    $query .= " ORDER BY c.nome_fantasia ASC LIMIT :offset, :per_page";

    // Preparar e executar a query principal
    $stmt = $pdo->prepare($query);
    
    // Bind dos parâmetros
    foreach ($params as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    
    $stmt->execute();
    $clinicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Para cada clínica, buscar os médicos associados
    foreach ($clinicas as &$clinica) {
        // Sanitizar strings da clínica
        foreach ($clinica as $key => $value) {
            if (is_string($value)) {
                $clinica[$key] = sanitizeString($value);
            }
        }

        $query_medicos = "
            SELECT 
                m.id,
                m.nome,
                m.especialidade,
                m.crm,
                m.pcmso,
                m.contato,
                m.status,
                mc.data_associacao
            FROM medicos m
            INNER JOIN medicos_clinicas mc ON m.id = mc.medico_id
            WHERE mc.clinica_id = :clinica_id
            AND mc.status = 'Ativo'
            ORDER BY m.nome ASC
        ";
        
        $stmt_medicos = $pdo->prepare($query_medicos);
        $stmt_medicos->execute(['clinica_id' => $clinica['id']]);
        $medicos = $stmt_medicos->fetchAll(PDO::FETCH_ASSOC);

        // Sanitizar strings dos médicos
        foreach ($medicos as &$medico) {
            foreach ($medico as $key => $value) {
                if (is_string($value)) {
                    $medico[$key] = sanitizeString($value);
                }
            }
        }

        $clinica['medicos'] = $medicos;
    }

    // Calcular total de páginas
    $total_pages = ceil($total_registros / $per_page);

    // Preparar resposta
    $response = [
        'status' => 'success',
        'data' => [
            'empresa' => [
                'id' => (int)$_SESSION['empresa_id'],
                'nome' => sanitizeString($_SESSION['empresa_nome']),
                'cnpj' => sanitizeString($_SESSION['empresa_cnpj'])
            ],
            'user' => [
                'id' => (int)$_SESSION['user_id'],
                'name' => sanitizeString($_SESSION['user_name']),
                'access_level' => sanitizeString($_SESSION['user_access_level'])
            ],
            'clinicas' => array_values($clinicas),
            'paginacao' => [
                'pagina_atual' => (int)$page,
                'registros_por_pagina' => (int)$per_page,
                'total_registros' => (int)$total_registros,
                'total_paginas' => (int)$total_pages
            ]
        ]
    ];

    // Retornar JSON formatado corretamente
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao buscar dados: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
