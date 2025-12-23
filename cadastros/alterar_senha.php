<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>
    <?php
    $nomeCompleto = $_SESSION['user_name'] ?? 'Usuário';

    // Lista de cargos que podem vir antes do nome
    $cargos = ['Vendedor', 'Cliente', 'Administrador', 'Operador', 'Admin'];

    // Divide a string
    $partes = explode(' ', trim($nomeCompleto));

    // Se o primeiro termo for um cargo conhecido, remove ele
    if (in_array($partes[0], $cargos)) {
        array_shift($partes);
    }

    // Junta o restante como nome da pessoa
    $nomePessoa = implode(' ', $partes);
    ?>
    <div id="dados" class="tab-content active">

        <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">
        <input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo $_SESSION['user_id']; ?>">
        <form class="custom-form">

            <div class="form-columns">
                <div class="form-column">


                    <div class="address-container">

                        <div class="form-group" style="flex: 50%;">
                            <label for="nome">Nome Completo:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input
                                    type="text"
                                    id="nome"
                                    name="nome"
                                    value="<?php echo !empty($nomePessoa) ? htmlspecialchars($nomePessoa) : ''; ?>"
                                    class="form-control">

                            </div>
                        </div>

                        <div class="form-group" style="flex: 50%;">
                            <label for="nova-senha">Nova senha:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-key"></i>
                                <input
                                    type="text"
                                    id="nova-senha"
                                    name="nova_senha"
                                    class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="address-container">
                        <!-- <div class="form-group" style="flex:20%;">
                            <label for="nascimento">Nível acesso:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user-shield"></i>
                                <input
                                    type="text"
                                    id="nascimento"
                                    name="nascimento"
                                    class="form-control"
                                    
                                    readonly>
                            </div>
                        </div> -->



                        <!-- <div class="form-group" style="flex:20%;">
                            <label for="sexo-pessoa">Sexo:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-mars"></i>
                                <select id="sexo-pessoa" name="sexo_pessoa" class="form-control">
                                    <option value="selecione">Selecione</option>
                                    <option value="feminino">Feminino</option>
                                    <option value="masculino">Masculino</option>
                                </select>
                            </div>
                        </div> -->

                        <!-- <div class="form-group" style="flex: 20%;">
                            <label for="criado-em">Criado em:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-alt"></i>
                                <input
                                    type="text"
                                    id="criado-em"
                                    name="criado_em"
                                    class="form-control"
                                    
                                    readonly>
                            </div>
                        </div>


                        <div class="form-group" style="flex: 20%;">
                            <label for="plano">Plano:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-tag"></i>
                                <input
                                    type="text"
                                    id="plano"
                                    name="plano"
                                    class="form-control"
                                   
                                    readonly>
                            </div>
                        </div> -->


                        <!-- <div class="form-group" style="flex: 20%;">
                            <label for="telefone">Whatsapp:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="whatsapp" name="whatsapp" oninput="mascaraTelefone(this);" class="form-control">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary" id="alterar-senha">Salvar</button>
            <!-- <button type="reset" id="retornar-listagem-pessoas" class="botao-cinza">Cancelar</button> -->
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

    /* .custom-form input[type="password"].form-control {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: none;
        border-radius: 8px;
        box-shadow: 0px 3px 5px -3px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    } */
</style>