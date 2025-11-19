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
        }