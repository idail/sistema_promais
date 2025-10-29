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

                        <div class="form-group" style="flex:30%;">
                            <label for="grupo_risco">Empresas:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-building"></i>

                                <select id="empresas" name="empresas" class="form-control" style="width: 25%;">
                                    <option value="selecione">Selecione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <table id="empresas_principal_tabela">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Fantasia</th>
                            <th>CNPJ</th>
                            <th>Endereço</th>
                            <th>Cidade/Estado</th>
                            <th>Telefone</th>
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
    #empresas_principal_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #empresas_principal_tabela th,
    #empresas_principal_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #empresas_principal_tabela th {
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

    .accordion-content {
        padding: 10px;
        background-color: #f2f2f2;
        border: 1px solid #ddd;
    }

    #risco_ergonomico {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #risco_ergonomico th,
    #risco_ergonomico td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #risco_ergonomico th {
        background-color: #f2f2f2;
        font-weight: bold;
    }


    #risco_acidente_mecanico {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #risco_acidente_mecanico th,
    #risco_acidente_mecanico td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #risco_acidente_mecanico th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #risco_fisico {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #risco_fisico th,
    #risco_fisico td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #risco_fisico th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #risco_quimico {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #risco_quimico th,
    #risco_quimico td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #risco_quimico th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #risco_biologico {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #risco_biologico th,
    #risco_biologico td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #risco_biologico th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #risco_outros {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #risco_outros th,
    #risco_outros td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #risco_outros th {
        background-color: #f2f2f2;
        font-weight: bold;
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

    #risco_ergonomico {
        width: 100% !important;
    }

    #risco_acidente_mecanico {
        width: 100% !important;
    }

    #risco_fisico {
        width: 100% !important;
    }

    #risco_biologico {
        width: 100% !important;
    }

    #risco_outros {
        width: 100% !important;
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

        buscar_grupos_riscos();

        inicializarTabelas();
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

    // async function popula_informacoes_medico_alteracao() {
    //     return new Promise((resolve, reject) => {
    //         $.ajax({
    //             url: "cadastros/processa_medico.php",
    //             method: "GET",
    //             dataType: "json",
    //             data: {
    //                 "processo_medico": "buscar_informacoes_medico_alteracao",
    //                 valor_codigo_medico_alteracao: recebe_codigo_alteracao_risco,
    //             },
    //             success: function(resposta_medico) {
    //                 debugger;
    //                 console.log(resposta_medico);

    //                 if (resposta_medico.length > 0) {
    //                     for (let indice = 0; indice < resposta_medico.length; indice++) {
    //                         $("#created_at").val(resposta_medico[indice].created_at);
    //                         $("#medico_id_alteracao").val(resposta_medico[indice].id);
    //                         $("#nome").val(resposta_medico[indice].nome);
    //                         $("#cpf").val(resposta_medico[indice].cpf);
    //                         $("#crm").val(resposta_medico[indice].crm);
    //                         $("#uf_crm").val(resposta_medico[indice].uf_crm);
    //                         $("#especialidade").val(resposta_medico[indice].especialidade);
    //                         $("#rqe").val(resposta_medico[indice].rqe);
    //                         $("#uf_rqe").val(resposta_medico[indice].uf_rqe);
    //                         $("#nascimento").val(resposta_medico[indice].nascimento);
    //                         $("#sexo-medico").val(resposta_medico[indice].sexo);
    //                         $("#contato").val(resposta_medico[indice].contato);
    //                     }
    //                 }

    //                 resolve(); // sinaliza que terminou
    //             },
    //             error: function(xhr, status, error) {
    //                 console.log("Falha ao buscar médicos:" + error);
    //                 reject(error);
    //             },
    //         });
    //     });
    // }

    function buscar_grupos_riscos(e) {
        debugger;

        $.ajax({
            url: "cadastros/processa_risco.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_risco": "buscar_riscos_ergonomico",
            },
            success: function(resposta_risco) {
                debugger;
                console.log(resposta_risco);

                if ($.fn.dataTable.isDataTable('#risco_ergonomico')) {
                    $('#risco_ergonomico').DataTable().clear().destroy();
                }

                // Limpa o tbody manualmente (opcional, mas recomendado)
                $("#risco_ergonomico tbody").empty();

                let corpo = document.querySelector("#risco_ergonomico tbody");
                corpo.innerHTML = "";

                if (resposta_risco.length > 0) {
                    // $("#risco_ergonomico tbody").html("");
                    for (let index = 0; index < resposta_risco.length; index++) {
                        let risco = resposta_risco[index];
                        let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

                        let linha = document.createElement("tr");
                        linha.innerHTML = `
                    <td>${risco.id}</td>
                    <td>${risco.codigo}</td>
                    <td>${risco.descricao_grupo_risco}</td>
                    <td>${resultado}</td>
                    <td>
                        <div class='action-buttons'>
                            <a href='#' id='alterar-risco' data-id-risco="${risco.id}" data-codigo-risco="${risco.codigo}"
                            data-descricao-risco="${risco.descricao_grupo_risco}" data-grupo-risco="${risco.grupo_risco}" title='Editar'><i class="fas fa-edit"></i></a>
                            <a href='#' id='excluir-risco' data-id-risco="${risco.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                        </div>
                    </td>`;
                        corpo.appendChild(linha);
                    }
                } else {
                    $("#risco_ergonomico tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
                }

                // 🧹 Destrói o DataTable antigo antes de recriar
                if ($.fn.dataTable.isDataTable('#risco_ergonomico')) {
                    $('#risco_ergonomico').DataTable().destroy();
                }

                $("#risco_ergonomico").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                    },
                    "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                    "pageLength": 5, // Exibir 5 registros por página
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Todos"]
                    ]
                });


            },
            error: function(xhr, status, error) {
                console.error("Erro ao carregar dados:", error);
            },
        });


        $.ajax({
            url: "cadastros/processa_risco.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_risco": "buscar_riscos_acidente_mecanico",
            },
            success: function(resposta_risco) {
                debugger;

                console.log(resposta_risco);

                if ($.fn.dataTable.isDataTable('#risco_acidente_mecanico')) {
                    $('#risco_acidente_mecanico').DataTable().clear().destroy();
                }

                // Limpa o tbody manualmente (opcional, mas recomendado)
                $("#risco_acidente_mecanico tbody").empty();

                let corpo = document.querySelector("#risco_acidente_mecanico tbody");
                corpo.innerHTML = "";

                if (resposta_risco.length > 0) {
                    // let corpo = document.querySelector("#risco_acidente_mecanico tbody");
                    // corpo.innerHTML = "";
                    for (let index = 0; index < resposta_risco.length; index++) {
                        let risco = resposta_risco[index];

                        // let resultado;

                        // if (risco.grupo_risco.includes("_")) {
                        //     resultado = risco.grupo_risco
                        //         .replace(/_/g, " ")
                        //         .split(" ")
                        //         .map(palavra => palavra.charAt(0).toUpperCase() + palavra.slice(1).toLowerCase())
                        //         .join(" ");
                        // } else {
                        //     resultado = risco.grupo_risco.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
                        // }

                        let resultado;

                        if (risco.grupo_risco !== "") {
                            resultado = "Acidente Mecânico";
                        }

                        let linha = document.createElement("tr");
                        linha.innerHTML =
                            `<td>${risco.id}</td>
                        <td>${risco.codigo}</td>
                        <td>${risco.descricao_grupo_risco}</td>
                        <td>${resultado}</td>
                        <td>
                        <div class='action-buttons'>
                        <a href='#' id='alterar-risco' data-id-risco="${risco.id}" data-codigo-risco="${risco.codigo}"
                        data-descricao-risco="${risco.descricao_grupo_risco}" data-grupo-risco="${risco.grupo_risco}" title='Editar'><i class="fas fa-edit"></i></a>
                        <a href='#' id='excluir-risco' data-id-risco="${risco.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                        </div>
                        </td>`;
                        corpo.appendChild(linha);
                    }
                } else {
                    $("#risco_acidente_mecanico tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
                }

                // 🧹 Destrói o DataTable antigo antes de recriar
                if ($.fn.dataTable.isDataTable('#risco_acidente_mecanico')) {
                    $('#risco_acidente_mecanico').DataTable().destroy();
                }

                // // 🎛️ Inicializa o DataTable com a paginação e idioma corretos
                // $("#risco_acidente_mecanico").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": 'lfrtip', // Exibe o filtro, paginação, etc.
                //     "pageLength": 10, // Quantos registros por página
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ] // Opções do select
                // });

                // $("#risco_acidente_mecanico").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                //     "pageLength": 10,
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ]
                // });

                $("#risco_acidente_mecanico").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                    },
                    "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                    "pageLength": 5, // Exibir 5 registros por página
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Todos"]
                    ]
                });

                // section1
            },
            error: function(xhr, status, error) {

            },
        });

        $.ajax({
            url: "cadastros/processa_risco.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_risco": "buscar_riscos_quimico",
            },
            success: function(resposta_risco) {
                debugger;

                console.log(resposta_risco);

                if ($.fn.dataTable.isDataTable('#risco_quimico')) {
                    $('#risco_quimico').DataTable().clear().destroy();
                }

                // Limpa o tbody manualmente (opcional, mas recomendado)
                $("#risco_quimico tbody").empty();

                let corpo = document.querySelector("#risco_quimico tbody");
                corpo.innerHTML = "";

                if (resposta_risco.length > 0) {
                    // let corpo = document.querySelector("#risco_quimico tbody");
                    // corpo.innerHTML = "";
                    for (let index = 0; index < resposta_risco.length; index++) {
                        let risco = resposta_risco[index];

                        let resultado;
                        if (risco.grupo_risco !== "") {
                            resultado = "Químico";
                        }

                        let linha = document.createElement("tr");
                        linha.innerHTML =
                            `<td>${risco.id}</td>
                        <td>${risco.codigo}</td>
                        <td>${risco.descricao_grupo_risco}</td>
                        <td>${resultado}</td>
                        <td>
                        <div class='action-buttons'>
                        <a href='#' id='alterar-risco' data-id-risco="${risco.id}" data-codigo-risco="${risco.codigo}"
                        data-descricao-risco="${risco.descricao_grupo_risco}" data-grupo-risco="${risco.grupo_risco}" title='Editar'><i class="fas fa-edit"></i></a>
                        <a href='#' id='excluir-risco' data-id-risco="${risco.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                        </div>
                        </td>`;
                        corpo.appendChild(linha);
                    }
                } else {
                    $("#risco_quimico tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
                }

                // 🧹 Destrói o DataTable antigo antes de recriar
                if ($.fn.dataTable.isDataTable('#risco_quimico')) {
                    $('#risco_quimico').DataTable().destroy();
                }

                // 🎛️ Inicializa o DataTable com a paginação e idioma corretos
                // $("#risco_quimico").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": 'lfrtip', // Exibe o filtro, paginação, etc.
                //     "pageLength": 10, // Quantos registros por página
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ] // Opções do select
                // });

                // $("#risco_quimico").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                //     "pageLength": 10,
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ]
                // });

                $("#risco_quimico").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                    },
                    "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                    "pageLength": 5, // Exibir 5 registros por página
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Todos"]
                    ]
                });

                // section1
            },
            error: function(xhr, status, error) {

            },
        });

        $.ajax({
            url: "cadastros/processa_risco.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_risco": "buscar_riscos_fisicos",
            },
            success: function(resposta_risco) {
                debugger;

                console.log(resposta_risco);

                if ($.fn.dataTable.isDataTable('#risco_fisico')) {
                    $('#risco_fisico').DataTable().clear().destroy();
                }

                // Limpa o tbody manualmente (opcional, mas recomendado)
                $("#risco_fisico tbody").empty();

                let corpo = document.querySelector("#risco_fisico tbody");
                corpo.innerHTML = "";

                if (resposta_risco.length > 0) {
                    // let corpo = document.querySelector("#risco_fisico tbody");
                    // corpo.innerHTML = "";
                    for (let index = 0; index < resposta_risco.length; index++) {
                        let risco = resposta_risco[index];

                        let resultado;
                        if (risco.grupo_risco !== "") {
                            resultado = "Físico";
                        }

                        let linha = document.createElement("tr");
                        linha.innerHTML =
                            `<td>${risco.id}</td>
                        <td>${risco.codigo}</td>
                        <td>${risco.descricao_grupo_risco}</td>
                        <td>${resultado}</td>
                        <td>
                        <div class='action-buttons'>
                        <a href='#' id='alterar-risco' data-id-risco="${risco.id}" data-codigo-risco="${risco.codigo}"
                        data-descricao-risco="${risco.descricao_grupo_risco}" data-grupo-risco="${risco.grupo_risco}" title='Editar'><i class="fas fa-edit"></i></a>
                        <a href='#' id='excluir-risco' data-id-risco="${risco.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                        </div>
                        </td>`;
                        corpo.appendChild(linha);
                    }
                } else {
                    $("#risco_fisico tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
                }

                // 🧹 Destrói o DataTable antigo antes de recriar
                if ($.fn.dataTable.isDataTable('#risco_fisico')) {
                    $('#risco_fisico').DataTable().destroy();
                }

                // 🎛️ Inicializa o DataTable com a paginação e idioma corretos
                // $("#risco_fisico").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": 'lfrtip', // Exibe o filtro, paginação, etc.
                //     "pageLength": 10, // Quantos registros por página
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ] // Opções do select
                // });

                // $("#risco_fisico").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                //     "pageLength": 10,
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ]
                // });

                $("#risco_fisico").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                    },
                    "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                    "pageLength": 5, // Exibir 5 registros por página
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Todos"]
                    ]
                });

                // section1
            },
            error: function(xhr, status, error) {

            },
        });


        $.ajax({
            url: "cadastros/processa_risco.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_risco": "buscar_riscos_biologico",
            },
            success: function(resposta_risco) {
                debugger;

                console.log(resposta_risco);

                if ($.fn.dataTable.isDataTable('#risco_biologico')) {
                    $('#risco_biologico').DataTable().clear().destroy();
                }

                // Limpa o tbody manualmente (opcional, mas recomendado)
                $("#risco_biologico tbody").empty();

                let corpo = document.querySelector("#risco_biologico tbody");
                corpo.innerHTML = "";

                if (resposta_risco.length > 0) {
                    // let corpo = document.querySelector("#risco_biologico tbody");
                    // corpo.innerHTML = "";
                    for (let index = 0; index < resposta_risco.length; index++) {
                        let risco = resposta_risco[index];

                        let resultado;
                        if (risco.grupo_risco !== "") {
                            resultado = "Biológico";
                        }

                        let linha = document.createElement("tr");
                        linha.innerHTML =
                            `<td>${risco.id}</td>
                        <td>${risco.codigo}</td>
                        <td>${risco.descricao_grupo_risco}</td>
                        <td>${resultado}</td>
                        <td>
                        <div class='action-buttons'>
                        <a href='#' id='alterar-risco' data-id-risco="${risco.id}" data-codigo-risco="${risco.codigo}"
                        data-descricao-risco="${risco.descricao_grupo_risco}" data-grupo-risco="${risco.grupo_risco}" title='Editar'><i class="fas fa-edit"></i></a>
                        <a href='#' id='excluir-risco' data-id-risco="${risco.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                        </div>
                        </td>`;
                        corpo.appendChild(linha);
                    }
                } else {
                    $("#risco_biologico tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
                }

                // 🧹 Destrói o DataTable antigo antes de recriar
                if ($.fn.dataTable.isDataTable('#risco_biologico')) {
                    $('#risco_biologico').DataTable().destroy();
                }

                // 🎛️ Inicializa o DataTable com a paginação e idioma corretos
                // $("#risco_biologico").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": 'lfrtip', // Exibe o filtro, paginação, etc.
                //     "pageLength": 10, // Quantos registros por página
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ] // Opções do select
                // });

                // $("#risco_biologico").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                //     "pageLength": 10,
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ]
                // });

                $("#risco_biologico").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                    },
                    "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                    "pageLength": 5, // Exibir 5 registros por página
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Todos"]
                    ]
                });

                // section1
            },
            error: function(xhr, status, error) {

            },
        });

        $.ajax({
            url: "cadastros/processa_risco.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_risco": "buscar_riscos_outros",
            },
            success: function(resposta_risco) {
                debugger;

                console.log(resposta_risco);

                if ($.fn.dataTable.isDataTable('#risco_outros')) {
                    $('#risco_outros').DataTable().clear().destroy();
                }

                // Limpa o tbody manualmente (opcional, mas recomendado)
                $("#risco_outros tbody").empty();

                let corpo = document.querySelector("#risco_outros tbody");
                corpo.innerHTML = "";

                if (resposta_risco.length > 0) {
                    // let corpo = document.querySelector("#risco_outros tbody");
                    // corpo.innerHTML = "";
                    for (let index = 0; index < resposta_risco.length; index++) {
                        let risco = resposta_risco[index];

                        let resultado;
                        if (risco.grupo_risco !== "") {
                            resultado = "Outros";
                        }

                        let linha = document.createElement("tr");
                        linha.innerHTML =
                            `<td>${risco.id}</td>
                        <td>${risco.codigo}</td>
                        <td>${risco.descricao_grupo_risco}</td>
                        <td>${resultado}</td>
                        <td>
                        <div class='action-buttons'>
                        <a href='#' id='alterar-risco' data-id-risco="${risco.id}" data-codigo-risco="${risco.codigo}"
                        data-descricao-risco="${risco.descricao_grupo_risco}" data-grupo-risco="${risco.grupo_risco}" title='Editar'><i class="fas fa-edit"></i></a>
                        <a href='#' id='excluir-risco' data-id-risco="${risco.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                        </div>
                        </td>`;
                        corpo.appendChild(linha);
                    }
                } else {
                    $("#risco_outros tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
                }

                // 🧹 Destrói o DataTable antigo antes de recriar
                if ($.fn.dataTable.isDataTable('#risco_outros')) {
                    $('#risco_outros').DataTable().destroy();
                }

                // 🎛️ Inicializa o DataTable com a paginação e idioma corretos
                // $("#risco_outros").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": 'lfrtip', // Exibe o filtro, paginação, etc.
                //     "pageLength": 10, // Quantos registros por página
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ] // Opções do select
                // });

                // $("#risco_outros").DataTable({
                //     "language": {
                //         "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                //     },
                //     "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                //     "pageLength": 10,
                //     "lengthMenu": [
                //         [10, 25, 50, -1],
                //         [10, 25, 50, "Todos"]
                //     ]
                // });

                $("#risco_outros").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                    },
                    "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                    "pageLength": 5, // Exibir 5 registros por página
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Todos"]
                    ]
                });

                // section1
            },
            error: function(xhr, status, error) {

            },
        });

        $(document).on("click", "#alterar-risco", function(e) {
            e.preventDefault();

            debugger;

            let recebe_id_risco = $(this).data("id-risco");
            let recebe_codigo_risco = $(this).data("codigo-risco");
            let recebe_descricao_risco = $(this).data("descricao-risco");
            let recebe_grupo_risco = $(this).data("grupo-risco");

            $("#id_risco_alteracao").val(recebe_id_risco);
            $("#codigo_risco").val(recebe_codigo_risco);
            $("#descricao_risco").val(recebe_descricao_risco);
            $("#grupo_risco").val(recebe_grupo_risco);

            // $('button[name="grava_risco"]').attr('id', 'altera-risco');
            recebe_acao_alteracao_risco = "editar";
        });
    }

    $(document).on("click", "#excluir-risco", function(e) {
        e.preventDefault();

        debugger;

        let recebe_confirmar_exclusao_risco = window.confirm("Tem certeza que deseja excluir o risco?");

        if (recebe_confirmar_exclusao_risco) {
            let recebe_id_risco = $(this).data("id-risco");
            $.ajax({
                url: "cadastros/processa_risco.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_risco: "excluir_risco",
                    valor_id_risco: recebe_id_risco,
                },
                success: function(retorno_risco) {
                    debugger;
                    console.log(retorno_risco);
                    if (retorno_risco) {
                        // window.location.href = "painel.php?pg=grava_risco";
                        buscar_grupos_riscos();
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