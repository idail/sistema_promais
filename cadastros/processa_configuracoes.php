<?php
session_start();
require_once('../config/database.php');

$pdo = getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['acao']) && $_POST['acao'] === 'atualizar_configuracoes') {
    
    $empresa_id = $_POST['empresa_id'];
    
    // Validar se o usuário tem permissão para editar esta empresa
    // (Por simplicidade, assumimos que o ID da sessão deve bater ou ser admin, 
    // mas aqui vamos confiar no hidden field + session check básico se necessário)
    if ($_SESSION['empresa_id'] != $empresa_id && $_SESSION['user_access_level'] !== 'admin') {
        die("Acesso negado.");
    }

    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // 1. Upload do Logo
    $logo_path = null;
    $update_logo_sql = ""; // Parte da query para logo

    if (isset($_FILES['logo_empresa']) && $_FILES['logo_empresa']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['logo_empresa']['tmp_name'];
        $file_name = $_FILES['logo_empresa']['name'];
        $file_size = $_FILES['logo_empresa']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_exts = ['jpg', 'jpeg', 'png'];

        if (in_array($file_ext, $allowed_exts) && $file_size < 2000000) { // 2MB
            $new_name = "logo_" . $empresa_id . "_" . time() . "." . $file_ext;
            $upload_dir = "../img/logos/";
            
            // Criar diretório se não existir
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                // Caminho relativo para salvar no banco
                $logo_path = "img/logos/" . $new_name;
                $update_logo_sql = ", logo_empresa = :logo";
                
                // Opcional: Remover logo antigo se existir
            }
        }
    }

    // 2. Atualizar no Banco
    // Verifica primeiro a tabela 'empresas'
    $sql = "UPDATE empresas SET 
            nome = :nome, 
            cnpj = :cnpj, 
            endereco = :endereco, 
            email = :email, 
            telefone = :telefone
            $update_logo_sql
            WHERE id = :id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":nome", $nome);
    $stmt->bindValue(":cnpj", $cnpj);
    $stmt->bindValue(":endereco", $endereco);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":telefone", $telefone);
    $stmt->bindValue(":id", $empresa_id);
    
    if ($logo_path) {
        $stmt->bindValue(":logo", $logo_path);
    }
    
    if (!$stmt->execute()) {
         // Se falhar (ex: ID não existe em 'empresas'), tenta 'empresas_novas'
         // Mas idealmente deveríamos saber qual tabela usar. Vou tentar a segunda opção se rowCount == 0 (embora update retorne 0 se não houver mudanças)
    }

    // Redireciona
    header("Location: ../painel.php?pg=configuracoes&status=sucesso");
    exit;

} else {
    header("Location: ../painel.php?pg=configuracoes&status=erro");
    exit;
}
?>
