<?php
// Ativar exibição de erros (apenas para desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir cabeçalho para JSON
header('Content-Type: application/json');


// conexao.php
$host = 'localhost';
$dbname = 'promais';
$user = 'root';
$password = ''; // Sem senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}


// Recuperar parâmetros da URL
$acao = $_GET['acao'] ?? null;
$id = $_GET['id'] ?? null;

// Verificar ação
try {
    switch ($acao) {
        case 'cadastrar':
            cadastrarEmpresa($pdo);
            break;

        case 'atualizar':
            atualizarEmpresa($pdo);
            break;

        case 'apagar':
            if (!$id) {
                throw new Exception('ID não fornecido.');
            }
            apagarEmpresa($pdo, $id);
            break;

        default:
            throw new Exception('Ação não reconhecida.');
    }
} catch (Exception $e) {
    // Retornar erro em JSON
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

function cadastrarEmpresa($pdo) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido.');
    }

    // Mapeia o valor do checkbox para 'Ativo' ou 'Inativo'
    $status = isset($_POST['status']) && $_POST['status'] == '1' ? 'Ativo' : 'Inativo';

    // Dados do formulário (incluindo empresa_id)
    $data = [
        'empresa_id' => $_POST['empresa_id'], // Captura o valor do campo hidden
        'created_at' => $_POST['created_at'],
        'cnpj' => $_POST['cnpj'],
        'nome_fantasia' => $_POST['nome_fantasia'],
        'razao_social' => $_POST['razao_social'],
        'endereco' => $_POST['endereco'],
        'numero' => $_POST['numero'],
        'complemento' => $_POST['complemento'],
        'bairro' => $_POST['bairro'],
        'cidade_id' => $_POST['cidade_id'],
        'cep' => $_POST['cep'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'status' => $status, // Usa o valor mapeado
    ];

    // Query SQL (incluindo empresa_id)
    $sql = "INSERT INTO clinicas (
        empresa_id, created_at, cnpj, nome_fantasia, razao_social, endereco, numero, complemento, bairro, cidade_id, cep, email, telefone, status
    ) VALUES (
        :empresa_id, :created_at, :cnpj, :nome_fantasia, :razao_social, :endereco, :numero, :complemento, :bairro, :cidade_id, :cep, :email, :telefone, :status
    )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    echo json_encode(['status' => 'success', 'message' => 'Empresa cadastrada com sucesso!']);
}
// Função para atualizar uma empresa
function atualizarEmpresa($pdo) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido.');
    }

    $data = [
        'id' => $_POST['empresa_id'],
        'created_at' => $_POST['created_at'],
        'cnpj' => $_POST['cnpj'],
        'nome_fantasia' => $_POST['nome_fantasia'],
        'razao_social' => $_POST['razao_social'],
        'endereco' => $_POST['endereco'],
        'numero' => $_POST['numero'],
        'complemento' => $_POST['complemento'],
        'bairro' => $_POST['bairro'],
        'cidade_id' => $_POST['cidade_id'],
        'cep' => $_POST['cep'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'status' => isset($_POST['status']) ? 1 : 0,
    ];

    $sql = "UPDATE empresas SET
        created_at = :created_at,
        cnpj = :cnpj,
        nome_fantasia = :nome_fantasia,
        razao_social = :razao_social,
        endereco = :endereco,
        numero = :numero,
        complemento = :complemento,
        bairro = :bairro,
        cidade_id = :cidade_id,
        cep = :cep,
        email = :email,
        telefone = :telefone,
        status = :status
    WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    echo json_encode(['status' => 'success', 'message' => 'Empresa atualizada com sucesso!']);
}

// Função para apagar uma empresa
function apagarEmpresa($pdo, $id) {
    $sql = "DELETE FROM clinicas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    // Redireciona para a página de clínicas após a exclusão
    header("Location: ../painel.php?pg=clinicas");
    exit(); // Garante que o script pare de executar após o redirecionamento
}

?>