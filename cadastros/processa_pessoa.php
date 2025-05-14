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
    $recebe_processo_pessoa = $_POST["processo_pessoa"];

    if($recebe_processo_pessoa === "inserir_pessoa")
    {
        $recebe_nome_pessoa = $_POST["valor_nome_pessoa"];
        $recebe_cpf_pessoa = $_POST["valor_cpf_pessoa"];
        $recebe_cargo_pessoa = $_POST["valor_cargo_pessoa"];
        $recebe_cbo_pessoa = $_POST["valor_cbo_pessoa"];
        $recebe_nascimento_pessoa = $_POST["valor_nascimento_pessoa"];
        $recebe_idade_pessoa = $_POST["valor_idade_pessoa"];
        $recebe_endereco_pessoa = $_POST["valor_endereco_pessoa"];
        $recebe_numero_pessoa = $_POST["valor_numero_pessoa"];
        $recebe_complemento_pessoa = $_POST["valor_complemento_pessoa"];
        $recebe_bairro_pessoa = $_POST["valor_bairro_pessoa"];
        $recebe_cep_pessoa = $_POST["valor_cep_pessoa"];
        $recebe_id_cidade_pessoa = $_POST["valor_id_cidade_pessoa"];
        $recebe_email_pessoa = $_POST["valor_email_pessoa"];
        $recebe_senha_pessoa = $_POST["valor_senha_pessoa"];
        $recebe_nivel_acesso_pessoa = $_POST["valor_nivel_acesso_pessoa"];
        $recebe_data_cadastro_pessoa = $_POST["valor_data_cadastro_pessoa"];
        $recebe_empresa_id_cadastro_pessoa = $_POST["valor_empresa_id"];

        $instrucao_cadastra_pessoa = 
        "insert into pessoas(nome,cpf,cargo,cbo,nascimento,idade,endereco,
        complemento,bairro,cep,id_cidade,email,created_at,updated_at)values(:recebe_nome_pessoa,:recebe_cpf_pessoa,
        :recebe_cargo_pessoa,:recebe_cbo_pessoa,:recebe_nascimento_pessoa,:recebe_idade_pessoa,
        :recebe_endereco_pessoa,:recebe_complemento_pessoa,:recebe_bairro_pessoa,
        :recebe_cep_pessoa,:recebe_id_cidade_pessoa,:recebe_email_pessoa,:recebe_created_at,:recebe_updated_at)";
        $comando_cadastra_pessoa = $pdo->prepare($instrucao_cadastra_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_nome_pessoa",$recebe_nome_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_cpf_pessoa",$recebe_cpf_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_cargo_pessoa",$recebe_cargo_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_cbo_pessoa",$recebe_cbo_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_nascimento_pessoa",$recebe_nascimento_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_idade_pessoa",$recebe_idade_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_endereco_pessoa",$recebe_endereco_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_complemento_pessoa",$recebe_complemento_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_bairro_pessoa",$recebe_bairro_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_cep_pessoa",$recebe_cep_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_id_cidade_pessoa",$recebe_id_cidade_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_email_pessoa",$recebe_email_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_created_at",$recebe_data_cadastro_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_updated_at",$recebe_data_cadastro_pessoa);
        $comando_cadastra_pessoa->execute();
        $resultado_cadastra_pessoa = $pdo->lastInsertId();

        if(!empty($resultado_cadastra_pessoa))
        {
            $recebe_senha_criptografada = md5($recebe_senha_pessoa);
            $instrucao_cadastra_usuario = 
            "insert into usuarios(nome,email,senha_hash,nivel_acesso,criado_em,empresa_id)values
            (:nome,:email,:senha_hash,:nivel_acesso,:criado_em,:empresa_id)";
            $comando_cadastra_usuario = $pdo->prepare($instrucao_cadastra_usuario);
            $comando_cadastra_usuario->bindValue(":nome",$recebe_nome_pessoa);
            $comando_cadastra_usuario->bindValue(":email",$recebe_email_pessoa);
            $comando_cadastra_usuario->bindValue(":senha_hash",$recebe_senha_criptografada);
            $comando_cadastra_usuario->bindValue(":nivel_acesso",$recebe_nivel_acesso_pessoa);
            $comando_cadastra_usuario->bindValue(":criado_em",$recebe_data_cadastro_pessoa);
            $comando_cadastra_usuario->bindValue(":empresa_id",$recebe_empresa_id_cadastro_pessoa);
            $comando_cadastra_usuario->execute();
            $resultado_cadastra_usuario = $pdo->lastInsertId();
            echo json_encode($resultado_cadastra_usuario);
        }
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_pessoa = $_GET["processo_pessoa"];

    if($recebe_processo_pessoa === "buscar_pessoas")
    {
        $instrucao_busca_pessoas = "select * from pessoas";
        $comando_buca_pessoas = $pdo->prepare($instrucao_busca_pessoas);
        $comando_buca_pessoas->execute();
        $resultado_busca_pessoas = $comando_buca_pessoas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoas);
    }
}
?>