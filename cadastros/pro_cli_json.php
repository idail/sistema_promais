<?php
session_start();
// Ativar exibição de erros (apenas para desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir cabeçalho para JSON
header('Content-Type: application/json');


// conexao.php
// $host = 'localhost';
// $dbname = 'promais';
// $user = 'root';
// $password = ''; // Sem senha

$host = 'mysql.idailneto.com.br';
$dbname = 'idailneto06';
$username = 'idailneto06';
$password = 'Sei20020615';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '-03:00'"
        ]
    );      
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
    // $status = isset($_POST['status']) && $_POST['status'] == '1' ? 'Ativo' : 'Inativo';

    // Dados do formulário (incluindo empresa_id)
    // $data = [
    //     'empresa_id' => $_POST['empresa_id'], // Captura o valor do campo hidden
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
    //     'status' => $status, // Usa o valor mapeado
    // ];

    $recebe_clinica_id_cadastrar = $_POST['empresa_id'];
    $recebe_nome_fantasia_clinica_cadastrar = $_POST['nome_fantasia'];
    $recebe_clinica_data_criacao_cadastrar = $_POST['created_at'];
    $recebe_razao_social_clinica_cadastrar = $_POST['razao_social'];
    $recebe_cnpj_clinica_cadastrar = $_POST['cnpj'];
    $recebe_endereco_clinica_cadastrar = $_POST['endereco'];
    $recebe_numero_clinica_cadastrar = $_POST['numero'];
    $recebe_complemento_clinica_cadastrar = $_POST['complemento'];
    $recebe_bairro_clinica_cadastrar = $_POST["bairro"];
    $recebe_cidade_id_clinica_cadastrar = $_POST['cidade_id'];
    $recebe_cep_clinica_cadastrar = $_POST['cep'];
    $recebe_email_clinica_cadastrar = $_POST['email'];
    $recebe_telefone_clinica_cadastrar = $_POST['telefone'];

    $recebe_estado_id_clinica_cadastrar = $_POST["id_estado"];

    if (isset($_POST['status']) && $_POST['status'] === "on") {
        $status = "Ativo";
    } else {
        $status = "Inativo";
    }

    // Query SQL (incluindo empresa_id)
    $sql = "INSERT INTO clinicas (
        empresa_id, cnpj, nome_fantasia, razao_social, endereco, numero, complemento, bairro, cidade_id,id_estado, cep, email, telefone, status, created_at,updated_at
    ) VALUES (
        :empresa_id, :cnpj, :nome_fantasia, :razao_social, :endereco, :numero, :complemento, :bairro, :cidade_id, :id_estado, :cep, :email, :telefone, :status,
        :created_at,:updated_at
    )";

    $comando_cadastra_clinica = $pdo->prepare($sql);
    $comando_cadastra_clinica->bindValue(":empresa_id",$recebe_clinica_id_cadastrar);
    // $comando_cadastra_clinica->bindValue(":created_at",$recebe_clinica_data_criacao_cadastrar);
    $comando_cadastra_clinica->bindValue(":nome_fantasia",$recebe_nome_fantasia_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":razao_social",$recebe_razao_social_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":cnpj",$recebe_cnpj_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":endereco",$recebe_endereco_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":numero",$recebe_numero_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":complemento",$recebe_complemento_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":bairro",$recebe_bairro_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":cidade_id",$recebe_cidade_id_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":id_estado",$recebe_estado_id_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":cep",$recebe_cep_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":email",$recebe_email_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":telefone",$recebe_telefone_clinica_cadastrar);
    $comando_cadastra_clinica->bindValue(":status",$status);
    $comando_cadastra_clinica->bindValue(":created_at",$recebe_clinica_data_criacao_cadastrar);
    $comando_cadastra_clinica->bindValue(":updated_at",$recebe_clinica_data_criacao_cadastrar);
    $comando_cadastra_clinica->execute();
    $recebe_ultimo_codigo_gerado_cadastramento_clinica = $pdo->lastInsertId();
    
    $recebe_codigos_medicos_associados = json_decode($_POST["codigos_medicos_associados"], true);

    if(count($recebe_codigos_medicos_associados) > 0)
    {
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

    // if(!empty($_POST["codigos_medicos_associados"]))
    // {
    //     $recebe_codigos_medicos_associados = json_decode($_POST["codigos_medicos_associados"], true);

        
    // }else{
        
    // }
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

    if (isset($_POST['status']) && $_POST['status'] === "on") {
        $status = "Ativo";
    } else {
        $status = "Inativo";
    }

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
    $comando_altera_clinica->bindValue(":recebe_status_clinica",$status);
    $comando_altera_clinica->bindValue(":recebe_id_clinica",$recebe_codigo_clinica_alterar);
    $resultado_altera_clinica = $comando_altera_clinica->execute();

    $recebe_codigos_medicos_associados = json_decode($_POST["codigos_medicos_associados"], true);

    if(count($recebe_codigos_medicos_associados) > 0)
    {
            $valores_codigos_registrado_clinica_alterar = array();
            $valores_codigos_empresa_id_alterar = array();

            for ($indice = 0; $indice < count($recebe_codigos_medicos_associados); $indice++) 
            { 
                array_push($valores_codigos_registrado_clinica_alterar,$recebe_codigo_clinica_alterar);
            }

            for ($empresa =0; $empresa < count($recebe_codigos_medicos_associados); $empresa++) 
            { 
                array_push($valores_codigos_empresa_id_alterar,$_SESSION["empresa_id"]);
            }

            $data_hora_atual_alterar = date('Y-m-d H:i:s');

            for ($relacao = 0; $relacao < count($recebe_codigos_medicos_associados); $relacao++) 
            { 
                $instrucao_cadastra_relacao_medicos_clinicas_na_alteracao = "insert into medicos_clinicas(empresa_id,medico_id,clinica_id,data_associacao,
                status)values(:recebe_empresa_id,:recebe_medico_id,:recebe_clinica_id,:recebe_data_associacao,:recebe_status)";
                $comando_cadastra_relacao_medicos_clinicas_na_alteracao = $pdo->prepare($instrucao_cadastra_relacao_medicos_clinicas_na_alteracao);
                $comando_cadastra_relacao_medicos_clinicas_na_alteracao->bindValue(":recebe_empresa_id",$valores_codigos_empresa_id_alterar[$relacao]);
                $comando_cadastra_relacao_medicos_clinicas_na_alteracao->bindValue(":recebe_medico_id",$recebe_codigos_medicos_associados[$relacao]);
                $comando_cadastra_relacao_medicos_clinicas_na_alteracao->bindValue(":recebe_clinica_id",$valores_codigos_registrado_clinica_alterar[$relacao]);
                $comando_cadastra_relacao_medicos_clinicas_na_alteracao->bindValue(":recebe_data_associacao",$data_hora_atual_alterar);
                $comando_cadastra_relacao_medicos_clinicas_na_alteracao->bindValue(":recebe_status","Ativo");
                $comando_cadastra_relacao_medicos_clinicas_na_alteracao->execute();
                $recebe_ultimo_codigo_registrado_medicos_clinicas_na_alteracao = $pdo->lastInsertId();
            }
            echo json_encode($recebe_ultimo_codigo_registrado_medicos_clinicas_na_alteracao);
    }else{
        echo json_encode($resultado_altera_clinica);
    }


    // if(isset($_POST["codigos_medicos_associados"]) && !empty($_POST["codigos_medicos_associados"]))
    // {
    //     $recebe_codigos_medicos_associados = json_decode($_POST["codigos_medicos_associados"], true);

    //     if (is_array($recebe_codigos_medicos_associados) && !empty($recebe_codigos_medicos_associados)) {
    //         echo json_encode("entrou aqui");
            
    //     }
    //     echo json_encode("entrou aqui 2");
    // }else{
    //     echo json_encode("entrou aqui por causa que so alterou a cinica sem alterar medicos");
    // }
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