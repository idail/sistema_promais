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

    /* Forçar dropdown do perfil a ficar atrás da modal */
    .profile-dropdown {
        position: absolute;
        z-index: 10 !important;
    }

    .profile-menu {
        position: absolute;
        z-index: 10 !important;
    }

    #informacoes-kit {
        z-index: 99999 !important;
    }

    #informacoes-kit>div {
        z-index: 100000 !important;
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

<div id="informacoes-kit"
    class="fixed inset-0 z-[99999] hidden bg-black bg-opacity-50 flex items-center justify-center h-screen">

    <!-- Modal grande -->
    <div class="bg-white rounded-lg shadow-lg w-[95%] max-w-[1500px] p-0 relative overflow-y-auto max-h-[95vh] z-[10000]" style="width: 55%;">



        <!-- Conteúdo interno -->
        <div style="
    background: #fff;
    border-radius: 18px;
    width: 100%;
    padding: 30px 40px;
    box-shadow: 0 15px 45px rgba(0,0,0,0.4);
    font-family: Arial, sans-serif;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
    box-sizing: border-box;
    margin: 0 auto;
">

            <h2 style="margin-top:0; text-align:center; font-size:30px; color:#333;">
                Detalhes do Kit: <span id="recebe-detalhe-tipo-exame"></span>
            </h2>

            <table style="width:100%; margin-top:10px; border-collapse:collapse; font-size:18px;">

                <tr>
                    <td style="font-weight:bold; padding:6px 8px; width:155px;">Tipo do Exame:</td>
                    <td><span id="recebe-tipo-exame"></span></td>
                    <td style="font-weight:bold; padding:12px; width:18%;">Empresa:</td>
                    <td style="width: 24%;"><span id="nome-empresa"></span></td>
                </tr>
                <tr>
                    <td style="font-weight:bold; padding:12px;">Clínica:</td>
                    <td><span id="recebe-clinica"></span></td>
                    <td style="font-weight:bold; padding:12px;">Colaborador:</td>
                    <td><span id="recebe-colaborador"></span></td>
                </tr>
                <tr>
                    <td style="font-weight:bold; padding:12px;">Cargo:</td>
                    <td><span id="recebe-cargo"></span></td>
                    <td style="font-weight:bold; padding:12px;">Motorista:</td>
                    <td><span id="recebe-motorista"></span></td>
                </tr>
                <tr>
                    <td style="font-weight:bold; padding:12px;width: 19%;">Médico Coordenador:</td>
                    <td><span id="recebe-medico-coordenador"></span></td>
                    <td style="font-weight:bold; padding:12px;width: 16%;">Médico Examinador:</td>
                    <td><span id="recebe-medico-examinador"></span></td>
                </tr>

                <tr>
                    <td style="font-weight:bold; padding:12px;width: 13%;">Médico Fonoaudiologo:</td>
                    <td><span id="recebe-medico-fonoaudiologo"></span></td>
                </tr>

                <tr>
                    <td colspan="4" style="padding:12px; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:6px;">Riscos:</div>

                        <table id="tabela-riscos" style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                            <tr style="background:#f2f2f2; font-weight:bold;">
                                <td style="padding:6px; border:1px solid #ccc; width:20%;">Código</td>
                                <td style="padding:6px; border:1px solid #ccc; width:60%;">Descrição</td>
                                <td style="padding:6px; border:1px solid #ccc; width:20%;">Grupo</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="padding:12px; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:6px;">Treinamentos:</div>

                        <table id="tabela-treinamentos" style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                            <tr style="background:#f2f2f2; font-weight:bold;">
                                <td style="padding:6px; border:1px solid #ccc; width:20%;">Código</td>
                                <td style="padding:6px; border:1px solid #ccc; width:60%;">Descrição</td>
                                <td style="padding:6px; border:1px solid #ccc; width:20%;">Valor</td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td colspan="4" style="padding:12px;">
                        <table style="width:100%; border-collapse:collapse; font-size:16px;">
                            <tr>
                                <td style="font-weight:bold; padding:8px; width:8%;">Insalubridade:</td>
                                <td><span id="recebe-insalubridade"></span></td>
                                <td style="font-weight:bold; padding:8px;">Porcentagem:</td>
                                <td><span id="recebe-porcentagem"></span></td>
                                <td style="font-weight:bold; padding:8px;">Periculosidade 30%:</td>
                                <td><span id="recebe-periculosidade"></span></td>
                                <td style="font-weight:bold; padding:8px;">Aposent. Especial:</td>
                                <td><span id="recebe-aposentaria-especial"></span></td>
                                <td style="font-weight:bold; padding:8px;">Agente Nocivo:</td>
                                <td><span id="recebe-agente-nocivo"></span></td>
                                <td style="font-weight:bold; padding:8px;">Ocorrência GFIP:</td>
                                <td><span id="recebe-ocorrencia-gfip"></span></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="padding:12px; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:6px;">Aptidões:</div>

                        <table id="tabela-aptidoes" style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                            <tr style="background:#f2f2f2; font-weight:bold;">
                                <td style="padding:6px; border:1px solid #ccc; width:20%;">Código</td>
                                <td style="padding:6px; border:1px solid #ccc; width:60%;">Nome</td>
                                <td style="padding:6px; border:1px solid #ccc; width:20%;">Valor</td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td colspan="4" style="padding:12px; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:6px;">Exames:</div>

                        <table id="tabela-exames" style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                            <tr style="background:#f2f2f2; font-weight:bold;">
                                <td style="padding:6px; border:1px solid #ccc; width:20%;">Código</td>
                                <td style="padding:6px; border:1px solid #ccc; width:60%;">Nome</td>
                                <td style="padding:6px; border:1px solid #ccc; width:20%;">Valor</td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td colspan="4" style="padding:12px; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:6px;">Faturamento:</div>
                        <div id="areaFaturamento"></div>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="padding:12px; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:6px;">Modelos Selecionados:</div>
                        <!-- tabela de modelos aqui -->
                    </td>
                </tr>

                <tr>
                    <td style="font-weight:bold; padding:12px;">Status do Kit:</td>
                    <td><span id="recebe-status"></span></td>
                    <td style="font-weight:bold; padding:12px;">Data:</td>
                    <td><span id="recebe-data"></span></td>
                </tr>
            </table>

            <div style="text-align:center; margin-top:40px;">
                <button id="fechar-modal-informacoes-kit" style="
          background:#fd9203;
          color:white;
          border:none;
          padding:14px 45px;
          border-radius:10px;
          cursor:pointer;
          font-size:18px;
          transition: background 0.3s;
        "
                    onmouseover="this.style.background='#e68100'"
                    onmouseout="this.style.background='#fd9203'">
                    Fechar
                </button>
            </div>
        </div>

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    let recebe_codigo_kit_informacoes_rapida;
    let recebe_tabela_kits;
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
                                    <a href="#" class="view" title="Visualizar" id="visualizar-informacoes-kit" data-codigo-kit="${kit.id}" data-nome-empresa="${recebe_empresa_selecionada}">
                                        <i class="fas fa-eye"></i>
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
        recebe_tabela_kits = $("#kits_tabela").DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            },
            "dom": 'lrtip'
        });
    }

    function requisitarDadosKITEspecifico(codigo_kit) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    processo_geracao_kit: "buscar_kit",
                    valor_id_kit: codigo_kit
                },
                success: function(resposta) {
                    console.log("KIT retornado:", resposta);
                    resolve(resposta);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function requisitarDadosClinicaEspecifico(codigo_clinica) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    processo_geracao_kit: "busca_clinica_kit",
                    valor_id_clinica_kit: codigo_clinica
                },
                success: function(resposta) {
                    console.log("KIT retornado:", resposta);
                    resolve(resposta);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function requisitarDadosColaboradorEspecifico(codigo_colaborador) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    processo_geracao_kit: "busca_pessoa_kit",
                    valor_id_pessoa_kit: codigo_colaborador
                },
                success: function(resposta) {
                    console.log("KIT retornado:", resposta);
                    resolve(resposta);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function requisitarDadosCargoEspecifico(codigo_cargo) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    processo_geracao_kit: "buscar_cargo_kit",
                    valor_id_cargo_kit: codigo_cargo
                },
                success: function(resposta) {
                    console.log("KIT retornado:", resposta);
                    resolve(resposta);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function requisitarDadosMedicoCoordenador(codigo_medico_coordenador) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    processo_geracao_kit: "buscar_medico_coordenador",
                    valor_id_medico_coordenador: codigo_medico_coordenador
                },
                success: function(resposta) {
                    console.log("Médico coordenador retornado:", resposta);
                    resolve(resposta);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function requisitarDadosMedicoExaminador(codigo_medico_examinador) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    processo_geracao_kit: "busca_medico_examinador",
                    valor_id_medico_examinador: codigo_medico_examinador
                },
                success: function(resposta) {
                    console.log("Médico examinador retornado:", resposta);
                    resolve(resposta);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function requisitarDadosMedicoFonoaudiologo(codigo_medico_fonoaudiologo) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    processo_geracao_kit: "buscar_medico_fonoaudiologo_gerenciamento_kits",
                    valor_id_fonoaudiologo: codigo_medico_fonoaudiologo
                },
                success: function(resposta) {
                    console.log("Médico examinador retornado:", resposta);
                    resolve(resposta);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function requisitarProdutos(codigo_kit) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    processo_geracao_kit: "busca_produtos",
                    valor_id_kit_produtos: codigo_kit
                },
                success: function(resposta) {
                    console.log("Produtos retornado:", resposta);
                    resolve(resposta);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }



    $(document).on("click", "#visualizar-informacoes-kit", async function(e) {
        debugger;
        recebe_codigo_kit_informacoes_rapida = $(this).data("codigo-kit");

        let recebe_dados_kit_especifico = await requisitarDadosKITEspecifico(recebe_codigo_kit_informacoes_rapida);

        let recebe_dados_clinica_especifico = await requisitarDadosClinicaEspecifico(recebe_dados_kit_especifico.clinica_id);

        let recebe_dados_colaborador_especifico = await requisitarDadosColaboradorEspecifico(recebe_dados_kit_especifico.pessoa_id);

        let recebe_dados_cargo_especifico = await requisitarDadosCargoEspecifico(recebe_dados_kit_especifico.pessoa_id);

        let recebe_dados_medico_coordenador_especifico = await requisitarDadosMedicoCoordenador(recebe_dados_kit_especifico.medico_coordenador_id);

        let recebe_dados_medico_examinador_especifico = await requisitarDadosMedicoExaminador(recebe_dados_kit_especifico.medico_clinica_id);

        let recebe_dados_medico_fonoaudiologo_especifico = await requisitarDadosMedicoFonoaudiologo(recebe_dados_kit_especifico.medico_fonoaudiologo);

        let recebe_dados_produto = await requisitarProdutos(recebe_codigo_kit_informacoes_rapida);

        console.log(recebe_dados_kit_especifico);

        // Tipo Exame (Título)
        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.tipo_exame) {
            document.getElementById("recebe-detalhe-tipo-exame").textContent = recebe_dados_kit_especifico.tipo_exame;
        } else {
            document.getElementById("recebe-detalhe-tipo-exame").textContent = "Não informado";
        }

        // Tipo Exame
        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.tipo_exame) {
            document.getElementById("recebe-tipo-exame").textContent = recebe_dados_kit_especifico.tipo_exame;
        } else {
            document.getElementById("recebe-tipo-exame").textContent = "Não informado";
        }

        // Empresa
        if (recebe_empresa_selecionada && recebe_empresa_selecionada !== "") {
            document.getElementById("nome-empresa").textContent = recebe_empresa_selecionada;
        } else {
            document.getElementById("nome-empresa").textContent = "Não informado";
        }

        // Clínica
        if (recebe_dados_clinica_especifico && recebe_dados_clinica_especifico.nome_fantasia) {
            document.getElementById("recebe-clinica").textContent = recebe_dados_clinica_especifico.nome_fantasia;
        } else {
            document.getElementById("recebe-clinica").textContent = "Não informado";
        }

        // Colaborador
        if (recebe_dados_colaborador_especifico && recebe_dados_colaborador_especifico.nome) {
            document.getElementById("recebe-colaborador").textContent = recebe_dados_colaborador_especifico.nome;
        } else {
            document.getElementById("recebe-colaborador").textContent = "Não informado";
        }

        // Motorista
        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.motorista) {
            document.getElementById("recebe-motorista").textContent = recebe_dados_kit_especifico.motorista;
        } else {
            document.getElementById("recebe-motorista").textContent = "Não informado";
        }

        // Cargo
        if (recebe_dados_cargo_especifico && recebe_dados_cargo_especifico.titulo_cargo) {
            document.getElementById("recebe-cargo").textContent = recebe_dados_cargo_especifico.titulo_cargo;
        } else {
            document.getElementById("recebe-cargo").textContent = "Não informado";
        }

        // Médico Coordenador
        if (recebe_dados_medico_coordenador_especifico && recebe_dados_medico_coordenador_especifico.nome) {
            document.getElementById("recebe-medico-coordenador").textContent = recebe_dados_medico_coordenador_especifico.nome;
        } else {
            document.getElementById("recebe-medico-coordenador").textContent = "Não informado";
        }

        // Médico Examinador
        if (recebe_dados_medico_examinador_especifico && recebe_dados_medico_examinador_especifico.nome) {
            document.getElementById("recebe-medico-examinador").textContent = recebe_dados_medico_examinador_especifico.nome;
        } else {
            document.getElementById("recebe-medico-examinador").textContent = "Não informado";
        }

        // Médico Fonoaudiólogo
        if (recebe_dados_medico_fonoaudiologo_especifico && recebe_dados_medico_fonoaudiologo_especifico.nome) {
            document.getElementById("recebe-medico-fonoaudiologo").textContent = recebe_dados_medico_fonoaudiologo_especifico.nome;
        } else {
            document.getElementById("recebe-medico-fonoaudiologo").textContent = "Não informado";
        }

        // Trata e converte os riscos
        let riscos = [];

        if (recebe_dados_kit_especifico?.riscos_selecionados) {
            try {
                riscos = JSON.parse(recebe_dados_kit_especifico.riscos_selecionados);
            } catch (e) {
                console.error("Erro ao converter riscos:", e);
                riscos = [];
            }
        }

        // Seleciona o tbody da tabela de riscos
        const tabelaRiscos = document.querySelector('#tabela-riscos');

        // Remove todas as linhas, **menos a primeira** (cabeçalho)
        while (tabelaRiscos.rows.length > 1) {
            tabelaRiscos.deleteRow(1);
        }

        // Insere as linhas se houver riscos
        for (let i = 0; i < riscos.length; i++) {
            const r = riscos[i];
            const row = document.createElement('tr');
            row.innerHTML = `
        <td style="padding:6px; border:1px solid #ccc;">${r.codigo || '-'}</td>
        <td style="padding:6px; border:1px solid #ccc;">${r.descricao || '-'}</td>
        <td style="padding:6px; border:1px solid #ccc;">${r.grupo || '-'}</td>
    `;
            tabelaRiscos.appendChild(row);
        }

        // Se não tiver riscos, adiciona linha indicando isso
        if (riscos.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td colspan="3" style="padding:6px; border:1px solid #ccc; text-align:center;">
            Nenhum risco informado
        </td>
    `;
            tabelaRiscos.appendChild(row);
        }

        // Trata e converte os treinamentos
        let treinamentos = [];

        if (recebe_dados_kit_especifico?.treinamentos_selecionados) {
            try {
                treinamentos = JSON.parse(recebe_dados_kit_especifico.treinamentos_selecionados);
            } catch (e) {
                console.error("Erro ao converter treinamentos:", e);
                treinamentos = [];
            }
        }

        // Seleciona a tabela de treinamentos
        const tabelaTreinamentos = document.querySelector('#tabela-treinamentos');

        // Remove todas as linhas, menos a primeira (cabeçalho)
        while (tabelaTreinamentos.rows.length > 1) {
            tabelaTreinamentos.deleteRow(1);
        }

        // Insere os treinamentos
        treinamentos.forEach(t => {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td style="padding:6px; border:1px solid #ccc;">${t.codigo || '-'}</td>
        <td style="padding:6px; border:1px solid #ccc;">${t.descricao || '-'}</td>
        <td style="padding:6px; border:1px solid #ccc;">${t.valor || '-'}</td>
    `;
            tabelaTreinamentos.appendChild(row);
        });

        // Se não tiver treinamentos, exibe linha informando
        if (treinamentos.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td colspan="3" style="padding:6px; border:1px solid #ccc; text-align:center;">
            Nenhum treinamento informado
        </td>
    `;
            tabelaTreinamentos.appendChild(row);
        }

        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.insalubridade) {
            document.getElementById("recebe-insalubridade").textContent = recebe_dados_kit_especifico.insalubridade;
        } else {
            document.getElementById("recebe-insalubridade").textContent = "Não informado";
        }

        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.porcentagem) {
            document.getElementById("recebe-porcentagem").textContent = recebe_dados_kit_especifico.porcentagem;
        } else {
            document.getElementById("recebe-porcentagem").textContent = "Não informado";
        }

        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.periculosidade) {
            document.getElementById("recebe-periculosidade").textContent = recebe_dados_kit_especifico.periculosidade;
        } else {
            document.getElementById("recebe-periculosidade").textContent = "Não informado";
        }

        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.aposentado_especial) {
            document.getElementById("recebe-aposentaria-especial").textContent = recebe_dados_kit_especifico.aposentado_especial;
        } else {
            document.getElementById("recebe-aposentaria-especial").textContent = "Não informado";
        }

        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.agente_nocivo) {
            document.getElementById("recebe-agente-nocivo").textContent = recebe_dados_kit_especifico.agente_nocivo;
        } else {
            document.getElementById("recebe-agente-nocivo").textContent = "Não informado";
        }

        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.ocorrencia_gfip) {
            document.getElementById("recebe-ocorrencia-gfip").textContent = recebe_dados_kit_especifico.ocorrencia_gfip;
        } else {
            document.getElementById("recebe-ocorrencia-gfip").textContent = "Não informado";
        }

        // Trata e converte as aptidões
        let aptidoes = [];

        if (recebe_dados_kit_especifico?.aptidoes_selecionadas) {
            try {
                aptidoes = JSON.parse(recebe_dados_kit_especifico.aptidoes_selecionadas);
            } catch (e) {
                console.error("Erro ao converter aptidões:", e);
                aptidoes = [];
            }
        }

        // Seleciona a tabela de aptidões
        const tabelaAptidoes = document.querySelector('#tabela-aptidoes');

        // Remove todas as linhas, menos o cabeçalho
        while (tabelaAptidoes.rows.length > 1) {
            tabelaAptidoes.deleteRow(1);
        }

        // Insere as aptidões
        aptidoes.forEach(ap => {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td style="padding:6px; border:1px solid #ccc;">${ap.codigo || '-'}</td>
        <td style="padding:6px; border:1px solid #ccc;">${ap.nome || '-'}</td>
        <td style="padding:6px; border:1px solid #ccc;">${ap.valor || '-'}</td>
    `;
            tabelaAptidoes.appendChild(row);
        });

        // Caso não tenha aptidões selecionadas
        if (aptidoes.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td colspan="3" style="padding:6px; border:1px solid #ccc; text-align:center;">
            Nenhuma aptidão informada
        </td>
    `;
            tabelaAptidoes.appendChild(row);
        }

        // Trata e converte os exames
        let exames = [];

        if (recebe_dados_kit_especifico?.exames_selecionados) {
            try {
                exames = JSON.parse(recebe_dados_kit_especifico.exames_selecionados);
            } catch (e) {
                console.error("Erro ao converter exames:", e);
                exames = [];
            }
        }

        // Seleciona a tabela de exames
        const tabelaExames = document.querySelector('#tabela-exames');

        // Remove todas as linhas, exceto a primeira (cabeçalho)
        while (tabelaExames.rows.length > 1) {
            tabelaExames.deleteRow(1);
        }

        // Insere os exames
        exames.forEach(ex => {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td style="padding:6px; border:1px solid #ccc;">${ex.codigo || '-'}</td>
        <td style="padding:6px; border:1px solid #ccc;">${ex.nome || '-'}</td>
        <td style="padding:6px; border:1px solid #ccc;">${ex.valor || '-'}</td>
    `;
            tabelaExames.appendChild(row);
        });

        // Caso não existam exames selecionados
        if (exames.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td colspan="3" style="padding:6px; border:1px solid #ccc; text-align:center;">
            Nenhum exame informado
        </td>
    `;
            tabelaExames.appendChild(row);
        }

        function montarFaturamento() {
            // --- Dados existentes ---
            const recebe_dados_produto = [{
                    id: 10,
                    id_kit: 162,
                    nome: "produto 1",
                    quantidade: 1,
                    valor: 25.55
                },
                {
                    id: 11,
                    id_kit: 162,
                    nome: "produto 2",
                    quantidade: 1,
                    valor: 25.55
                }
            ];

            const recebe_dados_kit_especifico = {
                aptidoes_selecionadas: [{
                        codigo: "5284",
                        nome: "Trabalho em Altura",
                        valor: "5284"
                    },
                    {
                        codigo: "5874",
                        nome: "Trabalho em Espaço Confinado",
                        valor: "5874"
                    }
                ],
                exames_selecionados: [{
                        codigo: "0068",
                        nome: "Acetilcolinesterase eritrocitária",
                        valor: "18,25"
                    },
                    {
                        codigo: "0109",
                        nome: "Acido hipúrico",
                        valor: "150,25"
                    }
                ],
                tipo_orcamento: "Exames e Procedimentos, Treinamentos, EPI/EPC",
                tipo_dado_bancario: "Agência/Conta",
                dado_bancario_agencia_conta: "Não informado",
                dado_bancario_pix: "Não informado"
            };

            // --- Cálculo do total ---
            let total_geral = 0;

            recebe_dados_produto.forEach(p => {
                total_geral += parseFloat(p.valor) * (p.quantidade || 1);
            });

            recebe_dados_kit_especifico.exames_selecionados.forEach(e => {
                total_geral += parseFloat((e.valor || "0").replace(",", "."));
            });

            // --- Criação da tabela ---
            const tabela = document.createElement("table");
            Object.assign(tabela.style, {
                width: "100%",
                borderCollapse: "collapse",
                fontFamily: "Arial, sans-serif",
                fontSize: "14px",
                border: "1px solid #ddd",
                borderRadius: "10px",
                boxShadow: "0 4px 12px rgba(0,0,0,0.1)",
                overflow: "hidden"
            });

            const criarLinha = (titulo, conteudo) => {
                const tr = document.createElement("tr");
                const td = document.createElement("td");
                td.style.padding = "10px";
                td.style.border = "1px solid #ddd";
                td.innerHTML = `<strong>${titulo}</strong><br>${conteudo}`;
                tr.appendChild(td);
                return tr;
            };

            const cabecalho = document.createElement("tr");
            Object.assign(cabecalho.style, {
                background: "#f1f1f1",
                fontWeight: "bold"
            });
            const tdCab = document.createElement("td");
            Object.assign(tdCab.style, {
                padding: "10px",
                border: "1px solid #ddd"
            });
            tdCab.textContent = "Itens do Faturamento";
            cabecalho.appendChild(tdCab);
            tabela.appendChild(cabecalho);

            // Produtos
            const produtosHTML = recebe_dados_produto.length ?
                recebe_dados_produto.map(p => `${p.nome} (${p.quantidade}x) - R$ ${p.valor.toFixed(2).replace('.', ',')}`).join("<br>") :
                "Nenhum produto informado.";
            tabela.appendChild(criarLinha("Produtos", produtosHTML));

            // Aptidões
            const aptidoesHTML = recebe_dados_kit_especifico.aptidoes_selecionadas.length ?
                recebe_dados_kit_especifico.aptidoes_selecionadas.map(a => a.nome).join("<br>") :
                "Nenhuma aptidão informada.";
            tabela.appendChild(criarLinha("Aptidões", aptidoesHTML));

            // Exames
            const examesHTML = recebe_dados_kit_especifico.exames_selecionados.length ?
                recebe_dados_kit_especifico.exames_selecionados.map(e => `${e.nome} - R$ ${e.valor}`).join("<br>") :
                "Nenhum exame informado.";
            tabela.appendChild(criarLinha("Exames", examesHTML));

            // Tipo de orçamento
            tabela.appendChild(criarLinha("Tipo de Orçamento", recebe_dados_kit_especifico.tipo_orcamento));

            // Dados bancários
            const dadosBancariosHTML = `
        Tipo: ${recebe_dados_kit_especifico.tipo_dado_bancario}<br>
        Agência/Conta: ${recebe_dados_kit_especifico.dado_bancario_agencia_conta}<br>
        PIX: ${recebe_dados_kit_especifico.dado_bancario_pix}
    `;
            tabela.appendChild(criarLinha("Dados Bancários", dadosBancariosHTML));

            // Total
            const totalRow = document.createElement("tr");
            Object.assign(totalRow.style, {
                background: "#fafafa",
                fontWeight: "bold"
            });
            const tdTotal = document.createElement("td");
            Object.assign(tdTotal.style, {
                padding: "12px",
                border: "1px solid #ddd",
                textAlign: "right"
            });
            tdTotal.textContent = `Total Geral: R$ ${total_geral.toLocaleString("pt-BR", { minimumFractionDigits: 2 })}`;
            totalRow.appendChild(tdTotal);
            tabela.appendChild(totalRow);

            // --- Inserir ---
            const area = document.getElementById("areaFaturamento");
            area.innerHTML = "";
            area.appendChild(tabela);
        }

        montarFaturamento();

        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.status) {
            document.getElementById("recebe-status").textContent = recebe_dados_kit_especifico.status;
        } else {
            document.getElementById("recebe-status").textContent = "Não informado";
        }

        if (recebe_dados_kit_especifico && recebe_dados_kit_especifico.data_geracao) {
            // Pega a string original
            let dataOriginal = recebe_dados_kit_especifico.data_geracao;

            // Cria um objeto Date (substitui espaço por 'T' para compatibilidade)
            let data = new Date(dataOriginal.replace(' ', 'T'));

            // Formata para o padrão brasileiro (dd/mm/aaaa)
            let dataFormatada = data.toLocaleDateString('pt-BR', {
                timeZone: 'America/Sao_Paulo'
            });

            // Exibe no elemento HTML
            document.getElementById("recebe-data").textContent = dataFormatada;
        } else {
            document.getElementById("recebe-data").textContent = "Não informado";
        }


        // $.ajax({
        //     url: "cadastros/processa_pessoa.php",
        //     method: "GET",
        //     dataType: "json",
        //     data: {
        //         "processo_pessoa": "buscar_informacoes_rapidas_pessoas",
        //         "valor_codigo_pessoa_informacoes_rapidas": recebe_codigo_pessoa_informacoes_rapida,
        //     },
        //     success: function(resposta) {
        //         debugger;

        //         if (resposta.length > 0) {
        //             for (let indice = 0; indice < resposta.length; indice++) {
        //                 $("#created_at").val(resposta[indice].created_at);
        //                 $("#nome").val(resposta[indice].nome);
        //                 $("#cpf").val(resposta[indice].cpf);
        //                 $("#nascimento").val(resposta[indice].nascimento);
        //                 $("#sexo-pessoa").val(resposta[indice].sexo);
        //                 $("#telefone").val(resposta[indice].telefone);
        //                 $("#whatsapp").val(resposta[indice].whatsapp);
        //             }
        //         }
        //     },
        //     error: function(xhr, status, error) {

        //     },
        // });

        document.getElementById('informacoes-kit').classList.remove('hidden');
        document.body.style.overflow = "hidden";
    });

    $(document).on("click", "#fechar-modal-informacoes-kit", function(e) {
        debugger;
        document.getElementById('informacoes-kit').classList.add('hidden'); // fechar
    });
</script>