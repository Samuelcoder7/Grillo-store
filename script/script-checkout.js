// ====================================
// script-checkout.js (COMPLETO E CORRIGIDO PARA ENVIAR O SLUG)
// ====================================

document.addEventListener('DOMContentLoaded', () => {

    // Helper para formatar BRL (incluindo ponto de milhar)
    const formatBRL = (value) => {
        // Garante 2 casas decimais, troca ponto por vírgula, e adiciona ponto de milhar
        return value.toFixed(2)
            .replace('.', ',')
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    };

    // ====================================
    // 1. LISTA DE PRODUTOS (16 produtos)
    // ⭐️ CORREÇÕES: Novos preços e ajuste de parcelas
    // ====================================
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
        // ⭐️ ID 14: CORREÇÃO DE PREÇO E PARCELAS (de 5x para 12x)
        { slug: "produto-14-mesa.php", nome: "Conjunto Sala de Jantar Cel Móveis com 08 Cadeiras", cor: "Branco", preco: 2632.48, parcelas: 12, imagem: "../imagens-produtos/mesa1.jpg" },
        // ⭐️ ID 15: CORREÇÃO DE PREÇO
        { slug: "produto-15-game.php", nome: "Sony PlayStation 4 Pro 1TB", cor: "Preto", preco: 2499.00 , parcelas: 18, imagem: "../imagens-produtos/game2.jpg" },
        // ⭐️ ID 16: CORREÇÃO DE PREÇO
        { slug: "produto-16-xbox.php", nome: "Microsoft Xbox 360 Super Slim 250GB Standard cor preto 2010", cor: "Preto", preco: 1190.00, parcelas: 18, imagem: "../imagens-produtos/box1.jpg" }
    ];

    // ====================================
    // 2. IDENTIFICAR O PRODUTO ATUAL (via query string)
    // ====================================
    const urlParams = new URLSearchParams(window.location.search);
    const currentSlug = urlParams.get('produto');
    const produto = produtos.find(p => p.slug === currentSlug);

    // ====================================
    // 3. PREENCHER O RESUMO DO PEDIDO
    // ====================================
    const orderItemsContainer = document.getElementById('order-items');
    const subtotalValue = document.getElementById('subtotal-value');
    const totalValue = document.getElementById('total-value');
    const cardInstallments = document.getElementById('card-installments');
    
    // Objeto de Formulários de Pagamento
    const paymentForms = {
        'credit-card': document.getElementById('credit-card-form'),
        'pix': document.getElementById('pix-info'),
        'boleto': document.getElementById('boleto-info')
    };

    let totalAmount = 0; // Inicializando o total

    if (produto) {
        document.getElementById('checkout-img').src = produto.imagem;
        document.getElementById('checkout-name').textContent = produto.nome;
        document.getElementById('checkout-color').textContent = `Cor: ${produto.cor}`;
        document.getElementById('checkout-price').textContent = `R$ ${formatBRL(produto.preco)}`;

        // Subtotal
        subtotalValue.textContent = `R$ ${formatBRL(produto.preco)}`;

        // Frete grátis acima de R$19
        let frete = 0;
        if (produto.preco < 19) frete = 9.90;
        document.getElementById('shipping-value').textContent = frete > 0 ? `R$ ${formatBRL(frete)}` : 'Grátis';

        // Total
        totalAmount = produto.preco + frete;
        totalValue.textContent = `R$ ${formatBRL(totalAmount)}`;

        // ====================================
        // ⭐️ CONTEÚDO PIX E BOLETO
        // ====================================
        
        // 3.1. Conteúdo PIX
        if (paymentForms['pix']) {
            const pixTotalFormatted = formatBRL(totalAmount);
            paymentForms['pix'].innerHTML = `
                <h3 class="payment-title">Pague com Pix e Receba Imediatamente!</h3>
                <p>Escaneie o QR Code abaixo usando o aplicativo do seu banco ou copie a chave Pix.</p>
                <div style="text-align: center; margin: 20px 0;">
                    <img src="../imagens-icones/qrcode-placeholder.png" alt="QR Code Pix" style="width: 150px; height: 150px; border: 1px solid #ccc; background-color: white;">
                </div>
                <div class="pix-info-details">
                    <p><strong>Valor:</strong> R$ ${pixTotalFormatted}</p>
                    <p><strong>Chave Aleatória (Copia e Cola):</strong> 1a2b3c4d-5e6f-7g8h-9i0j-k1l2m3n4o5p6</p>
                    <button class="button primary" onclick="navigator.clipboard.writeText('1a2b3c4d-5e6f-7g8h-9i0j-k1l2m3n4o5p6')">Copiar Chave Pix</button>
                </div>
            `;
        }

        // 3.2. Conteúdo BOLETO
        if (paymentForms['boleto']) {
            const boletoTotalFormatted = formatBRL(totalAmount);
            const dueDate = new Date();
            dueDate.setDate(dueDate.getDate() + 3); // Vencimento em 3 dias
            const formattedDueDate = dueDate.toLocaleDateString('pt-BR');

            paymentForms['boleto'].innerHTML = `
                <h3 class="payment-title">Pague com Boleto Bancário</h3>
                <p>O boleto será gerado ao finalizar o pedido e o pagamento pode levar até 3 dias úteis para ser compensado.</p>
                <div class="boleto-details">
                    <p><strong>Valor Total:</strong> R$ ${boletoTotalFormatted}</p>
                    <p><strong>Vencimento Estimado:</strong> ${formattedDueDate}</p>
                    <div style="margin: 20px 0; padding: 10px; border: 1px dashed #000; background: #f9f9f9;">
                        <p style="font-family: monospace; font-size: 14px; word-break: break-all;">
                            <strong>Linha Digitável:</strong> 12345.67890 12345.678901 23456.789012 3 00000000000000
                        </p>
                    </div>
                    <button class="button secondary" onclick="alert('Gerando o Boleto...');">Gerar Boleto em PDF</button>
                </div>
            `;
        }
        
        // Parcelas
        if (cardInstallments) {
            cardInstallments.innerHTML = '';
            for (let i = 1; i <= produto.parcelas; i++) {
                const valorParcela = (totalAmount / i);
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `${i}x de R$ ${formatBRL(valorParcela)} sem juros`;
                cardInstallments.appendChild(option);
            }
        }
    } else {
        orderItemsContainer.innerHTML = `<p style="color:red;">Produto não encontrado!</p>`;
        subtotalValue.textContent = `R$ 0,00`;
        totalValue.textContent = `R$ 0,00`;
    }

    // ====================================
    // 4. MÉTODOS DE PAGAMENTO (ATIVAÇÃO)
    // ====================================
    const paymentOptions = document.querySelectorAll('.payment-option');

    paymentOptions.forEach(option => {
        option.addEventListener('click', () => {
            paymentOptions.forEach(opt => opt.classList.remove('selected'));
            option.classList.add('selected');
            Object.values(paymentForms).forEach(f => f.classList.add('hidden'));
            const method = option.dataset.method;
            if (paymentForms[method]) paymentForms[method].classList.remove('hidden');
        });
    });

    // Garante que o primeiro método de pagamento (Cartão) esteja selecionado ao carregar
    const defaultOption = document.querySelector('.payment-option[data-method="credit-card"]');
    if (defaultOption) {
        defaultOption.classList.add('selected');
        const defaultForm = paymentForms[defaultOption.dataset.method];
        if (defaultForm) defaultForm.classList.remove('hidden');
    }

    // ====================================
    // 5. FINALIZAÇÃO DO PEDIDO (COLETA DE DADOS E REDIRECIONAMENTO)
    // ⭐️ ALTERAÇÃO: URL DE REDIRECIONAMENTO PARA .php
    // ====================================
    const checkoutForm = document.getElementById('checkout-form');
    checkoutForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // 1. Validação do Produto
        if (!produto) {
            alert("Não foi possível finalizar o pedido: Produto não encontrado.");
            return;
        }

        // 2. Coleta e Validação de Dados Pessoais/Entrega
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const address = document.getElementById('address').value.trim();
        const number = document.getElementById('number').value.trim();
        const city = document.getElementById('city').value.trim();
        const state = document.getElementById('state').value.trim();
        const selectedMethod = document.querySelector('.payment-option.selected')?.dataset.method;

        if (!name || !email || !address || !number || !city || !state || !selectedMethod) {
            alert("Por favor, preencha todos os campos de Contato e Entrega e selecione um Método de Pagamento.");
            return;
        }

        // 3. Cálculo Final do Frete e Total (replicando a lógica da seção 3)
        let frete = produto.preco < 19 ? 9.90 : 0;
        const totalAmount = produto.preco + frete;
        const previsao = produto.preco < 19 ? "7 a 15 dias úteis (Frete Padrão)" : "2 a 5 dias úteis (Frete Grátis)";
        
        // 4. Montagem dos Parâmetros da URL
        const params = new URLSearchParams();
        
        // Dados do Produto
        params.append('slug', currentSlug); // ⭐️ ESSENCIAL: AGORA ENVIANDO O SLUG
        params.append('nome', produto.nome);
        params.append('total', totalAmount.toFixed(2));
        params.append('cor', produto.cor);
        params.append('qty', 1); // Quantidade fixa para este exemplo de checkout
        params.append('img', produto.imagem);
        
        // Dados de Confirmação/Pedido
        params.append('pedido', "ABC" + Math.floor(Math.random() * 90000) + 10000); // ID de pedido aleatório para demonstração
        
        // Dados de Entrega
        const fullAddress = `${address}, ${number} - ${city}/${state}`;
        params.append('endereco', fullAddress);
        params.append('previsao', previsao);
        
        // Dados de Pagamento
        let metodoText = '';
        
        if (selectedMethod === 'credit-card') {
            const cardNumber = document.getElementById('card-number')?.value.replace(/\D/g, '') || '';
            const lastFour = cardNumber.slice(-4) || 'XXXX';
            const parcelas = document.getElementById('card-installments')?.value || '1';
            metodoText = `Cartão de Crédito (${parcelas}x, final **** ${lastFour})`;
            params.append('parcelas', parcelas);
        } else if (selectedMethod === 'pix') {
            metodoText = 'Pix (Pagamento Imediato)';
        } else if (selectedMethod === 'boleto') {
            metodoText = 'Boleto Bancário (3 dias para compensação)';
        }
        
        params.append('pagamento', metodoText);
        
        // 5. Redirecionamento para a página de confirmação
        // ⭐️ ALTERAÇÃO AQUI
        const urlConfirmacao = 'confirmacao-de-pedido.php'; 
        window.location.href = urlConfirmacao + '?' + params.toString();
    });

    // ====================================
    // 6. MÁSCARAS DE INPUT (CEP, cartão)
    // ====================================
    const cepInput = document.getElementById('cep');
    if (cepInput) cepInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 8);
        if (e.target.value.length > 5) e.target.value = e.target.value.slice(0,5) + '-' + e.target.value.slice(5,8);
    });

    const cardExpiryInput = document.getElementById('card-expiry');
    if (cardExpiryInput) cardExpiryInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0,4);
        if (e.target.value.length > 2) e.target.value = e.target.value.slice(0,2) + '/' + e.target.value.slice(2,4);
    });

    const cardNumberInput = document.getElementById('card-number');
    if (cardNumberInput) cardNumberInput.addEventListener('input', (e) => {
        // Máscara para número de cartão: 4 dígitos + espaço, repetidamente
        e.target.value = e.target.value.replace(/\D/g, '').slice(0,16).replace(/(\d{4})/g, '$1 ').trim();
    });
    
    const cardCvvInput = document.getElementById('card-cvv');
    if (cardCvvInput) cardCvvInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0,4);
    });

    // ====================================
    // 7. MODO ESCURO
    // ====================================
    const body = document.body;
    const darkModeToggle = document.getElementById('darkModeToggle');
    // Ícones simplificados aqui, assumindo que foram definidos no seu HTML ou CSS
    const sunIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>`;
    const moonIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>`;

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

    if (localStorage.getItem('darkMode') === 'enabled') enableDarkMode();
    else if (darkModeToggle) darkModeToggle.innerHTML = moonIcon;

    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            body.classList.contains('dark-mode') ? disableDarkMode() : enableDarkMode();
        });
    }

});