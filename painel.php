<?php
include('lock.php');
header('Content-Type: text/html; charset=utf-8');
?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicina e Segurança do Trabalho</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="assets/css/main.css" rel="stylesheet">

</head>

<style>
    .color-picker {
        position: fixed;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
        background: #fff;
        border-radius: 10px 0 0 10px;
        box-shadow: -2px 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 999;
    }

    .color-option {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s;
    }

    .color-option:hover {
        transform: scale(1.1);
    }

    /* Submenu dentro de "Gerenciar API - Recebimento" */
    .sidebar .submenu .submenu a {
        padding-left: 0px !important;
        /* distância equilibrada */
        display: block;
        font-size: 0.95em;
    }

    /* Ícones alinhados ao texto */
    .sidebar .submenu .submenu a i {
        margin-right: 8px;
        font-size: 0.9em;
        width: 18px;
        text-align: center;
    }

    /* Pequeno ajuste no espaço do submenu */
    .sidebar .submenu .submenu {
        margin-top: 3px;
        margin-bottom: 3px;
    }
</style>
<?php
$savedTheme = isset($savedTheme) ? $savedTheme : "theme-green";
?>

<body class="<?php echo htmlspecialchars($savedTheme); ?>">
    <button type="button" class="mobile-menu-trigger" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="mobile-overlay"></div>
    <div class="container">
        <aside class="sidebar">
            <!-- <h1>Medicina do Trabalho</h1> -->
            <div class="welcome-message">
                Bem-vindo ao Sistema Promais – Software de Medicina e Segurança do Trabalho
            </div>
            <nav>
                <ul class="nav-menu">
                    <li>
                        <a href="painel.php">
                            <i class="fas fa-tachometer-alt"></i>
                            Painel
                        </a>
                    </li>
                    <li>
                        <div class="menu-trigger">
                            <span>
                                <i class="fas fa-folder"></i>
                                Cadastros
                            </span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </div>
                        <div class="submenu">
                            <a href="?pg=clinicas">Cl&#xed;nicas</a>
                            <a href="?pg=empresas">Empresas</a>
                            <a href="?pg=pessoas">Pessoas</a>
                            <a href="?pg=medicos">Profissionais</a>
                            <a href="?pg=grava_risco">Riscos</a>
                            <a href="?pg=grava_exames_procedimentos">Exames/Procedimentos</a>
                            <!-- <a href="?pg=grava_cidade_estado">Cidades-CEP/ Estados-UF</a> -->
                            <a href="?pg=aptidao_extra">Aptidões Extras</a>
                            <a href="?pg=treinamento_capacitacao">Treinamentos/Capacitações</a>
                            <a href="?pg=contas_bancarias">Contas Bancárias</a>
                            <!-- <a href="?pg=cidades">Cidades</a>
                            <a href="?pg=bairros">Estados/UF</a> -->
                        </div>
                    </li>
                    <li>
                        <div class="menu-trigger">
                            <span>
                                <i class="fas fa-kit-medical"></i>
                                Kits
                            </span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </div>
                        <div class="submenu">
                            <a href="?pg=geracao_kit">Gera&#xe7;&#xe3;o de Kit</a>
                            <!-- <a href="?pg=kits_asos">ASO em Rascunho</a> -->
                            <a href="?pg=kits">Listar Kits</a>
                            <a href="?pg=informativos_kits">Informações Kits</a>
                        </div>
                        <!-- <a href="?pg=geracao_kit">
                            <i class="fas fa-file-medical"></i>
                        </a> -->
                    </li>
                    <!-- <li>
                        <a href="">
                            <i class="fas fa-clipboard-check"></i>
                            
                        </a>
                    </li> -->
                    <!-- <li>
                        <a href="?pg=config">
                            <i class="fas fa-cogs"></i>
                            Configura&#xe7;&#xf5;es
                        </a>
                    </li> -->
                    <!-- <li>
                        <a href="?pg=usuarios">
                            <i class="fas fa-users"></i>
                            Usu&#xe1;rios
                        </a>
                    </li> -->
                    <?php
                    // Verifique se o nível de acesso é "admin"
                    if (isset($_SESSION['user_access_level']) && $_SESSION['user_access_level'] === 'admin') {
                    ?>
                        <!-- <li>
                            <a href="?pg=admin" class="master-admin">
                                <i class="fas fa-shield-alt"></i>
                                MasterAdmin
                            </a>
                        </li> -->

                        <li>
                            <div class="menu-trigger">
                                <span>
                                    <i class="fas fa-shield-alt"></i>
                                    MasterAdmin
                                </span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </div>

                            <div class="submenu">
                                <!-- Primeira seção -->
                                <div class="menu-trigger" style="margin-left: -20px;">
                                    <span>Gerenciar API - Recebimento</span>
                                    <i class="fas fa-chevron-right arrow"></i>
                                </div>
                                <div class="submenu" style="margin-left: -5px;">
                                    <a href="?pg=pix"><i class="fas fa-qrcode"></i> PIX</a>
                                    <a href="?pg=boleto"><i class="fas fa-file-invoice"></i> Boleto</a>
                                    <a href="?pg=cartao"><i class="fas fa-credit-card"></i> Cartão de Crédito</a>
                                </div>

                                <!-- Segunda seção -->
                                <div class="menu-trigger" style="margin-left: -20px; margin-top: 5px;">
                                    <span>Gerenciar Planos</span>
                                    <i class="fas fa-chevron-right arrow"></i>
                                </div>
                                <div class="submenu" style="margin-left: -5px;">
                                    <a href="?pg=planos"><i class="fas fa-money-bill-wave"></i> Planos</a>
                                </div>

                                <!-- Terceira seção -->
                                <div class="menu-trigger" style="margin-left: -20px; margin-top: 5px;">
                                    <span>Gerenciar Administradores das Contas</span>
                                    <i class="fas fa-chevron-right arrow"></i>
                                </div>
                                <div class="submenu" style="margin-left: -5px;">
                                    <a href="?pg=empresas_principais"><i class="fas fa-building"></i>Empresa Principal</a>
                                    <a href="?pg=gerencia_kits"><i class="fas fa-kit-medical"></i>Gerencia KITS</a>
                                    <a href="?pg=gerencia_usuarios"><i class="fas fa-users"></i>Gerencia Usuários e Dados</a>
                                </div>
                            </div>
                        </li>

                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <div class="search-bar-container">
                <input type="search" class="search-bar" placeholder="Pesquisar...">
                <i class="fas fa-search search-icon"></i>
            </div>
            <div class="profile-dropdown">
                <button class="profile-trigger">
                    <div class="avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-info">
                        <div class="user-name">Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                        <div class="user-role"><?php echo isset($_SESSION['user_access_level']) ? htmlspecialchars($_SESSION['user_access_level']) : 'Usuário'; ?></div>
                    </div>
                </button>
                <div class="profile-menu">
                    <div class="profile-header">
                        <div class="avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-name"><?php echo isset($_SESSION['empresa_nome']) ? htmlspecialchars($_SESSION['empresa_nome']) : htmlspecialchars($_SESSION['user_name']); ?></div>
                        <div class="user-email"><?php echo isset($_SESSION['empresa_email']) ? htmlspecialchars($_SESSION['empresa_email']) : ''; ?></div>
                    </div>
                    <div class="menu-section">
                        <div class="menu-section-title">Conta</div>
                        <a href="?pg=perfil">
                            <i class="fas fa-user-circle"></i>
                            Meu Perfil
                        </a>
                        <a href="?pg=configuracoes">
                            <i class="fas fa-cog"></i>
                            Configura&#xe7;&#xf5;es
                        </a>
                        <a href="?pg=senha">
                            <i class="fas fa-key"></i>
                            Alterar Senha
                        </a>
                    </div>
                    <div class="menu-section">
                        <div class="menu-section-title">Atividade</div>
                        <a href="?pg=dados">
                            <i class="fas fa-chart-line"></i>
                            Meus Dados
                        </a>
                        <!-- <a href="?pg=relatorios">
                            <i class="fas fa-file-alt"></i>
                            Relat&#xf3;rios
                        </a>
                        <a href="?pg=notificacoes">
                            <i class="fas fa-bell"></i>
                            Notifica&#xe7;&#xf5;es
                        </a> -->
                    </div>
                    <div class="menu-section">
                        <a href="logout.php" class="logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Sair
                        </a>
                    </div>
                </div>
            </div>
            <?php
            // Verifica se o parâmetro 'pg' existe na URL
            $page = isset($_GET['pg']) ? $_GET['pg'] : 'dash';

            // Diretórios para buscar páginas
            $possiblePaths = [
                'cadastros/' . $page . '.php',
                'pages/' . $page . '.php',
                $page . '.php'
            ];

            // Inclui o dashboard por padrão
            if (empty($page) || $page === 'dash') {
                include 'dash.php';
            } else {
                // Lógica para incluir outras páginas
                $pageFound = false;
                foreach ($possiblePaths as $pagePath) {
                    if (file_exists($pagePath)) {
                        include $pagePath;
                        $pageFound = true;
                        break;
                    }
                }

                if (!$pageFound) {
                    echo "Página não encontrada: " . htmlspecialchars($page);
                }
            }
            ?>
        </main>
    </div>
    <div class="color-picker">
        <div class="color-option theme-green" style="background: #525d69" onclick="setTheme(&apos;theme-green&apos;)"></div>
        <div class="color-option theme-blue" style="background: #4834d4" onclick="setTheme(&apos;theme-blue&apos;)"></div>
        <div class="color-option theme-purple" style="background: #9c88ff" onclick="setTheme(&apos;theme-purple&apos;)"></div>
        <div class="color-option theme-orange" style="background: #ffa502" onclick="setTheme(&apos;theme-orange&apos;)"></div>
        <div class="color-option theme-red" style="background: #ff4757" onclick="setTheme(&apos;theme-red&apos;)"></div>
    </div>
    <script>
        // 🔹 Mantém referências para não empilhar gráficos
        let mainChartInstance = null;
        let pieChartInstance = null;

        window.onload = function() {
            initializeCharts();
        };

        function initializeCharts() {
            $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processo_geracao_kit": "buscar_todos_kits_empresa"
                },
                success: function(resposta_kits) {
                    if (!Array.isArray(resposta_kits)) {
                        console.warn("Resposta inválida:", resposta_kits);
                        resposta_kits = [];
                    }

                    // 🔹 Modelos permitidos
                    const modelosPermitidos = [
                        "Guia de Encaminhamento",
                        "ASO - Atestado de Saúde Ocupacional",
                        "Prontuário Médico"
                    ];

                    // 🔹 Função auxiliar para extrair modelos
                    function extrairModelos(kit) {
                        try {
                            if (typeof kit.modelos_selecionados === "string") {
                                return JSON.parse(kit.modelos_selecionados || "[]");
                            } else if (Array.isArray(kit.modelos_selecionados)) {
                                return kit.modelos_selecionados;
                            }
                        } catch (e) {
                            console.warn("Erro ao parsear modelos_selecionados:", e, kit.modelos_selecionados);
                        }
                        return [];
                    }

                    // 🔹 Verifica se o kit contém modelo permitido
                    function contemModeloPermitido(kit) {
                        const modelos = extrairModelos(kit);
                        return modelos.some(m => modelosPermitidos.includes(m));
                    }

                    // ------------------------------------------------------------------
                    // 🔸 GRÁFICO 1 — Pizza (Tipos de Exames) → usa TODOS os kits
                    // ------------------------------------------------------------------
                    const contagemTipos = {
                        Admissional: 0,
                        Periódico: 0,
                        Demissional: 0
                    };

                    resposta_kits.forEach(kit => {
                        const raw = (kit.tipo_exame || "").toString().trim().toLowerCase();

                        if (raw.includes("admiss")) contagemTipos.Admissional++;
                        else if (raw.includes("perio") || raw.includes("period") || raw.includes("periód")) contagemTipos.Periódico++;
                        else if (raw.includes("demiss")) contagemTipos.Demissional++;
                    });

                    const dadosPizza = [
                        contagemTipos.Admissional,
                        contagemTipos.Periódico,
                        contagemTipos.Demissional
                    ];

                    const pieEl = document.getElementById('pieChart');
                    if (pieEl) {
                        const pieCtx = pieEl.getContext('2d');
                        if (pieChartInstance) pieChartInstance.destroy();

                        pieChartInstance = new Chart(pieCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Admissional', 'Periódico', 'Demissional'],
                                datasets: [{
                                    data: dadosPizza,
                                    backgroundColor: ['#525d69', '#4834d4', '#ff4757'],
                                    borderWidth: 0,
                                    hoverOffset: 15
                                }]
                            },
                            options: {
                                responsive: true,
                                animation: {
                                    duration: 1000
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Tipos de Exames',
                                        font: {
                                            size: 16,
                                            weight: 'bold'
                                        }
                                    },
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 12
                                        }
                                    }
                                },
                                cutout: '60%'
                            }
                        });
                    }

                    // ------------------------------------------------------------------
                    // 🔸 GRÁFICO 2 — Linha (ASOs Finalizados por Mês)
                    // ------------------------------------------------------------------
                    const kitsFinalizados = resposta_kits.filter(kit => {
                        const status = (kit.status || "").toString().trim().toLowerCase();
                        return status === "finalizado" && contemModeloPermitido(kit);
                    });

                    const asosPorMes = Array(12).fill(0);

                    kitsFinalizados.forEach(kit => {
                        if (!kit.data_geracao) return;
                        const data = new Date(kit.data_geracao);
                        if (!isNaN(data)) {
                            asosPorMes[data.getMonth()]++;
                        }
                    });

                    const lineEl = document.getElementById('mainChart') || document.getElementById('lineChart') || document.getElementById('asoChart');
                    if (lineEl) {
                        const lineCtx = lineEl.getContext('2d');
                        if (mainChartInstance) mainChartInstance.destroy();

                        mainChartInstance = new Chart(lineCtx, {
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                datasets: [{
                                    label: 'ASOs Finalizados por Mês',
                                    data: asosPorMes,
                                    fill: true,
                                    borderColor: '#4834d4',
                                    backgroundColor: 'rgba(72,52,212,0.08)',
                                    tension: 0.35,
                                    pointRadius: 5,
                                    pointHoverRadius: 7
                                }]
                            },
                            options: {
                                responsive: true,
                                animation: {
                                    duration: 1000
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'ASOs por Mês',
                                        font: {
                                            size: 16,
                                            weight: 'bold'
                                        }
                                    },
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // ------------------------------------------------------------------
                    // Logs de depuração
                    // ------------------------------------------------------------------
                    console.log("✔️ Total de kits:", resposta_kits.length);
                    console.log("📊 Tipos de exame (todos os kits):", contagemTipos);
                    console.log("📈 Kits finalizados (com modelos permitidos):", kitsFinalizados.length);
                    console.log("📅 ASOs por mês:", asosPorMes);
                },
                error: function(xhr, status, error) {
                    console.error("Erro ao buscar kits:", error);
                }
            });
        }


        function setTheme(themeName) {
            document.body.className = themeName;
            localStorage.setItem('theme', themeName);
        }
        const savedTheme = localStorage.getItem('theme') || 'theme-green';
        setTheme(savedTheme);

        document.querySelector('.profile-trigger').addEventListener('click', e => {
            e.stopPropagation();
            document.querySelector('.profile-menu').classList.toggle('active');
        });
        document.addEventListener('click', e => {
            const dropdown = document.querySelector('.profile-dropdown');
            const menu = document.querySelector('.profile-menu');
            if (!dropdown.contains(e.target) && menu.classList.contains('active')) {
                menu.classList.remove('active');
            }
        });
        document.querySelectorAll('.profile-menu a').forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateX(4px)';
            });
            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateX(0)';
            });
        });
        document.addEventListener('click', e => {
            const dropdown = document.querySelector('.profile-dropdown');
            if (!dropdown.contains(e.target)) {
                document.querySelector('.profile-menu').classList.remove('active');
            }
        });
        document.querySelectorAll('.menu-trigger').forEach(trigger => {
            trigger.addEventListener('click', () => {
                const submenu = trigger.nextElementSibling;
                const arrow = trigger.querySelector('.arrow');
                submenu.classList.toggle('active');
                arrow.classList.toggle('active');
            });
        });

        // Mobile Menu
        const menuTrigger = document.querySelector('.mobile-menu-trigger');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.mobile-overlay');

        menuTrigger.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Fecha o menu ao clicar em um link
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    </script>
</body>

</html>