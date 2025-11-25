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

$emails = "neto_br_8@hotmail.com,idaillopes@gmail.com";

// var_dump($id_kit);

// var_dump($destino);

if ($tipo === "guia_encaminhamento") {
    // CSS exclusivo
    $css = '
<style>
body { font-family: Arial, sans-serif; background:#fff; }
table { border-collapse:collapse; width:100%; font-size:12px; }
th, td { border:1px solid #000; padding:4px; }
.titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; }
.section-title { background:#eaeaea; font-weight:bold; }

/* NOME DA CLÍNICA — QUEDA AUTOMÁTICA */
.hospital-nome {
    font-weight:bold;
    text-decoration:underline;
    display:block !important;         /* quebra garantida */
    margin-bottom:4px !important;     /* espaço entre linhas */
}

/* -------- LOGO -------- */
.logo img {
    width: 90px !important;
    height: auto !important;
    object-fit: contain !important;
    text-align:center;
    max-height:45px;
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
} else if ($tipo === "aso") {
    // CSS exclusivo
    $css = '
<style>
body { font-family: Arial, sans-serif; background:#fff; }
table { border-collapse:collapse; width:100%; font-size:12px; }
th, td { border:1px solid #000; padding:4px; }
.titulo-guia { background:#eaeaea; font-weight:bold; text-align:center; }
.section-title { background:#eaeaea; font-weight:bold; }

/* NOME DA CLÍNICA — QUEDA AUTOMÁTICA */
.hospital-nome {
    font-weight:bold;
    text-decoration:underline;
    display:block !important;         /* quebra garantida */
    margin-bottom:4px !important;     /* espaço entre linhas */
}

/* -------- LOGO -------- */
.logo img {
    width: 90px !important;
    height: auto !important;
    
    text-align:center !important;
    max-height:45px !important;
    margin-right:40px !important;
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

    $nome_pdf = "aso" . time() . ".pdf";
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

        $mail->Subject = "ASO";
        $mail->Body    = "Segue anexo o arquivo da guia solicitada.\nDestino escolhido: " . strtoupper($destino);

        $mail->addAttachment($caminho_pdf);

        $mail->send();

        echo json_encode(["mensagem" => "E-mail enviado com sucesso!"]);
        exit;
    } catch (Exception $e) {
        echo json_encode(["mensagem" => "Erro ao enviar: {$mail->ErrorInfo}"]);
        exit;
    }
}else if($tipo === "prontuario_medico")
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
    font-size: 10px; /* Fonte menor */
    page-break-inside: avoid !important;
    break-inside: avoid !important;
}

th, td { 
    border: 1px solid #000; 
    padding: 2px 3px; /* Padding menor */
    page-break-inside: avoid !important;
    break-inside: avoid !important;
}

/* Título da guia */
.titulo-guia { 
    background: #eaeaea; 
    font-weight: bold; 
    text-align: center; 
    font-size: 11px; /* Fonte menor para títulos */
    padding: 2px 0;
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
    margin-bottom: 2px; /* Margin reduzida */
    font-size: 10px;
}

/* LOGO */
.logo img {
    width: 80px !important; /* Leve redução para caber */
    height: auto !important;
    object-fit: contain;
    max-height: 40px !important;
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

    $nome_pdf = "prontuario_medico" . time() . ".pdf";
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

        $mail->Subject = "Prontuário Médico";
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