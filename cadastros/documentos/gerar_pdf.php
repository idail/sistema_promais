<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET");

require __DIR__ . '/../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// RECEBE DADOS
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["html"]) || !isset($data["tipo"])) {
    die("Erro: HTML ou tipo não enviado.");
}

$html_recebido = $data["html"];

// var_dump($html_recebido);
// file_put_contents("debug_html_recebido.html", $html_recebido);
// exit;


$tipo = $data["tipo"];

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$options->set('httpContext', stream_context_create([
    'http' => [
        'follow_location' => true,
        'timeout' => 30,
        'header' => "User-Agent: Mozilla/5.0\r\n"
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false
    ]
]));

$dompdf = new Dompdf($options);


if ($tipo === "guia_encaminhamento") {

    // CSS EXCLUSIVO
    $css = '
    <style>
        body { font-family: Arial, sans-serif; background:#fff; }
        table { border-collapse:collapse; width:100%; font-size:12px; }
        th, td { border:1px solid #000; padding:4px; }
        .titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; }
        .section-title { background:#eaeaea; font-weight:bold; }
        .hospital-nome { font-weight:bold; text-decoration:underline; display:block !important;         /* quebra garantida */
    margin-bottom:4px !important;     /* espaço entre linhas */}
        .logo img, img.logo { max-width:80px !important; height:auto !important; }
    </style>
    ';

    // HTML FINAL
    $html_final = $css . $html_recebido;

    // GERA PDF
    $dompdf->loadHtml($html_final);
    $dompdf->setPaper("A4", "portrait");
    $dompdf->render();

    // NOME ÚNICO
    $nome = "guia_encaminhamento_" . time() . ".pdf";
    $caminho = __DIR__ . "/$nome";

    file_put_contents($caminho, $dompdf->output());

    echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
    exit;
}else if($tipo === "aso")
{
    // CSS EXCLUSIVO
    $css = '
    <style>
        body { font-family: Arial, sans-serif; background:#fff; }
        table { border-collapse:collapse; width:100%; font-size:12px; }
        th, td { border:1px solid #000; padding:4px; }
        .titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; }
        .section-title { background:#eaeaea; font-weight:bold; }
        .hospital-nome { font-weight:bold; text-decoration:underline; display:block !important;         /* quebra garantida */
    margin-bottom:4px !important;     /* espaço entre linhas */}
        .logo img, img.logo { max-width:80px !important; height:auto !important; }

        /* 🔥 Ajuste correto da assinatura para o tamanho da tela */
    .assinatura {
        width: 45mm;
        height: 12mm;
        border-bottom: 1px solid #000;
        display: block;
        margin: 0 auto -2mm !important;
    }
    </style>
    ';

    // HTML FINAL
    $html_final = $css . $html_recebido;

    // GERA PDF
    $dompdf->loadHtml($html_final);
    $dompdf->setPaper("A4", "portrait");
    $dompdf->render();

    // NOME ÚNICO
    $nome = "aso_" . time() . ".pdf";
    $caminho = __DIR__ . "/$nome";

    file_put_contents($caminho, $dompdf->output());

    echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
    exit;
}else if($tipo === "prontuario_medico")
{
    // CSS EXCLUSIVO
    $css = '
    <style>
        body { font-family: Arial, sans-serif; background:#fff; }
        table { border-collapse:collapse; width:100%; font-size:12px; }
        th, td { border:1px solid #000; padding:4px; }
        .titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; }
        .section-title { background:#eaeaea; font-weight:bold; }
        .hospital-nome { font-weight:bold; text-decoration:underline; display:block !important;         /* quebra garantida */
    margin-bottom:4px !important;     /* espaço entre linhas */}
        .logo img, img.logo { max-width:80px !important; height:auto !important; }

        /* 🔥 Ajuste correto da assinatura para o tamanho da tela */
    .assinatura {
        width: 45mm;
        height: 12mm;
        border-bottom: 1px solid #000;
        display: block;
        margin: 0 auto -2mm !important;
    }
    </style>
    ';

    // HTML FINAL
    $html_final = $css . $html_recebido;

    // GERA PDF
    $dompdf->loadHtml($html_final);
    $dompdf->setPaper("A4", "portrait");
    $dompdf->render();

    // NOME ÚNICO
    $nome = "prontuario_medico_" . time() . ".pdf";
    $caminho = __DIR__ . "/$nome";

    file_put_contents($caminho, $dompdf->output());

    echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
    exit;
}
?>