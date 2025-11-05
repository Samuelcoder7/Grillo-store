// Espera o DOM ser completamente carregado antes de executar o script
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script carregado - iniciando...');

    // -------------------------------------------------------------------------
    // --- NOVO CARROSSEL ---
    // -------------------------------------------------------------------------
    const newCarouselTrack = document.querySelector('.new-carousel-track');
    const newSlides = document.querySelectorAll('.new-carousel-slide');
    const newPrevBtn = document.querySelector('.new-prev-btn');
    const newNextBtn = document.querySelector('.new-next-btn');
    const newCarouselDotsContainer = document.querySelector('.new-carousel-dots');

    let newCurrentSlideIndex = 0;
    let newAutoPlayInterval;

    if (newSlides.length > 0 && newCarouselTrack && newCarouselDotsContainer) {
        console.log('Inicializando carrossel...');

        function createNewDots() {
            newCarouselDotsContainer.innerHTML = '';
            newSlides.forEach((_, index) => {
                const dot = document.createElement('span');
                dot.classList.add('new-carousel-dot');
                if (index === newCurrentSlideIndex) dot.classList.add('active');
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
            newCurrentSlideIndex = (newCurrentSlideIndex + 1) % newSlides.length;
            updateNewCarousel();
        }

        function prevNewSlide() {
            newCurrentSlideIndex = (newCurrentSlideIndex - 1 + newSlides.length) % newSlides.length;
            updateNewCarousel();
        }

        function startNewAutoPlay() {
            stopNewAutoPlay();
            newAutoPlayInterval = setInterval(nextNewSlide, 5000);
        }

        function stopNewAutoPlay() {
            if (newAutoPlayInterval) {
                clearInterval(newAutoPlayInterval);
            }
        }

        createNewDots();
        updateNewCarousel();
        startNewAutoPlay();

        if (newNextBtn) {
            newNextBtn.addEventListener('click', () => {
                stopNewAutoPlay();
                nextNewSlide();
                startNewAutoPlay();
            });
        }

        if (newPrevBtn) {
            newPrevBtn.addEventListener('click', () => {
                stopNewAutoPlay();
                prevNewSlide();
                startNewAutoPlay();
            });
        }
    }

    // -------------------------------------------------------------------------
    // --- MODAL CEP ---
    // -------------------------------------------------------------------------
    console.log('Configurando modal CEP...');

    const cepModal = document.getElementById('cep-modal');
    const closeCepBtn = document.getElementById('close-cep-modal');
    const headerCepBtn = document.getElementById('header-cep-btn');

    // Verificar se os elementos existem
    console.log('CEP Modal:', cepModal);
    console.log('Close CEP Button:', closeCepBtn);
    console.log('Header CEP Button:', headerCepBtn);

    // Funções para mostrar e esconder modal
    function showModal(modalElement, event = null) {
        if (event) event.preventDefault();
        console.log('Abrindo modal:', modalElement);
        if (modalElement) {
            modalElement.style.display = 'flex';
            modalElement.classList.add('show');
        }
    }

    function hideModal(modalElement) {
        console.log('Fechando modal:', modalElement);
        if (modalElement) {
            modalElement.style.display = 'none';
            modalElement.classList.remove('show');
        }
    }

    // Certificar que os modais de bloqueio e seus controles existem antes de usar
    const blockModalCep = document.getElementById('block-modal-cep');
    const closeBlockModalCep = document.getElementById('close-block-modal-cep');

    const blockModalProduct = document.getElementById('block-modal-product');
    const closeBlockModalProduct = document.getElementById('close-block-modal-product');

    // Evento para abrir modal CEP
    if (headerCepBtn) {
        headerCepBtn.addEventListener('click', function(e) {
            console.log('Botão CEP clicado');
            e.preventDefault();
                // Se usuário logado: abrir modal de CEP; caso contrário, mostrar modal de bloqueio
                // Usar checagem 'truthy' para ser tolerante a strings 'true'/'false' vindas do servidor
                if (window.isUserLoggedIn) {
                    showModal(cepModal);
                } else {
                    console.log('Usuário não logado - mostrando block modal de CEP');
                    if (blockModalCep) {
                        showModal(blockModalCep);
                    } else {
                        // fallback: mostrar o cepModal mesmo (não ideal)
                        console.warn('blockModalCep não encontrado; abrindo cepModal como fallback');
                        showModal(cepModal);
                    }
                }
        });
    } else {
        console.log('Botão header CEP não encontrado');
    }

    // Evento para fechar modal CEP
    if (closeCepBtn) {
        closeCepBtn.addEventListener('click', function() {
            hideModal(cepModal);
        });
    }

    // Fechar modal ao clicar fora
    if (cepModal) {
        cepModal.addEventListener('click', function(e) {
            if (e.target === cepModal) {
                hideModal(cepModal);
            }
        });
    }

    // -------------------------------------------------------------------------
    // --- BUSCA DE CEP ---
    // -------------------------------------------------------------------------
    const cepInput = document.getElementById('cep');
    const cepForm = document.getElementById('cep-form');
    const logradouroInput = document.getElementById('logradouro');
    const numeroInput = document.getElementById('numero');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');
    const buscarCepBtn = document.getElementById('buscar-cep-btn');
    const cepLoading = document.getElementById('cep-loading');

    async function searchCep(cep) {
        cep = cep.replace(/\D/g, '');
        if (cep.length !== 8) {
            return { error: 'CEP inválido. Por favor, insira 8 dígitos.' };
        }

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();
            if (data.erro) {
                return { error: 'CEP não encontrado. Verifique o número e tente novamente.' };
            }
            return data;
        } catch (error) {
            console.error('Erro ao buscar CEP:', error);
            return { error: 'Erro de comunicação. Tente novamente mais tarde.' };
        }
    }

    function fillAddressFromData(data) {
        if (logradouroInput) logradouroInput.value = data.logradouro || '';
        if (bairroInput && !bairroInput.value) bairroInput.value = data.bairro || '';
        if (cidadeInput && !cidadeInput.value) cidadeInput.value = data.localidade || '';
        if (estadoInput && !estadoInput.value) estadoInput.value = data.uf || '';
    }

    function displayInfoPopup(message, title = 'Informação') {
        // Criar popup simples
        alert(title + ': ' + message);
    }

    // Buscar CEP
    if (buscarCepBtn && cepInput) {
        buscarCepBtn.addEventListener('click', async function() {
            const cepValue = cepInput.value;
            if (!cepValue) {
                displayInfoPopup('Informe o CEP antes de buscar.', 'Aviso');
                cepInput.focus();
                return;
            }

            if (cepLoading) cepLoading.style.display = 'inline';
            
            try {
                const result = await searchCep(cepValue);
                if (cepLoading) cepLoading.style.display = 'none';
                
                if (result.error) {
                    displayInfoPopup(result.error, 'Erro de CEP');
                } else {
                    fillAddressFromData(result);
                    displayInfoPopup('Endereço preenchido a partir do CEP.', 'Sucesso');
                }
            } catch (error) {
                if (cepLoading) cepLoading.style.display = 'none';
                displayInfoPopup('Erro ao buscar CEP.', 'Erro');
            }
        });
    }

    // -------------------------------------------------------------------------
    // --- DARK MODE ---
    // -------------------------------------------------------------------------
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

    function enableDarkMode() {
        body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
    }

    function disableDarkMode() {
        body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
    }

    // Inicializar Dark Mode
    if (localStorage.getItem('darkMode') === 'enabled') {
        enableDarkMode();
    }

    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            if (body.classList.contains('dark-mode')) {
                disableDarkMode();
            } else {
                enableDarkMode();
            }
        });
    }

    // -------------------------------------------------------------------------
    // --- BLOQUEIO DE ACESSO ---
    // -------------------------------------------------------------------------
    const viewAllButton = document.querySelector('.btn-view-all');

    if (viewAllButton) {
        viewAllButton.addEventListener('click', function(e) {
            if (!window.isUserLoggedIn) {
                e.preventDefault();
                if (blockModalProduct) {
                    showModal(blockModalProduct);
                }
            }
        });
    }

    // Handlers para fechar e clicar fora do modal de CEP
    if (closeBlockModalCep && blockModalCep) {
        closeBlockModalCep.addEventListener('click', function() {
            hideModal(blockModalCep);
        });

        blockModalCep.addEventListener('click', function(e) {
            if (e.target === blockModalCep) {
                hideModal(blockModalCep);
            }
        });
    }

    // Handlers para fechar e clicar fora do modal de PRODUCT
    if (closeBlockModalProduct && blockModalProduct) {
        closeBlockModalProduct.addEventListener('click', function() {
            hideModal(blockModalProduct);
        });

        blockModalProduct.addEventListener('click', function(e) {
            if (e.target === blockModalProduct) {
                hideModal(blockModalProduct);
            }
        });
    }

    // -------------------------------------------------------------------------
    // --- PRODUTOS ---
    // -------------------------------------------------------------------------
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    const productCards = document.querySelectorAll('.product-card');

    // Adicionar ao carrinho
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const productCard = button.closest('.product-card');
            const productTitle = productCard.querySelector('.product-title').textContent;
            console.log('Produto adicionado ao carrinho:', productTitle);
            displayInfoPopup(`"${productTitle}" foi adicionado ao seu carrinho!`, 'Produto Adicionado');
        });
    });

    // Cards clicáveis
    productCards.forEach(card => {
        let url = card.getAttribute('data-url');
        if (url) {
            if (url.endsWith('.html')) {
                url = url.replace('.html', '.php');
            }

            card.style.cursor = 'pointer';
            
            card.addEventListener('click', function(e) {
                // Não redirecionar se clicar em botões
                if (e.target.closest('button') || e.target.closest('.wishlist-btn') || e.target.closest('.btn-add-to-cart')) {
                    return;
                }

                if (isUserLoggedIn) {
                    window.location.href = url;
                } else {
                    e.preventDefault();
                    if (blockModalProduct) {
                        showModal(blockModalProduct);
                    }
                }
            });
        }
    });

    console.log('Script inicializado com sucesso!');
});