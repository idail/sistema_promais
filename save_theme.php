<?php
session_start();

// Recebe o tema via POST
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['theme'])) {
    // Lista de temas permitidos
    $allowedThemes = ['theme-green', 'theme-blue', 'theme-purple', 'theme-orange', 'theme-red'];
    
    // Valida o tema
    if (in_array($data['theme'], $allowedThemes)) {
        $_SESSION['theme'] = $data['theme'];
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tema inválido']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Tema não especificado']);
}
