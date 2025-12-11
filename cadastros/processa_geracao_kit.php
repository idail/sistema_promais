<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

// Se instalou via Composer
require(__DIR__ . "/../vendor/autoload.php");

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
            "exames_selecionado",
            "assinatura",
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
        // $valor_exame_bind = null;
        // if (isset($_POST["valor_exame"])) {
        //     $recebe_exame_selecionado = $_POST["valor_exame"] !== "" ? $_POST["valor_exame"] : null;
        //     if (!isset($_SESSION["exame_selecionado"]) || $_SESSION["exame_selecionado"] !== $recebe_exame_selecionado) {
        //         $_SESSION["exame_selecionado"] = $recebe_exame_selecionado;
        //     }
        // }
        // if (isset($_SESSION["exame_selecionado"])) {
        //     $valor_exame_bind = $_SESSION["exame_selecionado"];
        // }




        // // EMPRESA
        // $valor_empresa_bind = null;
        // if (isset($_POST["valor_empresa"])) {
        //     $recebe_empresa_selecionado = $_POST["valor_empresa"] !== "" ? $_POST["valor_empresa"] : null;
        //     if (!isset($_SESSION["empresa_selecionado"]) || $_SESSION["empresa_selecionado"] !== $recebe_empresa_selecionado) {
        //         $_SESSION["empresa_selecionado"] = $recebe_empresa_selecionado;
        //     }
        // }
        // if (isset($_SESSION["empresa_selecionado"])) {
        //     $valor_empresa_bind = $_SESSION["empresa_selecionado"];
        // }




        // // CLÍNICA
        // $valor_clinica_bind = null;
        // if (isset($_POST["valor_clinica"])) {
        //     $recebe_clinica_selecionado = $_POST["valor_clinica"] !== "" ? $_POST["valor_clinica"] : null;
        //     if (!isset($_SESSION["clinica_selecionado"]) || $_SESSION["clinica_selecionado"] !== $recebe_clinica_selecionado) {
        //         $_SESSION["clinica_selecionado"] = $recebe_clinica_selecionado;
        //     }
        // }
        // if (isset($_SESSION["clinica_selecionado"])) {
        //     $valor_clinica_bind = $_SESSION["clinica_selecionado"];
        // }




        // // COLABORADOR
        // $valor_colaborador_bind = null;
        // if (isset($_POST["valor_colaborador"])) {
        //     $recebe_colaborador_selecionado = $_POST["valor_colaborador"] !== "" ? $_POST["valor_colaborador"] : null;
        //     if (!isset($_SESSION["colaborador_selecionado"]) || $_SESSION["colaborador_selecionado"] !== $recebe_colaborador_selecionado) {
        //         $_SESSION["colaborador_selecionado"] = $recebe_colaborador_selecionado;
        //     }
        // }
        // if (isset($_SESSION["colaborador_selecionado"])) {
        //     $valor_colaborador_bind = $_SESSION["colaborador_selecionado"];
        // }




        // // CARGO
        // $valor_cargo_bind = null;
        // if (isset($_POST["valor_cargo"])) {
        //     $recebe_cargo_selecionado = $_POST["valor_cargo"] !== "" ? $_POST["valor_cargo"] : null;
        //     if (!isset($_SESSION["cargo_selecionado"]) || $_SESSION["cargo_selecionado"] !== $recebe_cargo_selecionado) {
        //         $_SESSION["cargo_selecionado"] = $recebe_cargo_selecionado;
        //     }
        // }
        // if (isset($_SESSION["cargo_selecionado"])) {
        //     $valor_cargo_bind = $_SESSION["cargo_selecionado"];
        // }





        // // MOTORISTA
        // $valor_motorista_bind = null;
        // if (isset($_POST["valor_motorista"])) {
        //     $recebe_motorista_selecionado = $_POST["valor_motorista"] !== "" ? $_POST["valor_motorista"] : null;
        //     if (!isset($_SESSION["motorista_selecionado"]) || $_SESSION["motorista_selecionado"] !== $recebe_motorista_selecionado) {
        //         $_SESSION["motorista_selecionado"] = $recebe_motorista_selecionado;
        //     }
        // }

        // if (isset($_SESSION["motorista_selecionado"])) {
        //     $valor_motorista_bind = $_SESSION["motorista_selecionado"];
        // }





        // // MÉDICO COORDENADOR
        // $valor_medico_coordenador_bind = null;
        // if (isset($_POST["valor_medico_coordenador_id"])) {
        //     $recebe_medico_coordenador_selecionado = $_POST["valor_medico_coordenador_id"] !== "" ? $_POST["valor_medico_coordenador_id"] : null;
        //     if (!isset($_SESSION["medico_coordenador_selecionado"]) || $_SESSION["medico_coordenador_selecionado"] !== $recebe_medico_coordenador_selecionado) {
        //         $_SESSION["medico_coordenador_selecionado"] = $recebe_medico_coordenador_selecionado;
        //     }
        // }
        // if (isset($_SESSION["medico_coordenador_selecionado"])) {
        //     $valor_medico_coordenador_bind = $_SESSION["medico_coordenador_selecionado"];
        // }





        // // MÉDICO CLÍNICA
        // $valor_medico_clinica_bind = null;
        // if (isset($_POST["valor_medico_clinica_id"])) {
        //     $recebe_medico_clinica_selecionado = $_POST["valor_medico_clinica_id"] !== "" ? $_POST["valor_medico_clinica_id"] : null;
        //     if (!isset($_SESSION["medico_clinica_selecionado"]) || $_SESSION["medico_clinica_selecionado"] !== $recebe_medico_clinica_selecionado) {
        //         $_SESSION["medico_clinica_selecionado"] = $recebe_medico_clinica_selecionado;
        //     }
        // }
        // if (isset($_SESSION["medico_clinica_selecionado"])) {
        //     $valor_medico_clinica_bind = $_SESSION["medico_clinica_selecionado"];
        // }





        // // RISCOS
        // $valor_risco_selecionado_bind = null;
        // if (isset($_POST["valor_riscos"])) {
        //     $recebe_riscos_selecionado = $_POST["valor_riscos"] !== "" ? $_POST["valor_riscos"] : null;
        //     if (!isset($_SESSION["medico_risco_selecionado"]) || $_SESSION["medico_risco_selecionado"] !== $recebe_riscos_selecionado) {
        //         $_SESSION["medico_risco_selecionado"] = $recebe_riscos_selecionado;
        //     }
        // }
        // if (isset($_SESSION["medico_risco_selecionado"])) {
        //     $valor_risco_selecionado_bind = $_SESSION["medico_risco_selecionado"];
        // }




        // // TREINAMENTOS
        // $valor_treinamento_selecionado_bind = null;
        // if (isset($_POST["valor_treinamentos"])) {
        //     $recebe_treinamento_selecionado = $_POST["valor_treinamentos"] !== "" ? $_POST["valor_treinamentos"] : null;
        //     if (!isset($_SESSION["medico_treinamento_selecionado"]) || $_SESSION["medico_treinamento_selecionado"] !== $recebe_treinamento_selecionado) {
        //         $_SESSION["medico_treinamento_selecionado"] = $recebe_treinamento_selecionado;
        //     }
        // }
        // if (isset($_SESSION["medico_treinamento_selecionado"])) {
        //     $valor_treinamento_selecionado_bind = $_SESSION["medico_treinamento_selecionado"];
        // }


        // if (
        //     isset($_POST["valor_laudo_selecionado"]) && $_POST["valor_laudo_selecionado"] !== ""
        //     && isset($_POST["valor_selecionado"]) && $_POST["valor_selecionado"] !== ""
        // ) {

        //     $valor_selecionado = $_POST["valor_selecionado"] !== "" ? $_POST["valor_selecionado"] : null;

        //     switch ($_POST["valor_laudo_selecionado"]) {
        //         case "insalubridade":
        //             if (!isset($_SESSION["insalubridade_selecionado"]) || $_SESSION["insalubridade_selecionado"] !== $valor_selecionado) {
        //                 $_SESSION["insalubridade_selecionado"] = $valor_selecionado;
        //             }
        //             break;
        //         case "porcentagem":
        //             if (!isset($_SESSION["porcentagem_selecionado"]) || $_SESSION["porcentagem_selecionado"] !== $valor_selecionado) {
        //                 $_SESSION["porcentagem_selecionado"] = $valor_selecionado;
        //             }
        //             break;
        //         case "periculosidade 30%":
        //             if (!isset($_SESSION["periculosidade_selecionado"]) || $_SESSION["periculosidade_selecionado"] !== $valor_selecionado) {
        //                 $_SESSION["periculosidade_selecionado"] = $valor_selecionado;
        //             }
        //             break;
        //         case "aposent. especial":
        //             if (!isset($_SESSION["aposentado_selecionado"]) || $_SESSION["aposentado_selecionado"] !== $valor_selecionado) {
        //                 $_SESSION["aposentado_selecionado"] = $valor_selecionado;
        //             }
        //             break;
        //         case "agente nocivo":
        //             if (!isset($_SESSION["agente_nocivo_selecionado"]) || $_SESSION["agente_nocivo_selecionado"] !== $valor_selecionado) {
        //                 $_SESSION["agente_nocivo_selecionado"] = $valor_selecionado;
        //             }
        //             break;
        //         case "ocorrência gfip":
        //             if (!isset($_SESSION["agente_ocorrencia_selecionado"]) || $_SESSION["agente_ocorrencia_selecionado"] !== $valor_selecionado) {
        //                 $_SESSION["agente_ocorrencia_selecionado"] = $valor_selecionado;
        //             }
        //             break;
        //     }
        // }

        // // Valores para bind
        // $valor_insalubridade_selecionado_bind = $_SESSION["insalubridade_selecionado"] ?? null;
        // $valor_porcentagem_selecionado_bind = $_SESSION["porcentagem_selecionado"] ?? null;
        // $valor_periculosidade_selecionado_bind = $_SESSION["periculosidade_selecionado"] ?? null;
        // $valor_aposentado_selecionado_bind = $_SESSION["aposentado_selecionado"] ?? null;
        // $valor_agente_nocivo_selecionado_bind = $_SESSION["agente_nocivo_selecionado"] ?? null;
        // $valor_ocorrencia_selecionado_bind = $_SESSION["agente_ocorrencia_selecionado"] ?? null;


        // // APTIDOES
        // $valor_aptidao_selecionado_bind = null; // garante que existe

        // if (isset($_POST["valor_aptidoes"])) {
        //     // Se vier valor do POST, trata "" como null
        //     $recebe_aptidao_selecionado = $_POST["valor_aptidoes"] !== "" ? $_POST["valor_aptidoes"] : null;

        //     // Atualiza a sessão somente se o valor for diferente do atual
        //     if (!isset($_SESSION["aptidao_selecionado"]) || $_SESSION["aptidao_selecionado"] !== $recebe_aptidao_selecionado) {
        //         $_SESSION["aptidao_selecionado"] = $recebe_aptidao_selecionado;
        //     }
        // }

        // // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        // if (isset($_SESSION["aptidao_selecionado"])) {
        //     $valor_aptidao_selecionado_bind = $_SESSION["aptidao_selecionado"];
        // }



        // // EXAMES SELECIONADOS
        // $valor_exames_selecionado_bind = null; // garante que existe

        // if (isset($_POST["valor_exames_selecionados"])) {
        //     // Se vier valor do POST, trata "" como null
        //     $recebe_exames_selecionado = $_POST["valor_exames_selecionados"] !== "" ? $_POST["valor_exames_selecionados"] : null;

        //     // Atualiza a sessão somente se o valor for diferente do atual
        //     if (!isset($_SESSION["exames_selecionado"]) || $_SESSION["exames_selecionado"] !== $recebe_exames_selecionado) {
        //         $_SESSION["exames_selecionado"] = $recebe_exames_selecionado;
        //     }
        // }

        // // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        // if (isset($_SESSION["exames_selecionado"])) {
        //     $valor_exames_selecionado_bind = $_SESSION["exames_selecionado"];
        // }






        // //TIPO ORCAMENTO
        // $valor_tipo_orcamento_bind = null; // garante que existe

        // if (isset($_POST["valor_tipo_orcamento"])) {
        //     // Se vier valor do POST, trata "" como null
        //     $recebe_tipo_orcamento = $_POST["valor_tipo_orcamento"] !== "" ? $_POST["valor_tipo_orcamento"] : null;

        //     // Atualiza a sessão somente se o valor for diferente do atual
        //     if (!isset($_SESSION["tipo_orcamento"]) || $_SESSION["tipo_orcamento"] !== $recebe_tipo_orcamento) {
        //         $_SESSION["tipo_orcamento"] = $recebe_tipo_orcamento;
        //     }
        // }

        // // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        // if (isset($_SESSION["tipo_orcamento"])) {
        //     $valor_tipo_orcamento_bind = $_SESSION["tipo_orcamento"];
        // }





        // //TIPO DADO BANCARIO
        // $valor_tipo_dado_bancario_bind = null; // garante que existe

        // if (isset($_POST["valor_tipo_dado_bancario"])) {
        //     // Se vier valor do POST, trata "" como null
        //     $recebe_tipo_orcamento = $_POST["valor_tipo_dado_bancario"] !== "" ? $_POST["valor_tipo_dado_bancario"] : null;

        //     // Atualiza a sessão somente se o valor for diferente do atual
        //     if (!isset($_SESSION["tipo_dado_bancario"]) || $_SESSION["tipo_dado_bancario"] !== $recebe_tipo_orcamento) {
        //         $_SESSION["tipo_dado_bancario"] = $recebe_tipo_orcamento;
        //     }
        // }

        // // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        // if (isset($_SESSION["tipo_dado_bancario"])) {
        //     $valor_tipo_dado_bancario_bind = $_SESSION["tipo_dado_bancario"];
        // }



        // // Agência/Conta
        // $valor_dado_bancario_agencia_conta_bind = null; // garante que existe

        // if (isset($_POST["valor_agencia_conta"])) {
        //     // Se vier valor do POST, trata "" como null
        //     $recebe_agencia_conta = $_POST["valor_agencia_conta"] !== "" ? $_POST["valor_agencia_conta"] : null;

        //     // Atualiza a sessão somente se o valor for diferente do atual
        //     if (!isset($_SESSION["dado_bancario_agencia_conta"]) || $_SESSION["dado_bancario_agencia_conta"] !== $recebe_agencia_conta) {
        //         $_SESSION["dado_bancario_agencia_conta"] = $recebe_agencia_conta;
        //     }
        // }

        // // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        // if (isset($_SESSION["dado_bancario_agencia_conta"])) {
        //     $valor_dado_bancario_agencia_conta_bind = $_SESSION["dado_bancario_agencia_conta"];
        // }





        // // PIX
        // $valor_dado_bancario_pix_bind = null; // garante que existe

        // if (isset($_POST["valor_pix"])) {
        //     // Trata "" como null
        //     $recebe_pix = $_POST["valor_pix"] !== "" ? $_POST["valor_pix"] : null;

        //     // Atualiza a sessão somente se for diferente do valor atual
        //     if (!isset($_SESSION["dado_bancario_pix"]) || $_SESSION["dado_bancario_pix"] !== $recebe_pix) {
        //         $_SESSION["dado_bancario_pix"] = $recebe_pix;
        //     }
        // }

        // // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        // if (isset($_SESSION["dado_bancario_pix"])) {
        //     $valor_dado_bancario_pix_bind = $_SESSION["dado_bancario_pix"];
        // }


        // // DOCUMENTO
        // $valor_documento_bind = null; // garante que existe

        // if (isset($_POST["valor_documento"])) {
        //     // Trata "" como null
        //     $recebe_documento = $_POST["valor_documento"] !== "" ? $_POST["valor_documento"] : null;

        //     // Atualiza a sessão somente se for diferente do valor atual
        //     if (!isset($_SESSION["documento"]) || $_SESSION["documento"] !== $recebe_documento) {
        //         $_SESSION["documento"] = $recebe_documento;
        //     }
        // }

        // // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        // if (isset($_SESSION["documento"])) {
        //     $valor_documento_bind = $_SESSION["documento"];
        // }




        // // TOTAL
        // $valor_total_bind = null; // garante que existe

        // if (isset($_POST["valor_total"])) {
        //     // Trata "" como null
        //     $recebe_total = $_POST["valor_total"] !== "" ? $_POST["valor_total"] : null;

        //     // Atualiza a sessão somente se for diferente do valor atual
        //     if (!isset($_SESSION["total"]) || $_SESSION["total"] !== $recebe_total) {
        //         $_SESSION["total"] = $recebe_total;
        //     }
        // }

        // // Se não veio POST, ou veio mas é igual ao que já estava, pega o valor da sessão
        // if (isset($_SESSION["total"])) {
        //     $valor_total_bind = $_SESSION["total"];
        // }


        // $recebe_status_kit_bind = "RASCUNHO";
        // //FINALIZACAO

        // if (isset($_POST["requer_assinatura"]) && $_POST["requer_assinatura"]) {
        //     $recebe_requer_assinatura = isset($_POST["requer_assinatura"]) ? $_POST["requer_assinatura"] : null;

        //     // Converte para booleano de forma segura
        //     $recebe_bool_requer_assinatura = filter_var($recebe_requer_assinatura, FILTER_VALIDATE_BOOLEAN);

        //     // Agora trata como Sim / Nao
        //     $recebe_final_requer_assinatura = $recebe_bool_requer_assinatura ? "Sim" : "Nao";

        //     // Atualiza sessão somente se não existir ainda ou se já existir
        //     if (!isset($_SESSION["assinatura"]) || $_SESSION["assinatura"]) {
        //         $_SESSION["assinatura"] = $recebe_final_requer_assinatura;
        //     }
        // }

        // // ASSINATURA
        // $valor_assinatura_bind = null; // garante que existe

        // if (isset($_POST["requer_assinatura"])) {
        //     // Trata "" como null
        //     $recebe_requer_assinatura = $_POST["requer_assinatura"] !== "" ? $_POST["requer_assinatura"] : null;

        //     // Converte para booleano de forma segura
        //     $recebe_bool_requer_assinatura = filter_var($recebe_requer_assinatura, FILTER_VALIDATE_BOOLEAN);

        //     // Agora trata como Sim / Nao
        //     $recebe_final_requer_assinatura = $recebe_bool_requer_assinatura ? "Sim" : "Nao";

        //     // Atualiza a sessão somente se for diferente do valor atual
        //     if (!isset($_SESSION["assinatura"]) || $_SESSION["assinatura"] !== $recebe_requer_assinatura) {
        //         $_SESSION["assinatura"] = $recebe_final_requer_assinatura;
        //     }
        // }


        function bindCondicionalSession(&$sql, $campoPost, $nomeCampoBanco, $parametroPDO, $nomeSessao = null)
        {
            // Se o campo não veio no POST ou está vazio, mantém o valor atual
            if (!isset($_POST[$campoPost]) || $_POST[$campoPost] === "") {
                $sql = str_replace(
                    "$nomeCampoBanco = $parametroPDO,",
                    "$nomeCampoBanco = $nomeCampoBanco,",
                    $sql
                );
                return false; // não vai bindar
            }

            $valor = $_POST[$campoPost];

            // 🔹 Se for booleano (true/false), converte para "Sim"/"Não"
            if (is_bool($valor) || $valor === "true" || $valor === "false") {
                $valor = ($valor === true || $valor === "true") ? "Sim" : "Não";
                $_POST[$campoPost] = $valor; // atualiza o POST para refletir o valor convertido
            }

            // 🔹 Atualiza a sessão se o nome da sessão foi informado
            if ($nomeSessao) {
                if (!isset($_SESSION[$nomeSessao]) || $_SESSION[$nomeSessao] !== $valor) {
                    $_SESSION[$nomeSessao] = $valor;
                }
            }

            return true; // vai bindar
        }


        function bindCondicionalLaudo(&$sql, $campoLaudo, $campoValor, $nomeCampoBanco, $parametroPDO)
        {
            if (
                !isset($_POST[$campoLaudo]) || $_POST[$campoLaudo] === "" ||
                !isset($_POST[$campoValor]) || $_POST[$campoValor] === ""
            ) {
                // Mantém o valor atual no banco
                $sql = str_replace(
                    "$nomeCampoBanco = $parametroPDO,",
                    "$nomeCampoBanco = $nomeCampoBanco,",
                    $sql
                );
                return false; // não vai bindar
            }

            $tipo_laudo = strtolower(trim($_POST[$campoLaudo]));
            $valor_selecionado = $_POST[$campoValor];

            // Só faz bind se o campo atual corresponder ao tipo de laudo do banco
            $mapa = [
                "insalubridade" => "insalubridade",
                "porcentagem" => "porcentagem",
                "periculosidade 30%" => "periculosidade",
                "aposent. especial" => "aposentado_especial",
                "agente nocivo" => "agente_nocivo",
                "ocorrência gfip" => "ocorrencia_gfip",
            ];

            if (!isset($mapa[$tipo_laudo])) {
                // Tipo de laudo não reconhecido
                return false;
            }

            // Se o tipo do POST for diferente do campo de banco, não faz bind
            if ($mapa[$tipo_laudo] !== $nomeCampoBanco) {
                // Mantém o valor atual
                $sql = str_replace(
                    "$nomeCampoBanco = $parametroPDO,",
                    "$nomeCampoBanco = $nomeCampoBanco,",
                    $sql
                );
                return false;
            }

            // Atualiza a sessão conforme o tipo
            $_SESSION[$mapa[$tipo_laudo] . "_selecionado"] = $valor_selecionado;

            return true; // vai bindar
        }



        // $valor_assinatura_bind = isset($_SESSION["assinatura"]) ? $_SESSION["assinatura"] : null;


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


        // if (isset($_POST['acao']) && $_POST['acao'] === 'gerar_pdf') {
        //     // gerar_pdf_basico();
        // }

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
        medico_fonoaudiologo = :recebe_medico_fonoaudiologo,
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
        informacoes_dados_bancarios_qrcode = :recebe_informacoes_dados_bancarios_qrcode,
        informacoes_dados_bancarios_agenciaconta_exames_procedimentos = :recebe_dado_bancario_agencia_conta_exames_procedimentos_selecionado,
        informacoes_dados_bancarios_pix_exames_procedimentos = :recebe_dado_bancario_pix_exames_procedimentos_selecionado,
        informacoes_dados_bancarios_agenciaconta_treinamentos = :recebe_dado_bancario_agencia_conta_treinamentos_selecionado,
        informacoes_dados_bancarios_pix_treinamentos = :recebe_dado_bancario_pix_treinamentos_selecionado,
        informacoes_dados_bancarios_agenciaconta_epi_epc = :recebe_dado_bancario_agencia_conta_epi_epc_selecionado,
        informacoes_dados_bancarios_pix_epi_epc = :recebe_dado_bancario_pix_epi_epc_dado_selecionado,
        assinatura_digital = :recebe_assinatura_digital_selecionada,
        tipo_orcamento = :recebe_tipo_orcamento_selecionado,
        modelos_selecionados = :recebe_documentos_selecionado,
        valor_total = :recebe_total,
        status = :recebe_status_kit
    WHERE id = :recebe_kit_id";
        // var_dump($instrucao_atualizar_kit);
        $comando_atualizar_kit = $pdo->prepare($instrucao_atualizar_kit);
        // $comando_atualizar_kit->debugDumpParams();


        // 🔹 Ajusta o SQL para campos opcionais
        $bind_tipo_exame = bindCondicionalSession($instrucao_atualizar_kit, "valor_exame", "tipo_exame", ":recebe_tipo_exame", "exame_selecionado");

        $bind_empresa_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_empresa", "empresa_id", ":recebe_empresa_id", "empresa_selecionado");

        $bind_clinica_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_clinica", "clinica_id", ":recebe_clinica_id", "clinica_selecionado");

        $bind_pessoa_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_colaborador", "pessoa_id", ":recebe_pessoa_id", "colaborador_selecionado");

        $bind_motorista = bindCondicionalSession($instrucao_atualizar_kit, "valor_motorista", "motorista", ":recebe_motorista", "motorista_selecionado");

        $bind_cargo = bindCondicionalSession($instrucao_atualizar_kit, "valor_cargo", "cargo_id", ":recebe_cargo_id", "cargo_selecionado");

        $bind_medico_coordenador_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_medico_coordenador_id", "medico_coordenador_id", ":recebe_medico_coordenador_id", "medico_coordenador_selecionado");

        $bind_medico_clinica_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_medico_clinica_id", "medico_clinica_id", ":recebe_medico_clinica_id", "medico_clinica_selecionado");

        $bind_medico_fonoaudiologo = bindCondicionalSession($instrucao_atualizar_kit, "valor_medico_fonoaudiologo", "medico_fonoaudiologo", ":recebe_medico_fonoaudiologo", "medico_fonoaudiologo_selecionado");

        $bind_riscos = bindCondicionalSession($instrucao_atualizar_kit, "valor_riscos", "riscos_selecionados", ":recebe_riscos_selecionados", "medico_risco_selecionado");

        $bind_treinamentos = bindCondicionalSession($instrucao_atualizar_kit, "valor_treinamentos", "treinamentos_selecionados", ":recebe_treinamentos_selecionados", "medico_treinamento_selecionado");



        $bind_insalubridade = bindCondicionalLaudo(
            $instrucao_atualizar_kit,
            "valor_laudo_selecionado",
            "valor_selecionado",
            "insalubridade",
            ":recebe_insalubridade_selecionado"
        );

        $bind_porcentagem = bindCondicionalLaudo(
            $instrucao_atualizar_kit,
            "valor_laudo_selecionado",
            "valor_selecionado",
            "porcentagem",
            ":recebe_porcentagem_selecionado"
        );

        $bind_periculosidade = bindCondicionalLaudo($instrucao_atualizar_kit, "valor_laudo_selecionado", "valor_selecionado", "periculosidade", ":recebe_periculosidade_selecionado");

        $bind_aposentado_especial = bindCondicionalLaudo($instrucao_atualizar_kit, "valor_laudo_selecionado", "valor_selecionado", "aposentado_especial", ":recebe_aposentado_especial_selecionado");

        $bind_agente_nocivo = bindCondicionalLaudo($instrucao_atualizar_kit, "valor_laudo_selecionado", "valor_selecionado", "agente_nocivo", ":recebe_agente_nocivo_selecionado");

        $bind_ocorrencia = bindCondicionalLaudo($instrucao_atualizar_kit, "valor_laudo_selecionado", "valor_selecionado", "ocorrencia_gfip", ":recebe_ocorrencia_gfip_selecionado");

        $bind_aptidoes = bindCondicionalSession($instrucao_atualizar_kit, "valor_aptidoes", "aptidoes_selecionadas", ":recebe_aptidao_selecionado", "aptidao_selecionado");

        $bind_exames = bindCondicionalSession($instrucao_atualizar_kit, "valor_exames_selecionados", "exames_selecionados", ":recebe_exames_selecionado", "exames_selecionado");

        $bind_tipo_orcamento = bindCondicionalSession($instrucao_atualizar_kit, "valor_tipo_orcamento", "tipo_orcamento", ":recebe_tipo_orcamento_selecionado", "tipo_orcamento");

        $bind_requer_assinatura = bindCondicionalSession($instrucao_atualizar_kit, "requer_assinatura", "assinatura_digital", ":recebe_assinatura_digital_selecionada", "assinatura");

        $bind_tipo_dado_bancario = bindCondicionalSession($instrucao_atualizar_kit, "valor_tipo_dado_bancario", "tipo_dado_bancario", ":recebe_tipo_dado_bancario_selecionado", "tipo_dado_bancario");

        $bind_informacoes_dados_bancarios_qrcode = bindCondicionalSession($instrucao_atualizar_kit, "valor_informacoes_bancarias_qrcode", "informacoes_dados_bancarios_qrcode", ":recebe_informacoes_dados_bancarios_qrcode", "informacoes_dados_bancarios_qrcode");

        $bind_dado_bancario_agencia_conta_exames_procedimentos = bindCondicionalSession($instrucao_atualizar_kit, "valor_agencia_conta_exames", "informacoes_dados_bancarios_agenciaconta_exames_procedimentos", ":recebe_dado_bancario_agencia_conta_exames_procedimentos_selecionado", "dado_bancario_agencia_conta_exames_procedimentos");

        $bind_dado_bancario_pix_exames_procedimentos = bindCondicionalSession($instrucao_atualizar_kit, "valor_pix_exames", "informacoes_dados_bancarios_pix_exames_procedimentos", ":recebe_dado_bancario_pix_exames_procedimentos_selecionado", "dado_bancario_pix_exames_procedimentos");

        $bind_dado_bancario_agencia_conta_treinamentos = bindCondicionalSession($instrucao_atualizar_kit, "valor_agencia_conta_treinamentos", "informacoes_dados_bancarios_agenciaconta_treinamentos", ":recebe_dado_bancario_agencia_conta_treinamentos_selecionado", "dado_bancario_agencia_conta_treinamentos");

        $bind_dado_bancario_pix_treinamentos = bindCondicionalSession($instrucao_atualizar_kit, "valor_pix_treinamentos", "informacoes_dados_bancarios_pix_treinamentos", ":recebe_dado_bancario_pix_treinamentos_selecionado", "dado_bancario_pix_treinamentos");

        $bind_dado_bancario_agencia_conta_epi_epc = bindCondicionalSession($instrucao_atualizar_kit, "valor_agencia_conta_epi_epc", "informacoes_dados_bancarios_agenciaconta_epi_epc", ":recebe_dado_bancario_agencia_conta_epi_epc_selecionado", "dado_bancario_agencia_conta_epi_epc");

        $bind_dado_bancario_pix_epi_epc = bindCondicionalSession($instrucao_atualizar_kit, "valor_pix_epi_epc", "informacoes_dados_bancarios_pix_epi_epc", ":recebe_dado_bancario_pix_epi_epc_dado_selecionado", "dado_bancario_pix_epi_epc");

        $bind_informacoes_dados_bancarios_agencia_conta = bindCondicionalSession($instrucao_atualizar_kit, "valor_informacoes_bancarias_agencia_conta", "informacoes_dados_bancarios_agenciaconta", ":recebe_informacoes_dados_bancarios_agencia_conta", "informacoes_dados_bancarios_agenciaconta");

        $bind_informacoes_dados_bancarios_pix = bindCondicionalSession($instrucao_atualizar_kit, "valor_informacoes_bancarias_pix", "informacoes_dados_bancarios_pix", ":recebe_informacoes_dados_bancarios_pix", "informacoes_dados_bancarios_pix");

        $bind_documentos = bindCondicionalSession($instrucao_atualizar_kit, "valor_documento", "modelos_selecionados", ":recebe_documentos_selecionado", "documento");

        $bind_valor_total = bindCondicionalSession($instrucao_atualizar_kit, "valor_total", "valor_total", ":recebe_total", "total");

        // 🔹 Prepara o comando APENAS UMA VEZ
        $comando_atualizar_kit = $pdo->prepare($instrucao_atualizar_kit);

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_tipo_exame) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $_POST["valor_exame"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_empresa_id) {
            // $valor_empresa = $_POST["valor_empresa"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["empresa_selecionado"] = $valor_empresa;

            $comando_atualizar_kit->bindValue(":recebe_empresa_id", $_POST["valor_empresa"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_clinica_id) {
            // $valor_clinica = $_POST["valor_clinica"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["clinica_selecionado"] = $valor_clinica;

            // $comando_atualizar_kit->bindValue(":recebe_clinica_id", $valor_clinica, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_clinica_id", $_POST["valor_clinica"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_pessoa_id) {
            // $valor_colaborador = $_POST["valor_colaborador"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["colaborador_selecionado"] = $valor_colaborador;

            // $comando_atualizar_kit->bindValue(":recebe_pessoa_id", $valor_colaborador, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_pessoa_id", $_POST["valor_colaborador"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_motorista) {
            // $valor_motorista = $_POST["valor_motorista"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["motorista_selecionado"] = $valor_motorista;

            $comando_atualizar_kit->bindValue(":recebe_motorista", $_POST["valor_motorista"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_cargo) {
            // $valor_cargo = $_POST["valor_cargo"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["cargo_selecionado"] = $valor_cargo;

            // $comando_atualizar_kit->bindValue(":recebe_cargo_id", $valor_cargo, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_cargo_id", $_POST["valor_cargo"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_medico_coordenador_id) {
            // $valor_medico_coordenador_id = $_POST["valor_medico_coordenador_id"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_coordenador_selecionado"] = $valor_medico_coordenador_id;

            $comando_atualizar_kit->bindValue(":recebe_medico_coordenador_id", $_POST["valor_medico_coordenador_id"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_medico_clinica_id) {
            // $valor_medico_clinica_id = $_POST["valor_medico_clinica_id"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_clinica_selecionado"] = $valor_medico_clinica_id;

            // $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id", $valor_medico_clinica_id, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id", $_POST["valor_medico_clinica_id"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_medico_fonoaudiologo) {
            // $valor_medico_clinica_id = $_POST["valor_medico_clinica_id"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_clinica_selecionado"] = $valor_medico_clinica_id;

            // $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id", $valor_medico_clinica_id, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_medico_fonoaudiologo", $_POST["valor_medico_fonoaudiologo"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_riscos) {
            // $valor_riscos = $_POST["valor_riscos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_risco_selecionado"] = $valor_riscos;

            // $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados", $valor_riscos, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados", $_POST["valor_riscos"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_treinamentos) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_treinamentos_selecionados", $_POST["valor_treinamentos"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_insalubridade) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_insalubridade_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_porcentagem) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_porcentagem_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_periculosidade) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_periculosidade_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_aposentado_especial) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_aposentado_especial_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_agente_nocivo) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_agente_nocivo_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_ocorrencia) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_ocorrencia_gfip_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_aptidoes) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_aptidao_selecionado", $_POST["valor_aptidoes"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_exames) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_exames_selecionado", $_POST["valor_exames_selecionados"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_tipo_orcamento) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_tipo_orcamento_selecionado", $_POST["valor_tipo_orcamento"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_requer_assinatura) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_assinatura_digital_selecionada", $_POST["requer_assinatura"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_tipo_dado_bancario) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_tipo_dado_bancario_selecionado", $_POST["valor_tipo_dado_bancario"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        // if ($bind_dado_bancario_agencia_conta_exames_procedimentos) {
        //     // $valor_exame = $_POST["valor_exame"];

        //     // // Atualiza a sessão com o valor que veio do POST
        //     // $_SESSION["exame_selecionado"] = $valor_exame;

        //     // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
        //     $comando_atualizar_kit->bindValue(":recebe_dado_bancario_agencia_conta_exames_procedimentos_selecionado", $_POST["valor_agencia_conta"], PDO::PARAM_STR);
        // }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_informacoes_dados_bancarios_qrcode) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_informacoes_dados_bancarios_qrcode", $_POST["valor_informacoes_bancarias_qrcode"], PDO::PARAM_STR);
        }

        // 🔹 Executa bind somente se o tipo de orçamento for "exames_procedimentos"
        if (
            $bind_dado_bancario_agencia_conta_exames_procedimentos &&
            isset($_POST["valor_tipo_orcamento"]) &&
            $_POST["valor_tipo_orcamento"] === "exames_procedimentos"
        ) {
            $comando_atualizar_kit->bindValue(
                ":recebe_dado_bancario_agencia_conta_exames_procedimentos_selecionado",
                $_POST["valor_agencia_conta_exames"],
                PDO::PARAM_STR
            );
        }

        // $tipo = $_POST["valor_tipo_orcamento"] ?? "";

        // if ($tipo === "exames_procedimentos") {
        //     $bind_dado_bancario_agencia_conta_exames_procedimentos =
        //         bindCondicionalSession(
        //             $instrucao_atualizar_kit,
        //             "valor_agencia_conta",
        //             "informacoes_dados_bancarios_agenciaconta_exames_procedimentos",
        //             "recebe_dado_bancario_agencia_conta_exames_procedimentos_selecionado"
        //         );
        // } else {
        //     $bind_dado_bancario_agencia_conta_exames_procedimentos = false;
        // }




        // // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_dado_bancario_pix_exames_procedimentos &&
            isset($_POST["valor_tipo_orcamento"]) &&
            $_POST["valor_tipo_orcamento"] === "exames_procedimentos") {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_dado_bancario_pix_exames_procedimentos_selecionado", $_POST["valor_pix_exames"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem e se for exames_procedimentos

        // if ($tipo === "exames_procedimentos") {
        //     $bind_dado_bancario_pix_exames_procedimentos =
        //         bindCondicionalSession(
        //             $instrucao_atualizar_kit,
        //             "valor_pix",
        //             "informacoes_dados_bancarios_pix_exames_procedimentos",
        //             "recebe_dado_bancario_pix_exames_procedimentos_selecionado"
        //         );
        // } else {
        //     $bind_dado_bancario_pix_exames_procedimentos = false;
        // }

        // if (
        //     $bind_dado_bancario_pix_exames_procedimentos &&
        //     isset($_POST["valor_tipo_orcamento"]) &&
        //     $_POST["valor_tipo_orcamento"] === "exames_procedimentos"
        // ) {
        //     $comando_atualizar_kit->bindValue(
        //         ":recebe_dado_bancario_pix_exames_procedimentos_selecionado",
        //         $_POST["valor_pix"],
        //         PDO::PARAM_STR
        //     );
        // }

        if (
            $bind_dado_bancario_agencia_conta_treinamentos &&
            isset($_POST["valor_tipo_orcamento"]) &&
            $_POST["valor_tipo_orcamento"] === "treinamentos"
        ) {
            $comando_atualizar_kit->bindValue(
                ":recebe_dado_bancario_agencia_conta_treinamentos_selecionado",
                $_POST["valor_agencia_conta_treinamentos"],
                PDO::PARAM_STR
            );
        }

        // if ($tipo === "treinamentos") {
        //     $bind_dado_bancario_agencia_conta_treinamentos =
        //         bindCondicionalSession(
        //             $instrucao_atualizar_kit,
        //             "valor_agencia_conta", // nome vindo do POST
        //             "informacoes_dados_bancarios_agencia_conta_treinamentos", // sessão
        //             "recebe_dado_bancario_agencia_conta_treinamentos_selecionado" // bind
        //         );
        // } else {
        //     $bind_dado_bancario_agencia_conta_treinamentos = false;
        // }


        if (
            $bind_dado_bancario_pix_treinamentos &&
            isset($_POST["valor_tipo_orcamento"]) &&
            $_POST["valor_tipo_orcamento"] === "treinamentos"
        ) {
            $comando_atualizar_kit->bindValue(
                ":recebe_dado_bancario_pix_treinamentos_selecionado",
                $_POST["valor_pix_treinamentos"],
                PDO::PARAM_STR
            );
        }

        // if ($tipo === "treinamentos") {
        //     $bind_dado_bancario_pix_treinamentos =
        //         bindCondicionalSession(
        //             $instrucao_atualizar_kit,
        //             "valor_pix", // nome vindo do POST
        //             "informacoes_dados_bancarios_pix_treinamentos", // sessão
        //             "recebe_dado_bancario_pix_treinamentos_selecionado" // bind
        //         );
        // } else {
        //     $bind_dado_bancario_pix_treinamentos = false;
        // }


        if (
            $bind_dado_bancario_agencia_conta_epi_epc &&
            isset($_POST["valor_tipo_orcamento"]) &&
            $_POST["valor_tipo_orcamento"] === "epi_epc"
        ) {
            $comando_atualizar_kit->bindValue(
                ":recebe_dado_bancario_agencia_conta_epi_epc_selecionado",
                $_POST["valor_agencia_conta_epi_epc"],
                PDO::PARAM_STR
            );
        }

        // if ($tipo === "epi_epc") {
        //     $bind_dado_bancario_agencia_conta_epi_epc =
        //         bindCondicionalSession(
        //             $instrucao_atualizar_kit,
        //             "valor_agencia_conta", // vem do POST
        //             "informacoes_dados_bancarios_agencia_conta_epi_epc", // sessão
        //             "recebe_dado_bancario_agencia_conta_epi_epc_selecionado" // bind
        //         );
        // } else {
        //     $bind_dado_bancario_agencia_conta_epi_epc = false;
        // }


        if (
            $bind_dado_bancario_pix_epi_epc &&
            isset($_POST["valor_tipo_orcamento"]) &&
            $_POST["valor_tipo_orcamento"] === "epi_epc"
        ) {
            $comando_atualizar_kit->bindValue(
                ":recebe_dado_bancario_pix_epi_epc_dado_selecionado",
                $_POST["valor_pix_epi_epc"],
                PDO::PARAM_STR
            );
        }

        // if ($tipo === "epi_epc") {
        //     $bind_dado_bancario_pix_epi_epc =
        //         bindCondicionalSession(
        //             $instrucao_atualizar_kit,
        //             "valor_pix", // vem do POST
        //             "informacoes_dados_bancarios_pix_epi_epc", // sessão
        //             "recebe_dado_bancario_pix_epi_epc_selecionado" // bind
        //         );
        // } else {
        //     $bind_dado_bancario_pix_epi_epc = false;
        // }


        // 🔹 Faz bind dos campos opcionais se vierem
        // if ($bind_informacoes_dados_bancarios_agencia_conta) {
        //     // $valor_exame = $_POST["valor_exame"];

        //     // // Atualiza a sessão com o valor que veio do POST
        //     // $_SESSION["exame_selecionado"] = $valor_exame;

        //     // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
        //     $comando_atualizar_kit->bindValue(":recebe_informacoes_dados_bancarios_agencia_conta", $_POST["valor_informacoes_bancarias_agencia_conta"], PDO::PARAM_STR);
        // }

        // // 🔹 Faz bind dos campos opcionais se vierem
        // if ($bind_informacoes_dados_bancarios_pix) {
        //     // $valor_exame = $_POST["valor_exame"];

        //     // // Atualiza a sessão com o valor que veio do POST
        //     // $_SESSION["exame_selecionado"] = $valor_exame;

        //     // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
        //     $comando_atualizar_kit->bindValue(":recebe_informacoes_dados_bancarios_pix", $_POST["valor_informacoes_bancarias_pix"], PDO::PARAM_STR);
        // }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_documentos) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_documentos_selecionado", $_POST["valor_documento"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_valor_total) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_total", $_POST["valor_total"], PDO::PARAM_STR);
        }

        // 🔹 Campos obrigatórios
        $recebe_status_kit_bind = "RASCUNHO";

        if (isset($_POST["valor_finalizamento"]) && $_POST["valor_finalizamento"]) {
            $recebe_status_kit_bind = "FINALIZADO";
        }

        $comando_atualizar_kit->bindValue(":recebe_status_kit", $recebe_status_kit_bind, PDO::PARAM_STR);

        // // Binds
        // // $comando_atualizar_kit->bindValue(":recebe_tipo_exame",   $valor_exame_bind,      $valor_exame_bind      === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame_bind, $valor_exame_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_empresa_id",   $valor_empresa_bind,    $valor_empresa_bind    === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_empresa_id", $valor_empresa_bind, $valor_empresa_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_clinica_id",   $valor_clinica_bind,    $valor_clinica_bind    === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_clinica_id", $valor_clinica_bind, $valor_clinica_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_pessoa_id",    $valor_colaborador_bind, $valor_colaborador_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_pessoa_id", $valor_colaborador_bind, $valor_colaborador_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_cargo_id",     $valor_cargo_bind,      $valor_cargo_bind      === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_cargo_id", $valor_cargo_bind, $valor_cargo_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_motorista",    $valor_motorista_bind,  $valor_motorista_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_motorista", $valor_motorista_bind, $valor_motorista_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_medico_coordenador_id",    $valor_medico_coordenador_bind,  $valor_medico_coordenador_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_medico_coordenador_id", $valor_medico_coordenador_bind, $valor_medico_coordenador_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id",    $valor_medico_clinica_bind,  $valor_medico_clinica_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id", $valor_medico_clinica_bind, $valor_medico_clinica_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados",    $valor_risco_selecionado_bind,  $valor_risco_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados", $valor_risco_selecionado_bind, $valor_risco_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_treinamentos_selecionados",    $valor_treinamento_selecionado_bind,  $valor_treinamento_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_treinamentos_selecionados", $valor_treinamento_selecionado_bind, $valor_treinamento_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_insalubridade_selecionado",    $valor_insalubridade_selecionado_bind,  $valor_insalubridade_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_insalubridade_selecionado", $valor_insalubridade_selecionado_bind, $valor_insalubridade_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // // $comando_atualizar_kit->bindValue(":recebe_porcentagem_selecionado",    $valor_porcentagem_selecionado_bind,  $valor_porcentagem_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_porcentagem_selecionado", $valor_porcentagem_selecionado_bind, $valor_porcentagem_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // // $comando_atualizar_kit->bindValue(":recebe_periculosidade_selecionado",    $valor_periculosidade_selecionado_bind,  $valor_periculosidade_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_periculosidade_selecionado", $valor_periculosidade_selecionado_bind, $valor_periculosidade_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // // $comando_atualizar_kit->bindValue(":recebe_aposentado_especial_selecionado",    $valor_aposentado_selecionado_bind,  $valor_aposentado_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_aposentado_especial_selecionado", $valor_aposentado_selecionado_bind, $valor_aposentado_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_agente_nocivo_selecionado",    $valor_agente_nocivo_selecionado_bind,  $valor_agente_nocivo_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_agente_nocivo_selecionado", $valor_agente_nocivo_selecionado_bind, $valor_agente_nocivo_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_ocorrencia_gfip_selecionado",    $valor_ocorrencia_selecionado_bind,  $valor_ocorrencia_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(":recebe_ocorrencia_gfip_selecionado", $valor_ocorrencia_selecionado_bind, $valor_ocorrencia_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // // $comando_atualizar_kit->bindValue(":recebe_aptidao_selecionado",    $valor_aptidao_selecionado_bind,  $valor_aptidao_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_aptidao_selecionado",
        //     $valor_aptidao_selecionado_bind,
        //     $valor_aptidao_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // // $comando_atualizar_kit->bindValue(":recebe_exames_selecionado",    $valor_exames_selecionado_bind,  $valor_exames_selecionado_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_exames_selecionado",
        //     $valor_exames_selecionado_bind,
        //     $valor_exames_selecionado_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // // $comando_atualizar_kit->bindValue(":recebe_tipo_dado_bancario_selecionado",    $valor_tipo_dado_bancario_bind,  $valor_tipo_dado_bancario_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_tipo_dado_bancario_selecionado",
        //     $valor_tipo_dado_bancario_bind,
        //     $valor_tipo_dado_bancario_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // // Bind no PDO
        // $comando_atualizar_kit->bindValue(
        //     ":recebe_dado_bancario_agencia_conta_selecionado",
        //     $valor_dado_bancario_agencia_conta_bind,
        //     $valor_dado_bancario_agencia_conta_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_dado_bancario_pix_selecionado",
        //     $valor_dado_bancario_pix_bind,
        //     $valor_dado_bancario_pix_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );
        // $comando_atualizar_kit->bindValue(":recebe_assinatura_digital_selecionada",    $valor_assinatura_bind,  $valor_assinatura_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // // $comando_atualizar_kit->bindValue(":recebe_tipo_orcamento_selecionado",    $valor_tipo_orcamento_bind,  $valor_tipo_orcamento_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_tipo_orcamento_selecionado",
        //     $valor_tipo_orcamento_bind,
        //     $valor_tipo_orcamento_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // // $comando_atualizar_kit->bindValue(":recebe_documentos_selecionado",    $valor_documento_bind,  $valor_documento_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_documentos_selecionado",
        //     $valor_documento_bind,
        //     $valor_documento_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // // $comando_atualizar_kit->bindValue(":recebe_total",    $valor_total_bind,  $valor_total_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // $comando_atualizar_kit->bindValue(
        //     ":recebe_total",
        //     $valor_total_bind,
        //     $valor_total_bind === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        // );

        // $comando_atualizar_kit->bindValue(":recebe_status_kit",    $recebe_status_kit_bind,  $recebe_status_kit_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        // Kit ID
        $comando_atualizar_kit->bindValue(":recebe_kit_id", $_SESSION["codigo_kit"], PDO::PARAM_INT);

        // Executa
        $resultado_atualizar_kit = $comando_atualizar_kit->execute();

        if ($resultado_atualizar_kit) {
            echo json_encode("KIT atualizado com sucesso");

            // 🔹 Limpa todas as sessões relacionadas ao kit atual
            // unset(
            //     $_SESSION["exame_selecionado"],
            //     $_SESSION["empresa_selecionado"],
            //     $_SESSION["clinica_selecionado"],
            //     $_SESSION["colaborador_selecionado"],
            //     $_SESSION["cargo_selecionado"],
            //     $_SESSION["motorista_selecionado"],
            //     $_SESSION["medico_coordenador_selecionado"],
            //     $_SESSION["medico_clinica_selecionado"],
            //     $_SESSION["medico_risco_selecionado"],
            //     $_SESSION["medico_treinamento_selecionado"],
            //     $_SESSION["insalubridade_selecionado"],
            //     $_SESSION["porcentagem_selecionado"],
            //     $_SESSION["periculosidade_selecionado"],
            //     $_SESSION["aposentado_selecionado"],
            //     $_SESSION["agente_nocivo_selecionado"],
            //     $_SESSION["agente_ocorrencia_selecionado"],
            //     $_SESSION["aptidao_selecionado"],
            //     $_SESSION["exames_selecionado"],
            //     $_SESSION["tipo_orcamento"],
            //     $_SESSION["tipo_dado_bancario"],
            //     $_SESSION["dado_bancario_agencia_conta"],
            //     $_SESSION["dado_bancario_pix"],
            //     $_SESSION["documento"],
            //     $_SESSION["total"]
            // );

            // // 🔹 (opcional) também remove qualquer session vazia
            // session_write_close();
        } else {
            echo json_encode("KIT não foi atualizado com sucesso");
        }
    } else if ($recebe_processo_geracao_kit === "atualizar_kit") {
        //     // EXAME
        //     // ... (seu código anterior, começando nos blocos de POST que você enviou)
        //     // if (isset($_POST["valor_exame"]) && $_POST["valor_exame"] !== "") {
        //     //     $recebe_exame_selecionado = $_POST["valor_exame"];

        //     //     if (!isset($_SESSION["exame_selecionado"]) || $_SESSION["exame_selecionado"] !== $recebe_exame_selecionado) {
        //     //         $_SESSION["exame_selecionado"] = $recebe_exame_selecionado;
        //     //     }
        //     // }
        //     // $valor_exame_bind = isset($_SESSION["exame_selecionado"]) ? $_SESSION["exame_selecionado"] : null;


        //     // Só entra aqui se realmente veio valor válido
        //     if (isset($_POST["valor_exame"]) && $_POST["valor_exame"] !== "") {
        //         $recebe_exame_selecionado = $_POST["valor_exame"];

        //         // Atualiza a sessão se mudou
        //         if (!isset($_SESSION["exame_selecionado"]) || $_SESSION["exame_selecionado"] !== $recebe_exame_selecionado) {
        //             $_SESSION["exame_selecionado"] = $recebe_exame_selecionado;
        //         }

        //         // Define apenas se tem valor
        //         $valor_exame_bind = $_SESSION["exame_selecionado"];

        //         // Faz o bind e atualiza o banco
        //         $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame_bind, PDO::PARAM_STR);
        //     } else {
        //         // ❌ Não faz nada — nem define variável, nem atualiza, nem muda sessão
        //         // Assim o campo não entra no UPDATE
        //     }

        //     $recebe_status_kit_bind = "RASCUNHO";

        //     if (isset($_POST["valor_finalizamento"]) && $_POST["valor_finalizamento"]) {
        //         $recebe_status_kit_bind = "FINALIZADO";
        //     }


        //     // function gerar_pdf_basico()
        //     // {
        //     //     // Cria a instância do Dompdf
        //     //     $dompdf = new Dompdf();
        //     //     // HTML que será convertido para PDF
        //     //     $html = "
        //     //         <html>
        //     //         <head>
        //     //         <meta charset='UTF-8'>
        //     //         <title>PDF com Dompdf</title>
        //     //         </head>
        //     //         <body>
        //     //         <h1 style='text-align: center;'>Promais Informações</h1>
        //     //         <p style='text-align: center;'>Este é um PDF básico gerado usando Dompdf e PHP puro.</p>
        //     //         </body>
        //     //         </html>
        //     //         ";

        //     //     $options = new Options();

        //     //     $dompdf = new Dompdf(['enable_remote' => true]);

        //     //     // Carrega o HTML no Dompdf
        //     //     $dompdf->loadHtml($html);

        //     //     // Define tamanho e orientação do papel
        //     //     $dompdf->setPaper('A4', 'portrait');

        //     //     // Renderiza o PDF
        //     //     $dompdf->render();

        //     //     // Envia o PDF para o navegador
        //     //     $dompdf->stream("promais_informacoes.pdf", ["Attachment" => false]);
        //     // }   


        //     // if (isset($_POST['acao']) && $_POST['acao'] === 'gerar_pdf') {
        //     //     // gerar_pdf_basico();
        //     // }

        //     // Atualização
        //     $instrucao_atualizar_kit = "UPDATE kits SET 
        //     tipo_exame = :recebe_tipo_exame,
        //     empresa_id = :recebe_empresa_id,
        //     clinica_id = :recebe_clinica_id,
        //     pessoa_id = :recebe_pessoa_id,
        //     motorista = :recebe_motorista,
        //     cargo_id = :recebe_cargo_id,
        //     medico_coordenador_id = :recebe_medico_coordenador_id,
        //     medico_clinica_id = :recebe_medico_clinica_id,
        //     riscos_selecionados = :recebe_riscos_selecionados,
        //     treinamentos_selecionados = :recebe_treinamentos_selecionados,
        //     insalubridade = :recebe_insalubridade_selecionado,
        //     porcentagem = :recebe_porcentagem_selecionado,
        //     periculosidade = :recebe_periculosidade_selecionado,
        //     aposentado_especial = :recebe_aposentado_especial_selecionado,
        //     agente_nocivo = :recebe_agente_nocivo_selecionado,
        //     ocorrencia_gfip = :recebe_ocorrencia_gfip_selecionado,
        //     aptidoes_selecionadas = :recebe_aptidao_selecionado,
        //     exames_selecionados = :recebe_exames_selecionado,
        //     tipo_dado_bancario = :recebe_tipo_dado_bancario_selecionado,
        //     dado_bancario_agencia_conta = :recebe_dado_bancario_agencia_conta_selecionado,
        //     dado_bancario_pix = :recebe_dado_bancario_pix_selecionado,
        //     assinatura_digital = :recebe_assinatura_digital_selecionada,
        //     tipo_orcamento = :recebe_tipo_orcamento_selecionado,
        //     modelos_selecionados = :recebe_documentos_selecionado,
        //     valor_total = :recebe_total,
        //     status = :recebe_status_kit
        // WHERE id = :recebe_kit_id";

        //     // 2️⃣ Só então faz o ajuste condicional
        //     if (!isset($_POST["valor_exame"]) || $_POST["valor_exame"] === "") {
        //         // Remove o campo do update (mantém o valor atual)
        //         $instrucao_atualizar_kit = str_replace(
        //             "tipo_exame = :recebe_tipo_exame,",
        //             "tipo_exame = tipo_exame,",
        //             $instrucao_atualizar_kit
        //         );
        //     }


        //     $comando_atualizar_kit->bindValue(":recebe_status_kit",    $recebe_status_kit_bind,  $recebe_status_kit_bind  === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        //     // Kit ID
        //     // Verifica se o GET possui valor
        //     if (isset($_POST['valor_id_kit']) && !empty($_POST['valor_id_kit'])) {
        //         $valor_id_kit = $_POST['valor_id_kit'];

        //         // Aqui você pode usar no bindValue
        //         $comando_atualizar_kit->bindValue(":recebe_kit_id", $valor_id_kit, PDO::PARAM_INT);

        //         // Executa o comando
        //         $comando_atualizar_kit->execute();
        //     } else {
        //         // Tratar caso não tenha valor
        //         echo "O valor do kit não foi informado.";
        //         exit;
        //     }

        //     // Executa
        //     $resultado_atualizar_kit = $comando_atualizar_kit->execute();

        //     if ($resultado_atualizar_kit) {
        //         echo json_encode("KIT atualizado com sucesso");
        //     } else {
        //         echo json_encode("KIT não foi atualizado com sucesso");
        //     }

        // // 🔹 Função auxiliar para bind condicional
        // function bindCondicional(&$sql, $campoPost, $nomeCampoBanco, $parametroPDO)
        // {
        //     if (!isset($_POST[$campoPost]) || $_POST[$campoPost] === "") {
        //         // Mantém o valor atual no banco (não altera)
        //         $sql = str_replace(
        //             "$nomeCampoBanco = $parametroPDO,",
        //             "$nomeCampoBanco = $nomeCampoBanco,",
        //             $sql
        //         );
        //         return false; // não vai bindar
        //     }
        //     return true; // vai bindar
        // }

        // 🔹 Função auxiliar para bind condicional e atualização de sessão
        // function bindCondicionalSession(&$sql, $campoPost, $nomeCampoBanco, $parametroPDO, $nomeSessao = null)
        // {
        //     if (!isset($_POST[$campoPost]) || $_POST[$campoPost] === "") {
        //         // Mantém o valor atual no banco (não altera)
        //         $sql = str_replace(
        //             "$nomeCampoBanco = $parametroPDO,",
        //             "$nomeCampoBanco = $nomeCampoBanco,",
        //             $sql
        //         );
        //         return false; // não vai bindar
        //     }

        //     $valor = $_POST[$campoPost];

        //     // Atualiza a sessão se $nomeSessao for informado
        //     if ($nomeSessao) {
        //         if (!isset($_SESSION[$nomeSessao]) || $_SESSION[$nomeSessao] !== $valor) {
        //             $_SESSION[$nomeSessao] = $valor;
        //         }
        //     }

        //     return true; // vai bindar
        // }


        function bindCondicionalSession(&$sql, $campoPost, $nomeCampoBanco, $parametroPDO, $nomeSessao = null)
        {
            // Se o campo não veio no POST ou está vazio, mantém o valor atual
            if (!isset($_POST[$campoPost]) || $_POST[$campoPost] === "") {
                $sql = str_replace(
                    "$nomeCampoBanco = $parametroPDO,",
                    "$nomeCampoBanco = $nomeCampoBanco,",
                    $sql
                );
                return false; // não vai bindar
            }

            $valor = $_POST[$campoPost];

            // 🔹 Se for booleano (true/false), converte para "Sim"/"Não"
            if (is_bool($valor) || $valor === "true" || $valor === "false") {
                $valor = ($valor === true || $valor === "true") ? "Sim" : "Não";
                $_POST[$campoPost] = $valor; // atualiza o POST para refletir o valor convertido
            }

            // 🔹 Atualiza a sessão se o nome da sessão foi informado
            if ($nomeSessao) {
                if (!isset($_SESSION[$nomeSessao]) || $_SESSION[$nomeSessao] !== $valor) {
                    $_SESSION[$nomeSessao] = $valor;
                }
            }

            return true; // vai bindar
        }



        // 🔹 Função auxiliar para bind condicional e atualização de sessão
        // function bindCondicionalSession(&$sql, $campoPost, $nomeCampoBanco, $parametroPDO, $nomeSessao = null)
        // {
        //     if (!isset($_POST[$campoPost]) || $_POST[$campoPost] === "") {
        //         // Remove o placeholder inteiro da instrução
        //         $sql = preg_replace(
        //             "/\s*$nomeCampoBanco\s*=\s*$parametroPDO\s*,?/",
        //             "$nomeCampoBanco = $nomeCampoBanco,",
        //             $sql
        //         );
        //         return false; // não vai bindar
        //     }

        //     $valor = $_POST[$campoPost];

        //     // Atualiza a sessão se $nomeSessao for informado
        //     if ($nomeSessao) {
        //         if (!isset($_SESSION[$nomeSessao]) || $_SESSION[$nomeSessao] !== $valor) {
        //             $_SESSION[$nomeSessao] = $valor;
        //         }
        //     }

        //     return true; // vai bindar
        // }


        // 🔹 Função para bind condicional de laudos
        // function bindCondicionalLaudo(&$sql, $campoLaudo, $campoValor, $nomeCampoBanco, $parametroPDO)
        // {
        //     if (
        //         !isset($_POST[$campoLaudo]) || $_POST[$campoLaudo] === "" ||
        //         !isset($_POST[$campoValor]) || $_POST[$campoValor] === ""
        //     ) {
        //         // Mantém o valor atual no banco
        //         $sql = str_replace(
        //             "$nomeCampoBanco = $parametroPDO,",
        //             "$nomeCampoBanco = $nomeCampoBanco,",
        //             $sql
        //         );
        //         return false; // não vai bindar
        //     }

        //     $valor_selecionado = $_POST[$campoValor];

        //     // Atualiza a sessão conforme o tipo de laudo
        //     switch ($_POST[$campoLaudo]) {
        //         case "insalubridade":
        //             $_SESSION["insalubridade_selecionado"] = $valor_selecionado;
        //             break;
        //         case "porcentagem":
        //             $_SESSION["porcentagem_selecionado"] = $valor_selecionado;
        //             break;
        //         case "periculosidade 30%":
        //             $_SESSION["periculosidade_selecionado"] = $valor_selecionado;
        //             break;
        //         case "aposent. especial":
        //             $_SESSION["aposentado_selecionado"] = $valor_selecionado;
        //             break;
        //         case "agente nocivo":
        //             $_SESSION["agente_nocivo_selecionado"] = $valor_selecionado;
        //             break;
        //         case "ocorrência gfip":
        //             $_SESSION["agente_ocorrencia_selecionado"] = $valor_selecionado;
        //             break;
        //     }

        //     return true; // vai bindar
        // }


        function bindCondicionalLaudo(&$sql, $campoLaudo, $campoValor, $nomeCampoBanco, $parametroPDO)
        {
            if (
                !isset($_POST[$campoLaudo]) || $_POST[$campoLaudo] === "" ||
                !isset($_POST[$campoValor]) || $_POST[$campoValor] === ""
            ) {
                // Mantém o valor atual no banco
                $sql = str_replace(
                    "$nomeCampoBanco = $parametroPDO,",
                    "$nomeCampoBanco = $nomeCampoBanco,",
                    $sql
                );
                return false; // não vai bindar
            }

            $tipo_laudo = strtolower(trim($_POST[$campoLaudo]));
            $valor_selecionado = $_POST[$campoValor];

            // Só faz bind se o campo atual corresponder ao tipo de laudo do banco
            $mapa = [
                "insalubridade" => "insalubridade",
                "porcentagem" => "porcentagem",
                "periculosidade 30%" => "periculosidade",
                "aposent. especial" => "aposentado_especial",
                "agente nocivo" => "agente_nocivo",
                "ocorrência gfip" => "ocorrencia_gfip",
            ];

            if (!isset($mapa[$tipo_laudo])) {
                // Tipo de laudo não reconhecido
                return false;
            }

            // Se o tipo do POST for diferente do campo de banco, não faz bind
            if ($mapa[$tipo_laudo] !== $nomeCampoBanco) {
                // Mantém o valor atual
                $sql = str_replace(
                    "$nomeCampoBanco = $parametroPDO,",
                    "$nomeCampoBanco = $nomeCampoBanco,",
                    $sql
                );
                return false;
            }

            // Atualiza a sessão conforme o tipo
            $_SESSION[$mapa[$tipo_laudo] . "_selecionado"] = $valor_selecionado;

            return true; // vai bindar
        }


        // 🔹 Função para bind condicional de laudos
        // function bindCondicionalLaudo(&$sql, $campoLaudo, $campoValor, $nomeCampoBanco, $parametroPDO)
        // {
        //     if (
        //         !isset($_POST[$campoLaudo]) || $_POST[$campoLaudo] === "" ||
        //         !isset($_POST[$campoValor]) || $_POST[$campoValor] === ""
        //     ) {
        //         // Remove o placeholder inteiro da instrução
        //         $sql = preg_replace(
        //             "/\s*$nomeCampoBanco\s*=\s*$parametroPDO\s*,?/",
        //             "$nomeCampoBanco = $nomeCampoBanco,",
        //             $sql
        //         );
        //         return false;
        //     }

        //     $valor_selecionado = $_POST[$campoValor];

        //     // Atualiza a sessão conforme o tipo de laudo
        //     switch ($_POST[$campoLaudo]) {
        //         case "insalubridade":
        //             $_SESSION["insalubridade_selecionado"] = $valor_selecionado;
        //             break;
        //         case "porcentagem":
        //             $_SESSION["porcentagem_selecionado"] = $valor_selecionado;
        //             break;
        //         case "periculosidade 30%":
        //             $_SESSION["periculosidade_selecionado"] = $valor_selecionado;
        //             break;
        //         case "aposent. especial":
        //             $_SESSION["aposentado_selecionado"] = $valor_selecionado;
        //             break;
        //         case "agente nocivo":
        //             $_SESSION["agente_nocivo_selecionado"] = $valor_selecionado;
        //             break;
        //         case "ocorrência gfip":
        //             $_SESSION["agente_ocorrencia_selecionado"] = $valor_selecionado;
        //             break;
        //     }

        //     return true; // vai bindar
        // }


        // 🔹 SQL Base
        $instrucao_atualizar_kit = "
            UPDATE kits SET 
                tipo_exame = :recebe_tipo_exame,
                empresa_id = :recebe_empresa_id,
                clinica_id = :recebe_clinica_id,
                pessoa_id = :recebe_pessoa_id,
                motorista = :recebe_motorista,
                cargo_id = :recebe_cargo_id,
                medico_coordenador_id = :recebe_medico_coordenador_id,
                medico_clinica_id = :recebe_medico_clinica_id,
                medico_fonoaudiologo = :recebe_medico_fonoaudiologo_id,
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
                tipo_orcamento = :recebe_tipo_orcamento_selecionado,
                assinatura_digital = :recebe_assinatura_digital_selecionada,
                tipo_dado_bancario = :recebe_tipo_dado_bancario_selecionado,
                dado_bancario_agencia_conta = :recebe_dado_bancario_agencia_conta_selecionado,
                dado_bancario_pix = :recebe_dado_bancario_pix_selecionado,
                informacoes_dados_bancarios_qrcode = :recebe_informacoes_dados_bancarios_qrcode,
                informacoes_dados_bancarios_agenciaconta = :recebe_informacoes_dados_bancarios_agencia_conta,
                informacoes_dados_bancarios_pix = :recebe_informacoes_dados_bancarios_pix,
                modelos_selecionados = :recebe_documentos_selecionado,
                valor_total = :recebe_total,
                status = :recebe_status_kit
            WHERE id = :recebe_kit_id
        ";

        // 🔹 Ajusta o SQL para campos opcionais
        $bind_tipo_exame = bindCondicionalSession($instrucao_atualizar_kit, "valor_exame", "tipo_exame", ":recebe_tipo_exame", "exame_selecionado");
        $bind_empresa_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_empresa", "empresa_id", ":recebe_empresa_id", "empresa_selecionado");
        $bind_clinica_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_clinica", "clinica_id", ":recebe_clinica_id", "clinica_selecionado");
        $bind_pessoa_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_colaborador", "pessoa_id", ":recebe_pessoa_id", "colaborador_selecionado");
        $bind_motorista = bindCondicionalSession($instrucao_atualizar_kit, "valor_motorista", "motorista", ":recebe_motorista", "motorista_selecionado");
        $bind_cargo = bindCondicionalSession($instrucao_atualizar_kit, "valor_cargo", "cargo_id", ":recebe_cargo_id", "cargo_selecionado");
        $bind_medico_coordenador_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_medico_coordenador_id", "medico_coordenador_id", ":recebe_medico_coordenador_id", "medico_coordenador_selecionado");
        $bind_medico_clinica_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_medico_clinica_id", "medico_clinica_id", ":recebe_medico_clinica_id", "medico_clinica_selecionado");
        $bind_medico_fonoaudiologo_id = bindCondicionalSession($instrucao_atualizar_kit, "valor_medico_fonoaudiologo_id", "medico_fonoaudiologo", ":recebe_medico_fonoaudiologo_id", "medico_fonoaudiologo_selecionado");
        $bind_riscos = bindCondicionalSession($instrucao_atualizar_kit, "valor_riscos", "riscos_selecionados", ":recebe_riscos_selecionados", "medico_risco_selecionado");
        $bind_treinamentos = bindCondicionalSession($instrucao_atualizar_kit, "valor_treinamentos", "treinamentos_selecionados", ":recebe_treinamentos_selecionados", "medico_treinamento_selecionado");



        $bind_insalubridade = bindCondicionalLaudo(
            $instrucao_atualizar_kit,
            "valor_laudo_selecionado",
            "valor_selecionado",
            "insalubridade",
            ":recebe_insalubridade_selecionado"
        );

        $bind_porcentagem = bindCondicionalLaudo(
            $instrucao_atualizar_kit,
            "valor_laudo_selecionado",
            "valor_selecionado",
            "porcentagem",
            ":recebe_porcentagem_selecionado"
        );

        $bind_periculosidade = bindCondicionalLaudo($instrucao_atualizar_kit, "valor_laudo_selecionado", "valor_selecionado", "periculosidade", ":recebe_periculosidade_selecionado");

        $bind_aposentado_especial = bindCondicionalLaudo($instrucao_atualizar_kit, "valor_laudo_selecionado", "valor_selecionado", "aposentado_especial", ":recebe_aposentado_especial_selecionado");

        $bind_agente_nocivo = bindCondicionalLaudo($instrucao_atualizar_kit, "valor_laudo_selecionado", "valor_selecionado", "agente_nocivo", ":recebe_agente_nocivo_selecionado");

        $bind_ocorrencia = bindCondicionalLaudo($instrucao_atualizar_kit, "valor_laudo_selecionado", "valor_selecionado", "ocorrencia_gfip", ":recebe_ocorrencia_gfip_selecionado");

        $bind_aptidoes = bindCondicionalSession($instrucao_atualizar_kit, "valor_aptidoes", "aptidoes_selecionadas", ":recebe_aptidao_selecionado", "aptidao_selecionado");

        $bind_exames = bindCondicionalSession($instrucao_atualizar_kit, "valor_exames_selecionados", "exames_selecionados", ":recebe_exames_selecionado", "exames_selecionado");

        $bind_tipo_orcamento = bindCondicionalSession($instrucao_atualizar_kit, "valor_tipo_orcamento", "tipo_orcamento", ":recebe_tipo_orcamento_selecionado", "tipo_orcamento");

        $bind_requer_assinatura = bindCondicionalSession($instrucao_atualizar_kit, "requer_assinatura", "assinatura_digital", ":recebe_assinatura_digital_selecionada", "assinatura");

        $bind_tipo_dado_bancario = bindCondicionalSession($instrucao_atualizar_kit, "valor_tipo_dado_bancario", "tipo_dado_bancario", ":recebe_tipo_dado_bancario_selecionado", "tipo_dado_bancario");

        $bind_dado_bancario_agencia_conta = bindCondicionalSession($instrucao_atualizar_kit, "valor_agencia_conta", "dado_bancario_agencia_conta", ":recebe_dado_bancario_agencia_conta_selecionado", "dado_bancario_agencia_conta");

        $bind_dado_bancario_pix = bindCondicionalSession($instrucao_atualizar_kit, "valor_pix", "dado_bancario_pix", ":recebe_dado_bancario_pix_selecionado", "dado_bancario_pix");

        $bind_informacoes_dados_bancarios_qrcode = bindCondicionalSession($instrucao_atualizar_kit, "valor_informacoes_bancarias_qrcode", "informacoes_dados_bancarios_qrcode", ":recebe_informacoes_dados_bancarios_qrcode", "informacoes_dados_bancarios_qrcode");

        $bind_informacoes_dados_bancarios_agencia_conta = bindCondicionalSession($instrucao_atualizar_kit, "valor_informacoes_bancarias_agencia_conta", "informacoes_dados_bancarios_agenciaconta", ":recebe_informacoes_dados_bancarios_agencia_conta", "informacoes_dados_bancarios_agenciaconta");

        $bind_informacoes_dados_bancarios_pix = bindCondicionalSession($instrucao_atualizar_kit, "valor_informacoes_bancarias_pix", "informacoes_dados_bancarios_pix", ":recebe_informacoes_dados_bancarios_pix", "informacoes_dados_bancarios_pix");

        $bind_documentos = bindCondicionalSession($instrucao_atualizar_kit, "valor_documento", "modelos_selecionados", ":recebe_documentos_selecionado", "documento");

        $bind_valor_total = bindCondicionalSession($instrucao_atualizar_kit, "valor_total", "valor_total", ":recebe_total", "total");

        // 🔹 Prepara o comando APENAS UMA VEZ
        $comando_atualizar_kit = $pdo->prepare($instrucao_atualizar_kit);

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_tipo_exame) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $_POST["valor_exame"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_empresa_id) {
            // $valor_empresa = $_POST["valor_empresa"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["empresa_selecionado"] = $valor_empresa;

            $comando_atualizar_kit->bindValue(":recebe_empresa_id", $_POST["valor_empresa"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_clinica_id) {
            // $valor_clinica = $_POST["valor_clinica"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["clinica_selecionado"] = $valor_clinica;

            // $comando_atualizar_kit->bindValue(":recebe_clinica_id", $valor_clinica, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_clinica_id", $_POST["valor_clinica"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_pessoa_id) {
            // $valor_colaborador = $_POST["valor_colaborador"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["colaborador_selecionado"] = $valor_colaborador;

            // $comando_atualizar_kit->bindValue(":recebe_pessoa_id", $valor_colaborador, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_pessoa_id", $_POST["valor_colaborador"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_motorista) {
            // $valor_motorista = $_POST["valor_motorista"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["motorista_selecionado"] = $valor_motorista;

            $comando_atualizar_kit->bindValue(":recebe_motorista", $_POST["valor_motorista"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_cargo) {
            // $valor_cargo = $_POST["valor_cargo"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["cargo_selecionado"] = $valor_cargo;

            // $comando_atualizar_kit->bindValue(":recebe_cargo_id", $valor_cargo, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_cargo_id", $_POST["valor_cargo"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_medico_coordenador_id) {
            // $valor_medico_coordenador_id = $_POST["valor_medico_coordenador_id"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_coordenador_selecionado"] = $valor_medico_coordenador_id;

            $comando_atualizar_kit->bindValue(":recebe_medico_coordenador_id", $_POST["valor_medico_coordenador_id"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_medico_clinica_id) {
            // $valor_medico_clinica_id = $_POST["valor_medico_clinica_id"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_clinica_selecionado"] = $valor_medico_clinica_id;

            // $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id", $valor_medico_clinica_id, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id", $_POST["valor_medico_clinica_id"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_medico_fonoaudiologo_id) {
            // $valor_medico_clinica_id = $_POST["valor_medico_clinica_id"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_clinica_selecionado"] = $valor_medico_clinica_id;

            // $comando_atualizar_kit->bindValue(":recebe_medico_clinica_id", $valor_medico_clinica_id, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_medico_fonoaudiologo_id", $_POST["valor_medico_fonoaudiologo_id"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_riscos) {
            // $valor_riscos = $_POST["valor_riscos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_risco_selecionado"] = $valor_riscos;

            // $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados", $valor_riscos, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_riscos_selecionados", $_POST["valor_riscos"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_treinamentos) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_treinamentos_selecionados", $_POST["valor_treinamentos"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_insalubridade) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_insalubridade_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_porcentagem) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_porcentagem_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_periculosidade) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_periculosidade_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_aposentado_especial) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_aposentado_especial_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_agente_nocivo) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_agente_nocivo_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_ocorrencia) {
            // $valor_treinamentos = $_POST["valor_treinamentos"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["medico_treinamento_selecionado"] = $valor_treinamentos;

            $comando_atualizar_kit->bindValue(":recebe_ocorrencia_gfip_selecionado", $_POST["valor_selecionado"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_aptidoes) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_aptidao_selecionado", $_POST["valor_aptidoes"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_exames) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_exames_selecionado", $_POST["valor_exames_selecionados"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_tipo_orcamento) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_tipo_orcamento_selecionado", $_POST["valor_tipo_orcamento"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_requer_assinatura) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_assinatura_digital_selecionada", $_POST["requer_assinatura"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_tipo_dado_bancario) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_tipo_dado_bancario_selecionado", $_POST["valor_tipo_dado_bancario"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_dado_bancario_agencia_conta) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_dado_bancario_agencia_conta_selecionado", $_POST["valor_agencia_conta"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_dado_bancario_pix) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_dado_bancario_pix_selecionado", $_POST["valor_pix"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_informacoes_dados_bancarios_qrcode) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_informacoes_dados_bancarios_qrcode", $_POST["valor_informacoes_bancarias_qrcode"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_informacoes_dados_bancarios_agencia_conta) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_informacoes_dados_bancarios_agencia_conta", $_POST["valor_informacoes_bancarias_agencia_conta"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_informacoes_dados_bancarios_pix) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_informacoes_dados_bancarios_pix", $_POST["valor_informacoes_bancarias_pix"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_documentos) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_documentos_selecionado", $_POST["valor_documento"], PDO::PARAM_STR);
        }

        // 🔹 Faz bind dos campos opcionais se vierem
        if ($bind_valor_total) {
            // $valor_exame = $_POST["valor_exame"];

            // // Atualiza a sessão com o valor que veio do POST
            // $_SESSION["exame_selecionado"] = $valor_exame;

            // $comando_atualizar_kit->bindValue(":recebe_tipo_exame", $valor_exame, PDO::PARAM_STR);
            $comando_atualizar_kit->bindValue(":recebe_total", $_POST["valor_total"], PDO::PARAM_STR);
        }


        // 🔹 Campos obrigatórios
        $recebe_status_kit_bind = "RASCUNHO";

        if (isset($_POST["valor_finalizamento"]) && $_POST["valor_finalizamento"]) {
            $recebe_status_kit_bind = "FINALIZADO";
        }

        $comando_atualizar_kit->bindValue(":recebe_status_kit", $recebe_status_kit_bind, PDO::PARAM_STR);

        // 🔹 ID do kit (obrigatório)
        if (isset($_POST['valor_id_kit']) && !empty($_POST['valor_id_kit'])) {
            $comando_atualizar_kit->bindValue(":recebe_kit_id", $_POST['valor_id_kit'], PDO::PARAM_INT);
        } else {
            echo "O valor do kit não foi informado.";
            exit;
        }

        // 🔹 Executa
        if ($comando_atualizar_kit->execute()) {
            echo json_encode("KIT atualizado com sucesso");
        } else {
            echo json_encode("KIT não foi atualizado com sucesso");
        }
    } else if ($recebe_processo_geracao_kit === "duplicar_kit") {
        $recebe_valores_kit_duplicar = $_POST["valores_kit"];

        $instrucao_duplicar_kit = "insert into kits(tipo_exame,status,empresa_id_principal,empresa_id,clinica_id,cargo_id,pessoa_id,
        motorista,medico_coordenador_id,medico_clinica_id,riscos_selecionados,treinamentos_selecionados
        ,insalubridade,porcentagem,periculosidade,aposentado_especial,agente_nocivo,ocorrencia_gfip,aptidoes_selecionadas,
        exames_selecionados,tipo_orcamento,tipo_dado_bancario,dado_bancario_agencia_conta,dado_bancario_pix,informacoes_dados_bancarios_qrcode,informacoes_dados_bancarios_agenciaconta,
        informacoes_dados_bancarios_pix,assinatura_digital,valor_total,modelos_selecionados,usuario_id)
        values(:recebe_tipo_exame,:recebe_status,:recebe_empresa_id_principal,:recebe_empresa_id,:recebe_clinica_id,:recebe_cargo_id,:recebe_pessoa_id,
        :recebe_motorista,:recebe_medico_coordenador_id,:recebe_medico_clinica_id,:recebe_riscos_selecionados,:recebe_treinamentos_selecionados,
        :recebe_insalubridade,:recebe_porcentagem,:recebe_periculosidade,:recebe_aposentado_especial,:recebe_agente_nocivo,:recebe_ocorrencia_gfip,:recebe_aptidoes_selecionadas,
        :recebe_exames_selecionados,:recebe_tipo_orcamento,:recebe_tipo_dado_bancario,:recebe_dado_bancario_agencia_conta,:recebe_dado_bancario_pix,:recebe_informacoes_dados_bancarios_qrcode,
        :recebe_informacoes_dados_bancarios_agenciaconta,:recebe_informacoes_dados_bancarios_pix,:recebe_assinatura_digital,:recebe_valor_total,:recebe_modelos_selecionados,:recebe_usuario_id)";


        $comando_duplicar_kit = $pdo->prepare($instrucao_duplicar_kit);


        // 🔹 Captura o valor
        $valor_tipo_exame = $recebe_valores_kit_duplicar["tipo_exame"] ?? null;
        $valor_empresa_id_principal = $recebe_valores_kit_duplicar["empresa_id_principal"] ?? null;
        $valor_empresa_id = $recebe_valores_kit_duplicar["empresa_id"] ?? null;
        $valor_clinica_id = $recebe_valores_kit_duplicar["clinica_id"] ?? null;
        $valor_cargo_id   = $recebe_valores_kit_duplicar["cargo_id"] ?? null;
        $valor_pessoa_id  = $recebe_valores_kit_duplicar["pessoa_id"] ?? null;
        $valor_motorista  = $recebe_valores_kit_duplicar["motorista"] ?? null;
        $valor_medico_coordenador_id  = $recebe_valores_kit_duplicar["medico_coordenador_id"] ?? null;
        $valor_medico_clinica_id  = $recebe_valores_kit_duplicar["medico_clinica_id"] ?? null;
        $valor_riscos_selecionados  = $recebe_valores_kit_duplicar["riscos_selecionados"] ?? null;
        $valor_treinamentos_selecionados  = $recebe_valores_kit_duplicar["treinamentos_selecionados"] ?? null;
        $valor_insalubridade  = $recebe_valores_kit_duplicar["insalubridade"] ?? null;
        $valor_porcentagem  = $recebe_valores_kit_duplicar["porcentagem"] ?? null;
        $valor_periculosidade  = $recebe_valores_kit_duplicar["periculosidade"] ?? null;
        $valor_aposentado_especial  = $recebe_valores_kit_duplicar["aposentado_especial"] ?? null;
        $valor_agente_nocivo  = $recebe_valores_kit_duplicar["agente_nocivo"] ?? null;
        $valor_ocorrencia_gfip  = $recebe_valores_kit_duplicar["ocorrencia_gfip"] ?? null;
        $valor_aptidoes_selecionadas  = $recebe_valores_kit_duplicar["aptidoes_selecionadas"] ?? null;
        $valor_exames_selecionados  = $recebe_valores_kit_duplicar["exames_selecionados"] ?? null;
        $valor_tipo_orcamento  = $recebe_valores_kit_duplicar["tipo_orcamento"] ?? null;
        $valor_tipo_dado_bancario  = $recebe_valores_kit_duplicar["tipo_dado_bancario"] ?? null;
        $valor_dado_bancario_agencia_conta  = $recebe_valores_kit_duplicar["dado_bancario_agencia_conta"] ?? null;
        $valor_dado_bancario_pix  = $recebe_valores_kit_duplicar["dado_bancario_pix"] ?? null;
        $valor_informacoes_dados_bancarios_qrcode = $recebe_valores_kit_duplicar["informacoes_dados_bancarios_qrcode"] ?? null;
        $valor_informacoes_dados_bancarios_agenciaconta = $recebe_valores_kit_duplicar["informacoes_dados_bancarios_agenciaconta"] ?? null;
        $valor_informacoes_dados_bancarios_pix = $recebe_valores_kit_duplicar["informacoes_dados_bancarios_pix"];
        $valor_assinatura_digital  = $recebe_valores_kit_duplicar["assinatura_digital"] ?? null;
        $valor_total  = $recebe_valores_kit_duplicar["valor_total"] ?? null;
        $valor_modelos_selecionados = $recebe_valores_kit_duplicar["modelos_selecionados"] ?? null;

        // 🔹 Se o valor for nulo ou vazio, envia NULL corretamente
        if ($valor_tipo_exame === null || $valor_tipo_exame === '') {
            $comando_duplicar_kit->bindValue(":recebe_tipo_exame", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_tipo_exame", $valor_tipo_exame, PDO::PARAM_STR);
        }

        $comando_duplicar_kit->bindValue(":recebe_status", "CÓPIA");

        if ($valor_empresa_id_principal === null || $valor_empresa_id_principal === "") {
            $comando_duplicar_kit->bindValue(":recebe_empresa_id_principal", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_empresa_id_principal", $valor_empresa_id_principal, PDO::PARAM_STR);
        }

        if ($valor_empresa_id === null || $valor_empresa_id === "") {
            $comando_duplicar_kit->bindValue(":recebe_empresa_id", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_empresa_id", $valor_empresa_id, PDO::PARAM_STR);
        }

        if ($valor_clinica_id === null || $valor_clinica_id === "") {
            $comando_duplicar_kit->bindValue(":recebe_clinica_id", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_clinica_id", $valor_clinica_id, PDO::PARAM_STR);
        }

        if ($valor_cargo_id === null || $valor_cargo_id === "") {
            $comando_duplicar_kit->bindValue(":recebe_cargo_id", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_cargo_id", $valor_cargo_id, PDO::PARAM_STR);
        }

        if ($valor_pessoa_id === null || $valor_pessoa_id === "") {
            $comando_duplicar_kit->bindValue(":recebe_pessoa_id", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_pessoa_id", $valor_pessoa_id, PDO::PARAM_STR);
        }

        if ($valor_motorista === null || $valor_motorista === "") {
            $comando_duplicar_kit->bindValue(":recebe_motorista", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_motorista", $valor_motorista, PDO::PARAM_STR);
        }

        if ($valor_medico_coordenador_id === null || $valor_medico_coordenador_id === "") {
            $comando_duplicar_kit->bindValue(":recebe_medico_coordenador_id", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_medico_coordenador_id", $valor_medico_coordenador_id, PDO::PARAM_STR);
        }

        if ($valor_medico_clinica_id === null || $valor_medico_clinica_id === "") {
            $comando_duplicar_kit->bindValue(":recebe_medico_clinica_id", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_medico_clinica_id", $valor_medico_clinica_id, PDO::PARAM_STR);
        }

        if ($valor_riscos_selecionados === null || $valor_riscos_selecionados === "") {
            $comando_duplicar_kit->bindValue(":recebe_riscos_selecionados", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_riscos_selecionados", $valor_riscos_selecionados, PDO::PARAM_STR);
        }

        if ($valor_treinamentos_selecionados === null || $valor_treinamentos_selecionados === "") {
            $comando_duplicar_kit->bindValue(":recebe_treinamentos_selecionados", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_treinamentos_selecionados", $valor_treinamentos_selecionados, PDO::PARAM_STR);
        }

        if ($valor_insalubridade === null || $valor_insalubridade === "") {
            $comando_duplicar_kit->bindValue(":recebe_insalubridade", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_insalubridade", $valor_insalubridade, PDO::PARAM_STR);
        }

        if ($valor_porcentagem === null || $valor_porcentagem === "") {
            $comando_duplicar_kit->bindValue(":recebe_porcentagem", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_porcentagem", $valor_porcentagem, PDO::PARAM_STR);
        }

        if ($valor_periculosidade === null || $valor_periculosidade === "") {
            $comando_duplicar_kit->bindValue(":recebe_periculosidade", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_periculosidade", $valor_periculosidade, PDO::PARAM_STR);
        }

        if ($valor_aposentado_especial === null || $valor_aposentado_especial === "") {
            $comando_duplicar_kit->bindValue(":recebe_aposentado_especial", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_aposentado_especial", $valor_aposentado_especial, PDO::PARAM_STR);
        }

        if ($valor_agente_nocivo === null || $valor_agente_nocivo === "") {
            $comando_duplicar_kit->bindValue(":recebe_agente_nocivo", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_agente_nocivo", $valor_agente_nocivo, PDO::PARAM_STR);
        }

        if ($valor_ocorrencia_gfip === null || $valor_ocorrencia_gfip === "") {
            $comando_duplicar_kit->bindValue(":recebe_ocorrencia_gfip", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_ocorrencia_gfip", $valor_ocorrencia_gfip, PDO::PARAM_STR);
        }

        if ($valor_ocorrencia_gfip === null || $valor_ocorrencia_gfip === "") {
            $comando_duplicar_kit->bindValue(":recebe_ocorrencia_gfip", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_ocorrencia_gfip", $valor_ocorrencia_gfip, PDO::PARAM_STR);
        }

        if ($valor_aptidoes_selecionadas === null || $valor_aptidoes_selecionadas === "") {
            $comando_duplicar_kit->bindValue(":recebe_aptidoes_selecionadas", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_aptidoes_selecionadas", $valor_aptidoes_selecionadas, PDO::PARAM_STR);
        }

        if ($valor_exames_selecionados === null || $valor_exames_selecionados === "") {
            $comando_duplicar_kit->bindValue(":recebe_exames_selecionados", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_exames_selecionados", $valor_exames_selecionados, PDO::PARAM_STR);
        }

        if ($valor_tipo_orcamento === null || $valor_tipo_orcamento === "") {
            $comando_duplicar_kit->bindValue(":recebe_tipo_orcamento", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_tipo_orcamento", $valor_tipo_orcamento, PDO::PARAM_STR);
        }

        if ($valor_tipo_dado_bancario === null || $valor_tipo_dado_bancario === "") {
            $comando_duplicar_kit->bindValue(":recebe_tipo_dado_bancario", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_tipo_dado_bancario", $valor_tipo_dado_bancario, PDO::PARAM_STR);
        }

        if ($valor_dado_bancario_agencia_conta === null || $valor_tipo_dado_bancario === "") {
            $comando_duplicar_kit->bindValue(":recebe_dado_bancario_agencia_conta", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_dado_bancario_agencia_conta", $valor_dado_bancario_agencia_conta, PDO::PARAM_STR);
        }

        if ($valor_dado_bancario_pix === null || $valor_dado_bancario_pix === "") {
            $comando_duplicar_kit->bindValue(":recebe_dado_bancario_pix", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_dado_bancario_pix", $valor_dado_bancario_pix, PDO::PARAM_STR);
        }

        if ($valor_informacoes_dados_bancarios_qrcode === null || $valor_informacoes_dados_bancarios_qrcode === "") {
            $comando_duplicar_kit->bindValue(":recebe_informacoes_dados_bancarios_qrcode", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_informacoes_dados_bancarios_qrcode", $valor_informacoes_dados_bancarios_qrcode, PDO::PARAM_STR);
        }

        if ($valor_informacoes_dados_bancarios_agenciaconta === null || $valor_informacoes_dados_bancarios_agenciaconta === "") {
            $comando_duplicar_kit->bindValue(":recebe_informacoes_dados_bancarios_agenciaconta", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_informacoes_dados_bancarios_agenciaconta", $valor_informacoes_dados_bancarios_agenciaconta, PDO::PARAM_STR);
        }

        if ($valor_informacoes_dados_bancarios_pix === null || $valor_informacoes_dados_bancarios_pix === "") {
            $comando_duplicar_kit->bindValue(":recebe_informacoes_dados_bancarios_pix", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_informacoes_dados_bancarios_pix", $valor_informacoes_dados_bancarios_pix, PDO::PARAM_STR);
        }

        if ($valor_assinatura_digital === null || $valor_assinatura_digital === "") {
            $comando_duplicar_kit->bindValue(":recebe_assinatura_digital", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_assinatura_digital", $valor_assinatura_digital, PDO::PARAM_STR);
        }

        if ($valor_total === null || $valor_total === "") {
            $comando_duplicar_kit->bindValue(":recebe_valor_total", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_valor_total", $valor_total, PDO::PARAM_STR);
        }

        if ($valor_modelos_selecionados === null || $valor_modelos_selecionados === "") {
            $comando_duplicar_kit->bindValue(":recebe_modelos_selecionados", null, PDO::PARAM_NULL);
        } else {
            $comando_duplicar_kit->bindValue(":recebe_modelos_selecionados", $valor_modelos_selecionados, PDO::PARAM_STR);
        }

        $comando_duplicar_kit->bindValue(":recebe_usuario_id", $_SESSION["user_id"]);


        $resultado_duplicar_kit = $comando_duplicar_kit->execute();

        $resultado_codigo_kit_duplicado = $pdo->lastInsertId();

        echo json_encode($resultado_codigo_kit_duplicado);
    } else if ($recebe_processo_geracao_kit === "excluir_kit") {
        if ($_POST["metodo"] === "PUT") {
            $instrucao_excluir_kit = "delete from kits where id = :recebe_id_kit";
            $comando_excluir_kit = $pdo->prepare($instrucao_excluir_kit);
            $comando_excluir_kit->bindValue(":recebe_id_kit", $_POST["valor_id_kit"]);
            $resultado_excluir_kit = $comando_excluir_kit->execute();
            echo json_encode($resultado_excluir_kit);
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $recebe_processo_geracao_kit = $_GET["processo_geracao_kit"];

    if ($recebe_processo_geracao_kit === "buscar_kits_empresa") {
        $instrucao_busca_kits_empresa = "select * from kits where empresa_id_principal = :recebe_empresa_id and pessoa_id = :recebe_pessoa_id";
        $comando_busca_kits_empresa = $pdo->prepare($instrucao_busca_kits_empresa);
        $comando_busca_kits_empresa->bindValue(":recebe_empresa_id", $_SESSION["empresa_id"]);
        $comando_busca_kits_empresa->bindValue(":recebe_pessoa_id", $_GET["valor_pessoa_id"]);
        $comando_busca_kits_empresa->execute();
        $resultado_busca_kits_empresa = $comando_busca_kits_empresa->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_kits_empresa);
    } else if ($recebe_processo_geracao_kit === "buscar_empresa_pessoa") {
        $instrucao_busca_empresa_pessoa = "select * from empresas_novas where id = :recebe_id_empresa";
        $comando_busca_empresa_pessoa = $pdo->prepare($instrucao_busca_empresa_pessoa);
        $comando_busca_empresa_pessoa->bindValue(":recebe_id_empresa", $_GET["valor_id_empresa"]);
        $comando_busca_empresa_pessoa->execute();
        $resultado_busca_empresa_pessoa = $comando_busca_empresa_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_empresa_pessoa);
    } else if ($recebe_processo_geracao_kit === "busca_clinica_pessoa") {
        $instrucao_busca_clinica_pessoa = "select * from clinicas where id = :recebe_id_clinica";
        $comando_busca_clinica_pessoa = $pdo->prepare($instrucao_busca_clinica_pessoa);
        $comando_busca_clinica_pessoa->bindValue(":recebe_id_clinica", $_GET["valor_id_clinica"]);
        $comando_busca_clinica_pessoa->execute();
        $resultado_busca_clinica_pessoa = $comando_busca_clinica_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_clinica_pessoa);
    } else if ($recebe_processo_geracao_kit === "busca_pessoa") {
        $instrucao_busca_pessoa = "select * from pessoas where id = :recebe_id_pessoa";
        $comando_busca_pessoa = $pdo->prepare($instrucao_busca_pessoa);
        $comando_busca_pessoa->bindValue(":recebe_id_pessoa", $_GET["valor_id_pessoa"]);
        $comando_busca_pessoa->execute();
        $resultado_busca_pessoa = $comando_busca_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoa);
    } else if ($recebe_processo_geracao_kit === "buscar_kit") {
        $instrucao_busca_kit_especifico = "select * from kits where id = :recebe_id_kit";
        $comando_busca_kit_especifico = $pdo->prepare($instrucao_busca_kit_especifico);
        $comando_busca_kit_especifico->bindValue(":recebe_id_kit", $_GET["valor_id_kit"]);
        $comando_busca_kit_especifico->execute();
        $resultado_busca_kit_especifico = $comando_busca_kit_especifico->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_kit_especifico);
    } else if ($recebe_processo_geracao_kit === "buscar_cargo") {
        $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
        $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
        $comando_busca_cargo->bindValue(":recebe_id_cargo", $_GET["valor_id_cargo"]);
        $comando_busca_cargo->execute();
        $resultado_busca_cargo = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cargo);
    } else if ($recebe_processo_geracao_kit === "buscar_medico_coordenador") {
        $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
        $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
        $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador", $_GET["valor_id_medico_coordenador"]);
        $comando_busca_medico_coordenador->execute();
        $resultado_busca_medico_coordenador = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medico_coordenador);
    } else if ($recebe_processo_geracao_kit === "busca_medico_examinador") {
        $instrucao_busca_medico_examinador = "select medico_id from medicos_clinicas where id = :recebe_id_medico_examinador";
        $comando_busca_medico_examinador = $pdo->prepare($instrucao_busca_medico_examinador);
        $comando_busca_medico_examinador->bindValue(":recebe_id_medico_examinador", $_GET["valor_id_medico_examinador"]);
        $comando_busca_medico_examinador->execute();
        $resultado_busca_medico_examinador = $comando_busca_medico_examinador->fetch(PDO::FETCH_ASSOC);

        if ($resultado_busca_medico_examinador) {
            $instrucao_busca_medico_examinador_dados = "select * from medicos where id = :recebe_id_medico_examinador";
            $comando_busca_medico_examinador_dados = $pdo->prepare($instrucao_busca_medico_examinador_dados);
            $comando_busca_medico_examinador_dados->bindValue(":recebe_id_medico_examinador", $resultado_busca_medico_examinador["medico_id"]);
            $comando_busca_medico_examinador_dados->execute();
            $resultado_busca_medico_examinador_dados = $comando_busca_medico_examinador_dados->fetch(PDO::FETCH_ASSOC);
            echo json_encode($resultado_busca_medico_examinador_dados);
        } else {
            echo json_encode("");
        }
    } else if ($recebe_processo_geracao_kit === "busca_produtos") {
        $instrucao_busca_produto = "select * from produto where id_kit = :recebe_id_kit_produto";
        $comando_busca_produto = $pdo->prepare($instrucao_busca_produto);
        $comando_busca_produto->bindValue(":recebe_id_kit_produto", $_GET["valor_id_kit_produtos"]);
        $comando_busca_produto->execute();
        $resultado_busca_produto = $comando_busca_produto->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_produto);
    } else if ($recebe_processo_geracao_kit === "buscar_empresa_kit") {
        $instrucao_busca_empresa_pessoa = "select * from empresas_novas where id = :recebe_id_empresa";
        $comando_busca_empresa_pessoa = $pdo->prepare($instrucao_busca_empresa_pessoa);
        $comando_busca_empresa_pessoa->bindValue(":recebe_id_empresa", $_GET["valor_id_empresa_kit"]);
        $comando_busca_empresa_pessoa->execute();
        $resultado_busca_empresa_pessoa = $comando_busca_empresa_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_empresa_pessoa);
    } else if ($recebe_processo_geracao_kit === "busca_clinica_kit") {
        $instrucao_busca_clinica_pessoa = "select * from clinicas where id = :recebe_id_clinica";
        $comando_busca_clinica_pessoa = $pdo->prepare($instrucao_busca_clinica_pessoa);
        $comando_busca_clinica_pessoa->bindValue(":recebe_id_clinica", $_GET["valor_id_clinica_kit"]);
        $comando_busca_clinica_pessoa->execute();
        $resultado_busca_clinica_pessoa = $comando_busca_clinica_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_clinica_pessoa);
    } else if ($recebe_processo_geracao_kit === "busca_pessoa_kit") {
        $instrucao_busca_pessoa = "select * from pessoas where id = :recebe_id_pessoa";
        $comando_busca_pessoa = $pdo->prepare($instrucao_busca_pessoa);
        $comando_busca_pessoa->bindValue(":recebe_id_pessoa", $_GET["valor_id_pessoa_kit"]);
        $comando_busca_pessoa->execute();
        $resultado_busca_pessoa = $comando_busca_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoa);
    } else if ($recebe_processo_geracao_kit === "busca_cargo_kit") {
        $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
        $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
        $comando_busca_cargo->bindValue(":recebe_id_cargo", $_GET["valor_id_cargo_kit"]);
        $comando_busca_cargo->execute();
        $resultado_busca_cargo = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cargo);
    } else if ($recebe_processo_geracao_kit === "buscar_medico_coordenador_kit") {
        $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
        $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
        $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador", $_GET["valor_id_medico_coordenador_kit"]);
        $comando_busca_medico_coordenador->execute();
        $resultado_busca_medico_coordenador = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medico_coordenador);
    } else if ($recebe_processo_geracao_kit === "busca_medico_examinador_kit") {
        $instrucao_busca_medico_examinador = "select medico_id from medicos_clinicas where id = :recebe_id_medico_examinador";
        $comando_busca_medico_examinador = $pdo->prepare($instrucao_busca_medico_examinador);
        $comando_busca_medico_examinador->bindValue(":recebe_id_medico_examinador", $_GET["valor_id_medico_examinador_kit"]);
        $comando_busca_medico_examinador->execute();
        $resultado_busca_medico_examinador = $comando_busca_medico_examinador->fetch(PDO::FETCH_ASSOC);

        if ($resultado_busca_medico_examinador) {
            $instrucao_busca_medico_examinador_dados = "select * from medicos where id = :recebe_id_medico_examinador";
            $comando_busca_medico_examinador_dados = $pdo->prepare($instrucao_busca_medico_examinador_dados);
            $comando_busca_medico_examinador_dados->bindValue(":recebe_id_medico_examinador", $resultado_busca_medico_examinador["medico_id"]);
            $comando_busca_medico_examinador_dados->execute();
            $resultado_busca_medico_examinador_dados = $comando_busca_medico_examinador_dados->fetch(PDO::FETCH_ASSOC);
            echo json_encode($resultado_busca_medico_examinador_dados);
        } else {
            echo json_encode("");
        }
    } else if ($recebe_processo_geracao_kit === "buscar_cargo_kit") {
        $instrucao_busca_pessoa = "select * from cargo where id_pessoa = :recebe_id_pessoa";
        $comando_busca_pessoa = $pdo->prepare($instrucao_busca_pessoa);
        $comando_busca_pessoa->bindValue(":recebe_id_pessoa", $_GET["valor_id_cargo_kit"]);
        $comando_busca_pessoa->execute();
        $resultado_busca_pessoa = $comando_busca_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoa);
    } else if ($recebe_processo_geracao_kit === "buscar_empresa_primeiro_kit") {
        echo json_encode($_SESSION["empresa_id"]);
    } else if ($recebe_processo_geracao_kit === "buscar_empresa_principal_pessoa") {
        $instrucao_busca_empresa_principal_pessoa = "select * from pessoas where empresa_id = :recebe_empresa_id";
        $comando_busca_empresa_principal_pessoa = $pdo->prepare($instrucao_busca_empresa_principal_pessoa);
        $comando_busca_empresa_principal_pessoa->bindValue(":recebe_empresa_id", $_GET["valor_empresa_id_pessoa"]);
        $comando_busca_empresa_principal_pessoa->execute();
        $resultado_busca_empresa_principal_pessoa = $comando_busca_empresa_principal_pessoa->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_empresa_principal_pessoa);
    } else if ($recebe_processo_geracao_kit === "buscar_fonoaudiologos_kit") {
        $instrucao_busca_fonoaudiologo_audiometria = "select * from medicos where categoria = :recebe_categoria and empresa_id = :recebe_empresa_id";
        $comando_busca_fonoaudiologo_audiometria = $pdo->prepare($instrucao_busca_fonoaudiologo_audiometria);
        $comando_busca_fonoaudiologo_audiometria->bindValue(":recebe_categoria", "fonoaudiologo");
        $comando_busca_fonoaudiologo_audiometria->bindValue(":recebe_empresa_id", $_SESSION["empresa_id"]);
        $comando_busca_fonoaudiologo_audiometria->execute();
        $resultado_busca_fonoaudiologo_audiometria = $comando_busca_fonoaudiologo_audiometria->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_fonoaudiologo_audiometria);
    } else if ($recebe_processo_geracao_kit === "buscar_fonoaudiologo_especifico") {
        $instrucao_busca_fonoaudiologo_especifico = "select * from medicos where categoria = :recebe_categoria and empresa_id = :recebe_empresa_id and id = :recebe_fonoaudiologo_id";
        $comando_busca_fonoaudiologo_especifico = $pdo->prepare($instrucao_busca_fonoaudiologo_especifico);
        $comando_busca_fonoaudiologo_especifico->bindValue(":recebe_categoria", "fonoaudiologo");
        $comando_busca_fonoaudiologo_especifico->bindValue(":recebe_empresa_id", $_SESSION["empresa_id"]);
        $comando_busca_fonoaudiologo_especifico->bindValue(":recebe_fonoaudiologo_id", $_GET["valor_id_fonoaudiologo"]);
        $comando_busca_fonoaudiologo_especifico->execute();
        $resultado_busca_fonoaudiologo_especifico = $comando_busca_fonoaudiologo_especifico->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_fonoaudiologo_especifico);
    } else if ($recebe_processo_geracao_kit === "buscar_todos_kits_empresa") {
        $instrucao_buscar_kits_empresa = "select * from kits where empresa_id_principal = :recebe_empresa_id_principal";
        $comando_buscar_kits_empresa = $pdo->prepare($instrucao_buscar_kits_empresa);
        $comando_buscar_kits_empresa->bindValue(":recebe_empresa_id_principal", $_SESSION["empresa_id"]);
        $comando_buscar_kits_empresa->execute();
        $resultado_buscar_kits_empresa = $comando_buscar_kits_empresa->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_buscar_kits_empresa);
    } else if ($recebe_processo_geracao_kit === "buscar_empresa_principal_kit") {
        $instrucao_buscar_empresa_kit = "select * from empresas where id = :recebe_id_empresa";
        $comando_buscar_empresa_kit = $pdo->prepare($instrucao_buscar_empresa_kit);
        $comando_buscar_empresa_kit->bindValue(":recebe_id_empresa", $_GET["valor_id_empresa"]);
        $comando_buscar_empresa_kit->execute();
        $resultado_buscar_empresa_kit = $comando_buscar_empresa_kit->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_buscar_empresa_kit);
    } else if ($recebe_processo_geracao_kit === "buscar_todos_kits_empresa_gerenciamento_kits") {
        $instrucao_buscar_kits_empresa = "select * from kits where empresa_id_principal = :recebe_id_principal";
        $comando_buscar_kits_empresa = $pdo->prepare($instrucao_buscar_kits_empresa);
        $comando_buscar_kits_empresa->bindValue(":recebe_id_principal", $_GET["valor_id_empresa_principal"]);
        $comando_buscar_kits_empresa->execute();
        $resultado_buscar_kits_empresa_principal = $comando_buscar_kits_empresa->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_buscar_kits_empresa_principal);
    } else if ($recebe_processo_geracao_kit === "buscar_medico_fonoaudiologo_gerenciamento_kits") {
        $instrucao_busca_fonoaudiologo_especifico = "select * from medicos where categoria = :recebe_categoria and id = :recebe_fonoaudiologo_id";
        $comando_busca_fonoaudiologo_especifico = $pdo->prepare($instrucao_busca_fonoaudiologo_especifico);
        $comando_busca_fonoaudiologo_especifico->bindValue(":recebe_categoria", "fonoaudiologo");
        $comando_busca_fonoaudiologo_especifico->bindValue(":recebe_fonoaudiologo_id", $_GET["valor_id_fonoaudiologo"]);
        $comando_busca_fonoaudiologo_especifico->execute();
        $resultado_busca_fonoaudiologo_especifico = $comando_busca_fonoaudiologo_especifico->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_fonoaudiologo_especifico);
    }
}
