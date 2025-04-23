// Gerenciamento avançado de médicos em clínicas
class ClinicDoctorManager {
    constructor(clinicaId) {
        this.clinicaId = clinicaId;
        this.selectedDoctors = [];
        console.log(`ClinicDoctorManager inicializado com clinicaId: ${clinicaId}`);
    }

    // Buscar médicos disponíveis para associação
    async searchAvailableDoctors(searchTerm = '') {
        try {
            // Garantir que o clinicaId esteja definido
            if (!this.clinicaId) {
                console.error('ID da clínica não definido');
                return [];
            }

            const response = await $.ajax({
                url: '../api/list/medicos.php',
                method: 'GET',
                data: { 
                    q: searchTerm,
                    limit: 10,
                    associar_clinica: true,
                    clinica_id: this.clinicaId
                },
                dataType: 'json'
            });

            console.log('Resposta de busca de médicos:', response);

            if (response.status === 'success') {
                return response.data.medicos.filter(medico => 
                    !this.selectedDoctors.some(selected => selected.id === medico.id)
                );
            }
            return [];
        } catch (error) {
            console.error('Erro ao buscar médicos:', error);
            
            // Tratamento de erro mais detalhado
            if (error.responseJSON) {
                alert(error.responseJSON.message || 'Erro ao buscar médicos');
            } else {
                alert('Erro de conexão ao buscar médicos');
            }
            
            return [];
        }
    }

    // Associar médicos à clínica
    async associateDoctors(medicos) {
        try {
            const response = await $.ajax({
                url: '../api/manage_clinic_doctors.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    clinica_id: this.clinicaId,
                    medicos: medicos.map(m => m.id)
                }),
                dataType: 'json'
            });

            console.log('Resposta de associação de médicos:', response);

            if (response.status === 'success') {
                // Atualizar lista de médicos selecionados
                this.selectedDoctors.push(...medicos);
                
                // Feedback detalhado
                console.log('Associação de médicos:', response.data);
                
                return {
                    success: true,
                    associados: response.data.associados,
                    jaAssociados: response.data.ja_associados,
                    naoAssociados: response.data.nao_associados
                };
            }
            return { success: false, message: response.message };
        } catch (error) {
            console.error('Erro ao associar médicos:', error);
            return { success: false, message: 'Erro de conexão' };
        }
    }

    // Carregar médicos já associados à clínica
    async loadAssociatedDoctors() {
        console.log(`Iniciando carregamento de médicos para clinicaId: ${this.clinicaId}`);
        
        try {
            // Verificar se o ID da clínica está definido
            if (!this.clinicaId) {
                console.error('ID da clínica não definido ao carregar médicos');
                return [];
            }

            console.log('Fazendo requisição AJAX para buscar médicos associados');
            const response = await $.ajax({
                url: '../api/manage_clinic_doctors.php',
                method: 'GET',
                data: { clinica_id: this.clinicaId },
                dataType: 'json'
            });

            console.log('Resposta recebida:', response);

            if (response.status === 'success' && response.data && response.data.medicos) {
                // Atualizar lista de médicos selecionados
                this.selectedDoctors = response.data.medicos.map(medico => {
                    console.log('Médico mapeado:', medico);
                    return {
                        id: medico.id,
                        nome: medico.nome,
                        crm: medico.crm,
                        especialidade: medico.especialidade,
                        status: medico.associacao_status
                    };
                });

                console.log('Médicos selecionados:', this.selectedDoctors);
                return this.selectedDoctors;
            }

            console.warn('Nenhum médico encontrado ou resposta inválida');
            return [];
        } catch (error) {
            console.error('Erro completo ao carregar médicos associados:', error);
            
            // Log detalhado do erro
            if (error.responseJSON) {
                console.error('Detalhes da resposta de erro:', error.responseJSON);
                alert(error.responseJSON.message || 'Erro ao carregar médicos associados');
            } else if (error.responseText) {
                console.error('Texto de resposta de erro:', error.responseText);
                alert('Erro ao carregar médicos: ' + error.responseText);
            } else {
                alert('Erro de conexão ao carregar médicos');
            }
            
            return [];
        }
    }

    // Remover médicos da clínica
    async removeDoctors(medicos) {
        try {
            const response = await $.ajax({
                url: '../api/manage_clinic_doctors.php',
                method: 'DELETE',
                contentType: 'application/json',
                data: JSON.stringify({
                    clinica_id: this.clinicaId,
                    medicos: medicos.map(m => m.id)
                }),
                dataType: 'json'
            });

            console.log('Resposta de remoção de médicos:', response);

            if (response.status === 'success') {
                // Remover médicos da lista local
                this.selectedDoctors = this.selectedDoctors.filter(
                    selected => !medicos.some(toRemove => toRemove.id === selected.id)
                );
                
                return { 
                    success: true, 
                    removedDoctors: medicos 
                };
            }
            return { success: false, message: response.message };
        } catch (error) {
            console.error('Erro ao remover médicos:', error);
            return { success: false, message: 'Erro de conexão' };
        }
    }

    // Renderizar lista de médicos
    renderDoctorList(containerSelector) {
        const container = $(containerSelector);
        container.empty();

        if (this.selectedDoctors.length === 0) {
            container.append('<p>Nenhum médico associado</p>');
            return;
        }

        const list = $('<ul class="list-group"></ul>');
        this.selectedDoctors.forEach(medico => {
            const listItem = $(`
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${medico.nome} - ${medico.especialidade} (CRM: ${medico.crm})
                    <span class="badge ${medico.status === 'Ativo' ? 'bg-success' : 'bg-warning'}">
                        ${medico.status}
                    </span>
                    <button class="btn btn-danger btn-sm remove-doctor" data-medico-id="${medico.id}">
                        Remover
                    </button>
                </li>
            `);

            listItem.find('.remove-doctor').on('click', async () => {
                const result = await this.removeDoctors([medico]);
                if (result.success) {
                    this.renderDoctorList(containerSelector);
                    
                    // Atualizar lista global de médicos selecionados
                    window.medicosSelecionados = window.medicosSelecionados.filter(
                        m => m.id !== medico.id
                    );
                } else {
                    alert(result.message);
                }
            });

            list.append(listItem);
        });

        container.append(list);
    }
}

// Uso no contexto da página de clínicas
$(document).ready(function() {
    let clinicDoctorManager = null;

    // Função para limpar seleção de médicos
    function limparSelecaoMedicos() {
        console.log('Limpando seleção de médicos');
        $('#medicos_selecionados').empty();
        $('#busca_medico').val('');
        $('#medicos_dropdown').empty();
    }

    // Inicializar gerenciador quando uma clínica é selecionada
    async function initializeDoctorManager(clinicaId) {
        console.log(`Inicializando gerenciador de médicos para clinicaId: ${clinicaId}`);

        // Verificar se o ID da clínica é válido
        if (!clinicaId) {
            console.error('Tentativa de inicializar gerenciador sem ID de clínica');
            alert('Erro: ID da clínica não definido');
            return;
        }

        // Limpar seleções anteriores
        limparSelecaoMedicos();

        // Criar novo gerenciador
        clinicDoctorManager = new ClinicDoctorManager(clinicaId);
        
        try {
            // Carregar médicos associados
            const medicos = await clinicDoctorManager.loadAssociatedDoctors();

            console.log('Médicos carregados:', medicos);

            if (medicos.length > 0) {
                // Renderizar lista de médicos
                clinicDoctorManager.renderDoctorList('#medicos_selecionados');
                
                // Popular lista de médicos selecionados para envio
                window.medicosSelecionados = medicos.map(medico => ({
                    id: medico.id,
                    nome: medico.nome,
                    crm: medico.crm,
                    especialidade: medico.especialidade
                }));

                console.log('Médicos selecionados globalmente:', window.medicosSelecionados);
            } else {
                // Limpar lista de médicos selecionados
                window.medicosSelecionados = [];
                $('#medicos_selecionados').html('<p>Nenhum médico associado</p>');
                console.log('Nenhum médico associado encontrado');
            }
        } catch (error) {
            console.error('Erro ao inicializar gerenciador de médicos:', error);
            alert('Erro ao carregar médicos associados');
        }

        // Configurar busca de médicos
        $('#busca_medico').on('input', async function() {
            const searchTerm = $(this).val().trim();
            
            // Verificar se o gerenciador está inicializado
            if (!clinicDoctorManager) {
                console.error('Gerenciador de médicos não inicializado');
                return;
            }

            const availableDoctors = await clinicDoctorManager.searchAvailableDoctors(searchTerm);
            
            console.log('Médicos disponíveis:', availableDoctors);

            // Renderizar resultados da busca
            const dropdown = $('#medicos_dropdown');
            dropdown.empty();

            if (availableDoctors.length === 0) {
                dropdown.append('<div class="dropdown-item">Nenhum médico encontrado</div>');
                return;
            }

            availableDoctors.forEach(medico => {
                const item = $(`
                    <div class="dropdown-item" data-medico-id="${medico.id}">
                        ${medico.nome} - ${medico.especialidade} (CRM: ${medico.crm})
                    </div>
                `);

                item.on('click', async () => {
                    const result = await clinicDoctorManager.associateDoctors([medico]);
                    if (result.success) {
                        // Atualizar lista de médicos selecionados
                        window.medicosSelecionados.push({
                            id: medico.id,
                            nome: medico.nome,
                            crm: medico.crm,
                            especialidade: medico.especialidade
                        });

                        clinicDoctorManager.renderDoctorList('#medicos_selecionados');
                        $('#busca_medico').val('');
                        dropdown.empty();
                    } else {
                        alert(result.message);
                    }
                });

                dropdown.append(item);
            });
        });
    }

    // Evento de edição de clínica
    $('#clinicasTable tbody').on('click', '.edit-btn', function() {
        const data = table.row($(this).parents('tr')).data();
        
        console.log('Dados da clínica selecionada:', data);
        
        // Preencher formulário de edição
        $('#clinica_id').val(data.id);
        $('#codigo').val(data.codigo);
        $('#nome_fantasia').val(data.nome_fantasia);
        $('#razao_social').val(data.razao_social);
        $('#cnpj').val(data.cnpj);
        $('#cidade_id').val(data.cidade_id);
        $('#endereco').val(data.endereco);
        $('#numero').val(data.numero);
        $('#complemento').val(data.complemento);
        $('#bairro').val(data.bairro);
        $('#cep').val(data.cep);
        $('#email').val(data.email);
        $('#telefone').val(data.telefone);
        $('#status').val(data.status);

        // Inicializar gerenciador de médicos
        initializeDoctorManager(data.id);

        // Abrir modal de edição
        $('#clinicModal').removeClass('hidden');
    });

    // Evento de adição de clínica
    $('#addClinic').on('click', function() {
        // Limpar formulário
        $('#clinica_id').val('');
        $('#codigo, #nome_fantasia, #razao_social, #cnpj, #cidade_id, #endereco, #numero, #complemento, #bairro, #cep, #email, #telefone').val('');
        $('#status').val('Ativo');

        // Limpar seleção de médicos
        limparSelecaoMedicos();
        window.medicosSelecionados = [];

        // Fechar qualquer gerenciador de médicos existente
        clinicDoctorManager = null;

        // Abrir modal
        $('#clinicModal').removeClass('hidden');
    });
});
