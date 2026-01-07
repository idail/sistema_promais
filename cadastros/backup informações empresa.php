' . (!empty($resultado_empresa_selecionada['nome'])
    ? '<span class="hospital-nome">' . mb_strtoupper(htmlspecialchars($resultado_empresa_selecionada['nome']), 'UTF-8') . '</span>'
    : '') . '

' . (!empty($resultado_empresa_selecionada['cnpj'])
    ? 'CNPJ: ' . mb_strtoupper(htmlspecialchars($resultado_empresa_selecionada['cnpj']), 'UTF-8')
    : '') . '

' . (!empty($resultado_empresa_selecionada['endereco'])
    ? ' ENDEREÇO: ' . mb_strtoupper(
        htmlspecialchars(rtrim($resultado_empresa_selecionada['endereco'], ', ')),
        'UTF-8'
      )
    : '') . '

' . (!empty($resultado_empresa_selecionada['bairro'])
    ? ' BAIRRO: ' . mb_strtoupper(htmlspecialchars($resultado_empresa_selecionada['bairro']), 'UTF-8')
    : '') . '

' . (!empty($recebe_cidade_uf)
    ? ' CIDADE: ' . mb_strtoupper(htmlspecialchars($recebe_cidade_uf), 'UTF-8')
    : '') . '

' . (!empty($resultado_empresa_selecionada['cep'])
    ? ', CEP: ' . mb_strtoupper(htmlspecialchars($resultado_empresa_selecionada['cep']), 'UTF-8')
    : '') . '

' . (!empty($resultado_empresa_selecionada['telefone'])
    ? ' TELEFONE PARA CONTATO: ' . mb_strtoupper(htmlspecialchars($resultado_empresa_selecionada['telefone']), 'UTF-8') . '.'
    : '') . '