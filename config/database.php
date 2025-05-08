<?php
/**
 * Configuração e funções do banco de dados
 * 
 * Este arquivo contém as configurações de conexão com o banco de dados
 * e funções úteis para manipulação de dados
 */

// Configurações do banco de dados
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'promais');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_CHARSET', 'utf8mb4');
define("DB_HOST","mysql.idailneto.com.br");
define("DB_NAME","idailneto06");
define("DB_USER","idailneto06");
define("DB_PASS","Sei20020615");
define("DB_CHARSET","utf8mb4");
/**
 * Obtém uma conexão PDO com o banco de dados
 * 
 * @return PDO
 * @throws PDOException
 */
function getConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s", DB_HOST, DB_NAME, DB_CHARSET);
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Erro de conexão: " . $e->getMessage());
            throw new PDOException("Erro ao conectar ao banco de dados");
        }
    }
    
    return $pdo;
}

/**
 * Sanitiza uma string para uso seguro em consultas SQL
 * 
 * @param string $string String a ser sanitizada
 * @return string String sanitizada
 */
function sanitizeString($string) {
    return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
}

/**
 * Valida um CNPJ
 * 
 * @param string $cnpj CNPJ a ser validado
 * @return bool True se válido, false se inválido
 */
function validateCNPJ($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    
    if (strlen($cnpj) != 14) {
        return false;
    }
    
    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }
    
    for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
        $sum += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    
    $rest = $sum % 11;
    if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) {
        return false;
    }
    
    for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
        $sum += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    
    $rest = $sum % 11;
    return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
}

/**
 * Executa uma consulta SQL com prepared statements
 * 
 * @param string $sql Query SQL
 * @param array $params Parâmetros para bind
 * @return PDOStatement
 */
function executeQuery($sql, $params = []) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Erro na query: " . $e->getMessage());
        throw new PDOException("Erro ao executar consulta no banco de dados");
    }
}

/**
 * Inicia uma transação
 */
function beginTransaction() {
    getConnection()->beginTransaction();
}

/**
 * Confirma uma transação
 */
function commitTransaction() {
    getConnection()->commit();
}

/**
 * Reverte uma transação
 */
function rollbackTransaction() {
    getConnection()->rollBack();
}

/**
 * Formata um número de telefone
 * 
 * @param string $phone Número do telefone
 * @return string Telefone formatado
 */
function formatPhone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    $len = strlen($phone);
    
    if ($len == 11) {
        return sprintf('(%s) %s-%s', 
            substr($phone, 0, 2),
            substr($phone, 2, 5),
            substr($phone, 7)
        );
    } elseif ($len == 10) {
        return sprintf('(%s) %s-%s',
            substr($phone, 0, 2),
            substr($phone, 2, 4),
            substr($phone, 6)
        );
    }
    
    return $phone;
}

/**
 * Formata um CEP
 * 
 * @param string $cep CEP
 * @return string CEP formatado
 */
function formatCEP($cep) {
    $cep = preg_replace('/[^0-9]/', '', $cep);
    if (strlen($cep) == 8) {
        return substr($cep, 0, 5) . '-' . substr($cep, 5);
    }
    return $cep;
}

/**
 * Formata um CNPJ
 * 
 * @param string $cnpj CNPJ
 * @return string CNPJ formatado
 */
function formatCNPJ($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    if (strlen($cnpj) == 14) {
        return sprintf('%s.%s.%s/%s-%s',
            substr($cnpj, 0, 2),
            substr($cnpj, 2, 3),
            substr($cnpj, 5, 3),
            substr($cnpj, 8, 4),
            substr($cnpj, 12)
        );
    }
    return $cnpj;
}
