<style>
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
        to { transform: rotate(360deg); }
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
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
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
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
</style>

<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <input type="hidden" name="empresa_id_alteracao" id="empresa_id_alteracao">

            <div class="form-group">
                <label for="created_at">Data de Cadastro:</label>
                <div class="input-with-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="datetime-local" id="created_at" name="created_at" class="form-control" readonly>
                </div>
            </div>

            <div class="form-columns">
                <div class="form-column">
                    <div class="form-group">
                        <label for="cnpj">CNPJ:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-address-card"></i>
                            <input type="text" id="cnpj" name="cnpj" class="form-control cnpj-input" onblur="fetchCompanyData(this.value)" oninput="formatCNPJ(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nome_fantasia">Nome Fantasia:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-building"></i>
                            <input type="text" id="nome_fantasia" name="nome_fantasia" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="razao_social">Razão Social:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-file-signature"></i>
                            <input type="text" id="razao_social" name="razao_social" class="form-control">
                        </div>
                    </div>

                    <div class="address-container">
                        <div class="form-group" style="flex: 75%;">
                            <label for="endereco">Endereço:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" id="endereco" name="endereco" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 25%; margin-left: 10px;">
                            <label for="numero">Número:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-pin"></i>
                                <input type="text" id="numero" name="numero" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="address-container">
                        <div class="form-group" style="flex: 75%;">
                            <label for="complemento">Complemento:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-signs"></i>
                                <input type="text" id="complemento" name="complemento" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 25%;">
                            <label for="bairro">Bairro:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map"></i>
                                <input type="text" id="bairro" name="bairro" class="form-control">
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
                            <select id="estado" class="form-control" onchange="carregarCidades()">
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
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone"></i>
                            <input type="text" id="telefone" name="telefone" class="form-control" oninput="formatPhone(this)">
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary" id="grava-empresa">Salvar</button>
            <button type="button" id="retornar-listagem-empresas" class="botao-cinza">Cancelar</button>
        </form>
    </div>

    <!-- <div id="profissionais" class="tab-content">
        <p>Conteúdo da aba Profissionais da Medicina Relacionados.</p>
    </div> -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<style>
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

<script>
    let recebe_codigo_alteracao_empresa;
    let recebe_acao_alteracao_empresa = "cadastrar";
    let verifica_vinculacao_medico_empresa;
    
    // Carrega os estados quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', function() {
        carregarEstados();
    });

    $(document).ready(function(e) {
        debugger;
        let recebe_url_atual = window.location.href;

        let recebe_parametro_acao_empresa = new URLSearchParams(recebe_url_atual.split("&")[1]);

        let recebe_parametro_codigo_empresa = new URLSearchParams(recebe_url_atual.split("&")[2]);

        recebe_codigo_alteracao_empresa = recebe_parametro_codigo_empresa.get("id");

        let recebe_acao_empresa = recebe_parametro_acao_empresa.get("acao");

        if (recebe_acao_empresa !== "" && recebe_acao_empresa !== null)
            recebe_acao_alteracao_empresa = recebe_acao_empresa;

        async function buscar_informacoes_empresa() {
            debugger;
            if (recebe_acao_alteracao_empresa === "editar") {
                carrega_cidades();
                await popula_lista_cidade_empresa_alteracao();
                await popula_informacoes_empresa_alteracao();

                // if (!verifica_vinculacao_medico_empresa) {
                //     $("#medico-associado-empresa").prop("disabled", false);
                //     $("#associar-medico-empresa").prop("disabled", false);
                // } else {
                //     $("#medico-associado-empresa").prop("disabled", true);
                //     $("#associar-medico-empresa").prop("disabled", true);
                // }
            } else {
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

                carrega_cidades();
            }
        }

        buscar_informacoes_empresa();
    });

    $("#retornar-listagem-empresas").click(function(e) {
        e.preventDefault();

        debugger;

        window.location.href = "painel.php?pg=empresas_principais";
    });

    async function popula_lista_cidade_empresa_alteracao() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_empresa.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_cidade_empresa",
                    "valor_id_empresa": recebe_codigo_alteracao_empresa,
                },
                success: function(resposta) {
                    debugger;
                    console.log(resposta);
                    for (let indice = 0; indice < resposta.length; indice++) {
                        $("#cidade_id").val(resposta[0].id);
                    }
                    resolve(); // sinaliza que terminou
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar cidade da clinica:" + error);
                    reject(error);
                },
            });
        });
    }

    async function popula_informacoes_empresa_alteracao() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "cadastros/processa_empresa_principal.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_empresa": "buscar_informacoes_empresas_principal_alteracao",
                    valor_codigo_empresa_principal_alteracao: recebe_codigo_alteracao_empresa,
                },
                success: async function(resposta_empresa) {
                    debugger;
                    console.log(resposta_empresa);

                    if (resposta_empresa.length > 0) {
                        const empresa = resposta_empresa[0];
                        
                        // Preenche os campos básicos
                        $("#created_at").val(empresa.created_at);
                        $("#cnpj").val(empresa.cnpj);
                        $("#nome_fantasia").val(empresa.nome);
                        $("#razao_social").val(empresa.razao_social);
                        $("#cep").val(empresa.cep);
                        $("#endereco").val(empresa.endereco);
                        $("#bairro").val(empresa.bairro);
                        $("#complemento").val(empresa.complemento);
                        $("#email").val(empresa.email);
                        $("#telefone").val(empresa.telefone);
                        $("#empresa_id_alteracao").val(empresa.id);
                        
                        // Se tiver ID de cidade, busca os dados da cidade e estado
                        if (empresa.id_cidade) {
                            try {
                                // Primeiro busca os dados da cidade para obter o estado
                                const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/municipios/${empresa.id_cidade}`);
                                const cidade = await response.json();
                                
                                if (cidade) {
                                    // Define o estado
                                    const estadoSelect = document.getElementById('estado');
                                    const uf = cidade.microrregiao.mesorregiao.UF;
                                    estadoSelect.value = uf.sigla;
                                    estadoSelect.disabled = false;
                                    
                                    // Define o ID do estado no campo oculto
                                    document.getElementById('id_estado').value = uf.id;
                                    
                                    // Armazena o estado atual para uso posterior
                                    const estadoAtual = {
                                        id: uf.id,
                                        sigla: uf.sigla,
                                        nome: uf.nome
                                    };
                                    
                                    // Dispara o evento de mudança para carregar as cidades
                                    estadoSelect.dispatchEvent(new Event('change'));
                                    
                                    // Aguarda um pouco para garantir que as cidades foram carregadas
                                    setTimeout(() => {
                                        // Define a cidade
                                        const cidadeInput = document.getElementById('cidade');
                                        cidadeInput.value = cidade.nome;
                                        document.getElementById('id_cidade').value = cidade.id;
                                        
                                        // Armazena a cidade atual
                                        cidadeAtual = cidade;
                                        
                                        // Habilita o botão de limpar
                                        document.getElementById('limparCidade').style.display = 'block';
                                        
                                        resolve(resposta_empresa);
                                    }, 500);
                                } else {
                                    resolve(resposta_empresa);
                                }
                            } catch (error) {
                                console.error('Erro ao carregar dados da cidade:', error);
                                resolve(resposta_empresa);
                            }
                        } else {
                            resolve(resposta_empresa);
                        }
                    } else {
                        reject("Nenhum dado encontrado");
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar dados da empresa: " + error);
                    reject(error);
                }
            });
        });
    }

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
        debugger;
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
        debugger;
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
        toast.textContent = message;
        
        // Estilos básicos para o toast
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.padding = '12px 20px';
        toast.style.borderRadius = '4px';
        toast.style.color = 'white';
        toast.style.fontFamily = 'Arial, sans-serif';
        toast.style.fontSize = '14px';
        toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
        toast.style.zIndex = '9999';
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease-in-out';
        
        // Cores baseadas no tipo de mensagem
        const colors = {
            success: '#4CAF50',
            error: '#F44336',
            warning: '#FF9800',
            info: '#2196F3'
        };
        
        toast.style.backgroundColor = colors[type] || colors.info;
        
        // Adiciona o toast ao corpo do documento
        document.body.appendChild(toast);
        
        // Anima a entrada
        setTimeout(() => {
            toast.style.opacity = '1';
        }, 10);
        
        // Remove o toast após 5 segundos
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 5000);
    }

    // Função para carregar cidades baseado no nome da cidade e UF
    async function carrega_cidades(nomeCidade, uf) {
        const cidadeInput = document.getElementById('cidade');
        const estadoSelect = document.getElementById('estado');
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'loading-indicator';
        loadingIndicator.innerHTML = 'Carregando...';
        loadingIndicator.style.marginTop = '5px';
        loadingIndicator.style.color = '#666';
        loadingIndicator.style.fontSize = '12px';
        
        // Adiciona o indicador de carregamento
        estadoSelect.parentNode.insertBefore(loadingIndicator, estadoSelect.nextSibling);
        
        try {
            // Primeiro, garante que os estados foram carregados
            if (estados.length === 0) {
                await carregarEstados();
            }
            
            // Define o estado selecionado
            const estadoEncontrado = estados.find(e => 
                e.sigla === uf || e.nome.toLowerCase() === uf.toLowerCase()
            );
            
            if (estadoEncontrado) {
                estadoSelect.value = estadoEncontrado.sigla;
                document.getElementById('id_estado').value = estadoEncontrado.id;
                
                // Carrega as cidades do estado
                try {
                    await carregarCidades();
                    
                    // Aguarda um pouco para garantir que as cidades foram carregadas
                    setTimeout(() => {
                        // Tenta encontrar a cidade pelo nome (busca parcial)
                        const cidadeEncontrada = cidades.find(c => 
                            c.nome.toLowerCase().includes(nomeCidade.toLowerCase())
                        );
                        
                        if (cidadeEncontrada) {
                            // Seleciona a cidade encontrada
                            selecionarCidade(cidadeEncontrada);
                            showToast('Cidade encontrada e selecionada com sucesso!', 'success');
                        } else {
                            // Se não encontrar a cidade, preenche manualmente o campo
                            cidadeInput.value = nomeCidade;
                            cidadeAtual = { nome: nomeCidade };
                            document.getElementById('limparCidade').style.display = 'block';
                            showToast('Cidade não encontrada. Por favor, selecione manualmente.', 'warning');
                        }
                    }, 800);
                } catch (error) {
                    console.error('Erro ao carregar cidades:', error);
                    cidadeInput.value = nomeCidade;
                    cidadeAtual = { nome: nomeCidade };
                    document.getElementById('limparCidade').style.display = 'block';
                    showToast('Erro ao carregar cidades. Por favor, selecione manualmente.', 'error');
                }
            } else {
                console.error('Estado não encontrado:', uf);
                cidadeInput.value = nomeCidade;
                estadoSelect.value = '';
                cidadeAtual = { nome: nomeCidade };
                document.getElementById('limparCidade').style.display = 'block';
                showToast('Estado não encontrado. Por favor, selecione manualmente.', 'error');
            }
        } catch (error) {
            console.error('Erro ao carregar estados:', error);
            // Em caso de erro, preenche manualmente os campos
            cidadeInput.value = nomeCidade;
            estadoSelect.value = uf;
            cidadeAtual = { nome: nomeCidade };
            document.getElementById('limparCidade').style.display = 'block';
            showToast('Erro ao carregar localização. Por favor, preencha manualmente.', 'error');
        } finally {
            // Remove o indicador de carregamento
            if (loadingIndicator.parentNode) {
                loadingIndicator.parentNode.removeChild(loadingIndicator);
            }
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
            if (recebe_acao_alteracao_empresa !== 'editar') {
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
            if (recebe_acao_alteracao_empresa === 'editar' && cidadeAtual) {
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

    // Removida a variável recebe_nome_cidade_empresa e recebe_id_cidade
    // pois agora usamos os campos id_cidade e id_estado diretamente

    $("#grava-empresa").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_cnpj_empresa = $("#cnpj").val();
        let recebe_nome_fantasia_empresa = $("#nome_fantasia").val()
        let recebe_razao_social_empresa = $("#razao_social").val();
        let recebe_endereco_empresa = $("#endereco").val();
        let recebe_numero_empresa = $("#numero").val();
        let recebe_complemento_empresa = $("#complemento").val();
        let recebe_bairro_empresa = $("#bairro").val();
        let recebe_cep_empresa = $("#cep").val();
        let recebe_email_empresa = $("#email").val();
        let recebe_telefone_empresa = $("#telefone").val();
        let recebe_empresa_id = $("#empresa_id").val();
        let recebe_nome_contabilidade = $("#nome_contabilidade").val();
        let recebe_email_contabilidade = $("#email_contabilidade").val();
        
        // Obtém os IDs de cidade e estado dos campos ocultos
        let recebe_id_cidade = $("#id_cidade").val();
        let recebe_id_estado = $("#id_estado").val();
        
        // Monta o endereço completo sem incluir a cidade/estado, pois agora são campos separados
        let recebe_endereco_completo = recebe_endereco_empresa + "," + recebe_numero_empresa;

        console.log(recebe_endereco_completo);

        if (recebe_acao_alteracao_empresa === "editar") {
            $.ajax({
                url: "cadastros/processa_empresa_principal.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_empresa: "alterar_empresas_principal",
                    valor_nome_fantasia_empresa: recebe_nome_fantasia_empresa,
                    valor_cnpj_empresa: recebe_cnpj_empresa,
                    valor_endereco_empresa: recebe_endereco_completo,
                    valor_telefone_empresa: recebe_telefone_empresa,
                    valor_email_empresa: recebe_email_empresa,
                    valor_id_cidade: recebe_id_cidade,
                    valor_id_estado: recebe_id_estado, // Adicionando o ID do estado
                    valor_razao_social_empresa: recebe_razao_social_empresa,
                    valor_bairro_empresa: recebe_bairro_empresa,
                    valor_cep_empresa: recebe_cep_empresa,
                    valor_complemento_empresa: recebe_complemento_empresa,
                    valor_nome_contabilidade: recebe_nome_contabilidade,
                    valor_email_contabilidade: recebe_email_contabilidade,
                    valor_id_empresa: $("#empresa_id_alteracao").val(),
                },
                success: function(retorno_empresa) {
                    debugger;

                    console.log(retorno_empresa);
                    if (retorno_empresa) {
                        console.log("Empresa alterada com sucesso");
                        window.location.href = "painel.php?pg=empresas_principais";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        } else {
            $.ajax({
                url: "cadastros/processa_empresa_principal.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_empresa: "inserir_empresas_principal",
                    valor_nome_fantasia_empresa: recebe_nome_fantasia_empresa,
                    valor_cnpj_empresa: recebe_cnpj_empresa,
                    valor_endereco_empresa: recebe_endereco_completo,
                    valor_telefone_empresa: recebe_telefone_empresa,
                    valor_email_empresa: recebe_email_empresa,
                    valor_id_cidade: recebe_id_cidade,
                    valor_id_estado: recebe_id_estado, // Adicionando o ID do estado
                    valor_razao_social_empresa: recebe_razao_social_empresa,
                    valor_bairro_empresa: recebe_bairro_empresa,
                    valor_cep_empresa: recebe_cep_empresa,
                    valor_complemento_empresa: recebe_complemento_empresa,
                },
                success: function(retorno_empresa) {
                    debugger;

                    console.log(retorno_empresa);

                    if (retorno_empresa) {
                        console.log("Empresa cadastrada com sucesso");
                        window.location.href = "painel.php?pg=empresas";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        }
    });
</script>