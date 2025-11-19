if (isset($_POST['valor_id_kit'])) {
                $valor_id_kit = $_POST['valor_id_kit'];

                // var_dump($valor_id_kit);

                $instrucao_busca_dados_kit = "select * from kits where id = :recebe_id_kit";
                $comando_busca_dados_kit = $pdo->prepare($instrucao_busca_dados_kit);
                $comando_busca_dados_kit->bindValue(":recebe_id_kit", $valor_id_kit);
                $comando_busca_dados_kit->execute();
                $resultado_dados_kit = $comando_busca_dados_kit->fetch(PDO::FETCH_ASSOC);


                $recebe_exame;
                if (!empty($resultado_dados_kit["tipo_exame"])) {
                    // Tem valor válido (não nulo, não vazio, não zero)
                    $recebe_exame = $resultado_dados_kit["tipo_exame"];
                }

                if (!empty($resultado_dados_kit["exames_selecionados"])) {
                    // Pega os exames do resultado
                    $examesJson = $resultado_dados_kit["exames_selecionados"] ?? "";
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
                                    (" . htmlspecialchars($codigo) . ") " . htmlspecialchars($nome) . "
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
                }

                if (!empty($resultado_dados_kit["clinica_id"])) {
                    $instrucao_busca_clinica = "select * from clinicas where id = :recebe_clinica_id";
                    $comando_busca_clinica = $pdo->prepare($instrucao_busca_clinica);
                    $comando_busca_clinica->bindValue(":recebe_clinica_id", $resultado_dados_kit["clinica_id"]);
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
                }


                if (!empty($resultado_dados_kit["empresa_id"])) {
                    $instrucao_busca_empresa = "select * from empresas_novas where id = :recebe_id_empresa";
                    $comando_busca_empresa = $pdo->prepare($instrucao_busca_empresa);
                    $comando_busca_empresa->bindValue(":recebe_id_empresa", $resultado_dados_kit["empresa_id"]);
                    $comando_busca_empresa->execute();
                    $resultado_empresa_selecionada = $comando_busca_empresa->fetch(PDO::FETCH_ASSOC);
                }


                if (!empty($resultado_dados_kit["pessoa_id"])) {
                    $instrucao_busca_pessoa = "select * from pessoas where id = :recebe_id_pessoa";
                    $comando_busca_pessoa = $pdo->prepare($instrucao_busca_pessoa);
                    $comando_busca_pessoa->bindValue(":recebe_id_pessoa", $resultado_dados_kit["pessoa_id"]);
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

                    $instrucao_busca_cargo_pessoa = "select * from cargo where id_pessoa = :recebe_id_pessoa";
                    $comando_busca_cargo_pessoa = $pdo->prepare($instrucao_busca_cargo_pessoa);
                    $comando_busca_cargo_pessoa->bindValue(":recebe_id_pessoa", $resultado_pessoa_selecionada["id"]);
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


                if (!empty($resultado_dados_kit["medico_coordenador_id"])) {
                    $instrucao_busca_medico_coordenador = "select * from medicos where id = :recebe_id_medico_coordenador";
                    $comando_busca_medico_coordenador = $pdo->prepare($instrucao_busca_medico_coordenador);
                    $comando_busca_medico_coordenador->bindValue(":recebe_id_medico_coordenador", $resultado_dados_kit["medico_coordenador_id"]);
                    $comando_busca_medico_coordenador->execute();
                    $resultado_medico_coordenador_selecionado = $comando_busca_medico_coordenador->fetch(PDO::FETCH_ASSOC);
                }

                if (!empty($resultado_dados_kit["medico_clinica_id"])) {
                    $instrucao_busca_medico_clinica = "select medico_id from medicos_clinicas where id = :recebe_id_medico_clinica";
                    $comando_busca_medico_clinica = $pdo->prepare($instrucao_busca_medico_clinica);
                    $comando_busca_medico_clinica->bindValue(":recebe_id_medico_clinica", $resultado_dados_kit["medico_clinica_id"]);
                    $comando_busca_medico_clinica->execute();
                    $resultado_medico_clinica_selecionado = $comando_busca_medico_clinica->fetch(PDO::FETCH_ASSOC);


                    $instrucao_busca_medico_relacionado_clinica = "select * from medicos where id = :recebe_id_medico_relacionado_clinica";
                    $comando_busca_medico_relacionado_clinica = $pdo->prepare($instrucao_busca_medico_relacionado_clinica);
                    $comando_busca_medico_relacionado_clinica->bindValue(":recebe_id_medico_relacionado_clinica", $resultado_medico_clinica_selecionado["medico_id"]);
                    $comando_busca_medico_relacionado_clinica->execute();
                    $resultado_medico_relacionado_clinica = $comando_busca_medico_relacionado_clinica->fetch(PDO::FETCH_ASSOC);

                    $instrucao_verifica_marcacao_assinatura_digital = "select * from kits where id = :recebe_id_kit";
                    $comando_verifica_marcacao_assinatura_digital = $pdo->prepare($instrucao_verifica_marcacao_assinatura_digital);
                    $comando_verifica_marcacao_assinatura_digital->bindValue(":recebe_id_kit", $valor_id_kit);
                    $comando_verifica_marcacao_assinatura_digital->execute();
                    $resultado_verifica_marcacao_assinatura_digital = $comando_verifica_marcacao_assinatura_digital->fetch(PDO::FETCH_ASSOC);

                    if ($resultado_verifica_marcacao_assinatura_digital["assinatura_digital"] === "Sim") {
                        // supondo que o campo no banco seja "assinatura" com o nome do arquivo
                        $html_assinatura = "<img src='assinaturas/"
                            . htmlspecialchars($resultado_medico_relacionado_clinica['imagem_assinatura'] ?? '')
                            . "' alt='Assinatura do Médico' class='assinatura'>";
                    } else if ($resultado_verifica_marcacao_assinatura_digital["assinatura_digital"] === "Nao") {
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

                if (!empty($resultado_dados_kit["riscos_selecionados"])) {
                    $data = json_decode($resultado_dados_kit["riscos_selecionados"], true);

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


                // ===================== AJUSTE NAS APTIDÕES =====================
                $aptidoesTabela = '';

                // busca aptidões do banco
                $instrucao_busca_aptidoes = "SELECT * FROM aptidao_extra WHERE empresa_id = :recebe_empresa_id";
                $comando_busca_aptidoes = $pdo->prepare($instrucao_busca_aptidoes);
                $comando_busca_aptidoes->bindValue(":recebe_empresa_id", $resultado_dados_kit["empresa_id_principal"]);
                $comando_busca_aptidoes->execute();
                $resultado_busca_aptidoes = $comando_busca_aptidoes->fetchAll(PDO::FETCH_ASSOC);

                // cria lista de aptidões a partir do banco (id => nome)
                $listaAptidoes = [];
                foreach ($resultado_busca_aptidoes as $apt) {
                    $listaAptidoes[$apt['id']] = trim($apt['nome']); // ajuste conforme nome da coluna no banco
                }

                // transforma o JSON da sessão em array associativo
                $aptidoesSelecionadas = [];
                if (!empty($resultado_dados_kit["aptidoes_selecionadas"])) {
                    $dataApt = json_decode($resultado_dados_kit["aptidoes_selecionadas"], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($dataApt)) {
                        foreach ($dataApt as $apt) {
                            if (isset($apt['nome'])) {
                                $aptidoesSelecionadas[] = strtolower(trim($apt['nome']));
                            }
                        }
                    }
                }
            } else {


                if (isset($_SESSION['clinica_selecionado']) && $_SESSION['clinica_selecionado'] !== '') {
                    salvarLog("id da clinica selecionada:" . $_SESSION["clinica_selecionado"]);
                    salvarLog($_SESSION["exame_selecionado"]);

                    // echo "id da clinica selecionada:" . $_SESSION["clinica_selecionado"] . "<br>";

                    // echo $_SESSION["exame_selecionado"] . "<br>";

                    $recebe_exame = $_SESSION["exame_selecionado"];

                    // var_dump($recebe_exame);

                    $recebe_exame_exibicao;

                    if ($recebe_exame === "admissional") {
                        $recebe_exame_exibicao = "Admissional";
                    } else if ($recebe_exame === "mudanca") {
                        $recebe_exame_exibicao = "Mudança de função";
                    }

                    $instrucao_busca_exames_procedimentos_kit = "select * from kits where id = :recebe_id_kit";
                    $comando_busca_exames_procedimentos_kit = $pdo->prepare($instrucao_busca_exames_procedimentos_kit);
                    $comando_busca_exames_procedimentos_kit->bindValue(":recebe_id_kit", $_SESSION["codigo_kit"]);
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
                    // function marcar($valor, $tipoExame)
                    // {
                    //     return ($tipoExame === strtolower($valor)) ? '(X)' : '( )';
                    // }

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
                        $comando_busca_cargo_pessoa->bindValue(":recebe_id_pessoa", $resultado_pessoa_selecionada["id"]);
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
                        $comando_verifica_marcacao_assinatura_digital->bindValue(":recebe_id_kit", $_SESSION["codigo_kit"]);
                        $comando_verifica_marcacao_assinatura_digital->execute();
                        $resultado_verifica_marcacao_assinatura_digital = $comando_verifica_marcacao_assinatura_digital->fetch(PDO::FETCH_ASSOC);

                        //var_dump($resultado_verifica_marcacao_assinatura_digital);

                        if ($resultado_verifica_marcacao_assinatura_digital["assinatura_digital"] === "Sim") {
                            // supondo que o campo no banco seja "assinatura" com o nome do arquivo
                            $html_assinatura = "<img src='assinaturas/"
                                . htmlspecialchars($resultado_medico_relacionado_clinica['imagem_assinatura'] ?? '')
                                . "' alt='Assinatura do Médico' class='assinatura'>";
                        } else if ($resultado_verifica_marcacao_assinatura_digital["assinatura_digital"] === "Nao") {
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
                    //     function marcarAptidao($nome, $aptidoesSelecionadas)
                    //     {
                    //         $nomeLower = strtolower(trim($nome));
                    //         $sim  = in_array($nomeLower, $aptidoesSelecionadas) ? "X" : " ";
                    //         $nao  = $sim === "X" ? " " : "X";
                    //         return htmlspecialchars($nome) . " ( $sim ) Sim ( $nao ) Não";
                    //     }

                    //     // gerar tabela apenas com as selecionadas
                    //     $aptidoesTabela .= '
                    // <table>
                    //     <tr>
                    //         <td colspan="2" class="section-title">APTIDÕES EXTRAS</td>
                    //     </tr>';

                    //     $aptidoesFiltradas = [];
                    //     foreach ($listaAptidoes as $nome) {
                    //         if (in_array(strtolower($nome), $aptidoesSelecionadas)) {
                    //             $aptidoesFiltradas[] = $nome;
                    //         }
                    //     }

                    //     // gerar com 2 colunas por linha
                    //     for ($i = 0; $i < count($aptidoesFiltradas); $i += 2) {
                    //         $esq = marcarAptidao($aptidoesFiltradas[$i], $aptidoesSelecionadas);

                    //         $dir = "&nbsp;";
                    //         if (isset($aptidoesFiltradas[$i + 1])) {
                    //             $dir = marcarAptidao($aptidoesFiltradas[$i + 1], $aptidoesSelecionadas);
                    //         }

                    //         $aptidoesTabela .= '
                    //     <tr>
                    //         <td style="width:50%; font-size:12px; padding:4px;">' . $esq . '</td>
                    //         <td style="width:50%; font-size:12px; padding:4px;">' . $dir . '</td>
                    //     </tr>';
                    //     }

                    //     $aptidoesTabela .= '
                    // </table>';
                }
            }