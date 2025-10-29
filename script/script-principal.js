// Espera o DOM ser completamente carregado antes de executar o script
document.addEventListener('DOMContentLoaded', () => {

    // -------------------------------------------------------------------------
    // --- NOVO CARROSSEL (MANTIDO) ---
    // -------------------------------------------------------------------------
    const newCarouselTrack = document.querySelector('.new-carousel-track');
    const newSlides = document.querySelectorAll('.new-carousel-slide');
    const newPrevBtn = document.querySelector('.new-prev-btn');
    const newNextBtn = document.querySelector('.new-next-btn');
    const newCarouselDotsContainer = document.querySelector('.new-carousel-dots');

    let newCurrentSlideIndex = 0;
    let newAutoPlayInterval;

    function createNewDots() {
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
        newAutoPlayInterval = setInterval(nextNewSlide, 5000);
    }

    function stopNewAutoPlay() {
        clearInterval(newAutoPlayInterval);
    }

    if (newSlides.length > 0) {
        createNewDots();
        updateNewCarousel();
        startNewAutoPlay();
    }

    if (newNextBtn) newNextBtn.addEventListener('click', () => {
        stopNewAutoPlay();
        nextNewSlide();
        startNewAutoPlay();
    });

    if (newPrevBtn) newPrevBtn.addEventListener('click', () => {
        stopNewAutoPlay();
        prevNewSlide();
        startNewAutoPlay();
    });

    // -------------------------------------------------------------------------
    // --- ELEMENTOS DA INTERFACE ---
    // -------------------------------------------------------------------------
    const cepModal = document.getElementById('cep-modal');
    const closeCepBtn = document.getElementById('close-cep-modal');
    const headerCepBtn = document.getElementById('header-cep-btn');

    const viewAllButton = document.querySelector('.btn-view-all');
    const viewAllButtonContainer = viewAllButton ? viewAllButton.parentElement : null;
    const blockModal = document.getElementById('block-modal');
    const closeBlockModal = document.getElementById('close-block-modal');
    const productCards = document.querySelectorAll('.product-card');

    const cepInput = document.getElementById('principal-cep');
    const cepForm = document.getElementById('cep-form');
    const ruaInput = document.getElementById('principal-logradouro');
    const numeroInput = document.getElementById('principal-numero');
    const bairroInput = document.getElementById('principal-bairro');
    const cidadeInput = document.getElementById('principal-cidade');
    const estadoInput = document.getElementById('principal-estado');
    const buscarCepBtn = document.getElementById('buscar-cep-btn');
    const cepLoading = document.getElementById('cep-loading');

    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');

    // -------------------------------------------------------------------------
    // --- DARK MODE ---
    // -------------------------------------------------------------------------
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

    const moonIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16"><path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/></svg>';
    const sunIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun" viewBox="0 0 16 16"><path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m0 1a4 4 0 1 1 0-8 4 4 0 0 1 0 8"/></svg>';

    function enableDarkMode() {
        body.classList.add('dark-mode');
        darkModeToggle.innerHTML = sunIcon;
        localStorage.setItem('darkMode', 'enabled');
        document.querySelectorAll('.navbar, .modal-content, .product-card, .mega-promo-section, .footer')
            .forEach(el => el.classList.add('dark-mode'));
    }

    function disableDarkMode() {
        body.classList.remove('dark-mode');
        darkModeToggle.innerHTML = moonIcon;
        localStorage.setItem('darkMode', 'disabled');
        document.querySelectorAll('.navbar, .modal-content, .product-card, .mega-promo-section, .footer')
            .forEach(el => el.classList.remove('dark-mode'));
    }

    // -------------------------------------------------------------------------
    // --- FUNÇÕES AUXILIARES ---
    // -------------------------------------------------------------------------
    const showModal = (modalElement, event = null) => {
        if (event) event.preventDefault();
        modalElement.classList.add('show');
    };

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

    async function searchCep(cep) {
        cep = cep.replace(/\D/g, '');
        if (cep.length !== 8) return { error: 'CEP inválido. Por favor, insira 8 dígitos.' };

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();
            if (data.erro) return { error: 'CEP não encontrado. Verifique o número e tente novamente.' };
            return data;
        } catch {
            return { error: 'Erro de comunicação. Tente novamente mais tarde.' };
        }
    }

    function fillAddressFromData(data) {
        ruaInput.value = data.logradouro || '';
        if (!bairroInput.value) bairroInput.value = data.bairro || '';
        if (!cidadeInput.value) cidadeInput.value = data.localidade || '';
        if (!estadoInput.value) estadoInput.value = data.uf || '';
    }

    function displayInfoPopup(message, title = 'Informação') {
        const popup = document.createElement('div');
        popup.classList.add('info-popup');
        popup.innerHTML = `
            <div class="popup-content">
                <div class="popup-header">
                    <h3>${title}</h3>
                    <span class="close-popup">&times;</span>
                </div>
                <div class="popup-body"><p>${message}</p></div>
            </div>
        `;
        document.body.appendChild(popup);
        popup.querySelector('.close-popup').addEventListener('click', () => popup.remove());
        popup.addEventListener('click', e => { if (e.target === popup) popup.remove(); });
    }

    // -------------------------------------------------------------------------
    // --- EVENTOS ---
    // -------------------------------------------------------------------------

    // Bloqueio "Ver Todos os Produtos"
    if (viewAllButtonContainer) {
        viewAllButtonContainer.addEventListener('click', (event) => {
            if (!(typeof isUserLoggedIn !== 'undefined' && isUserLoggedIn)) {
                event.preventDefault();
                if (blockModal) blockModal.style.display = 'flex';
            }
        });
    }

    if (closeBlockModal) closeBlockModal.addEventListener('click', () => blockModal.style.display = 'none');
    window.addEventListener('click', e => { if (e.target === blockModal) blockModal.style.display = 'none'; });

    // Modal CEP
    if (headerCepBtn) headerCepBtn.addEventListener('click', e => showModal(cepModal, e));
    if (closeCepBtn) closeCepBtn.addEventListener('click', () => hideModal(cepModal));
    window.addEventListener('click', e => { if (e.target === cepModal) hideModal(cepModal); });

    // Buscar CEP
    if (buscarCepBtn) {
        buscarCepBtn.addEventListener('click', async () => {
            const cepValue = cepInput.value;
            if (!cepValue) {
                displayInfoPopup('Informe o CEP antes de buscar.', 'Aviso');
                cepInput.focus();
                return;
            }
            if (cepLoading) cepLoading.style.display = 'inline';
            const result = await searchCep(cepValue);
            if (cepLoading) cepLoading.style.display = 'none';
            if (result.error) return displayInfoPopup(result.error, 'Erro de CEP');
            fillAddressFromData(result);
            displayInfoPopup('Endereço preenchido a partir do CEP.', 'Sucesso');
        });
    }

    // Submissão do formulário CEP
    if (cepForm) {
        cepForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const cepValue = cepInput.value;
            const result = await searchCep(cepValue);
            if (result.error) return displayInfoPopup(result.error, 'Erro de CEP');
            fillAddressFromData(result);
            if (!numeroInput.value.trim()) {
                displayInfoPopup('Informe o número do endereço antes de salvar.', 'Atenção');
                numeroInput.focus();
                return;
            }
            cepForm.submit();
        });
    }

    // Preenchimento automático de CEP
    if (cepInput) {
        cepInput.addEventListener('blur', async () => {
            const cepValue = cepInput.value.replace(/\D/g, '');
            if (cepValue.length === 8) {
                const data = await searchCep(cepValue);
                if (!data.error) fillAddressFromData(data);
                else [ruaInput, bairroInput, cidadeInput, estadoInput].forEach(el => el.value = '');
            }
        });
    }

    // Botões "Adicionar ao Carrinho"
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productCard = button.closest('.product-card');
            const productTitle = productCard.querySelector('.product-title').innerText;
            console.log(`Produto "${productTitle}" adicionado ao carrinho.`);
            displayInfoPopup(`"${productTitle}" foi adicionado ao seu carrinho!`, 'Produto Adicionado');
        });
    });

    // Dark Mode inicial
    if (localStorage.getItem('darkMode') === 'enabled') {
        enableDarkMode();
    } else if (darkModeToggle) {
        darkModeToggle.innerHTML = moonIcon;
    }

    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            if (body.classList.contains('dark-mode')) disableDarkMode();
            else enableDarkMode();
        });
    }

    // Cards de produto clicáveis
    productCards.forEach(card => {
        let url = card.getAttribute('data-url');
        if (url && url.endsWith('.html')) url = url.replace('.html', '.php');
        if (url) {
            card.addEventListener('click', (e) => {
                if (e.target.closest('button') || e.target.closest('.wishlist-btn')) return;
                if (typeof isUserLoggedIn !== 'undefined' && isUserLoggedIn) {
                    window.location.href = url;
                } else {
                    e.preventDefault();
                    if (blockModal) blockModal.style.display = 'flex';
                }
            });
            card.style.cursor = 'pointer';
        }
    });
});
