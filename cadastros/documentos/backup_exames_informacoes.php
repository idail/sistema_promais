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
                    <th colspan="2" class="titulo-guia">ASO - Atestado de Saúde Ocupacional</th>
                </tr>
                
            </table>