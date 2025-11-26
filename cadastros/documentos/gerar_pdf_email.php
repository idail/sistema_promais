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
} else if ($tipo === "prontuario_medico") {
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
} else if ($tipo === "teste_acuidade") {
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

    $nome_pdf = "teste_acuidade" . time() . ".pdf";
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

        $mail->Subject = "Teste Acuidade Visual";
        $mail->Body    = "Segue anexo o arquivo da guia solicitada.\nDestino escolhido: " . strtoupper($destino);

        $mail->addAttachment($caminho_pdf);

        $mail->send();

        echo json_encode(["mensagem" => "E-mail enviado com sucesso!"]);
        exit;
    } catch (Exception $e) {
        echo json_encode(["mensagem" => "Erro ao enviar: {$mail->ErrorInfo}"]);
        exit;
    }
} else if ($tipo === "psicossocial") {
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

    $nome_pdf = "psicossocial" . time() . ".pdf";
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

        $mail->Subject = "Psicossocial";
        $mail->Body    = "Segue anexo o arquivo da guia solicitada.\nDestino escolhido: " . strtoupper($destino);

        $mail->addAttachment($caminho_pdf);

        $mail->send();

        echo json_encode(["mensagem" => "E-mail enviado com sucesso!"]);
        exit;
    } catch (Exception $e) {
        echo json_encode(["mensagem" => "Erro ao enviar: {$mail->ErrorInfo}"]);
        exit;
    }
} else if ($tipo === "exame_toxicologico") {
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

/* LOGO */
.logo img {
    width: 90px !important;
    height: auto !important;
    max-height:45px !important;
    display:block;
    margin: 0 auto !important;
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

    $nome_pdf = "exame_toxicologico" . time() . ".pdf";
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

        $mail->Subject = "Exame Toxicologico";
        $mail->Body    = "Segue anexo o arquivo da guia solicitada.\nDestino escolhido: " . strtoupper($destino);

        $mail->addAttachment($caminho_pdf);

        $mail->send();

        echo json_encode(["mensagem" => "E-mail enviado com sucesso!"]);
        exit;
    } catch (Exception $e) {
        echo json_encode(["mensagem" => "Erro ao enviar: {$mail->ErrorInfo}"]);
        exit;
    }
} else if ($tipo === "audiometria") {
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
    border-collapse: collapse !important;
    table-layout: fixed !important;
    border: 1px solid #000 !important; /* fecha a tabela */
}

/* === LINHA DAS ASSINATURAS === */
table.parecer-fono tr.assinaturas td {
    height: 110px !important;          /* altura fixa */
    vertical-align: bottom !important; /* força assinatura no rodapé */
    text-align: center !important;
    padding: 8px !important;
    border: 1px solid #000 !important; /* garante fechamento */
}

/* COLUNA ESQUERDA - PROFISSIONAL */
table.parecer-fono tr.assinaturas td:nth-child(1) {
    width: 60% !important;
    border-right: none !important;
}

/* COLUNA DIREITA - FUNCIONÁRIO */
table.parecer-fono tr.assinaturas td:nth-child(2) {
    width: 40% !important;
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
    border-collapse: collapse !important;
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
table.parecer-fono,
table.parecer-fono tr,
table.parecer-fono td {
    margin: 0 !important;
    padding: 0 !important;
    border: 1px solid #000 !important;
}

/* Ajuste para as células de assinatura */
table.parecer-fono tr:last-child > td {
    padding: 10px 15px !important;
    vertical-align: bottom !important;
    text-align: center !important;
    height: 100px !important;
}

/* Remove borda direita da primeira célula e esquerda da última */
table.parecer-fono tr:last-child > td:first-child {
    border-right: none !important;
    border-left: none !important;
}

table.parecer-fono tr:last-child > td:last-child {
    border-left: none !important;
    border-right: none !important;
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
</style> ';




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

    $nome_pdf = "audiometria" . time() . ".pdf";
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

        $mail->Subject = "Audiometria";
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
