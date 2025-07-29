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
    $recebe_processo_geracao_kit = $_POST["processo_geracao_kit"];

    $recebe_codigo_gerado_kit;

    if($recebe_processo_geracao_kit === "incluir_exame")
    {
        $recebe_exame_selecionado = $_POST["valor_exame"];

        $instrucao_cadastra_exame = "insert into kits(tipo_exame)values(:recebe_tipo_exame)";
        $comando_cadastra_exame = $pdo->prepare($instrucao_cadastra_exame);
        $comando_cadastra_exame->bindValue(":recebe_tipo_exame",$recebe_exame_selecionado);
        $comando_cadastra_exame->execute();
        $recebe_codigo_gerado_kit = $pdo->lastInsertId();
        echo json_encode($recebe_codigo_gerado_kit);
    }
}
?>