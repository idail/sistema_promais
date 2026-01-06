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
    $recebe_processo_conta_bancaria = $_POST["processo_conta_bancaria"];
    
    if($recebe_processo_conta_bancaria === "inserir_conta_bancaria")
    {
        $recebe_agencia_conta_bancaria = !empty($_POST["valor_agencia_conta_bancaria"]) ? $_POST["valor_agencia_conta_bancaria"] : null;
        $recebe_conta_bancaria = !empty($_POST["valor_conta_bancaria"]) ? $_POST["valor_conta_bancaria"] : null;
        $recebe_tipo_pix_conta_bancaria = !empty($_POST["valor_tipo_pix_conta_bancaria"]) ? $_POST["valor_tipo_pix_conta_bancaria"] : null;
        $recebe_valor_pix_conta_bancaria = !empty($_POST["valor_pix_conta_bancaria"]) ? $_POST["valor_pix_conta_bancaria"] : null;
        $recebe_valor_tipo_orcamento = !empty($_POST["valor_tipo_orcamento"]) ? $_POST["valor_tipo_orcamento"] : null;

        $instrucao_cadastra_contas_bancaria = "insert into conta_bancaria(agencia,conta,tipo_pix,valor_pix,tipo_orcamento,empresa_id)
        values(:recebe_agencia,:recebe_conta,:recebe_tipo_pix,:recebe_valor_pix,:recebe_tipo_orcamento,:recebe_empresa_id)";
        $comando_cadastra_contas_bancaria = $pdo->prepare($instrucao_cadastra_contas_bancaria);
        $comando_cadastra_contas_bancaria->bindValue(":recebe_agencia",$recebe_agencia_conta_bancaria);
        $comando_cadastra_contas_bancaria->bindValue(":recebe_conta",$recebe_conta_bancaria);
        $comando_cadastra_contas_bancaria->bindValue(":recebe_tipo_pix",$recebe_tipo_pix_conta_bancaria);
        $comando_cadastra_contas_bancaria->bindValue(":recebe_valor_pix",$recebe_valor_pix_conta_bancaria);
        $comando_cadastra_contas_bancaria->bindValue(":recebe_tipo_orcamento",$recebe_valor_tipo_orcamento);
        $comando_cadastra_contas_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_cadastra_contas_bancaria->execute();
        $recebe_ultimo_codigo_gerado_contas_bancaria = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_gerado_contas_bancaria);
    }else if($recebe_processo_conta_bancaria === "excluir_conta_bancaria")
    {
        $recebe_codigo_excluir_conta_bancaria = $_POST["valor_codigo_excluir_conta_bancaria"];

        $instrucao_excluir_conta_bancaria = "delete from conta_bancaria where id_conta_bancaria = :recebe_id_conta_bancaria and empresa_id = :recebe_empresa_id";
        $comando_excluir_conta_bancaria = $pdo->prepare($instrucao_excluir_conta_bancaria);
        $comando_excluir_conta_bancaria->bindValue(":recebe_id_conta_bancaria",$recebe_codigo_excluir_conta_bancaria);
        $comando_excluir_conta_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $resultado_excluir_conta_bancaria = $comando_excluir_conta_bancaria->execute();
        echo json_encode($resultado_excluir_conta_bancaria);
    }else if($recebe_processo_conta_bancaria === "alterar_conta_bancaria")
    {
        $recebe_agencia_conta_bancaria = !empty($_POST["valor_agencia_conta_bancaria"]) ? $_POST["valor_agencia_conta_bancaria"] : null;
        $recebe_conta_bancaria = !empty($_POST["valor_conta_bancaria"]) ? $_POST["valor_conta_bancaria"] : null;
        $recebe_tipo_pix_conta_bancaria = !empty($_POST["valor_tipo_pix_conta_bancaria"]) ? $_POST["valor_tipo_pix_conta_bancaria"] : null;
        $recebe_valor_pix_conta_bancaria = !empty($_POST["valor_pix_conta_bancaria"]) ? $_POST["valor_pix_conta_bancaria"] : null;
        $recebe_valor_tipo_orcamento = !empty($_POST["valor_tipo_orcamento"]) ? $_POST["valor_tipo_orcamento"] : null;

        $recebe_id_conta_bancaria_alteracao = $_POST["valor_id_conta_bancaria"];

        $instrucao_altera_conta_bancaria = "update conta_bancaria set agencia = :recebe_agencia,conta = :recebe_conta,
        tipo_pix = :recebe_tipo_pix,valor_pix = :recebe_valor_pix,tipo_orcamento = :recebe_tipo_orcamento where id_conta_bancaria = :recebe_id_conta_bancaria and empresa_id = :recebe_empresa_id";
        $comando_altera_conta_bancaria = $pdo->prepare($instrucao_altera_conta_bancaria);
        $comando_altera_conta_bancaria->bindValue(":recebe_agencia",$recebe_agencia_conta_bancaria);
        $comando_altera_conta_bancaria->bindValue(":recebe_conta",$recebe_conta_bancaria);
        $comando_altera_conta_bancaria->bindValue(":recebe_tipo_pix",$recebe_tipo_pix_conta_bancaria);
        $comando_altera_conta_bancaria->bindValue(":recebe_valor_pix",$recebe_valor_pix_conta_bancaria);
        $comando_altera_conta_bancaria->bindValue(":recebe_tipo_orcamento",$recebe_valor_tipo_orcamento);
        $comando_altera_conta_bancaria->bindValue(":recebe_id_conta_bancaria",$recebe_id_conta_bancaria_alteracao);
        $comando_altera_conta_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $resultado_altera_conta_bancaria = $comando_altera_conta_bancaria->execute();
        echo json_encode($resultado_altera_conta_bancaria);
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_conta_bancaria = $_GET["processo_conta_bancaria"];

    if($recebe_processo_conta_bancaria === "buscar_contas_bancarias_exames_procedimentos")
    {
        $instrucao_busca_contas_bancaria = "select * from conta_bancaria where tipo_orcamento = :recebe_tipo_orcamento and empresa_id = :recebe_empresa_id";
        $comando_busca_contas_bancaria = $pdo->prepare($instrucao_busca_contas_bancaria);
        $comando_busca_contas_bancaria->bindValue(":recebe_tipo_orcamento","exames_procedimentos");
        $comando_busca_contas_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_contas_bancaria->execute();
        $resultado_busca_contas_bancaria = $comando_busca_contas_bancaria->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_contas_bancaria);
    }else if($recebe_processo_conta_bancaria === "buscar_pix_exames_procedimentos")
    {
        $instrucao_busca_contas_bancaria = "select * from conta_bancaria where tipo_orcamento = :recebe_tipo_orcamento and empresa_id = :recebe_empresa_id";
        $comando_busca_contas_bancaria = $pdo->prepare($instrucao_busca_contas_bancaria);
        $comando_busca_contas_bancaria->bindValue(":recebe_tipo_orcamento","exames_procedimentos");
        $comando_busca_contas_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_contas_bancaria->execute();
        $resultado_busca_contas_bancaria = $comando_busca_contas_bancaria->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_contas_bancaria);
    }else if($recebe_processo_conta_bancaria === "buscar_pix_treinamentos")
    {
        $instrucao_busca_contas_bancaria = "select * from conta_bancaria where tipo_orcamento = :recebe_tipo_orcamento and empresa_id = :recebe_empresa_id";
        $comando_busca_contas_bancaria = $pdo->prepare($instrucao_busca_contas_bancaria);
        $comando_busca_contas_bancaria->bindValue(":recebe_tipo_orcamento","treinamentos");
        $comando_busca_contas_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_contas_bancaria->execute();
        $resultado_busca_contas_bancaria = $comando_busca_contas_bancaria->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_contas_bancaria);
    }else if($recebe_processo_conta_bancaria === "buscar_agencia_conta_treinamentos")
    {
        $instrucao_busca_contas_bancaria = "select * from conta_bancaria where tipo_orcamento = :recebe_tipo_orcamento and empresa_id = :recebe_empresa_id";
        $comando_busca_contas_bancaria = $pdo->prepare($instrucao_busca_contas_bancaria);
        $comando_busca_contas_bancaria->bindValue(":recebe_tipo_orcamento","treinamentos");
        $comando_busca_contas_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_contas_bancaria->execute();
        $resultado_busca_contas_bancaria = $comando_busca_contas_bancaria->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_contas_bancaria);
    }else if($recebe_processo_conta_bancaria === "buscar_dados_bancarios_epi_epc")
    {
        $instrucao_busca_contas_bancaria = "select * from conta_bancaria where tipo_orcamento = :recebe_tipo_orcamento and empresa_id = :recebe_empresa_id";
        $comando_busca_contas_bancaria = $pdo->prepare($instrucao_busca_contas_bancaria);
        $comando_busca_contas_bancaria->bindValue(":recebe_tipo_orcamento","epi_epc");
        $comando_busca_contas_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_contas_bancaria->execute();
        $resultado_busca_contas_bancaria = $comando_busca_contas_bancaria->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_contas_bancaria);
    }else if($recebe_processo_conta_bancaria === "buscar_informacoes_conta_bancaria_alteracao")
    {
        $recebe_codigo_conta_bancaria_alteracao = $_GET["valor_codigo_conta_bancaria_alteracao"];
        $instrucao_busca_contas_bancaria = "select * from conta_bancaria where id_conta_bancaria = :recebe_id_conta_bancaria and empresa_id = :recebe_empresa_id";
        $comando_busca_contas_bancaria = $pdo->prepare($instrucao_busca_contas_bancaria);
        $comando_busca_contas_bancaria->bindValue(":recebe_id_conta_bancaria",$recebe_codigo_conta_bancaria_alteracao);
        $comando_busca_contas_bancaria->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_contas_bancaria->execute();
        $resultado_busca_contas_bancaria = $comando_busca_contas_bancaria->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_contas_bancaria);
    }else if($recebe_processo_conta_bancaria === "busca_informacoes_rapidas_conta_bancaria")
    {
        $recebe_codigo_contas_bancarias_informacoes_rapidas = $_GET["valor_codigo_contas_bancarias_informacoes_rapidas"];

        $instrucao_busca_contas_bancaria_informacoes_rapidas = "select * from conta_bancaria where id_conta_bancaria = :recebe_id_conta_bancaria and empresa_id = :recebe_empresa_id";
        $comando_busca_contas_bancaria_informacoes_rapidas = $pdo->prepare($instrucao_busca_contas_bancaria_informacoes_rapidas);
        $comando_busca_contas_bancaria_informacoes_rapidas->bindValue(":recebe_id_conta_bancaria",$recebe_codigo_contas_bancarias_informacoes_rapidas);
        $comando_busca_contas_bancaria_informacoes_rapidas->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_contas_bancaria_informacoes_rapidas->execute();
        $resultado_busca_contas_bancaria_informacoes_rapidas = $comando_busca_contas_bancaria_informacoes_rapidas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_contas_bancaria_informacoes_rapidas);
    }else if($recebe_processo_conta_bancaria === "buscar_contas_bancarias")
    {
        $instrucao_busca_contas_bancarias = "select * from conta_bancaria where empresa_id = :recebe_empresa_id";
        $comando_busca_contas_bancarias = $pdo->prepare($instrucao_busca_contas_bancarias);
        $comando_busca_contas_bancarias->bindValue(":recebe_empresa_id",$_SESSION["empresa_id"]);
        $comando_busca_contas_bancarias->execute();
        $resultado_busca_contas_bancarias = $comando_busca_contas_bancarias->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_contas_bancarias);
    }
}

?>