<td class="dados-hospital">

                ' . (!empty($resultado_clinica_selecionada["nome_fantasia"])
                    ? '<span class="hospital-nome">' . $resultado_clinica_selecionada["nome_fantasia"] . '</span><br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["cnpj"])
                    ? 'CNPJ: ' . $resultado_clinica_selecionada["cnpj"] . '<br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["endereco"])
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada["endereco"]
                    : '') .

                (!empty($resultado_clinica_selecionada["numero"])
                    ? ', ' . $resultado_clinica_selecionada["numero"]
                    : '') .

                (!empty($resultado_clinica_selecionada["bairro"])
                    ? ' - BAIRRO: ' . $resultado_clinica_selecionada["bairro"]
                    : '') . '

                ' . (!empty($recebe_cidade_uf)
                    ? '<br>CIDADE: ' . $recebe_cidade_uf
                    : '') .

                (!empty($resultado_clinica_selecionada["cep"])
                    ? ', CEP: ' . $resultado_clinica_selecionada["cep"]
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["telefone"])
                    ? '<br>TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada["telefone"]
                    : '') . '

            </td>


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


                <td class="dados-hospital">

                ' . (!empty($resultado_clinica_selecionada["nome_fantasia"])
                    ? '<span class="hospital-nome">' . $resultado_clinica_selecionada["nome_fantasia"] . '</span><br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["cnpj"])
                    ? 'CNPJ: ' . $resultado_clinica_selecionada["cnpj"] . '<br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["endereco"])
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada["endereco"]
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["numero"])
                    ? ', ' . $resultado_clinica_selecionada["numero"]
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["bairro"])
                    ? ' - BAIRRO: ' . $resultado_clinica_selecionada["bairro"]
                    : '') . '

                ' . (!empty($recebe_cidade_uf)
                    ? '<br>CIDADE: ' . $recebe_cidade_uf
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["cep"])
                    ? ', CEP: ' . $resultado_clinica_selecionada["cep"]
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["telefone"])
                    ? '<br>TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada["telefone"]
                    : '') . '

            </td>

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


                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>


                    <td class="dados-hospital">

                ' . (!empty($resultado_clinica_selecionada["nome_fantasia"])
                    ? '<span class="hospital-nome">' . $resultado_clinica_selecionada["nome_fantasia"] . '</span><br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["cnpj"])
                    ? 'CNPJ: ' . $resultado_clinica_selecionada["cnpj"] . '<br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["endereco"])
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada["endereco"]
                    : '') .

                (!empty($resultado_clinica_selecionada["numero"])
                    ? ', ' . $resultado_clinica_selecionada["numero"]
                    : '') .

                (!empty($resultado_clinica_selecionada["bairro"])
                    ? ' BAIRRO: ' . $resultado_clinica_selecionada["bairro"]
                    : '') . '

                ' . (!empty($recebe_cidade_uf)
                    ? '<br>CIDADE: ' . $recebe_cidade_uf
                    : '') .

                (!empty($resultado_clinica_selecionada["cep"])
                    ? ', CEP: ' . $resultado_clinica_selecionada["cep"]
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada["telefone"])
                    ? '<br>TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada["telefone"]
                    : '') . '

            </td>


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



                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>



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
            .dados-hospital { padding-top: 1px !important;
    padding-bottom: 1px !important;
    line-height: 1.05 !important;
    font-size: 14px !important; }
            .hospital-nome { font-weight:bold; text-transform:uppercase; text-decoration:underline; display:block; margin-bottom:3px;font-size: 12px !important; }

            .logo { text-align:center; }
            .logo img {
    max-height: 50px !important;
    display: block;
    margin: 0 auto !important;
    padding: 0 !important;
}

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
    .page-break {
        page-break-before: always;
    }
}

    /* Ajuste das linhas longas */
.parecer-fono td[colspan] {
    width: 100% !important;
    display: table-cell !important;
}
</style>';



<table style="width:100%; border-collapse:collapse;">
        <tr>
            <th colspan="2" class="titulo-guia">TESTE DE ACUIDADE VISUAL</th>
        </tr>

        <tr>
            <td class="dados-hospital" style="vertical-align:top; padding-right:10px;">

                ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) 
                    ? '<span class="hospital-nome" style="font-weight:bold;">' 
                        . $resultado_clinica_selecionada['nome_fantasia'] . 
                      '</span><br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cnpj']) 
                    ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['endereco']) 
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['numero']) 
                    ? ', ' . $resultado_clinica_selecionada['numero'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['bairro']) 
                    ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] 
                    : '') . '

                ' . (!empty($recebe_cidade_uf) 
                    ? '<br>CIDADE: ' . $recebe_cidade_uf 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cep']) 
                    ? ', CEP: ' . $resultado_clinica_selecionada['cep'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['telefone']) 
                    ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] 
                    : '') . '

            </td>

            <td class="logo" style="width:150px; text-align:center; vertical-align:middle;">
                <img src="' . $logo . '" alt="Logo"
                     style="max-height:70px !important; display:block; margin:0 auto;">
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


            ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) 
                    ? '<span class="hospital-nome" style="font-weight:bold;">' 
                        . $resultado_clinica_selecionada['nome_fantasia'] . 
                      '</span><br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cnpj']) 
                    ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['endereco']) 
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['numero']) 
                    ? ', ' . $resultado_clinica_selecionada['numero'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['bairro']) 
                    ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] 
                    : '') . '

                ' . (!empty($recebe_cidade_uf) 
                    ? '<br>CIDADE: ' . $recebe_cidade_uf 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cep']) 
                    ? ', CEP: ' . $resultado_clinica_selecionada['cep'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['telefone']) 
                    ? '. TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] 
                    : '') . '



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



                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>


                    ' . (!empty($resultado_clinica_selecionada['nome_fantasia'])
                    ? '<span class="hospital-nome" style="margin-bottom:-10px !important;">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span><br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cnpj'])
                    ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['endereco'])
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco']
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['numero'])
                    ? ', ' . $resultado_clinica_selecionada['numero']
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['bairro'])
                    ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] . '<br>'
                    : '') . '

                ' . (!empty($recebe_cidade_uf)
                    ? 'CIDADE: ' . $recebe_cidade_uf
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cep'])
                    ? ', CEP: ' . $resultado_clinica_selecionada['cep'] . '<br>'
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['telefone'])
                    ? 'TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone']
                    : '') . '


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


                    <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>



                    ' . (!empty($resultado_clinica_selecionada["nome_fantasia"])
                ? '<span class="hospital-nome" style="font-weight:bold; margin-bottom:-10px !important;">'
                    . $resultado_clinica_selecionada["nome_fantasia"] .
                  '</span><br>'
                : '') . '

            ' . (!empty($resultado_clinica_selecionada["cnpj"])
                ? 'CNPJ: ' . $resultado_clinica_selecionada["cnpj"] . '<br>'
                : '') . '

            ' . (!empty($resultado_clinica_selecionada["endereco"])
                ? 'ENDEREÇO: ' . $resultado_clinica_selecionada["endereco"]
                : '') . '

            ' . (!empty($resultado_clinica_selecionada["numero"])
                ? ', ' . $resultado_clinica_selecionada["numero"]
                : '') . '

            ' . (!empty($resultado_clinica_selecionada["bairro"])
                ? ' BAIRRO: ' . $resultado_clinica_selecionada["bairro"] . '<br>'
                : '') . '

            ' . (!empty($recebe_cidade_uf)
                ? 'CIDADE: ' . $recebe_cidade_uf
                : '') . '

            ' . (!empty($resultado_clinica_selecionada["cep"])
                ? ', CEP: ' . $resultado_clinica_selecionada["cep"] . '<br>'
                : '') . '

            ' . (!empty($resultado_clinica_selecionada["telefone"])
                ? 'TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada["telefone"]
                : '') . '


                ' . (!empty($resultado_empresa_selecionada['nome'])
            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
            : '') . '

        ' . (!empty($resultado_empresa_selecionada['nome'])
            ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
            : '') . '

        <div class="empresa-info">
            ' . (!empty($resultado_empresa_selecionada['cnpj'])
                ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) . ' '
                : '') . '

            ' . (!empty($resultado_empresa_selecionada['endereco'])
                ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) . ' '
                : '') . '

            ' . (!empty($resultado_empresa_selecionada['bairro'])
                ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) . ' '
                : '') . '

            ' . (!empty($recebe_cidade_uf)
                ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) . ', '
                : '') . '

            ' . (!empty($resultado_empresa_selecionada['cep'])
                ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) . ' '
                : '') . '

            ' . (!empty($resultado_empresa_selecionada['telefone'])
                ? 'TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.'
                : '') . '
        </div>


        <td colspan="2" style="font-size:12px; font-weight:bold; text-transform:uppercase; line-height:1.5;">
                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '
                    </td>


                    ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) 
                    ? '<span class="hospital-nome" style="margin-bottom:-10px !important;">' 
                        . $resultado_clinica_selecionada['nome_fantasia'] . 
                      '</span><br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cnpj']) 
                    ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['endereco']) 
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['numero']) 
                    ? ', ' . $resultado_clinica_selecionada['numero'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['bairro']) 
                    ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] . '<br>' 
                    : '') . '

                ' . (!empty($recebe_cidade_uf) 
                    ? 'CIDADE: ' . $recebe_cidade_uf 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cep']) 
                    ? ', CEP: ' . $resultado_clinica_selecionada['cep'] . '<br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['telefone']) 
                    ? 'TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] 
                    : '') . '

                    ' . (!empty($resultado_empresa_selecionada['nome'])
                ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '



                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '


                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) 
                    ? '<span class="hospital-nome" style="margin-bottom:-10px !important;">' 
                        . $resultado_clinica_selecionada['nome_fantasia'] . 
                      '</span><br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cnpj']) 
                    ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['endereco']) 
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['numero']) 
                    ? ', ' . $resultado_clinica_selecionada['numero'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['bairro']) 
                    ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] . '<br>' 
                    : '') . '

                ' . (!empty($recebe_cidade_uf) 
                    ? 'CIDADE: ' . $recebe_cidade_uf 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cep']) 
                    ? ', CEP: ' . $resultado_clinica_selecionada['cep'] . '<br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['telefone']) 
                    ? 'TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] 
                    : '') . '


                    ' . (!empty($resultado_empresa_selecionada['nome'])
                ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '


                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '


                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) 
                    ? '<span class="hospital-nome" style="margin-bottom:-10px !important;">' 
                        . $resultado_clinica_selecionada['nome_fantasia'] . 
                      '</span><br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cnpj']) 
                    ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['endereco']) 
                    ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['numero']) 
                    ? ', ' . $resultado_clinica_selecionada['numero'] 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['bairro']) 
                    ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] . '<br>' 
                    : '') . '

                ' . (!empty($recebe_cidade_uf) 
                    ? 'CIDADE: ' . $recebe_cidade_uf 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['cep']) 
                    ? ', CEP: ' . $resultado_clinica_selecionada['cep'] . '<br>' 
                    : '') . '

                ' . (!empty($resultado_clinica_selecionada['telefone']) 
                    ? 'TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] 
                    : '') . '



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



                ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['titulo_cargo']) ? 'CARGO: ' . $resultado_cargo_selecionado['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_cargo_selecionado['codigo_cargo']) ? 'CBO: ' . $resultado_cargo_selecionado['codigo_cargo'] : '') . '



                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) 
                ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['cnpj']) 
                ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['endereco']) 
                ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['numero']) 
                ? ', ' . $resultado_clinica_selecionada['numero'] 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['bairro']) 
                ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] 
                : '') . '

            ' . (!empty($recebe_cidade_uf) 
                ? '<br>CIDADE: ' . $recebe_cidade_uf 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['cep']) 
                ? ', CEP: ' . $resultado_clinica_selecionada['cep'] . '<br>' 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['telefone']) 
                ? 'TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] 
                : '') . '


                ' . (!empty($resultado_empresa_selecionada['nome'])
                ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '


                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '

                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) 
                ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['cnpj']) 
                ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['endereco']) 
                ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['numero']) 
                ? ', ' . $resultado_clinica_selecionada['numero'] 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['bairro']) 
                ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] 
                : '') . '

            ' . (!empty($recebe_cidade_uf) 
                ? '<br>CIDADE: ' . $recebe_cidade_uf 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['cep']) 
                ? ', CEP: ' . $resultado_clinica_selecionada['cep'] . '<br>' 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['telefone']) 
                ? 'TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] 
                : '') . '


                ' . (!empty($resultado_empresa_selecionada['nome'])
                ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '



                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '


                        ' . (!empty($resultado_clinica_selecionada['nome_fantasia']) 
                ? '<span class="hospital-nome">' . $resultado_clinica_selecionada['nome_fantasia'] . '</span>' 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['cnpj']) 
                ? 'CNPJ: ' . $resultado_clinica_selecionada['cnpj'] . '<br>' 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['endereco']) 
                ? 'ENDEREÇO: ' . $resultado_clinica_selecionada['endereco'] 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['numero']) 
                ? ', ' . $resultado_clinica_selecionada['numero'] 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['bairro']) 
                ? ' BAIRRO: ' . $resultado_clinica_selecionada['bairro'] 
                : '') . '

            ' . (!empty($recebe_cidade_uf) 
                ? '<br>CIDADE: ' . $recebe_cidade_uf 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['cep']) 
                ? ', CEP: ' . $resultado_clinica_selecionada['cep'] 
                : '') . '

            ' . (!empty($resultado_clinica_selecionada['telefone']) 
                ? '<br>TELEFONE PARA CONTATO: ' . $resultado_clinica_selecionada['telefone'] 
                : '') . '


                 <td class="logo">
            <img src="'.$logo.'" alt="Logo" style="max-height:55px !important; display:block !important; margin:0 auto !important;">
        </td>



        ' . (!empty($resultado_empresa_selecionada['nome'])
                ? '<span class="hospital-nome">' . htmlspecialchars($resultado_empresa_selecionada['nome']) . '</span>'
                : '') . '
                        ' . (!empty($resultado_empresa_selecionada['cnpj']) ? 'CNPJ: ' . htmlspecialchars($resultado_empresa_selecionada['cnpj']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['endereco']) ? 'ENDEREÇO: ' . htmlspecialchars($resultado_empresa_selecionada['endereco']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['bairro']) ? 'BAIRRO: ' . htmlspecialchars($resultado_empresa_selecionada['bairro']) : '') . '
                        ' . (!empty($recebe_cidade_uf) ? 'CIDADE: ' . htmlspecialchars($recebe_cidade_uf) : '') . ',
                        ' . (!empty($resultado_empresa_selecionada['cep']) ? 'CEP: ' . htmlspecialchars($resultado_empresa_selecionada['cep']) : '') . '
                        ' . (!empty($resultado_empresa_selecionada['telefone']) ? ' TELEFONE PARA CONTATO: ' . htmlspecialchars($resultado_empresa_selecionada['telefone']) . '.' : '') . '



                        ' . (!empty($resultado_pessoa_selecionada['nome']) ? 'NOME DO FUNCIONÁRIO:' . $resultado_pessoa_selecionada['nome'] . '<br>' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['cpf']) ? 'CPF:' . $resultado_pessoa_selecionada['cpf'] . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($recebe_nascimento_colaborador) ? 'DATA DE NASCIMENTO: ' . $recebe_nascimento_colaborador . '&nbsp;&nbsp;&nbsp;&nbsp' : '') . '
                        ' . (!empty($idade) ? 'Idade: ' . $idade . ' anos &nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_pessoa_selecionada['telefone']) ? 'TELEFONE: ' . $resultado_pessoa_selecionada['telefone'] . '<br>' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['titulo_cargo']) ? 'CARGO: ' . $resultado_busca_cargo_pessoa['titulo_cargo'] . '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '
                        ' . (!empty($resultado_busca_cargo_pessoa['codigo_cargo']) ? 'CBO: ' . $resultado_busca_cargo_pessoa['codigo_cargo'] : '') . '


                        /* 🔹 Ajusta definitivamente qualquer célula da linha */
.bloco-cabecalho td {
    padding: 5px 3px !important;
    line-height: 1.05 !important;
}

@media print {

    /* Força a tabela EXATA da audiometria a ocupar 100% */
    table.parecer-fono-tabela {
        width: 100% !important;
        max-width: 100% !important;
        table-layout: auto !important;
        border-collapse: collapse !important;
    }

    /* Todas as células expandem normalmente */
    table.parecer-fono-tabela td,
    table.parecer-fono-tabela th {
        width: auto !important;
        max-width: none !important;
        white-space: normal !important;
        padding: 2px !important;
    }
}

/* ===========================
   AJUSTE FINAL DO PARECER
   =========================== */

@media print {

  /* força a tabela a ocupar toda a largura */
  table.parecer-fono-tabela {
      width: 100% !important;
      max-width: 100% !important;
      border-collapse: collapse !important;
      table-layout: auto !important;
  }

  /* remove larguras internas que limitam expansão */
  table.parecer-fono-tabela td,
  table.parecer-fono-tabela th {
      width: auto !important;
      max-width: none !important;
      white-space: normal !important;
      padding: 2px !important;
      line-height: 1.15 !important;
  }

  /* remove atributos width vindo do HTML */
  table.parecer-fono-tabela [width],
  table.parecer-fono-tabela td[width],
  table.parecer-fono-tabela th[width] {
      width: auto !important;
  }

  /* corrige assinatura descendo a linha */
  .parecer-fono .assinatura {
      margin-top: 8px !important;
      padding-top: 4px !important;
      height: auto !important;
  }

  .parecer-fono .assinatura .linha-assinatura {
      height: 40px !important;
      border-bottom: 1px solid #000 !important;
      margin-top: 6px !important;
  }
}




@media print {

    /* Força a tabela EXATA da audiometria a ocupar 100% */
    table.parecer-fono-tabela {
        width: 100% !important;
        max-width: 100% !important;
        table-layout: auto !important;
        border-collapse: collapse !important;
    }

    /* Todas as células expandem normalmente */
    table.parecer-fono-tabela td,
    table.parecer-fono-tabela th {
        width: auto !important;
        max-width: none !important;
        white-space: normal !important;
        padding: 2px !important;
    }
}

/* ===========================
   AJUSTE FINAL DO PARECER
   =========================== */

@media print {

  /* força a tabela a ocupar toda a largura */
  table.parecer-fono-tabela {
      width: 100% !important;
      max-width: 100% !important;
      border-collapse: collapse !important;
      table-layout: auto !important;
  }

  /* remove larguras internas que limitam expansão */
  table.parecer-fono-tabela td,
  table.parecer-fono-tabela th {
      width: auto !important;
      max-width: none !important;
      white-space: normal !important;
      padding: 2px !important;
      line-height: 1.15 !important;
  }

  /* remove atributos width vindo do HTML */
  table.parecer-fono-tabela [width],
  table.parecer-fono-tabela td[width],
  table.parecer-fono-tabela th[width] {
      width: auto !important;
  }

  /* corrige assinatura descendo a linha */
  .parecer-fono .assinatura {
      margin-top: 8px !important;
      padding-top: 4px !important;
      height: auto !important;
  }

  .parecer-fono .assinatura .linha-assinatura {
      height: 40px !important;
      border-bottom: 1px solid #000 !important;
      margin-top: 6px !important;
  }
}



.logo-audio img { width: 50px !important; height: 50px !important; max-height:90px !important; display:block; margin: 0 auto !important; } 