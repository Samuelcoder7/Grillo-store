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

    <main>
        <!-- Seu conteúdo de carousel, promoções e produtos permanece igual -->

    </main>

    <!-- Modais (CEP, Bloqueio) permanecem iguais -->

    <script>
        const isUserLoggedIn = <?php echo isset($_SESSION['usuario_nome']) ? 'true' : 'false'; ?>;

        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const darkModeToggle = document.getElementById('darkModeToggle');

            const enableDarkMode = () => {
                body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
            };
            const disableDarkMode = () => {
                body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'disabled');
            };

            // Inicializa dark mode com base no localStorage
            if(localStorage.getItem('darkMode') === 'enabled') {
                enableDarkMode();
            } else {
                disableDarkMode();
            }

            // Alternar dark mode ao clicar no botão
            darkModeToggle.addEventListener('click', () => {
                if(body.classList.contains('dark-mode')) disableDarkMode();
                else enableDarkMode();
            });

            // Exemplo de uso do modal de bloqueio para produtos
            const viewAllBtn = document.querySelector('.btn-view-all');
            const blockModal = document.getElementById('block-modal');
            const closeBlockModal = document.getElementById('close-block-modal');

            if(viewAllBtn) {
                viewAllBtn.addEventListener('click', (e) => {
                    if(!isUserLoggedIn) {
                        e.preventDefault();
                        if(blockModal) blockModal.style.display = 'flex';
                    }
                });
            }
            if(closeBlockModal) {
                closeBlockModal.addEventListener('click', () => {
                    blockModal.style.display = 'none';
                });
            }
        });
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
