<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<style>
    /* Estilos gerais da tabela */
    #aptidao_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #aptidao_tabela th,
    #aptidao_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #aptidao_tabela th {
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
    <h1 class="dashboard">Aptidão</h1>
</div>

<!-- Botão Cadastrar -->
<div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=grava_aptidao_extra&acao=cadastrar';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div>



<div>
    <table id="aptidao_tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nome</th>
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
    let recebe_tabela_aptidao_extra;
    $(document).ready(function() {
        // Função para buscar dados da API
        function buscar_aptidao_extra() {
            $.ajax({
                url: "cadastros/processa_aptidao_extra.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_aptidao_extra": "busca_aptidao_extra"
                },
                success: function(resposta_aptidao) {
                    debugger;
                    if (resposta_aptidao.length > 0) {
                        console.log(resposta_aptidao);
                        preencher_tabela(resposta_aptidao);
                        inicializarDataTable();
                    } else {
                        preencher_tabela(resposta_aptidao);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        // Função para preencher a tabela com os dados das clínicas
        function preencher_tabela(aptidao) {
            debugger;
            let tbody = document.querySelector("#aptidao_tabela tbody");
            tbody.innerHTML = ""; // Limpa o conteúdo existente

            if (aptidao.length > 0) {
                for (let index = 0; index < aptidao.length; index++) {
                    let aptidao_extra = aptidao[index];

                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${aptidao_extra.id}</td>
                        <td>${aptidao_extra.codigo_aptidao}</td>
                        <td>${aptidao_extra.nome}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="view" title="Visualizar" id='visualizar-informacoes-aptidao-extra' data-codigo-aptidao='${aptidao_extra.id}'>
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?pg=grava_aptidao_extra&acao=editar&id=${aptidao_extra.id}" target="_parent" class="edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" id='excluir-aptidao' data-codigo-aptidao="${aptidao_extra.id}" class="delete" title="Apagar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(row);
                }
            } else {
                $("#aptidao_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
            }
        }

        // Função para inicializar o DataTables
        function inicializarDataTable() {
            recebe_tabela_aptidao_extra = $("#aptidao_tabela").DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "dom": 'lrtip' // Remove a barra de pesquisa padrão
            });
        }

        buscar_aptidao_extra();

        $(".search-bar").on('keyup', function() {
            recebe_tabela_aptidao_extra.search(this.value).draw();
        });

        // async function buscar_informacoes_rapidas_clinica() {
        //     await popula_cidades_informacoes_rapidas();
        // }

        // buscar_informacoes_rapidas_clinica();
    });

    $(document).on("click", "#excluir-aptidao", function(e) {
        e.preventDefault();

        debugger;

        let recebe_id_aptidao = $(this).data("codigo-aptidao");

        let recebe_resposta_excluir_aptidao = window.confirm(
            "Tem certeza que deseja excluir a aptidão?"
        );

        if (recebe_resposta_excluir_aptidao) {
            $.ajax({
                url: "cadastros/processa_aptidao_extra.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_aptidao_extra: "excluir_aptidao",
                    valor_id_aptidao: recebe_id_aptidao,
                },
                success: function(retorno_aptidao) {
                    debugger;
                    console.log(retorno_aptidao);
                    if (retorno_aptidao) {
                        window.location.href = "painel.php?pg=aptidao_extra";
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

    $(document).on("click", "#visualizar-informacoes-aptidao-extra", function(e) {
        debugger;
        recebe_codigo_pessoa_informacoes_rapida = $(this).data("codigo-aptidao");

        $.ajax({
            url: "cadastros/processa_aptidao_extra.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_aptidao_extra": "buscar_informacoes_rapidas_aptidao_extra",
                "valor_codigo_aptidao_extra_informacoes_rapidas": recebe_codigo_pessoa_informacoes_rapida,
            },
            success: function(resposta) {
                debugger;

                if (resposta.length > 0) {
                    for (let indice = 0; indice < resposta.length; indice++) {
                        // $("#created_at").val(resposta[indice].created_at);
                        $("#codigo_aptidao").val(resposta[indice].codigo_aptidao);
                        $("#nome_aptidao").val(resposta[indice].nome);
                    }
                }
            },
            error: function(xhr, status, error) {

            },
        });
        document.getElementById('informacoes-aptidao-extra').classList.remove('hidden'); // abrir
    });

    $(document).on("click", "#fechar-modal-informacoes-aptidao-extra", function(e) {
        debugger;
        document.getElementById('informacoes-aptidao-extra').classList.add('hidden'); // fechar
    });
</script>

<!-- Modal -->
<div id="informacoes-aptidao-extra"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-6 relative">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Informações da Aptidão Extra</h2>
            <button id="fechar-modal-informacoes-aptidao-extra" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
        </div>

        <!-- Corpo da modal -->
        <form method="post" id="empresaForm" class="space-y-6 text-sm text-gray-700">
            <!-- Data de Cadastro -->
            <!-- <div class="form-group">
                <label for="created_at" class="block font-semibold mb-1">Data de Cadastro:</label>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-gray-500"></i>
                    <input type="datetime-local" value="" id="created_at" name="created_at" class="form-control w-full" readonly>
                </div>
            </div> -->

            <!-- Grid com 2 colunas maiores -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="nome">Código:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-user text-gray-500"></i>
                        <input type="text" id="codigo_aptidao" name="codigo_aptidao" disabled class="form-control w-full">
                    </div>
                </div>

                <div class="form-group">
                    <label for="cpf">Nome:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-address-card text-gray-500"></i>
                        <input type="text" id="nome_aptidao" name="nome_aptidao" disabled class="form-control w-full">
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-between mt-6">
                <button id="fechar-modal-informacoes-aptidao-extra" type="button"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">Fechar</button>
            </div>
        </form>
    </div>
</div>