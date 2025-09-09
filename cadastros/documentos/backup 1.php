<?php
$recebe_processo_geraca = $_POST["processo_geracao"];

// Função helper para log
function salvarLog($conteudo)
{
    $arquivo = __DIR__ . "/debug_log.txt"; // cria debug_log.txt na mesma pasta
    $data = "[" . date("d/m/Y H:i:s") . "] " . $conteudo . PHP_EOL;
    file_put_contents($arquivo, $data, FILE_APPEND);
}

// Substitui var_dump por log
ob_start();
var_dump($recebe_processo_geraca);
salvarLog(ob_get_clean());

// Primeiro verifica se não está vazio
if (!empty($recebe_processo_geraca)) {

    $dados = trim($recebe_processo_geraca); // remove espaços no começo/fim
    $dados = str_replace(["\r", "\n"], "", $dados); // remove quebras de linha

    $dados_lower = strtolower($dados);

    $guia_encaminhamento   = strpos($dados_lower, strtolower('Guia de Encaminhamento')) !== false;
    $aso                   = strpos($dados_lower, strtolower('ASO - Atestado de Saúde Ocupacional')) !== false;
    $prontuario_medico     = strpos($dados_lower, strtolower('Prontuário Médico')) !== false;
    $acuidade_visual       = strpos($dados_lower, strtolower('Acuidade Visual')) !== false;
    $psicosocial           = strpos($dados_lower, strtolower('Psico Social')) !== false;
    $toxicologico          = strpos($dados_lower, strtolower('Toxicológico')) !== false;
    $resumo_laudo          = strpos($dados_lower, strtolower('Resumo de Laudo')) !== false;
    $exames_procedimentos  = strpos($dados_lower, strtolower('Exames e Procedimentos')) !== false;
    $treinamentos          = strpos($dados_lower, strtolower('Treinamentos')) !== false;
    $epi_epc               = strpos($dados_lower, strtolower('EPI/EPC')) !== false;

    // Substitui var_dump por log
    ob_start();
    var_dump($guia_encaminhamento, $aso, $prontuario_medico);
    salvarLog(ob_get_clean());

    if ($guia_encaminhamento || $aso || $prontuario_medico) {

        if (isset($_SESSION['clinica_selecionado']) && $_SESSION['clinica_selecionado'] !== '') {
            salvarLog("id da clinica selecionada:" . $_SESSION["clinica_selecionado"]);
            salvarLog($_SESSION["exame_selecionado"]);

            $recebe_exame = $_SESSION["exame_selecionado"];
            $recebe_exame_exibicao = "";

            if ($recebe_exame === "admissional") {
                $recebe_exame_exibicao = "Admissional";
            } else if ($recebe_exame === "mudanca") {
                $recebe_exame_exibicao = "Mudança de função";
            }

            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date('d/m/Y');

            // Busca clínica
            $instrucao_busca_clinica = "select * from clinicas where id = :recebe_clinica_id";
            $comando_busca_clinica = $pdo->prepare($instrucao_busca_clinica);
            $comando_busca_clinica->bindValue(":recebe_clinica_id", $_SESSION["clinica_selecionado"]);
            $comando_busca_clinica->execute();
            $resultado_clinica_selecionada = $comando_busca_clinica->fetch(PDO::FETCH_ASSOC);

            // Busca cidade/UF
            $cidadeNome = '';
            $estadoSigla = '';
            if (!empty($resultado_clinica_selecionada['cidade_id'])) {
                $urlCidade = "https://servicodados.ibge.gov.br/api/v1/localidades/municipios/" . $resultado_clinica_selecionada['cidade_id'];
                $cidadeJson = @file_get_contents($urlCidade);
                if ($cidadeJson !== false) {
                    $cidadeData = json_decode($cidadeJson, true);
                    $cidadeNome = $cidadeData['nome'] ?? '';
                }
            }

            if (!empty($resultado_clinica_selecionada['id_estado'])) {
                $urlEstado = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" . $resultado_clinica_selecionada['id_estado'];
                $estadoJson = @file_get_contents($urlEstado);
                if ($estadoJson !== false) {
                    $estadoData = json_decode($estadoJson, true);
                    $estadoSigla = $estadoData['sigla'] ?? '';
                }
            }

            $recebe_cidade_uf = trim($cidadeNome . ' - ' . $estadoSigla);
            salvarLog("Cidade/UF via IBGE: " . $recebe_cidade_uf);

            if (isset($_SESSION['empresa_selecionado']) && $_SESSION['empresa_selecionado'] !== '') {
                $instrucao_busca_empresa = "select * from empresas_novas where id = :recebe_id_empresa";
                $comando_busca_empresa = $pdo->prepare($instrucao_busca_empresa);
                $comando_busca_empresa->bindValue(":recebe_id_empresa", $_SESSION["empresa_selecionado"]);
                $comando_busca_empresa->execute();
                $resultado_empresa_selecionada = $comando_busca_empresa->fetch(PDO::FETCH_ASSOC);

                ob_start();
                var_dump($resultado_empresa_selecionada);
                salvarLog(ob_get_clean());
            }

            if (isset($_SESSION['colaborador_selecionado']) && $_SESSION['colaborador_selecionado'] !== '') {
                $instrucao_busca_pessoa = "select * from pessoas where id = :recebe_id_pessoa";
                $comando_busca_pessoa = $pdo->prepare($instrucao_busca_pessoa);
                $comando_busca_pessoa->bindValue(":recebe_id_pessoa", $_SESSION["colaborador_selecionado"]);
                $comando_busca_pessoa->execute();
                $resultado_pessoa_selecionada = $comando_busca_pessoa->fetch(PDO::FETCH_ASSOC);

                ob_start();
                var_dump($resultado_pessoa_selecionada);
                salvarLog(ob_get_clean());
            }

            if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
                $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
                $comando_busca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                $comando_busca_cargo->execute();
                $resultado_cargo_selecionado = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);

                ob_start();
                var_dump($resultado_cargo_selecionado);
                salvarLog(ob_get_clean());
            }

            if ($recebe_exame === "mudanca") {
                if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                    salvarLog("Cargo:" . $_SESSION["cargo_selecionado"]);

                    $instrucao_busca_mudanca_cargo = "select * from cargo where id = :recebe_id_cargo";
                    $comando_busca_mudanca_cargo = $pdo->prepare($instrucao_busca_mudanca_cargo);
                    $comando_busca_mudanca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                    $comando_busca_mudanca_cargo->execute();
                    $resultado_mudanca_cargo_selecionado = $comando_busca_mudanca_cargo->fetch(PDO::FETCH_ASSOC);

                    ob_start();
                    var_dump($resultado_mudanca_cargo_selecionado);
                    salvarLog(ob_get_clean());
                }
            }

            if (isset($_SESSION["medico_coordenador_selecionado"]) && $_SESSION["medico_coordenador_selecionado"] !== "") {
                salvarLog("ID Médico coordenador:" . $_SESSION["medico_coordenador_selecionado"]);

                $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
                $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
                $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador", $_SESSION["medico_coordenador_selecionado"]);
                $comando_busca_medico_coordenador->execute();
                $resultado_medico_coordenador_selecionado = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);

                ob_start();
                var_dump($resultado_medico_coordenador_selecionado);
                salvarLog(ob_get_clean());
            }

            if (isset($_SESSION["medico_clinica_selecionado"]) && $_SESSION["medico_clinica_selecionado"] !== "") {
                salvarLog("ID médico emitente:" . $_SESSION["medico_clinica_selecionado"]);

                $instrucao_busca_medico_clinica = "select medico_id from medicos_clinicas where id = :recebe_id_medico_clinica";
                $comando_busca_medico_clinica = $pdo->prepare($instrucao_busca_medico_clinica);
                $comando_busca_medico_clinica->bindValue(":recebe_id_medico_clinica", $_SESSION["medico_clinica_selecionado"]);
                $comando_busca_medico_clinica->execute();
                $resultado_medico_clinica_selecionado = $comando_busca_medico_clinica->fetch(PDO::FETCH_ASSOC);

                $instrucao_busca_medico_relacionado_clinica = "select * from medicos where id = :recebe_id_medico_relacionado_clinica";
                $comando_busca_medico_relacionado_clinica = $pdo->prepare($instrucao_busca_medico_relacionado_clinica);
                $comando_busca_medico_relacionado_clinica->bindValue(":recebe_id_medico_relacionado_clinica", $resultado_medico_clinica_selecionado["medico_id"]);
                $comando_busca_medico_relacionado_clinica->execute();
                $resultado_medico_relacionado_clinica = $comando_busca_medico_relacionado_clinica->fetch(PDO::FETCH_ASSOC);

                ob_start();
                var_dump($resultado_medico_relacionado_clinica);
                salvarLog(ob_get_clean());
            }
        }
    }
}