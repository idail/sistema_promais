<html><base href="https://example.com">
<head>
  <meta charset="UTF-8">
  <title>Dashboard de Usuários</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      background: linear-gradient(120deg, #f0f0f0, #e6e6e6);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding: 20px;
    }

    h1 {
      margin-bottom: 20px;
      text-align: center;
      color: #333;
    }

    .table-container {
      width: 100%;
      max-width: 800px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
    }

    .table-container table {
      width: 100%;
      border-collapse: collapse;
    }

    .table-container th,
    .table-container td {
      padding: 12px 8px;
      text-align: left;
    }

    .table-container thead {
      background-color: #333;
      color: #fff;
    }

    .table-container tbody tr:nth-child(odd) {
      background-color: #f9f9f9;
    }

    .table-container tbody tr:hover {
      background-color: #eaeaea;
      transition: background-color 0.3s ease;
    }

    .spinner {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 50px;
      margin: 20px auto;
    }

    /* Inline SVG Spinner Animation */
    .spinner svg {
      width: 50px;
      height: 50px;
      animation: rotate 1s linear infinite;
    }

    @keyframes rotate {
      100% {
        transform: rotate(360deg);
      }
    }

    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <h1>Dashboard de Usuários</h1>
  <div class="table-container">
    <div id="loading" class="spinner">
      <svg viewBox="0 0 50 50">
        <circle cx="25" cy="25" r="20" fill="none" stroke="#333" stroke-width="4" stroke-linecap="round" />
      </svg>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Nível de Acesso</th>
          <th>Criado em</th>
        </tr>
      </thead>
      <tbody id="users-body">
        <!-- Linhas serão geradas dinamicamente via JavaScript -->
      </tbody>
    </table>
  </div>

  <script>
    // Função para buscar e exibir dados dos usuários
    async function fetchAndDisplayUsers() {
      try {
        const response = await fetch('http://168.90.139.50:8095/promais/usr_json.php');
        const users = await response.json();

        const tbody = document.getElementById('users-body');
        const loading = document.getElementById('loading');

        // Esconde o spinner de carregamento
        loading.classList.add('hidden');

        // Preenche a tabela com os dados retornados
        users.forEach(user => {
          // Criando uma nova linha na tabela
          const row = document.createElement('tr');

          // Populando a linha com dados (não exibimos senha_hash)
          row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.nome}</td>
            <td>${user.email}</td>
            <td>${user.nivel_acesso}</td>
            <td>${user.criado_em}</td>
          `;

          // Adiciona a linha no tbody
          tbody.appendChild(row);
        });
      } catch (error) {
        console.error('Erro ao buscar dados dos usuários:', error);
      }
    }

    // Chama a função assim que a página for carregada
    window.addEventListener('DOMContentLoaded', fetchAndDisplayUsers);
  </script>

</body>
</html>