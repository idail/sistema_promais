<!-- Pré-venda -->
            <div class="pre-venda">
                PRÉ-VENDA Nº ' . htmlspecialchars($numero_pre_venda ?? "000000") . '
            </div>

            <!-- Identificação do Cliente -->
        <h3 style="text-align:center;">Identificação do Cliente</h3>

        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <tr>
                <td style="width:19%; padding:6px; border:none; vertical-align:top;">
                    <strong>Código:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["codigo"] ?? "500") . '</div>
                </td>
                <td style="width:25%; padding:6px; border:none; vertical-align:top;">
                    <strong>Nome do cliente/Nome de Fantasia:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['nome_fantasia'] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;" colspan="2">
                    <strong>Razão social:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['razao_social'] ?? "") . '</div>
                </td>
            </tr>

            <tr>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Cnpj:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['cnpj'] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Insc.Estadual:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["inscricao_estadual"] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>CPF:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["cpf"] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>RG:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["rg"] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Contato:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['telefone'] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Setor:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["setor"] ?? "") . '</div>
                </td>
            </tr>

            <tr>
                <td style="padding:6px; border:none; vertical-align:top;" colspan="2">
                    <strong>Fone Comercial:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['telefone'] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Fone Resid.:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["fone_residencial"] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Fax:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["fax"] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Celular:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['telefone'] ?? "") . '</div>
                </td>
            </tr>

            <tr>
                <td style="padding:6px; border:none; vertical-align:top;" colspan="3">
                    <strong>Endereço:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['endereco'] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Complemento:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["complemento"] ?? "") . '</div>
                </td>
            </tr>

            <tr>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Bairro:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["bairro"] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>Cidade:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cidadeNome ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>CEP:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['cep'] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;">
                    <strong>UF:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($estadoSigla ?? "") . '</div>
                </td>
            </tr>

            <tr>
                <td style="padding:6px; border:none; vertical-align:top;" colspan="2">
                    <strong>Email:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($resultado_clinica_selecionada['email'] ?? "") . '</div>
                </td>
                <td style="padding:6px; border:none; vertical-align:top;" colspan="2">
                    <strong>Vendedor:</strong>
                    <div style="margin-top:6px; min-height:20px;">' . htmlspecialchars($cliente["vendedor"] ?? "") . '</div>
                </td>
            </tr>
        </table>

        <div class="top-bar"></div>
            <!-- Produtos / Serviços -->
        <h3 style="text-align:center;">Discriminação dos Produtos / Serviços</h3>

        <table style="width:100%; border-collapse:collapse; font-size:12px; border:1px solid #000;">
            <tr style="border:1px solid #000;">
                <th style="border:1px solid #000; padding:4px;">Código</th>
                <th style="border:1px solid #000; padding:4px;">Barras</th>
                <th style="border:1px solid #000; padding:4px;">Descrição dos produtos/serviços</th>
                <th style="border:1px solid #000; padding:4px;">Und</th>
                <th style="border:1px solid #000; padding:4px;">Pço.Unt.</th>
                <th style="border:1px solid #000; padding:4px;">Quant.</th>
                <th style="border:1px solid #000; padding:4px;">Total do item</th>
            </tr>
        ';

                    $totalGeral = 0;
                    $numeroItens = 0;

                    if (!empty($itens)) {
                        foreach ($itens as $item) {
                            $totalItem = $item["quantidade"] * $item["valor_unitario"];
                            $totalGeral += $totalItem;
                            $numeroItens++;

                            echo '<tr style="border:1px solid #000;">
                    <td style="border:1px solid #000; padding:4px;">' . htmlspecialchars($item["codigo"]) . '</td>
                    <td style="border:1px solid #000; padding:4px;">' . htmlspecialchars($item["barras"] ?? "") . '</td>
                    <td style="border:1px solid #000; padding:4px;">' . htmlspecialchars($item["descricao"]) . '</td>
                    <td style="border:1px solid #000; padding:4px;">' . htmlspecialchars($item["unidade"]) . '</td>
                    <td style="border:1px solid #000; padding:4px; text-align:right;">' . number_format($item["valor_unitario"], 2, ",", ".") . '</td>
                    <td style="border:1px solid #000; padding:4px; text-align:right;">' . htmlspecialchars($item["quantidade"]) . '</td>
                    <td style="border:1px solid #000; padding:4px; text-align:right;">' . number_format($totalItem, 2, ",", ".") . '</td>
                </tr>';
                        }
                    }

                    echo '
        </table>

        <table style="width:100%; margin-top:8px; font-size:12px; border-collapse:collapse;">
            <tr>
                <td style="padding:4px;">quinta-feira, ' . date("d \d\e F \d\e Y") . '</td>
                <td style="padding:4px;">Nro. de Itens: <strong>' . $numeroItens . '</strong></td>
            </tr>
            <tr>
                <td style="padding:4px;">Formas de Pagamento:</td>
                <td style="padding:4px;">Total dos Produtos: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding:4px;">Desconto Concedido: <strong>0,00</strong></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding:4px;">Total do Orçamento: <strong>' . number_format($totalGeral, 2, ",", ".") . '</strong></td>
            </tr>
        </table>

            <!-- Rodapé -->
            <p><strong>Prazo de Entrega:</strong> ' . htmlspecialchars($prazo_entrega ?? "A combinar") . '</p>
            <p><strong>Observações:</strong> ' . htmlspecialchars($observacoes ?? "Nenhuma") . '</p>
            <div class="top-bar"></div>
            <div class="top-bar" style="margin-top: 30px;"></div>
        </div>