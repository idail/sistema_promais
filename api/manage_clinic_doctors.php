<?php
// Definir cabeçalhos para resposta JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Iniciar sessão e configurações
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
session_start();

// Incluir configurações do banco de dados
require_once '../config/database.php';

// Verificar sessão e permissões
if (!isset($_SESSION['user_id']) || !isset($_SESSION['empresa_id'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Sessão inválida ou expirada'
    ]);
    exit;
}

try {
    $pdo = getConnection();
    $pdo->beginTransaction();

    // Determinar ação baseada no método HTTP
    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($method) {
        case 'POST':
            // Associar médicos a uma clínica
            if (!isset($input['clinica_id']) || empty($input['medicos'])) {
                throw new Exception("Dados inválidos para associação");
            }

            $clinicaId = $input['clinica_id'];
            $medicos = $input['medicos'];
            $empresaId = $_SESSION['empresa_id'];

            $associados = [];
            $jaAssociados = [];
            $naoAssociados = [];

            // Preparar statement para verificação e inserção
            $checkQuery = "
                SELECT id FROM medicos_clinicas 
                WHERE medico_id = :medico_id 
                AND clinica_id = :clinica_id 
                AND status = 'Ativo'
            ";
            $checkStmt = $pdo->prepare($checkQuery);

            $insertQuery = "
                INSERT INTO medicos_clinicas 
                (medico_id, clinica_id, empresa_id, status, data_associacao) 
                VALUES 
                (:medico_id, :clinica_id, :empresa_id, 'Ativo', NOW())
                ON DUPLICATE KEY UPDATE 
                status = 'Ativo', 
                data_associacao = NOW()
            ";
            $insertStmt = $pdo->prepare($insertQuery);

            foreach ($medicos as $medicoId) {
                // Verificar se já está associado
                $checkStmt->bindParam(':medico_id', $medicoId, PDO::PARAM_INT);
                $checkStmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
                $checkStmt->execute();

                if ($checkStmt->rowCount() > 0) {
                    $jaAssociados[] = $medicoId;
                    continue;
                }

                // Tentar associar
                try {
                    $insertStmt->bindParam(':medico_id', $medicoId, PDO::PARAM_INT);
                    $insertStmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
                    $insertStmt->bindParam(':empresa_id', $empresaId, PDO::PARAM_INT);
                    $insertStmt->execute();
                    $associados[] = $medicoId;
                } catch (PDOException $e) {
                    $naoAssociados[] = $medicoId;
                }
            }

            $pdo->commit();

            echo json_encode([
                'status' => 'success',
                'message' => 'Associações processadas',
                'data' => [
                    'associados' => $associados,
                    'ja_associados' => $jaAssociados,
                    'nao_associados' => $naoAssociados
                ]
            ]);
            break;

        case 'GET':
            // Listar médicos de uma clínica
            $clinicaId = $_GET['clinica_id'] ?? null;
            
            // Validar parâmetros de entrada
            if (!$clinicaId) {
                error_log("ERRO: ID da clínica não fornecido na requisição GET");
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'ID da clínica não fornecido',
                    'data' => []
                ]);
                exit;
            }

            // Log de depuração
            error_log("Buscando médicos para clinicaId: {$clinicaId}, empresaId: {$_SESSION['empresa_id']}");

            // Consulta detalhada para recuperar médicos associados
            $query = "
                SELECT 
                    m.id, 
                    m.nome, 
                    m.crm, 
                    m.especialidade,
                    m.email,
                    m.telefone,
                    mc.status as associacao_status,
                    mc.data_associacao,
                    mc.observacoes
                FROM medicos m
                JOIN medicos_clinicas mc ON m.id = mc.medico_id
                WHERE 
                    mc.clinica_id = :clinica_id 
                    AND mc.empresa_id = :empresa_id
                    AND mc.status = 'Ativo'
                ORDER BY 
                    m.nome
            ";

            try {
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
                $stmt->bindParam(':empresa_id', $_SESSION['empresa_id'], PDO::PARAM_INT);
                $stmt->execute();

                $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Log de depuração para médicos encontrados
                error_log("Médicos encontrados para clinicaId {$clinicaId}: " . json_encode($medicos));

                // Verificar se há médicos associados
                if (empty($medicos)) {
                    error_log("Nenhum médico associado à clinicaId: {$clinicaId}");
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Nenhum médico associado à clínica',
                        'data' => [
                            'clinica_id' => $clinicaId,
                            'medicos' => []
                        ]
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'success',
                        'data' => [
                            'clinica_id' => $clinicaId,
                            'medicos' => $medicos
                        ]
                    ]);
                }
            } catch (PDOException $e) {
                // Log do erro para debug
                error_log("ERRO ao buscar médicos associados: " . $e->getMessage());
                
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erro interno ao recuperar médicos associados',
                    'error_details' => $e->getMessage()
                ]);
            }
            break;

        case 'DELETE':
            // Desassociar médicos de uma clínica
            $clinicaId = $input['clinica_id'] ?? null;
            $medicos = $input['medicos'] ?? [];

            if (!$clinicaId || empty($medicos)) {
                throw new Exception("Dados inválidos para desassociação");
            }

            $query = "
                UPDATE medicos_clinicas 
                SET 
                    status = 'Inativo', 
                    data_desassociacao = NOW() 
                WHERE 
                    clinica_id = :clinica_id 
                    AND medico_id IN (:medicos)
                    AND empresa_id = :empresa_id
            ";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':clinica_id', $clinicaId, PDO::PARAM_INT);
            $stmt->bindParam(':empresa_id', $_SESSION['empresa_id'], PDO::PARAM_INT);
            
            // Converter array de médicos para string de IDs
            $medicosIds = implode(',', $medicos);
            $stmt->bindParam(':medicos', $medicosIds);

            $stmt->execute();

            echo json_encode([
                'status' => 'success',
                'message' => 'Médicos desassociados com sucesso',
                'data' => [
                    'clinica_id' => $clinicaId,
                    'medicos_desassociados' => $medicos
                ]
            ]);
            break;

        default:
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'message' => 'Método não permitido'
            ]);
    }

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Log do erro para debug
    error_log("Erro ao gerenciar associações de médicos: " . $e->getMessage());
    
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
