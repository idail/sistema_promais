<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<style>
    /* Estilos gerais da tabela */
    #contas_bancarias_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #contas_bancarias_tabela th,
    #contas_bancarias_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #contas_bancarias_tabela th {
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
    <h1 class="dashboard">Contas Bancárias</h1>
</div>

<!-- Botão Cadastrar -->
<div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=grava_conta_bancaria&acao=cadastrar';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div>



<div>
    <table id="contas_bancarias_tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Agencia</th>
                <th>Conta</th>
                <th>Tipo PIX</th>
                <th>Valor PIX</th>
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
    let recebe_tabela_pessoas;
    $(document).ready(function() {
        // Função para buscar dados da API
        function buscar_contas_bancarias() {
            $.ajax({
                url: "cadastros/processa_conta_bancaria.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_conta_bancaria": "buscar_contas_bancarias"
                },
                success: function(retorno_contas_bancarias) {
                    debugger;
                    if (retorno_contas_bancarias.length > 0) {
                        console.log(retorno_contas_bancarias);
                        preencher_tabela(retorno_contas_bancarias);
                        inicializarDataTable();
                    } else {
                        preencher_tabela(retorno_contas_bancarias);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        // Função para preencher a tabela com os dados das clínicas
        function preencher_tabela(contas_bancarias) {
            debugger;
            let tbody = document.querySelector("#contas_bancarias_tabela tbody");
            tbody.innerHTML = ""; // Limpa o conteúdo existente

            if (contas_bancarias.length > 0) {
                for (let index = 0; index < contas_bancarias.length; index++) {
                    let conta_bancaria = contas_bancarias[index];

                    // Separar o endereço
                    // let partesEndereco = pessoa.endereco.split(',');
                    // let ruaNumero = `${partesEndereco[0] || ''}, ${partesEndereco[1] || ''}`;
                    // let cidadeEstado = `${(partesEndereco[2] || '').trim()} / ${(partesEndereco[3] || '').trim()}`;

                    // Converter data de nascimento para formato brasileiro
                    // let data_nascimento_formatado = "";
                    // if (pessoa.nascimento) {
                    //     let data = new Date(pessoa.nascimento);
                    //     data_nascimento_formatado = data.toLocaleDateString("pt-BR");
                    // }

                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${conta_bancaria.id_conta_bancaria}</td>
                        <td>${conta_bancaria.agencia}</td>
                        <td>${conta_bancaria.conta}</td>
                        <td>${conta_bancaria.tipo_pix}</td>
                        <td>${conta_bancaria.valor_pix}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="view" title="Visualizar" id='visualizar-informacoes-conta-bancaria' data-codigo-conta-bancaria='${conta_bancaria.id_conta_bancaria}'>
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?pg=grava_conta_bancaria&acao=editar&id=${conta_bancaria.id_conta_bancaria}" target="_parent" class="edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" id='excluir-conta-bancaria' data-codigo-conta-bancaria="${conta_bancaria.id_conta_bancaria}" class="delete" title="Apagar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(row);
                }
            } else {
                $("#contas_bancarias_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
            }
        }

        // Função para inicializar o DataTables
        function inicializarDataTable() {
            recebe_tabela_contas_bancarias = $("#contas_bancarias_tabela").DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "dom": 'lrtip' // Remove a barra de pesquisa padrão
            });
        }

        buscar_contas_bancarias();

        $(".search-bar").on('keyup', function() {
            recebe_tabela_contas_bancarias.search(this.value).draw();
        });

        // async function buscar_informacoes_rapidas_clinica() {
        //     await popula_cidades_informacoes_rapidas();
        // }

        // buscar_informacoes_rapidas_clinica();
    });

    $(document).on("click", "#excluir-conta-bancaria", function(e) {
        e.preventDefault();

        debugger;

        let recebe_id_conta_bancaria = $(this).data("codigo-conta-bancaria");

        let recebe_resposta_excluir_conta_bancaria = window.confirm(
            "Tem certeza que deseja excluir a conta bancária?"
        );

        if (recebe_resposta_excluir_conta_bancaria) {
            $.ajax({
                url: "cadastros/processa_conta_bancaria.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_conta_bancaria: "excluir_conta_bancaria",
                    valor_codigo_excluir_conta_bancaria: recebe_id_conta_bancaria,
                },
                success: function(retorno_excluir_conta_bancaria) {
                    debugger;
                    console.log(retorno_excluir_conta_bancaria);
                    if (retorno_excluir_conta_bancaria) {
                        window.location.href = "painel.php?pg=contas_bancarias";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao excluir conta bancária:" + error);
                },
            });
        } else {
            return;
        }
    });

    $(document).on("click", "#visualizar-informacoes-conta-bancaria", function(e) {
        debugger;
        recebe_codigo_conta_bancaria_informacoes_rapida = $(this).data("codigo-conta-bancaria");

        $.ajax({
            url: "cadastros/processa_conta_bancaria.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_conta_bancaria": "busca_informacoes_rapidas_conta_bancaria",
                "valor_codigo_contas_bancarias_informacoes_rapidas": recebe_codigo_conta_bancaria_informacoes_rapida,
            },
            success: function(resposta) {
                debugger;

                if (resposta.length > 0) {
                    for (let indice = 0; indice < resposta.length; indice++) {
                        // $("#created_at").val(resposta[indice].created_at);
                        $("#agencia").val(resposta[indice].agencia);
                        $("#conta").val(resposta[indice].conta);
                        $("#tipo-pix").val(resposta[indice].tipo_pix);
                        $("#valor-pix").val(resposta[indice].valor_pix);
                    }
                }
            },
            error: function(xhr, status, error) {

            },
        });
        document.getElementById('informacoes-conta-bancaria').classList.remove('hidden'); // abrir
    });

    $(document).on("click", "#fechar-modal-informacoes-conta-bancaria", function(e) {
        debugger;
        document.getElementById('informacoes-conta-bancaria').classList.add('hidden'); // fechar
    });
</script>

<!-- Modal -->
<div id="informacoes-conta-bancaria"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-6 relative">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Informações da Conta Bancária</h2>
            <button id="fechar-modal-informacoes-conta-bancaria" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
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
                    <label for="nome">Agencia:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-university"></i>
                        <input type="text" id="agencia" name="nome" disabled class="form-control w-full">
                    </div>
                </div>

                <div class="form-group">
                    <label for="cpf">Conta:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-credit-card"></i>
                        <input type="text" id="conta" name="cpf" disabled oninput="formatCPF(this)" class="form-control w-full">
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="nascimento">Data Nascimento:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-gray-500"></i>
                        <input type="date" id="nascimento" disabled name="nascimento" class="form-control w-full">
                    </div>
                </div> -->

                <div class="form-group">
                    <label for="sexo-pessoa">Tipo PIX:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-map-marker-alt"></i>
                        <select id="tipo-pix" disabled name="sexo_pessoa" class="form-control w-full">
                            <option value="selecione">Selecione</option>
                            <option value="telefone">Telefone</option>
                            <option value="cpf">CPF</option>
                            <option value="cnpj">CNPJ</option>
                            <option value="email">E-mail</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telefone">Valor PIX:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-credit-card"></i>
                        <input type="text" disabled id="valor-pix" name="telefone" oninput="mascaraTelefone(this);" class="form-control w-full">
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="whatsapp">Whatsapp:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-phone text-gray-500"></i>
                        <input type="text" disabled id="whatsapp" name="whatsapp" oninput="mascaraTelefone(this);" class="form-control w-full">
                    </div>
                </div> -->
            </div>

            <!-- Botões -->
            <div class="flex justify-between mt-6">
                <button id="fechar-modal-informacoes-conta-bancaria" type="button"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">Fechar</button>
            </div>
        </form>
    </div>
</div>