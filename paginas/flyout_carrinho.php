<?php 
// Este arquivo deve ser incluído em todas as páginas após session_start()

// Variável para armazenar o total do carrinho
$total_carrinho = 0; 

// O HTML do Flyout começa aqui:
?>
<div class="cart-flyout" id="cart-flyout">
    <div class="flyout-content-wrapper">
        <div class="flyout-header">
            <h3>Seu Carrinho</h3>
            <button class="close-flyout" id="close-cart-flyout">&times;</button>
        </div>
        
        <div class="flyout-body">
            <?php 
            if (!empty($_SESSION['carrinho'])) {
                
                echo "<ul>";
                // Loop que lista os itens
                foreach ($_SESSION['carrinho'] as $chave => $item) { 
                    // Cálculo e formatação dos valores (necessário aqui dentro do flyout_carrinho.php)
                    $subtotal = $item['quantidade'] * $item['preco'];
                    $total_carrinho += $subtotal;
                    $preco_unitario_formatado = number_format($item['preco'], 2, ',', '.');
                    $subtotal_formatado = number_format($subtotal, 2, ',', '.');

                    // Exibição do item
                    echo "<li class='flyout-item'>";
                    echo "  <p class='item-name'><strong>" . htmlspecialchars($item['nome']) . "</strong></p>";
                    echo "  <p class='item-details'>" . htmlspecialchars($item['quantidade']) . " x R$ " . $preco_unitario_formatado . "</p>";
                    echo "  <p class='item-subtotal'>Subtotal: R$ " . $subtotal_formatado . "</p>";
                    
                    // Link de remoção que usa a chave para remover_carrinho.php
                    echo "  <a href='remover_carrinho.php?chave=" . urlencode($chave) . "' class='remove-item-link'>Remover</a>";

                    echo "</li>"; 
                }
                echo "</ul>";
                echo "<p class='flyout-total'><strong>Total: R$ " . number_format($total_carrinho, 2, ',', '.') . "</strong></p>";
                
            } else {
                // Mensagem quando o carrinho está realmente vazio
                echo "<p style='text-align: center; padding: 20px;'>Seu carrinho está vazio.</p>";
            }
            ?>
        </div>
        
        <div class="flyout-footer">
            <div class="flyout-actions">
                <button class="back-button" id="continue-shopping">Continuar Comprando</button>
                <a href="carrinho.php" class="checkout-button" id="checkout-flyout-button">Finalizar Compra</a>
            </div>
        </div>
    </div>
</div>