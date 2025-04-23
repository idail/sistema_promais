<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Datagrid de Clínicas</title>
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="styles.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Gerenciamento de Clínicas</h1>
      <div class="user-info">
        <span id="userName"></span>
        <span id="companyName"></span>
      </div>
    </div>

    <div class="filters">
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="Pesquisar...">
        <i class="mdi mdi-magnify"></i>
      </div>
      
      <div class="filter-group">
        <select id="stateFilter">
          <option value="">Estado</option>
        </select>
        
        <select id="cityFilter">
          <option value="">Cidade</option>
        </select>
        
        <select id="statusFilter">
          <option value="">Status</option>
          <option value="Ativo">Ativo</option>
          <option value="Inativo">Inativo</option>
        </select>
      </div>
    </div>

    <div class="datagrid">
      <table id="clinicTable">
        <thead>
          <tr>
            <th data-sort="codigo">Código <i class="mdi mdi-sort"></i></th>
            <th data-sort="nome_fantasia">Nome Fantasia <i class="mdi mdi-sort"></i></th>
            <th data-sort="razao_social">Razão Social <i class="mdi mdi-sort"></i></th>
            <th data-sort="cnpj">CNPJ <i class="mdi mdi-sort"></i></th>
            <th data-sort="cidade_estado">Cidade/UF <i class="mdi mdi-sort"></i></th>
            <th data-sort="total_medicos">Total Médicos <i class="mdi mdi-sort"></i></th>
            <th data-sort="status">Status <i class="mdi mdi-sort"></i></th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <div class="pagination">
      <button id="prevPage" class="mdi mdi-chevron-left"></button>
      <span id="pageInfo"></span>
      <button id="nextPage" class="mdi mdi-chevron-right"></button>
    </div>
  </div>

  <!-- Modal para detalhes -->
  <div id="detailModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Detalhes da Clínica</h2>
        <span class="close">&times;</span>
      </div>
      <div class="modal-body">
        <div class="clinic-details"></div>
        <div class="doctors-list">
          <h3>Médicos Associados</h3>
          <div class="doctors-grid"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para edição -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Editar Clínica</h2>
        <span class="close">&times;</span>
      </div>
      
      <div class="modal-tabs">
        <div class="modal-tab active" data-tab="clinicTab">Dados da Clínica</div>
        <div class="modal-tab" data-tab="doctorTab">Médico</div>
      </div>
      
      <div class="tab-content active" id="clinicTab">
        <form id="editForm">
          <div class="form-grid">
            <div class="form-group">
              <label>Código</label>
              <input type="text" name="codigo" required>
            </div>
            <div class="form-group">
              <label>Nome Fantasia</label>
              <input type="text" name="nome_fantasia" required>
            </div>
            <div class="form-group">
              <label>Razão Social</label>
              <input type="text" name="razao_social" required>
            </div>
            <div class="form-group">
              <label>CNPJ</label>
              <input type="text" name="cnpj" required>
            </div>
            <div class="form-group">
              <label>Endereço</label>
              <input type="text" name="endereco" required>
            </div>
            <div class="form-group">
              <label>Número</label>
              <input type="text" name="numero" required>
            </div>
            <div class="form-group">
              <label>Complemento</label>
              <input type="text" name="complemento">
            </div>
            <div class="form-group">
              <label>Bairro</label>
              <input type="text" name="bairro" required>
            </div>
            <div class="form-group">
              <label>CEP</label>
              <input type="text" name="cep" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" required>
            </div>
            <div class="form-group">
              <label>Telefone</label>
              <input type="tel" name="telefone" required>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="status" required>
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
              </select>
            </div>
          </div>
          
          <h3>Médicos Associados</h3>
          <button type="button" id="addDoctorBtn" class="btn btn-primary add-doctor-btn">
            Adicionar Médico
          </button>
          
          <table class="doctors-table" id="doctorsTable">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Especialidade</th>
                <th>CRM</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <button type="button" class="btn btn-secondary close">Cancelar</button>
          </div>
        </form>
      </div>
      
      <div class="tab-content" id="doctorTab">
        <form id="doctorForm">
          <div class="form-grid">
            <div class="form-group">
              <label>Nome</label>
              <input type="text" name="nome" required>
            </div>
            <div class="form-group">
              <label>Especialidade</label>
              <input type="text" name="especialidade" required>
            </div>
            <div class="form-group">
              <label>CRM</label>
              <input type="text" name="crm" required>
            </div>
            <div class="form-group">
              <label>PCMSO</label>
              <input type="text" name="pcmso" required>
            </div>
            <div class="form-group">
              <label>Contato</label>
              <input type="text" name="contato" required>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="status" required>
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
              </select>
            </div>
          </div>
          
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar Médico</button>
            <button type="button" class="btn btn-secondary close">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="module" src="main.js"></script>
</body>
</html>