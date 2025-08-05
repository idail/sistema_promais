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
    $recebe_processo_geracao_kit = $_POST["processo_geracao_kit"];

    $recebe_codigo_gerado_kit;

    if ($recebe_processo_geracao_kit === "geracao_kit_sessao") {
        $instrucao_cadastra_kit = "insert into kits(status,empresa_id_principal,usuario_id)values(:recebe_status_kit,:recebe_empresa_id_kit,:recebe_usuario_id)";
        $comando_cadastra_kit = $pdo->prepare($instrucao_cadastra_kit);
        $comando_cadastra_kit->bindValue(":recebe_status_kit", "RASCUNHO");
        $comando_cadastra_kit->bindValue(":recebe_empresa_id_kit", $_SESSION["empresa_id"]);
        $comando_cadastra_kit->bindValue(":recebe_usuario_id", $_SESSION['user_id']);
        $comando_cadastra_kit->execute();
        $recebe_codigo_gerado_kit = $pdo->lastInsertId();
        $_SESSION["codigo_kit"] = $recebe_codigo_gerado_kit;
        echo json_encode($recebe_codigo_gerado_kit);
    } else if ($recebe_processo_geracao_kit === "incluir_valores_kit") {
        if (isset($_POST["valor_exame"]) && $_POST["valor_exame"] !== "") {
            $recebe_exame_selecionado = $_POST["valor_exame"];
        } else {
            $recebe_exame_selecionado = null;
        }

        if (isset($_POST["valor_empresa"]) && $_POST["valor_empresa"] !== "") {
            $recebe_empresa_selecionado = $_POST["valor_empresa"];
        } else {
            $recebe_empresa_selecionado = null;
        }

        if (isset($_POST["valor_clinica"]) && $_POST["valor_clinica"] !== "") {
            $recebe_clinica_selecionado = $_POST["valor_clinica"];
        } else {
            $recebe_clinica_selecionado = null;
        }

        if (isset($_POST["valor_colaborador"]) && $_POST["valor_colaborador"] !== "") {
            $recebe_colaborador_selecionado = $_POST["valor_colaborador"];
        } else {
            $recebe_colaborador_selecionado = null;
        }

        if (isset($_POST["valor_cargo"]) && $_POST["valor_cargo"] !== "") {
            $recebe_cargo_selecionado = $_POST["valor_cargo"];
        } else {
            $recebe_cargo_selecionado = null;
        }


        $instrucao_atualizar_kit = "update kits set tipo_exame = :recebe_tipo_exame,empresa_id = :recebe_empresa_id,clinica_id = :recebe_clinica_id,pessoa_id = :recebe_pessoa_id,cargo_id = :recebe_cargo_id where id = :recebe_kit_id";
        $comando_atualizar_kit = $pdo->prepare($instrucao_atualizar_kit);
        $comando_atualizar_kit->bindValue(
            ":recebe_tipo_exame",
            $recebe_exame_selecionado,
            $recebe_exame_selecionado === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        $comando_atualizar_kit->bindValue(
            ":recebe_empresa_id",
            $recebe_empresa_selecionado,
            $recebe_empresa_selecionado === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        $comando_atualizar_kit->bindValue(
            ":recebe_clinica_id",
            $recebe_clinica_selecionado,
            $recebe_clinica_selecionado === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        $comando_atualizar_kit->bindValue(
            ":recebe_pessoa_id",
            $recebe_colaborador_selecionado,
            $recebe_colaborador_selecionado === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        $comando_atualizar_kit->bindValue(
            ":recebe_cargo_id",
            $recebe_cargo_selecionado,
            $recebe_cargo_selecionado === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        $comando_atualizar_kit->bindValue(
            ":recebe_kit_id",
            $_SESSION["codigo_kit"],
            PDO::PARAM_INT
        );
        $resultado_atualizar_kit = $comando_atualizar_kit->execute();

        if ($resultado_atualizar_kit)
            echo json_encode("KIT atualizado com sucesso");
        else
            echo json_encode("KIT não foi atualizado com sucesso");
    }
}
?>