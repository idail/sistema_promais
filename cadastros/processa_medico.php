<?php 
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

// conexao.php
// $host = 'localhost';
// $dbname = 'promais';
// $user = 'root';
// $password = ''; // Sem senha

$host = 'mysql.idailneto.com.br';
$dbname = 'idailneto06';
$username = 'idailneto06';
$password = 'Sei20020615';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_medico = $_GET["processo_medico"];
    if($recebe_processo_medico === "buscar_medicos_associar_clinica")
    {
        $instrucao_busca_medicos = "SELECT *
        FROM medicos
        WHERE crm IS NOT NULL AND TRIM(crm) != ''
        AND status = 'Ativo';
        ";
        $comando_buca_medicos = $pdo->prepare($instrucao_busca_medicos);
        $comando_buca_medicos->execute();
        $resultado_busca_medicos = $comando_buca_medicos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medicos);
    }else if($recebe_processo_medico === "buscar_medicos_associados_clinica")
    {
        $recebe_codigo_clinica_medicos_associados = $_GET["valor_codigo_clinica_medicos_associados"];
        $instrucao_busca_medicos_associados_clinica = "SELECT DISTINCT m.id AS medico_id,mc.id, m.nome AS nome_medico FROM 
        medicos_clinicas mc JOIN medicos m ON mc.medico_id = m.id WHERE mc.status = 'Ativo' AND mc.clinica_id = :recebe_codigo_clinica";
        $comando_busca_medicos_associados_clinica = $pdo->prepare($instrucao_busca_medicos_associados_clinica);
        $comando_busca_medicos_associados_clinica->bindValue(":recebe_codigo_clinica",$recebe_codigo_clinica_medicos_associados);
        $comando_busca_medicos_associados_clinica->execute();
        $resultado_busca_medicos_associados_clinica = $comando_busca_medicos_associados_clinica->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medicos_associados_clinica);
    }else if($recebe_processo_medico === "buscar_medicos_associar_empresa")
    {
        $instrucao_busca_medicos = "SELECT *
        FROM medicos
        WHERE crm IS NOT NULL AND TRIM(crm) != ''
        AND status = 'Ativo';
        ";
        $comando_buca_medicos = $pdo->prepare($instrucao_busca_medicos);
        $comando_buca_medicos->execute();
        $resultado_busca_medicos = $comando_buca_medicos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medicos);
    }else if($recebe_processo_medico === "buscar_medicos_associados_empresa")
    {
        $recebe_codigo_empresa_medicos_associados = $_GET["valor_codigo_empresa_medicos_associados"];
        $instrucao_busca_medicos_associados_empresa = "SELECT DISTINCT m.id AS medico_id,me.id, m.nome AS nome_medico FROM 
        medicos_empresas me JOIN medicos m ON me.medico_id = m.id WHERE me.status = 'Ativo' AND me.empresa_id = :recebe_codigo_empresa";
        $comando_busca_medicos_associados_empresa = $pdo->prepare($instrucao_busca_medicos_associados_empresa);
        $comando_busca_medicos_associados_empresa->bindValue(":recebe_codigo_empresa",$recebe_codigo_empresa_medicos_associados);
        $comando_busca_medicos_associados_empresa->execute();
        $resultado_busca_medicos_associados_empresa = $comando_busca_medicos_associados_empresa->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medicos_associados_empresa);
    }
}
?>