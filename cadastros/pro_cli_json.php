<?php
session_start();
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

        case 'editar':
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
    $recebe_ultimo_codigo_gerado_cadastramento_clinica = $pdo->lastInsertId();    

    if(!empty($_POST["codigos_medicos_associados"]))
    {
        $recebe_codigos_medicos_associados = json_decode($_POST["codigos_medicos_associados"], true);

        $valores_codigos_registrado_clinica = array();
        $valores_codigos_empresa_id = array();

        for ($indice = 0; $indice < count($recebe_codigos_medicos_associados); $indice++) 
        { 
            array_push($valores_codigos_registrado_clinica,$recebe_ultimo_codigo_gerado_cadastramento_clinica);
        }

        for ($empresa =0; $empresa < count($recebe_codigos_medicos_associados); $empresa++) 
        { 
            array_push($valores_codigos_empresa_id,$_SESSION["empresa_id"]);
        }

        $dataHoraAtual = date('Y-m-d H:i:s');

        for ($relacao = 0; $relacao < count($recebe_codigos_medicos_associados); $relacao++) 
        { 
            $instrucao_cadastra_relacao_medicos_clinicas = "insert into medicos_clinicas(empresa_id,medico_id,clinica_id,data_associacao,
            status)values(:recebe_empresa_id,:recebe_medico_id,:recebe_clinica_id,:recebe_data_associacao,:recebe_status)";
            $comando_cadastra_relacao_medicos_clinicas = $pdo->prepare($instrucao_cadastra_relacao_medicos_clinicas);
            $comando_cadastra_relacao_medicos_clinicas->bindValue(":recebe_empresa_id",$valores_codigos_empresa_id[$relacao]);
            $comando_cadastra_relacao_medicos_clinicas->bindValue(":recebe_medico_id",$recebe_codigos_medicos_associados[$relacao]);
            $comando_cadastra_relacao_medicos_clinicas->bindValue(":recebe_clinica_id",$valores_codigos_registrado_clinica[$relacao]);
            $comando_cadastra_relacao_medicos_clinicas->bindValue(":recebe_data_associacao",$dataHoraAtual);
            $comando_cadastra_relacao_medicos_clinicas->bindValue(":recebe_status","Ativo");
            $comando_cadastra_relacao_medicos_clinicas->execute();
            $recebe_ultimo_codigo_registrado_medicos_clinicas = $pdo->lastInsertId();
        }

        echo json_encode($recebe_ultimo_codigo_registrado_medicos_clinicas);
    }else{
        echo json_encode(['status' => 'success', 'message' => 'Empresa cadastrada com sucesso!']);
    }
}
// Função para atualizar uma empresa
function atualizarEmpresa($pdo) {
    // if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //     throw new Exception('Método não permitido.');
    // }

    // $data = [
    //     'id' => $_POST['empresa_id'],
    //     'created_at' => $_POST['created_at'],
    //     'cnpj' => $_POST['cnpj'],
    //     'nome_fantasia' => $_POST['nome_fantasia'],
    //     'razao_social' => $_POST['razao_social'],
    //     'endereco' => $_POST['endereco'],
    //     'numero' => $_POST['numero'],
    //     'complemento' => $_POST['complemento'],
    //     'bairro' => $_POST['bairro'],
    //     'cidade_id' => $_POST['cidade_id'],
    //     'cep' => $_POST['cep'],
    //     'email' => $_POST['email'],
    //     'telefone' => $_POST['telefone'],
    //     'status' => isset($_POST['status']) ? 1 : 0,
    //     'codigo_clinica' => $_POST["codigo_clinica_alteracao"]
    // ];

    $recebe_id_empresa_alterar = $_POST["empresa_id"];
    $recebe_data_cadastro_empresa_alterar = $_POST["created_at"];
    $recebe_nome_fantasia_clinica_alterar = $_POST["nome_fantasia"];
    $recebe_razao_social_clinica_alterar = $_POST["razao_social"];
    $recebe_cnpj_clinica_alterar = $_POST["cnpj"];
    $recebe_endereco_clinica_alterar = $_POST["endereco"];
    $recebe_numero_clinica_alterar = $_POST["numero"];
    $recebe_complemento_clinica_alterar = $_POST["complemento"];
    $recebe_bairro_clinica_alterar = $_POST["bairro"];
    $recebe_cidade_id_clinica_alterar = $_POST["cidade_id"];
    $recebe_cep_clinica_alterar = $_POST["cep"];
    $recebe_email_clinica_alterar = $_POST["email"];
    $recebe_telefone_clinica_alterar = $_POST["telefone"];
    $recebe_status_clinica_alterar = $_POST["status"];
    $recebe_codigo_clinica_alterar = $_POST["codigo_clinica_alteracao"];

    // $sql = "UPDATE empresas SET
    //     created_at = :created_at,
    //     cnpj = :cnpj,
    //     nome_fantasia = :nome_fantasia,
    //     razao_social = :razao_social,
    //     endereco = :endereco,
    //     numero = :numero,
    //     complemento = :complemento,
    //     bairro = :bairro,
    //     cidade_id = :cidade_id,
    //     cep = :cep,
    //     email = :email,
    //     telefone = :telefone,
    //     status = :status
    // WHERE id = :id";

    $sql_altera_clinica = 
    "update clinicas set empresa_id = :recebe_empresa_id,codigo = :recebe_codigo_clinica,nome_fantasia = :recebe_nome_fantasia_clinica,
    razao_social = :recebe_razao_social_clinica,cnpj = :recebe_cnpj_clinica,endereco = :recebe_endereco_clinica,numero = :recebe_numero_clinica,
    complemento = :recebe_complemento_clinica,bairro = :recebe_bairro_clinica,cidade_id = :recebe_cidade_id_clinica,cep = :recebe_cep_clinica,
    email = :recebe_email_clinica,telefone = :recebe_telefone_clinica,status = :recebe_status_clinica where id = :recebe_id_clinica";

    $comando_altera_clinica = $pdo->prepare($sql_altera_clinica);
    $comando_altera_clinica->bindValue(":recebe_empresa_id",$recebe_id_empresa_alterar);
    // $comando_altera_clinica->bindValue(":recebe_data_criacao_clinica",$recebe_data_cadastro_empresa_alterar);
    $comando_altera_clinica->bindValue(":recebe_codigo_clinica","CL001");
    $comando_altera_clinica->bindValue(":recebe_nome_fantasia_clinica",$recebe_nome_fantasia_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_razao_social_clinica",$recebe_razao_social_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_cnpj_clinica",$recebe_cnpj_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_endereco_clinica",$recebe_endereco_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_numero_clinica",$recebe_numero_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_complemento_clinica",$recebe_complemento_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_bairro_clinica",$recebe_bairro_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_cidade_id_clinica",$recebe_cidade_id_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_cep_clinica",$recebe_cep_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_email_clinica",$recebe_email_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_telefone_clinica",$recebe_telefone_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_status_clinica",$recebe_status_clinica_alterar);
    $comando_altera_clinica->bindValue(":recebe_id_clinica",$recebe_codigo_clinica_alterar);
    $resultado_altera_clinica = $comando_altera_clinica->execute();

    echo json_encode($resultado_altera_clinica);
    // echo json_encode(['status' => 'success', 'message' => 'Empresa atualizada com sucesso!']);
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