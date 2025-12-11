function updateSelectedList() {
  debugger;
  try {
    if (window._smDocUpdating) return;
    window._smDocUpdating = true;

    const selectedList = document.getElementById('sm-selected-list');
    if (!selectedList) {
      console.warn('⚠️ Elemento #sm-selected-list não encontrado.');
      window._smDocUpdating = false;
      return;
    }

    const modelosSelecionados = [];
    const tiposOrcamentoSelecionados = [];

    // 🔹 Coleta modelos selecionados
    document.querySelectorAll('.sm-label').forEach(label => {
      const card = label.querySelector('.sm-card');
      const checkbox = label.querySelector('input[type="checkbox"]');
      if (card && checkbox && checkbox.checked) {
        const text = card.querySelector('span')?.textContent?.trim();
        if (text) modelosSelecionados.push({ text, card, checkbox });
      }
    });

    // 🔹 Coleta tipos de orçamento selecionados (armazenamento apenas)
    document.querySelectorAll('.tipo-orcamento-label').forEach(label => {
      const checkbox = label.querySelector('input[type="checkbox"]');
      const text = label.querySelector('span')?.textContent?.trim();
      if (checkbox && checkbox.checked && text) {
        tiposOrcamentoSelecionados.push(text);
      }
    });

    // 🔹 Atualiza variáveis globais
    window._modelosSelecionados = [...new Set(modelosSelecionados.map(m => m.text))];
    window._tiposOrcamentoSelecionados = [...new Set(tiposOrcamentoSelecionados)];

    // ✅ Nova variável: simplesmente copia os textos selecionados (strings)
//     if (!Array.isArray(window.smModelosSelecionadosCompletos)) {
//   window.smModelosSelecionadosCompletos = (window._modelosSelecionados || []).slice();
// }

    // 🔹 Armazena todos os selecionados (modelos + tipos)
    window.todosSelecionados = [...window._modelosSelecionados, ...window._tiposOrcamentoSelecionados];

        // 🔹 Atualiza apenas a exibição dos blocos por tipo de orçamento
    try {
      if (Array.isArray(window._tiposOrcamentoSelecionados)) {
        atualizarExibicaoTiposOrcamento(window._tiposOrcamentoSelecionados);
      }
    } catch (e) {
      console.warn('Falha ao atualizar exibicao dos tipos de orcamento:', e);
    }

    // 🔹 Limpa exibição anterior
    selectedList.innerHTML = '';

    // 🎨 Função para definir cores com base no ícone
    const colorsFromIcon = (icon) => {
      let bgColor = '#f3f4f6';
      let textColor = '#1f2937';

      if (icon) {
        if (icon.classList.contains('fa-paper-plane')) {
          bgColor = '#dbeafe'; textColor = '#1e40af';
        } else if (icon.classList.contains('fa-clipboard-list')) {
          bgColor = '#d1fae5'; textColor = '#065f46';
        } else if (icon.classList.contains('fa-file-medical')) {
          bgColor = '#fef3c7'; textColor = '#92400e';
        } else if (icon.classList.contains('fa-eye')) {
          bgColor = '#fee2e2'; textColor = '#991b1b';
        } else if (icon.classList.contains('fa-users')) {
          bgColor = '#e0e7ff'; textColor = '#3730a3';
        } else if (icon.classList.contains('fa-exclamation-triangle')) {
          bgColor = '#fef3c7'; textColor = '#92400e';
        } else if (icon.classList.contains('fa-file-alt')) {
          bgColor = '#1e1b4b'; textColor = '#ffffff';
        } else if (icon.classList.contains('fa-dollar-sign')) {
          bgColor = '#ecfdf5'; textColor = '#065f46';
        } else if (icon.classList.contains('fa-stethoscope')) {
          bgColor = '#f3e8ff'; textColor = '#6d28d9';
        } else if (icon.classList.contains('fa-graduation-cap')) {
          bgColor = '#fff7ed'; textColor = '#9a3412';
        } else if (icon.classList.contains('fa-hard-hat')) {
          bgColor = '#fef9c3'; textColor = '#854d0e';
        }
      }

      return { bgColor, textColor };
    };

    // 🔸 Exibe apenas os modelos
    modelosSelecionados.forEach(({ text, card, checkbox }) => {
      const selectedItem = document.createElement('div');
      selectedItem.className = 'sm-selected-item';
      selectedItem.style.display = 'flex';
      selectedItem.style.alignItems = 'center';
      selectedItem.style.justifyContent = 'space-between';
      selectedItem.style.gap = '8px';
      selectedItem.style.padding = '6px 8px';
      selectedItem.style.borderRadius = '8px';
      selectedItem.style.marginBottom = '6px';

      // Aplica cores conforme o ícone
      const icon = card ? card.querySelector('i') : null;
      const { bgColor, textColor } = colorsFromIcon(icon);
      selectedItem.style.backgroundColor = bgColor;
      selectedItem.style.color = textColor;

      // Clona ícone (se existir)
      if (icon) {
        const iconClone = icon.cloneNode(true);
        iconClone.classList.add('sm-selected-icon');
        selectedItem.appendChild(iconClone);
      }

      // Texto do modelo
      const textNode = document.createElement('span');
      textNode.textContent = text;
      textNode.style.flex = '1';
      selectedItem.appendChild(textNode);

      // Botão remover
      const removeBtn = document.createElement('button');
      removeBtn.className = 'remove-document';
      removeBtn.innerHTML = '×';
      removeBtn.title = 'Remover';
      removeBtn.style.cursor = 'pointer';
      removeBtn.style.border = 'none';
      removeBtn.style.background = 'transparent';
      removeBtn.style.fontSize = '18px';
      removeBtn.style.lineHeight = '1';
      removeBtn.style.padding = '2px 6px';

      removeBtn.onclick = (e) => {
        e.stopPropagation();

        // Desmarca o checkbox
        if (checkbox) checkbox.checked = false;

        // Atualiza variáveis globais
        window._modelosSelecionados = (window._modelosSelecionados || []).filter(m => m !== text);

        // // 🔁 Atualiza a variável completa também
        window.smModelosSelecionadosCompletos = window.smModelosSelecionadosCompletos.filter(m => m.text !== text);

        // // Atualiza exibição
        window._smDocUpdating = false;
        updateSelectedList();

        e.stopPropagation();

  // Desmarca o checkbox
  if (checkbox) checkbox.checked = false;

  // Atualiza variáveis globais
  window._modelosSelecionados = (window._modelosSelecionados || []).filter(m => m !== text);

  // 🔁 Atualiza a variável completa também (mesma estrutura - array de strings)
  window.smModelosSelecionadosCompletos = (window._modelosSelecionados || []).slice();

  // Atualiza exibição
  window._smDocUpdating = false;
  updateSelectedList();
      };

      selectedItem.appendChild(removeBtn);
      selectedList.appendChild(selectedItem);
    });

    // 🔸 Mensagem quando não houver modelos
    if (window._modelosSelecionados.length === 0) {
      selectedList.innerHTML = '<p class="sm-empty-message">Nenhum modelo selecionado</p>';
    }

    // 🔸 Atualiza JSONs
    window.smDocumentosSelecionadosJSON = JSON.stringify(window._modelosSelecionados || []);
    window.tiposOrcamentoSelecionadosJSON = JSON.stringify(window._tiposOrcamentoSelecionados || []);
    window.smModelosSelecionadosCompletosJSON = JSON.stringify(window.smModelosSelecionadosCompletos || []);

    console.log('✅ Modelos:', window._modelosSelecionados);
    console.log('📦 Objetos completos:', window.smModelosSelecionadosCompletos);
  } catch (err) {
    console.error('❌ Erro em updateSelectedList:', err);
  } finally {
    window._smDocUpdating = false;
  }
}

// Controle de exibição dos blocos de conta bancária por tipo de orçamento
function atualizarExibicaoTiposOrcamento(tiposSelecionados) {
  try {
    const tipos = Array.isArray(tiposSelecionados) ? tiposSelecionados : [];

    const hasExames = tipos.includes('Exames e Procedimentos');
    const hasTreinamentos = tipos.includes('Treinamentos');
    const hasEpi = tipos.includes('EPI/EPC');

    const secExames = document.getElementById('orcamento-exames-container');
    const secTreinamentos = document.getElementById('orcamento-treinamentos-container');
    const secEpi = document.getElementById('orcamento-epi-container');

    if (secExames) secExames.style.display = hasExames ? 'block' : 'none';
    if (secTreinamentos) secTreinamentos.style.display = hasTreinamentos ? 'block' : 'none';
    if (secEpi) secEpi.style.display = hasEpi ? 'block' : 'none';
  } catch (e) {
    console.warn('Erro ao controlar exibicao dos blocos de tipos de orcamento:', e);
  }
}