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
    $recebe_processo_usuario = $_POST["processo_usuario"];

    if($recebe_processo_usuario === "alterar_senha_usuario")
    {
        $recebe_senha_usuario = $_POST["valor_senha_alterada"];

        $recebe_senha_usuario_md5 = md5($recebe_senha_usuario);

        $recebe_id_usuario = $_POST["valor_id_usuario"];

        $instrucao_alterar_senha_usuario = "update usuarios set senha_hash = :recebe_senha_hash where id = :recebe_id_usuario";
        $comando_alterar_senha_usuario = $pdo->prepare($instrucao_alterar_senha_usuario);
        $comando_alterar_senha_usuario->bindValue(":recebe_senha_hash",$recebe_senha_usuario_md5);
        $comando_alterar_senha_usuario->bindValue(":recebe_id_usuario",$recebe_id_usuario);
        $resultado_alterar_senha_usuario = $comando_alterar_senha_usuario->execute();
        echo json_encode($resultado_alterar_senha_usuario);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_usuario = $_GET["processo_usuario"];

    if($recebe_processo_usuario === "buscar_usuarios")
    {
        $instrucao_busca_usuarios = "select * from usuarios";
        $comando_busca_usuarios = $pdo->prepare($instrucao_busca_usuarios);
        $comando_busca_usuarios->execute();
        $resultado_busca_usuarios = $comando_busca_usuarios->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_usuarios);
    }else if($recebe_processo_usuario === "buscar_usuario_especifico")
    {
        $instrucao_busca_usuario_especifico = "select * from usuarios where id = :recebe_id_usuario";
        $comando_busca_usuario_especifico = $pdo->prepare($instrucao_busca_usuario_especifico);
        $comando_busca_usuario_especifico->bindValue(":recebe_id_usuario",$_GET["valor_id_usuario"]);
        $comando_busca_usuario_especifico->execute();
        $resultado_busca_usuario_especifico = $comando_busca_usuario_especifico->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_usuario_especifico);
    }
}
?>