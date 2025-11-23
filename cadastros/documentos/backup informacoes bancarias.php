 echo '
    //     <style>
    //                     body {
    //             font-family: Arial, sans-serif;
    //             background:#f2f2f2;
    //             margin:0;
    //             padding:0;
    //         }
    //         .guia-container {
    //             width: 210mm;
    //             min-height: 297mm;
    //             margin:5mm auto;
    //             padding:10px;
    //             background:#fff;
    //             border:1px solid #000;
    //         }
    //         table { width:100%; border-collapse:collapse; font-size:12px; }
    //         th, td { border:1px solid #000; padding:4px; vertical-align:top; }

    //         .titulo-guia {
    //             background:#eaeaea;
    //             border:1px solid #000;
    //             font-weight:bold;
    //             text-align:center;
    //             font-size:14px;
    //             padding:5px;
    //             height:22px;
    //         }
    //         .section-title {
    //             background:#eaeaea;
    //             border:1px solid #666;
    //             font-weight:bold;
    //             font-size:12px;
    //             padding:3px 5px;
    //             text-align:left;
    //         }
    //         .dados-hospital { font-size:12px; line-height:1.4; }
    //         .hospital-nome { font-weight:bold; text-transform:uppercase; text-decoration:underline; display:block; margin-bottom:3px; }

    //         .logo { text-align:center; }
    //         .logo img { max-height:45px; }

    //         /* 🔹 QR Code - garante que apareça na tela e na impressão */
    //         .qrcode img {
    //             display:block;
    //             width:120px;
    //             height:auto;
    //             margin-top:5px;
    //         }

    //         /* 🔹 Botões - agora fora do @media print */
    //         .actions {
    //             margin:10px 0;
    //             text-align:center;
    //         }
    //         .btn {
    //             padding:10px 18px;
    //             font-size:14px;
    //             font-weight:bold;
    //             border:none;
    //             border-radius:5px;
    //             cursor:pointer;
    //             color:#fff;
    //             box-shadow:0 2px 5px rgba(0,0,0,.2);
    //             margin:0 5px;
    //         }
    //         .btn-email { background:#007bff; }
    //         .btn-whatsapp { background:#25d366; }
    //         .btn-print { background:#6c757d; }
    //         .btn:hover { opacity:.9; }

    //         @media print {
    //             * {
    //                 -webkit-print-color-adjust: exact !important;
    //                 print-color-adjust: exact !important;
    //             }
    //             body { background:#fff; }
    //             .actions { display: none !important; }
    //         }
    //     </style>

    //     <div class="guia-container">

    //     <table>
    //             <!-- Linha do título -->
    //             <tr>
    //                 <th colspan="2" class="titulo-guia">GUIA DE ENCAMINHAMENTO</th>
    //             </tr>
    //             <!-- Linha dados hospital + logo -->
    //             <tr>
    //                 <td class="dados-hospital">
    //                     ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' : '') . '
    //                     ' . (!empty($resultado_clinica_selecionada['cnpj']) ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' : '') . '
    //                     ' . (!empty($resultado_clinica_selecionada['endereco']) ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] : '') . '
    //                     ' . (!empty($resultado_clinica_selecionada['numero']) ? ', ' . $resultado_clinica_selecionada['numero'] : '') . '
    //                     ' . (!empty($resultado_clinica_selecionada['bairro']) ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] : '') . '
    //                     ' . (!empty($recebe_cidade_uf) ? '<br>CIDADE: ' . $recebe_cidade_uf : '') . '
    //                     ' . (!empty($resultado_clinica_selecionada['cep']) ? ', CEP: ' . $resultado_clinica_selecionada['cep'] : '') . '
    //                     ' . (!empty($resultado_clinica_selecionada['telefone']) ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] : '') . '

    //                 </td>
    //                 <td class="logo">
    //                     <img src="logo.jpg" alt="Logo">
    //                 </td>
    //             </tr>
    //         </table>

    //         <!-- 🔹 Seção IDENTIFICAÇÃO DA EMPRESA -->
    //         <table>
    //             <tr>
    //                 <td colspan="2" class="section-title">IDENTIFICAÇÃO DA EMPRESA:</td>
    //             </tr>
    //             <tr>
    //                 <td class="dados-hospital" colspan="2">
    //                     ' . (!empty($resultado_empresa_selecionada['nome'])
    //             ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
    //             : '') . '

    //                     ' . (!empty($resultado_empresa_selecionada['cnpj'])
    //             ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj'])
    //             : '') . '
    //                 ' . (!empty($resultado_empresa_selecionada['endereco'])
    //             ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco'])
    //             : '') . '
    //                 ' . (!empty($resultado_empresa_selecionada['bairro'])
    //             ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro'])
    //             : '') . '
    //                 ' . (!empty($recebe_cidade_uf)
    //             ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf)
    //             : '') . '
    //                 ,
    //                                         ' . (!empty($resultado_empresa_selecionada['cep'])
    //             ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep'])
    //             : '') . '

    //                 ' . (!empty($resultado_empresa_selecionada['telefone'])
    //             ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.'
    //             : '') . '
    //                 </td>
    //             </tr>
    //         </table>

    //         <!-- 🔹 Seção IDENTIFICAÇÃO DO FUNCIONÁRIO -->
    //         <table>
    //             <tr>
    //                 <td colspan="2" class="section-title">IDENTIFICAÇÃO DO FUNCIONÁRIO:</td>
    //             </tr>
    //             <tr>
    //                 <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
    //                     ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
    //                     ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
    //                     ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
    //                     ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
    //                     ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
    //                     ' . (!empty($resultado_cargo_selecionado['titulo_cargo']) ? 'CARGO: ' . $resultado_cargo_selecionado['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
    //                     ' . (!empty($resultado_cargo_selecionado['codigo_cargo']) ? 'CBO: ' . $resultado_cargo_selecionado['codigo_cargo'] : '') . '
    //                 </td>
    //             </tr>
    //         </table>

    //         <h4 style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;text-align:center;">Faturamento / Orçamento</h4>

    //         <h4 style="font-size:11px; line-height:1.3; margin:6px 0;">
    //     03 - EPIs / EPCs
    // </h4>';

    //             $combinar = "<p style='font-size:11px; line-height:1.4; margin:2px 0;'>A combinar</p>";

    //             echo '<div style="border-top:1px solid #000; margin:6px 0;"></div>

    //     <!-- Produtos / Serviços -->
    //     <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
    //         <tr>
    //             <th style="padding:3px;">Código</th>
    //             <th style="padding:3px;">Descrição dos produtos/serviços</th>
    //             <th style="padding:3px;">Und</th>
    //             <th style="padding:3px;">Pço.Unt.</th>
    //             <th style="padding:3px;">Quant.</th>
    //             <th style="padding:3px;">Total do item</th>
    //         </tr>';

    //             $totalGeral = 0;
    //             $numeroItens = 0;

    //             if (!empty($valores_pedidos)) {
    //                 foreach ($valores_pedidos as $item) {
    //                     if (!empty($item["tipo"]) && $item["tipo"] === "epi") {
    //                         $quantidade = $item["quantidade"] ?? 1;
    //                         $valorUnitario = $item["valor"] ?? 0;
    //                         $totalItem = $quantidade * $valorUnitario;

    //                         $totalGeral += $totalItem;
    //                         $numeroItens++;

    //                         echo '<tr style="border:1px solid #000;">
    //                             <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["codigo"] ?? '') . '</td>
    //                             <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:left;">' . htmlspecialchars($item["nome"] ?? '') . '</td>
    //                             <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:center;">un</td>
    //                             <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($valorUnitario, 2, ",", ".") . '</td>
    //                             <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">' . $quantidade . '</td>
    //                             <td style="border:1px solid #000; padding:2px; font-size:11px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
    //                         </tr>';
    //                     }
    //                 }
    //             }

    //             // Define o fuso horário do Brasil (evita diferenças)
    //             date_default_timezone_set('America/Sao_Paulo');

    //             // Data atual no formato brasileiro
    //             $dataAtual = date('d/m/Y');

    //             echo '
    //         </table>

    //         <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
    //                 <tr>
    //                     <td style="padding:3px;">' . $dataAtual . '</td>
    //                     <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
    //                 </tr>
    //                 <tr>
    //                     <td style="padding:3px;">Formas de Pagamento:</td>
    //                     <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
    //                 </tr>
    //                 <tr>
    //                     <td></td>
    //                     <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
    //                 </tr>
    //                 <tr>
    //                     <td></td>
    //                     <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
    //                 </tr>
    //             </table>

    //             <!-- Rodapé -->
    //             <p style="margin:4px 0;">
    //                 <strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
    //                 (!empty($prazo_entrega)
    //                     ? '<span style="font-size:11px;">' . htmlspecialchars($prazo_entrega) . '</span>'
    //                     : '<span style="font-size:11px;">A combinar</span>') .
    //                 '</p>

    //             <p style="margin:4px 0;">
    //                 <strong style="font-size:11px;">Observações:</strong> ' .
    //                 (!empty($observacoes)
    //                     ? '<span style="font-size:11px;">' . htmlspecialchars($observacoes) . '</span>'
    //                     : '<span style="font-size:11px;">Nenhuma</span>') .
    //                 '</p>

    //             <div class="top-bar"></div>
    //             <div class="top-bar" style="margin-top:20px;"></div>';


    //             if (!empty($resultado_busca_dados_bancarios)) {
    //                 $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

    //                 if (!is_array($tipos)) {
    //                     $tipos = [];
    //                 }

    //                 if (empty($tipos)) {
    //                     echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
    //                             <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
    //                         </p>';
    //                 } else {
    //                     $temQrCode = in_array('qrcode', $tipos);
    //                     $temPix = in_array('pix', $tipos);
    //                     $temAgenciaConta = in_array('agencia-conta', $tipos);

    //                     if ($temQrCode || $temPix || $temAgenciaConta) {
    //                         // Container principal
    //                         echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

    //                         // Bloco QR Code (imagem + texto ao lado)
    //                         if ($temQrCode) {
    //                             $chave = '(64) 99606-5577'; // ou busca no banco
    //                             ob_start();
    //                             QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
    //                             $imageString = base64_encode(ob_get_contents());
    //                             ob_end_clean();

    //                             echo '
    //                             <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
    //                                 <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
    //                                 <div>
    //                                     <p style="margin:0; font-weight:bold;">Chave:</p>
    //                                     <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
    //                                 </div>
    //                             </div>
    //                         ';
    //                         }

    //                         // Bloco PIX
    //                         if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
    //                             echo '
    //                             <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
    //                                 <p style="margin:0; font-weight:bold;">Chave PIX:</p>
    //                                 <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
    //                             </div>';
    //                         }

    //                         // Bloco Agência e Conta
    //                         if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
    //                             $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
    //                             echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
    //                                 <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
    //                                 <div>';
    //                             foreach ($dados as $dado) {
    //                                 echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
    //                             }
    //                             echo '</div></div>';
    //                         }

    //                         echo '</div>'; // fecha container principal
    //                     }
    //                 }
    //             }
    //             echo '       
    //         </div>

    //     <!-- 🔹 Botões -->
    //     <div class="actions">
    //         <button class="btn btn-email" onclick="enviarClinica()">Enviar por email</button>
    //         <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Enviar por WhatsApp</button>
    //         <button class="btn btn-print" onclick="window.print()">Imprimir KIT Completo</button>
    //     </div>';

    //             echo '</div>';



    //            <h4 style="font-size:11px; line-height:1.3; margin:6px 0;">01 - Exames / Procedimentos</h4>';
//             $combinar = "<h4 style='font-size: 11px; line-height: 1.3; margin:2px 0;'>A combinar</h4>";

//             echo '<div class="top-bar"></div>
//                 <!-- Produtos / Serviços -->
    

//             <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000;">
//                 <tr>
//                     <th style="padding:3px;">Código</th>
//                     <th style="padding:3px;">Descrição dos produtos/serviços</th>
//                     <th style="padding:3px;">Und</th>
//                     <th style="padding:3px;">Pço.Unt.</th>
//                     <th style="padding:3px;">Quant.</th>
//                     <th style="padding:3px;">Total do item</th>
//                 </tr>
//         ';

//             // Total geral e número de itens
//             $totalGeral = 0;
//             $numeroItens = count($exames_count); // Número de linhas = número de itens distintos

//             foreach ($exames_count as $item) {
//                 $quantidade = 1; // Cada linha representa 1 item
//                 $totalItem = $quantidade * $item['valor'];
//                 $totalGeral += $totalItem;

//                 echo '<tr>
//                     <td style="padding:3px;">' . htmlspecialchars($item["codigo"]) . '</td>
//                     <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
//                     <td style="padding:3px; text-align:right;">un</td>
//                     <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
//                     <td style="padding:3px; text-align:right;">' . $quantidade . '</td>
//                     <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
//                 </tr>';
//             }



//             // Define o fuso horário do Brasil (evita diferenças)
//             date_default_timezone_set('America/Sao_Paulo');

//             // Data atual no formato brasileiro
//             $dataAtual = date('d/m/Y');

//             echo '</table>

//             <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
//                 <tr>
//                     <td style="padding:3px;">' . $dataAtual . '</td>
//                     <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
//                 </tr>
//                 <tr>
//                     <td style="padding:3px;">Formas de Pagamento:</td>
//                     <td style="padding:3px;">Total dos Produtos: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
//                 </tr>
//                 <tr>
//                     <td></td>
//                     <td style="padding:3px;">Desconto Concedido: <strong>R$ 0,00</strong></td>
//                 </tr>
//                 <tr>
//                     <td></td>
//                     <td style="padding:3px;">Total do Orçamento: <strong>R$ ' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
//                 </tr>
//             </table>';


            

// // $categoria = "exames";

// // $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"] ?? "[]", true);
// // $dadosBancarios = [
// //     'qr' => $resultado_busca_dados_bancarios[0]['qrcode'] ?? '',
// //     'pix' => $resultado_busca_dados_bancarios[0]['dado_bancario_pix'] ?? '',
// //     'agencia_conta' => $resultado_busca_dados_bancarios[0]['dado_bancario_agencia_conta'] ?? ''
// // ];


// // // ✅ Adiciona bancos logo abaixo de "Nenhuma"
// // if (
// //     deve_exibir_banco($categoria, $valQrcode) ||
// //     deve_exibir_banco($categoria, $valPix) ||
// //     deve_exibir_banco($categoria, $valAgencia)
// // ) {
// //     // como essa função já deve imprimir o HTML, não entra no echo
// //     exibe_info_bancaria($tipos, $dadosBancarios);
// // }

// // // EXAMES
// // $categoria = "exames";
// // $mostrarQr       = deve_exibir_banco($categoria, $valQrcode);
// // $mostrarPix      = deve_exibir_banco($categoria, $valPix);
// // $mostrarAgConta  = deve_exibir_banco($categoria, $valAgencia);

// // exibe_info_bancaria([
// //     "qrcode"         => $mostrarQr,
// //     "pix"            => $mostrarPix,
// //     "agencia-conta"  => $mostrarAgConta
// // ], $dadosBancarios);

// // EXAMES
// $categoria = "exames";
// $mostrarQr       = deve_exibir_banco($categoria, $valQrcode);
// $mostrarPix      = deve_exibir_banco($categoria, $valPix);
// $mostrarAgConta  = deve_exibir_banco($categoria, $valAgencia);

// // echo "<pre>";
// // var_dump($categoria, $mostrarQr, $mostrarPix, $mostrarAgConta);
// // echo "</pre>";

// exibe_info_bancaria([
//     "qrcode"         => $mostrarQr,
//     "pix"            => $mostrarPix,
//     "agencia-conta"  => $mostrarAgConta
// ], $dadosBancarios);

// echo '
// <div class="top-bar"></div>
// <div class="top-bar" style="margin-top: 10px;"></div>
// ';

//             echo '<h4 style="font-size:11px; line-height:1.3; margin:6px 0;">02 - Treinamentos</h4>';
//             $combinar = "<h4 style='font-size:11px; line-height:1.3; margin:2px 0;'>A combinar</h4>";

//             echo '<div class="top-bar"></div>
//             <!-- Produtos / Serviços -->

//                 <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:4px;">
//             <tr>
//                 <th style="padding:3px;">Código</th>
//                 <th style="padding:3px;">Descrição dos produtos/serviços</th>
//                 <th style="padding:3px;">Und</th>
//                 <th style="padding:3px;">Pço.Unt.</th>
//                 <th style="padding:3px;">Quant.</th>
//                 <th style="padding:3px;">Total do item</th>
//             </tr>';

//             $totalGeral = 0;
//             $numeroItens = 0;

//             if (!empty($valores_pedidos)) {
//                 foreach ($valores_pedidos as $item) {
//                     // Só exibe se for treinamento
//                     if (($item["tipo"] ?? "") === "treinamento") {

//                         $totalItem = $item["quantidade"] * $item["valor"];
//                         $totalGeral += $totalItem;
//                         $numeroItens++;

//                         echo '
//                             <tr>
//                                 <td style="padding:3px;">' . $item["codigo"] . '</td>
//                                 <td style="padding:3px;">' . htmlspecialchars($item["nome"]) . '</td>
//                                 <td style="padding:3px;">un</td>
//                                 <td style="padding:3px; text-align:right;">R$ ' . number_format($item["valor"], 2, ",", ".") . '</td>
//                                 <td style="padding:3px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
//                                 <td style="padding:3px; text-align:right;">R$ ' . number_format($totalItem, 2, ",", ".") . '</td>
//                             </tr>';
//                     }
//                 }
//             }



//             echo '</table>

//                 <table style="width:100%; margin-top:0px; font-size:11px; border-collapse:collapse;">
//                     <tr>
//                         <td style="padding:3px;">' . $dataAtual . '</td>
//                         <td style="padding:3px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
//                     </tr>
//                     <tr>
//                         <td style="padding:3px;">Formas de Pagamento:</td>
//                         <td style="padding:3px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
//                     </tr>
//                     <tr>
//                         <td></td>
//                         <td style="padding:3px;">Desconto Concedido: <strong>0,00</strong></td>
//                     </tr>
//                     <tr>
//                         <td></td>
//                         <td style="padding:3px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
//                     </tr>
//                 </table>';

                

// $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"] ?? "[]", true);
// $dadosBancarios = [
//     'qr' => $resultado_busca_dados_bancarios[0]['qrcode'] ?? '',
//     'pix' => $resultado_busca_dados_bancarios[0]['dado_bancario_pix'] ?? '',
//     'agencia_conta' => $resultado_busca_dados_bancarios[0]['dado_bancario_agencia_conta'] ?? ''
// ];

// // $categoria = "treinamentos";

// // // ✅ Adiciona bancos logo abaixo de "Nenhuma"
// // if (
// //     deve_exibir_banco($categoria, $valQrcode) ||
// //     deve_exibir_banco($categoria, $valPix) ||
// //     deve_exibir_banco($categoria, $valAgencia)
// // ) {
// //     // como essa função já deve imprimir o HTML, não entra no echo
// //     exibe_info_bancaria($tipos, $dadosBancarios);
// // }

// // // TREINAMENTOS
// // $categoria = "treinamentos";
// // $mostrarQr       = deve_exibir_banco($categoria, $valQrcode);
// // $mostrarPix      = deve_exibir_banco($categoria, $valPix);
// // $mostrarAgConta  = deve_exibir_banco($categoria, $valAgencia); // ✅ agora passa corretamente

// // exibe_info_bancaria([
// //     "qrcode"         => $mostrarQr,
// //     "pix"            => $mostrarPix,
// //     "agencia-conta"  => $mostrarAgConta // ✅ incluído
// // ], $dadosBancarios);

// // TREINAMENTOS
// $categoria = "treinamentos";
// $mostrarQr       = deve_exibir_banco($categoria, $valQrcode);
// $mostrarPix      = deve_exibir_banco($categoria, $valPix);
// $mostrarAgConta  = deve_exibir_banco($categoria, $valAgencia);

// // echo "<pre>";
// // var_dump($categoria, $mostrarQr, $mostrarPix, $mostrarAgConta);
// // echo "</pre>";

// exibe_info_bancaria([
//     "qrcode"         => $mostrarQr,
//     "pix"            => $mostrarPix,
//     "agencia-conta"  => $mostrarAgConta
// ], $dadosBancarios);


// echo '
// <div class="top-bar"></div>
// <div class="top-bar" style="margin-top: 10px;"></div>
// ';