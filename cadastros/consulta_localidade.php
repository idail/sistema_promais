<?php
header('Content-Type: application/json');

$cidade = isset($_GET['cidade']) ? trim($_GET['cidade']) : '';
$logradouro = isset($_GET['logradouro']) ? trim($_GET['logradouro']) : '';

if (empty($cidade) || empty($logradouro)) {
    echo json_encode(["error" => "Cidade e logradouro são obrigatórios"]);
    exit;
}

function consultarViaCep($uf, $cidade, $logradouro) {
    $ufEnc = urlencode($uf);
    $cidadeEnc = urlencode($cidade);
    $logradouroEnc = urlencode($logradouro);
    $url = "https://viacep.com.br/ws/$ufEnc/$cidadeEnc/$logradouroEnc/json/";
    $response = @file_get_contents($url);
    if ($response === false) return null;
    $data = json_decode($response, true);
    if (isset($data['erro'])) return null;
    return $data;
}

try {
    $cidadeEnc = urlencode($cidade);
    $ibgeURL = "https://servicodados.ibge.gov.br/api/v1/localidades/municipios?nome={$cidadeEnc}";
    $ibgeResponse = json_decode(file_get_contents($ibgeURL), true);

    if (empty($ibgeResponse)) {
        echo json_encode(["error" => "Cidade não encontrada no IBGE"]);
        exit;
    }

    $resultado = null;

    // Tenta para cada cidade (em diferentes estados) consultar ViaCEP com logradouro
    foreach ($ibgeResponse as $cidadeInfo) {
        $uf = $cidadeInfo['microrregiao']['mesorregiao']['UF']['sigla'];
        $estado = $cidadeInfo['microrregiao']['mesorregiao']['UF']['nome'];
        $cidadeNome = $cidadeInfo['nome'];

        $viacepData = consultarViaCep($uf, $cidadeNome, $logradouro);
        if ($viacepData && isset($viacepData[0]['cep'])) {
            // Achou um resultado válido
            $resultado = [
                "cidade" => $cidadeNome,
                "uf" => $uf,
                "estado" => $estado,
                "cep" => $viacepData[0]['cep']
            ];
            break;
        }
    }

    if ($resultado) {
        echo json_encode($resultado);
    } else {
        // Se não achou nenhum resultado
        echo json_encode([
            "cidade" => $cidade,
            "uf" => null,
            "estado" => null,
            "cep" => "CEP não encontrado"
        ]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Erro ao processar: " . $e->getMessage()]);
}
?>