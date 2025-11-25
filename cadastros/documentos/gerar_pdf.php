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
    // CSS exclusivo
// $css = '
// <style>
// body { 
//     font-family: Arial, sans-serif; 
//     background: #fff; 
//     margin: 0;
//     padding: 0;
//     font-size: 10px; /* Fonte menor para caber na página */
// }

// /* Evita que o conteúdo do formulário quebre */
// .guia-container {
//     page-break-inside: avoid !important;
//     break-inside: avoid !important;
    
//     width: 100%;
//     padding: 2px 5px; /* Padding reduzido */
//     margin: 0;
//     line-height: 1.1; /* Linha mais compacta */
// }

// /* Tabelas */
// table { 
//     border-collapse: collapse; 
//     width: 100%; 
//     font-size: 10px; /* Fonte menor */
//     page-break-inside: avoid !important;
//     break-inside: avoid !important;
// }

// th, td { 
//     border: 1px solid #000; 
//     padding: 2px 3px; /* Padding menor */
//     page-break-inside: avoid !important;
//     break-inside: avoid !important;
// }

// /* Título da guia */
// .titulo-guia { 
//     background: #eaeaea; 
//     font-weight: bold; 
//     text-align: center; 
//     font-size: 11px; /* Fonte menor para títulos */
//     padding: 2px 0;
// }

// /* Seções */
// .section-title { 
//     background: #eaeaea; 
//     font-weight: bold; 
//     font-size: 10px;
//     padding: 1px 0;
// }

// /* Nome da clínica */
// .hospital-nome {
//     font-weight: bold;
//     text-decoration: underline;
//     display: block;
//     margin-bottom: 2px; /* Margin reduzida */
//     font-size: 10px;
// }

// /* LOGO */
// .logo img {
//     width: 80px !important; /* Leve redução para caber */
//     height: auto !important;
//     object-fit: contain;
//     max-height: 40px !important;
// }

// /* ASSINATURA */
// td img {
//     width: 120px !important;
//     max-height: 50px !important;
//     object-fit: contain;
//     display: block;
//     margin: 0 auto 2px auto !important;
// }

// /* Evita quebras em qualquer conteúdo */
// table, tr, td, th, div, p, span {
//     break-inside: avoid !important;
//     page-break-inside: avoid !important;
// }
// </style>
// ';

// CSS exclusivo
$css = '
<style>
body { 
    font-family: Arial, sans-serif; 
    background: #fff; 
    margin: 0;
    padding: 0;
    font-size: 10px; /* Fonte menor para caber na página */
}

/* Evita que o conteúdo do formulário quebre */
.guia-container {
    page-break-inside: avoid !important;
    break-inside: avoid !important;
    width: 100%;
    padding: 2px 5px; /* Padding reduzido */
    margin: 0;
    line-height: 1.1; /* Linha mais compacta */
}

/* Tabelas */
table { 
    border-collapse: collapse; 
    width: 100%; 
    font-size: 10px;
    table-layout: fixed; /* Garante que colspan ocupe a largura total */
    page-break-inside: avoid !important;
    break-inside: avoid !important;
}

/* Células */
th, td { 
    border: 1px solid #000; 
    padding: 2px 3px; /* Padding menor */
    word-wrap: break-word; /* Evita ultrapassar a largura */
    page-break-inside: avoid !important;
    break-inside: avoid !important;
}

/* Título da guia */
.titulo-guia { 
    background: #eaeaea; 
    font-weight: bold; 
    text-align: center; 
    font-size: 11px; 
    padding: 2px 4px;
}

/* Seções */
.section-title { 
    background: #eaeaea; 
    font-weight: bold; 
    font-size: 10px;
    padding: 1px 0;
}

/* Nome da clínica */
.hospital-nome {
    font-weight: bold;
    text-decoration: underline;
    display: block;
    margin-bottom: 2px;
    font-size: 10px;
}

/* Coluna da logo */
td.logo {
    width: 100px; /* largura menor da coluna da logo */
    text-align: center; /* centraliza a logo horizontalmente */
    vertical-align: middle; /* centraliza a logo verticalmente */
    padding: 2px;
}

/* LOGO */
td.logo img {
    width: 80px !important; 
    height: auto !important;
    object-fit: contain;
    max-height: 40px !important;
    display: inline-block; /* mantém centralizado */
}

td.logo{
    width:25%; !important;
}

/* ASSINATURA */
td img {
    width: 120px !important;
    max-height: 50px !important;
    object-fit: contain;
    display: block;
    margin: 0 auto 2px auto !important;
}

/* Evita quebras em qualquer conteúdo */
table, tr, td, th, div, p, span {
    break-inside: avoid !important;
    page-break-inside: avoid !important;
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
}else if($tipo === "teste_acuidade")
{
    // CSS exclusivo
$css = '
<style>
body { 
    font-family: Arial, sans-serif; 
    background: #fff; 
    margin: 0;
    padding: 0;
    font-size: 10px; /* Fonte menor para caber na página */
}

/* Evita que o conteúdo do formulário quebre */
.guia-container {
    page-break-inside: avoid !important;
    break-inside: avoid !important;
    width: 100%;
    padding: 2px 5px; /* Padding reduzido */
    margin: 0;
    line-height: 1.1; /* Linha mais compacta */
}

/* Tabelas */
table { 
    border-collapse: collapse; 
    width: 100%; 
    font-size: 10px;
    table-layout: fixed; /* Garante que colspan ocupe a largura total */
    page-break-inside: avoid !important;
    break-inside: avoid !important;
}

/* Células */
th, td { 
    border: 1px solid #000; 
    padding: 2px 3px; /* Padding menor */
    word-wrap: break-word; /* Evita ultrapassar a largura */
    page-break-inside: avoid !important;
    break-inside: avoid !important;
}

/* Título da guia */
.titulo-guia { 
    background: #eaeaea; 
    font-weight: bold; 
    text-align: center; 
    font-size: 11px; 
    padding: 2px 4px;
}

/* Seções */
.section-title { 
    background: #eaeaea; 
    font-weight: bold; 
    font-size: 10px;
    padding: 1px 0;
}

/* Nome da clínica */
.hospital-nome {
    font-weight: bold;
    text-decoration: underline;
    display: block;
    margin-bottom: 2px;
    font-size: 10px;
}

/* Coluna da logo */
td.logo {
    width: 100px; /* largura menor da coluna da logo */
    text-align: center; /* centraliza a logo horizontalmente */
    vertical-align: middle; /* centraliza a logo verticalmente */
    padding: 2px;
}

/* LOGO */
td.logo img {
    width: 80px !important; 
    height: auto !important;
    object-fit: contain;
    max-height: 40px !important;
    display: inline-block; /* mantém centralizado */
}

td.logo{
    width:25%; !important;
}

/* ASSINATURA */
td img {
    width: 120px !important;
    max-height: 50px !important;
    object-fit: contain;
    display: block;
    margin: 0 auto 2px auto !important;
}

/* Evita quebras em qualquer conteúdo */
table, tr, td, th, div, p, span {
    break-inside: avoid !important;
    page-break-inside: avoid !important;
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
    $nome = "teste_acuidade_" . time() . ".pdf";
    $caminho = __DIR__ . "/$nome";

    file_put_contents($caminho, $dompdf->output());

    echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
}else if($tipo === "psicossocial")
{
    // CSS exclusivo
$css = '
<style>
body { 
    font-family: Arial, sans-serif; 
    background: #fff; 
    margin: 0;
    padding: 0;
    font-size: 9px; /* Fonte ligeiramente menor para economizar espaço */
}

/* Evita que o conteúdo do formulário quebre */
.guia-container {
    page-break-inside: avoid !important;
    break-inside: avoid !important;
    width: 100%;
    padding: 1px 3px; /* Padding reduzido */
    margin: 0;
    line-height: 1.05; /* Linha mais compacta */
}

/* Tabelas */
table { 
    border-collapse: collapse; 
    width: 100%; 
    font-size: 9px; /* Fonte menor */
    table-layout: fixed; /* Garante que colspan ocupe a largura total */
    page-break-inside: avoid !important;
    break-inside: avoid !important;
}

/* Células */
th, td { 
    border: 1px solid #000; 
    padding: 1px 2px; /* Padding menor */
    word-wrap: break-word; /* Evita ultrapassar a largura */
    page-break-inside: avoid !important;
    break-inside: avoid !important;
}

/* Título da guia */
.titulo-guia { 
    background: #eaeaea; 
    font-weight: bold; 
    text-align: center; /* Ajustado para títulos de formulários */
    font-size: 10px; 
    padding: 1px 3px; /* Padding menor */
}

/* Seções */
.section-title { 
    background: #eaeaea; 
    font-weight: bold; 
    font-size: 9px;
    padding: 1px 0;
}

/* Nome da clínica */
.hospital-nome {
    font-weight: bold;
    text-decoration: underline;
    display: block;
    margin-bottom: 1px; /* Margin reduzida */
    font-size: 9px;
}

/* Coluna da logo */
td.logo {
    width: 25%; /* Largura da coluna da logo */
    text-align: center; /* Centraliza horizontalmente */
    vertical-align: middle; /* Centraliza verticalmente */
    padding: 1px;
}

/* LOGO */
td.logo img {
    width: 80px !important; 
    height: auto !important;
    object-fit: contain;
    max-height: 40px !important;
    display: inline-block; /* mantém centralizado */
}

/* ASSINATURA */
td img {
    width: 120px !important;
    max-height: 50px !important;
    object-fit: contain;
    display: block;
    margin: 0 auto 1px auto !important;
}

/* Evita quebras em qualquer conteúdo */
table, tr, td, th, div, p, span {
    break-inside: avoid !important;
    page-break-inside: avoid !important;
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
    $nome = "psicossocial" . time() . ".pdf";
    $caminho = __DIR__ . "/$nome";

    file_put_contents($caminho, $dompdf->output());

    echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
    exit;
}
?>