<?php
else if ($exames_procedimentos === true || $treinamentos === true || $epi_epc === true || $faturamento === true) {

            if (isset($_POST['valor_id_kit'])) {
                $valor_id_kit = $_POST['valor_id_kit'];

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


                $valores_pedidos = [];

                // -------------------
                // Buscar EPIs (Produtos)
                // -------------------
                $instrucao_busca_pedidos = "SELECT * FROM produto WHERE id_kit = :recebe_id_kit";
                $comando_busca_pedidos = $pdo->prepare($instrucao_busca_pedidos);
                $comando_busca_pedidos->bindValue(":recebe_id_kit", $valor_id_kit);
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
                $comando_busca_treinamentos_kit->bindValue(":recebe_id_kit", $valor_id_kit);
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
                $comando_busca_exames_kit->bindValue(":recebe_id_kit", $valor_id_kit);
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


                $instrucao_busca_dados_bancarios = "select tipo_dado_bancario,dado_bancario_pix,dado_bancario_agencia_conta from kits where id = :recebe_id_kit";
                $comando_busca_dados_bancarios = $pdo->prepare($instrucao_busca_dados_bancarios);
                $comando_busca_dados_bancarios->bindValue(":recebe_id_kit", $valor_id_kit);
                $comando_busca_dados_bancarios->execute();
                $resultado_busca_dados_bancarios = $comando_busca_dados_bancarios->fetchAll(PDO::FETCH_ASSOC);
            } else {
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
                $comando_busca_dados_bancarios->bindValue(":recebe_id_kit", $_SESSION["codigo_kit"]);
                $comando_busca_dados_bancarios->execute();
                $resultado_busca_dados_bancarios = $comando_busca_dados_bancarios->fetchAll(PDO::FETCH_ASSOC);
            }

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

            if ($exames_procedimentos === true && $treinamentos === true && $epi_epc === true && $faturamento === true) {
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
            } else if ($exames_procedimentos === true && $treinamentos === true && $faturamento === true) {
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
            } else if ($exames_procedimentos === true && $epi_epc === true && $faturamento === true) {
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
            } else if ($treinamentos === true && $epi_epc === true && $faturamento === true) {
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
            } else if ($exames_procedimentos === true && $faturamento === true) {
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
            } else if ($treinamentos === true && $faturamento === true) {
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
            } else if ($epi_epc === true && $faturamento === true) {
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
            } else if ($exames_procedimentos === true && $treinamentos === true && $epi_epc === true) {
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
            } else if ($treinamentos === true && $epi_epc === true) {
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
            } else if ($exames_procedimentos === true) {
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
            } else if ($treinamentos === true) {
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
            } else if ($epi_epc === true) {
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