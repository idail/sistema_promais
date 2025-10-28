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
    $recebe_processo_boleto = $_POST["processo_boleto"];

    if ($recebe_processo_boleto === "inserir_boleto") {
        $instrucao_inserir_boleto = "insert into boleto(valor)values(:valor)";
        $comando_inserir_boleto = $pdo->prepare($instrucao_inserir_boleto);
        $comando_inserir_boleto->bindValue(":valor", $_POST["recebe_valor_boleto"]);
        $resultado_inserir_boleto = $comando_inserir_boleto->execute();
        echo json_encode($resultado_inserir_boleto);
    }else if($recebe_processo_boleto === "alterar_boleto")
    {
        $instrucao_alterar_boleto = "update boleto set valor = :recebe_valor where id = :recebe_id_boleto";
        $comando_alterar_boleto = $pdo->prepare($instrucao_alterar_boleto);
        $comando_alterar_boleto->bindValue(":recebe_valor",$_POST["valor_boleto"]);
        $comando_alterar_boleto->bindValue(":recebe_id_boleto",$_POST["valor_id_boleto"]);
        $resultado_alterar_boleto = $comando_alterar_boleto->execute();
        echo json_encode($resultado_alterar_boleto);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $recebe_processo_boleto = $_GET["processo_boleto"];

    if ($recebe_processo_boleto === "busar_boleto") {
        $instrucao_buscar_boleto = "select * from boleto";
        $comando_buscar_boleto = $pdo->prepare($instrucao_buscar_boleto);
        $comando_buscar_boleto->execute();
        $resultado_buscar_boleto = $comando_buscar_boleto->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_buscar_boleto);
    } else if ($recebe_processo_boleto === "buscar_informacoes_boleto_alteracao") {
        $instrucao_buscar_boleto = "select * from boleto where id = :recebe_id_boleto";
        $comando_buscar_boleto = $pdo->prepare($instrucao_buscar_boleto);
        $comando_buscar_boleto->bindValue(":recebe_id_boleto", $_GET["valor_codigo_boleto_alteracao"]);
        $comando_buscar_boleto->execute();
        $resultado_buscar_boleto = $comando_buscar_boleto->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_buscar_boleto);
    }
}
?>