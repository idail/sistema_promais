<?php

function buscarClinica($conexao, $id)
{
    $id = intval($id); // Garante que o ID seja um número inteiro para evitar SQL Injection

    $query = "SELECT * FROM clinicas WHERE id = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    return $resultado->fetch_assoc();
}

// Conectar ao banco de dados
// $conexao = new mysqli("localhost", "root", "", "promais")
$conexao = new mysqli("mysql.idailneto.com.br", "idailneto06", "Sei20020615", "idailneto06");

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8");

// Obtendo o ID da URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$clinica = buscarClinica($conexao, $id);

$conexao->close();

?>

<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form method="post" id="empresaForm" class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <input type="hidden" id="codigo-clinica-alteracao" name="codigo_clinica_alteracao" value="<?php echo $clinica["id"]; ?>">

            <div class="form-group">
                <label for="created_at">Data de Cadastro:</label>
                <div class="input-with-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="datetime-local" value="<?= htmlspecialchars($clinica['created_at'] ?? '') ?>" id="created_at" name="created_at" class="form-control" readonly>
                </div>
            </div>

            <div class="form-columns">
                <div class="form-column">
                    <div class="form-group">
                        <label for="cnpj">CNPJ:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-address-card"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['cnpj'] ?? '') ?>" id="cnpj" name="cnpj" class="form-control cnpj-input" onblur="fetchCompanyData(this.value)" oninput="formatCNPJ(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nome_fantasia">Nome Fantasia:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-building"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['nome_fantasia'] ?? '') ?>" id="nome_fantasia" name="nome_fantasia" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="razao_social">Razão Social:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-file-signature"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['razao_social'] ?? '') ?>" id="razao_social" name="razao_social" class="form-control">
                        </div>
                    </div>

                    <div class="address-container">
                        <div class="form-group" style="flex: 75%;">
                            <label for="endereco">Endereço:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" value="<?= htmlspecialchars($clinica['endereco'] ?? '') ?>" id="endereco" name="endereco" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 25%; margin-left: 10px;">
                            <label for="numero">Número:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-pin"></i>
                                <input type="text" value="<?= htmlspecialchars($clinica['numero'] ?? '') ?>" id="numero" name="numero" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="address-container">
                        <div class="form-group" style="flex: 75%;">
                            <label for="complemento">Complemento:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-signs"></i>
                                <input type="text" value="<?= htmlspecialchars($clinica['complemento'] ?? '') ?>" id="complemento" name="complemento" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 25%;">
                            <label for="bairro">Bairro:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map"></i>
                                <input type="text" value="<?= htmlspecialchars($clinica['bairro'] ?? '') ?>" id="bairro" name="bairro" class="form-control">
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
                            <input type="text" value="<?= htmlspecialchars($clinica['cep'] ?? '') ?>" id="cep" name="cep" class="form-control" oninput="formatCEP(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" value="<?= htmlspecialchars($clinica['email'] ?? '') ?>" id="email" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['telefone'] ?? '') ?>" id="telefone" name="telefone" class="form-control" oninput="formatPhone(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status: Ativa/Inativa</label>
                        <div class="status-toggle">
                            <input
                                type="checkbox"
                                id="status"
                                name="status"
                                class="toggle-checkbox"

                                <?php if (isset($clinica["status"]) && $clinica["status"] == "Ativo") {
                                    echo 'checked' ?? "";
                                } ?>>
                            <label for="status" class="toggle-label"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: flex-start; gap: 40px;">
                <!-- Coluna esquerda: select + botão -->
                <div class="form-group">
                    <label for="cidade_id_2">Vincular Médico Examinador</label>
                    <div class="input-with-icon" style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-user-md"></i>
                        <select id="medico-associado" name="medico_associado" class="form-control" style="max-width: 250px;"></select>
                        <button type="button" class="btn btn-primary" id="associar-medico-clinica">Incluir</button>
                    </div>
                </div>

                <!-- Coluna direita: tabela -->
                <div>
                    <table id="tabela-medico-associado" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Médicos examinadores vinculados a essa clinica</th>
                                <th>Opção</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dados serão preenchidos via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>



            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <!-- <div id="profissionais" class="tab-content">
        <p>Conteúdo da aba Profissionais da Medicina Relacionados.</p>
    </div> -->
</div>

<style>
    /* Estilos gerais da tabela */
    #tabela-medico-associado {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #tabela-medico-associado th,
    #tabela-medico-associado td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #tabela-medico-associado th {
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
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    let recebe_codigo_alteracao_clinica;
    let recebe_acao_alteracao_clinica;
    $(document).ready(function(e) {

        debugger;

        let recebe_url_atual = window.location.href;

        let recebe_parametro_acao_clinica = new URLSearchParams(recebe_url_atual.split("&")[1]);

        let recebe_parametro_codigo_clinica = new URLSearchParams(recebe_url_atual.split("&")[2]);

        recebe_codigo_alteracao_clinica = recebe_parametro_codigo_clinica.get("id");

        recebe_acao_alteracao_clinica = recebe_parametro_acao_clinica.get("acao");

        console.log(recebe_codigo_alteracao_clinica);

        async function buscar_informacoes_clinica() {
            debugger;
            if (recebe_acao_alteracao_clinica === "editar") {
                await popula_lista_cidade_clinica_alteracao();
                await popula_medicos_associar_clinica();
                await popula_medicos_associados_clinica();
            } else {
                await popula_medicos_associar_clinica();

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

        carregarCidades();

        buscar_informacoes_clinica();
    });

    // $("#cep").blur(function(e){
    //     e.preventDefault();

    //     let cep = $(this).val();

    //     $.ajax({
    //         url: `https://viacep.com.br/ws/${cep}/json/`,
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(dados) {
    //             debugger;
    //             if (dados.erro) {
    //                 $('#resultado').text('CEP não encontrado.');
    //             } else {
    //                 console.log(dados);
    //                 let cidade = dados.localidade;
    //                 let estado = dados.uf;
    //                 // $('#resultado').text(`${cidade} - ${estado}`);
    //             }
    //         },
    //         error: function() {
    //             $('#resultado').text('Erro ao buscar o CEP.');
    //         }
    //     });
    // });

    async function popula_lista_cidade_clinica_alteracao() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_clinica.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_clinica": "buscar_cidade_clinica",
                    "valor_id_clinica": recebe_codigo_alteracao_clinica,
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

    async function popula_medicos_associar_clinica() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_medico.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_medico": "buscar_medicos_associar_clinica"
                },
                success: function(resposta_medicos) {
                    debugger;
                    console.log(resposta_medicos);
                    if (resposta_medicos.length > 0) {
                        let select_medicos = document.getElementById('medico-associado');
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

    async function popula_medicos_associados_clinica() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_medico.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_medico": "buscar_medicos_associados_clinica",
                    valor_codigo_clinica_medicos_associados: recebe_codigo_alteracao_clinica,
                },
                success: function(resposta_medicos) {
                    debugger;
                    console.log(resposta_medicos);

                    if (resposta_medicos.length > 0) {
                        let recebe_tabela_associar_medico_clinica = document.querySelector(
                            "#tabela-medico-associado tbody"
                        );

                        $("#tabela-medico-associado tbody").html("");

                        for (let indice = 0; indice < resposta_medicos.length; indice++) {
                            recebe_tabela_associar_medico_clinica +=
                                "<tr>" +
                                "<td>" + resposta_medicos[indice].nome_medico + "</td>" +
                                "<td><i class='fas fa-trash' id='exclui-medico-ja-associado'" +
                                " data-codigo-medico-clinica='" + resposta_medicos[indice].id + "' data-codigo-medico='" + resposta_medicos[indice].medico_id + "'></i></td>" +
                                "</tr>";
                        }
                        $("#tabela-medico-associado tbody").append(recebe_tabela_associar_medico_clinica);
                    }else{
                        $("#tabela-medico-associado tbody").html("");
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

        let recebe_codigo_medico_ja_associado = $(this).data("codigo-medico-clinica");

        let recebe_codigo_medico = $(this).data("codigo-medico");

        $.ajax({
            url: "cadastros/processa_clinica.php",
            method: "POST",
            dataType: "json",
            data: {
                "processo_clinica": "desvincular_medico_clinica",
                valor_medico_clinica_id: recebe_codigo_medico_ja_associado,
                valor_codigo_medico: recebe_codigo_medico
            },
            success: function(resposta_medicos_clinicas) {
                debugger;

                console.log(resposta_medicos_clinicas);

                if (resposta_medicos_clinicas) {
                    async function buscar_informacoes_clinica() {
                        debugger;
                        if (recebe_acao_alteracao_clinica === "editar") {
                            await popula_medicos_associados_clinica();
                        }
                    }

                    buscar_informacoes_clinica();
                }
            },
            error: function(xhr, status, error) {

            },
        });
    });

    let valores_codigos_medicos = Array();
    let limpou_tabela_alteracao;

    $("#associar-medico-clinica").click(function(e) {
        e.preventDefault();

        debugger;

        if (recebe_acao_alteracao_clinica === "editar") {
            if (!limpou_tabela_alteracao) {
                $("#tabela-medico-associado tbody").html("");
                limpou_tabela_alteracao = true;
            }

            let recebe_codigo_medico_selecionado_associar_clinica = $("#medico-associado").val();

            let recebe_nome_medico_selecionado_associar_clinica = $('#medico-associado option:selected').text();

            let recebe_tabela_associar_medico_clinica = document.querySelector("#tabela-medico-associado tbody");

            let indice = recebe_tabela_associar_medico_clinica.querySelectorAll("tr").length;

            recebe_tabela_associar_medico_clinica.innerHTML +=
                "<tr data-index='" + indice + "'>" +
                "<td>" + recebe_nome_medico_selecionado_associar_clinica + "</td>" +
                "<td><i class='fas fa-trash' id='exclui-medico-associado'></i></td>" +
                "</tr>";

            valores_codigos_medicos.push(recebe_codigo_medico_selecionado_associar_clinica);
        } else {
            let recebe_codigo_medico_selecionado_associar_clinica = $("#medico-associado").val();

            let recebe_nome_medico_selecionado_associar_clinica = $('#medico-associado option:selected').text();

            console.log(recebe_codigo_medico_selecionado_associar_clinica + " - " + recebe_nome_medico_selecionado_associar_clinica);

            let recebe_tabela_associar_medico_clinica = document.querySelector(
                "#tabela-medico-associado tbody"
            );

            let indice = recebe_tabela_associar_medico_clinica.querySelectorAll("tr").length;

            recebe_tabela_associar_medico_clinica.innerHTML +=
                "<tr data-index='" + indice + "'>" +
                "<td>" + recebe_nome_medico_selecionado_associar_clinica + "</td>" +
                "<td><i class='fas fa-trash' id='exclui-medico-associado'></i></td>" +
                "</tr>";

            valores_codigos_medicos.push(recebe_codigo_medico_selecionado_associar_clinica);

            $("#tabela-medico-associado tbody").append(recebe_tabela_associar_medico_clinica);
        }
    });

    $(document).on("click", "#exclui-medico-associado", function(e) {
        e.preventDefault();

        debugger;

        let linha = $(this).closest("tr");
        let index = linha.data("index");

        linha.remove();

        valores_codigos_medicos.splice(index, 1);

        console.log(valores_codigos_medicos);

        let recebe_tabela_associar_medico_clinica = document.querySelector("#tabela-medico-associado tbody");

        // Pega todas as linhas <tr> dentro do tbody
        let linhas = recebe_tabela_associar_medico_clinica.querySelectorAll("tr");

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
        let value = input.value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        input.value = value;
    }

    function carregarCidades(cidadeSelecionada = '', estadoSelecionado = '') {
        const apiUrl = 'api/list/cidades.php';
        const cidadeSelect = document.getElementById('cidade_id');

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

                    data.data.cidades.forEach(cidade => {
                        const option = document.createElement('option');
                        option.value = cidade.id;
                        option.textContent = `${cidade.nome} - ${cidade.estado}`;
                        cidadeSelect.appendChild(option);
                    });

                    if (cidadeSelecionada) {
                        for (let i = 0; i < cidadeSelect.options.length; i++) {
                            if (cidadeSelect.options[i].text.includes(cidadeSelecionada) &&
                                cidadeSelect.options[i].text.includes(estadoSelecionado)) {
                                cidadeSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }
                } else {
                    console.error('Erro ao carregar cidades:', data.message);
                }
            })
            .catch(error => console.error('Erro na requisição:', error));
    }

    function fetchCompanyData(cnpj) {
        const cleanedCNPJ = cnpj.replace(/[.\/-]/g, '');

        fetch(`https://open.cnpja.com/office/${cleanedCNPJ}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('nome_fantasia').value = data.alias || '';
                document.getElementById('razao_social').value = data.company.name || '';
                document.getElementById('endereco').value = data.address.street || '';
                document.getElementById('numero').value = data.address.number || '';
                document.getElementById('complemento').value = data.address.details || '';
                document.getElementById('bairro').value = data.address.district || '';
                document.getElementById('cep').value = formatCEPValue(data.address.zip || '');
                document.getElementById('email').value = data.emails[0]?.address || '';
                document.getElementById('telefone').value = formatPhoneValue(data.phones[0] ? `${data.phones[0].area}${data.phones[0].number}` : '');

                carregarCidades(data.address.city, data.address.state);

                // const now = new Date();
                // const formattedDateTime = now.toISOString().slice(0, 16);

                // const now = new Date();

                // Formatar data e hora local no formato "dd/mm/yyyy hh:mm"
                // const dia = String(now.getDate()).padStart(2, '0');
                // const mes = String(now.getMonth() + 1).padStart(2, '0'); // mês começa do 0
                // const ano = now.getFullYear();
                // const horas = String(now.getHours()).padStart(2, '0');
                // const minutos = String(now.getMinutes()).padStart(2, '0');

                // const formattedDateTime = `${dia}/${mes}/${ano} ${horas}:${minutos}`;

                // console.log("Hora local:", formattedDateTime);


                // document.getElementById('created_at').value = formattedDateTime;
            })
            .catch(error => console.error('Erro ao buscar CNPJ:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        //carregarCidades();

        // const now = new Date();
        // const formattedDateTime = now.toISOString().slice(0, 16);

        // const now = new Date();

        // Formatar data e hora local no formato "dd/mm/yyyy hh:mm"
        // const dia = String(now.getDate()).padStart(2, '0');
        // const mes = String(now.getMonth() + 1).padStart(2, '0'); // mês começa do 0
        // const ano = now.getFullYear();
        // const horas = String(now.getHours()).padStart(2, '0');
        // const minutos = String(now.getMinutes()).padStart(2, '0');

        // const formattedDateTime = `${dia}/${mes}/${ano} ${horas}:${minutos}`;

        // console.log("Hora local:", formattedDateTime);
        // document.getElementById('created_at').value = formattedDateTime;
    });

    document.getElementById('empresaForm').addEventListener('submit', function(event) {
        event.preventDefault();
        debugger;
        const formData = new FormData(this);
        formData.append("codigos_medicos_associados", JSON.stringify(valores_codigos_medicos));

        console.log(formData);

        if (recebe_acao_alteracao_clinica === "editar") {
            fetch('cadastros/pro_cli_json.php?pg=pro_cli&acao=editar', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    debugger;
                    console.log(data);
                    window.location.href = "painel.php?pg=clinicas";
                })
                .catch((error) => {
                    console.error('Erro:', error);
                });
        } else {
            fetch('cadastros/pro_cli_json.php?pg=pro_cli&acao=cadastrar&tipo=insert', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    debugger;
                    console.log(data);
                    window.location.href = "painel.php?pg=clinicas";
                })
                .catch((error) => {
                    console.error('Erro:', error);
                });
        }
    });
</script>


<!-- Adicione o Font Awesome para os ícones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">