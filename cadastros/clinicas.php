<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<style>
    /* Estilos gerais da tabela */
    #clinicasTable {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #clinicasTable th,
    #clinicasTable td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #clinicasTable th {
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
    <h1 class="dashboard">Clínicas</h1>
</div>

<!-- Botão Cadastrar -->
<div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=pro_cli&acao=cadastrar';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div>



<div>
    <table id="clinicasTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Fantasia</th>
                <th>CNPJ</th>
                <th>Endereço</th>
                <th>Cidade/Estado</th>
                <th>Telefone</th>
                <th>Status</th>
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
    let recebe_tabela_clinicas;

    // Função para buscar o nome da cidade pelo ID
    async function buscarCidadePorId(idCidade) {
        if (!idCidade) return null;

        try {
            const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/municipios/${idCidade}`);
            if (!response.ok) {
                throw new Error('Cidade não encontrada');
            }
            return await response.json();
        } catch (error) {
            console.error('Erro ao buscar cidade:', error);
            return null;
        }
    }

    // Função para buscar o nome do estado pelo ID
    async function buscarEstadoPorId(idEstado) {
        if (!idEstado) return null;

        try {
            const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${idEstado}`);
            if (!response.ok) {
                throw new Error('Estado não encontrado');
            }
            return await response.json();
        } catch (error) {
            console.error('Erro ao buscar estado:', error);
            return null;
        }
    }

    $(document).ready(function() {
        // Função para buscar dados da API
        async function buscarDados() {
            try {
                const response = await fetch("api/list/clinicas.php?per_page=1000");
                const data = await response.json();

                if (data.status === "success") {
                    // Inicializa o DataTable com os dados processados
                    inicializarDataTable(data.data.clinicas);
                } else {
                    console.error("Erro ao buscar dados:", data.message);
                }
            } catch (error) {
                console.error("Erro na requisição:", error);
            }
        }



        $(document).on("click", "#exclui-clinica", function(e) {
            e.preventDefault();

            debugger;

            let recebe_confirmacao_excluir_clinica = window.confirm("Tem certeza que deseja excluir a clínica?");

            if (recebe_confirmacao_excluir_clinica) {

                let recebe_id_clinica = $(this).data("codigo-clinica");

                $.ajax({
                    url: "cadastros/processa_clinica.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        processo_clinica: "excluir_clinica",
                        valor_id_clinica: recebe_id_clinica,
                    },
                    success: function(retorno_clinica) {
                        debugger;
                        console.log(retorno_clinica);
                        if (retorno_clinica) {
                            window.location.href = "painel.php?pg=clinicas";
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Falha ao excluir empresa:" + error);
                    },
                });
            } else {
                return;
            }
        });


        // Função para inicializar o DataTables
        function inicializarDataTable(clinicas) {
            // Verifica se já existe uma instância do DataTable
            if ($.fn.DataTable.isDataTable('#clinicasTable')) {
                $('#clinicasTable').DataTable().destroy();
            }
            
            recebe_tabela_clinicas = $('#clinicasTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "dom": 'lrtip',
                "retrieve": true,
                "pageLength": 10,
                "data": clinicas,
                "columns": [
                    { "data": "id" },
                    { "data": "nome_fantasia" },
                    { 
                        "data": "cnpj",
                        "render": function(data) {
                            return formatarCNPJ(data) || '';
                        }
                    },
                    { 
                        "data": null,
                        "render": function(data) {
                            return [data.endereco, data.numero, data.complemento].filter(Boolean).join(', ');
                        }
                    },
                    { 
                        "data": "cidade_nome",
                        "render": function(data, type, row) {
                            return row.cidade_nome ? `${row.cidade_nome} / ${row.cidade_estado || ''}` : 'Não informado';
                        }
                    },
                    { 
                        "data": "telefone",
                        "render": function(data) {
                            return formatarTelefone(data) || '';
                        }
                    },
                    { "data": "status" },
                    {
                        "data": null,
                        "orderable": false,
                        "render": function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <a href="#" class="view" title="Visualizar" id="visualizar-informacoes-clinica" data-codigo-clinica="${row.id}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="?pg=pro_cli&acao=editar&id=${row.id}" target="_parent" class="edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" id="exclui-clinica" data-codigo-clinica="${row.id}" class="delete" title="Apagar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>`;
                        }
                    }
                ]
            });
            
            return recebe_tabela_clinicas;
        }

        // Função para formatar CNPJ
        function formatarCNPJ(cnpj) {
            if (!cnpj) return '';
            cnpj = cnpj.replace(/\D/g, '');
            return cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
        }

        // Função para formatar telefone
        function formatarTelefone(telefone) {
            if (!telefone) return '';
            telefone = telefone.replace(/\D/g, '');
            if (telefone.length === 11) {
                return telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (telefone.length === 10) {
                return telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            }
            return telefone;
        }

        // Iniciar a busca dos dados ao carregar a página
        buscarDados();

        $(".search-bar").on('keyup', function() {
            recebe_tabela_clinicas.search(this.value).draw();
        });

        async function buscar_informacoes_rapidas_clinica() {
            await popula_cidades_informacoes_rapidas();
        }

        buscar_informacoes_rapidas_clinica();
        
        // Carrega os dados iniciais da tabela
        buscarDados();
    });

    // Função global para carregar os dados da clínica
    window.carregarDadosClinica = async function() {
        debugger;
        try {
            let resposta = await $.ajax({
                url: "cadastros/processa_clinica.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_clinica": "buscar_informacoes_rapidas_clinicas",
                    "valor_id_clinica_informacoes_rapidas": window.recebe_codigo_clinica_informacoes_rapida,
                }
            });

            console.log("Resposta do servidor:", resposta);

            if (resposta.length > 0) {
                let clinica = resposta[0];
                const recebe_endereco_cortado = clinica.endereco ? clinica.endereco.split(",") : ['', ''];

                $("#created_at").val(clinica.created_at);
                $("#cnpj").val(clinica.cnpj);
                $("#nome_fantasia").val(clinica.nome_fantasia);
                $("#razao_social").val(clinica.razao_social);
                $("#endereco").val(clinica.endereco);
                $("#numero").val(clinica.numero);
                $("#complemento").val(clinica.complemento);
                $("#bairro").val(clinica.bairro);
                $("#cidade_id").val(clinica.cidade_id);
                $("#cep").val(clinica.cep);
                $("#email").val(clinica.email);
                $("#telefone").val(clinica.telefone);

                if (clinica.status === "Ativo")
                    $("#status").prop("checked", true);
                else
                    $("#status").prop("checked", false);

                if (clinica.cidade_id) {
                    try {
                        const cidade = await buscarCidadePorId(clinica.cidade_id);
                        if (cidade) {
                            // Busca o estado relacionado à cidade
                            const estado = await buscarEstadoPorId(cidade.microrregiao.mesorregiao.UF.id);
                            const estadoNome = estado ? (estado.nome || estado.sigla) : '';
                            const textoCidadeEstado = [cidade.nome, estado.sigla].filter(Boolean).join(' / ');

                            if (textoCidadeEstado) {
                                $("#cidade_id").html(`<option value="${clinica.cidade_id}" selected>${textoCidadeEstado}</option>`);
                            } else {
                                $("#cidade_id").html(`<option value="${clinica.cidade_id}" selected>${cidade.nome || 'Cidade desconhecida'}</option>`);
                            }
                            
                            // Preenche o estado se existir o campo
                            if (estado && $("#estado_id").length) {
                                $("#estado_id").html(`<option value="${estado.id}" selected>${estado.nome} (${estado.sigla})</option>`);
                            }
                        } else {
                            $("#cidade_id").html(`<option value="${clinica.cidade_id}" selected>ID: ${clinica.cidade_id} (não encontrada)</option>`);
                        }
                    } catch (error) {
                        console.error('Erro ao carregar cidade/estado:', error);
                        $("#cidade_id").html(`<option value="${clinica.cidade_id || ''}" selected>Erro ao carregar cidade</option>`);
                    }
                } else {
                    $("#cidade_id").html('<option value="">Não informado</option>');
                }

                // Preenche os campos de contabilidade
                $("#nome_contabilidade").val(clinica.nome_contabilidade || '');
                $("#email_contabilidade").val(clinica.email_contabilidade || '');

                async function exibi_medicos_associados_clinica() {
                    await popula_medicos_associados_clinica();
                }

                exibi_medicos_associados_clinica();
            }
        } catch (error) {
            console.error('Erro ao carregar dados da empresa:', error);
            $("#cidade_id").html('<option value="">Erro ao carregar dados</option>');
        }
    };

    $(document).on("click", "#visualizar-informacoes-clinica", function(e) {
        e.preventDefault(); // Previne o comportamento padrão do link
        debugger;
        window.recebe_codigo_clinica_informacoes_rapida = $(this).data("codigo-clinica");
        
        // Mostra a modal imediatamente
        document.getElementById('informacoes-clinica').classList.remove('hidden');
        
        // Limpa os campos antes de preencher
        $("#cidade_id").html("<option value=''>Carregando...</option>");
        $("#estado_id").html("<option value=''>Carregando...</option>");
        
        // Chama a função para carregar os dados da clínica
        window.carregarDadosClinica();
    });

    $(document).on("click", "#fechar-modal-informacoes-clinica", function(e) {
        debugger;
        document.getElementById('informacoes-clinica').classList.add('hidden'); // fechar
    });

    async function popula_cidades_informacoes_rapidas(cidadeSelecionada = "", estadoSelecionado = "") {
        debugger;
        const cidadeSelect = document.getElementById('cidade_id');
        
        try {
            // Se tiver um estado selecionado, busca as cidades desse estado
            if (estadoSelecionado) {
                const responseCidades = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoSelecionado}/municipios?orderBy=nome`);
                const cidades = await responseCidades.json();
                
                cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
                
                cidades.forEach(cidade => {
                    const option = document.createElement('option');
                    option.value = cidade.id;
                    option.textContent = cidade.nome;
                    // Marca como selecionada se for a cidade desejada
                    if (cidadeSelecionada && cidade.id.toString() === cidadeSelecionada.toString()) {
                        option.selected = true;
                    }
                    cidadeSelect.appendChild(option);
                });
            } 
            // Se tiver uma cidade selecionada mas não tiver estado, busca o estado da cidade
            else if (cidadeSelecionada) {
                const cidade = await buscarCidadePorId(cidadeSelecionada);
                if (cidade) {
                    const estado = await buscarEstadoPorId(cidade.microrregiao.mesorregiao.UF.id);
                    if (estado) {
                        // Busca as cidades do estado da cidade selecionada
                        await popula_cidades_informacoes_rapidas(cidadeSelecionada, estado.id);
                        return;
                    }
                }
            }
        } catch (error) {
            console.error('Erro ao carregar cidades:', error);
            cidadeSelect.innerHTML = '<option value="">Erro ao carregar cidades</option>';
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
                    <input type="datetime-local" value="" id="created_at" disabled name="created_at" class="form-control" readonly>
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
                            <input type="text" value="" id="cnpj" name="cnpj" disabled class="form-control cnpj-input">
                        </div>
                    </div>

                    <div>
                        <label for="nome_fantasia" class="block font-semibold mb-1">Nome Fantasia:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building text-gray-500"></i>
                            <input type="text" value="teste" id="nome_fantasia" disabled name="nome_fantasia" class="form-control">
                        </div>
                    </div>

                    <div>
                        <label for="razao_social" class="block font-semibold mb-1">Razão Social:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-file-signature text-gray-500"></i>
                            <input type="text" id="razao_social" name="razao_social" disabled class="form-control">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="endereco" class="block font-semibold mb-1">Endereço:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-gray-500"></i>
                                <input type="text" id="endereco" name="endereco" disabled class="form-control">
                            </div>
                        </div>
                        <div class="w-1/3">
                            <label for="numero" class="block font-semibold mb-1">Número:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-pin text-gray-500"></i>
                                <input type="text" id="numero" name="numero" disabled class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="complemento" class="block font-semibold mb-1">Complemento:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-signs text-gray-500"></i>
                                <input type="text" id="complemento" name="complemento" disabled class="form-control">
                            </div>
                        </div>
                        <div class="w-1/3">
                            <label for="bairro" class="block font-semibold mb-1">Bairro:</label>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map text-gray-500"></i>
                                <input type="text" id="bairro" name="bairro" disabled class="form-control">
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
                            <select id="cidade_id" name="cidade_id" disabled class="form-control"></select>
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
                            <input type="email" id="email" name="email" disabled class="form-control">
                        </div>
                    </div>

                    <div>
                        <label for="telefone" class="block font-semibold mb-1">Telefone:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone text-gray-500"></i>
                            <input type="text" id="telefone" name="telefone" disabled class="form-control" oninput="formatPhone(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status: Ativa/Inativa</label>
                        <div class="status-toggle">
                            <input
                                type="checkbox"
                                id="status"
                                name="status"
                                class="toggle-checkbox" disabled>
                            <label for="status" class="toggle-label"></label>
                        </div>
                    </div>

                    <!-- Nome da Contabilidade -->
                    <div>
                        <label for="nome_contabilidade" class="block font-semibold mb-1">Nome da Contabilidade:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building text-gray-500"></i>
                            <input type="text" id="nome_contabilidade" disabled name="nome_contabilidade" class="form-control" disabled>
                        </div>
                    </div>

                    <!-- Email da Contabilidade -->
                    <div>
                        <label for="email_contabilidade" class="block font-semibold mb-1">Email da Contabilidade:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-envelope text-gray-500"></i>
                            <input type="text" id="email_contabilidade" disabled name="email_contabilidade" class="form-control" disabled>
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
                            <!-- <th>Opção</th> -->
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