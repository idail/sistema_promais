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
            <h1>Medicina do Trabalho</h1>
            <div class="welcome-message">
                Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
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
                            <a href="?pg=medicos">M&#xe9;dicos</a>
                            <a href="?pg=grava_risco">Riscos</a>
                            <a href="?pg=exames">Exames</a>
                            <a href="?pg=cargos">Cidades/CEP</a>
                            <a href="?pg=cidades">Cidades</a>
                            <a href="?pg=bairros">Estados/UF</a>
                        </div>
                    </li>
                    <li>
                        <a href="?pg=kit">
                            <i class="fas fa-file-medical"></i>
                            Gera&#xe7;&#xe3;o de Kit
                        </a>
                    </li>
                    <li>
                        <a href="?pg=aso">
                            <i class="fas fa-clipboard-check"></i>
                            ASO em Rascunho
                        </a>
                    </li>
                    <li>
                        <a href="?pg=config">
                            <i class="fas fa-cogs"></i>
                            Configura&#xe7;&#xf5;es
                        </a>
                    </li>
                    <li>
                        <a href="?pg=usuarios">
                            <i class="fas fa-users"></i>
                            Usu&#xe1;rios
                        </a>
                    </li>
                    <?php
                    // Verifique se o nível de acesso é "admin"
                    if (isset($_SESSION['user_access_level']) && $_SESSION['user_access_level'] === 'admin') {
                    ?>
                        <li>
                            <a href="?pg=admin" class="master-admin">
                                <i class="fas fa-shield-alt"></i>
                                MasterAdmin
                            </a>
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
                        <div class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
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
                        <a href="?pg=relatorios">
                            <i class="fas fa-file-alt"></i>
                            Relat&#xf3;rios
                        </a>
                        <a href="?pg=notificacoes">
                            <i class="fas fa-bell"></i>
                            Notifica&#xe7;&#xf5;es
                        </a>
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
    </div>
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
        window.onload = function() {
            initializeCharts();
        };

        function initializeCharts() {
            const mainCtx = document.getElementById('mainChart').getContext('2d');
            const mainChart = new Chart(mainCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'ASOs Emitidos',
                        data: [65, 59, 80, 81, 56, 55],
                        borderColor: '#525d69',
                        backgroundColor: 'rgba(0, 255, 157, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#525d69',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 2000
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'ASOs Emitidos por Mês',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                drawBorder: false,
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            const pieCtx = document.getElementById('pieChart').getContext('2d');
            const pieChart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Admissional', 'Periódico', 'Demissional'],
                    datasets: [{
                        data: [300, 150, 100],
                        backgroundColor: ['#525d69', '#4834d4', '#ff4757'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 2000
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
                                padding: 20
                            }
                        }
                    },
                    cutout: '60%'
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