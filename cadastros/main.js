// Configuração inicial
const API_URL = 'api/list/clinicas.php';
let currentData = null;
let currentSort = { field: null, direction: 'asc' };
let currentFilters = {
  search: '',
  state: '',
  city: '',
  status: ''
};

// Variáveis globais para edição
let editingClinicId = null;
let editingDoctorId = null;

// Elementos DOM
const elements = {
  table: document.getElementById('clinicTable'),
  tbody: document.querySelector('#clinicTable tbody'),
  searchInput: document.getElementById('searchInput'),
  stateFilter: document.getElementById('stateFilter'),
  cityFilter: document.getElementById('cityFilter'),
  statusFilter: document.getElementById('statusFilter'),
  prevPage: document.getElementById('prevPage'),
  nextPage: document.getElementById('nextPage'),
  pageInfo: document.getElementById('pageInfo'),
  modal: document.getElementById('detailModal'),
  modalClose: document.querySelector('.close'),
  userName: document.getElementById('userName'),
  companyName: document.getElementById('companyName'),
  editModal: document.getElementById('editModal'),
  editForm: document.getElementById('editForm'),
  modalTabs: document.querySelectorAll('.modal-tab'),
  tabContents: document.querySelectorAll('.tab-content'),
  doctorsTable: document.getElementById('doctorsTable'),
  addDoctorBtn: document.getElementById('addDoctorBtn')
};

// Corrigir a inicialização do editModalClose
elements.editModalClose = elements.editModal.querySelector('.close');

// Funções auxiliares
const formatCNPJ = (cnpj) => {
  if (!cnpj) return '';
  return cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
};

const formatAddress = (clinic) => {
  return `${clinic.endereco}, ${clinic.numero}${clinic.complemento ? `, ${clinic.complemento}` : ''} - ${clinic.bairro}`;
};

const setUserInfo = (data) => {
  if (data?.user?.name) {
    elements.userName.textContent = `Usuário: ${data.user.name}`;
  }
  if (data?.empresa?.nome) {
    elements.companyName.textContent = `Empresa: ${data.empresa.nome}`;
  }
};

const updateFilters = (data) => {
  if (!data?.clinicas) return;

  const states = [...new Set(data.clinicas.map(c => c.cidade_estado))];
  const cities = [...new Set(data.clinicas.map(c => c.cidade_nome))];

  elements.stateFilter.innerHTML = '<option value="">Estado</option>' +
    states.sort().map(state => `<option value="${state}">${state}</option>`).join('');

  elements.cityFilter.innerHTML = '<option value="">Cidade</option>' +
    cities.sort().map(city => `<option value="${city}">${city}</option>`).join('');
};

const filterData = (data) => {
  if (!data?.clinicas) return [];

  return data.clinicas.filter(clinic => {
    const searchMatch = Object.values(clinic).some(value =>
      String(value).toLowerCase().includes(currentFilters.search.toLowerCase())
    );
    const stateMatch = !currentFilters.state || clinic.cidade_estado === currentFilters.state;
    const cityMatch = !currentFilters.city || clinic.cidade_nome === currentFilters.city;
    const statusMatch = !currentFilters.status || clinic.status === currentFilters.status;

    return searchMatch && stateMatch && cityMatch && statusMatch;
  });
};

const sortData = (data, field, direction) => {
  return [...data].sort((a, b) => {
    const aVal = a[field];
    const bVal = b[field];
    return direction === 'asc' ?
      String(aVal).localeCompare(String(bVal)) :
      String(bVal).localeCompare(String(aVal));
  });
};

const renderTable = () => {
  if (!currentData?.clinicas) {
    elements.tbody.innerHTML = '<tr><td colspan="8">Nenhum dado disponível</td></tr>';
    return;
  }

  let filteredData = filterData(currentData);
  if (currentSort.field) {
    filteredData = sortData(filteredData, currentSort.field, currentSort.direction);
  }

  elements.tbody.innerHTML = filteredData.map(clinic => `
    <tr>
      <td>${clinic.codigo || '-'}</td>
      <td>${clinic.nome_fantasia || '-'}</td>
      <td>${clinic.razao_social || '-'}</td>
      <td>${formatCNPJ(clinic.cnpj)}</td>
      <td>${clinic.cidade_nome || '-'}/${clinic.cidade_estado || '-'}</td>
      <td>${clinic.total_medicos || '0'}</td>
      <td><span class="status-badge status-${(clinic.status || 'inativo').toLowerCase()}">${clinic.status || 'Inativo'}</span></td>
      <td>
        <div class="action-buttons">
          <button class="action-button mdi mdi-eye" onclick="showDetails(${clinic.id})"></button>
          <button class="action-button mdi mdi-pencil" onclick="editClinic(${clinic.id})"></button>
        </div>
      </td>
    </tr>
  `).join('');
};

const showDetails = (clinicId) => {
  const clinic = currentData?.clinicas?.find(c => c.id === clinicId);
  if (!clinic) return;

  const modalBody = elements.modal.querySelector('.clinic-details');
  const doctorsGrid = elements.modal.querySelector('.doctors-grid');

  modalBody.innerHTML = `
    <div>
      <h3>${clinic.nome_fantasia}</h3>
      <p><strong>Razão Social:</strong> ${clinic.razao_social}</p>
      <p><strong>CNPJ:</strong> ${formatCNPJ(clinic.cnpj)}</p>
      <p><strong>Endereço:</strong> ${formatAddress(clinic)}</p>
    </div>
    <div>
      <p><strong>CEP:</strong> ${clinic.cep}</p>
      <p><strong>Email:</strong> ${clinic.email}</p>
      <p><strong>Telefone:</strong> ${clinic.telefone}</p>
      <p><strong>Status:</strong> ${clinic.status}</p>
    </div>
  `;

  doctorsGrid.innerHTML = (clinic.medicos || []).map(doctor => `
    <div class="doctor-card">
      <h4>${doctor.nome}</h4>
      <p><strong>Especialidade:</strong> ${doctor.especialidade}</p>
      <p><strong>CRM:</strong> ${doctor.crm}</p>
      <p><strong>PCMSO:</strong> ${doctor.pcmso}</p>
      <p><strong>Contato:</strong> ${doctor.contato}</p>
      <p><strong>Status:</strong> ${doctor.status}</p>
    </div>
  `).join('') || '<p>Nenhum médico associado</p>';

  elements.modal.style.display = 'block';
};

const switchTab = (tabId) => {
  elements.modalTabs.forEach(tab => tab.classList.remove('active'));
  elements.tabContents.forEach(content => content.classList.remove('active'));

  document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
  document.getElementById(tabId).classList.add('active');
};

const populateEditForm = (clinic) => {
  const form = elements.editForm;

  // Preenche os campos do formulário
  Object.keys(clinic).forEach(key => {
    const input = form.querySelector(`[name="${key}"]`);
    if (input) input.value = clinic[key];
  });

  // Atualiza a tabela de médicos
  renderDoctorsTable(clinic.medicos || []);
};

const renderDoctorsTable = (doctors) => {
  elements.doctorsTable.querySelector('tbody').innerHTML = doctors.map(doctor => `
    <tr>
      <td>${doctor.nome}</td>
      <td>${doctor.especialidade}</td>
      <td>${doctor.crm}</td>
      <td>${doctor.status}</td>
      <td>
        <button class="action-button mdi mdi-pencil" onclick="editDoctor(${doctor.id})"></button>
        <button class="action-button mdi mdi-delete" onclick="removeDoctor(${doctor.id})"></button>
      </td>
    </tr>
  `).join('');
};

const editClinic = async (id) => {
  editingClinicId = id;
  const clinic = currentData?.clinicas?.find(c => c.id === id);
  if (!clinic) return;

  populateEditForm(clinic);
  elements.editModal.style.display = 'block';
  switchTab('clinicTab');
};

const editDoctor = (id) => {
  editingDoctorId = id;
  const clinic = currentData?.clinicas?.find(c => c.id === editingClinicId);
  const doctor = clinic?.medicos?.find(d => d.id === id);
  if (!doctor) return;

  // Preenche o formulário de médico
  const form = document.getElementById('doctorForm');
  Object.keys(doctor).forEach(key => {
    const input = form.querySelector(`[name="${key}"]`);
    if (input) input.value = doctor[key];
  });

  switchTab('doctorTab');
};

const saveClinic = async (formData) => {
  try {
    const response = await fetch(`${API_URL}/update`, {
      method: 'POST',
      body: JSON.stringify(formData),
      headers: {
        'Content-Type': 'application/json'
      }
    });

    if (!response.ok) throw new Error('Erro ao salvar clínica');

    await loadData(); // Recarrega os dados
    elements.editModal.style.display = 'none';
  } catch (error) {
    console.error('Erro ao salvar:', error);
    alert('Erro ao salvar as alterações');
  }
};

const removeDoctor = async (doctorId) => {
  if (!confirm('Deseja realmente remover este médico?')) return;

  try {
    const response = await fetch(`${API_URL}/doctor/delete/${doctorId}`, {
      method: 'DELETE'
    });

    if (!response.ok) throw new Error('Erro ao remover médico');

    await loadData(); // Recarrega os dados
    populateEditForm(currentData.clinicas.find(c => c.id === editingClinicId));
  } catch (error) {
    console.error('Erro ao remover médico:', error);
    alert('Erro ao remover o médico');
  }
};

// Função para carregar dados da API
const loadData = async () => {
  try {
    const response = await fetch(API_URL);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const result = await response.json();
    console.log('Dados recebidos:', result); // Adicione este log

    if (result.status === 'success' && result.data) {
      currentData = result.data;
      setUserInfo(currentData);
      updateFilters(currentData);
      renderTable();
    } else {
      throw new Error('Formato de dados inválido');
    }
  } catch (error) {
    console.error('Erro ao carregar dados:', error);
    elements.tbody.innerHTML = `<tr><td colspan="8">Erro ao carregar dados: ${error.message}</td></tr>`;
  }
};

// Event Listeners
document.addEventListener('DOMContentLoaded', loadData);

elements.searchInput.addEventListener('input', (e) => {
  currentFilters.search = e.target.value;
  renderTable();
});

elements.stateFilter.addEventListener('change', (e) => {
  currentFilters.state = e.target.value;
  renderTable();
});

elements.cityFilter.addEventListener('change', (e) => {
  currentFilters.city = e.target.value;
  renderTable();
});

elements.statusFilter.addEventListener('change', (e) => {
  currentFilters.status = e.target.value;
  renderTable();
});

elements.table.querySelector('thead').addEventListener('click', (e) => {
  const th = e.target.closest('th');
  if (!th) return;

  const field = th.dataset.sort;
  if (field) {
    currentSort.direction = currentSort.field === field && currentSort.direction === 'asc' ? 'desc' : 'asc';
    currentSort.field = field;
    renderTable();
  }
});

elements.modalClose.addEventListener('click', () => {
  elements.modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
  if (e.target === elements.modal) {
    elements.modal.style.display = 'none';
  }
});

elements.editForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);
  await saveClinic(Object.fromEntries(formData));
});

elements.modalTabs.forEach(tab => {
  tab.addEventListener('click', () => {
    switchTab(tab.dataset.tab);
  });
});

elements.editModalClose.addEventListener('click', () => {
  elements.editModal.style.display = 'none';
});

elements.addDoctorBtn.addEventListener('click', () => {
  editingDoctorId = null;
  document.getElementById('doctorForm').reset();
  switchTab('doctorTab');
});

// Atualiza funções globais para uso nos eventos inline
window.showDetails = showDetails;
window.editClinic = editClinic;
window.editDoctor = editDoctor;
window.removeDoctor = removeDoctor;