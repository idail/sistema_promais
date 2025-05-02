<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

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

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $recebe_processo_empresa = $_POST["processo_empresa"];
    if($recebe_processo_empresa === "inserir_empresa")
    {
        $recebe_nome_fantasia_empresa = $_POST["valor_nome_fantasia_empresa"];
        $recebe_cnpj_empresa = $_POST["valor_cnpj_empresa"];
        $recebe_endereco_empresa = $_POST["valor_endereco_empresa"];
        $recebe_telefone_empresa = $_POST["valor_telefone_empresa"];
        $recebe_email_empresa = $_POST["valor_email_empresa"];
        $recebe_id_cidade_empresa = $_POST["valor_id_cidade"];
        $recebe_chave_id_empresa = $_SESSION["user_plan"];

        $instrucao_cadastra_empresa = "insert into empresas(nome,cnpj,endereco,id_cidade,telefone,email,chave_id)values
        (:recebe_nome_empresa,:recebe_cnpj_empresa,:recebe_endereco_empresa,:recebe_id_cidade_empresa,:recebe_telefone_empresa,
        :recebe_email_empresa,:recebe_chave_id_empresa)";
        $comando_cadastra_empresa = $pdo->prepare($instrucao_cadastra_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_nome_empresa",$recebe_nome_fantasia_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_cnpj_empresa",$recebe_cnpj_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_endereco_empresa",$recebe_endereco_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_id_cidade_empresa",$recebe_id_cidade_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_telefone_empresa",$recebe_telefone_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_email_empresa",$recebe_email_empresa);
        $comando_cadastra_empresa->bindValue(":recebe_chave_id_empresa",$recebe_chave_id_empresa);
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
                    $comando_cadastra_relacao_medicos_empresas->bindValue(":recebe_empresa_id",$valores_id_cadastramento_empresa[$i]);
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
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $recebe_processo_empresa = $_GET["processo_empresa"];

    if($recebe_processo_empresa === "buscar_empresas")
    {
        $instrucao_busca_empresas = "select * from empresas";
        $comando_buca_empresas = $pdo->prepare($instrucao_busca_empresas);
        $comando_buca_empresas->execute();
        $resultado_busca_empresas = $comando_buca_empresas->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado_busca_empresas);
    }
}
?>