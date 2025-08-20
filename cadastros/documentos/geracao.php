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

    if (isset($recebe_processo_geraca) && strtolower(trim($recebe_processo_geraca)) === "guia_de_encaminhamento") 
    {

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

    }
}
