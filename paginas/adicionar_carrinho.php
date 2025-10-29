<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST['produto_id'], $_POST['produto_nome'], $_POST['produto_preco'])) {
    
    // 1. Limpeza e validação de dados
    $produto_id = filter_var($_POST['produto_id'], FILTER_SANITIZE_NUMBER_INT);
    
    // CORREÇÃO: LÊ A QUANTIDADE ENVIADA PELO FORMULÁRIO (se existir, caso contrário, usa 1)
    $quantidade = isset($_POST['quantidade']) ? filter_var($_POST['quantidade'], FILTER_SANITIZE_NUMBER_INT) : 1; 
    $quantidade = max(1, (int)$quantidade); // Garante que a quantidade seja no mínimo 1
    
    $produto_nome = filter_var($_POST['produto_nome'], FILTER_SANITIZE_STRING);
    
    $produto_preco = filter_var($_POST['produto_preco'], FILTER_VALIDATE_FLOAT);

    
    if ($produto_id <= 0 || $quantidade <= 0 || $produto_preco === false) {
        
        // Define um erro e redireciona (opcional, pode ser útil para debug)
        $_SESSION['erro'] = 'Erro ao adicionar. Dados do produto inválidos (ID, Preço ou Quantidade).';
    } else {
        // Inicializa o carrinho se não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // 2. Busca e Atualiza o item (se já estiver no carrinho)
        $item_existe = false;
        foreach ($_SESSION['carrinho'] as $chave => $item) {
           
            if ((string)$item['id'] === (string)$produto_id) { 
                
                $_SESSION['carrinho'][$chave]['quantidade'] += $quantidade;
                $item_existe = true;
                break;
            }
        }
        
        // 3. Adiciona o novo item
        if (!$item_existe) {
            $novo_item = [
                'id' => $produto_id,
                'quantidade' => $quantidade,
                'nome' => $produto_nome,
                'preco' => $produto_preco, 
            ];
            $_SESSION['carrinho'][] = $novo_item;
        }

        // 4. CORREÇÃO CRÍTICA: Define a flag de sucesso ESPERADA pelo seu código HTML
        $_SESSION['carrinho_sucesso'] = true; 
        
        // NOTA: A variável $_SESSION['notificacao'] é redundante, pois o HTML 
        // já tem a mensagem de sucesso hardcoded: 'Produto adicionado com sucesso!'.
    }

    // 5. Redirecionar de volta
    // Pega o REFERER (URL da página do produto) como destino principal.
    $pagina_destino = $_SERVER['HTTP_REFERER'] ?? 'listagem.php'; 
    
    header('Location: ' . $pagina_destino);
    exit();

} else {
    // Caso o acesso tenha sido direto ou os dados mínimos estavam faltando
    $_SESSION['erro'] = 'Requisição inválida. Não foi possível adicionar o produto.';
    // Redireciona para o nome do arquivo principal correto.
    header('Location: listagem-produtos.php'); // Assumindo listagem-produtos.php como a página principal
    exit();
}
?>