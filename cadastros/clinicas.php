<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Função para buscar dados da API
        function buscarDados() {
            $.ajax({
                url: "api/list/clinicas.php", // Endpoint da API
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        preencherTabela(response.data.clinicas);
                        inicializarDataTable();
                    } else {
                        console.error("Erro ao buscar dados:", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", error);
                }
            });
        }

        // Função para preencher a tabela com os dados das clínicas
        function preencherTabela(clinicas) {
            const tbody = document.querySelector("#clinicasTable tbody");
            tbody.innerHTML = ""; // Limpa o conteúdo existente

            clinicas.forEach(clinica => {
                const row = document.createElement("tr");
                row.innerHTML = `
                        <td>${clinica.id}</td>
                        <td>${clinica.nome_fantasia}</td>
                        <td>${clinica.cnpj}</td>
                        <td>${clinica.endereco}, ${clinica.numero}, ${clinica.complemento}</td>
                        <td>${clinica.cidade_nome}/${clinica.cidade_estado}</td>
                        <td>${clinica.telefone}</td>
                        <td>${clinica.status}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="view" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?pg=pro_cli&acao=editar&id=${clinica.id}" target="_parent" class="edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="cadastros/pro_cli_json.php?pg=pro_cli&acao=apagar&id=${clinica.id}" class="delete" title="Apagar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    `;
                tbody.appendChild(row);
            });
        }

        // Função para inicializar o DataTables
        function inicializarDataTable() {
            $('#clinicasTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            });
        }

        // Iniciar a busca dos dados ao carregar a página
        buscarDados();
    });
</script>