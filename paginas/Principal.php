<?php
session_start();

// Exibir mensagens de erro de login (código original)
if (isset($_SESSION['erro_login'])) {
    echo "<p style='color:red; text-align:center;'>" . $_SESSION['erro_login'] . "</p>";
    unset($_SESSION['erro_login']);
}

// Exibir mensagens de sucesso ou erro do CEP (novo)
if (isset($_SESSION['sucesso'])) {
    echo "<div class='alert alert-success' style='background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 5px; text-align: center;'>" . $_SESSION['sucesso'] . "</div>";
    unset($_SESSION['sucesso']);
}

if (isset($_SESSION['erro'])) {
    echo "<div class='alert alert-danger' style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center;'>" . $_SESSION['erro'] . "</div>";
    unset($_SESSION['erro']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grillo Store</title>
    <link rel="stylesheet" href="../estilo/estilo-pgprincipal.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="../script/script-principal.js" defer></script>
    <link rel="icon" href="../imagem-grilo/grilo.png" type="image/x-icon">
</head>

<body>

    <header class="top-bar">
        <div class="top-bar-content">
            <div class="left-text">
                Frete grátis para compras acima de R$ 200
            </div>
            <div class="right-text">
                Atendimento: (11) 9999-9999
                <i class="fas fa-question-circle"></i>
            </div>
        </div>
    </header>

    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <div class="grilo-logo">
                    <img src="../imagem-grilo/grilo.png" alt="Grillo Store"> Grillo Store
                </div>
            </div>
            <form class="search-bar">
                <input type="text" placeholder="Buscar produtos...">
                <i class="fas fa-search"></i>
            </form>
            <ul class="nav-links">
               <?php if (isset($_SESSION['usuario_nome'])): ?>
    <li><a href="minha_conta.php"><i class="fas fa-user"></i> Olá, <?= $_SESSION['usuario_nome']; ?></a></li>
    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
<?php else: ?>
    <li><a href="minha_conta.php" rel="account"><i class="fas fa-user"></i> Minha Conta</a></li>
    <li><a href="cadastro.php" class="btn btn-primary">Cadastro</a></li>
    <li><a href="login.php" class="btn btn-secondary" id="login-btn">Login</a></li>
<?php endif; ?>


                <li class="cart-link"><a href="#"><i class="fas fa-shopping-cart"></i> Carrinho</a></li>

                <li class="cep-link"><a href="#" id="header-cep-btn"><i class="fas fa-map-marker-alt"></i> Inserir CEP </a></li>

            </ul>

            <div class="darkmode-container">
                <button id="darkModeToggle" class="btn-dark-mode" aria-label="Alternar modo claro/escuro">
                    <span class="sun-icon">🔆</span>
                    <span class="moon-icon">🌙</span>
                </button>
            </div>
        </div>
    </nav>

    <main>
        <section class="new-carousel-section">
            <div class="new-carousel-container">
                <div class="new-carousel-track">
                    <div class="new-carousel-slide">
                        <img src="../imagem/eletronicos.png" alt="Destaque 1">
                        <div class="slide-caption">
                            <h3>Super Ofertas em Eletrônicos!</h3>
                            <p>Encontre os gadgets mais recentes com preços incríveis.</p>
                            <a href="#" class="carousel-action-btn">Compre Agora</a>
                        </div>
                    </div>
                    <div class="new-carousel-slide">
                        <img src="../imagem/moda.png" alt="Destaque 2">
                        <div class="slide-caption">
                            <h3>Nova Coleção de Moda Feminina</h3>
                            <p>Estilo e elegância para todas as ocasiões.</p>
                            <a href="#" class="carousel-action-btn">Ver Coleção</a>
                        </div>
                    </div>
                    <div class="new-carousel-slide">
                        <img src="../imagem/jardim-casa.png" alt="Destaque 3">
                        <div class="slide-caption">
                            <h3>Renove sua Casa e Jardim</h3>
                            <p>Produtos essenciais para deixar seu lar ainda mais bonito.</p>
                            <a href="#" class="carousel-action-btn">Explorar</a>
                        </div>
                    </div>
                </div>
                <button class="new-carousel-btn new-prev-btn">&#10094;</button>
                <button class="new-carousel-btn new-next-btn">&#10095;</button>
                <div class="new-carousel-dots"></div>
            </div>
        </section>

        <section class="mega-promo-section">
            <div class="mega-promo-banner">
                <p class="flash-sale-tag">FLASH SALE</p>
                <h2>Mega Promoção</h2>
                <p class="promo-description">Até 70% de desconto em produtos selecionados</p>
                <p class="timer"><i class="fas fa-clock"></i> Oferta válida por tempo limitado!</p>
                <button class="btn-promo-info" disabled>
                    <i class="fas fa-tag"></i> Ofertas Especiais
                </button>
            </div>
            <div class="mega-promo-image">
                <!-- CÍRCULO VAZIO SEM TEXTO -->
            </div>
        </section>

        <section class="products-highlight">
            <h2>Produtos em Destaque</h2>
            <p>Os melhores produtos com os maiores descontos</p>
            <div class="product-grid">
                <div class="product-card" data-url="produto-5-polaroide.php">
                    <div class="product-badge">-10%</div>
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                    <!-- IMAGEM COM FALLBACK -->
                    <img src="../imagens-produtos/pola1.jpg" alt="Câmera Polaroid Fujifilm" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzY2NjY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPlBvbGFyb2lkPC90ZXh0Pjwvc3ZnPg=='">
                    <div class="product-info">
                        <p class="product-category">Fotografia</p>
                        <h3 class="product-title">Câmera Fujifilm Kit Mini 12 + Filmes</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                            <span>(123 avaliações)</span>
                        </div>
                        <p class="product-price">R$ 535,00 <span class="old-price">R$ 800,00</span></p>
                        <button class="btn-add-to-cart"><i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-url="produto-16-xbox.php">
                    <div class="product-badge">-40%</div>
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="../imagens-produtos/box1.jpg" alt="Xbox 360" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzY2NjY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPlhib3g8L3RleHQ+PC9zdmc+'">
                    <div class="product-info">
                        <p class="product-category">Games</p>
                        <h3 class="product-title">Microsoft Xbox 360 Super 250GB</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
                            <span>(99 avaliações)</span>
                        </div>
                        <p class="product-price">R$ 1.190,00 <span class="old-price">R$ 1.400,00</span></p>
                        <button class="btn-add-to-cart"><i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-url="produto-1-camiseta-basica.php">
                    <div class="product-badge">-20%</div>
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="../imagens-produtos/camisa1.jpg" alt="Kit Camiseta Básica" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzY2NjY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkNhbWlzZXRhPC90ZXh0Pjwvc3ZnPg=='">
                    <div class="product-info">
                        <p class="product-category">Moda</p>
                        <h3 class="product-title">Kit Camiseta Básica Masculina - 3 Peças</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span>(50 avaliações)</span>
                        </div>
                        <p class="product-price">R$ 47,49 <span class="old-price">R$ 60,49</span></p>
                        <button class="btn-add-to-cart"><i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

            <a href="listagem-produtos.php">
                <button class="btn-view-all">Ver Todos os Produtos</button>
            </a>
        </section>
    </main>

    <div class="bottom-right-icon">
        <i class="fas fa-question-circle"></i>
    </div>

    <!-- MODAIS (mantidos iguais) -->
    <div id="cep-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="close-cep-modal">&times;</span>
            <h2>Inserir Endereço</h2>
            <p>Preencha os campos abaixo para salvar seu endereço.</p>
            <form id="cep-form" method="POST" action="processa-cep.php" novalidate>
                <div class="form-group cep-row">
                    <label for="cep">CEP</label>
                    <div class="cep-input-wrap">
                        <input type="text" id="cep" name="cep" placeholder="00000-000" maxlength="9" required>
                        <button type="button" id="buscar-cep-btn" class="btn-small">Buscar</button>
                        <span id="cep-loading" style="display:none;margin-left:8px;font-size:0.9em;color:#666;">Buscando...</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="logradouro">Rua</label>
                    <input type="text" id="logradouro" name="logradouro" placeholder="Ex: Rua das Flores" readonly>
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" id="numero" name="numero" placeholder="Ex: 123" required>
                </div>
                <div class="form-group">
                    <label for="bairro">Bairro</label>
                    <input type="text" id="bairro" name="bairro" placeholder="Ex: Centro">
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" id="cidade" name="cidade" placeholder="Ex: São Paulo">
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" id="estado" name="estado" placeholder="Ex: SP">
                </div>
                <input type="hidden" name="tipo" value="principal">
                <button type="submit" class="btn-primary">Salvar Endereço</button>
            </form>
        </div>
    </div>

    <!-- duplicate malformed modal removed; keep a single block-modal below -->


    <!-- Modal de bloqueio específico para CEP -->
    <div id="block-modal-cep" class="modal" style="display:none;">
        <div class="modal-content block-content">
            <span class="close-btn" id="close-block-modal-cep">&times;</span>
            <h2>Área restrita - CEP</h2>
            <p>Para calcular o frete e inserir o endereço, você precisa estar logado.</p>
            <i class="fas fa-lock"></i>
            <p>Faça login ou crie uma conta para prosseguir:</p>
            <ul>
                <li><i class="fas fa-check"></i> Calcular frete</li>
                <li><i class="fas fa-check"></i> Salvar endereços</li>
            </ul>
            <div class="btn-container">
                <a href="login.php" class="btn-primary">Fazer Login</a>
                <a href="cadastro.php" class="btn-secondary">Criar Conta</a>
            </div>
        </div>
    </div>

    <!-- Modal de bloqueio específico para Produtos / Navegação -->
    <div id="block-modal-product" class="modal" style="display:none;">
        <div class="modal-content block-content">
            <span class="close-btn" id="close-block-modal-product">&times;</span>
            <h2>Área restrita - Produtos</h2>
            <p>Para acessar detalhes do produto ou a listagem completa, faça login.</p>
            <i class="fas fa-lock"></i>
            <p>Ao criar uma conta você poderá salvar endereços, acompanhar pedidos e finalizar compras.</p>
            <ul>
                <li><i class="fas fa-check"></i> Ver detalhes do produto</li>
                <li><i class="fas fa-check"></i> Acessar listagem completa</li>
            </ul>
            <div class="btn-container">
                <a href="login.php" class="btn-primary">Fazer Login</a>
                <a href="cadastro.php" class="btn-secondary">Criar Conta</a>
            </div>
        </div>
    </div>

    <script>
        // Variável global para controle de login
        window.isUserLoggedIn = <?php echo isset($_SESSION['usuario_nome']) ? 'true' : 'false'; ?>;
        console.log('Status de login:', window.isUserLoggedIn);
    </script>

    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Links Úteis</h3>
                <ul>
                    <li><a href="../paginas/sobrenos.php">Sobre Nós</a></li>
                    <li><a href="../paginas/contato.php">Contato</a></li>
                    <li><a href="../paginas/FAQ.php">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Redes Sociais</h3>
                <div class="social-icons">
                    <a href="https://www.instagram.com/grillo_store_oficial/?next=%2F"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>