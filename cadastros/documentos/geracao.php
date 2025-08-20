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

    if (isset($recebe_processo_geraca) && strtolower(trim($recebe_processo_geraca)) === "guia_de_encaminhamento") {
        echo '
<style>
  :root { --ink:#111; --line:#000; --muted:#666; --soft:#f1f3f5; --gap:10px; }
  * { box-sizing: border-box; }
  body { background:#f5f6f8; font-family: Arial, Helvetica, sans-serif; color:var(--ink); }
  .sheet {
    width: 210mm; min-height: 297mm; margin: 12mm auto; padding: 12mm;
    background:#fff; border:1px solid #ddd; box-shadow: 0 6px 24px rgba(0,0,0,.08);
  }
  .doc-title { text-align:center; font-weight:700; letter-spacing:.5px; margin-bottom:14px; font-size:18px; }
  .topbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
  .logo-box { width: 140px; height: 50px; border:1px solid var(--line); display:flex; align-items:center; justify-content:center; font-size:12px; }

  .section { margin-top: 14px; }
  .section-header {
    display:flex; align-items:center; gap:10px; background:var(--soft); border:1px solid var(--line);
    padding:6px 8px; font-weight:700; letter-spacing:.3px; font-size:12px; text-transform:uppercase;
  }
  .badge {
    min-width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center;
    border:1px solid var(--line); background:#fff; font-weight:700;
  }

  table.form, table.aptidao { width:100%; border-collapse:collapse; margin-top:6px; font-size:12px; }
  table.form th, table.form td, table.aptidao th, table.aptidao td { border:1px solid var(--line); padding:6px 8px; vertical-align:middle; }
  table.form th { background:#fafafa; width: 28%; text-align:left; font-weight:700; }
  table.form td { background:#fff; }

  input[type=text], input[type=date], input[type=tel], input[type=number], textarea {
    width:100%; border:none; outline:none; padding:2px 0; font-size:12px; background:transparent;
  }
  textarea { min-height: 70px; border:1px dashed #999; padding:6px; resize:vertical; }

  .options { display:flex; flex-wrap:wrap; gap:14px 18px; padding:6px 2px; }
  .opt { display:inline-flex; align-items:center; gap:6px; }
  .muted { color:var(--muted); font-size:11px; }

  .assinatura { height:40px; display:flex; align-items:flex-end; }
  .assinatura .linha { width:100%; border-bottom:1px solid var(--line); }
  .assinatura small { display:block; text-align:center; margin-top:4px; color:var(--muted); }

  @media print {
    body { background:#fff; }
    .sheet { margin:0; box-shadow:none; border-color:#000; }
    a { color:inherit; text-decoration:none; }
  }
</style>

<div class="sheet guia-encaminhamento">
  <div class="doc-title">GUIA DE ENCAMINHAMENTO</div>
  <div class="topbar">
    <div class="muted">Preencha todos os campos legíveis.</div>
    <div class="logo-box">LOGO</div>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">01</span> Identificação</div>
    <table class="form">
      <tr><th>Hospital/Clínica</th><td><input type="text" name="hospital" value="HOSPITAL BOM SAMARITANO"></td></tr>
      <tr><th>CNPJ</th><td><input type="text" name="cnpj" value="01.362.987/0001-57"></td></tr>
      <tr><th>Endereço</th><td><input type="text" name="endereco" value="RUA 24 DE FEVEREIRO, S/N - BAIRRO: BOIADEIRO"></td></tr>
      <tr><th>Cidade / UF</th><td><input type="text" name="cidade" value="ALTO ARAGUAIA - MT"></td></tr>
      <tr><th>Telefone</th><td><input type="text" name="telefone" value="(66) 3481-1880"></td></tr>
      <tr><th>Logo (quem emite)</th><td class="muted">Anexe sua logomarca na caixa LOGO acima.</td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">02</span> Tipo de Exame / Procedimento</div>
    <div class="options">
      <label class="opt"><input type="radio" name="tipo_exame" value="ADMISSIONAL"> Admissional</label>
      <label class="opt"><input type="radio" name="tipo_exame" value="PERIODICO"> Periódico</label>
      <label class="opt"><input type="radio" name="tipo_exame" value="DEMISSIONAL"> Demissional</label>
      <label class="opt"><input type="radio" name="tipo_exame" value="MUDANCA_FUNCAO"> Mudança de Risco/Função</label>
      <label class="opt"><input type="radio" name="tipo_exame" value="RETORNO"> Retorno ao Trabalho</label>
    </div>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">03</span> Dados do Funcionário / Empresa</div>
    <table class="form">
      <tr><th>Empresa (Razão Social)</th><td><input type="text" name="empresa" value="PROMAIS SAÚDE E SEGURANÇA DO TRABALHO"></td></tr>
      <tr><th>CNPJ/CAEPF</th><td><input type="text" name="cnpj_empresa" value="19.464.436/0001-60"></td></tr>
      <tr><th>Endereço</th><td><input type="text" name="endereco_empresa" placeholder=""></td></tr>
      <tr><th>Telefone</th><td><input type="text" name="telefone_empresa" placeholder=""></td></tr>
      <tr><th>Nome do Funcionário</th><td><input type="text" name="funcionario" placeholder=""></td></tr>
      <tr><th>Cargo</th><td><input type="text" name="cargo" placeholder="Ex.: Lubrificador de Veículos Automotores (exceto embarcações)"></td></tr>
      <tr><th>CBO</th><td><input type="text" name="cbo" placeholder="621005"></td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">04</span> Em Caso de Mudança de Risco/Função</div>
    <table class="form">
      <tr><th>Novo Cargo</th><td><input type="text" name="novo_cargo" placeholder="Ex.: Trabalhador de Pecuária Polivalente"></td></tr>
      <tr><th>Novo CBO</th><td><input type="text" name="novo_cbo" placeholder="623015"></td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">05</span> Dados dos Médicos</div>
    <table class="form">
      <tr><th>Médico Coordenador (PCMSO)</th><td><input type="text" name="medico_coord" placeholder=""></td></tr>
      <tr><th>CRM (Coordenador)</th><td><input type="text" name="crm_coord" placeholder="Ex.: 819/MT"></td></tr>
      <tr><th>Médico Emitente</th><td><input type="text" name="medico_emit" placeholder=""></td></tr>
      <tr><th>CRM (Emitente)</th><td><input type="text" name="crm_emit" placeholder="Ex.: 819/MT"></td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">06</span> Descrição de Fatores de Risco (PGR/PCMSO)</div>
    <textarea name="fatores_risco" placeholder="Ex.: Físicos: Vibração de Corpo Inteiro (02.01.003), VDVR (02.01.004), Ruído (02.01.001 e 01.01.021). Ergonômicos: ... Químicos: ... Biológicos: ..."></textarea>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">07</span> Procedimentos / Exames Realizados</div>
    <table class="form">
      <tr><th>Exame/Procedimento</th><td><input type="text" name="exame1" value="Avaliação Clínica Ocupacional (Anamnese e Exame físico) (0295)"></td></tr>
      <tr><th>Data</th><td><input type="date" name="data_exame1"></td></tr>
      <tr><th>Exame/Procedimento</th><td><input type="text" name="exame2" placeholder=""></td></tr>
      <tr><th>Data</th><td><input type="date" name="data_exame2"></td></tr>
      <tr><th>Exame/Procedimento</th><td><input type="text" name="exame3" placeholder=""></td></tr>
      <tr><th>Data</th><td><input type="date" name="data_exame3"></td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">08</span> Aptidões Extras</div>
    <table class="aptidao">
      <tr><th>Atividade</th><th style="width:80px; text-align:center;">Sim</th><th style="width:80px; text-align:center;">Não</th></tr>
      <tr><td>Trabalho em Altura</td><td style="text-align:center;"><input type="radio" name="apt_altura" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_altura" value="NAO"></td></tr>
      <tr><td>Manusear Produtos Alimentícios</td><td style="text-align:center;"><input type="radio" name="apt_alimentos" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_alimentos" value="NAO"></td></tr>
      <tr><td>Trabalho com Eletricidade</td><td style="text-align:center;"><input type="radio" name="apt_eletricidade" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_eletricidade" value="NAO"></td></tr>
      <tr><td>Operar Máquinas e Equipamentos</td><td style="text-align:center;"><input type="radio" name="apt_maquinas" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_maquinas" value="NAO"></td></tr>
      <tr><td>Conduzir Veículos</td><td style="text-align:center;"><input type="radio" name="apt_veiculos" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_veiculos" value="NAO"></td></tr>
      <tr><td>Trabalho a Quente</td><td style="text-align:center;"><input type="radio" name="apt_quente" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_quente" value="NAO"></td></tr>
      <tr><td>Trabalho com Líquidos Inflamáveis</td><td style="text-align:center;"><input type="radio" name="apt_inflamaveis" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_inflamaveis" value="NAO"></td></tr>
      <tr><td>Exposição a Radiações Ionizantes</td><td style="text-align:center;"><input type="radio" name="apt_radiacao" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_radiacao" value="NAO"></td></tr>
      <tr><td>Trabalho em Espaço Confinado</td><td style="text-align:center;"><input type="radio" name="apt_espaco" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_espaco" value="NAO"></td></tr>
      <tr><td>Inspeções e Manutenções em Máquinas e Equipamentos</td><td style="text-align:center;"><input type="radio" name="apt_inspecoes" value="SIM"></td><td style="text-align:center;"><input type="radio" name="apt_inspecoes" value="NAO"></td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-header"><span class="badge">09</span> Conclusão do Exame</div>
    <table class="form">
      <tr><th>Cidade / UF</th><td><input type="text" name="cidade_conclusao" value="ALTO ARAGUAIA - MT"></td></tr>
      <tr><th>Data</th><td><input type="date" name="data_conclusao"></td></tr>
      <tr><th>Resultado</th><td><div class="options"><label class="opt"><input type="radio" name="resultado" value="APTO"> APTO</label><label class="opt"><input type="radio" name="resultado" value="INAPTO"> INAPTO</label></div></td></tr>
      <tr><th>Médico Responsável</th><td><input type="text" name="medico_resp" placeholder=""></td></tr>
      <tr><th>CRM / CPF</th><td><div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;"><input type="text" name="crm_resp" placeholder="CRM"><input type="text" name="cpf_resp" placeholder="CPF"></div></td></tr>
      <tr><th>Assinatura</th><td><div class="assinatura"><div class="linha"></div></div><small>Assinatura do Médico</small></td></tr>
    </table>
  </div>
</div>
';
    }
}
?>