<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <div class="form-group">
                <label for="created_at">Data de Cadastro:</label>
                <div class="input-with-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="datetime-local" id="created_at" name="created_at" class="form-control" readonly>
                </div>
            </div>

            <div class="form-columns">
                <div class="form-column">
                    <div class="form-group">
                        <label for="cnpj">CNPJ:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-address-card"></i>
                            <input type="text" id="cnpj" name="cnpj" class="form-control cnpj-input" onblur="fetchCompanyData(this.value)" oninput="formatCNPJ(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nome_fantasia">Nome Fantasia:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-building"></i>
                            <input type="text" id="nome_fantasia" name="nome_fantasia" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="razao_social">Razão Social:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-file-signature"></i>
                            <input type="text" id="razao_social" name="razao_social" class="form-control">
                        </div>
                    </div>

                    <div class="address-container">
                        <div class="form-group" style="flex: 75%;">
                            <label for="endereco">Endereço:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" id="endereco" name="endereco" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 25%; margin-left: 10px;">
                            <label for="numero">Número:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-pin"></i>
                                <input type="text" id="numero" name="numero" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="address-container">
                        <div class="form-group" style="flex: 75%;">
                            <label for="complemento">Complemento:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-signs"></i>
                                <input type="text" id="complemento" name="complemento" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 25%;">
                            <label for="bairro">Bairro:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map"></i>
                                <input type="text" id="bairro" name="bairro" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="cidade_id">Cidade:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-city"></i>
                            <select id="cidade_id" name="cidade_id" class="form-control">
                                <!-- As opções serão adicionadas dinamicamente aqui -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cep">CEP:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-marked-alt"></i>
                            <input type="text" id="cep" name="cep" class="form-control" oninput="formatCEP(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone"></i>
                            <input type="text" id="telefone" name="telefone" class="form-control" oninput="formatPhone(this)">
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="status">Status: Ativa/Inativa</label>
                        <div class="status-toggle">
                            <input type="checkbox" id="status" name="status" class="toggle-checkbox" value="1">
                            <label for="status" class="toggle-label"></label>
                        </div>
                    </div> -->
                </div>
            </div>

            <div style="display: flex; align-items: flex-start; gap: 40px;">
                <!-- Coluna esquerda: select + botão -->
                <div class="form-group">
                    <label for="cidade_id_2">Vincular Médico Examinador</label>
                    <div class="input-with-icon" style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-user-md"></i>
                        <select id="medico-associado-empresa" name="medico_associado" class="form-control" style="max-width: 250px;"></select>
                        <button type="button" class="btn btn-primary" id="associar-medico-empresa">Incluir</button>
                    </div>
                </div>

                <!-- Coluna direita: tabela -->
                <div>
                    <table id="tabela-medico-associado-coordenador" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Médicos examinadores coordenadores vinculados a essa empresa</th>
                                <th>Opção</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dados serão preenchidos via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="button" class="btn btn-primary" id="grava-empresa">Salvar</button>
        </form>
    </div>

    <!-- <div id="profissionais" class="tab-content">
        <p>Conteúdo da aba Profissionais da Medicina Relacionados.</p>
    </div> -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
</style>

<script>
    let recebe_codigo_alteracao_empresa;
    let recebe_acao_alteracao_empresa = "cadastrar";
    let verifica_vinculacao_medico_empresa;

    $(document).ready(function(e) {
        debugger;
        let recebe_url_atual = window.location.href;

        let recebe_parametro_acao_empresa = new URLSearchParams(recebe_url_atual.split("&")[1]);

        let recebe_parametro_codigo_empresa = new URLSearchParams(recebe_url_atual.split("&")[2]);

        recebe_codigo_alteracao_empresa = recebe_parametro_codigo_empresa.get("id");

        let recebe_acao_empresa = recebe_parametro_acao_empresa.get("acao");

        if (recebe_acao_empresa !== "" && recebe_acao_empresa !== null)
            recebe_acao_alteracao_empresa = recebe_acao_empresa;

        async function buscar_informacoes_empresa() {
            debugger;
            if (recebe_acao_alteracao_empresa === "editar") {
                carrega_cidades();
                await popula_lista_cidade_empresa_alteracao();
                await popula_medicos_associar_empresa();
                await popula_medicos_associados_empresa();
                await popula_informacoes_empresa_alteracao();
            } else {
                carrega_cidades();
                await popula_medicos_associar_empresa();
            }
        }

        buscar_informacoes_empresa();
    });

    async function popula_lista_cidade_empresa_alteracao() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_empresa.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_cidade_empresa",
                    "valor_id_empresa": recebe_codigo_alteracao_empresa,
                },
                success: function(resposta) {
                    debugger;
                    console.log(resposta);
                    for (let indice = 0; indice < resposta.length; indice++) {
                        $("#cidade_id").val(resposta[0].id);
                    }
                    resolve(); // sinaliza que terminou
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar cidade da clinica:" + error);
                    reject(error);
                },
            });
        });
    }

    async function popula_medicos_associar_empresa() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_medico.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_medico": "buscar_medicos_associar_empresa"
                },
                success: function(resposta_medicos) {
                    debugger;
                    console.log(resposta_medicos);
                    if (resposta_medicos.length > 0) {
                        let select_medicos = document.getElementById('medico-associado-empresa');
                        let options = '<option value="">Selecione um médico</option>';
                        for (let i = 0; i < resposta_medicos.length; i++) {
                            let medico = resposta_medicos[i];
                            options += `<option value="${medico.id}">${medico.nome}</option>`;
                        }
                        select_medicos.innerHTML = options;
                    }
                    resolve(); // sinaliza que terminou
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar médicos:" + error);
                    reject(error);
                },
            });
        });
    }

    async function popula_medicos_associados_empresa() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_medico.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_medico": "buscar_medicos_associados_empresa",
                    valor_codigo_empresa_medicos_associados: recebe_codigo_alteracao_empresa,
                },
                success: function(resposta_medicos) {
                    debugger;
                    console.log(resposta_medicos);

                    if (resposta_medicos.length > 0) {
                        let recebe_tabela_associar_medico_empresa = document.querySelector(
                            "#tabela-medico-associado-coordenador tbody"
                        );

                        $("#tabela-medico-associado-coordenador tbody").html("");

                        for (let indice = 0; indice < resposta_medicos.length; indice++) {
                            let recebe_botao_desvincular_medico_empresa;
                            if (resposta_medicos[indice].id !== "" && resposta_medicos[indice].medico_id !== "") {
                                recebe_botao_desvincular_medico_empresa = "<td><i class='fas fa-trash' id='exclui-medico-ja-associado'" +
                                    " data-codigo-medico-empresa='" + resposta_medicos[indice].id + "' data-codigo-medico='" + resposta_medicos[indice].medico_id + "'></i></td>";
                            }

                            recebe_tabela_associar_medico_empresa +=
                                "<tr>" +
                                "<td>" + resposta_medicos[indice].nome_medico + "</td>" +
                                recebe_botao_desvincular_medico_empresa +
                                "</tr>";
                        }
                        $("#tabela-medico-associado-coordenador tbody").append(recebe_tabela_associar_medico_empresa);
                    } else {
                        $("#tabela-medico-associado-coordenador tbody").html("");
                    }

                    resolve(); // sinaliza que terminou
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar médicos:" + error);
                    reject(error);
                },
            });
        });
    }

    async function popula_informacoes_empresa_alteracao() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_empresa.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_informacoes_empresa_alteracao",
                    valor_codigo_empresa_alteracao: recebe_codigo_alteracao_empresa,
                },
                success: function(resposta_empresa) {
                    debugger;
                    console.log(resposta_empresa);

                    if (resposta_empresa.length > 0) {
                        for (let indice = 0; indice < resposta_empresa.length; indice++) {
                            $("#created_at").val(resposta_empresa[indice].created_at);
                            $("#cnpj").val(resposta_empresa[indice].cnpj);
                            $("#nome_fantasia").val(resposta_empresa[indice].nome);
                            $("#razao_social").val(resposta_empresa[indice].razao_social);
                            $("#cep").val(resposta_empresa[indice].cep);
                            let recebe_endereco_empresa = resposta_empresa[indice].endereco.split(",");
                            $("#endereco").val(recebe_endereco_empresa[0]);
                            $("#numero").val(recebe_endereco_empresa[1]);
                            $("#complemento").val(resposta_empresa[indice].complemento);
                            $("#bairro").val(resposta_empresa[indice].bairro);
                            $("#email").val(resposta_empresa[indice].email);
                            $("#telefone").val(resposta_empresa[indice].telefone);
                        }
                    }

                    resolve(); // sinaliza que terminou
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar médicos:" + error);
                    reject(error);
                },
            });
        });
    }

    $(document).on("click", "#exclui-medico-ja-associado", function(e) {
        e.preventDefault();

        debugger;

        let recebe_codigo_medico_ja_associado = $(this).data("codigo-medico-empresa");

        let recebe_codigo_medico = $(this).data("codigo-medico");

        $.ajax({
            url: "cadastros/processa_empresa.php",
            method: "POST",
            dataType: "json",
            data: {
                "processo_empresa": "desvincular_medico_empresa",
                valor_medico_empresa_id: recebe_codigo_medico_ja_associado,
                valor_codigo_medico: recebe_codigo_medico
            },
            success: function(resposta_medicos_clinicas) {
                debugger;

                console.log(resposta_medicos_clinicas);

                if (resposta_medicos_clinicas) {
                    if (verifica_vinculacao_medico_empresa) {
                        $("#medico-associado-empresa").prop("disabled", true);
                        $("#associar-medico-empresa").prop("disabled", true);
                    }
                    
                    async function buscar_informacoes_empresa() {
                        debugger;
                        if (recebe_acao_alteracao_empresa === "editar") {
                            await popula_medicos_associados_empresa();
                        }
                    }

                    buscar_informacoes_empresa();
                }
            },
            error: function(xhr, status, error) {

            },
        });
    });

    let valores_codigos_medicos_empresas = Array();
    let limpou_tabela_alteracao_empresa;

    $("#associar-medico-empresa").click(function(e) {
        e.preventDefault();

        debugger;

        if (recebe_acao_alteracao_empresa === "editar") {
            let recebe_codigo_medico_selecionado_associar_empresa = $("#medico-associado-empresa").val();

            let recebe_nome_medico_selecionado_associar_empresa = $('#medico-associado-empresa option:selected').text();

            console.log(recebe_codigo_medico_selecionado_associar_empresa + " - " + recebe_nome_medico_selecionado_associar_empresa);

            let recebe_tabela_associar_medico_empresa = document.querySelector(
                "#tabela-medico-associado-coordenador tbody"
            );

            let indice = recebe_tabela_associar_medico_empresa.querySelectorAll("tr").length;

            recebe_tabela_associar_medico_empresa.innerHTML +=
                "<tr data-index='" + indice + "'>" +
                "<td>" + recebe_nome_medico_selecionado_associar_empresa + "</td>" +
                "<td><i class='fas fa-trash' id='exclui-medico-associado-empresa'></i></td>" +
                "</tr>";

            valores_codigos_medicos_empresas.push(recebe_codigo_medico_selecionado_associar_empresa);

            $("#tabela-medico-associado-coordenador tbody").append(recebe_tabela_associar_medico_empresa);

            $("#medico-associado-empresa").prop('disabled', true);

            // Desabilita o botão
            $('#associar-medico-empresa').prop('disabled', true);

            verifica_vinculacao_medico_empresa = true;
        } else {
            let recebe_codigo_medico_selecionado_associar_empresa = $("#medico-associado-empresa").val();

            let recebe_nome_medico_selecionado_associar_empresa = $('#medico-associado-empresa option:selected').text();

            console.log(recebe_codigo_medico_selecionado_associar_empresa + " - " + recebe_nome_medico_selecionado_associar_empresa);

            let recebe_tabela_associar_medico_empresa = document.querySelector(
                "#tabela-medico-associado-coordenador tbody"
            );

            let indice = recebe_tabela_associar_medico_empresa.querySelectorAll("tr").length;

            recebe_tabela_associar_medico_empresa.innerHTML +=
                "<tr data-index='" + indice + "'>" +
                "<td>" + recebe_nome_medico_selecionado_associar_empresa + "</td>" +
                "<td><i class='fas fa-trash' id='exclui-medico-associado-empresa'></i></td>" +
                "</tr>";

            valores_codigos_medicos_empresas.push(recebe_codigo_medico_selecionado_associar_empresa);

            $("#tabela-medico-associado-coordenador tbody").append(recebe_tabela_associar_medico_empresa);

            $("#medico-associado-empresa").prop('disabled', true);

            // Desabilita o botão
            $('#associar-medico-empresa').prop('disabled', true);
        }
    });

    $(document).on("click", "#exclui-medico-associado-empresa", function(e) {
        e.preventDefault();

        debugger;

        let linha = $(this).closest("tr");
        let index = linha.data("index");

        linha.remove();

        valores_codigos_medicos_empresas.splice(index, 1);

        console.log(valores_codigos_medicos_empresas);

        let recebe_tabela_associar_medico_empresa = document.querySelector("#tabela-medico-associado-coordenador tbody");

        // Pega todas as linhas <tr> dentro do tbody
        let linhas = recebe_tabela_associar_medico_empresa.querySelectorAll("tr");

        // Itera usando for tradicional
        for (let i = 0; i < linhas.length; i++) {
            linhas[i].setAttribute("data-index", i);
        }
    });

    function openTab(event, tabName) {
        const tabContents = document.querySelectorAll('.tab-content');
        const tabButtons = document.querySelectorAll('.tab-button');

        tabContents.forEach(tab => tab.classList.remove('active'));
        tabButtons.forEach(button => button.classList.remove('active'));

        document.getElementById(tabName).classList.add('active');
        event.currentTarget.classList.add('active');
    }

    function formatCNPJ(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 14) value = value.slice(0, 14);
        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
        input.value = value;
    }

    function validateCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if (cnpj.length !== 14) return false;
        fetchCompanyData(cnpj);
    }

    function formatCEPValue(cep) {
        cep = cep.replace(/\D/g, '');
        if (cep.length > 8) cep = cep.slice(0, 8);
        return cep.replace(/^(\d{5})(\d{3})$/, '$1-$2');
    }

    function formatPhoneValue(phone) {
        debugger;
        phone = phone.replace(/\D/g, '');
        if (phone.length > 11) phone = phone.slice(0, 11);
        return phone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    }

    function formatCEP(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 8) value = value.slice(0, 8);
        value = value.replace(/^(\d{5})(\d{3})$/, '$1-$2');
        input.value = value;
    }

    function formatPhone(input) {
        debugger;
        let value = input.value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        input.value = value;
    }

    function fetchCompanyData(cnpj) {
        const cleanedCNPJ = cnpj.replace(/[.\/-]/g, '');

        fetch(`https://open.cnpja.com/office/${cleanedCNPJ}`)
            .then(response => response.json())
            .then(data => {
                debugger;
                console.log(data);
                document.getElementById('nome_fantasia').value = data.alias || '';
                document.getElementById('razao_social').value = data.company.name || '';
                document.getElementById('endereco').value = data.address.street || '';
                document.getElementById('numero').value = data.address.number || '';
                document.getElementById('complemento').value = data.address.details || '';
                document.getElementById('bairro').value = data.address.district || '';
                document.getElementById('cep').value = formatCEPValue(data.address.zip || '');
                document.getElementById('email').value = data.emails[0]?.address || '';
                document.getElementById('telefone').value = formatPhoneValue(data.phones[0] ? `${data.phones[0].area}${data.phones[0].number}` : '');

                carrega_cidades(data.address.city, data.address.state);

                const now = new Date();
                const formattedDateTime = now.toISOString().slice(0, 16);
                document.getElementById('created_at').value = formattedDateTime;
            })
            .catch(error => console.error('Erro ao buscar CNPJ:', error));
    }

    function carrega_cidades(cidadeSelecionada = '', estadoSelecionado = '') {
        $.ajax({
            url: "api/list/cidades.php",
            type: "get",
            dataType: "json",
            data: {},
            success: function(retorno_cidades) {
                //debugger;

                console.log(retorno_cidades.data.cidades);

                let recebe_select_list_cidades = document.getElementById('cidade_id');

                // Limpa opções anteriores
                recebe_select_list_cidades.innerHTML = '<option value="">Selecione uma cidade</option>';

                let cidades = retorno_cidades.data.cidades;

                if (cidades.length > 0) {
                    for (let i = 0; i < cidades.length; i++) {
                        let option = document.createElement('option');
                        option.value = cidades[i].id;
                        option.text = cidades[i].nome + ' - ' + cidades[i].estado;
                        recebe_select_list_cidades.appendChild(option);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log("Erro ao pegar cidades:" + error);
            },
        });
    }

    let recebe_nome_cidade_empresa;
    let recebe_id_cidade;

    $("#cidade_id").change(function(e) {
        e.preventDefault();

        debugger;
        recebe_id_cidade = $(this).val();
        let recebe_cidade_empresa = $('#cidade_id option:selected').text(); // Nome da cidade
        let recebe_array_informacoes_cidade_empresa = recebe_cidade_empresa.split("-");
        let recebe_informacao_cidade_empresa = recebe_array_informacoes_cidade_empresa[0];
        let recebe_informacao_estado_empresa = recebe_array_informacoes_cidade_empresa[1];
        recebe_nome_cidade_empresa = recebe_informacao_cidade_empresa + "," + recebe_informacao_estado_empresa;
    });

    $("#grava-empresa").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_cnpj_empresa = $("#cnpj").val();
        let recebe_nome_fantasia_empresa = $("#nome_fantasia").val()
        let recebe_razao_social_empresa = $("#razao_social").val();
        let recebe_endereco_empresa = $("#endereco").val();
        let recebe_numero_empresa = $("#numero").val();
        let recebe_complemento_empresa = $("#complemento").val();
        let recebe_bairro_empresa = $("#bairro").val();
        let recebe_cep_empresa = $("#cep").val();
        let recebe_email_empresa = $("#email").val();
        let recebe_telefone_empresa = $("#telefone").val();

        let recebe_endereco_completo = recebe_endereco_empresa + "," + recebe_numero_empresa + "," + recebe_nome_cidade_empresa;

        console.log(recebe_endereco_completo);

        $.ajax({
            url: "cadastros/processa_empresa.php",
            type: "POST",
            dataType: "json",
            data: {
                processo_empresa: "inserir_empresa",
                valor_nome_fantasia_empresa: recebe_nome_fantasia_empresa,
                valor_cnpj_empresa: recebe_cnpj_empresa,
                valor_endereco_empresa: recebe_endereco_completo,
                valor_telefone_empresa: recebe_telefone_empresa,
                valor_email_empresa: recebe_email_empresa,
                valor_medico_coordenador_empresa: valores_codigos_medicos_empresas,
                valor_id_cidade: recebe_id_cidade,
                valor_razao_social_empresa: recebe_razao_social_empresa,
                valor_bairro_empresa: recebe_bairro_empresa,
                valor_cep_empresa: recebe_cep_empresa,
                valor_complemento_empresa: recebe_complemento_empresa,
            },
            success: function(retorno_empresa) {
                debugger;

                console.log(retorno_empresa > 0);
                if (retorno_empresa) {
                    console.log("Empresa cadastrada com sucesso");
                    window.location.href = "painel.php?pg=empresas";
                }
            },
            error: function(xhr, status, error) {
                console.log("Falha ao inserir empresa:" + error);
            },
        });
    });
</script>