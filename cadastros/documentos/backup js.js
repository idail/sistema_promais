// Mantém a variável global em sincronia no modo edição
    if (tipo === 'exame' && window.recebe_acao === 'editar') {
      window.aptExamesSelecionados = Array.isArray(arraySelecionado)
        ? arraySelecionado.map(item => ({
            codigo: String(item.codigo),
            recebe_apenas_nome: item.recebe_apenas_nome,
            valor: item.valor
          }))
        : [];
    }