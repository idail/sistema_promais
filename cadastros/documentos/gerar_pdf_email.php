<?php
require __DIR__ . '/../../vendor/autoload.php';


use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// RECEBE JSON
$data = json_decode(file_get_contents("php://input"), true);

$html_recebido = $data['html'] ?? "";
$emails         = $data['emails'] ?? "";
$destino        = $data['destino'] ?? "";
$tipo           = $data["tipo"] ?? "";
$id_kit         = $data["id_kit"] ?? "";

// var_dump($id_kit);

var_dump($destino);

if ($tipo === "guia_encaminhamento") {
    // CSS exclusivo
    $css = '
<style>
body { font-family: Arial, sans-serif; background:#fff; }
table { border-collapse:collapse; width:100%; font-size:12px; }
th, td { border:1px solid #000; padding:4px; }
.titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; }
.section-title { background:#eaeaea; font-weight:bold; }
.hospital-nome { font-weight:bold; text-decoration:underline; }

/* -------- LOGO -------- */
.logo img {
    width: 90px !important;
    height: auto !important;
    object-fit: contain !important;
}

/* -------- ASSINATURA (imagem pura sem div) -------- */
td img {
    width: 140px !important;
    max-height: 60px !important;
    object-fit: contain !important;
    display: block;
    margin: 0 auto 2px auto !important;
}
</style>
';



    $html_final = $css . $html_recebido;

    // =======================
    // GERA PDF EXCLUSIVO EMAIL
    // =======================
    $dompdf = new Dompdf();
    $dompdf->set_option('isRemoteEnabled', true); // obrigatório para carregar imagens da web
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->loadHtml($html_final);
    $dompdf->setPaper("A4", "portrait");
    $dompdf->render();

    $nome_pdf = "guia_encaminhamento_email_" . time() . ".pdf";
    $caminho_pdf = __DIR__ . "/" . $nome_pdf;

    file_put_contents($caminho_pdf, $dompdf->output());

    // =======================
    // ENVIA E-MAIL
    // =======================
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.kinghost.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'idailneto@idailneto.com.br';
        $mail->Password   = 'Sei#20020615';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('idailneto@idailneto.com.br', 'PDF');

        // SUPORTA VÁRIOS E-MAILS SEPARADOS POR VÍRGULA
        $lista = array_map('trim', explode(",", $emails));
        foreach ($lista as $email) {
            if (!empty($email)) {
                $mail->addAddress($email);
            }
        }

        $mail->Subject = "Guia de Encaminhamento";
        $mail->Body    = "Segue anexo o arquivo da guia solicitada.\nDestino escolhido: " . strtoupper($destino);

        $mail->addAttachment($caminho_pdf);

        $mail->send();

        echo json_encode(["mensagem" => "E-mail enviado com sucesso!"]);
        exit;
    } catch (Exception $e) {
        echo json_encode(["mensagem" => "Erro ao enviar: {$mail->ErrorInfo}"]);
        exit;
    }
}
?>