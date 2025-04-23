<?php
require_once 'C:/xampp/htdocs/promais/config/database.php';

function migrate() {
    try {
        $pdo = getConnection();
        
        // Criar tabela medico_clinica
        $createTableQuery = "
        CREATE TABLE IF NOT EXISTS medico_clinica (
            id INT AUTO_INCREMENT PRIMARY KEY,
            medico_id INT NOT NULL,
            clinica_id INT NOT NULL,
            status ENUM('Ativo', 'Inativo') DEFAULT 'Ativo',
            data_associacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE,
            FOREIGN KEY (clinica_id) REFERENCES clinicas(id) ON DELETE CASCADE,
            UNIQUE KEY unique_medico_clinica (medico_id, clinica_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        -- Índices para melhorar performance
        CREATE INDEX IF NOT EXISTS idx_medico_id ON medico_clinica(medico_id);
        CREATE INDEX IF NOT EXISTS idx_clinica_id ON medico_clinica(clinica_id);
        ";

        $pdo->exec($createTableQuery);

        echo "Tabela medico_clinica criada com sucesso!\n";
        return true;
    } catch (Exception $e) {
        echo "Erro ao criar tabela: " . $e->getMessage() . "\n";
        return false;
    }
}

// Se este script for executado diretamente
if (basename(__FILE__) === '20240128_create_medico_clinica_table.php') {
    migrate();
}
?>
