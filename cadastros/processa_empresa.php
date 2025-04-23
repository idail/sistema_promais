<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $recebe_processo_empresa = $_POST["processo_empresa"];
    if($recebe_processo_empresa === "inserir_empresa")
    {
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

        $recebe_nome_fantasia_empresa = $_POST["valor_nome_fantasia_empresa"];
        $recebe_cnpj_empresa = $_POST["valor_cnpj_empresa"];
        $recebe_endereco_empresa = $_POST["valor_endereco_empresa"];
        $recebe_telefone_empresa = $_POST["valor_telefone_empresa"];
        $recebe_email_empresa = $_POST["valor_email_empresa"];
        $recebe_chave_id_empresa = $_SESSION["user_plan"];

        $instrucao_cadastra_empresa = "insert into empresas(nome,cnpj,endereco,telefone,email,chave_id)values
        (:recebe_nome_empresa,:recebe_cnpj_empresa,:recebe_endereco_empresa,:recebe_telefone_empresa,
        :recebe_email_empresa,:recebe_chave_id_empresa)";
        $comando_cadastra_empresa = $pdo->prepare($instrucao_cadastra_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_nome_empresa",$recebe_nome_fantasia_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_cnpj_empresa",$recebe_cnpj_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_endereco_empresa",$recebe_endereco_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_telefone_empresa",$recebe_telefone_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_email_empresa",$recebe_email_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_chave_id_empresa",$recebe_chave_id_empresa);
        $resultado_cadastra_empresa = $comando_cadastra_empresa->execute();
        echo json_encode($resultado_cadastra_empresa);
    }
}
?>