<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    /* Estilos gerais da tabela */
    #empresas_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #empresas_tabela th,
    #empresas_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #empresas_tabela th {
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
</style>

<div>
    <h1 class="dashboard">Empresas</h1>
</div>

<!-- Botão Cadastrar -->
<div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=grava_empresa';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div>

<div>
    <table id="empresas_tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Fantasia</th>
                <th>CNPJ</th>
                <th>Endereço</th>
                <th>Cidade/Estado</th>
                <th>Telefone</th>
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
    let recebe_codigo_empresa_informacoes_rapida;
    let recebe_tabela_empresas;
    $(document).ready(function(e) {
        function buscar_empresas() {
            $.ajax({
                url: "cadastros/processa_empresa.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_empresas"
                },
                success: function(resposta_empresa) {
                    debugger;
                    if (resposta_empresa.length > 0) {
                        console.log(resposta_empresa);
                        preencher_tabela(resposta_empresa);
                        inicializarDataTable();
                    } else {
                        console.error("Erro ao buscar dados:", resposta_empresa);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        // Iniciar a busca dos dados ao carregar a página
        buscar_empresas();

        $('.search-bar').on('keyup', function() {
            recebe_tabela_empresas.search(this.value).draw();
        });

        async function buscar_informacoes_rapidas_empresa() {
            await popula_cidades_informacoes_rapidas_empresa();
        }

        buscar_informacoes_rapidas_empresa();
    });


    async function popula_cidades_informacoes_rapidas_empresa(cidadeSelecionada = "", estadoSelecionado = "") {
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


    // Função para preencher a tabela com os dados das clínicas
    function preencher_tabela(resposta_empresa) {
        debugger;
        let tbody = document.querySelector("#empresas_tabela tbody");
        tbody.innerHTML = ""; // Limpa o conteúdo existente

        for (let i = 0; i < resposta_empresa.length; i++) {
            let empresa = resposta_empresa[i];

            // Separar o endereço
            let partesEndereco = empresa.endereco.split(',');
            let ruaNumero = `${partesEndereco[0] || ''}, ${partesEndereco[1] || ''}`;
            let cidadeEstado = `${(partesEndereco[2] || '').trim()} / ${(partesEndereco[3] || '').trim()}`;

            let row = document.createElement("tr");
            row.innerHTML = `
            <td>${empresa.id}</td>
            <td>${empresa.nome}</td>
            <td>${empresa.cnpj}</td>
            <td>${ruaNumero}</td>
            <td>${cidadeEstado}</td>
            <td>${empresa.telefone}</td>
            <td>
                <div class="action-buttons">
                    <a href="#" class="view" title="Visualizar" id='visualizar-informacoes-empresa' data-codigo-empresa='${empresa.id}'>
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="?pg=grava_empresa&acao=editar&id=${empresa.id}" target="_parent" class="edit" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href='#' id='exclui-empresa' data-codigo-empresa="${empresa.id}" class="delete" title="Apagar">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </td>
        `;
            tbody.appendChild(row);
        }

        $(document).on("click", "#exclui-empresa", function(e) {
            e.preventDefault();

            debugger;

            let recebe_id_empresa = $(this).data("codigo-empresa");

            // alert(recebe_id_empresa);

            $.ajax({
                url: "cadastros/processa_empresa.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_empresa: "excluir_empresa",
                    valor_id_empresa: recebe_id_empresa,
                },
                success: function(retorno_empresa) {
                    debugger;
                    console.log(retorno_empresa);
                    if (retorno_empresa) {
                        window.location.href = "painel.php?pg=empresas";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao excluir empresa:" + error);
                },
            });
        });

        async function popula_medicos_associados_empresa() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "cadastros/processa_medico.php",
                    method: "GET",
                    dataType: "json",
                    data: {
                        "processo_medico": "buscar_medicos_associados_empresa",
                        valor_codigo_empresa_medicos_associados: recebe_codigo_empresa_informacoes_rapida,
                    },
                    success: function(resposta_medicos) {
                        debugger;
                        console.log(resposta_medicos);

                        if (resposta_medicos.length > 0) {
                            let recebe_tabela_associar_medico_empresa = document.querySelector(
                                "#tabela-medico-associado-coordenador tbody"
                            );

                            $("#tabela-medico-associado-coordenador tbody").html("");

                            for (let indice = 0; indice < resposta_medicos.length; indice++) {
                                let recebe_botao_desvincular_medico_empresa;
                                if (resposta_medicos[indice].id !== "" && resposta_medicos[indice].medico_id !== "") {
                                    recebe_botao_desvincular_medico_empresa = "<td><i class='fas fa-trash' title='Desvincular Médico' id='exclui-medico-ja-associado'" +
                                        " data-codigo-medico-empresa='" + resposta_medicos[indice].id + "' data-codigo-medico='" + resposta_medicos[indice].medico_id + "'></i></td>";
                                }

                                recebe_tabela_associar_medico_empresa +=
                                    "<tr>" +
                                    "<td>" + resposta_medicos[indice].nome_medico + "</td>" +
                                    "</tr>";
                            }
                            $("#tabela-medico-associado-coordenador tbody").append(recebe_tabela_associar_medico_empresa);
                        } else {
                            $("#tabela-medico-associado-coordenador tbody").html("");
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

        $(document).on("click", "#visualizar-informacoes-empresa", function(e) {
            debugger;
            recebe_codigo_empresa_informacoes_rapida = $(this).data("codigo-empresa");

            $.ajax({
                url: "cadastros/processa_empresa.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_informacoes_rapidas_empresa",
                    "valor_id_empresa_informacoes_rapidas": recebe_codigo_empresa_informacoes_rapida,
                },
                success: function(resposta) {
                    debugger;

                    if (resposta.length > 0) {
                        for (let indice = 0; indice < resposta.length; indice++) {
                            let recebe_endereco_cortado = resposta[indice].endereco.split(",");

                            $("#created_at").val(resposta[indice].created_at);
                            $("#cnpj").val(resposta[indice].cnpj);
                            $("#nome_fantasia").val(resposta[indice].nome);
                            $("#razao_social").val(resposta[indice].razao_social);
                            $("#endereco").val(resposta[indice].endereco);
                            $("#numero").val(recebe_endereco_cortado[1]);
                            $("#complemento").val(resposta[indice].complemento);
                            $("#bairro").val(resposta[indice].bairro);
                            $("#cidade_id").val(resposta[indice].id_cidade);
                            $("#cep").val(resposta[indice].cep);
                            $("#email").val(resposta[indice].email);
                            $("#telefone").val(resposta[indice].telefone);

                            // let recebe_status_clinica;
                            // if (resposta[indice].status === "Ativo")
                            //     $("#status").prop("checked", true);
                            // else
                            //     $("#status").prop("checked", false);

                            async function exibi_medicos_associados_empresa() {
                                await popula_medicos_associados_empresa();
                            }

                            exibi_medicos_associados_empresa();
                        }
                    }
                },
                error: function(xhr, status, error) {

                },
            });
            document.getElementById('informacoes-empresa').classList.remove('hidden'); // abrir
        });

        $(document).on("click", "#fechar-modal-informacoes-empresa", function(e) {
            debugger;
            document.getElementById('informacoes-empresa').classList.add('hidden'); // fechar
        });

        // resposta_empresa.forEach(empresa => {
        //     const row = document.createElement("tr");
        //     row.innerHTML = `
        //                 <td>${empresa.id}</td>
        //                 <td>${empresa.nome_fantasia}</td>
        //                 <td>${empresa.cnpj}</td>
        //                 <td>${empresa.endereco}, ${empresa.numero}, ${empresa.complemento}</td>
        //                 <td>${empresa.cidade_nome}/${empresa.cidade_estado}</td>
        //                 <td>${empresa.telefone}</td>
        //                 <td>${empresa.status}</td>
        //                 <td>
        //                     <div class="action-buttons">
        //                         <a href="#" class="view" title="Visualizar">
        //                             <i class="fas fa-eye"></i>
        //                         </a>
        //                         <a href="?pg=pro_cli&acao=editar&id=${empresa.id}" target="_parent" class="edit" title="Editar">
        //                             <i class="fas fa-edit"></i>
        //                         </a>
        //                         <a href="cadastros/pro_cli_json.php?pg=pro_cli&acao=apagar&id=${empresa.id}" class="delete" title="Apagar">
        //                             <i class="fas fa-trash"></i>
        //                         </a>
        //                     </div>
        //                 </td>
        //             `;
        //     tbody.appendChild(row);
        // });
    }

    // Função para inicializar o DataTables
    function inicializarDataTable() {
        recebe_tabela_empresas = $('#empresas_tabela').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            },
            "dom": 'lrtip' // Remove a barra de pesquisa padrão
        });
    }
</script>

<!-- Modal -->
<div id="informacoes-empresa"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-6 relative">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Informações da Empresa</h2>
            <button id="fechar-modal-informacoes-empresa" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
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
                            <input type="text" value="" id="cnpj" name="cnpj" class="form-control cnpj-input" disabled>
                        </div>
                    </div>

                    <div>
                        <label for="nome_fantasia" class="block font-semibold mb-1">Nome Fantasia:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building text-gray-500"></i>
                            <input type="text" value="teste" id="nome_fantasia" name="nome_fantasia" class="form-control" disabled>
                        </div>
                    </div>

                    <div>
                        <label for="razao_social" class="block font-semibold mb-1">Razão Social:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-file-signature text-gray-500"></i>
                            <input type="text" id="razao_social" name="razao_social" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="endereco" class="block font-semibold mb-1">Endereço:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-gray-500"></i>
                                <input type="text" id="endereco" name="endereco" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <label for="numero" class="block font-semibold mb-1">Número:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-pin text-gray-500"></i>
                                <input type="text" id="numero" name="numero" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="complemento" class="block font-semibold mb-1">Complemento:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-signs text-gray-500"></i>
                                <input type="text" id="complemento" name="complemento" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <label for="bairro" class="block font-semibold mb-1">Bairro:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map text-gray-500"></i>
                                <input type="text" id="bairro" name="bairro" class="form-control" disabled>
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
                            <select id="cidade_id" name="cidade_id" class="form-control" disabled></select>
                        </div>
                    </div>

                    <div>
                        <label for="cep" class="block font-semibold mb-1">CEP:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-marked-alt text-gray-500" id="cep" disabled></i>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block font-semibold mb-1">Email:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-envelope text-gray-500"></i>
                            <input type="email" id="email" name="email" class="form-control" disabled>
                        </div>
                    </div>

                    <div>
                        <label for="telefone" class="block font-semibold mb-1">Telefone:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone text-gray-500"></i>
                            <input type="text" id="telefone" name="telefone" class="form-control" oninput="formatPhone(this)" disabled>
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

                <table id="tabela-medico-associado-coordenador" class="table table-bordered w-full mt-4">
                    <thead>
                        <tr>
                            <th>Médicos examinadores coordenadores vinculados a essa empresa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dados via JS -->
                    </tbody>
                </table>
            </div>

            <!-- Botões -->
            <div class="flex justify-between mt-6">
                <button id="fechar-modal-informacoes-empresa" type="button"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">Fechar</button>
                <!-- <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Salvar</button> -->
            </div>
        </form>
    </div>
</div>