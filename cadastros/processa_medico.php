<?php 
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_medico = $_GET["processo_medico"];
    if($recebe_processo_medico === "buscar_medicos_associar_clinica")
    {
        // conexao.php
        $host = 'localhost';
        $dbname = 'promais';
        $user = 'root';
        $password = ''; // Sem senha

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }

        $instrucao_busca_medicos = "SELECT *
        FROM medicos
        WHERE crm IS NOT NULL AND TRIM(crm) != ''
        AND status = 'Ativo';
        ";
        $comando_buca_medicos = $pdo->prepare($instrucao_busca_medicos);
        $comando_buca_medicos->execute();
        $resultado_busca_medicos = $comando_buca_medicos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medicos);
    }
}
?>