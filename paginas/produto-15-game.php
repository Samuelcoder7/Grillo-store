<?php
session_start();

// Lógica para mostrar a notificação
$mostrar_notificacao_classe = '';
$notificacao_mensagem = '';

if (isset($_SESSION['carrinho_sucesso'])) {
    $mostrar_notificacao_classe = 'visible success';
    $notificacao_mensagem = 'Produto adicionado com sucesso!';
    unset($_SESSION['carrinho_sucesso']);
} elseif (isset($_SESSION['remocao_sucesso'])) {
    $mostrar_notificacao_classe = 'visible removal';
    $notificacao_mensagem = 'Produto removido do carrinho.';
    unset($_SESSION['remocao_sucesso']);
}

// Variáveis do produto
$produto_id = 15;
$produto_nome = "Sony PlayStation 4 Pro 1TB Standard cor preto onyx 2020";
$produto_preco = 2499.00;
$produto_preco_formatado = "R$ 2.499,00";
$imagem_principal_inicial = "../imagens-produtos/ps4pro1.jpg";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title"><?php echo htmlspecialchars($produto_nome); ?> - Grillo Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilo/style-produto.css">
</head>
<body>
    
    <div id="notification-popup" class="<?php echo htmlspecialchars($mostrar_notificacao_classe); ?>">
        <?php echo htmlspecialchars($notificacao_mensagem); ?>
    </div>
    
    <header class="header">
        <div class="header-content">
            <a href="listagem-produtos.php" class="logo">Grillo Store</a>
            <div class="header-actions">
                <button id="darkModeToggle" class="dark-mode-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>
                <div class="cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </div>
            </div>
        </div>
    </header>

    <?php require_once 'flyout_carrinho.php'; ?>

    <main class="product-page-container">
        <a href="listagem-produtos.php" class="back-button">
            &larr; Voltar para a página de produtos
        </a>
        
        <div class="product-content-wrapper">
            
            <div class="product-images">
                <div class="thumbnail-gallery" id="thumbnail-gallery">
                    <!-- thumbnails podem ser adicionadas aqui -->
                </div>
                <div class="main-image-container">
                    <img src="<?php echo $imagem_principal_inicial; ?>" alt="<?php echo htmlspecialchars($produto_nome); ?>" class="main-product-image" id="main-product-image">
                </div>
            </div>

            <div class="product-info-details">
                <h1 class="product-title" id="product-title"><?php echo htmlspecialchars($produto_nome); ?></h1>
                <div class="price-section">
                    <p class="price-label">À vista</p>
                    <p class="price-value" id="price-value"><?php echo $produto_preco_formatado; ?></p>
                    <p class="installments" id="installments-text">ou 18x de R$ 138,83 sem juros</p>
                    <a href="#" class="payment-methods-link">ver meios de pagamento</a>
                </div>

                <div class="product-specs">
                    <p class="spec-color" id="product-color">Cor:<span class="spec-value" id="product-color-value">acetato(preto)</span></p>
                    <h2 class="specs-title">O que você precisa saber sobre este produto</h2>
                    <ul class="specs-list" id="specs-list">
                        <li>Resolução máxima de saída de vídeo **3840 x 2160 px** (4K).</li>
                        <li>Conectividade **Wi-Fi e Bluetooth** para jogos online.</li>
                        <li>Memória **RAM de 8 GB** e **VRAM de 8 GB** para jogabilidade fluida.</li>
                        <li>Inclui cabo **HDMI** e cabo de alimentação.</li>
                        <li>GPU **AMD Radeon** com desempenho gráfico superior.</li>
                    </ul>
                </div>
            </div>

            <aside class="purchase-sidebar">
                <form action="adicionar_carrinho.php" method="POST">
                    <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
                    <input type="hidden" name="produto_nome" value="<?php echo htmlspecialchars($produto_nome); ?>">
                    <input type="hidden" name="produto_preco" value="<?php echo $produto_preco; ?>">

                    <div class="sidebar-price-block">
                        <div class="current-price-display">
                            <span class="current-price" id="current-price-sidebar"><?php echo $produto_preco_formatado; ?></span>
                            <label class="price-option-radio">
                                <input type="radio" name="priceOption" checked>
                            </label>
                        </div>
                        <p class="free-shipping">Frete Grátis acima de R$19</p>
                        <p class="delivery-estimate">Chega entre Quarta-feira e Quinta-feira</p>
                        <div class="installments-display">
                            <span class="installment-amount" id="installment-amount-sidebar">18x de R$ 138,83</span>
                            <span class="installment-details" id="installment-details-sidebar">sem juros</span>
                            <label class="price-option-radio">
                                <input type="radio" name="priceOption">
                            </label>
                        </div>
                    </div>

                    <div class="delivery-info-block">
                        <p class="delivery-details-link">Mais detalhes da forma de entrega</p>
                        <p class="stock-status">Estoque Disponível</p>
                        <div class="quantity-selector">
                            <label for="quantity">Quantidade:</label>
                            <select id="quantity" name="quantidade">
                                <option value="1">1 Unidade</option>
                                <option value="2">2 Unidades</option>
                                <option value="3">3 Unidades</option>
                            </select>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="checkout.php?produto=produto-<?php echo $produto_id; ?>" class="buy-now-button">Comprar Agora</a>
                        <button type="submit" class="add-to-cart-button">Adicionar ao Carrinho</button>
                    </div>

                    <div class="seller-info">
                        <p>Vendido por: <span class="seller-name" id="seller-name">Básicos</span></p>
                    </div>
                </form>
            </aside>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-columns">
                <div class="footer-col">
                    <h3 class="footer-title">Grillo Store</h3>
                    <p>Nossa missão é trazer a melhor qualidade com o preço justo.</p>
                </div>
                <div class="footer-col">
                    <h3 class="footer-title">Institucional</h3>
                    <ul>
                        <li><a href="#">Sobre Nós</a></li>
                        <li><a href="#">Trabalhe Conosco</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-title">Ajuda</h3>
                    <ul>
                        <li><a href="#">Fale Conosco</a></li>
                        <li><a href="#">Trocas e Devoluções</a></li>
                        <li><a href="#">Rastrear Pedido</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-title">Redes Sociais</h3>
                    <div class="social-links">
                        <a href="#">Facebook</a> | 
                        <a href="#">Instagram</a> | 
                        <a href="#">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Grillo Store. Todos os direitos reservados. | CNPJ: 00.000.000/0001-00</p>
            </div>
        </div>
    </footer>

    <script src="../script/script-produto16.js"></script>
</body>
</html>
