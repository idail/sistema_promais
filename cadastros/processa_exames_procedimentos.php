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
    $recebe_processo_exame_procedimento = $_POST["processo_exame_procedimento"];

    if($recebe_processo_exame_procedimento === "inserir_exame_procedimento")
    {
        $recebe_codigo_exame_procedimento = $_POST["valor_codigo_exame_procedimento"];
        $recebe_procedimento = $_POST["valor_procedimento"];
        $recebe_valor_exame_procedimento = $_POST["valor_exame_procedimento"];
        $recebe_empresa_id = $_SESSION["empresa_id"];

        $instrucao_cadastra_exame_procedimento = 
        "insert into exames_procedimentos(empresa_id,codigo,procedimento,valor)values(:recebe_empresa_id,
        :recebe_codigo,:recebe_procedimento,:recebe_valor)";
        $comando_cadastra_exame_procedimento = $pdo->prepare($instrucao_cadastra_exame_procedimento);
        $comando_cadastra_exame_procedimento->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_cadastra_exame_procedimento->bindValue(":recebe_codigo",$recebe_codigo_exame_procedimento);
        $comando_cadastra_exame_procedimento->bindValue(":recebe_procedimento",$recebe_procedimento);
        $comando_cadastra_exame_procedimento->bindValue(":recebe_valor",$recebe_valor_exame_procedimento);
        $comando_cadastra_exame_procedimento->execute();
        $recebe_ultimo_codigo_registrado_cadastro_exame_procedimento = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_registrado_cadastro_exame_procedimento);
    }else if($recebe_processo_exame_procedimento === "alterar_exame_procedimento")
    {
        $recebe_codigo_exame_procedimento = $_POST["valor_codigo_exame_procedimento"];
        $recebe_procedimento = $_POST["valor_procedimento"];
        $recebe_valor_exame_procedimento = $_POST["valor_exame_procedimento"];
        $recebe_id_exame_procedimento = $_POST["valor_id_exame_procedimento"];
        $recebe_empresa_id = $_SESSION["empresa_id"];

        $instrucao_altera_exame_procedimento = 
        "update exames_procedimentos set codigo = :recebe_codigo_alterar,
        procedimento = :recebe_procedimento_alterar, valor = :recebe_valor_alterar
        where id = :recebe_id_alterar and empresa_id = :recebe_empresa_id_alterar";
        $comando_altera_exame_procedimento = $pdo->prepare($instrucao_altera_exame_procedimento);
        $comando_altera_exame_procedimento->bindValue(":recebe_codigo_alterar",$recebe_codigo_exame_procedimento);
        $comando_altera_exame_procedimento->bindValue(":recebe_procedimento_alterar",$recebe_procedimento);
        $comando_altera_exame_procedimento->bindValue(":recebe_valor_alterar",$recebe_valor_exame_procedimento);
        $comando_altera_exame_procedimento->bindValue(":recebe_id_alterar",$recebe_id_exame_procedimento);
        $comando_altera_exame_procedimento->bindValue(":recebe_empresa_id_alterar",$recebe_empresa_id);
        $resultado_altera_exame_procedimento = $comando_altera_exame_procedimento->execute();
        echo json_encode($resultado_altera_exame_procedimento);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_exame_procedimento = $_GET["processo_exame_procedimento"];

    $recebe_empresa_id = $_SESSION["empresa_id"];

    if($recebe_processo_exame_procedimento === "buscar_exames_procedimentos")
    {
        $instrucao_busca_exames_procedimentos = 
        "select * from exames_procedimentos where empresa_id = :recebe_empresa_id";
        $comando_busca_exames_procedimentos = $pdo->prepare($instrucao_busca_exames_procedimentos);
        $comando_busca_exames_procedimentos->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_exames_procedimentos->execute();
        $resultado_busca_exames_procedimentos = $comando_busca_exames_procedimentos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_exames_procedimentos);
    }
}
?>