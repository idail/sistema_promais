<?php
include ('lock.php');
?>
<html><head><base href="./">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    .menu-icon {
      font-size: 1.1rem;
      margin-right: 0.5rem;
    }
    .submenu a {
      font-size: 0.85rem;
    }
    .submenu {
      overflow: hidden;
      max-height: 0;
      transition: max-height 0.3s ease;
    }
    .collapsed .submenu {
      max-height: 200px;
    }
    .fa-angle-right {
      transition: transform 0.3s ease;
      transform: rotate(0);
    }
    .collapsed .fa-angle-right {
      transform: rotate(90deg);
    }
    .profile-menu {
      background-color: #2d3748;
      color: white;
      width: 12rem;
      border-radius: 0.375rem;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                  0 4px 6px -2px rgba(0, 0, 0, 0.05),
                  0 10px 25px rgba(0, 0, 0, 0.3);
      position: absolute;
      right: 0;
      margin-top: 0.5rem;
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
      display: none;
      z-index: 10; /* Ensure the profile menu is in front */
      transition: max-height 0.3s ease, opacity 0.3s ease;
      max-height: 0; /* Initially collapsed */
      opacity: 0; /* Initially hidden */
      overflow: hidden; /* To prevent overflow during the transition */
    }
    .profile-menu.open {
      display: block; /* Keep display block for the menu to render */
      max-height: 200px; /* Set to a value high enough to show the full content */
      opacity: 1; /* Make it fully visible */
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2); /* Adding a shadow to the open menu */
    }
    .profile-menu a {
      display: block;
      padding: 0.5rem 1rem;
    }
    .profile-menu a:hover {
      background-color: #4a5568;
    }
    @media screen and (max-width: 768px) {
      .grid-cols-12 {
        grid-template-columns: 1fr;
      }
      .col-span-2, .col-span-10 {
        grid-column: span 1;
      }
    }
    .special-menu {
      background-color: #e53e3e;
      border-radius: 0.375rem;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                  0 4px 6px -2px rgba(0, 0, 0, 0.05);
      color: white;
      margin-top: 1rem;
      padding: 0.5rem;
    }
    .search-box {
      transition: width 0.3s ease;
      width: 12rem;
    }
    .search-box:focus {
      width: 16rem;
    }
    .box-link {
      background: linear-gradient(135deg, #3b82f6, #1e40af);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .box-link:nth-child(1) {
      background: linear-gradient(135deg, #3b82f6, #1e40af);
    }
    .box-link:nth-child(2) {
      background: linear-gradient(135deg, #10b981, #065f46); 
    }
    .box-link:nth-child(3) {
      background: linear-gradient(135deg, #f59e0b, #92400e); 
    }
    .box-link:nth-child(4) {
      background: linear-gradient(135deg, #ef4444, #7f1d1d); 
    }
    .box-link:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5); 
    }
    .box-link:nth-child(1):hover {
      background: linear-gradient(135deg, #1e40af, #3b82f6); 
    }
    .box-link:nth-child(2):hover {
      background: linear-gradient(135deg, #065f46, #10b981);
    }
    .box-link:nth-child(3):hover {
      background: linear-gradient(135deg, #92400e, #f59e0b);
    }
    .box-link:nth-child(4):hover {
      background: linear-gradient(135deg, #7f1d1d, #ef4444);
    }
    .box-link:nth-child(2), .box-link:nth-child(3), .box-link:nth-child(4) {
      transform: scale(0.85); /* Reduce size by 15% */
    }
    .color-palette {
      display: flex;
      justify-content: center;
      margin: 0 auto;
      margin-top: 0.5rem;
      order: 0; 
    }
    .color-swatch {
      width: 8px; 
      height: 8px;
      border-radius: 50%;
      margin: 0 4px;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    .color-swatch:hover {
      transform: scale(1.5);
    }
    .bg-transition {
      transition: background-color 0.5s ease;
    }
    nav {
      background-color: #2d3748;
    }
    .menu-bar {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .primary-menu {
      background-color: #2d3748;
      transition: background-color 0.3s ease;
    }
    .color-palette .color-swatch:nth-child(1) { background-color: #2d3748; } /* New Standard Color */
    .color-palette .color-swatch:nth-child(2) { background-color: #ff7a05; } /* Adjusted Color */
    .color-palette .color-swatch:nth-child(3) { background-color: #b52f2f; } /* Adjusted Color */
    .color-palette .color-swatch:nth-child(4) { background-color: #333333; } /* Adjusted Color */
    .color-palette .color-swatch:nth-child(5) { background-color: #443f4d; } /* Adjusted Color */
    .color-palette .color-swatch:nth-child(6) { background-color: #3b3a4a; } /* Cinza Escuro */
    
  </style>
  
  
  <script>
  // Função para alterar o fundo da navegação
  function changeBackground(color) {
    document.querySelector('nav').style.backgroundColor = color;
    document.querySelector('.primary-menu').style.backgroundColor = color;
    if (color === '#2d3748') {
      document.querySelector('nav').style.backgroundColor = '#2d3748';
      document.querySelector('.primary-menu').style.backgroundColor = '#2d3748';
    }
  }

  // Função para alternar o estado do menu
  function toggleMenu(menuItem) {
    menuItem.parentElement.classList.toggle('collapsed');
    document.querySelector('.color-palette').children[0].click();
  }

  // Função para alternar o menu de perfil
  function toggleProfileMenu() {
    const profileMenu = document.querySelector('.profile-menu');
    if (profileMenu.classList.contains('open')) {
      profileMenu.classList.remove('open');
      setTimeout(() => {
        profileMenu.style.display = 'none';
      }, 300);
    } else {
      profileMenu.style.display = 'block';
      requestAnimationFrame(() => {
        profileMenu.classList.add('open');
      });
    }
  }

  // Função para fazer logout
  function logout() {
    alert("Você foi deslogado com sucesso!");
    window.location.href = "/login.html";
  }

  // Função de busca de pesquisa
  function handleSearchFocus(event) {
    const inputValue = event.target.value.trim();
    if (!inputValue) {
      event.target.classList.add('empty');
    } else {
      event.target.classList.remove('empty');
    }
  }

  // Função para permitir arraste de itens no layout
  function handleDragStart(e) {
    e.dataTransfer.setData('text/plain', e.target.id);
  }

  function handleDragOver(e) {
    e.preventDefault();
  }

  function handleDrop(e) {
    e.preventDefault();
    const sourceId = e.dataTransfer.getData('text/plain');
    const sourceElement = document.getElementById(sourceId);
    const targetElement = e.target.closest('.box-link');
    if (targetElement && sourceElement !== targetElement) {
      sourceElement.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
      targetElement.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
      const sourceParent = sourceElement.parentNode;
      const targetParent = targetElement.parentNode;
      if (sourceParent === targetParent) {
        const sourceIndex = Array.from(sourceParent.children).indexOf(sourceElement);
        const targetIndex = Array.from(targetParent.children).indexOf(targetElement);
        if (sourceIndex < targetIndex) {
          targetParent.insertBefore(sourceElement, targetElement.nextSibling);
        } else {
          targetParent.insertBefore(sourceElement, targetElement);
        }
      } else {
        targetParent.insertBefore(sourceElement, targetElement);
        const sourceIndex = Array.from(sourceParent.children).indexOf(sourceElement);
        sourceParent.insertBefore(targetElement, sourceParent.children[sourceIndex]);
      }
      requestAnimationFrame(() => {
        sourceElement.style.transition = '';
        targetElement.style.transition = '';
      });
      setTimeout(() => {
        sourceElement.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
        targetElement.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
      }, 0);
    }
  }

  // Função para fechar o menu de perfil quando clicar fora
  document.addEventListener('click', function (event) {
    const profileMenu = document.querySelector('.profile-menu');
    const button = document.querySelector('button[onclick="toggleProfileMenu()"]');
    if (!profileMenu.contains(event.target) && !button.contains(event.target) && profileMenu.classList.contains('open')) {
      toggleProfileMenu();
    }
  });
</script>


</head>
<body class="bg-gray-100">
  <nav class="p-4 shadow bg-transition menu-bar flex justify-center">
    <div class="container mx-auto flex items-center justify-center">
      <h1 class="text-2xl font-bold text-white">Sistema PROMAIS</h1>
      <div class="color-palette mx-auto">
        <div class="color-swatch" style="background-color: #2d3748;" onclick="changeBackground('#2d3748')"></div> 
        <div class="color-swatch" style="background-color: #ff7a05;" onclick="changeBackground('#ff7a05')"></div> 
        <div class="color-swatch" style="background-color: #b52f2f;" onclick="changeBackground('#b52f2f')"></div> 
        <div class="color-swatch" style="background-color: #333333;" onclick="changeBackground('#333333')"></div> 
        <div class="color-swatch" style="background-color: #443f4d;" onclick="changeBackground('#443f4d')"></div> 
        <div class="color-swatch" style="background-color: #3b3a4a;" onclick="changeBackground('#3b3a4a')"></div> 
      </div>
      <div class="relative mr-6">
        <input type="text" class="bg-gray-700 text-white rounded-full px-4 py-2 pl-10 focus:outline-none search-box" placeholder="Pesquisar..." onfocus="handleSearchFocus(event)" onblur="handleSearchFocus(event)">
        <i class="fas fa-search absolute left-0 top-0 mt-3 ml-3 text-white"></i>
      </div>
      <a href="notifications" class="text-white hover:text-gray-200 mr-6">
        <i class="fas fa-bell text-xl"></i>
      </a>
      <div class="relative">
        <button class="flex items-center text-white hover:text-gray-200 focus:outline-none" onclick="toggleProfileMenu()">
          <svg class="w-10 h-10 rounded-full mr-2 bg-gray-500" viewBox="0 0 40 40">
            <circle cx="20" cy="20" r="20" fill="#4a5568"/>
            <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="white" font-size="14" font-family="Arial">A</text>
          </svg>
          <span><?php echo htmlspecialchars($_SESSION['user_name']) . (isset($_SESSION['empresa_id']) ? htmlspecialchars($_SESSION['empresa_id']) : ''); ?></span>
          <i class="fas fa-caret-down ml-2"></i>
        </button>
        <div class="profile-menu">
          <a href="painel.php?pg=meu-perfil">Perfil</a>
          <a href="painel.php?pg=meu-perfil/editar">Editar Perfil</a>
          <a href="painel.php?pg=meu-perfil/alterar-senha">Alterar Senha</a>
          <a href="logout.php">Sair</a>
        </div>
      </div>
    </div>
  </nav>
  <div class="container mx-auto mt-8 grid grid-cols-12 gap-6">
    <div class="col-span-2 bg-transition">
      <div class="primary-menu bg-gray-800 text-white rounded-lg shadow p-4 text-sm">
        <a href="painel.php?pg=dash" class="flex items-center mb-4 hover:text-gray-200">
          <i class="fas fa-chart-bar menu-icon text-white"></i> Painel
        </a>
        <div class="mb-4 collapsed">
          <a href="javascript:;" class="flex items-center hover:text-gray-200" onclick="toggleMenu(this)">
            <i class="fas fa-address-book menu-icon text-white"></i> Cadastros
            <i class="fas fa-angle-right ml-auto text-lg"></i>
          </a>
          <div class="submenu ml-8">
            <a href="painel.php?pg=clinicas" class="block text-gray-300 mb-2 hover:text-white">Clinicas</a>
            <a href="painel.php?pg=empresas" class="block text-gray-300 mb-2 hover:text-white">Empresas</a>
            <a href="painel.php?pg=funcionarios" class="block text-gray-300 mb-2 hover:text-white">Funcionários</a>
            <a href="painel.php?pg=medicos" class="block text-gray-300 mb-2 hover:text-white">Médicos</a>
            <a href="painel.php?pg=riscos" class="block text-gray-300 mb-2 hover:text-white">Riscos</a>
            <a href="painel.php?pg=exames" class="block text-gray-300 mb-2 hover:text-white">Cadastro de Exames</a>
            <a href="painel.php?pg=cargos" class="block text-gray-300 mb-2 hover:text-white">Cargos/CBO</a>
            <a href="painel.php?pg=cidades" class="block text-gray-300 mb-2 hover:text-white">Cidades</a>
            <a href="painel.php?pg=bairros" class="block text-gray-300 mb-2 hover:text-white">Bairros</a>
          </div>
        </div>
        <a href="painel.php?pg=gera-kit" class="flex items-center mb-4 hover:text-gray-200">
          <i class="fas fa-box-open menu-icon text-white"></i> Geração de Kit
        </a>
        <a href="painel.php?pg=aso-rascunho" class="flex items-center mb-4 hover:text-gray-200">
          <i class="fas fa-file-alt menu-icon text-white"></i> ASO em Rascunho
        </a>
        <a href="painel.php?pg=configuracoes" class="flex items-center mb-4 hover:text-gray-200">
          <i class="fas fa-cogs menu-icon text-white"></i> Configurações
        </a>
        <a href="painel.php?pg=usuarios" class="flex items-center mb-4 hover:text-gray-200">
          <i class="fas fa-users menu-icon text-white"></i> Usuários
        </a>
      </div>
      <?php
      // Verifique se o nível de acesso é "admin"
      if (isset($_SESSION['user_access_level']) && $_SESSION['user_access_level'] === 'admin') {
        echo '<div class="special-menu">';
        echo '<a href="painel.php?pg=masteradmin" class="flex items-center mb-2 hover:text-white">';
        echo '<i class="fas fa-user-shield menu-icon"></i> MasterAdmin';
        echo '</a>';
        echo '</div>';
      }
      ?>
    </div>
    <div class="col-span-10">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="mt-12 grid grid-cols-4 gap-8">
          <a href="painel.php?pg=gera-kit" id="box1" draggable="true" ondragstart="handleDragStart(event)" ondragover="handleDragOver(event)" ondrop="handleDrop(event)" class="box-link flex flex-col items-center justify-center bg-blue-500 text-white rounded-full w-40 h-40 mx-auto p-4 hover:bg-blue-600 hover:shadow-lg transition duration-300">
            <i class="fas fa-box-open text-4xl mb-2"></i>
            <span class="text-center">Lançar KIT</span>
          </a>
          <a href="#" id="box2" draggable="true" ondragstart="handleDragStart(event)" ondragover="handleDragOver(event)" ondrop="handleDrop(event)" class="box-link flex flex-col items-center justify-center bg-green-500 text-white rounded-full w-40 h-40 mx-auto p-4 hover:bg-green-600 hover:shadow-lg transition duration-300">
            <i class="fas fa-th text-4xl mb-2"></i>
            <span class="text-center">Grade de KIT</span>
          </a>
          <a href="painel.php?pg=aso-rascunho" id="box3" draggable="true" ondragstart="handleDragStart(event)" ondragover="handleDragOver(event)" ondrop="handleDrop(event)" class="box-link flex flex-col items-center justify-center bg-yellow-500 text-white rounded-full w-40 h-40 mx-auto p-4 hover:bg-yellow-600 hover:shadow-lg transition duration-300">
            <i class="fas fa-file-alt text-4xl mb-2"></i>
            <span class="text-center">ASO Rascunho</span>
          </a>
          <a href="painel.php?pg=usuarios" id="box4" draggable="true" ondragstart="handleDragStart(event)" ondragover="handleDragOver(event)" ondrop="handleDrop(event)" class="box-link flex flex-col items-center justify-center bg-red-500 text-white rounded-full w-40 h-40 mx-auto p-4 hover:bg-red-600 hover:shadow-lg transition duration-300">
            <i class="fas fa-users text-4xl mb-2"></i>
            <span class="text-center">Usuários</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>