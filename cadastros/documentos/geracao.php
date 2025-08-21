<?php
session_start();
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET");

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recebe_processo_geraca = $_POST["processo_geracao"];

    if (isset($recebe_processo_geraca) && strtolower(trim($recebe_processo_geraca)) === "guia de encaminhamento") {

        echo '
        <style>
        body { font-family: Arial, sans-serif; background:#f2f2f2; }
        .guia-container {
            width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
            background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
        }
        h2 { text-align:center; margin-bottom:20px; }
        h3 {
            margin-top:20px; margin-bottom:10px;
            background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
        }
        table { width:100%; border-collapse:collapse; margin-bottom:15px; }
        th, td { border:1px solid #ccc; padding:6px; font-size:13px; }
        th { background:#f8f9fa; text-align:left; width:30%; }
        input, textarea {
            width:100%; border:none; background:transparent; font-size:13px;
        }
        input:disabled, textarea:disabled {
            color:#000; cursor:not-allowed;
        }
        .options { display:flex; flex-wrap:wrap; gap:15px; margin:8px 0; }
        .opt { display:flex; align-items:center; gap:6px; }
        .assinatura { height:40px; border-bottom:1px solid #000; margin-top:10px; }
        .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
        .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
        .btn {
            padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
            cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
        }
        .btn-email { background:#007bff; }
        .btn-whatsapp { background:#25d366; }
        .btn-print { background:#6c757d; }
        .btn:hover { opacity:.9; }
        @media print { .actions { display:none; } body { background:#fff; } }
        </style>

        <div class="guia-container">
        <h2>GUIA DE ENCAMINHAMENTO</h2>

        <h3>01 - Identificação</h3>
        <table>
            <tr><th>Hospital/Clínica</th><td><input type="text" value="HOSPITAL BOM SAMARITANO" disabled></td></tr>
            <tr><th>CNPJ</th><td><input type="text" value="01.362.987/0001-57" disabled></td></tr>
            <tr><th>Endereço</th><td><input type="text" value="RUA 24 DE FEVEREIRO, S/N - BAIRRO: BOIADEIRO" disabled></td></tr>
            <tr><th>Cidade/UF</th><td><input type="text" value="ALTO ARAGUAIA - MT" disabled></td></tr>
            <tr><th>Telefone</th><td><input type="text" value="(66) 3481-1880" disabled></td></tr>
        </table>

        <h3>02 - Tipo de Exame / Procedimento</h3>
        <div class="options">
            <label class="opt"><input type="radio" disabled> Admissional</label>
            <label class="opt"><input type="radio" disabled> Periódico</label>
            <label class="opt"><input type="radio" disabled> Demissional</label>
            <label class="opt"><input type="radio" disabled> Mudança de Função</label>
            <label class="opt"><input type="radio" disabled> Retorno ao Trabalho</label>
        </div>

        <h3>03 - Dados do Funcionário / Empresa</h3>
        <table>
            <tr><th>Empresa</th><td><input type="text" value="PROMAIS SAÚDE E SEGURANÇA DO TRABALHO" disabled></td></tr>
            <tr><th>CNPJ</th><td><input type="text" value="19.464.436/0001-60" disabled></td></tr>
            <tr><th>Nome Funcionário</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>Cargo</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>CBO</th><td><input type="text" value="" disabled></td></tr>
        </table>

        <h3>04 - Mudança de Função</h3>
        <table>
            <tr><th>Novo Cargo</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>Novo CBO</th><td><input type="text" value="" disabled></td></tr>
        </table>

        <h3>05 - Dados dos Médicos</h3>
        <table>
            <tr><th>Médico Coordenador</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>CRM</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>Médico Emitente</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>CRM</th><td><input type="text" value="" disabled></td></tr>
        </table>

        <h3>06 - Fatores de Risco</h3>
        <textarea disabled>Físicos: Vibração, Ruído etc.</textarea>

        <h3>07 - Procedimentos / Exames Realizados</h3>
        <table>
            <tr><th>Exame</th><td><input type="text" value="Avaliação Clínica Ocupacional (0295)" disabled></td></tr>
            <tr><th>Data</th><td><input type="text" value="" disabled></td></tr>
        </table>

        <h3>08 - Aptidões Extras</h3>
        <table>
            <tr><th>Trabalho em Altura</th><td><input type="radio" disabled></td><td><input type="radio" disabled></td></tr>
            <tr><th>Operar Máquinas</th><td><input type="radio" disabled></td><td><input type="radio" disabled></td></tr>
            <tr><th>Espaço Confinado</th><td><input type="radio" disabled></td><td><input type="radio" disabled></td></tr>
        </table>

        <h3>09 - Conclusão</h3>
        <table>
            <tr><th>Cidade</th><td><input type="text" value="ALTO ARAGUAIA - MT" disabled></td></tr>
            <tr><th>Data</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>Resultado</th><td>
            <label><input type="radio" disabled> APTO</label>
            <label><input type="radio" disabled> INAPTO</label>
            </td></tr>
            <tr><th>Médico Responsável</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>CRM / CPF</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>Assinatura</th><td><div class="assinatura"></div><small>Assinatura do Médico</small></td></tr>
        </table>

        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>
        </div>

        <script>
        function enviarClinica(){
        alert("Função de envio de email para clínica ainda não implementada.");
        }
        function enviarEmpresa(){
        let msg = encodeURIComponent("Segue a guia de encaminhamento.");
        window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
        }
        </script>
        ';
    }else if(isset($recebe_processo_geraca) && strtolower(trim($recebe_processo_geraca)) === "acuidade visual")
    {
        echo '
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <title>Teste de Acuidade Visual</title>
    <style>
      body { font-family: Arial, sans-serif; background:#f2f2f2; }
      .documento {
        width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
        background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
      }
      h2 { text-align:center; margin-bottom:15px; }
      table { width:100%; border-collapse:collapse; margin-bottom:15px; }
      th, td { border:1px solid #ccc; padding:6px; font-size:13px; text-align:center; }
      th { background:#f8f9fa; }
      .bloco-titulo {
        margin:15px 0 8px 0; font-weight:bold; font-size:14px;
        background:#e9ecef; padding:6px 10px; border:1px solid #ccc; text-align:left;
      }
      .assinatura { height:40px; border-bottom:1px solid #000; margin:10px 0; }
      .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
      .options { display:flex; gap:20px; margin:5px 0; }
      .opt { display:flex; align-items:center; gap:5px; font-size:13px; }
      input { border:none; background:transparent; width:100%; text-align:center; }
      input:disabled { color:#000; }

      /* Botões de ação */
      .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
      .btn {
        padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
        cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
      }
      .btn-email { background:#007bff; }
      .btn-whatsapp { background:#25d366; }
      .btn-print { background:#6c757d; }
      .btn:hover { opacity:.9; }

      @media print { body { background:#fff; } .actions { display:none; } }
    </style>
    </head>
    <body>

    <div class="documento">
      <h2>TESTE DE ACUIDADE VISUAL</h2>

      <div class="bloco-titulo">Identificação</div>
      <table>
        <tr>
          <th>Nome</th><td>AGNALDO MORAIS MENDES</td>
          <th>Código</th><td>4732661300</td>
        </tr>
        <tr>
          <th>Cidade</th><td>RONDONOPOLIS</td>
          <th>Função</th><td>AJUDANTE DE ELETRICISTA</td>
        </tr>
        <tr>
          <th>Empresa</th><td colspan="3">ECOPROJ</td>
        </tr>
      </table>

      <div class="bloco-titulo">Questionário</div>
      <table>
        <tr><th>1) Usa óculos / lentes de contato?</th><td>Não</td></tr>
        <tr><th>2) Já teve algum problema com os olhos?</th><td>Não</td></tr>
        <tr><th>3) Exame será realizado com óculos/lentes?</th><td>Não</td></tr>
      </table>

      <div class="bloco-titulo">Tabela de Snellen</div>
      <table>
        <tr>
          <th></th>
          <th>20/200</th><th>20/100</th><th>20/50</th><th>20/40</th><th>20/30</th>
          <th>20/25</th><th>20/20</th><th>20/15</th><th>20/13</th><th>20/10</th>
        </tr>
        <tr><th>OD</th><td colspan="10">X</td></tr>
        <tr><th>OE</th><td colspan="10">X</td></tr>
        <tr><th>AO</th><td colspan="10">X</td></tr>
      </table>

      <div class="bloco-titulo">Carta de Jeager (Visão de Perto)</div>
      <table>
        <tr><th>J6</th><th>J5</th><th>J4</th><th>J3</th><th>J2</th><th>J1</th></tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td>X</td></tr>
      </table>

      <div class="bloco-titulo">Teste de Ishihara</div>
      <div class="options">
        <label class="opt"><input type="checkbox" checked disabled> Normal</label>
        <label class="opt"><input type="checkbox" disabled> Alterado</label>
      </div>

      <div class="bloco-titulo">Conclusão</div>
      <table>
        <tr><th>Tabela de Snellen</th><td>Normal</td></tr>
        <tr><th>Carta de Jeager</th><td>Normal</td></tr>
      </table>

      <div class="bloco-titulo">Assinaturas</div>
      <table>
        <tr><th>Data</th><td>22/01/2025</td></tr>
        <tr><th>Examinador</th><td><div class="assinatura"></div></td></tr>
        <tr><th>Colaborador</th><td><div class="assinatura"></div></td></tr>
      </table>

      <div class="actions">
        <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
        <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
        <button class="btn btn-print" onclick="window.print()">Salvar</button>
      </div>
    </div>

    <script>
    function enviarClinica(){
      alert("Função de envio de email para clínica ainda não implementada.");
    }
    function enviarEmpresa(){
      var msg = encodeURIComponent("Segue o Teste de Acuidade Visual.");
      window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
    }
    </script>

    </body>
    </html>
    ';


    echo '<style>
        body { font-family: Arial, sans-serif; background:#f2f2f2; }
        .guia-container {
            width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
            background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
        }
        h2 { text-align:center; margin-bottom:20px; }
        h3 {
            margin-top:20px; margin-bottom:10px;
            background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
        }
        table { width:100%; border-collapse:collapse; margin-bottom:15px; }
        th, td { border:1px solid #ccc; padding:6px; font-size:13px; text-align:left; }
        th { background:#f8f9fa; width:30%; }
        input, textarea {
            width:100%; border:none; background:transparent; font-size:13px;
        }
        input:disabled, textarea:disabled {
            color:#000; cursor:not-allowed;
        }
        .assinatura { height:40px; border-bottom:1px solid #000; margin-top:10px; }
        .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
        .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
        .btn {
            padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
            cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
        }
        .btn-email { background:#007bff; }
        .btn-whatsapp { background:#25d366; }
        .btn-print { background:#6c757d; }
        .btn:hover { opacity:.9; }
        @media print { .actions { display:none; } body { background:#fff; } }
    </style>

    <div class="guia-container">
        <h2>Laudo de Audiometria Tonal</h2>

        <h3>01 - Identificação</h3>
        <table>
            <tr><th>Paciente</th><td><input type="text" value="Bruno Henrique" disabled></td></tr>
            <tr><th>Data</th><td><input type="text" value="02/10/2023" disabled></td></tr>
            <tr><th>Sexo</th><td><input type="text" value="M" disabled></td></tr>
            <tr><th>Profissão</th><td><input type="text" value="Motorista" disabled></td></tr>
            <tr><th>Encaminhado por</th><td><input type="text" value="Samaritano Medicina do Trabalho" disabled></td></tr>
        </table>

        <h3>02 - Audiometria Tonal Limiar</h3>
        <table>
            <tr>
                <th>Orelha Direita (OD)</th>
                <td><input type="text" value="Média: 22 dB" disabled></td>
            </tr>
            <tr>
                <th>Orelha Esquerda (OE)</th>
                <td><input type="text" value="Média: 16 dB" disabled></td>
            </tr>
        </table>

        <h3>03 - Logoaudiometria</h3>
        <table>
            <tr><th>Lim. Reconhecimento de Fala (OD)</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>Lim. Reconhecimento de Fala (OE)</th><td><input type="text" value="" disabled></td></tr>
            <tr><th>Índice de Reconhecimento de Fala</th><td><input type="text" value="Monossílabos / Dissílabos / Dissílabos" disabled></td></tr>
        </table>

        <h3>04 - Exames Complementares</h3>
        <table>
            <tr><th>Weber Audiométrico</th><td><input type="text" value="Sem alterações" disabled></td></tr>
            <tr><th>Tone Decay Técnica Rosenberg</th><td><input type="text" value="Normal" disabled></td></tr>
        </table>

        <h3>05 - Parecer Fonoaudiólogo</h3>
        <textarea disabled>Mínima alteração auditiva neurossensorial unilateral em OD.</textarea>

        <h3>06 - Assinaturas</h3>
        <table>
            <tr>
                <th>Paciente</th>
                <td><div class="assinatura"></div><small>Assinatura do Paciente</small></td>
            </tr>
            <tr>
                <th>Médico Responsável</th>
                <td><div class="assinatura"></div><small>Assinatura e Carimbo do Médico</small></td>
            </tr>
        </table>

        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>
    </div>

    <script>
    function enviarClinica(){
        alert("Função de envio de email para clínica ainda não implementada.");
    }
    function enviarEmpresa(){
        let msg = encodeURIComponent("Segue o laudo de audiometria.");
        window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
    }
    </script>
    ';

    echo '<style>
        body { font-family: Arial, sans-serif; background:#f2f2f2; }
        .guia-container {
            width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
            background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
        }
        h2 { text-align:center; margin-bottom:20px; }
        h3 {
            margin-top:20px; margin-bottom:10px;
            background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
        }
        table { width:100%; border-collapse:collapse; margin-bottom:15px; }
        th, td { border:1px solid #ccc; padding:6px; font-size:13px; text-align:left; }
        th { background:#f8f9fa; }
        input, textarea {
            width:100%; border:none; background:transparent; font-size:13px;
        }
        input:disabled, textarea:disabled { color:#000; cursor:not-allowed; }
        .assinatura { height:40px; border-bottom:1px solid #000; margin-top:10px; }
        .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
        .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
        .btn {
            padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
            cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
        }
        .btn-email { background:#007bff; }
        .btn-whatsapp { background:#25d366; }
        .btn-print { background:#6c757d; }
        .btn:hover { opacity:.9; }
        @media print { .actions { display:none; } body { background:#fff; } }
    </style>

    <div class="guia-container">
        <h2>QUESTIONÁRIO PSICOSSOCIAL</h2>

        <h3>01 - Identificação</h3>
        <table>
            <tr><th>Nome</th><td><input type="text" value="________________" disabled></td><th>Data</th><td><input type="text" value="__/__/____" disabled></td></tr>
            <tr><th>RG</th><td><input type="text" value="___________" disabled></td><th>Telefone</th><td><input type="text" value="____________" disabled></td></tr>
            <tr><th>Idade</th><td><input type="text" value="___" disabled></td><th>Peso</th><td><input type="text" value="___ kg" disabled></td></tr>
            <tr><th>Altura</th><td><input type="text" value="___ cm" disabled></td><td colspan="2"></td></tr>
        </table>

        <h3>02 - Avaliação da Qualidade do Sono</h3>
        <table>
            <tr><td>1. Você leva mais de 30 minutos para adormecer?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>2. Você acorda muitas vezes durante a noite?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>3. E quando acorda, demora muito para voltar a dormir?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>4. Seu sono é agitado, inquieto?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>5. Precisa de um despertador para acordar?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>6. Tem dificuldades para levantar de manhã?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>7. Sente-se cansado ao longo do dia?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>8. Já sofreu algum acidente de estepe por dormir pouco?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>9. Cochila diante da TV ou em outras situações?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>10. Dorme mais nos finais de semana?</td><td>Sim ( ) Não ( )</td></tr>
        </table>

        <h3>03 - Escala de Sonolência Diurna (Epworth)</h3>
        <table>
            <tr><th>Situação</th><th>Nunca (0)</th><th>Pouca (1)</th><th>Média (2)</th><th>Grande (3)</th></tr>
            <tr><td>Lendo</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Assistindo TV</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Em local público</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Como passageiro em carro</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Conversando com alguém</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Sentado calmamente</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Após almoço sem álcool</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>No carro, parado no trânsito</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
        </table>

        <h3>04 - Escala de Fadiga de Chalder</h3>
        <table>
            <tr><th>Sintomas Físicos</th><th>Nunca</th><th>Como Normal</th><th>Mais que Normal</th><th>Muito mais</th></tr>
            <tr><td>Vorça muscular reduzida?</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Você sente fraqueza?</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
        </table>

        <h3>05 - Avaliação Psicológica / SRQ</h3>
        <table>
            <tr><td>Você tem dores de cabeça frequentes?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>Você dorme mal?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>Você tem má digestão?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>Você tem dificuldade para pensar com clareza?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>Você se sente inútil, sem préstimo?</td><td>Sim ( ) Não ( )</td></tr>
        </table>

        <h3>06 - Distúrbio de Uso do Álcool (AUDIT)</h3>
        <table>cê tem problemas com cansaço?</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Você precisa descansar mais?</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Você sente sono ou sonolência?</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Você tem problemas para começar coisas?</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Fica cansado quando começa?</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Você está perdendo energia?</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Fo
            <tr><th>Pergunta</th><th>0</th><th>1</th><th>2</th><th>3</th><th>4</th></tr>
            <tr><td>Frequência de consumo</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Quantidade ingerida</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
            <tr><td>Beber 6 ou mais em uma ocasião</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td><td>( )</td></tr>
        </table>

        <h3>07 - Teste de Nicotina de Fagerstrom</h3>
        <table>
            <tr><td>Quanto tempo após acordar você fuma o primeiro cigarro?</td><td>( ) 5 min ( ) 6-30 ( ) 31-60 ( ) >60</td></tr>
            <tr><td>Você fuma mais pela manhã?</td><td>Sim ( ) Não ( )</td></tr>
            <tr><td>Você fuma mesmo doente?</td><td>Sim ( ) Não ( )</td></tr>
        </table>

        <h3>08 - Assinatura</h3>
        <div class="assinatura"></div>
        <small>Assinatura do Avaliado</small>

        <div class="actions">
            <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
            <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
            <button class="btn btn-print" onclick="window.print()">Salvar</button>
        </div>
    </div>

    <script>
    function enviarClinica(){
        alert("Função de envio de email para clínica ainda não implementada.");
    }
    function enviarEmpresa(){
        let msg = encodeURIComponent("Segue o Questionário Psicossocial preenchido.");
        window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
    }
    </script>
    ';

    echo 
      '<style>
      body { font-family: Arial, sans-serif; background:#f2f2f2; }
      .guia-container {
          width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
          background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
      }
      h2 { text-align:center; margin-bottom:20px; }
      h3 {
          margin-top:20px; margin-bottom:10px;
          background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
      }
      table { width:100%; border-collapse:collapse; margin-bottom:15px; }
      th, td { border:1px solid #ccc; padding:6px; font-size:13px; text-align:left; }
      th { background:#f8f9fa; width:30%; }
      input, textarea {
          width:100%; border:none; background:transparent; font-size:13px;
      }
      input:disabled, textarea:disabled { color:#000; cursor:not-allowed; }
      .assinatura { height:40px; border-bottom:1px solid #000; margin-top:10px; }
      .assinatura small { display:block; text-align:center; font-size:12px; color:#666; }
      .actions { margin-top:25px; display:flex; gap:15px; justify-content:center; }
      .btn {
          padding:10px 18px; font-size:14px; font-weight:bold; border:none; border-radius:5px;
          cursor:pointer; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);
      }
      .btn-email { background:#007bff; }
      .btn-whatsapp { background:#25d366; }
      .btn-print { background:#6c757d; }
      .btn:hover { opacity:.9; }
      @media print { .actions { display:none; } body { background:#fff; } }
  </style>

  <div class="guia-container">
      <h2>GUIA DE ENCAMINHAMENTO - EXAME TOXICOLÓGICO</h2>

      <h3>01 - Encaminhado por</h3>
      <table>
          <tr><th>Empresa</th><td><input type="text" value="PROMAIS SAÚDE E SEGURANÇA DO TRABALHO" disabled></td></tr>
          <tr><th>CNPJ</th><td><input type="text" value="19.464.436/0001-60" disabled></td></tr>
          <tr><th>Endereço</th><td><input type="text" value="Rua Antonio Aires Favero, 647, Bairro: Atlântico" disabled></td></tr>
          <tr><th>Cidade / UF</th><td><input type="text" value="Alto Araguaia - MT, CEP 78780-000" disabled></td></tr>
          <tr><th>Telefone</th><td><input type="text" value="(66) 3481-3786 / (66) 99967-2766" disabled></td></tr>
      </table>

      <h3>02 - Tipo de Exame</h3>
      <p>Exame Toxicológico ( X )</p>

      <h3>03 - Dados do Funcionário / Empresa</h3>
      <table>
          <tr><th>Empresa</th><td><input type="text" value="PROMAIS SAÚDE E SEGURANÇA DO TRABALHO" disabled></td></tr>
          <tr><th>CNPJ / CAEPF</th><td><input type="text" value="19.464.436/0001-60" disabled></td></tr>
          <tr><th>Nome do Funcionário</th><td><input type="text" value="Amanda Aparecida Carvalho Rodrigues" disabled></td></tr>
          <tr><th>CPF</th><td><input type="text" value="072.143.511-45" disabled></td></tr>
          <tr><th>Data de Nascimento</th><td><input type="text" value="08/10/1998" disabled></td></tr>
          <tr><th>Idade</th><td><input type="text" value="25 anos" disabled></td></tr>
          <tr><th>RG</th><td><input type="text" value="2943351 - SSP/MT" disabled></td></tr>
          <tr><th>Telefone</th><td><input type="text" value="(66) 99656-4161" disabled></td></tr>
          <tr><th>Cidade</th><td><input type="text" value="Santa Rita do Araguaia - GO, CEP 75840-000" disabled></td></tr>
          <tr><th>Cargo</th><td><input type="text" value="Lubricador de Veículos Automotores (exceto embarcações)" disabled></td></tr>
          <tr><th>CBO</th><td><input type="text" value="621005" disabled></td></tr>
      </table>

      <h3>07 - Procedimentos / Exames Realizados</h3>
      <table>
          <tr><th>Exame</th><td><input type="text" value="Exame Toxicológico (AA999999999)" disabled></td></tr>
          <tr><th>Data</th><td><input type="text" value="__/__/2024" disabled></td></tr>
      </table>

      <h3>09 - Conclusão</h3>
      <table>
          <tr><th>Cidade</th><td><input type="text" value="Alto Araguaia - MT" disabled></td></tr>
          <tr><th>Data</th><td><input type="text" value="__/__/2024" disabled></td></tr>
          <tr>
              <th>Assinaturas</th>
              <td>
                  <div class="assinatura"></div><small>Assinatura do Funcionário</small>
                  <br><br>
                  <div class="assinatura"></div><small>Carimbo / Responsável</small>
              </td>
          </tr>
      </table>

      <div class="actions">
          <button class="btn btn-email" onclick="enviarClinica()">Enviar Email Clínica</button>
          <button class="btn btn-whatsapp" onclick="enviarEmpresa()">Empresa (WhatsApp)</button>
          <button class="btn btn-print" onclick="window.print()">Salvar</button>
      </div>
  </div>

  <script>
  function enviarClinica(){
      alert("Função de envio de email para clínica ainda não implementada.");
  }
  function enviarEmpresa(){
      let msg = encodeURIComponent("Segue a guia de encaminhamento para Exame Toxicológico.");
      window.open("https://wa.me/5599999999999?text=" + msg, "_blank");
  }
  </script>
  ';
    }
}
?>