/// ARQUIVO: script-produto14.js
// ----------------------------------------------------
// LÓGICA DA PÁGINA DE PRODUTO INDIVIDUAL (APENAS EXIBIÇÃO E EVENTOS VISUAIS)

const product = {
    id: 14,
    name: "Conjunto Sala de Jantar Cel Móveis com 08 Cadeiras Mesa de Cinamomo/off White/suede Animale",
    price: 2632.48, // Valor à vista
    oldPrice: 0.00,
    // 12x de R$ 219,37 = R$ 2.632,44 (sem juros, pois é quase igual ao preço à vista R$ 2.632,48)
    installments: { 
        count: 12, 
        value: 219.37,
        total: (12 * 219.37), // 2632.44
        isInterest: false // Indicando que é sem juros
    }, 
    color: "Cinamomo/Off White/Suede Animale",
    images: [
        "../imagens-produtos/mesa1.jpg", 
        "../imagens-produtos/mesa2.jpg", 
        "../imagens-produtos/mesa3.jpg", 
        "../imagens-produtos/mesa4.jpg",
        "../imagens-produtos/mesa5.jpg"
    ],
    specs: [
        "Forma da mesa: retangular.",
        "Materiais das cadeiras: madeira.",
        "Incluí estofamento.",
        "Dimensões das cadeiras: 77cm x 61cm x 53cm.",
        "Requer montagem."
    ],
    seller: "Cel Móveis"
};


// ====================================
// FUNÇÕES DE EXIBIÇÃO E GALERIA
// ====================================

function displayProductDetails(product) {
    document.getElementById('page-title').textContent = `${product.name} - Grillo Store`;
    document.getElementById('product-title').textContent = product.name;
    
    // Formatação robusta para Real (BR) usando Intl.NumberFormat
    const formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2
    });
    const formattedPrice = formatter.format(product.price);

    document.getElementById('price-value').textContent = formattedPrice;
    document.getElementById('current-price-sidebar').textContent = formattedPrice;
    document.getElementById('seller-name').textContent = product.seller;

    if (product.installments) {
        const hasInterest = product.installments.isInterest || (product.installments.total > (product.price * 1.01)); // Tolera pequena diferença de arredondamento
        const installmentType = hasInterest ? 'com juros' : 'sem juros';
        
        const installmentValueFormatted = product.installments.value.toFixed(2).replace('.', ',');
        
        let installmentText = `ou ${product.installments.count}x de R$ ${installmentValueFormatted} ${installmentType}`;
        
        if (hasInterest && product.installments.total) {
             const totalFormatted = product.installments.total.toFixed(2).replace('.', ',');
             installmentText += ` (Total: R$ ${totalFormatted})`;
        }
        
        document.getElementById('installments-text').textContent = installmentText;
        
        document.getElementById('installment-amount-sidebar').textContent = `${product.installments.count}x de R$ ${installmentValueFormatted}`;
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
    
    if (mainImage && thumbnailGallery) {
        mainImage.src = product.images[0];
        mainImage.alt = product.name;

        thumbnailGallery.innerHTML = '';
        product.images.forEach((imgSrc, index) => {
            const img = document.createElement('img');
            img.src = imgSrc;
            img.alt = `Miniatura do Produto ${index + 1}`;
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
// FUNÇÃO DO POP-UP DE NOTIFICAÇÃO (TOAST)
// ====================================

function showNotification(message) {
    const popup = document.getElementById('notification-popup');
    if (popup) {
        popup.textContent = message;
        
        // Usa a classe 'visible' para exibir
        popup.classList.add('visible');

        // Remove a classe 'visible' após 3 segundos para ocultar
        setTimeout(() => {
            popup.classList.remove('visible');
        }, 3000); 
    }
}


// ====================================
// INICIALIZAÇÃO E EVENTOS (FUNCIONAL)
// ====================================

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Carrega os detalhes do produto
    displayProductDetails(product);

    // Função de redirecionamento para o checkout
    function goToCheckout() {
        window.location.href = 'checkout.php'; 
    }
    
    // Configura o redirecionamento para os botões de compra
    const buyNowButton = document.querySelector('.buy-now-button');
    const checkoutPageButton = document.getElementById('checkout-button'); 
    const checkoutFlyoutButton = document.getElementById('checkout-flyout-button'); 
    
    if (buyNowButton) {
        buyNowButton.addEventListener('click', () => {
            showNotification(`Iniciando a Compra Rápida para "${product.name}"...`);
            setTimeout(goToCheckout, 500);
        });
    }
    if (checkoutPageButton) {
        checkoutPageButton.addEventListener('click', goToCheckout);
    }
    if (checkoutFlyoutButton) {
        checkoutFlyoutButton.addEventListener('click', goToCheckout);
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

    // 3. Lógica para o ícone do Carrinho (Modal Centralizado)
    const cartIcon = document.querySelector('.cart-icon'); 
    const cartFlyout = document.getElementById('cart-flyout');
    const closeFlyoutButton = document.getElementById('close-cart-flyout');
    const continueShoppingButton = document.getElementById('continue-shopping'); 

    function openFlyout() {
        if (cartFlyout) {
            cartFlyout.classList.add('visible');
            document.body.style.overflow = 'hidden'; // Bloqueia scroll do body
        }
    }

    function closeFlyout() {
        if (cartFlyout) {
            cartFlyout.classList.remove('visible');
            
            // Restaura o scroll do body depois da transição de saída (0.3s)
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
    
    // O botão Continuar Comprando também fecha o modal
    if (continueShoppingButton) {
        continueShoppingButton.addEventListener('click', closeFlyout);
    }
    
    // Fechar ao clicar fora do modal (no overlay)
    document.addEventListener('click', (event) => {
        const isVisible = cartFlyout && cartFlyout.classList.contains('visible');
        const clickedOnIcon = cartIcon && cartIcon.contains(event.target);
        
        // Verifica se o clique foi diretamente no elemento pai do modal (o overlay escuro)
        const clickedOnOverlay = event.target === cartFlyout; 

        if (isVisible && (clickedOnOverlay && !clickedOnIcon)) {
            closeFlyout();
        }
    });

    // 4. LÓGICA DO MODO ESCURO (Mantém o localStorage)
    
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