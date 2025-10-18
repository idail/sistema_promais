<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

// Se instalou via Composer
require(__DIR__."/../vendor/autoload.php");

use  Dompdf\Dompdf;
use  Dompdf\Options;


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
        // if (isset($_POST["valor_exame"]) && $_POST["valor_exame"] !== "") {
        //     $recebe_exame_selecionado = $_POST["valor_exame"];

        //     if (!isset($_SESSION["exame_selecionado"]) || $_SESSION["exame_selecionado"] !== $recebe_exame_selecionado) {
        //         $_SESSION["exame_selecionado"] = $recebe_exame_selecionado;
        //     }
        // }
        // $valor_exame_bind = isset($_SESSION["exame_selecionado"]) ? $_SESSION["exame_selecionado"] : null;

        // EXAME
        $valor_exame_bind = null;
        if (isset($_POST["valor_exame"])) {
            $recebe_exame_selecionado = $_POST["valor_exame"] !== "" ? $_POST["valor_exame"] : null;
            if (!isset($_SESSION["exame_selecionado"]) || $_SESSION["exame_selecionado"] !== $recebe_exame_selecionado) {
                $_SESSION["exame_selecionado"] = $recebe_exame_selecionado;
            }
        }
        if (isset($_SESSION["exame_selecionado"])) {
            $valor_exame_bind = $_SESSION["exame_selecionado"];
        }


        // EMPRESA
        // if (isset($_POST["valor_empresa"]) && $_POST["valor_empresa"] !== "") {
        //     $recebe_empresa_selecionado = $_POST["valor_empresa"];

        //     if (!isset($_SESSION["empresa_selecionado"]) || $_SESSION["empresa_selecionado"] !== $recebe_empresa_selecionado) {
        //         $_SESSION["empresa_selecionado"] = $recebe_empresa_selecionado;
        //     }
        // }
        // $valor_empresa_bind = isset($_SESSION["empresa_selecionado"]) ? $_SESSION["empresa_selecionado"] : null;

        // EMPRESA
        $valor_empresa_bind = null;
        if (isset($_POST["valor_empresa"])) {
            $recebe_empresa_selecionado = $_POST["valor_empresa"] !== "" ? $_POST["valor_empresa"] : null;
            if (!isset($_SESSION["empresa_selecionado"]) || $_SESSION["empresa_selecionado"] !== $recebe_empresa_selecionado) {
                $_SESSION["empresa_selecionado"] = $recebe_empresa_selecionado;
            }
        }
        if (isset($_SESSION["empresa_selecionado"])) {
            $valor_empresa_bind = $_SESSION["empresa_selecionado"];
        }


        // CLÍNICA
        // if (isset($_POST["valor_clinica"]) && $_POST["valor_clinica"] !== "") {
        //     $recebe_clinica_selecionado = $_POST["valor_clinica"];

        //     if (!isset($_SESSION["clinica_selecionado"]) || $_SESSION["clinica_selecionado"] !== $recebe_clinica_selecionado) {
        //         $_SESSION["clinica_selecionado"] = $recebe_clinica_selecionado;
        //     }
        // }
        // $valor_clinica_bind = isset($_SESSION["clinica_selecionado"]) ? $_SESSION["clinica_selecionado"] : null;

        // CLÍNICA
        $valor_clinica_bind = null;
        if (isset($_POST["valor_clinica"])) {
            $recebe_clinica_selecionado = $_POST["valor_clinica"] !== "" ? $_POST["valor_clinica"] : null;
            if (!isset($_SESSION["clinica_selecionado"]) || $_SESSION["clinica_selecionado"] !== $recebe_clinica_selecionado) {
                $_SESSION["clinica_selecionado"] = $recebe_clinica_selecionado;
            }
        }
        if (isset($_SESSION["clinica_selecionado"])) {
            $valor_clinica_bind = $_SESSION["clinica_selecionado"];
        }


        // COLABORADOR
        // if (isset($_POST["valor_colaborador"]) && $_POST["valor_colaborador"] !== "") {
        //     $recebe_colaborador_selecionado = $_POST["valor_colaborador"];

        //     if (!isset($_SESSION["colaborador_selecionado"]) || $_SESSION["colaborador_selecionado"] !== $recebe_colaborador_selecionado) {
        //         $_SESSION["colaborador_selecionado"] = $recebe_colaborador_selecionado;
        //     }
        // }
        // $valor_colaborador_bind = isset($_SESSION["colaborador_selecionado"]) ? $_SESSION["colaborador_selecionado"] : null;

        // COLABORADOR
        $valor_colaborador_bind = null;
        if (isset($_POST["valor_colaborador"])) {
            $recebe_colaborador_selecionado = $_POST["valor_colaborador"] !== "" ? $_POST["valor_colaborador"] : null;
            if (!isset($_SESSION["colaborador_selecionado"]) || $_SESSION["colaborador_selecionado"] !== $recebe_colaborador_selecionado) {
                $_SESSION["colaborador_selecionado"] = $recebe_colaborador_selecionado;
            }
        }
        if (isset($_SESSION["colaborador_selecionado"])) {
            $valor_colaborador_bind = $_SESSION["colaborador_selecionado"];
        }


        // CARGO
        // if (isset($_POST["valor_cargo"]) && $_POST["valor_cargo"] !== "") {
        //     $recebe_cargo_selecionado = $_POST["valor_cargo"];

        //     if (!isset($_SESSION["cargo_selecionado"]) || $_SESSION["cargo_selecionado"] !== $recebe_cargo_selecionado) {
        //         $_SESSION["cargo_selecionado"] = $recebe_cargo_selecionado;
        //     }
        // }
        // $valor_cargo_bind = isset($_SESSION["cargo_selecionado"]) ? $_SESSION["cargo_selecionado"] : null;

        // CARGO
        $valor_cargo_bind = null;
        if (isset($_POST["valor_cargo"])) {
            $recebe_cargo_selecionado = $_POST["valor_cargo"] !== "" ? $_POST["valor_cargo"] : null;
            if (!isset($_SESSION["cargo_selecionado"]) || $_SESSION["cargo_selecionado"] !== $recebe_cargo_selecionado) {
                $_SESSION["cargo_selecionado"] = $recebe_cargo_selecionado;
            }
        }
        if (isset($_SESSION["cargo_selecionado"])) {
            $valor_cargo_bind = $_SESSION["cargo_selecionado"];
        }


        // MOTORISTA
        // if (isset($_POST["valor_motorista"]) && $_POST["valor_motorista"] !== "") {
        //     $recebe_motorista_selecionado = $_POST["valor_motorista"];

        //     if (!isset($_SESSION["motorista_selecionado"]) || $_SESSION["motorista_selecionado"] !== $recebe_motorista_selecionado) {
        //         $_SESSION["motorista_selecionado"] = $recebe_motorista_selecionado;
        //     }
        // }
        // $valor_motorista_bind = isset($_SESSION["motorista_selecionado"]) ? $_SESSION["motorista_selecionado"] : null;


        // MOTORISTA
        $valor_motorista_bind = null;
        if (isset($_POST["valor_motorista"])) {
            $recebe_motorista_selecionado = $_POST["valor_motorista"] !== "" ? $_POST["valor_motorista"] : null;
            if (!isset($_SESSION["motorista_selecionado"]) || $_SESSION["motorista_selecionado"] !== $recebe_motorista_selecionado) {
                $_SESSION["motorista_selecionado"] = $recebe_motorista_selecionado;
            }
        }

        if (isset($_SESSION["motorista_selecionado"])) {
           $valor_motorista_bind = $_SESSION["motorista_selecionado"];
        }


        // MEDICO COORDENADOR
        // if (isset($_POST["valor_medico_coordenador_id"]) && $_POST["valor_medico_coordenador_id"] !== "") {
        //     $recebe_medico_coordenador_selecionado = $_POST["valor_medico_coordenador_id"];

        //     if (!isset($_SESSION["medico_coordenador_selecionado"]) || $_SESSION["medico_coordenador_selecionado"] !== $recebe_medico_coordenador_selecionado) {
        //         $_SESSION["medico_coordenador_selecionado"] = $recebe_medico_coordenador_selecionado;
        //     }
        // }
        // $valor_medico_coordenador_bind = isset($_SESSION["medico_coordenador_selecionado"]) ? $_SESSION["medico_coordenador_selecionado"] : null;


        // MÉDICO COORDENADOR
        $valor_medico_coordenador_bind = null;
        if (isset($_POST["valor_medico_coordenador_id"])) {
            $recebe_medico_coordenador_selecionado = $_POST["valor_medico_coordenador_id"] !== "" ? $_POST["valor_medico_coordenador_id"] : null;
            if (!isset($_SESSION["medico_coordenador_selecionado"]) || $_SESSION["medico_coordenador_selecionado"] !== $recebe_medico_coordenador_selecionado) {
                $_SESSION["medico_coordenador_selecionado"] = $recebe_medico_coordenador_selecionado;
            }
        }
        if (isset($_SESSION["medico_coordenador_selecionado"])) {
            $valor_medico_coordenador_bind = $_SESSION["medico_coordenador_selecionado"];
        }


        // MEDICO CLINICA
        // if (isset($_POST["valor_medico_clinica_id"]) && $_POST["valor_medico_clinica_id"] !== "") {
        //     $recebe_medico_clinica_selecionado = $_POST["valor_medico_clinica_id"];

        //     if (!isset($_SESSION["medico_clinica_selecionado"]) || $_SESSION["medico_clinica_selecionado"] !== $recebe_medico_clinica_selecionado) {
        //         $_SESSION["medico_clinica_selecionado"] = $recebe_medico_clinica_selecionado;
        //     }
        // }
        // $valor_medico_clinica_bind = isset($_SESSION["medico_clinica_selecionado"]) ? $_SESSION["medico_clinica_selecionado"] : null;


        // MÉDICO CLÍNICA
        $valor_medico_clinica_bind = null;
        if (isset($_POST["valor_medico_clinica_id"])) {
            $recebe_medico_clinica_selecionado = $_POST["valor_medico_clinica_id"] !== "" ? $_POST["valor_medico_clinica_id"] : null;
            if (!isset($_SESSION["medico_clinica_selecionado"]) || $_SESSION["medico_clinica_selecionado"] !== $recebe_medico_clinica_selecionado) {
                $_SESSION["medico_clinica_selecionado"] = $recebe_medico_clinica_selecionado;
            }
        }
        if (isset($_SESSION["medico_clinica_selecionado"])) {
            $valor_medico_clinica_bind = $_SESSION["medico_clinica_selecionado"];
        }


        // RISCOS
        // if (isset($_POST["valor_riscos"]) && $_POST["valor_riscos"] !== "") {
        //     $recebe_riscos_selecionado = $_POST["valor_riscos"];

        //     if (!isset($_SESSION["medico_risco_selecionado"]) || $_SESSION["medico_risco_selecionado"] !== $recebe_riscos_selecionado) {
        //         $_SESSION["medico_risco_selecionado"] = $recebe_riscos_selecionado;
        //     }
        // }
        // $valor_risco_selecionado_bind = isset($_SESSION["medico_risco_selecionado"]) ? $_SESSION["medico_risco_selecionado"] : null;


        // RISCOS
        $valor_risco_selecionado_bind = null;
        if (isset($_POST["valor_riscos"])) {
            $recebe_riscos_selecionado = $_POST["valor_riscos"] !== "" ? $_POST["valor_riscos"] : null;
            if (!isset($_SESSION["medico_risco_selecionado"]) || $_SESSION["medico_risco_selecionado"] !== $recebe_riscos_selecionado) {
                $_SESSION["medico_risco_selecionado"] = $recebe_riscos_selecionado;
            }
        }
        if (isset($_SESSION["medico_risco_selecionado"])) {
            $valor_risco_selecionado_bind = $_SESSION["medico_risco_selecionado"];
        }


        // TREINAMENTOS
        // if (isset($_POST["valor_treinamentos"]) && $_POST["valor_treinamentos"] !== "") {
        //     $recebe_treinamento_selecionado = $_POST["valor_treinamentos"];

        //     if (!isset($_SESSION["medico_treinamento_selecionado"]) || $_SESSION["medico_treinamento_selecionado"] !== $recebe_treinamento_selecionado) {
        //         $_SESSION["medico_treinamento_selecionado"] = $recebe_treinamento_selecionado;
        //     }
        // }
        // $valor_treinamento_selecionado_bind = isset($_SESSION["medico_treinamento_selecionado"]) ? $_SESSION["medico_treinamento_selecionado"] : null;

        // TREINAMENTOS
        $valor_treinamento_selecionado_bind = null;
        if (isset($_POST["valor_treinamentos"])) {
            $recebe_treinamento_selecionado = $_POST["valor_treinamentos"] !== "" ? $_POST["valor_treinamentos"] : null;
            if (!isset($_SESSION["medico_treinamento_selecionado"]) || $_SESSION["medico_treinamento_selecionado"] !== $recebe_treinamento_selecionado) {
                $_SESSION["medico_treinamento_selecionado"] = $recebe_treinamento_selecionado;
            }
        }
        if (isset($_SESSION["medico_treinamento_selecionado"])) {
            $valor_treinamento_selecionado_bind = $_SESSION["medico_treinamento_selecionado"];
        }


        if (isset($_POST["valor_laudo_selecionado"]) && $_POST["valor_laudo_selecionado"] !== ""
        && isset($_POST["valor_selecionado"]) && $_POST["valor_selecionado"] !== "") {

            $valor_selecionado = $_POST["valor_selecionado"] !== "" ? $_POST["valor_selecionado"] : null;

            switch ($_POST["valor_laudo_selecionado"]) {
                case "insalubridade":
                    if (!isset($_SESSION["insalubridade_selecionado"]) || $_SESSION["insalubridade_selecionado"] !== $valor_selecionado) {
                        $_SESSION["insalubridade_selecionado"] = $valor_selecionado;
                    }
                    break;
                case "porcentagem":
                    if (!isset($_SESSION["porcentagem_selecionado"]) || $_SESSION["porcentagem_selecionado"] !== $valor_selecionado) {
                        $_SESSION["porcentagem_selecionado"] = $valor_selecionado;
                    }
                    break;
                case "periculosidade 30%":
                    if (!isset($_SESSION["periculosidade_selecionado"]) || $_SESSION["periculosidade_selecionado"] !== $valor_selecionado) {
                        $_SESSION["periculosidade_selecionado"] = $valor_selecionado;
                    }
                    break;
                case "aposent. especial":
                    if (!isset($_SESSION["aposentado_selecionado"]) || $_SESSION["aposentado_selecionado"] !== $valor_selecionado) {
                        $_SESSION["aposentado_selecionado"] = $valor_selecionado;
                    }
                    break;
                case "agente nocivo":
                    if (!isset($_SESSION["agente_nocivo_selecionado"]) || $_SESSION["agente_nocivo_selecionado"] !== $valor_selecionado) {
                        $_SESSION["agente_nocivo_selecionado"] = $valor_selecionado;
                    }
                    break;
                case "ocorrência gfip":
                    if (!isset($_SESSION["agente_ocorrencia_selecionado"]) || $_SESSION["agente_ocorrencia_selecionado"] !== $valor_selecionado) {
                        $_SESSION["agente_ocorrencia_selecionado"] = $valor_selecionado;
                    }
                    break;
            }
        }

        // Valores para bind
        $valor_insalubridade_selecionado_bind = $_SESSION["insalubridade_selecionado"] ?? null;
        $valor_porcentagem_selecionado_bind = $_SESSION["porcentagem_selecionado"] ?? null;
        $valor_periculosidade_selecionado_bind = $_SESSION["periculosidade_selecionado"] ?? null;
        $valor_aposentado_selecionado_bind = $_SESSION["aposentado_selecionado"] ?? null;
        $valor_agente_nocivo_selecionado_bind = $_SESSION["agente_nocivo_selecionado"] ?? null;
        $valor_ocorrencia_selecionado_bind = $_SESSION["agente_ocorrencia_selecionado"] ?? null;



        // if (
        //     isset($_POST["valor_laudo_selecionado"]) && $_POST["valor_laudo_selecionado"] !== ""
        //     && isset($_POST["valor_selecionado"]) && $_POST["valor_selecionado"] !== ""
        // ) {
        //     if ($_POST["valor_laudo_selecionado"] === "insalubridade") {
        //         if (!empty($_POST["valor_selecionado"]))
        //             $recebe_valor_insalubridade = $_POST["valor_selecionado"];
        //     } else if ($_POST["valor_laudo_selecionado"] === "porcentagem") {
        //         if (!empty($_POST["valor_selecionado"]))
        //             $recebe_valor_laudo = $_POST["valor_selecionado"];
        //     } else if ($_POST["valor_laudo_selecionado"] === "periculosidade 30%") {
        //         if (!empty($_POST["valor_laudo_selecionado"]))
        //             $recebe_valor_periculosidade = $_POST["valor_selecionado"];
        //     } else if ($_POST["valor_laudo_selecionado"] === "aposent. especial") {
        //         if (!empty($_POST["valor_laudo_selecionado"]))
        //             $recebe_valor_aposentado = $_POST["valor_selecionado"];
        //     } else if ($_POST["valor_laudo_selecionado"] === "agente nocivo") {
        //         if (!empty($_POST["valor_laudo_selecionado"]))
        //             $recebe_valor_agente = $_POST["valor_selecionado"];
        //     } else if ($_POST["valor_laudo_selecionado"] === "ocorrência gfip") {
        //         if (!empty($_POST["valor_laudo_selecionado"]))
        //             $recebe_valor_ocorrencia = $_POST["valor_selecionado"];
        //     }

        //     if (!empty($recebe_valor_insalubridade)) {
        //         if (!isset($_SESSION["insalubridade_selecionado"]) || $_SESSION["insalubridade_selecionado"] !== $recebe_valor_insalubridade) {
        //             $_SESSION["insalubridade_selecionado"] = $recebe_valor_insalubridade;
        //         }
        //     }

        //     if (!empty($recebe_valor_laudo)) {
        //         if (!isset($_SESSION["porcentagem_selecionado"]) || $_SESSION["porcentagem_selecionado"] !== $recebe_valor_laudo) {
        //             $_SESSION["porcentagem_selecionado"] = $recebe_valor_laudo;
        //         }
        //     }

        //     if (!empty($recebe_valor_periculosidade)) {
        //         if (!isset($_SESSION["periculosidade_selecionado"]) || $_SESSION["periculosidade_selecionado"] !== $recebe_valor_periculosidade) {
        //             $_SESSION["periculosidade_selecionado"] = $recebe_valor_periculosidade;
        //         }
        //     }

        //     if (!empty($recebe_valor_aposentado)) {
        //         if (!isset($_SESSION["aposentado_selecionado"]) || $_SESSION["aposentado_selecionado"] !== $recebe_valor_aposentado) {
        //             $_SESSION["aposentado_selecionado"] = $recebe_valor_aposentado;
        //         }
        //     }

        //     if (!empty($recebe_valor_agente)) {
        //         if (!isset($_SESSION["agente_nocivo_selecionado"]) || $_SESSION["agente_nocivo_selecionado"] !== $recebe_valor_agente) {
        //             $_SESSION["agente_nocivo_selecionado"] = $recebe_valor_agente;
        //         }
        //     }

        //     if (!empty($recebe_valor_ocorrencia)) {
        //         if (!isset($_SESSION["agente_ocorrencia_selecionado"]) || $_SESSION["agente_ocorrencia_selecionado"] !== $recebe_valor_ocorrencia) {
        //             $_SESSION["agente_ocorrencia_selecionado"] = $recebe_valor_ocorrencia;
        //         }
        //     }
        // }

        // $valor_insalubridade_selecionado_bind = isset($_SESSION["insalubridade_selecionado"]) ? $_SESSION["insalubridade_selecionado"] : null;
        // $valor_porcentagem_selecionado_bind = isset($_SESSION["porcentagem_selecionado"]) ? $_SESSION["porcentagem_selecionado"] : null;
        // $valor_periculosidade_selecionado_bind = isset($_SESSION["periculosidade_selecionado"]) ? $_SESSION["periculosidade_selecionado"] : null;
        // $valor_aposentado_selecionado_bind = isset($_SESSION["aposentado_selecionado"]) ? $_SESSION["aposentado_selecionado"] : null;
        // $valor_agente_nocivo_selecionado_bind = isset($_SESSION["agente_nocivo_selecionado"]) ? $_SESSION["agente_nocivo_selecionado"] : null;
        // $valor_ocorrencia_selecionado_bind = isset($_SESSION["agente_ocorrencia_selecionado"]) ? $_SESSION["agente_ocorrencia_selecionado"] : null;

        // // APTIDOES
        // if (isset($_POST["valor_aptidoes"]) && $_POST["valor_aptidoes"] !== "") {
        //     $recebe_aptidao_selecionado = $_POST["valor_aptidoes"];

        //     if (!isset($_SESSION["aptidao_selecionado"]) || $_SESSION["aptidao_selecionado"] !== $recebe_aptidao_selecionado) {
        //         $_SESSION["aptidao_selecionado"] = $recebe_aptidao_selecionado;
        //     }
        // }
        // $valor_aptidao_selecionado_bind = isset($_SESSION["aptidao_selecionado"]) ? $_SESSION["aptidao_selecionado"] : null;

        // APTIDOES
        $valor_aptidao_selecionado_bind = null; // garante que existe

        if (isset($_POST["valor_aptidoes"])) {
            // Se vier valor do POST, trata "" como null
            $recebe_aptidao_selecionado = $_POST["valor_aptidoes"] !== "" ? $_POST["valor_aptidoes"] : null;

            // Atualiza a sessão somente se o valor for diferente do atual
            if (!isset($_SESSION["aptidao_selecionado"]) || $_SESSION["aptidao_selecionado"] !== $recebe_aptidao_selecionado) {
                $_SESSION["aptidao_selecionado"] = $recebe_aptidao_selecionado;
            }
        }

        // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        if (isset($_SESSION["aptidao_selecionado"])) {
            $valor_aptidao_selecionado_bind = $_SESSION["aptidao_selecionado"];
        }

        // EXAMES SELECIONADOS
        // if (isset($_POST["valor_exames_selecionados"]) && $_POST["valor_exames_selecionados"] !== "") {
        //     $recebe_exames_selecionado = $_POST["valor_exames_selecionados"];

        //     if (!isset($_SESSION["exames_selecionado"]) || $_SESSION["exames_selecionado"] !== $recebe_exames_selecionado) {
        //         $_SESSION["exames_selecionado"] = $recebe_exames_selecionado;
        //     }
        // }
        // $valor_exames_selecionado_bind = isset($_SESSION["exames_selecionado"]) ? $_SESSION["exames_selecionado"] : null;

        // EXAMES SELECIONADOS
        $valor_exames_selecionado_bind = null; // garante que existe

        if (isset($_POST["valor_exames_selecionados"])) {
            // Se vier valor do POST, trata "" como null
            $recebe_exames_selecionado = $_POST["valor_exames_selecionados"] !== "" ? $_POST["valor_exames_selecionados"] : null;

            // Atualiza a sessão somente se o valor for diferente do atual
            if (!isset($_SESSION["exames_selecionado"]) || $_SESSION["exames_selecionado"] !== $recebe_exames_selecionado) {
                $_SESSION["exames_selecionado"] = $recebe_exames_selecionado;
            }
        }

        // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        if (isset($_SESSION["exames_selecionado"])) {
            $valor_exames_selecionado_bind = $_SESSION["exames_selecionado"];
        }
          


        //TIPO ORCAMENTO
        // if (isset($_POST["valor_tipo_orcamento"]) && $_POST["valor_tipo_orcamento"]) {
        //     $recebe_tipo_orcamento = $_POST["valor_tipo_orcamento"];

        //     if (!isset($_SESSION["tipo_orcamento"]) || $_SESSION["tipo_orcamento"] !== $recebe_tipo_orcamento) {
        //         $_SESSION["tipo_orcamento"] = $recebe_tipo_orcamento;
        //     }
        // }
        // $valor_tipo_orcamento_bind = isset($_SESSION["tipo_orcamento"]) ? $_SESSION["tipo_orcamento"] : null;


        //TIPO ORCAMENTO
        $valor_tipo_orcamento_bind = null; // garante que existe

        if (isset($_POST["valor_tipo_orcamento"])) {
            // Se vier valor do POST, trata "" como null
            $recebe_tipo_orcamento = $_POST["valor_tipo_orcamento"] !== "" ? $_POST["valor_tipo_orcamento"] : null;

            // Atualiza a sessão somente se o valor for diferente do atual
            if (!isset($_SESSION["tipo_orcamento"]) || $_SESSION["tipo_orcamento"] !== $recebe_tipo_orcamento) {
                $_SESSION["tipo_orcamento"] = $recebe_tipo_orcamento;
            }
        }

        // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        if (isset($_SESSION["tipo_orcamento"])) {
            $valor_tipo_orcamento_bind = $_SESSION["tipo_orcamento"];
        }

        
        // if(isset($_POST["valor_tipo_dado_bancario"]) && $_POST["valor_tipo_dado_bancario"])
        // {
        //     $recebe_tipo_dado_bancario = $_POST["valor_tipo_dado_bancario"];

        //     if(!isset($_SESSION["tipo_dado_bancario"]) || $_SESSION["tipo_dado_bancario"] !== $recebe_tipo_dado_bancario)
        //     {
        //         $_SESSION["tipo_dado_bancario"] = $recebe_tipo_dado_bancario;
        //     }
        // }
        // $valor_tipo_dado_bancario_bind = isset($_SESSION["tipo_dado_bancario"]) ? $_SESSION["tipo_dado_bancario"] : null;


        //TIPO DADO BANCARIO
        $valor_tipo_dado_bancario_bind = null; // garante que existe

        if (isset($_POST["valor_tipo_dado_bancario"])) {
            // Se vier valor do POST, trata "" como null
            $recebe_tipo_orcamento = $_POST["valor_tipo_dado_bancario"] !== "" ? $_POST["valor_tipo_dado_bancario"] : null;

            // Atualiza a sessão somente se o valor for diferente do atual
            if (!isset($_SESSION["tipo_dado_bancario"]) || $_SESSION["tipo_dado_bancario"] !== $recebe_tipo_orcamento) {
                $_SESSION["tipo_dado_bancario"] = $recebe_tipo_orcamento;
            }
        }

        // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        if (isset($_SESSION["tipo_dado_bancario"])) {
            $valor_tipo_dado_bancario_bind = $_SESSION["tipo_dado_bancario"];
        }

        // if(isset($_POST["valor_agencia_conta"]) && $_POST["valor_agencia_conta"])
        // {
        //     $recebe_agencia_conta = $_POST["valor_agencia_conta"];

        //     if(!isset($_SESSION["dado_bancario_agencia_conta"]) || $_SESSION["dado_bancario_agencia_conta"] !== $recebe_agencia_conta)
        //     {
        //         $_SESSION["dado_bancario_agencia_conta"] = $recebe_agencia_conta;
        //     }
        // }
        // $valor_dado_bancario_agencia_conta_bind = isset($_SESSION["dado_bancario_agencia_conta"]) ? $_SESSION["dado_bancario_agencia_conta"] : null;

        // Agência/Conta
        $valor_dado_bancario_agencia_conta_bind = null; // garante que existe

        if (isset($_POST["valor_agencia_conta"])) {
            // Se vier valor do POST, trata "" como null
            $recebe_agencia_conta = $_POST["valor_agencia_conta"] !== "" ? $_POST["valor_agencia_conta"] : null;

            // Atualiza a sessão somente se o valor for diferente do atual
            if (!isset($_SESSION["dado_bancario_agencia_conta"]) || $_SESSION["dado_bancario_agencia_conta"] !== $recebe_agencia_conta) {
                $_SESSION["dado_bancario_agencia_conta"] = $recebe_agencia_conta;
            }
        }

        // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        if (isset($_SESSION["dado_bancario_agencia_conta"])) {
            $valor_dado_bancario_agencia_conta_bind = $_SESSION["dado_bancario_agencia_conta"];
        }



        // if(isset($_POST["valor_pix"]) && $_POST["valor_pix"])
        // {
        //     $recebe_pix = $_POST["valor_pix"];

        //     if(!isset($_SESSION["dado_bancario_pix"]) || $_SESSION["dado_bancario_pix"] !== $recebe_pix)
        //     {
        //         $_SESSION["dado_bancario_pix"] = $recebe_pix;
        //     }
        // }
        // $valor_dado_bancario_pix_bind = isset($_SESSION["dado_bancario_pix"]) ? $_SESSION["dado_bancario_pix"] : null;

        // PIX
        $valor_dado_bancario_pix_bind = null; // garante que existe

        if (isset($_POST["valor_pix"])) {
            // Trata "" como null
            $recebe_pix = $_POST["valor_pix"] !== "" ? $_POST["valor_pix"] : null;

            // Atualiza a sessão somente se for diferente do valor atual
            if (!isset($_SESSION["dado_bancario_pix"]) || $_SESSION["dado_bancario_pix"] !== $recebe_pix) {
                $_SESSION["dado_bancario_pix"] = $recebe_pix;
            }
        }

        // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        if (isset($_SESSION["dado_bancario_pix"])) {
            $valor_dado_bancario_pix_bind = $_SESSION["dado_bancario_pix"];
        }


        //DOCUMENTO
        // if (isset($_POST["valor_documento"]) && $_POST["valor_documento"]) {
        //     $recebe_documento = $_POST["valor_documento"];

        //     if (!isset($_SESSION["documento"]) || $_SESSION["documento"] !== $recebe_documento) {
        //         $_SESSION["documento"] = $recebe_documento;
        //     }
        // }
        // $valor_documento_bind = isset($_SESSION["documento"]) ? $_SESSION["documento"] : null;


        // DOCUMENTO
        $valor_documento_bind = null; // garante que existe

        if (isset($_POST["valor_documento"])) {
            // Trata "" como null
            $recebe_documento = $_POST["valor_documento"] !== "" ? $_POST["valor_documento"] : null;

            // Atualiza a sessão somente se for diferente do valor atual
            if (!isset($_SESSION["documento"]) || $_SESSION["documento"] !== $recebe_documento) {
                $_SESSION["documento"] = $recebe_documento;
            }
        }

        // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        if (isset($_SESSION["documento"])) {
            $valor_documento_bind = $_SESSION["documento"];
        }


        //TOTAL
        // if (isset($_POST["valor_total"]) && $_POST["valor_total"]) {
        //     $recebe_total = $_POST["valor_total"];

        //     if (!isset($_SESSION["total"]) || $_SESSION["total"] !== $recebe_total) {
        //         $_SESSION["total"] = $recebe_total;
        //     }
        // }
        // $valor_total_bind = isset($_SESSION["total"]) ? $_SESSION["total"] : null;

        // TOTAL
        $valor_total_bind = null; // garante que existe

        if (isset($_POST["valor_total"])) {
            // Trata "" como null
            $recebe_total = $_POST["valor_total"] !== "" ? $_POST["valor_total"] : null;

            // Atualiza a sessão somente se for diferente do valor atual
            if (!isset($_SESSION["total"]) || $_SESSION["total"] !== $recebe_total) {
                $_SESSION["total"] = $recebe_total;
            }
        }

        // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        if (isset($_SESSION["total"])) {
            $valor_total_bind = $_SESSION["total"];
        }


        $recebe_status_kit_bind = "RASCUNHO";
        //FINALIZACAO

        if(isset($_POST["requer_assinatura"]) && $_POST["requer_assinatura"])
        {
            $recebe_requer_assinatura = isset($_POST["requer_assinatura"]) ? $_POST["requer_assinatura"] : null;

            // Converte para booleano de forma segura
            $recebe_bool_requer_assinatura = filter_var($recebe_requer_assinatura, FILTER_VALIDATE_BOOLEAN);

            // Agora trata como Sim / Nao
            $recebe_final_requer_assinatura = $recebe_bool_requer_assinatura ? "Sim" : "Nao";

            // Atualiza sessão somente se não existir ainda ou se já existir
            if (!isset($_SESSION["assinatura"]) || $_SESSION["assinatura"]) {
                $_SESSION["assinatura"] = $recebe_final_requer_assinatura;
            }

        }

        // ASSINATURA
        $valor_assinatura_bind = null; // garante que existe

        if (isset($_POST["requer_assinatura"])) {
            // Trata "" como null
            $recebe_requer_assinatura = $_POST["requer_assinatura"] !== "" ? $_POST["requer_assinatura"] : null;

            // Converte para booleano de forma segura
            $recebe_bool_requer_assinatura = filter_var($recebe_requer_assinatura, FILTER_VALIDATE_BOOLEAN);

            // Agora trata como Sim / Nao
            $recebe_final_requer_assinatura = $recebe_bool_requer_assinatura ? "Sim" : "Nao";

            // Atualiza a sessão somente se for diferente do valor atual
            if (!isset($_SESSION["assinatura"]) || $_SESSION["assinatura"] !== $recebe_requer_assinatura) {
                $_SESSION["assinatura"] = $recebe_final_requer_assinatura;
            }
        }

        $valor_assinatura_bind = isset($_SESSION["assinatura"]) ? $_SESSION["assinatura"] : null;


        if (isset($_POST["valor_finalizamento"]) && $_POST["valor_finalizamento"]) {
            $recebe_status_kit_bind = "FINALIZADO";
        }


        // function gerar_pdf_basico()
        // {
        //     // Cria a instância do Dompdf
        //     $dompdf = new Dompdf();
        //     // HTML que será convertido para PDF
        //     $html = "
        //         <html>
        //         <head>
        //         <meta charset='UTF-8'>
        //         <title>PDF com Dompdf</title>
        //         </head>
        //         <body>
        //         <h1 style='text-align: center;'>Promais Informações</h1>
        //         <p style='text-align: center;'>Este é um PDF básico gerado usando Dompdf e PHP puro.</p>
        //         </body>
        //         </html>
        //         ";

        //     $options = new Options();

        //     $dompdf = new Dompdf(['enable_remote' => true]);

        //     // Carrega o HTML no Dompdf
        //     $dompdf->loadHtml($html);

        //     // Define tamanho e orientação do papel
        //     $dompdf->setPaper('A4', 'portrait');

        //     // Renderiza o PDF
        //     $dompdf->render();

        //     // Envia o PDF para o navegador
        //     $dompdf->stream("promais_informacoes.pdf", ["Attachment" => false]);
        // }   


        if (isset($_POST['acao']) && $_POST['acao'] === 'gerar_pdf') {
            // gerar_pdf_basico();
        }

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
        exames_selecionados = :recebe_exames_selecionado,
        tipo_dado_bancario = :recebe_tipo_dado_bancario_selecionado,
        dado_bancario_agencia_conta = :recebe_dado_bancario_agencia_conta_selecionado,
        dado_bancario_pix = :recebe_dado_bancario_pix_selecionado,
        assinatura_digital = :recebe_assinatura_digital_selecionada,
        tipo_orcamento = :recebe_tipo_orcamento_selecionado,
        modelos_selecionados = :recebe_documentos_selecionado,
        valor_total = :recebe_total,
        status = :recebe_status_kit
    WHERE id = :recebe_kit_id";

        $comando_atualizar_kit = $pdo->prepare($instrucao_atualizar_kit);

        // Binds
        // $comando_atualizar_kit->bindValue(":recebe_tipo_exame",   $valor_exame_bind,      $valor_exame_bind      === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame_bind, $valor_exame_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_empresa_id",   $valor_empresa_bind,    $valor_empresa_bind    === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_empresa_id", $valor_empresa_bind, $valor_empresa_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_clinica_id",   $valor_clinica_bind,    $valor_clinica_bind    === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_clinica_id", $valor_clinica_bind, $valor_clinica_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_pessoa_id",    $valor_colaborador_bind, $valor_colaborador_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_pessoa_id", $valor_colaborador_bind, $valor_colaborador_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_cargo_id",     $valor_cargo_bind,      $valor_cargo_bind      === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_cargo_id", $valor_cargo_bind, $valor_cargo_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_motorista",    $valor_motorista_bind,  $valor_motorista_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_motorista", $valor_motorista_bind, $valor_motorista_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_medico_coordenador_id",    $valor_medico_coordenador_bind,  $valor_medico_coordenador_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_medico_coordenador_id", $valor_medico_coordenador_bind, $valor_medico_coordenador_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id",    $valor_medico_clinica_bind,  $valor_medico_clinica_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id", $valor_medico_clinica_bind, $valor_medico_clinica_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados",    $valor_risco_selecionado_bind,  $valor_risco_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados", $valor_risco_selecionado_bind, $valor_risco_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_treinamentos_selecionados",    $valor_treinamento_selecionado_bind,  $valor_treinamento_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_treinamentos_selecionados", $valor_treinamento_selecionado_bind, $valor_treinamento_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_insalubridade_selecionado",    $valor_insalubridade_selecionado_bind,  $valor_insalubridade_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_insalubridade_selecionado", $valor_insalubridade_selecionado_bind, $valor_insalubridade_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_porcentagem_selecionado",    $valor_porcentagem_selecionado_bind,  $valor_porcentagem_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_porcentagem_selecionado", $valor_porcentagem_selecionado_bind, $valor_porcentagem_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_periculosidade_selecionado",    $valor_periculosidade_selecionado_bind,  $valor_periculosidade_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_periculosidade_selecionado", $valor_periculosidade_selecionado_bind, $valor_periculosidade_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_aposentado_especial_selecionado",    $valor_aposentado_selecionado_bind,  $valor_aposentado_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_aposentado_especial_selecionado", $valor_aposentado_selecionado_bind, $valor_aposentado_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_agente_nocivo_selecionado",    $valor_agente_nocivo_selecionado_bind,  $valor_agente_nocivo_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_agente_nocivo_selecionado", $valor_agente_nocivo_selecionado_bind, $valor_agente_nocivo_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_ocorrencia_gfip_selecionado",    $valor_ocorrencia_selecionado_bind,  $valor_ocorrencia_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(":recebe_ocorrencia_gfip_selecionado", $valor_ocorrencia_selecionado_bind, $valor_ocorrencia_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // $comando_atualizar_kit->bindValue(":recebe_aptidao_selecionado",    $valor_aptidao_selecionado_bind,  $valor_aptidao_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(
          ":recebe_aptidao_selecionado",
            $valor_aptidao_selecionado_bind,
            $valor_aptidao_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        // $comando_atualizar_kit->bindValue(":recebe_exames_selecionado",    $valor_exames_selecionado_bind,  $valor_exames_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(
            ":recebe_exames_selecionado",
            $valor_exames_selecionado_bind,
            $valor_exames_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        // $comando_atualizar_kit->bindValue(":recebe_tipo_dado_bancario_selecionado",    $valor_tipo_dado_bancario_bind,  $valor_tipo_dado_bancario_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(
            ":recebe_tipo_dado_bancario_selecionado",
            $valor_tipo_dado_bancario_bind,
            $valor_tipo_dado_bancario_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        // Bind no PDO
        $comando_atualizar_kit->bindValue(
            ":recebe_dado_bancario_agencia_conta_selecionado",
            $valor_dado_bancario_agencia_conta_bind,
            $valor_dado_bancario_agencia_conta_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        $comando_atualizar_kit->bindValue(
            ":recebe_dado_bancario_pix_selecionado",
            $valor_dado_bancario_pix_bind,
            $valor_dado_bancario_pix_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );
        $comando_atualizar_kit->bindValue(":recebe_assinatura_digital_selecionada",    $valor_assinatura_bind,  $valor_assinatura_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_tipo_orcamento_selecionado",    $valor_tipo_orcamento_bind,  $valor_tipo_orcamento_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(
            ":recebe_tipo_orcamento_selecionado",
            $valor_tipo_orcamento_bind,
            $valor_tipo_orcamento_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        // $comando_atualizar_kit->bindValue(":recebe_documentos_selecionado",    $valor_documento_bind,  $valor_documento_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(
            ":recebe_documentos_selecionado",
            $valor_documento_bind,
            $valor_documento_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        // $comando_atualizar_kit->bindValue(":recebe_total",    $valor_total_bind,  $valor_total_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $comando_atualizar_kit->bindValue(
            ":recebe_total",
            $valor_total_bind,
            $valor_total_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        $comando_atualizar_kit->bindValue(":recebe_status_kit",    $recebe_status_kit_bind,  $recebe_status_kit_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // Kit ID
        $comando_atualizar_kit->bindValue(":recebe_kit_id", $_SESSION["codigo_kit"], PDO::PARAM_INT);

        // Executa
        $resultado_atualizar_kit = $comando_atualizar_kit->execute();

        if ($resultado_atualizar_kit) {
            echo json_encode("KIT atualizado com sucesso");
        } else {
            echo json_encode("KIT não foi atualizado com sucesso");
        }
    }else if($recebe_processo_geracao_kit === "atualizar_kit")
    {
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

        //TIPO ORCAMENTO
        if (isset($_POST["valor_tipo_orcamento"]) && $_POST["valor_tipo_orcamento"]) {
            $recebe_tipo_orcamento = $_POST["valor_tipo_orcamento"];

            if (!isset($_SESSION["tipo_orcamento"]) || $_SESSION["tipo_orcamento"] !== $recebe_tipo_orcamento) {
                $_SESSION["tipo_orcamento"] = $recebe_tipo_orcamento;
            }
        }
        $valor_tipo_orcamento_bind = isset($_SESSION["tipo_orcamento"]) ? $_SESSION["tipo_orcamento"] : null;

        if(isset($_POST["valor_tipo_dado_bancario"]) && $_POST["valor_tipo_dado_bancario"])
        {
            $recebe_tipo_dado_bancario = $_POST["valor_tipo_dado_bancario"];

            if(!isset($_SESSION["tipo_dado_bancario"]) || $_SESSION["tipo_dado_bancario"] !== $recebe_tipo_dado_bancario)
            {
                $_SESSION["tipo_dado_bancario"] = $recebe_tipo_dado_bancario;
            }
        }
        $valor_tipo_dado_bancario_bind = isset($_SESSION["tipo_dado_bancario"]) ? $_SESSION["tipo_dado_bancario"] : null;

        // if(isset($_POST["valor_agencia_conta"]) && $_POST["valor_agencia_conta"])
        // {
        //     $recebe_agencia_conta = $_POST["valor_agencia_conta"];

        //     if(!isset($_SESSION["dado_bancario_agencia_conta"]) || $_SESSION["dado_bancario_agencia_conta"] !== $recebe_agencia_conta)
        //     {
        //         $_SESSION["dado_bancario_agencia_conta"] = $recebe_agencia_conta;
        //     }
        // }
        // $valor_dado_bancario_agencia_conta_bind = isset($_SESSION["dado_bancario_agencia_conta"]) ? $_SESSION["dado_bancario_agencia_conta"] : null;

        // Agência/Conta
        $valor_dado_bancario_agencia_conta_bind = null; // garante que existe

if (isset($_POST["valor_agencia_conta"])) {
    // Se vier valor do POST, trata "" como null
    $recebe_agencia_conta = $_POST["valor_agencia_conta"] !== "" ? $_POST["valor_agencia_conta"] : null;

    // Atualiza a sessão somente se o valor for diferente do atual
    if (!isset($_SESSION["dado_bancario_agencia_conta"]) || $_SESSION["dado_bancario_agencia_conta"] !== $recebe_agencia_conta) {
        $_SESSION["dado_bancario_agencia_conta"] = $recebe_agencia_conta;
    }
}

// Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
if (isset($_SESSION["dado_bancario_agencia_conta"])) {
    $valor_dado_bancario_agencia_conta_bind = $_SESSION["dado_bancario_agencia_conta"];
}

        // if(isset($_POST["valor_pix"]) && $_POST["valor_pix"])
        // {
        //     $recebe_pix = $_POST["valor_pix"];

        //     if(!isset($_SESSION["dado_bancario_pix"]) || $_SESSION["dado_bancario_pix"] !== $recebe_pix)
        //     {
        //         $_SESSION["dado_bancario_pix"] = $recebe_pix;
        //     }
        // }
        // $valor_dado_bancario_pix_bind = isset($_SESSION["dado_bancario_pix"]) ? $_SESSION["dado_bancario_pix"] : null;

        // PIX
        $valor_dado_bancario_pix_bind = null; // garante que existe

if (isset($_POST["valor_pix"])) {
    // Trata "" como null
    $recebe_pix = $_POST["valor_pix"] !== "" ? $_POST["valor_pix"] : null;

    // Atualiza a sessão somente se for diferente do valor atual
    if (!isset($_SESSION["dado_bancario_pix"]) || $_SESSION["dado_bancario_pix"] !== $recebe_pix) {
        $_SESSION["dado_bancario_pix"] = $recebe_pix;
    }
}

// Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
if (isset($_SESSION["dado_bancario_pix"])) {
    $valor_dado_bancario_pix_bind = $_SESSION["dado_bancario_pix"];
}


        //DOCUMENTO
        if (isset($_POST["valor_documento"]) && $_POST["valor_documento"]) {
            $recebe_documento = $_POST["valor_documento"];

            if (!isset($_SESSION["documento"]) || $_SESSION["documento"] !== $recebe_documento) {
                $_SESSION["documento"] = $recebe_documento;
            }
        }
        $valor_documento_bind = isset($_SESSION["documento"]) ? $_SESSION["documento"] : null;

        //TOTAL
        if (isset($_POST["valor_total"]) && $_POST["valor_total"]) {
            $recebe_total = $_POST["valor_total"];

            if (!isset($_SESSION["total"]) || $_SESSION["total"] !== $recebe_total) {
                $_SESSION["total"] = $recebe_total;
            }
        }
        $valor_total_bind = isset($_SESSION["total"]) ? $_SESSION["total"] : null;

        $recebe_status_kit_bind = "RASCUNHO";
        //FINALIZACAO

        if(isset($_POST["requer_assinatura"]) && $_POST["requer_assinatura"])
        {
            $recebe_requer_assinatura = isset($_POST["requer_assinatura"]) ? $_POST["requer_assinatura"] : null;

            // Converte para booleano de forma segura
            $recebe_bool_requer_assinatura = filter_var($recebe_requer_assinatura, FILTER_VALIDATE_BOOLEAN);

            // Agora trata como Sim / Nao
            $recebe_final_requer_assinatura = $recebe_bool_requer_assinatura ? "Sim" : "Nao";

            // Atualiza sessão somente se não existir ainda ou se já existir
            if (!isset($_SESSION["assinatura"]) || $_SESSION["assinatura"]) {
                $_SESSION["assinatura"] = $recebe_final_requer_assinatura;
            }

        }

        $valor_assinatura_bind = isset($_SESSION["assinatura"]) ? $_SESSION["assinatura"] : null;

        if (isset($_POST["valor_finalizamento"]) && $_POST["valor_finalizamento"]) {
            $recebe_status_kit_bind = "FINALIZADO";
        }


        // function gerar_pdf_basico()
        // {
        //     // Cria a instância do Dompdf
        //     $dompdf = new Dompdf();
        //     // HTML que será convertido para PDF
        //     $html = "
        //         <html>
        //         <head>
        //         <meta charset='UTF-8'>
        //         <title>PDF com Dompdf</title>
        //         </head>
        //         <body>
        //         <h1 style='text-align: center;'>Promais Informações</h1>
        //         <p style='text-align: center;'>Este é um PDF básico gerado usando Dompdf e PHP puro.</p>
        //         </body>
        //         </html>
        //         ";

        //     $options = new Options();

        //     $dompdf = new Dompdf(['enable_remote' => true]);

        //     // Carrega o HTML no Dompdf
        //     $dompdf->loadHtml($html);

        //     // Define tamanho e orientação do papel
        //     $dompdf->setPaper('A4', 'portrait');

        //     // Renderiza o PDF
        //     $dompdf->render();

        //     // Envia o PDF para o navegador
        //     $dompdf->stream("promais_informacoes.pdf", ["Attachment" => false]);
        // }   


        if (isset($_POST['acao']) && $_POST['acao'] === 'gerar_pdf') {
            // gerar_pdf_basico();
        }

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
        exames_selecionados = :recebe_exames_selecionado,
        tipo_dado_bancario = :recebe_tipo_dado_bancario_selecionado,
        dado_bancario_agencia_conta = :recebe_dado_bancario_agencia_conta_selecionado,
        dado_bancario_pix = :recebe_dado_bancario_pix_selecionado,
        assinatura_digital = :recebe_assinatura_digital_selecionada,
        tipo_orcamento = :recebe_tipo_orcamento_selecionado,
        modelos_selecionados = :recebe_documentos_selecionado,
        valor_total = :recebe_total,
        status = :recebe_status_kit
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
        $comando_atualizar_kit->bindValue(":recebe_tipo_dado_bancario_selecionado",    $valor_tipo_dado_bancario_bind,  $valor_tipo_dado_bancario_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        // Bind no PDO
        $comando_atualizar_kit->bindValue(
            ":recebe_dado_bancario_agencia_conta_selecionado",
            $valor_dado_bancario_agencia_conta_bind,
            $valor_dado_bancario_agencia_conta_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );

        $comando_atualizar_kit->bindValue(
            ":recebe_dado_bancario_pix_selecionado",
            $valor_dado_bancario_pix_bind,
            $valor_dado_bancario_pix_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );
        $comando_atualizar_kit->bindValue(":recebe_assinatura_digital_selecionada",    $valor_assinatura_bind,  $valor_assinatura_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_tipo_orcamento_selecionado",    $valor_tipo_orcamento_bind,  $valor_tipo_orcamento_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_documentos_selecionado",    $valor_documento_bind,  $valor_documento_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_total",    $valor_total_bind,  $valor_total_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $comando_atualizar_kit->bindValue(":recebe_status_kit",    $recebe_status_kit_bind,  $recebe_status_kit_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // Kit ID
        // Verifica se o GET possui valor
        if (isset($_POST['valor_id_kit']) && !empty($_POST['valor_id_kit'])) {
            $valor_id_kit = $_POST['valor_id_kit'];

            // Aqui você pode usar no bindValue
            $comando_atualizar_kit->bindValue(":recebe_kit_id", $valor_id_kit, PDO::PARAM_INT);

            // Executa o comando
            $comando_atualizar_kit->execute();
        } else {
            // Tratar caso não tenha valor
            echo "O valor do kit não foi informado.";
            exit;
        }

        // Executa
        $resultado_atualizar_kit = $comando_atualizar_kit->execute();

        if ($resultado_atualizar_kit) {
            echo json_encode("KIT atualizado com sucesso");
        } else {
            echo json_encode("KIT não foi atualizado com sucesso");
        }
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_geracao_kit = $_GET["processo_geracao_kit"];

    if($recebe_processo_geracao_kit === "buscar_kits_empresa")
    {
        $instrucao_busca_kits_empresa = "select * from kits where empresa_id_principal = :recebe_empresa_id and pessoa_id = :recebe_pessoa_id";
        $comando_busca_kits_empresa = $pdo->prepare($instrucao_busca_kits_empresa);
        $comando_busca_kits_empresa->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_kits_empresa->bindValue(":recebe_pessoa_id",$_GET["valor_pessoa_id"]);
        $comando_busca_kits_empresa->execute();
        $resultado_busca_kits_empresa = $comando_busca_kits_empresa->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_kits_empresa);
    }else if($recebe_processo_geracao_kit === "buscar_empresa_pessoa")
    {
        $instrucao_busca_empresa_pessoa = "select * from empresas_novas where id = :recebe_id_empresa";
        $comando_busca_empresa_pessoa = $pdo->prepare($instrucao_busca_empresa_pessoa);
        $comando_busca_empresa_pessoa->bindValue(":recebe_id_empresa",$_GET["valor_id_empresa"]);
        $comando_busca_empresa_pessoa->execute();
        $resultado_busca_empresa_pessoa = $comando_busca_empresa_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_empresa_pessoa);
    }else if($recebe_processo_geracao_kit === "busca_clinica_pessoa")
    {
        $instrucao_busca_clinica_pessoa = "select * from clinicas where id = :recebe_id_clinica";
        $comando_busca_clinica_pessoa = $pdo->prepare($instrucao_busca_clinica_pessoa);
        $comando_busca_clinica_pessoa->bindValue(":recebe_id_clinica",$_GET["valor_id_clinica"]);
        $comando_busca_clinica_pessoa->execute();
        $resultado_busca_clinica_pessoa = $comando_busca_clinica_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_clinica_pessoa);
    }else if($recebe_processo_geracao_kit === "busca_pessoa")
    {
        $instrucao_busca_pessoa = "select * from pessoas where id = :recebe_id_pessoa";
        $comando_busca_pessoa = $pdo->prepare($instrucao_busca_pessoa);
        $comando_busca_pessoa->bindValue(":recebe_id_pessoa",$_GET["valor_id_pessoa"]);
        $comando_busca_pessoa->execute();
        $resultado_busca_pessoa = $comando_busca_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoa);
    }else if($recebe_processo_geracao_kit === "buscar_kit")
    {
        $instrucao_busca_kit_especifico = "select * from kits where id = :recebe_id_kit";
        $comando_busca_kit_especifico = $pdo->prepare($instrucao_busca_kit_especifico);
        $comando_busca_kit_especifico->bindValue(":recebe_id_kit",$_GET["valor_id_kit"]);
        $comando_busca_kit_especifico->execute();
        $resultado_busca_kit_especifico = $comando_busca_kit_especifico->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_kit_especifico);
    }else if($recebe_processo_geracao_kit === "buscar_cargo")
    {
        $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
        $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
        $comando_busca_cargo->bindValue(":recebe_id_cargo",$_GET["valor_id_cargo"]);
        $comando_busca_cargo->execute();
        $resultado_busca_cargo = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cargo);
    }else if($recebe_processo_geracao_kit === "buscar_medico_coordenador")
    {
        $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
        $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
        $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador",$_GET["valor_id_medico_coordenador"]);
        $comando_busca_medico_coordenador->execute();
        $resultado_busca_medico_coordenador = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medico_coordenador);
    }else if($recebe_processo_geracao_kit === "busca_medico_examinador")
    {
        $instrucao_busca_medico_examinador = "select medico_id from medicos_clinicas where id = :recebe_id_medico_examinador";
        $comando_busca_medico_examinador = $pdo->prepare($instrucao_busca_medico_examinador);
        $comando_busca_medico_examinador->bindValue(":recebe_id_medico_examinador",$_GET["valor_id_medico_examinador"]);
        $comando_busca_medico_examinador->execute();
        $resultado_busca_medico_examinador = $comando_busca_medico_examinador->fetch(PDO::FETCH_ASSOC);

        if($resultado_busca_medico_examinador)
        {
            $instrucao_busca_medico_examinador_dados = "select * from medicos where id = :recebe_id_medico_examinador";
            $comando_busca_medico_examinador_dados = $pdo->prepare($instrucao_busca_medico_examinador_dados);
            $comando_busca_medico_examinador_dados->bindValue(":recebe_id_medico_examinador",$resultado_busca_medico_examinador["medico_id"]);
            $comando_busca_medico_examinador_dados->execute();
            $resultado_busca_medico_examinador_dados = $comando_busca_medico_examinador_dados->fetch(PDO::FETCH_ASSOC);
            echo json_encode($resultado_busca_medico_examinador_dados);
        }else{
            echo json_encode("");
        }
    }else if($recebe_processo_geracao_kit === "busca_produtos")
    {
        $instrucao_busca_produto = "select * from produto where id_kit = :recebe_id_kit_produto";
        $comando_busca_produto = $pdo->prepare($instrucao_busca_produto);
        $comando_busca_produto->bindValue(":recebe_id_kit_produto",$_GET["valor_id_kit_produtos"]);
        $comando_busca_produto->execute();
        $resultado_busca_produto = $comando_busca_produto->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_produto);
    }else if($recebe_processo_geracao_kit === "buscar_empresa_kit")
    {
        $instrucao_busca_empresa_pessoa = "select * from empresas_novas where id = :recebe_id_empresa";
        $comando_busca_empresa_pessoa = $pdo->prepare($instrucao_busca_empresa_pessoa);
        $comando_busca_empresa_pessoa->bindValue(":recebe_id_empresa",$_GET["valor_id_empresa_kit"]);
        $comando_busca_empresa_pessoa->execute();
        $resultado_busca_empresa_pessoa = $comando_busca_empresa_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_empresa_pessoa);
    }else if($recebe_processo_geracao_kit === "busca_clinica_kit")
    {
        $instrucao_busca_clinica_pessoa = "select * from clinicas where id = :recebe_id_clinica";
        $comando_busca_clinica_pessoa = $pdo->prepare($instrucao_busca_clinica_pessoa);
        $comando_busca_clinica_pessoa->bindValue(":recebe_id_clinica",$_GET["valor_id_clinica_kit"]);
        $comando_busca_clinica_pessoa->execute();
        $resultado_busca_clinica_pessoa = $comando_busca_clinica_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_clinica_pessoa);
    }else if($recebe_processo_geracao_kit === "busca_pessoa_kit")
    {
        $instrucao_busca_pessoa = "select * from pessoas where id = :recebe_id_pessoa";
        $comando_busca_pessoa = $pdo->prepare($instrucao_busca_pessoa);
        $comando_busca_pessoa->bindValue(":recebe_id_pessoa",$_GET["valor_id_pessoa_kit"]);
        $comando_busca_pessoa->execute();
        $resultado_busca_pessoa = $comando_busca_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoa);
    }else if($recebe_processo_geracao_kit === "busca_cargo_kit")
    {
        $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
        $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
        $comando_busca_cargo->bindValue(":recebe_id_cargo",$_GET["valor_id_cargo_kit"]);
        $comando_busca_cargo->execute();
        $resultado_busca_cargo = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cargo);
    }else if($recebe_processo_geracao_kit === "buscar_medico_coordenador_kit")
    {
        $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
        $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
        $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador",$_GET["valor_id_medico_coordenador_kit"]);
        $comando_busca_medico_coordenador->execute();
        $resultado_busca_medico_coordenador = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medico_coordenador);
    }else if($recebe_processo_geracao_kit === "busca_medico_examinador_kit")
    {
        $instrucao_busca_medico_examinador = "select medico_id from medicos_clinicas where id = :recebe_id_medico_examinador";
        $comando_busca_medico_examinador = $pdo->prepare($instrucao_busca_medico_examinador);
        $comando_busca_medico_examinador->bindValue(":recebe_id_medico_examinador",$_GET["valor_id_medico_examinador_kit"]);
        $comando_busca_medico_examinador->execute();
        $resultado_busca_medico_examinador = $comando_busca_medico_examinador->fetch(PDO::FETCH_ASSOC);

        if($resultado_busca_medico_examinador)
        {
            $instrucao_busca_medico_examinador_dados = "select * from medicos where id = :recebe_id_medico_examinador";
            $comando_busca_medico_examinador_dados = $pdo->prepare($instrucao_busca_medico_examinador_dados);
            $comando_busca_medico_examinador_dados->bindValue(":recebe_id_medico_examinador",$resultado_busca_medico_examinador["medico_id"]);
            $comando_busca_medico_examinador_dados->execute();
            $resultado_busca_medico_examinador_dados = $comando_busca_medico_examinador_dados->fetch(PDO::FETCH_ASSOC);
            echo json_encode($resultado_busca_medico_examinador_dados);
        }else{
            echo json_encode("");
        }
    }else if($recebe_processo_geracao_kit === "buscar_cargo_kit")
    {
        $instrucao_busca_pessoa = "select * from cargo where id_pessoa = :recebe_id_pessoa";
        $comando_busca_pessoa = $pdo->prepare($instrucao_busca_pessoa);
        $comando_busca_pessoa->bindValue(":recebe_id_pessoa",$_GET["valor_id_cargo_kit"]);
        $comando_busca_pessoa->execute();
        $resultado_busca_pessoa = $comando_busca_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoa);
    }else if($recebe_processo_geracao_kit === "buscar_empresa_primeiro_kit")
    {
        echo json_encode($_SESSION["empresa_id"]);
    }
}
?>