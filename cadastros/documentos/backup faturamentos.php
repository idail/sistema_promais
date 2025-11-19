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
                </table>';


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
                </table>';



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
                </table>';

                

$tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"] ?? "[]", true);
$dadosBancarios = [
    'qr' => $resultado_busca_dados_bancarios[0]['qrcode'] ?? '',
    'pix' => $resultado_busca_dados_bancarios[0]['dado_bancario_pix'] ?? '',
    'agencia_conta' => $resultado_busca_dados_bancarios[0]['dado_bancario_agencia_conta'] ?? ''
];

// $categoria = "treinamentos";

// // ✅ Adiciona bancos logo abaixo de "Nenhuma"
// if (
//     deve_exibir_banco($categoria, $valQrcode) ||
//     deve_exibir_banco($categoria, $valPix) ||
//     deve_exibir_banco($categoria, $valAgencia)
// ) {
//     // como essa função já deve imprimir o HTML, não entra no echo
//     exibe_info_bancaria($tipos, $dadosBancarios);
// }

// // TREINAMENTOS
// $categoria = "treinamentos";
// $mostrarQr       = deve_exibir_banco($categoria, $valQrcode);
// $mostrarPix      = deve_exibir_banco($categoria, $valPix);
// $mostrarAgConta  = deve_exibir_banco($categoria, $valAgencia); // ✅ agora passa corretamente

// exibe_info_bancaria([
//     "qrcode"         => $mostrarQr,
//     "pix"            => $mostrarPix,
//     "agencia-conta"  => $mostrarAgConta // ✅ incluído
// ], $dadosBancarios);

// TREINAMENTOS
$categoria = "treinamentos";
$mostrarQr       = deve_exibir_banco($categoria, $valQrcode);
$mostrarPix      = deve_exibir_banco($categoria, $valPix);
$mostrarAgConta  = deve_exibir_banco($categoria, $valAgencia);

// echo "<pre>";
// var_dump($categoria, $mostrarQr, $mostrarPix, $mostrarAgConta);
// echo "</pre>";

exibe_info_bancaria([
    "qrcode"         => $mostrarQr,
    "pix"            => $mostrarPix,
    "agencia-conta"  => $mostrarAgConta
], $dadosBancarios);