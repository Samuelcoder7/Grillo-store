<?php

/**
 * ============================================================================
 * PÁGINA PRINCIPAL DO GRILLO STORE
 * ============================================================================
 * Esta é a página inicial/homepage do e-commerce Grillo Store.
 * Ela exibe produtos em destaque, carrossel promocional e gerencia a sessão
 * do usuário, carrinho de compras e mensagens de feedback.
 */

/**
 * Inicia a sessão PHP para permitir o armazenamento e recuperação de dados
 * do usuário (login, carrinho, mensagens flash, etc.) entre requisições.
 */
session_start();

/**
 * SEÇÃO: Exibição de Mensagens Flash (Erro de Login)
 * ============================================================================
 * Verifica se existe uma mensagem de erro de login armazenada na sessão.
 * Se existir, exibe a mensagem em vermelho centralizada e depois a remove
 * da sessão para que não apareça novamente no próximo acesso.
 */
if (isset($_SESSION['erro_login'])) {
    // Exibe a mensagem de erro com estilos inline (cor vermelha, centralizado)
    echo "<p style='color:red; text-align:center;'>" . $_SESSION['erro_login'] . "</p>";

    // Remove a mensagem da sessão após exibir (evita redundância)
    unset($_SESSION['erro_login']);
}

/**
 * SEÇÃO: Exibição de Mensagens Flash (Sucesso de CEP)
 * ============================================================================
 * Verifica se existe uma mensagem de sucesso armazenada na sessão (ex: CEP
 * calculado com sucesso). Se existir, exibe em uma caixa com fundo verde
 * e depois remove da sessão.
 */
if (isset($_SESSION['sucesso'])) {
    // Exibe div com classe 'alert' e estilos inline para sucesso (fundo verde claro)
    echo "<div class='alert alert-success' style='background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 5px; text-align: center;'>" . $_SESSION['sucesso'] . "</div>";

    // Remove a mensagem da sessão
    unset($_SESSION['sucesso']);
}

/**
 * SEÇÃO: Exibição de Mensagens Flash (Erro de CEP ou Operação)
 * ============================================================================
 * Verifica se existe uma mensagem de erro armazenada na sessão (ex: CEP
 * inválido). Se existir, exibe em uma caixa com fundo vermelho claro.
 */
if (isset($_SESSION['erro'])) {
    // Exibe div com classe 'alert' e estilos inline para erro (fundo vermelho claro)
    echo "<div class='alert alert-danger' style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center;'>" . $_SESSION['erro'] . "</div>";

    // Remove a mensagem da sessão
    unset($_SESSION['erro']);
}

/**
 * SEÇÃO: Cálculo da Quantidade de Itens no Carrinho
 * ============================================================================
 * Calcula o total de itens no carrinho para exibir no badge (número com
 * fundo vermelho ao lado do ícone do carrinho).
 * 
 * Lógica:
 * - Verifica se $_SESSION['carrinho'] existe (carrinho tem itens)
 * - Se sim: usa array_sum() com array_column() para somar todas as quantidades
 * - Se não: retorna 0 (carrinho vazio)
 * 
 * Exemplo: Se carrinho tem [produto1 qty=2, produto2 qty=3], resultado será 5
 */
$cart_count = isset($_SESSION['carrinho']) ? array_sum(array_column($_SESSION['carrinho'], 'quantidade')) : 0;

?>


<!DOCTYPE html>
<!-- DOCTYPE declara ao navegador que este é um documento HTML5 -->

<html lang="pt-br">
<!-- Tag HTML raiz com atributo lang="pt-br" indicando que a página é em Português Brasileiro -->

<head>
    <!-- Seção HEAD contém metadados e configurações da página (não são visíveis diretamente) -->

    <!-- Define o conjunto de caracteres como UTF-8, permitindo exibir acentos e caracteres especiais corretamente -->
    <meta charset="UTF-8">

    <!-- Viewport: instrui o navegador em dispositivos móveis a usar a largura real do dispositivo
         e não fazer zoom automático, melhorando a responsividade -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Título da página que aparece na aba do navegador -->
    <title>Grillo Store</title>

    <!-- Link para o arquivo CSS principal da página.
         O parâmetro ?v=<?php echo time(); ?> adiciona um "cache buster" - força o navegador
         a recarregar o CSS mesmo que tenha sido modificado, evitando versões antigas em cache. -->
    <link rel="stylesheet" href="../estilo/estilo-pgprincipal.css?v=<?php echo time(); ?>">

    <!-- Link para o Font Awesome (biblioteca de ícones) via CDN.
         Fornece ícones como carrinho, usuário, mapa, etc. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Link para o arquivo JavaScript da página.
         O atributo 'defer' faz o script carregar após o HTML ser completamente parseado,
         evitando bloqueios de renderização. -->
    <script src="../script/script-principal.js" defer></script>

    <!-- Define o ícone da página (favicon) que aparece na aba do navegador -->
    <link rel="icon" href="../imagem-grilo/grilo.png" type="image/x-icon">
</head>

<body>
    <!-- SEÇÃO: BARRA SUPERIOR (TOP BAR)
         ====================================================================
         Exibe informações promotivas no topo da página (frete grátis, contato, etc.) -->

    <header class="top-bar">
        <!-- Container que centraliza o conteúdo e controla a largura máxima -->
        <div class="top-bar-content">

            <!-- Texto da esquerda: promoção de frete grátis -->
            <div class="left-text">
                Frete grátis para compras acima de R$ 200
            </div>

            <!-- Texto da direita: telefone de atendimento e ícone de ajuda -->
            <div class="right-text">
                Atendimento: (11) 9999-9999
                <!-- Ícone de círculo com interrogação (Font Awesome) para indicar ajuda -->
                <i class="fas fa-question-circle"></i>
            </div>
        </div>
    </header>

    <!-- SEÇÃO: NAVEGAÇÃO PRINCIPAL (NAVBAR)
         ====================================================================
         Contém logo, barra de busca, links de usuário, carrinho, CEP e toggle de modo escuro -->

    <nav class="navbar">
        <!-- Container que organiza os elementos em linha -->
        <div class="nav-container">

            <!-- LOGO E NOME DA LOJA -->
            <div class="logo">
                <div class="grilo-logo">
                    <!-- Imagem do logo (mascote grilo) -->
                    <img src="../imagem-grilo/grilo.png" alt="Grillo Store">
                    <!-- Texto do nome da loja ao lado do logo -->
                    Grillo Store
                </div>
            </div>

            <!-- BARRA DE BUSCA
                 Formulário (ainda não funcional neste código, precisaria de JavaScript) -->
            <form class="search-bar">
                <!-- Campo de entrada para o usuário digitar o nome do produto -->
                <input type="text" placeholder="Buscar produtos...">
                <!-- Ícone de lupa dentro do campo (Font Awesome) -->
                <i class="fas fa-search"></i>
            </form>

            <!-- LINKS PRINCIPAIS DE NAVEGAÇÃO -->
            <ul class="nav-links">
                <!-- CONDICIONAL: Se usuário está logado, mostra saudação e botão de sair -->
                <?php if (isset($_SESSION['usuario_nome'])): ?>
                    <!-- Link para "Minha Conta" com o nome do usuário -->
                    <li><a href="minha_conta.php"><i class="fas fa-user"></i> Olá, <?= $_SESSION['usuario_nome']; ?></a></li>

                    <!-- Link para fazer logout (sair da sessão) -->
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>

                    <!-- SENÃO: Se usuário NÃO está logado, mostra opções de acesso -->
                <?php else: ?>
                    <!-- Link para página de conta (login/cadastro) -->
                    <li><a href="minha_conta.php" rel="account"><i class="fas fa-user"></i> Minha Conta</a></li>

                    <!-- Botão de Cadastro (estilos especiais btn btn-primary) -->
                    <li><a href="cadastro.php" class="btn btn-primary">Cadastro</a></li>

                    <!-- Botão de Login (estilos especiais btn btn-secondary com ID para JavaScript) -->
                    <li><a href="login.php" class="btn btn-secondary" id="login-btn">Login</a></li>
                <?php endif; ?>

                <!-- CARRINHO DE COMPRAS
                     Exibe ícone de carrinho com um badge (número) mostrando quantidade de itens -->
                <li class="cart-link">
                    <a href="#" id="cart-btn">
                        <!-- Ícone de carrinho de compras -->
                        <i class="fas fa-shopping-cart"></i> Carrinho
                        <!-- Badge (circulozinho vermelho) com a quantidade de itens.
                             O ID 'cart-badge-count' permite que JavaScript atualize este número dinamicamente -->
                        <span class="cart-badge" id="cart-badge-count" style="display: inline-block; background-color: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.75em;"><?= $cart_count; ?></span>
                    </a>
                </li>

                <!-- BOTÃO DE INSERIR CEP
                     Permite que usuários insiram seu CEP para calcular frete -->
                <li class="cep-link"><a href="#" id="header-cep-btn"><i class="fas fa-map-marker-alt"></i> Inserir CEP </a></li>
            </ul>

            <!-- BOTÃO TOGGLE DE MODO ESCURO
                 Permite alternar entre modo claro e modo escuro (dark mode) -->
            <div class="darkmode-container">
                <!-- Botão com aria-label para acessibilidade -->
                <button id="darkModeToggle" class="btn-dark-mode" aria-label="Alternar modo claro/escuro">
                    <!-- Ícone do sol (modo claro) -->
                    <span class="sun-icon">🔆</span>
                    <!-- Ícone da lua (modo escuro) - fica oculto até ser ativado -->
                    <span class="moon-icon">🌙</span>
                </button>
            </div>

            <a href="super-administrador.php">
                <button id="superAdminPanel" class="btn-super-admin" aria-label="Acessar Painel do Super Administrador">
                    <!-- Ícone de escudo (super admin) -->
                    <span class="shield-icon">🛡️</span>
                </button>        


        </div>
    </nav>

    <!-- SEÇÃO PRINCIPAL (MAIN)
         ====================================================================
         Contém todo o conteúdo principal da página: carrossel, promoção, produtos -->

    <main>
        <!-- SEÇÃO: CARROSSEL DE PROMOÇÕES
             ================================================================
             Exibe um carrossel rotativo com imagens e textos promocionais.
             JavaScript permite navegação com botões ou rolagem automática. -->

        <section class="new-carousel-section">
            <!-- Container do carrossel -->
            <div class="new-carousel-container">

                <!-- Track: contém todos os slides e se move horizontalmente -->
                <div class="new-carousel-track">

                    <!-- SLIDE 1: Eletrônicos -->
                    <div class="new-carousel-slide">
                        <!-- Imagem do slide (fundo visual) -->
                        <img src="../imagem/eletronicos.png" alt="Destaque 1">
                        <!-- Legenda com texto sobreposto na imagem -->
                        <div class="slide-caption">
                            <h3>Super Ofertas em Eletrônicos!</h3>
                            <p>Encontre os gadgets mais recentes com preços incríveis.</p>
                            <!-- Link para promover ação do usuário -->
                            <a href="#" class="carousel-action-btn">Compre Agora</a>
                        </div>
                    </div>

                    <!-- SLIDE 2: Moda -->
                    <div class="new-carousel-slide">
                        <img src="../imagem/moda.png" alt="Destaque 2">
                        <div class="slide-caption">
                            <h3>Nova Coleção de Moda Feminina</h3>
                            <p>Estilo e elegância para todas as ocasiões.</p>
                            <a href="#" class="carousel-action-btn">Ver Coleção</a>
                        </div>
                    </div>

                    <!-- SLIDE 3: Casa e Jardim -->
                    <div class="new-carousel-slide">
                        <img src="../imagem/jardim-casa.png" alt="Destaque 3">
                        <div class="slide-caption">
                            <h3>Renove sua Casa e Jardim</h3>
                            <p>Produtos essenciais para deixar seu lar ainda mais bonito.</p>
                            <a href="#" class="carousel-action-btn">Explorar</a>
                        </div>
                    </div>
                </div>

                <!-- Botão para ir ao slide anterior (seta esquerda) -->
                <button class="new-carousel-btn new-prev-btn">&#10094;</button>

                <!-- Botão para ir ao próximo slide (seta direita) -->
                <button class="new-carousel-btn new-next-btn">&#10095;</button>

                <!-- Dots (pontinhos): indicam qual slide está ativo e permitem navegação -->
                <div class="new-carousel-dots"></div>
            </div>
        </section>

        <!-- SEÇÃO: MEGA PROMOÇÃO
             ================================================================
             Destaca uma grande promoção com bônus visual (círculo vazio à direita) -->

        <section class="mega-promo-section">
            <!-- Banner com texto e informações da promoção -->
            <div class="mega-promo-banner">
                <!-- Tag indicando tipo de promoção (FLASH SALE - venda relâmpago) -->
                <p class="flash-sale-tag">FLASH SALE</p>
                <!-- Título principal da promoção -->
                <h2>Mega Promoção</h2>
                <!-- Descrição da oferta -->
                <p class="promo-description">Até 70% de desconto em produtos selecionados</p>
                <!-- Informação de urgência com ícone de relógio -->
                <p class="timer"><i class="fas fa-clock"></i> Oferta válida por tempo limitado!</p>
                <!-- Botão informativo (desabilitado - não é clicável) -->
                <button class="btn-promo-info" disabled>
                    <i class="fas fa-tag"></i> Ofertas Especiais
                </button>
            </div>
            <!-- Círculo decorativo/visual à direita (vazio no estilo atual) -->
            <div class="mega-promo-image">
            </div>
        </section>

        <!-- SEÇÃO: PRODUTOS EM DESTAQUE
             ================================================================
             Exibe uma grade com os produtos principais do site com imagens,
             preços, avaliações e botão de adicionar ao carrinho. -->

        <section class="products-highlight">
            <!-- Título da seção -->
            <h2>Produtos em Destaque</h2>
            <!-- Subtítulo descritivo -->
            <p>Os melhores produtos com os maiores descontos</p>

            <!-- Grid (grade) que exibe os produtos em colunas -->
            <div class="product-grid">

                <!-- ========================================
                     CARD DO PRODUTO 1: CÂMERA POLAROID
                     ======================================== -->
                <div class="product-card" data-url="produto-5-polaroide.php">
                    <!-- Badge com percentual de desconto (posição absoluta no canto) -->
                    <div class="product-badge">-10%</div>

                    <!-- Botão de favoritinho (coração vazio que pode ficar cheio) -->
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>

                    <!-- Imagem do produto.
                         O atributo 'onerror' mostra uma imagem placeholder (SVG) se a imagem real não carregar.
                         Isso garante que a página sempre tenha algo visual mesmo se a imagem estiver quebrada. -->
                    <img src="../imagens-produtos/pola1.jpg" alt="Câmera Polaroid Fujifilm" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzY2NjY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPlBvbGFyb2lkPC90ZXh0Pjwvc3ZnPg=='">

                    <!-- Container com informações do produto -->
                    <div class="product-info">
                        <!-- Categoria do produto -->
                        <p class="product-category">Fotografia</p>

                        <!-- Nome/Título do produto -->
                        <h3 class="product-title">Câmera Fujifilm Kit Mini 12 + Filmes</h3>

                        <!-- Avaliação em estrelas (4 estrelas cheias + 1 vazia) -->
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <!-- Número de avaliações entre parênteses -->
                            <span>(123 avaliações)</span>
                        </div>

                        <!-- Preço com desconto + preço antigo riscado -->
                        <p class="product-price">
                            R$ 535,00
                            <span class="old-price">R$ 800,00</span>
                        </p>

                        <!-- Botão para adicionar ao carrinho.
                             Atributos data-* armazenam informações do produto em formato JSON,
                             permitindo que JavaScript leia esses dados quando o botão é clicado. -->
                        <button class="btn-add-to-cart" data-produto-id="5" data-nome="Câmera Fujifilm Kit Mini 12 + Filmes" data-preco="535.00">
                            <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                        </button>
                    </div>
                </div>

                <!-- ========================================
                     CARD DO PRODUTO 2: XBOX 360
                     ======================================== -->
                <div class="product-card" data-url="produto-16-xbox.php">
                    <div class="product-badge">-40%</div>
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="../imagens-produtos/box1.jpg" alt="Xbox 360" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzY2NjY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPlhib3g8L3RleHQ+PC9zdmc+'">
                    <div class="product-info">
                        <p class="product-category">Games</p>
                        <h3 class="product-title">Microsoft Xbox 360 Super 250GB</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(99 avaliações)</span>
                        </div>
                        <p class="product-price">R$ 1.190,00 <span class="old-price">R$ 1.400,00</span></p>
                        <button class="btn-add-to-cart" data-produto-id="16" data-nome="Microsoft Xbox 360 Super 250GB" data-preco="1190.00">
                            <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                        </button>
                    </div>
                </div>

                <!-- ========================================
                     CARD DO PRODUTO 3: CAMISETA
                     ======================================== -->
                <div class="product-card" data-url="produto-1-camiseta-basica.php">
                    <div class="product-badge">-20%</div>
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                    <img src="../imagens-produtos/camisa1.jpg" alt="Kit Camiseta Básica" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzY2NjY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkNhbWlzZXRhPC90ZXh0Pjwvc3ZnPg=='">
                    <div class="product-info">
                        <p class="product-category">Moda</p>
                        <h3 class="product-title">Kit Camiseta Básica Masculina - 3 Peças</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(50 avaliações)</span>
                        </div>
                        <p class="product-price">R$ 47,49 <span class="old-price">R$ 60,49</span></p>
                        <button class="btn-add-to-cart" data-produto-id="1" data-nome="Kit Camiseta Básica Masculina - 3 Peças" data-preco="47.49">
                            <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            </div>

            <!-- Botão para visualizar o catálogo completo -->
            <a href="listagem-produtos.php">
                <button class="btn-view-all">Ver Todos os Produtos</button>
            </a>
        </section>
    </main>

    <!-- ÍCONE FLUTUANTE DE AJUDA
         ====================================================================
         Ícone fixo no canto inferior direito que pode ser clicado para abrir chat/ajuda -->

    <div class="bottom-right-icon">
        <i class="fas fa-question-circle"></i>
    </div>

    <!-- SEÇÃO: MODAL DO CARRINHO
         ====================================================================
         Janela popup que exibe os itens do carrinho, totais e opção de checkout.
         ID 'cart-modal' é usado pelo JavaScript para abrir/fechar este modal. -->

    <div id="cart-modal" class="modal">
        <!-- Container do modal com estilos e sombra -->
        <div class="modal-content">
            <!-- Botão de fechar (X) no canto superior direito -->
            <span class="close-btn">&times;</span>

            <!-- Título do modal com ícone de carrinho -->
            <h2><i class="fas fa-shopping-cart"></i> Seu Carrinho</h2>

            <!-- Container onde os itens do carrinho serão renderizados dinamicamente via JavaScript.
                 Tem uma mensagem padrão "carrinho vazio" que aparece até o usuário adicionar itens. -->
            <div id="cart-items-container" class="cart-items">
                <p id="empty-cart-message" style="text-align: center; color: #666; padding: 20px;">Seu carrinho está vazio.</p>
            </div>

            <!-- Resumo do carrinho com total a pagar -->
            <div class="cart-summary">
                <p>Total: <span id="cart-total-value">R$ 0,00</span></p>
            </div>

            <!-- Botão para finalizar a compra (ir para checkout) -->
            <button class="btn-primary btn-checkout" style="width: 100%; margin-top: 15px;">Finalizar Compra</button>
        </div>
    </div>

    <!-- SEÇÃO: MODAL DE INSERIR CEP
         ====================================================================
         Modal que permite o usuário inserir seu CEP para calcular frete
         e preencher endereço automaticamente via API ViaCEP. -->

    <div id="cep-modal" class="modal">
        <div class="modal-content">
            <!-- Botão de fechar o modal -->
            <span class="close-btn" id="close-cep-modal">&times;</span>

            <!-- Título do modal -->
            <h2>Inserir Endereço</h2>

            <!-- Instruções para o usuário -->
            <p>Preencha os campos abaixo para salvar seu endereço.</p>

            <!-- Formulário para inserir endereço via CEP.
                 'novalidate' permite validação customizada via JavaScript em vez da padrão do HTML5. -->
            <form id="cep-form" method="POST" action="processa-cep.php" novalidate>

                <!-- Campo para inserir o CEP.
                     maxlength="9" limita a 9 caracteres (ex: 00000-000) -->
                <div class="form-group cep-row">
                    <label for="cep">CEP</label>
                    <div class="cep-input-wrap">
                        <!-- Campo de entrada para o CEP -->
                        <input type="text" id="cep" name="cep" placeholder="00000-000" maxlength="9" required>

                        <!-- Botão para buscar CEP na API ViaCEP -->
                        <button type="button" id="buscar-cep-btn" class="btn-small">Buscar</button>

                        <!-- Mensagem de "Buscando..." que aparece enquanto a API está processando -->
                        <span id="cep-loading" style="display:none;margin-left:8px;font-size:0.9em;color:#666;">Buscando...</span>
                    </div>
                </div>

                <!-- Campo de endereço (Rua).
                     'readonly' significa que este campo é preenchido automaticamente pela API e não pode ser editado pelo usuário -->
                <div class="form-group">
                    <label for="logradouro">Rua</label>
                    <input type="text" id="logradouro" name="logradouro" placeholder="Ex: Rua das Flores" readonly>
                </div>

                <!-- Campo de número da casa/prédio (usuário deve preencher) -->
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" id="numero" name="numero" placeholder="Ex: 123" required>
                </div>

                <!-- Campo de bairro (preenchido automaticamente pela API, mas pode ser editado) -->
                <div class="form-group">
                    <label for="bairro">Bairro</label>
                    <input type="text" id="bairro" name="bairro" placeholder="Ex: Centro">
                </div>

                <!-- Campo de cidade (preenchido automaticamente pela API) -->
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" id="cidade" name="cidade" placeholder="Ex: São Paulo">
                </div>

                <!-- Campo de estado/UF (preenchido automaticamente pela API) -->
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" id="estado" name="estado" placeholder="Ex: SP">
                </div>

                <!-- Campo oculto que identifica qual página está salvando (principal vs outras) -->
                <input type="hidden" name="tipo" value="principal">

                <!-- Botão para submeter o formulário ao servidor -->
                <button type="submit" class="btn-primary">Salvar Endereço</button>
            </form>
        </div>
    </div>

    <!-- SEÇÃO: MODAL DE BLOQUEIO - CEP
         ====================================================================
         Aparece quando usuário NÃO está logado e tenta inserir CEP.
         Pede login ou cadastro para prosseguir. -->

    <div id="block-modal-cep" class="modal" style="display:none;">
        <div class="modal-content block-content">
            <!-- Botão de fechar -->
            <span class="close-btn" id="close-block-modal-cep">&times;</span>

            <!-- Título informando restrição -->
            <h2>Área restrita - CEP</h2>

            <!-- Mensagem explicativa -->
            <p>Para calcular o frete e inserir o endereço, você precisa estar logado.</p>

            <!-- Ícone de cadeado (Font Awesome) para indicar área restrita -->
            <i class="fas fa-lock"></i>

            <!-- Texto adicional com benefícios de fazer login -->
            <p>Faça login ou crie uma conta para prosseguir:</p>

            <!-- Lista de benefícios com ícones de check -->
            <ul>
                <li><i class="fas fa-check"></i> Calcular frete</li>
                <li><i class="fas fa-check"></i> Salvar endereços</li>
            </ul>

            <!-- Botões de ação: login ou cadastro -->
            <div class="btn-container">
                <!-- Link para página de login -->
                <a href="login.php" class="btn-primary">Fazer Login</a>

                <!-- Link para página de cadastro -->
                <a href="cadastro.php" class="btn-secondary">Criar Conta</a>
            </div>
        </div>
    </div>

    <!-- SEÇÃO: MODAL DE BLOQUEIO - PRODUTOS
         ====================================================================
         Aparece quando usuário NÃO está logado e tenta acessar detalhes
         de um produto ou a listagem completa. -->

    <div id="block-modal-product" class="modal" style="display:none;">
        <div class="modal-content block-content">
            <!-- Botão de fechar -->
            <span class="close-btn" id="close-block-modal-product">&times;</span>

            <!-- Título informando restrição -->
            <h2>Área restrita - Produtos</h2>

            <!-- Mensagem explicativa -->
            <p>Para acessar detalhes do produto ou a listagem completa, faça login.</p>

            <!-- Ícone de cadeado -->
            <i class="fas fa-lock"></i>

            <!-- Benefícios de criar uma conta -->
            <p>Ao criar uma conta você poderá salvar endereços, acompanhar pedidos e finalizar compras.</p>

            <!-- Lista de benefícios -->
            <ul>
                <li><i class="fas fa-check"></i> Ver detalhes do produto</li>
                <li><i class="fas fa-check"></i> Acessar listagem completa</li>
            </ul>

            <!-- Botões de ação -->
            <div class="btn-container">
                <a href="login.php" class="btn-primary">Fazer Login</a>
                <a href="cadastro.php" class="btn-secondary">Criar Conta</a>
            </div>
        </div>
    </div>

    <!-- SEÇÃO: SCRIPT GLOBAL
         ====================================================================
         Pequeno script inline para definir a variável global isUserLoggedIn
         que JavaScript pode usar para verificar se o usuário está logado. -->

    <script>
        /**
         * Variável global que indica se o usuário está logado ou não.
         * Preenchida por PHP baseada na sessão.
         * Valores: true (logado) ou false (não logado)
         * 
         * Exemplo de uso em JavaScript:
         * if (window.isUserLoggedIn) { ... fazer algo para logado ... }
         */
        window.isUserLoggedIn = <?php echo isset($_SESSION['usuario_nome']) ? 'true' : 'false'; ?>;
        console.log('Status de login:', window.isUserLoggedIn);
    </script>

    <!-- SEÇÃO: FOOTER
         ====================================================================
         Rodapé da página com links úteis e redes sociais. -->

    <footer class="main-footer">
        <!-- Container que centraliza e controla a largura máxima do footer -->
        <div class="footer-content">

            <!-- COLUNA 1: Links Úteis -->
            <div class="footer-column">
                <!-- Título da coluna -->
                <h3>Links Úteis</h3>
                <!-- Lista de links para páginas importantes -->
                <ul>
                    <li><a href="../paginas/sobrenos.php">Sobre Nós</a></li>
                    <li><a href="../paginas/contato.php">Contato</a></li>
                    <li><a href="../paginas/FAQ.php">FAQ</a></li>
                </ul>
            </div>

            <!-- COLUNA 2: Redes Sociais -->
            <div class="footer-column">
                <!-- Título da coluna -->
                <h3>Redes Sociais</h3>
                <!-- Ícones das redes sociais (links para perfis da loja) -->
                <div class="social-icons">
                    <!-- Link para Instagram da loja -->
                    <a href="https://www.instagram.com/grillo_store_oficial/?next=%2F"><i class="fab fa-instagram"></i></a>
                    <!-- Link para WhatsApp da loja -->
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
</div>

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
<?php include "../componentes/footer.php"; ?>
</body>

</html>