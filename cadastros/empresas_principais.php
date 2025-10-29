<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    /* Estilos gerais da tabela */
    #empresas_principal_tabela {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #empresas_principal_tabela th,
    #empresas_principal_tabela td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #empresas_principal_tabela th {
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
    <button class="btn-cadastrar" onclick="window.location.href='?pg=grava_empresas_principais';">
        <i class="fas fa-plus"></i> Cadastrar
    </button>
</div>

<div>
    <table id="empresas_principal_tabela">
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
                url: "cadastros/processa_empresa_principal.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_empresas_principal"
                },
                success: async function(resposta_empresa_principal) {
                    debugger;
                    try {
                        console.log(resposta_empresa_principal);
                        await preencher_tabela(resposta_empresa_principal);
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

        // async function buscar_informacoes_rapidas_empresa() {
        //     await popula_cidades_informacoes_rapidas_empresa();
        // }

        // buscar_informacoes_rapidas_empresa();
    });


    // Função para preencher a tabela com os dados das clínicas
    async function preencher_tabela(resposta_empresa) {
        debugger;
        let tbody = document.querySelector("#empresas_principal_tabela tbody");
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
                    <a href="?pg=grava_empresas_principais&acao=editar&id=${empresa.id}" target="_parent" class="edit" title="Editar">
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
            $("#empresas_principal_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
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
    }

    // Função para inicializar o DataTables
    function inicializarDataTable() {
        recebe_tabela_empresas = $('#empresas_principal_tabela').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            },
            "dom": 'lrtip' // Remove a barra de pesquisa padrão
        });
    }
</script>