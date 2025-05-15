<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<style>
    /* Estilos gerais da tabela */
    #pessoas_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #pessoas_tabela th,
    #pessoas_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #pessoas_tabela th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    /* Estilos para os botões de ação */
    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .action-buttons a {
        color: #333;
        text-decoration: none;
        font-size: 14px;
    }

    .action-buttons a:hover {
        opacity: 0.8;
    }

    .action-buttons .view {
        color: rgb(43, 94, 148);
    }

    .action-buttons .edit {
        color: rgb(33, 158, 127);
    }

    .action-buttons .delete {
        color: rgb(247, 109, 55);
    }

    /* Estilos para o título */
    .dashboard {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Estilo para o botão Cadastrar */
    .btn-cadastrar {
        background-color: rgb(73, 73, 73);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .btn-cadastrar:hover {
        background-color: rgb(0, 110, 81);
    }

    .dataTables_filter {
        padding-bottom: 20px;
    }


    .tab-container {
        width: 100%;
    }

    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #ccc;
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
</style>

<div>
    <h1 class="dashboard">Pessoas</h1>
</div>

<!-- Botão Cadastrar -->
<div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=grava_pessoa&acao=cadastrar';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div>



<div>
    <table id="pessoas_tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Nascimento</th>
                <th>Sexo</th>
                <th>Ações</th> <!-- Nova coluna para os botões de ação -->
            </tr>
        </thead>
        <tbody>
            <!-- Dados serão preenchidos via JavaScript -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    let recebe_codigo_clinica_informacoes_rapida;
    $(document).ready(function() {
        // Função para buscar dados da API
        function buscar_pessoas() {
            $.ajax({
                url: "cadastros/processa_pessoa.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_pessoa": "buscar_pessoas"
                },
                success: function(resposta_pessoa) {
                    debugger;
                    if (resposta_pessoa.length > 0) {
                        console.log(resposta_pessoa);
                        preencher_tabela(resposta_pessoa);
                        inicializarDataTable();
                    } else {
                        preencher_tabela(resposta_pessoa);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        // Função para preencher a tabela com os dados das clínicas
        function preencher_tabela(pessoas) {
            debugger;
            let tbody = document.querySelector("#pessoas_tabela tbody");
            tbody.innerHTML = ""; // Limpa o conteúdo existente

            if (pessoas.length > 0) {
                for (let index = 0; index < pessoas.length; index++) {
                    let pessoa = pessoas[index];

                    // Separar o endereço
                    // let partesEndereco = pessoa.endereco.split(',');
                    // let ruaNumero = `${partesEndereco[0] || ''}, ${partesEndereco[1] || ''}`;
                    // let cidadeEstado = `${(partesEndereco[2] || '').trim()} / ${(partesEndereco[3] || '').trim()}`;

                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${pessoa.id}</td>
                        <td>${pessoa.nome}</td>
                        <td>${pessoa.telefone}</td>
                        <td>${pessoa.cpf}</td>
                        <td>${pessoa.nascimento}</td>
                        <td>${pessoa.sexo}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="view" title="Visualizar" id='visualizar-informacoes-pessoa' data-codigo-clinica='${pessoa.id}'>
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?pg=grava_pessoa&acao=editar&id=${pessoa.id}" target="_parent" class="edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" id='excluir-pessoa' data-codigo-pessoa="${pessoa.id}" class="delete" title="Apagar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(row);
                }
            } else {
                $("#pessoas_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
            }
        }

        // Função para inicializar o DataTables
        function inicializarDataTable() {
            $('#pessoas_tabela').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            });
        }

        buscar_pessoas();

        // async function buscar_informacoes_rapidas_clinica() {
        //     await popula_cidades_informacoes_rapidas();
        // }

        // buscar_informacoes_rapidas_clinica();
    });

    $(document).on("click", "#excluir-pessoa", function(e) {
        e.preventDefault();

        debugger;

        let recebe_id_pessoa = $(this).data("codigo-pessoa");

        let recebe_resposta_excluir_pessoa = window.confirm(
            "Tem certeza que deseja excluir a pessoa?"
        );

        if (recebe_resposta_excluir_pessoa) {
            $.ajax({
                url: "cadastros/processa_pessoa.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_pessoa: "excluir_pessoa",
                    valor_id_pessoa: recebe_id_pessoa,
                },
                success: function(retorno_pessoa) {
                    debugger;
                    console.log(retorno_pessoa);
                    if (retorno_pessoa) {
                        window.location.href = "painel.php?pg=pessoas";
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

    $(document).on("click", "#visualizar-informacoes-clinica", function(e) {
        debugger;
        recebe_codigo_clinica_informacoes_rapida = $(this).data("codigo-clinica");

        $.ajax({
            url: "cadastros/processa_clinica.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_clinica": "buscar_informacoes_rapidas_clinicas",
                "valor_id_clinica_informacoes_rapidas": recebe_codigo_clinica_informacoes_rapida,
            },
            success: function(resposta) {
                debugger;

                if (resposta.length > 0) {
                    for (let indice = 0; indice < resposta.length; indice++) {
                        $("#created_at").val(resposta[indice].created_at);
                        $("#cnpj").val(resposta[indice].cnpj);
                        $("#nome_fantasia").val(resposta[indice].nome_fantasia);
                        $("#razao_social").val(resposta[indice].razao_social);
                        $("#endereco").val(resposta[indice].endereco);
                        $("#numero").val(resposta[indice].numero);
                        $("#complemento").val(resposta[indice].complemento);
                        $("#bairro").val(resposta[indice].bairro);
                        $("#cidade_id").val(resposta[indice].cidade_id);
                        $("#cep").val(resposta[indice].cep);
                        $("#email").val(resposta[indice].email);
                        $("#telefone").val(resposta[indice].telefone);

                        let recebe_status_clinica;
                        if (resposta[indice].status === "Ativo")
                            $("#status").prop("checked", true);
                        else
                            $("#status").prop("checked", false);

                        async function exibi_medicos_associados_clinica() {
                            await popula_medicos_associados_clinica();
                        }

                        exibi_medicos_associados_clinica();
                    }
                }
            },
            error: function(xhr, status, error) {

            },
        });
        document.getElementById('informacoes-clinica').classList.remove('hidden'); // abrir
    });

    $(document).on("click", "#fechar-modal-informacoes-clinica", function(e) {
        debugger;
        document.getElementById('informacoes-clinica').classList.add('hidden'); // fechar
    });

    async function popula_cidades_informacoes_rapidas(cidadeSelecionada = "", estadoSelecionado = "") {
        debugger;
        const apiUrl = 'api/list/cidades.php';
        const cidadeSelect = document.getElementById('cidade_id');

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            if (data.status === 'success') {
                cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

                data.data.cidades.forEach(cidade => {
                    const option = document.createElement('option');
                    option.value = cidade.id;
                    option.textContent = `${cidade.nome} - ${cidade.estado}`;
                    cidadeSelect.appendChild(option);
                });

                if (cidadeSelecionada && estadoSelecionado) {
                    for (let i = 0; i < cidadeSelect.options.length; i++) {
                        const optionText = cidadeSelect.options[i].text;
                        if (optionText.includes(cidadeSelecionada) && optionText.includes(estadoSelecionado)) {
                            cidadeSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
            } else {
                console.error('Erro ao carregar cidades:', data.message);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
        }
    }

    async function popula_medicos_associados_clinica() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_medico.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_medico": "buscar_medicos_associados_clinica",
                    valor_codigo_clinica_medicos_associados: recebe_codigo_clinica_informacoes_rapida,
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
                                // "<td><i class='fas fa-trash' id='exclui-medico-ja-associado'" +
                                // " data-codigo-medico-clinica='" + resposta_medicos[indice].id + "' data-codigo-medico='" + resposta_medicos[indice].medico_id + "'></i></td>" +
                                "</tr>";
                        }
                        $("#tabela-medico-associado tbody").append(recebe_tabela_associar_medico_clinica);
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
</script>

<!-- Modal -->
<div id="informacoes-clinica"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-6 relative">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Informações da Clínica</h2>
            <button id="fechar-modal-informacoes-clinica" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
        </div>

        <!-- Corpo da modal -->
        <form method="post" id="empresaForm" class="space-y-6 text-sm text-gray-700">
            <!-- Data de Cadastro -->
            <div class="form-group">
                <label for="created_at" class="block font-semibold mb-1">Data de Cadastro:</label>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-gray-500"></i>
                    <input type="datetime-local" value="" id="created_at" name="created_at" class="form-control" readonly>
                </div>
            </div>

            <!-- Colunas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Coluna 1 -->
                <div class="space-y-4">
                    <div>
                        <label for="cnpj" class="block font-semibold mb-1">CNPJ:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-address-card text-gray-500"></i>
                            <input type="text" value="" id="cnpj" name="cnpj" class="form-control cnpj-input">
                        </div>
                    </div>

                    <div>
                        <label for="nome_fantasia" class="block font-semibold mb-1">Nome Fantasia:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building text-gray-500"></i>
                            <input type="text" value="teste" id="nome_fantasia" name="nome_fantasia" class="form-control">
                        </div>
                    </div>

                    <div>
                        <label for="razao_social" class="block font-semibold mb-1">Razão Social:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-file-signature text-gray-500"></i>
                            <input type="text" id="razao_social" name="razao_social" class="form-control">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="endereco" class="block font-semibold mb-1">Endereço:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-gray-500"></i>
                                <input type="text" id="endereco" name="endereco" class="form-control">
                            </div>
                        </div>
                        <div class="w-1/3">
                            <label for="numero" class="block font-semibold mb-1">Número:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-pin text-gray-500"></i>
                                <input type="text" id="numero" name="numero" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="complemento" class="block font-semibold mb-1">Complemento:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-signs text-gray-500"></i>
                                <input type="text" id="complemento" name="complemento" class="form-control">
                            </div>
                        </div>
                        <div class="w-1/3">
                            <label for="bairro" class="block font-semibold mb-1">Bairro:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map text-gray-500"></i>
                                <input type="text" id="bairro" name="bairro" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2 -->
                <div class="space-y-4">
                    <div>
                        <label for="cidade_id" class="block font-semibold mb-1">Cidade:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-city text-gray-500"></i>
                            <select id="cidade_id" name="cidade_id" class="form-control"></select>
                        </div>
                    </div>

                    <div>
                        <label for="cep" class="block font-semibold mb-1">CEP:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-marked-alt text-gray-500" id="cep"></i>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block font-semibold mb-1">Email:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-envelope text-gray-500"></i>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>

                    <div>
                        <label for="telefone" class="block font-semibold mb-1">Telefone:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone text-gray-500"></i>
                            <input type="text" id="telefone" name="telefone" class="form-control" oninput="formatPhone(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status: Ativa/Inativa</label>
                        <div class="status-toggle">
                            <input
                                type="checkbox"
                                id="status"
                                name="status"
                                class="toggle-checkbox">
                            <label for="status" class="toggle-label"></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Médicos Vinculados -->
            <div class="mt-8 space-y-4">
                <!-- <label for="medico-associado" class="block font-semibold">Vincular Médico Examinador</label>
                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-md text-gray-500"></i>
                        <select id="medico-associado" name="medico_associado" class="form-control w-64"></select>
                    </div>
                    <button type="button" class="btn btn-primary" id="associar-medico-clinica">Incluir</button>
                </div> -->

                <table id="tabela-medico-associado" class="table table-bordered w-full mt-4">
                    <thead>
                        <tr>
                            <th>Médicos examinadores vinculados a essa clínica</th>
                            <th>Opção</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dados via JS -->
                    </tbody>
                </table>
            </div>

            <!-- Botões -->
            <div class="flex justify-between mt-6">
                <button id="fechar-modal-informacoes-clinica" type="button"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">Fechar</button>
                <!-- <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Salvar</button> -->
            </div>
        </form>
    </div>
</div>