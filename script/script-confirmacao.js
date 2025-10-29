// ====================================
// script-confirmacao.js: Lógica da Confirmação de Pedido e Dark Mode
// - LÊ O PRODUTO VIA SLUG (para detalhes do catálogo)
// - LÊ OS DADOS DE TRANSAÇÃO (total, endereço, pagamento) VIA URL
// ====================================

document.addEventListener('DOMContentLoaded', () => {

    // ====================================
    // 1. DADOS E FUNÇÕES ESSENCIAIS (Lista de Produtos e Formatador)
    // ⭐️ ALTERAÇÃO: Preços e Parcelas do ID 14-16 corrigidos
    // ====================================
    // LISTA DE PRODUTOS (Necessária para encontrar o item pelo slug)
    const produtos = [
        { slug: "produto-1-camiseta-basica.php", nome: "Kit Camiseta Básica Masculina", cor: "Branca", preco: 47.49, parcelas: 2, imagem: "../imagens-produtos/camisa1.jpg" },
        { slug: "produto-2-camisetas-femininas.php", nome: "Kit 4 Camisetas Feminina Academia", cor: "variada", preco: 53.99, parcelas: 2, imagem: "../imagens-produtos/camisa1fem.jpg" },
        { slug: "produto-3-notebook.php", nome: "Notebook Acer Aspire Go Intel Core i5 13420H 8GB RAM 512GB", cor: "cinza", preco: 2890.00, parcelas: 10, imagem: "../imagens-produtos/note1.jpg" },
        { slug: "produto-4-impressora.php", nome: "Impressora Multifuncional HP Smart Tank", cor: "Cinza", preco: 730.90, parcelas: 18, imagem: "../imagens-produtos/impre4.jpg" },
        { slug: "produto-5-polaroide.php", nome: "Câmera instantânea Fujifilm Instax Kit Mini 12 + 10 fotos lilac purple", cor: "bege", preco: 535.00, parcelas: 18, imagem: "../imagens-produtos/pola1.jpg" },
        { slug: "produto-6-camera.php", nome: "Câmera Fotográfica Digital Profissional A6x G Zoom", cor: "preto", preco: 163.83, parcelas: 12, imagem: "../imagens-produtos/camera1.jpg" },
        { slug: "produto7-macacao-eletrico.php", nome: "Macaco Elétrico 2 Toneladas 12v 100w Controle Carro", cor: "Preto", preco: 379.99, parcelas: 12, imagem: "../imagens-produtos/macaco1.jpg" },
        { slug: "produto-8-chupeta.php", nome: "Cabo de Carga para Bateria Chupeta 3,5M Famastil", cor: "laranja/preto", preco: 66.16, parcelas: 2, imagem: "../imagens-produtos/chu1.jpg" },
        { slug: "produto-9-kit-jardinagem.php", nome: "Kit De Jardinagem 10 Peças + Maleta", cor: "verde", preco: 155.52, parcelas: 3, imagem: "../imagens-produtos/maleta .jpg" },
        { slug: "produto-10-mangueira.php", nome: "Mangueira Flexível Tramontina 15m Flex", cor: "verde", preco: 60.79, parcelas: 2, imagem: "../imagens-produtos/mangueira_1.jpg" },
        { slug: "produto-11-fone-de-ouvido.php", nome: "Headset Gamer", cor: "Preto", preco: 47.99, parcelas: 2, imagem: "../imagens-produtos/fone1.jpg" },
        { slug: "produto-12-caixa-de-som.php", nome: "Caixa de Som Amplificada Portátil, Bluetooth, USB, Microfone, LED RGB", cor: "Preto", preco: 179.90, parcelas: 5, imagem: "../imagens-produtos/caixa1.jpg" },
        { slug: "produto-13-sofa.php", nome: "Sofá Cama Colchão Casal", cor: "Vermelha", preco: 1851.35, parcelas: 12, imagem: "../imagens-produtos/sofa1.jpg" },
        // ✅ CORREÇÃO ID 14: Parcelas ajustadas para 12 (consistente com o script-produto14 e checkout)
        { slug: "produto-14-mesa.php", nome: "Conjunto Sala de Jantar Cel Móveis com 08 Cadeiras", cor: "Branco", preco: 2632.48, parcelas: 12, imagem: "../imagens-produtos/mesa1.jpg" },
        // ✅ CORREÇÃO ID 15: Preço ajustado para 2499.00
        { slug: "produto-15-game.php", nome: "Sony PlayStation 4 Pro 1TB", cor: "Preto", preco: 2499.00 , parcelas: 18, imagem: "../imagens-produtos/game2.jpg" },
        // ✅ CORREÇÃO ID 16: Preço ajustado para 1190.00
        { slug: "produto-16-xbox.php", nome: "Microsoft Xbox 360 Super Slim 250GB Standard cor preto 2010", cor: "Preto", preco: 1190.00, parcelas: 18, imagem: "../imagens-produtos/box1.jpg" }
    ];

    const formatBRL = (value) => {
        return parseFloat(value).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    };

    // ====================================
    // 2. LÓGICA DO DARK MODE (Correção no disableDarkMode)
    // ====================================
    const body = document.body;
    const darkModeToggle = document.getElementById('darkModeToggle');
    // SVGs idênticos aos do Checkout
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
        // ✅ CORREÇÃO DO BUG: Deve ser 'disabled' ao desativar.
        localStorage.setItem('darkMode', 'disabled'); 
    }

    // Carregar estado ao iniciar
    if (localStorage.getItem('darkMode') === 'enabled') {
        enableDarkMode();
    } else if (darkModeToggle) {
        disableDarkMode(); // Força o modo claro e o ícone de lua, se não estiver 'enabled'
    }

    // Evento de clique
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
    // 3. PREENCHER INFORMAÇÕES DO PEDIDO
    // ====================================

    const urlParams = new URLSearchParams(window.location.search);
    const confirmationSection = document.querySelector('.confirmation-section');

    // ⭐️ LÊ O SLUG DO PRODUTO PARA BUSCA NO ARRAY LOCAL
    const currentSlug = urlParams.get('slug'); 
    const produto = produtos.find(p => p.slug === currentSlug);

    // Leitura dos dados do usuário e transação (que SÓ vêm pela URL)
    const total = parseFloat(urlParams.get('total')) || 0;
    const pedido = urlParams.get('pedido');
    const endereco = urlParams.get('endereco');
    const previsao = urlParams.get('previsao');
    const pagamento = urlParams.get('pagamento'); 
    const qty = urlParams.get('qty'); 

    if (produto && total > 0 && pedido) {
        
        // 3.1. DADOS PRINCIPAIS E DA ENTREGA (USANDO DADOS DA URL)
        
        // Card Principal de Confirmação
        document.getElementById('order-number').textContent = `#${pedido}`;
        
        // Card de Detalhes de Entrega
        document.getElementById('delivery-address').textContent = endereco || 'Endereço não informado.';
        document.getElementById('delivery-period').textContent = previsao || 'Previsão de entrega não calculada.';
        
        // Card de Detalhes de Pagamento
        document.getElementById('payment-method-text').textContent = pagamento || 'Método de pagamento não informado.';
        
        // 3.2. INFORMAÇÕES DO PRODUTO (Resumo Lateral)
        
        // Cálculo do Frete e Subtotal
        // Utilizamos o total da URL, que já inclui o frete
        const freteGratis = previsao.includes('Grátis');
        const frete = freteGratis ? 0 : 9.90; 
        const subtotal = total - frete; 
        
        // Item do Produto (Dados vêm da lista de PRODUTOS locais)
        if (document.getElementById('summary-item-image')) {
             document.getElementById('summary-item-image').src = produto.imagem;
        }
        if (document.getElementById('summary-item-name')) {
            document.getElementById('summary-item-name').textContent = produto.nome;
        }
        if (document.getElementById('summary-item-color')) {
            document.getElementById('summary-item-color').textContent = `Cor: ${produto.cor}`;
        }
        if (document.getElementById('summary-item-qty')) {
            document.getElementById('summary-item-qty').textContent = `Qtde: ${qty || 1}`;
        }

        // Resumo Total (A seção de resumo lateral)
        document.getElementById('product-subtotal').textContent = `R$ ${formatBRL(subtotal)}`;
        document.getElementById('shipping-cost').textContent = frete === 0 ? 'Grátis' : `R$ ${formatBRL(frete)}`;
        document.getElementById('total-paid-value').textContent = `R$ ${formatBRL(total)}`;

    } else {
        // Exibir erro se o produto não for encontrado (via slug) ou se faltarem dados essenciais
        const sidebar = document.querySelector('.order-summary-sidebar');
        if (sidebar) sidebar.style.display = 'none';

        // Substituir a seção de confirmação por uma mensagem de erro
        confirmationSection.innerHTML = `
            <div class="confirmation-card" style="border-color: #f44336; background-color: rgba(244, 67, 54, 0.1);">
                <div class="confirmation-icon" style="color: #f44336;">⚠️</div>
                <h1 class="confirmation-title" style="color: #f44336;">Ops! Pedido Não Encontrado.</h1>
                <p class="confirmation-message">Houve um erro ao processar seu pedido. Por favor, volte e tente novamente.</p>
            </div>
            <div class="action-buttons" style="margin-top: 20px;">
                <a href="listagem.php" class="submit-button" style="background-color: #6c757d;">Voltar para a Loja</a>
            </div>
        `;
    }
});