<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Selecionar Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-item:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="bg-gray-50 p-6 font-sans">
    <div class="max-w-6xl mx-auto space-y-8">
        <!-- Bloco de Seleção -->
        <div class="bg-white rounded-2xl shadow-lg p-8 space-y-8 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-700">Selecione Empresa, Clínica e Colaborador</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Empresa -->
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Empresa</label>
                    <div class="relative">
                        <input type="text" id="empresaInput" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="Digite para procurar..." oninput="mostrarDropdown('empresa')">
                        <ul id="empresaDropdown" class="absolute w-full bg-white border rounded-md shadow mt-1 z-10 hidden"></ul>
                    </div>
                    <div class="text-sm text-gray-500" id="infoEmpresa"></div>
                </div>
                <!-- Clínica -->
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Clínica</label>
                    <div class="relative">
                        <input type="text" id="clinicaInput" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="Digite para procurar..." oninput="mostrarDropdown('clinica')">
                        <ul id="clinicaDropdown" class="absolute w-full bg-white border rounded-md shadow mt-1 z-10 hidden"></ul>
                    </div>
                    <div class="text-sm text-gray-500" id="infoClinica"></div>
                </div>
                <!-- Pessoa -->
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Colaborador</label>
                    <div class="relative">
                        <input type="text" id="pessoaInput" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="Digite para procurar..." oninput="mostrarDropdown('pessoa')">
                        <ul id="pessoaDropdown" class="absolute w-full bg-white border rounded-md shadow mt-1 z-10 hidden"></ul>
                    </div>
                    <div class="text-sm text-gray-500" id="infoPessoa"></div>
                </div>
            </div>
        </div>

        <!-- Selecionar Modelos -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Selecionar Modelos</h2>
                <div id="modelosSelecionados" class="text-sm text-gray-500">0 modelos selecionados</div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <label for="modelo1" class="relative group">
                    <input type="checkbox" id="modelo1" name="modelos[]" value="guia" class="hidden peer" onchange="atualizarContadorModelos()">
                    <div class="border rounded-xl shadow cursor-pointer p-4 transition-all peer-checked:ring-2 peer-checked:ring-green-500 peer-checked:shadow-lg peer-checked:-translate-y-0.5">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 text-green-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 10h4l3-8 4 16 3-8h4"></path>
                                </svg>
                                <span class="font-semibold">Guia de encaminhamento</span>
                            </div>
                            <p class="text-sm text-gray-500">Gera guia de Encaminhamento com base no modelo</p>
                        </div>
                    </div>
                </label>

                <label for="modelo2" class="relative group">
                    <input type="checkbox" id="modelo2" name="modelos[]" value="prontuario" class="hidden peer" onchange="atualizarContadorModelos()">
                    <div class="border rounded-xl shadow cursor-pointer p-4 transition-all peer-checked:ring-2 peer-checked:ring-yellow-500 peer-checked:shadow-lg peer-checked:-translate-y-0.5">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 text-yellow-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="font-semibold">Prontuário Médico</span>
                            </div>
                            <p class="text-sm text-gray-500">Gera guia de Prontuário com base no modelo</p>
                        </div>
                    </div>
                </label>

                <label for="modelo3" class="relative group">
                    <input type="checkbox" id="modelo3" name="modelos[]" value="aptidao" class="hidden peer" onchange="atualizarContadorModelos()">
                    <div class="border rounded-xl shadow cursor-pointer p-4 transition-all peer-checked:ring-2 peer-checked:ring-cyan-500 peer-checked:shadow-lg peer-checked:-translate-y-0.5">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 text-cyan-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-semibold">Aptidão Física Mental</span>
                            </div>
                            <p class="text-sm text-gray-500">Gera guia de Aptidão com base no modelo</p>
                        </div>
                    </div>
                </label>

                <label for="modelo4" class="relative group">
                    <input type="checkbox" id="modelo4" name="modelos[]" value="aso" class="hidden peer" onchange="atualizarContadorModelos()">
                    <div class="border rounded-xl shadow cursor-pointer p-4 transition-all peer-checked:ring-2 peer-checked:ring-violet-500 peer-checked:shadow-lg peer-checked:-translate-y-0.5">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 text-violet-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M5 12h14M12 5v14"></path>
                                </svg>
                                <span class="font-semibold">ASO - Atestado de Saúde Ocupacional</span>
                            </div>
                            <p class="text-sm text-gray-500">Gera ASO com base no modelo</p>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <div class="pt-6">
            <button class="bg-green-500 text-white font-semibold px-8 py-3 rounded-xl shadow hover:bg-green-600 transition w-full sm:w-auto">SALVAR E CONTINUAR</button>
        </div>
    </div>

    <script>
        const empresas = [{
                nome: "L. C. DE CARVALHO - ME",
                endereco: "Rua Benjamin Constant, S/N",
                cidade: "Alto Araguaia / MT",
                cnpj: "10.658.887/0001-88",
                vidas: 56,
                clinicas: 12,
                status: "Ativa"
            },
            {
                nome: "Promais Medicina do Trabalho",
                endereco: "Rua Antônio Àires Fávero, S/N",
                cidade: "Alto Araguaia / MT",
                cnpj: "00.613.587/0001-51",
                vidas: 88,
                clinicas: 14,
                status: "Ativa"
            }
        ];

        const clinicas = [{
                nome: "Hospital Samaritano - Alto Araguaia/MT",
                cnpj: "00.254.587/0001-58"
            },
            {
                nome: "Hospital Jetúlio - Alto Araguaia/MT",
                cnpj: "00.254.587/0001-58"
            }
        ];

        const pessoas = [{
                nome: "Maria Olanda Silva",
                cpf: "258.456.857-58"
            },
            {
                nome: "Henrique Soares",
                cpf: "258.456.857-58"
            }
        ];

        function mostrarDropdown(tipo) {
            debugger;
            let input = document.getElementById(tipo + 'Input').value.toLowerCase();
            let lista = tipo === 'empresa' ? empresas : tipo === 'clinica' ? clinicas : pessoas;
            let dropdown = document.getElementById(tipo + 'Dropdown');
            let infoId = 'info' + tipo.charAt(0).toUpperCase() + tipo.slice(1);
            let infoContainer = document.getElementById(infoId);

            dropdown.innerHTML = '';
            infoContainer.innerHTML = '';

            if (input.trim() === '') {
                dropdown.classList.add('hidden');
                return;
            }

            let encontrados = lista.filter(item => item.nome.toLowerCase().includes(input));

            if (encontrados.length > 0) {
                encontrados.forEach(item => {
                    let li = document.createElement('li');
                    li.className = 'dropdown-item px-4 py-2 cursor-pointer';
                    li.textContent = item.nome;
                    li.onclick = () => selecionarItem(tipo, item);
                    dropdown.appendChild(li);
                });
                dropdown.classList.remove('hidden');
            } else {
                // Oculta o dropdown e mostra o botão de adicionar no local das informações
                dropdown.classList.add('hidden');

                infoContainer.innerHTML = `
            <div class="pt-6">
                <button onclick="adicionarNovo('${tipo}', '${input}')" class="bg-green-500 text-white font-semibold px-8 py-3 rounded-xl shadow hover:bg-green-600 transition w-full sm:w-auto">+ Adicionar novo</button>
            </div>
        `;
            }
        }

        function selecionarItem(tipo, item) {
            debugger;
            document.getElementById(tipo + 'Input').value = item.nome;
            document.getElementById(tipo + 'Dropdown').classList.add('hidden');

            let infoId = 'info' + tipo.charAt(0).toUpperCase() + tipo.slice(1);
            let html = '';
            if (tipo === 'empresa') {
                html = `Empresa: ${item.nome}<br>Endereço: ${item.endereco}<br>Cidade: ${item.cidade}<br>CNPJ: ${item.cnpj}<br><span class='text-green-500'>✔ ${item.status}</span> <span class='text-orange-500'>👤 ${item.vidas} Vidas</span> <span class='text-blue-500'>🏥 ${item.clinicas} Clínicas</span>`;
            } else if (tipo === 'clinica') {
                html = `Clínica: ${item.nome}<br>CNPJ: ${item.cnpj}<br><span class='text-green-500'>✔</span>`;
            } else if (tipo === 'pessoa') {
                html = `Nome: ${item.nome}<br>CPF: ${item.cpf}<br><span class='text-green-500'>✔</span>`;
            }
            document.getElementById(infoId).innerHTML = html;
        }

        // Função para lidar com o botão de adicionar novo item
        function adicionarNovo(tipo, nomeDigitado) {
            alert(`Adicionar novo ${tipo}: ${nomeDigitado}`);
            // Aqui você pode abrir um modal ou redirecionar para um formulário de criação
        }



        function atualizarContadorModelos() {
            const selecionados = document.querySelectorAll("input[name='modelos[]']:checked").length;
            document.getElementById("modelosSelecionados").innerText = `${selecionados} modelo${selecionados === 1 ? '' : 's'} selecionado${selecionados === 1 ? '' : 's'}`;
        }
    </script>
</body>

</html>