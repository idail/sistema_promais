-- Criar tabela de associação entre médicos e clínicas
CREATE TABLE IF NOT EXISTS medico_clinica (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    clinica_id INT NOT NULL,
    data_associacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE,
    FOREIGN KEY (clinica_id) REFERENCES clinicas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_medico_clinica (medico_id, clinica_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices para melhorar performance
CREATE INDEX idx_medico_id ON medico_clinica(medico_id);
CREATE INDEX idx_clinica_id ON medico_clinica(clinica_id);
