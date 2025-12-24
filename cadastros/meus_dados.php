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
    <h1 class="dashboard">KITS</h1>
</div>

<!-- Botão Cadastrar -->
<!-- <div>
    <button class="btn-cadastrar" onclick="window.location.href='?pg=geracao_kit';">
        <i class="fas fa-plus"></i> Gerar KIT
    </button>
</div> -->



<div>
    <table id="kits_tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Tipo do Exame</th>
                <!-- <th>Ações</th> Nova coluna para os botões de ação -->
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
    window.recebe_codigo_id_empresa_principal;
    let recebe_tabela_kits;
    $(document).ready(function() {

        let url_parametros = window.location.search;
        const params = new URLSearchParams(url_parametros);

        console.log("id do usuario",params.get("id_user"));

        
        // Função para buscar dados da API
        // function buscar_kits() {
        //     $.ajax({
        //         url: "cadastros/processa_geracao_kit.php", // Endpoint da API
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processo_geracao_kit": "buscar_todos_kits_empresa"
        //         },
        //         success: async function(resposta_kits) {
        //             debugger;
        //             if (resposta_kits.length > 0) {
        //                 console.log(resposta_kits);
        //                 await preencher_tabela(resposta_kits);
        //                 inicializarDataTable();
        //             } else {
        //                 preencher_tabela(resposta_kits);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro na requisição:", error);
        //         }
        //     });
        // } 
    });

    //         function requisitarEmpresaPrincipalKIT() {
    //             return new Promise((resolve, reject) => {
    //                 $.ajax({
    //                     url: "cadastros/processa_geracao_kit.php",
    //                     method: "GET",
    //                     dataType: "json",
    //                     data: {
    //                         processo_geracao_kit: "buscar_empresa_principal_kit",
    //                         valor_id_empresa: window.recebe_codigo_id_empresa_principal
    //                     },
    //                     success: function(resposta) {
    //                         console.log("KITs retornados:", resposta);
    //                         resolve(resposta);
    //                     },
    //                     error: function(xhr, status, error) {
    //                         reject(error);
    //                     }
    //                 });
    //             });
    //         }

    //         // Função para preencher a tabela com os dados das clínicas
    //         async function preencher_tabela(kits) {
    //             debugger;
    //             let tbody = document.querySelector("#kits_tabela tbody");
    //             tbody.innerHTML = ""; // Limpa o conteúdo existente

    //             if (kits.length > 0) {
    //                 for (let index = 0; index < kits.length; index++) {
    //                     let kit = kits[index];

    //                     // Separar o endereço
    //                     // let partesEndereco = pessoa.endereco.split(',');
    //                     // let ruaNumero = `${partesEndereco[0] || ''}, ${partesEndereco[1] || ''}`;
    //                     // let cidadeEstado = `${(partesEndereco[2] || '').trim()} / ${(partesEndereco[3] || '').trim()}`;

    //                     // Converter data de nascimento para formato brasileiro
    //                     // let data_nascimento_formatado = "";
    //                     // if (pessoa.nascimento) {
    //                     //     let data = new Date(pessoa.nascimento);
    //                     //     data_nascimento_formatado = data.toLocaleDateString("pt-BR");
    //                     // }

    //                     // <a href="#" class="view" title="Visualizar" id='visualizar-informacoes-pessoa' data-codigo-pessoa='${pessoa.id}'>
    //                     //                 <i class="fas fa-eye"></i>
    //                     //             </a>

    //                     window.recebe_codigo_id_empresa_principal = kit.empresa_id_principal;

    //                     window.recebe_dados_empresa_principal_kit = await requisitarEmpresaPrincipalKIT();

    //                     let row = document.createElement("tr");
    //                     row.innerHTML = `
    //                         <td style="text-align:center; vertical-align:middle;">${kit.id}</td>
    // <td style="text-align:center; vertical-align:middle;">${kit.status && kit.status.trim() !== "" ? kit.status : "Não informado"}</td>
    // <td style="text-align:center; vertical-align:middle;">${kit.tipo_exame && kit.tipo_exame.trim() !== "" ? kit.tipo_exame : "Não informado"}</td>
    // <td style="text-align:center; vertical-align:middle;">${window.recebe_dados_empresa_principal_kit?.nome || "Não informado"}</td>
    //     <td style="text-align:center; vertical-align:middle;">
    //         <div class="action-buttons">
    //             <a href="?pg=geracao_kit&id=${kit.id}&acao=editar" target="_parent" class="edit" title="Editar">
    //                 <i class="fas fa-edit"></i>
    //             </a>
    //             <a href="#" id='excluir-kit' data-codigo-kit="${kit.id}" class="delete" title="Apagar">
    //                 <i class="fas fa-trash"></i>
    //             </a>
    //         </div>
    //     </td>
    //                     `;
    //                     tbody.appendChild(row);
    //                 }
    //             } else {
    //                 $("#kits_tabela tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
    //             }
    //         }

    //         // Função para inicializar o DataTables
    //         function inicializarDataTable() {
    //             recebe_tabela_kits = $("#kits_tabela").DataTable({
    //                 "language": {
    //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
    //                 },
    //                 "dom": 'lrtip' // Remove a barra de pesquisa padrão
    //             });
    //         }

    //         buscar_kits();

    //         $(".search-bar").on('keyup', function() {
    //             recebe_tabela_kits.search(this.value).draw();
    //         });

    //         // async function buscar_informacoes_rapidas_clinica() {
    //         //     await popula_cidades_informacoes_rapidas();
    //         // }

    //         // buscar_informacoes_rapidas_clinica();
    //     });

    //     $(document).on("click", "#excluir-kit", function(e) {
    //         e.preventDefault();

    //         debugger;

    //         let recebe_id_kit = $(this).data("codigo-kit");

    //         let recebe_resposta_excluir_kit = window.confirm(
    //             "Tem certeza que deseja excluir o kit?"
    //         );

    //         if (recebe_resposta_excluir_kit) {
    //             $.ajax({
    //                 url: "cadastros/processa_geracao_kit.php",
    //                 type: "POST",
    //                 dataType: "json",
    //                 data: {
    //                     processo_geracao_kit: "excluir_kit",
    //                     valor_id_kit: recebe_id_kit,
    //                     metodo:"PUT"
    //                 },
    //                 success: function(retorno_kits) {
    //                     debugger;
    //                     console.log(retorno_kits);
    //                     if (retorno_kits) {
    //                         window.location.href = "painel.php?pg=kits";
    //                     }
    //                 },
    //                 error: function(xhr, status, error) {
    //                     console.log("Falha ao excluir pessoa:" + error);
    //                 },
    //             });
    //         } else {
    //             return;
    //         }
</script>