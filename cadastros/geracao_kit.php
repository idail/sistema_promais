<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modelo de Abas Interativas com Elevação</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .tab-container {
            display: flex;
            position: relative;
            z-index: 1;
            padding-left: 10px;
            gap: 0;
        }

        .tab-button {
            position: relative;
            z-index: 1;
            transition: all .3s cubic-bezier(.4, 0, .2, 1);
            border-radius: 10px 10px 0 0;
            cursor: pointer;
            flex: 1 1 auto;
            min-width: 100px;
            padding: 1.25rem;
            background-color: rgba(240, 240, 240, 0.3);
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            color: #939393;
            transform: translateY(10px);
            text-align: center;
            user-select: none;
        }

        /* REMOVIDO: .tab-button:hover, .tab-button:focus-visible */

        .active-tab {
            background-color: white;
            color: #111827;
            box-shadow: 0 14px 20px rgba(0, 0, 0, 0.3);
            z-index: 10 !important;
            font-weight: 600;
            transform: translateY(0);
        }

        .tab-content {
            width: 100%;
            padding: 30px;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 5;
            margin-top: -12px;
        }

        .tab-content[aria-hidden="false"] {
            display: flex;
        }

        .text-area {
            font-size: 18px;
            color: black;
        }

        .exam-card {
            width: 160px;
            /* largura fixa */
            height: 128px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgb(0 0 0 / 0.1);
            font-weight: 700;
            color: white;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            transition: transform 0.2s ease-in-out;
            flex: 0 0 auto;
            /* impede o redimensionamento automático */
        }

        .exam-card:hover,
        .exam-card:focus-visible {
            transform: scale(1.05);
            outline: none;
        }

        .bg-admissional {
            background-color: #00A759;
        }

        .bg-periodico {
            background-color: #0086FF;
        }

        .bg-demissional {
            background-color: #FF0066;
        }

        .bg-mudanca {
            background-color: #750099;
        }

        .bg-retorno {
            background-color: #606163;
        }

        .bg_exame_laudo {
            background-color: #db5c00;
        }

        .exam-card img {
            margin-bottom: 0.5rem;
            width: 50px;
            height: 50px;
        }

        .cards-container {
            display: flex;
            flex-wrap: nowrap;
            /* evita quebra de linha */
            gap: 1rem;
            width: 100%;
            overflow-x: auto;
            /* adiciona scroll horizontal se necessário */
            justify-content: flex-start;
            /* alinha ao início */
            padding-bottom: 10px;
        }

        .exames-header {
            display: flex;
            align-items: center;
            gap: 16px;
            width: 100%;
            max-width: 1069px;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 0 20px;
            margin-top: 40px;
            z-index: 1;
        }

        .btn-nav {
            font-size: 18px;
            font-weight: 600;
            color: #000;
            cursor: pointer;
            border: none;
            background: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-nav:hover {
            background-color: #eaeaea;
            color: #007bff;
        }

        .bloco-selecao {
            background: white;
            border-radius: 16px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            padding: 24px;
            border: 1px solid #E5E7EB;
            width: 100%;
        }

        .input-container {
            position: relative;
        }

        .input-container label {
            font-weight: 500;
            color: #374151;
        }

        .input-container input {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #D1D5DB;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.3s ease-in-out;
        }

        .input-container input:focus {
            border-color: #00A759;
            box-shadow: 0 0 0 4px rgba(0, 167, 89, 0.2);
        }

        .input-container ul {
            position: absolute;
            width: 100%;
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 4px;
            max-height: 160px;
            overflow-y: auto;
            display: none;
        }

        .info-text {
            font-size: 14px;
            color: #6B7280;
        }

        .input-uniforme {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #D1D5DB;
            border-radius: 10px;
            outline: none;
            font-size: 16px;
        }

        .input-uniforme:focus {
            border-color: #00A759;
            box-shadow: 0 0 0 4px rgba(0, 167, 89, 0.2);
        }

        .btn-green {
            background-color: #00A759;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
            border: none;
            outline: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            margin-bottom: 7px;
        }

        .btn-green i {
            font-size: 20px;
        }

        .btn-green:hover {
            background-color: #008C4A;
        }

        .input-container {
            flex-grow: 1;
        }

        .flex.items-center {
            align-items: flex-end;
            gap: 12px;
        }

        .passo-text {
            font-size: 0.875rem;
            margin-bottom: 1rem;
            /* espaço abaixo do passo */
            color: #555;
            /* tom cinza discreto, se quiser */
            font-weight: 600;
            /* opcional para destacar */
        }

        .laudo-resumo {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            padding: 30px;
            margin: 0;
        }

        .laudo-resumo .container {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .laudo-resumo .header {
            background-color: #f57c00;
            color: white;
            padding: 16px;
            border-radius: 16px 16px 0 0;
            text-align: center;
            font-size: 18px;
            font-weight: 500;
        }

        .laudo-resumo .title {
            font-size: 22px;
            font-weight: 500;
            color: #444;
            margin-bottom: 16px;
            text-align: center;
        }

        .laudo-resumo .dropdown-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
            gap: 10px;
            margin-top: 20px;
        }

        .laudo-resumo .dropdown-wrapper {
            flex: 1;
            min-width: 120px;
        }

        .laudo-resumo label {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            color: #333;
            text-align: center;
        }

        .laudo-resumo .custom-dropdown {
            background: #fff;
            border-radius: 14px;
            padding: 10px 12px;
            font-size: 14px;
            color: #333;
            box-shadow: 0 8px 14px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            position: relative;
            user-select: none;
            text-align: center;
        }

        .laudo-resumo .custom-dropdown::after {
            content: '▼';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 10px;
            color: #666;
        }

        .laudo-resumo .options {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            width: 100%;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            z-index: 100;
            display: none;
            flex-direction: column;
            padding: 6px 0;
        }

        .laudo-resumo .option {
            padding: 8px 12px;
            font-size: 14px;
            color: #222;
            cursor: pointer;
            text-align: center;
        }

        .laudo-resumo .option:hover {
            background-color: #f0f0f0;
        }

        .laudo-resumo .active .options {
            display: flex;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">

    <div class="w-full px-4 max-w-7xl">
        <div class="tab-container" role="tablist" aria-label="Abas principais">
            <div class="tab-button active-tab flex items-center justify-center gap-2" role="tab" tabindex="0" aria-selected="true" aria-controls="exames" id="tab-exames" data-tab="exames">
                <i class="fas fa-vial text-xl"></i>
                <h3 class="text-lg">Passo 01</h3>
            </div>
            <div class="tab-button flex items-center justify-center gap-2" role="tab" tabindex="-1" aria-selected="false" aria-controls="selecao" id="tab-selecao" data-tab="selecao">
                <i class="fas fa-tasks" style="margin-bottom: 3px;"></i>
                <h3 class="text-lg" style="margin-bottom: 0px;">Passo 02</h3>
            </div>
            <div class="tab-button flex items-center justify-center gap-2" role="tab" tabindex="-1" aria-selected="false" aria-controls="medicos" id="tab-medicos" data-tab="medicos">
                <i class="fas fa-user-md" style="margin-bottom: 3px;"></i>
                <h3 class="text-lg" style="margin-bottom: 0px;">Passo 03</h3>
            </div>
            <div class="tab-button flex items-center justify-center gap-2" role="tab" tabindex="-1" aria-selected="false" aria-controls="riscos" id="tab-riscos" data-tab="riscos">
                <i class="fas fa-exclamation-triangle" style="margin-bottom: 3px;"></i>
                <h3 class="text-lg" style="margin-bottom: 0px;">Passo 04</h3>
            </div>
            <div class="tab-button flex items-center justify-center gap-2" role="tab" tabindex="-1" aria-selected="false" aria-controls="procedimentos" id="tab-procedimentos" data-tab="procedimentos">
                <i class="fas fa-stethoscope" style="margin-bottom: 3px;"></i>
                <h3 class="text-lg" style="margin-bottom: 0px;">Passo 05</h3>
            </div>
        </div>
    </div>

    <main class="w-full px-4 max-w-7xl mt-0">
        <section id="exames" class="tab-content" aria-labelledby="tab-exames" role="tabpanel" aria-hidden="false">
            <div class="exames-header" style="margin-top: 30px;">
                <img src="https://www.idailneto.com.br/promais/cadastros/circulo_exame.svg" alt="Círculo Exame" width="100" height="100" />
                <p class="text-area text-left flex-1">Selecione o tipo de exame / procedimento a ser realizado para Iniciar</p>
            </div>

            <div class="cards-container" style="margin-top: 50px;">
                <div class="exam-card bg-admissional" role="button" tabindex="0" aria-label="Exame Admissional" style="margin-top: 5px;margin-left: 10px;">
                    <img src="https://www.idailneto.com.br/promais/cadastros/admissional.svg" alt="Ícone Admissional" />
                    <span>Admissional</span>
                </div>
                <div class="exam-card bg-periodico" role="button" tabindex="0" aria-label="Exame Periódico" style="margin-top: 5px;">
                    <img src="https://www.idailneto.com.br/promais/cadastros/periodico.svg" alt="Ícone Periódico" />
                    <span>Periódico</span>
                </div>
                <div class="exam-card bg-demissional" role="button" tabindex="0" aria-label="Exame Demissional" style="margin-top: 5px;">
                    <img src="https://www.idailneto.com.br/promais/cadastros/demissional.svg" alt="Ícone Demissional" />
                    <span>Demissional</span>
                </div>
                <div class="exam-card bg-mudanca" role="button" tabindex="0" aria-label="Mudança de Risco/Função" style="margin-top: 5px;">
                    <img src="https://www.idailneto.com.br/promais/cadastros/mud_rs_fn.svg" alt="Ícone Mudança Risco/Função" />
                    <span>Mud. Risco/Função</span>
                </div>
                <div class="exam-card bg-retorno" role="button" tabindex="0" aria-label="Retorno ao Trabalho" style="margin-top: 5px;">
                    <img src="https://www.idailneto.com.br/promais/cadastros/retorno_ao_trabalho.svg" alt="Ícone Retorno ao Trabalho" />
                    <span>Retorno ao Trabalho</span>
                </div>
                <div class="exam-card bg_exame_laudo" role="button" tabindex="0" aria-label="Retorno ao Trabalho" style="margin-top: 5px;">
                    <img src="https://www.idailneto.com.br/promais/cadastros/exame_laudo.svg" alt="Ícone Retorno ao Trabalho" />
                    <span>Resumo de Laudo</span>
                </div>
            </div>
        </section>

        <section id="selecao" class="tab-content" aria-labelledby="tab-selecao" role="tabpanel" aria-hidden="true">
            <div class="bloco-selecao w-full px-4 mx-auto">
                <h4 class="text-2xl font-bold text-gray-700 mb-6">Selecione Empresa, Clínica e Colaborador</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Coluna da Esquerda: Clínica -->
                    <div class="col-span-1">
                        <div class="flex items-center gap-3">
                            <div class="input-container grow">
                                <label class="block mb-1 text-sm font-medium text-gray-600">Buscar/Selecionar empresa</label>
                                <input type="text" id="clinicaInput" placeholder="Digite para procurar..." class="input-uniforme" oninput="mostrarDropdown('empresa')">
                                <ul id="clinicaDropdown"></ul>
                                <div class="info-text text-sm text-gray-500 mt-1" id="infoempresa"></div>
                            </div>
                            <button class="btn-green">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Coluna da Direita: Empresa acima, Colaborador abaixo -->
                    <div class="col-span-1 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="input-container grow" style="margin-bottom: 20px;">
                                <label class="block mb-1 text-sm font-medium text-gray-600">Buscar/Selecionar clínica</label>
                                <input type="text" id="empresaInput" placeholder="Digite para procurar..." class="input-uniforme" oninput="mostrarDropdown('clinica')">
                                <ul id="empresaDropdown"></ul>
                                <div class="info-text text-sm text-gray-500 mt-1" id="infoclinicas"></div>
                            </div>
                            <button class="btn-green" style="margin-bottom: 27px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="flex items-center gap-3" style="margin-bottom: 35px;">
                            <div class="input-container grow">
                                <label class="block mb-1 text-sm font-medium text-gray-600">Buscar/Selecionar pessoa/colaborador</label>
                                <input type="text" id="pessoaInput" placeholder="Digite para procurar..." class="input-uniforme" oninput="mostrarDropdown('pessoa')">
                                <ul id="pessoaDropdown"></ul>
                                <div class="info-text text-sm text-gray-500 mt-1" id="infoPessoa"></div>
                            </div>
                            <button class="btn-green">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="input-container grow">
                                <label class="block mb-1 text-sm font-medium text-gray-600">Buscar/Cargo/CBO</label>
                                <input type="text" id="pessoaInput" placeholder="Digite para procurar..." class="input-uniforme" oninput="mostrarDropdown('cargo_cbo')">
                                <ul id="pessoaDropdown"></ul>
                                <div class="info-text text-sm text-gray-500 mt-1" id="infocargo_pessoa"></div>
                            </div>
                            <button class="btn-green">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section id="medicos" class="tab-content" aria-labelledby="tab-medicos" role="tabpanel" aria-hidden="true">
            <div class="bloco-selecao w-full px-4 mx-auto">
                <h4 class="text-2xl font-bold text-gray-700 mb-6">Selecione os Profissionais da Medicina</h4>
                <h2>Profissinais relacionados a clínica:Nome da clínica</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" style="margin-top: 50px;">
                    <!-- Coluna da Esquerda: Clínica -->
                    <div class="col-span-1">
                        <div class="flex items-center gap-3">
                            <div class="input-container grow">
                                <label class="block mb-1 text-sm font-medium text-gray-600">Coordenador Responsável PCMSO da empresa</label>
                                <input type="text" id="clinicaInput" placeholder="Digite para procurar..." class="input-uniforme" oninput="mostrarDropdown('profissional_relacionado_empresa')">
                                <ul id="clinicaDropdown"></ul>
                                <div class="info-text text-sm text-gray-500 mt-1" id="infoprofissionalrelacionadoempresa"></div>
                            </div>
                            <button class="btn-green">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Coluna da Direita: Empresa acima, Colaborador abaixo -->
                    <div class="col-span-1 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="input-container grow">
                                <label class="block mb-1 text-sm font-medium text-gray-600">Médico Emitente/Examinador da Clínica </label>
                                <input type="text" id="empresaInput" placeholder="Digite para procurar..." class="input-uniforme" oninput="mostrarDropdown('profissional_relacionado_clinica')">
                                <ul id="empresaDropdown"></ul>
                                <div class="info-text text-sm text-gray-500 mt-1" id="infoprofissionalrelacionadoclinica"></div>
                            </div>
                            <button class="btn-green">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="riscos" class="tab-content" aria-labelledby="tab-riscos" role="tabpanel" aria-hidden="true">
            <div class="bloco-selecao w-full px-4 mx-auto">
                <h4 class="text-2xl font-bold text-gray-700 mb-6">Selecione Fatores e Riscos</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" style="margin-top: 50px;">
                    <div class="col-span-1">
                        <div class="flex items-center gap-3">
                            <div class="input-container grow">
                                <label class="block mb-1 text-sm font-medium text-gray-600">Digite para buscar ou apenas digite</label>
                                <select id="clinicaSelect" class="input-uniforme">
                                    <option value="">Selecione uma opção...</option>
                                    <option value="clinica1">Clínica 1</option>
                                    <option value="clinica2">Clínica 2</option>
                                    <option value="clinica3">Clínica 3</option>
                                </select>
                                <ul id="clinicaDropdown"></ul>
                                <div class="info-text text-sm text-gray-500 mt-1" id="infofatoresderisco"></div>
                            </div>
                            <button class="btn-green flex items-center gap-2 px-4 py-2 min-w-max">
                                <i class="fas fa-save" style="margin-bottom: 5px;"></i> Adicionar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="laudo-resumo">
                    <div class="container mt-12">

                        <!-- Título e bloco laranja agrupados e acima dos dropdowns -->
                        <div class="flex flex-col items-center justify-center text-center w-full mb-6">
                            <h4 class="text-2xl font-bold text-gray-700 mb-4">
                                Resumo de laudo (Aba opcional de Profissional Técnico)
                            </h4>
                            <div class="w-full bg-[#f57c00] text-white font-medium text-sm py-3 px-6 rounded-md shadow-sm uppercase tracking-wide">
                                Nome da empresa, CAEPF/ CNPJ; Resumo de Laudos/ LTCAT / Laudo de Insalubridade e Periculosidade
                            </div>
                        </div>

                        <!-- Linha de dropdowns que agora ocupa a largura completa e quebra se necessário -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 w-full">
                            <div class="dropdown-wrapper">
                                <label class="block mb-1 text-sm font-medium text-center">Insalubridade</label>
                                <div class="custom-dropdown">Selecione
                                    <div class="options">
                                        <div class="option">Sim</div>
                                        <div class="option">Não</div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-wrapper flex-1 min-w-[150px]">
                                <label class="block mb-1 text-sm font-medium text-center">Porcentagem</label>
                                <div class="custom-dropdown">Selecione
                                    <div class="options">
                                        <div class="option">10%</div>
                                        <div class="option">20%</div>
                                        <div class="option">40%</div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-wrapper flex-1 min-w-[150px]">
                                <label class="block mb-1 text-sm font-medium text-center">Periculosidade 30%</label>
                                <div class="custom-dropdown">Selecione
                                    <div class="options">
                                        <div class="option">Sim</div>
                                        <div class="option">Não</div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-wrapper flex-1 min-w-[150px]">
                                <label class="block mb-1 text-sm font-medium text-center">Aposent. Esp.</label>
                                <div class="custom-dropdown">Selecione
                                    <div class="options">
                                        <div class="option">Sim</div>
                                        <div class="option">Não</div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-wrapper flex-1 min-w-[150px]">
                                <label class="block mb-1 text-sm font-medium text-center">Agente Nocivo</label>
                                <div class="custom-dropdown">Selecione
                                    <div class="options">
                                        <div class="option">Sim</div>
                                        <div class="option">Não</div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-wrapper flex-1 min-w-[150px]">
                                <label class="block mb-1 text-sm font-medium text-center">Ocorrência GFIP</label>
                                <div class="custom-dropdown">Selecione
                                    <div class="options">
                                        <div class="option">00</div>
                                        <div class="option">01</div>
                                        <div class="option">02</div>
                                        <div class="option">03</div>
                                        <div class="option">04</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fim do bloco -->
            </div>
        </section>

        <section id="procedimentos" class="tab-content" aria-labelledby="tab-procedimentos" role="tabpanel" aria-hidden="true">
            <!-- Título principal -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-left text-gray-800">Procedimentos / Exames Realizados</h1>
            </div>

            <!-- Cabeçalho com "Selecionar Modelos" e contador -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-left">Selecionar Modelos</h2>
                <div id="modelosSelecionados" class="text-sm text-gray-500 text-right">0 modelos selecionados</div>
            </div>

            <!-- Grid com os modelos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Modelo 1 -->
                <label for="modelo1" class="relative group">
                    <input type="checkbox" id="modelo1" name="modelos[]" value="guia" class="hidden peer" onchange="atualizarContadorModelos()">
                    <div class="border rounded-xl shadow cursor-pointer p-4 transition-all peer-checked:ring-2 peer-checked:ring-green-500 peer-checked:shadow-lg peer-checked:-translate-y-0.5 border-b-4 border-b-green-400">
                        <div class="flex gap-2 items-center text-green-500 mb-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 10h4l3-8 4 16 3-8h4"></path>
                            </svg>
                            <span class="font-semibold text-left">Guia de encaminhamento</span>
                        </div>
                        <p class="text-sm text-gray-500 text-left">Gera guia de Encaminhamento com base no modelo</p>
                    </div>
                </label>

                <!-- Modelo 2 -->
                <label for="modelo2" class="relative group">
                    <input type="checkbox" id="modelo2" name="modelos[]" value="prontuario" class="hidden peer" onchange="atualizarContadorModelos()">
                    <div class="border rounded-xl shadow cursor-pointer p-4 transition-all peer-checked:ring-2 peer-checked:ring-yellow-500 peer-checked:shadow-lg peer-checked:-translate-y-0.5 border-b-4 border-b-yellow-400">
                        <div class="flex gap-2 items-center text-yellow-500 mb-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="font-semibold text-left">Prontuário Médico</span>
                        </div>
                        <p class="text-sm text-gray-500 text-left">Gera guia de Prontuário com base no modelo</p>
                    </div>
                </label>

                <!-- Modelo 3 -->
                <label for="modelo3" class="relative group">
                    <input type="checkbox" id="modelo3" name="modelos[]" value="aptidao" class="hidden peer" onchange="atualizarContadorModelos()">
                    <div class="border rounded-xl shadow cursor-pointer p-4 transition-all peer-checked:ring-2 peer-checked:ring-cyan-500 peer-checked:shadow-lg peer-checked:-translate-y-0.5 border-b-4 border-b-cyan-400">
                        <div class="flex gap-2 items-center text-cyan-500 mb-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="font-semibold text-left">Aptidão Física Mental</span>
                        </div>
                        <p class="text-sm text-gray-500 text-left">Gera guia de Aptidão com base no modelo</p>
                    </div>
                </label>

                <!-- Modelo 4 -->
                <label for="modelo4" class="relative group">
                    <input type="checkbox" id="modelo4" name="modelos[]" value="aso" class="hidden peer" onchange="atualizarContadorModelos()">
                    <div class="border rounded-xl shadow cursor-pointer p-4 transition-all peer-checked:ring-2 peer-checked:ring-violet-500 peer-checked:shadow-lg peer-checked:-translate-y-0.5 border-b-4 border-b-violet-400">
                        <div class="flex gap-2 items-center text-violet-500 mb-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5v14"></path>
                            </svg>
                            <span class="font-semibold text-left">ASO - Atestado de Saúde Ocupacional</span>
                        </div>
                        <p class="text-sm text-gray-500 text-left">Gera ASO com base no modelo</p>
                    </div>
                </label>
            </div>

            <!-- Botões de navegação -->
            <!-- <div class="flex justify-between items-center mt-8">
                <button class="text-black text-lg font-medium">&lt; Anterior</button>
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow">
                    GRAVAR KIT
                </button>
            </div> -->
        </section>


    </main>

    <div class="navigation-buttons">
        <button class="btn-nav" id="prevBtn"><i class="fas fa-arrow-left"></i> Anterior</button>
        <button class="btn-nav" id="nextBtn">Próximo <i class="fas fa-arrow-right"></i></button>
    </div>


    <script>
        const tabs = document.querySelectorAll('.tab-button');
        const contents = document.querySelectorAll('.tab-content');

        function activateTab(tabId) {
            tabs.forEach(tab => {
                const isSelected = tab.dataset.tab === tabId;
                tab.classList.toggle('active-tab', isSelected);
                tab.setAttribute('aria-selected', isSelected);
                tab.tabIndex = isSelected ? 0 : -1;
            });

            contents.forEach(content => {
                const isActive = content.id === tabId;
                content.setAttribute('aria-hidden', !isActive);
            });

            // Mover foco para a aba ativa para acessibilidade
            const activeTab = document.querySelector(`.tab-button[data-tab="${tabId}"]`);
            if (activeTab) activeTab.focus();
        }

        // Permitir ativar abas com teclado (Enter e Espaço)
        tabs.forEach(tab => {
            tab.addEventListener('click', () => activateTab(tab.dataset.tab));
            tab.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    activateTab(tab.dataset.tab);
                }
            });
        });
    </script>

</body>

</html>