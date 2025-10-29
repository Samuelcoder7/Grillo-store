// ARQUIVO: script-produto10.js
// ----------------------------------------------------
// LÓGICA DA PÁGINA DE PRODUTO INDIVIDUAL (APENAS EXIBIÇÃO E EVENTOS VISUAIS)

const product = {
    id: 10, // ID alterado para 10
    name: "Mangueira Flexível Tramontina 15m Flex",
    price: 60.79, // Valor à vista
    oldPrice: 0.00,
    // Valor a prazo (2x de R$ 63,99)
    installments: { count: 2, value: 63.99, total: 127.98, isInterest: true }, 
    color: "Verde",
    images: [
        "../imagens-produtos/mangueira_1.jpg", 
        "../imagens-produtos/mangueira_2.jpg", 
        "../imagens-produtos/mangueira_3.jpg"
    ],
    specs: [
        "Marca: Tramontina",
        "Comprimento: 15 metros",
        "Mangueira flexível",
        "Cor: Somente Verde",
        "Inclui 1 bico de engate rápido para torneira",
        "Inclui 1 bico regulador de pressão de água"
    ],
    seller: "Grillo Store" // Vendedor padrão, pois não foi especificado
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

    if (product.installments) {
        // Assume juros se houver a propriedade isInterest ou se o total da parcela for maior que o preço à vista.
        const hasInterest = product.installments.isInterest || (product.installments.total > product.price);
        const installmentType = hasInterest ? 'com juros' : 'sem juros';
        
        let installmentText = `ou ${product.installments.count}x de R$ ${product.installments.value.toFixed(2).replace('.', ',')}`;
        
        if (product.installments.total) {
            installmentText += ` (Total: R$ ${product.installments.total.toFixed(2).replace('.', ',')})`;
        }
        
        installmentText += ` ${installmentType}`;

        document.getElementById('installments-text').textContent = installmentText;
        
        document.getElementById('installment-amount-sidebar').textContent = `${product.installments.count}x de R$ ${product.installments.value.toFixed(2).replace('.', ',')}`;
        document.getElementById('installment-details-sidebar').textContent = installmentType;
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
            img.alt = `Miniatura da Mangueira ${index + 1}`;
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

    // Função de redirecionamento para o checkout
    function goToCheckout() {
        window.location.href = 'checkout.php'; 
    }

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
            setTimeout(goToCheckout, 500); // Dá um pequeno tempo para a notificação
        });
    }
    
    // Botão Finalizar Compra na área principal
    const checkoutPageButton = document.getElementById('checkout-button'); 
    if (checkoutPageButton) {
        checkoutPageButton.addEventListener('click', goToCheckout);
    }
    
    // Botão Finalizar Compra DENTRO do modal do carrinho
    const checkoutFlyoutButton = document.getElementById('checkout-flyout-button'); 
    if (checkoutFlyoutButton) {
        checkoutFlyoutButton.addEventListener('click', goToCheckout);
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