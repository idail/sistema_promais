<?php
header('Content-Type: application/json; charset=utf-8');
require_once('../config/database.php'); // Adjust path if necessary. valid based on file structure.

$pdo = getConnection();
$term = isset($_GET['term']) ? trim($_GET['term']) : '';

if (strlen($term) < 2) {
    echo json_encode([]);
    exit;
}

$results = [];

// Helper function to safely add results
function addResult(&$array, $category, $label, $url, $subtext = '') {
    if (!isset($array[$category])) {
        $array[$category] = [];
    }
    // Limit to 5 results per category to avoid clutter
    if (count($array[$category]) < 5) {
        $array[$category][] = [
            'label' => $label,
            'url' => $url,
            'subtext' => $subtext
        ];
    }
}

try {
    // 1. EMPRESAS
    $stmt = $pdo->prepare("SELECT id, nome, cnpj FROM empresas_novas WHERE nome LIKE :term1 OR cnpj LIKE :term2 OR razao_social LIKE :term3 OR email LIKE :term4 OR endereco LIKE :term5 LIMIT 5");
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->bindValue(':term3', "%$term%");
    $stmt->bindValue(':term4', "%$term%");
    $stmt->bindValue(':term5', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Empresas'] = [];
        foreach ($rows as $row) {
            $results['Empresas'][] = [
                'label' => $row['nome'],
                'subtext' => "CNPJ: " . $row['cnpj'],
                'url' => "?pg=grava_empresa&acao=editar&id=" . $row['id'],
                'actions' => [
                    ['type' => 'edit', 'url' => "?pg=grava_empresa&acao=editar&id=" . $row['id'], 'icon' => 'fa-edit', 'title' => 'Editar']
                ]
            ];
        }
    }

    // 2. KITS (ASOs)
    $stmt = $pdo->prepare("SELECT id, tipo_exame, status FROM kits WHERE id = :id OR tipo_exame LIKE :term1 OR status LIKE :term2 LIMIT 5");
    $stmt->bindValue(':id', $term);
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Kits'] = [];
        foreach ($rows as $row) {
            $results['Kits'][] = [
                'label' => "Kit #" . $row['id'] . " - " . ($row['tipo_exame'] ?? 'Sem tipo'),
                'subtext' => "Status: " . $row['status'],
                'url' => "?pg=geracao_kit&acao=editar&id=" . $row['id'],
                'actions' => [
                    ['type' => 'view', 'url' => "?pg=geracao_kit&acao=editar&id=" . $row['id'], 'icon' => 'fa-eye', 'title' => 'Visualizar'],
                    ['type' => 'duplicate', 'url' => '#', 'onclick' => "duplicarKit(" . $row['id'] . ")", 'icon' => 'fa-copy', 'title' => 'Duplicar']
                ]
            ];
        }
    }

    // 3. CLÍNICAS (Using pro_cli logic)
    $stmt = $pdo->prepare("SELECT id, nome_fantasia, cnpj, razao_social FROM clinicas WHERE nome_fantasia LIKE :term1 OR cnpj LIKE :term2 OR email LIKE :term3 OR endereco LIKE :term4 LIMIT 5");
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->bindValue(':term3', "%$term%");
    $stmt->bindValue(':term4', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Clínicas'] = [];
        foreach ($rows as $row) {
            $results['Clínicas'][] = [
                'label' => $row['nome_fantasia'],
                'subtext' => "Razão Social: " . $row['razao_social'],
                'url' => "?pg=pro_cli&acao=editar&id=" . $row['id'],
                'actions' => [
                    ['type' => 'edit', 'url' => "?pg=pro_cli&acao=editar&id=" . $row['id'], 'icon' => 'fa-edit', 'title' => 'Editar']
                ]
            ];
        }
    }

    // 4. PESSOAS (Funcionários)
    try {
        $stmt = $pdo->prepare("SELECT id, nome, cpf FROM pessoas WHERE nome LIKE :term1 OR cpf LIKE :term2 LIMIT 5");
        $stmt->bindValue(':term1', "%$term%");
        $stmt->bindValue(':term2', "%$term%");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            $results['Pessoas'] = [];
            foreach ($rows as $row) {
                // Assuming view/edit logic
                $results['Pessoas'][] = [
                    'label' => $row['nome'],
                    'subtext' => "CPF: " . $row['cpf'],
                    'url' => "?pg=grava_pessoa&acao=editar&id=" . $row['id'],
                    'actions' => [
                        ['type' => 'edit', 'url' => "?pg=grava_pessoa&acao=editar&id=" . $row['id'], 'icon' => 'fa-edit', 'title' => 'Editar']
                    ]
                ];
            }
        }
    } catch (Exception $e) { /* Ignore if table doesn't exist */ }

    // 5. MÉDICOS
    $stmt = $pdo->prepare("SELECT id, nome, crm, especialidade FROM medicos WHERE nome LIKE :term1 OR crm LIKE :term2 OR especialidade LIKE :term3 LIMIT 5");
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->bindValue(':term3', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Médicos'] = [];
        foreach ($rows as $row) {
            $subtext = $row['crm'] . ($row['especialidade'] ? ' - ' . $row['especialidade'] : '');
            $results['Médicos'][] = [
                'label' => $row['nome'],
                'subtext' => $subtext,
                'url' => "?pg=grava_medico&acao=editar&id=" . $row['id'],
                'actions' => [
                    ['type' => 'edit', 'url' => "?pg=grava_medico&acao=editar&id=" . $row['id'], 'icon' => 'fa-edit', 'title' => 'Editar']
                ]
            ];
        }
    }
    
    // 6. RISCOS
    $stmt = $pdo->prepare("SELECT id, descricao_grupo_risco, codigo FROM grupo_riscos WHERE descricao_grupo_risco LIKE :term1 OR codigo LIKE :term2 LIMIT 5");
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Riscos'] = [];
        foreach ($rows as $row) {
            $results['Riscos'][] = [
                'label' => $row['descricao_grupo_risco'],
                'subtext' => "Código: " . $row['codigo'],
                'url' => "?pg=grava_risco&id=" . $row['id'],
                'actions' => [
                    ['type' => 'edit', 'url' => "?pg=grava_risco&id=" . $row['id'], 'icon' => 'fa-edit', 'title' => 'Editar']
                ]
            ];
        }
    }

    // 7. EXAMES/PROCEDIMENTOS
    $stmt = $pdo->prepare("SELECT id, procedimento, codigo FROM exames_procedimentos WHERE procedimento LIKE :term1 OR codigo LIKE :term2 LIMIT 5");
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Exames'] = [];
        foreach ($rows as $row) {
            $results['Exames'][] = [
                'label' => $row['procedimento'],
                'subtext' => "Código: " . $row['codigo'],
                'url' => "?pg=grava_exames_procedimentos&acao=editar&id=" . $row['id'],
                'actions' => [
                    ['type' => 'edit', 'url' => "?pg=grava_exames_procedimentos&acao=editar&id=" . $row['id'], 'icon' => 'fa-edit', 'title' => 'Editar']
                ]
            ];
        }
    }


    // 8. APTIDÃO EXTRA
    $stmt = $pdo->prepare("SELECT id, nome, codigo_aptidao FROM aptidao_extra WHERE nome LIKE :term1 OR codigo_aptidao LIKE :term2 LIMIT 5");
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Aptidão Extra'] = [];
        foreach ($rows as $row) {
            $results['Aptidão Extra'][] = [
                'label' => $row['nome'],
                'subtext' => "Código: " . $row['codigo_aptidao'],
                'url' => "?pg=grava_aptidao_extra&acao=editar&id=" . $row['id'],
                'actions' => [
                    ['type' => 'edit', 'url' => "?pg=grava_aptidao_extra&acao=editar&id=" . $row['id'], 'icon' => 'fa-edit', 'title' => 'Editar']
                ]
            ];
        }
    }

    // 9. TREINAMENTO / CAPACITAÇÃO
    $stmt = $pdo->prepare("SELECT id, nome, codigo_treinamento_capacitacao FROM treinamento_capacitacao WHERE nome LIKE :term1 OR codigo_treinamento_capacitacao LIKE :term2 LIMIT 5");
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Treinamentos'] = [];
        foreach ($rows as $row) {
            $results['Treinamentos'][] = [
                'label' => $row['nome'],
                'subtext' => "Código: " . $row['codigo_treinamento_capacitacao'],
                'url' => "?pg=grava_treinamento_capacitacao&acao=editar&id=" . $row['id'],
                'actions' => [
                    ['type' => 'edit', 'url' => "?pg=grava_treinamento_capacitacao&acao=editar&id=" . $row['id'], 'icon' => 'fa-edit', 'title' => 'Editar']
                ]
            ];
        }
    }

    // 10. CONTA BANCÁRIA
    $stmt = $pdo->prepare("SELECT id_conta_bancaria, agencia, conta, valor_pix FROM conta_bancaria WHERE agencia LIKE :term1 OR conta LIKE :term2 OR valor_pix LIKE :term3 LIMIT 5");
    $stmt->bindValue(':term1', "%$term%");
    $stmt->bindValue(':term2', "%$term%");
    $stmt->bindValue(':term3', "%$term%");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        $results['Contas Bancárias'] = [];
        foreach ($rows as $row) {
            $label = $row['agencia'] ? "Ag: " . $row['agencia'] . " Cc: " . $row['conta'] : "PIX: " . $row['valor_pix'];
            $results['Contas Bancárias'][] = [
                'label' => $label,
                'subtext' => "ID: " . $row['id_conta_bancaria'],
                'url' => "?pg=grava_conta_bancaria&acao=editar&id=" . $row['id_conta_bancaria'],
                'actions' => [
                    ['type' => 'edit', 'url' => "?pg=grava_conta_bancaria&acao=editar&id=" . $row['id_conta_bancaria'], 'icon' => 'fa-edit', 'title' => 'Editar']
                ]
            ];
        }
    }

} catch (PDOException $e) {
    // Return error in JSON for debugging
    $results['Error'] = [
        ['label' => 'Erro no Banco de Dados', 'url' => '#', 'subtext' => $e->getMessage()]
    ];
    error_log("Search Error: " . $e->getMessage());
} catch (Exception $e) {
    $results['Error'] = [
        ['label' => 'Erro Geral', 'url' => '#', 'subtext' => $e->getMessage()]
    ];
    error_log("General Error: " . $e->getMessage());
}

// Force UTF-8 on all strings before encoding to avoid JSON_ERROR_UTF8
array_walk_recursive($results, function(&$item, $key) {
    if (is_string($item)) {
        $item = mb_convert_encoding($item, 'UTF-8', 'auto');
    }
});

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['Error' => [['label' => 'JSON Error', 'url' => '#', 'subtext' => json_last_error_msg()]]]);
}
?>
