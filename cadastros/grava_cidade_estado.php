<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/heroicons@2.0.16/20/solid/index.js"></script>
<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <input type="hidden" name="cidade_estado_id_alteracao" id="cidade_estado_id_alteracao">

            <!-- <div class="form-group">
                <label for="created_at">Data de Cadastro:</label>
                <div class="input-with-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="datetime-local" id="created_at" name="created_at" class="form-control" readonly>
                </div>
            </div> -->
            <div class="p-6 max-w-6xl mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold">Estados e Cidades</h2>
                    <button type="button" onclick="abrirModalEstado()" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-2xl hover:bg-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Estado
                    </button>

                </div>

                <!-- Grid com colunas -->
                <div id="listaEstados" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
            </div>

            <!-- Modal de Estado -->
            <div id="modalEstado" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl p-6 w-96 space-y-4">
                    <h3 class="text-lg font-medium">Novo Estado</h3>
                    <input id="inputEstadoNome" class="w-full border border-gray-300 p-2 rounded-xl focus:outline-none focus:ring" placeholder="Nome do Estado">
                    <input id="inputEstadoUF" maxlength="2" class="w-full border border-gray-300 p-2 rounded-xl focus:outline-none focus:ring" placeholder="UF (ex: SP)">
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="fecharModalEstado()" class="text-gray-500 hover:underline">Cancelar</button>
                        <button type="button" onclick="salvarEstado()" class="bg-green-600 text-white px-4 py-2 rounded-xl">Salvar</button>
                    </div>
                </div>
            </div>

            <!-- Modal de Cidade -->
            <div id="modalCidade" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl p-6 w-96 space-y-4">
                    <h3 class="text-lg font-medium">Nova Cidade</h3>
                    <input id="inputCidadeNome" class="w-full border border-gray-300 p-2 rounded-xl focus:outline-none focus:ring" placeholder="Nome da Cidade">
                    <input id="inputCidadeCEP" class="w-full border border-gray-300 p-2 rounded-xl focus:outline-none focus:ring" placeholder="CEP">
                    <input type="hidden" id="cidadeEstadoId">
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="fecharModalCidade()" class="text-gray-500 hover:underline">Cancelar</button>
                        <button type="button" onclick="salvarCidade()" class="bg-green-600 text-white px-4 py-2 rounded-xl">Salvar</button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<script>
    let recebe_acao_alteracao_cidade_estado = "cadastrar";

    let estadoAbertoId = null; // ← apenas um estado pode estar aberto

    $(document).ready(function(e) {
        async function buscar_informacoes_cidades_estados() {
            await renderEstados();
        }

        buscar_informacoes_cidades_estados();
    });

    // document.querySelectorAll('.accordion-header').forEach(button => {
    //     button.addEventListener('click', () => {
    //         const expanded = button.getAttribute('aria-expanded') === 'true';
    //         button.setAttribute('aria-expanded', !expanded);

    //         const content = document.getElementById(button.getAttribute('aria-controls'));
    //         content.classList.toggle('hidden');
    //     });
    // });

    let estados = [];

    function abrirModalEstado() {
        document.getElementById('modalEstado').classList.remove('hidden');
    }

    function fecharModalEstado() {
        document.getElementById('modalEstado').classList.add('hidden');
        document.getElementById('inputEstadoNome').value = '';
        document.getElementById('inputEstadoUF').value = '';
    }

    let recebe_id_estado_gravado;

    function salvarEstado() {
        debugger;
        const nome = document.getElementById('inputEstadoNome').value.trim();
        const uf = document.getElementById('inputEstadoUF').value.trim().toUpperCase();
        if (!nome || !uf) return alert("Preencha todos os campos.");

        $.ajax({
            url: "cadastros/processa_cidade_estado.php",
            type: "POST",
            dataType: "json",
            data: {
                processo_cidade_estado: "inserir_estado",
                valor_nome_estado: nome,
                valor_uf_estado: uf,
            },
            success: async function(retorno_cidade_estado) {
                debugger;

                console.log(retorno_cidade_estado);

                if (retorno_cidade_estado > 0) {
                    console.log("Cidade cadastrada com sucesso");

                    // $("#corpo-mensagem-gravacao").html("Cidade gravada com sucesso");
                    // $("#mensagem-gravacao").removeClass("hidden").addClass("opacity-100");

                    // setTimeout(() => {
                    //     $("#mensagem-gravacao").addClass("opacity-0");
                    // }, 4000);

                    // setTimeout(() => {
                    //     $("#mensagem-gravacao").addClass("hidden").removeClass("opacity-0 opacity-100");
                    // }, 4500);

                    // $("#cidade").val("");
                    // $("#cep").val("");
                    // $("#estado").val("");
                    // $("#uf").val("");
                    // // window.location.href = "painel.php?pg=grava_risco";
                    // await todas_cidades_estados();



                    // let novoEstado = {
                    //     id: retorno_cidade_estado,
                    //     nome,
                    //     uf,
                    //     cidades: [],
                    //     aberto: false
                    // };

                    // estados.push(novoEstado);

                    const novoEstado = {
                        id: parseInt(retorno_cidade_estado),
                        nome,
                        uf,
                        cidades: [],
                        aberto: false
                    };
                    estados.push(novoEstado);

                    recebe_id_estado_gravado = retorno_cidade_estado;

                    fecharModalEstado();
                    renderEstados();

                }

                // const novoEstado = {
                //     id: Date.now(),
                //     nome,
                //     uf,
                //     cidades: [],
                //     aberto: false
                // };
                // estados.push(novoEstado);

                // fecharModalEstado();
                // renderEstados();
            },
            error: function(xhr, status, error) {
                console.log("Falha ao inserir empresa:" + error);
            },
        });

        // const novoEstado = {
        //     id: Date.now(),
        //     nome,
        //     uf,
        //     cidades: [],
        //     aberto: false
        // };
        // estados.push(novoEstado);
        // fecharModalEstado();
        // renderEstados();
    }

    function abrirModalCidade(estadoId) {
        debugger;
        document.getElementById('cidadeEstadoId').value = estadoId;
        document.getElementById('modalCidade').classList.remove('hidden');
    }

    function fecharModalCidade() {
        document.getElementById('modalCidade').classList.add('hidden');
        document.getElementById('inputCidadeNome').value = '';
    }

    function salvarCidade() {
        debugger;
        const nome = document.getElementById('inputCidadeNome').value.trim();
        const estadoId = parseInt(document.getElementById('cidadeEstadoId').value);
        if (!nome) return alert("Informe o nome da cidade.");

        const estado = estados.find(e => e.id === estadoId);
        if (estado) {
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cidade_estado: "inserir_cidade",
                    valor_nome_cidade: nome,
                    valor_cep_cidade: estado.uf, // ← uf vem do estado atual
                    valor_id_estado: estado.id,
                },
                success: async function(retorno_cidade_estado) {
                    if (retorno_cidade_estado > 0) {
                        estado.cidades.push({
                            id: parseInt(retorno_cidade_estado),
                            nome
                        });
                        fecharModalCidade();
                        renderEstados(); // Atualiza a interface com a nova cidade
                    }
                },
                error: function(xhr, status, error) {
                    alert("Erro ao salvar cidade.");
                },
            });
        }
    }

    // let estadosAbertos = new Set();

    function toggleCollapse(id) {
        if (estadoAbertoId === id) {
            estadoAbertoId = null;
        } else {
            estadoAbertoId = id;
        }
        renderEstados();
    }

    async function renderEstados() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidades_estados"
                },
                success: function(resposta_cidade_estado) {
                    debugger;
                    const container = document.getElementById('listaEstados');
                    container.innerHTML = '';

                    const agrupados = {};

                    resposta_cidade_estado.forEach(item => {
                        const estadoId = item.estado_id;

                        if (!agrupados[estadoId]) {
                            agrupados[estadoId] = {
                                id: estadoId,
                                nome: item.estado_nome,
                                uf: item.uf,
                                aberto: estadoAbertoId === estadoId,
                                cidades: []
                            };
                        }

                        if (item.cidade_id && item.cidade_nome) {
                            agrupados[estadoId].cidades.push({
                                id: item.cidade_id,
                                nome: item.cidade_nome
                            });
                        }
                    });

                    estados = Object.values(agrupados);

                    estados.forEach(estado => {
                        const div = document.createElement('div');
                        div.className = 'bg-white rounded-2xl p-4 mb-2 shadow';

                        div.innerHTML = `
                        <div class="flex justify-between items-center cursor-pointer" onclick="toggleCollapse(${estado.id})">
                            <div class="text-lg font-medium">
                                ${estado.nome} <span class="text-gray-400 text-sm">(${estado.uf})</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform duration-300 ${estado.aberto ? 'rotate-90' : 'rotate-0'}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 6L14 10L6 14V6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="mt-3 ${estado.aberto ? '' : 'hidden'}">
                            <ul class="list-disc ml-5 text-sm text-gray-700 space-y-1">
                                ${estado.cidades.length ? estado.cidades.map(c => `<li>${c.nome}</li>`).join('') : '<li class="text-gray-400">Nenhuma cidade</li>'}
                            </ul>
                            <button type="button" onclick="abrirModalCidade(${estado.id})" class="mt-3 inline-flex items-center gap-1 text-blue-600 text-sm hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg> Adicionar Cidade
                            </button>
                        </div>
                    `;
                        container.appendChild(div);
                    });

                    resolve();
                },
                error: function() {
                    alert("Erro ao carregar os dados dos estados e cidades.");
                    reject();
                }
            });
        });
    }




    $(document).on("click", "#alterar-cidade-estado", function(e) {
        e.preventDefault();

        debugger;

        let recebe_cidade_estado_id = $(this).data("id-cidade-estado");
        let recebe_cidade = $(this).data("cidade");
        let recebe_cep = $(this).data("cep");
        let recebe_estado = $(this).data("estado");
        let recebe_estado_uf = $(this).data("estado-uf");

        $("#cidade_estado_id_alteracao").val(recebe_cidade_estado_id);
        $("#cidade").val(recebe_cidade);
        $("#cep").val(recebe_cep);
        $("#estado").val(recebe_estado);
        $("#uf").val(recebe_estado_uf);

        recebe_acao_alteracao_cidade_estado = "editar";
    });

    $(document).on("click", "#excluir-cidade-estado", function(e) {
        debugger;

        let recebe_confirmar_exclusao_cidade_estado = window.confirm("Tem certeza que deseja excluir cidade?");

        if (recebe_confirmar_exclusao_cidade_estado) {
            let recebe_id_cidade_estado = $(this).data("id-cidade-estado");
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cidade_estado: "excluir_cidade_estado",
                    valor_id_cidade_estado: recebe_id_cidade_estado,
                },
                success: async function(retorno_cidade) {
                    debugger;
                    console.log(retorno_cidade);
                    if (retorno_cidade) {
                        // window.location.href = "painel.php?pg=grava_risco";
                        await todas_cidades_estados();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao excluir pessoa:" + error);
                },
            });
        } else {
            return;
        }
    });

    $("#grava-cidade-estado").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_cidade = $("#cidade").val();
        let recebe_cep = $("#cep").val();
        let recebe_estado = $("#estado").val();
        let recebe_uf = $("#uf").val();
        // let recebe_id_cidade_estado = $("#cidade_estado_id_alteracao").val();

        if (recebe_acao_alteracao_cidade_estado === "editar") {
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cidade_estado: "alterar_cidade_estado",
                    valor_cidade: recebe_cidade,
                    valor_cep: recebe_cep,
                    valor_estado: recebe_estado,
                    valor_uf: recebe_uf,
                    valor_id_cidade_estado: $("#cidade_estado_id_alteracao").val()
                },
                success: async function(retorno_cidade_estado) {
                    debugger;

                    console.log(retorno_cidade_estado);
                    if (retorno_cidade_estado) {
                        console.log("Cidade alterada com sucesso");
                        $("#corpo-mensagem-gravacao").html("Cidade alterada com sucesso");
                        $("#mensagem-gravacao").removeClass("hidden").addClass("opacity-100");

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("opacity-0");
                        }, 4000);

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("hidden").removeClass("opacity-0 opacity-100");
                        }, 4500);

                        $("#cidade").val("");
                        $("#cep").val("");
                        $("#estado").val("");
                        $("#uf").val("");
                        // window.location.href = "painel.php?pg=grava_risco";
                        await todas_cidades_estados();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao alterar médico:" + error);
                },
            });
        } else {

        }
    });
</script>

<style>
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

    .accordion-content {
        padding: 10px;
        background-color: #f2f2f2;
        border: 1px solid #ddd;
    }

    .accordion-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-arrow {
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .accordion-header[aria-expanded="true"] .accordion-arrow {
        transform: rotate(180deg);
    }

    /* Alinhar seletor e busca à direita */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        margin-left: 10px;
    }

    /* Alinhar paginação à direita */
    .dataTables_wrapper .dataTables_paginate {
        float: right;
        text-align: right;
        margin-top: 10px;
    }

    /* Estilizar o número da página atual */
    .dataTables_wrapper .dataTables_paginate .current {
        background-color: #3b3b3b;
        color: white;
        border-radius: 4px;
        padding: 5px 10px;
        margin: 0 2px;
    }

    /* Força o alinhamento horizontal entre a info e os botões */
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        display: inline-block;
        vertical-align: middle;
        margin: 0;
        padding: 8px 0;
        /* Ajuste a altura aqui */
    }

    /* Para o container geral da parte inferior do DataTable */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        box-sizing: border-box;
    }

    /* Garante que tudo fique dentro do container da tabela */
    .dataTables_wrapper .dataTables_paginate {
        text-align: right;
        float: right;
    }

    .dataTables_wrapper .dataTables_info {
        float: left;
    }

    /* Limpa margens extras do paginador */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0;
        padding: 4px 8px;
        line-height: 1.5;
        vertical-align: middle;
    }

    /* Ajuste para o layout responsivo da section */
    .dataTables_wrapper .row:last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dataTables_empty {
        text-align: center !important;
    }


    /* .accordion-content {
        min-height: 150px;
        /* ou outro valor */
</style>

<!-- Heroicons Symbols -->
<svg style="display:none">
    <symbol id="plus" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 4v16m8-8H4" />
    </symbol>
    <symbol id="chevron-right" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 5l7 7-7 7" />
    </symbol>
</svg>