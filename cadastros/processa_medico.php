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
        // $recebe_id_empresa = $_SESSION["empresa_id"];
        $instrucao_busca_medicos_associados_empresa = "SELECT DISTINCT m.id AS medico_id,me.id, m.nome AS nome_medico,m.cpf AS cpf FROM 
        medicos_empresas me JOIN medicos m ON me.medico_id = m.id WHERE me.status = 'Ativo' AND me.empresa_id = :recebe_id_empresa";
        $comando_busca_medicos_associados_empresa = $pdo->prepare($instrucao_busca_medicos_associados_empresa);
        $comando_busca_medicos_associados_empresa->bindValue(":recebe_id_empresa",$recebe_codigo_empresa_medicos_associados);
        $comando_busca_medicos_associados_empresa->execute();
        $resultado_busca_medicos_associados_empresa = $comando_busca_medicos_associados_empresa->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medicos_associados_empresa);
    }else if($recebe_processo_medico === "buscar_medicos")
    {
        $instrucao_busca_medicos = "select * from medicos";
        $comando_busca_medicos = $pdo->prepare($instrucao_busca_medicos);
        $comando_busca_medicos->execute();
        $resultado_busca_medicos = $comando_busca_medicos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medicos);
    }else if($recebe_processo_medico === "buscar_informacoes_medico_alteracao")
    {
        $recebe_id_medico = $_GET["valor_codigo_medico_alteracao"];

        $instrucao_busca_informacoes_medico_alteracao = 
        "select * from medicos where id = :recebe_id_medico_alteracao";
        $comando_busca_informacoes_medico_alteracao = $pdo->prepare($instrucao_busca_informacoes_medico_alteracao);
        $comando_busca_informacoes_medico_alteracao->bindValue(":recebe_id_medico_alteracao",$recebe_id_medico);
        $comando_busca_informacoes_medico_alteracao->execute();
        $resultado_busca_informacoes_medico_alteracao = $comando_busca_informacoes_medico_alteracao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_informacoes_medico_alteracao);
    }else if($recebe_processo_medico === "buscar_total_medicos")
    {
        $recebe_id_empresa = $_SESSION["empresa_id"];
        $instrucao_busca_total_medicos = "select count(id) as total from medicos where empresa_id = :recebe_empresa_id";
        $comando_busca_total_medicos = $pdo->prepare($instrucao_busca_total_medicos);
        $comando_busca_total_medicos->bindValue(":recebe_empresa_id",$recebe_id_empresa);
        $comando_busca_total_medicos->execute();
        $resultado_busca_total_medicos = $comando_busca_total_medicos->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_total_medicos);
    }else if($recebe_processo_medico === "buscar_informacoes_rapidas_medicos")
    {
        $recebe_codigo_medico_informacoes_rapidas = $_GET["valor_codigo_medico_informacoes_rapidas"];

        $recebe_id_empresa_medico_informacoes_rapidas = $_SESSION["empresa_id"];

        $instrucao_busca_medico_informacoes_rapidas = 
        "select * from medicos where id = :recebe_id_medicos_informacoes_rapidas and empresa_id = :recebe_empresa_id_medicos_informacoes_rapidas";
        $comando_busca_medicos_informacoes_rapidas = $pdo->prepare($instrucao_busca_medico_informacoes_rapidas);
        $comando_busca_medicos_informacoes_rapidas->bindValue(":recebe_id_medicos_informacoes_rapidas",$recebe_codigo_medico_informacoes_rapidas);
        $comando_busca_medicos_informacoes_rapidas->bindValue(":recebe_empresa_id_medicos_informacoes_rapidas",$recebe_id_empresa_medico_informacoes_rapidas);
        $comando_busca_medicos_informacoes_rapidas->execute();
        $resultado_busca_medicos_informacoes_rapidas = $comando_busca_medicos_informacoes_rapidas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_medicos_informacoes_rapidas);
    }
}else if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $recebe_processo_medico = $_POST["processo_medico"];

    if($recebe_processo_medico === "inserir_medico")
    {
        $recebe_data_cadastro_medico = $_POST["valor_data_cadastro_medico"];
        $recebe_nome_medico = $_POST["valor_nome_medico"];
        $recebe_cpf_medico = $_POST["valor_cpf_medico"];
        $recebe_crm_medico = $_POST["valor_crm_medico"];
        $recebe_uf_crm_medico = !empty($_POST["valor_uf_crm_medico"]) ? $_POST["valor_uf_crm_medico"] : null;
        $recebe_especialidade_medico = !empty($_POST["valor_especialidade_medico"]) ? $_POST["valor_especialidade_medico"] : null;
        $recebe_rqe_medico = !empty($_POST["valor_rqe_medico"]) ? $_POST["valor_rqe_medico"] : null;
        $recebe_uf_rqe_medico = !empty($_POST["valor_uf_rqe_medico"]) ? $_POST["valor_uf_rqe_medico"] : null;
        $recebe_nascimento_medico = !empty($_POST["valor_nascimento_medico"]) ? $_POST["valor_nascimento_medico"] : null;
        $recebe_sexo_medico = !empty($_POST["valor_sexo_medico"]) ? $_POST["valor_sexo_medico"] : null;
        $recebe_contato_medico = !empty($_POST["valor_contato_medico"]) ? $_POST["valor_contato_medico"] : null;
        $recebe_empresa_id_medico = $_POST["valor_empresa_id_medico"];
        
        // $recebe_uf_rg_medico = $_POST["valor_uf_rg_medico"];
        // $recebe_documento_classe_medico = $_POST["valor_documento_classe_medico"];
        // $recebe_n_documento_classe_medico = $_POST["valor_n_documento_classe_medico"];
        // $recebe_uf_documento_classe_medico = $_POST["valor_uf_documento_classe_medico"];
        
        
        
        // $recebe_numero_rg_medico = $_POST["valor_numero_rg_medico"];
        

        $instrucao_cadastra_medico = "insert into medicos(empresa_id,nome,cpf,nascimento,sexo,
        especialidade,crm,uf_crm,rqe,uf_rqe,contato,status,created_at,updated_at)
        values(:recebe_empresa_id,:recebe_nome,:recebe_cpf,:recebe_nascimento,:recebe_sexo,:recebe_especialidade,
        :recebe_crm,:recebe_uf_crm,:recebe_rqe,:recebe_uf_rqe,:recebe_contato,
        :recebe_status,:recebe_created_at,:recebe_updated_at)";
        $comando_cadastra_medico = $pdo->prepare($instrucao_cadastra_medico);
        $comando_cadastra_medico->bindValue(":recebe_empresa_id",$recebe_empresa_id_medico);
        $comando_cadastra_medico->bindValue(":recebe_nome",$recebe_nome_medico);
        $comando_cadastra_medico->bindValue(":recebe_cpf",$recebe_cpf_medico);
        
        if ($recebe_nascimento_medico === null) {
            $comando_cadastra_medico->bindValue(":recebe_nascimento", null, PDO::PARAM_NULL);
        } else {
            $comando_cadastra_medico->bindValue(":recebe_nascimento", $recebe_nascimento_medico);
        }

        $comando_cadastra_medico->bindValue(":recebe_sexo",$recebe_sexo_medico);
        $comando_cadastra_medico->bindValue(":recebe_especialidade",$recebe_especialidade_medico);

        $comando_cadastra_medico->bindValue(":recebe_crm",$recebe_crm_medico);
        $comando_cadastra_medico->bindValue(":recebe_uf_crm",$recebe_uf_crm_medico);
        $comando_cadastra_medico->bindValue(":recebe_rqe",$recebe_rqe_medico);
        $comando_cadastra_medico->bindValue(":recebe_uf_rqe",$recebe_uf_rqe_medico);
        $comando_cadastra_medico->bindValue(":recebe_contato",$recebe_contato_medico);
        $comando_cadastra_medico->bindValue(":recebe_status","Ativo");
        $comando_cadastra_medico->bindValue(":recebe_created_at",$recebe_data_cadastro_medico);
        $comando_cadastra_medico->bindValue(":recebe_updated_at",$recebe_data_cadastro_medico);
        $comando_cadastra_medico->execute();
        $recebe_ultimo_codigo_registrado_cadastra_medico = $pdo->lastInsertId();
        echo json_encode($recebe_ultimo_codigo_registrado_cadastra_medico);
    }else if($recebe_processo_medico === "alterar_medico")
    {
        $recebe_data_cadastro_medico_alterar = $_POST["valor_data_cadastro_medico"];
        $recebe_nome_medico_alterar = $_POST["valor_nome_medico"];
        $recebe_cpf_medico_alterar = $_POST["valor_cpf_medico"];
        $recebe_crm_medico_alterar = $_POST["valor_crm_medico"];
        $recebe_uf_crm_medico_alterar = !empty($_POST["valor_uf_crm_medico"]) ? $_POST["valor_uf_crm_medico"] : null;
        $recebe_especialidade_medico_alterar = !empty($_POST["valor_especialidade_medico"]) ? $_POST["valor_especialidade_medico"] : null;
        $recebe_rqe_medico_alterar = !empty($_POST["valor_rqe_medico"]) ? $_POST["valor_rqe_medico"] : null;
        $recebe_uf_rqe_medico_alterar = !empty($_POST["valor_uf_rqe_medico"]) ? $_POST["valor_uf_rqe_medico"] : null;
        $recebe_nascimento_medico_alterar = !empty($_POST["valor_nascimento_medico"]) ? $_POST["valor_nascimento_medico"] : null;
        $recebe_sexo_medico_alterar = !empty($_POST["valor_sexo_medico"]) ? $_POST["valor_sexo_medico"] : null;
        $recebe_contato_medico_alterar = !empty($_POST["valor_contato_medico"]) ? $_POST["valor_contato_medico"] : null;
        $recebe_empresa_id_medico_alterar = $_POST["valor_empresa_id_medico"];
        $recebe_id_medico_alterar = $_POST["valor_id_medico"];

        $instrucao_altera_medico = 
        "update medicos set nome = :recebe_nome,cpf = :recebe_cpf,nascimento = :recebe_nascimento,sexo = :recebe_sexo,especialidade = :recebe_especialidade,
        crm = :recebe_crm,uf_crm = :recebe_uf_crm,rqe = :recebe_rqe,uf_rqe = :recebe_uf_rqe,contato = :recebe_contato,created_at = :recebe_created_at,
        updated_at = :recebe_updated_at where id = :recebe_id and empresa_id = :recebe_empresa_id";
        $comando_altera_medico = $pdo->prepare($instrucao_altera_medico);
        $comando_altera_medico->bindValue(":recebe_nome",$recebe_nome_medico_alterar).
        $comando_altera_medico->bindValue(":recebe_cpf",$recebe_cpf_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_nascimento",$recebe_nascimento_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_sexo",$recebe_sexo_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_especialidade",$recebe_especialidade_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_crm",$recebe_crm_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_uf_crm",$recebe_uf_crm_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_rqe",$recebe_rqe_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_uf_rqe",$recebe_uf_rqe_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_contato",$recebe_contato_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_created_at",$recebe_data_cadastro_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_updated_at",$recebe_data_cadastro_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_id",$recebe_id_medico_alterar);
        $comando_altera_medico->bindValue(":recebe_empresa_id",$recebe_empresa_id_medico_alterar);
        $resultado_altera_medico = $comando_altera_medico->execute();
        echo json_encode($resultado_altera_medico);
    }else if($recebe_processo_medico === "excluir_medico")
    {
        $recebe_codigo_excluir_medico = $_POST["valor_id_medico"];

        $recebe_id_empresa_excluir_medico = $_SESSION["empresa_id"];

        $instrucao_excluir_medico = 
        "delete from medicos where id = :recebe_id_medico_excluir and empresa_id = :recebe_empresa_id_medico_excluir";
        $comando_excluir_medico = $pdo->prepare($instrucao_excluir_medico);
        $comando_excluir_medico->bindValue(":recebe_id_medico_excluir",$recebe_codigo_excluir_medico);
        $comando_excluir_medico->bindValue(":recebe_empresa_id_medico_excluir",$recebe_id_empresa_excluir_medico);
        $resultado_excluir_medico = $comando_excluir_medico->execute();
        echo json_encode($resultado_excluir_medico);
    }
}
?>