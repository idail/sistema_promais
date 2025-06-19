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
    $recebe_processo_empresa = $_POST["processo_empresa"];
    if($recebe_processo_empresa === "inserir_empresa")
    {
        $recebe_data_cadastro_empresa = $_POST["valor_data_cadastro_empresa"];
        $recebe_nome_fantasia_empresa = $_POST["valor_nome_fantasia_empresa"];
        $recebe_cnpj_empresa = $_POST["valor_cnpj_empresa"];
        $recebe_endereco_empresa = $_POST["valor_endereco_empresa"];
        $recebe_telefone_empresa = $_POST["valor_telefone_empresa"];
        $recebe_email_empresa = $_POST["valor_email_empresa"];
        $recebe_id_cidade_empresa = $_POST["valor_id_cidade"];
        $recebe_id_estado_empresa = isset($_POST["valor_id_estado"]) ? $_POST["valor_id_estado"] : '';
        $recebe_razao_social_empresa = $_POST["valor_razao_social_empresa"];
        $recebe_bairro_empresa = $_POST["valor_bairro_empresa"];
        $recebe_cep_empresa = $_POST["valor_cep_empresa"];
        $recebe_complemento_empresa = $_POST["valor_complemento_empresa"];
        $recebe_nome_contabilidade = $_POST["valor_nome_contabilidade"];
        $recebe_email_contabilidade = $_POST["valor_email_contabilidade"];
        $recebe_chave_id_empresa = $_SESSION["user_plan"];
        $recebe_empresa_id = $_POST["valor_empresa_id"];

        // echo json_encode($recebe_data_cadastro_empresa);

        // $informacoes = "nome fantasia empresa:".$recebe_nome_fantasia_empresa."\n 
        // cnpj empresa:".$recebe_cnpj_empresa."\n endereco empresa:".$recebe_endereco_empresa.".n 
        // telefone empresa:".$recebe_telefone_empresa."\n
        // email empresa:".$recebe_email_empresa."\n id cidade empresa:".$recebe_id_cidade_empresa."\n
        // razao social empresa:".$recebe_razao_social_empresa."\n bairro empresa:".$recebe_bairro_empresa."\n
        // cep empresa:".$recebe_cep_empresa."\n complemento empresa:".$recebe_complemento_empresa."\n
        // chave id empresa:".$recebe_chave_id_empresa;

        // echo json_encode($informacoes);

        $instrucao_cadastra_empresa = "insert into empresas_novas(nome,empresa_id,cnpj,endereco,id_cidade,id_estado,telefone,email,chave_id,razao_social
        ,bairro,cep,complemento,nome_contabilidade,email_contabilidade,created_at,updated_at)values(:recebe_nome_empresa,:recebe_empresa_id,:recebe_cnpj_empresa,:recebe_endereco_empresa,
        :recebe_id_cidade_empresa,:recebe_id_estado_empresa,:recebe_telefone_empresa,
        :recebe_email_empresa,:recebe_chave_id_empresa,:recebe_razao_social,:recebe_bairro,:recebe_cep,
        :recebe_complemento,:recebe_nome_contabilidade,:recebe_email_contabilidade,:created_at,:updated_at)";
        $comando_cadastra_empresa = $pdo->prepare($instrucao_cadastra_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_nome_empresa",$recebe_nome_fantasia_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_empresa_id",$recebe_empresa_id);
        $comando_cadastra_empresa->bindValue(":recebe_cnpj_empresa",$recebe_cnpj_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_endereco_empresa",$recebe_endereco_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_id_cidade_empresa",$recebe_id_cidade_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_id_estado_empresa",$recebe_id_estado_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_telefone_empresa",$recebe_telefone_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_email_empresa",$recebe_email_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_chave_id_empresa",$recebe_chave_id_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_razao_social",$recebe_razao_social_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_bairro",$recebe_bairro_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_cep",$recebe_cep_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_complemento",$recebe_complemento_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_nome_contabilidade",$recebe_nome_contabilidade);
        $comando_cadastra_empresa->bindValue(":recebe_email_contabilidade",$recebe_email_contabilidade);
        $comando_cadastra_empresa->bindValue(":created_at",$recebe_data_cadastro_empresa);
        $comando_cadastra_empresa->bindValue(":updated_at",$recebe_data_cadastro_empresa);
        $comando_cadastra_empresa->execute();
        $recebe_ultimo_codigo_gerado_cadastramento_empresa = $pdo->lastInsertId();

        if(!empty($_POST["valor_medico_coordenador_empresa"]))
        {
            if(count($_POST["valor_medico_coordenador_empresa"]) > 0)
            {
                $recebe_id_medico_associado_empresa = $_POST["valor_medico_coordenador_empresa"];
                
                $valores_id_cadastramento_empresa = array();

                for ($i = 0; $i < count($recebe_id_medico_associado_empresa); $i++) 
                { 
                    array_push($valores_id_cadastramento_empresa,$recebe_ultimo_codigo_gerado_cadastramento_empresa);
                }

                $data_hora_atual = date("Y-m-d H:i:s");

                for ($i=0; $i < count($recebe_id_medico_associado_empresa); $i++)
                { 
                    $instrucao_cadastra_relacao_medicos_empresas = 
                    "insert into medicos_empresas(empresa_id,medico_id,status)
                    values(:recebe_empresa_id,:recebe_medico_id,:recebe_status)";
                    $comando_cadastra_relacao_medicos_empresas = $pdo->prepare($instrucao_cadastra_relacao_medicos_empresas);
                    // $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_empresa_id",$valores_id_cadastramento_empresa[$i]);
                    $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_empresa_id",$recebe_ultimo_codigo_gerado_cadastramento_empresa);
                    $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_medico_id",$recebe_id_medico_associado_empresa[$i]);
                    // $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_data_associacao",$data_hora_atual);
                    $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_status","Ativo");
                    $comando_cadastra_relacao_medicos_empresas->execute();
                    $recebe_ultimo_codigo_registrado_medicos_empresas = $pdo->lastInsertId();
                }
                echo json_encode($recebe_ultimo_codigo_registrado_medicos_empresas);
            }
        }else{
            echo json_encode($recebe_ultimo_codigo_gerado_cadastramento_empresa);
        }
    }else if($recebe_processo_empresa === "desvincular_medico_empresa")
    {
        $recebe_medico_empresa_id = $_POST["valor_medico_empresa_id"];

        $recebe_codigo_medico = $_POST["valor_codigo_medico"];

        $recebe_id_empresa = $_POST["valor_empresa_id"];

        $instrucao_desvincular_medico_empresa =
        "update medicos_empresas set status = :recebe_status_desvincular where id = :recebe_codigo_medicos_empresas_desvincular
        and medico_id = :recebe_codigo_medico_desvincular and empresa_id = :recebe_empresa_id";
        $comando_desvincular_medico_empresa = $pdo->prepare($instrucao_desvincular_medico_empresa);
        $comando_desvincular_medico_empresa->bindValue(":recebe_status_desvincular","Inativo");
        $comando_desvincular_medico_empresa->bindValue(":recebe_codigo_medicos_empresas_desvincular",$recebe_medico_empresa_id);
        $comando_desvincular_medico_empresa->bindValue(":recebe_codigo_medico_desvincular",$recebe_codigo_medico);
        $comando_desvincular_medico_empresa->bindValue(":recebe_empresa_id",$recebe_id_empresa);
        $resultado_desvincular_medico_empresa = $comando_desvincular_medico_empresa->execute();
        echo json_encode($resultado_desvincular_medico_empresa);
    }else if($recebe_processo_empresa === "alterar_empresa")
    {
        $recebe_nome_fantasia_empresa_alterar = $_POST["valor_nome_fantasia_empresa"];
        $recebe_cnpj_empresa_alterar = $_POST["valor_cnpj_empresa"];
        $recebe_endereco_empresa_alterar = $_POST["valor_endereco_empresa"];
        $recebe_telefone_empresa_alterar = $_POST["valor_telefone_empresa"];
        $recebe_email_empresa_alterar = $_POST["valor_email_empresa"];
        $recebe_id_cidade_empresa_alterar = $_POST["valor_id_cidade"];
        $recebe_id_estado_empresa_alterar = isset($_POST["valor_id_estado"]) ? $_POST["valor_id_estado"] : '';
        $recebe_razao_social_empresa_alterar = $_POST["valor_razao_social_empresa"];
        $recebe_bairro_empresa_alterar = $_POST["valor_bairro_empresa"];
        $recebe_cep_empresa_alterar = $_POST["valor_cep_empresa"];
        $recebe_complemento_empresa_alterar = $_POST["valor_complemento_empresa"];
        $recebe_nome_contabilidade_alterar = $_POST["valor_nome_contabilidade"];
        $recebe_email_contabilidade_alterar = $_POST["valor_email_contabilidade"];
        $recebe_chave_id_empresa_alterar = $_SESSION["user_plan"];
        $recebe_codigo_empresa_alterar = $_POST["valor_id_empresa"];

        $recebe_id_empresa_aterar = $_SESSION["empresa_id"];

        $instrucao_altera_empresa = 
        "update empresas_novas set nome = :recebe_nome_alterar,cnpj = :recebe_cnpj_alterar,endereco = :recebe_endereco_alterar,id_cidade = :recebe_id_cidade_alterar,
        id_estado = :recebe_id_estado_alterar,telefone = :recebe_telefone_alterar,email = :recebe_email_alterar,chave_id = :recebe_chave_id_alterar,razao_social = :recebe_razao_social_alterar,
        bairro = :recebe_bairro_alterar,cep = :recebe_cep_alterar,complemento = :recebe_complemento_alterar,
        nome_contabilidade = :recebe_nome_contabilidade_alterar,email_contabilidade = :recebe_email_contabilidade_alterar 
        where id = :recebe_id_empresa_alterar and empresa_id = :recebe_empresa_id";
        $comando_altera_empresa = $pdo->prepare($instrucao_altera_empresa);
        $comando_altera_empresa->bindValue(":recebe_nome_alterar",$recebe_nome_fantasia_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_cnpj_alterar",$recebe_cnpj_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_endereco_alterar",$recebe_endereco_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_id_cidade_alterar",$recebe_id_cidade_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_id_estado_alterar",$recebe_id_estado_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_telefone_alterar",$recebe_telefone_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_email_alterar",$recebe_email_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_chave_id_alterar",$recebe_chave_id_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_razao_social_alterar",$recebe_razao_social_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_bairro_alterar",$recebe_bairro_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_cep_alterar",$recebe_cep_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_complemento_alterar",$recebe_complemento_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_nome_contabilidade_alterar",$recebe_nome_contabilidade_alterar);
        $comando_altera_empresa->bindValue(":recebe_email_contabilidade_alterar",$recebe_email_contabilidade_alterar);
        $comando_altera_empresa->bindValue(":recebe_id_empresa_alterar",$recebe_codigo_empresa_alterar);
        $comando_altera_empresa->bindValue(":recebe_empresa_id",$recebe_id_empresa_aterar);
        $resultado_altera_empresa = $comando_altera_empresa->execute();

        if(!empty($_POST["valor_medico_coordenador_empresa"]))
        {
            if(count($_POST["valor_medico_coordenador_empresa"]) > 0)
            {
                $recebe_id_medico_associado_empresa = $_POST["valor_medico_coordenador_empresa"];
                
                $valores_id_cadastramento_empresa = array();

                for ($i = 0; $i < count($recebe_id_medico_associado_empresa); $i++) 
                { 
                    array_push($valores_id_cadastramento_empresa,$recebe_id_empresa_aterar);
                }

                $data_hora_atual = date("Y-m-d H:i:s");

                for ($i=0; $i < count($recebe_id_medico_associado_empresa); $i++)
                { 
                    $instrucao_cadastra_relacao_medicos_empresas = 
                    "insert into medicos_empresas(empresa_id,medico_id,status)
                    values(:recebe_empresa_id,:recebe_medico_id,:recebe_status)";
                    $comando_cadastra_relacao_medicos_empresas = $pdo->prepare($instrucao_cadastra_relacao_medicos_empresas);
                    // $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_empresa_id",$valores_id_cadastramento_empresa[$i]);
                    $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_empresa_id",$recebe_codigo_empresa_alterar);
                    $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_medico_id",$recebe_id_medico_associado_empresa[$i]);
                    // $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_data_associacao",$data_hora_atual);
                    $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_status","Ativo");
                    $comando_cadastra_relacao_medicos_empresas->execute();
                    $recebe_ultimo_codigo_registrado_medicos_empresas = $pdo->lastInsertId();
                }
                echo json_encode($recebe_ultimo_codigo_registrado_medicos_empresas);
            }
        }else{
            echo json_encode($resultado_altera_empresa);
        }
    }else if($recebe_processo_empresa === "excluir_empresa")
    {
        $recebe_codigo_empresa_excluir = $_POST["valor_id_empresa"];
        $recebe_id_empresa_excluir = $_SESSION["empresa_id"];

        if(!empty($recebe_id_empresa_excluir))
        {
            $instrucao_excluir_empresa = "delete from empresas_novas where id = :recebe_id_empresa_excluir and empresa_id = :recebe_empresa_id";
            $comando_excluir_empresa = $pdo->prepare($instrucao_excluir_empresa);
            $comando_excluir_empresa->bindValue(":recebe_id_empresa_excluir",$recebe_codigo_empresa_excluir);
            $comando_excluir_empresa->bindValue(":recebe_empresa_id",$recebe_id_empresa_excluir);
            $resultado_excluir_empresa = $comando_excluir_empresa->execute();
            echo json_encode($resultado_excluir_empresa);   
        }
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_empresa = $_GET["processo_empresa"];

    if($recebe_processo_empresa === "buscar_empresas")
    {
        $recebe_id_empresa = $_SESSION["empresa_id"];
        $instrucao_busca_empresas = "select * from empresas_novas where empresa_id = :recebe_id_empresa";
        $comando_buca_empresas = $pdo->prepare($instrucao_busca_empresas);
        $comando_buca_empresas->bindValue(":recebe_id_empresa",$recebe_id_empresa);
        $comando_buca_empresas->execute();
        $resultado_busca_empresas = $comando_buca_empresas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_empresas);
    }else if($recebe_processo_empresa === "buscar_cidade_empresa")
    {
        $recebe_codigo_empresa = $_GET["valor_id_empresa"];
        $recebe_id_empresa = $_SESSION["empresa_id"];

        $instrucao_busca_cidade_empresa_alteracao = "SELECT c.id, c.nome
        FROM cidades c
        JOIN empresas_novas en ON en.id_cidade = c.id
        WHERE en.id = :recebe_codigo_empresa_alteracao and en.empresa_id = :recebe_empresa_id";
        $comando_busca_empresa_cidade_alteracao = $pdo->prepare($instrucao_busca_cidade_empresa_alteracao);
        $comando_busca_empresa_cidade_alteracao->bindValue(":recebe_codigo_empresa_alteracao",$recebe_codigo_empresa);
        $comando_busca_empresa_cidade_alteracao->bindValue(":recebe_empresa_id",$recebe_id_empresa);
        $comando_busca_empresa_cidade_alteracao->execute();
        $resultado_busca_cidade_empresa_alteracao = $comando_busca_empresa_cidade_alteracao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_cidade_empresa_alteracao);
    }else if($recebe_processo_empresa === "buscar_informacoes_empresa_alteracao")
    {
        $recebe_codigo_empresa = $_GET["valor_codigo_empresa_alteracao"];
        $recebe_id_empresa = $_SESSION["empresa_id"];

        $instrucao_busca_informacoes_empresa_alteracao = 
        "select * from empresas_novas where id = :recebe_id_empresa_alteracao and empresa_id = :recebe_id_empresa";
        $comando_busca_informacoes_empresa_alteracao = $pdo->prepare($instrucao_busca_informacoes_empresa_alteracao);
        $comando_busca_informacoes_empresa_alteracao->bindValue(":recebe_id_empresa_alteracao",$recebe_codigo_empresa);
        $comando_busca_informacoes_empresa_alteracao->bindValue(":recebe_id_empresa",$recebe_id_empresa);
        $comando_busca_informacoes_empresa_alteracao->execute();
        $resultado_busca_informacoes_empresa_alteracao = $comando_busca_informacoes_empresa_alteracao->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_informacoes_empresa_alteracao);
    }else if($recebe_processo_empresa === "buscar_informacoes_rapidas_empresa")
    {
        $recebe_codigo_empresa_informacoes_rapidas = $_GET["valor_id_empresa_informacoes_rapidas"];
        $recebe_id_empresa = $_SESSION["empresa_id"];

        $instrucao_busca_empresa_informacoes_rapidas = "select * from empresas_novas where id = :recebe_id_empresa_informacoes_rapidas and empresa_id = :recebe_empresa_id";
        $comando_busca_empresa_informacoes_rapidas = $pdo->prepare($instrucao_busca_empresa_informacoes_rapidas);
        $comando_busca_empresa_informacoes_rapidas->bindValue(":recebe_id_empresa_informacoes_rapidas",$recebe_codigo_empresa_informacoes_rapidas);
        $comando_busca_empresa_informacoes_rapidas->bindValue(":recebe_empresa_id",$recebe_id_empresa);
        $comando_busca_empresa_informacoes_rapidas->execute();
        $resultado_busca_informacoes_rapidas_empresa = $comando_busca_empresa_informacoes_rapidas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_informacoes_rapidas_empresa);
    }else if($recebe_processo_empresa === "buscar_total_empresas")
    {
        $recebe_id_empresa = $_SESSION["empresa_id"];
        $instrucao_busca_total_empresas = "select COUNT(id) as total from empresas_novas where empresa_id = :recebe_empresa_id";
        $comando_busca_total_empresas = $pdo->prepare($instrucao_busca_total_empresas);
        $comando_busca_total_empresas->bindValue(":recebe_empresa_id",$recebe_id_empresa);
        $comando_busca_total_empresas->execute();
        $resultado_busca_total_empresas = $comando_busca_total_empresas->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_total_empresas);
    }
}
?>