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
            flex: 1 1 200px;
            max-width: 220px;
            min-width: 180px;
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

        .exam-card img {
            margin-bottom: 0.5rem;
            width: 50px;
            height: 50px;
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            width: 100%;
            justify-content: center;
        }

        .exames-header {
            display: flex;
            align-items: center;
            gap: 16px;
            width: 100%;
            max-width: 1069px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">

    <div class="w-full px-4 max-w-7xl">
        <div class="tab-container" role="tablist" aria-label="Abas principais">
            <div class="tab-button active-tab flex items-center justify-center gap-2" role="tab" tabindex="0" aria-selected="true" aria-controls="exames" id="tab-exames" data-tab="exames">
                <i class="fas fa-vial text-xl"></i>
                <h3 class="text-lg">Exames</h3>
            </div>


            <div class="tab-button flex items-center justify-center gap-2" role="tab" tabindex="-1" aria-selected="false" aria-controls="selecao" id="tab-selecao" data-tab="selecao">
                <i class="fas fa-tasks"></i>
                <h3 class="text-lg">Seleção ECP</h3>
            </div>
            <div class="tab-button flex items-center justify-center gap-2" role="tab" tabindex="-1" aria-selected="false" aria-controls="medicos" id="tab-medicos" data-tab="medicos">
                <i class="fas fa-user-md"></i>
                <h3 class="text-lg">Médicos</h3>
            </div>
            <div class="tab-button flex items-center justify-center gap-2" role="tab" tabindex="-1" aria-selected="false" aria-controls="riscos" id="tab-riscos" data-tab="riscos">
                <i class="fas fa-exclamation-triangle"></i>
                <h3 class="text-lg">Fatores de Riscos</h3>
            </div>
            <div class="tab-button flex items-center justify-center gap-2" role="tab" tabindex="-1" aria-selected="false" aria-controls="procedimentos" id="tab-procedimentos" data-tab="procedimentos">
                <i class="fas fa-stethoscope"></i>
                <h3 class="text-lg">Procedimentos</h3>
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
                <div class="exam-card bg-admissional" role="button" tabindex="0" aria-label="Exame Admissional">
                    <img src="https://www.idailneto.com.br/promais/cadastros/admissional.svg" alt="Ícone Admissional" />
                    <span>Admissional</span>
                </div>
                <div class="exam-card bg-periodico" role="button" tabindex="0" aria-label="Exame Periódico">
                    <img src="https://www.idailneto.com.br/promais/cadastros/periodico.svg" alt="Ícone Periódico" />
                    <span>Periódico</span>
                </div>
                <div class="exam-card bg-demissional" role="button" tabindex="0" aria-label="Exame Demissional">
                    <img src="https://www.idailneto.com.br/promais/cadastros/demissional.svg" alt="Ícone Demissional" />
                    <span>Demissional</span>
                </div>
                <div class="exam-card bg-mudanca" role="button" tabindex="0" aria-label="Mudança de Risco/Função">
                    <img src="https://www.idailneto.com.br/promais/cadastros/mud_rs_fn.svg" alt="Ícone Mudança Risco/Função" />
                    <span>Mud. Risco/Função</span>
                </div>
                <div class="exam-card bg-retorno" role="button" tabindex="0" aria-label="Retorno ao Trabalho">
                    <img src="https://www.idailneto.com.br/promais/cadastros/retorno_ao_trabalho.svg" alt="Ícone Retorno ao Trabalho" />
                    <span>Retorno ao Trabalho</span>
                </div>
            </div>
        </section>

        <section id="selecao" class="tab-content" aria-labelledby="tab-selecao" role="tabpanel" aria-hidden="true">
            <p class="text-area">Conteúdo para Seleção ECP</p>
        </section>
        <section id="medicos" class="tab-content" aria-labelledby="tab-medicos" role="tabpanel" aria-hidden="true">
            <p class="text-area">Conteúdo para Médicos</p>
        </section>
        <section id="riscos" class="tab-content" aria-labelledby="tab-riscos" role="tabpanel" aria-hidden="true">
            <p class="text-area">Conteúdo para Fatores de Risco</p>
        </section>
        <section id="procedimentos" class="tab-content" aria-labelledby="tab-procedimentos" role="tabpanel" aria-hidden="true">
            <p class="text-area">Conteúdo para Procedimentos</p>
        </section>
    </main>

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