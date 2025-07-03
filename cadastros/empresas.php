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
                success: async function(resposta_empresa) {
                    debugger;
                    try {
                        console.log(resposta_empresa);
                        await preencher_tabela(resposta_empresa);
                        inicializarDataTable();
                    } catch (error) {
                        console.error("Erro ao preencher tabela:", error);
                        $("#empresas_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Erro ao carregar dados</td></tr>");
                        inicializarDataTable();
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
        const cidadeSelect = document.getElementById('cidade_id');

        // Estado inicial do <select>
        cidadeSelect.innerHTML = '<option value="">Carregando cidades...</option>';
        cidadeSelect.disabled = true;

        try {
            // Traz todos os municípios ordenados por nome (aprox. 5.500 itens)
            const response = await fetch('https://servicodados.ibge.gov.br/api/v1/localidades/municipios?orderBy=nome');
            if (!response.ok) throw new Error(`Falha ao buscar cidades: ${response.status}`);

            const cidadesIBGE = await response.json();

            // Limpa o <select> e insere opção padrão
            cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

            cidadesIBGE.forEach(cidade => {
                const option = document.createElement('option');
                option.value = cidade.id;
                const uf = cidade.microrregiao.mesorregiao.UF.sigla;
                option.textContent = `${cidade.nome} - ${uf}`;
                cidadeSelect.appendChild(option);
            });

            // Habilita o campo após preenchimento
            cidadeSelect.disabled = false;

            // Seleciona automaticamente caso tenha sido informado
            if (cidadeSelecionada) {
                const busca = cidadeSelecionada.toLowerCase();
                for (let i = 0; i < cidadeSelect.options.length; i++) {
                    const texto = cidadeSelect.options[i].textContent.toLowerCase();
                    if (texto.includes(busca) && (!estadoSelecionado || texto.includes(estadoSelecionado.toLowerCase()))) {
                        cidadeSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        } catch (error) {
            console.error('Erro ao carregar cidades do IBGE:', error);
            cidadeSelect.innerHTML = '<option value="">Erro ao carregar cidades</option>';
        }
    }


    // Função para preencher a tabela com os dados das clínicas
    async function preencher_tabela(resposta_empresa) {
        debugger;
        let tbody = document.querySelector("#empresas_tabela tbody");
        tbody.innerHTML = ""; // Limpa o conteúdo existente

        if (resposta_empresa.length > 0) {
            // Criar um array de promessas para buscar as cidades/estados
            const promessas = resposta_empresa.map(async (empresa) => {
                // Formatar endereço
                let ruaNumero = empresa.endereco || '';
                
                // Inicializar com valor padrão
                let cidadeEstado = 'Não informado';
                
                // Se tiver ID de cidade, busca os dados
                if (empresa.id_cidade) {
                    try {
                        const cidade = await buscarCidadePorId(empresa.id_cidade);
                        if (cidade) {
                            const estado = await buscarEstadoPorId(empresa.id_estado);
                            const estadoNome = estado ? (estado.nome || estado.sigla) : '';
                            cidadeEstado = `${cidade.nome || 'Cidade desconhecida'}${estadoNome ? ' / ' + estadoNome : ''}`;
                        }
                    } catch (error) {
                        console.error('Erro ao buscar cidade/estado:', error);
                        cidadeEstado = 'Erro ao carregar';
                    }
                }
                
                return { empresa, ruaNumero, cidadeEstado };
            });
            
            // Aguarda todas as promessas serem resolvidas
            const resultados = await Promise.all(promessas);
            
            // Agora sim, monta as linhas da tabela com os dados já processados
            resultados.forEach(({ empresa, ruaNumero, cidadeEstado }) => {

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
            });
        } else {
            $("#empresas_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        }

        $(document).on("click", "#exclui-empresa", function(e) {
            e.preventDefault();

            debugger;

            let recebe_confirmacao_excluir_empresa = window.confirm("Tem certeza que deseja excluir a empresa?");

            if (recebe_confirmacao_excluir_empresa) {
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
            } else {
                return;
            }
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
            e.preventDefault();
            const recebe_codigo_empresa_informacoes_rapida = $(this).data("codigo-empresa");
            $("#modal-informacoes-rapidas-empresa").modal("show");

            // Limpa os campos antes de preencher
            $("#cidade_id").html("<option value=''>Carregando...</option>");

            // Função assíncrona para carregar os dados da empresa
            async function carregarDadosEmpresa() {
                try {
                    const resposta = await $.ajax({
                        url: "cadastros/processa_empresa.php",
                        method: "GET",
                        dataType: "json",
                        data: {
                            "processo_empresa": "buscar_informacoes_rapidas_empresa",
                            "valor_id_empresa_informacoes_rapidas": recebe_codigo_empresa_informacoes_rapida,
                        }
                    });

                    console.log("Resposta do servidor:", resposta);

                    if (resposta.length > 0) {
                        const empresa = resposta[0];
                        const recebe_endereco_cortado = empresa.endereco ? empresa.endereco.split(",") : ['', ''];

                        // Preenche os campos básicos
                        $("#created_at").val(empresa.created_at || '');
                        $("#cnpj").val(empresa.cnpj || '');
                        $("#nome_fantasia").val(empresa.nome || '');
                        $("#razao_social").val(empresa.razao_social || '');
                        $("#endereco").val(recebe_endereco_cortado[0] || '');
                        $("#numero").val(recebe_endereco_cortado[1] ? recebe_endereco_cortado[1].trim() : '');
                        $("#complemento").val(empresa.complemento || '');
                        $("#bairro").val(empresa.bairro || '');
                        $("#cep").val(empresa.cep || '');
                        $("#email").val(empresa.email || '');
                        $("#telefone").val(empresa.telefone || '');

                        // Busca e exibe a cidade e o estado
                        if (empresa.id_cidade) {
                            try {
                                const cidade = await buscarCidadePorId(empresa.id_cidade);
                                if (cidade) {
                                    const estado = await buscarEstadoPorId(empresa.id_estado);
                                    const estadoNome = estado ? (estado.nome || estado.sigla) : '';
                                    const textoCidadeEstado = [cidade.nome, estadoNome].filter(Boolean).join(' / ');
                                    
                                    if (textoCidadeEstado) {
                                        $("#cidade_id").html(`<option value="${empresa.id_cidade}" selected>${textoCidadeEstado}</option>`);
                                    } else {
                                        $("#cidade_id").html(`<option value="${empresa.id_cidade}" selected>${cidade.nome || 'Cidade desconhecida'}</option>`);
                                    }
                                } else {
                                    $("#cidade_id").html(`<option value="${empresa.id_cidade}" selected>ID: ${empresa.id_cidade} (não encontrada)</option>`);
                                }
                            } catch (error) {
                                console.error('Erro ao carregar cidade/estado:', error);
                                $("#cidade_id").html(`<option value="${empresa.id_cidade || ''}" selected>Erro ao carregar cidade</option>`);
                            }
                        } else {
                            $("#cidade_id").html('<option value="">Não informado</option>');
                        }

                        // Preenche os campos de contabilidade
                        $("#nome_contabilidade").val(empresa.nome_contabilidade || '');
                        $("#email_contabilidade").val(empresa.email_contabilidade || '');

                        // Chama a função para exibir os médicos associados
                        async function exibi_medicos_associados_empresa() {
                            await popula_medicos_associados_empresa();
                        }
                        exibi_medicos_associados_empresa();
                    }
                } catch (error) {
                    console.error('Erro ao carregar dados da empresa:', error);
                    $("#cidade_id").html('<option value="">Erro ao carregar dados</option>');
                }
            }

            // Chama a função para carregar os dados da empresa
            carregarDadosEmpresa();
            
            // Mostra o modal
            document.getElementById('informacoes-empresa').classList.remove('hidden');
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
                            <i class="fas fa-map-marked-alt text-gray-500"></i>
                            <input type="text" id="cep" name="cep" class="form-control cep-input" disabled>
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

                    <!-- Nome da Contabilidade -->
                    <div>
                        <label for="nome_contabilidade" class="block font-semibold mb-1">Nome da Contabilidade:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building text-gray-500"></i>
                            <input type="text" id="nome_contabilidade" name="nome_contabilidade" class="form-control" disabled>
                        </div>
                    </div>

                    <!-- Email da Contabilidade -->
                    <div>
                        <label for="email_contabilidade" class="block font-semibold mb-1">Email da Contabilidade:</label>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-envelope text-gray-500"></i>
                            <input type="email" id="email_contabilidade" name="email_contabilidade" class="form-control" disabled>
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