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
                <!-- <div class="input-with-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="datetime-local" id="created_at" name="created_at" class="form-control" readonly>
                </div> -->
            </div>

            <div class="form-columns">
                <div class="form-column">


                    <div class="address-container">

                        <div class="form-group" style="flex: 50%;">
                            <label for="nome">Valor:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-money-bill"></i> 
                                <input type="text" id="valor" name="valor" class="form-control" style="width: 20%;">
                            </div>
                        </div>

                        <!-- <div class="form-group" style="flex: 50%;">
                            <label for="cpf">CPF:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-address-card"></i>
                                <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)">
                                <input type="text" id="cpf" name="cpf" class="form-control" oninput="formatCPF(this)">
                            </div>
                        </div> -->
                    </div>

                    <!-- <div class="address-container">
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
                                <input type="text" id="telefone" name="telefone" oninput="mascaraTelefone(this);" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 20%;">
                            <label for="telefone">Whatsapp:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="whatsapp" name="whatsapp" oninput="mascaraTelefone(this);" class="form-control">
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <button type="button" class="btn btn-primary" id="grava-boleto">Salvar</button>
            <button type="reset"  class="botao-cinza">Cancelar</button>
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
</style>

<script>

    $("#grava-pessoa").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_nome_pessoa = $("#nome").val();
        let recebe_cpf_pessoa = $("#cpf").val();
        let recebe_nascimento_pessoa = $("#nascimento").val();
        let recebe_sexo_pessoa = $("#sexo-pessoa").val();
        let recebe_telefone_pessoa = $("#telefone").val();
        let recebe_data_cadastro_pessoa = $("#created_at").val();
        let recebe_whatsapp_pessoa = $("#whatsapp").val();
        let recebe_empresa_id_pessoa = $("#empresa_id").val();
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
                    processo_pessoa: "alterar_pessoa",
                    valor_nome_pessoa: recebe_nome_pessoa,
                    valor_cpf_pessoa: recebe_cpf_pessoa,
                    valor_nascimento_pessoa: recebe_nascimento_pessoa,
                    valor_sexo_pessoa: recebe_sexo_pessoa,
                    valor_telefone_pessoa: recebe_telefone_pessoa,
                    valor_data_cadastro_pessoa: recebe_data_cadastro_pessoa,
                    valor_whatsapp_pessoa: recebe_whatsapp_pessoa,
                    valor_id_pessoa: $("#pessoa_id_alteracao").val(),
                },
                success: function(retorno_pessoa) {
                    debugger;

                    console.log(retorno_pessoa);
                    if (retorno_pessoa) {
                        console.log("Pessoa alterada com sucesso");
                        window.location.href = "painel.php?pg=pessoas";
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
                    valor_sexo_pessoa: recebe_sexo_pessoa,
                    valor_telefone_pessoa: recebe_telefone_pessoa,
                    valor_data_cadastro_pessoa: recebe_data_cadastro_pessoa,
                    valor_whatsapp_pessoa: recebe_whatsapp_pessoa,
                    valor_empresa_id_pessoa: recebe_empresa_id_pessoa,
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