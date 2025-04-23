<?php
session_start();

// Função para redirecionar de forma segura
function safeRedirect($url) {
    if (!headers_sent()) {
        header("Location: $url");
        exit();
    }
    echo "<script>window.location.href='$url';</script>";
    exit();
}

// Verificar se todas as variáveis de sessão necessárias existem
if (!isset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_plan'], $_SESSION['user_expire'])) {
    session_unset();
    session_destroy();
    safeRedirect("login.php");
}

// Verificar se a sessão expirou
if (isset($_SESSION['user_expire'])) {
    $expireTime = strtotime($_SESSION['user_expire']);
    if ($expireTime < time()) {
        session_unset();
        session_destroy();
        safeRedirect("login.php");
    }
}

?>
