<tr>
    <!-- Assinatura médico -->
    <td class="assinaturas informacoes_medico" style="height:100px; text-align:center; vertical-align:bottom; font-size:11px; border-top:1px solid #000; padding: 10px;">
        
            ' . (!empty($html_assinatura_fono) ? $html_assinatura_fono : 
                (!empty($html_assinatura_medico) ? $html_assinatura_medico : '')) . '
            <div style="border-top: 1px solid #000; width: 80%; margin: 15px auto 3px;"></div>
            <div style="font-weight: bold; margin: 3px 0;">Assinatura</div>
            <div style="font-size: 10px; margin-bottom: 2px;">
                ' . (!empty($resultado_medico_fonoaudiologo['nome'])
                    ? 'Fonoaudiólogo Examinador'
                    : (!empty($resultado_medico_relacionado_clinica['nome'])
                        ? 'Médico Examinador'
                        : '')) . '
            </div>
            
                ' . htmlspecialchars(
                    !empty($resultado_medico_fonoaudiologo['nome'])
                        ? $resultado_medico_fonoaudiologo['nome']
                        : ($resultado_medico_relacionado_clinica['nome'] ?? '')
                ) .
                (!empty($resultado_medico_fonoaudiologo['crm']) || !empty($resultado_medico_relacionado_clinica['crm'])
                    ? ' — CRM: ' . 
                      (!empty($resultado_medico_fonoaudiologo['crm'])
                        ? $resultado_medico_fonoaudiologo['crm']
                        : $resultado_medico_relacionado_clinica['crm'])
                    : '') . '
            
        
    </td>








    <table class="no-break parecer-fono-tabela" style="width:100%; border-collapse:collapse; margin-top:5px;">



    <tr>
        <td colspan="6" class="parecer-fono titulo" style="border:1px solid #000; padding:4px; font-weight:bold; text-align:center;">
            PARECER FONOAUDIOLÓGICO
        </td>
    </tr>

    <tr>
        <td colspan="6" class="parecer-fono" style="border:1px solid #000; padding:4px;">
            <strong>• LIMIARES AUDITIVOS DENTRO DOS PADRÕES DE NORMALIDADE (500 a 4000Hz)</strong>  
            (&nbsp;&nbsp;&nbsp;  ) | OD |  
            (&nbsp;&nbsp;&nbsp;  ) | OE |
        </td>
    </tr>

    <tr>
        <td colspan="6" class="parecer-fono" style="border:1px solid #000; padding:4px;">
            <strong>• DO TIPO DA PERDA AUDITIVA:</strong> (Silman e Silverman, 1997)<br>
            (&nbsp;&nbsp;&nbsp;  ) Condutiva | OD | (&nbsp;&nbsp;&nbsp;  ) OE  
            (&nbsp;&nbsp;&nbsp;  ) Mista | OD | (&nbsp;&nbsp;&nbsp;  ) OE  
            (&nbsp;&nbsp;&nbsp;  ) Neurosensorial | OD | (&nbsp;&nbsp;&nbsp;  ) OE
        </td>
    </tr>

    <tr>
        <td colspan="6" class="parecer-fono" style="border:1px solid #000; padding:4px;">
            <strong>• DO GRAU DA PERDA AUDITIVA</strong> (Lloyd e Kaplan, 1978)<br>
            (&nbsp;&nbsp;&nbsp;  ) Normal | OD | (&nbsp;&nbsp;&nbsp;  ) OE  
            (&nbsp;&nbsp;&nbsp;  ) Leve | OD | (&nbsp;&nbsp;&nbsp;  ) OE  
            (&nbsp;&nbsp;&nbsp;  ) Moderada | OD | (&nbsp;&nbsp;&nbsp;  ) OE  
            (&nbsp;&nbsp;&nbsp;  ) Moderada Severa | OD | (&nbsp;&nbsp;&nbsp;  ) OE  
            (&nbsp;&nbsp;&nbsp;  ) Severa | OD | (&nbsp;&nbsp;&nbsp;  ) OE  
            (&nbsp;&nbsp;&nbsp;  ) Profunda | OD | (&nbsp;&nbsp;&nbsp;  ) OE
        </td>
    </tr>

    <tr>
    <td colspan="6" class="obs-linha" style="border:1px solid #000; vertical-align:top;">
        <strong>Obs:</strong> 
    </td>
</tr>

    <tr>
        <td colspan="6" style="border:1px solid #000; padding:4px;">
            ' . htmlspecialchars($recebe_cidade_uf) . ' , DATA: ' . htmlspecialchars($dataAtual ?? "") . '
        </td>
    </tr>


    

   <tr>
    <!-- Assinatura médico -->
    <td class="assinaturas informacoes_medico" style="height:100px; text-align:center; vertical-align:bottom; font-size:11px; border-top:1px solid #000; padding: 10px;">
        
            ' . (!empty($html_assinatura_fono) ? $html_assinatura_fono : 
                (!empty($html_assinatura_medico) ? $html_assinatura_medico : '')) . '
            <div style="border-top: 1px solid #000; width: 80%; margin: 15px auto 3px;"></div>
            <div style="font-weight: bold; margin: 3px 0;">Assinatura</div>
            <div style="font-size: 10px; margin-bottom: 2px;">
                ' . (!empty($resultado_medico_fonoaudiologo['nome'])
                    ? 'Fonoaudiólogo Examinador'
                    : (!empty($resultado_medico_relacionado_clinica['nome'])
                        ? 'Médico Examinador'
                        : '')) . '
            </div>
            
                ' . htmlspecialchars(
                    !empty($resultado_medico_fonoaudiologo['nome'])
                        ? $resultado_medico_fonoaudiologo['nome']
                        : ($resultado_medico_relacionado_clinica['nome'] ?? '')
                ) .
                (!empty($resultado_medico_fonoaudiologo['crm']) || !empty($resultado_medico_relacionado_clinica['crm'])
                    ? ' — CRM: ' . 
                      (!empty($resultado_medico_fonoaudiologo['crm'])
                        ? $resultado_medico_fonoaudiologo['crm']
                        : $resultado_medico_relacionado_clinica['crm'])
                    : '') . '
            
        
    </td>

    <!-- Assinatura funcionário -->
    <td class="assinaturas informacoes_funcionario" style="height:90px; text-align:center; vertical-align:bottom; font-size:7.2px; line-height:1.05; border-top:1px solid #000; padding:4px 6px; box-sizing:border-box; min-width:0; width:38%;">
        <div style="display:inline-block; text-align:center; width:100%; max-width:90%; margin:0 auto; padding:0;" class="funcionario">
            <div style="border-top:1px solid #000; width:50%; margin:2px auto;" class="linha_assinatura"></div>
            <div style="font-weight:bold; font-size:7px; line-height:1.1; margin:1px 0; white-space:nowrap;" class="titulo_assinatura">Assinatura do Funcionário</div>
            <div style="font-size:6.8px; line-height:1.05; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:88%; margin:0 auto;" class="nome_funcionario">
                ' . htmlspecialchars($resultado_pessoa_selecionada['nome'] ?? '') . 
                (!empty($resultado_pessoa_selecionada['cpf']) 
                    ? 'CPF: ' . htmlspecialchars($resultado_pessoa_selecionada['cpf']) 
                    : '') . '
            </div>
        </div>
    </td>
</tr>
</table>