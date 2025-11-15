function setupModal(triggerSelector, modalId, onOpenCallback = () => {}) {
   
    const triggerElement = document.querySelector(triggerSelector);
    const modalElement = document.getElementById(modalId);
    
  
    if (!triggerElement || !modalElement) {
        return; 
    }

  
    const closeButton = modalElement.querySelector('.close-btn'); 

    // Abre o modal
    triggerElement.addEventListener('click', (e) => {
        e.preventDefault();
        onOpenCallback(); 
        modalElement.style.display = 'block';
    });

   
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            modalElement.style.display = 'none';
        });
    }

 
    window.addEventListener('click', (e) => {
        if (e.target === modalElement) {
            modalElement.style.display = 'none';
        }
    });
}



const body = document.body;
const darkModeToggle = document.getElementById('darkModeToggle');

const sunIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>`;
const moonIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>`;

function enableDarkMode() {
    body.classList.add('dark-mode');
    if (darkModeToggle) darkModeToggle.innerHTML = sunIcon;
    localStorage.setItem('darkMode', 'enabled');
}

function disableDarkMode() {
    body.classList.remove('dark-mode');
    if (darkModeToggle) darkModeToggle.innerHTML = moonIcon;
    localStorage.setItem('darkMode', 'disabled');
}

if (localStorage.getItem('darkMode') === 'enabled') {
    enableDarkMode();
} else {
    if (darkModeToggle) darkModeToggle.innerHTML = moonIcon;
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


// ====================================
// 3. LÓGICA DA BARRA DE PESQUISA
// ====================================

const searchInput = document.getElementById('searchInput');
const productCards = document.querySelectorAll('.product-card');

if (searchInput) {
    searchInput.addEventListener('input', (e) => {
        const searchText = e.target.value.toLowerCase();

        productCards.forEach(card => {
            const title = card.querySelector('.product-title').textContent.toLowerCase();
            const category = card.querySelector('.product-category').textContent.toLowerCase();
            const parentLink = card.closest('.product-card-link');
    
            if (parentLink) { 
                if (title.includes(searchText) || category.includes(searchText)) {
                    parentLink.style.display = 'block';
                } else {
                    parentLink.style.display = 'none';
                }
            }
        });
    });
}



// Função auxiliar para remover item via AJAX
function removerItemDoCarrinho(produtoId, buttonElement) {
    // Requisição Fetch para o script PHP (remover_carrinho.php)
    fetch('remover_carrinho.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        // Envia o ID do produto para o PHP
        body: `produto_id=${produtoId}` 
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 1. Remove visualmente o item do HTML (DOM)
            // Procura o elemento pai do item (que precisa ter a classe .cart-item)
            const itemParaRemover = buttonElement.closest('.cart-item');
            if (itemParaRemover) {
                itemParaRemover.remove();
            }
            
            // 2. Opcional: Atualiza o badge do carrinho e o total.
            if (document.getElementById('cart-badge-count') && data.nova_quantidade !== undefined) {
                document.getElementById('cart-badge-count').textContent = data.nova_quantidade;
            }
            
            console.log(`Produto ${produtoId} removido com sucesso.`);
            // Você pode adicionar uma mensagem de sucesso aqui se quiser
            
        } else {
            console.error('Erro ao remover:', data.message);
            alert(`Erro ao remover o produto ${produtoId}. Mensagem do servidor: ${data.message || 'Erro desconhecido'}`);
        }
    })
    .catch(error => {
        console.error('Erro na comunicação com o servidor:', error);
        alert('Houve um erro de rede ao tentar remover o produto.');
    });
}

// Escuta cliques no container principal do carrinho (Delegação de Eventos)
document.addEventListener('DOMContentLoaded', () => {
    // ATENÇÃO: Verifique se 'cart-items-container' é o ID do container onde os itens do carrinho são listados.
    const cartItemsContainer = document.getElementById('cart-items-container');

    if (cartItemsContainer) {
        cartItemsContainer.addEventListener('click', (event) => {
            
            const removerButton = event.target.closest('.btn-remover-item');

            if (removerButton) {
                const produtoId = removerButton.getAttribute('data-produto-id');

                if (produtoId) {
                    removerItemDoCarrinho(produtoId, removerButton);
                }
            }
        });
    }
});


function renderCart() {
    
}


const btnCheckout = document.querySelector('.btn-checkout');

if (btnCheckout) {
    btnCheckout.addEventListener('click', () => {
        window.location.href = 'checkout.php';
    });
}

setupModal('#header-cep-btn', 'cep-modal');

const checkCepBtn = document.getElementById('checkCepBtn');
if (checkCepBtn) {
    checkCepBtn.addEventListener('click', (e) => {
        e.preventDefault();
        
        const cepInput = document.getElementById('cepInput'); 
        const cepValue = cepInput ? cepInput.value : 'N/A (Input não encontrado)';

        alert(`Verificando o CEP: ${cepValue}`);
    });
}

setupModal('#login-btn', 'login-modal');

const loginForm = document.getElementById('login-form');
const loginModal = document.getElementById('login-modal');
if (loginForm && loginModal) {
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (email && password) {
            alert(`Login simulado com sucesso! Usuário: ${email}`);
            loginModal.style.display = 'none'; 
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });
}



const wishlistButtons = document.querySelectorAll('.wishlist-btn');

wishlistButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      
        e.stopPropagation(); 
        e.preventDefault(); 
        
        const icon = button.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');
        
        if (icon.classList.contains('fas')) {
            alert('Produto adicionado à sua lista de desejos!');
        } else {
            alert('Produto removido da sua lista de desejos!');
        }
    });
});