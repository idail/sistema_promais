$.ajax({
            url: "cadastros/processa_clinica.php", // Endpoint da API
            method: "GET",
            dataType: "json",
            data: {
                "processo_clinica": "buscar_cidade_clinica",
                "valor_id_clinica":recebe_codigo_alteracao_clinica,
            },
            success: function(resposta) 
            {
                debugger;
                console.log(resposta);

                for (let indice = 0; indice < resposta.length; indice++)
                {
                    $("#cidade_id").val(resposta[0].id);
                }

                // let recebe_nome_cidade_clinica = resposta.nome;
                // let recebe_estado_clinica = resposta.estado;
                // let recebe_cidade_estado_clinica = recebe_nome_cidade_clinica + "-" + recebe_cidade_estado_clinica;

            },
            error:function(xhr,status,error)
            {
                console.log("Falha ao buscar cidade da clinica:" + error);
            },
        });

        $.ajax({
            url: "cadastros/processa_medico.php", // Endpoint da API
            method: "GET",
            dataType: "json",
            data: {
                "processo_medico": "buscar_medicos_associar_clinica"
            },
            success: function(resposta_medicos) {
                debugger;

                console.log(resposta_medicos);

                if (resposta_medicos.length > 0) {
                    let select_medicos = document.getElementById('medico-associado');
                    // Começa com uma opção padrão
                    let options = '<option value="">Selecione um médico</option>';

                    // Adiciona opções dos médicos retornados
                    for (let i = 0; i < resposta_medicos.length; i++) {
                        let medico = resposta_medicos[i];
                        options += `<option value="${medico.id}">${medico.nome}</option>`;
                    }

                    // Insere todas as opções de uma vez no select
                    select_medicos.innerHTML = options;
                }
            },
            error: function(xhr, status, error) {
                console.log("Falha ao buscar médicos:" + error);
            },
        });