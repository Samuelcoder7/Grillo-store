// ARQUIVO: script-produto16.js
// ----------------------------------------------------
// LÓGICA DA PÁGINA DE PRODUTO INDIVIDUAL (APENAS EXIBIÇÃO E EVENTOS VISUAIS)

const product = {
    id: 16,
    name: "Microsoft Xbox 360 Super Slim 250GB Standard cor preto 2010",
    price: 1190.00, // Valor à vista
    oldPrice: 0.00,
    // As informações de parcelamento foram removidas para focar apenas no preço à vista.
    // installments: { count: 12, value: 177.96, total: 2135.52, isInterest: true },
    color: "Preto",
    images: [
        "../imagens-produtos/box1.jpg", 
        "../imagens-produtos/box2.jpg", 
        "../imagens-produtos/box3.jpg", 
        "../imagens-produtos/box4.jpg",
        "../imagens-produtos/box5.jpg"
    ],
    specs: [
        "Inclui controle.",
        "Memória RAM de 512MB.",
        "Conta com: 1 cabo de alimentação ca.",
        "A duração da bateria dos controles depende de como o produto é usado."
    ],
    seller: "Básicos",
    slug: "produto-16-xbox.php"
};


// ====================================
// FUNÇÕES DE EXIBIÇÃO E GALERIA
// ====================================

function displayProductDetails(product) {
    document.getElementById('page-title').textContent = `${product.name} - Grillo Store`;
    document.getElementById('product-title').textContent = product.name;
    document.getElementById('price-value').textContent = `R$ ${product.price.toFixed(2).replace('.', ',')}`;
    document.getElementById('current-price-sidebar').textContent = `R$ ${product.price.toFixed(2).replace('.', ',')}`;
    document.getElementById('seller-name').textContent = product.seller;

    // Remove a lógica de parcelamento para este produto
    const installmentsTextElement = document.getElementById('installments-text');
    if (installmentsTextElement) {
        installmentsTextElement.style.display = 'none'; // Esconde o elemento no HTML se existir
    }
    const installmentAmountSidebar = document.getElementById('installment-amount-sidebar');
    if (installmentAmountSidebar) {
        installmentAmountSidebar.textContent = ''; 
    }
    const installmentDetailsSidebar = document.getElementById('installment-details-sidebar');
    if (installmentDetailsSidebar) {
        installmentDetailsSidebar.textContent = 'Preço à vista'; // Altera para indicar preço à vista
    }


    if (product.color && product.color !== "N/A") {
        document.getElementById('product-color-value').textContent = product.color;
    } else {
        const colorElement = document.getElementById('product-color');
        if (colorElement) {
            colorElement.style.display = 'none';
        }
    }
    
    const specsList = document.getElementById('specs-list');
    if (specsList) {
        specsList.innerHTML = '';
        product.specs.forEach(spec => {
            const li = document.createElement('li');
            li.textContent = spec;
            specsList.appendChild(li);
        });
    }

    const mainImage = document.getElementById('main-product-image');
    const thumbnailGallery = document.getElementById('thumbnail-gallery');
    
    // Este bloco sobrescreve o conteúdo da galeria, garantindo a lógica de clique e a imagem principal
    if (mainImage && thumbnailGallery) {
        mainImage.src = product.images[0];
        mainImage.alt = product.name;

        thumbnailGallery.innerHTML = ''; 
        product.images.forEach((imgSrc, index) => {
            const img = document.createElement('img');
            img.src = imgSrc;
            img.alt = `Miniatura do Xbox ${index + 1}`;
            img.classList.add('thumbnail-image');
            if (index === 0) {
                img.classList.add('active');
            }
            thumbnailGallery.appendChild(img);
        });

        document.querySelectorAll('.thumbnail-image').forEach(thumbnail => { 
            thumbnail.addEventListener('click', () => {
                const currentActive = document.querySelector('.thumbnail-image.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }
                thumbnail.classList.add('active');
                mainImage.src = thumbnail.src;
            });
        });
    }
}


// ====================================
// FUNÇÃO DE POP-UP DE NOTIFICAÇÃO (TOAST)
// ====================================

function showNotification(message) {
    const popup = document.getElementById('notification-popup');
    if (popup) {
        popup.textContent = message;
        
        popup.classList.add('visible');

        setTimeout(() => {
            popup.classList.remove('visible');
        }, 3000); 
    }
}


// ====================================
// INICIALIZAÇÃO E EVENTOS
// ====================================

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Carrega os detalhes do produto
    displayProductDetails(product);

    // 2. Lógica do botão "Adicionar ao Carrinho" (ANIMAÇÃO)
    const addToCartButton = document.getElementById('add-to-cart-button');
    if (addToCartButton) {
        addToCartButton.addEventListener('click', () => {
            showNotification(`"${product.name}" adicionado ao carrinho!`);
            
            addToCartButton.textContent = 'Adicionado! ✅';
            addToCartButton.disabled = true;

            setTimeout(() => {
                addToCartButton.textContent = 'Adicionar ao Carrinho';
                addToCartButton.disabled = false;
            }, 2000); 
        });
    }

    // Ações de "Comprar Agora" (Redireciona diretamente para checkout)
    const buyNowButton = document.querySelector('.buy-now-button');
    if (buyNowButton) {
        buyNowButton.addEventListener('click', () => {
            showNotification(`Iniciando a Compra Rápida para "${product.name}"...`);
            // Redirecionamento DIRETO sem setTimeout
            window.location.replace('checkout.php');
        });
    }
    
    // Botão Finalizar Compra na área principal
    const checkoutPageButton = document.getElementById('checkout-button'); 
    if (checkoutPageButton) {
        checkoutPageButton.addEventListener('click', () => {
            window.location.replace('checkout.php');
        });
    }
    
    // Botão Finalizar Compra DENTRO do modal do carrinho
    const checkoutFlyoutButton = document.getElementById('checkout-flyout-button'); 
    if (checkoutFlyoutButton) {
        checkoutFlyoutButton.addEventListener('click', () => {
            window.location.replace('checkout.php');
        });
    }


    // 3. Lógica para o ícone do Carrinho (Modal Centralizado)
    const cartIcon = document.querySelector('.cart-icon'); 
    const cartFlyout = document.getElementById('cart-flyout');
    const closeFlyoutButton = document.getElementById('close-cart-flyout');
    const continueShoppingButton = document.getElementById('continue-shopping'); 

    function openFlyout() {
        if (cartFlyout) {
            cartFlyout.classList.add('visible');
            document.body.style.overflow = 'hidden'; 
        }
    }

    function closeFlyout() {
        if (cartFlyout) {
            cartFlyout.classList.remove('visible');
            setTimeout(() => {
                 document.body.style.overflow = '';
            }, 300);
        }
    }

    if (cartIcon) {
        cartIcon.addEventListener('click', openFlyout);
    }

    if (closeFlyoutButton) {
        closeFlyoutButton.addEventListener('click', closeFlyout);
    }
    
    if (continueShoppingButton) {
        continueShoppingButton.addEventListener('click', closeFlyout);
    }
    
    document.addEventListener('click', (event) => {
        const isVisible = cartFlyout && cartFlyout.classList.contains('visible');
        const clickedOnIcon = cartIcon && cartIcon.contains(event.target);
        const clickedOnOverlay = event.target === cartFlyout; 

        if (isVisible && (clickedOnOverlay && !clickedOnIcon)) {
            closeFlyout();
        }
    });

    // 4. LÓGICA DO MODO ESCURO
    
    const body = document.body;
    const darkModeToggle = document.getElementById('darkModeToggle');
    const sunIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>`;
    const moonIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>`;

    function enableDarkMode() {
        body.classList.add('dark-mode');
        if (darkModeToggle) {
            darkModeToggle.innerHTML = sunIcon;
        }
        localStorage.setItem('darkMode', 'enabled');
    }

    function disableDarkMode() {
        body.classList.remove('dark-mode');
        if (darkModeToggle) {
            darkModeToggle.innerHTML = moonIcon;
        }
        localStorage.setItem('darkMode', 'disabled');
    }

    if (localStorage.getItem('darkMode') === 'enabled') {
        enableDarkMode();
    } else {
        if (darkModeToggle) {
            darkModeToggle.innerHTML = moonIcon;
        }
    }

    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            if (body.classList.contains('dark-mode')) {
                disableDarkMode();
            } else {
                enableDarkMode();
            }
        });
    }
});