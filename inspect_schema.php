<?php
require_once 'config/database.php';

try {
    $pdo = getConnection();
    
    // Tables to inspect
    $tables = ['clinicas', 'medicos', 'medicos_clinicas'];
    
    foreach ($tables as $table) {
        echo "Table: $table\n";
        echo "-------------------\n";
        
        // Get table structure
        $stmt = $pdo->query("DESCRIBE $table");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($columns as $column) {
            echo sprintf(
                "Field: %s, Type: %s, Null: %s, Key: %s, Default: %s, Extra: %s\n",
                $column['Field'], 
                $column['Type'], 
                $column['Null'], 
                $column['Key'], 
                $column['Default'] ?? 'NULL', 
                $column['Extra']
            );
        }
        
        echo "\n";
        
        // Get foreign key constraints
        $stmt = $pdo->query("
            SELECT 
                COLUMN_NAME, 
                REFERENCED_TABLE_NAME, 
                REFERENCED_COLUMN_NAME 
            FROM 
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE 
                TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = '$table' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        $fks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($fks)) {
            echo "Foreign Keys:\n";
            foreach ($fks as $fk) {
                echo sprintf(
                    "Column: %s -> %s.%s\n", 
                    $fk['COLUMN_NAME'], 
                    $fk['REFERENCED_TABLE_NAME'], 
                    $fk['REFERENCED_COLUMN_NAME']
                );
            }
        }
        
        echo "\n\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
