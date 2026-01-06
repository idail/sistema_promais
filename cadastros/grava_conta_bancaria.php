<style>
    /* Reaproveitando os estilos da tela modelo */
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

    /* --- Botões --- */
    .btn {
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 10px;
        box-shadow: 0px 3px 5px -3px rgba(0, 0, 0, 0.2);
    }

    .btn-primary {
        background-color: #3b3b3b;
        color: white;
    }

    .btn-primary:hover {
        background-color: #222;
    }

    .botao-cinza {
        background-color: #e0e0e0;
        color: #333;
    }

    .botao-cinza:hover {
        background-color: #c9c9c9;
    }

    /* Container dos botões alinhados à direita */
    .form-actions {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
    }
</style>

<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">
            <input type="hidden" name="conta_bancaria_id_alteracao" id="conta-bancaria-id-alteracao">

            <div class="form-columns">
                <div class="form-column">
                    <div class="form-group">
                        <label for="agencia">Agência:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-university"></i>
                            <input type="text" id="agencia" name="agencia" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="conta">Conta:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-credit-card"></i>
                            <input type="text" id="conta" name="conta" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="estado">PIX:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-money-bill-wave"></i>

                            <select id="tipo-pix" name="tipo_pix" class="form-control">
                                <option value="">Selecione</option>
                                <option value="TELEFONE">Telefone</option>
                                <option value="CPF">CPF</option>
                                <option value="CNPJ">CNPJ</option>
                                <option value="EMAIL">E-mail</option>
                                <option value="ALEATORIA">Aleatoria</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="conta">Valor PIX:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-credit-card"></i>
                            <input type="text" id="valor-pix" name="valor_pix" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="estado">Tipo Orçamento:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <select id="tipo-orcamento" name="tipo_pix" class="form-control">
                                <option value="">Selecione</option>
                                <option value="exames_procedimentos">Exames e Procedimentos</option>
                                <option value="treinamentos">Treinamentos</option>
                                <option value="epi_epc">EPI/EPC</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="form-actions">
                <button type="button" class="btn btn-primary" id="grava-conta-bancaria">Salvar</button>
                <button type="button" id="retornar-listagem-empresas" class="btn botao-cinza">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    let recebe_codigo_alteracao_conta_bancaria;
    let recebe_acao_alteracao_conta_bancaria = "cadastrar";

    $(document).ready(function(e) {
        debugger;
        let recebe_url_atual = window.location.href;

        let recebe_parametro_acao_conta_bancaria = new URLSearchParams(recebe_url_atual.split("&")[1]);

        let recebe_parametro_codigo_conta_bancaria = new URLSearchParams(recebe_url_atual.split("&")[2]);

        recebe_codigo_alteracao_conta_bancaria = recebe_parametro_codigo_conta_bancaria.get("id");

        let recebe_acao_conta_bancaria = recebe_parametro_acao_conta_bancaria.get("acao");

        if (recebe_acao_conta_bancaria !== "" && recebe_acao_conta_bancaria !== null)
            recebe_acao_alteracao_conta_bancaria = recebe_acao_conta_bancaria;

        async function buscar_informacoes_pessoa() {
            debugger;
            if (recebe_acao_alteracao_pessoa === "editar") {
                // carrega_cidades();
                // await popula_lista_cidade_empresa_alteracao();
                await buscar_informacoes_conta_bancaria();
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

        buscar_informacoes_conta_bancaria();
    });

    $("#retornar-listagem-conta-bancaria").click(function(e) {
        e.preventDefault();

        debugger;

        window.location.href = "painel.php?pg=conta_bancaria";
    });

    async function buscar_informacoes_conta_bancaria() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_conta_bancaria.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_conta_bancaria": "buscar_informacoes_conta_bancaria_alteracao",
                    valor_codigo_conta_bancaria_alteracao: recebe_codigo_alteracao_conta_bancaria,
                },
                success: function(resposta_conta_bancaria) {
                    debugger;
                    console.log(resposta_conta_bancaria);

                    if (resposta_conta_bancaria.length > 0) {
                        for (let indice = 0; indice < resposta_conta_bancaria.length; indice++) {
                            $("#conta-bancaria-id-alteracao").val(resposta_conta_bancaria[indice].id_conta_bancaria);
                            $("#agencia").val(resposta_conta_bancaria[indice].agencia);
                            $("#conta").val(resposta_conta_bancaria[indice].conta);
                            $("#tipo-pix").val(resposta_conta_bancaria[indice].tipo_pix);
                            $("#valor-pix").val(resposta_conta_bancaria[indice].valor_pix);
                            $("#tipo-orcamento").val(resposta_conta_bancaria[indice].tipo_orcamento);
                        }
                    }

                    resolve(); // sinaliza que terminou
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar conta bancária:" + error);
                    reject(error);
                },
            });
        });
    }

    $("#grava-conta-bancaria").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_agencia_conta_bancaria = $("#agencia").val();
        let recebe_conta_bancaria = $("#conta").val();
        let recebe_tipo_pix_conta_bancaria = $("#tipo-pix").val();
        let recebe_valor_pix_conta_bancaria = $("#valor-pix").val();
        let recebe_tipo_orcamento = $("#tipo-orcamento").val();

        if (recebe_acao_alteracao_conta_bancaria === "editar") {
            $.ajax({
                url: "cadastros/processa_conta_bancaria.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_conta_bancaria: "alterar_conta_bancaria",
                    valor_agencia_conta_bancaria: recebe_agencia_conta_bancaria,
                    valor_conta_bancaria: recebe_conta_bancaria,
                    valor_tipo_pix_conta_bancaria: recebe_tipo_pix_conta_bancaria,
                    valor_pix_conta_bancaria: recebe_valor_pix_conta_bancaria,
                    valor_id_conta_bancaria: $("#conta-bancaria-id-alteracao").val(),
                    valor_tipo_orcamento:recebe_tipo_orcamento
                },
                success: function(retorno_conta_bancaria) {
                    debugger;

                    console.log(retorno_conta_bancaria);
                    if (retorno_conta_bancaria) {
                        console.log("Conta bancária alterada com sucesso");
                        window.location.href = "painel.php?pg=contas_bancarias";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        } else {
            $.ajax({
                url: "cadastros/processa_conta_bancaria.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_conta_bancaria: "inserir_conta_bancaria",
                    valor_agencia_conta_bancaria: recebe_agencia_conta_bancaria,
                    valor_conta_bancaria: recebe_conta_bancaria,
                    valor_tipo_pix_conta_bancaria: recebe_tipo_pix_conta_bancaria,
                    valor_pix_conta_bancaria: recebe_valor_pix_conta_bancaria,
                    valor_tipo_orcamento:recebe_tipo_orcamento
                },
                success: function(retorno_conta_bancaria) {
                    debugger;

                    console.log(retorno_conta_bancaria);

                    if (retorno_conta_bancaria) {
                        console.log("Pessoa cadastrada com sucesso");
                        window.location.href = "painel.php?pg=contas_bancarias";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        }
    });
</script>