<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

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

        $dados = trim($recebe_processo_geraca); // remove espaços no começo/fim
        $dados = str_replace(["\r", "\n"], "", $dados); // remove quebras de linha

        $dados_lower = strtolower($dados);


        // Variáveis começam como false (ou vazio)
        $guia_encaminhamento   = strpos($dados_lower, strtolower('Guia de Encaminhamento')) !== false;
        $aso                   = strpos($dados_lower, strtolower('ASO - Atestado de Saúde Ocupacional')) !== false;
        $prontuario_medico     = strpos($dados_lower, strtolower('Prontuário Médico')) !== false;
        $acuidade_visual       = strpos($dados_lower, strtolower('Acuidade Visual')) !== false;
        $psicosocial           = strpos($dados_lower, strtolower('Psico Social')) !== false;
        $toxicologico          = strpos($dados_lower, strtolower('Toxicológico')) !== false;
        $resumo_laudo          = strpos($dados_lower, strtolower('Resumo de Laudo')) !== false;
        $exames_procedimentos  = strpos($dados_lower, strtolower('Exames e Procedimentos')) !== false;
        $treinamentos          = strpos($dados_lower, strtolower('Treinamentos')) !== false;
        $epi_epc          = strpos($dados_lower, strtolower('EPI/EPC')) !== false;

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


        if ($guia_encaminhamento || $aso || $prontuario_medico) {



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
                        echo "Cargo:" . $_SESSION["cargo_selecionado"] . "<br>";

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
                    echo "ID Médico coordenador:" . $_SESSION["medico_coordenador_selecionado"];

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
                    echo "ID médico emitente:" . $_SESSION["medico_clinica_selecionado"] . "<br>";

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
                $riscosTabela .= '<h3>06 - Fatores de Risco</h3><table>';
                foreach ($grupos as $chave => $titulo) {
                    $valores = !empty($riscosPorGrupo[$chave]) ? implode(", ", $riscosPorGrupo[$chave]) : "N/A";
                    $riscosTabela .= "<tr><th>{$titulo}</th><td>{$valores}</td></tr>";
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

                $aptidoesTabela .= '<h3>08 - Aptidões Extras</h3><p>';
                foreach ($linhas as $par) {
                    $esq = $par[0] . " " . marcarApt($par[0], $aptidoesSelecionadas);
                    $dir = $par[1] . " " . marcarApt($par[1], $aptidoesSelecionadas);
                    $aptidoesTabela .= $esq . " — " . $dir . "<br>";
                }
                $aptidoesTabela .= '</p>';
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
    body { font-family: Arial, sans-serif; background:#f2f2f2; }
    .guia-container {
        width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
        background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
        page-break-after: always;
    }
    h2 { text-align:center; margin:20px 0; }
    h3 {
        margin-top:20px; margin-bottom:10px;
        background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
    }
    table { width:100%; border-collapse:collapse; margin-bottom:15px; }
    th, td { border:1px solid #ccc; padding:6px; font-size:13px; vertical-align:top; }
    th { background:#f8f9fa; text-align:left; width:35%; }
    input, textarea {
        width:100%; border:none; background:transparent; font-size:13px;
    }
    input:disabled, textarea:disabled {
        color:#000; cursor:not-allowed;
    }
    .assinatura { height:40px; border-bottom:1px solid #000; margin-top:10px; }
    .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
    .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
    .btn {
        padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
        cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
    }
    .btn-email { background:#007bff; }
    .btn-whatsapp { background:#25d366; }
    .btn-print { background:#6c757d; }
    .btn:hover { opacity:.9; }
    @media print { .actions { display:none; } body { background:#fff; } }
    .logo { text-align:center; margin-bottom:15px; }
    .logo img { max-height:80px; }
</style>

<!-- ===================== GUIA DE ENCAMINHAMENTO ===================== -->
<div class="guia-container">
    <div class="logo">
        <img src="logo.png" alt="Logo da Empresa">
    </div>
    <h2>GUIA DE ENCAMINHAMENTO</h2>

    <h3>01 - Identificação</h3>
    <table>
        <tr><th>Hospital/Clínica</th><td>' . htmlspecialchars($resultado_clinica_selecionada['nome_fantasia'] ?? "") . '</td></tr>
        <tr><th>CNPJ</th><td>' . htmlspecialchars($resultado_clinica_selecionada['cnpj'] ?? "") . '</td></tr>
        <tr><th>Endereço</th><td>' . htmlspecialchars(trim($resultado_clinica_selecionada['endereco'] ?? "")) . ', ' . htmlspecialchars($resultado_clinica_selecionada['numero'] ?? "") . ', ' . htmlspecialchars($resultado_clinica_selecionada['bairro'] ?? "") . '</td></tr>
        <tr><th>Cidade/UF</th><td>' . htmlspecialchars($recebe_cidade_uf ?? "") . '</td></tr>
        <tr><th>Telefone</th><td>' . htmlspecialchars($resultado_clinica_selecionada['telefone'] ?? "") . '</td></tr>
    </table>

    <h3>02 - Tipo de Exame / Procedimento</h3>
    <p>Admissional ' . marcar("admissional", $recebe_exame) . ' 
       Periódico ' . marcar("periodico", $recebe_exame) . ' 
       Demissional ' . marcar("demissional", $recebe_exame) . ' 
       Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' 
       Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '</p>

    <h3>03 - Dados do Funcionário / Empresa</h3>
    <table>
        <tr><th>Empresa</th><td>' . htmlspecialchars($resultado_empresa_selecionada['nome'] ?? "") . '</td></tr>
        <tr><th>CNPJ</th><td>' . htmlspecialchars($resultado_empresa_selecionada['cnpj'] ?? "") . '</td></tr>
        <tr><th>Nome Funcionário</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . '</td></tr>
        <tr><th>CPF</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '</td></tr>
        <tr><th>Cargo</th><td>' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td></tr>
        <tr><th>CBO</th><td>' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td></tr>
    </table>

    <h3>04 - Mudança de Função</h3>
    <table>
        <tr><th>Novo Cargo</th><td>' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td></tr>
        <tr><th>Novo CBO</th><td>' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td></tr>
    </table>

    <h3>05 - Dados dos Médicos</h3>
    <table>
        <tr><th>Médico Coordenador</th><td>' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . '</td></tr>
        <tr><th>CRM</th><td>' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '</td></tr>
        <tr><th>Médico Emitente</th><td>' . htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "") . '</td></tr>
        <tr><th>CRM</th><td>' . htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "") . '</td></tr>
    </table>

    ' . $riscosTabela . '

    <h3>07 - Procedimentos / Exames Realizados</h3>
    <table>
        <tr><th>Exame</th><td>' . htmlspecialchars($recebe_exame_exibicao ?? "") . '</td></tr>
        <tr><th>Data</th><td>' . htmlspecialchars($dataAtual ?? "") . '</td></tr>
    </table>

    ' . $aptidoesTabela . '

    <h3>09 - Conclusão</h3>
    <p>ALTO ARAGUAIA - MT, DATA: ' . htmlspecialchars($dataAtual ?? "") . '</p>
    <p>Resultado: ( ) APTO  ( ) INAPTO</p>
    <div class="assinatura"></div>
    <small>
        Médico Responsável - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '/MT<br>
        Funcionário: ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
    </small>
</div>

<!-- ===================== PRONTUÁRIO MÉDICO ===================== -->
<div class="guia-container">
    <div class="logo">
        <img src="logo.png" alt="Logo da Empresa">
    </div>
    <h2>PRONTUÁRIO MÉDICO</h2>

    <h3>01 - Identificação</h3>
    <table>
        <tr><th>Hospital/Clínica</th><td>' . htmlspecialchars($resultado_clinica_selecionada['nome_fantasia'] ?? "") . '</td></tr>
        <tr><th>CNPJ</th><td>' . htmlspecialchars($resultado_clinica_selecionada['cnpj'] ?? "") . '</td></tr>
        <tr><th>Endereço</th><td>' . htmlspecialchars(trim($resultado_clinica_selecionada['endereco'] ?? "")) . '</td></tr>
        <tr><th>Cidade/UF</th><td>' . htmlspecialchars($recebe_cidade_uf ?? "") . '</td></tr>
        <tr><th>Telefone</th><td>' . htmlspecialchars($resultado_clinica_selecionada['telefone'] ?? "") . '</td></tr>
    </table>

    <h3>02 - Tipo de Prontuário</h3>
    <p>Admissional ' . marcar("admissional", $recebe_exame) . ' 
       Periódico ' . marcar("periodico", $recebe_exame) . ' 
       Demissional ' . marcar("demissional", $recebe_exame) . ' 
       Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' 
       Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '</p>

    <h3>03 - Dados do Funcionário / Empresa</h3>
    <table>
        <tr><th>Empresa</th><td>' . htmlspecialchars($resultado_empresa_selecionada['nome'] ?? "") . '</td></tr>
        <tr><th>CNPJ</th><td>' . htmlspecialchars($resultado_empresa_selecionada['cnpj'] ?? "") . '</td></tr>
        <tr><th>Funcionário</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . '</td></tr>
        <tr><th>CPF</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '</td></tr>
        <tr><th>Telefone</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['telefone'] ?? "") . '</td></tr>
        <tr><th>Data Nascimento</th><td>' . htmlspecialchars($recebe_nascimento_colaborador ?? "") . '</td></tr>
        <tr><th>Idade</th><td>' . htmlspecialchars($idade) . ' anos</td></tr>
        <tr><th>Cargo</th><td>' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td></tr>
        <tr><th>CBO</th><td>' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td></tr>
    </table>

    <h3>04 - Mudança de Função</h3>
    <table>
        <tr><th>Novo Cargo</th><td>' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td></tr>
        <tr><th>Novo CBO</th><td>' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td></tr>
    </table>

    <h3>05 - Dados dos Médicos</h3>
    <table>
        <tr><th>Médico Coordenador</th><td>' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - CRM: ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '</td></tr>
        <tr><th>Médico Emitente</th><td>' . htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "") . ' - CRM: ' . htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "") . '</td></tr>
    </table>

    <h3>06 - Informações Clínicas</h3>
    <table>
        <tr><th colspan="2">ANTECEDENTES FAMILIARES</th><th>SIM</th><th>NÃO</th><th colspan="2">ANTECEDENTES PESSOAIS</th><th>SIM</th><th>NÃO</th></tr>

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
    </table>

    <h3>07 - Hábitos de Vida</h3>
    <table>
        <tr><th colspan="2">HÁBITOS DE VIDA</th><th>SIM</th><th>NÃO</th><th colspan="2"></th><th>SIM</th><th>NÃO</th></tr>

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

    <h3>08 - Antecedentes Ocupacionais</h3>
    <table>
        <tr><th colspan="2">ANTECEDENTES OCUPACIONAIS</th><th>SIM</th><th>NÃO</th><th colspan="2"></th><th>SIM</th><th>NÃO</th></tr>

        <tr><td colspan="2">JÁ TEVE FRATURAS?</td><td></td><td></td>
            <td colspan="2">PODE EXECUTAR TAREFAS PESADAS?</td><td></td><td></td></tr>

        <tr><td colspan="2">REALIZA TRABALHO FORA DA EMPRESA?</td><td></td><td></td>
            <td colspan="2">EXECUTOU TAREFAS INSALUBRES/PERIGOSAS?</td><td></td><td></td></tr>

        <tr><td colspan="2">JÁ ESTEVE DOENTE DEVIDO AO SEU TRABALHO?</td><td></td><td></td>
            <td colspan="2">POSSUI DIFICULDADE MOTORA?</td><td></td><td></td></tr>

        <tr><td colspan="2">JÁ FOI DEMITIDO POR MOTIVO DE DOENÇA?</td><td></td><td></td>
            <td colspan="2">JÁ ESTEVE AFASTADO PELO INSS?</td><td></td><td></td></tr>

        <tr><td colspan="2">JÁ TEVE ACIDENTE DE TRABALHO?</td><td></td><td></td>
            <td colspan="2">PARA MULHERES — DATA DA ÚLTIMA MENSTRUAÇÃO ___/___/____ &nbsp; DATA DO ÚLTIMO PREVENTIVO ___/___/____</td><td></td><td></td></tr>
    </table>

    <p><strong>07 - Declaração:</strong> Declaro como verdade os dados preenchidos neste prontuário.<br>
    ALTO ARAGUAIA - MT, DATA: ' . htmlspecialchars($dataAtual ?? "") . '</p>

    <div class="assinatura"></div>
    <small>
        Médico Responsável - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '/MT<br>
        Funcionário: ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
    </small>


        <h3>08 - Aptidão Física e Mental</h3>
<table>
    <tr>
        <th>Altura</th>
        <th>Peso</th>
        <th>Temperatura</th>
        <th>Pulso</th>
        <th>Pressão Arterial</th>
    </tr>
</table>

<table>
    <tr><th>Normal</th><th>Anormal</th><th>Observação</th></tr>
    <tr><td colspan="3">Aspecto Geral</td></tr>
    <tr><td colspan="3">Olhos</td></tr>
    <tr><td colspan="3">Otoscopia</td></tr>
    <tr><td colspan="3">Nariz</td></tr>
    <tr><td colspan="3">Boca - Amígdalas - Dentes</td></tr>
    <tr><td colspan="3">Pescoço - Gânglios</td></tr>
    <tr><td colspan="3">Pulmão</td></tr>
    <tr><td colspan="3">Coração</td></tr>
    <tr><td colspan="3">Abdome</td></tr>
    <tr><td colspan="3">Coluna</td></tr>
    <tr><td colspan="3">Membros Superiores</td></tr>
    <tr><td colspan="3">Membros Inferiores</td></tr>
    <tr><td colspan="3">Pele e Faneros</td></tr>
    <tr><td colspan="3">Psiquismo</td></tr>
    <tr><td colspan="3">Exames Complementares</td></tr>
</table>

<h3>09 - Preenchimento Obrigatório em Caso de Exame Demissional</h3>
<table>
    <tr><th colspan="6">Demissional</th></tr>
<tr><td colspan="6">Adquiriu alguma doença em virtude da função?</td></tr>
<tr><td colspan="6">Sofreu acidente de trabalho na empresa?</td></tr>
<tr><td colspan="6">Recebeu EPI da empresa?</td></tr>
<tr>
  <td colspan="6">
    PRESSÃO ARTERIAL: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 
    PULSO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | 
    TEMPERATURA: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </td>
</tr>
</table>


<h3>10 - Para Mulheres</h3>
<table>
    <tr>
        <th>Data da Última Menstruação</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['ultima_menstruacao'] ?? "") . '</td>
        <th>Data do Último Preventivo</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['ultimo_preventivo'] ?? "") . '</td>
    </tr>
</table>

<h3>11 - Exames Complementares</h3>
<p>___________________________________________________________________________________</p>

<h3>12 - Evolução Clínica</h3>
<p>___________________________________________________________________________________</p>

<h3>13 - Conclusão</h3>
<p>Atesto que o trabalhador acima identificado se submeteu aos exames médicos ocupacionais em cumprimento à NR-07, itens 7.5.19.1 e 7.5.19.2.<br>
Resultado: ( ) APTO  ( ) INAPTO</p>
<p>ALTO ARAGUAIA - MT, DATA: ' . htmlspecialchars($dataAtual ?? "") . '</p>

<div class="assinatura"></div>
<small>
    Médico Responsável - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '/MT<br>
    Funcionário: ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
</small>

    </div>


<!-- ===================== ASO ===================== -->
<div class="guia-container">
    <h2>ASO - Atestado de Saúde Ocupacional</h2>
    <table>
        <tr><th>Hospital/Clínica</th><td>' . htmlspecialchars($resultado_clinica_selecionada['nome_fantasia'] ?? "") . '</td></tr>
        <tr><th>CNPJ</th><td>' . htmlspecialchars($resultado_clinica_selecionada['cnpj'] ?? "") . '</td></tr>
        <tr><th>Endereço</th><td>' . htmlspecialchars(trim($resultado_clinica_selecionada['endereco'] ?? "")) . '</td></tr>
        <tr><th>Cidade/UF</th><td>' . htmlspecialchars($recebe_cidade_uf ?? "") . '</td></tr>
        <tr><th>Telefone</th><td>' . htmlspecialchars($resultado_clinica_selecionada['telefone'] ?? "") . '</td></tr>
    </table>

    <h3>02 - Tipo de Prontuário</h3>
    <p>Admissional ' . marcar("admissional", $recebe_exame) . ' 
       Periódico ' . marcar("periodico", $recebe_exame) . ' 
       Demissional ' . marcar("demissional", $recebe_exame) . ' 
       Mudança de Risco/Função ' . marcar("mudanca", $recebe_exame) . ' 
       Retorno ao Trabalho ' . marcar("retorno", $recebe_exame) . '</p>

    <h3>03 - Dados do Funcionário / Empresa</h3>
    <table>
        <tr><th>Empresa</th><td>' . htmlspecialchars($resultado_empresa_selecionada['nome'] ?? "") . '</td></tr>
        <tr><th>CNPJ</th><td>' . htmlspecialchars($resultado_empresa_selecionada['cnpj'] ?? "") . '</td></tr>
        <tr><th>Funcionário</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . '</td></tr>
        <tr><th>CPF</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '</td></tr>
        <tr><th>Telefone</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['telefone'] ?? "") . '</td></tr>
        <tr><th>Data Nascimento</th><td>' . htmlspecialchars($recebe_nascimento_colaborador ?? "") . '</td></tr>
        <tr><th>Idade</th><td>' . htmlspecialchars($idade) . ' anos</td></tr>
        <tr><th>Cargo</th><td>' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td></tr>
        <tr><th>CBO</th><td>' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td></tr>
    </table>

    <h3>04 - Mudança de Função</h3>
    <table>
        <tr><th>Novo Cargo</th><td>' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td></tr>
        <tr><th>Novo CBO</th><td>' . htmlspecialchars($resultado_cargo_selecionado['codigo_cargo'] ?? "") . '</td></tr>
    </table>

    <h3>05 - Dados dos Médicos</h3>
    <table>
        <tr><th>Médico Coordenador</th><td>' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . '</td></tr>
        <tr><th>CRM</th><td>' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '</td></tr>
        <tr><th>Médico Emitente</th><td>' . htmlspecialchars($resultado_medico_relacionado_clinica['nome'] ?? "") . '</td></tr>
        <tr><th>CRM</th><td>' . htmlspecialchars($resultado_medico_relacionado_clinica['crm'] ?? "") . '</td></tr>
    </table>

    ' . $riscosTabela . '

    <h3>07 - Procedimentos / Exames Realizados</h3>
    <table>
        <tr><th>Exame</th><td>' . htmlspecialchars($recebe_exame_exibicao ?? "") . '</td></tr>
        <tr><th>Data</th><td>' . htmlspecialchars($dataAtual ?? "") . '</td></tr>
    </table>

    ' . $aptidoesTabela . '

    <h3>Conclusão</h3>
    <p>Atesto que o trabalhador foi avaliado conforme NR-07: ( ) APTO ( ) INAPTO<br>
    Local: ALTO ARAGUAIA-MT — Data:' . htmlspecialchars($dataAtual ?? "") . '</p>
    <div class="assinatura"></div>
    <small>
        Médico Responsável - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['nome'] ?? "") . ' - ' . htmlspecialchars($resultado_medico_coordenador_selecionado['crm'] ?? "") . '/MT<br>
        Funcionário: ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") . ' — CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '
    </small>
</div>

<div class="actions">
    <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
    <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
    <button class="btn btn-print" onclick="window.print()">Salvar</button>
</div>

<script>
function enviarClinica(){
    alert("Função de envio de email para clínica ainda não implementada.");
}
function enviarEmpresa(){
    let msg = encodeURIComponent("Segue documento médico.");
    window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
}
</script>
';
            }

            if ($acuidade_visual) {


                echo '
                <!DOCTYPE html>
                <html lang="pt-br">
                <head>
                <meta charset="UTF-8">
                <title>Teste de Acuidade Visual</title>
                <style>
                body { font-family: Arial, sans-serif; background:#f2f2f2; }
                .documento {
                    width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
                    background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
                }
                h2 { text-align:center; margin-bottom:15px; }
                table { 
        border-collapse:collapse; 
        width:100%; 
        margin-bottom:15px; 
    }
    th, td { 
        border:1px solid #ccc; 
        padding:6px; 
        font-size:13px; 
    }
    th { 
        background:#f8f9fa; 
        text-align:left; 
    }
    td { 
        text-align:left; 
    }

    /* Apenas tabelas de testes visuais centralizadas */
    .table-center td, 
    .table-center th { 
        text-align:center; 
    }
                .bloco-titulo {
                    margin:15px 0 8px 0; font-weight:bold; font-size:14px;
                    background:#e9ecef; padding:6px 10px; border:1px solid #ccc; text-align:left;
                }
                .assinatura { height:40px; border-bottom:1px solid #000; margin:10px 0; }
                .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
                .options { display:flex; gap:20px; margin:5px 0; }
                .opt { display:flex; align-items:center; gap:5px; font-size:13px; }
                input { border:none; background:transparent; width:100%; text-align:center; }
                input:disabled { color:#000; }

                /* Botões de ação */
                .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
                .btn {
                    padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
                    cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
                }
                .btn-email { background:#007bff; }
                .btn-whatsapp { background:#25d366; }
                .btn-print { background:#6c757d; }
                .btn:hover { opacity:.9; }

                @media print { body { background:#fff; } .actions { display:none; } }
                </style>
                </head>
                <body>

                <div class="documento">
                <h2>TESTE DE ACUIDADE VISUAL</h2>

                <div class="bloco-titulo">Identificação</div>
                <table>
                    <tr>
                    <th>Nome</th><td>'. htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") .'</td>
                    <th>Código</th><td>' . htmlspecialchars($resultado_pessoa_selecionada['cpf'] ?? "") . '</td>
                    </tr>
                    <tr>
                    <th>Cidade</th><td>' . htmlspecialchars($recebe_cidade_uf ?? "") . '</td>
                    <th>Função</th><td>' . htmlspecialchars($resultado_cargo_selecionado['titulo_cargo'] ?? "") . '</td>
                    </tr>
                    <tr>
                    <th>Empresa</th><td colspan="3">' . htmlspecialchars($resultado_empresa_selecionada['nome'] ?? "") . '</td>
                    </tr>
                </table>

                <div class="bloco-titulo">Questionário</div>
                <table>
                    <tr><th>1) Usa óculos / lentes de contato?</th><td></td></tr>
                    <tr><th>2) Já teve algum problema com os olhos?</th><td></td></tr>
                    <tr><th>3) Exame será realizado com óculos/lentes?</th><td></td></tr>
                </table>

                <div class="bloco-titulo">Tabela de Snellen</div>
                <table>
                    <tr>
                    <th></th>
                    <th>20/200</th><th>20/100</th><th>20/50</th><th>20/40</th><th>20/30</th>
                    <th>20/25</th><th>20/20</th><th>20/15</th><th>20/13</th><th>20/10</th>
                    </tr>
                    <tr><th>OD</th><td colspan="10"></td></tr>
                    <tr><th>OE</th><td colspan="10"></td></tr>
                    <tr><th>AO</th><td colspan="10"></td></tr>
                </table>

                <div class="bloco-titulo">Carta de Jeager (Visão de Perto)</div>
                <table>
                    <tr><th>J6</th><th>J5</th><th>J4</th><th>J3</th><th>J2</th><th>J1</th></tr>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                </table>

                <div class="bloco-titulo">Teste de Ishihara</div>
                <div class="options">
                    <label class="opt"><input type="checkbox"> Normal</label>
                    <label class="opt"><input type="checkbox"> Alterado</label>
                </div>

                <div class="bloco-titulo">Conclusão</div>
                <table>
                    <tr><th>Tabela de Snellen</th><td></td></tr>
                    <tr><th>Carta de Jeager</th><td></td></tr>
                </table>

                <div class="bloco-titulo">Assinaturas</div>
                <table>
                    <tr><th>Data</th><td>' . htmlspecialchars($dataAtual ?? "") . '</td></tr>
                    <tr><th>Examinador</th><td><div class="assinatura"></div></td></tr>
                    <tr><th>Colaborador</th><td><div class="assinatura"></div></td></tr>
                </table>

                <div class="actions">
                    <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                    <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                    <button class="btn btn-print" onclick="window.print()">Salvar</button>
                </div>
                </div>

                <script>
                function enviarClinica(){
                alert("Função de envio de email para clínica ainda não implementada.");
                }
                function enviarEmpresa(){
                var msg = encodeURIComponent("Segue o Teste de Acuidade Visual.");
                window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
                }
                </script>

                </body>
                </html>
                ';
            } else if ($psicosocial) {
                echo '<style>
                    body { font-family: Arial, sans-serif; background:#f2f2f2; }
                    .guia-container {
                        width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
                        background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
                    }
                    h2 { text-align:center; margin-bottom:20px; }
                    h3 {
                        margin-top:20px; margin-bottom:10px;
                        background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
                    }
                    table { width:100%; border-collapse:collapse; margin-bottom:15px; }
                    th, td { border:1px solid #ccc; padding:6px; font-size:13px; text-align:left; }
                    th { background:#f8f9fa; }
                    input, textarea {
                        width:100%; border:none; background:transparent; font-size:13px;
                    }
                    input:disabled, textarea:disabled { color:#000; cursor:not-allowed; }
                    .assinatura { height:40px; border-bottom:1px solid #000; margin-top:10px; }
                    .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
                    .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
                    .btn {
                        padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
                        cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
                    }
                    .btn-email { background:#007bff; }
                    .btn-whatsapp { background:#25d366; }
                    .btn-print { background:#6c757d; }
                    .btn:hover { opacity:.9; }
                    @media print { .actions { display:none; } body { background:#fff; } }
                </style>

                <div class="guia-container">
                    <h2>QUESTIONÁRIO PSICOSSOCIAL</h2>

                    <h3>01 - Identificação</h3>
                    <table>
                        <tr>
                            <th style="width:10%;">Nome</th>
                            <td>'. htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? "") .'</td>
                            <th style="width:10%;">Data</th>
                            <td>' . htmlspecialchars($dataAtual ?? "") . '</td>
                        </tr>
                        <tr>
                            <th style="width:10%;">RG</th>
                            <td><input type="text" value="" disabled></td>
                            <th style="width:10%;">Telefone</th>
                            <td>'. htmlspecialchars($resultado_pessoa_selecionada['telefone'] ?? "") .'</td>
                        </tr>
                        <tr>
                            <th style="width:10%;">Idade</th>
                            <td>' . htmlspecialchars($idade) . ' anos</td>
                            <th style="width:10%;">Peso</th>
                            <td><input type="text" value="" disabled></td>
                        </tr>
                        <tr>
                            <th style="width:10%;">Altura</th>
                            <td><input type="text" value="" disabled></td>
                            <td colspan="2"></td>
                        </tr>
                    </table>


                    <h3>02 - Avaliação da Qualidade do Sono</h3>
                    <table>
                        <tr><td>1. Você leva mais de 30 minutos para adormecer?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>2. Você acorda muitas vezes durante a noite?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>3. E quando acorda, demora muito para voltar a dormir?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>4. Seu sono é agitado, inquieto?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>5. Precisa de um despertador para acordar?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>6. Tem dificuldades para levantar de manhã?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>7. Sente-se cansado ao longo do dia?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>8. Já sofreu algum acidente de estepe por dormir pouco?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>9. Cochila diante da TV ou em outras situações?</td><td>Sim ( ) Não ( )</td></tr>
                        <tr><td>10. Dorme mais nos finais de semana?</td><td>Sim ( ) Não ( )</td></tr>
                    </table>

                    <h3>03 - Escala de Sonolência Diurna (Epworth)</h3>
                        <table style="width:100%; border-collapse:collapse;">
                            <tr>
                                <th style="width:40%;">Situação</th>
                                <th style="width:15%;">Nunca (0)</th>
                                <th style="width:15%;">Pouca (1)</th>
                                <th style="width:15%;">Média (2)</th>
                                <th style="width:15%;">Grande (3)</th>
                            </tr>
                            <tr><td>Lendo</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td></tr>
                            <tr><td>Assistindo TV</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td></tr>
                            <tr><td>Em local público</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td></tr>
                            <tr><td>Como passageiro em carro</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td></tr>
                            <tr><td>Conversando com alguém</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td></tr>
                            <tr><td>Sentado calmamente</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td></tr>
                            <tr><td>Após almoço sem álcool</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td></tr>
                            <tr><td>No carro, parado no trânsito</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td><td style="text-align:center;">( )</td></tr>
                        </table>


                    <h3>04 - Escala de Fadiga de Chalder</h3>
                    <table style="width:100%; border-collapse:collapse; border: 1px solid #000;">
                        <tr>
                            <th style="width:40%; border: 1px solid #000;">Sintomas Físicos</th>
                            <th style="width:15%; border: 1px solid #000;">Não ou Menos que o Normal</th>
                            <th style="width:15%; border: 1px solid #000;">Igual ao Normal</th>
                            <th style="width:15%; border: 1px solid #000;">Mais que Normal</th>
                            <th style="width:15%; border: 1px solid #000;">Muito mais que o Normal</th>
                        </tr>
                        <tr>
                            <td>1. Você tem problemas com cansaço?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>2. Você precisa descansar mais?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>3. Você se sente com sono ou sonolência?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>4. Você tem problemas para começar a fazer as coisas?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>5. Você começa coisas com dificuldade mas fica cansado quando continua?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>6. Você está perdendo energia?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>7. Você tem menos força em seus músculos?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>8. Você se sente fraco?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>

                        <!-- Sintomas Mentais -->
                        <tr>
                            <th style="border: 1px solid #000;" colspan="5">Sintomas Mentais</th>
                        </tr>
                        <tr>
                            <td>9. Você tem dificuldade de concentração?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>10. Você tem problemas em pensar claramente?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>11. Você comete erros, sem intenção, na sua língua (Português) quando acha mais difícil de encontrar a palavra correta?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>12. Como está sua memória?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                        <tr>
                            <td>13. Você perdeu o interesse em coisas que costumava fazer?</td>
                            <td style="text-align:center;">1</td><td style="text-align:center;">2</td><td style="text-align:center;">3</td><td style="text-align:center;">4</td>
                        </tr>
                    </table>




                    <h3>05 - Avaliação Psicológica</h3>
                    <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
                        <tr>
                            <td style="width:50%; border:1px solid #000;">3. Você tem ou teve síndrome do pânico?</td>
                            <td style="width:25%; border:1px solid #000;">SIM ( )</td>
                            <td style="width:25%; border:1px solid #000;">NÃO ( )</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;">4. Você tem ou teve familiar com síndrome do pânico?</td>
                            <td style="border:1px solid #000;">SIM ( )</td>
                            <td style="border:1px solid #000;">NÃO ( )</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;">5. Você tem ou teve depressão?</td>
                            <td style="border:1px solid #000;">SIM ( )</td>
                            <td style="border:1px solid #000;">NÃO ( )</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;">6. Você tem ou teve familiar com depressão?</td>
                            <td style="border:1px solid #000;">SIM ( )</td>
                            <td style="border:1px solid #000;">NÃO ( )</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;">9. Você tem ou já teve crise convulsiva?</td>
                            <td style="border:1px solid #000;">SIM ( )</td>
                            <td style="border:1px solid #000;">NÃO ( )</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;">10. Você tem tonturas? Labirintite?</td>
                            <td style="border:1px solid #000;">SIM ( )</td>
                            <td style="border:1px solid #000;">NÃO ( )</td>
                        </tr>
                    </table>


                    <h3>06 - Self Report Questionnaire (SRQ) (HARDING et al., 1980)</h3>
                    <table style="width:100%; border-collapse:collapse; border:1px solid #000; font-size:13px;">
                    <tr>
                        <td style="width:30%; border:1px solid #000;">1. Tem dores de cabeça frequentes?</td>
                        <td style="width:7%; border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="width:8%; border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="width:40%; border:1px solid #000;">11. Tem falta de apetite?</td>
                        <td style="width:7%; border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="width:8%; border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">2. Assusta-se com facilidade?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">12. Dorme mal?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">3. Tem tremores de mão?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">13. Tem perdido o interesse pelas coisas?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">4. Tem má digestão?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">14. Você cansa com facilidade?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">5. Você tem se sentido triste ultimamente?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">15. Tem tido ideias de acabar com a própria vida?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">6. Você tem chorado mais do que de costume?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">16. Sente-se cansado (a) o tempo todo?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">7. Tem dificuldade de pensar com clareza?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">17. Tem sensações desagradáveis no estômago?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">8. Tem dificuldades no serviço (ou trabalho de casa, causas sofrimento)?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">18. Tem dificuldades para tomar decisões?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">9. É incapaz de desempenhar um papel útil na sua vida?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">19. Encontra dificuldades para realizar com satisfação suas atividades?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000;">10. Sente-se nervoso, tenso ou preocupado?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                        <td style="border:1px solid #000;">20. Você se sente uma pessoa inútil, sem préstimo?</td>
                        <td style="border:1px solid #000; text-align:center;">SIM ( )</td>
                        <td style="border:1px solid #000; text-align:center;">NÃO ( )</td>
                    </tr>
                    </table>

                    <h3>07 - Distúrbio de Uso do Álcool (AUDIT)</h3>
                    <table style="width:100%; border-collapse:collapse; border:1px solid #000; font-size:13px;">
                    <tr>
                        <th style="text-align:left; border:1px solid #000;">Pergunta</th>
                        <th style="width:18%; border:1px solid #000; text-align:center;">0</th>
                        <th style="width:18%; border:1px solid #000; text-align:center;">1</th>
                        <th style="width:18%; border:1px solid #000; text-align:center;">2</th>
                        <th style="width:18%; border:1px solid #000; text-align:center;">3</th>
                        <th style="width:18%; border:1px solid #000; text-align:center;">4</th>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">1. Frequência de consumo de bebidas alcoólicas</td>
                        <td style="border:1px solid #000;">Nunca</td>
                        <td style="border:1px solid #000;">1 vez/mês ou menos</td>
                        <td style="border:1px solid #000;">2 a 4 vezes/mês</td>
                        <td style="border:1px solid #000;">2 a 3 vezes/semana</td>
                        <td style="border:1px solid #000;">4 ou mais vezes/semana</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">2. Quantidade ingerida em um dia típico</td>
                        <td style="border:1px solid #000;">1 ou 2 doses</td>
                        <td style="border:1px solid #000;">3 ou 4 doses</td>
                        <td style="border:1px solid #000;">5 ou 6 doses</td>
                        <td style="border:1px solid #000;">7 a 9 doses</td>
                        <td style="border:1px solid #000;">10 ou mais doses</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">3. Frequência de beber 6 ou mais doses em uma ocasião</td>
                        <td style="border:1px solid #000;">Nunca</td>
                        <td style="border:1px solid #000;">Menos de 1 vez/mês</td>
                        <td style="border:1px solid #000;">Mensalmente</td>
                        <td style="border:1px solid #000;">Semanalmente</td>
                        <td style="border:1px solid #000;">Quase todos os dias</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">4. Incapaz de parar de beber uma vez iniciado</td>
                        <td style="border:1px solid #000;">Nunca</td>
                        <td style="border:1px solid #000;">Menos de 1 vez/mês</td>
                        <td style="border:1px solid #000;">Mensalmente</td>
                        <td style="border:1px solid #000;">Semanalmente</td>
                        <td style="border:1px solid #000;">Diariamente</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">5. Falhou em cumprir tarefas por causa do álcool</td>
                        <td style="border:1px solid #000;">Nunca</td>
                        <td style="border:1px solid #000;">Menos de 1 vez/mês</td>
                        <td style="border:1px solid #000;">Mensalmente</td>
                        <td style="border:1px solid #000;">Semanalmente</td>
                        <td style="border:1px solid #000;">Diariamente</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">6. Precisa beber pela manhã para “pegar no tranco”</td>
                        <td style="border:1px solid #000;">Nunca</td>
                        <td style="border:1px solid #000;">Menos de 1 vez/mês</td>
                        <td style="border:1px solid #000;">Mensalmente</td>
                        <td style="border:1px solid #000;">Semanalmente</td>
                        <td style="border:1px solid #000;">Diariamente</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">7. Sentiu culpa ou remorso após beber</td>
                        <td style="border:1px solid #000;">Nunca</td>
                        <td style="border:1px solid #000;">Menos de 1 vez/mês</td>
                        <td style="border:1px solid #000;">Mensalmente</td>
                        <td style="border:1px solid #000;">Semanalmente</td>
                        <td style="border:1px solid #000;">Diariamente</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">8. Incapaz de lembrar o que aconteceu (blackout)</td>
                        <td style="border:1px solid #000;">Nunca</td>
                        <td style="border:1px solid #000;">Menos de 1 vez/mês</td>
                        <td style="border:1px solid #000;">Mensalmente</td>
                        <td style="border:1px solid #000;">Semanalmente</td>
                        <td style="border:1px solid #000;">Diariamente</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">9. Você ou outra pessoa já se feriu por causa do seu beber</td>
                        <td style="border:1px solid #000;">Não</td>
                        <td style="border:1px solid #000;">-----------</td>
                        <td style="border:1px solid #000;">Sim, no último ano</td>
                        <td style="border:1px solid #000;" colspan="2">-----------</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000;">10. Alguém sugeriu que você diminuísse o consumo</td>
                        <td style="border:1px solid #000;">Não</td>
                        <td style="border:1px solid #000;">-----------</td>
                        <td style="border:1px solid #000;">Sim, no último ano</td>
                        <td style="border:1px solid #000;" colspan="2">-----------</td>
                    </tr>
                    </table>

                    <h3>08 - Teste de Nicotina de Fagerström</h3>
<table style="width:100%; border-collapse:collapse; border:1px solid #000; font-size:13px;">
    <!-- Título das colunas -->
    <tr>
        <th style="border:1px solid #000;">Responda as questões</th>
        <th style="border:1px solid #000; text-align:center;" colspan="4">Pontuações</th>
    </tr>
    <!-- Números das pontuações -->
    <tr>
        <th style="border:1px solid #000;"></th>
        <th style="border:1px solid #000; text-align:center;">3</th>
        <th style="border:1px solid #000; text-align:center;">2</th>
        <th style="border:1px solid #000; text-align:center;">1</th>
        <th style="border:1px solid #000; text-align:center;">0</th>
    </tr>
    <!-- Linha "Não fumo" abaixo da célula vazia -->
    <tr>
        <td style="border:1px solid #000; text-align:center;">Não fumo</td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
    </tr>

    <!-- Pergunta 1 -->
    <tr>
        <td style="border:1px solid #000;">1. Depois de quanto tempo, após acordar, você acende o primeiro cigarro do dia?</td>
        <td style="border:1px solid #000; text-align:center;">Menos de 5 min</td>
        <td style="border:1px solid #000; text-align:center;">De 6 a 30 min</td>
        <td style="border:1px solid #000; text-align:center;">De 31 a 60 min</td>
        <td style="border:1px solid #000; text-align:center;">Mais de 60 min</td>
    </tr>

    <!-- Pergunta 2 -->
    <tr>
        <td style="border:1px solid #000;">2. Atualmente quantos cigarros você fuma por dia?</td>
        <td style="border:1px solid #000; text-align:center;">Mais de 31</td>
        <td style="border:1px solid #000; text-align:center;">De 21 a 30</td>
        <td style="border:1px solid #000; text-align:center;">De 11 a 20</td>
        <td style="border:1px solid #000; text-align:center;">Menos de 10</td>
    </tr>

    <!-- Pergunta 3 -->
    <tr>
        <td style="border:1px solid #000;">3. Qual o cigarro do dia que você acha que será mais difícil de largar?</td>
        <td style="border:1px solid #000; text-align:center;" colspan="2">O primeiro da manhã</td>
        <td style="border:1px solid #000; text-align:center;" colspan="2">Qualquer outro</td>
    </tr>

    <!-- Pergunta 4 -->
    <tr>
        <td style="border:1px solid #000;">4. Você fuma mais frequentemente (ou mais) cigarros no período da manhã do que no resto do dia?</td>
        <td style="border:1px solid #000; text-align:center;" colspan="2">Manhã</td>
        <td style="border:1px solid #000; text-align:center;" colspan="2">Resto do dia</td>
    </tr>

    <!-- Pergunta 5 -->
    <tr>
        <td style="border:1px solid #000;">5. Você fumaria se estivesse doente a ponto de ficar de cama a maior parte do dia?</td>
        <td style="border:1px solid #000; text-align:center;" colspan="2">Sim</td>
        <td style="border:1px solid #000; text-align:center;" colspan="2">Não</td>
    </tr>

    <!-- Pergunta 6 -->
    <tr>
        <td style="border:1px solid #000;">6. É difícil ficar sem fumar em locais proibidos (igrejas, bibliotecas, cinemas, etc.)?</td>
        <td style="border:1px solid #000; text-align:center;" colspan="2">Sim</td>
        <td style="border:1px solid #000; text-align:center;" colspan="2">Não</td>
    </tr>
</table>








                    <h3>08 - Assinatura</h3>
                    <div class="assinatura"></div>
                    <small>Assinatura do Avaliado</small>

                    <div class="actions">
                        <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                        <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                        <button class="btn btn-print" onclick="window.print()">Salvar</button>
                    </div>
                </div>

                <script>
                function enviarClinica(){
                    alert("Função de envio de email para clínica ainda não implementada.");
                }
                function enviarEmpresa(){
                    let msg = encodeURIComponent("Segue o Questionário Psicossocial preenchido.");
                    window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
                }
                </script>
                ';
            } else if ($toxicologico) {
                echo
                '<style>
                    body { font-family: Arial, sans-serif; background:#f2f2f2; }
                    .guia-container {
                        width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
                        background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
                    }
                    h2 { text-align:center; margin-bottom:20px; }
                    h3 {
                        margin-top:20px; margin-bottom:10px;
                        background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
                    }
                    table { width:100%; border-collapse:collapse; margin-bottom:15px; }
                    th, td { border:1px solid #ccc; padding:6px; font-size:13px; text-align:left; }
                    th { background:#f8f9fa; width:30%; }
                    input, textarea {
                        width:100%; border:none; background:transparent; font-size:13px;
                    }
                    input:disabled, textarea:disabled { color:#000; cursor:not-allowed; }
                    .assinatura { height:40px; border-bottom:1px solid #000; margin-top:10px; }
                    .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
                    .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
                    .btn {
                        padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
                        cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
                    }
                    .btn-email { background:#007bff; }
                    .btn-whatsapp { background:#25d366; }
                    .btn-print { background:#6c757d; }
                    .btn:hover { opacity:.9; }
                    @media print { .actions { display:none; } body { background:#fff; } }
                </style>

                <div class="guia-container">
                    <h2>GUIA DE ENCAMINHAMENTO - EXAME TOXICOLÓGICO</h2>

                    <h3>01 - Encaminhado por</h3>
                    <table>
                        <tr><th>Empresa</th><td><input type="text" value="PROMAIS SAÚDE E SEGURANÇA DO TRABALHO" disabled></td></tr>
                        <tr><th>CNPJ</th><td><input type="text" value="19.464.436/0001-60" disabled></td></tr>
                        <tr><th>Endereço</th><td><input type="text" value="Rua Antonio Aires Favero, 647, Bairro: Atlântico" disabled></td></tr>
                        <tr><th>Cidade / UF</th><td><input type="text" value="Alto Araguaia - MT, CEP 78780-000" disabled></td></tr>
                        <tr><th>Telefone</th><td><input type="text" value="(66) 3481-3786 / (66) 99967-2766" disabled></td></tr>
                    </table>

                    <h3>02 - Tipo de Exame</h3>
                    <p>Exame Toxicológico ( X )</p>

                    <h3>03 - Dados do Funcionário / Empresa</h3>
                    <table>
                        <tr><th>Empresa</th><td><input type="text" value="PROMAIS SAÚDE E SEGURANÇA DO TRABALHO" disabled></td></tr>
                        <tr><th>CNPJ / CAEPF</th><td><input type="text" value="19.464.436/0001-60" disabled></td></tr>
                        <tr><th>Nome do Funcionário</th><td><input type="text" value="Amanda Aparecida Carvalho Rodrigues" disabled></td></tr>
                        <tr><th>CPF</th><td><input type="text" value="072.143.511-45" disabled></td></tr>
                        <tr><th>Data de Nascimento</th><td><input type="text" value="08/10/1998" disabled></td></tr>
                        <tr><th>Idade</th><td><input type="text" value="25 anos" disabled></td></tr>
                        <tr><th>RG</th><td><input type="text" value="2943351 - SSP/MT" disabled></td></tr>
                        <tr><th>Telefone</th><td><input type="text" value="(66) 99656-4161" disabled></td></tr>
                        <tr><th>Cidade</th><td><input type="text" value="Santa Rita do Araguaia - GO, CEP 75840-000" disabled></td></tr>
                        <tr><th>Cargo</th><td><input type="text" value="Lubricador de Veículos Automotores (exceto embarcações)" disabled></td></tr>
                        <tr><th>CBO</th><td><input type="text" value="621005" disabled></td></tr>
                    </table>

                    <h3>07 - Procedimentos / Exames Realizados</h3>
                    <table>
                        <tr><th>Exame</th><td><input type="text" value="Exame Toxicológico (AA999999999)" disabled></td></tr>
                        <tr><th>Data</th><td><input type="text" value="__/__/2024" disabled></td></tr>
                    </table>

                    <h3>09 - Conclusão</h3>
                    <table>
                        <tr><th>Cidade</th><td><input type="text" value="Alto Araguaia - MT" disabled></td></tr>
                        <tr><th>Data</th><td><input type="text" value="__/__/2024" disabled></td></tr>
                        <tr>
                            <th>Assinaturas</th>
                            <td>
                                <div class="assinatura"></div><small>Assinatura do Funcionário</small>
                                <br><br>
                                <div class="assinatura"></div><small>Carimbo / Responsável</small>
                            </td>
                        </tr>
                    </table>

                    <div class="actions">
                        <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                        <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                        <button class="btn btn-print" onclick="window.print()">Salvar</button>
                    </div>
                </div>

                <script>
                function enviarClinica(){
                    alert("Função de envio de email para clínica ainda não implementada.");
                }
                function enviarEmpresa(){
                    let msg = encodeURIComponent("Segue a guia de encaminhamento para Exame Toxicológico.");
                    window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
                }
                </script>
                ';
            } else if ($resumo_laudo) {
                echo '<style>
                    body { font-family: Arial, sans-serif; background:#f2f2f2; }
                    .guia-container {
                        width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
                        background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
                    }
                    h2 { text-align:center; margin-bottom:20px; }
                    h3 {
                        margin-top:20px; margin-bottom:10px;
                        background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
                    }
                    table { width:100%; border-collapse:collapse; margin-bottom:15px; }
                    th, td { border:1px solid #ccc; padding:6px; font-size:13px; text-align:left; }
                    th { background:#f8f9fa; width:30%; }
                    input, textarea {
                        width:100%; border:none; background:transparent; font-size:13px;
                    }
                    input:disabled, textarea:disabled {
                        color:#000; cursor:not-allowed;
                    }
                    .assinatura { height:40px; border-bottom:1px solid #000; margin-top:10px; }
                    .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
                    .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
                    .btn {
                        padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
                        cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
                    }
                    .btn-email { background:#007bff; }
                    .btn-whatsapp { background:#25d366; }
                    .btn-print { background:#6c757d; }
                    .btn:hover { opacity:.9; }
                    @media print { .actions { display:none; } body { background:#fff; } }
                </style>

                <div class="guia-container">
                    <h2>Laudo de Audiometria Tonal</h2>

                    <h3>01 - Identificação</h3>
                    <table>
                        <tr><th>Paciente</th><td><input type="text" value="Bruno Henrique" disabled></td></tr>
                        <tr><th>Data</th><td><input type="text" value="02/10/2023" disabled></td></tr>
                        <tr><th>Sexo</th><td><input type="text" value="M" disabled></td></tr>
                        <tr><th>Profissão</th><td><input type="text" value="Motorista" disabled></td></tr>
                        <tr><th>Encaminhado por</th><td><input type="text" value="Samaritano Medicina do Trabalho" disabled></td></tr>
                    </table>

                    <h3>02 - Audiometria Tonal Limiar</h3>
                    <table>
                        <tr>
                            <th>Orelha Direita (OD)</th>
                            <td><input type="text" value="Média: 22 dB" disabled></td>
                        </tr>
                        <tr>
                            <th>Orelha Esquerda (OE)</th>
                            <td><input type="text" value="Média: 16 dB" disabled></td>
                        </tr>
                    </table>

                    <h3>03 - Logoaudiometria</h3>
                    <table>
                        <tr><th>Lim. Reconhecimento de Fala (OD)</th><td><input type="text" value="" disabled></td></tr>
                        <tr><th>Lim. Reconhecimento de Fala (OE)</th><td><input type="text" value="" disabled></td></tr>
                        <tr><th>Índice de Reconhecimento de Fala</th><td><input type="text" value="Monossílabos / Dissílabos / Dissílabos" disabled></td></tr>
                    </table>

                    <h3>04 - Exames Complementares</h3>
                    <table>
                        <tr><th>Weber Audiométrico</th><td><input type="text" value="Sem alterações" disabled></td></tr>
                        <tr><th>Tone Decay Técnica Rosenberg</th><td><input type="text" value="Normal" disabled></td></tr>
                    </table>

                    <h3>05 - Parecer Fonoaudiólogo</h3>
                    <textarea disabled>Mínima alteração auditiva neurossensorial unilateral em OD.</textarea>

                    <h3>06 - Assinaturas</h3>
                    <table>
                        <tr>
                            <th>Paciente</th>
                            <td><div class="assinatura"></div><small>Assinatura do Paciente</small></td>
                        </tr>
                        <tr>
                            <th>Médico Responsável</th>
                            <td><div class="assinatura"></div><small>Assinatura e Carimbo do Médico</small></td>
                        </tr>
                    </table>

                    <div class="actions">
                        <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
                        <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
                        <button class="btn btn-print" onclick="window.print()">Salvar</button>
                    </div>
                </div>

                <script>
                function enviarClinica(){
                    alert("Função de envio de email para clínica ainda não implementada.");
                }
                function enviarEmpresa(){
                    let msg = encodeURIComponent("Segue o laudo de audiometria.");
                    window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
                }
                </script>
                ';
            }
        } else if ($exames_procedimentos || $treinamentos || $epi_epc) {
            echo '
            <style>
                body { font-family: Arial, sans-serif; background:#f2f2f2; }
                .guia-container {
                    width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
                    background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
                    page-break-after: always;
                }
                h2 { text-align:center; margin:20px 0; }
                h3 {
                    margin-top:20px; margin-bottom:10px;
                    background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
                }
                table { width:100%; border-collapse:collapse; margin-bottom:15px; }
                th, td { border:1px solid #ccc; padding:6px; font-size:13px; vertical-align:top; }
                th { background:#f8f9fa; text-align:left; }
                .valor { text-align:right; font-weight:bold; }
            </style>

            <div class="guia-container">
                <h2>FATURAMENTO</h2>

                <h3>Resumo do Faturamento</h3>
                <table>
                    <tr><th colspan="2">Itens Selecionados</th></tr>';

            // Garante valores padrão
            $total_exames = $total_exames ?? 0;
            $total_treinamentos = $total_treinamentos ?? 0;
            $total_epi = $total_epi ?? 0;

            // Exames
            if (!empty($itens_exames) && isset($itens_exames)) {
                echo '<tr><td>Exames e Procedimentos</td><td class="valor">R$ ' . number_format($total_exames, 2, ",", ".") . '</td></tr>';
            }

            // Treinamentos
            if (!empty($itens_treinamentos) && isset($itens_treinamentos)) {
                echo '<tr><td>Treinamentos</td><td class="valor">R$ ' . number_format($total_treinamentos, 2, ",", ".") . '</td></tr>';
            }

            // EPI/EPC
            if (!empty($itens_epi) && isset($itens_epi)) {
                echo '<tr><td>EPI / EPC</td><td class="valor">R$ ' . number_format($total_epi, 2, ",", ".") . '</td></tr>';
            }


            echo '
                    <tr>
                        <th>Total Geral</th>
                        <td class="valor">R$ ' . number_format(($total_exames + $total_treinamentos + $total_epi), 2, ",", ".") . '</td>
                    </tr>
                </table>

                <h3>Detalhamento</h3>
                <table>
                    <tr><th>Descrição</th><th>Qtd</th><th>Valor Unitário</th><th>Total</th></tr>';

            // Lista os exames
            if (!empty($itens_exames)) {
                foreach ($itens_exames as $exame) {
                    echo '<tr>
                                    <td>' . htmlspecialchars($exame["descricao"]) . '</td>
                                    <td>' . htmlspecialchars($exame["quantidade"]) . '</td>
                                    <td class="valor">R$ ' . number_format($exame["valor_unitario"], 2, ",", ".") . '</td>
                                    <td class="valor">R$ ' . number_format($exame["total"], 2, ",", ".") . '</td>
                                </tr>';
                }
            }

            // Lista os treinamentos
            if (!empty($itens_treinamentos)) {
                foreach ($itens_treinamentos as $trein) {
                    echo '<tr>
                                    <td>' . htmlspecialchars($trein["descricao"]) . '</td>
                                    <td>' . htmlspecialchars($trein["quantidade"]) . '</td>
                                    <td class="valor">R$ ' . number_format($trein["valor_unitario"], 2, ",", ".") . '</td>
                                    <td class="valor">R$ ' . number_format($trein["total"], 2, ",", ".") . '</td>
                                </tr>';
                }
            }

            // Lista os EPIs
            if (!empty($itens_epi)) {
                foreach ($itens_epi as $epi) {
                    echo '<tr>
                                    <td>' . htmlspecialchars($epi["descricao"]) . '</td>
                                    <td>' . htmlspecialchars($epi["quantidade"]) . '</td>
                                    <td class="valor">R$ ' . number_format($epi["valor_unitario"], 2, ",", ".") . '</td>
                                    <td class="valor">R$ ' . number_format($epi["total"], 2, ",", ".") . '</td>
                                </tr>';
                }
            }

            echo '
                </table>
            </div>
            ';
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
