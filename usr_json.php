<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

// Verificar se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido']);
    exit;
}

// Obter dados do POST
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Dados incompletos']);
    exit;
}

// Configurações do banco de dados
$host = 'mysql.idailneto.com.br';
$dbname = 'idailneto06';
$username = 'idailneto06';
$password = 'Sei20020615';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8", // charset adicionado aqui
        $username,
        $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") // comando adicional
    );
    // Configurar o modo de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obter usuário, empresa e chave de liberação
    $comando = $pdo->prepare("
        SELECT u.*, 
               e.id as empresa_id,
               e.nome as empresa_nome, 
               e.cnpj as empresa_cnpj, 
               e.telefone as empresa_telefone, 
               e.email as empresa_email,
               c.expira_em,
               c.id as id_chave_liberacao,
               p.nome as plano_nome, 
               p.duracao as plano_duracao
        FROM usuarios u
        LEFT JOIN empresas e ON u.empresa_id = e.id
        LEFT JOIN chaves_liberacao c ON u.id = c.usuario_id AND c.ativo = 1
        LEFT JOIN planos p ON c.plano_id = p.id
        WHERE u.email = :email
        ORDER BY c.expira_em DESC
        LIMIT 1
    ");
    
    $comando->bindValue(":email",$data["email"]);
    $comando->execute();
    // $stmt->execute([$data['email']]);
    $usuario = $comando->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado']);
        exit;
    }

    // Verificação de senha com múltiplos métodos
    if (password_verify($data['password'], $usuario['senha_hash'])) {
        $senhaCorreta = true;
    } 
    else if (md5($data['password']) === $usuario['senha_hash']) {
        $senhaCorreta = true;
    } 
    else if ($data['password'] === $usuario['senha_hash']) {
        $senhaCorreta = true;
    } else {
        $senhaCorreta = false;
    }

    if (!$senhaCorreta) {
        echo json_encode(['status' => 'error', 'message' => 'Senha incorreta']);
        exit;
    }

    // Verificar se tem chave de liberação ativa
    if (!isset($usuario['expira_em'])) {
        echo json_encode(['status' => 'error', 'message' => 'Usuário sem chave de liberação ativa']);
        exit;
    }

    // Verificar se a chave já expirou
    if (strtotime($usuario['expira_em']) < time()) {
        echo json_encode(['status' => 'error', 'message' => 'Sua chave de liberação expirou']);
        exit;
    }

    // Preparar dados para auth.php
    $authData = [
        'user_id' => $usuario['id'],
        'user_name' => $usuario['nome'],
        'user_plan' => $usuario['plano_nome'],
        'user_expire' => $usuario['expira_em'],
        'user_access_level' => $usuario['nivel_acesso'],
        'user_email' => $usuario["email"],
        'criacao_user' => $usuario["criado_em"],
    ];

    session_start();
    // Iniciar sessão e armazenar dados
    foreach ($authData as $key => $value) {
        $_SESSION[$key] = $value;
    }

    if(!empty($usuario["plano_nome"]))
    {
        $_SESSION['id_chave_liberacao'] = $usuario['id_chave_liberacao'];
    }

    // Armazenar dados da empresa
    if (!empty($usuario['empresa_nome'])) {
        $_SESSION['empresa_id'] = $usuario['empresa_id'];
        $_SESSION['empresa_nome'] = $usuario['empresa_nome'];
        $_SESSION['empresa_cnpj'] = $usuario['empresa_cnpj'];
        $_SESSION['empresa_telefone'] = $usuario['empresa_telefone'];
        $_SESSION['empresa_email'] = $usuario['empresa_email'];
    }

    // Calcular dias restantes
    $diasRestantes = ceil((strtotime($usuario['expira_em']) - time()) / (60 * 60 * 24));

    // $resultado =  json_encode([
    //     "status" => "success",
    //     "message" => "Login realizado com sucesso",
    //     "data" => array_merge($authData)
    //     // 'data' => array_merge($authData, [
    //     //     'dias_restantes' => $diasRestantes,
    //     //     'plano_duracao' => $usuario['plano_duracao'],
    //     //     'empresa' => [
    //     //         'nome' => $usuario['empresa_nome'],
    //     //         'cnpj' => $usuario['empresa_cnpj'],
    //     //         'telefone' => $usuario['empresa_telefone'],
    //     //         'email' => $usuario['empresa_email']
    //     //     ]
    //     // ])
    // ]);

    // Monta o array final
    $finalArray = [
        "status" => "success",
        "message" => "Login realizado com sucesso",
        "data" => array_merge($authData, [
            "dias_restantes" => $diasRestantes,
            "plano_duracao" => $usuario["plano_duracao"],
            "empresa" => [
                "nome" => $usuario["empresa_nome"],
                "cnpj" => $usuario["empresa_cnpj"],
                "telefone" => $usuario["empresa_telefone"],
                "email" => $usuario["empresa_email"]
            ]
        ])
    ];

    // Corrige encoding de **todo o array final**
    array_walk_recursive($finalArray, function (&$item) {
        if (is_string($item)) {
            $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
        }
    });

    $resultado = json_encode($finalArray);

    if ($resultado === false) {
        echo "Erro no json_encode: " . json_last_error_msg();
        exit;
    }

    echo $resultado;

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro no servidor: ' . $e->getMessage()]);
}
?>
