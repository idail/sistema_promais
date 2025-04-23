<?php
header('Content-Type: application/json');

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'promais';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao conectar ao banco de dados.']);
    exit;
}

// Função para autenticar e buscar a chave de API
function autenticar($pdo, $usuarioId) {
    // Primeiro, buscamos o usuario_id e o empresa_id do usuário
    $queryUsuario = "
        SELECT u.id AS usuario_id, u.nome AS usuario_nome, u.empresa_id
        FROM usuarios u
        WHERE u.id = :usuarioId
    ";

    $stmtUsuario = $pdo->prepare($queryUsuario);
    $stmtUsuario->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
    $stmtUsuario->execute();

    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        return ['status' => 'error', 'message' => 'Usuário não encontrado.'];
    }

    // Validamos se o usuário está associado a uma empresa
    if (!$usuario['empresa_id']) {
        return ['status' => 'error', 'message' => 'Usuário não está associado a uma empresa.'];
    }

    // Agora buscamos a chave de API na tabela chaves_liberacao, usando o empresa_id
    $queryChave = "
        SELECT 
            c.id AS chave_id, 
            c.chave,
            c.empresa_id, 
            c.expira_em, 
            c.ativo, 
            p.nome AS plano_nome, 
            p.duracao,
            e.nome AS empresa_nome,
            e.cnpj AS empresa_cnpj
        FROM chaves_liberacao c
        INNER JOIN empresas e ON c.empresa_id = e.id
        INNER JOIN planos p ON c.plano_id = p.id
        WHERE c.empresa_id = :empresaId
    ";

    $stmtChave = $pdo->prepare($queryChave);
    $stmtChave->bindParam(':empresaId', $usuario['empresa_id'], PDO::PARAM_INT);
    $stmtChave->execute();

    $chave = $stmtChave->fetch(PDO::FETCH_ASSOC);

    if (!$chave) {
        return ['status' => 'error', 'message' => 'Chave de API não encontrada para esta empresa.'];
    }

    // Verifica se o campo chave_id foi recuperado corretamente
    if (!isset($chave['chave_id'])) {
        return ['status' => 'error', 'message' => 'Campo chave_id não encontrado na tabela chaves_liberacao.'];
    }

    // Retorna os dados com a chave, a empresa e o usuário
    return [
        'status' => 'success',
        'data' => [
            'empresa_id' => $chave['empresa_id'],
            'empresa_nome' => $chave['empresa_nome'],
            'empresa_cnpj' => $chave['empresa_cnpj'],
            'chave_id' => $chave['chave_id'],
            'chave' => $chave['chave'],
            'expira_em' => $chave['expira_em'],
            'ativo' => $chave['ativo'],
            'plano' => $chave['plano_nome'],
            'usuario_id' => $usuario['usuario_id'],
            'usuario_nome' => $usuario['usuario_nome'],
            'plano_duracao' => $chave['duracao']
        ]
    ];
}

// Verifica se o ID do usuário foi fornecido e se é válido
if (!isset($_GET['usuarioId']) || !is_numeric($_GET['usuarioId'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID do usuário inválido ou não fornecido.']);
    exit;
}

$usuarioId = $_GET['usuarioId']; // ID do usuário fornecido no parâmetro GET
$response = autenticar($pdo, $usuarioId);

// Se a chave foi encontrada, fazemos as validações
if ($response['status'] === 'success') {
    // Verifica a validade da chave
    if (!$response['data']['ativo'] || strtotime($response['data']['expira_em']) < time()) {
        echo json_encode(['status' => 'error', 'message' => 'API key expirada ou desativada.']);
        exit;
    }
}

// Retorna a resposta final com a chave válida
echo json_encode($response);
?>
