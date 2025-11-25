<?php
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

$host = 'mysql.idailneto.com.br';
$dbname = 'idailneto06';
$username = 'idailneto06';
$password = 'Sei20020615';

require_once "./phpqrcode/phpqrcode.php";
require __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["html"])) {
    die("Nenhum HTML recebido.");
}

$html_recebido = $data["html"];

// 🔥 ADICIONA O CSS AQUI (somente um INSERT no topo)
$css = '
<style>
    body { font-family: Arial, sans-serif; background:#fff; }
    table { border-collapse:collapse; width:100%; font-size:12px; }
    th, td { border:1px solid #000; padding:4px; }
    .titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; }
    .section-title { background:#eaeaea; font-weight:bold; }
    .hospital-nome { font-weight:bold; text-decoration:underline; }
    /* 🔥 CORREÇÃO DO TAMANHO DA LOGO */
    .logo img, img.logo {
        max-width:120px !important;
        height:auto !important;
    }
</style>
';

$html_final = $css . $html_recebido;

$options = new Options();
$options->set("isRemoteEnabled", true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html_final);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();

// SALVA O PDF
$nome = "guia_" . time() . ".pdf";
$caminho = __DIR__ . "/$nome";

file_put_contents($caminho, $dompdf->output());

// DEVOLVE O LINK PARA O JAVASCRIPT
echo "https://www.idailneto.com.br/promais/cadastros/documentos/$nome";
?>