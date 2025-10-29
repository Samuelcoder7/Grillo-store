<?php 
session_start(); 
if(isset($_SESSION['erro_login'])) {
    echo "<p style='color:red; text-align:center;'>" . $_SESSION['erro_login'] . "</p>";
    unset($_SESSION['erro_login']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grillo Store</title>
    <link rel="stylesheet" href="../estilo/estilo-pgprincipal.css">
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
                    <img src="../imagem-grilo/grilo.png"> Grillo Store
                </div>
            </div>
            <form class="search-bar">
                <input type="text" placeholder="Buscar produtos...">
                <i class="fas fa-search"></i>
            </form>
          <ul class="nav-links">
           <?php if(isset($_SESSION['usuario_nome'])): ?>
              <li><a href="#"><i class="fas fa-user"></i> Olá, <?= $_SESSION['usuario_nome']; ?></a></li>
              <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
            <?php else: ?>
              <li><a href="#" rel="account"><i class="fas fa-user"></i> Minha Conta</a></li>
              <li><a href="cadastro.php" class="btn btn-primary">Cadastro</a></li>
              <li><a href="login.php" class="btn btn-secondary" id="login-btn">Login</a></li>
           <?php endif; ?>
           
           <li class="cart-link"><a href="#"><i class="fas fa-shopping-cart"></i> Carrinho</a></li>
           
           <li class="cep-link"><a href="cep.php" id="header-cep-btn"><i class="fas fa-map-marker-alt"></i> Inserir CEP </a></li>

         </ul>

            <div class="darkmode-container">
                <button id="darkModeToggle" class="btn-dark-mode" aria-label="Alternar modo claro/escuro">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
                        <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- BOTÕES DE CATEGORIA REMOVIDOS -->

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

        <!-- SEÇÃO EXPLORE POR CATEGORIA REMOVIDA -->

         <section class="mega-promo-section">
            <div class="mega-promo-banner">
                <p class="flash-sale-tag">FLASH SALE</p>
                <h2>Mega Promoção</h2>
                <p class="promo-description">Até 70% de desconto em produtos selecionados</p>
                <p class="timer"><i class="fas fa-clock"></i> Oferta válida por tempo limitado!</p>
                <!-- BOTÃO SEM FUNCIONALIDADE - APENAS INFORMATIVO -->
                <button class="btn-promo-info" disabled>
                    <i class="fas fa-tag"></i> Ofertas Especiais
                </button>
            </div>
            <div class="mega-promo-image">
                <img src="https://via.placeholder.com/200x200.png?text=Promo+Image" >
            </div>
        </section>

        <section class="products-highlight">
            <h2>Produtos em Destaque</h2>
            <p>Os melhores produtos com os maiores descontos</p>
            <div class="product-grid">
                <div class="product-card" data-url="produto-5-polaroide.php">
                    <div class="product-badge">-10%</div>
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="../imagens-produtos/pola1.jpg" alt="Polaroide">
                    <div class="product-info">
                        <p class="product-category">Fotografia</p>
                        <h3 class="product-title"> Câmera Fujifilm Kit Mini 12 + </h3>
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
                    <img src="../imagens-produtos/box1.jpg" alt="Xbox">
                    <div class="product-info">
                        <p class="product-category">Games</p>
                        <h3 class="product-title">Microsoft Xbox 360 Super </h3>
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
                    <img src="../imagens-produtos/camisa1.jpg" alt="Kit Camiseta">
                    <div class="product-info">
                        <p class="product-category">Moda</p>
                        <h3 class="product-title">Kit Camiseta Básica Masculina</h3>
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


    <div id="cep-modal" class="modal">  
        <div class="modal-content">
            <span class="close-btn" id="close-cep-modal">&times;</span>
            <h2>Inserir Endereço</h2>
            <p>Preencha os campos abaixo para salvar seu endereço.</p>
            <form id="cep-form" method="POST" action="processa-cep.php" novalidate>  <!-- adicionar method e action aqui -->
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
                    <!-- Mudar id="rua" para id="logradouro" e name="rua" para name="logradouro" -->
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
                <input type="hidden" name="tipo" value="principal">  <!-- Adicionar campo tipo -->
                <button type="submit" class="btn-primary">Salvar Endereço</button>
            </form>
        </div>
        
    </div>

    <div id="block-modal" class="modal" style="display:none;"> 
    <div class="modal-content block-content">
        <span class="close-btn" id="close-block-modal">&times;</span>
        <h2>Acesso Restrito</h2>
        <p>Você precisa estar logado para visualizar todos os produtos da loja.</p>
        
        <i class="fas fa-lock" style="font-size: 30px; color: #dc3545; margin: 15px 0;"></i>
        
        <p>Faça login ou cadastre-se para continuar navegando.</p>
        
        <a href="login.php" class="btn-primary block-login-btn">
            Fazer Login
        </a>
        
    </div>
</div>

<script>
    // Variável do php que informa ao JS se o usuário está logado na conta
    const isUserLoggedIn = <?php echo isset($_SESSION['usuario_nome']) ? 'true' : 'false'; ?>;
</script>
<script src="../script/script-principal.js" defer></script>

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