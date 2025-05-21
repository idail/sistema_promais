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
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8", // charset adicionado aqui
        $username,
        $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") // comando adicional
    );
    // Configurar o modo de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_clinica = $_GET["processo_clinica"];

    if($recebe_processo_clinica === "buscar_cidade_clinica")
    {
        $recebe_id_clinica = $_GET["valor_id_clinica"];

        // $instrucao_busca_cidade_clinica_alteracao = "select cl.empresa_id,cl.cidade_id,c.nome,c.estado,c.id from clinicas as cl inner join cidades as c on cl.empresa_id = 
        // c.empresa_id and cl.cidade_id = c.id where cl.id = :recebe_codigo_clinica_alteracao";
        // $instrucao_busca_cidade_clinica_alteracao = "SELECT c.nome AS cidade, c.estado FROM clinicas cl 
        // JOIN cidades c ON cl.cidade_id = c.id WHERE cl.id = :recebe_codigo_clinica_alteracao";
        $instrucao_busca_cidade_clinica_alteracao = "SELECT c.id, c.nome
        FROM cidades c
        JOIN clinicas cl ON cl.cidade_id = c.id
        WHERE cl.id = :recebe_codigo_clinica_alteracao";
        $comando_busca_cidade_clinica_alteracao = $pdo->prepare($instrucao_busca_cidade_clinica_alteracao);
        $comando_busca_cidade_clinica_alteracao->bindValue(":recebe_codigo_clinica_alteracao",$recebe_id_clinica);
        $comando_busca_cidade_clinica_alteracao->execute();
        $resultado_busca_cidade_clinica_alteracao = $comando_busca_cidade_clinica_alteracao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_clinica_alteracao);
    }else if($recebe_processo_clinica === "buscar_informacoes_rapidas_clinicas")
    {
        $recebe_codigo_clinica_informacoes_rapidas = $_GET["valor_id_clinica_informacoes_rapidas"];

        $instrucao_busca_clinica_informacoes_rapidas = "select * from clinicas where id = :recebe_id_clinica_informacoes_rapidas";
        $comando_busca_clinica_informacoes_rapidas = $pdo->prepare($instrucao_busca_clinica_informacoes_rapidas);
        $comando_busca_clinica_informacoes_rapidas->bindValue(":recebe_id_clinica_informacoes_rapidas",$recebe_codigo_clinica_informacoes_rapidas);
        $comando_busca_clinica_informacoes_rapidas->execute();
        $resultado_busca_informacoes_rapidas_clinica = $comando_busca_clinica_informacoes_rapidas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_informacoes_rapidas_clinica);
    }
}else if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $recebe_processo_clinica = $_POST["processo_clinica"];

    if($recebe_processo_clinica === "desvincular_medico_clinica")
    {
        $recebe_medico_clinica_id = $_POST["valor_medico_clinica_id"];

        $recebe_codigo_medico = $_POST["valor_codigo_medico"];

        $instrucao_desvincular_medico_clinica = 
        "update medicos_clinicas set status = :recebe_status_desvincular where id = :recebe_codigo_medicos_clinicas_desvincular and medico_id = :recebe_codigo_medico_desvincular";
        $comando_desvincular_medicos_clinica = $pdo->prepare($instrucao_desvincular_medico_clinica);
        $comando_desvincular_medicos_clinica->bindValue(":recebe_status_desvincular","Inativo");
        $comando_desvincular_medicos_clinica->bindValue(":recebe_codigo_medicos_clinicas_desvincular",$recebe_medico_clinica_id);
        $comando_desvincular_medicos_clinica->bindValue(":recebe_codigo_medico_desvincular",$recebe_codigo_medico);
        $resultado_desvincular_medicos_clinica = $comando_desvincular_medicos_clinica->execute();
        echo json_encode($resultado_desvincular_medicos_clinica);
    }else if($recebe_processo_clinica === "excluir_clinica")
    {
        $recebe_id_clinica = $_POST["valor_id_clinica"];

        $instrucao_exclui_clinica = "delete from clinicas where id = :recebe_id_clinica";
        $comando_exclui_clinica = $pdo->prepare($instrucao_exclui_clinica);
        $comando_exclui_clinica->bindValue(":recebe_id_clinica",$recebe_id_clinica);
        $resultado_excluir_clinica = $comando_exclui_clinica->execute();
        echo json_encode($resultado_excluir_clinica);
    }
}