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

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $recebe_processo_treinamento_capacitacao = $_POST["processo_treinamento_capacitacao"];

    $recebe_empresa_id = $_SESSION["empresa_id"];

    if($recebe_processo_treinamento_capacitacao === "inserir_treinamento_capacitacao")
    {
        $recebe_codigo_treinamento_capacitacao = $_POST["valor_codigo_treinamento_capacitacao"];
        $recebe_nome_treinamento_capacitacao = $_POST["valor_nome_treinamento_capacitacao"];
        $recebe_valor_treinamento_capacitacao = $_POST["valor_treinamento_capacitacao"];

        $instrucao_cadsatra_treinamento_capacitacao = 
        "insert into treinamento_capacitacao(codigo_treinamento_capacitacao,nome,valor,empresa_id)values(:recebe_codigo_treinamento_capacitacao,
        :recebe_nome_treinamento_capacitacao,:recebe_valor_treinamento_capacitacao,:recebe_empresa_id)";
        $comando_cadastra_treinamento_capacitacao = $pdo->prepare($instrucao_cadsatra_treinamento_capacitacao);
        $comando_cadastra_treinamento_capacitacao->bindValue(":recebe_codigo_treinamento_capacitacao",$recebe_codigo_treinamento_capacitacao);
        $comando_cadastra_treinamento_capacitacao->bindValue(":recebe_nome_treinamento_capacitacao",$recebe_nome_treinamento_capacitacao);
        $comando_cadastra_treinamento_capacitacao->bindValue(":recebe_valor_treinamento_capacitacao",$recebe_valor_treinamento_capacitacao);
        $comando_cadastra_treinamento_capacitacao->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_cadastra_treinamento_capacitacao->execute();
        $recebe_ultimo_codigo_registrado_treinamento_capacitacao = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_registrado_treinamento_capacitacao);
    }else if($recebe_processo_treinamento_capacitacao === "alterar_treinamento_capacitacao")
    {
        $recebe_codigo_treinamento_capacitacao_alterar = $_POST["valor_codigo_treinamento_capacitacao"];
        $recebe_nome_treinamento_capacitacao_alterar = $_POST["valor_nome_treinamento_capacitacao"];
        $recebe_valor_treinamento_capacitacao_alterar = $_POST["valor_treinamento_capacitacao"];
        $recebe_id_treinamento_capacitacao_alterar = $_POST["valor_id_treinamento_capacitacao"];

        $instrucao_altera_treinamento_capacitacao = 
        "update treinamento_capacitacao set codigo_treinamento_capacitacao = :recebe_codigo_treinamento_capacitacao,nome = :recebe_nome_treinamento_capacitacao,valor = :recebe_valor_treinamento_capacitacao where
        id = :recebe_id_treinamento_capacitacao and empresa_id = :recebe_empresa_id";
        $comando_altera_treinamento_capacitacao = $pdo->prepare($instrucao_altera_treinamento_capacitacao);
        $comando_altera_treinamento_capacitacao->bindValue(":recebe_codigo_treinamento_capacitacao",$recebe_codigo_treinamento_capacitacao_alterar);
        $comando_altera_treinamento_capacitacao->bindValue(":recebe_nome_treinamento_capacitacao",$recebe_nome_treinamento_capacitacao_alterar);
        $comando_altera_treinamento_capacitacao->bindValue(":recebe_valor_treinamento_capacitacao",$recebe_valor_treinamento_capacitacao_alterar);
        $comando_altera_treinamento_capacitacao->bindValue(":recebe_id_treinamento_capacitacao",$recebe_id_treinamento_capacitacao_alterar);
        $comando_altera_treinamento_capacitacao->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $resultado_altera_treinamento_capacitacao = $comando_altera_treinamento_capacitacao->execute();
        echo json_encode($resultado_altera_treinamento_capacitacao);
    }else if($recebe_processo_treinamento_capacitacao === "excluir_treinamento_capacitacao")
    {
        $recebe_codigo_treinamento_capacitacao_excluir = $_POST["valor_codigo_treinamento_capacitacao"];

        $instrucao_exclui_treinamento_capacitacao = 
        "delete from treinamento_capacitacao where id = :recebe_id_treinamento_capacitacao_excluir and
        empresa_id = :recebe_empresa_id";
        $comando_exclui_treinamento_capacitacao = $pdo->prepare($instrucao_exclui_treinamento_capacitacao);
        $comando_exclui_treinamento_capacitacao->bindValue(":recebe_id_treinamento_capacitacao_excluir",$recebe_codigo_treinamento_capacitacao_excluir);
        $comando_exclui_treinamento_capacitacao->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $resultado_exclui_treinamento_capacitacao = $comando_exclui_treinamento_capacitacao->execute();
        echo json_encode($resultado_exclui_treinamento_capacitacao);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_treinamento_capacitacao = $_GET["processo_treinamento_capacitacao"];
    $recebe_empresa_id = $_SESSION["empresa_id"];

    if($recebe_processo_treinamento_capacitacao === "busca_treinamento_capacitacao")
    {
        $instrucao_busca_treinamento_capacitacao = 
        "select * from treinamento_capacitacao where empresa_id = :recebe_empresa_id";
        $comando_busca_treinamento_capacitacao = $pdo->prepare($instrucao_busca_treinamento_capacitacao);
        $comando_busca_treinamento_capacitacao->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_treinamento_capacitacao->execute();
        $resultado_busca_treinamento_capacitacao = $comando_busca_treinamento_capacitacao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_treinamento_capacitacao);
    }else if($recebe_processo_treinamento_capacitacao === "buscar_informacoes_rapidas_treinamento_capacitacao")
    {
        $recebe_codigo_treinamento_capacitacao = $_GET["valor_codigo_treinamento_capacitacao_informacoes_rapidas"];

        $instrucao_busca_treinamento_capacitacao_informacoes_rapidas = 
        "select * from treinamento_capacitacao where id = :recebe_id_treinamento_capacitacao_informacoes_rapidas 
        and empresa_id = :recebe_empresa_id_treinamento_capacitacao_informacoes_rapidas";
        $comando_busca_treinamento_capacitacao_informacoes_rapidas = $pdo->prepare($instrucao_busca_treinamento_capacitacao_informacoes_rapidas);
        $comando_busca_treinamento_capacitacao_informacoes_rapidas->bindValue(":recebe_id_treinamento_capacitacao_informacoes_rapidas",$recebe_codigo_treinamento_capacitacao);
        $comando_busca_treinamento_capacitacao_informacoes_rapidas->bindValue(":recebe_empresa_id_treinamento_capacitacao_informacoes_rapidas",$recebe_empresa_id);
        $comando_busca_treinamento_capacitacao_informacoes_rapidas->execute();
        $resultado_busca_treinamento_capacitacao_informacoes_rapidas = $comando_busca_treinamento_capacitacao_informacoes_rapidas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_treinamento_capacitacao_informacoes_rapidas);
    }else if($recebe_processo_treinamento_capacitacao === "buscar_informacoes_treinamento_capacitacao_alteracao")
    {
        $recebe_codigo_treinamento_capacitacao = $_GET["valor_codigo_treinamento_capacitacao_alteracao"];

        $instrucao_busca_treinamento_capacitacao_alteracao = 
        "select * from treinamento_capacitacao where id = :recebe_id_treinamento_capacitacao_aleracao and empresa_id = :recebe_empresa_id_treinamento_capacitacao_alteracao";
        $comando_busca_treinamento_capacitacao_alteracao = $pdo->prepare($instrucao_busca_treinamento_capacitacao_alteracao);
        $comando_busca_treinamento_capacitacao_alteracao->bindValue(":recebe_id_treinamento_capacitacao_aleracao",$recebe_codigo_treinamento_capacitacao);
        $comando_busca_treinamento_capacitacao_alteracao->bindValue(":recebe_empresa_id_treinamento_capacitacao_alteracao",$recebe_empresa_id);
        $comando_busca_treinamento_capacitacao_alteracao->execute();
        $resultado_busca_treinamento_capacitacao_alteracao = $comando_busca_treinamento_capacitacao_alteracao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_treinamento_capacitacao_alteracao);
    }
}
?>