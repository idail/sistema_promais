<?php
session_start();

// Verificar se a sessão já está iniciada
if (isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'success', 'message' => 'Usuário já está logado.']);
    exit;
}

// Configurações do banco de dados
// $host = 'localhost';
// $dbname = 'promais';
// $username = 'root';
// $password = '';

$host = 'mysql.idailneto.com.br';
$dbname = 'idailneto06';
$username = 'idailneto06';
$password = 'Sei20020615';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
    exit;
}

// Obter os dados JSON enviados
$data = json_decode(file_get_contents('php://input'), true);

// Adicionando log para verificar os dados recebidos
error_log("Dados recebidos: " . print_r($data, true));

// Verificar se os dados foram recebidos corretamente
$requiredFields = ['user_id', 'user_name', 'user_plan', 'user_expire', 'user_access_level'];
$missingFields = array_filter($requiredFields, fn($field) => empty($data[$field]));

if (!empty($missingFields)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Dados inválidos. Os seguintes campos estão ausentes: ' . implode(', ', $missingFields),
    ]);
    exit;
}

// Sanitizar e validar os dados
$userId = filter_var($data['user_id'], FILTER_VALIDATE_INT);
$userName = filter_var($data['user_name'], FILTER_SANITIZE_STRING);
$userPlan = filter_var($data['user_plan'], FILTER_SANITIZE_STRING);
$userExpire = DateTime::createFromFormat('Y-m-d H:i:s', $data['user_expire']);
$userAccessLevel = filter_var($data['user_access_level'], FILTER_SANITIZE_STRING);

if (!$userId || !$userExpire) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Dados inválidos. Certifique-se de que os valores fornecidos estão corretos.',
    ]);
    exit;
}

// Consulta para buscar os dados da empresa associada ao usuário
$query = "
    SELECT 
        e.id AS empresa_id, 
        e.nome AS empresa_nome, 
        e.cnpj AS empresa_cnpj, 
        e.endereco AS empresa_endereco, 
        e.telefone AS empresa_telefone, 
        e.email AS empresa_email
    FROM empresas e
    INNER JOIN usuarios u ON e.id = u.empresa_id
    WHERE u.id = :userId
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

// Adicionando log para verificar os dados da empresa
error_log("Dados da empresa: " . print_r($empresa, true));

// Verificar se a empresa foi encontrada
if (!$empresa) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Empresa associada ao usuário não encontrada.',
    ]);
    exit;
}

// Armazenar os dados na sessão no formato padrão
$_SESSION['user_id'] = $userId;
$_SESSION['user_name'] = $userName;
$_SESSION['user_plan'] = $userPlan;
$_SESSION['user_expire'] = $userExpire->format('Y-m-d H:i:s');
$_SESSION['user_access_level'] = $userAccessLevel;

// Armazenar os dados da empresa na sessão
$_SESSION['empresa_id'] = $empresa['empresa_id'];
$_SESSION['empresa_nome'] = $empresa['empresa_nome'];
$_SESSION['empresa_cnpj'] = $empresa['empresa_cnpj'];
$_SESSION['empresa_endereco'] = $empresa['empresa_endereco'];
$_SESSION['empresa_telefone'] = $empresa['empresa_telefone'];
$_SESSION['empresa_email'] = $empresa['empresa_email'];

// Registrar o log do login
registrarLog($userId, $userName, $empresa['empresa_nome']);


// Função para registrar o log de login
function registrarLog($userId, $userName, $empresaNome) {
    $logData = sprintf(
        "[%s] Login efetuado: UserID=%d, Nome=%s, Empresa=%s\n",
        date('d/m/Y H:i:s'), // Formato brasileiro para o log
        $userId,
        $userName,
        $empresaNome
    );

    file_put_contents('logins.log', $logData, FILE_APPEND);
}

// Registrar o log do login
registrarLog($userId, $userName, $empresa['empresa_nome']);

// Responder com sucesso
echo json_encode(['status' => 'success', 'message' => 'Login realizado com sucesso.']);
?>
