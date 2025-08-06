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
        // EXAME
        // if (isset($_POST["valor_exame"]) && $_POST["valor_exame"] !== "") {
        //     $recebe_exame_selecionado = $_POST["valor_exame"];

        //     if (!isset($_SESSION["exame_selecionado"]) || $_SESSION["exame_selecionado"] !== $recebe_exame_selecionado) {
        //         $_SESSION["exame_selecionado"] = $recebe_exame_selecionado;
        //     }
        // }

        // // EMPRESA
        // if (isset($_POST["valor_empresa"]) && $_POST["valor_empresa"] !== "") {
        //     $recebe_empresa_selecionado = $_POST["valor_empresa"];

        //     if (!isset($_SESSION["empresa_selecionado"]) || $_SESSION["empresa_selecionado"] !== $recebe_empresa_selecionado) {
        //         $_SESSION["empresa_selecionado"] = $recebe_empresa_selecionado;
        //     }
        // }

        // // CLÍNICA
        // if (isset($_POST["valor_clinica"]) && $_POST["valor_clinica"] !== "") {
        //     $recebe_clinica_selecionado = $_POST["valor_clinica"];

        //     if (!isset($_SESSION["clinica_selecionado"]) || $_SESSION["clinica_selecionado"] !== $recebe_clinica_selecionado) {
        //         $_SESSION["clinica_selecionado"] = $recebe_clinica_selecionado;
        //     }
        // }

        // // COLABORADOR
        // if (isset($_POST["valor_colaborador"]) && $_POST["valor_colaborador"] !== "") {
        //     $recebe_colaborador_selecionado = $_POST["valor_colaborador"];

        //     if (!isset($_SESSION["colaborador_selecionado"]) || $_SESSION["colaborador_selecionado"] !== $recebe_colaborador_selecionado) {
        //         $_SESSION["colaborador_selecionado"] = $recebe_colaborador_selecionado;
        //     }
        // }

        // // CARGO
        // if (isset($_POST["valor_cargo"]) && $_POST["valor_cargo"] !== "") {
        //     $recebe_cargo_selecionado = $_POST["valor_cargo"];

        //     if (!isset($_SESSION["cargo_selecionado"]) || $_SESSION["cargo_selecionado"] !== $recebe_cargo_selecionado) {
        //         $_SESSION["cargo_selecionado"] = $recebe_cargo_selecionado;
        //     }
        // }

        // // MOTORISTA
        // if (isset($_POST["valor_motorista"]) && $_POST["valor_motorista"] !== "") {
        //     $recebe_motorista_selecionado = $_POST["valor_motorista"];

        //     if (!isset($_SESSION["motorista_selecionado"]) || $_SESSION["motorista_selecionado"] !== $recebe_motorista_selecionado) {
        //         $_SESSION["motorista_selecionado"] = $recebe_motorista_selecionado;
        //     }
        // }



        // $instrucao_atualizar_kit = "update kits set tipo_exame = :recebe_tipo_exame,empresa_id = :recebe_empresa_id,clinica_id = :recebe_clinica_id,
        // pessoa_id = :recebe_pessoa_id,motorista = :recebe_motorista,cargo_id = :recebe_cargo_id where id = :recebe_kit_id";
        // $comando_atualizar_kit = $pdo->prepare($instrucao_atualizar_kit);
        // $comando_atualizar_kit->bindValue(
        //     ":recebe_tipo_exame",
        //     $_SESSION["exame_selecionado"],
        //     $_SESSION["exame_selecionado"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_empresa_id",
        //     $_SESSION["empresa_selecionado"],
        //     $_SESSION["empresa_selecionado"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_clinica_id",
        //     $_SESSION["clinica_selecionado"],
        //     $_SESSION["clinica_selecionado"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_pessoa_id",
        //     $_SESSION["colaborador_selecionado"],
        //     $_SESSION["colaborador_selecionado"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_cargo_id",
        //     $_SESSION["cargo_selecionado"],
        //     $_SESSION["cargo_selecionado"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_motorista",
        //     $_SESSION["motorista_selecionado"],
        //     $_SESSION["motorista_selecionado"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // EXAME
        // EXAME
        if (isset($_POST["valor_exame"]) && $_POST["valor_exame"] !== "") {
            $recebe_exame_selecionado = $_POST["valor_exame"];

            if (!isset($_SESSION["exame_selecionado"]) || $_SESSION["exame_selecionado"] !== $recebe_exame_selecionado) {
                $_SESSION["exame_selecionado"] = $recebe_exame_selecionado;
            }
        }
        $valor_exame_bind = isset($_SESSION["exame_selecionado"]) ? $_SESSION["exame_selecionado"] : null;

        // EMPRESA
        if (isset($_POST["valor_empresa"]) && $_POST["valor_empresa"] !== "") {
            $recebe_empresa_selecionado = $_POST["valor_empresa"];

            if (!isset($_SESSION["empresa_selecionado"]) || $_SESSION["empresa_selecionado"] !== $recebe_empresa_selecionado) {
                $_SESSION["empresa_selecionado"] = $recebe_empresa_selecionado;
            }
        }
        $valor_empresa_bind = isset($_SESSION["empresa_selecionado"]) ? $_SESSION["empresa_selecionado"] : null;

        // CLÍNICA
        if (isset($_POST["valor_clinica"]) && $_POST["valor_clinica"] !== "") {
            $recebe_clinica_selecionado = $_POST["valor_clinica"];

            if (!isset($_SESSION["clinica_selecionado"]) || $_SESSION["clinica_selecionado"] !== $recebe_clinica_selecionado) {
                $_SESSION["clinica_selecionado"] = $recebe_clinica_selecionado;
            }
        }
        $valor_clinica_bind = isset($_SESSION["clinica_selecionado"]) ? $_SESSION["clinica_selecionado"] : null;

        // COLABORADOR
        if (isset($_POST["valor_colaborador"]) && $_POST["valor_colaborador"] !== "") {
            $recebe_colaborador_selecionado = $_POST["valor_colaborador"];

            if (!isset($_SESSION["colaborador_selecionado"]) || $_SESSION["colaborador_selecionado"] !== $recebe_colaborador_selecionado) {
                $_SESSION["colaborador_selecionado"] = $recebe_colaborador_selecionado;
            }
        }
        $valor_colaborador_bind = isset($_SESSION["colaborador_selecionado"]) ? $_SESSION["colaborador_selecionado"] : null;

        // CARGO
        if (isset($_POST["valor_cargo"]) && $_POST["valor_cargo"] !== "") {
            $recebe_cargo_selecionado = $_POST["valor_cargo"];

            if (!isset($_SESSION["cargo_selecionado"]) || $_SESSION["cargo_selecionado"] !== $recebe_cargo_selecionado) {
                $_SESSION["cargo_selecionado"] = $recebe_cargo_selecionado;
            }
        }
        $valor_cargo_bind = isset($_SESSION["cargo_selecionado"]) ? $_SESSION["cargo_selecionado"] : null;

        // MOTORISTA
        if (isset($_POST["valor_motorista"]) && $_POST["valor_motorista"] !== "") {
            $recebe_motorista_selecionado = $_POST["valor_motorista"];

            if (!isset($_SESSION["motorista_selecionado"]) || $_SESSION["motorista_selecionado"] !== $recebe_motorista_selecionado) {
                $_SESSION["motorista_selecionado"] = $recebe_motorista_selecionado;
            }
        }
        $valor_motorista_bind = isset($_SESSION["motorista_selecionado"]) ? $_SESSION["motorista_selecionado"] : null;

        // MEDICO COORDENADOR
        if (isset($_POST["valor_medico_coordenador_id"]) && $_POST["valor_medico_coordenador_id"] !== "") {
            $recebe_medico_coordenador_selecionado = $_POST["valor_medico_coordenador_id"];

            if (!isset($_SESSION["medico_coordenador_selecionado"]) || $_SESSION["medico_coordenador_selecionado"] !== $recebe_medico_coordenador_selecionado) {
                $_SESSION["medico_coordenador_selecionado"] = $recebe_medico_coordenador_selecionado;
            }
        }
        $valor_medico_coordenador_bind = isset($_SESSION["medico_coordenador_selecionado"]) ? $_SESSION["medico_coordenador_selecionado"] : null;

        // MEDICO COORDENADOR
        if (isset($_POST["valor_medico_clinica_id"]) && $_POST["valor_medico_clinica_id"] !== "") {
            $recebe_medico_clinica_selecionado = $_POST["valor_medico_clinica_id"];

            if (!isset($_SESSION["medico_clinica_selecionado"]) || $_SESSION["medico_clinica_selecionado"] !== $recebe_medico_clinica_selecionado) {
                $_SESSION["medico_clinica_selecionado"] = $recebe_medico_clinica_selecionado;
            }
        }
        $valor_medico_clinica_bind = isset($_SESSION["medico_clinica_selecionado"]) ? $_SESSION["medico_clinica_selecionado"] : null;

        // Atualização
        $instrucao_atualizar_kit = "UPDATE kits SET 
            tipo_exame = :recebe_tipo_exame,
            empresa_id = :recebe_empresa_id,
            clinica_id = :recebe_clinica_id,
            pessoa_id = :recebe_pessoa_id,
            motorista = :recebe_motorista,
            cargo_id = :recebe_cargo_id,
            medico_coordenador_id = :recebe_medico_coordenador_id,
            medico_clinica_id = :recebe_medico_clinica_id
        WHERE id = :recebe_kit_id";

        $comando_atualizar_kit = $pdo->prepare($instrucao_atualizar_kit);

        // Binds
        $comando_atualizar_kit->bindValue(":recebe_tipo_exame",   $valor_exame_bind,      $valor_exame_bind      === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_empresa_id",   $valor_empresa_bind,    $valor_empresa_bind    === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_clinica_id",   $valor_clinica_bind,    $valor_clinica_bind    === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_pessoa_id",    $valor_colaborador_bind, $valor_colaborador_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_cargo_id",     $valor_cargo_bind,      $valor_cargo_bind      === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_motorista",    $valor_motorista_bind,  $valor_motorista_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_medico_coordenador_id",    $valor_medico_coordenador_bind,  $valor_medico_coordenador_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id",    $valor_medico_clinica_bind,  $valor_medico_clinica_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // Kit ID
        $comando_atualizar_kit->bindValue(":recebe_kit_id", $_SESSION["codigo_kit"], PDO::PARAM_INT);

        // Executa
        $resultado_atualizar_kit = $comando_atualizar_kit->execute();

        if ($resultado_atualizar_kit)
            echo json_encode("KIT atualizado com sucesso");
        else
            echo json_encode("KIT não foi atualizado com sucesso");
    }
}
?>