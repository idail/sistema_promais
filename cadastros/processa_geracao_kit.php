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

        // --- Limpa as sessões de seleção antigas ao gerar NOVO kit ---
        // (mantém $_SESSION['empresa_id'], $_SESSION['user_id'] e outras persistentes)
        $sess_to_clear = [
            "exame_selecionado",
            "empresa_selecionado",
            "clinica_selecionado",
            "colaborador_selecionado",
            "cargo_selecionado",
            "motorista_selecionado",
            "medico_coordenador_selecionado",
            "medico_clinica_selecionado",
            "medico_risco_selecionado",
            "medico_treinamento_selecionado",
            "insalubridade_selecionado",
            "porcentagem_selecionado",
            "periculosidade_selecionado",
            "aposentado_selecionado",
            "agente_nocivo_selecionado",
            "agente_ocorrencia_selecionado",
            "aptidao_selecionado",
            "exames_selecionado"
        ];

        foreach ($sess_to_clear as $sk) {
            if (array_key_exists($sk, $_SESSION)) {
                unset($_SESSION[$sk]);
            }
        }
        // ------------------------------------------------------------

        // Registra o código do kit recém-criado
        $_SESSION["codigo_kit"] = $recebe_codigo_gerado_kit;
        echo json_encode($recebe_codigo_gerado_kit);
    } else if ($recebe_processo_geracao_kit === "incluir_valores_kit") {
        // EXAME
        // ... (seu código anterior, começando nos blocos de POST que você enviou)
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

        // MEDICO CLINICA
        if (isset($_POST["valor_medico_clinica_id"]) && $_POST["valor_medico_clinica_id"] !== "") {
            $recebe_medico_clinica_selecionado = $_POST["valor_medico_clinica_id"];

            if (!isset($_SESSION["medico_clinica_selecionado"]) || $_SESSION["medico_clinica_selecionado"] !== $recebe_medico_clinica_selecionado) {
                $_SESSION["medico_clinica_selecionado"] = $recebe_medico_clinica_selecionado;
            }
        }
        $valor_medico_clinica_bind = isset($_SESSION["medico_clinica_selecionado"]) ? $_SESSION["medico_clinica_selecionado"] : null;

        // RISCOS
        if (isset($_POST["valor_riscos"]) && $_POST["valor_riscos"] !== "") {
            $recebe_riscos_selecionado = $_POST["valor_riscos"];

            if (!isset($_SESSION["medico_risco_selecionado"]) || $_SESSION["medico_risco_selecionado"] !== $recebe_riscos_selecionado) {
                $_SESSION["medico_risco_selecionado"] = $recebe_riscos_selecionado;
            }
        }
        $valor_risco_selecionado_bind = isset($_SESSION["medico_risco_selecionado"]) ? $_SESSION["medico_risco_selecionado"] : null;

        // TREINAMENTOS
        if (isset($_POST["valor_treinamentos"]) && $_POST["valor_treinamentos"] !== "") {
            $recebe_treinamento_selecionado = $_POST["valor_treinamentos"];

            if (!isset($_SESSION["medico_treinamento_selecionado"]) || $_SESSION["medico_treinamento_selecionado"] !== $recebe_treinamento_selecionado) {
                $_SESSION["medico_treinamento_selecionado"] = $recebe_treinamento_selecionado;
            }
        }
        $valor_treinamento_selecionado_bind = isset($_SESSION["medico_treinamento_selecionado"]) ? $_SESSION["medico_treinamento_selecionado"] : null;

        if (
            isset($_POST["valor_laudo_selecionado"]) && $_POST["valor_laudo_selecionado"] !== ""
            && isset($_POST["valor_selecionado"]) && $_POST["valor_selecionado"] !== ""
        ) {
            if ($_POST["valor_laudo_selecionado"] === "insalubridade") {
                if (!empty($_POST["valor_selecionado"]))
                    $recebe_valor_insalubridade = $_POST["valor_selecionado"];
            } else if ($_POST["valor_laudo_selecionado"] === "porcentagem") {
                if (!empty($_POST["valor_selecionado"]))
                    $recebe_valor_laudo = $_POST["valor_selecionado"];
            } else if ($_POST["valor_laudo_selecionado"] === "periculosidade 30%") {
                if (!empty($_POST["valor_laudo_selecionado"]))
                    $recebe_valor_periculosidade = $_POST["valor_selecionado"];
            } else if ($_POST["valor_laudo_selecionado"] === "aposent. especial") {
                if (!empty($_POST["valor_laudo_selecionado"]))
                    $recebe_valor_aposentado = $_POST["valor_selecionado"];
            } else if ($_POST["valor_laudo_selecionado"] === "agente nocivo") {
                if (!empty($_POST["valor_laudo_selecionado"]))
                    $recebe_valor_agente = $_POST["valor_selecionado"];
            } else if ($_POST["valor_laudo_selecionado"] === "ocorrência gfip") {
                if (!empty($_POST["valor_laudo_selecionado"]))
                    $recebe_valor_ocorrencia = $_POST["valor_selecionado"];
            }

            if (!empty($recebe_valor_insalubridade)) {
                if (!isset($_SESSION["insalubridade_selecionado"]) || $_SESSION["insalubridade_selecionado"] !== $recebe_valor_insalubridade) {
                    $_SESSION["insalubridade_selecionado"] = $recebe_valor_insalubridade;
                }
            }

            if (!empty($recebe_valor_laudo)) {
                if (!isset($_SESSION["porcentagem_selecionado"]) || $_SESSION["porcentagem_selecionado"] !== $recebe_valor_laudo) {
                    $_SESSION["porcentagem_selecionado"] = $recebe_valor_laudo;
                }
            }

            if (!empty($recebe_valor_periculosidade)) {
                if (!isset($_SESSION["periculosidade_selecionado"]) || $_SESSION["periculosidade_selecionado"] !== $recebe_valor_periculosidade) {
                    $_SESSION["periculosidade_selecionado"] = $recebe_valor_periculosidade;
                }
            }

            if (!empty($recebe_valor_aposentado)) {
                if (!isset($_SESSION["aposentado_selecionado"]) || $_SESSION["aposentado_selecionado"] !== $recebe_valor_aposentado) {
                    $_SESSION["aposentado_selecionado"] = $recebe_valor_aposentado;
                }
            }

            if (!empty($recebe_valor_agente)) {
                if (!isset($_SESSION["agente_nocivo_selecionado"]) || $_SESSION["agente_nocivo_selecionado"] !== $recebe_valor_agente) {
                    $_SESSION["agente_nocivo_selecionado"] = $recebe_valor_agente;
                }
            }

            if (!empty($recebe_valor_ocorrencia)) {
                if (!isset($_SESSION["agente_ocorrencia_selecionado"]) || $_SESSION["agente_ocorrencia_selecionado"] !== $recebe_valor_ocorrencia) {
                    $_SESSION["agente_ocorrencia_selecionado"] = $recebe_valor_ocorrencia;
                }
            }
        }

        $valor_insalubridade_selecionado_bind = isset($_SESSION["insalubridade_selecionado"]) ? $_SESSION["insalubridade_selecionado"] : null;
        $valor_porcentagem_selecionado_bind = isset($_SESSION["porcentagem_selecionado"]) ? $_SESSION["porcentagem_selecionado"] : null;
        $valor_periculosidade_selecionado_bind = isset($_SESSION["periculosidade_selecionado"]) ? $_SESSION["periculosidade_selecionado"] : null;
        $valor_aposentado_selecionado_bind = isset($_SESSION["aposentado_selecionado"]) ? $_SESSION["aposentado_selecionado"] : null;
        $valor_agente_nocivo_selecionado_bind = isset($_SESSION["agente_nocivo_selecionado"]) ? $_SESSION["agente_nocivo_selecionado"] : null;
        $valor_ocorrencia_selecionado_bind = isset($_SESSION["agente_ocorrencia_selecionado"]) ? $_SESSION["agente_ocorrencia_selecionado"] : null;

        // APTIDOES
        if (isset($_POST["valor_aptidoes"]) && $_POST["valor_aptidoes"] !== "") {
            $recebe_aptidao_selecionado = $_POST["valor_aptidoes"];

            if (!isset($_SESSION["aptidao_selecionado"]) || $_SESSION["aptidao_selecionado"] !== $recebe_aptidao_selecionado) {
                $_SESSION["aptidao_selecionado"] = $recebe_aptidao_selecionado;
            }
        }
        $valor_aptidao_selecionado_bind = isset($_SESSION["aptidao_selecionado"]) ? $_SESSION["aptidao_selecionado"] : null;

        // EXAMES SELECIONADOS
        if (isset($_POST["valor_exames_selecionados"]) && $_POST["valor_exames_selecionados"] !== "") {
            $recebe_exames_selecionado = $_POST["valor_exames_selecionados"];

            if (!isset($_SESSION["exames_selecionado"]) || $_SESSION["exames_selecionado"] !== $recebe_exames_selecionado) {
                $_SESSION["exames_selecionado"] = $recebe_exames_selecionado;
            }
        }
        $valor_exames_selecionado_bind = isset($_SESSION["exames_selecionado"]) ? $_SESSION["exames_selecionado"] : null;

        // Atualização
        $instrucao_atualizar_kit = "UPDATE kits SET 
        tipo_exame = :recebe_tipo_exame,
        empresa_id = :recebe_empresa_id,
        clinica_id = :recebe_clinica_id,
        pessoa_id = :recebe_pessoa_id,
        motorista = :recebe_motorista,
        cargo_id = :recebe_cargo_id,
        medico_coordenador_id = :recebe_medico_coordenador_id,
        medico_clinica_id = :recebe_medico_clinica_id,
        riscos_selecionados = :recebe_riscos_selecionados,
        treinamentos_selecionados = :recebe_treinamentos_selecionados,
        insalubridade = :recebe_insalubridade_selecionado,
        porcentagem = :recebe_porcentagem_selecionado,
        periculosidade = :recebe_periculosidade_selecionado,
        aposentado_especial = :recebe_aposentado_especial_selecionado,
        agente_nocivo = :recebe_agente_nocivo_selecionado,
        ocorrencia_gfip = :recebe_ocorrencia_gfip_selecionado,
        aptidoes_selecionadas = :recebe_aptidao_selecionado,
        exames_selecionados = :recebe_exames_selecionado
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
        $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados",    $valor_risco_selecionado_bind,  $valor_risco_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_treinamentos_selecionados",    $valor_treinamento_selecionado_bind,  $valor_treinamento_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_insalubridade_selecionado",    $valor_insalubridade_selecionado_bind,  $valor_insalubridade_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_porcentagem_selecionado",    $valor_porcentagem_selecionado_bind,  $valor_porcentagem_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_periculosidade_selecionado",    $valor_periculosidade_selecionado_bind,  $valor_periculosidade_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_aposentado_especial_selecionado",    $valor_aposentado_selecionado_bind,  $valor_aposentado_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_agente_nocivo_selecionado",    $valor_agente_nocivo_selecionado_bind,  $valor_agente_nocivo_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_ocorrencia_gfip_selecionado",    $valor_ocorrencia_selecionado_bind,  $valor_ocorrencia_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_aptidao_selecionado",    $valor_aptidao_selecionado_bind,  $valor_aptidao_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_exames_selecionado",    $valor_exames_selecionado_bind,  $valor_exames_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // Kit ID
        $comando_atualizar_kit->bindValue(":recebe_kit_id", $_SESSION["codigo_kit"], PDO::PARAM_INT);

        // Executa
        $resultado_atualizar_kit = $comando_atualizar_kit->execute();

        if ($resultado_atualizar_kit) {
            echo json_encode("KIT atualizado com sucesso");
        } else {
            echo json_encode("KIT não foi atualizado com sucesso");
        }
    }
}
?>