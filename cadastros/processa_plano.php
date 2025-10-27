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
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $recebe_processo_plano = $_GET["processa_plano"];

    if ($recebe_processo_plano === "buscar_planos") {
        $instrucao_busca_planos = "select * from planos";
        $comando_busca_planos = $pdo->prepare($instrucao_busca_planos);
        $comando_busca_planos->execute();
        $resultado_busca_planos = $comando_busca_planos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_planos);
    }
}
?>