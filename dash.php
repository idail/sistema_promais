<?php
// Adicionar log de depuração
$debugLogFile = 'dash_debug.log';
$debugLog = "Dash.php sendo executado:\n";
$debugLog .= "- Data/Hora: " . date('Y-m-d H:i:s') . "\n";
$debugLog .= "- Diretório atual: " . getcwd() . "\n";
$debugLog .= "- Variáveis de ambiente:\n";
foreach ($_SERVER as $key => $value) {
    $debugLog .= "  * $key: $value\n";
}
file_put_contents($debugLogFile, $debugLog, FILE_APPEND);
?>

<div class="dashboard">
  <!-- Cards Grid -->
  <div class="cards-grid">
    <div class="card" style="--card-color: var(--card1-bg)">
      <div class="card-header">
        <span class="card-title">Total de Empresas</span>
        <span class="card-subtitle">Ativos no sistema</span>
      </div>
      <div class="card-body">
        <div class="card-main">
          <i class="fas fa-building card-icon"></i>
          <div class="card-info">
            <span class="card-value">152</span>
            <div class="card-trend up">
              <i class="fas fa-arrow-up"></i>
              <span class="trend-value">12%</span>
              <span class="trend-period">último mês</span>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <span class="card-compare">+18 empresas desde o mês anterior</span>
        </div>
      </div>
    </div>

    <div class="card" style="--card-color: var(--card2-bg)">
      <div class="card-header">
        <span class="card-title">Vidas Ativas</span>
        <span class="card-subtitle">Funcionários monitorados</span>
      </div>
      <div class="card-body">
        <div class="card-main">
          <i class="fas fa-users card-icon"></i>
          <div class="card-info">
            <span class="card-value">3,487</span>
            <div class="card-trend up">
              <i class="fas fa-arrow-up"></i>
              <span class="trend-value">8%</span>
              <span class="trend-period">último mês</span>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <span class="card-compare">+279 funcionários desde o mês anterior</span>
        </div>
      </div>
    </div>

    <div class="card" style="--card-color: var(--card3-bg)">
      <div class="card-header">
        <span class="card-title">ASOs em Rascunho</span>
        <span class="card-subtitle">Pendentes de finalização</span>
      </div>
      <div class="card-body">
        <div class="card-main">
          <i class="fas fa-file-medical card-icon"></i>
          <div class="card-info">
            <span class="card-value">28</span>
            <div class="card-trend down">
              <i class="fas fa-arrow-down"></i>
              <span class="trend-value">5%</span>
              <span class="trend-period">última semana</span>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <span class="card-compare">-3 ASOs comparado à semana anterior</span>
        </div>
      </div>
    </div>

    <div class="card" style="--card-color: var(--card4-bg)">
      <div class="card-header">
        <span class="card-title">Kits Gerados</span>
        <span class="card-subtitle">Total do mês atual</span>
      </div>
      <div class="card-body">
        <div class="card-main">
          <i class="fas fa-box-open card-icon"></i>
          <div class="card-info">
            <span class="card-value">945</span>
            <div class="card-trend up">
              <i class="fas fa-arrow-up"></i>
              <span class="trend-value">15%</span>
              <span class="trend-period">último mês</span>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <span class="card-compare">+142 kits comparado ao mês anterior</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Grid -->
  <div class="charts-grid">
    <div class="chart-container">
      <div class="chart-header">
        <span class="chart-title">ASOs Emitidos por Mês</span>
        <div class="chart-actions">
          <button class="chart-btn">
            <i class="fas fa-download"></i>
          </button>
          <button class="chart-btn">
            <i class="fas fa-expand"></i>
          </button>
        </div>
      </div>
      <canvas id="mainChart"></canvas>
    </div>

    <div class="chart-container">
      <div class="chart-header">
        <span class="chart-title">Tipos de Exames</span>
        <div class="chart-actions">
          <button class="chart-btn">
            <i class="fas fa-download"></i>
          </button>
          <button class="chart-btn">
            <i class="fas fa-expand"></i>
          </button>
        </div>
      </div>
      <canvas id="pieChart"></canvas>
    </div>
  </div>
</div>
