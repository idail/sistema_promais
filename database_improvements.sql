-- Melhorias na estrutura de tabelas para relacionamentos de clínicas e médicos

-- Tabela de Clínicas
ALTER TABLE clinicas 
ADD COLUMN empresa_id INT,
ADD COLUMN data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD CONSTRAINT fk_clinica_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id);

-- Tabela de Médicos
ALTER TABLE medicos
ADD COLUMN empresa_id INT,
ADD COLUMN data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD CONSTRAINT fk_medico_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id);

-- Tabela de Associações Médico-Clínica com mais detalhes
CREATE TABLE medicos_clinicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    clinica_id INT NOT NULL,
    empresa_id INT NOT NULL,
    status ENUM('Ativo', 'Inativo', 'Suspenso') DEFAULT 'Ativo',
    data_associacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_desassociacao TIMESTAMP NULL,
    observacoes TEXT,
    
    UNIQUE KEY unique_associacao (medico_id, clinica_id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE,
    FOREIGN KEY (clinica_id) REFERENCES clinicas(id) ON DELETE CASCADE,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE
);

-- Índices para melhorar performance
CREATE INDEX idx_medico_clinica_status ON medicos_clinicas(status);
CREATE INDEX idx_medico_clinica_empresa ON medicos_clinicas(empresa_id);
