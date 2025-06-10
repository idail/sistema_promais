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
    $recebe_processo_aptidao_extra = $_POST["processo_aptidao_extra"];

    if($recebe_processo_aptidao_extra === "inserir_aptidao_extra")
    {
        $recebe_codigo_aptidao_extra = $_POST["valor_codigo_aptidao_extra"];
        $recebe_nome_aptidao_extra = $_POST["valor_nome_aptidao_extra"];

        $recebe_empresa_id = $_SESSION["empresa_id"];

        $instrucao_cadastra_aptidao_extra = 
        "insert into aptidao_extra(codigo_aptidao,nome,empresa_id)values
        (:recebe_codigo_aptidao,:recebe_nome_aptidao,:recebe_empresa_id)";
        $comando_cadastra_aptidao_extra = $pdo->prepare($instrucao_cadastra_aptidao_extra);
        $comando_cadastra_aptidao_extra->bindValue(":recebe_codigo_aptidao",$recebe_codigo_aptidao_extra);
        $comando_cadastra_aptidao_extra->bindValue(":recebe_nome_aptidao",$recebe_nome_aptidao_extra);
        $comando_cadastra_aptidao_extra->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_cadastra_aptidao_extra->execute();
        $recebe_ultimo_codigo_registrado_aptidao_extra = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_registrado_aptidao_extra);
    }
}else{
    $recebe_processo_aptidao_extra = $_GET["processo_aptidao_extra"];
    $recebe_empresa_id = $_SESSION["empresa_id"];
    if($recebe_processo_aptidao_extra === "busca_aptidao_extra")
    {
        $instrucao_busca_aptidao_extra = 
        "select * from aptidao_extra where empresa_id = :recebe_empresa_id";
        $comando_busca_aptidao_extra = $pdo->prepare($instrucao_busca_aptidao_extra);
        $comando_busca_aptidao_extra->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_aptidao_extra->execute();
        $resultado_busca_aptidao_extra = $comando_busca_aptidao_extra->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_aptidao_extra);
    }else if($recebe_processo_aptidao_extra === "buscar_informacoes_rapidas_aptidao_extra")
    {
        $recebe_codigo_aptidao_extra = $_GET["valor_codigo_aptidao_extra_informacoes_rapidas"];

        $instrucao_busca_aptidao_extra_informacoes_rapidas = 
        "select * from aptidao_extra where id = :recebe_id_aptidao_extra_informacoes_rapidas and empresa_id = :recebe_empresa_id_aptidao_informacoes_rapidas";
        $comando_busca_aptidao_extra_informacoes_rapidas = $pdo->prepare($instrucao_busca_aptidao_extra_informacoes_rapidas);
        $comando_busca_aptidao_extra_informacoes_rapidas->bindValue(":recebe_id_aptidao_extra_informacoes_rapidas",$recebe_codigo_aptidao_extra);
        $comando_busca_aptidao_extra_informacoes_rapidas->bindValue(":recebe_empresa_id_aptidao_informacoes_rapidas",$recebe_empresa_id);
        $comando_busca_aptidao_extra_informacoes_rapidas->execute();
        $resultado_busca_aptidao_extra_informacoes_rapidas = $comando_busca_aptidao_extra_informacoes_rapidas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_aptidao_extra_informacoes_rapidas);
    }
}
?>