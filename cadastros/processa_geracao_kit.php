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

    if($recebe_processo_geracao_kit === "geracao_kit_sessao")
    {
        $instrucao_cadastra_kit = "insert into kits(status,empresa_id,usuario_id)values(:recebe_status_kit,:recebe_empresa_id_kit,:recebe_usuario_id)";
        $comando_cadastra_kit = $pdo->prepare($instrucao_cadastra_kit);
        $comando_cadastra_kit->bindValue(":recebe_status_kit","RASCUNHO");
        $comando_cadastra_kit->bindValue(":recebe_empresa_id_kit",$_SESSION["empresa_id"]);
        $comando_cadastra_kit->bindValue(":recebe_usuario_id",$_SESSION['user_id']);
        $comando_cadastra_kit->execute();
        $recebe_codigo_gerado_kit = $pdo->lastInsertId();
        $_SESSION["codigo_kit"] = $recebe_codigo_gerado_kit;
        echo json_encode($recebe_codigo_gerado_kit);
    }else if($recebe_processo_geracao_kit === "incluir_valores_kit")
    {
        if(isset($_POST["valor_exame"]) && $_POST["valor_exame"] !== "")
            $recebe_exame_selecionado = $_POST["valor_exame"];

        $instrucao_atualizar_kit = "update kits set tipo_exame = :recebe_tipo_exame where id = :recebe_kit_id";
        $comando_atualizar_kit = $pdo->prepare($instrucao_atualizar_kit);
        $comando_atualizar_kit->bindValue(":recebe_tipo_exame",$recebe_exame_selecionado);
        $comando_atualizar_kit->bindValue(":recebe_kit_id",$_SESSION["codigo_kit"]);
        $resultado_atualizar_kit = $comando_atualizar_kit->execute();

        if($resultado_atualizar_kit)
            echo json_encode("Exame gravado com sucesso");
        else
            echo json_encode("Exame não foi gravado");
    }
}
?>