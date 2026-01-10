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

$recebe_empresa_id = $_SESSION["empresa_id"];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8", // charset adicionado aqui
        $username,
        $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") // comando adicional
    );
    // Configurar o modo de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_valor_email = $_GET["termo"];
    $sql = "
    SELECT 
        email,
        email_contabilidade,
        'empresa' AS origem
    FROM empresas_novas
    WHERE empresa_id = :empresa_id
      AND (email LIKE :termo OR email_contabilidade LIKE :termo)

    UNION ALL

    SELECT 
        email,
        email_contabilidade,
        'clinica' AS origem
    FROM clinicas
    WHERE empresa_id = :empresa_id
      AND (email LIKE :termo OR email_contabilidade LIKE :termo)
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':empresa_id', $recebe_empresa_id, PDO::PARAM_INT);
$stmt->bindValue(':termo', '%' . $recebe_valor_email . '%', PDO::PARAM_STR);
$stmt->execute();

$resultado = $stmt->fetchAll();

echo json_encode($resultado);

}
?>