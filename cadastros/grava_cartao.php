<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">

            <input type="hidden" id="cartao-id-alteracao" />

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

            <button type="button" class="btn btn-primary" id="grava-cartao">Salvar</button>
            <button type="reset" class="botao-cinza">Cancelar</button>
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
    let recebe_codigo_alteracao_cartao;
    let recebe_acao_alteracao_cartao = "cadastrar";
    $(document).ready(function(e) {
        debugger;
        let recebe_url_atual = window.location.href;

        let recebe_parametro_acao_cartao = new URLSearchParams(recebe_url_atual.split("&")[1]);

        let recebe_parametro_codigo_cartao = new URLSearchParams(recebe_url_atual.split("&")[2]);

        recebe_codigo_alteracao_cartao = recebe_parametro_codigo_cartao.get("id");

        let recebe_acao_cartao = recebe_parametro_acao_cartao.get("acao");

        if (recebe_acao_cartao !== "" && recebe_acao_cartao !== null)
            recebe_acao_alteracao_cartao = recebe_acao_cartao;

        async function buscar_informacoes_cartao() {
            debugger;
            if (recebe_acao_alteracao_cartao === "editar") {
                // carrega_cidades();
                // await popula_lista_cidade_empresa_alteracao();
                await popula_informacoes_cartao_alteracao();
            } else {
                // carrega_cidades();

                // let atual = new Date();

                // let ano = atual.getFullYear();
                // let mes = String(atual.getMonth() + 1).padStart(2, '0');
                // let dia = String(atual.getDate()).padStart(2, '0');
                // let horas = String(atual.getHours()).padStart(2, '0');
                // let minutos = String(atual.getMinutes()).padStart(2, '0');

                // // Formato aceito por <input type="datetime-local">
                // let data_formatada = `${ano}-${mes}-${dia}T${horas}:${minutos}`;

                // console.log("Data formatada para input datetime-local:", data_formatada);
                // document.getElementById('created_at').value = data_formatada;
            }
        }

        buscar_informacoes_cartao();
    });

    async function popula_informacoes_cartao_alteracao() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_cartao.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_cartao": "buscar_informacoes_cartao_alteracao",
                    valor_codigo_cartao_alteracao: recebe_codigo_alteracao_cartao,
                },
                success: function(resposta_cartao) {
                    debugger;
                    console.log(resposta_cartao);

                    if (resposta_cartao.length > 0) {
                        for (let indice = 0; indice < resposta_cartao.length; indice++) {
                            $("#cartao-id-alteracao").val(resposta_cartao[indice].id);
                            $("#valor").val(resposta_cartao[indice].valor);
                        }
                    }

                    resolve(); // sinaliza que terminou
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar cartao:" + error);
                    reject(error);
                },
            });
        });
    }

    $("#grava-cartao").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_valor = $("#valor").val();

        if (recebe_acao_alteracao_cartao === "editar") {
            $.ajax({
                url: "cadastros/processa_cartao.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cartao: "alterar_cartao",
                    valor_cartao: recebe_valor,
                    valor_id_cartao: $("#cartao-id-alteracao").val(),
                },
                success: function(retorno_cartao) {
                    debugger;

                    console.log(retorno_cartao);
                    if (retorno_cartao) {
                        console.log("Cartão alterado com sucesso");
                        window.location.href = "painel.php?pg=cartao";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir cartao:" + error);
                },
            });
        } else {
            $.ajax({
                url: "cadastros/processa_cartao.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cartao: "inserir_cartao",
                    recebe_valor_cartao: recebe_valor,
                },
                success: function(retorno_cartao) {
                    debugger;

                    console.log(retorno_cartao);

                    if (retorno_cartao) {
                        console.log("Cartão cadastrado com sucesso");
                        window.location.href = "painel.php?pg=cartao";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir cartão:" + error);
                },
            });
        }
    });
</script>