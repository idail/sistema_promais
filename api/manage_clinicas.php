<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/database.php';
require_once '../config/seguranca.php';

// Função para lidar com erros de forma consistente
function handleError($message, $status = 500, $data = []) {
    http_response_code($status);
    echo json_encode([
        'status' => 'error',
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, 
        DB_USER, 
        DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Determinar ação baseada no método HTTP
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            // Listar clínicas
            $query = "
                SELECT 
                    c.id, 
                    c.codigo, 
                    c.nome_fantasia, 
                    c.razao_social, 
                    c.cnpj, 
                    c.endereco, 
                    c.numero, 
                    c.complemento, 
                    c.bairro, 
                    c.cidade_id, 
                    c.cep, 
                    c.email, 
                    c.telefone, 
                    c.status,
                    cidade.nome as cidade_nome,
                    cidade.uf as cidade_uf
                FROM clinicas c
                LEFT JOIN cidades cidade ON c.cidade_id = cidade.id
                WHERE c.empresa_id = :empresa_id
            ";

            $stmt = $pdo->prepare($query);
            $stmt->execute([':empresa_id' => $_SESSION['empresa_id']]);
            $clinicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'status' => 'success',
                'data' => [
                    'clinicas' => $clinicas
                ]
            ]);
            break;

        case 'POST':
            // Adicionar nova clínica
            $data = json_decode(file_get_contents('php://input'), true);

            // Validações
            $requiredFields = ['nome_fantasia', 'razao_social', 'cnpj', 'cidade_id'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    handleError("Campo obrigatório '$field' não preenchido", 400);
                }
            }

            $query = "
                INSERT INTO clinicas 
                (empresa_id, codigo, nome_fantasia, razao_social, cnpj, 
                 endereco, numero, complemento, bairro, cidade_id, 
                 cep, email, telefone, status) 
                VALUES 
                (:empresa_id, :codigo, :nome_fantasia, :razao_social, :cnpj, 
                 :endereco, :numero, :complemento, :bairro, :cidade_id, 
                 :cep, :email, :telefone, :status)
            ";

            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':empresa_id' => $_SESSION['empresa_id'],
                ':codigo' => $data['codigo'] ?? null,
                ':nome_fantasia' => $data['nome_fantasia'],
                ':razao_social' => $data['razao_social'],
                ':cnpj' => $data['cnpj'],
                ':endereco' => $data['endereco'] ?? null,
                ':numero' => $data['numero'] ?? null,
                ':complemento' => $data['complemento'] ?? null,
                ':bairro' => $data['bairro'] ?? null,
                ':cidade_id' => $data['cidade_id'],
                ':cep' => $data['cep'] ?? null,
                ':email' => $data['email'] ?? null,
                ':telefone' => $data['telefone'] ?? null,
                ':status' => $data['status'] ?? 'Ativo'
            ]);

            $clinicaId = $pdo->lastInsertId();

            echo json_encode([
                'status' => 'success',
                'data' => [
                    'clinica_id' => $clinicaId
                ]
            ]);
            break;

        case 'PUT':
            // Atualizar clínica existente
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['id'])) {
                handleError("ID da clínica não fornecido", 400);
            }

            $query = "
                UPDATE clinicas 
                SET nome_fantasia = :nome_fantasia, 
                    razao_social = :razao_social, 
                    cnpj = :cnpj, 
                    endereco = :endereco, 
                    numero = :numero, 
                    complemento = :complemento, 
                    bairro = :bairro, 
                    cidade_id = :cidade_id, 
                    cep = :cep, 
                    email = :email, 
                    telefone = :telefone, 
                    status = :status
                WHERE id = :id AND empresa_id = :empresa_id
            ";

            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':empresa_id' => $_SESSION['empresa_id'],
                ':nome_fantasia' => $data['nome_fantasia'],
                ':razao_social' => $data['razao_social'],
                ':cnpj' => $data['cnpj'],
                ':endereco' => $data['endereco'] ?? null,
                ':numero' => $data['numero'] ?? null,
                ':complemento' => $data['complemento'] ?? null,
                ':bairro' => $data['bairro'] ?? null,
                ':cidade_id' => $data['cidade_id'],
                ':cep' => $data['cep'] ?? null,
                ':email' => $data['email'] ?? null,
                ':telefone' => $data['telefone'] ?? null,
                ':status' => $data['status'] ?? 'Ativo'
            ]);

            echo json_encode([
                'status' => 'success',
                'data' => [
                    'clinica_id' => $data['id']
                ]
            ]);
            break;

        case 'DELETE':
            // Excluir clínica
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['ids'])) {
                handleError("Nenhum ID de clínica fornecido", 400);
            }

            $placeholders = implode(',', array_fill(0, count($data['ids']), '?'));
            $query = "
                DELETE FROM clinicas 
                WHERE id IN ($placeholders) 
                AND empresa_id = ?
            ";

            $stmt = $pdo->prepare($query);
            $params = array_merge($data['ids'], [$_SESSION['empresa_id']]);
            $stmt->execute($params);

            echo json_encode([
                'status' => 'success',
                'message' => 'Clínicas excluídas com sucesso'
            ]);
            break;

        default:
            handleError("Método não permitido", 405);
    }
} catch (PDOException $e) {
    handleError("Erro interno: " . $e->getMessage(), 500);
}
?>
