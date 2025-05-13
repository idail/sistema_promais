<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

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
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $recebe_processo_funcionario = $_POST["processo_funcionario"];

    if($recebe_processo_funcionario === "inserir_funcionario")
    {
        $recebe_nome_funcionario = $_POST["valor_nome_funcionario"];
        $recebe_cpf_funcionario = $_POST["valor_cpf_funcionario"];
        $recebe_cargo_funcionario = $_POST["valor_cargo_funcionario"];
        $recebe_cbo_funcionario = $_POST["valor_cbo_funcionario"];
        $recebe_nascimento_funcionario = $_POST["valor_nascimento_funcionario"];
        $recebe_idade_funcionario = $_POST["valor_idade_funcionario"];
        $recebe_endereco_funcionario = $_POST["valor_endereco_funcionario"];
        $recebe_numero_funcionario = $_POST["valor_numero_funcionario"];
        $recebe_complemento_funcionario = $_POST["valor_complemento_funcionario"];
        $recebe_bairro_funcionario = $_POST["valor_bairro_funcionario"];
        $recebe_cep_funcionario = $_POST["valor_cep_funcionario"];
        $recebe_id_cidade_funcionario = $_POST["valor_id_cidade_funcionario"];
        $recebe_email_funcionario = $_POST["valor_email_funcionario"];
        $recebe_senha_funcionario = $_POST["valor_senha_funcionario"];
        $recebe_nivel_acesso_funcionario = $_POST["valor_nivel_acesso_funcionario"];

        $instrucao_cadastra_funcionario = 
        "insert into funcionarios(nome,cpf,cargo,cbo,nascimento,idade,endereco,
        complemento,bairro,cep,id_cidade,email)values(:recebe_nome_funcionario,:recebe_cpf_funcionario,
        :recebe_cargo_funcionario,:recebe_cbo_funcionario,:recebe_nascimento_funcionario,:recebe_idade_funcionario,
        :recebe_endereco_funcionario,:recebe_complemento_funcionario,:recebe_bairro_funcionario,
        :recebe_cep_funcionario,:recebe_id_cidade_funcionario,:recebe_email_funcionario)";
        $comando_cadastra_funcionario = $pdo->prepare($instrucao_cadastra_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_nome_funcionario",$recebe_nome_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_cpf_funcionario",$recebe_cpf_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_cargo_funcionario",$recebe_cargo_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_cbo_funcionario",$recebe_cbo_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_nascimento_funcionario",$recebe_nascimento_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_idade_funcionario",$recebe_idade_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_endereco_funcionario",$recebe_endereco_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_complemento_funcionario",$recebe_complemento_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_bairro_funcionario",$recebe_bairro_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_cep_funcionario",$recebe_cep_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_id_cidade_funcionario",$recebe_id_cidade_funcionario);
        $comando_cadastra_funcionario->bindValue(":recebe_email_funcionario",$recebe_email_funcionario);
        $comando_cadastra_funcionario->execute();
        $resultado_cadastra_funcionario = $pdo->lastInsertId();
        echo json_encode($resultado_cadastra_funcionario);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_funcionario = $_GET["processo_funcionario"];

    if($recebe_processo_funcionario === "buscar_funcionarios")
    {
        $instrucao_busca_funcionarios = "select * from funcionarios";
        $comando_buca_funcionarios = $pdo->prepare($instrucao_busca_funcionarios);
        $comando_buca_funcionarios->execute();
        $resultado_busca_funcionarios = $comando_buca_funcionarios->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_funcionarios);
    }
}
?>