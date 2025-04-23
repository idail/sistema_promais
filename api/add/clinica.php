<?php
// Definir cabeçalhos para resposta JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Iniciar sessão e configurações
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
session_start();

// Incluir configurações do banco de dados
require_once '../../config/database.php';

// Função de validação e sanitização
function validateClinicData($data) {
    $errors = [];

    // Validações
    if (empty($data['codigo'])) {
        $errors[] = 'Código da clínica é obrigatório';
    }

    if (empty($data['nome_fantasia'])) {
        $errors[] = 'Nome fantasia é obrigatório';
    }

    if (empty($data['razao_social'])) {
        $errors[] = 'Razão social é obrigatória';
    }

    if (empty($data['cnpj']) || !preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/', $data['cnpj'])) {
        $errors[] = 'CNPJ inválido';
    }

    return $errors;
}

// Verificar sessão e permissões
if (!isset($_SESSION['user_id']) || $_SESSION['user_access_level'] !== 'admin') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Acesso não autorizado'
    ]);
    exit;
}

// Receber dados do POST
$input = json_decode(file_get_contents('php://input'), true);

// Validar dados recebidos
$validationErrors = validateClinicData($input);
if (!empty($validationErrors)) {
    echo json_encode([
        'status' => 'error',
        'errors' => $validationErrors
    ]);
    exit;
}

try {
    $pdo = getConnection();
    $pdo->beginTransaction();

    // Preparar query de inserção
    $query = "
        INSERT INTO clinicas (
            empresa_id, codigo, nome_fantasia, razao_social, cnpj, 
            endereco, numero, complemento, bairro, cidade_id, 
            cep, email, telefone, status
        ) VALUES (
            :empresa_id, :codigo, :nome_fantasia, :razao_social, :cnpj,
            :endereco, :numero, :complemento, :bairro, :cidade_id,
            :cep, :email, :telefone, :status
        )
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':empresa_id' => $_SESSION['empresa_id'],
        ':codigo' => $input['codigo'],
        ':nome_fantasia' => $input['nome_fantasia'],
        ':razao_social' => $input['razao_social'],
        ':cnpj' => $input['cnpj'],
        ':endereco' => $input['endereco'] ?? '',
        ':numero' => $input['numero'] ?? '',
        ':complemento' => $input['complemento'] ?? '',
        ':bairro' => $input['bairro'] ?? '',
        ':cidade_id' => $input['cidade_id'] ?? null,
        ':cep' => $input['cep'] ?? '',
        ':email' => $input['email'] ?? '',
        ':telefone' => $input['telefone'] ?? '',
        ':status' => $input['status'] ?? 'Ativo'
    ]);

    $clinica_id = $pdo->lastInsertId();

    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Clínica adicionada com sucesso',
        'clinica_id' => $clinica_id
    ]);

} catch (PDOException $e) {
    $pdo->rollBack();
    
    // Log do erro para debug
    error_log("Erro ao adicionar clínica: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao adicionar clínica: ' . $e->getMessage()
    ]);
}
?>
