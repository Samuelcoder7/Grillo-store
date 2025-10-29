<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação do Pedido - Grillo Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilo/estilo-confirmacao.css"> 
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="principal.php" class="logo">Grillo Store</a>
            <div class="header-actions">
                <button id="darkModeToggle" class="dark-mode-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="feather feather-moon">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>
                <div class="secure-checkout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="feather feather-lock">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <span>Compra Segura</span>
                </div>
            </div>
        </div>
    </header>

    <main class="checkout-container">
        <div class="checkout-content">

            <section class="checkout-details confirmation-section">
                
                <div class="confirmation-card">
                    <div class="confirmation-icon">✔</div>
                    <h1 class="confirmation-title">Pedido Confirmado!</h1>
                    <p class="confirmation-message">
                        Obrigado por sua compra. Seu pedido <strong id="order-number">#...</strong> será processado em breve.
                    </p>
                </div>

                <h2 class="section-title">Informações de Entrega</h2>
                <div class="confirmation-detail-card">
                    <div class="detail-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <div class="detail-content-box">
                        <div class="detail-item">
                            <label>Previsão de Entrega:</label>
                            <p id="delivery-period">2 a 5 dias úteis</p>
                        </div>
                        <div class="detail-item">
                            <label>Endereço de Entrega:</label>
                            <p id="delivery-address">Endereço fictício (Exemplo: Rua Teste, 456, Centro, Rio de Janeiro)</p>
                        </div>
                    </div>
                </div>

                <h2 class="section-title">Detalhes do Pagamento</h2>
                <div class="confirmation-detail-card">
                    <div class="detail-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    </div>
                    <div class="detail-content-box">
                        <div class="detail-item">
                            <label>Forma de Pagamento:</label>
                            <p id="payment-method-text">Carregando...</p>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="listagem-produtos.php" class="submit-button">Voltar para Loja</a>
                </div>
            </section>

            <aside class="order-summary-sidebar">
                <h2 class="section-title">Resumo do Pedido</h2>

                <div class="order-items" id="order-items">
                    <div class="order-item">
                        <img id="summary-item-image" class="item-image" src="" alt="Produto">
                        <div class="item-details">
                            <p id="summary-item-name" class="item-name"></p>
                            <p id="summary-item-color" class="item-color"></p>
                        </div>
                        <p class="item-price" id="summary-item-price"></p>
                    </div>
                </div>

                <div class="summary-line">
                    <p>Subtotal</p>
                    <p class="summary-value" id="product-subtotal">R$ 0,00</p>
                </div>
                <div class="summary-line">
                    <p>Frete</p>
                    <p class="summary-value" id="shipping-cost">Grátis</p>
                </div>
                <div class="summary-total">
                    <h3>Total Pago</h3>
                    <h3 class="summary-value" id="total-paid-value">R$ 0,00</h3>
                </div>
            </aside>
        </div>
    </main>
    
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Grillo Store. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="../script/script-confirmacao.js"></script>
</body>
</html>