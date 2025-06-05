<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Abas Interativas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .shadow-box {
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        }

        .active-tab {
            background-color: white;
            border: 2px solid black;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
        }

        .inactive-tab {
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(0, 0, 0, 0.2);
        }

        .tab-container {
            display: flex;
            gap: 0;
        }

        .tab-content {
            width: 100%;
            padding: 30px;
            display: none;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        }

        .circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: white;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circle::before {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            top: -10px;
            left: -10px;
            background: conic-gradient(red 0% 20%,
                    orange 20% 40%,
                    yellow 40% 60%,
                    green 60% 80%,
                    blue 80% 100%);
            z-index: -1;
        }

        .text-area {
            font-size: 18px;
            color: black;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">

    <!-- Linha de abas -->
    <div class="w-full px-4">
        <div class="tab-container">
            <div class="flex-1 rounded-xl p-5 shadow-box active-tab relative" onclick="activateTab('exames')">
                <h3 class="text-lg font-semibold text-black/70 text-center">Exames</h3>
            </div>
            <div class="flex-1 rounded-xl p-5 text-center shadow-box inactive-tab" onclick="activateTab('selecao')">
                <h3 class="text-lg font-medium text-gray-400">Seleção ECP</h3>
            </div>
            <div class="flex-1 rounded-xl p-5 text-center shadow-box inactive-tab" onclick="activateTab('medicos')">
                <h3 class="text-lg font-medium text-gray-400">Médicos</h3>
            </div>
            <div class="flex-1 rounded-xl p-5 text-center shadow-box inactive-tab" onclick="activateTab('riscos')">
                <h3 class="text-lg font-medium text-gray-400">Fatores de Riscos</h3>
            </div>
            <div class="flex-1 rounded-xl p-5 text-center shadow-box inactive-tab" onclick="activateTab('procedimentos')">
                <h3 class="text-lg font-medium text-gray-400">Procedimentos</h3>
            </div>
        </div>
    </div>


    <!-- Corpo das Abas -->
    <div class="w-full px-4 mt-0">
        <div id="exames" class="tab-content flex flex-col items-center gap-4">
            <!-- SVG à esquerda e informativo ao lado -->
            <div class="flex items-center gap-4" style="width: 100%;">
                <img src="https://www.idailneto.com.br/promais/cadastros/circulo_exame.svg" alt="Círculo Exame" width="100" height="100">
                <p class="text-area text-left" style="width: auto;">Selecione o tipo de exame / procedimento a ser realizado para Iniciar</p>
            </div>

            <!-- Cards abaixo do informativo -->
            <!-- Cards abaixo do informativo -->
            <div class="flex flex-wrap gap-4 w-full">
                <div class="flex-1 bg-[#00A759] p-6 h-32 rounded-lg shadow-md text-center font-bold text-white cursor-pointer transition hover:shadow-lg hover:scale-105 flex flex-col items-center justify-center">
                    <img src="https://www.idailneto.com.br/promais/cadastros/admissional.svg" alt="Admissional" width="50" height="50" class="mb-2">
                    <span style="height: 0px;">Adminissional</span>
                </div>

                <div class="flex-1 bg-[#0086FF] p-6 h-32 rounded-lg shadow-md text-center font-bold text-white cursor-pointer transition hover:shadow-lg hover:scale-105 flex flex-col items-center justify-center">
                    <img src="https://www.idailneto.com.br/promais/cadastros/periodico.svg" alt="Periódico" width="50" height="50" class="mb-2">
                    <span style="height: 0px;">Periódico</span>
                </div>

                <div class="flex-1 bg-[#FF0066] p-6 h-32 rounded-lg shadow-md text-center font-bold text-white cursor-pointer transition hover:shadow-lg hover:scale-105 flex flex-col items-center justify-center">
                    <img src="https://www.idailneto.com.br/promais/cadastros/demissional.svg" alt="Demissional" width="50" height="50" class="mb-2">
                    <span style="height: 0px;">Demissional</span>
                </div>

                <div class="flex-1 bg-[#750099] p-6 h-32 rounded-lg shadow-md text-center font-bold text-white cursor-pointer transition hover:shadow-lg hover:scale-105 flex flex-col items-center justify-center">
                    <img src="https://www.idailneto.com.br/promais/cadastros/mud_rs_fn.svg" alt="Mud. Risco/Função" width="50" height="50" class="mb-2">
                    <span style="height: 0px;">Mud. Risco/Função</span>
                </div>

                <div class="flex-1 bg-[#606163] p-6 h-32 rounded-lg shadow-md text-center font-bold text-white cursor-pointer transition hover:shadow-lg hover:scale-105 flex flex-col items-center justify-center">
                    <img src="https://www.idailneto.com.br/promais/cadastros/retorno_ao_trabalho.svg" alt="Retorno ao Trabalho" width="50" height="50" class="mb-2">
                    <span>Retorno ao Trabalho</span>
                </div>
            </div>

        </div>




        <div id="selecao" class="tab-content">
            <p class="text-area">Conteúdo para Seleção ECP</p>
        </div>
        <div id="medicos" class="tab-content">
            <p class="text-area">Conteúdo para Médicos</p>
        </div>
        <div id="riscos" class="tab-content">
            <p class="text-area">Conteúdo para Fatores de Risco</p>
        </div>
        <div id="procedimentos" class="tab-content">
            <p class="text-area">Conteúdo para Procedimentos</p>
        </div>
    </div>


    <script>
        function activateTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });

            document.getElementById(tabName).style.display = 'flex';
        }

        activateTab('exames'); // Exibe a aba Exames por padrão
    </script>

</body>

</html>