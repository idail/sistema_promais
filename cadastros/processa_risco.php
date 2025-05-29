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
    $recebe_processo_risco = $_POST["processo_risco"];

    if($recebe_processo_risco === "inserir_risco")
    {
        $recebe_codigo_risco = $_POST["valor_codigo_risco"];
        $recebe_descricao_risco = $_POST["valor_descricao_risco"];
        $recebe_grupo_risco = $_POST["valor_grupo_risco"];

        $recebe_empresa_id = $_SESSION["empresa_id"];

        $instrucao_cadastra_risco =
        "insert into grupo_riscos(codigo,empresa_id,descricao_grupo_risco,grupo_risco)values
        (:recebe_codigo,:recebe_empresa_id,:recebe_descricao_grupo,:recebe_grupo_risco)";
        $comando_cadastra_risco = $pdo->prepare($instrucao_cadastra_risco);
        $comando_cadastra_risco->bindValue(":recebe_codigo",$recebe_codigo_risco);
        $comando_cadastra_risco->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_cadastra_risco->bindValue(":recebe_descricao_grupo",$recebe_descricao_risco);
        $comando_cadastra_risco->bindValue(":recebe_grupo_risco",$recebe_grupo_risco);
        $comando_cadastra_risco->execute();
        $recebe_ultimo_codigo_registrado_cadastra_risco = $pdo->lastInsertId();

        echo json_encode($recebe_ultimo_codigo_registrado_cadastra_risco);
    }else if($recebe_processo_risco === "alterar_risco")
    {
        $recebe_codigo_risco_alterar = $_POST["valor_codigo_risco"];
        $recebe_descricao_risco_alterar = $_POST["valor_descricao_risco"];
        $recebe_grupo_risco_alterar = $_POST["valor_grupo_risco"];
        $recebe_id_risco_alterar = $_POST["valor_id_risco"];

        $recebe_empresa_id = $_SESSION["empresa_id"];

        $instrucao_altera_risco = 
        "update grupo_riscos set codigo = :recebe_codigo_alterar,descricao_grupo_risco = :recebe_descricao_alterar,
        grupo_risco = :recebe_grupo_risco_alterar where id = :recebe_id_alterar and empresa_id = :recebe_empresa_id_alterar";
        $comando_altera_risco = $pdo->prepare($instrucao_altera_risco);
        $comando_altera_risco->bindValue(":recebe_codigo_alterar",$recebe_codigo_risco_alterar);
        $comando_altera_risco->bindValue(":recebe_descricao_alterar",$recebe_descricao_risco_alterar);
        $comando_altera_risco->bindValue(":recebe_grupo_risco_alterar",$recebe_grupo_risco_alterar);
        $comando_altera_risco->bindValue(":recebe_id_alterar",$recebe_id_risco_alterar);
        $comando_altera_risco->bindValue(":recebe_empresa_id_alterar",$recebe_empresa_id);
        $resultado_altera_risco = $comando_altera_risco->execute();
        echo json_encode($resultado_altera_risco);
    }else if($recebe_processo_risco === "excluir_risco")
    {
        $recebe_id_risco = $_POST["valor_id_risco"];

        $instrucao_exclui_risco = 
        "delete from grupo_riscos where id = :recebe_id_excluir";
        $comando_exclui_risco = $pdo->prepare($instrucao_exclui_risco);
        $comando_exclui_risco->bindValue(":recebe_id_excluir",$recebe_id_risco);
        $resultado_exclui_risco = $comando_exclui_risco->execute();
        echo json_encode($resultado_exclui_risco);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_risco = $_GET["processo_risco"];

    $recebe_empresa_id = $_SESSION["empresa_id"];

    if($recebe_processo_risco === "buscar_riscos_ergonomico")
    {
        $instrucao_busca_riscos_ergonomicos = 
        "select * from grupo_riscos where grupo_risco = :recebe_grupo_risco and empresa_id = :recebe_empresa_id";
        $comando_busca_riscos_ergonomicos = $pdo->prepare($instrucao_busca_riscos_ergonomicos);
        $comando_busca_riscos_ergonomicos->bindValue(":recebe_grupo_risco","ergonomico");
        $comando_busca_riscos_ergonomicos->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_riscos_ergonomicos->execute();
        $resultado_busca_riscos_ergonomicos = $comando_busca_riscos_ergonomicos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_riscos_ergonomicos);
    }else if($recebe_processo_risco === "buscar_riscos_acidente_mecanico")
    {
        $instrucao_busca_riscos_acidente_mecanico = 
        "select * from grupo_riscos where grupo_risco = :recebe_grupo_risco and empresa_id = :recebe_empresa_id";
        $comando_busca_riscos_acidente_mecanico = $pdo->prepare($instrucao_busca_riscos_acidente_mecanico);
        $comando_busca_riscos_acidente_mecanico->bindValue(":recebe_grupo_risco","acidente_mecanico");
        $comando_busca_riscos_acidente_mecanico->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_riscos_acidente_mecanico->execute();
        $resultado_busca_riscos_acidente_mecanico = $comando_busca_riscos_acidente_mecanico->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_riscos_acidente_mecanico);
    }else if($recebe_processo_risco ==="buscar_riscos_fisicos")
    {
        $instrucao_busca_riscos_fisicos = 
        "select * from grupo_riscos where grupo_risco = :recebe_grupo_risco and empresa_id = :recebe_empresa_id";
        $comando_busca_riscos_fisicos = $pdo->prepare($instrucao_busca_riscos_fisicos);
        $comando_busca_riscos_fisicos->bindValue(":recebe_grupo_risco","fisico");
        $comando_busca_riscos_fisicos->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_riscos_fisicos->execute();
        $resultado_busca_riscos_fisicos = $comando_busca_riscos_fisicos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_riscos_fisicos);
    }else if($recebe_processo_risco === "buscar_riscos_quimico")
    {
        $instrucao_busca_riscos_quimico = 
        "select * from grupo_riscos where grupo_risco = :recebe_grupo_risco and empresa_id = :recebe_empresa_id";
        $comando_busca_riscos_quimico = $pdo->prepare($instrucao_busca_riscos_quimico);
        $comando_busca_riscos_quimico->bindValue(":recebe_grupo_risco","quimico");
        $comando_busca_riscos_quimico->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_riscos_quimico->execute();
        $resultado_busca_riscos_quimico = $comando_busca_riscos_quimico->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_riscos_quimico);
    }else if($recebe_processo_risco === "buscar_riscos_biologico")
    {
        $instrucao_busca_riscos_biologicos = 
        "select * from grupo_riscos where grupo_risco = :recebe_grupo_risco and empresa_id = :recebe_empresa_id";
        $comando_busca_riscos_biologicos = $pdo->prepare($instrucao_busca_riscos_biologicos);
        $comando_busca_riscos_biologicos->bindValue(":recebe_grupo_risco","biologico");
        $comando_busca_riscos_biologicos->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_riscos_biologicos->execute();
        $resultado_busca_riscos_biologicos = $comando_busca_riscos_biologicos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_riscos_biologicos);
    }else if($recebe_processo_risco === "buscar_riscos_outros")
    {
        $instrucao_busca_riscos_outros = 
        "select * from grupo_riscos where grupo_risco = :recebe_grupo_risco and empresa_id = :recebe_empresa_id";
        $comando_busca_riscos_outros = $pdo->prepare($instrucao_busca_riscos_outros);
        $comando_busca_riscos_outros->bindValue(":recebe_grupo_risco","outro");
        $comando_busca_riscos_outros->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_riscos_outros->execute();
        $resultado_busca_riscos_outros = $comando_busca_riscos_outros->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_riscos_outros);
    }
}
?>