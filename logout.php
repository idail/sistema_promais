<?php
session_start();

// Função para registrar o log de login e logout
function registrarLog($acao, $userId = null, $userName = null, $empresaNome = null) {
    $logFile = 'logins.log'; // Nome do arquivo de log
    $logData = sprintf(
        "[%s] Ação: %s, UsuarioID=%s, Nome=%s, Empresa=%s\n",
        date('d/m/Y H:i:s'), // Data e hora no formato brasileiro
        $acao,
        $userId ?? 'Desconhecido',
        $userName ?? 'Desconhecido',
        $empresaNome ?? 'Desconhecida'
    );

    // Adiciona a entrada de log ao arquivo
    file_put_contents($logFile, $logData, FILE_APPEND);
}

// Função para limpar registros de log com mais de 30 dias
function limparLogsAntigos($logFile) {
    $diasLimite = 30;
    $dataLimite = strtotime("-$diasLimite days");

    // Lê o conteúdo do arquivo de log
    $logs = file($logFile);

    // Filtra os logs que têm uma data maior que 30 dias
    $logsFiltrados = array_filter($logs, function($log) use ($dataLimite) {
        // Extrai a data do log (formato: [d/m/Y H:i:s])
        preg_match('/\[(\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2})\]/', $log, $matches);
        if (isset($matches[1])) {
            $dataLog = strtotime($matches[1]);
            return $dataLog >= $dataLimite; // Mantém logs dentro do limite de 30 dias
        }
        return false;
    });

    // Sobrescreve o arquivo com os logs filtrados
    file_put_contents($logFile, implode('', $logsFiltrados));
}

// Verifica se a sessão está ativa antes de proceder
if (isset($_SESSION['user_id'])) {
    // Captura os dados do usuário para o log
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    $empresaNome = $_SESSION['empresa_nome'];

    // Registra o log de logout
    registrarLog('Logout', $userId, $userName, $empresaNome);

    // Limpar logs antigos com mais de 30 dias
    limparLogsAntigos('logins.log');
}

// Destruir a sessão
session_unset();
session_destroy();

// Redireciona para a página de login
header("Location: login.php");
exit();
?>
