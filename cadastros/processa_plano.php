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
    $recebe_processo_plano = $_POST["processo_plano"];

    if($recebe_processo_plano === "inserir_plano")
    {
        $instrucao_inserir_plano = "insert into planos(nome,descricao,preco,duracao)values(:nome,:descricao,:preco,:duracao)";
        $comando_inserir_plano = $pdo->prepare($instrucao_inserir_plano);
        $comando_inserir_plano->bindValue(":nome",$_POST["recebe_valor_nome_plano"]);
        $comando_inserir_plano->bindValue(":descricao",$_POST["recebe_valor_descricao_plano"]);
        $comando_inserir_plano->bindValue(":preco",$_POST["recebe_valor_preco_plano"]);
        $comando_inserir_plano->bindValue(":duracao",$_POST["recebe_valor_duracao_plano"]);
        $resultado_inserir_plano = $comando_inserir_plano->execute();
        echo json_encode($resultado_inserir_plano);
    }else if($recebe_processo_plano === "alterar_plano")
    {
        $instrucao_alterar_plano = "update planos set nome = :recebe_nome,descricao = :recebe_descricao,preco = :recebe_preco,duracao = :recebe_duracao where id = :recebe_id_plano";
        $comando_alterar_plano = $pdo->prepare($instrucao_alterar_plano);
        $comando_alterar_plano->bindValue(":recebe_nome",$_POST["recebe_valor_nome_plano"]);
        $comando_alterar_plano->bindValue(":recebe_descricao",$_POST["recebe_valor_descricao_plano"]);
        $comando_alterar_plano->bindValue(":recebe_preco",$_POST["recebe_valor_preco_plano"]);
        $comando_alterar_plano->bindValue(":recebe_duracao",$_POST["recebe_valor_duracao_plano"]);
        $comando_alterar_plano->bindValue(":recebe_id_plano",$_POST["recebe_valor_id_plano"]);
        $resultado_alterar_plano = $comando_alterar_plano->execute();
        echo json_encode($resultado_alterar_plano);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $recebe_processo_plano = $_GET["processo_plano"];

    if ($recebe_processo_plano === "buscar_planos") {
        $instrucao_busca_planos = "select * from planos";
        $comando_busca_planos = $pdo->prepare($instrucao_busca_planos);
        $comando_busca_planos->execute();
        $resultado_busca_planos = $comando_busca_planos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_planos);
    }else if($recebe_processo_plano === "buscar_informacoes_plano_alteracao")
    {
        $instrucao_busca_plano = "select * from planos where id = :recebe_id_plano";
        $comando_busca_plano = $pdo->prepare($instrucao_busca_plano);
        $comando_busca_plano->bindValue(":recebe_id_plano",$_GET["valor_codigo_plano_alteracao"]);
        $comando_busca_plano->execute();
        $resultado_busca_plano = $comando_busca_plano->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_plano);
    }
}
?>