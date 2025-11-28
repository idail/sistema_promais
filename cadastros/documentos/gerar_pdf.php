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
}else if($tipo === "exame_toxicologico")
{
// CSS exclusivo
$css = '
<style>
body { font-family: Arial, sans-serif; background:#fff; margin:0; padding:0; }
table { border-collapse:collapse; width:100%; font-size:12px; }
th, td { border:1px solid #000; padding:4px; vertical-align:top; }
.titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; }
.section-title { background:#eaeaea; font-weight:bold; }

/* NOME DA CLÍNICA — QUEDA AUTOMÁTICA */
.hospital-nome {
    font-weight:bold;
    text-decoration:underline;
    display:block !important;         
    margin-bottom:4px !important;    
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

/* ASSINATURA - ocupa 100% da linha */
td.assinatura {
    width: 100% !important;  /* força a célula ocupar toda a largura */
    text-align:center;        /* centraliza horizontalmente */
    vertical-align:bottom;    /* alinha na parte inferior */
    padding: 2px;             /* padding reduzido */
    border:1px solid #000;    /* garante borda completa */
}
td.assinatura img {
    width: 140px !important;
    max-height: 60px !important;
    object-fit: contain !important;
    display: block;
    margin: 0 auto 2px auto !important;
}

/* Evita quebras */
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
}else if($tipo === "audiometria")
{
    // CSS exclusivo 
    $css = ' <style> 
    body { font-family: Arial, sans-serif; background:#fff; margin:0; padding:0; } 
    table { border-collapse:collapse; width:100%; font-size:12px; } 

    th, td { border:1px solid #000; padding:4px; vertical-align:top; } 

    .titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; } 

    .section-title { background:#eaeaea; font-weight:bold; } 
    /* NOME DA CLÍNICA — QUEDA AUTOMÁTICA */ 
    .hospital-nome { font-weight:bold; text-decoration:underline; display:block !important; margin-bottom:4px !important; } 

    /* LOGO */ 
    .logo img { width: 90px !important; height: auto !important; max-height:45px !important; display:block; margin: 0 auto !important; } 

    /* ASSINATURA - ocupa 100% da linha */ 
    td.assinatura { width: 100% !important; /* força a célula ocupar toda a largura */ text-align:center; /* centraliza horizontalmente */ vertical-align:bottom; /* alinha na parte inferior */ padding: 2px; /* padding reduzido */ border:1px solid #000; 
    /* garante borda completa */ } 

    td.assinatura img { width: 140px !important; max-height: 60px !important; object-fit: contain !important; display: block; margin: 0 auto 2px auto !important; } 

    /* Evita quebras */ 
    table, tr, td, th, div, p, span { break-inside: avoid !important; page-break-inside: avoid !important; } 
    
    /* Altura total das 3 tabelas (laterais e centro) */
table.blocos-audio { height: 160px !important;margin-bottom:-63px !important; }

/* 2) Reduz volume das células do meio (menor que as laterais) */
table.tabela-centro td {
  padding: 3px 4px !important;  /* menor padding */
  line-height: 13px !important; /* linha mais baixa */
  height: auto !important;
}

/* 1) Mantém a mesma altura total declarada das laterais */
table.tabela-centro { height: 160px !important; }

/* Aumenta a altura das células (vale para as 3 tabelas) */
table.blocos-audio td {
  padding: 8px 6px !important;   /* mais espaço interno */
  line-height: 20px !important;  /* aumenta a “altura visual” da linha */
  height: auto !important;       /* evita travar a altura mínima */
}

.tabela-centro{
    padding: 1px 1px !important;   /* mais espaço interno */
  line-height: 20px !important;  /* aumenta a “altura visual” da linha */
  height: auto !important;       /* evita travar a altura mínima */
}

/* === Compactação máxima da TABELA DO MEIO === */
table.tabela-centro td {
  padding: 2px 3px !important;
  line-height: 12px !important;
  font-size: 10px !important;
  height: auto !important;
}

/* Linhas internas do meio mais baixas (exceto cabeçalho) */
table.tabela-centro tr:not(:first-child) {
  height: 16px !important; /* se ainda ficar alta, tente 14px */
}

/* Garantir a mesma altura total do bloco central */
table.tabela-centro { height: 160px !important; }

/* Cabeçalhos das 3 tabelas: 1 linha, mais baixos e fonte menor */
table.blocos-audio tr:first-child td {
  padding: 2px 3px !important;
  line-height: 12px !important;
  font-size: 9px !important;     /* reduz a fonte */
  font-weight: bold !important;
  white-space: nowrap !important;  /* evita quebra */
  letter-spacing: 0 !important;
  word-spacing: -0.5px !important; /* compacta levemente as palavras */
}

/* (Opcional) Se o do meio ainda estourar, deixe 9px */
table.tabela-centro tr:first-child td {
  font-size: 10px !important; /* altere para 9px se precisar */
}

/* ===== Ajustes SOMENTE para a tabela do meio ===== */
.logo-col2 table.tabela-centro { 
  table-layout: fixed !important;
  height: 160px !important;         /* mesma altura das laterais */
}

/* Células do meio mais compactas (todas as células) */
.logo-col2 table.tabela-centro td {
  padding: 2px 3px !important;       /* reduz volume */
  line-height: 15px !important;      /* linhas mais baixas */
  font-size: 10px !important;        /* fonte menor que as laterais */
  height: auto !important;
  text-align: right !important;
  padding-right: 4px !important;
}

/* Primeira coluna (OD/OE) centralizada */
.logo-col2 table.tabela-centro td[style*="width:10%"] {
  text-align: center !important;
  padding-right: 0 !important;
}

/* Segunda coluna (dB/NS) levemente à direita para não invadir a célula do OE */
.logo-col2 table.tabela-centro td[style*="width:15%"] {
  text-align: center !important; /* aplica ao OD (tem width:15%) */
  padding-right: 0 !important;
}

/* Última coluna (Monossílabos/Dissílabos) alinhada à esquerda */
.logo-col2 table.tabela-centro td[style*="width:35%"] {
  text-align: left !important;
  padding-right: 0 !important;
}

/* Coluna das porcentagens (3ª coluna) sempre alinhada à direita com o mesmo padding */
.logo-col2 table.tabela-centro tr > td:nth-of-type(3) {
  text-align: right !important;
  padding-right: 6px !important;
}

/* Garantia extra: % da linha inicial do OE (4ª linha) */
.logo-col2 table.tabela-centro tr:nth-child(4) > td:nth-of-type(3) {
  text-align: right !important;
  padding-right: 6px !important;
}

/* Nas linhas 3 e 5 a célula de % é a primeira (por causa do rowspan) */
.logo-col2 table.tabela-centro tr:nth-child(3) > td:first-child,
.logo-col2 table.tabela-centro tr:nth-child(5) > td:first-child {
  text-align: right !important;
  padding-right: 6px !important;
}

/* Específico: linha inicial do OE -> a 2ª célula (dB/NS) alinhada à direita */
.logo-col2 table.tabela-centro tr:nth-child(4) > td:nth-of-type(2),
.logo-col2 table.tabela-centro tr:nth-child(4) > td + td,
.logo-col2 table.tabela-centro tr:nth-of-type(4) > td:nth-child(2) {
  text-align: center !important; /* igual ao dB/NS do OD */
  padding-left: 0 !important;
  padding-right: 0 !important;
}

/* Específico: segunda linha do OE (por garantia) -> manter alinhada à direita */
.logo-col2 table.tabela-centro tr:nth-child(5) > td:nth-of-type(2),
.logo-col2 table.tabela-centro tr:nth-child(5) > td + td,
.logo-col2 table.tabela-centro tr:nth-of-type(5) > td:nth-child(2) {
  text-align: center !important; /* igual ao dB/NS do OD */
  padding-left: 0 !important;
  padding-right: 0 !important;
}

/* Cabeçalho central permanece centralizado */
.logo-col2 table.tabela-centro tr:first-child td {
  text-align: center !important;
  padding-right: 0 !important;
}

/* Cabeçalho do meio: 1 linha e baixo */
.logo-col2 table.tabela-centro tr:first-child td {
  padding: 2px 3px !important;
  line-height: 12px !important;
  font-size: 9.5px !important;       /* ajuste fino do título central */
  white-space: nowrap !important;
}

/* Linhas internas do meio (exceto cabeçalho) com altura mínima menor */
.logo-col2 table.tabela-centro tr:not(:first-child) {
  height: 25px !important;           /* se ainda ficar alto, use 14px */
}

/* === Laterais: aumentar altura para igualar ao centro === */
.logo-col1 table.blocos-audio,
.logo-col3 table.blocos-audio {
  height: 160px !important; /* mesma altura total */
}

.logo-col1 table.blocos-audio td,
.logo-col3 table.blocos-audio td {
  padding: 6px 6px !important;    /* mais volume que o centro */
  line-height: 28px !important;   /* linhas mais altas */
  height: auto !important;
}

/* Linhas internas das laterais (exceto o cabeçalho) iguais ao centro */
.logo-col1 table.blocos-audio tr:not(:first-child),
.logo-col3 table.blocos-audio tr:not(:first-child) {
  height: 25px !important;
}

/* Zera espaçamento entre tabelas no PDF */
table { 
  margin: 0 !important;
  border-collapse: collapse !important;
  border-spacing: 0 !important;
}

/* Remove respiro na base da linha que contém as 3 colunas do bloco */
.section-title + tr > td {
  padding-bottom: 0 !important;
  border-bottom: 0 !important;
}

/* Garante borda final do bloco de 3 tabelas */
.logo-col1 table.blocos-audio tr:last-child td,
.logo-col2 table.tabela-centro tr:last-child td,
.logo-col3 table.blocos-audio tr:last-child td {
  padding-bottom: 0 !important;
  margin-bottom: 0 !important;
  border-bottom: 1px solid #000 !important;
}

/* Cola a tabela Audiômetro no bloco acima */
table.audiometro {
  margin-top: -4px !important;          /* ajuste fino: -3 a -6 */
  border-top: 1px solid #000 !important; /* mantém a linha superior do Audiômetro */
}
  
/* Zera espaçamento entre tabelas no PDF */
table { 
  margin: 0 !important;
  border-collapse: collapse !important;
  border-spacing: 0 !important;
}

/* Remove respiro na base da linha que contém as 3 colunas do bloco */
.section-title + tr > td {
  padding-bottom: 0 !important;
  border-bottom: 0 !important;
}

/* Borda final do bloco das 3 tabelas (últimas células internas) */
.logo-col1 table.blocos-audio tr:last-child td,
.logo-col2 table.tabela-centro tr:last-child td,
.logo-col3 table.blocos-audio tr:last-child td {
  padding-bottom: 0 !important;
  margin-bottom: 0 !important;
  border-bottom: 1px solid #000 !important;
}

/* Cola a tabela Audiômetro no bloco acima */
table.audiometro {
  margin-top: -4px !important;          /* ajuste fino: -3 a -6 */
  border-top: 1px solid #000 !important;/* mantém a linha superior do Audiômetro */
}

/* Audiômetro em uma única linha (Dompdf) */
table.audiometro {
  table-layout: auto !important;
  width: 100% !important;
  border-collapse: collapse !important;

  /* já está colada ao bloco de cima (você usa margin-bottom negativo nas 3 tabelas) */
  margin-top: -4px !important;           /* ajuste fino: -3 a -6 */
  border-top: 1px solid #000 !important;

  page-break-inside: avoid !important;
  break-inside: avoid !important;
}

table.audiometro th,
table.audiometro td {
  white-space: nowrap !important;        /* não quebrar linha */
  padding: 2px 4px !important;           /* compacta */
  line-height: 12px !important;          /* Dompdf lida melhor com menor */
  vertical-align: middle !important;
  font-size: 10px !important;            /* ajuste fino */
}

table.audiometro th {
  width: 12% !important;                 /* rótulo menor */
  text-align: left !important;
}

table.audiometro td {
  width: 88% !important;                 /* mais espaço para o texto longo */
  letter-spacing: 0 !important;
  word-spacing: -0.5px !important;       /* leve compactação visual */
}
 
/* Mantém apenas uma linha de borda entre os blocos */
.section-title + tr > td {
    padding-bottom: 0 !important;
    border-bottom: 1px solid #000 !important;  /* única linha de borda */
}

/* Ajusta a tabela Audiômetro para ficar colada */
table.audiometro {
    margin-top: 0 !important;      /* remove margem superior */
    border-top: 0 !important;      /* remove borda superior duplicada */
}

/* Remove bordas inferiores das tabelas internas */
.logo-col1 table.blocos-audio tr:last-child td,
.logo-col2 table.tabela-centro tr:last-child td,
.logo-col3 table.blocos-audio tr:last-child td {
    border-bottom: 0 !important;
}

/* Garante que o conteúdo do Audiômetro fique em uma linha */
table.audiometro th,
table.audiometro td {
    white-space: nowrap !important;
}

/* ===== ESTILOS PARA A SEÇÃO DE ASSINATURAS ===== */
table.parecer-fono {
    margin-top: 10px !important;
    width: 100% !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    border: 1px solid #000 !important;
    border-bottom: none !important; /* Remove borda inferior da tabela principal */
}

/* Células de assinatura */
table.parecer-fono tr:last-child > td {
    height: 100px !important;
    vertical-align: bottom !important;
    padding: 10px !important;
    text-align: center !important;
    border: 1px solid #000 !important;
    border-top: 1px solid #000 !important;
    border-bottom: 1px solid #000 !important;
}

/* Remove borda direita da última célula para evitar duplicação */
table.parecer-fono tr:last-child > td:last-child {
    border-right: 1px solid #000 !important; /* Mantém a borda direita */
}

/* Assinatura do profissional (esquerda) */
table.parecer-fono tr:last-child > td:first-child {
    width: 60% !important;
    padding-right: 15px !important;
    border-right: none !important; /* Remove a borda direita da primeira célula */
}

/* Assinatura do funcionário (direita) */
table.parecer-fono tr:last-child > td:last-child {
    width: 40% !important;
    padding-left: 15px !important;
    border-left: none !important; /* Remove a borda esquerda da última célula */
}

/* Container da assinatura */
table.parecer-fono tr:last-child > td > div {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

/* Ajuste para a imagem da assinatura */
table.parecer-fono tr:last-child > td img {
    max-height: 40px !important;
    width: auto !important;
    margin: 0 auto 5px !important;
    display: block !important;
}

/* Linha de assinatura */
table.parecer-fono tr:last-child > td > div > div[style*="border-top"] {
    border-top: 1px solid #000 !important;
    width: 100% !important;
    margin: 5px 0 !important;
}

/* Texto "Assinatura" */
table.parecer-fono tr:last-child > td > div > div[style*="font-weight: bold"] {
    font-weight: bold !important;
    margin: 3px 0 !important;
    text-align: center !important;
}

/* Informações do profissional */
table.parecer-fono tr:last-child > td > div > div[style*="font-size: 10px"] {
    font-size: 10px !important;
    line-height: 1.2 !important;
    margin: 2px 0 !important;
    text-align: center !important;
}

/* Nome do funcionário */
table.parecer-fono tr:last-child > td > div > div[style*="font-size: 9px"] {
    font-size: 9px !important;
    line-height: 1.2 !important;
    margin: 2px 0 !important;
    text-align: center !important;
}

/* --- ENXUGAR APENAS A COLUNA DO FUNCIONÁRIO (direita) para não estourar a largura --- */
table.parecer-fono tr:last-child > td:last-child {
    padding-left: 6px !important;
    padding-right: 6px !important;
    padding-top: 6px !important;
    padding-bottom: 6px !important;
    white-space: nowrap !important;      /* evita quebra que empurra a borda */
    overflow: hidden !important;         /* corta excedente sem expandir a célula */
    text-overflow: ellipsis !important;  /* indica texto cortado, se necessário */
    font-size: 8px !important;           /* reduz fonte base da célula */
    line-height: 1.1 !important;         /* reduz altura das linhas */
}

/* Limita a largura útil do conteúdo interno da coluna do funcionário */
table.parecer-fono tr:last-child > td:last-child > div {
    max-width: 100% !important; /* não restringe a largura útil do wrapper interno */
    margin: 0 auto !important;
}

/* Linha de assinatura da coluna do funcionário um pouco mais curta para abrir espaço à direita */
table.parecer-fono tr:last-child > td:last-child > div > div[style*="border-top"] {
    width: 60% !important;
    margin: 3px auto !important;
}

/* Texto "Assinatura do Funcionário" um pouco menor para caber melhor */
table.parecer-fono tr:last-child > td:last-child > div > div[style*="font-weight: bold"] {
    font-size: 8px !important;
    margin: 1px 0 !important;
}

/* Nome + CPF do funcionário levemente menor para evitar overflow */
table.parecer-fono tr:last-child > td:last-child > div > div[style*="font-size: 9px"] {
    font-size: 7.5px !important;
    line-height: 1.1 !important;
}

/* Ajustes para impressão */
@media print {
    @page {
        size: A4;
        margin: 5mm 5mm 5mm 5mm;
    }
    body {
        padding: 2mm !important;
    }
}

/* Estilos para formulários */
input[type="checkbox"] {
    transform: scale(0.7);
    margin: 0 1px 0 0 !important;
}

input[type="text"],
input[type="number"],
input[type="date"],
select,
textarea {
    height: 12px !important;
    font-size: 8px !important;
    padding: 0 2px !important;
    margin: 0 !important;
}

/* Outros ajustes de margens */
p, div, span {
    margin: 0 !important;
    padding: 0 !important;
}

/* ==========================================================
      AJUSTES GERAIS — PERMITIDOS
   (não mexe nas 3 tabelas do bloco)
   ========================================================== */

body, table, td, th {
    font-size: 10px !important;
    line-height: 12px !important;
}

th, td {
    padding: 2px 3px !important;
}

/* Títulos de seção mais compactos */
.section-title {
    font-size: 11px !important;
    padding: 3px !important;
}

/* Dados gerais das tabelas fora do bloco */
table:not(.blocos-audio):not(.tabela-centro) td {
    font-size: 9px !important;
    padding: 2px 3px !important;
    line-height: 11px !important;
}

/* ==========================================================
      AJUSTE ESPECÍFICO DA OBS
   ========================================================== */
.obs-linha,
td.obs-linha {
    font-size: 8px !important;
    line-height: 9px !important;
    padding: 1px 3px !important;
    height: 14px !important; /* força 1 linha */
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

/* Se a OBS estiver assim no HTML, funciona: 
   <td colspan="6" class="obs-linha">...</td> */

/* ==========================================================
   REDUÇÃO DE FONTES DAS SEÇÕES:
   - AUDIOMETRIA (dados da clínica)
   - IDENTIFICAÇÃO DA EMPRESA
   - IDENTIFICAÇÃO DO FUNCIONÁRIO
   ========================================================== */

/* Título AUDIOMETRIA */
.titulo-guia {
    font-size: 11px !important;
    padding: 2px 3px !important;
}

/* Dados da clínica (lado esquerdo) */
.dados-hospital {
    font-size: 8.5px !important;
    line-height: 11px !important;
}

/* Nome da clínica em destaque */
.dados-hospital .hospital-nome {
    font-size: 9px !important;
    font-weight: bold !important;
}

/* IDENTIFICAÇÃO DA EMPRESA */
.section-title {
    font-size: 10px !important;
    padding: 2px 3px !important;
    font-weight: bold !important;
}

.empresa-info,
table .empresa-info,
table .empresa-info span,
table .empresa-info div {
    font-size: 8.5px !important;
    line-height: 11px !important;
}

/* Nome da empresa */
.hospital-nome {
    font-size: 9px !important;
    font-weight: bold !important;
}

/* IDENTIFICAÇÃO DO FUNCIONÁRIO */
table td[colspan="2"][style*="font-size:12px"] {
    font-size: 8.5px !important;
    line-height: 11px !important;
    font-weight: bold !important;
}

/* Deixar textos longos mais compactos */
table td[colspan="2"] {
    word-break: break-word;
}
/* ======== REDUÇÃO EXCLUSIVA DA TABELA DE MEATOSCOPIA ======== */

/* Fonte menor e mais compacta na tabela */
table.tabela-meatoscopia {
    font-size: 9px !important;
    line-height: 11px !important;
    margin-bottom: 6px !important;
}

/* Cabeçalho (MEATOSCOPIA) mais compacto */
table.tabela-meatoscopia tr:first-child td {
    padding: 2px 3px !important;
    font-size: 9px !important;
}

/* Células OD e OE */
table.tabela-meatoscopia td {
    padding: 3px !important;
    font-size: 9px !important;
    line-height: 11px !important;
}

/* Reduz o espaço entre os labels */
table.tabela-meatoscopia label {
    font-size: 9px !important;
    margin-right: 4px !important;
    white-space: nowrap !important;
}

/* Título OD / OE */
table.tabela-meatoscopia strong {
    font-size: 9px !important;
}

/* Diminui checkbox visualmente (HTML não muda tamanho real) */
table.tabela-meatoscopia input[type="checkbox"] {
    transform: scale(0.8);
    margin-right: 2px;
}
/* Ajuste para as colunas de assinatura */
.parecer-fono-tabela tr:last-child > td {
    width: 50% !important;
    padding: 10px !important;
    vertical-align: bottom !important;
    text-align: center !important;
    border: 1px solid #000 !important;
}

/* Garante que a linha de assinatura ocupe 100% */
.parecer-fono-tabela tr:last-child {
    display: table-row !important;
    width: 100% !important;
}

/* Remove bordas duplicadas entre as células */
.parecer-fono-tabela tr:last-child > td:first-child {
    border-right: none !important;
}

.parecer-fono-tabela tr:last-child > td:last-child {
    border-left: none !important;
}

/* Ajuste para a imagem da assinatura */
.parecer-fono-tabela tr:last-child img {
    max-height: 40px !important;
    max-width: 120px !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
    display: block !important;
    margin: 0 auto 5px !important;
}




/* === TABELA PRINCIPAL DAS ASSINATURAS === */
table.parecer-fono {
    width: 100% !important;
    margin-top: 12px !important;
    border-collapse: separate !important; /* evita fusão que pode suprimir borda externa no Dompdf */
    border-spacing: 0 !important;
    table-layout: fixed !important;
    border: 1px solid #000 !important; /* fecha a tabela */
}

/* === LINHA DAS ASSINATURAS === */
table.parecer-fono tr.assinaturas td {
    height: 90px !important;           /* altura menor */
    vertical-align: bottom !important; /* força assinatura no rodapé */
    text-align: center !important;
    padding: 4px 6px !important;       /* menos padding = mais largura útil */
    border: 1px solid #000 !important; /* garante fechamento */
}

/* COLUNA ESQUERDA - PROFISSIONAL */
table.parecer-fono tr.assinaturas td:nth-child(1) {
    width: 58% !important; /* libera mais espaço para a coluna do funcionário */
    border-right: none !important;
}

/* COLUNA DIREITA - FUNCIONÁRIO */
table.parecer-fono tr.assinaturas td:nth-child(2) {
    width: 42% !important; /* aumenta espaço efetivo para o funcionário */
    border-left: none !important;
}

/* CONTAINER INTERNO QUE SEGURA A ASSINATURA */
table.parecer-fono tr.assinaturas td .assinatura-container {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end; /* joga a linha e texto para baixo */
}

/* IMAGEM DA ASSINATURA */
table.parecer-fono tr.assinaturas td img {
    max-height: 45px !important;
    width: auto !important;
    margin: 0 auto 5px auto !important;
    display: block !important;
}

/* LINHA DE ASSINAR */
table.parecer-fono .linha-assinatura {
    border-top: 1px solid #000 !important;
    width: 100% !important;
    margin-top: 5px !important;
}

/* TEXTO “Assinatura” */
table.parecer-fono .titulo-assinatura {
    font-size: 10px !important;
    font-weight: bold !important;
    margin-top: 4px !important;
}

/* NOME / CRM / DADOS */
table.parecer-fono .dados-assinatura {
    font-size: 9px !important;
    line-height: 1.2 !important;
    margin-top: 2px !important;
    text-align: center !important;
}
/* FECHAMENTO DA TABELA DE ASSINATURAS */
table.parecer-fono {
    border: 1px solid #000 !important;
    border-collapse: separate !important; /* manter separada para preservar borda externa */
    border-spacing: 0 !important;
    margin-bottom: 0 !important;
    width: 100% !important;
    table-layout: fixed !important;
}

/* Remove borda inferior das células internas */
table.parecer-fono tr:not(:last-child) > td {
    border-bottom: none !important;
}

/* Última linha - assinaturas */
table.parecer-fono tr:last-child {
    border-top: 1px solid #000 !important;
}

/* Remove margens e paddings extras */
/* Evita inflar bordas em todas as células; controlamos bordas onde necessário */
table.parecer-fono {
    margin: 0 !important;
    padding: 0 !important;
}

/* Ajuste para as células de assinatura */
table.parecer-fono tr:last-child > td {
    padding: 4px 6px !important; /* reduz o respiro que tomava largura útil */
    vertical-align: bottom !important;
    text-align: center !important;
    height: 90px !important;
    overflow: hidden !important; /* garante que nada ultrapasse a borda externa */
    box-sizing: border-box !important; /* inclui borda e padding no cálculo da largura */
    min-width: 0 !important; /* evita estourar a largura da célula por texto longo */
}

/* Remove borda direita da primeira célula e esquerda da última */
table.parecer-fono tr:last-child > td:first-child {
    border-right: none !important;
    border-left: none !important;
}

table.parecer-fono tr:last-child > td:last-child {
    border-left: none !important;
    border-right: 1px solid #000 !important; /* garante fechamento da borda direita */
    position: relative !important; /* necessário para o pseudo-elemento */
}

/* Linha de assinatura */
table.parecer-fono .linha-assinatura {
    border-top: 1px solid #000 !important;
    margin: 5px 0 !important;
    width: 100% !important;
}

/* Garante que a borda inferior da tabela seja visível */
table.parecer-fono {
    border-bottom: 1px solid #000 !important;
}

/* Garante que a borda DIREITA da tabela feche visualmente mesmo com border-collapse */
table.parecer-fono {
    border-right: 1px solid #000 !important;
}

/* Desenho externo independente da colapsagem de bordas (garante o lado direito) */
table.parecer-fono {
    outline: 1px solid #000 !important;
    outline-offset: 0 !important;
}

/* Fallback explícito: desenha uma "borda" com pseudo-elemento no último TD */
table.parecer-fono tr:last-child > td:last-child::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 1px;
    background: #000;
}



.parecer-fono .funcionario{
    max-width:100% !important;          /* usa toda a largura disponível do TD */
    margin:0 auto !important;
    padding:0 !important;
}

/* Reduz e prioriza a célula da coluna do funcionário (override do inline) */
table.parecer-fono tr:last-child > td.teste {
    width: 36% !important;              /* encolhe a coluna direita */
    font-size: 7.2px !important;        /* derruba fonte base do TD */
    line-height: 1.05 !important;       /* linhas mais baixas */
    padding: 4px 6px !important;        /* menos padding */
    height: 90px !important;            /* ligeiramente menor */
}

.informacoes_medico{
    width:62% !important;              /* coluna do médico mais larga */
    padding:4px 6px !important;        /* menos padding */
    font-size:7.2px !important;        /* base menor para todo o TD */
    line-height:1.05 !important;
}



/* Reduções específicas dentro do TD do MÉDICO (override de inline) */
table.parecer-fono tr:last-child > td.informacoes_medico > div[style*="border-top"]{
    width:60% !important;
    margin:3px auto 2px !important;
}
table.parecer-fono tr:last-child > td.informacoes_medico > div[style*="font-weight: bold"]{
    font-size:7px !important;
    margin:1px 0 !important;
}
table.parecer-fono tr:last-child > td.informacoes_medico > div[style*="font-size: 10px"]{
    font-size:7px !important;
    line-height:1.05 !important;
    margin-bottom:1px !important;
}


/* ===== OVERRIDE FINAL PARECER-FONO — SIMPLES E FECHADO ===== */
/* Fecha bordas e padroniza 50%/50% na última linha, evitando regras conflitantes anteriores */
table.parecer-fono {
    width: 99.5% !important;            /* ligeiramente menor que 100% para evitar corte de borda no Dompdf */
    margin: 0 !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
    table-layout: fixed !important;
    border: 1px solid #000 !important;
}
table.parecer-fono td {
    border: 1px solid #000 !important;
    padding: 4px !important;
}
table.parecer-fono tr:last-child > td {
    width: 50% !important;                /* metade/metade */
    height: 80px !important;              /* um pouco mais alto para acomodar quebras */
    vertical-align: bottom !important;
    text-align: center !important;
    box-sizing: border-box !important;
    padding: 3px 4px !important;
    font-size: 8px !important;            /* reduz tipografia base das duas colunas */
}
table.parecer-fono tr:last-child > td img {
    width: 85px !important;               /* imagem um pouco menor para abrir espaço */
    max-width: 85px !important;
    height: auto !important;
    max-height: 36px !important;
    object-fit: contain !important;
    display: block !important;
    margin: 0 auto 4px auto !important;
}

/* Compactação do bloco ACIMA das assinaturas (Parecer Fonoaudiológico) */
/* Aplica tanto à tabela (.parecer-fono-tabela) quanto aos TDs com classe .parecer-fono */
.parecer-fono-tabela td,
.parecer-fono-tabela th,
td.parecer-fono,
th.parecer-fono {
    font-size: 7.6px !important;
    line-height: 1.06 !important;
    padding: 1px 2px !important;
    white-space: normal !important;
    overflow-wrap: anywhere !important;
    word-break: break-word !important;
    hyphens: auto !important;
    letter-spacing: -0.1px !important;
    word-spacing: -0.4px !important;
}
/* Células com colspan tendem a estourar — reduzir mais */
.parecer-fono-tabela td[colspan],
td.parecer-fono[colspan] {
    font-size: 7.4px !important;
    line-height: 1.05 !important;
}
/* Título do bloco */
td.parecer-fono.titulo,
.parecer-fono-tabela td.titulo {
    font-size: 7.8px !important;
    padding: 2px !important;
}
/* Negritos dentro do parecer mais compactos */
td.parecer-fono strong,
.parecer-fono-tabela td strong {
    font-size: 7.6px !important;
    font-weight: 700 !important;
}

/* Compactação específica da célula do Funcionário para evitar estouro */
table.parecer-fono tr:last-child > td:last-child {
    font-size: 7.4px !important;          /* ainda mais compacto para caber sempre */
    line-height: 1.05 !important;
    text-align: left !important;           /* alinha à esquerda para ganhar espaço útil */
    padding: 2px 2px !important;           /* respiro mínimo */
    white-space: normal !important;        /* permite quebra */
    overflow-wrap: anywhere !important;    /* força quebra se necessário */
    word-break: break-word !important;
    letter-spacing: -0.1px !important;     /* compacta ligeiramente */
    word-spacing: -0.3px !important;
}
table.parecer-fono tr:last-child > td:last-child > div {
    max-width: 96% !important;             /* evita tocar a borda */
    margin: 0 !important;
}
table.parecer-fono tr:last-child > td:last-child .linha-assinatura {
    width: 58% !important;                 /* ainda menor p/ sobrar espaço à direita */
    margin: 3px 0 2px 0 !important;        /* encosta à esquerda */
}

/* ================= Fallback: Tabela de assinaturas separada ================= */
/* Caso você mova as assinaturas para uma tabela própria (sem TH), use:
   <table class="assinaturas-separadas"> ... </table> */
table.assinaturas-separadas {
    width: 100% !important;             /* ocupa toda a largura do formulário */
    border: 1px solid #000 !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
    table-layout: fixed !important;
    margin-top: 0px !important;
    margin-bottom: 0 !important;         /* evita espaço/linha visual abaixo */
    page-break-inside: avoid !important;
}
table.assinaturas-separadas td {
    border: 1px solid #000 !important;
    width: 50% !important;
    height: 80px !important;
    vertical-align: middle !important;     /* centraliza verticalmente o conteúdo */
    text-align: center !important;          /* centraliza horizontalmente */
    padding: 3px 4px !important;
    font-size: 8px !important;
    box-sizing: border-box !important;
}
/* Remove a borda inferior do container (última linha) para não aparecer linha abaixo */
.parecer-fono-tabela tr:last-child > td {
    border-bottom: 0 !important;
    padding-bottom: 0 !important;
}

/* Garante que a tabela de assinaturas ocupe 100% e fique colada ao bloco anterior */
table.assinaturas-separadas {
    width: 100% !important;
    max-width: 100% !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    display: table !important;
    border-left: 1px solid #000 !important;
    border-right: 1px solid #000 !important;
}

table.assinaturas-separadas td img {
    width: 85px !important;
    max-height: 36px !important;
    height: auto !important;
    object-fit: contain !important;
    display: block !important;             /* garante bloco para centralização */
    margin: 0px 0px 0px 120px !important;    /* centraliza a imagem ao meio */
}



/* Centralização específica da imagem do MÉDICO (primeira coluna) */
table.assinaturas-separadas td.informacoes_medico img {
    display: block !important;
    margin: 0 auto 0px 120px !important;  /* ao centro, imediatamente acima da linha */
    float: none !important;               /* remove qualquer flutuação herdada */
}
/* Garante centralização de qualquer conteúdo no TD do médico */
table.assinaturas-separadas td.informacoes_medico {
    text-align: center !important;
}
/* Linha de assinatura do médico centralizada */
table.assinaturas-separadas td.informacoes_medico .linha-assinatura {
    margin: 4px auto 2px auto !important;
}
/* Coluna direita (funcionário) — centralizada como a esquerda */
table.assinaturas-separadas td:last-child {
    font-size: 7.4px !important;
    line-height: 1.05 !important;
    text-align: center !important;        /* centraliza textos */
    padding: 2px 2px !important;
    white-space: normal !important;
    overflow-wrap: anywhere !important;
    word-break: break-word !important;
}
table.assinaturas-separadas .linha-assinatura { border-top:1px solid #000 !important; width:60% !important; margin:4px auto 2px auto !important; }

/* ===== FIX: Colar assinaturas no parecer e ocupar 100% ===== */
/* Zera qualquer respiro do container de assinaturas que vem logo após o parecer */
tr.assinaturas-container > td {
    padding: 0 !important;
    border: 0 !important;
    line-height: 0 !important;
}
/* Remove a linha/borda extra da última linha do parecer para não ficar dupla */
.parecer-fono-tabela tr:last-child > td {
    border-bottom: 0 !important;
    padding-bottom: 0 !important;
    margin-bottom: 0 !important;
}

/* ===== Quando as tabelas são SEPARADAS ===== */
/* Remove qualquer espaço visual entre as tabelas e evita borda dupla */
table.parecer-fono-tabela {
    width: 100% !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
    margin-bottom: 0 !important;
    page-break-after: avoid !important;
}

/* Remove somente a borda inferior geral do bloco de parecer para não duplicar */
table.parecer-fono-tabela { border-bottom: 0 !important; }

/* E garante que a assinatura feche com a borda superior */
table.assinaturas-separadas {
    border-top: 1px solid #000 !important;
    margin-top: 0 !important;
    page-break-before: avoid !important;
}

/* Evita quebra entre as duas tabelas */
table.parecer-fono-tabela, table.assinaturas-separadas {
    break-inside: avoid !important;
    page-break-inside: avoid !important;
}

.assinaturas-separadas
{
margin-top:-10px !important;
}

.ajuste{
padding-left: 6px !important;
}
</style> ';


    // HTML FINAL
    $html_final = $css . $html_recebido;

    // GERA PDF
    $dompdf->loadHtml($html_final);
    $dompdf->setPaper("A4", "portrait");
    $dompdf->render();

    // NOME ÚNICO
    $nome = "audiometria" . time() . ".pdf";
    $caminho = __DIR__ . "/$nome";

    file_put_contents($caminho, $dompdf->output());

    echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
    exit;
}else if($tipo === "resumo_laudo")
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
    $nome = "resumo_laudo" . time() . ".pdf";
    $caminho = __DIR__ . "/$nome";

    file_put_contents($caminho, $dompdf->output());

    echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
    exit;
}else if($tipo === "teste_romberg")
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
    $nome = "teste_romberg" . time() . ".pdf";
    $caminho = __DIR__ . "/$nome";

    file_put_contents($caminho, $dompdf->output());

    echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
    exit;
}
?>