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

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $recebe_processo_cidade_estado = $_POST["processo_cidade_estado"];

    if($recebe_processo_cidade_estado === "inserir_cidade_estado")
    {
        $recebe_cidade = $_POST["valor_cidade"];
        $recebe_cep = $_POST["valor_cep"];
        $recebe_estado = $_POST["valor_estado"];
        $recebe_uf = $_POST["valor_uf"];
        $recebe_empresa_id = $_SESSION["empresa_id"];

        $instrucao_cadastra_cidade_estado = 
        "insert into cidades(empresa_id,nome,estado,status,cep,uf)
        values(:recebe_empresa_id,:recebe_nome,:recebe_estado,:recebe_status,:recebe_cep,:recebe_uf)";
        $comando_cadastra_cidade_estado = $pdo->prepare($instrucao_cadastra_cidade_estado);
        $comando_cadastra_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_cadastra_cidade_estado->bindValue(":recebe_nome",$recebe_cidade);
        $comando_cadastra_cidade_estado->bindValue(":recebe_estado",$recebe_estado);
        $comando_cadastra_cidade_estado->bindValue(":recebe_status","Ativo");
        $comando_cadastra_cidade_estado->bindValue(":recebe_cep",$recebe_cep);
        $comando_cadastra_cidade_estado->bindValue(":recebe_uf",$recebe_uf);
        $comando_cadastra_cidade_estado->execute();
        $recebe_ultimo_codigo_cadastra_cidade_estado = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_cadastra_cidade_estado);
    }else if($recebe_processo_cidade_estado === "alterar_cidade_estado")
    {
        $recebe_cidade = $_POST["valor_cidade"];
        $recebe_cep = $_POST["valor_cep"];
        $recebe_estado = $_POST["valor_estado"];
        $recebe_uf = $_POST["valor_uf"];
        $recebe_id_cidade_estado = $_POST["valor_id_cidade_estado"];
        $instrucao_altera_cidade_estado = 
        "update cidades set nome = :recebe_nome,cep = :recebe_cep,estado = :recebe_estado,
        uf = :recebe_uf where id = :recebe_id_cidade";
        $comando_altera_cidade_estado = $pdo->prepare($instrucao_altera_cidade_estado);
        $comando_altera_cidade_estado->bindValue(":recebe_nome",$recebe_cidade);
        $comando_altera_cidade_estado->bindValue(":recebe_cep",$recebe_cep);
        $comando_altera_cidade_estado->bindValue(":recebe_estado",$recebe_estado);
        $comando_altera_cidade_estado->bindValue(":recebe_uf",$recebe_uf);
        $comando_altera_cidade_estado->bindValue(":recebe_id_cidade",$recebe_id_cidade_estado);
        $resultado_altera_cidade_estado = $comando_altera_cidade_estado->execute();
        echo json_encode($resultado_altera_cidade_estado);
    }else if($recebe_processo_cidade_estado === "excluir_cidade_estado")
    {
        $recebe_id_cidade_estado = $_POST["valor_id_cidade_estado"];

        $instrucao_exclui_cidade_estado = 
        "delete from cidades where id = :recebe_cidade_id";
        $comando_exclui_cidade_estado = $pdo->prepare($instrucao_exclui_cidade_estado);
        $comando_exclui_cidade_estado->bindValue(":recebe_cidade_id",$recebe_id_cidade_estado);
        $resultado_exclui_cidade_estado = $comando_exclui_cidade_estado->execute();
        echo json_encode($resultado_exclui_cidade_estado);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_cidade_estado = $_GET["processa_cidade_estado"];

    if($recebe_processo_cidade_estado === "buscar_cidade_estado_mt")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","MT");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_ms")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","MS");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_bh")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","BH");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_mg")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","MG");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_sp")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","SP");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_sc")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","SC");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_pr")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","PR");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_rs")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","RS");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_go")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","GO");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_ce")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","CE");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_am")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","AM");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_rj")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","RJ");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_pa")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","PA");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_pe")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","PE");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_ma")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","MA");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_es")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","ES");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_ap")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","AP");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_rn")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","RN");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_pb")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","PB");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_ac")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","AC");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_al")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","AL");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_to")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","TO");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_pi")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","PI");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_rr")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","RR");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }else if($recebe_processo_cidade_estado === "buscar_cidade_estado_ro")
    {
        $recebe_empresa_id = $_SESSION["empresa_id"];
        $instrucao_busca_cidade_estado = "select * from cidades where uf = :recebe_uf and empresa_id = :recebe_empresa_id";
        $comando_busca_cidade_estado = $pdo->prepare($instrucao_busca_cidade_estado);
        $comando_busca_cidade_estado->bindValue(":recebe_uf","RO");
        $comando_busca_cidade_estado->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_busca_cidade_estado->execute();
        $resultado_busca_cidade_estado = $comando_busca_cidade_estado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_estado);
    }
}
?>