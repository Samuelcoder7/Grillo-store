<?php
session_start();
require_once('middleware-super-admin.php');
require_once('conexao.php');

// Retorna para a página admin com mensagem
function redirect($msg = '', $success = true) {
    $tipo = $success ? 'ok' : 'erro';
    header("Location: super-administrador.php?$tipo=" . urlencode($msg));
    exit;
}

$acao = isset($_POST['acao']) ? $_POST['acao'] : '';

if ($acao === 'create') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);
    $estoque = intval($_POST['estoque'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');

    if ($nome === '') {
        redirect('Nome do produto é obrigatório.', false);
    }

    $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, categoria) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) redirect('Erro de preparação SQL: ' . $conexao->error, false);

    $stmt->bind_param('ssdis', $nome, $descricao, $preco, $estoque, $categoria);
    $executou = $stmt->execute();
    $stmt->close();

    if ($executou) {
        redirect('Produto criado com sucesso.');
    } else {
        redirect('Falha ao criar produto: ' . $conexao->error, false);
    }

} elseif ($acao === 'update') {
    $id = intval($_POST['id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);
    $estoque = intval($_POST['estoque'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');

    if ($id <= 0) redirect('ID inválido para edição.', false);
    if ($nome === '') redirect('Nome do produto é obrigatório.', false);

    $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, estoque = ?, categoria = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) redirect('Erro de preparação SQL: ' . $conexao->error, false);

    $stmt->bind_param('ssdisi', $nome, $descricao, $preco, $estoque, $categoria, $id);
    $executou = $stmt->execute();
    $stmt->close();

    if ($executou) redirect('Produto atualizado com sucesso.');
    else redirect('Falha ao atualizar: ' . $conexao->error, false);

} elseif ($acao === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) redirect('ID inválido para exclusão.', false);

    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) redirect('Erro de preparação SQL: ' . $conexao->error, false);

    $stmt->bind_param('i', $id);
    $executou = $stmt->execute();
    $stmt->close();

    if ($executou) redirect('Produto excluído com sucesso.');
    else redirect('Falha ao excluir: ' . $conexao->error, false);

} else {
    redirect('Ação inválida.', false);
}

?>