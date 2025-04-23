<?php
// Iniciar sessão se não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar autenticação
function verificaLogin() {
    // Verificar se usuário está logado
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ../login.php');
        exit();
    }
}

// Verificar permissão de acesso
function verificaPermissao($permissao_requerida) {
    // Lógica de verificação de permissão
    if (!isset($_SESSION['permissoes']) || !in_array($permissao_requerida, $_SESSION['permissoes'])) {
        header('HTTP/1.1 403 Forbidden');
        echo json_encode([
            'status' => 'error',
            'message' => 'Acesso negado. Permissão insuficiente.'
        ]);
        exit();
    }
}

// Definir valores padrão de sessão para desenvolvimento
if (!isset($_SESSION['empresa_id'])) {
    $_SESSION['empresa_id'] = 1;  // ID de empresa padrão
}

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['usuario_id'] = 1;  // ID de usuário padrão
}

// Função para gerar token CSRF
function gerarTokenCSRF() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Função para validar token CSRF
function validarTokenCSRF($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Registrar log de atividades
function registrarLog($acao, $detalhes = []) {
    // Implementação de log de atividades
    // Pode ser expandido para salvar em banco de dados ou arquivo
    error_log(json_encode([
        'usuario_id' => $_SESSION['usuario_id'] ?? 'Não autenticado',
        'acao' => $acao,
        'detalhes' => $detalhes,
        'timestamp' => date('Y-m-d H:i:s')
    ]));
}
?>
