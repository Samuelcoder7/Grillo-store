// Espera o DOM (Document Object Model) ser completamente carregado antes de executar o script
document.addEventListener('DOMContentLoaded', () => {
    
    // --- CÓDIGO DO NOVO CARROSSEL (MANTIDO) ---
    // Seleciona os elementos do carrossel
    const newCarouselTrack = document.querySelector('.new-carousel-track');
    const newSlides = document.querySelectorAll('.new-carousel-slide');
    const newPrevBtn = document.querySelector('.new-prev-btn');
    const newNextBtn = document.querySelector('.new-next-btn');
    const newCarouselDotsContainer = document.querySelector('.new-carousel-dots');

    let newCurrentSlideIndex = 0;
    let newAutoPlayInterval;
    
    // Funções do Carrossel (MANTIDAS)
    function createNewDots() { 
        newSlides.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.classList.add('new-carousel-dot');
            if (index === newCurrentSlideIndex) {
                dot.classList.add('active');
            }
            dot.addEventListener('click', () => {
                stopNewAutoPlay();
                newCurrentSlideIndex = index;
                updateNewCarousel();
                startNewAutoPlay();
            });
            newCarouselDotsContainer.appendChild(dot);
        });
    }

    function updateNewCarousel() {
        const offset = -newCurrentSlideIndex * 100;
        newCarouselTrack.style.transform = `translateX(${offset}%)`;
        updateNewDots();
    }

    function updateNewDots() {
        const dots = document.querySelectorAll('.new-carousel-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === newCurrentSlideIndex);
        });
    }

    function nextNewSlide() {
        newCurrentSlideIndex++;
        if (newCurrentSlideIndex >= newSlides.length) {
            newCurrentSlideIndex = 0;
        }
        updateNewCarousel();
    }

    function prevNewSlide() {
        newCurrentSlideIndex--;
        if (newCurrentSlideIndex < 0) {
            newCurrentSlideIndex = newSlides.length - 1;
        }
        updateNewCarousel();
    }

    function startNewAutoPlay() {
        newAutoPlayInterval = setInterval(nextNewSlide, 5000);
    }

    function stopNewAutoPlay() {
        clearInterval(newAutoPlayInterval);
    }

    // Listeners do Carrossel (MANTIDOS)
    newNextBtn.addEventListener('click', () => {
        stopNewAutoPlay();
        nextNewSlide();
        startNewAutoPlay();
    });

    newPrevBtn.addEventListener('click', () => {
        stopNewAutoPlay();
        prevNewSlide();
        startNewAutoPlay();
    });

    // Inicialização do Carrossel (MANTIDA)
    if (newSlides.length > 0) {
        createNewDots();
        updateNewCarousel();
        startNewAutoPlay();
    }
    // --- FIM DO CÓDIGO DO NOVO CARROSSEL ---

    // -------------------------------------------------------------------------
    // 🎨 --- Elementos da Interface (TODAS AS VARIÁVEIS DECLARADAS AQUI) ---
    // -------------------------------------------------------------------------
    
    // Modal CEP e Navegação
    const cepModal = document.getElementById('cep-modal');
    const closeCepBtn = document.getElementById('close-cep-modal');
    const headerCepBtn = document.getElementById('header-cep-btn'); 

    // Variáveis para o Bloqueio de Acesso
    const viewAllButtonContainer = document.querySelector('.btn-view-all').parentElement; 
    const blockModal = document.getElementById('block-modal');
    const closeBlockModal = document.getElementById('close-block-modal');
    const productCards = document.querySelectorAll(".product-card"); // Selecionado aqui

    // Elementos do formulário de CEP
    const cepInput = document.getElementById('cep');
    const cepForm = document.getElementById('cep-form');
    const ruaInput = document.getElementById('logradouro'); // agora usa 'logradouro'
    const numeroInput = document.getElementById('numero');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');
    const buscarCepBtn = document.getElementById('buscar-cep-btn');
    const cepLoading = document.getElementById('cep-loading');

    // Botões de adicionar ao carrinho
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');

    // DARK MODE
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    
    // Ícones para o modo escuro
    const moonIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16"><path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/></svg>';
    const sunIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun" viewBox="0 0 16 16"><path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m0 1a4 4 0 1 1 0-8 4 4 0 0 1 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.65-5.65a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193-9.193a.5.5 0 0 1 .707 0l1.414 1.414a.5.5 0 0 1-.707.707L12.657 4.343a.5.5 0 0 1 0-.707m-9.193 9.193a.5.5 0 0 1 .707 0l1.414 1.414a.5.5 0 0 1-.707.707l-1.414-1.414a.5.5 0 0 1 0-.707"/></svg>';
    
    // -------------------------------------------------------------------------
    // --- Funções Auxiliares ---
    // -------------------------------------------------------------------------

    // Função genérica para mostrar modais
    const showModal = (modalElement, event = null) => {
        if (event) event.preventDefault();
        modalElement.classList.add('show');
    };

    // Função genérica para esconder modais
    const hideModal = (modalElement) => {
        modalElement.classList.remove('show');
        if (modalElement === cepModal) {
            cepForm.reset();
            ruaInput.value = '';
            bairroInput.value = '';
            cidadeInput.value = '';
            estadoInput.value = '';
        }
    };

    // Função para buscar CEP usando a API ViaCEP
    async function searchCep(cep) {
        cep = cep.replace(/\D/g, '');
        if (cep.length !== 8) {
            return { error: 'CEP inválido. Por favor, insira 8 dígitos.' };
        }

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            if (!response.ok) {
                throw new Error('Erro na comunicação com a API.');
            }
            const data = await response.json();
            if (data.erro) {
                return { error: 'CEP não encontrado. Verifique o número e tente novamente.' };
            }
            return data;
        } catch (error) {
            console.error('Falha na busca de CEP:', error);
            return { error: 'Erro de comunicação. Tente novamente mais tarde.' };
        }
    }
    
    // Função para ativar o modo escuro
    function enableDarkMode() {
        body.classList.add('dark-mode');
        darkModeToggle.innerHTML = sunIcon;
        localStorage.setItem('darkMode', 'enabled');
        console.log('Modo Escuro ativado.');
    }

    // Função para desativar o modo escuro
    function disableDarkMode() {
        body.classList.remove('dark-mode');
        darkModeToggle.innerHTML = moonIcon;
        localStorage.setItem('darkMode', 'disabled');
        console.log('Modo Escuro desativado.');
    }

    // Função para exibir pop-ups informativos
    function displayInfoPopup(message, title = 'Informação') {
        const popup = document.createElement('div');
        popup.classList.add('info-popup');

        popup.innerHTML = `
            <div class="popup-content">
                <div class="popup-header">
                    <h3>${title}</h3>
                    <span class="close-popup">&times;</span>
                </div>
                <div class="popup-body">
                    <p>${message}</p>
                </div>
            </div>
        `;

        document.body.appendChild(popup);

        const closePopupBtn = popup.querySelector('.close-popup');
        closePopupBtn.addEventListener('click', () => {
            popup.remove();
        });

        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.remove();
            }
        });
    }

    // -------------------------------------------------------------------------
    // 🚀 --- Lógica de Eventos ---
    // -------------------------------------------------------------------------
    
    // --- Lógica de Bloqueio para "Ver Todos os Produtos" ---
    viewAllButtonContainer.addEventListener('click', (event) => {
        if (typeof isUserLoggedIn !== 'undefined' && isUserLoggedIn) {
            return; 
        } else {
            event.preventDefault(); 
            blockModal.style.display = 'flex';
        }
    });

    // Lógica para fechar os Modais de Bloqueio
    if (closeBlockModal) {
        closeBlockModal.addEventListener('click', () => {
            blockModal.style.display = 'none';
        });
    }

    window.addEventListener('click', (event) => {
        if (event.target === blockModal && blockModal.id === 'block-modal') {
            blockModal.style.display = 'none';
        }
    });

    // --- Event Listeners para Modal CEP ---
    headerCepBtn.addEventListener('click', (e) => showModal(cepModal, e));
    closeCepBtn.addEventListener('click', () => hideModal(cepModal));

    window.addEventListener('click', (e) => {
        if (e.target === cepModal) {
            hideModal(cepModal);
        }
    });

    // Função utilitária para preencher campos a partir do objeto retornado pela API
    function fillAddressFromData(data) {
        ruaInput.value = data.logradouro || '';
        if (!bairroInput.value) bairroInput.value = data.bairro || '';
        if (!cidadeInput.value) cidadeInput.value = data.localidade || '';
        if (!estadoInput.value) estadoInput.value = data.uf || '';
    }

    // Handler do botão "Buscar" (procura o CEP e preenche os campos)
    if (buscarCepBtn) {
        buscarCepBtn.addEventListener('click', async () => {
            const cepValue = cepInput.value;
            if (!cepValue) {
                displayInfoPopup('Informe o CEP antes de buscar.', 'Aviso');
                cepInput.focus();
                return;
            }

            // mostra loading
            if (cepLoading) cepLoading.style.display = 'inline';

            const result = await searchCep(cepValue);

            if (cepLoading) cepLoading.style.display = 'none';

            if (result.error) {
                displayInfoPopup(result.error, 'Erro de CEP');
                return;
            }

            fillAddressFromData(result);
            displayInfoPopup('Endereço preenchido a partir do CEP.', 'Sucesso');
        });
    }

    // Manipula o envio do formulário de CEP
    cepForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const cepValue = cepInput.value;
        // tenta buscar/validar o CEP antes de enviar
        const result = await searchCep(cepValue);
        if (result.error) {
            displayInfoPopup(result.error, 'Erro de CEP');
            return;
        }

        fillAddressFromData(result);

        // exige que o usuário preencha o número antes de submeter
        if (!numeroInput.value || numeroInput.value.trim() === '') {
            displayInfoPopup('Informe o número do endereço antes de salvar.', 'Atenção');
            numeroInput.focus();
            return;
        }

        // Submete normalmente para processa-cep.php
        cepForm.submit();
    });

    // Lógica para preencher automaticamente os campos de endereço ao perder o foco do input CEP
    cepInput.addEventListener('blur', async () => {
        const cepValue = cepInput.value.replace(/\D/g, '');
        if (cepValue.length === 8) {
            const data = await searchCep(cepValue);
            if (!data.error) {
                ruaInput.value = data.logradouro || '';
                if (!bairroInput.value) bairroInput.value = data.bairro || '';
                if (!cidadeInput.value) cidadeInput.value = data.localidade || '';
                if (!estadoInput.value) estadoInput.value = data.uf || '';
            } else {
                ruaInput.value = '';
                bairroInput.value = '';
                cidadeInput.value = '';
                estadoInput.value = '';
            }
        } else {
            ruaInput.value = '';
            bairroInput.value = '';
            cidadeInput.value = '';
            estadoInput.value = '';
        }
    });

    // Funcionalidade dos botões "Adicionar ao Carrinho"
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productCard = button.closest('.product-card');
            const productTitle = productCard.querySelector('.product-title').innerText;
            console.log(`Produto "${productTitle}" adicionado ao carrinho.`);

            displayInfoPopup(`"${productTitle}" foi adicionado ao seu carrinho!`, 'Produto Adicionado');
        });
    });

    // --- FUNCIONALIDADE DO DARK MODE (COMPLETAMENTE REPOSICIONADA) ---
    // Carrega o estado do modo escuro do localStorage
    const savedDarkModeState = localStorage.getItem('darkMode') || 'disabled';
    if (savedDarkModeState === 'enabled') {
        enableDarkMode();
    } else {
        disableDarkMode();
    }

    // Listener para o botão de alternância do modo escuro
    darkModeToggle.addEventListener('click', () => {
        if (body.classList.contains('dark-mode')) {
            disableDarkMode();
        } else {
            enableDarkMode();
        }
    });

    // -------------------------------------------------------------------------
    // --- CARDS DE PRODUTOS CLICÁVEIS (COM BLOQUEIO DE ACESSO) ---
    // -------------------------------------------------------------------------
    productCards.forEach(card => {
        let url = card.getAttribute("data-url");
        
        if (url && url.endsWith('.html')) {
            url = url.replace('.html', '.php');
        }

        if (url) {
            card.addEventListener("click", (e) => {
                // 1. Permite o clique em botões de ação dentro do card (ex: adicionar ao carrinho)
                if (e.target.closest("button") || e.target.closest(".wishlist-btn")) {
                    return; 
                }

                // 2. Lógica de Bloqueio: Verifica se o usuário está logado
                if (typeof isUserLoggedIn !== 'undefined' && isUserLoggedIn) {
                    // Usuário logado: Permite a navegação
                    window.location.href = url;
                } else {
                    // Usuário NÃO logado: Bloqueia e mostra o modal
                    e.preventDefault(); 
                    blockModal.style.display = 'flex'; 
                }
            });

            card.style.cursor = "pointer";
        }
    });
    // --- FIM CARDS DE PRODUTOS CLICÁVEIS ---

});