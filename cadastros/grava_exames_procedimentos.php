<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <!-- <input type="hidden" name="exames_procedimentos_id_alteracao" id="exames_procedimentos_id_alteracao"> -->

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
                            <label for="codigo_exame_procedimento">Código:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-cogs"></i>

                                <input type="text" id="codigo_exame_procedimento" name="codigo_exame_procedimento" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 30%;">
                            <label for="procedimento_exame">Proedimento:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-tasks"></i>

                                <!-- <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)"> -->
                                <input type="text" id="procedimento_exame" name="procedimento_exame" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 30%;">
                            <label for="valor_procedimento">Valor:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-money-bill-wave"></i>

                                <!-- <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)"> -->
                                <input type="text" id="valor_procedimento" name="valor_procedimento" class="form-control">
                            </div>
                        </div>

                        <!-- <div class="form-group" style="flex:30%;">
                            <label for="grupo_risco">Grupo de Risco:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-users"></i>

                                <select id="grupo_risco" name="grupo_risco" class="form-control">
                                    <option value="selecione">Selecione</option>
                                    <option value="ergonomico" selected>Riscos Ergonômicos</option>
                                    <option value="acidente_mecanico">Riscos Acidentes - Mecânicos</option>
                                    <option value="fisico">Riscos Físicos</option>
                                    <option value="quimico">Riscos Químicos</option>
                                    <option value="biologico">Riscos Biológicos</option>
                                    <option value="outro">Outros</option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="text-sm text-red-600 mt-3" id="mensagem-campo-vazio">
                <span id="corpo-mensagem-campo-vazio"></span>
            </div>

            <input type="hidden" name="id_exame_procedimento_alteracao" id="id_exame_procedimento_alteracao">

            <button type="button" class="btn btn-primary" name="grava_risco" id="grava-exame-procedimento">Salvar</button>
            <button type="button" id="retornar-listagem-medicos" class="botao-cinza">Cancelar</button>
        </form>

        <div class="form-columns">

            <div class="accordion" id="accordion-riscos">

                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="section1" id="accordion1">
                        Exames/Procedimentos
                        <span class="accordion-arrow">▼</span>
                    </button>
                    <div class="accordion-content hidden" id="section1" role="region" aria-labelledby="accordion1" style="height: 35%;">
                        <div>
                            <table id="exames_procedimentos">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Código</th>
                                        <th>Procedimento</th>
                                        <th>Valor</th>
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

    #exames_procedimentos {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #exames_procedimentos th,
    #exames_procedimentos td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #exames_procedimentos th {
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

    #exames_procedimentos {
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
    debugger;
    let recebe_acao_alteracao_exame_procedimento = "cadastrar";

    $(document).ready(function(e) {
        buscar_exames_procedimentos();
    });

    document.querySelectorAll('.accordion-header').forEach(button => {
        button.addEventListener('click', () => {
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', !expanded);

            const content = document.getElementById(button.getAttribute('aria-controls'));
            content.classList.toggle('hidden');
        });
    });

    function buscar_exames_procedimentos() {
        // Desativa os alertas de erro do DataTables
        $.fn.dataTable.ext.errMode = 'none';

        // 🧹 Inicializa o DataTable apenas UMA vez quando a página carrega:
        let tabelaExamesProcedimentos = $('#exames_procedimentos').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            },
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            pageLength: 5,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"]
            ]
        });

        // Seu AJAX normalmente...
        $.ajax({
            url: "cadastros/processa_exames_procedimentos.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_exame_procedimento": "buscar_exames_procedimentos",
            },
            success: function(resposta_exame_procedimento) {
                console.log(resposta_exame_procedimento);

                tabelaExamesProcedimentos.clear();

                if (resposta_exame_procedimento.length > 0) {
                    for (let index = 0; index < resposta_exame_procedimento.length; index++) {
                        let exame_procedimento = resposta_exame_procedimento[index];

                        tabelaExamesProcedimentos.row.add([
                            exame_procedimento.id,
                            exame_procedimento.codigo,
                            exame_procedimento.procedimento,
                            exame_procedimento.valor,
                            `<div class='action-buttons'>
                        <a href='#' id='alterar-exame-procedimento' data-id-exame-procedimento="${exame_procedimento.id}" data-codigo-exame-procedimento="${exame_procedimento.codigo}"
                        data-exame-procedimento="${exame_procedimento.procedimento}" data-valor-procedimento="${exame_procedimento.valor}" title='Editar'><i class="fas fa-edit"></i></a>
                        <a href='#' id='excluir-exame-procedimento' data-id-exame-procedimento="${exame_procedimento.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                    </div>`
                        ]);
                    }
                } else {
                    tabelaExamesProcedimentos.row.add([
                        '', '', '', '', '<div style="text-align:center; width:100%">Nenhum registro localizado</div>'
                    ]);
                }

                tabelaExamesProcedimentos.draw();
            },
            error: function(xhr, status, error) {
                console.error("Erro ao carregar dados:", error);
            }
        });
    }


    $(document).on("click", "#excluir-exame-procedimento", function(e) {
        e.preventDefault();

        debugger;

        let recebe_confirmacao_excluir_exame_procedimento = window.confirm("Tem certeza que deseja excluir o exame?");

        if (recebe_confirmacao_excluir_exame_procedimento) {
            let recebe_id_exame_procedimento = $(this).data("id-exame-procedimento");
            $.ajax({
                url: "cadastros/processa_exames_procedimentos.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_exame_procedimento: "excluir_exame_procedimento",
                    valor_id_exame_procedimento: recebe_id_exame_procedimento,
                },
                success: function(retorno_exame_procedimento) {
                    debugger;
                    console.log(retorno_exame_procedimento);
                    if (retorno_exame_procedimento) {
                        // window.location.href = "painel.php?pg=grava_risco";
                        buscar_exames_procedimentos();
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

    $(document).on("click", "#alterar-exame-procedimento", function(e) {
        e.preventDefault();

        debugger;

        let recebe_id_exame_procedimento = $(this).data("id-exame-procedimento");
        let recebe_codigo_exame_procedimento = $(this).data("codigo-exame-procedimento");
        let recebe_procedimento_exame = $(this).data("exame-procedimento");
        let recebe_valor_exame_procedimento = $(this).data("valor-procedimento");

        $("#id_exame_procedimento_alteracao").val(recebe_id_exame_procedimento);
        $("#codigo_exame_procedimento").val(recebe_codigo_exame_procedimento);
        $("#procedimento_exame").val(recebe_procedimento_exame);
        $("#valor_procedimento").val(recebe_valor_exame_procedimento);

        recebe_acao_alteracao_exame_procedimento = "editar";
    });

    $("#grava-exame-procedimento").click(function(e) {
        e.preventDefault();

        debugger;

        let recebe_codigo_exame_procedimento = $("#codigo_exame_procedimento").val();
        let recebe_procedimento = $("#procedimento_exame").val();
        let recebe_valor_procedimento = $("#valor_procedimento").val();

        // let recebe_valor_convertido_float = parseFloat(recebe_valor_procedimento.replace(',', '.'));

        if (recebe_acao_alteracao_exame_procedimento === "editar") {
            $.ajax({
                url: "cadastros/processa_exames_procedimentos.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_exame_procedimento: "alterar_exame_procedimento",
                    valor_codigo_exame_procedimento: recebe_codigo_exame_procedimento,
                    valor_procedimento: recebe_procedimento,
                    valor_exame_procedimento: recebe_valor_procedimento,
                    valor_id_exame_procedimento: $("#id_exame_procedimento_alteracao").val(),
                },
                success: function(retorno_exame_procedimento) {
                    debugger;

                    console.log(retorno_exame_procedimento);
                    if (retorno_exame_procedimento) {
                        console.log("Risco alterada com sucesso");
                        // window.location.href = "painel.php?pg=grava_risco";

                        $("#codigo_exame_procedimento").val("");
                        $("#procedimento_exame").val("");
                        $("#valor_procedimento").val("");
                        buscar_exames_procedimentos(e);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao alterar médico:" + error);
                },
            });
        } else {
            $.ajax({
                url: "cadastros/processa_exames_procedimentos.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_exame_procedimento: "inserir_exame_procedimento",
                    valor_codigo_exame_procedimento: recebe_codigo_exame_procedimento,
                    valor_procedimento: recebe_procedimento,
                    valor_exame_procedimento: recebe_valor_procedimento
                },
                success: function(retorno_exame_procedimento) {
                    debugger;

                    console.log(retorno_exame_procedimento);

                    if (retorno_exame_procedimento > 0) {
                        console.log("Risco cadastrada com sucesso");
                        // window.location.href = "painel.php?pg=grava_risco";
                        $("#codigo_exame_procedimento").val("");
                        $("#procedimento_exame").val("");
                        $("#valor_procedimento").val("");
                        buscar_exames_procedimentos(e);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        }
    });
</script>