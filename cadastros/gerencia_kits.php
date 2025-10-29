<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<style>
    /* Estilos gerais da tabela */
    #kits_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #kits_tabela th,
    #kits_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #kits_tabela th {
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
    <h1 class="dashboard">Gerenciar KITS</h1>
</div>

<!-- Botão Cadastrar -->
<!-- <div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=grava_pessoa&acao=cadastrar';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div> -->

<div class="relative w-1/3 mb-6"> <!-- Define a largura do campo -->
    <i class="fas fa-building absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
    <select id="empresas" name="empresas"
        class="block w-full pl-10 pr-8 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400 text-gray-700 text-sm appearance-none">
    </select>
    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm pointer-events-none"></i>
</div>



<div>
    <table id="kits_tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Tipo do Exame</th>
                <th>Empresa</th>
                <th>Ações</th> <!-- Nova coluna para os botões de ação -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="text-align:center; color:#555; padding:15px;">
                    Nenhum registro localizado
                </td>
            </tr>
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

        function buscar_empresas_principais() {
            $.ajax({
                url: "cadastros/processa_empresa_principal.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_empresas_principal"
                },
                success: async function(resposta_empresa_principal) {
                    debugger;

                    try {
                        // Preenche o select
                        let select = $("#empresas");
                        select.empty(); // limpa antes
                        select.append('<option value="selecione">Selecione</option>');

                        resposta_empresa_principal.forEach(function(empresa) {
                            select.append(`<option value="${empresa.id}">${empresa.nome}</option>`);
                        });

                        // Se quiser, continua com sua lógica da tabela
                        console.log(resposta_empresa_principal);

                    } catch (error) {
                        console.error("Erro ao preencher tabela:", error);
                    }

                    // try {
                    //     console.log(resposta_empresa_principal);
                    //     await preencher_tabela(resposta_empresa_principal);
                    //     inicializarDataTable();
                    // } catch (error) {
                    //     console.error("Erro ao preencher tabela:", error);
                    //     $("#empresas_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Erro ao carregar dados</td></tr>");
                    //     inicializarDataTable();
                    // }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        buscar_empresas_principais();
        // inicializarDataTable();

        // $(".search-bar").on('keyup', function() {
        //     recebe_tabela_pessoas.search(this.value).draw();
        // });

        // async function buscar_informacoes_rapidas_clinica() {
        //     await popula_cidades_informacoes_rapidas();
        // }

        // buscar_informacoes_rapidas_clinica();
    });

    let recebe_empresa_selecionada;
    let recebe_id_empresa_principal_selecionada;

    $("#empresas").change(function(e) {
        e.preventDefault();

        debugger;

        recebe_empresa_selecionada = $("#empresas option:selected").text();

        recebe_id_empresa_principal_selecionada = this.value;

        buscar_kits();

        // Função para buscar dados da API
        function buscar_kits() {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_geracao_kit": "buscar_todos_kits_empresa_gerenciamento_kits",
                    valor_id_empresa_principal: recebe_id_empresa_principal_selecionada
                },
                success: async function(resposta_kits) {
                    debugger;
                    if ($.fn.DataTable.isDataTable('#kits_tabela')) {
                        $('#kits_tabela').DataTable().clear().destroy();
                    }

                    await preencher_tabela(resposta_kits);

                    // Inicializa o DataTable apenas depois de preencher a tabela
                    if (resposta_kits.length > 0) {
                        inicializarDataTable();
                    } else {
                        $("#kits_tabela tbody").html("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }
    });

    // Função para preencher a tabela com os dados das clínicas
    async function preencher_tabela(kits) {
        debugger;
        let tbody = document.querySelector("#kits_tabela tbody");
        tbody.innerHTML = ""; // Limpa o conteúdo existente

        if (kits.length > 0) {
            for (let index = 0; index < kits.length; index++) {
                let kit = kits[index];

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

                // <a href="#" class="view" title="Visualizar" id='visualizar-informacoes-pessoa' data-codigo-pessoa='${pessoa.id}'>
                //                 <i class="fas fa-eye"></i>
                //             </a>

                window.recebe_codigo_id_empresa_principal = kit.empresa_id_principal;

                window.recebe_dados_empresa_principal_kit = "";

                let row = document.createElement("tr");
                row.innerHTML = `
                        <td style="text-align:center; vertical-align:middle;">${kit.id}</td>
                        <td style="text-align:center; vertical-align:middle;">${kit.status && kit.status.trim() !== "" ? kit.status : "Não informado"}</td>
                        <td style="text-align:center; vertical-align:middle;">${kit.tipo_exame && kit.tipo_exame.trim() !== "" ? kit.tipo_exame : "Não informado"}</td>
                        <td style="text-align:center; vertical-align:middle;">${recebe_empresa_selecionada || "Não informado"}</td>
                            <td style="text-align:center; vertical-align:middle;">
                                <div class="action-buttons">
                                    <a href="?pg=geracao_kit&id=${kit.id}&acao=editar" target="_parent" class="edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" id='excluir-kit' data-codigo-kit="${kit.id}" class="delete" title="Apagar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                    `;
                tbody.appendChild(row);
            }
        } else {
            $("#kits_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        }
    }

    function inicializarDataTable() {
        recebe_tabela_pessoas = $("#kits_tabela").DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            },
            "dom": 'lrtip'
        });
    }


    $(document).on("click", "#visualizar-informacoes-pessoa", function(e) {
        debugger;
        recebe_codigo_pessoa_informacoes_rapida = $(this).data("codigo-pessoa");

        $.ajax({
            url: "cadastros/processa_pessoa.php",
            method: "GET",
            dataType: "json",
            data: {
                "processo_pessoa": "buscar_informacoes_rapidas_pessoas",
                "valor_codigo_pessoa_informacoes_rapidas": recebe_codigo_pessoa_informacoes_rapida,
            },
            success: function(resposta) {
                debugger;

                if (resposta.length > 0) {
                    for (let indice = 0; indice < resposta.length; indice++) {
                        $("#created_at").val(resposta[indice].created_at);
                        $("#nome").val(resposta[indice].nome);
                        $("#cpf").val(resposta[indice].cpf);
                        $("#nascimento").val(resposta[indice].nascimento);
                        $("#sexo-pessoa").val(resposta[indice].sexo);
                        $("#telefone").val(resposta[indice].telefone);
                        $("#whatsapp").val(resposta[indice].whatsapp);
                    }
                }
            },
            error: function(xhr, status, error) {

            },
        });
        document.getElementById('informacoes-pessoa').classList.remove('hidden'); // abrir
    });

    $(document).on("click", "#fechar-modal-informacoes-pessoa", function(e) {
        debugger;
        document.getElementById('informacoes-pessoa').classList.add('hidden'); // fechar
    });
</script>

<!-- Modal -->
<div id="informacoes-pessoa"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-6 relative">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Informações da Pessoa</h2>
            <button id="fechar-modal-informacoes-pessoa" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
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

            <!-- Grid com 2 colunas maiores -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="nome">Nome Completo:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-user text-gray-500"></i>
                        <input type="text" id="nome" name="nome" disabled class="form-control w-full">
                    </div>
                </div>

                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-address-card text-gray-500"></i>
                        <input type="text" id="cpf" name="cpf" disabled oninput="formatCPF(this)" class="form-control w-full">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nascimento">Data Nascimento:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-gray-500"></i>
                        <input type="date" id="nascimento" disabled name="nascimento" class="form-control w-full">
                    </div>
                </div>

                <div class="form-group">
                    <label for="sexo-pessoa">Sexo:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-mars text-gray-500"></i>
                        <select id="sexo-pessoa" disabled name="sexo_pessoa" class="form-control w-full">
                            <option value="selecione">Selecione</option>
                            <option value="feminino">Feminino</option>
                            <option value="masculino">Masculino</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-phone text-gray-500"></i>
                        <input type="text" disabled id="telefone" name="telefone" oninput="mascaraTelefone(this);" class="form-control w-full">
                    </div>
                </div>

                <div class="form-group">
                    <label for="whatsapp">Whatsapp:</label>
                    <div class="input-with-icon flex items-center gap-2">
                        <i class="fas fa-phone text-gray-500"></i>
                        <input type="text" disabled id="whatsapp" name="whatsapp" oninput="mascaraTelefone(this);" class="form-control w-full">
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-between mt-6">
                <button id="fechar-modal-informacoes-pessoa" type="button"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">Fechar</button>
            </div>
        </form>
    </div>
</div>