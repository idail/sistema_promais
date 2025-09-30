<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

$host = 'mysql.idailneto.com.br';
$dbname = 'idailneto06';
$username = 'idailneto06';
$password = 'Sei20020615';

require_once "./phpqrcode/phpqrcode.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    // var_dump($recebe_processo_geraca);

    // Primeiro verifica se não está vazio
    if (!empty($recebe_processo_geraca)) {

        // Inicializa tudo como false
        $exames_procedimentos = false;
        $treinamentos         = false;
        $epi_epc              = false;

        $dados = trim($recebe_processo_geraca); // remove espaços no começo/fim
        $dados = str_replace(["\r", "\n"], "", $dados); // remove quebras de linha

        $dados_lower = strtolower($dados);

        $itens = array_map('trim', explode(',', $dados_lower));

        //         function getBooleanCampo(string $dados, string $campo): bool {
        //     // strtolower e trim garantem que espaços e maiúsculas/minúsculas não afetem
        //     return strpos($dados, strtolower(trim($campo))) !== false;
        // }

        foreach ($itens as $item) {
            if ($item === 'exames e procedimentos') {
                $exames_procedimentos = true;
            } elseif ($item === 'treinamentos') {
                $treinamentos = true;
            } elseif ($item === 'epi/epc' || $item === 'epi,epc') {
                $epi_epc = true;
            }
        }


        // Variáveis começam como false (ou vazio)
        $guia_encaminhamento   = strpos($dados_lower, strtolower('Guia de Encaminhamento')) !== false;
        $aso                   = strpos($dados_lower, strtolower('ASO - Atestado de Saúde Ocupacional')) !== false;
        $prontuario_medico     = strpos($dados_lower, strtolower('Prontuário Médico')) !== false;
        $acuidade_visual       = strpos($dados_lower, strtolower('Acuidade Visual')) !== false;
        $psicosocial           = strpos($dados_lower, strtolower('Psico Social')) !== false;
        $toxicologico          = strpos($dados_lower, strtolower('Toxicológico')) !== false;
        $resumo_laudo          = strpos($dados_lower, strtolower('Resumo de Laudo')) !== false;
        // $exames_procedimentos = getBooleanCampo($dados_lower, 'exames e procedimentos');
        // $treinamentos         = getBooleanCampo($dados_lower, 'treinamentos');
        // $epi_epc              = getBooleanCampo($dados_lower, 'epi/epc'); // ou 'epi,epc'
        $faturamento           = strpos($dados_lower, strtolower('Faturamento')) !== false;

        // Debug
        // var_dump([
        //     'exames_procedimentos' => $exames_procedimentos,
        //     'treinamentos'         => $treinamentos,
        //     'epi_epc'              => $epi_epc
        // ]);

        // // Verificações simples
        // if (stripos($recebe_processo_geraca, 'Guia de Encaminhamento') !== false) {
        //     $guia_encaminhamento = true;
        // }

        // if (stripos($recebe_processo_geraca, 'ASO - Atestado de Saúde Ocupacional') !== false) {
        //     $aso = true;
        // }

        // if (stripos($recebe_processo_geraca, 'Prontuário Médico') !== false) {
        //     $prontuario_medico = true;
        // }

        // if(stripos($recebe_processo_geraca, "Acuidade Visual") !== false){
        //     $acuidade_visual = true;
        // }

        // if(stripos($recebe_processo_geraca, "Psico Social") !== false){
        //     $psicosocial = true;
        // }

        // if(stripos($recebe_processo_geraca, "Toxicológico") !== false){
        //     $toxicologico = true;
        // }

        // if(stripos($recebe_processo_geraca, "Resumo de Laudo") !== false)
        // {
        //     $resumo_laudo = true;
        // }

        // Exemplo de uso
        // var_dump($guia_encaminhamento, $aso, $prontuario_medico);


        // Substitui var_dump por log
        ob_start();
        var_dump($guia_encaminhamento, $aso, $prontuario_medico);
        salvarLog(ob_get_clean());

        //echo "exame:".$exames_procedimentos.",treinamentos:".$treinamentos.",epi,epc:".$epi_epc;


        if ($guia_encaminhamento && $aso && $prontuario_medico) {



            $informacoes_clinica;

            if (isset($_SESSION['clinica_selecionado']) && $_SESSION['clinica_selecionado'] !== '') {
                salvarLog("id da clinica selecionada:" . $_SESSION["clinica_selecionado"]);
                salvarLog($_SESSION["exame_selecionado"]);

                // echo "id da clinica selecionada:" . $_SESSION["clinica_selecionado"] . "<br>";

                // echo $_SESSION["exame_selecionado"] . "<br>";

                $recebe_exame = $_SESSION["exame_selecionado"];

                $recebe_exame_exibicao;

                if ($recebe_exame === "admissional") {
                    $recebe_exame_exibicao = "Admissional";
                } else if ($recebe_exame === "mudanca") {
                    $recebe_exame_exibicao = "Mudança de função";
                }

                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                // Função helper para marcar
                function marcar($valor, $tipoExame)
                {
                    return ($tipoExame === strtolower($valor)) ? '(X)' : '( )';
                }

                $instrucao_busca_clinica = "select * from clinicas where id = :recebe_clinica_id";
                $comando_busca_clinica = $pdo->prepare($instrucao_busca_clinica);
                $comando_busca_clinica->bindValue(":recebe_clinica_id", $_SESSION["clinica_selecionado"]);
                $comando_busca_clinica->execute();
                $resultado_clinica_selecionada = $comando_busca_clinica->fetch(PDO::FETCH_ASSOC);

                // print_r($resultado_clinica_selecionada);

                // ----------------- BUSCA NA API DO IBGE -----------------
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

                // Exemplo: "ALTO ARAGUAIA - MT"
                $recebe_cidade_uf = trim($cidadeNome . ' - ' . $estadoSigla);
                salvarLog("Cidade/UF via IBGE: " . $recebe_cidade_uf);

                // Debug
                // print_r($resultado_clinica_selecionada);
                // echo "<br>Cidade/UF via IBGE: " . $recebe_cidade_uf;

                if (isset($_SESSION['empresa_selecionado']) && $_SESSION['empresa_selecionado'] !== '') {
                    $instrucao_busca_empresa = "select * from empresas_novas where id = :recebe_id_empresa";
                    $comando_busca_empresa = $pdo->prepare($instrucao_busca_empresa);
                    $comando_busca_empresa->bindValue(":recebe_id_empresa", $_SESSION["empresa_selecionado"]);
                    $comando_busca_empresa->execute();
                    $resultado_empresa_selecionada = $comando_busca_empresa->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_empresa_selecionada);

                    // echo "<br>";

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

                    $recebe_nascimento_colaborador = '';

                    $raw = $resultado_pessoa_selecionada['nascimento'] ?? '';
                    if (!empty($raw) && $raw !== '0000-00-00' && $raw !== '0000-00-00 00:00:00') {
                        try {
                            $recebe_nascimento_colaborador = (new DateTime($raw))->format('d/m/Y');
                        } catch (Exception $e) {
                            $recebe_nascimento_colaborador = '';
                        }

                        // Converte para objeto DateTime
                        $dtNascimento = new DateTime($raw);
                        $dtHoje = new DateTime("now");

                        // Calcula a diferença
                        $idade = $dtHoje->diff($dtNascimento)->y;

                        // echo "Idade: " . $idade . " anos";
                    }

                    // var_dump($resultado_pessoa_selecionada);

                    // echo "<br>";

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

                    // var_dump($resultado_cargo_selecionado);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_cargo_selecionado);
                    salvarLog(ob_get_clean());
                }

                if ($recebe_exame === "mudanca") {
                    if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                        ob_start();
                        echo "Cargo:" . $_SESSION["cargo_selecionado"] . "<br>";
                        salvarLog(ob_get_clean());

                        $instrucao_busca_mudanca_cargo = "select * from cargo where id = :recebe_id_cargo";
                        $comando_busca_mudanca_cargo = $pdo->prepare($instrucao_busca_mudanca_cargo);
                        $comando_busca_mudanca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                        $comando_busca_mudanca_cargo->execute();
                        $resultado_mudanca_cargo_selecionado = $comando_busca_mudanca_cargo->fetch(PDO::FETCH_ASSOC);

                        // var_dump($resultado_mudanca_cargo_selecionado);

                        // echo "<br>";

                        ob_start();
                        var_dump($resultado_mudanca_cargo_selecionado);
                        salvarLog(ob_get_clean());
                    }
                }

                if (isset($_SESSION["medico_coordenador_selecionado"]) && $_SESSION["medico_coordenador_selecionado"] !== "") {
                    ob_start();
                    echo "ID Médico coordenador:" . $_SESSION["medico_coordenador_selecionado"];
                    salvarLog(ob_get_clean());

                    $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
                    $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
                    $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador", $_SESSION["medico_coordenador_selecionado"]);
                    $comando_busca_medico_coordenador->execute();
                    $resultado_medico_coordenador_selecionado = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_medico_coordenador_selecionado);

                    ob_start();
                    var_dump($resultado_medico_coordenador_selecionado);
                    salvarLog(ob_get_clean());
                }

                if (isset($_SESSION["medico_clinica_selecionado"]) && $_SESSION["medico_clinica_selecionado"] !== "") {
                    ob_start();
                    echo "ID médico emitente:" . $_SESSION["medico_clinica_selecionado"] . "<br>";
                    salvarLog(ob_get_clean());


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

                    // var_dump($resultado_medico_relacionado_clinica);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_medico_relacionado_clinica);
                    salvarLog(ob_get_clean());
                }

                // ===================== AJUSTE APENAS NOS RISCOS =====================
                $riscosTabela = '';
                $grupos = [
                    "acidente"   => "Acidentes / Mecânicos",
                    "ergonomico" => "Ergonômicos",
                    "fisico"     => "Físicos",
                    "quimico"    => "Químicos",
                    "biologico"  => "Biológicos"
                ];

                // Prepara array vazio para armazenar riscos por grupo
                $riscosPorGrupo = array_fill_keys(array_keys($grupos), []);

                if (isset($_SESSION["medico_risco_selecionado"]) && $_SESSION["medico_risco_selecionado"] !== "") {
                    $data = json_decode($_SESSION["medico_risco_selecionado"], true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        for ($i = 0; $i < count($data); $i++) {
                            $grupo     = strtolower($data[$i]['grupo']);
                            $descricao = $data[$i]['descricao'] ?? "";

                            if (isset($riscosPorGrupo[$grupo])) {
                                $riscosPorGrupo[$grupo][] = $descricao;
                            }
                        }
                    }
                }

                // Monta a tabela de riscos
                $riscosTabela .= '
                <table>
                    <tr>
                        <td colspan="2" class="section-title">FATORES DE RISCO</td>
                    </tr>';
                foreach ($grupos as $chave => $titulo) {
                    $valores = !empty($riscosPorGrupo[$chave]) ? implode(", ", $riscosPorGrupo[$chave]) : "N/A";
                    $riscosTabela .= "
                    <tr>
                        <th style='text-align:left; font-weight:bold; font-size:12px; font-family:Arial, sans-serif; padding:4px;'>{$titulo}</th>
                        <td style='font-size:12px; font-family:Arial, sans-serif; padding:4px;'>{$valores}</td>
                    </tr>";
                }
                $riscosTabela .= '</table>';


                // =====================================================================

                // ===================== AJUSTE NAS APTIDÕES =====================
                $aptidoesTabela = '';

                $listaAptidoes = [
                    "trabalho em altura"            => "Trabalho em Altura",
                    "manusear produtos alimentícios" => "Manusear Produtos Alimentícios",
                    "eletricidade"                  => "Eletricidade",
                    "operar máquinas"               => "Operar Máquinas",
                    "conduzir veículos"             => "Conduzir Veículos",
                    "trabalho a quente"             => "Trabalho a Quente",
                    "inflamáveis"                   => "Inflamáveis",
                    "radiações ionizantes"          => "Radiações Ionizantes",
                    "espaço confinado"              => "Espaço Confinado",
                    "inspeções e manutenções"       => "Inspeções e Manutenções"
                ];

                // transforma o JSON da sessão em array associativo
                $aptidoesSelecionadas = [];
                if (isset($_SESSION["aptidao_selecionado"]) && $_SESSION["aptidao_selecionado"] !== "") {
                    var_dump($_SESSION["aptidao_selecionado"]);


                    $dataApt = json_decode($_SESSION["aptidao_selecionado"], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($dataApt)) {
                        foreach ($dataApt as $apt) {
                            if (isset($apt['nome'])) {
                                $aptidoesSelecionadas[] = strtolower(trim($apt['nome']));
                            }
                        }
                    }
                }

                // função para marcar sim/não
                function marcarApt($nomeExibicao, $aptidoesSelecionadas)
                {
                    $nomeLower = strtolower($nomeExibicao);
                    $sim  = in_array($nomeLower, $aptidoesSelecionadas) ? "X" : " ";
                    $nao  = $sim === "X" ? " " : "X";
                    return "( $sim ) Sim ( $nao ) Não";
                }

                // define os pares para exibição (duas colunas por linha)
                $linhas = [
                    ["Trabalho em Altura", "Manusear Produtos Alimentícios"],
                    ["Eletricidade", "Operar Máquinas"],
                    ["Conduzir Veículos", "Trabalho a Quente"],
                    ["Inflamáveis", "Radiações Ionizantes"],
                    ["Espaço Confinado", "Inspeções e Manutenções"]
                ];

                $aptidoesTabela .= '
                <table>
                    <tr>
                        <td colspan="2" class="section-title">APTIDÕES EXTRAS</td>
                    </tr>';
                foreach ($linhas as $par) {
                    $esq = $par[0] . " " . marcarApt($par[0], $aptidoesSelecionadas);
                    $dir = $par[1] . " " . marcarApt($par[1], $aptidoesSelecionadas);

                    $aptidoesTabela .= '
                    <tr>
                        <td style="width:50%; font-size:12px; padding:4px;">' . $esq . '</td>
                        <td style="width:50%; font-size:12px; padding:4px;">' . $dir . '</td>
                    </tr>';
                }
                $aptidoesTabela .= '
                </table>';

                // =====================================================================


                // Função helper para marcar Apto/Inapto
                function marcarAptidao($nome, $aptidoesSelecionadas)
                {
                    $nomeLower = strtolower($nome);
                    $apto   = in_array($nomeLower, $aptidoesSelecionadas) ? 'X' : ' ';
                    $inapto = in_array($nomeLower, $aptidoesSelecionadas) ? ' ' : 'X';
                    return "$nome ( $apto ) Apto ( $inapto ) Inapto";
                }

                echo '
        <style>
            body {
                font-family: Arial, sans-serif;
                background:#f2f2f2;
                margin:0;
                padding:0;
            }
            .guia-container {
                width: 210mm;
                /*min-height: 297mm;*/
                margin:5mm auto;
                padding:10px;
                background:#fff;
                border:1px solid #000;
            }
            table { width:100%; border-collapse:collapse; font-size:12px; }
            th, td { border:1px solid #000; padding:4px; vertical-align:top; }

            .titulo-guia {
                background:#eaeaea;
                border:1px solid #000;
                font-weight:bold;
                text-align:center;
                font-size:14px;
                padding:5px;
                height:22px;
            }
            .section-title {
                background:#eaeaea;
                border:1px solid #666;
                font-weight:bold;
                font-size:12px;
                padding:3px 5px;
                text-align:left;
            }
            .dados-hospital { font-size:12px; line-height:1.4; }
            .hospital-nome { font-weight:bold; text-transform:uppercase; text-decoration:underline; display:block; margin-bottom:3px; }

            .logo { text-align:center; }
            .logo img { max-height:45px; }

            /* QR Code */
            .qrcode img {
                display:block;
                width:120px;
                height:auto;
                margin-top:5px;
            }

            /* Botões - Centralizados abaixo do formulário */
            .actions {
                margin-top: 15px;
                padding-top: 10px;
                text-align: center;
                border-top: 1px solid #ccc; /* linha de separação opcional */
            }
            .btn {
                padding:10px 18px;
                font-size:14px;
                font-weight:bold;
                border:none;
                border-radius:5px;
                cursor:pointer;
                color:#fff;
                box-shadow:0 2px 5px rgba(0,0,0,.2);
                margin:0 5px;
            }
            .btn-email { background:#007bff; }
            .btn-whatsapp { background:#25d366; }
            .btn-print { background:#6c757d; }
            .btn:hover { opacity:.9; }

            @media print {
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                body { background:#fff; }
                .actions { display: none !important; }
            }

            /* 🔹 Estilo para cabeçalhos de tabelas de riscos */
        .table-riscos th {
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 4px;
            vertical-align: top;
        }
        .table-riscos td {
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 4px;
            vertical-align: top;
        }

        .table-exames th {
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            padding: 4px;
        }

        /* 🔹 Quebra de página forçada */
.page-break {
    page-break-before: always; /* compatível com navegadores antigos */
    break-before: page;        /* compatível com navegadores modernos */
}

        </style>

        <div class="guia-container">
            <table>
                <tr>
                    <th colspan="2" class="titulo-guia">GUIA DE ENCAMINHAMENTO</th>
                </tr>
                <tr>
                    <td class="dados-hospital">
                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
                        ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '
                    </td>
                    <td class="logo">
                        <img src="logo.jpg" alt="Logo">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
                </tr>
                <tr>
                    <td class="dados-hospital" colspan="2">
                        ' . (!empty($resultado_empresa_selecionada['nome'])
                            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                            : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['titulo_cargo']) ? 'CARGO: ' . $resultado_cargo_selecionado['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['codigo_cargo']) ? 'CBO: ' . $resultado_cargo_selecionado['codigo_cargo'] : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">TIPO DE EXAME / PROCEDIMENTO</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; line-height:1.5; padding:5px;">
                        Admissional ' . marcar("admissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Periódico ' . marcar("periodico", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Demissional ' . marcar("demissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">Mudança de Função</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Novo Cargo</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Novo CBO</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">Dados dos Médicos</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico Coordenador</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">CRM</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico Emitente</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">CRM</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "") . '</td>
                </tr>
            </table>

            ' . $riscosTabela . '

            <table class="table-exames">
                <tr>
                    <td colspan="2" class="section-title">PROCEDIMENTOS / EXAMES REALIZADOS</td>
                </tr>
                <tr>
                    <th>Exame</th>
                    <td>' . htmlspecialchars($recebe_exame_exibicao ?? "") . '</td>
                </tr>
                <tr>
                    <th>Data</th>
                    <td>' . htmlspecialchars($dataAtual ?? "") . '</td>
                </tr>
            </table>

            ' . $aptidoesTabela . '
            
            <table>
                <tr>
                    <td colspan="2" class="section-title">09 - CONCLUSÃO</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; padding:4px;">
                        ALTO ARAGUAIA - MT, DATA: ' . htmlspecialchars($dataAtual ?? "") . '
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; padding:4px;">
                        Resultado: ( ) APTO &nbsp;&nbsp; ( ) INAPTO
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:11px; padding:4px;">
                        Médico Responsável - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '/MT
                        <br>
                        Funcionário: ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
                    </td>
                </tr>
            </table>

            <div class="actions">
                <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                <button class="btn btn-print" onclick="printSection(this)">Salvar</button>
            </div>
        </div>

            <div class="page-break"></div> <!-- 🔹 QUEBRA DE PÁGINA -->
         <div class="guia-container">   
            <table>
                <tr>
                    <th colspan="2" class="titulo-guia">PRONTUARIO MÉDICO</th>
                </tr>
                <tr>
                    <td class="dados-hospital">
                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
                        ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '
                    </td>
                    <td class="logo">
                        <img src="logo.jpg" alt="Logo">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
                </tr>
                <tr>
                    <td class="dados-hospital" colspan="2">
                        ' . (!empty($resultado_empresa_selecionada['nome'])
                            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                            : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['titulo_cargo']) ? 'CARGO: ' . $resultado_cargo_selecionado['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['codigo_cargo']) ? 'CBO: ' . $resultado_cargo_selecionado['codigo_cargo'] : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">TIPO DE PRONTUARIO MÉDICO EXAME OCUPACIONAL ANAMNESE CLINICA E PROFISSIONAL</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; line-height:1.5; padding:5px;">
                        Admissional ' . marcar("admissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Periódico ' . marcar("periodico", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Demissional ' . marcar("demissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">Mudança de Função</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Novo Cargo</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Novo CBO</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">Dados dos Médicos</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico Coordenador</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">CRM</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico Emitente</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">CRM</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "") . '</td>
                </tr>
            </table>


            <!-- 🔹 06 - Informações Clínicas -->
            <table>
                <tr>
                    <td colspan="8" class="section-title">INFORMAÇÕES CLÍNICAS</td>
                </tr>
                <tr>
                    <th colspan="2">ANTECEDENTES FAMILIARES</th>
                    <th>SIM</th>
                    <th>NÃO</th>
                    <th colspan="2">ANTECEDENTES PESSOAIS</th>
                    <th>SIM</th>
                    <th>NÃO</th>
                </tr>
                <tr>
                    <td colspan="2">DIABETE (AÇÚCAR NO SANGUE)</td><td></td><td></td>
                    <td colspan="2">ESTEVE EM TRATAMENTO? JÁ TEVE ALGUMA DOENÇA GRAVE?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">ASMA / BRONQUITE / ALERGIA OU URTICÁRIA</td><td></td><td></td>
                    <td colspan="2">FAZ USO DIÁRIO DE ALGUM MEDICAMENTO?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">DOENÇAS MENTAIS OU NERVOSAS</td><td></td><td></td>
                    <td colspan="2">SOFREU ALGUM ACIDENTE?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">EPILEPSIA - ATAQUES</td><td></td><td></td>
                    <td colspan="2">ESTEVE INTERNADO EM HOSPITAL?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">ALCOOLISMO</td><td></td><td></td>
                    <td colspan="2">JÁ FOI OPERADO?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">REUMATISMO</td><td></td><td></td>
                    <td colspan="2">TEM DEFICIÊNCIA OU IMPEDIMENTOS FÍSICOS?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">GASTRITE / ÚLCERA</td><td></td><td></td>
                    <td colspan="2">TRABALHOU EM AMBIENTE COM RUÍDO?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">PRESSÃO ALTA / DOENÇAS DO CORAÇÃO</td><td></td><td></td>
                    <td colspan="2">TEVE ALGUMA CRISE CONVULSIVA (ATAQUE)?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">CÂNCER</td><td></td><td></td>
                    <td colspan="2">TEM DOR DE CABEÇA?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">DERRAME</td><td></td><td></td>
                    <td colspan="2">TEVE TRAUMA OU BATIDA NA CABEÇA? TEM TONTURA?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">HIPERCOLESTEROLEMIA (COLESTEROL ALTO)</td><td></td><td></td>
                    <td colspan="2">TEM ALGUMA ALERGIA (ASMA, RINITE)?</td><td></td><td></td>
                </tr>
                <tr>
                    <td colspan="2">TUBERCULOSE</td><td></td><td></td>
                    <td colspan="2">TEM OU TEVE ALGUMA DOENÇA NO PULMÃO / FALTA DE AR?</td><td></td><td></td>
                </tr>
            </table>

            <!-- 🔹 07 - Hábitos de Vida -->
            <table>
                <tr>
                    <td colspan="8" class="section-title">HÁBITOS DE VIDA</td>
                </tr>
                <tr>
                    <th colspan="2">HÁBITOS DE VIDA</th><th>SIM</th><th>NÃO</th>
                    <th colspan="2"></th><th>SIM</th><th>NÃO</th>
                </tr>
                <tr><td colspan="2">FUMA?</td><td></td><td></td>
                    <td colspan="2">TEM REUMATISMO?</td><td></td><td></td></tr>
                <tr><td colspan="2">TOMA/TOMAVA BEBIDA ALCOÓLICA?</td><td></td><td></td>
                    <td colspan="2">TEM HÉRNIA (SACO RENDIDO)?</td><td></td><td></td></tr>
                <tr><td colspan="2">USA/USAVA DROGA?</td><td></td><td></td>
                    <td colspan="2">TEVE DOENÇA DE CHAGAS?</td><td></td><td></td></tr>
                <tr><td colspan="2">PRATICA ESPORTE?</td><td></td><td></td>
                    <td colspan="2">SENTE CANSAÇO FACILMENTE?</td><td></td><td></td></tr>
                <tr><td colspan="2">DORME BEM?</td><td></td><td></td>
                    <td colspan="2">ESTÁ COM FEBRE OU PERDA DE PESO?</td><td></td><td></td></tr>
            </table>

            <!-- 🔹 08 - Antecedentes Ocupacionais -->
            <table>
                <tr>
                    <td colspan="8" class="section-title">ANTECEDENTES OCUPACIONAIS</td>
                </tr>
                <tr>
                    <th colspan="2">ANTECEDENTES OCUPACIONAIS</th><th>SIM</th><th>NÃO</th>
                    <th colspan="2"></th><th>SIM</th><th>NÃO</th>
                </tr>
                <tr><td colspan="2">JÁ TEVE FRATURAS?</td><td></td><td></td>
                    <td colspan="2">PODE EXECUTAR TAREFAS PESADAS?</td><td></td><td></td></tr>
                <tr><td colspan="2">REALIZA TRABALHO FORA DA EMPRESA?</td><td></td><td></td>
                    <td colspan="2">EXECUTOU TAREFAS INSALUBRES/PERIGOSAS?</td><td></td><td></td></tr>
                <tr><td colspan="2">JÁ ESTEVE DOENTE DEVIDO AO SEU TRABALHO?</td><td></td><td></td>
                    <td colspan="2">POSSUI DIFICULDADE MOTORA?</td><td></td><td></td></tr>
                <tr><td colspan="2">JÁ FOI DEMITIDO POR MOTIVO DE DOENÇA?</td><td></td><td></td>
                    <td colspan="2">JÁ ESTEVE AFASTADO PELO INSS?</td><td></td><td></td></tr>
                <tr><td colspan="2">JÁ TEVE ACIDENTE DE TRABALHO?</td><td></td><td></td>
                    <td colspan="2">PARA MULHERES — DATA DA ÚLTIMA MENSTRUAÇÃO ___/___/____ &nbsp;&nbsp; DATA DO ÚLTIMO PREVENTIVO ___/___/____</td><td></td><td></td></tr>
            </table>

            <!-- 🔹 Declaração -->
            <table>
                <tr>
                    <td colspan="2" class="section-title">DECLARAÇÃO</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; padding:4px;">
                        Declaro como verdade os dados preenchidos neste prontuário.<br>
                        ALTO ARAGUAIA - MT, DATA: ' . htmlspecialchars($dataAtual ?? "") . '
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:11px; padding:4px;">
                        Médico Responsável - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '/MT
                        <br>
                        Funcionário: ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
                    </td>
                </tr>
            </table>

            <br>
            <br>
        
            <table>
                <tr>
                    <th colspan="2" class="titulo-guia">APTIDÃO FÍSICA E MENTAL</th>
                </tr>
            </table>

                        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:6px;">
                <tr>
                    <th style="text-align:left; padding:4px;">Altura</th>
                    <th style="text-align:left; padding:4px;">Peso</th>
                    <th style="text-align:left; padding:4px;">Temperatura</th>
                    <th style="text-align:left; padding:4px;">Pulso</th>
                    <th style="text-align:left; padding:4px;">Pressão Arterial</th>
                </tr>
            </table>

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:6px;">
                <tr>
                    <th style="text-align:left; padding:4px;">Normal</th>
                    <th style="text-align:left; padding:4px;">Anormal</th>
                    <th style="text-align:left; padding:4px;">Observação</th>
                </tr>
                <tr><td colspan="3" style="padding:4px;">Aspecto Geral</td></tr>
                <tr><td colspan="3" style="padding:4px;">Olhos</td></tr>
                <tr><td colspan="3" style="padding:4px;">Otoscopia</td></tr>
                <tr><td colspan="3" style="padding:4px;">Nariz</td></tr>
                <tr><td colspan="3" style="padding:4px;">Boca - Amígdalas - Dentes</td></tr>
                <tr><td colspan="3" style="padding:4px;">Pescoço - Gânglios</td></tr>
                <tr><td colspan="3" style="padding:4px;">Pulmão</td></tr>
                <tr><td colspan="3" style="padding:4px;">Coração</td></tr>
                <tr><td colspan="3" style="padding:4px;">Abdome</td></tr>
                <tr><td colspan="3" style="padding:4px;">Coluna</td></tr>
                <tr><td colspan="3" style="padding:4px;">Membros Superiores</td></tr>
                <tr><td colspan="3" style="padding:4px;">Membros Inferiores</td></tr>
                <tr><td colspan="3" style="padding:4px;">Pele e Faneros</td></tr>
                <tr><td colspan="3" style="padding:4px;">Psiquismo</td></tr>
                <tr><td colspan="3" style="padding:4px;">Exames Complementares</td></tr>
            </table>

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th colspan="2" class="titulo-guia" style="text-align:left;">Preenchimento Obrigatório em Caso de Exame Demissional</th>
                </tr>

                <tr><th colspan="6" style="text-align:left; padding:4px;" class="titulo-guia">Demissional</th></tr>
                <tr><td colspan="6" style="padding:4px;">Adquiriu alguma doença em virtude da função?</td></tr>
                <tr><td colspan="6" style="padding:4px;">Sofreu acidente de trabalho na empresa?</td></tr>
                <tr><td colspan="6" style="padding:4px;">Recebeu EPI da empresa?</td></tr>
                <tr>
                    <td colspan="6" style="padding:4px;">
                        PRESSÃO ARTERIAL: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 
                        PULSO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 
                        TEMPERATURA: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </table>

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th colspan="4" class="titulo-guia" style="text-align:left;">Para Mulheres</th>
                </tr>
                <tr>
                    <th style="text-align:left; padding:4px;width: 160px;">Data da Última Menstruação</th>
                    <td style="padding:4px;width:200px"></td>
                    <th style="text-align:left; padding:4px;width: 160px;">Data do Último Preventivo</th>
                    <td style="padding:4px;width:200px"></td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="2" class="titulo-guia" style="text-align:left;">EXAMES COMPLEMENTARES</th>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="height:60px;">
                        ___________________________________________________________________________________
                    </td>
                </tr>
            </table>



            <table>
                <tr>
                    <th colspan="2" class="titulo-guia" style="text-align:left;">EVOLUÇÃO CLÍNICA</th>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="height:60px;">
                        ___________________________________________________________________________________
                    </td>
                </tr>
            </table>


            <table>
                <tr>
                    <th colspan="2" class="titulo-guia" style="text-align:left;">CONCLUSÃO</th>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="height:60px;">
                        Atesto que o trabalhador acima identificado se submeteu aos exames médicos ocupacionais em cumprimento à NR-07, itens 7.5.19.1 e 7.5.19.2.<br>
                        Resultado: ( ) APTO  ( ) INAPTO
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital">
                        ALTO ARAGUAIA - MT, DATA: ' . htmlspecialchars($dataAtual ?? "") . '
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="height:50px;">
                        <div class="assinatura"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="font-size:10px;">
                        Médico Responsável - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '/MT<br>
                        Funcionário: ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
                    </td>
                </tr>
            </table>
            <div class="actions">
                <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                <button class="btn btn-print" onclick="printSection(this)">Salvar</button>
            </div>
        </div>

            <div class="page-break"></div> <!-- 🔹 QUEBRA DE PÁGINA -->

            <br>
            <br>
        <div class="guia-container">
            <table>
                <tr>
                    <th colspan="2" class="titulo-guia">ASO - Atestado de Saúde Ocupacional</th>
                </tr>
                <tr>
                    <td class="dados-hospital">
                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
                        ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '
                    </td>
                    <td class="logo">
                        <img src="logo.jpg" alt="Logo">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
                </tr>
                <tr>
                    <td class="dados-hospital" colspan="2">
                        ' . (!empty($resultado_empresa_selecionada['nome'])
                            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                            : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['titulo_cargo']) ? 'CARGO: ' . $resultado_cargo_selecionado['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['codigo_cargo']) ? 'CBO: ' . $resultado_cargo_selecionado['codigo_cargo'] : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">TIPO DE PRONTUARIO MÉDICO EXAME OCUPACIONAL ANAMNESE CLINICA E PROFISSIONAL</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; line-height:1.5; padding:5px;">
                        Admissional ' . marcar("admissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Periódico ' . marcar("periodico", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Demissional ' . marcar("demissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">Mudança de Função</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Novo Cargo</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Novo CBO</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">Dados dos Médicos</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico Coordenador</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">CRM</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico Emitente</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "") . '</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;">CRM</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "") . '</td>
                </tr>
            </table>

            ' . $riscosTabela . '

            <table class="table-exames">
                <tr>
                    <td colspan="2" class="section-title">PROCEDIMENTOS / EXAMES REALIZADOS</td>
                </tr>
                <tr>
                    <th>Exame</th>
                    <td>' . htmlspecialchars($recebe_exame_exibicao ?? "") . '</td>
                </tr>
                <tr>
                    <th>Data</th>
                    <td>' . htmlspecialchars($dataAtual ?? "") . '</td>
                </tr>
            </table>

            ' . $aptidoesTabela . '

            <table>
                <tr>
                    <th colspan="2" class="titulo-guia">CONCLUSÃO</th>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="height:60px;">
                        Atesto que o trabalhador foi avaliado conforme NR-07: ( ) APTO ( ) INAPTO<br>
                        Local: ALTO ARAGUAIA-MT — Data: ' . htmlspecialchars($dataAtual ?? "") . '
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="height:50px;">
                        <div class="assinatura"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="font-size:10px;">
                        Médico Responsável - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '/MT<br>
                        Funcionário: ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
                    </td>
                </tr>
            </table>


            <div class="actions">
                <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                <button class="btn btn-print" onclick="printSection(this)">Salvar</button>
            </div>
        </div>

        <script>
function printSection(button) {
    // Pega o conteúdo do formulário específico
    var container = button.closest(".guia-container").outerHTML;

    // Captura o CSS já existente na página
    var styles = document.querySelector("style").outerHTML;

    // Abre nova janela só com esse formulário
    var newWin = window.open("", "_blank", "width=900,height=650");
    newWin.document.write(`
        <html>
        <head>
            <title>Imprimir</title>
            ${styles} <!-- 🔹 Inclui o CSS original -->
            <style>
                body { background:#fff; margin:0; padding:0; }
                .actions { display:none !important; } /* esconde botões */
                
                /* 🔹 Força tamanho A4 e remove cabeçalho/rodapé */
                @page {
                    size: A4;
                    margin: 10mm;
                }
                @page {
                    @top-left { content: none }
                    @top-center { content: none }
                    @top-right { content: none }
                    @bottom-left { content: none }
                    @bottom-center { content: none }
                    @bottom-right { content: none }
                }
            </style>
        </head>
        <body>
            ${container}
        </body>
        </html>
    `);

    newWin.document.close();
    newWin.focus();
    newWin.print();
    newWin.close();
}
</script>



';



            }
        }else if($guia_encaminhamento)
        {

            $informacoes_clinica;

            if (isset($_SESSION['clinica_selecionado']) && $_SESSION['clinica_selecionado'] !== '') {
                salvarLog("id da clinica selecionada:" . $_SESSION["clinica_selecionado"]);
                salvarLog($_SESSION["exame_selecionado"]);

                // echo "id da clinica selecionada:" . $_SESSION["clinica_selecionado"] . "<br>";

                // echo $_SESSION["exame_selecionado"] . "<br>";

                $recebe_exame = $_SESSION["exame_selecionado"];

                $recebe_exame_exibicao;

                if ($recebe_exame === "admissional") {
                    $recebe_exame_exibicao = "Admissional";
                } else if ($recebe_exame === "mudanca") {
                    $recebe_exame_exibicao = "Mudança de função";
                }

                $instrucao_busca_exames_procedimentos_kit = "select * from kits where id = :recebe_id_kit";
                $comando_busca_exames_procedimentos_kit = $pdo->prepare($instrucao_busca_exames_procedimentos_kit);
                $comando_busca_exames_procedimentos_kit->bindValue(":recebe_id_kit",$_SESSION["codigo_kit"]);
                $comando_busca_exames_procedimentos_kit->execute();
                $resultado_busca_exames_procedimentos_kit = $comando_busca_exames_procedimentos_kit->fetchAll(PDO::FETCH_ASSOC);

                //var_dump($resultado_busca_exames_procedimentos_kit[0]["exames_selecionados"]);

                // Pega os exames do resultado
                $examesJson = $resultado_busca_exames_procedimentos_kit[0]["exames_selecionados"] ?? "";
                $linhasExames = "";

                if (!empty($examesJson)) {
                    $exames = json_decode($examesJson, true);
                    if (is_array($exames)) {
                        $coluna = 0;
                        $linhasExames .= "<tr>";
                        
                        foreach ($exames as $exame) {
                            $codigo = $exame['codigo'] ?? '';
                            $nome   = $exame['nome'] ?? '';
                            $dataExame = $dataAtual ?? "__/__/2025";

                            $linhasExames .= "
                                <td style='font-size:12px; line-height:1.4; width:50%;'>
                                    (" . htmlspecialchars($codigo) . ") " . htmlspecialchars($nome) ."
                                </td>
                            ";

                            $coluna++;

                            // quando preencher 2 colunas, fecha a linha
                            if ($coluna % 2 == 0) {
                                $linhasExames .= "</tr><tr>";
                            }
                        }

                        // Se terminou com uma coluna só, fecha linha corretamente
                        if ($coluna % 2 != 0) {
                            $linhasExames .= "<td style='width:50%;'>&nbsp;</td></tr>";
                        } else {
                            $linhasExames .= "</tr>";
                        }
                    }
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                // Função helper para marcar
                function marcar($valor, $tipoExame)
                {
                    return ($tipoExame === strtolower($valor)) ? '(X)' : '( )';
                }

                $instrucao_busca_clinica = "select * from clinicas where id = :recebe_clinica_id";
                $comando_busca_clinica = $pdo->prepare($instrucao_busca_clinica);
                $comando_busca_clinica->bindValue(":recebe_clinica_id", $_SESSION["clinica_selecionado"]);
                $comando_busca_clinica->execute();
                $resultado_clinica_selecionada = $comando_busca_clinica->fetch(PDO::FETCH_ASSOC);

                // print_r($resultado_clinica_selecionada);

                // ----------------- BUSCA NA API DO IBGE -----------------
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

                // Exemplo: "ALTO ARAGUAIA - MT"
                $recebe_cidade_uf = trim($cidadeNome . ' - ' . $estadoSigla);
                salvarLog("Cidade/UF via IBGE: " . $recebe_cidade_uf);

                // Debug
                // print_r($resultado_clinica_selecionada);
                // echo "<br>Cidade/UF via IBGE: " . $recebe_cidade_uf;

                if (isset($_SESSION['empresa_selecionado']) && $_SESSION['empresa_selecionado'] !== '') {
                    $instrucao_busca_empresa = "select * from empresas_novas where id = :recebe_id_empresa";
                    $comando_busca_empresa = $pdo->prepare($instrucao_busca_empresa);
                    $comando_busca_empresa->bindValue(":recebe_id_empresa", $_SESSION["empresa_selecionado"]);
                    $comando_busca_empresa->execute();
                    $resultado_empresa_selecionada = $comando_busca_empresa->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_empresa_selecionada);

                    // echo "<br>";

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

                    $recebe_nascimento_colaborador = '';

                    $raw = $resultado_pessoa_selecionada['nascimento'] ?? '';
                    if (!empty($raw) && $raw !== '0000-00-00' && $raw !== '0000-00-00 00:00:00') {
                        try {
                            $recebe_nascimento_colaborador = (new DateTime($raw))->format('d/m/Y');
                        } catch (Exception $e) {
                            $recebe_nascimento_colaborador = '';
                        }

                        // Converte para objeto DateTime
                        $dtNascimento = new DateTime($raw);
                        $dtHoje = new DateTime("now");

                        // Calcula a diferença
                        $idade = $dtHoje->diff($dtNascimento)->y;

                        // echo "Idade: " . $idade . " anos";
                    }

                    // var_dump($resultado_pessoa_selecionada);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_pessoa_selecionada);
                    salvarLog(ob_get_clean());

                    $instrucao_busca_cargo_pessoa = "select * from cargo where id_pessoa = :recebe_id_pessoa";
                    $comando_busca_cargo_pessoa = $pdo->prepare($instrucao_busca_cargo_pessoa);
                    $comando_busca_cargo_pessoa->bindValue(":recebe_id_pessoa",$resultado_pessoa_selecionada["id"]);
                    $comando_busca_cargo_pessoa->execute();
                    $resultado_busca_cargo_pessoa = $comando_busca_cargo_pessoa->fetch(PDO::FETCH_ASSOC);

                    if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                        $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
                        $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
                        $comando_busca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                        $comando_busca_cargo->execute();
                        $resultado_cargo_selecionado = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);

                        // var_dump($resultado_cargo_selecionado);

                        // echo "<br>";

                        ob_start();
                        var_dump($resultado_cargo_selecionado);
                        salvarLog(ob_get_clean());
                    }

                if ($recebe_exame === "mudanca") {
                    if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                        ob_start();
                        echo "Cargo:" . $_SESSION["cargo_selecionado"] . "<br>";
                        salvarLog(ob_get_clean());

                        $instrucao_busca_mudanca_cargo = "select * from cargo where id = :recebe_id_cargo";
                        $comando_busca_mudanca_cargo = $pdo->prepare($instrucao_busca_mudanca_cargo);
                        $comando_busca_mudanca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                        $comando_busca_mudanca_cargo->execute();
                        $resultado_mudanca_cargo_selecionado = $comando_busca_mudanca_cargo->fetch(PDO::FETCH_ASSOC);

                        // var_dump($resultado_mudanca_cargo_selecionado);

                        // echo "<br>";

                        ob_start();
                        var_dump($resultado_mudanca_cargo_selecionado);
                        salvarLog(ob_get_clean());
                    }
                }

                if (isset($_SESSION["medico_coordenador_selecionado"]) && $_SESSION["medico_coordenador_selecionado"] !== "") {
                    ob_start();
                    echo "ID Médico coordenador:" . $_SESSION["medico_coordenador_selecionado"];
                    salvarLog(ob_get_clean());

                    $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
                    $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
                    $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador", $_SESSION["medico_coordenador_selecionado"]);
                    $comando_busca_medico_coordenador->execute();
                    $resultado_medico_coordenador_selecionado = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_medico_coordenador_selecionado);

                    ob_start();
                    var_dump($resultado_medico_coordenador_selecionado);
                    salvarLog(ob_get_clean());
                }

                if (isset($_SESSION["medico_clinica_selecionado"]) && $_SESSION["medico_clinica_selecionado"] !== "") {
                    ob_start();
                    echo "ID médico emitente:" . $_SESSION["medico_clinica_selecionado"] . "<br>";
                    salvarLog(ob_get_clean());


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

                    // var_dump($resultado_medico_relacionado_clinica);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_medico_relacionado_clinica);
                    salvarLog(ob_get_clean());

                    //var_dump($resultado_medico_relacionado_clinica);

                    $instrucao_verifica_marcacao_assinatura_digital = "select * from kits where id = :recebe_id_kit";
                    $comando_verifica_marcacao_assinatura_digital = $pdo->prepare($instrucao_verifica_marcacao_assinatura_digital);
                    $comando_verifica_marcacao_assinatura_digital->bindValue(":recebe_id_kit",$_SESSION["codigo_kit"]);
                    $comando_verifica_marcacao_assinatura_digital->execute();
                    $resultado_verifica_marcacao_assinatura_digital = $comando_verifica_marcacao_assinatura_digital->fetch(PDO::FETCH_ASSOC);

                    //var_dump($resultado_verifica_marcacao_assinatura_digital);

                    if ($resultado_verifica_marcacao_assinatura_digital["assinatura_digital"] === "Sim") {
                        // supondo que o campo no banco seja "assinatura" com o nome do arquivo
                                        $html_assinatura = "<img src='assinaturas/" 
                        . htmlspecialchars($resultado_medico_relacionado_clinica['imagem_assinatura'] ?? '') 
                        . "' alt='Assinatura do Médico' class='assinatura'>";
                    } else {
                        $html_assinatura = "_______________________________";
                    }
                }

                // ===================== AJUSTE APENAS NOS RISCOS =====================
                $riscosTabela = '';
                $grupos = [
                    "acidente"   => "Acidentes / Mecânicos",
                    "ergonomico" => "Ergonômicos",
                    "fisico"     => "Físicos",
                    "quimico"    => "Químicos",
                    "biologico"  => "Biológicos"
                ];

                // Prepara array vazio para armazenar riscos por grupo
                $riscosPorGrupo = array_fill_keys(array_keys($grupos), []);

                if (isset($_SESSION["medico_risco_selecionado"]) && $_SESSION["medico_risco_selecionado"] !== "") {
                    $data = json_decode($_SESSION["medico_risco_selecionado"], true);

                    // var_dump($data);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        for ($i = 0; $i < count($data); $i++) {
                            $grupo     = strtolower($data[$i]['grupo']);
                            $codigo    = $data[$i]['codigo'] ?? "";       // <-- Novo
                            $descricao = $data[$i]['descricao'] ?? "";

                            if (isset($riscosPorGrupo[$grupo])) {
                                // Exibir código + descrição
                                $texto = trim($codigo . " - " . $descricao);
                                $riscosPorGrupo[$grupo][] = $texto;
                            }
                        }
                    }
                }

                // Monta a tabela de riscos
                $riscosTabela .= '
                <table>
                    <tr>
                        <td colspan="2" class="section-title">DESCRIÇÃO DE FATOR DE RISCOS DE ACORDO PGR/PCMSO</td>
                    </tr>';
                foreach ($grupos as $chave => $titulo) {
                    $valores = !empty($riscosPorGrupo[$chave]) ? implode(", ", $riscosPorGrupo[$chave]) : "N/A";
                    $riscosTabela .= "
                    <tr>
                        <th style='text-align:left; font-weight:bold; font-size:12px; font-family:Arial, sans-serif; padding:4px;width: 80px;'>{$titulo}</th>
                        <td style='font-size:12px; font-family:Arial, sans-serif; padding:4px;'>{$valores}</td>
                    </tr>";
                }
                $riscosTabela .= '</table>';



                // =====================================================================

                // ===================== AJUSTE NAS APTIDÕES =====================
                $aptidoesTabela = '';

                // busca aptidões do banco
                $instrucao_busca_aptidoes = "SELECT * FROM aptidao_extra WHERE empresa_id = :recebe_empresa_id";
                $comando_busca_aptidoes = $pdo->prepare($instrucao_busca_aptidoes);
                $comando_busca_aptidoes->bindValue(":recebe_empresa_id", $_SESSION["empresa_id"]);
                $comando_busca_aptidoes->execute();
                $resultado_busca_aptidoes = $comando_busca_aptidoes->fetchAll(PDO::FETCH_ASSOC);

                // cria lista de aptidões a partir do banco (id => nome)
                $listaAptidoes = [];
                foreach ($resultado_busca_aptidoes as $apt) {
                    $listaAptidoes[$apt['id']] = trim($apt['nome']); // ajuste conforme nome da coluna no banco
                }

                // transforma o JSON da sessão em array associativo
                $aptidoesSelecionadas = [];
                if (isset($_SESSION["aptidao_selecionado"]) && $_SESSION["aptidao_selecionado"] !== "") {
                    $dataApt = json_decode($_SESSION["aptidao_selecionado"], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($dataApt)) {
                        foreach ($dataApt as $apt) {
                            if (isset($apt['nome'])) {
                                $aptidoesSelecionadas[] = strtolower(trim($apt['nome']));
                            }
                        }
                    }
                }

                // função para marcar Sim/Não
                function marcarAptidao($nome, $aptidoesSelecionadas)
                {
                    $nomeLower = strtolower(trim($nome));
                    $sim  = in_array($nomeLower, $aptidoesSelecionadas) ? "X" : " ";
                    $nao  = $sim === "X" ? " " : "X";
                    return htmlspecialchars($nome) . " ( $sim ) Sim ( $nao ) Não";
                }

                // gerar tabela apenas com as selecionadas
                $aptidoesTabela .= '
                <table>
                    <tr>
                        <td colspan="2" class="section-title">Observações Importantes - Aptidões Extras</td>
                    </tr>';

                $aptidoesFiltradas = [];
                foreach ($listaAptidoes as $nome) {
                    if (in_array(strtolower($nome), $aptidoesSelecionadas)) {
                        $aptidoesFiltradas[] = $nome;
                    }
                }

                // gerar com 2 colunas por linha
                for ($i = 0; $i < count($aptidoesFiltradas); $i += 2) {
                    $esq = marcarAptidao($aptidoesFiltradas[$i], $aptidoesSelecionadas);

                    $dir = "&nbsp;";
                    if (isset($aptidoesFiltradas[$i + 1])) {
                        $dir = marcarAptidao($aptidoesFiltradas[$i + 1], $aptidoesSelecionadas);
                    }

                    $aptidoesTabela .= '
                    <tr>
                        <td style="width:50%; font-size:12px; padding:4px;">' . $esq . '</td>
                        <td style="width:50%; font-size:12px; padding:4px;">' . $dir . '</td>
                    </tr>';
                }

                $aptidoesTabela .= '
                </table>';


                }
            }

            echo '
        <style>
            body {
                font-family: Arial, sans-serif;
                background:#f2f2f2;
                margin:0;
                padding:0;
            }
            .guia-container {
                width: 210mm;
                min-height: 297mm;
                margin:5mm auto;
                padding:10px;
                background:#fff;
                border:1px solid #000;
            }
            table { width:100%; border-collapse:collapse; font-size:12px; }
            th, td { border:1px solid #000; padding:4px; vertical-align:top; }

            .titulo-guia {
                background:#eaeaea;
                border:1px solid #000;
                font-weight:bold;
                text-align:center;
                font-size:14px;
                padding:5px;
                height:22px;
            }
            .section-title {
                background:#eaeaea;
                border:1px solid #666;
                font-weight:bold;
                font-size:12px;
                padding:3px 5px;
                text-align:left;
            }
            .dados-hospital { font-size:12px; line-height:1.4; }
            .hospital-nome { font-weight:bold; text-transform:uppercase; text-decoration:underline; display:block; margin-bottom:3px; }

            .logo { text-align:center; }
            .logo img { max-height:45px; }

            /* QR Code */
            .qrcode img {
                display:block;
                width:120px;
                height:auto;
                margin-top:5px;
            }

            /* Botões - Centralizados abaixo do formulário */
            .actions {
                margin-top: 15px;
                padding-top: 10px;
                text-align: center;
                border-top: 1px solid #ccc; /* linha de separação opcional */
            }
            .btn {
                padding:10px 18px;
                font-size:14px;
                font-weight:bold;
                border:none;
                border-radius:5px;
                cursor:pointer;
                color:#fff;
                box-shadow:0 2px 5px rgba(0,0,0,.2);
                margin:0 5px;
            }
            .btn-email { background:#007bff; }
            .btn-whatsapp { background:#25d366; }
            .btn-print { background:#6c757d; }
            .btn:hover { opacity:.9; }

            @media print {
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                body { background:#fff; }
                .actions { display: none !important; }
            }

            /* 🔹 Estilo para cabeçalhos de tabelas de riscos */
        .table-riscos th {
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 4px;
            vertical-align: top;
        }
        .table-riscos td {
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 4px;
            vertical-align: top;
        }

        .table-exames th {
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            padding: 4px;
        }

        .assinatura {
                width: 150px;
    height: 60px;
    border-bottom: 1px solid #000;
    display: block;
    margin: 0px auto 5px auto;
        }

        .legenda {
            text-align: center;
            font-size: 14px;
        }


        </style>

        <div class="guia-container">
            <table>
                <tr>
                    <th colspan="2" class="titulo-guia">GUIA DE ENCAMINHAMENTO</th>
                </tr>
                <tr>
                    <td class="dados-hospital">
                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
                        ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '
                    </td>
                    <td class="logo">
                        <img src="logo.jpg" alt="Logo">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
                </tr>
                <tr>
                    <td class="dados-hospital" colspan="2">
                        ' . (!empty($resultado_empresa_selecionada['nome'])
                            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                            : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">TIPO DE EXAME / PROCEDIMENTO</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; line-height:1.5; padding:5px;">
                        Admissional ' . marcar("admissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Periódico ' . marcar("periodico", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Demissional ' . marcar("demissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '
                    </td>
                </tr>
            </table>';

            if (
                isset($resultado_mudanca_cargo_selecionado) 
                && !empty($resultado_mudanca_cargo_selecionado)
            ) {
                echo '
                    <table> 
                        <tr>
                            <td colspan="2" class="section-title">Mudança de Função</td>
                        </tr>
                        <tr>
                            <th style="font-size:12px; text-align:left;">Novo Cargo</th>
                            <td style="font-size:12px; line-height:1.4; text-align:left;">' . 
                                htmlspecialchars($resultado_mudanca_cargo_selecionado['titulo_cargo'] ?? "") . 
                            '</td>
                        </tr>
                        <tr>
                            <th style="font-size:12px; text-align:left;">Novo CBO</th>
                            <td style="font-size:12px; line-height:1.4; text-align:left;">' . 
                                htmlspecialchars($resultado_mudanca_cargo_selecionado['codigo_cargo'] ?? "") . 
                            '</td>
                        </tr>
                    </table>
                ';
            }

            $nomeCoord = htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "");
            $crmCoord  = htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "");
            $textoCoord = $nomeCoord . (!empty($nomeCoord) && !empty($crmCoord) ? " / " : "") . $crmCoord;

            $nomeExam = htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "");
            $crmExam  = htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "");
            $textoExam = $nomeExam . (!empty($nomeExam) && !empty($crmExam) ? " / " : "") . $crmExam;

            echo '
            <table>
                <tr>
                    <td colspan="2" class="section-title">Dados dos Médicos</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;width: 185px;">Médico coordenador do PCMSO</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . $textoCoord . '</td>
                </tr>
                
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico emitente/examinador</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . $textoExam . '</td>
                </tr>
            </table>

            ' . $riscosTabela . '

            <table class="table-exames" style="width:100%; border-collapse:collapse;">
                <tr>
                    <td colspan="2" class="section-title" style="text-align:left; font-size:12px; font-weight:bold;">
                        Procedimentos e Exames a realizar
                    </td>
                </tr>
                    ' . $linhasExames .'
            </table>

            ' . $aptidoesTabela . '
            
            
        </div>';

        echo '
            <div class="actions">
                <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                <button class="btn btn-print" onclick="window.print()">Salvar</button>
            </div>
        ';
        }else if($aso)
        {
            $informacoes_clinica;

            if (isset($_SESSION['clinica_selecionado']) && $_SESSION['clinica_selecionado'] !== '') {
                salvarLog("id da clinica selecionada:" . $_SESSION["clinica_selecionado"]);
                salvarLog($_SESSION["exame_selecionado"]);

                // echo "id da clinica selecionada:" . $_SESSION["clinica_selecionado"] . "<br>";

                // echo $_SESSION["exame_selecionado"] . "<br>";

                $recebe_exame = $_SESSION["exame_selecionado"];

                $recebe_exame_exibicao;

                if ($recebe_exame === "admissional") {
                    $recebe_exame_exibicao = "Admissional";
                } else if ($recebe_exame === "mudanca") {
                    $recebe_exame_exibicao = "Mudança de função";
                }

                $instrucao_busca_exames_procedimentos_kit = "select * from kits where id = :recebe_id_kit";
                $comando_busca_exames_procedimentos_kit = $pdo->prepare($instrucao_busca_exames_procedimentos_kit);
                $comando_busca_exames_procedimentos_kit->bindValue(":recebe_id_kit",$_SESSION["codigo_kit"]);
                $comando_busca_exames_procedimentos_kit->execute();
                $resultado_busca_exames_procedimentos_kit = $comando_busca_exames_procedimentos_kit->fetchAll(PDO::FETCH_ASSOC);

                //var_dump($resultado_busca_exames_procedimentos_kit[0]["exames_selecionados"]);

                // Pega os exames do resultado
                $examesJson = $resultado_busca_exames_procedimentos_kit[0]["exames_selecionados"] ?? "";
                $linhasExames = "";

                if (!empty($examesJson)) {
                    $exames = json_decode($examesJson, true);
                    if (is_array($exames)) {
                    $coluna = 0;
                    $linhasExames .= "<tr>";
                    
                    foreach ($exames as $exame) {
                        $codigo = $exame['codigo'] ?? '';
                        $nome   = $exame['nome'] ?? '';
                        $dataExame = $dataAtual ?? "__/__/2025";

                        $linhasExames .= "
                            <td style='font-size:12px; line-height:1.4; width:50%;'>
                                (" . htmlspecialchars($codigo) . ") " . htmlspecialchars($nome) . " " . htmlspecialchars($dataExame) . "
                            </td>
                        ";

                        $coluna++;

                        // quando preencher 2 colunas, fecha a linha
                        if ($coluna % 2 == 0) {
                            $linhasExames .= "</tr><tr>";
                        }
                    }

                    // Se terminou com uma coluna só, fecha linha corretamente
                    if ($coluna % 2 != 0) {
                        $linhasExames .= "<td style='width:50%;'>&nbsp;</td></tr>";
                    } else {
                        $linhasExames .= "</tr>";
                    }
                }
            }

                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                // Função helper para marcar
                function marcar($valor, $tipoExame)
                {
                    return ($tipoExame === strtolower($valor)) ? '(X)' : '( )';
                }

                $instrucao_busca_clinica = "select * from clinicas where id = :recebe_clinica_id";
                $comando_busca_clinica = $pdo->prepare($instrucao_busca_clinica);
                $comando_busca_clinica->bindValue(":recebe_clinica_id", $_SESSION["clinica_selecionado"]);
                $comando_busca_clinica->execute();
                $resultado_clinica_selecionada = $comando_busca_clinica->fetch(PDO::FETCH_ASSOC);

                // print_r($resultado_clinica_selecionada);

                // ----------------- BUSCA NA API DO IBGE -----------------
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

                // Exemplo: "ALTO ARAGUAIA - MT"
                $recebe_cidade_uf = trim($cidadeNome . ' - ' . $estadoSigla);
                salvarLog("Cidade/UF via IBGE: " . $recebe_cidade_uf);

                // Debug
                // print_r($resultado_clinica_selecionada);
                // echo "<br>Cidade/UF via IBGE: " . $recebe_cidade_uf;

                if (isset($_SESSION['empresa_selecionado']) && $_SESSION['empresa_selecionado'] !== '') {
                    $instrucao_busca_empresa = "select * from empresas_novas where id = :recebe_id_empresa";
                    $comando_busca_empresa = $pdo->prepare($instrucao_busca_empresa);
                    $comando_busca_empresa->bindValue(":recebe_id_empresa", $_SESSION["empresa_selecionado"]);
                    $comando_busca_empresa->execute();
                    $resultado_empresa_selecionada = $comando_busca_empresa->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_empresa_selecionada);

                    // echo "<br>";

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

                    $recebe_nascimento_colaborador = '';

                    $raw = $resultado_pessoa_selecionada['nascimento'] ?? '';
                    if (!empty($raw) && $raw !== '0000-00-00' && $raw !== '0000-00-00 00:00:00') {
                        try {
                            $recebe_nascimento_colaborador = (new DateTime($raw))->format('d/m/Y');
                        } catch (Exception $e) {
                            $recebe_nascimento_colaborador = '';
                        }

                        // Converte para objeto DateTime
                        $dtNascimento = new DateTime($raw);
                        $dtHoje = new DateTime("now");

                        // Calcula a diferença
                        $idade = $dtHoje->diff($dtNascimento)->y;

                        // echo "Idade: " . $idade . " anos";
                    }

                    // var_dump($resultado_pessoa_selecionada);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_pessoa_selecionada);
                    salvarLog(ob_get_clean());

                    $instrucao_busca_cargo_pessoa = "select * from cargo where id_pessoa = :recebe_id_pessoa";
                    $comando_busca_cargo_pessoa = $pdo->prepare($instrucao_busca_cargo_pessoa);
                    $comando_busca_cargo_pessoa->bindValue(":recebe_id_pessoa",$resultado_pessoa_selecionada["id"]);
                    $comando_busca_cargo_pessoa->execute();
                    $resultado_busca_cargo_pessoa = $comando_busca_cargo_pessoa->fetch(PDO::FETCH_ASSOC);
                }

                if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                    $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
                    $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
                    $comando_busca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                    $comando_busca_cargo->execute();
                    $resultado_cargo_selecionado = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_cargo_selecionado);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_cargo_selecionado);
                    salvarLog(ob_get_clean());
                }

                if ($recebe_exame === "mudanca") {
                    if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                        ob_start();
                        echo "Cargo:" . $_SESSION["cargo_selecionado"] . "<br>";
                        salvarLog(ob_get_clean());

                        $instrucao_busca_mudanca_cargo = "select * from cargo where id = :recebe_id_cargo";
                        $comando_busca_mudanca_cargo = $pdo->prepare($instrucao_busca_mudanca_cargo);
                        $comando_busca_mudanca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                        $comando_busca_mudanca_cargo->execute();
                        $resultado_mudanca_cargo_selecionado = $comando_busca_mudanca_cargo->fetch(PDO::FETCH_ASSOC);

                        // var_dump($resultado_mudanca_cargo_selecionado);

                        // echo "<br>";

                        ob_start();
                        var_dump($resultado_mudanca_cargo_selecionado);
                        salvarLog(ob_get_clean());
                    }
                }

                if (isset($_SESSION["medico_coordenador_selecionado"]) && $_SESSION["medico_coordenador_selecionado"] !== "") {
                    ob_start();
                    echo "ID Médico coordenador:" . $_SESSION["medico_coordenador_selecionado"];
                    salvarLog(ob_get_clean());

                    $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
                    $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
                    $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador", $_SESSION["medico_coordenador_selecionado"]);
                    $comando_busca_medico_coordenador->execute();
                    $resultado_medico_coordenador_selecionado = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_medico_coordenador_selecionado);

                    ob_start();
                    var_dump($resultado_medico_coordenador_selecionado);
                    salvarLog(ob_get_clean());
                }

                if (isset($_SESSION["medico_clinica_selecionado"]) && $_SESSION["medico_clinica_selecionado"] !== "") {
                    ob_start();
                    echo "ID médico emitente:" . $_SESSION["medico_clinica_selecionado"] . "<br>";
                    salvarLog(ob_get_clean());


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

                    // var_dump($resultado_medico_relacionado_clinica);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_medico_relacionado_clinica);
                    salvarLog(ob_get_clean());

                    $instrucao_verifica_marcacao_assinatura_digital = "select * from kits where id = :recebe_id_kit";
                    $comando_verifica_marcacao_assinatura_digital = $pdo->prepare($instrucao_verifica_marcacao_assinatura_digital);
                    $comando_verifica_marcacao_assinatura_digital->bindValue(":recebe_id_kit",$_SESSION["codigo_kit"]);
                    $comando_verifica_marcacao_assinatura_digital->execute();
                    $resultado_verifica_marcacao_assinatura_digital = $comando_verifica_marcacao_assinatura_digital->fetch(PDO::FETCH_ASSOC);

                    //var_dump($resultado_verifica_marcacao_assinatura_digital);

                    if ($resultado_verifica_marcacao_assinatura_digital["assinatura_digital"] === "Sim") {
                        // supondo que o campo no banco seja "assinatura" com o nome do arquivo
                                        $html_assinatura = "<img src='assinaturas/" 
                        . htmlspecialchars($resultado_medico_relacionado_clinica['imagem_assinatura'] ?? '') 
                        . "' alt='Assinatura do Médico' class='assinatura'>";
                    } else {
                        $html_assinatura = "_______________________________";
                    }
                }

                // ===================== AJUSTE APENAS NOS RISCOS =====================
                $riscosTabela = '';
                $grupos = [
                    "acidente"   => "Acidentes / Mecânicos",
                    "ergonomico" => "Ergonômicos",
                    "fisico"     => "Físicos",
                    "quimico"    => "Químicos",
                    "biologico"  => "Biológicos"
                ];

                // Prepara array vazio para armazenar riscos por grupo
                $riscosPorGrupo = array_fill_keys(array_keys($grupos), []);

                if (isset($_SESSION["medico_risco_selecionado"]) && $_SESSION["medico_risco_selecionado"] !== "") {
                    $data = json_decode($_SESSION["medico_risco_selecionado"], true);

                    // var_dump($data);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        for ($i = 0; $i < count($data); $i++) {
                            $grupo     = strtolower($data[$i]['grupo']);
                            $codigo    = $data[$i]['codigo'] ?? "";       // <-- Novo
                            $descricao = $data[$i]['descricao'] ?? "";

                            if (isset($riscosPorGrupo[$grupo])) {
                                // Exibir código + descrição
                                $texto = trim($codigo . " - " . $descricao);
                                $riscosPorGrupo[$grupo][] = $texto;
                            }
                        }
                    }
                }

                // Monta a tabela de riscos
                $riscosTabela .= '
                <table>
                    <tr>
                        <td colspan="2" class="section-title">DESCRIÇÃO DE FATOR DE RISCOS DE ACORDO PGR/PCMSO</td>
                    </tr>';
                foreach ($grupos as $chave => $titulo) {
                    $valores = !empty($riscosPorGrupo[$chave]) ? implode(", ", $riscosPorGrupo[$chave]) : "N/A";
                    $riscosTabela .= "
                    <tr>
                        <th style='text-align:left; font-weight:bold; font-size:12px; font-family:Arial, sans-serif; padding:4px;width: 80px;'>{$titulo}</th>
                        <td style='font-size:12px; font-family:Arial, sans-serif; padding:4px;'>{$valores}</td>
                    </tr>";
                }
                $riscosTabela .= '</table>';


                // =====================================================================

                // ===================== AJUSTE NAS APTIDÕES =====================
                $aptidoesTabela = '';

                // busca aptidões do banco
                $instrucao_busca_aptidoes = "SELECT * FROM aptidao_extra WHERE empresa_id = :recebe_empresa_id";
                $comando_busca_aptidoes = $pdo->prepare($instrucao_busca_aptidoes);
                $comando_busca_aptidoes->bindValue(":recebe_empresa_id", $_SESSION["empresa_id"]);
                $comando_busca_aptidoes->execute();
                $resultado_busca_aptidoes = $comando_busca_aptidoes->fetchAll(PDO::FETCH_ASSOC);

                // cria lista de aptidões a partir do banco (id => nome)
                $listaAptidoes = [];
                foreach ($resultado_busca_aptidoes as $apt) {
                    $listaAptidoes[$apt['id']] = trim($apt['nome']); // ajuste conforme nome da coluna no banco
                }

                // transforma o JSON da sessão em array associativo
                $aptidoesSelecionadas = [];
                if (isset($_SESSION["aptidao_selecionado"]) && $_SESSION["aptidao_selecionado"] !== "") {
                    $dataApt = json_decode($_SESSION["aptidao_selecionado"], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($dataApt)) {
                        foreach ($dataApt as $apt) {
                            if (isset($apt['nome'])) {
                                $aptidoesSelecionadas[] = strtolower(trim($apt['nome']));
                            }
                        }
                    }
                }

                // função para marcar Sim/Não
                function marcarAptidao($nome, $aptidoesSelecionadas)
                {
                    $nomeLower = strtolower(trim($nome));
                    $sim  = in_array($nomeLower, $aptidoesSelecionadas) ? "X" : " ";
                    $nao  = $sim === "X" ? " " : "X";
                    return htmlspecialchars($nome) . " ( $sim ) Sim ( $nao ) Não";
                }

                // gerar tabela apenas com as selecionadas
                $aptidoesTabela .= '
                <table>
                    <tr>
                        <td colspan="2" class="section-title">APTIDÕES EXTRAS</td>
                    </tr>';

                $aptidoesFiltradas = [];
                foreach ($listaAptidoes as $nome) {
                    if (in_array(strtolower($nome), $aptidoesSelecionadas)) {
                        $aptidoesFiltradas[] = $nome;
                    }
                }

                // gerar com 2 colunas por linha
                for ($i = 0; $i < count($aptidoesFiltradas); $i += 2) {
                    $esq = marcarAptidao($aptidoesFiltradas[$i], $aptidoesSelecionadas);

                    $dir = "&nbsp;";
                    if (isset($aptidoesFiltradas[$i + 1])) {
                        $dir = marcarAptidao($aptidoesFiltradas[$i + 1], $aptidoesSelecionadas);
                    }

                    $aptidoesTabela .= '
                    <tr>
                        <td style="width:50%; font-size:12px; padding:4px;">' . $esq . '</td>
                        <td style="width:50%; font-size:12px; padding:4px;">' . $dir . '</td>
                    </tr>';
                }

                $aptidoesTabela .= '
                </table>';
            }

            echo '
        <style>
            body {
                font-family: Arial, sans-serif;
                background:#f2f2f2;
                margin:0;
                padding:0;
            }
            .guia-container {
                width: 210mm;
                min-height: 297mm;
                margin:5mm auto;
                padding:10px;
                background:#fff;
                border:1px solid #000;
            }
            table { width:100%; border-collapse:collapse; font-size:12px; }
            th, td { border:1px solid #000; padding:4px; vertical-align:top; }

            .titulo-guia {
                background:#eaeaea;
                border:1px solid #000;
                font-weight:bold;
                text-align:center;
                font-size:14px;
                padding:5px;
                height:22px;
            }
            .section-title {
                background:#eaeaea;
                border:1px solid #666;
                font-weight:bold;
                font-size:12px;
                padding:3px 5px;
                text-align:left;
            }
            .dados-hospital { font-size:12px; line-height:1.4; }
            .hospital-nome { font-weight:bold; text-transform:uppercase; text-decoration:underline; display:block; margin-bottom:3px; }

            .logo { text-align:center; }
            .logo img { max-height:45px; }

            /* QR Code */
            .qrcode img {
                display:block;
                width:120px;
                height:auto;
                margin-top:5px;
            }

            /* Botões - Centralizados abaixo do formulário */
            .actions {
                margin-top: 15px;
                padding-top: 10px;
                text-align: center;
                border-top: 1px solid #ccc; /* linha de separação opcional */
            }
            .btn {
                padding:10px 18px;
                font-size:14px;
                font-weight:bold;
                border:none;
                border-radius:5px;
                cursor:pointer;
                color:#fff;
                box-shadow:0 2px 5px rgba(0,0,0,.2);
                margin:0 5px;
            }
            .btn-email { background:#007bff; }
            .btn-whatsapp { background:#25d366; }
            .btn-print { background:#6c757d; }
            .btn:hover { opacity:.9; }

            @media print {
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                body { background:#fff; }
                .actions { display: none !important; }
            }

            /* 🔹 Estilo para cabeçalhos de tabelas de riscos */
        .table-riscos th {
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 4px;
            vertical-align: top;
        }
        .table-riscos td {
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 4px;
            vertical-align: top;
        }

        .table-exames th {
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            padding: 4px;
        }

        .assinatura {
            width: 150px;
            height: 60px;
            border-bottom: 1px solid #000;
            display: block;
            margin: 0px auto 5px auto;
        }

        .legenda {
            text-align: center;
            font-size: 14px;
        }

        .assinatura {
                width: 150px;
    height: 60px;
    border-bottom: 1px solid #000;
    display: block;
    margin: 0px auto 5px auto;
        }


        </style>

        <div class="guia-container">
            <table>
                <tr>
                    <th colspan="2" class="titulo-guia">ASO - Atestado de Saúde Ocupacional</th>
                </tr>
                <tr>
                    <td class="dados-hospital">
                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
                        ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '
                    </td>
                    <td class="logo">
                        <img src="logo.jpg" alt="Logo">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
                </tr>
                <tr>
                    <td class="dados-hospital" colspan="2">
                        ' . (!empty($resultado_empresa_selecionada['nome'])
                            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                            : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>
                </tr>
            </table>            

            <table>
                <tr>
                    <td colspan="2" class="section-title">TIPO DE PRONTUARIO MÉDICO EXAME OCUPACIONAL ANAMNESE CLINICA E PROFISSIONAL</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; line-height:1.5; padding:5px;">
                        Admissional ' . marcar("admissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Periódico ' . marcar("periodico", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Demissional ' . marcar("demissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '
                    </td>
                </tr>
            </table>';

            if (
                isset($resultado_mudanca_cargo_selecionado) 
                && !empty($resultado_mudanca_cargo_selecionado)
            ) {
                echo '
                    <table> 
                        <tr>
                            <td colspan="2" class="section-title">Mudança de Função</td>
                        </tr>
                        <tr>
                            <th style="font-size:12px; text-align:left;">Novo Cargo</th>
                            <td style="font-size:12px; line-height:1.4; text-align:left;">' . 
                                htmlspecialchars($resultado_mudanca_cargo_selecionado['titulo_cargo'] ?? "") . 
                            '</td>
                        </tr>
                        <tr>
                            <th style="font-size:12px; text-align:left;">Novo CBO</th>
                            <td style="font-size:12px; line-height:1.4; text-align:left;">' . 
                                htmlspecialchars($resultado_mudanca_cargo_selecionado['codigo_cargo'] ?? "") . 
                            '</td>
                        </tr>
                    </table>
                ';
            }

            $nomeCoord = htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "");
            $crmCoord  = htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "");
            $textoCoord = $nomeCoord . (!empty($nomeCoord) && !empty($crmCoord) ? " / " : "") . $crmCoord;

            $nomeExam = htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "");
            $crmExam  = htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "");
            $textoExam = $nomeExam . (!empty($nomeExam) && !empty($crmExam) ? " / " : "") . $crmExam;

            echo '
            <table>
                <tr>
                    <td colspan="2" class="section-title">Dados dos Médicos</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;width: 185px;">Médico coordenador do PCMSO</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . $textoCoord . '</td>
                </tr>
                
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico emitente/examinador</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . $textoExam . '</td>
                </tr>
            </table>

            ' . $riscosTabela . '

            <table class="table-exames" style="width:100%; border-collapse:collapse;">
                <tr>
                    <td colspan="2" class="section-title" style="text-align:left; font-size:12px; font-weight:bold;">
                       Procedimentos e Exames realizados
                    </td>
                </tr>
                    ' . $linhasExames .'
            </table>

            ' . $aptidoesTabela . '

            <table>
                <tr>
                    <td colspan="2" style="background:#eaeaea; border:1px solid #666; font-weight:bold; font-size:12px; padding:3px 8px; text-align:left;">
                        CONCLUSÃO DO EXAME
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; padding:6px;">
                        ' . htmlspecialchars($recebe_cidade_uf) . ' , DATA: ' . htmlspecialchars($dataAtual ?? "") . '
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; padding:6px;">
                    Atesto que o trabalhador acima identificado se submeteu aos exames médicos ocupacionais em cumprimento a NR 07 e seus itens 7.5.19.1 e
7.5.19.2 sendo o resultado de avaliação considerado:
                        Resultado: ( ) APTO &nbsp;&nbsp; ( ) INAPTO
                    </td>
                </tr>
                <tr>
                    <!-- Espaço para assinatura -->
                    <td style="height:80px; text-align:center; vertical-align:bottom; font-size:11px; border-top:1px solid #000;">
                        
                        ' . $html_assinatura . ' <br>
                        Médico emitente/ Examinador
                        ' . htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "") . '/MT
                    </td>
                    <td style="height:80px; text-align:center; vertical-align:bottom; font-size:11px; border-top:1px solid #000;">
                        Funcionário<br>
                        ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
                        <br>
                        _______________________________<br>
                        Assinatura do Funcionário
                    </td>
                </tr>
            </table>

            </div>';

            echo '

            <div class="actions">
                <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                <button class="btn btn-print" onclick="window.print()">Salvar</button>
            </div>
        </div>
';

        }else if($prontuario_medico)
        {
            $informacoes_clinica;

            if (isset($_SESSION['clinica_selecionado']) && $_SESSION['clinica_selecionado'] !== '') {
                salvarLog("id da clinica selecionada:" . $_SESSION["clinica_selecionado"]);
                salvarLog($_SESSION["exame_selecionado"]);

                // echo "id da clinica selecionada:" . $_SESSION["clinica_selecionado"] . "<br>";

                // echo $_SESSION["exame_selecionado"] . "<br>";

                $recebe_exame = $_SESSION["exame_selecionado"];

                $recebe_exame_exibicao;

                if ($recebe_exame === "admissional") {
                    $recebe_exame_exibicao = "Admissional";
                } else if ($recebe_exame === "mudanca") {
                    $recebe_exame_exibicao = "Mudança de função";
                }

                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                // Função helper para marcar
                function marcar($valor, $tipoExame)
                {
                    return ($tipoExame === strtolower($valor)) ? '(X)' : '( )';
                }

                $instrucao_busca_clinica = "select * from clinicas where id = :recebe_clinica_id";
                $comando_busca_clinica = $pdo->prepare($instrucao_busca_clinica);
                $comando_busca_clinica->bindValue(":recebe_clinica_id", $_SESSION["clinica_selecionado"]);
                $comando_busca_clinica->execute();
                $resultado_clinica_selecionada = $comando_busca_clinica->fetch(PDO::FETCH_ASSOC);

                // print_r($resultado_clinica_selecionada);

                // ----------------- BUSCA NA API DO IBGE -----------------
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

                // Exemplo: "ALTO ARAGUAIA - MT"
                $recebe_cidade_uf = trim($cidadeNome . ' - ' . $estadoSigla);
                salvarLog("Cidade/UF via IBGE: " . $recebe_cidade_uf);

                // Debug
                // print_r($resultado_clinica_selecionada);
                // echo "<br>Cidade/UF via IBGE: " . $recebe_cidade_uf;

                if (isset($_SESSION['empresa_selecionado']) && $_SESSION['empresa_selecionado'] !== '') {
                    $instrucao_busca_empresa = "select * from empresas_novas where id = :recebe_id_empresa";
                    $comando_busca_empresa = $pdo->prepare($instrucao_busca_empresa);
                    $comando_busca_empresa->bindValue(":recebe_id_empresa", $_SESSION["empresa_selecionado"]);
                    $comando_busca_empresa->execute();
                    $resultado_empresa_selecionada = $comando_busca_empresa->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_empresa_selecionada);

                    // echo "<br>";

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

                    $recebe_nascimento_colaborador = '';

                    $raw = $resultado_pessoa_selecionada['nascimento'] ?? '';
                    if (!empty($raw) && $raw !== '0000-00-00' && $raw !== '0000-00-00 00:00:00') {
                        try {
                            $recebe_nascimento_colaborador = (new DateTime($raw))->format('d/m/Y');
                        } catch (Exception $e) {
                            $recebe_nascimento_colaborador = '';
                        }

                        // Converte para objeto DateTime
                        $dtNascimento = new DateTime($raw);
                        $dtHoje = new DateTime("now");

                        // Calcula a diferença
                        $idade = $dtHoje->diff($dtNascimento)->y;

                        // echo "Idade: " . $idade . " anos";
                    }

                    // var_dump($resultado_pessoa_selecionada);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_pessoa_selecionada);
                    salvarLog(ob_get_clean());

                    $instrucao_busca_cargo_pessoa = "select * from cargo where id_pessoa = :recebe_id_pessoa";
                    $comando_busca_cargo_pessoa = $pdo->prepare($instrucao_busca_cargo_pessoa);
                    $comando_busca_cargo_pessoa->bindValue(":recebe_id_pessoa",$resultado_pessoa_selecionada["id"]);
                    $comando_busca_cargo_pessoa->execute();
                    $resultado_busca_cargo_pessoa = $comando_busca_cargo_pessoa->fetch(PDO::FETCH_ASSOC);
                }

                if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                    $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
                    $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
                    $comando_busca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                    $comando_busca_cargo->execute();
                    $resultado_cargo_selecionado = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_cargo_selecionado);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_cargo_selecionado);
                    salvarLog(ob_get_clean());
                }

                if ($recebe_exame === "mudanca") {
                    if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                        ob_start();
                        echo "Cargo:" . $_SESSION["cargo_selecionado"] . "<br>";
                        salvarLog(ob_get_clean());

                        $instrucao_busca_mudanca_cargo = "select * from cargo where id = :recebe_id_cargo";
                        $comando_busca_mudanca_cargo = $pdo->prepare($instrucao_busca_mudanca_cargo);
                        $comando_busca_mudanca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                        $comando_busca_mudanca_cargo->execute();
                        $resultado_mudanca_cargo_selecionado = $comando_busca_mudanca_cargo->fetch(PDO::FETCH_ASSOC);

                        // var_dump($resultado_mudanca_cargo_selecionado);

                        // echo "<br>";

                        ob_start();
                        var_dump($resultado_mudanca_cargo_selecionado);
                        salvarLog(ob_get_clean());
                    }
                }

                if (isset($_SESSION["medico_coordenador_selecionado"]) && $_SESSION["medico_coordenador_selecionado"] !== "") {
                    ob_start();
                    echo "ID Médico coordenador:" . $_SESSION["medico_coordenador_selecionado"];
                    salvarLog(ob_get_clean());

                    $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
                    $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
                    $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador", $_SESSION["medico_coordenador_selecionado"]);
                    $comando_busca_medico_coordenador->execute();
                    $resultado_medico_coordenador_selecionado = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);

                    // var_dump($resultado_medico_coordenador_selecionado);

                    ob_start();
                    var_dump($resultado_medico_coordenador_selecionado);
                    salvarLog(ob_get_clean());
                }

                if (isset($_SESSION["medico_clinica_selecionado"]) && $_SESSION["medico_clinica_selecionado"] !== "") {
                    ob_start();
                    echo "ID médico emitente:" . $_SESSION["medico_clinica_selecionado"] . "<br>";
                    salvarLog(ob_get_clean());


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

                    // var_dump($resultado_medico_relacionado_clinica);

                    // echo "<br>";

                    ob_start();
                    var_dump($resultado_medico_relacionado_clinica);
                    salvarLog(ob_get_clean());

                    $instrucao_verifica_marcacao_assinatura_digital = "select * from kits where id = :recebe_id_kit";
                    $comando_verifica_marcacao_assinatura_digital = $pdo->prepare($instrucao_verifica_marcacao_assinatura_digital);
                    $comando_verifica_marcacao_assinatura_digital->bindValue(":recebe_id_kit",$_SESSION["codigo_kit"]);
                    $comando_verifica_marcacao_assinatura_digital->execute();
                    $resultado_verifica_marcacao_assinatura_digital = $comando_verifica_marcacao_assinatura_digital->fetch(PDO::FETCH_ASSOC);

                    //var_dump($resultado_verifica_marcacao_assinatura_digital);

                    if ($resultado_verifica_marcacao_assinatura_digital["assinatura_digital"] === "Sim") {
                        // supondo que o campo no banco seja "assinatura" com o nome do arquivo
                                        $html_assinatura = "<img src='assinaturas/" 
                        . htmlspecialchars($resultado_medico_relacionado_clinica['imagem_assinatura'] ?? '') 
                        . "' alt='Assinatura do Médico' class='assinatura'>";
                    } else {
                        $html_assinatura = "_______________________________";
                    }
                }

                // ===================== AJUSTE APENAS NOS RISCOS =====================
                $riscosTabela = '';
                $grupos = [
                    "acidente"   => "Acidentes / Mecânicos",
                    "ergonomico" => "Ergonômicos",
                    "fisico"     => "Físicos",
                    "quimico"    => "Químicos",
                    "biologico"  => "Biológicos"
                ];

                // Prepara array vazio para armazenar riscos por grupo
                $riscosPorGrupo = array_fill_keys(array_keys($grupos), []);

                if (isset($_SESSION["medico_risco_selecionado"]) && $_SESSION["medico_risco_selecionado"] !== "") {
                    $data = json_decode($_SESSION["medico_risco_selecionado"], true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        for ($i = 0; $i < count($data); $i++) {
                            $grupo     = strtolower($data[$i]['grupo']);
                            $descricao = $data[$i]['descricao'] ?? "";

                            if (isset($riscosPorGrupo[$grupo])) {
                                $riscosPorGrupo[$grupo][] = $descricao;
                            }
                        }
                    }
                }

                // Monta a tabela de riscos
                $riscosTabela .= '
                <table>
                    <tr>
                        <td colspan="2" class="section-title">FATORES DE RISCO</td>
                    </tr>';
                foreach ($grupos as $chave => $titulo) {
                    $valores = !empty($riscosPorGrupo[$chave]) ? implode(", ", $riscosPorGrupo[$chave]) : "N/A";
                    $riscosTabela .= "
                    <tr>
                        <th style='text-align:left; font-weight:bold; font-size:12px; font-family:Arial, sans-serif; padding:4px;'>{$titulo}</th>
                        <td style='font-size:12px; font-family:Arial, sans-serif; padding:4px;'>{$valores}</td>
                    </tr>";
                }
                $riscosTabela .= '</table>';


                // =====================================================================

                // ===================== AJUSTE NAS APTIDÕES =====================
                $aptidoesTabela = '';

                $listaAptidoes = [
                    "trabalho em altura"            => "Trabalho em Altura",
                    "manusear produtos alimentícios" => "Manusear Produtos Alimentícios",
                    "eletricidade"                  => "Eletricidade",
                    "operar máquinas"               => "Operar Máquinas",
                    "conduzir veículos"             => "Conduzir Veículos",
                    "trabalho a quente"             => "Trabalho a Quente",
                    "inflamáveis"                   => "Inflamáveis",
                    "radiações ionizantes"          => "Radiações Ionizantes",
                    "espaço confinado"              => "Espaço Confinado",
                    "inspeções e manutenções"       => "Inspeções e Manutenções"
                ];

                // transforma o JSON da sessão em array associativo
                $aptidoesSelecionadas = [];
                if (isset($_SESSION["aptidao_selecionado"]) && $_SESSION["aptidao_selecionado"] !== "") {
                    var_dump($_SESSION["aptidao_selecionado"]);


                    $dataApt = json_decode($_SESSION["aptidao_selecionado"], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($dataApt)) {
                        foreach ($dataApt as $apt) {
                            if (isset($apt['nome'])) {
                                $aptidoesSelecionadas[] = strtolower(trim($apt['nome']));
                            }
                        }
                    }
                }

                // função para marcar sim/não
                function marcarApt($nomeExibicao, $aptidoesSelecionadas)
                {
                    $nomeLower = strtolower($nomeExibicao);
                    $sim  = in_array($nomeLower, $aptidoesSelecionadas) ? "X" : " ";
                    $nao  = $sim === "X" ? " " : "X";
                    return "( $sim ) Sim ( $nao ) Não";
                }

                // define os pares para exibição (duas colunas por linha)
                $linhas = [
                    ["Trabalho em Altura", "Manusear Produtos Alimentícios"],
                    ["Eletricidade", "Operar Máquinas"],
                    ["Conduzir Veículos", "Trabalho a Quente"],
                    ["Inflamáveis", "Radiações Ionizantes"],
                    ["Espaço Confinado", "Inspeções e Manutenções"]
                ];

                $aptidoesTabela .= '
                <table>
                    <tr>
                        <td colspan="2" class="section-title">APTIDÕES EXTRAS</td>
                    </tr>';
                foreach ($linhas as $par) {
                    $esq = $par[0] . " " . marcarApt($par[0], $aptidoesSelecionadas);
                    $dir = $par[1] . " " . marcarApt($par[1], $aptidoesSelecionadas);

                    $aptidoesTabela .= '
                    <tr>
                        <td style="width:50%; font-size:12px; padding:4px;">' . $esq . '</td>
                        <td style="width:50%; font-size:12px; padding:4px;">' . $dir . '</td>
                    </tr>';
                }
                $aptidoesTabela .= '
                </table>';

                // =====================================================================


                // Função helper para marcar Apto/Inapto
                function marcarAptidao($nome, $aptidoesSelecionadas)
                {
                    $nomeLower = strtolower($nome);
                    $apto   = in_array($nomeLower, $aptidoesSelecionadas) ? 'X' : ' ';
                    $inapto = in_array($nomeLower, $aptidoesSelecionadas) ? ' ' : 'X';
                    return "$nome ( $apto ) Apto ( $inapto ) Inapto";
                }
            }

            echo '
        <style>
            body {
                font-family: Arial, sans-serif;
                background:#f2f2f2;
                margin:0;
                padding:0;
            }
            .guia-container {
                width: 210mm;
                min-height: 297mm;
                margin:5mm auto;
                padding:10px;
                background:#fff;
                border:1px solid #000;
            }
            table { width:100%; border-collapse:collapse; font-size:12px; }
            th, td { border:1px solid #000; padding:4px; vertical-align:top; }

            .titulo-guia {
                background:#eaeaea;
                border:1px solid #000;
                font-weight:bold;
                text-align:center;
                font-size:14px;
                padding:5px;
                height:22px;
            }
            .section-title {
                background:#eaeaea;
                border:1px solid #666;
                font-weight:bold;
                font-size:12px;
                padding:3px 5px;
                text-align:left;
            }
            .dados-hospital { font-size:12px; line-height:1.4; }
            .hospital-nome { font-weight:bold; text-transform:uppercase; text-decoration:underline; display:block; margin-bottom:3px; }

            .logo { text-align:center; }
            .logo img { max-height:45px; }

            /* QR Code */
            .qrcode img {
                display:block;
                width:120px;
                height:auto;
                margin-top:5px;
            }

            /* Botões - Centralizados abaixo do formulário */
            .actions {
                margin-top: 15px;
                padding-top: 10px;
                text-align: center;
                border-top: 1px solid #ccc; /* linha de separação opcional */
            }
            .btn {
                padding:10px 18px;
                font-size:14px;
                font-weight:bold;
                border:none;
                border-radius:5px;
                cursor:pointer;
                color:#fff;
                box-shadow:0 2px 5px rgba(0,0,0,.2);
                margin:0 5px;
            }
            .btn-email { background:#007bff; }
            .btn-whatsapp { background:#25d366; }
            .btn-print { background:#6c757d; }
            .btn:hover { opacity:.9; }

            @media print {
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                body { background:#fff; }
                .actions { display: none !important; }
            }

            /* 🔹 Estilo para cabeçalhos de tabelas de riscos */
        .table-riscos th {
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 4px;
            vertical-align: top;
        }
        .table-riscos td {
            font-size: 12px;
            font-family: Arial, sans-serif;
            padding: 4px;
            vertical-align: top;
        }

        .table-exames th {
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            padding: 4px;
        }

        .legenda {
            text-align: center;
            font-size: 14px;
        }

        .assinatura {
                width: 150px;
    height: 60px;
    border-bottom: 1px solid #000;
    display: block;
    margin: 0px auto 5px auto;
        }

        @media print {
  table {
    page-break-inside: avoid;
  }
}

        </style>

        <div class="guia-container">
            <table>
                <tr>
                    <th colspan="2" class="titulo-guia">PRONTUÁRIO MÉDICO - 01</th>
                </tr>
                <tr>
                    <td class="dados-hospital">
                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
                        ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '
                    </td>
                    <td class="logo">
                        <img src="logo.jpg" alt="Logo">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
                </tr>
                <tr>
                    <td class="dados-hospital" colspan="2">
                        ' . (!empty($resultado_empresa_selecionada['nome'])
                            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                            : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">TIPO DE PRONTUARIO MÉDICO EXAME OCUPACIONAL ANAMNESE CLINICA E PROFISSIONAL</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; line-height:1.5; padding:5px;">
                        Admissional ' . marcar("admissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Periódico ' . marcar("periodico", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Demissional ' . marcar("demissional", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '
                    </td>
                </tr>
            </table>';

            if (
                isset($resultado_mudanca_cargo_selecionado) 
                && !empty($resultado_mudanca_cargo_selecionado)
            ) {
                echo '
                    <table> 
                        <tr>
                            <td colspan="2" class="section-title">Mudança de Função</td>
                        </tr>
                        <tr>
                            <th style="font-size:12px; text-align:left;">Novo Cargo</th>
                            <td style="font-size:12px; line-height:1.4; text-align:left;">' . 
                                htmlspecialchars($resultado_mudanca_cargo_selecionado['titulo_cargo'] ?? "") . 
                            '</td>
                        </tr>
                        <tr>
                            <th style="font-size:12px; text-align:left;">Novo CBO</th>
                            <td style="font-size:12px; line-height:1.4; text-align:left;">' . 
                                htmlspecialchars($resultado_mudanca_cargo_selecionado['codigo_cargo'] ?? "") . 
                            '</td>
                        </tr>
                    </table>
                ';
            }

            $nomeCoord = htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "");
            $crmCoord  = htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "");
            $textoCoord = $nomeCoord . (!empty($nomeCoord) && !empty($crmCoord) ? " / " : "") . $crmCoord;

            $nomeExam = htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "");
            $crmExam  = htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "");
            $textoExam = $nomeExam . (!empty($nomeExam) && !empty($crmExam) ? " / " : "") . $crmExam;

            echo '
            <table>
                <tr>
                    <td colspan="2" class="section-title">Dados dos Médicos</td>
                </tr>
                <tr>
                    <th style="font-size:12px; text-align:left;width: 185px;">Médico coordenador do PCMSO</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . $textoCoord . '</td>
                </tr>
                
                <tr>
                    <th style="font-size:12px; text-align:left;">Médico emitente/examinador</th>
                    <td style="font-size:12px; line-height:1.4; text-align:left;">' . $textoExam . '</td>
                </tr>
            </table>


            <!-- INFORMAÇÕES CLÍNICAS -->
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td colspan="8" class="section-title">INFORMAÇÕES CLÍNICAS</td>
                </tr>

                <!-- Cabeçalho -->
                <tr>
                    <th colspan="2" class="section-title">ANTECEDENTES FAMILIARES</th>
                    <th>SIM</th><th>NÃO</th>
                    <th colspan="2" class="section-title">ANTECEDENTES PESSOAIS</th>
                    <th>SIM</th><th>NÃO</th>
                </tr>

                <!-- Familiares x Pessoais -->
                <tr><td colspan="2">DIABETE (AÇÚCAR NO SANGUE)</td><td></td><td></td>
                    <td colspan="2">ESTEVE EM TRATAMENTO? JÁ TEVE ALGUMA DOENÇA GRAVE?</td><td></td><td></td></tr>
                <tr><td colspan="2">ASMA / BRONQUITE / ALERGIA OU URTICÁRIA</td><td></td><td></td>
                    <td colspan="2">FAZ USO DIÁRIO DE ALGUM MEDICAMENTO?</td><td></td><td></td></tr>
                <tr><td colspan="2">DOENÇAS MENTAIS OU NERVOSAS</td><td></td><td></td>
                    <td colspan="2">SOFREU ALGUM ACIDENTE?</td><td></td><td></td></tr>
                <tr><td colspan="2">EPILEPSIA - ATAQUES</td><td></td><td></td>
                    <td colspan="2">ESTEVE INTERNADO EM HOSPITAL?</td><td></td><td></td></tr>
                <tr><td colspan="2">ALCOOLISMO</td><td></td><td></td>
                    <td colspan="2">JÁ FOI OPERADO?</td><td></td><td></td></tr>
                <tr><td colspan="2">REUMATISMO</td><td></td><td></td>
                    <td colspan="2">TEM DEFICIÊNCIA OU IMPEDIMENTOS FÍSICOS?</td><td></td><td></td></tr>
                <tr><td colspan="2">GASTRITE / ÚLCERA</td><td></td><td></td>
                    <td colspan="2">TRABALHOU EM AMBIENTE COM RUÍDO?</td><td></td><td></td></tr>
                <tr><td colspan="2">PRESSÃO ALTA / DOENÇAS DO CORAÇÃO</td><td></td><td></td>
                    <td colspan="2">TEVE ALGUMA CRISE CONVULSIVA (ATAQUE)?</td><td></td><td></td></tr>
                <tr><td colspan="2">CÂNCER</td><td></td><td></td>
                    <td colspan="2">TEM DOR DE CABEÇA?</td><td></td><td></td></tr>
                <tr><td colspan="2">DERRAME</td><td></td><td></td>
                    <td colspan="2">TEVE TRAUMA OU BATIDA NA CABEÇA? TEM TONTURA?</td><td></td><td></td></tr>
                <tr><td colspan="2">HIPERCOLESTEROLEMIA (COLESTEROL ALTO)</td><td></td><td></td>
                    <td colspan="2">TEM ALGUMA ALERGIA (ASMA, RINITE)?</td><td></td><td></td></tr>
                <tr><td colspan="2">TUBERCULOSE</td><td></td><td></td>
                    <td colspan="2">TEM OU TEVE ALGUMA DOENÇA NO PULMÃO / FALTA DE AR?</td><td></td><td></td></tr>

                <!-- Habitos de Vida alinhado com Coluna -->
                <tr>
                    <th colspan="2" class="section-title">HÁBITOS DE VIDA</th><th>SIM</th><th>NÃO</th>
                    <td colspan="2">TEM ALGUM PROBLEMA DE COLUNA?</td><td></td><td></td>
                </tr>
                <tr><td colspan="2">FUMA?</td><td></td><td></td>
                    <td colspan="2">TEM REUMATISMO?</td><td></td><td></td></tr>
                <tr><td colspan="2">TOMA/TOMAVA BEBIDA ALCOÓLICA?</td><td></td><td></td>
                    <td colspan="2">TEM HÉRNIA (SACO RENDIDO)?</td><td></td><td></td></tr>
                <tr><td colspan="2">USA/USAVA DROGA?</td><td></td><td></td>
                    <td colspan="2">TEVE DOENÇA DE CHAGAS?</td><td></td><td></td></tr>
                <tr><td colspan="2">PRATICA ESPORTE?</td><td></td><td></td>
                    <td colspan="2">SENTE CANSAÇO FACILMENTE?</td><td></td><td></td></tr>
                <tr><td colspan="2">DORME BEM?</td><td></td><td></td>
                    <td colspan="2">ESTÁ COM FEBRE OU PERDA DE PESO?</td><td></td><td></td></tr>

                <!-- Ocupacionais alinhado -->
                <tr>
                    <th colspan="2" class="section-title">ANTECEDENTES OCUPACIONAIS</th><th>SIM</th><th>NÃO</th>
                    <td colspan="2">JÁ TEVE FRATURAS?</td><td></td><td></td>
                </tr>
                <tr><td colspan="2">PODE EXECUTAR TAREFAS PESADAS?</td><td></td><td></td>
                    <td colspan="2">REALIZA TRABALHO FORA DA EMPRESA?</td><td></td><td></td></tr>
                <tr><td colspan="2">EXECUTOU TAREFAS INSALUBRES PERIGOSAS?</td><td></td><td></td>
                    <td colspan="2">CONSIDERA TER SUA SAÚDE?</td><td></td><td></td></tr>
                <tr><td colspan="2">JÁ ESTEVE DOENTE DEVIDO AO SEU TRABALHO?</td><td></td><td></td>
                    <td colspan="2">POSSUI DIFICULDADE MOTORA?</td><td></td><td></td></tr>

                <!-- Para Mulheres alinhado -->
                <tr>
                    <td colspan="2">JÁ FOI DEMITIDO POR MOTIVO DE DOENÇA?</td><td></td><td></td>
                    <th colspan="4" class="section-title">PARA MULHERES</th>
                </tr>
                <tr><td colspan="2">JÁ ESTEVE AFASTADO PELO INSS?</td><td></td><td></td>
                    <td colspan="4">DATA DA ÚLTIMA MENSTRUAÇÃO: ___/___/____</td></tr>
                <tr><td colspan="2">JÁ TEVE ACIDENTE DE TRABALHO?</td><td></td><td></td>
                    <td colspan="4">DATA DO ÚLTIMO PREVENTIVO: ___/___/____</td></tr>
            </table>

            <table>
                <tr>
                    <th colspan="2" style="page-break-before: always;" class="titulo-guia">PRONTUÁRIO MÉDICO - 02</th>
                </tr>
                <tr>
                    <td class="dados-hospital">
                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
                        ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '
                    </td>
                    <td class="logo">
                        <img src="logo.jpg" alt="Logo">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
                </tr>
                <tr>
                    <td class="dados-hospital" colspan="2">
                        ' . (!empty($resultado_empresa_selecionada['nome'])
                            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                            : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>
                </tr>
            </table>

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:6px;">
               <!-- Linha com dados clínicos -->
               <tr>
                    <th colspan="5" class="titulo-guia">APTIDÃO FÍSICA E METAL</th>
                </tr>
               <tr>
                  <th style="text-align:left; padding:4px; width: 15%;">ALTURA:</th>
                  <th style="text-align:left; padding:4px; width: 15%;">PESO:</th>
                  <th style="text-align:left; padding:4px; width: 15%;">TEMPERATURA:</th>
                  <th style="text-align:left; padding:4px; width: 15%;">PULSO:</th>
                  <th style="text-align:left; padding:4px; width: 15%;">PRESSÃO ARTERIAL:</th>
                </tr>
            </table>

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:0px;">
                <!-- Cabeçalho das colunas de avaliação -->
                <tr>
                    <td style="padding:4px;"></td>
                    <th style="text-align:center; padding:4px; width:6%;">NORMAL</th>
                    <th style="text-align:center; padding:4px; width:6%;">ANORMAL</th>
                    <th colspan="2" style="text-align:center; padding:4px; width:64%;">OBSERVAÇÃO</th>
                </tr>

                <!-- Linhas dos exames físicos -->
                <tr><td style="padding:4px; width:24%;">ASPECTO GERAL</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">OLHOS</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">OTOSCOPIA</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">NARIZ</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">BOCA - AMÍGDALAS - DENTES</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">PESCOÇO - GÂNGLIOS</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">PULMÃO</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">CORAÇÃO</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">ABDOMÊ</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">COLUNA</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">MEMBROS SUPERIORES</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">MEMBROS INFERIORES</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">PELE E FÂNEROS</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">PSIQUISMO</td><td></td><td></td><td colspan="2"></td></tr>
                <tr><td style="padding:4px;">EXAMES COMPLEMENTARES</td><td></td><td></td><td colspan="2"></td></tr>
            </table>

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th colspan="2" class="titulo-guia" style="text-align:left;">Preenchimento Obrigatório em Caso de Exame Demissional</th>
                </tr>

                <tr><th colspan="6" style="text-align:left; padding:4px;" class="titulo-guia">Demissional</th></tr>
                <tr><td colspan="6" style="padding:4px;">Adquiriu alguma doença em virtude da função?</td></tr>
                <tr><td colspan="6" style="padding:4px;">Sofreu acidente de trabalho na empresa?</td></tr>
                <tr><td colspan="6" style="padding:4px;">Recebeu EPI da empresa?</td></tr>
                <tr>
                    <td colspan="6" style="padding:4px;">
                        PRESSÃO ARTERIAL: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 
                        PULSO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 
                        TEMPERATURA: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </table>

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th colspan="4" class="titulo-guia" style="text-align:left;">Para Mulheres</th>
                </tr>
                <tr>
                    <th style="text-align:left; padding:4px;width: 160px;">Data da Última Menstruação</th>
                    <td style="padding:4px;width:200px"></td>
                    <th style="text-align:left; padding:4px;width: 160px;">Data do Último Preventivo</th>
                    <td style="padding:4px;width:200px"></td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="2" class="titulo-guia" style="text-align:left;">EXAMES COMPLEMENTARES</th>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="height:60px;">
                        ___________________________________________________________________________________
                    </td>
                </tr>
            </table>



            <table>
                <tr>
                    <th colspan="2" class="titulo-guia" style="text-align:left;">EVOLUÇÃO CLÍNICA</th>
                </tr>
                <tr>
                    <td colspan="2" class="dados-hospital" style="height:60px;">
                        ___________________________________________________________________________________
                    </td>
                </tr>
            </table>


            <table>
    
    <tr>
        <td colspan="2" class="dados-hospital">
            ' . htmlspecialchars($recebe_cidade_uf) . ' , DATA: ' . htmlspecialchars($dataAtual ?? "") . '
        </td>
    </tr>
    <tr>
        <!-- Espaço para assinatura -->
        <td style="height:80px; text-align:center; vertical-align:bottom; font-size:11px; border-top:1px solid #000;">
            ' . $html_assinatura . ' <br>
            Médico emitente/ Examinador<br>
            ' . htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "") . '/MT
        </td>
        <td style="height:80px; text-align:center; vertical-align:bottom; font-size:11px; border-top:1px solid #000;">
            Funcionário<br>
            ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
            <br>
            _______________________________<br>
            Assinatura do Funcionário
        </td>
    </tr>
</table>

            

            <div class="actions">
                <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                <button class="btn btn-print" onclick="window.print()">Salvar</button>
            </div>
        </div>
';
        } else if ($exames_procedimentos === true || $treinamentos === true || $epi_epc === true || $faturamento === true) {

            if (isset($_SESSION['clinica_selecionado']) && $_SESSION['clinica_selecionado'] !== '') {

                $instrucao_busca_clinica = "select * from clinicas where id = :recebe_clinica_id";
                $comando_busca_clinica = $pdo->prepare($instrucao_busca_clinica);
                $comando_busca_clinica->bindValue(":recebe_clinica_id", $_SESSION["clinica_selecionado"]);
                $comando_busca_clinica->execute();
                $resultado_clinica_selecionada = $comando_busca_clinica->fetch(PDO::FETCH_ASSOC);

                // print_r($resultado_clinica_selecionada);

                // ----------------- BUSCA NA API DO IBGE -----------------
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

                // Exemplo: "ALTO ARAGUAIA - MT"
                $recebe_cidade_uf = trim($cidadeNome . ' - ' . $estadoSigla);
                salvarLog("Cidade/UF via IBGE: " . $recebe_cidade_uf);
            }


            if (isset($_SESSION['empresa_selecionado']) && $_SESSION['empresa_selecionado'] !== '') {
                $instrucao_busca_empresa = "select * from empresas_novas where id = :recebe_id_empresa";
                $comando_busca_empresa = $pdo->prepare($instrucao_busca_empresa);
                $comando_busca_empresa->bindValue(":recebe_id_empresa", $_SESSION["empresa_selecionado"]);
                $comando_busca_empresa->execute();
                $resultado_empresa_selecionada = $comando_busca_empresa->fetch(PDO::FETCH_ASSOC);

                $cidadeNome = '';
                $estadoSigla = '';

                if (!empty($resultado_empresa_selecionada['id_cidade'])) {
                    $urlCidade = "https://servicodados.ibge.gov.br/api/v1/localidades/municipios/" . $resultado_empresa_selecionada['id_cidade'];
                    $cidadeJson = @file_get_contents($urlCidade);
                    if ($cidadeJson !== false) {
                        $cidadeData = json_decode($cidadeJson, true);
                        $cidadeNome = $cidadeData['nome'] ?? '';
                    }
                }

                if (!empty($resultado_empresa_selecionada['id_estado'])) {
                    $urlEstado = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" . $resultado_empresa_selecionada['id_estado'];
                    $estadoJson = @file_get_contents($urlEstado);
                    if ($estadoJson !== false) {
                        $estadoData = json_decode($estadoJson, true);
                        $estadoSigla = $estadoData['sigla'] ?? '';
                    }
                }

                // Exemplo: "ALTO ARAGUAIA - MT"
                $recebe_cidade_uf = trim($cidadeNome . ' - ' . $estadoSigla);

                // var_dump($resultado_empresa_selecionada);

                // echo "<br>";

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

                $recebe_nascimento_colaborador = '';

                $raw = $resultado_pessoa_selecionada['nascimento'] ?? '';
                if (!empty($raw) && $raw !== '0000-00-00' && $raw !== '0000-00-00 00:00:00') {
                    try {
                        $recebe_nascimento_colaborador = (new DateTime($raw))->format('d/m/Y');
                    } catch (Exception $e) {
                        $recebe_nascimento_colaborador = '';
                    }

                    // Converte para objeto DateTime
                    $dtNascimento = new DateTime($raw);
                    $dtHoje = new DateTime("now");

                    // Calcula a diferença
                    $idade = $dtHoje->diff($dtNascimento)->y;

                    // echo "Idade: " . $idade . " anos";
                }
            }

            if (isset($_SESSION["cargo_selecionado"]) && $_SESSION["cargo_selecionado"] !== "") {
                $instrucao_busca_cargo = "select * from cargo where id = :recebe_id_cargo";
                $comando_busca_cargo = $pdo->prepare($instrucao_busca_cargo);
                $comando_busca_cargo->bindValue(":recebe_id_cargo", $_SESSION["cargo_selecionado"]);
                $comando_busca_cargo->execute();
                $resultado_cargo_selecionado = $comando_busca_cargo->fetch(PDO::FETCH_ASSOC);
            }

            $valores_pedidos = [];

            // -------------------
            // Buscar EPIs (Produtos)
            // -------------------
            $instrucao_busca_pedidos = "SELECT * FROM produto WHERE id_kit = :recebe_id_kit";
            $comando_busca_pedidos = $pdo->prepare($instrucao_busca_pedidos);
            $comando_busca_pedidos->bindValue(":recebe_id_kit", $_SESSION["codigo_kit"]);
            $comando_busca_pedidos->execute();
            $resultado_busca_pedidos = $comando_busca_pedidos->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < count($resultado_busca_pedidos); $i++) {
                $item = $resultado_busca_pedidos[$i];
                $valores_pedidos[] = [
                    "tipo"       => "epi",
                    "nome"       => $item["nome"] ?? "Sem nome",
                    "quantidade" => $item["quantidade"] ?? 1,
                    "valor"      => (float) ($item["valor"] ?? 0),
                    "codigo"     => $item["id"]
                ];
            }

            // -------------------
            // Buscar Treinamentos
            // -------------------
            $instrucao_busca_treinamentos_kit = "SELECT treinamentos_selecionados FROM kits WHERE id = :recebe_id_kit";
            $comando_busca_treinamentos_kit = $pdo->prepare($instrucao_busca_treinamentos_kit);
            $comando_busca_treinamentos_kit->bindValue(":recebe_id_kit", $_SESSION["codigo_kit"]);
            $comando_busca_treinamentos_kit->execute();
            $resultado_busca_treinamentos_kit = $comando_busca_treinamentos_kit->fetchAll(PDO::FETCH_ASSOC);

            // Contador associativo para treinamentos
            $treinamentos_count = [];

            for ($i = 0; $i < count($resultado_busca_treinamentos_kit); $i++) {
                $registro = $resultado_busca_treinamentos_kit[$i];
                if (!empty($registro["treinamentos_selecionados"])) {
                    $treinamentos_recebidos = json_decode($registro["treinamentos_selecionados"], true);
                    if (is_array($treinamentos_recebidos)) {
                        for ($j = 0; $j < count($treinamentos_recebidos); $j++) {
                            $treinamento = $treinamentos_recebidos[$j];
                            $codigo = $treinamento["codigo"];
                            $nome = $treinamento["nome"] ?? "Sem nome";
                            $valor = (float) str_replace(",", ".", $treinamento["valor"] ?? 0);
                            $descricao = $treinamento["descricao"];

                            if (isset($treinamentos_count[$nome])) {
                                $treinamentos_count[$nome]["quantidade"]++;
                            } else {
                                $treinamentos_count[$nome] = [
                                    "tipo"       => "treinamento",
                                    "nome"       => $descricao,
                                    "quantidade" => 1,
                                    "valor"      => $valor,
                                    "codigo"     => $codigo
                                ];
                            }
                        }
                    }
                }
            }

            // Adiciona os treinamentos ao array final
            foreach ($treinamentos_count as $treinamento) {
                $valores_pedidos[] = $treinamento;
            }

            // -------------------
            // Buscar Exames
            // -------------------
            $instrucao_busca_exames_kit = "SELECT exames_selecionados FROM kits WHERE id = :recebe_id_kit";
            $comando_busca_exames_kit = $pdo->prepare($instrucao_busca_exames_kit);
            $comando_busca_exames_kit->bindValue(":recebe_id_kit", $_SESSION["codigo_kit"]);
            $comando_busca_exames_kit->execute();
            $resultado_busca_exames_kit = $comando_busca_exames_kit->fetchAll(PDO::FETCH_ASSOC);

            // Contador associativo para exames
            $exames_count = [];

            for ($i = 0; $i < count($resultado_busca_exames_kit); $i++) {
                $registro = $resultado_busca_exames_kit[$i];
                if (!empty($registro["exames_selecionados"])) {
                    $exames = json_decode($registro["exames_selecionados"], true);
                    if (is_array($exames)) {
                        for ($j = 0; $j < count($exames); $j++) {
                            $exame = $exames[$j];
                            $codigo = $exame["codigo"];
                            $nome = $exame["nome"] ?? "Sem nome";
                            $valor = (float) str_replace(",", ".", $exame["valor"] ?? 0);

                            if (isset($exames_count[$nome])) {
                                $exames_count[$nome]["quantidade"]++;
                            } else {
                                $exames_count[$nome] = [
                                    "tipo"       => "exame",
                                    "codigo"     => $codigo,
                                    "nome"       => $nome,
                                    "quantidade" => 1,
                                    "valor"      => $valor
                                ];
                            }
                        }
                    }
                }
            }

            // Adiciona os exames ao array final
            foreach ($exames_count as $exame) {
                $valores_pedidos[] = $exame;
            }

            // -------------------
            // Log final do array
            // -------------------
            ob_start();
            var_dump($valores_pedidos);
            salvarLog(ob_get_clean());



            ob_start();
            var_dump($resultado_busca_exames_kit);
            salvarLog(ob_get_clean());

            $instrucao_busca_dados_bancarios = "select tipo_dado_bancario,dado_bancario_pix,dado_bancario_agencia_conta from kits where id = :recebe_id_kit";
            $comando_busca_dados_bancarios = $pdo->prepare($instrucao_busca_dados_bancarios);
            $comando_busca_dados_bancarios->bindValue(":recebe_id_kit",$_SESSION["codigo_kit"]);
            $comando_busca_dados_bancarios->execute();
            $resultado_busca_dados_bancarios = $comando_busca_dados_bancarios->fetchAll(PDO::FETCH_ASSOC);

            //var_dump($resultado_busca_dados_bancarios);

            // if ($resultado_busca_dados_bancarios && !empty($resultado_busca_dados_bancarios[0]['tipo_dado_bancario'])) 
            // {
            //     $tipo_dado = strtolower(trim($resultado_busca_dados_bancarios[0]['tipo_dado_bancario']));

            //     if($tipo_dado === "qrcode")
            //     {
            //         $chave = '(64) 99606-5577';

            //         // Gera QR em memória e captura como base64
            //         ob_start();
            //         QRcode::png($chave, null, QR_ECLEVEL_L, 6, 2);
            //         $imageString = base64_encode(ob_get_contents());
            //         ob_end_clean();
            //     }else if($tipo_dado === "pix")
            //     {
            //         $chave = $resultado_busca_dados_bancarios[0]["dado_bancario"];
            //     }else if($tipo_dado === "agencia-conta")
            //     {
            //         $chave = $resultado_busca_dados_bancarios[0]["dado_bancario"];   
            //     }
            // }

            echo '
        <style>
                        body {
                font-family: Arial, sans-serif;
                background:#f2f2f2;
                margin:0;
                padding:0;
            }
            .guia-container {
                width: 210mm;
                min-height: 297mm;
                margin:5mm auto;
                padding:10px;
                background:#fff;
                border:1px solid #000;
            }
            table { width:100%; border-collapse:collapse; font-size:12px; }
            th, td { border:1px solid #000; padding:4px; vertical-align:top; }

            .titulo-guia {
                background:#eaeaea;
                border:1px solid #000;
                font-weight:bold;
                text-align:center;
                font-size:14px;
                padding:5px;
                height:22px;
            }
            .section-title {
                background:#eaeaea;
                border:1px solid #666;
                font-weight:bold;
                font-size:12px;
                padding:3px 5px;
                text-align:left;
            }
            .dados-hospital { font-size:12px; line-height:1.4; }
            .hospital-nome { font-weight:bold; text-transform:uppercase; text-decoration:underline; display:block; margin-bottom:3px; }

            .logo { text-align:center; }
            .logo img { max-height:45px; }

            /* 🔹 QR Code - garante que apareça na tela e na impressão */
            .qrcode img {
                display:block;
                width:120px;
                height:auto;
                margin-top:5px;
            }

            /* 🔹 Botões - agora fora do @media print */
            .actions {
                margin:10px 0;
                text-align:center;
            }
            .btn {
                padding:10px 18px;
                font-size:14px;
                font-weight:bold;
                border:none;
                border-radius:5px;
                cursor:pointer;
                color:#fff;
                box-shadow:0 2px 5px rgba(0,0,0,.2);
                margin:0 5px;
            }
            .btn-email { background:#007bff; }
            .btn-whatsapp { background:#25d366; }
            .btn-print { background:#6c757d; }
            .btn:hover { opacity:.9; }

            @media print {
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                body { background:#fff; }
                .actions { display: none !important; }
            }
        </style>

        <div class="guia-container">
            <table>
                <!-- Linha do título -->
                <tr>
                    <th colspan="2" class="titulo-guia">GUIA DE ENCAMINHAMENTO</th>
                </tr>
                <!-- Linha dados hospital + logo -->
                <tr>
                    <td class="dados-hospital">
                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
                        ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
                        ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
                        ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
                        ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '

                    </td>
                    <td class="logo">
                        <img src="logo.jpg" alt="Logo">
                    </td>
                </tr>
            </table>

            <!-- 🔹 Seção IDENTIFICAÇÃO DA EMPRESA -->
            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
                </tr>
                <tr>
                    <td class="dados-hospital" colspan="2">
                        ' . (!empty($resultado_empresa_selecionada['nome'])
                ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                : '') . '

                        ' . (!empty($resultado_empresa_selecionada['cnpj'])
                ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj'])
                : '') . '
                    ' . (!empty($resultado_empresa_selecionada['endereco'])
                ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco'])
                : '') . '
                    ' . (!empty($resultado_empresa_selecionada['bairro'])
                ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro'])
                : '') . '
                    ' . (!empty($recebe_cidade_uf)
                ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf)
                : '') . '
                    ,
                                            ' . (!empty($resultado_empresa_selecionada['cep'])
                ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep'])
                : '') . '

                    ' . (!empty($resultado_empresa_selecionada['telefone'])
                ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.'
                : '') . '
                    </td>
                </tr>
            </table>

            <!-- 🔹 Seção IDENTIFICAÇÃO DO FUNCIONÁRIO -->
            <table>
                <tr>
                    <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['titulo_cargo']) ? 'CARGO: ' . $resultado_cargo_selecionado['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['codigo_cargo']) ? 'CBO: ' . $resultado_cargo_selecionado['codigo_cargo'] : '') . '
                    </td>
                </tr>
            </table>

            <h4 style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;text-align:center;">Faturamento / Orçamento</h4>
            ';


            if($exames_procedimentos === true && $treinamentos === true && $epi_epc === true && $faturamento === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
            <div class="top-bar" style="margin-top: 10px;"></div>';

                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }



                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div style="margin-top:10px;"></div>';


                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
        03 - EPIs / EPCs
    </h4>';

                $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

                echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

        <!-- Produtos / Serviços -->
        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
                            $quantidade = $item["quantidade"] ?? 1;
                            $valorUnitario = $item["valor"] ?? 0;
                            $totalItem = $quantidade * $valorUnitario;

                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }


                echo '
            </table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';

                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
    echo '
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            }else if($exames_procedimentos === true && $treinamentos === true && $faturamento === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
            <div class="top-bar" style="margin-top: 10px;"></div>';

                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }



                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    // Converte string JSON em array
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = []; // garante que $tipos seja sempre array
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:12px; color:red;"><strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.</p>';
                    } else {

                        // Verifica quais dados exibir
                $temQrCode = in_array('qrcode', $tipos);
                $temPix = in_array('pix', $tipos);
                $temAgenciaConta = in_array('agencia-conta', $tipos);

                if ($temQrCode || $temPix || $temAgenciaConta) {
                    echo '<div style="display:flex; align-items:flex-start; gap:20px; margin-bottom:20px;">';

                    // Coluna esquerda (QR Code)
                if ($temQrCode) {
                    $chave = '(64) 99606-5577'; // ou busca no banco
                    ob_start();
                    QRcode::png($chave, null, QR_ECLEVEL_L, 6, 2);
                    $imageString = base64_encode(ob_get_contents());
                    ob_end_clean();

                    echo '
                        <div style="text-align:center;">
                            <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:150px; display:block; margin:0 auto;">
                            <p style="margin-top:8px; font-size:12px;"><strong>Chave:</strong><br>' . htmlspecialchars($chave) . '</p>
                        </div>
                    ';
                }


                    // Coluna direita → PIX e Agência/Conta lado a lado
                    echo '<div style="display:flex; gap:40px; font-size:13px;">';

                    if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                        echo '
                            <div>
                                <p style="margin:0 0 5px 0;"><strong>Chave PIX:</strong></p>
                                <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                            </div>';
                    }

                    if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                        $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                        echo '<div>
                                <p style="margin:0 0 5px 0;"><strong>Dados para Transferência:</strong></p>';
                        foreach ($dados as $dado) {
                            echo '<p style="margin:2px 0;">' . htmlspecialchars($dado) . '</p>';
                        }
                        echo '</div>';
                    }

                    echo '</div>'; // fecha coluna direita (pix + agencia-conta lado a lado)
                    echo '</div>'; // fecha container
                }
            }
        }
        echo '
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            }else if($exames_procedimentos === true && $epi_epc === true && $faturamento === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
            <div class="top-bar" style="margin-top: 10px;"></div>';

                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
        03 - EPIs / EPCs
    </h4>';

                $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

                echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

        <!-- Produtos / Serviços -->
        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
                            $quantidade = $item["quantidade"] ?? 1;
                            $valorUnitario = $item["valor"] ?? 0;
                            $totalItem = $quantidade * $valorUnitario;

                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }


                echo '
            </table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }

        echo '</div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';

                echo '</div>';
            }else if($treinamentos === true && $epi_epc === true && $faturamento === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }

                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div style="margin-top:10px;"></div>';


                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
        03 - EPIs / EPCs
    </h4>';

                $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

                echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

        <!-- Produtos / Serviços -->
        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
                            $quantidade = $item["quantidade"] ?? 1;
                            $valorUnitario = $item["valor"] ?? 0;
                            $totalItem = $quantidade * $valorUnitario;

                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }


                echo '
            </table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    // Converte string JSON em array
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = []; // garante que $tipos seja sempre array
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:12px; color:red;"><strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.</p>';
                    } else {

                        // Verifica quais dados exibir
                $temQrCode = in_array('qrcode', $tipos);
                $temPix = in_array('pix', $tipos);
                $temAgenciaConta = in_array('agencia-conta', $tipos);

                if ($temQrCode || $temPix || $temAgenciaConta) {
                    echo '<div style="display:flex; align-items:flex-start; gap:20px; margin-bottom:20px;">';

                    // Coluna esquerda (QR Code)
                if ($temQrCode) {
                    $chave = '(64) 99606-5577'; // ou busca no banco
                    ob_start();
                    QRcode::png($chave, null, QR_ECLEVEL_L, 6, 2);
                    $imageString = base64_encode(ob_get_contents());
                    ob_end_clean();

                    echo '
                        <div style="text-align:center;">
                            <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:150px; display:block; margin:0 auto;">
                            <p style="margin-top:8px; font-size:12px;"><strong>Chave:</strong><br>' . htmlspecialchars($chave) . '</p>
                        </div>
                    ';
                }


                    // Coluna direita → PIX e Agência/Conta lado a lado
                    echo '<div style="display:flex; gap:40px; font-size:13px;">';

                    if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                        echo '
                            <div>
                                <p style="margin:0 0 5px 0;"><strong>Chave PIX:</strong></p>
                                <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                            </div>';
                    }

                    if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                        $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                        echo '<div>
                                <p style="margin:0 0 5px 0;"><strong>Dados para Transferência:</strong></p>';
                        foreach ($dados as $dado) {
                            echo '<p style="margin:2px 0;">' . htmlspecialchars($dado) . '</p>';
                        }
                        echo '</div>';
                    }

                    echo '</div>'; // fecha coluna direita (pix + agencia-conta lado a lado)
                    echo '</div>'; // fecha container
                }
            }
        }
echo '
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            }else if($exames_procedimentos === true && $faturamento === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


               if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }

            echo '</div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';

                echo '</div>';
            }else if($treinamentos === true && $faturamento === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }


                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
            
            echo '    </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            }else if($epi_epc === true && $faturamento === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
        03 - EPIs / EPCs
    </h4>';

                $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

                echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

        <!-- Produtos / Serviços -->
        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
                            $quantidade = $item["quantidade"] ?? 1;
                            $valorUnitario = $item["valor"] ?? 0;
                            $totalItem = $quantidade * $valorUnitario;

                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }

                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '
            </table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
         echo '       
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';

                echo '</div>';
            }else if ($exames_procedimentos === true && $treinamentos === true && $epi_epc === true) {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
            <div class="top-bar" style="margin-top: 10px;"></div>';

                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }



                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div style="margin-top:10px;"></div>';


                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
        03 - EPIs / EPCs
    </h4>';

                $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

                echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

        <!-- Produtos / Serviços -->
        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
                            $quantidade = $item["quantidade"] ?? 1;
                            $valorUnitario = $item["valor"] ?? 0;
                            $totalItem = $quantidade * $valorUnitario;

                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }


                echo '
            </table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';

                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
    echo '
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            } else if ($exames_procedimentos === true && $treinamentos === true) {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
            <div class="top-bar" style="margin-top: 10px;"></div>';

                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }



                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
        echo '
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            } else if ($exames_procedimentos === true && $epi_epc === true) {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
            <div class="top-bar" style="margin-top: 10px;"></div>';

                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
        03 - EPIs / EPCs
    </h4>';

                $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

                echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

        <!-- Produtos / Serviços -->
        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
                            $quantidade = $item["quantidade"] ?? 1;
                            $valorUnitario = $item["valor"] ?? 0;
                            $totalItem = $quantidade * $valorUnitario;

                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }


                echo '
            </table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }

        echo '</div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';

                echo '</div>';
            }else if($treinamentos === true && $epi_epc === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }

                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div style="margin-top:10px;"></div>';


                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
        03 - EPIs / EPCs
    </h4>';

                $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

                echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

        <!-- Produtos / Serviços -->
        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
                            $quantidade = $item["quantidade"] ?? 1;
                            $valorUnitario = $item["valor"] ?? 0;
                            $totalItem = $quantidade * $valorUnitario;

                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }


                echo '
            </table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
echo '
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            }else if($exames_procedimentos === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


               if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }










            echo '</div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';

                echo '</div>';
            }else if($treinamentos === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }


                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
            
            echo '    </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            }else if($epi_epc === true)
            {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
        03 - EPIs / EPCs
    </h4>';

                $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

                echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

        <!-- Produtos / Serviços -->
        <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
                            $quantidade = $item["quantidade"] ?? 1;
                            $valorUnitario = $item["valor"] ?? 0;
                            $totalItem = $quantidade * $valorUnitario;

                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
                                <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }

                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '
            </table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
         echo '       
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';

                echo '</div>';
            } else if ($exames_procedimentos === true && $treinamentos === true) {
                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
                $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
                <!-- Produtos / Serviços -->
    

            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
                <tr>
                    <th style="padding:3px;">Código</th>
                    <th style="padding:3px;">Descrição dos produtos/serviços</th>
                    <th style="padding:3px;">Und</th>
                    <th style="padding:3px;">Pço.Unt.</th>
                    <th style="padding:3px;">Quant.</th>
                    <th style="padding:3px;">Total do item</th>
                </tr>
        ';

                // Total geral e número de itens
                $totalGeral = 0;
                $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

                foreach ($exames_count as $item) {
                    $quantidade = 1; // Cada linha representa 1 item
                    $totalItem = $quantidade * $item['valor'];
                    $totalGeral += $totalItem;

                    echo '<tr>
                    <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                    <td style="padding:3px; text-align:right;">un</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                    <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
                    <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                }



                // Define o fuso horário do Brasil (evita diferenças)
                date_default_timezone_set('America/Sao_Paulo');

                // Data atual no formato brasileiro
                $dataAtual = date('d/m/Y');

                echo '</table>

            <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                <tr>
                    <td style="padding:3px;">' . $dataAtual . '</td>
                    <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                </tr>
                <tr>
                    <td style="padding:3px;">Formas de Pagamento:</td>
                    <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                </tr>
            </table>


            <!-- Rodapé -->
            <p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

            <p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

            <div class="top-bar"></div>
            <div class="top-bar" style="margin-top: 10px;"></div>';

                echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
                $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

                echo '<div class="top-bar"></div>
            <!-- Produtos / Serviços -->

                <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
            <tr>
                <th style="padding:3px;">Código</th>
                <th style="padding:3px;">Descrição dos produtos/serviços</th>
                <th style="padding:3px;">Und</th>
                <th style="padding:3px;">Pço.Unt.</th>
                <th style="padding:3px;">Quant.</th>
                <th style="padding:3px;">Total do item</th>
            </tr>';

                $totalGeral = 0;
                $numeroItens = 0;

                if (!empty($valores_pedidos)) {
                    foreach ($valores_pedidos as $item) {
                        // Só exibe se for treinamento
                        if (($item["tipo"] ?? "") === "treinamento") {

                            $totalItem = $item["quantidade"] * $item["valor"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '
                            <tr>
                                <td style="padding:3px;">' . $item["codigo"] . '</td>
                                <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
                                <td style="padding:3px;">un</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
                                <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                                <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
                            </tr>';
                        }
                    }
                }



                echo '</table>

                <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
                    <tr>
                        <td style="padding:3px;">' . $dataAtual . '</td>
                        <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:3px;">Formas de Pagamento:</td>
                        <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
                    </tr>
                </table>

                <!-- Rodapé -->
                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
                    (!empty($prazo_entrega)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
                        : '<span style="font-size:11px;">A combinar</span>') .
                    '</p>

                <p style="margin:4px 0;">
                    <strong style="font-size:11px;">Observações:</strong> ' .
                    (!empty($observacoes)
                        ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
                        : '<span style="font-size:11px;">Nenhuma</span>') .
                    '</p>

                <div class="top-bar"></div>
                <div class="top-bar" style="margin-top:20px;"></div>';


                if (!empty($resultado_busca_dados_bancarios)) {
                    $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                    if (!is_array($tipos)) {
                        $tipos = [];
                    }

                    if (empty($tipos)) {
                        echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                    } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
        }
        echo '
            </div>

        <!-- 🔹 Botões -->
        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>';


                echo '</div>';
            }
        }
    } else {
        echo "String vazia.";
    }

    // if (
    //     isset($recebe_processo_geraca) && strtolower(trim($recebe_processo_geraca)) === "guia de encaminhamento"
    //     || isset($recebe_processo_geraca) && strtolower(trim($recebe_processo_geraca)) === "aso - atestado de saúde ocupacional"
    //     || isset($recebe_processo_geraca) && strtolower(trim($recebe_processo_geraca)) === "prontuário médico"
    // ) {
    // }
}
