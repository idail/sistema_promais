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
    $recebe_processo_cartao = $_POST["processo_cartao"];

    if($recebe_processo_cartao === "inserir_cartao")
    {
        $instrucao_inserir_cartao = "insert into cartao(valor)values(:valor)";
        $comando_inserir_cartao = $pdo->prepare($instrucao_inserir_cartao);
        $comando_inserir_cartao->bindValue(":valor",$_POST["recebe_valor_cartao"]);
        $resultado_inserir_cartao = $comando_inserir_cartao->execute();
        echo json_encode($resultado_inserir_cartao);
    }else if($recebe_processo_cartao === "alterar_cartao")
    {
        $instrucao_alterar_cartao = "update cartao set valor = :recebe_valor where id = :recebe_id_cartao";
        $comando_alterar_cartao = $pdo->prepare($instrucao_alterar_cartao);
        $comando_alterar_cartao->bindValue(":recebe_valor",$_POST["valor_cartao"]);
        $comando_alterar_cartao->bindValue(":recebe_id_cartao",$_POST["valor_id_cartao"]);
        $resultado_alterar_cartao = $comando_alterar_cartao->execute();
        echo json_encode($resultado_alterar_cartao);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $recebe_processo_cartao = $_GET["processo_cartao"];

    if($recebe_processo_cartao === "buscar_cartao")
    {
        $instrucao_busca_cartao = "select * from cartao";
        $comando_busca_cartao = $pdo->prepare($instrucao_busca_cartao);
        $comando_busca_cartao->execute();
        $resultado_busca_cartao = $comando_busca_cartao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cartao);
    }else if($recebe_processo_cartao === "buscar_informacoes_cartao_alteracao")
    {
        $instrucao_busca_cartao = "select * from cartao where id = :recebe_id_cartao";
        $comando_busca_cartao = $pdo->prepare($instrucao_busca_cartao);
        $comando_busca_cartao->bindValue(":recebe_id_cartao",$_GET["valor_codigo_cartao_alteracao"]);
        $comando_busca_cartao->execute();
        $resultado_busca_cartao = $comando_busca_cartao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cartao);
    }
}
?>