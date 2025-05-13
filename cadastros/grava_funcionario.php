<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <input type="hidden" name="empresa_id_alteracao" id="empresa_id_alteracao">

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
                        <label for="nome">Nome Completo:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="nome" name="nome" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-address-card"></i>
                            <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)">
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="cargo">Idail:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-file-signature"></i>
                            <input type="text" id="cargo" name="cargo" class="form-control">
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label for="nascimento">Data Nascimento:</label>
                        <div class="input-with-icon" style="flex: 25%; margin-left: 10px;">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" id="nascimento" name="nascimento" class="form-control">
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

                        <div class="form-group" style="flex: 40%;">
                            <label for="numero">Número:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-pin"></i>
                                <input type="text" id="numero" name="numero" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 90%;">
                            <label for="complemento">Complemento:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-signs"></i>
                                <input type="text" id="complemento" name="complemento" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="address-container">

                        <div class="form-group" style="flex: 90%;">
                            <label for="bairro">Bairro:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map"></i>
                                <input type="text" id="bairro" name="bairro" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 90%;">
                            <label for="cep">CEP:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" id="cep" name="cep" class="form-control" oninput="formatCEP(this);">
                            </div>
                        </div>
                    </div>

                    <div class="address-container">

                        <div class="form-group" style="flex: 50%;">
                            <label for="email">E-mail:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="text" id="email" name="email" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 40%;">
                            <label for="senha">Senha:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-lock"></i>
                                <input type="text" id="senha" name="senha" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex:30%;">
                        <label for="acesso-funcionario">Nível Acesso:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-city"></i>
                            <select id="acesso-funcionario" name="acesso_funcionario" class="form-control">
                                <option value="selecione">Selecione</option>
                                <option value="admin">Admin</option>
                                <option value="operador">Operador</option>
                                <option value="cliente">Cliente</option>
                            </select>
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
                        <label for="cargo">Cargo:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-briefcase"></i>
                            <input type="text" id="cargo" name="cargo" class="form-control" oninput="formatCEP(this)">
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="form-group" style="flex: 75%;">
                            <label for="cbo">CBO:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-briefcase"></i>
                                <input type="text" id="cbo" name="cbo" class="form-control">
                            </div>
                        </div>


                    </div>

                    <div class="form-group">
                        <label for="idade">Idade:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-birthday-cake"></i>
                            <input type="text" id="idade" name="idade" class="form-control">
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

            <button type="button" class="btn btn-primary" id="grava-funcionario">Salvar</button>
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
    let recebe_acao_alteracao_funcionario = "cadastrar";

    $(document).ready(function(e) {
        debugger;
        let recebe_url_atual = window.location.href;

        let recebe_parametro_acao_empresa = new URLSearchParams(recebe_url_atual.split("&")[1]);

        let recebe_parametro_codigo_empresa = new URLSearchParams(recebe_url_atual.split("&")[2]);

        recebe_codigo_alteracao_empresa = recebe_parametro_codigo_empresa.get("id");

        let recebe_acao_empresa = recebe_parametro_acao_empresa.get("acao");

        if (recebe_acao_empresa !== "" && recebe_acao_empresa !== null)
            recebe_acao_alteracao_funcionario = recebe_acao_empresa;

        async function buscar_informacoes_funcionario() {
            debugger;
            if (recebe_acao_alteracao_funcionario === "editar") {
                carrega_cidades();
                await popula_lista_cidade_empresa_alteracao();
                await popula_informacoes_empresa_alteracao();
            } else {
                carrega_cidades();
            }
        }

        buscar_informacoes_funcionario();
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
                            $("#empresa_id_alteracao").val(resposta_empresa[indice].id);
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

    function formatCEP(input) {
        let value = input.value.replace(/\D/g, ''); // remove tudo que não for número

        // Limita a quantidade de dígitos para 8
        if (value.length > 8) {
            value = value.substring(0, 8);
        }

        // Aplica a máscara
        if (value.length > 5) {
            value = value.replace(/(\d{5})(\d{1,3})/, '$1-$2');
        }

        input.value = value; // atualiza o valor do input
    }


    function formatCPF(input) {
        let value = input.value.replace(/\D/g, ''); // remove tudo que não for número

        // Limita a quantidade de dígitos para 11
        if (value.length > 11) {
            value = value.substring(0, 11);
        }

        // Aplica a máscara
        if (value.length > 9) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        } else if (value.length > 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        } else if (value.length > 3) {
            value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        }

        input.value = value; // atualiza o valor do input
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

    let recebe_nome_cidade_funcionario;
    let recebe_id_cidade;

    $("#cidade_id").change(function(e) {
        e.preventDefault();

        debugger;
        recebe_id_cidade = $(this).val();
        let recebe_cidade_funcionario = $('#cidade_id option:selected').text(); // Nome da cidade
        let recebe_array_informacoes_cidade_funcionario = recebe_cidade_funcionario.split("-");
        let recebe_informacao_cidade_funcionario = recebe_array_informacoes_cidade_funcionario[0];
        let recebe_informacao_estado_funcionario = recebe_array_informacoes_cidade_funcionario[1];
        recebe_nome_cidade_funcionario = recebe_informacao_cidade_funcionario + "," + recebe_informacao_estado_funcionario;
    });

    $("#grava-funcionario").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_nome_funcionario = $("#nome").val();
        let recebe_cpf_funcionario = $("#cpf").val()
        let recebe_cargo_funcionario = $("#cargo").val();
        let recebe_nascimento_funcionario = $("#nascimento").val();

        if (recebe_id_cidade === "" || recebe_id_cidade === undefined)
            recebe_id_cidade = $("#cidade_id").val();

        // let recebe_cidade_id_empresa = $("#cidade_id").val();
        let recebe_endereco_funcionario = $("#endereco").val();
        let recebe_numero_funcionario = $("#numero").val();
        let recebe_complemento_funcionario = $("#complemento").val();
        let recebe_bairro_funcionario = $("#bairro").val();
        let recebe_cep_funcionario = $("#cep").val();
        let recebe_email_funcionario = $("#email").val();
        let recebe_cbo_funcionario = $("#cbo").val();
        let recebe_idade_funcionario = $("#idade").val();

        let recebe_endereco_completo = recebe_endereco_funcionario + "," + recebe_numero_funcionario + "," + recebe_nome_cidade_funcionario;

        console.log(recebe_endereco_completo);

        if (recebe_acao_alteracao_funcionario === "editar") {
            $.ajax({
                url: "cadastros/processa_funcionario.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_empresa: "inserir_funcionario",
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
                    valor_id_empresa: $("#empresa_id_alteracao").val(),
                },
                success: function(retorno_empresa) {
                    debugger;

                    console.log(retorno_empresa);
                    if (retorno_empresa) {
                        console.log("Empresa alterada com sucesso");
                        window.location.href = "painel.php?pg=empresas";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        } else {
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

                    console.log(retorno_empresa);

                    if (retorno_empresa) {
                        console.log("Empresa cadastrada com sucesso");
                        window.location.href = "painel.php?pg=empresas";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        }
    });
</script>