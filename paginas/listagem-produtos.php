<?php
session_start();


$abrir_carrinho = false;
if (isset($_SESSION['carrinho_adicionado']) && $_SESSION['carrinho_adicionado']) {
    $abrir_carrinho = true;
    unset($_SESSION['carrinho_adicionado']);
}

$produtos = [
    1 => ['nome' => 'Kit Camiseta Básica Masculina', 'preco' => 47.49, 'img' => '../imagens-produtos/camisa1.jpg', 'categoria' => 'Moda'],
    2 => ['nome' => 'Kit 4 Camisetas Feminina de Academia- Atacado', 'preco' => 53.99, 'img' => '../imagens-produtos/camisa1fem.jpg', 'categoria' => 'Moda'],
    3 => ['nome' => 'Notebook Acer Aspire Go', 'preco' => 2890.00, 'img' => '../imagens-produtos/note2.jpg', 'categoria' => 'Eletrônicos'],
    4 => ['nome' => 'Impressora Multifuncional HP Smart Tank', 'preco' => 730.00, 'img' => '../imagens-produtos/Impre1.jpg', 'categoria' => 'Eletrônicos'],
    5 => ['nome' => 'Câmera instantânea Fujifilm Instax Kit Mini 12', 'preco' => 1200.00, 'img' => '../imagens-produtos/pola1.jpg', 'categoria' => 'Eletrônico'],
    6 => ['nome' => 'Câmera Fotográfica Digital Profissional A6x', 'preco' => 2500.00, 'img' => '../imagens-produtos/camera1.jpg', 'categoria' => 'Eletrônico'],
    7 => ['nome' => 'Macaco Elétrico Toneladas com 12v', 'preco' => 189.00, 'img' => '../imagens-produtos/macaco5.jpg', 'categoria' => 'ferramentas'],
    8 => ['nome' => 'Cabo de Carga para Bateria Chupeta 3,5M', 'preco' => 145.00, 'img' => '../imagens-produtos/chu1.jpg', 'categoria' => 'Automotivo'],
    9 => ['nome' => 'Kit De Jardinagem 10 Peças + Maleta', 'preco' => 155.52, 'img' => '../imagens-produtos/maleta .jpg', 'categoria' => 'Casa e Jardim'],
    10 => ['nome' => 'Mangueira Flexível Tramontina 15m Flex', 'preco' => 60.79, 'img' => '../imagens-produtos/mangueira_1.jpg', 'categoria' => 'Casa e Jardim'],
    11 => ['nome' => 'Headset Gamer Evolut EG307', 'preco' => 46.99, 'img' => '../imagens-produtos/fone1.jpg', 'categoria' => 'Aúdio'],
    12 => ['nome' => 'Caixa de Som Amplificada Portátil', 'preco' => 110.00, 'img' => '../imagens-produtos/caixa1.jpg', 'categoria' => 'Eletrônicos'],
    13 => ['nome' => 'Sofá Cama Colchão Casal Compactair', 'preco' => 1851.35, 'img' => '../imagens-produtos/sofa1.jpg', 'categoria' => 'Esportes'],
    14 => ['nome' => 'Conjunto Sala de Jantar Cel Móveis', 'preco' => 2632.48, 'img' => '../imagens-produtos/mesa1.jpg', 'categoria' => 'Casa e Jardim'],
    15 => ['nome' => 'Sony PlayStation 4 Pro 1TB Standard', 'preco' => 2499.00, 'img' => '../imagens-produtos/game2.jpg', 'categoria' => 'Games'],
    16 => ['nome' => 'Microsoft Xbox 360 Super Slim 250GB', 'preco' => 1190.00, 'img' => '../imagens-produtos/box1.jpg', 'categoria' => 'Games'],
];


function formatar_preco($preco)
{
    return number_format($preco, 2, ',', '.');
}

function calcular_total_carrinho()
{
    $total = 0;
    if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $item) {
            $total += ($item['preco'] * $item['quantidade']);
        }
    }
    return $total;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Grilo Store</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../estilo/style-listagem.css">
    <link rel="icon" href="../imagem-grilo/grilo.png" type="image/x-icon">

</head>

<body>

    <header>
        <div class="top-bar">
            <div class="top-bar-content">
                <div class="left-text">
                    <p>Entrega rápida para todo o Brasil!</p>
                </div>
                <div class="right-text">
                    <p>Fale Conosco <i class="fas fa-phone"></i></p>
                </div>
            </div>
        </div>
        <nav class="navbar">
            <div class="nav-container">
                <div class="grilo-logo">
                    <img src="../imagem-grilo/grilo.png"> Grillo Store
                </div>
                <a href="Principal.php" class="btn btn-secondary"> Voltar </a>

                <div class="search-bar">
                    <input type="text" placeholder="Pesquisar produtos..." id="searchInput">
                    <i class="fas fa-search"></i>
                </div>

                <ul class="nav-links">
                    <?php if (isset($_SESSION['usuario_nome'])): ?>
                        <li><a href="#"><i class="fas fa-user"></i> Olá, <?= $_SESSION['usuario_nome']; ?></a></li>
                        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                    <?php else: ?>
                        <li><a href="#" rel="account" id="open-login-modal"><i class="fas fa-user"></i> Minha Conta</a></li>
                        <li><a href="cadastro.php" class="btn btn-primary">Cadastro</a></li>
                        <li><a href="#" class="btn btn-secondary" id="login-btn">Login</a></li>
                    <?php endif; ?>

                    <?php
                    $quantidade_carrinho = 0;
                    if (isset($_SESSION['carrinho'])) {
                        foreach ($_SESSION['carrinho'] as $item) {
                            $quantidade_carrinho += $item['quantidade'];
                        }
                    }
                    ?>
                    <li class="cart-link">
                        <a href="#" id="cart-icon" onclick="openModal('cartModal')">
                            <i class="fas fa-shopping-cart"></i> Carrinho
                            <?php if ($quantidade_carrinho > 0): ?>
                                <span class="cart-badge" id="cart-badge-count"><?= $quantidade_carrinho; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="cep-link"><a href="#" id="header-cep-btn" onclick="openModal('cepModal')"><i class="fas fa-map-marker-alt"></i> Inserir CEP</a></li>

                    <li class="darkmode-container">
                        <button id="darkModeToggle" class="btn-dark-mode"><i class="fas fa-moon"></i></button>
                    </li>
                </ul>
            </div>
        </nav>
    </header>


    <main>
        <section class="product-listing">
            <div class="product-listing-header">
                <h2>Todos os Produtos</h2>
                <p>Confira nossa seleção de produtos de alta qualidade.</p>
            </div>

            <div class="product-grid" id="productGrid">

                <a href="produto-1-camiseta-basica.php" class="product-card-link" data-id="1">
                    <div class="product-card" data-category="moda">
                        <span class="product-badge">NOVO</span>
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[1]['img']; ?>" alt="Camisa base Masculina " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Moda</p>
                            <h3 class="product-title"><?= $produtos[1]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                <span>(4.0)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[1]['preco']); ?><span class="old-price">R$ 25,00 </span></p>

                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="1">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[1]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[1]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1"> <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-2-camisetas-femininas.php" class="product-card-link" data-id="2">
                    <div class="product-card" data-category="moda">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[2]['img']; ?>" alt="Camisas Femininas" class="product-image">
                        <div class="product-info">
                            <p class="product-category">Moda</p>
                            <h3 class="product-title"><?= $produtos[2]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[2]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="2">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[2]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[2]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-3-notebook.php" class="product-card-link" data-id="3">
                    <div class="product-card" data-category="Tecnologia">
                        <span class="product-badge">OFERTA</span>
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[3]['img']; ?>" alt="Notebook" class="product-image">
                        <div class="product-info">
                            <p class="product-category">Eletrônicos</p>
                            <h3 class="product-title"><?= $produtos[3]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                <span>(4.5)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[3]['preco']); ?> <span class="old-price">No cartão 10x de 321,11</span></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="3">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[3]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[3]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-4-impressora.php" class="product-card-link" data-id="4">
                    <div class="product-card" data-category="Eletrônicos">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[4]['img']; ?>" alt="Impressora" class="product-image">
                        <div class="product-info">
                            <p class="product-category">Eletrônico</p>
                            <h3 class="product-title"><?= $produtos[4]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[4]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="4">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[4]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[4]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="Produto-5-polaroide.php" class="product-card-link" data-id="5">
                    <div class="product-card" data-category="Fotografia">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[5]['img']; ?>" alt="Polaroid" class="product-image">
                        <div class="product-info">
                            <p class="product-category">Eletrônico</p>
                            <h3 class="product-title"><?= $produtos[5]['nome']; ?> + 10 fotos lilac purple</h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                <span>(4.2)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[5]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="5">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[5]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[5]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-6-camera.php" class="product-card-link" data-id="6">
                    <div class="product-card" data-category="Fotografia">
                        <span class="product-badge">OFERTA</span>
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[6]['img']; ?>" alt="Camera" class="product-image">
                        <div class="product-info">
                            <p class="product-category">Eletrônico</p>
                            <h3 class="product-title"><?= $produtos[6]['nome']; ?> G Zoom Cor Preto EZSEP487</h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                <span>(4.8)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[6]['preco']); ?> <span class="old-price">R$ 2.999,00</span></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="6">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[6]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[6]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto7-macacao-eletrico.php" class="product-card-link" data-id="7">
                    <div class="product-card" data-category="Automotivo">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[7]['img']; ?>" alt="Produto 7" class="product-image">
                        <div class="product-info">
                            <p class="product-category">ferramentas</p>
                            <h3 class="product-title"><?= $produtos[7]['nome']; ?> e 100w Controle Carro</h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                <span>(4.1)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[7]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="7">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[7]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[7]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-8-chupeta.php" class="product-card-link" data-id="8">
                    <div class="product-card" data-category="Automotivo">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[8]['img']; ?>" alt="produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Automotivo</p>
                            <h3 class="product-title"><?= $produtos[8]['nome']; ?> Famastil </h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[8]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="8">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[8]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[8]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-9-kit-jardinagem.php" class="product-card-link" data-id="9">
                    <div class="product-card" data-category="Casa e Jardim">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[9]['img']; ?>" alt="Produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Casa e Jardim</p>
                            <h3 class="product-title"><?= $produtos[9]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                <span>(3.8)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[9]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="9">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[9]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[9]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-10-mangueira.php" class="product-card-link" data-id="10">
                    <div class="product-card" data-category="Casa e Jardim">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[10]['img']; ?>" alt="Produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Casa e Jardim</p>
                            <h3 class="product-title"><?= $produtos[10]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                <span>(4.5)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[10]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="10">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[10]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[10]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-11-fone-de-ouvido.php" class="product-card-link" data-id="11">
                    <div class="product-card" data-category="Aúdio">
                        <span class="product-badge">OFERTA</span>
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[11]['img']; ?> " alt="Produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Aúdio</p>
                            <h3 class="product-title"><?= $produtos[11]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[11]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="11">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[11]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[11]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-12-caixa-de-som.php" class="product-card-link" data-id="12">
                    <div class="product-card" data-category="Aúdio">
                        <span class="product-badge">NOVO</span>
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[12]['img']; ?>" alt="Produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Eletrônicos</p>
                            <h3 class="product-title"><?= $produtos[12]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                <span>(4.8)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[12]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="12">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[12]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[12]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-13-sofa.php" class="product-card-link" data-id="13">
                    <div class="product-card" data-category="Casa e jardim">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[13]['img']; ?>" alt="Produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Esportes</p>
                            <h3 class="product-title"><?= $produtos[13]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                <span>(3.9)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[13]['preco']); ?></p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="13">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[13]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[13]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-14-mesa.php" class="product-card-link" data-id="14">
                    <div class="product-card" data-category="Casa e Jardim">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[14]['img']; ?>" alt="Produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Casa e Jardim</p>
                            <h3 class="product-title"><?= $produtos[14]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[14]['preco']); ?> </p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="14">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[14]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[14]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-15-game.php" class="product-card-link" data-id="15">
                    <div class="product-card" data-category="games">
                        <span class="product-badge">OFERTA</span>
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[15]['img']; ?>" alt="Produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Games</p>
                            <h3 class="product-title"><?= $produtos[15]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                <span>(4.2)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[15]['preco']); ?> </p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="15">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[15]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[15]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

                <a href="produto-16-xbox.php" class="product-card-link" data-id="16">
                    <div class="product-card" data-category="games">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <img src="<?= $produtos[16]['img']; ?>" alt="Produto " class="product-image">
                        <div class="product-info">
                            <p class="product-category">Games</p>
                            <h3 class="product-title"><?= $produtos[16]['nome']; ?></h3>
                            <div class="product-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <p class="product-price">R$ <?= formatar_preco($produtos[16]['preco']); ?> </p>
                            <form action="adicionar_carrinho.php" method="POST" onclick="event.stopPropagation();">
                                <input type="hidden" name="produto_id" value="16">
                                <input type="hidden" name="produto_nome" value="<?= $produtos[16]['nome']; ?>">
                                <input type="hidden" name="produto_preco" value="<?= $produtos[16]['preco']; ?>">
                                <input type="hidden" name="produto_quantidade" value="1">
                                <button type="submit" class="btn-add-to-cart">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </a>

            </div>
        </section>

        <a href="https://wa.me/seu-numero-aqui" target="_blank" class="bottom-right-icon">
            
        </a>
    </main>



    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('cartModal')">&times;</span>
            <div class="modal-header">
                <h2><i class="fas fa-shopping-cart"></i> Seu Carrinho</h2>
            </div>
            <div class="modal-body">
                <div class="cart-items-list">
                    <?php
                    $total_carrinho = 0;
                    if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                        foreach ($_SESSION['carrinho'] as $produto_id => $item) {
                            $subtotal = $item['preco'] * $item['quantidade'];
                            $total_carrinho += $subtotal;
                    ?>
                            <div class="cart-item">
                                <div class="cart-item-info-and-remove">
                                    <div>
                                        <h4 class="cart-item-name">
                                            <?= htmlspecialchars($item['nome']); ?>
                                            (x<?= htmlspecialchars($item['quantidade']); ?>)
                                        </h4>
                                    </div>
                                    <span class="cart-item-price">
                                        R$ <?= number_format($subtotal, 2, ',', '.'); ?>
                                    </span>

                                    <form action="remover_carrinho.php" method="POST" class="form-remove-item">
                                        <input type="hidden" name="produto_id" value="<?= htmlspecialchars($produto_id); ?>">
                                        <button type="submit" name="remover" class="btn-remove-item" title="Remover item">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        <?php
                        } // Fim do foreach
                    } else {
                        ?>
                        <p class="empty-cart-message">Seu carrinho está vazio.</p>
                    <?php
                    }
                    ?>
                </div>

                <div class="cart-total-info">
                    Total: R$ <?= number_format($total_carrinho, 2, ',', '.'); ?>
                </div>

                <?php if (!empty($_SESSION['carrinho'])): ?>
                    <a href="checkout.php" class="btn btn-primary btn-checkout">
                        Finalizar Compra
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="cepModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('cepModal')">&times;</span>
            <div class="modal-header">
                <h2><i class="fas fa-map-marker-alt"></i> Calcular Frete</h2>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="cep-input">Digite seu CEP:</label>
                    <input type="text" id="cep-input" placeholder="Ex: 00000-000">
                </div>
                <button class="btn btn-primary" id="calculate-cep-btn">Calcular</button>
            </div>
        </div>
    </div>

    <div id="accountModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('accountModal')">&times;</span>
            <div class="modal-header">
                <h2>Acesso à Conta</h2>
            </div>
            <div class="modal-body">
                <p>Você precisa estar logado para acessar esta área.</p>
                <div class="modal-link">
                    <a href="login.php" class="btn btn-primary">Fazer Login</a>
                </div>
            </div>
        </div>
    </div>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
            <div class="modal-header">
                <h2>Login</h2>
            </div>
            <div class="modal-body">
                <form action="processar_login.php" method="POST">
                    <div class="form-group">
                        <label for="login-email">Email:</label>
                        <input type="email" id="login-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Senha:</label>
                        <input type="password" id="login-password" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
                <div class="modal-link">
                    <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Função para abrir modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        // Função para fechar modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Fechar o modal clicando fora dele
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        }

        // Lógica de Abertura do Modal do Carrinho
        const cartIcon = document.getElementById('cart-icon');
        if (cartIcon) {
            cartIcon.addEventListener('click', function(e) {
                e.preventDefault();
                openModal('cartModal');
            });
        }

        // Lógica de Abertura do Modal de CEP
        const cepBtn = document.getElementById('header-cep-btn');
        if (cepBtn) {
            cepBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal('cepModal');
            });
        }

        // Lógica de Abertura do Modal de Login/Conta (Se não estiver logado)
        const loginBtn = document.getElementById('login-btn');
        if (loginBtn && loginBtn.href.includes('login.php')) {
            loginBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal('loginModal'); // Se você quer usar o modal de login
                // Se quiser apenas ir para a página de login:
                // window.location.href = 'login.php'; 
            });
        }

        const accountLink = document.querySelector('a[rel="account"]');
        if (accountLink) {
            accountLink.addEventListener('click', function(e) {
                e.preventDefault();
                // Assumindo que este link só aparece se o usuário NÃO está logado
                openModal('loginModal');
            });
        }


        // Lógica do Dark Mode
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;
        const icon = darkModeToggle.querySelector('i');

        // Carrega o estado salvo ou define o padrão
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'enabled') {
            body.classList.add('dark-mode');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        }

        darkModeToggle.addEventListener('click', () => {
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'disabled');
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            } else {
                body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });

        // Lógica para abrir o modal do carrinho automaticamente após adição
        <?php if ($abrir_carrinho): ?>
            document.addEventListener('DOMContentLoaded', () => {
                openModal('cartModal');
            });
        <?php endif; ?>
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formsRemove = document.querySelectorAll('.form-remove-item');

            formsRemove.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Evita recarregar a página

                    const formData = new FormData(form);

                    fetch('remover_carrinho.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove o item da interface
                                const cartItem = form.closest('.cart-item');
                                cartItem.remove();

                                // Atualiza o total do carrinho
                                const totalElement = document.querySelector('.cart-total-info');
                                totalElement.textContent = 'Total: R$ ' + data.total;

                                // Atualiza o badge do carrinho
                                const cartBadge = document.getElementById('cart-badge-count');
                                if (data.quantidade_carrinho > 0) {
                                    cartBadge.textContent = data.quantidade_carrinho;
                                } else {
                                    cartBadge.remove();
                                    // Se carrinho vazio, mostra mensagem
                                    const cartBody = document.querySelector('.cart-items-list');
                                    cartBody.innerHTML = '<p class="empty-cart-message">Seu carrinho está vazio.</p>';
                                }
                            }
                        })
                        .catch(err => console.error('Erro ao remover item:', err));
                });
            });
        });
    </script>

    <?php include "../componentes/footer.php"; ?>

</body>

</html>