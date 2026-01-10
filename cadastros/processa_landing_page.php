<?php
session_start();
header('Content-Type: application/json');

// Verifica autenticação (Segurança simples baseada na sessão existente)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Acesso não autorizado']);
    exit;
}

require_once '../config/database.php';

try {
    $pdo = getConnection();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'salvar_config') {
        
        $pdo->beginTransaction();

        $sections = ['hero', 'features', 'segments', 'contact', 'social', 'about', 'services_page', 'email_config'];
        
        foreach ($sections as $section) {
            if (isset($_POST[$section]) && is_array($_POST[$section])) {
                foreach ($_POST[$section] as $key => $value) {
                    // Prepara a query de atualização
                    // Tenta atualizar, se não afetar linhas (porque não existe), insere
                    // Mas como não temos unique constraint garantida no CREATE TABLE anterior (mea culpa),
                    // vamos fazer um SELECT antes para decidir ou UPDATE direto se garantirmos os dados iniciais.
                    // Vamos assumir UPDATE por segurança, os dados iniciais DEVEM ser rodados.
                    
                    $stmt = $pdo->prepare("UPDATE landing_page_config SET value_text = :value, updated_at = NOW() WHERE section = :section AND key_name = :key");
                    $stmt->execute([
                        ':value' => $value,
                        ':section' => $section,
                        ':key' => $key
                    ]);

                    // Se não atualizou nada, pode ser que não exista, então inserimos
                    if ($stmt->rowCount() == 0) {
                        // Verifica se realmente não existe ou se o valor era igual
                        $check = $pdo->prepare("SELECT id FROM landing_page_config WHERE section = :section AND key_name = :key");
                        $check->execute([':section' => $section, ':key' => $key]);
                        
                        if ($check->rowCount() == 0) {
                            $insert = $pdo->prepare("INSERT INTO landing_page_config (section, key_name, value_text) VALUES (:section, :key, :value)");
                            $insert->execute([
                                ':section' => $section,
                                ':key' => $key,
                                ':value' => $value
                            ]);
                        }
                    }
                }
            }
        }

        $pdo->commit();
        echo json_encode(['status' => 'success', 'message' => 'Configurações salvas com sucesso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ação inválida']);
    }

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Erro ao salvar config: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Erro interno do servidor: ' . $e->getMessage()]);
}
