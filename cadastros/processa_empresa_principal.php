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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recebe_processo_empresa = $_POST["processo_empresa"];

    if ($recebe_processo_empresa === "inserir_empresas_principal") {
        $recebe_nome_fantasia_empresa = !empty($_POST["valor_nome_fantasia_empresa"]) ? $_POST["valor_nome_fantasia_empresa"] : null;
        $recebe_cnpj_empresa = !empty($_POST["valor_cnpj_empresa"]) ? $_POST["valor_cnpj_empresa"] : null;
        $recebe_endereco_empresa = !empty($_POST["valor_endereco_empresa"]) ? $_POST["valor_endereco_empresa"] : null;
        $recebe_telefone_empresa = !empty($_POST["valor_telefone_empresa"]) ? $_POST["valor_telefone_empresa"] : null;
        $recebe_email_empresa = !empty($_POST["valor_email_empresa"]) ? $_POST["valor_email_empresa"] : null;
        $recebe_id_cidade_empresa = !empty($_POST["valor_id_cidade"]) ? $_POST["valor_id_cidade"] : null;
        $recebe_id_estado_empresa = !empty($_POST["valor_id_estado"]) ? $_POST["valor_id_estado"] : null;
        $recebe_razao_social_empresa = !empty($_POST["valor_razao_social_empresa"]) ? $_POST["valor_razao_social_empresa"] : null;
        $recebe_bairro_empresa = !empty($_POST["valor_bairro_empresa"]) ? $_POST["valor_bairro_empresa"] : null;
        $recebe_cep_empresa = !empty($_POST["valor_cep_empresa"]) ? $_POST["valor_cep_empresa"] : null;
        $recebe_complemento_empresa = !empty($_POST["valor_complemento_empresa"]) ? $_POST["valor_complemento_empresa"] : null;
        $recebe_chave_id_empresa = $_SESSION["id_chave_liberacao"]; // Sempre presente pela sessão

        $instrucao_cadastra_empresa_principal = "INSERT INTO empresas
        (nome,cnpj,endereco,id_cidade,id_estado,telefone,email,chave_id,razao_social,
        bairro,cep,complemento)
        VALUES
        (:recebe_nome_empresa,:recebe_cnpj_empresa,:recebe_endereco_empresa,
        :recebe_id_cidade_empresa,:recebe_id_estado_empresa,:recebe_telefone_empresa,
        :recebe_email_empresa,:recebe_chave_id_empresa,:recebe_razao_social,:recebe_bairro,:recebe_cep,:recebe_complemento)";

        $comando_cadastra_empresa_principal = $pdo->prepare($instrucao_cadastra_empresa_principal);

        // Bind dos valores
        $comando_cadastra_empresa_principal->bindValue(":recebe_nome_empresa", $recebe_nome_fantasia_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_cnpj_empresa", $recebe_cnpj_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_endereco_empresa", $recebe_endereco_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_id_cidade_empresa", $recebe_id_cidade_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_id_estado_empresa", $recebe_id_estado_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_telefone_empresa", $recebe_telefone_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_email_empresa", $recebe_email_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_chave_id_empresa", $recebe_chave_id_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_razao_social", $recebe_razao_social_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_bairro", $recebe_bairro_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_cep", $recebe_cep_empresa);
        $comando_cadastra_empresa_principal->bindValue(":recebe_complemento", $recebe_complemento_empresa);
        $comando_cadastra_empresa_principal->execute();
        $recebe_ultimo_codigo_gerado_cadastramento_empresa_principal = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_gerado_cadastramento_empresa_principal);
    } else if ($recebe_processo_empresa === "alterar_empresas_principal") {
        $recebe_nome_fantasia_empresa = !empty($_POST["valor_nome_fantasia_empresa"]) ? $_POST["valor_nome_fantasia_empresa"] : null;
        $recebe_cnpj_empresa = !empty($_POST["valor_cnpj_empresa"]) ? $_POST["valor_cnpj_empresa"] : null;
        $recebe_endereco_empresa = !empty($_POST["valor_endereco_empresa"]) ? $_POST["valor_endereco_empresa"] : null;
        $recebe_telefone_empresa = !empty($_POST["valor_telefone_empresa"]) ? $_POST["valor_telefone_empresa"] : null;
        $recebe_email_empresa = !empty($_POST["valor_email_empresa"]) ? $_POST["valor_email_empresa"] : null;
        $recebe_id_cidade_empresa = !empty($_POST["valor_id_cidade"]) ? $_POST["valor_id_cidade"] : null;
        $recebe_id_estado_empresa = !empty($_POST["valor_id_estado"]) ? $_POST["valor_id_estado"] : null;
        $recebe_razao_social_empresa = !empty($_POST["valor_razao_social_empresa"]) ? $_POST["valor_razao_social_empresa"] : null;
        $recebe_bairro_empresa = !empty($_POST["valor_bairro_empresa"]) ? $_POST["valor_bairro_empresa"] : null;
        $recebe_cep_empresa = !empty($_POST["valor_cep_empresa"]) ? $_POST["valor_cep_empresa"] : null;
        $recebe_complemento_empresa = !empty($_POST["valor_complemento_empresa"]) ? $_POST["valor_complemento_empresa"] : null;
        $recebe_id_empresa_principal_alterar = !empty($_POST["valor_id_empresa"]) ? $_POST["valor_id_empresa"] : null;

        $instrucao_altera_empresa_principal = "update empresas set nome = :recebe_nome,endereco = :recebe_endereco,
        id_cidade = :recebe_id_ciadde,id_estado = :recebe_id_estado,telefone = :recebe_telefone,email = :recebe_email,razao_social = :recebe_razao_social,
        bairro = :recebe_bairro,cep = :recebe_cep,complemento = :recebe_complemento where id = :recebe_id_empresa_principal";
        $comando_altera_empresa_principal = $pdo->prepare($instrucao_altera_empresa_principal);
        $comando_altera_empresa_principal->bindValue(":recebe_nome",$recebe_nome_fantasia_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_endereco",$recebe_endereco_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_id_ciadde",$recebe_id_cidade_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_id_estado",$recebe_id_estado_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_telefone",$recebe_telefone_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_email",$recebe_email_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_razao_social",$recebe_razao_social_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_bairro",$recebe_bairro_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_cep",$recebe_cep_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_complemento",$recebe_complemento_empresa);
        $comando_altera_empresa_principal->bindValue(":recebe_id_empresa_principal",$recebe_id_empresa_principal_alterar);
        $resultado_altera_empresa_principal = $comando_altera_empresa_principal->execute();
        echo json_encode($resultado_altera_empresa_principal);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $recebe_processo_empresa = $_GET["processo_empresa"];

    if ($recebe_processo_empresa === "buscar_empresas_principal") {
        $instrucao_busca_empresas_principal = "select * from empresas";
        $comando_busca_empresas_principal = $pdo->prepare($instrucao_busca_empresas_principal);
        $comando_busca_empresas_principal->execute();
        $resultado_busca_empresas_principal = $comando_busca_empresas_principal->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_empresas_principal);
    }else if($recebe_processo_empresa === "buscar_informacoes_empresas_principal_alteracao")
    {
        $recebe_codigo_empresa_principal = $_GET["valor_codigo_empresa_principal_alteracao"];
        $instrucao_busca_informacoes_empresas_principal = "select * from empresas where id = :recebe_id_empresa_principal";
        $comando_busca_informacoes_empresas_principal = $pdo->prepare($instrucao_busca_informacoes_empresas_principal);
        $comando_busca_informacoes_empresas_principal->bindValue(":recebe_id_empresa_principal",$recebe_codigo_empresa_principal);
        $comando_busca_informacoes_empresas_principal->execute();
        $resultado_busca_informacoes_empresas_principal = $comando_busca_informacoes_empresas_principal->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_informacoes_empresas_principal);
    }
}
