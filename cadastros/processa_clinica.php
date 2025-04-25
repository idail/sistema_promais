<?php 
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_clinica = $_GET["processo_clinica"];

    if($recebe_processo_clinica === "buscar_cidade_clinica")
    {
        $recebe_id_clinica = $_GET["valor_id_clinica"];

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

        $instrucao_busca_cidade_clinica_alteracao = "select cl.empresa_id,cl.cidade_id,c.nome,c.estado,c.id from clinicas as cl inner join cidades as c on cl.empresa_id = 
        c.empresa_id and cl.cidade_id = c.id where cl.id = :recebe_codigo_clinica_alteracao";
        $comando_busca_cidade_clinica_alteracao = $pdo->prepare($instrucao_busca_cidade_clinica_alteracao);
        $comando_busca_cidade_clinica_alteracao->bindValue(":recebe_codigo_clinica_alteracao",$recebe_id_clinica);
        $comando_busca_cidade_clinica_alteracao->execute();
        $resultado_busca_cidade_clinica_alteracao = $comando_busca_cidade_clinica_alteracao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_clinica_alteracao);
    }
}