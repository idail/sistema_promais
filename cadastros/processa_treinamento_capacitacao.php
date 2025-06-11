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
    $recebe_processo_treinamento_capacitacao = $_POST["processo_treinamento_capacitacao"];

    $recebe_empresa_id = $_SESSION["empresa_id"];

    if($recebe_processo_treinamento_capacitacao === "inserir_treinamento_capacitacao")
    {
        $recebe_codigo_treinamento_capacitacao = $_POST["valor_codigo_treinamento_capacitacao"];
        $recebe_nome_treinamento_capacitacao = $_POST["valor_nome_treinamento_capacitacao"];
        $recebe_valor_treinamento_capacitacao = $_POST["valor_treinamento_capacitacao"];

        $instrucao_cadsatra_treinamento_capacitacao = 
        "insert into treinamento_capacitacao(codigo_treinamento_capacitacao,nome,valor,empresa_id)values(:recebe_codigo_treinamento_capacitacao,
        :recebe_nome_treinamento_capacitacao,:recebe_valor_treinamento_capacitacao,:recebe_empresa_id)";
        $comando_cadastra_treinamento_capacitacao = $pdo->prepare($instrucao_cadsatra_treinamento_capacitacao);
        $comando_cadastra_treinamento_capacitacao->bindValue(":recebe_codigo_treinamento_capacitacao",$recebe_codigo_treinamento_capacitacao);
        $comando_cadastra_treinamento_capacitacao->bindValue(":recebe_nome_treinamento_capacitacao",$recebe_nome_treinamento_capacitacao);
        $comando_cadastra_treinamento_capacitacao->bindValue(":recebe_valor_treinamento_capacitacao",$recebe_valor_treinamento_capacitacao);
        $comando_cadastra_treinamento_capacitacao->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_cadastra_treinamento_capacitacao->execute();
        $recebe_ultimo_codigo_registrado_treinamento_capacitacao = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_registrado_treinamento_capacitacao);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_treinamento_capacitacao = $_GET["processo_treinamento_capacitacao"];
    $recebe_empresa_id = $_SESSION["empresa_id"];

    if($recebe_processo_treinamento_capacitacao === "busca_treinamento_capacitacao")
    {
        $instrucao_busca_treinamento_capacitacao = 
        "select * from treinamento_capacitacao where empresa_id = :recebe_empresa_id";
        $comando_busca_treinamento_capacitacao = $pdo->prepare($instrucao_busca_treinamento_capacitacao);
        $comando_busca_treinamento_capacitacao->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_treinamento_capacitacao->execute();
        $resultado_busca_treinamento_capacitacao = $comando_busca_treinamento_capacitacao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_treinamento_capacitacao);
    }
}