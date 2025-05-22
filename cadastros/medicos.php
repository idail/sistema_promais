<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<style>
    /* Estilos gerais da tabela */
    #medicos_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #medicos_tabela th,
    #medicos_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #medicos_tabela th {
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
    <h1 class="dashboard">Médicos</h1>
</div>

<!-- Botão Cadastrar -->
<div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=grava_medico&acao=cadastrar';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div>



<div>
    <table id="medicos_tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Número Registro</th>
                <th>Data Cadastro</th>
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
    let recebe_codigo_medico_informacoes_rapida;
    let recebe_tabela_medicos;
    $(document).ready(function() {
        // Função para buscar dados da API
        function buscar_medicos() {
            $.ajax({
                url: "cadastros/processa_medico.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_medico": "buscar_medicos"
                },
                success: function(retorno_medico) {
                    debugger;
                    if (retorno_medico.length > 0) {
                        preencherTabela(retorno_medico);
                        inicializarDataTable();
                    } else {
                        console.error("Erro ao buscar dados:", response.message);
                        preencherTabela(retorno_medico);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        // Função para preencher a tabela com os dados das clínicas
        function preencherTabela(medicos) {
            debugger;
            const tbody = document.querySelector("#medicos_tabela tbody");
            tbody.innerHTML = ""; // Limpa o conteúdo existente
            if (medicos.length > 0) {
                for (let i = 0; i < medicos.length; i++) {
                    const medico = medicos[i];

                    let data_cadastro_formatada = "";
                    if (medico.created_at) {
                        let data = new Date(medico.created_at);
                        data_cadastro_formatada = data.toLocaleDateString("pt-BR");
                    }

                    const row = document.createElement("tr");
                    row.innerHTML = `
                <td>${medico.id}</td>
                <td>${medico.nome}</td>
                <td>${medico.cpf}</td>
                <td>${medico.pcmso}</td>
                <td>${data_cadastro_formatada}</td>
                <td>
                <div class="action-buttons">
                    <a href="#" class="view" title="Visualizar" id='visualizar-informacoes-medico' data-codigo-medico='${medico.id}'>
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="?pg=grava_medico&acao=editar&id=${medico.id}" target="_parent" class="edit" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" id='excluir-medico' data-codigo-medico="${medico.id}" class="delete" title="Apagar">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                </td>
                `;
                    tbody.appendChild(row);
                }
            } else {
                $("#medicos_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
            }
        }


        // Função para inicializar o DataTables
        function inicializarDataTable() {
            recebe_tabela_medicos = $('#medicos_tabela').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "dom": 'lrtip' // Remove a barra de pesquisa padrão
            });
        }

        // Iniciar a busca dos dados ao carregar a página
        buscar_medicos();

        $(".search-bar").on('keyup', function() {
            recebe_tabela_medicos.search(this.value).draw();
        });

        async function buscar_informacoes_rapidas_clinica() {
            await popula_cidades_informacoes_rapidas();
        }

        buscar_informacoes_rapidas_clinica();
    });

    $(document).on("click", "#excluir-medico", function(e) {
        e.preventDefault();

        debugger;

        let recebe_id_medico = $(this).data("codigo-medico");

        let recebe_resposta_excluir_medico = window.confirm(
            "Tem certeza que deseja excluir o médico?"
        );

        if (recebe_resposta_excluir_medico) {
            $.ajax({
                url: "cadastros/processa_medico.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_medico: "excluir_medico",
                    valor_id_medico: recebe_id_medico,
                },
                success: function(retorno_medico) {
                    debugger;
                    console.log(retorno_medico);
                    if (retorno_medico) {
                        window.location.href = "painel.php?pg=medicos";
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

    $(document).on("click", "#visualizar-informacoes-medico", function(e) {
        debugger;
        recebe_codigo_medico_informacoes_rapida = $(this).data("codigo-medico");

        $.ajax({
            url: "cadastros/processa_medico.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_medico": "buscar_informacoes_rapidas_medicos",
                "valor_codigo_medico_informacoes_rapidas": recebe_codigo_medico_informacoes_rapida,
            },
            success: function(resposta) {
                debugger;

                if (resposta.length > 0) {
                    for (let indice = 0; indice < resposta.length; indice++) {
                        $("#created_at").val(resposta[indice].created_at);
                        $("#nome").val(resposta[indice].nome);
                        $("#cpf").val(resposta[indice].cpf);
                        $("#nascimento").val(resposta[indice].nascimento);
                        $("#sexo").val(resposta[indice].sexo);
                        $("#uf_rg").val(resposta[indice].uf_rg);
                        $("#documento_classe").val(resposta[indice].documento_classe);
                        $("#n_documento_classe").val(resposta[indice].n_documento_classe);
                        $("#uf_documento_classe").val(resposta[indice].uf_documento_classe);
                        $("#crm").val(resposta[indice].crm);
                        $("#contato").val(resposta[indice].contato);

                        let recebe_status_medico;
                        if (resposta[indice].status === "Ativo")
                            $("#status").prop("checked", true);
                        else
                            $("#status").prop("checked", false);
                    }
                }
            },
            error: function(xhr, status, error) {

            },
        });
        document.getElementById('informacoes-medico').classList.remove('hidden'); // abrir
    });

    $(document).on("click", "#fechar-modal-informacoes-medico", function(e) {
        debugger;
        document.getElementById('informacoes-medico').classList.add('hidden'); // fechar
    });

    // async function popula_cidades_informacoes_rapidas(cidadeSelecionada = "", estadoSelecionado = "")
    // {
    //     debugger;
    //     const apiUrl = 'api/list/cidades.php';
    //     const cidadeSelect = document.getElementById('cidade_id');

    //     try {
    //         const response = await fetch(apiUrl);
    //         const data = await response.json();

    //         if (data.status === 'success') {
    //             cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

    //             data.data.cidades.forEach(cidade => {
    //                 const option = document.createElement('option');
    //                 option.value = cidade.id;
    //                 option.textContent = `${cidade.nome} - ${cidade.estado}`;
    //                 cidadeSelect.appendChild(option);
    //             });

    //             if (cidadeSelecionada && estadoSelecionado) {
    //                 for (let i = 0; i < cidadeSelect.options.length; i++) {
    //                     const optionText = cidadeSelect.options[i].text;
    //                     if (optionText.includes(cidadeSelecionada) && optionText.includes(estadoSelecionado)) {
    //                         cidadeSelect.selectedIndex = i;
    //                         break;
    //                     }
    //                 }
    //             }
    //         } else {
    //             console.error('Erro ao carregar cidades:', data.message);
    //         }
    //     } catch (error) {
    //         console.error('Erro na requisição:', error);
    //     }
    // }

    // async function popula_medicos_associados_clinica() {
    //     return new Promise((resolve, reject) => {
    //         $.ajax({
    //             url: "cadastros/processa_medico.php",
    //             method: "GET",
    //             dataType: "json",
    //             data: {
    //                 "processo_medico": "buscar_medicos_associados_clinica",
    //                 valor_codigo_clinica_medicos_associados: recebe_codigo_clinica_informacoes_rapida,
    //             },
    //             success: function(resposta_medicos) {
    //                 debugger;
    //                 console.log(resposta_medicos);

    //                 if (resposta_medicos.length > 0) {
    //                     let recebe_tabela_associar_medico_clinica = document.querySelector(
    //                         "#tabela-medico-associado tbody"
    //                     );

    //                     $("#tabela-medico-associado tbody").html("");

    //                     for (let indice = 0; indice < resposta_medicos.length; indice++) {
    //                         recebe_tabela_associar_medico_clinica +=
    //                             "<tr>" +
    //                             "<td>" + resposta_medicos[indice].nome_medico + "</td>" +
    //                             // "<td><i class='fas fa-trash' id='exclui-medico-ja-associado'" +
    //                             // " data-codigo-medico-clinica='" + resposta_medicos[indice].id + "' data-codigo-medico='" + resposta_medicos[indice].medico_id + "'></i></td>" +
    //                             "</tr>";
    //                     }
    //                     $("#tabela-medico-associado tbody").append(recebe_tabela_associar_medico_clinica);
    //                 }

    //                 resolve(); // sinaliza que terminou
    //             },
    //             error: function(xhr, status, error) {
    //                 console.log("Falha ao buscar médicos:" + error);
    //                 reject(error);
    //             },
    //         });
    //     });
    // }
</script>

<!-- Modal -->
<div id="informacoes-medico"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-6 relative">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Informações do Médico</h2>
            <button id="fechar-modal-informacoes-medico" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
        </div>

        <!-- Corpo da modal -->
        <form method="post" id="empresaForm" class="space-y-6 text-sm text-gray-700">
            <!-- Data de Cadastro -->
            <div class="form-group">
                <label for="created_at" class="block font-semibold mb-1">Data de Cadastro:</label>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-gray-500"></i>
                    <input type="datetime-local" value="" id="created_at" name="created_at" class="form-control w-full" readonly>
                </div>
            </div>

            <!-- Grid com 2 colunas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Coluna 1 -->
                <div class="space-y-4">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-address-card text-gray-500"></i>
                            <input type="text" value="" id="nome" name="nome" class="form-control w-full">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-id-card text-gray-500"></i>
                            <input type="text" id="cpf" name="cpf" class="form-control w-full">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="crm">CRM:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-file-signature text-gray-500"></i>
                            <input type="text" id="crm" name="crm" class="form-control w-full">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contato">Contato:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-phone text-gray-500"></i>
                            <input type="text" id="contato" name="contato" class="form-control w-full">
                        </div>
                    </div>

                    <!-- Sexo -->
                    <div class="form-group">
                        <label for="sexo_medico">Sexo:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-mars text-gray-500"></i>
                            <select id="sexo_medico" name="sexo_medico" class="form-control w-full">
                                <option value="selecione">Selecione</option>
                                <option value="feminino">Feminino</option>
                                <option value="masculino">Masculino</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="uf_rg">UF/RG:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-gray-500"></i>
                            <input type="text" id="uf_rg" name="uf_rg" class="form-control w-full">
                        </div>
                    </div>
                </div>

                <!-- Coluna 2 -->
                <div class="space-y-4">
                    <div class="form-group">
                        <label for="documento_classe">Documento de Classe:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-address-card text-gray-500"></i>
                            <select id="documento_classe" name="documento_classe" class="form-control w-full">
                                <option value="selecione">Selecione</option>
                                <option value="RQE">RQE</option>
                                <option value="CRM">CRM</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="numero_documento_classe">N° Documento de Classe:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-id-card text-gray-500"></i>
                            <input type="text" id="numero_documento_classe" name="numero_documento_classe" class="form-control w-full">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="uf_documento_classe">UF/Documento de Classe:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-gray-500"></i>
                            <input type="text" id="uf_documento_classe" name="uf_documento_classe" class="form-control w-full">
                        </div>
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="form-group">
                        <label for="nascimento">Data Nascimento:</label>
                        <div class="input-with-icon flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-gray-500"></i>
                            <input type="date" id="nascimento" name="nascimento" class="form-control w-full">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-between mt-6">
                <button id="fechar-modal-informacoes-medico" type="button"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">Fechar</button>
            </div>
        </form>
    </div>
</div>