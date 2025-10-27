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
    $recebe_processo_pix = $_POST["processo_pix"];

    if($recebe_processo_pix === "inserir_pix")
    {
        $instrucao_inserir_pix = "insert into pix(valor)values(:valor)";
        $comando_inserir_pix = $pdo->prepare($instrucao_inserir_pix);
        $comando_inserir_pix->bindValue(":valor",$_POST["recebe_valor_pix"]);
        $resultado_inserir_pix = $comando_inserir_pix->execute();
        echo json_encode($resultado_inserir_pix);
    }else if($recebe_processo_pix === "alterar_pix")
    {
        $instrucao_alterar_pix = "update pix set valor = :recebe_valor where id = :recebe_id_pix";
        $comando_alterar_pix = $pdo->prepare($instrucao_alterar_pix);
        $comando_alterar_pix->bindValue(":recebe_valor",$_POST["valor_pix"]);
        $comando_alterar_pix->bindValue(":recebe_id_pix",$_POST["valor_id_pix"]);
        $resultado_alterar_pix = $comando_alterar_pix->execute();
        echo json_encode($resultado_alterar_pix);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processa_pix = $_GET["processa_pix"];

    if($recebe_processa_pix === "buscar_pix")
    {
        $instrucao_buscar_pix = "select * from pix";
        $comando_buscar_pix = $pdo->prepare($instrucao_buscar_pix);
        $comando_buscar_pix->execute();
        $resultado_buscar_pix = $comando_buscar_pix->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_buscar_pix);
    }else if($recebe_processa_pix === "buscar_informacoes_pix_alteracao")
    {
        $instrucao_buscar_pix_alteracao = "select * from pix where id = :recebe_id_pix";
        $comando_buscar_pix_alteracao = $pdo->prepare($instrucao_buscar_pix_alteracao);
        $comando_buscar_pix_alteracao->bindValue(":recebe_id_pix",$_GET["valor_codigo_pix_alteracao"]);
        $comando_buscar_pix_alteracao->execute();
        $resultado_buscar_pix_alteracao = $comando_buscar_pix_alteracao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_buscar_pix_alteracao);
    }
}
?>