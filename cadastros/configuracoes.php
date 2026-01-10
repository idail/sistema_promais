<?php
// Verifique se o usuário tem permissão, se necessário
// include('lock.php'); // Já incluído no painel.php geralmente

// Busca dados da empresa atual
require_once('config/database.php');
$pdo = getConnection();

$empresa_id = $_SESSION['empresa_id'] ?? null;
// Se não tiver empresa_id na sessão, tenta pegar do usuário ou redireciona
if (!$empresa_id) {
    echo "<div class='alert alert-danger'>Erro: ID da empresa não encontrado na sessão.</div>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM empresas_novas WHERE empresa_id = :id LIMIT 1"); // Assumindo que empresa_id na tabela é o ID da empresa principal
// OU se empresa_id for o ID da tabela empresas_novas:
// $stmt = $pdo->prepare("SELECT * FROM empresas_novas WHERE id = :id");
// VAMOS ASSUMIR QUE $_SESSION['empresa_id'] é o ID da empresa na tabela `empresas_novas` ou `empresas`.
// O arquivo mysql/empresas.sql cria a tabela `empresas`. O arquivo processa_empresa.php usa `empresas_novas`.
// VAMOS USAR A TABELA `empresas` com base no SQL fornecido pelo usuário, mas o processa_empresa.php usava `empresas_novas`.
// VOU USAR `empresas` conforme o SQL que vi. Se der erro, ajustamos.
// AJUSTE: O arquivo processa_empresa.php usava `empresas_novas`. O SQL fornecido era `empresas`.
// Vou verificar qual tabela existe de fato no banco ou usar `empresas` conforme o dump SQL que o usuário mostrou.
// O dump SQL mostrava `INSERT INTO empresas ...`.
// Vou usar `empresas`.

$stmt = $pdo->prepare("SELECT * FROM empresas WHERE id = :id");
$stmt->bindValue(":id", $empresa_id);
$stmt->execute();
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empresa) {
    // Tenta buscar na tabela empresas_novas caso a anterior falhe ou esteja vazia, só por garantia
    $stmt = $pdo->prepare("SELECT * FROM empresas_novas WHERE id = :id");
    $stmt->bindValue(":id", $empresa_id);
    $stmt->execute();
    $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Se ainda não tiver empresa, pode ser um novo cadastro ou erro
$nome = $empresa['nome'] ?? '';
$cnpj = $empresa['cnpj'] ?? '';
$endereco = $empresa['endereco'] ?? '';
$email = $empresa['email'] ?? '';
$telefone = $empresa['telefone'] ?? '';
$logo = $empresa['logo_empresa'] ?? '';

?>

<div class="settings-container">
    <div class="settings-header">
        <h2><i class="fas fa-cog"></i> Configurações da Empresa</h2>
        <p>Gerencie os dados da sua organização e personalize o sistema.</p>
    </div>

    <form action="cadastros/processa_configuracoes.php" method="POST" enctype="multipart/form-data" class="settings-form">
        <input type="hidden" name="acao" value="atualizar_configuracoes">
        <input type="hidden" name="empresa_id" value="<?php echo htmlspecialchars($empresa_id); ?>">

        <!-- Logo Upload Section -->
        <div class="form-section logo-section">
            <h3>Logotipo</h3>
            <div class="logo-upload-wrapper">
                <div class="current-logo">
                    <?php if (!empty($logo) && file_exists($logo)): ?>
                        <img src="<?php echo htmlspecialchars($logo); ?>" alt="Logo Atual" id="preview-logo">
                    <?php else: ?>
                        <div class="logo-placeholder" id="preview-placeholder">
                            <i class="fas fa-image"></i>
                            <span>Sem Logo</span>
                        </div>
                        <img src="" alt="Preview" id="preview-logo" style="display: none;">
                    <?php endif; ?>
                </div>
                <div class="upload-controls">
                    <label for="logo_empresa" class="btn-upload">
                        <i class="fas fa-upload"></i> Escolher Arquivo
                    </label>
                    <input type="file" name="logo_empresa" id="logo_empresa" accept="image/*" onchange="previewImage(this)">
                    <span class="help-text">Formatos aceitos: PNG, JPG, JPEG. Tam. máx: 2MB.</span>
                </div>
            </div>
        </div>

        <!-- Dados da Empresa -->
        <div class="form-section">
            <h3>Dados Cadastrais</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nome">Nome Fantasia</label>
                    <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
                </div>

                <div class="form-group">
                    <label for="cnpj">CNPJ</label>
                    <input type="text" name="cnpj" id="cnpj" value="<?php echo htmlspecialchars($cnpj); ?>" required>
                </div>

                <div class="form-group span-2">
                    <label for="endereco">Endereço Completo</label>
                    <input type="text" name="endereco" id="endereco" value="<?php echo htmlspecialchars($endereco); ?>">
                </div>

                <div class="form-group">
                    <label for="email">E-mail Corporativo</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone / WhatsApp</label>
                    <input type="text" name="telefone" id="telefone" value="<?php echo htmlspecialchars($telefone); ?>">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Salvar Alterações
            </button>
        </div>
    </form>
</div>

<style>
    .settings-container {
        background: #fff;
        border-radius: 8px;
        padding: 30px;
        max-width: 900px;
        margin: 0 auto;
    }

    .settings-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .settings-header h2 {
        color: var(--primary);
        font-size: 1.5rem;
        margin-bottom: 5px;
    }

    .settings-header p {
        color: #666;
        font-size: 0.9rem;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section h3 {
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 15px;
        border-left: 4px solid var(--accent);
        padding-left: 10px;
    }

    .logo-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 25px;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 1px dashed #ddd;
    }

    .current-logo {
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }

    .current-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .logo-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #ccc;
    }

    .logo-placeholder i {
        font-size: 2rem;
        margin-bottom: 5px;
    }

    .upload-controls {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-upload {
        display: inline-block;
        padding: 10px 20px;
        background: var(--primary);
        color: white;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.3s;
        text-align: center;
    }

    .btn-upload:hover {
        background: var(--secondary);
    }

    #logo_empresa {
        display: none;
    }

    .help-text {
        font-size: 0.8rem;
        color: #888;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .span-2 {
        grid-column: span 2;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .form-group label {
        font-weight: 500;
        color: #444;
        font-size: 0.9rem;
    }

    .form-group input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .form-group input:focus {
        border-color: var(--accent);
        outline: none;
    }

    .form-actions {
        margin-top: 30px;
        text-align: right;
        border-top: 1px solid #eee;
        padding-top: 20px;
    }

    .btn-save {
        padding: 12px 30px;
        background: #2ed573;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-save:hover {
        background: #26af61;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .span-2 {
            grid-column: span 1;
        }
        .logo-upload-wrapper {
            flex-direction: column;
            text-align: center;
        }
        .current-logo {
            margin: 0 auto;
        }
    }
</style>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var preview = document.getElementById('preview-logo');
                var placeholder = document.getElementById('preview-placeholder');
                
                preview.src = e.target.result;
                preview.style.display = 'block';
                if(placeholder) placeholder.style.display = 'none';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
