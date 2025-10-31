<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<style>
    /* Estilos gerais da tabela */
    #treinamento_capacitacao_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #treinamento_capacitacao_tabela th,
    #treinamento_capacitacao_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #treinamento_capacitacao_tabela th {
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
    <h1 class="dashboard">Usuários</h1>
</div>

<!-- Botão Cadastrar -->
<div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=grava_treinamento_capacitacao&acao=cadastrar';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div>



<div>
    <table id="usuario_tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Nivel Acesso</th>
                <th>Data Criação</th>
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
    let recebe_tabela_usuarios;
    $(document).ready(function() {
        // Função para buscar dados da API
        function buscar_usuarios() {
            $.ajax({
                url: "cadastros/processa_usuario.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_usuario": "buscar_usuarios"
                },
                success: function(resposta_usuario) {
                    debugger;
                    if (resposta_usuario.length > 0) {
                        console.log(resposta_usuario);
                        preencher_tabela(resposta_usuario);
                        inicializarDataTable();
                    } else {
                        preencher_tabela(resposta_usuario);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        // Função para preencher a tabela com os dados das clínicas
        function preencher_tabela(usuarios) {
            debugger;
            let tbody = document.querySelector("#usuario_tabela tbody");
            tbody.innerHTML = ""; // Limpa o conteúdo existente

            if (usuarios.length > 0) {
                for (let index = 0; index < usuarios.length; index++) {
                    let usuario = usuarios[index];

                    const dataObj = new Date(usuario.criado_em.replace(" ", "T")); // substitui espaço por T para o padrão ISO
                    const dataFormatada = dataObj.toLocaleDateString("pt-BR", {
                        timeZone: "America/Sao_Paulo"
                    });

                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${usuario.id}</td>
                        <td>${usuario.nome}</td>
                        <td>${usuario.email}</td>
                        <td>${usuario.nivel_acesso}</td>
                        <td>${dataFormatada}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="?pg=grava_treinamento_capacitacao&acao=editar&id=${usuario.id}" target="_parent" class="edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" id='excluir-treinamento-capacitacao' data-codigo-treinamento-capacitacao="${usuario.id}" class="delete" title="Apagar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(row);
                }
            } else {
                $("#usuario_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
            }
        }

        // Função para inicializar o DataTables
        function inicializarDataTable() {
            recebe_tabela_usuarios = $("#usuario_tabela").DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "dom": 'lrtip' // Remove a barra de pesquisa padrão
            });
        }

        buscar_usuarios();

        $(".search-bar").on('keyup', function() {
            recebe_tabela_usuarios.search(this.value).draw();
        });

        // async function buscar_informacoes_rapidas_clinica() {
        //     await popula_cidades_informacoes_rapidas();
        // }

        // buscar_informacoes_rapidas_clinica();
    });

    // $(document).on("click", "#excluir-treinamento-capacitacao", function(e) {
    //     e.preventDefault();

    //     debugger;

    //     let recebe_id_treinamento_capacitacao = $(this).data("codigo-treinamento-capacitacao");

    //     let recebe_resposta_excluir_treinamento_capacitacao = window.confirm(
    //         "Tem certeza que deseja excluir o treinamento?"
    //     );

    //     if (recebe_resposta_excluir_treinamento_capacitacao) {
    //         $.ajax({
    //             url: "cadastros/processa_treinamento_capacitacao.php",
    //             type: "POST",
    //             dataType: "json",
    //             data: {
    //                 processo_treinamento_capacitacao: "excluir_treinamento_capacitacao",
    //                 valor_codigo_treinamento_capacitacao: recebe_id_treinamento_capacitacao,
    //             },
    //             success: function(retorno_treinamento_capacitacao) {
    //                 debugger;
    //                 console.log(retorno_treinamento_capacitacao);
    //                 if (retorno_treinamento_capacitacao) {
    //                     window.location.href = "painel.php?pg=treinamento_capacitacao";
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.log("Falha ao excluir treinamento:" + error);
    //             },
    //         });
    //     } else {
    //         return;
    //     }
    // });

    // $(document).on("click", "#visualizar-informacoes-treinamento-capacitacao", function(e) {
    //     debugger;
    //     recebe_codigo_treinamento_capacitacao_informacoes_rapida = $(this).data("codigo-treinamento-capacitacao");

    //     $.ajax({
    //         url: "cadastros/processa_treinamento_capacitacao.php",
    //         method: "GET",
    //         dataType: "json",
    //         data: {
    //             "processo_treinamento_capacitacao": "buscar_informacoes_rapidas_treinamento_capacitacao",
    //             "valor_codigo_treinamento_capacitacao_informacoes_rapidas": recebe_codigo_treinamento_capacitacao_informacoes_rapida,
    //         },
    //         success: function(resposta) {
    //             debugger;

    //             if (resposta.length > 0) {
    //                 for (let indice = 0; indice < resposta.length; indice++) {
    //                     // $("#created_at").val(resposta[indice].created_at);
    //                     $("#codigo").val(resposta[indice].codigo_treinamento_capacitacao);
    //                     $("#nome").val(resposta[indice].nome);
    //                     $("#valor").val(resposta[indice].valor);
    //                 }
    //             }
    //         },
    //         error: function(xhr, status, error) {

    //         },
    //     });
    //     document.getElementById('informacoes-treinamento-capacitacao').classList.remove('hidden'); // abrir
    // });

    // $(document).on("click", "#fechar-modal-informacoes-treinamento-capacitacao", function(e) {
    //     debugger;
    //     document.getElementById('informacoes-treinamento-capacitacao').classList.add('hidden'); // fechar
    // });
</script>

<!-- Modal -->
<div id="informacoes-treinamento-capacitacao"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-6 relative">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Informações da Treinamento/Capacitação</h2>
            <button id="fechar-modal-informacoes-treinamento-capacitacao" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
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
                    <label for="codigo">Código:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-user text-gray-500"></i>
                        <input type="text" id="codigo" name="codigo" disabled class="form-control w-full">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-address-card text-gray-500"></i>
                        <input type="text" id="nome" name="nome" disabled class="form-control w-full">
                    </div>
                </div>

                <div class="form-group" style="flex: 50%;">
                    <label for="valor">Valor:</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <!-- <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)"> -->
                        <input type="text" id="valor" name="valor" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-between mt-6">
                <button id="fechar-modal-informacoes-treinamento-capacitacao" type="button"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">Fechar</button>
            </div>
        </form>
    </div>
</div>