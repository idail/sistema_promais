if (quickRiskBtnSalvar && quickRiskModal && selectedRisksContainer) {
        quickRiskBtnSalvar.addEventListener('click', function() {
          debugger;

          const grupo = quickRiskGrupo ? quickRiskGrupo.value.trim() : '';
          const codigo = quickRiskCodigo ? quickRiskCodigo.value.trim() : '';
          const descricao = quickRiskDescricao ? quickRiskDescricao.value.trim() : '';

          // Validação básica dos campos obrigatórios
          if (!grupo || grupo === 'selecione' || !codigo || !descricao) {
            alert('Informe o grupo, o código e a descrição do risco.');
            return;
          }

          // Garante que o objeto global de grupos de risco exista
          if (typeof window.risksData !== 'object' || !window.risksData) {
            window.risksData = {};
          }

          // Descobre o nome amigável do grupo (se disponível)
          let nomeGrupo = grupo;
          try {
            if (window.nomesGrupos && window.nomesGrupos[grupo]) {
              nomeGrupo = window.nomesGrupos[grupo];
            }
          } catch (e) { /* ignore */ }

          // Se o grupo ainda não existir em risksData, cria no mesmo formato de buscar_riscos()
          if (!window.risksData[grupo]) {
            window.risksData[grupo] = {
              name: nomeGrupo,
              risks: []
            };
          }

          // Adiciona o risco informado ao array do grupo, no formato padrão
          window.risksData[grupo].risks.push({
            code: codigo,
            name: descricao,
            isOther: descricao.toLowerCase() === 'outros'
          });

          console.log('Risco rápido adicionado a risksData:', {
            grupo,
            grupoDados: window.risksData[grupo]
          });

          // Não atualiza a listagem visual de riscos selecionados aqui;
          // apenas alimenta a estrutura de grupos de risco

          quickRiskModal.style.display = 'none';
        });
      }