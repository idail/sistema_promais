<html>

<head>
  <title>Promais - Software de Medicina e Segurança do Trabalho</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="A Promais oferece uma solução completa e inteligente para transformar a rotina da Medicina e Segurança do Trabalho. Com nosso software, você emite atestados, laudos e documentos ocupacionais com agilidade e total segurança, além de realizar o faturamento de forma simples e integrada. A plataforma facilita a gestão digital de prontuários e toda a documentação dos pacientes, garantindo organização, rastreabilidade e conformidade. E mais: otimiza o cuidado com a saúde dos colaboradores, tornando todo o processo operacional mais eficiente, seguro e confiável. Promais: tecnologia que impulsiona a gestão de SST e eleva o padrão de qualidade da sua operação.">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .hero-slide {
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .logo img {
      width: 150px;
      /* ajuste como desejar */
      height: auto;
      /* mantém a proporção correta */
      /* object-fit: contain;
      display: block; */
      /* evita espaços extras */
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="bg-white shadow-lg fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex-shrink-0 logo">
          <img src="./img/logos/verificando_2.png" alt="Logo">
        </div>
        <!-- Menu Links -->
        <div class="hidden md:flex space-x-8">
          <a href="./inicio.html" class="text-gray-700 hover:text-teal-600 px-3 py-2">Início</a>
          <a href="./sobre.html" class="text-gray-700 hover:text-teal-600 px-3 py-2">Sobre Nós</a>
          <a href="./servicos.html" class="text-gray-700 hover:text-teal-600 px-3 py-2">Serviços</a>
          <a href="./contato.html" class="text-gray-700 hover:text-teal-600 px-3 py-2">Contato</a>
        </div>
        <!-- Botões -->
        <div class="flex items-center space-x-4">
          <a href="./painel.php" class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition flex items-center">
            <i class="fas fa-user-circle mr-2"></i> Acessar Sistema
          </a>
          <a href="./agendar.html" class="bg-teal-600 text-white px-6 py-2 rounded-full hover:bg-teal-700 transition">
            Agende Agora
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="pt-16">
    <div class="hero-slide bg-gradient-to-r from-teal-500 to-blue-600 text-white py-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-bold mb-6">Software de Medicina e Segurança do Trabalho</h1>
          <!-- <p class="text-xl mb-8">Gestão de laudos, exames ocupacionais e eSocial</p> -->
          <p style="margin-bottom: 20px;">Solução otimizada na emissão de atestados, laudos e documentos ocupacionais, gerenciamento de prontuários de forma totalmente digital e faturamento com rapidez e segurança.</p>
          <a href="./demonstracao.html" class="bg-white text-teal-600 px-8 py-3 rounded-full hover:bg-gray-100 transition">
            Veja como funciona
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition">
          <div class="text-teal-600 text-4xl mb-4">
            <i class="fas fa-file-medical"></i>
          </div>
          <h3 class="text-xl font-semibold mb-4">Atestados Médicos</h3>
          <p class="text-gray-600">Emissão de atestados e documentos ocupacionais de forma rápida e segura</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition">
          <div class="text-teal-600 text-4xl mb-4">
            <i class="fas fa-folder-open"></i>
          </div>
          <h3 class="text-xl font-semibold mb-4">Prontuários</h3>
          <p class="text-gray-600">Gerenciamento digital de prontuários e documentação dos pacientes</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition">
          <div class="text-teal-600 text-4xl mb-4">
            <i class="fas fa-sync"></i>
          </div>
          <h3 class="text-xl font-semibold mb-4">Integração</h3>
          <p class="text-gray-600">Integração com plataformas fiscais e eSocial para envio de declarações</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Para quem é Section -->
  <div class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center mb-12">Para quem é a plataforma?</h2>
      <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-4">Para Clínicas e Consultórios SST</h3>
          <p class="text-gray-600">Saiba mais sobre como otimizar sua gestão</p>
          <a href="./clinicas.html" class="inline-block mt-4 text-teal-600 hover:text-teal-700">Saiba mais →</a>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-4">Para Empresas / SESMT</h3>
          <p class="text-gray-600">Saiba mais sobre como gerenciar a saúde dos seus colaboradores</p>
          <a href="./empresas.html" class="inline-block mt-4 text-teal-600 hover:text-teal-700">Saiba mais →</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="grid md:grid-cols-4 gap-8">
        <div>
          <h4 class="text-lg font-semibold mb-4">Sobre nós</h4>
          <p class="text-gray-400">Software especializado em medicina e segurança do trabalho</p>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">Links Rápidos</h4>
          <ul class="space-y-2">
            <li><a href="./inicio.html" class="text-gray-400 hover:text-white">Início</a></li>
            <li><a href="./servicos.html" class="text-gray-400 hover:text-white">Serviços</a></li>
            <li><a href="./contato.html" class="text-gray-400 hover:text-white">Contato</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">Contato</h4>
          <ul class="space-y-2 text-gray-400">
            <li><i class="fas fa-phone mr-2"></i> (00) 0000-0000</li>
            <li><i class="fas fa-envelope mr-2"></i> contato@promais.com</li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">Redes Sociais</h4>
          <div class="flex space-x-4">
            <a href="https://linkedin.com/company/promais" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin text-2xl"></i></a>
            <a href="https://facebook.com/promais" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-2xl"></i></a>
            <a href="https://instagram.com/promais" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-2xl"></i></a>
          </div>
        </div>
      </div>
      <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
        <p>© 2024 Plataforma Promais - Todos os direitos reservados</p>
      </div>
    </div>
  </footer>

</body>

</html>