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

            <div class="form-columns">
                <div class="form-column">


                    <div class="address-container">

                        <div class="form-group" style="flex: 30%;">
                            <label for="cidade">Cidade:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-city"></i>

                                <input type="text" id="cidade" name="cidade" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 30%;">
                            <label for="cep">CEP:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope-open-text"></i>
                                <!-- <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)"> -->
                                <input type="text" id="cep" name="cep" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 30%;">
                            <label for="estado">Estado:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-city"></i>

                                <input type="text" id="estado" name="estado" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 30%;">
                            <label for="uf">UF:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marked-alt"></i>
                                <!-- <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)"> -->
                                <input type="text" id="uf" name="uf" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-sm text-red-600 mt-3" id="mensagem-campo-vazio">
                <span id="corpo-mensagem-campo-vazio"></span>
            </div>

            <input type="hidden" name="id_risco_alteracao" id="id_risco_alteracao">

            <button type="button" class="btn btn-primary" name="grava_risco" id="grava-cidade-estado">Salvar</button>
            <button type="button" id="retornar-listagem-medicos" class="botao-cinza">Cancelar</button>
        </form>

        <div class="form-columns">

            <div class="accordion" id="accordion-registros-mt">

                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="section1" id="accordion1">
                        Mato Grosso
                        <span class="accordion-arrow">▼</span>
                    </button>
                    <div class="accordion-content hidden" id="section1" role="region" aria-labelledby="accordion1" style="height: 35%;">
                        <div>
                            <table id="registros_mt">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cidade</th>
                                        <th>CEP</th>
                                        <th>Estado</th>
                                        <th>UF</th>
                                        <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dados serão preenchidos via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-ms">
                <button class="accordion-header" aria-expanded="false" aria-controls="section2" id="accordion1">
                    Mato Grosso do Sul
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section2" role="region" aria-labelledby="accordion1" style="height: 35%;">
                    <div>
                        <table id="registros_ms">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-bh">
                <button class="accordion-header" aria-expanded="false" aria-controls="section3" id="accordion1">
                    Bahia
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section3" role="region" aria-labelledby="accordion1" style="height: 35%;">
                    <div>
                        <table id="registros_bh">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section4" id="accordion1">
                    Minas Gerais
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section4" role="region" aria-labelledby="accordion1" style="height: 35%;">
                    <div>
                        <table id="registros_mg">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section5" id="accordion1">
                    São Paulo
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section5" role="region" aria-labelledby="accordion1" style="height: 35%;">
                    <div>
                        <table id="registros_sp">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

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

    #registros_mt {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_mt th,
    #registros_mt td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_mt th {
        background-color: #f2f2f2;
        font-weight: bold;
    }


    #registros_ms {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_ms th,
    #registros_ms td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_ms th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_bh {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_bh th,
    #registros_bh td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_bh th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_mg {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_mg th,
    #registros_mg td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_mg th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_sp {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_sp th,
    #registros_sp td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_sp th {
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

    #registros_mt {
        width: 100% !important;
    }

    #registros_ms {
        width: 100% !important;
    }

    #registros_mg {
        width: 100% !important;
    }

    #registros_bh {
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
    let recebe_acao_alteracao_cidade_estado = "cadastrar";

    $(document).ready(function(e) {
        buscar_cidades_estados();
    });

    document.querySelectorAll('.accordion-header').forEach(button => {
        button.addEventListener('click', () => {
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', !expanded);

            const content = document.getElementById(button.getAttribute('aria-controls'));
            content.classList.toggle('hidden');
        });
    });

    function buscar_cidades_estados() {
        debugger;

        $.ajax({
            url: "cadastros/processa_cidade_estado.php",
            method: "GET",
            dataType: "json",
            data: {
                "processa_cidade_estado": "buscar_cidade_estado_mt",
            },
            success: function(resposta_cidade_estado) {
                debugger;
                console.log(resposta_cidade_estado);

                if ($.fn.dataTable.isDataTable('#registros_mt')) {
                    $('#registros_mt').DataTable().clear().destroy();
                }

                // Limpa o tbody manualmente (opcional, mas recomendado)
                $("#registros_mt tbody").empty();

                let corpo = document.querySelector("#registros_mt tbody");
                corpo.innerHTML = "";

                if (resposta_cidade_estado.length > 0) {
                    // $("#risco_ergonomico tbody").html("");
                    for (let index = 0; index < resposta_cidade_estado.length; index++) {
                        let cidade_estado = resposta_cidade_estado[index];
                        // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

                        let linha = document.createElement("tr");
                        linha.innerHTML = `
                    <td>${cidade_estado.id}</td>
                    <td>${cidade_estado.nome}</td>
                    <td>${cidade_estado.cep}</td>
                    <td>${cidade_estado.estado}</td>
                    <td>${cidade_estado.uf}</td>
                    <td>
                        <div class='action-buttons'>
                            <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
                            data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
                            <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                        </div>
                    </td>`;
                        corpo.appendChild(linha);
                    }
                } else {
                    $("#registros_mt tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
                }

                // 🧹 Destrói o DataTable antigo antes de recriar
                if ($.fn.dataTable.isDataTable('#registros_mt')) {
                    $('#registros_mt').DataTable().destroy();
                }

                $("#registros_mt").DataTable({
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

    $(document).on("click","#excluir-cidade-estado", function(e) {
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
                success: function(retorno_cidade) {
                    debugger;
                    console.log(retorno_cidade);
                    if (retorno_cidade) {
                        // window.location.href = "painel.php?pg=grava_risco";
                        buscar_cidades_estados();
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
                success: function(retorno_cidade_estado) {
                    debugger;

                    console.log(retorno_cidade_estado);
                    if (retorno_cidade_estado) {
                        console.log("Cidade alterada com sucesso");
                        // window.location.href = "painel.php?pg=grava_risco";
                        buscar_cidades_estados();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao alterar médico:" + error);
                },
            });
        } else {
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cidade_estado: "inserir_cidade_estado",
                    valor_cidade: recebe_cidade,
                    valor_cep: recebe_cep,
                    valor_estado: recebe_estado,
                    valor_uf: recebe_uf,
                },
                success: function(retorno_cidade_estado) {
                    debugger;

                    console.log(retorno_cidade_estado);

                    if (retorno_cidade_estado > 0) {
                        console.log("Cidade cadastrada com sucesso");
                        // window.location.href = "painel.php?pg=grava_risco";
                        buscar_cidades_estados();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        }
    });
</script>