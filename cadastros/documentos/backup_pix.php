 <!-- Botão de Adicionar Chave PIX (posicionado abaixo do Tipo de Orçamento) -->
        <div style="margin-top: 1rem; margin-bottom: 2rem; text-align: right;">
          <button type="button" id="btn-adicionar-pix-outside" class="btn btn-primary" 
                  style="padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; 
                         background-color: #3b82f6; color: white; cursor: pointer; 
                         font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i> Adicionar Chave PIX
          </button>
        </div>


        window.fatAdicionarProduto = function() {
    debugger;
    const descricao = document.getElementById('fat-descricao')?.value.trim();
    const quantidade = parseInt(document.getElementById('fat-quantidade')?.value);
    const valorUnit = parseFloat(document.getElementById('fat-valorUnit')?.value);

    if (!descricao || isNaN(quantidade) || isNaN(valorUnit)) {
      alert('Preencha todos os campos corretamente.');
      return;
    }

    const valorTotal = quantidade * valorUnit;
    
    // Atualiza o total global de EPI/EPC
    window.fatTotalEPI = (window.fatTotalEPI || 0) + valorTotal;
    console.log('Produto adicionado. Novo total EPI/EPC:', window.fatTotalEPI);

    // Adiciona estilos CSS para a lista de produtos (uma única vez)
    const style = document.createElement('style');
    if (!document.getElementById('fat-styles')) {
      style.id = 'fat-styles';
      style.textContent = `
        .fat-produto-item {
          display: flex;
          align-items: center;
          gap: 15px;
          padding: 12px 15px;
          color: #2d3748;
          font-size: 14px;
          border-bottom: 1px solid #e2e8f0;
          transition: all 0.2s ease;
          background-color: white;
          border-radius: 8px;
          margin-bottom: 8px;
          box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .fat-produto-item:hover {
          background-color: #f8fafc;
          transform: translateY(-1px);
          box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .fat-produto-item > div { padding: 4px 8px; }
        .fat-produto-descricao { flex: 3; font-weight: 500; color: #1a365d; }
        .fat-produto-quantidade, .fat-produto-valor-unit, .fat-produto-total { flex: 1; text-align: center; color: #4a5568; }
        .fat-produto-total { font-weight: 600; color: #2b6cb0; }
        .fat-produto-acoes { flex: 0.8; text-align: center; }
        .btn-remover {
          background-color: #fff; color: #e53e3e; border: 1px solid #fed7d7; border-radius: 6px;
          padding: 6px 12px; font-size: 13px; font-weight: 500; cursor: pointer; display: inline-flex;
          align-items: center; gap: 4px; transition: all 0.2s ease;
        }
        .btn-remover:hover { background-color: #feb2b2; color: #9b2c2c; transform: translateY(-1px); }
        .btn-remover i { font-size: 14px; }
      `;
      document.head.appendChild(style);
    }

    const linha = document.createElement('div');
    linha.className = 'fat-produto-item';
    
    const html = [
      `<div class="fat-produto-descricao">${descricao}</div>`,
      `<div class="fat-produto-quantidade">${quantidade}</div>`,
      `<div class="fat-produto-valor-unit">${window.fatFormatter.format(valorUnit)}</div>`,
      `<div class="fat-produto-total">${window.fatFormatter.format(valorTotal)}</div>`,
      '<div class="fat-produto-acoes">',
      `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${valorTotal})">`,
      '    <i class="fas fa-trash-alt"></i> Remover',
      '  </button>',
      '</div>'
    ].join('');
    
    linha.innerHTML = html;

    // Adiciona à lista de produtos
    const lista = document.getElementById('fat-lista-produtos');
    if (lista) lista.appendChild(linha);

    // Limpa os campos
    const descEl = document.getElementById('fat-descricao');
    const qtdEl = document.getElementById('fat-quantidade');
    const valEl = document.getElementById('fat-valorUnit');
    if (descEl) descEl.value = '';
    if (qtdEl) qtdEl.value = '1';
    if (valEl) valEl.value = '';
    
    // Atualiza os totais exibidos
    if (typeof window.fatAtualizarTotais === 'function') {
      window.fatAtualizarTotais();
    }
  };