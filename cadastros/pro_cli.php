<?php
// Conectar ao banco de dados
$conexao = new mysqli("mysql.idailneto.com.br", "idailneto06", "Sei20020615", "idailneto06");

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8");

// Inicializa o array da clínica
$clinica = [
    'id' => '',
    'cnpj' => '',
    'nome_fantasia' => '',
    'razao_social' => '',
    'endereco' => '',
    'numero' => '',
    'complemento' => '',
    'bairro' => '',
    'cidade_id' => '',
    'id_estado' => '',
    'cep' => '',
    'email' => '',
    'telefone' => '',
    'nome_contabilidade' => '',
    'email_contabilidade' => ''
];

// Se estiver editando, busca os dados da clínica
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM clinicas WHERE id = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($dados = $resultado->fetch_assoc()) {
        $clinica = array_merge($clinica, $dados);
    }
}

$conexao->close();
?>

<!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->

<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form method="post" id="empresaForm" class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <input type="hidden" id="codigo-clinica-alteracao" name="codigo_clinica_alteracao" value="<?php echo $clinica["id"]; ?>">

            <div class="form-group">
                <label for="created_at">Data de Cadastro:</label>
                <div class="input-with-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="datetime-local" value="<?= htmlspecialchars($clinica['created_at'] ?? '') ?>" id="created_at" name="created_at" class="form-control" readonly>
                </div>
            </div>

            <div class="form-columns">
                <div class="form-column">
                    <div class="form-group">
                        <label for="cnpj">CNPJ:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-address-card"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['cnpj'] ?? '') ?>" id="cnpj" name="cnpj" class="form-control cnpj-input" onblur="fetchCompanyData(this.value)" oninput="formatCNPJ(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nome_fantasia">Nome Fantasia:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-building"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['nome_fantasia'] ?? '') ?>" id="nome_fantasia" name="nome_fantasia" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="razao_social">Razão Social:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-file-signature"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['razao_social'] ?? '') ?>" id="razao_social" name="razao_social" class="form-control">
                        </div>
                    </div>

                    <div class="address-container">
                        <div class="form-group" style="flex: 75%;">
                            <label for="endereco">Endereço:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" value="<?= htmlspecialchars($clinica['endereco'] ?? '') ?>" id="endereco" name="endereco" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 25%; margin-left: 10px;">
                            <label for="numero">Número:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-pin"></i>
                                <input type="text" value="<?= htmlspecialchars($clinica['numero'] ?? '') ?>" id="numero" name="numero" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="address-container">
                        <div class="form-group" style="flex: 75%;">
                            <label for="complemento">Complemento:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-signs"></i>
                                <input type="text" value="<?= htmlspecialchars($clinica['complemento'] ?? '') ?>" id="complemento" name="complemento" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 25%;">
                            <label for="bairro">Bairro:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map"></i>
                                <input type="text" value="<?= htmlspecialchars($clinica['bairro'] ?? '') ?>" id="bairro" name="bairro" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-column">
                    <input type="hidden" id="id_estado" name="id_estado">
                    <input type="hidden" id="id_cidade" name="cidade_id">

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-marker-alt"></i>
                            <select id="estado"  class="form-control" onchange="carregarCidades()">
                                <option value="">Carregando estados...</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cidade">Cidade:</label>
                        <div class="autocomplete-box">
                            <div class="autocomplete-container">
                                <div class="input-with-icon">
                                    <i class="fas fa-city"></i>
                                    <input type="text" id="cidade" class="form-control" placeholder="Digite o nome da cidade" oninput="filtrarCidades()" disabled>
                                    <button type="button" id="limparCidade" class="clear-btn" style="display: none;" onclick="limparCidade()">×</button>
                                </div>
                            </div>
                            <ul id="listaCidades" class="autocomplete-list"></ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cep">CEP:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-marked-alt"></i>
                            <input type="text" id="cep" name="cep" class="form-control" oninput="formatCEP(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" value="<?= htmlspecialchars($clinica['email'] ?? '') ?>" id="email" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['telefone'] ?? '') ?>" id="telefone" name="telefone" class="form-control" oninput="formatPhone(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status: Ativa/Inativa</label>
                        <div class="status-toggle">
                            <input
                                type="checkbox"
                                id="status"
                                name="status"
                                class="toggle-checkbox"

                                <?php if (isset($clinica["status"]) && $clinica["status"] == "Ativo") {
                                    echo 'checked' ?? "";
                                } ?>>
                            <label for="status" class="toggle-label"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nome_contabilidade">Nome da Contabilidade:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-building"></i>
                            <input type="text" value="<?= htmlspecialchars($clinica['nome_contabilidade'] ?? '') ?>" id="nome_contabilidade" name="nome_contabilidade" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email_contabilidade">Email da Contabilidade:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" value="<?= htmlspecialchars($clinica['email_contabilidade'] ?? '') ?>" id="email_contabilidade" name="email_contabilidade" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: flex-start; gap: 40px;">
                <!-- Coluna esquerda: select + botão -->
                <div class="form-group">
                    <label for="cidade_id_2">Vincular Médico Examinador</label>
                    <div class="input-with-icon" style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-user-md"></i>
                        <select id="medico-associado" name="medico_associado" class="form-control" style="max-width: 250px;"></select>
                        <button type="button" class="btn btn-primary" id="associar-medico-clinica">Incluir</button>
                    </div>
                </div>

                <!-- Coluna direita: tabela -->
                <div>
                    <table id="tabela-medico-associado" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Médicos examinadores vinculados a essa clinica</th>
                                <th>Opção</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dados serão preenchidos via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>



            <button type="submit" class="btn btn-primary">Salvar</button>
            <button type="button" id="retornar-listagem-clinicas" class="botao-cinza">Cancelar</button>
        </form>
    </div>

    <!-- <div id="profissionais" class="tab-content">
        <p>Conteúdo da aba Profissionais da Medicina Relacionados.</p>
    </div> -->
</div>

<style>
    /* Estilos gerais da tabela */
    #tabela-medico-associado {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #tabela-medico-associado th,
    #tabela-medico-associado td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #tabela-medico-associado th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .tab-container {
        width: 100%;
    }

    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #ccc;
    }

    .tab-button {
        padding: 10px 20px;
        cursor: pointer;
        background-color: #f1f1f1;
        border: none;
        outline: none;
        transition: background-color 0.3s;
    }

    .tab-button:hover {
        background-color: #ddd;
    }

    .tab-button.active {
        background-color: rgb(59, 59, 59);
        color: white;
    }

    .tab-content {
        display: none;
        padding: 20px;
        border: none;
        border-top: none;
    }

    .tab-content.active {
        display: block;
    }

    .custom-form .form-columns {
        display: flex;
        gap: 20px;
    }

    .custom-form .form-column {
        flex: 1;
    }

    .custom-form .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 11px;
        color: #888;
    }

    .custom-form .form-control {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: none;
        border-radius: 8px;
        box-shadow: 0px 3px 5px -3px rgba(0, 0, 0, 0.1);
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
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

    .btn-primary {
        padding: 10px 20px;
        background-color: rgb(72, 74, 77);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Ajuste para o campo de data e hora */
    input[type="datetime-local"] {
        width: auto;
        /* Define a largura automática */
        max-width: 300px;
        /* Define uma largura máxima */
    }

    /* Estilo para o container de endereço */
    .address-container {
        display: flex;
        gap: 10px;
    }

    /* Estilo para o input de CNPJ */
    .cnpj-input {
        border: none;
        background-color: rgb(201, 201, 201);
        font-weight: bold;
        color: black;
    }


    .cnpj-input:focus {
        border-color: #45a049;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
    }

    .botao-cinza {
        background-color: #6c757d;
        /* cinza escuro */
        color: white;
        /* texto branco */
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .botao-cinza:hover {
        background-color: #5a6268;
        /* cinza mais escuro no hover */
    }

    /* Estilos para indicadores de carregamento e feedback */
    .loading-indicator,
    .loading-cidades {
        display: inline-block;
        margin-left: 10px;
        color: #666;
        font-size: 0.875rem;
    }

    .spinner-border {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 0.2em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        vertical-align: middle;
        margin-right: 5px;
        animation: spinner-border .75s linear infinite;
    }

    @keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
    }

    /* Estilo para mensagens toast */
    .toast-message {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 4px;
        color: white;
        font-family: Arial, sans-serif;
        font-size: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        max-width: 300px;
    }

    .toast-success {
        background-color: #4CAF50;
    }

    .toast-error {
        background-color: #F44336;
    }

    .toast-warning {
        background-color: #FF9800;
    }

    .toast-info {
        background-color: #2196F3;
    }

    /* Melhorias para o autocomplete de cidades */
    .autocomplete-box {
        position: relative;
    }

    #listaCidades {
        position: absolute;
        z-index: 1000;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-top: 2px;
        display: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #listaCidades li {
        padding: 8px 12px;
        cursor: pointer;
        list-style: none;
        border-bottom: 1px solid #eee;
    }

    #listaCidades li:hover {
        background-color: #f5f5f5;
    }

    #listaCidades li:last-child {
        border-bottom: none;
    }

    /* Melhorias para o botão de limpar cidade */
    #limparCidade {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        display: none;
    }

    #limparCidade:hover {
        color: #666;
    }


    /* Estilos para o autocomplete de cidades */
    .autocomplete-box {
        position: relative;
        width: 100%;
    }

    .autocomplete-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .clear-btn {
        position: absolute;
        right: 10px;
        background: none;
        border: none;
        color: #999;
        font-size: 18px;
        cursor: pointer;
        padding: 0 5px;
        z-index: 2;
    }

    .clear-btn:hover {
        color: #666;
    }

    .autocomplete-list {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: white;
        z-index: 1000;
        list-style: none;
        padding: 0;
        margin: 2px 0 0 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .autocomplete-list li {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .autocomplete-list li:hover {
        background-color: #f5f5f5;
    }

    .autocomplete-list li:last-child {
        border-bottom: none;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    // Dados da clínica carregados diretamente do PHP
    const dadosClinica = <?php echo json_encode($clinica); ?>;
    
    let recebe_codigo_alteracao_clinica = '<?php echo $clinica['id'] ?: ''; ?>';
    let recebe_acao_alteracao_clinica = '<?php echo !empty($clinica['id']) ? 'editar' : 'novo'; ?>';

    // Carrega os estados quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', function() {
        carregarEstados();
    });


    $(document).ready(function(e) {

        debugger;

        let recebe_url_atual = window.location.href;

        let recebe_parametro_acao_clinica = new URLSearchParams(recebe_url_atual.split("&")[1]);

        let recebe_parametro_codigo_clinica = new URLSearchParams(recebe_url_atual.split("&")[2]);

        recebe_codigo_alteracao_clinica = recebe_parametro_codigo_clinica.get("id");

        recebe_acao_alteracao_clinica = recebe_parametro_acao_clinica.get("acao");

        console.log(recebe_codigo_alteracao_clinica);

        async function buscar_informacoes_clinica() {
            debugger;
            if (recebe_acao_alteracao_clinica === "editar") {
                // Carrega os dados da clínica, incluindo cidade e estado
                await carregarDadosClinica();
                await popula_medicos_associar_clinica();
                await popula_medicos_associados_clinica();
            } else {
                carregarCidades();
                await popula_medicos_associar_clinica();

                let atual = new Date();

                let ano = atual.getFullYear();
                let mes = String(atual.getMonth() + 1).padStart(2, '0');
                let dia = String(atual.getDate()).padStart(2, '0');
                let horas = String(atual.getHours()).padStart(2, '0');
                let minutos = String(atual.getMinutes()).padStart(2, '0');

                // Formato aceito por <input type="datetime-local">
                let data_formatada = `${ano}-${mes}-${dia}T${horas}:${minutos}`;

                console.log("Data formatada para input datetime-local:", data_formatada);
                document.getElementById('created_at').value = data_formatada;

            }
        }

        buscar_informacoes_clinica();
    });

    $("#retornar-listagem-clinicas").click(function(e) {
        e.preventDefault();

        debugger;

        window.location.href = "painel.php?pg=clinicas";
    });

    // $("#cep").blur(function(e){
    //     e.preventDefault();

    //     let cep = $(this).val();

    //     $.ajax({
    //         url: `https://viacep.com.br/ws/${cep}/json/`,
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(dados) {
    //             debugger;
    //             if (dados.erro) {
    //                 $('#resultado').text('CEP não encontrado.');
    //             } else {
    //                 console.log(dados);
    //                 let cidade = dados.localidade;
    //                 let estado = dados.uf;
    //                 // $('#resultado').text(`${cidade} - ${estado}`);
    //             }
    //         },
    //         error: function() {
    //             $('#resultado').text('Erro ao buscar o CEP.');
    //         }
    //     });
    // });

    async function carregarDadosClinica() {
        if (!dadosClinica || !dadosClinica.id) {
            console.log('Nenhum dado de clínica disponível para carregar');
            return;
        }
        
        try {
            console.log('Carregando dados da clínica:', dadosClinica);
            
            // Preenche os campos do formulário diretamente dos dados já carregados
            document.getElementById('cnpj').value = dadosClinica.cnpj || '';
            document.getElementById('nome_fantasia').value = dadosClinica.nome_fantasia || '';
            document.getElementById('razao_social').value = dadosClinica.razao_social || '';
            document.getElementById('endereco').value = dadosClinica.endereco || '';
            document.getElementById('numero').value = dadosClinica.numero || '';
            document.getElementById('complemento').value = dadosClinica.complemento || '';
            document.getElementById('bairro').value = dadosClinica.bairro || '';
            document.getElementById('cep').value = dadosClinica.cep || '';
            document.getElementById('email').value = dadosClinica.email || '';
            document.getElementById('telefone').value = dadosClinica.telefone || '';
            document.getElementById('nome_contabilidade').value = dadosClinica.nome_contabilidade || '';
            document.getElementById('email_contabilidade').value = dadosClinica.email_contabilidade || '';
            
            // Se tiver o ID do estado, carrega os estados e depois as cidades
            if (dadosClinica.id_estado) {
                console.log('Carregando estado:', dadosClinica.id_estado);
                
                // Primeiro carrega a lista de estados
                await carregarEstados();
                
                // Depois de carregar os estados, seleciona o estado correto
                const estadoSelect = document.getElementById('estado');
                if (estadoSelect) {
                    // Aguarda um pequeno atraso para garantir que o select foi preenchido
                    await new Promise(resolve => setTimeout(resolve, 100));
                    
                    // Encontra a opção correta baseada no ID do estado
                    const estadoOption = Array.from(estadoSelect.options).find(
                        option => option.getAttribute('data-id') == dadosClinica.id_estado
                    );
                    
                    if (estadoOption) {
                        estadoSelect.value = estadoOption.value;
                        document.getElementById('id_estado').value = dadosClinica.id_estado;
                        
                        // Dispara o evento de mudança para carregar as cidades
                        const event = new Event('change');
                        estadoSelect.dispatchEvent(event);
                    }
                    
                    // Agora carrega as cidades para o estado selecionado
                    if (dadosClinica.cidade_id) {
                        console.log('Carregando cidade:', dadosClinica.cidade_id);
                        
                        // Aguarda um pequeno atraso para garantir que o estado foi selecionado
                        await new Promise(resolve => setTimeout(resolve, 300));
                        
                        try {
                            // Busca o nome da cidade pelo ID usando a API do IBGE
                            const responseCidade = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/municipios/${dadosClinica.cidade_id}`);
                            const cidadeData = await responseCidade.json();
                            
                            if (cidadeData) {
                                const cidadeInput = document.getElementById('cidade');
                                const cidadeIdInput = document.getElementById('id_cidade');
                                
                                // Define os valores dos campos
                                cidadeInput.value = cidadeData.nome;
                                cidadeIdInput.value = cidadeData.id;
                                
                                console.log('Cidade carregada com sucesso:', cidadeData.nome);
                                
                                // Aguarda um pouco mais para garantir que o datalist foi atualizado
                                await new Promise(resolve => setTimeout(resolve, 500));
                                
                                // Atualiza o datalist com a cidade selecionada
                                const datalist = document.getElementById('listaCidades');
                                if (datalist) {
                                    // Limpa o datalist
                                    datalist.innerHTML = '';
                                    // Adiciona a cidade ao datalist
                                    const option = document.createElement('li');
                                    option.textContent = cidadeData.nome;
                                    option.dataset.id = cidadeData.id;
                                    option.addEventListener('click', function() {
                                        cidadeInput.value = this.textContent;
                                        cidadeIdInput.value = this.dataset.id;
                                        datalist.style.display = 'none';
                                    });
                                    datalist.appendChild(option);
                                }
                            }
                        } catch (error) {
                            console.error('Erro ao buscar dados da cidade:', error);
                        }
                    }
                }
            }
        } catch (error) {
            console.error('Erro ao carregar dados da clínica:', error);
        }
    }
    
    // Função para carregar cidades baseado no estado selecionado com cache e tratamento de erros aprimorado
    
    // Função para carregar os estados do IBGE com cache e tratamento de erros aprimorado
    
    async function carregarCidadesPorEstado(uf) {
        if (!uf) return;
        
        try {
            const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios?orderBy=nome`);
            const cidades = await response.json();
            
            const cidadeInput = document.getElementById('cidade');
            const cidadeIdInput = document.getElementById('id_cidade');
            const datalist = document.getElementById('listaCidades');
            
            // Limpa o datalist
            if (datalist) {
                datalist.innerHTML = '';
                
                // Adiciona as cidades ao datalist
                cidades.forEach(cidade => {
                    const option = document.createElement('li');
                    option.textContent = cidade.nome;
                    option.dataset.id = cidade.id;
                    option.addEventListener('click', function() {
                        cidadeInput.value = this.textContent;
                        cidadeIdInput.value = this.dataset.id;
                        datalist.style.display = 'none';
                    });
                    datalist.appendChild(option);
                });
            }
            
            // Habilita o campo de cidade
            cidadeInput.disabled = false;
            
            return cidades;
        } catch (error) {
            console.error('Erro ao carregar cidades:', error);
            return [];
        }
    }
    
    // Função para filtrar cidades conforme o usuário digita
    function filtrarCidades() {
        const input = document.getElementById('cidade');
        const filter = input.value.toUpperCase();
        const datalist = document.getElementById('listaCidades');
        
        if (!datalist) return;
        
        const items = datalist.getElementsByTagName('li');
        let hasVisibleItems = false;
        
        for (let i = 0; i < items.length; i++) {
            const txtValue = items[i].textContent || items[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                items[i].style.display = '';
                hasVisibleItems = true;
            } else {
                items[i].style.display = 'none';
            }
        }
        
        datalist.style.display = hasVisibleItems ? 'block' : 'none';
    }
    
    // Função para limpar a cidade selecionada
    function limparCidade() {
        const cidadeInput = document.getElementById('cidade');
        const cidadeIdInput = document.getElementById('id_cidade');
        const limparBtn = document.getElementById('limparCidade');
        
        cidadeInput.value = '';
        cidadeIdInput.value = '';
        limparBtn.style.display = 'none';
    }


    async function popula_medicos_associar_clinica() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_medico.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_medico": "buscar_medicos_associar_clinica"
                },
                success: function(resposta_medicos) {
                    debugger;
                    console.log(resposta_medicos);
                    if (resposta_medicos.length > 0) {
                        let select_medicos = document.getElementById('medico-associado');
                        let options = '<option value="">Selecione um médico</option>';
                        for (let i = 0; i < resposta_medicos.length; i++) {
                            let medico = resposta_medicos[i];
                            options += `<option value="${medico.id}">${medico.nome}</option>`;
                        }
                        select_medicos.innerHTML = options;
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

    async function popula_medicos_associados_clinica() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_medico.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_medico": "buscar_medicos_associados_clinica",
                    valor_codigo_clinica_medicos_associados: recebe_codigo_alteracao_clinica,
                },
                success: function(resposta_medicos) {
                    debugger;
                    console.log(resposta_medicos);

                    if (resposta_medicos.length > 0) {
                        let recebe_tabela_associar_medico_clinica = document.querySelector(
                            "#tabela-medico-associado tbody"
                        );

                        $("#tabela-medico-associado tbody").html("");

                        let htmlContent = "";
                        for (let indice = 0; indice < resposta_medicos.length; indice++) {
                            htmlContent +=
                                '<tr>' +
                                '<td>' + resposta_medicos[indice].nome_medico + '</td>' +
                                '<td><i class="fas fa-trash" id="exclui-medico-ja-associado"' +
                                ' data-codigo-medico-clinica="' + resposta_medicos[indice].id + '" data-codigo-medico="' + resposta_medicos[indice].medico_id + '"></i></td>' +
                                '</tr>';
                        }
                        $("#tabela-medico-associado tbody").html(htmlContent);
                    } else {
                        $("#tabela-medico-associado tbody").html("");
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

    $(document).on("click", "#exclui-medico-ja-associado", function(e) {
        e.preventDefault();

        let recebe_codigo_medico_ja_associado = $(this).data("codigo-medico-clinica");

        let recebe_codigo_medico = $(this).data("codigo-medico");

        $.ajax({
            url: "cadastros/processa_clinica.php",
            method: "POST",
            dataType: "json",
            data: {
                "processo_clinica": "desvincular_medico_clinica",
                valor_medico_clinica_id: recebe_codigo_medico_ja_associado,
                valor_codigo_medico: recebe_codigo_medico
            },
            success: function(resposta_medicos_clinicas) {
                debugger;

                console.log(resposta_medicos_clinicas);

                if (resposta_medicos_clinicas) {
                    async function buscar_informacoes_clinica() {
                        debugger;
                        if (recebe_acao_alteracao_clinica === "editar") {
                            await popula_medicos_associados_clinica();
                        }
                    }

                    buscar_informacoes_clinica();
                }
            },
            error: function(xhr, status, error) {

            },
        });
    });

    let valores_codigos_medicos = Array();
    let limpou_tabela_alteracao;

    $("#associar-medico-clinica").click(function(e) {
        e.preventDefault();

        debugger;

        if (recebe_acao_alteracao_clinica === "editar") {
            if (!limpou_tabela_alteracao) {
                $("#tabela-medico-associado tbody").html("");
                limpou_tabela_alteracao = true;
            }

            let recebe_codigo_medico_selecionado_associar_clinica = $("#medico-associado").val();

            let recebe_nome_medico_selecionado_associar_clinica = $('#medico-associado option:selected').text();

            let recebe_tabela_associar_medico_clinica = document.querySelector("#tabela-medico-associado tbody");

            let indice = recebe_tabela_associar_medico_clinica.querySelectorAll("tr").length;

            recebe_tabela_associar_medico_clinica.insertAdjacentHTML('beforeend', 
                '<tr data-index="' + indice + '">' +
                '<td>' + recebe_nome_medico_selecionado_associar_clinica + '</td>' +
                '<td><i class="fas fa-trash" id="exclui-medico-associado"></i></td>' +
                '</tr>');

            valores_codigos_medicos.push(recebe_codigo_medico_selecionado_associar_clinica);
        } else {
            let recebe_codigo_medico_selecionado_associar_clinica = $("#medico-associado").val();

            let recebe_nome_medico_selecionado_associar_clinica = $('#medico-associado option:selected').text();

            console.log(recebe_codigo_medico_selecionado_associar_clinica + " - " + recebe_nome_medico_selecionado_associar_clinica);

            let recebe_tabela_associar_medico_clinica = document.querySelector(
                "#tabela-medico-associado tbody"
            );

            let indice = recebe_tabela_associar_medico_clinica.querySelectorAll("tr").length;

            recebe_tabela_associar_medico_clinica.insertAdjacentHTML('beforeend', 
                '<tr data-index="' + indice + '">' +
                '<td>' + recebe_nome_medico_selecionado_associar_clinica + '</td>' +
                '<td><i class="fas fa-trash" id="exclui-medico-associado"></i></td>' +
                '</tr>');

            valores_codigos_medicos.push(recebe_codigo_medico_selecionado_associar_clinica);

            $("#tabela-medico-associado tbody").append(recebe_tabela_associar_medico_clinica);
        }
    });

    $(document).on("click", "#exclui-medico-associado", function(e) {
        e.preventDefault();

        debugger;

        let linha = $(this).closest("tr");
        let index = linha.data("index");

        linha.remove();

        valores_codigos_medicos.splice(index, 1);

        console.log(valores_codigos_medicos);

        let recebe_tabela_associar_medico_clinica = document.querySelector("#tabela-medico-associado tbody");

        // Pega todas as linhas <tr> dentro do tbody
        let linhas = recebe_tabela_associar_medico_clinica.querySelectorAll("tr");

        // Itera usando for tradicional
        for (let i = 0; i < linhas.length; i++) {
            linhas[i].setAttribute("data-index", i);
        }
    });


    function openTab(event, tabName) {
        const tabContents = document.querySelectorAll('.tab-content');
        const tabButtons = document.querySelectorAll('.tab-button');

        tabContents.forEach(tab => tab.classList.remove('active'));
        tabButtons.forEach(button => button.classList.remove('active'));

        document.getElementById(tabName).classList.add('active');
        event.currentTarget.classList.add('active');
    }

    function formatCNPJ(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 14) value = value.slice(0, 14);
        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
        input.value = value;
    }

    function formatCNPJ(input) {
        // Remove tudo que não for dígito
        let value = input.value.replace(/\D/g, '');
        
        // Limita a 14 caracteres (tamanho do CNPJ sem formatação)
        if (value.length > 14) {
            value = value.slice(0, 14);
        }
        
        // Aplica a formatação do CNPJ (XX.XXX.XXX/XXXX-XX)
        value = value.replace(/(\d{2})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1/$2');
        value = value.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
        
        // Atualiza o valor do campo
        input.value = value;
        
        // Se o CNPJ estiver completo (com formatação), valida
        if (value.length === 18) {
            validateCNPJ(value);
        }
    }
    
    function validateCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if (cnpj.length !== 14) return false;
        fetchCompanyData(cnpj);
    }

    function formatCEPValue(cep) {
        cep = cep.replace(/\D/g, '');
        if (cep.length > 8) cep = cep.slice(0, 8);
        return cep.replace(/^(\d{5})(\d{3})$/, '$1-$2');
    }

    function formatPhoneValue(phone) {
        phone = phone.replace(/\D/g, '');
        if (phone.length > 11) phone = phone.slice(0, 11);
        return phone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    }

    function formatCEP(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 8) value = value.slice(0, 8);
        value = value.replace(/^(\d{5})(\d{3})$/, '$1-$2');
        input.value = value;
    }

    function formatPhone(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        input.value = value;
    }


    function fetchCompanyData(cnpj) {
        const cleanedCNPJ = cnpj.replace(/[.\/-]/g, '');

        // Limpa os campos de cidade/estado
        document.getElementById('cidade').value = '';
        document.getElementById('id_cidade').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('id_estado').value = '';
        document.getElementById('limparCidade').style.display = 'none';
        cidadeAtual = null;

        fetch(`https://open.cnpja.com/office/${cleanedCNPJ}`)
            .then(response => response.json())
            .then(data => {
                debugger;
                console.log(data);

                // Preenche os campos básicos
                document.getElementById('nome_fantasia').value = data.alias || '';
                document.getElementById('razao_social').value = data.company.name || '';
                document.getElementById('endereco').value = data.address.street || '';
                document.getElementById('numero').value = data.address.number || '';
                document.getElementById('complemento').value = data.address.details || '';
                document.getElementById('bairro').value = data.address.district || '';
                document.getElementById('cep').value = formatCEPValue(data.address.zip || '');
                document.getElementById('email').value = data.emails[0]?.address || '';

                // Formata o telefone se existir
                if (data.phones && data.phones.length > 0) {
                    const phone = data.phones[0];
                    const phoneNumber = phone.area && phone.number ?
                        formatPhoneValue(`${phone.area}${phone.number}`) : '';
                    document.getElementById('telefone').value = phoneNumber;
                } else {
                    document.getElementById('telefone').value = '';
                }

                // Preenche cidade e estado usando a função carrega_cidades
                if (data.address.city && data.address.state) {
                    carrega_cidades(data.address.city, data.address.state);
                } else {
                    // Se não tiver cidade/estado, apenas carrega os estados
                    carregarEstados();
                }

                // Atualiza a data/hora atual
                const now = new Date();
                const formattedDateTime = now.toISOString().slice(0, 16);
                document.getElementById('created_at').value = formattedDateTime;
            })
            .catch(error => {
                console.error('Erro ao buscar CNPJ:', error);
                // Mesmo em caso de erro, carrega os estados para o usuário poder selecionar
                carregarEstados();
            });
    }

    // Variáveis globais para armazenar estados e cidades
    let estados = [];
    let cidades = [];
    let cidadeAtual = null;

    // Função para exibir notificações toast
    function showToast(message, type = 'info') {
        // Remove toasts antigos
        const oldToasts = document.querySelectorAll('.toast-message');
        oldToasts.forEach(toast => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        });

        // Cria o elemento do toast
        const toast = document.createElement('div');
        toast.className = `toast-message toast-${type}`;
        try {
            // Remove toasts antigos
            const oldToasts = document.querySelectorAll('.toast-message');
            oldToasts.forEach(toast => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            });

            // Cria o elemento do toast
            const toast = document.createElement('div');
            toast.className = `toast-message toast-${type}`;
            
            // Adiciona o ícone baseado no tipo
            let icon = 'info-circle';
            if (type === 'success') icon = 'check-circle';
            else if (type === 'error') icon = 'exclamation-circle';
            else if (type === 'warning') icon = 'exclamation-triangle';

            toast.innerHTML = `
                <i class="fas fa-${icon}"></i>
                <span>${message}</span>
                <button class="toast-close">&times;</button>
            `;

            // Adiciona o toast ao corpo do documento
            document.body.appendChild(toast);

            // Força o navegador a renderizar o elemento com opacidade 0
            setTimeout(() => {
                toast.style.opacity = '1';
            }, 10);

            // Fecha o toast após 3 segundos
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300); // Tempo para a animação de fade out
            }, 3000);
        } catch (error) {
            console.error('Erro ao exibir toast:', error);
        }
    }

    // Função auxiliar para atualizar a UI após o carregamento das cidades
    function updateUIAfterCityLoad(fromCache = false) {
        const cidadeInput = document.getElementById('cidade');
        cidadeInput.disabled = false;
        cidadeInput.placeholder = 'Digite o nome da cidade';

        // Preenche o campo de cidade com as cidades
        const cidadeOptions = cidades.map(cidade => {
            return {
                label: cidade.nome,
                value: cidade.nome
            };
        });

        // Adiciona o evento de mudança para carregar as cidades
        try {
            cidadeInput.addEventListener('input', function() {
                try {
                    const cidadeEncontrada = cidades.find(c =>
                        c.nome.toLowerCase().includes(this.value.toLowerCase())
                    );

                    if (cidadeEncontrada) {
                        // Seleciona a cidade encontrada
                        selecionarCidade(cidadeEncontrada);
                        showToast('Cidade encontrada e selecionada com sucesso!', 'success');
                    } else {
                        // Se não encontrar a cidade, preenche manualmente o campo
                        cidadeInput.value = this.value;
                        cidadeAtual = {
                            nome: this.value
                        };
                        document.getElementById('limparCidade').style.display = 'block';
                        showToast('Cidade não encontrada. Por favor, selecione manualmente.', 'warning');
                    }
                } catch (error) {
                    console.error('Erro ao processar cidade:', error);
                    cidadeInput.value = this.value;
                    cidadeAtual = { nome: this.value };
                    document.getElementById('limparCidade').style.display = 'block';
                    showToast('Erro ao processar a cidade. Por favor, tente novamente.', 'error');
                }
            });
        } catch (error) {
            console.error('Erro ao configurar o evento de input da cidade:', error);
            showToast('Erro ao configurar a busca de cidades. Por favor, recarregue a página.', 'error');
        }
    }

    // Função para carregar os estados do IBGE com cache e tratamento de erros aprimorado
    async function carregarEstados() {
        const estadoSelect = document.getElementById('estado');

        // Cria e configura o indicador de carregamento
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'loading-estados';
        loadingIndicator.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="spinner-border spinner-border-sm me-2" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <span>Buscando estados...</span>
            </div>
        `;
        loadingIndicator.style.marginTop = '5px';
        loadingIndicator.style.color = '#666';

        // Insere o indicador após o campo de estado
        const estadoContainer = estadoSelect.parentNode;
        estadoContainer.insertBefore(loadingIndicator, estadoSelect.nextSibling);

        // Configura o estado inicial do campo
        estadoSelect.disabled = true;
        estadoSelect.innerHTML = '<option value="">Carregando estados...</option>';

        try {
            // Verifica se já temos os estados em cache
            const cacheKey = 'estados_ibge';
            const cachedData = sessionStorage.getItem(cacheKey);

            if (cachedData) {
                // Usa os dados em cache
                estados = JSON.parse(cachedData);
                updateUIAfterStateLoad(true);
            } else {
                // Faz a requisição para a API do IBGE
                showToast('Buscando lista de estados...', 'info');

                const response = await fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Erro ao buscar estados: ${response.status} ${response.statusText} - ${errorText}`);
                }

                estados = await response.json();

                // Armazena em cache na sessionStorage
                try {
                    sessionStorage.setItem(cacheKey, JSON.stringify(estados));
                } catch (e) {
                    console.warn('Não foi possível armazenar estados em cache:', e);
                }

                updateUIAfterStateLoad(false);
            }

        } catch (error) {
            console.error('Erro ao carregar estados:', error);

            // Mensagem de erro mais amigável
            let errorMessage = 'Não foi possível carregar a lista de estados.';

            if (error.message.includes('Failed to fetch')) {
                errorMessage = 'Erro de conexão. Verifique sua internet e tente novamente.';
            } else if (error.message.includes('404')) {
                errorMessage = 'Serviço de estados não disponível no momento.';
            } else if (error.message.includes('429')) {
                errorMessage = 'Muitas requisições. Por favor, aguarde um momento e tente novamente.';
            }

            showToast(errorMessage, 'error');

            // Define uma mensagem de erro no select
            estadoSelect.innerHTML = '<option value="">Erro ao carregar estados</option>';

        } finally {
            // Remove o indicador de carregamento
            if (loadingIndicator.parentNode) {
                loadingIndicator.parentNode.removeChild(loadingIndicator);
            }
        }

        // Função auxiliar para atualizar a UI após o carregamento dos estados
        function updateUIAfterStateLoad(fromCache = false) {
            const estadoSelect = document.getElementById('estado');
            estadoSelect.innerHTML = '<option value="">Selecione um estado</option>';

            // Preenche o select com os estados
            estados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.sigla;
                option.textContent = estado.nome;
                option.setAttribute('data-id', estado.id);
                estadoSelect.appendChild(option);
            });

            // Habilita o campo de estado
            estadoSelect.disabled = false;

            // Se estiver em modo de edição, o estado será definido posteriormente
            if (recebe_acao_alteracao_clinica !== 'editar') {
                estadoSelect.disabled = false;

                // Adiciona o evento de mudança para carregar as cidades
                estadoSelect.addEventListener('change', function() {
                    if (this.value) {
                        carregarCidades();
                    } else {
                        // Se nenhum estado for selecionado, limpa as cidades
                        const cidadeInput = document.getElementById('cidade');
                        cidadeInput.value = '';
                        document.getElementById('id_cidade').value = '';
                        document.getElementById('id_estado').value = '';
                        document.getElementById('limparCidade').style.display = 'none';
                    }
                });
            }

            // Mostra mensagem de sucesso
            const cacheMessage = fromCache ? ' (dados em cache)' : '';
            showToast(`${estados.length} estados carregados${cacheMessage}`, 'success');
        }
    }

    // Função para carregar cidades baseado no estado selecionado com cache e tratamento de erros aprimorado
    async function carregarCidades() {
        const estadoSelect = document.getElementById('estado');
        const cidadeInput = document.getElementById('cidade');
        const listaCidades = document.getElementById('listaCidades');
        const siglaEstado = estadoSelect.value;

        // Verificação inicial de estado vazio
        if (!siglaEstado) {
            cidadeInput.disabled = true;
            cidadeInput.value = '';
            document.getElementById('id_estado').value = '';
            return;
        }

        // Cria e configura o indicador de carregamento
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'loading-cidades';
        loadingIndicator.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="spinner-border spinner-border-sm me-2" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <span>Buscando cidades...</span>
            </div>
        `;
        loadingIndicator.style.marginTop = '5px';
        loadingIndicator.style.color = '#666';

        // Insere o indicador após o campo de cidade
        const cidadeContainer = cidadeInput.parentNode;
        cidadeContainer.insertBefore(loadingIndicator, cidadeInput.nextSibling);

        // Configura o estado inicial do campo de cidade
        cidadeInput.disabled = true;
        cidadeInput.placeholder = 'Aguarde, carregando cidades...';

        try {
            // Encontra o estado selecionado
            const estado = estados.find(e => e.sigla === siglaEstado);
            if (!estado) {
                throw new Error('Estado não encontrado na lista de estados disponíveis');
            }

            // Atualiza o ID do estado no campo oculto
            document.getElementById('id_estado').value = estado.id;

            // Verifica se já temos as cidades em cache para este estado
            const cacheKey = `cidades_${estado.id}`;
            const cachedData = sessionStorage.getItem(cacheKey);

            if (cachedData) {
                // Usa os dados em cache
                cidades = JSON.parse(cachedData);
                updateUIAfterCityLoad(estado, true);
            } else {
                // Faz a requisição para a API do IBGE
                showToast(`Buscando cidades de ${estado.nome}...`, 'info');

                const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${siglaEstado}/municipios`);

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Erro ao buscar cidades: ${response.status} ${response.statusText} - ${errorText}`);
                }

                cidades = await response.json();

                // Ordena as cidades alfabeticamente
                cidades.sort((a, b) => a.nome.localeCompare(b.nome));

                // Armazena em cache na sessionStorage (válido apenas durante a sessão)
                try {
                    sessionStorage.setItem(cacheKey, JSON.stringify(cidades));
                } catch (e) {
                    console.warn('Não foi possível armazenar em cache:', e);
                }

                updateUIAfterCityLoad(estado, false);
            }

        } catch (error) {
            console.error('Erro ao carregar cidades:', error);

            // Mensagem de erro mais amigável
            let errorMessage = 'Não foi possível carregar a lista de cidades.';

            if (error.message.includes('Failed to fetch')) {
                errorMessage = 'Erro de conexão. Verifique sua internet e tente novamente.';
            } else if (error.message.includes('404')) {
                errorMessage = 'Estado não encontrado. Por favor, selecione outro estado.';
            } else if (error.message.includes('429')) {
                errorMessage = 'Muitas requisições. Por favor, aguarde um momento e tente novamente.';
            }

            showToast(errorMessage, 'error');

            // Define uma mensagem de erro no placeholder e permite digitação manual
            cidadeInput.placeholder = 'Digite o nome da cidade';
            cidadeInput.disabled = false;

        } finally {
            // Remove o indicador de carregamento
            if (loadingIndicator.parentNode) {
                loadingIndicator.parentNode.removeChild(loadingIndicator);
            }
        }

        // Função auxiliar para atualizar a UI após o carregamento das cidades
        function updateUIAfterCityLoad(estado, fromCache = false) {
            // Habilita o campo de cidade
            cidadeInput.disabled = false;
            cidadeInput.placeholder = 'Digite o nome da cidade';

            // Mostra mensagem de sucesso
            const cacheMessage = fromCache ? ' (dados em cache)' : '';
            showToast(`${cidades.length} cidades carregadas para ${estado.nome}${cacheMessage}`, 'success');

            // Se estiver em modo de edição, tenta selecionar a cidade
            if (recebe_acao_alteracao_clinica === 'editar' && cidadeAtual) {
                const cidadeEncontrada = cidades.find(c =>
                    c.nome.toLowerCase() === cidadeAtual.nome.toLowerCase()
                );

                if (cidadeEncontrada) {
                    selecionarCidade(cidadeEncontrada);
                    showToast(`Cidade ${cidadeEncontrada.nome} selecionada automaticamente`, 'success');
                } else {
                    showToast('Cidade não encontrada na lista. Por favor, selecione manualmente.', 'warning');
                }
            }

            // Foca no campo de cidade para facilitar a digitação
            cidadeInput.focus();
        }
    }

    // Função para filtrar cidades conforme o usuário digita
    function filtrarCidades() {
        const input = document.getElementById('cidade');
        const filtro = input.value.toLowerCase();
        const listaCidades = document.getElementById('listaCidades');

        if (!filtro) {
            listaCidades.style.display = 'none';
            document.getElementById('limparCidade').style.display = 'none';
            return;
        }

        const cidadesFiltradas = cidades.filter(cidade =>
            cidade.nome.toLowerCase().includes(filtro)
        );

        if (cidadesFiltradas.length === 0) {
            listaCidades.innerHTML = '<li>Nenhuma cidade encontrada</li>';
            listaCidades.style.display = 'block';
            return;
        }

        listaCidades.innerHTML = '';

        cidadesFiltradas.slice(0, 10).forEach(cidade => {
            const li = document.createElement('li');
            li.textContent = cidade.nome;
            li.onclick = () => selecionarCidade(cidade);
            listaCidades.appendChild(li);
        });

        listaCidades.style.display = 'block';
        document.getElementById('limparCidade').style.display = 'block';
    }

    // Função para selecionar uma cidade
    function selecionarCidade(cidade) {
        const cidadeInput = document.getElementById('cidade');
        const listaCidades = document.getElementById('listaCidades');
        const estadoSelect = document.getElementById('estado');
        const idEstadoInput = document.getElementById('id_estado');

        // Atualiza o campo de cidade
        cidadeInput.value = cidade.nome;
        document.getElementById('id_cidade').value = cidade.id;
        listaCidades.style.display = 'none';

        // Obtém o estado selecionado atual
        const siglaEstado = estadoSelect.value;

        // Se já tivermos um estado selecionado, usa o ID desse estado
        if (siglaEstado) {
            const estadoSelecionado = estados.find(e => e.sigla === siglaEstado);
            if (estadoSelecionado) {
                idEstadoInput.value = estadoSelecionado.id;
            }
        }
        // Se a cidade tiver informações de estado, atualiza o estado também
        else if (cidade.microrregiao?.mesorregiao?.UF) {
            const uf = cidade.microrregiao.mesorregiao.UF;
            estadoSelect.value = uf.sigla;
            idEstadoInput.value = uf.id;
        }
        // Se não encontrou o estado de outra forma, tenta obter do nome da cidade (último recurso)
        else if (cidade['municipio-region']?.UF) {
            const uf = cidade['municipio-region'].UF;
            estadoSelect.value = uf.sigla;
            idEstadoInput.value = uf.id;
        }

        console.log('Cidade selecionada:', cidade.nome, 'ID Cidade:', cidade.id, 'ID Estado:', idEstadoInput.value);

        // Armazena a cidade atual para uso posterior
        cidadeAtual = cidade;

        // Habilita o botão de limpar
        document.getElementById('limparCidade').style.display = 'block';
    }

    // Função para limpar a seleção de cidade
    function limparCidade() {
        const cidadeInput = document.getElementById('cidade');
        const listaCidades = document.getElementById('listaCidades');
        const estadoSelect = document.getElementById('estado');

        // Limpa os campos de cidade
        cidadeInput.value = '';
        document.getElementById('id_cidade').value = '';

        // Limpa o estado e o ID do estado
        estadoSelect.value = '';
        document.getElementById('id_estado').value = '';

        // Esconde a lista de cidades e o botão de limpar
        listaCidades.style.display = 'none';
        document.getElementById('limparCidade').style.display = 'none';

        // Limpa a referência à cidade atual
        cidadeAtual = null;

        // Foca no campo de cidade
        cidadeInput.focus();

        // Habilita o campo de estado para permitir nova seleção
        estadoSelect.disabled = false;

        // Limpa o array de cidades para forçar recarregar quando um novo estado for selecionado
        cidades = [];
    }

    // Fechar a lista de cidades ao clicar fora
    document.addEventListener('click', function(event) {
        const listaCidades = document.getElementById('listaCidades');
        const cidadeInput = document.getElementById('cidade');

        if (event.target !== cidadeInput && event.target !== listaCidades) {
            listaCidades.style.display = 'none';
        }
    });

    // Função mantida para compatibilidade, mas agora usando a API do IBGE
    function carrega_cidades(cidadeSelecionada = '', estadoSelecionado = '') {
        // Se for uma chamada vinda do preenchimento automático do CNPJ
        if (estadoSelecionado) {
            const estadoSelect = document.getElementById('estado');
            const idEstadoInput = document.getElementById('id_estado');

            // Encontra o estado pelo nome ou sigla
            const estado = estados.find(e =>
                e.nome.toLowerCase() === estadoSelecionado.toLowerCase() ||
                e.sigla.toLowerCase() === estadoSelecionado.toLowerCase()
            );

            if (estado) {
                console.log('Estado encontrado:', estado.nome, 'ID:', estado.id);

                // Define o estado e o ID do estado
                estadoSelect.value = estado.sigla;
                idEstadoInput.value = estado.id;

                // Carrega as cidades
                carregarCidades().then(() => {
                    // Depois de carregar as cidades, tenta encontrar e selecionar a cidade
                    if (cidadeSelecionada) {
                        const cidadeEncontrada = cidades.find(c =>
                            c.nome.toLowerCase() === cidadeSelecionada.toLowerCase()
                        );

                        if (cidadeEncontrada) {
                            console.log('Cidade encontrada:', cidadeEncontrada.nome, 'ID:', cidadeEncontrada.id);
                            selecionarCidade(cidadeEncontrada);
                        } else {
                            console.log('Cidade não encontrada na lista:', cidadeSelecionada);
                            // Se não encontrar a cidade, preenche apenas o nome e garante o ID do estado
                            const cidadeInput = document.getElementById('cidade');
                            cidadeInput.value = cidadeSelecionada;
                            document.getElementById('id_estado').value = estado.id; // Garante que o ID do estado está definido
                            document.getElementById('limparCidade').style.display = 'block';
                        }
                    }
                });
            } else {
                console.warn('Estado não encontrado:', estadoSelecionado);
                // Se não encontrar o estado, apenas carrega os estados
                carregarEstados();
            }
        } else {
            // Se não tiver estado/cidade, apenas carrega os estados
            carregarEstados();
        }
    }

    // async function carregarCidades(cidadeSelecionada = '', estadoSelecionado = '') {
    //     const apiUrl = 'api/list/cidades.php';
    //     const cidadeSelect = document.getElementById('cidade_id');

    //     fetch(apiUrl)
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.status === 'success') {
    //                 cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

    //                 data.data.cidades.forEach(cidade => {
    //                     const option = document.createElement('option');
    //                     option.value = cidade.id;
    //                     option.textContent = `${cidade.nome} - ${cidade.estado}`;
    //                     cidadeSelect.appendChild(option);
    //                 });

    //                 if (cidadeSelecionada) {
    //                     debugger;
    //                     for (let i = 0; i < cidadeSelect.options.length; i++) {
    //                         if (cidadeSelect.options[i].text.includes(cidadeSelecionada) &&
    //                             cidadeSelect.options[i].text.includes(estadoSelecionado)) {
    //                             cidadeSelect.selectedIndex = i;
    //                             break;
    //                         }
    //                     }
    //                 }
    //             } else {
    //                 console.error('Erro ao carregar cidades:', data.message);
    //             }
    //         })
    //         .catch(error => console.error('Erro na requisição:', error));
    // }

    // function fetchCompanyData(cnpj) {
    //     const cleanedCNPJ = cnpj.replace(/[.\/-]/g, '');

    //     fetch(`https://open.cnpja.com/office/${cleanedCNPJ}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             document.getElementById('nome_fantasia').value = data.alias || '';
    //             document.getElementById('razao_social').value = data.company.name || '';
    //             document.getElementById('endereco').value = data.address.street || '';
    //             document.getElementById('numero').value = data.address.number || '';
    //             document.getElementById('complemento').value = data.address.details || '';
    //             document.getElementById('bairro').value = data.address.district || '';
    //             document.getElementById('cep').value = formatCEPValue(data.address.zip || '');
    //             document.getElementById('email').value = data.emails[0]?.address || '';
    //             document.getElementById('telefone').value = formatPhoneValue(data.phones[0] ? `${data.phones[0].area}${data.phones[0].number}` : '');

    //             carregarCidades(data.address.city, data.address.state);

    //             // const now = new Date();
    //             // const formattedDateTime = now.toISOString().slice(0, 16);

    //             // const now = new Date();

    //             // Formatar data e hora local no formato "dd/mm/yyyy hh:mm"
    //             // const dia = String(now.getDate()).padStart(2, '0');
    //             // const mes = String(now.getMonth() + 1).padStart(2, '0'); // mês começa do 0
    //             // const ano = now.getFullYear();
    //             // const horas = String(now.getHours()).padStart(2, '0');
    //             // const minutos = String(now.getMinutes()).padStart(2, '0');

    //             // const formattedDateTime = `${dia}/${mes}/${ano} ${horas}:${minutos}`;

    //             // console.log("Hora local:", formattedDateTime);


    //             // document.getElementById('created_at').value = formattedDateTime;
    //         })
    //         .catch(error => console.error('Erro ao buscar CNPJ:', error));
    // }

    // document.addEventListener('DOMContentLoaded', function() {
    //     //carregarCidades();

    //     // const now = new Date();
    //     // const formattedDateTime = now.toISOString().slice(0, 16);

    //     // const now = new Date();

    //     // Formatar data e hora local no formato "dd/mm/yyyy hh:mm"
    //     // const dia = String(now.getDate()).padStart(2, '0');
    //     // const mes = String(now.getMonth() + 1).padStart(2, '0'); // mês começa do 0
    //     // const ano = now.getFullYear();
    //     // const horas = String(now.getHours()).padStart(2, '0');
    //     // const minutos = String(now.getMinutes()).padStart(2, '0');

    //     // const formattedDateTime = `${dia}/${mes}/${ano} ${horas}:${minutos}`;

    //     // console.log("Hora local:", formattedDateTime);
    //     // document.getElementById('created_at').value = formattedDateTime;
    // });

    document.getElementById('empresaForm').addEventListener('submit', function(event) {
        event.preventDefault();
        debugger;
        const formData = new FormData(this);

        console.log(formData);

        formData.append("codigos_medicos_associados", JSON.stringify(valores_codigos_medicos));

        console.log(formData);

        if (recebe_acao_alteracao_clinica === "editar") {
            fetch('cadastros/pro_cli_json.php?pg=pro_cli&acao=editar', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    debugger;
                    console.log(data);
                    window.location.href = "painel.php?pg=clinicas";
                })
                .catch((error) => {
                    console.error('Erro:', error);
                });
        } else {
            fetch('cadastros/pro_cli_json.php?pg=pro_cli&acao=cadastrar&tipo=insert', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    debugger;
                    console.log(data);
                    window.location.href = "painel.php?pg=clinicas";
                })
                .catch((error) => {
                    console.error('Erro:', error);
                });
        }
    });
</script>


<!-- Adicione o Font Awesome para os ícones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">