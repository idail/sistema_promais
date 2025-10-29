<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <input type="hidden" name="medico_id_alteracao" id="medico_id_alteracao">

            <!-- <div class="form-group">
                <label for="created_at">Data de Cadastro:</label>
                <div class="input-with-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="datetime-local" id="created_at" name="created_at" class="form-control" readonly>
                </div>
            </div> -->

            <div class="form-columns">
                <div class="form-column">


                    <div class="address-container">

                        <div class="form-group" style="flex:35%;">
                            <label for="grupo_risco">Empresas:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-building"></i>

                                <select id="empresas" name="empresas" class="form-control" style="width: 25%;">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <table id="kits_tabela">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Tipo do Exame</th>
                            <th>Empresa</th>
                            <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dados serão preenchidos via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- <div class="text-sm text-red-600 mt-3" id="mensagem-campo-vazio">
                <span id="corpo-mensagem-campo-vazio"></span>
            </div>

            <div id="mensagem-gravacao"
                class="hidden items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 transition-opacity duration-500"
                role="alert">
                
                <div>
                    <span class="font-medium" id="corpo-mensagem-gravacao"></span>
                </div>
            </div> -->

            <!-- <input type="hidden" name="id_risco_alteracao" id="id_risco_alteracao">

            <button type="button" class="btn btn-primary" name="grava_risco" id="grava-risco">Salvar</button>
            <button type="button" id="cancelar-risco" class="botao-cinza">Cancelar</button> -->
        </form>
    </div>

    <!-- <div id="profissionais" class="tab-content">
        <p>Conteúdo da aba Profissionais da Medicina Relacionados.</p>
    </div> -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<style>
    /* Estilos gerais da tabela */
    #kits_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #kits_tabela th,
    #kits_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #kits_tabela th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .tab-container {
        width: 100%;
    }

    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #ccc;
    }

    .tab-button {
        padding: 10px 20px;
        cursor: pointer;
        background-color: #f1f1f1;
        border: none;
        outline: none;
        transition: background-color 0.3s;
    }

    .tab-button:hover {
        background-color: #ddd;
    }

    .tab-button.active {
        background-color: rgb(59, 59, 59);
        color: white;
    }

    .tab-content {
        display: none;
        padding: 20px;
        border: none;
        border-top: none;
    }

    .tab-content.active {
        display: block;
    }

    .custom-form .form-columns {
        display: flex;
        gap: 20px;
    }

    .custom-form .form-column {
        flex: 1;
    }

    .custom-form .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 11px;
        color: #888;
    }

    .custom-form .form-control {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: none;
        border-radius: 8px;
        box-shadow: 0px 3px 5px -3px rgba(0, 0, 0, 0.1);
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
    }

    .status-toggle {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .status-toggle .toggle-checkbox {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .status-toggle .toggle-label {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .status-toggle .toggle-label:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .status-toggle .toggle-checkbox:checked+.toggle-label {
        background-color: #4CAF50;
    }

    .status-toggle .toggle-checkbox:checked+.toggle-label:before {
        transform: translateX(26px);
    }

    .btn-primary {
        padding: 10px 20px;
        background-color: rgb(72, 74, 77);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Ajuste para o campo de data e hora */
    input[type="datetime-local"] {
        width: auto;
        /* Define a largura automática */
        max-width: 300px;
        /* Define uma largura máxima */
    }

    /* Estilo para o container de endereço */
    .address-container {
        display: flex;
        gap: 10px;
    }

    /* Estilo para o input de CNPJ */
    .cnpj-input {
        border: none;
        background-color: rgb(201, 201, 201);
        font-weight: bold;
        color: black;
    }


    .cnpj-input:focus {
        border-color: #45a049;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
    }

    .botao-cinza {
        background-color: #6c757d;
        /* cinza escuro */
        color: white;
        /* texto branco */
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .botao-cinza:hover {
        background-color: #5a6268;
        /* cinza mais escuro no hover */
    }

    .accordion {
        margin-top: 30px;
    }

    .accordion-item {
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .accordion-header {
        width: 100%;
        text-align: left;
        background-color: #f1f1f1;
        color: #333;
        font-weight: 600;
        padding: 14px 20px;
        /* Ajuste do padding do cabeçalho */
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .accordion-header:hover {
        background-color: #ddd;
    }

    .accordion-header[aria-expanded="true"] {
        background-color: #ccc;
    }

    .accordion-content {
        padding: 20px 30px;
        /* Aumentei o padding interno */
        background-color: #fafafa;
        color: #555;
        line-height: 1.6;
        font-size: 14px;
    }

    .accordion-content.hidden {
        display: none;
    }




    /* Botões de salvar e cancelar ajustados */
    #grava-medico,
    #retornar-listagem-medicos {
        margin-top: 20px;
    }

    /* Ajuste opcional no botão 'Cancelar' */
    #retornar-listagem-medicos.botao-cinza {
        background-color: #bbb;
        color: #333;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    #retornar-listagem-medicos.botao-cinza:hover {
        background-color: #999;
    }

    /* Ajuste no container */
    .tab-content {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
    }

    .hidden {
        display: none;
    }

    /* .accordion-content {
        min-height: 150px;
        /* ou outro valor */
</style>

<script>
    let recebe_codigo_alteracao_risco;
    let recebe_acao_alteracao_risco = "cadastrar";

    $(document).ready(function(e) {
        debugger;

        $("#mensagem-campo-vazio").hide();

        function buscar_empresas_principais() {
            $.ajax({
                url: "cadastros/processa_empresa_principal.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_empresas_principal"
                },
                success: async function(resposta_empresa_principal) {
                    debugger;

                    try {
                        // Preenche o select
                        let select = $("#empresas");
                        select.empty(); // limpa antes
                        select.append('<option value="selecione">Selecione</option>');

                        resposta_empresa_principal.forEach(function(empresa) {
                            select.append(`<option value="${empresa.id}">${empresa.nome}</option>`);
                        });

                        // Se quiser, continua com sua lógica da tabela
                        console.log(resposta_empresa_principal);

                    } catch (error) {
                        console.error("Erro ao preencher tabela:", error);
                    }

                    // try {
                    //     console.log(resposta_empresa_principal);
                    //     await preencher_tabela(resposta_empresa_principal);
                    //     inicializarDataTable();
                    // } catch (error) {
                    //     console.error("Erro ao preencher tabela:", error);
                    //     $("#empresas_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Erro ao carregar dados</td></tr>");
                    //     inicializarDataTable();
                    // }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        // let recebe_url_atual = window.location.href;

        // let recebe_parametro_acao_risco = new URLSearchParams(recebe_url_atual.split("&")[1]);

        // let recebe_parametro_codigo_risco = new URLSearchParams(recebe_url_atual.split("&")[2]);

        // recebe_codigo_alteracao_risco = recebe_parametro_codigo_risco.get("id");

        // let recebe_acao_risco = recebe_parametro_acao_risco.get("acao");

        // if (recebe_acao_risco !== "" && recebe_acao_risco !== null)
        //     recebe_acao_alteracao_risco = recebe_acao_risco;

        // async function buscar_informacoes_medico() {
        //     debugger;
        //     if (recebe_acao_alteracao_risco === "editar") {
        //         // carrega_cidades();
        //         // await popula_lista_cidade_empresa_alteracao();
        //         await popula_informacoes_medico_alteracao();
        //     } else {
        //         // carrega_cidades();

        //         // let atual = new Date();

        //         // let ano = atual.getFullYear();
        //         // let mes = String(atual.getMonth() + 1).padStart(2, '0');
        //         // let dia = String(atual.getDate()).padStart(2, '0');
        //         // let horas = String(atual.getHours()).padStart(2, '0');
        //         // let minutos = String(atual.getMinutes()).padStart(2, '0');

        //         // // Formato aceito por <input type="datetime-local">
        //         // let data_formatada = `${ano}-${mes}-${dia}T${horas}:${minutos}`;

        //         // console.log("Data formatada para input datetime-local:", data_formatada);
        //         // document.getElementById('created_at').value = data_formatada;
        //     }
        // }

        // buscar_informacoes_medico();

        buscar_empresas_principais();

        // inicializarTabelas();
    });

    let recebe_empresa_selecionada;
    let recebe_id_empresa_principal_selecionada;

    $("#empresas").change(function(e){
        e.preventDefault();

        debugger;

        recebe_empresa_selecionada = $("#empresas option:selected").text();

        recebe_id_empresa_principal_selecionada = this.value;

        buscar_kits();

        // Função para buscar dados da API
        function buscar_kits() {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_geracao_kit": "buscar_todos_kits_empresa_gerenciamento_kits",
                    valor_id_empresa_principal:recebe_id_empresa_principal_selecionada
                },
                success: async function(resposta_kits) {
                    debugger;
                    if (resposta_kits.length > 0) {
                        console.log(resposta_kits);
                        await preencher_tabela(resposta_kits);
                        inicializarDataTable();
                    } else {
                        preencher_tabela(resposta_kits);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }
    });

    // Accordion toggle
    document.querySelectorAll('.accordion-header').forEach(button => {
        button.addEventListener('click', () => {
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', !expanded);

            const content = document.getElementById(button.getAttribute('aria-controls'));
            content.classList.toggle('hidden');
        });
    });



    $("#cancelar-risco").click(function(e) {
        e.preventDefault();

        debugger;

        $("#codigo_risco").val("");
        $("#descricao_risco").val("");
        let select_grupo_risco = document.querySelector(
            "#grupo_risco"
        );
        select_grupo_risco.selectedIndex = 0;
    });

    // Função para preencher a tabela com os dados das clínicas
    async function preencher_tabela(kits) {
        debugger;
        let tbody = document.querySelector("#kits_tabela tbody");
        tbody.innerHTML = ""; // Limpa o conteúdo existente

        if (kits.length > 0) {
            for (let index = 0; index < kits.length; index++) {
                let kit = kits[index];

                // Separar o endereço
                // let partesEndereco = pessoa.endereco.split(',');
                // let ruaNumero = `${partesEndereco[0] || ''}, ${partesEndereco[1] || ''}`;
                // let cidadeEstado = `${(partesEndereco[2] || '').trim()} / ${(partesEndereco[3] || '').trim()}`;

                // Converter data de nascimento para formato brasileiro
                // let data_nascimento_formatado = "";
                // if (pessoa.nascimento) {
                //     let data = new Date(pessoa.nascimento);
                //     data_nascimento_formatado = data.toLocaleDateString("pt-BR");
                // }

                // <a href="#" class="view" title="Visualizar" id='visualizar-informacoes-pessoa' data-codigo-pessoa='${pessoa.id}'>
                //                 <i class="fas fa-eye"></i>
                //             </a>

                window.recebe_codigo_id_empresa_principal = kit.empresa_id_principal;

                window.recebe_dados_empresa_principal_kit = "";

                let row = document.createElement("tr");
                row.innerHTML = `
                        <td style="text-align:center; vertical-align:middle;">${kit.id}</td>
<td style="text-align:center; vertical-align:middle;">${kit.status && kit.status.trim() !== "" ? kit.status : "Não informado"}</td>
<td style="text-align:center; vertical-align:middle;">${kit.tipo_exame && kit.tipo_exame.trim() !== "" ? kit.tipo_exame : "Não informado"}</td>
<td style="text-align:center; vertical-align:middle;">${recebe_empresa_selecionada || "Não informado"}</td>
    <td style="text-align:center; vertical-align:middle;">
        <div class="action-buttons">
            <a href="?pg=geracao_kit&id=${kit.id}&acao=editar" target="_parent" class="edit" title="Editar">
                <i class="fas fa-edit"></i>
            </a>
            <a href="#" id='excluir-kit' data-codigo-kit="${kit.id}" class="delete" title="Apagar">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    </td>
                    `;
                tbody.appendChild(row);
            }
        } else {
            $("#kits_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        }
    }

    let recebe_tabela_kits;

    // Função para inicializar o DataTables
    function inicializarDataTable() {
        recebe_tabela_kits = $('#kits_tabela').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            },
            "dom": 'lrtip' // Remove a barra de pesquisa padrão
        });
    }

    $("#grava-risco").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_codigo_risco = $("#codigo_risco").val();
        let recebe_descricao_risco = $("#descricao_risco").val();
        let recebe_grupo_risco = $("#grupo_risco").val();

        if (recebe_acao_alteracao_risco === "editar") {
            $.ajax({
                url: "cadastros/processa_risco.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_risco: "alterar_risco",
                    valor_codigo_risco: recebe_codigo_risco,
                    valor_descricao_risco: recebe_descricao_risco,
                    valor_grupo_risco: recebe_grupo_risco,
                    valor_id_risco: $("#id_risco_alteracao").val(),
                },
                success: function(retorno_risco) {
                    debugger;

                    console.log(retorno_risco);
                    if (retorno_risco) {
                        console.log("Risco alterada com sucesso");
                        $("#corpo-mensagem-gravacao").html("Risco alterada com sucesso");
                        $("#mensagem-gravacao").removeClass("hidden").addClass("opacity-100");

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("opacity-0");
                        }, 4000);

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("hidden").removeClass("opacity-0 opacity-100");
                        }, 4500);

                        $("#codigo_risco").val("");
                        $("#descricao_risco").val("");
                        let select_grupo_risco = document.querySelector(
                            "#grupo_risco"
                        );
                        select_grupo_risco.selectedIndex = 0;
                        // window.location.href = "painel.php?pg=grava_risco";
                        buscar_grupos_riscos();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao alterar médico:" + error);
                },
            });
        } else {
            $.ajax({
                url: "cadastros/processa_risco.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_risco: "inserir_risco",
                    valor_codigo_risco: recebe_codigo_risco,
                    valor_descricao_risco: recebe_descricao_risco,
                    valor_grupo_risco: recebe_grupo_risco
                },
                success: function(retorno_risco) {
                    debugger;

                    console.log(retorno_risco);

                    if (retorno_risco > 0) {
                        console.log("Risco cadastrada com sucesso");
                        $("#corpo-mensagem-gravacao").html("Risco gravado com sucesso");
                        $("#mensagem-gravacao").removeClass("hidden").addClass("opacity-100");

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("opacity-0");
                        }, 4000);

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("hidden").removeClass("opacity-0 opacity-100");
                        }, 4500);

                        $("#codigo_risco").val("");
                        $("#descricao_risco").val("");
                        let select_grupo_risco = document.querySelector(
                            "#grupo_risco"
                        );
                        select_grupo_risco.selectedIndex = 0;
                        // window.location.href = "painel.php?pg=grava_risco";
                        buscar_grupos_riscos();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        }
    });
</script>