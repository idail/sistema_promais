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


                    <div class="address-container">

                        <div class="form-group" style="flex: 50%;">
                            <label for="nome">Nome Completo:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" id="nome" name="nome" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 50%;">
                            <label for="cpf">CPF:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-address-card"></i>
                                <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)">
                            </div>
                        </div>
                    </div>

                    <div class="address-container">
                        <div class="form-group" style="flex:20%;">
                            <label for="nascimento">Data Nascimento:</label>
                            <div class="input-with-icon" style="flex: 25%; margin-left: 10px;">
                                <i class="fas fa-calendar-alt"></i>
                                <input type="date" id="nascimento" name="nascimento" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex:20%;">
                            <label for="sexo-pessoa">Sexo:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-mars"></i>
                                <select id="sexo-pessoa" name="sexo_pessoa" class="form-control">
                                    <option value="selecione">Selecione</option>
                                    <option value="feminino">Feminino</option>
                                    <option value="masculino">Masculino</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="flex: 20%;">
                            <label for="telefone">Telefone:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="telefone" name="telefone" class="form-control cnpj-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary" id="grava-pessoa">Salvar</button>
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
    let recebe_acao_alteracao_pessoa = "cadastrar";

    $(document).ready(function(e) {
        debugger;
        let recebe_url_atual = window.location.href;

        let recebe_parametro_acao_empresa = new URLSearchParams(recebe_url_atual.split("&")[1]);

        let recebe_parametro_codigo_empresa = new URLSearchParams(recebe_url_atual.split("&")[2]);

        recebe_codigo_alteracao_empresa = recebe_parametro_codigo_empresa.get("id");

        let recebe_acao_empresa = recebe_parametro_acao_empresa.get("acao");

        if (recebe_acao_empresa !== "" && recebe_acao_empresa !== null)
            recebe_acao_alteracao_pessoa = recebe_acao_empresa;

        async function buscar_informacoes_pessoa() {
            debugger;
            if (recebe_acao_alteracao_pessoa === "editar") {
                carrega_cidades();
                await popula_lista_cidade_empresa_alteracao();
                await popula_informacoes_empresa_alteracao();
            } else {
                carrega_cidades();

                let atual = new Date();

                let ano = atual.getFullYear();
                let mes = String(atual.getMonth() + 1).padStart(2, '0');
                let dia = String(atual.getDate()).padStart(2, '0');
                let horas = String(atual.getHours()).padStart(2, '0');
                let minutos = String(atual.getMinutes()).padStart(2, '0');

                // Formato aceito por <input type="datetime-local">
                let data_formatada = `${ano}-${mes}-${dia}T${horas}:${minutos}`;

                console.log("Data formatada para input datetime-local:", data_formatada);
                document.getElementById('created_at').value = data_formatada;
            }
        }

        buscar_informacoes_pessoa();
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

    let recebe_nome_cidade_pessoa;
    let recebe_id_cidade;

    $("#cidade_id").change(function(e) {
        e.preventDefault();

        debugger;
        recebe_id_cidade = $(this).val();
        let recebe_cidade_pessoa = $('#cidade_id option:selected').text(); // Nome da cidade
        let recebe_array_informacoes_cidade_pessoa = recebe_cidade_pessoa.split("-");
        let recebe_informacao_cidade_pessoa = recebe_array_informacoes_cidade_pessoa[0];
        let recebe_informacao_estado_pessoa = recebe_array_informacoes_cidade_pessoa[1];
        recebe_nome_cidade_pessoa = recebe_informacao_cidade_pessoa + "," + recebe_informacao_estado_pessoa;
    });

    $("#grava-pessoa").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_nome_pessoa = $("#nome").val();
        let recebe_cpf_pessoa = $("#cpf").val();
        let recebe_nascimento_pessoa = $("#nascimento").val();
        let recebe_sexo_pessoa = $("#sexo-pessoa").val();
        let recebe_telefone_pessoa = $("#telefone").val();
        let recebe_data_cadastro_pessoa = $("#created_at").val();
        // let recebe_cargo_pessoa = $("#cargo").val();

        // if (recebe_id_cidade === "" || recebe_id_cidade === undefined)
        //     recebe_id_cidade = $("#cidade_id").val();

        // let recebe_cidade_id_empresa = $("#cidade_id").val();
        // let recebe_endereco_pessoa = $("#endereco").val();
        // let recebe_numero_pessoa = $("#numero").val();
        // let recebe_complemento_pessoa = $("#complemento").val();
        // let recebe_bairro_pessoa = $("#bairro").val();
        // let recebe_cep_pessoa = $("#cep").val();
        // let recebe_email_pessoa = $("#email").val();
        // let recebe_senha_pessoa = $("#senha").val();
        // let recebe_cbo_pessoa = $("#cbo").val();
        // let recebe_idade_pessoa = $("#idade").val();
        // let recebe_nivel_acesso_pessoa = $("#acesso-pessoa").val();
        // let recebe_empresa_id = $("#empresa_id").val();

        // let recebe_endereco_completo = recebe_endereco_pessoa + "," + recebe_numero_pessoa + "," + recebe_nome_cidade_pessoa;

        // console.log(recebe_endereco_completo);

        if (recebe_acao_alteracao_pessoa === "editar") {
            $.ajax({
                url: "cadastros/processa_pessoa.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_empresa: "inserir_pessoa",
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
                url: "cadastros/processa_pessoa.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_pessoa: "inserir_pessoa",
                    valor_nome_pessoa: recebe_nome_pessoa,
                    valor_cpf_pessoa: recebe_cpf_pessoa,
                    valor_nascimento_pessoa: recebe_nascimento_pessoa,
                    valor_sexo_pessoa:recebe_sexo_pessoa,
                    valor_telefone_pessoa:recebe_telefone_pessoa,
                    valor_data_cadastro_pessoa: recebe_data_cadastro_pessoa,
                    // valor_cargo_pessoa: recebe_cargo_pessoa,
                    // valor_cbo_pessoa: recebe_cbo_pessoa,
                    // valor_idade_pessoa: recebe_idade_pessoa,
                    // valor_endereco_pessoa: recebe_endereco_completo,
                    // valor_numero_pessoa: recebe_numero_pessoa,
                    // valor_complemento_pessoa: recebe_complemento_pessoa,
                    // valor_bairro_pessoa: recebe_bairro_pessoa,
                    // valor_cep_pessoa: recebe_cep_pessoa,
                    // valor_id_cidade_pessoa: recebe_id_cidade,
                    // valor_email_pessoa: recebe_email_pessoa,
                    // valor_senha_pessoa: recebe_senha_pessoa,
                    // valor_nivel_acesso_pessoa: recebe_nivel_acesso_pessoa,
                    // valor_empresa_id: recebe_empresa_id,
                },
                success: function(retorno_pessoa) {
                    debugger;

                    console.log(retorno_pessoa);

                    if (retorno_pessoa) {
                        console.log("Pessoa cadastrada com sucesso");
                        window.location.href = "painel.php?pg=pessoas";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        }
    });
</script>