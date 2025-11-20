<?php
require_once('conexao.php');

$acao = $_POST['acao'] ?? '';

if ($acao === 'create' || $acao === 'update') {
    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $descricao = $_POST['descricao'];

    // Upload da imagem
    $imagem = null;
    if (!empty($_FILES['imagem']['name'])) {
        $nomeImagem = time() . "_" . basename($_FILES['imagem']['name']);
        $caminho = "uploads/" . $nomeImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem = $nomeImagem;
        }
    }

    if ($acao === 'create') {
        $stmt = $conexao->prepare("INSERT INTO produtos (nome, categoria, preco, estoque, descricao, imagem) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiis", $nome, $categoria, $preco, $estoque, $descricao, $imagem);
        $stmt->execute();
        header("Location: super-administrador.php?ok=Produto adicionado com sucesso!");
    }

    if ($acao === 'update') {
        $id = $_POST['id'];
        if ($imagem) {
            $stmt = $conexao->prepare("UPDATE produtos SET nome=?, categoria=?, preco=?, estoque=?, descricao=?, imagem=? WHERE id=?");
            $stmt->bind_param("ssdiisi", $nome, $categoria, $preco, $estoque, $descricao, $imagem, $id);
        } else {
            $stmt = $conexao->prepare("UPDATE produtos SET nome=?, categoria=?, preco=?, estoque=?, descricao=? WHERE id=?");
            $stmt->bind_param("ssdisi", $nome, $categoria, $preco, $estoque, $descricao, $id);
        }
        $stmt->execute();
        header("Location: super-administrador.php?ok=Produto atualizado com sucesso!");
    }
}

if ($acao === 'delete') {
    $id = $_POST['id'];
    $stmt = $conexao->prepare("DELETE FROM produtos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: super-administrador.php?ok=Produto excluído com sucesso!");
}
?>
