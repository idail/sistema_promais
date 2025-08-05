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

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    $recebe_processo_cargo = $_POST["processo_cargo"];

    if($recebe_processo_cargo === "inserir_cargo")
    {
        $recebe_titulo_cargo = $_POST["valor_titulo_cargo"];

        $recebe_codigo_cargo = $_POST["valor_codigo_cargo"];

        $recebe_descricao_cargo = $_POST["valor_descricao_cargo"];

        $recebe_empresa_id = $_SESSION["empresa_id"];

        $instrucao_cadastra_cargo = "insert into cargo(titulo_cargo,codigo_cargo,descricao_cargo,empresa_id)values(:recebe_titulo_cargo,:recebe_codigo_cargo,:recebe_descricao_cargo,:recebe_empresa_id_cargo)";
        $comando_cadastra_cargo = $pdo->prepare($instrucao_cadastra_cargo);
        $comando_cadastra_cargo->bindValue(":recebe_titulo_cargo",$recebe_titulo_cargo);
        $comando_cadastra_cargo->bindValue(":recebe_codigo_cargo",$recebe_codigo_cargo);
        $comando_cadastra_cargo->bindValue(":recebe_descricao_cargo",$recebe_descricao_cargo);
        $comando_cadastra_cargo->bindValue(":recebe_empresa_id_cargo",$recebe_empresa_id);
        $comando_cadastra_cargo->execute();
        $resultado_cadastra_cargo = $pdo->lastInsertId();

        echo json_encode($resultado_cadastra_cargo);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_cargo = $_GET["processo_cargo"];

    if($recebe_processo_cargo === "buscar_cargos")
    {
        $instrucao_busca_cargo = "select * from cargo where empresa_id = :recebe_empresa_id_cargo";
        $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
        $comando_busca_cargo->bindValue(":recebe_empresa_id_cargo",$_SESSION["empresa_id"]);
        $comando_busca_cargo->execute();
        $resultado_busca_cargo = $comando_busca_cargo->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cargo);
    }
}
?>