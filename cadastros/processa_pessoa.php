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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recebe_processo_pessoa = $_POST["processo_pessoa"];

    if ($recebe_processo_pessoa === "inserir_pessoa") {
        $recebe_nome_pessoa = $_POST["valor_nome_pessoa"];
        $recebe_cpf_pessoa = $_POST["valor_cpf_pessoa"];
        $recebe_nascimento_pessoa = !empty($_POST["valor_nascimento_pessoa"])
            ? $_POST["valor_nascimento_pessoa"]
            : null;

        $recebe_sexo_pessoa = !empty($_POST["valor_sexo_pessoa"])
            ? $_POST["valor_sexo_pessoa"]
            : null;

        $recebe_telefone_pessoa = !empty($_POST["valor_telefone_pessoa"])
            ? $_POST["valor_telefone_pessoa"]
            : null;

        $recebe_data_cadastro_pessoa = !empty($_POST["valor_data_cadastro_pessoa"])
            ? $_POST["valor_data_cadastro_pessoa"]
            : null;

        $recebe_whatsapp_pessoa = !empty($_POST["valor_whatsapp_pessoa"])
            ? $_POST["valor_whatsapp_pessoa"]
            : null;

        $recebe_empresa_id_pessoa = $_SESSION["empresa_id"];

        // $recebe_cargo_pessoa = $_POST["valor_cargo_pessoa"];
        // $recebe_cbo_pessoa = $_POST["valor_cbo_pessoa"];
        // $recebe_idade_pessoa = $_POST["valor_idade_pessoa"];
        // $recebe_endereco_pessoa = $_POST["valor_endereco_pessoa"];
        // $recebe_numero_pessoa = $_POST["valor_numero_pessoa"];
        // $recebe_complemento_pessoa = $_POST["valor_complemento_pessoa"];
        // $recebe_bairro_pessoa = $_POST["valor_bairro_pessoa"];
        // $recebe_cep_pessoa = $_POST["valor_cep_pessoa"];
        // $recebe_id_cidade_pessoa = $_POST["valor_id_cidade_pessoa"];
        // $recebe_email_pessoa = $_POST["valor_email_pessoa"];
        // $recebe_senha_pessoa = $_POST["valor_senha_pessoa"];
        // $recebe_nivel_acesso_pessoa = $_POST["valor_nivel_acesso_pessoa"];
        // $recebe_data_cadastro_pessoa = $_POST["valor_data_cadastro_pessoa"];
        // $recebe_empresa_id_cadastro_pessoa = $_POST["valor_empresa_id"];

        $instrucao_cadastra_pessoa =
            "insert into pessoas(nome,empresa_id,cpf,telefone,whatsapp,nascimento,sexo,created_at,updated_at)values(:recebe_nome_pessoa,:recebe_empresa_id,:recebe_cpf_pessoa,
        :recebe_telefone_pessoa,:recebe_whatsapp_pessoa,:recebe_nascimento_pessoa,:recebe_sexo_pessoa,:recebe_created_at,:recebe_updated_at)";
        $comando_cadastra_pessoa = $pdo->prepare($instrucao_cadastra_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_nome_pessoa", $recebe_nome_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_empresa_id", $recebe_empresa_id_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_cpf_pessoa", $recebe_cpf_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_telefone_pessoa", $recebe_telefone_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_whatsapp_pessoa", $recebe_whatsapp_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_nascimento_pessoa", $recebe_nascimento_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_sexo_pessoa", $recebe_sexo_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_created_at", $recebe_data_cadastro_pessoa);
        $comando_cadastra_pessoa->bindValue(":recebe_updated_at", $recebe_data_cadastro_pessoa);
        $comando_cadastra_pessoa->execute();
        $resultado_cadastra_pessoa = $pdo->lastInsertId();

        echo json_encode($resultado_cadastra_pessoa);
    } else if ($recebe_processo_pessoa === "alterar_pessoa") {
        $recebe_nome_pessoa_alterar = $_POST["valor_nome_pessoa"];
        $recebe_cpf_pessoa_alterar = $_POST["valor_cpf_pessoa"];
        $recebe_nascimento_pessoa_alterar = $_POST["valor_nascimento_pessoa"];
        $recebe_sexo_pessoa_alterar = $_POST["valor_sexo_pessoa"];
        $recebe_telefone_pessoa_alterar = $_POST["valor_telefone_pessoa"];
        $recebe_whatsapp_pessoa_alterar = $_POST["valor_whatsapp_pessoa"];
        $recebe_data_cadastro_pessoa_alterar = $_POST["valor_data_cadastro_pessoa"];
        $recebe_id_pessoa_alterar = $_POST["valor_id_pessoa"];

        $recebe_empresa_id_pessoa_alterar = $_SESSION["empresa_id"];

        $instrucao_alterar_pessoa =
            "update pessoas set nome = :recebe_nome_pessoa_alterar,cpf = :recebe_cpf_pessoa_alterar,telefone = :recebe_telefone_pessoa_alterar,
        whatsapp = :recebe_whatsapp_pessoa_alterar,nascimento = :recebe_nascimento_pessoa_alterar,sexo = :recebe_sexo_pessoa_alterar,
        updated_at = :recebe_updated_at_pessoa_alterar where id = :recebe_id_pessoa_alterar and empresa_id = :recebe_empresa_id_pessoa_alterar";
        $comando_alterar_pessoa = $pdo->prepare($instrucao_alterar_pessoa);
        $comando_alterar_pessoa->bindValue(":recebe_nome_pessoa_alterar", $recebe_nome_pessoa_alterar);
        $comando_alterar_pessoa->bindValue(":recebe_cpf_pessoa_alterar", $recebe_cpf_pessoa_alterar);
        $comando_alterar_pessoa->bindValue(":recebe_telefone_pessoa_alterar", $recebe_telefone_pessoa_alterar);
        $comando_alterar_pessoa->bindValue(":recebe_whatsapp_pessoa_alterar", $recebe_whatsapp_pessoa_alterar);
        $comando_alterar_pessoa->bindValue(":recebe_nascimento_pessoa_alterar", $recebe_nascimento_pessoa_alterar);
        $comando_alterar_pessoa->bindValue(":recebe_sexo_pessoa_alterar", $recebe_sexo_pessoa_alterar);
        $comando_alterar_pessoa->bindValue(":recebe_updated_at_pessoa_alterar", $recebe_data_cadastro_pessoa_alterar);
        $comando_alterar_pessoa->bindValue(":recebe_id_pessoa_alterar", $recebe_id_pessoa_alterar);
        $comando_alterar_pessoa->bindValue(":recebe_empresa_id_pessoa_alterar", $recebe_empresa_id_pessoa_alterar);
        $resultado_alterar_pessoa = $comando_alterar_pessoa->execute();
        echo json_encode($resultado_alterar_pessoa);
    } else if ($recebe_processo_pessoa === "excluir_pessoa") {
        $recebe_codigo_excluir_pessoa = $_POST["valor_id_pessoa"];

        $recebe_id_empresa_excluir_pessoa = $_SESSION["empresa_id"];

        $instrucao_excluir_pessoa =
            "delete from pessoas where id = :recebe_id_pessoa_excluir and empresa_id = :recebe_id_empresa_pessoa_excluir";
        $comando_excluir_pessoa = $pdo->prepare($instrucao_excluir_pessoa);
        $comando_excluir_pessoa->bindValue(":recebe_id_pessoa_excluir", $recebe_codigo_excluir_pessoa);
        $comando_excluir_pessoa->bindValue(":recebe_id_empresa_pessoa_excluir", $recebe_id_empresa_excluir_pessoa);
        $resultado_excluir_pessoa = $comando_excluir_pessoa->execute();
        echo json_encode($resultado_excluir_pessoa);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $recebe_processo_pessoa = $_GET["processo_pessoa"];

    if ($recebe_processo_pessoa === "buscar_pessoas") {
        $recebe_id_empresa = $_SESSION["empresa_id"];
        $instrucao_busca_pessoas = "select * from pessoas where empresa_id = :recebe_empresa_id";
        $comando_buca_pessoas = $pdo->prepare($instrucao_busca_pessoas);
        $comando_buca_pessoas->bindValue(":recebe_empresa_id", $recebe_id_empresa);
        $comando_buca_pessoas->execute();
        $resultado_busca_pessoas = $comando_buca_pessoas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoas);
    } else if ($recebe_processo_pessoa === "buscar_informacoes_pessoa_alteracao") {
        $recebe_codigo_pessoa = $_GET["valor_codigo_pessoa_alteracao"];

        $recebe_id_empresa_pessoa = $_SESSION["empresa_id"];

        $instrucao_busca_informacoes_pessoa_alteracao =
            "select * from pessoas where id = :recebe_id_pessoa_alteracao and empresa_id = :recebe_empresa_id_pessoa_alteracao";
        $comando_busca_informacoes_pessoa_alteracao = $pdo->prepare($instrucao_busca_informacoes_pessoa_alteracao);
        $comando_busca_informacoes_pessoa_alteracao->bindValue(":recebe_id_pessoa_alteracao", $recebe_codigo_pessoa);
        $comando_busca_informacoes_pessoa_alteracao->bindValue(":recebe_empresa_id_pessoa_alteracao", $recebe_id_empresa_pessoa);
        $comando_busca_informacoes_pessoa_alteracao->execute();
        $resultado_busca_informacoes_pessoa_alteracao = $comando_busca_informacoes_pessoa_alteracao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_informacoes_pessoa_alteracao);
    } else if ($recebe_processo_pessoa === "buscar_informacoes_rapidas_pessoas") {
        $recebe_codigo_pessoa_informacoes_rapidas = $_GET["valor_codigo_pessoa_informacoes_rapidas"];

        $recebe_id_empresa_pessoa_informacoes_rapidas = $_SESSION["empresa_id"];

        $instrucao_busca_pessoa_informacoes_rapidas =
            "select * from pessoas where id = :recebe_id_pessoa_informacoes_rapidas and empresa_id = :recebe_empresa_id_pessoa_informacoes_rapidas";
        $comando_busca_pessoa_informacoes_rapidas = $pdo->prepare($instrucao_busca_pessoa_informacoes_rapidas);
        $comando_busca_pessoa_informacoes_rapidas->bindValue(":recebe_id_pessoa_informacoes_rapidas", $recebe_codigo_pessoa_informacoes_rapidas);
        $comando_busca_pessoa_informacoes_rapidas->bindValue(":recebe_empresa_id_pessoa_informacoes_rapidas", $recebe_id_empresa_pessoa_informacoes_rapidas);
        $comando_busca_pessoa_informacoes_rapidas->execute();
        $resultado_busca_pessoa_informacoes_rapidas = $comando_busca_pessoa_informacoes_rapidas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_pessoa_informacoes_rapidas);
    } else if ($recebe_processo_pessoa === "buscar_total_pessoas") {
        $recebe_id_empresa = $_SESSION["empresa_id"];
        $instrucao_busca_total_pessoas = "select count(id) as total from pessoas where empresa_id = :recebe_empresa_id";
        $comando_busca_total_pessoas = $pdo->prepare($instrucao_busca_total_pessoas);
        $comando_busca_total_pessoas->bindValue(":recebe_empresa_id", $recebe_id_empresa);
        $comando_busca_total_pessoas->execute();
        $resultado_busca_total_pessoas = $comando_busca_total_pessoas->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_total_pessoas);
    }
}
?>