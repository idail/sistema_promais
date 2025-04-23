<?php
// Função para registrar o log de login e logout
function registrarLog($acao, $userId = null, $userName = null, $empresaNome = null) {
    $logFile = 'logins.log'; // Nome do arquivo de log
    $logData = sprintf(
        "[%s] Ação: %s, UsuarioID=%s, Nome=%s, Empresa=%s\n",
        date('d/m/Y H:i:s'),
        $acao,
        $userId ?? 'Desconhecido',
        $userName ?? 'Desconhecido',
        $empresaNome ?? 'Desconhecida'
    );

    file_put_contents($logFile, $logData, FILE_APPEND); // Adiciona o log ao arquivo
}
?>
