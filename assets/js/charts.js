function initializeCharts() {
    console.log('Inicializando gráficos...');
    
    // Verifica se o Chart.js está disponível
    if (typeof Chart === 'undefined') {
        console.error('Chart.js não carregado');
        return;
    }

    // Função para criar gráfico com tratamento de erros
    function createChart(elementId, chartConfig) {
        try {
            const chartEl = document.getElementById(elementId);
            
            if (!chartEl) {
                console.warn(`Elemento ${elementId} não encontrado`);
                return null;
            }

            // Destruir gráfico existente
            if (chartEl.chart) {
                chartEl.chart.destroy();
            }

            const ctx = chartEl.getContext('2d');
            if (!ctx) {
                console.error(`Não foi possível obter contexto 2D para ${elementId}`);
                return null;
            }

            // Definir dimensões explícitas
            chartEl.width = chartEl.parentElement.clientWidth;
            chartEl.height = chartEl.parentElement.clientHeight;

            const chart = new Chart(ctx, {
                ...chartConfig,
                options: {
                    ...chartConfig.options,
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Armazenar referência do gráfico no elemento
            chartEl.chart = chart;
            return chart;
        } catch (error) {
            console.error(`Erro ao criar gráfico ${elementId}:`, error);
            return null;
        }
    }

    // Configurações dos gráficos
    const mainChartConfig = {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'ASOs Emitidos',
                data: [65, 59, 80, 81, 56, 55],
                borderColor: getComputedStyle(document.body).getPropertyValue('--primary'),
                backgroundColor: 'rgba(0, 255, 157, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: getComputedStyle(document.body).getPropertyValue('--primary'),
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            animation: { duration: 2000 },
            plugins: {
                title: {
                    display: true,
                    text: 'ASOs Emitidos por Mês',
                    font: { size: 16, weight: 'bold' }
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
                x: { grid: { display: false } }
            }
        }
    };

    const pieChartConfig = {
        type: 'doughnut',
        data: {
            labels: ['Admissional', 'Periódico', 'Demissional'],
            datasets: [{
                data: [300, 150, 100],
                backgroundColor: [
                    getComputedStyle(document.body).getPropertyValue('--primary'),
                    getComputedStyle(document.body).getPropertyValue('--accent'),
                    getComputedStyle(document.body).getPropertyValue('--secondary')
                ],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            animation: { duration: 2000 },
            plugins: {
                title: {
                    display: true,
                    text: 'Tipos de Exames',
                    font: { size: 16, weight: 'bold' }
                },
                legend: {
                    position: 'bottom',
                    labels: { padding: 20 }
                }
            },
            cutout: '60%'
        }
    };

    // Criar gráficos
    createChart('mainChart', mainChartConfig);
    createChart('pieChart', pieChartConfig);

    console.log('Gráficos inicializados');
}

// Inicialização múltipla e robusta
function setupChartsInitialization() {
    console.log('Configurando inicialização dos gráficos');
    
    // Remover listeners antigos para evitar múltiplas inicializações
    window.removeEventListener('load', initializeCharts);
    document.removeEventListener('themeChanged', initializeCharts);
    
    // Adicionar novos listeners
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeCharts);
    } else {
        // Usar setTimeout para garantir que o DOM esteja completamente renderizado
        setTimeout(initializeCharts, 100);
    }
    
    window.addEventListener('load', initializeCharts);
    document.addEventListener('themeChanged', initializeCharts);
}

// Executar configuração
setupChartsInitialization();
