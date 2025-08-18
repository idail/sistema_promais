<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");
header('Content-Type: application/json; charset=utf-8');

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
    $recebe_processo_produto = $_POST["processo_produto"];

    if($recebe_processo_produto === "inserir_produto")
    {
        $recebe_nome_produto = $_POST["valor_descricao_produto"];
        $recebe_valor_produto = $_POST["valor_produto"];

        $instrucao_cadastra_produto = "insert into produto(nome,valor,id_kit)values(:recebe_nome_produto,:recebe_valor_produto,:recebe_id_kit)";
        $comando_cadastra_produto = $pdo->prepare($instrucao_cadastra_produto);
        $comando_cadastra_produto->bindValue(":recebe_nome_produto",$recebe_nome_produto);
        $comando_cadastra_produto->bindValue(":recebe_valor_produto",$recebe_valor_produto);
        $comando_cadastra_produto->bindValue(":recebe_id_kit",$_SESSION["codigo_kit"]);
        $comando_cadastra_produto->execute();
        $recebe_ultimo_codigo_cadastrado_produto = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_cadastrado_produto);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_produto = $_GET["processo_produto"];

    if($recebe_processo_produto === "buscar_produto_nome")
    {
        $recebe_nome_produto = isset($_GET["valor_descricao_produto"]) ? $_GET["valor_descricao_produto"] : '';
        if ($recebe_nome_produto === '' || strlen($recebe_nome_produto) < 1) {
            echo json_encode([]);
            exit;
        }

        $instrucao_busca_produto = "select * from produto where nome like :recebe_nome_produto";
        $comando_busca_produto = $pdo->prepare($instrucao_busca_produto);
        $comando_busca_produto->bindValue(":recebe_nome_produto","%$recebe_nome_produto%");
        $comando_busca_produto->execute();
        $resultado_busca_produto = $comando_busca_produto->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_produto);
    }
}
?>