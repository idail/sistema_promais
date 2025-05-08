<?php
session_start();

// Verificar se o usuário já está autenticado
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name']) && isset($_SESSION['user_plan']) && isset($_SESSION['user_expire'])) {
    // Verificar se a sessão não expirou antes de redirecionar
    if (strtotime($_SESSION['user_expire']) > time()) {
        // Se o usuário já estiver logado, redirecioná-lo para o painel
        // header("Location: painel.php");
        exit();  // Impede que o restante da página seja carregado
    } else {
        // Se expirou, limpar a sessão
        session_unset();
        session_destroy();
    }
}
?>

<html>
<head>
<base href>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f5f5f5;
}

.login-container {
    display: flex;
    max-width: 800px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.login-form {
    padding: 80px;
    width: 460px;
}

.login-image {
    width: 600px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.login-header {
    margin-bottom: 30px;
}

.login-header h1 {
    font-size: 24px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.subtitle {
    color: #666;
    font-size: 14px;
    line-height: 1.4;
}

.form-group {
    position: relative;
    margin-bottom: 20px;
}

.form-group i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%); /* Certificando-se de que está centralizado verticalmente */
    color: #666;
    display: flex;
    align-items: center;
    height: 100%;
}

.form-group input {
    width: 100%;
    padding: 12px;
    padding-left: 35px;  /* Espaço para o ícone */
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
    height: 45px;  /* Tamanho do campo */
    line-height: 45px;  /* Alinha o texto no meio do campo */
}

.form-group input:focus {
    border-color: #6c63ff;
}


.signin-button {
    width: 100%;
    padding: 12px;
    background:rgb(63, 139, 75);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

.signin-button:hover {
    background: #5b52e0;
}

.bottom-links {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.bottom-links a {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 6px;
    transition: background-color 0.3s;
}

.bottom-links a:hover {
    background-color: #f5f5f5;
}

.bottom-links i {
    font-size: 16px;
}

.info-card {
    position: absolute;
    top: 20%;
    right: 15%;
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    max-width: 300px;
}

.info-card h3 {
    margin-bottom: 10px;
}

.info-card p {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
}

#progressBarContainer {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    transition: opacity 0.3s;
    opacity: 0;
}

#progressBarContainer.show {
    opacity: 1;
}

#countdownLightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    opacity: 0;
    transition: opacity 0.3s ease;
}

#countdownLightbox.show {
    opacity: 1;
}

#expirationNotice {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    text-align: center;
    max-width: 400px;
    width: 90%;
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

#expirationNotice.show {
    opacity: 1;
    display: block;
}

#expirationNotice h4 {
    color: #dc3545;
    margin-bottom: 15px;
    font-size: 1.2em;
}

#expirationNotice p {
    margin-bottom: 10px;
    color: #666;
}

#expirationDays {
    font-weight: bold;
    color: #dc3545;
}

#countdownTimer {
    font-weight: bold;
    color: #007bff;
}

.fade {
    transition: opacity 0.5s;
    opacity: 0;
}

.fade.show {
    opacity: 1;
}

#expirationNotice {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    z-index: 1001;
}
.fa-envelope {
  padding-top:22px;
}
.fa-lock {
  padding-top:22px;
}
</style>
</head>
<body>
<div class="login-container">
    <div class="login-form" id="loginSection">
        <div class="login-header">
        <img src="./img/logos/logo_p_p.png" alt="Logo">
            <p class="subtitle">Assessoria em Seguran&#xe7;a do Trabalho - Alto Araguaia - MT</p>
        </div>

        <form id="loginForm">
            <div class="form-group">
                <label>Email</label>
                <i class="fas fa-envelope"></i>
                <input type="email" id="username" name="email" placeholder="seunome@empresa.com" required>
            </div>
            <div class="form-group">
                <label>Senha</label>
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="signin-button">Entrar</button>
        </form>

        <div class="bottom-links">
            <a href="#" class="signup-link">
                <i class="fas fa-user-plus"></i>
                Assine
            </a>
            <a href="./" class="exit-link">
                <i class="fas fa-sign-out-alt"></i>
                Sair
            </a>
        </div>
    </div>
    
    <div class="login-image" style="background-image: url(&apos;./img/logos/fundo.png&apos;); background-size: cover; background-position: middle; background-repeat: no-repeat;">
        <div class="info-card">
            <h3>Seja bem vindo(a)</h3>
            <p>Ao fazer login, voc&#xea; pode acessar seu painel pessoal onde pode gerenciar sua empresa, visualizar seu perfil e muito mais.</p>
        </div>
    </div>
</div>

<div id="progressBarContainer" class="progress">
    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div id="countdownLightbox">
    <div id="expirationNotice">
        <h4><i class="fas fa-exclamation-triangle"></i> Aviso de Expiração</h4>
        <p>Sua licença expirará em <span id="expirationDays">0</span> dias.</p>
        <p>Redirecionando em <span id="countdownTimer">3</span> segundos...</p>
    </div>
</div>

<div id="contentSection" style="display: none;">
    <span id="userNameLabel"></span>
    <span id="userPlanLabel"></span>
    <span id="userExpireLabel"></span>
    <a href="#" id="navLogoutLink" style="display: none;">Sair</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById('loginForm');
  const progressBarContainer = document.getElementById('progressBarContainer');
  const progressBar = document.getElementById('progressBar');
  const countdownLightbox = document.getElementById('countdownLightbox');
  const expirationNotice = document.getElementById('expirationNotice');
  const expirationDays = document.getElementById('expirationDays');
  const countdownTimer = document.getElementById('countdownTimer');

  function updateProgress(value) {
    progressBar.style.width = value + '%';
    progressBar.setAttribute('aria-valuenow', value);
  }

  function fadeIn(element) {
    element.style.display = 'block';
    // Força um reflow para garantir que a transição funcione
    element.offsetHeight;
    element.classList.add('show');
  }

  function fadeOut(element) {
    element.classList.remove('show');
    setTimeout(() => {
      element.style.display = 'none';
    }, 300);
  }

  function startCountdown() {
    let seconds = 3;
    countdownTimer.textContent = seconds;
    const interval = setInterval(() => {
      seconds--;
      countdownTimer.textContent = seconds;
      if (seconds < 0) {
        clearInterval(interval);
        fadeOut(countdownLightbox);
        setTimeout(() => {
          window.location.href = 'painel.php';
        }, 300);
      }
    }, 1000);
  }

  loginForm.addEventListener('submit', async evt => {
    evt.preventDefault();
    const email = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    
    if (!email || !password) {
      alert('Por favor, insira seu usuário (email) e senha.');
      return;
    }

    try {
      progressBarContainer.style.display = 'block';
      progressBarContainer.classList.add('show');
      updateProgress(20);

      const response = await fetch('usr_json.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password })
      });

      if (!response.ok) {
        throw new Error('Erro na conexão com o servidor.');
      }

      debugger;
      const data = await response.json();
      updateProgress(60);
      
      if (data.status === 'success') {
        updateProgress(100);
        
        const diasRestantes = data.data.dias_restantes;
        console.log('Dias até expirar:', diasRestantes); // Debug

        if (diasRestantes <= 3 && diasRestantes > 0) {
          // Mostrar aviso de expiração com plano
          const planoDuracao = data.data.plano_duracao || 30;
          const planoNome = data.data.user_plan || 'Básico';
          expirationDays.textContent = `${diasRestantes} dia${diasRestantes > 1 ? 's' : ''}`;
          
          // Atualizar texto do aviso
          const noticeText = document.querySelector('#expirationNotice p:first-of-type');
          noticeText.innerHTML = `
            Sua licença do plano <strong>${planoNome}</strong> expirará em <span id="expirationDays">${diasRestantes}</span> dia${diasRestantes > 1 ? 's' : ''}.
            <br><small>Duração total do plano: ${planoDuracao} dias</small>
          `;
          
          fadeIn(countdownLightbox);
          setTimeout(() => {
            fadeIn(expirationNotice);
            startCountdown();
          }, 100);
        } else {
          window.location.href = 'painel.php';
        }
      } else {
        alert(data.message || 'Erro ao fazer login.');
        progressBarContainer.classList.remove('show');
        setTimeout(() => {
          progressBarContainer.style.display = 'none';
          updateProgress(0);
        }, 300);
      }
    } catch (error) {
      console.error('Erro:', error);
      alert('Erro ao tentar fazer login: ' + error.message);
      progressBarContainer.classList.remove('show');
      setTimeout(() => {
        progressBarContainer.style.display = 'none';
        updateProgress(0);
      }, 300);
    }
  });
});
</script>
</body>
</html>