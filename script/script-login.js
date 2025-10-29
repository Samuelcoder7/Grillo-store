// script-login.js
document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

    // Função para verificar e aplicar o dark mode
    function applyDarkMode() {
        const isDarkMode = localStorage.getItem('darkMode') === 'enabled';
        
        if (isDarkMode) {
            body.classList.add('dark-mode');
            // Muda o ícone para sol se estiver em dark mode
            if (darkModeToggle) {
                darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }
        } else {
            body.classList.remove('dark-mode');
            // Muda o ícone para lua se estiver em light mode
            if (darkModeToggle) {
                darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }
        }
    }

    // Aplica o dark mode ao carregar a página
    applyDarkMode();

    // Adiciona o evento de clique no botão dark mode
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            const isDarkMode = body.classList.contains('dark-mode');
            
            if (isDarkMode) {
                // Desativa dark mode
                body.classList.remove('dark-mode');
                darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                localStorage.setItem('darkMode', 'disabled');
            } else {
                // Ativa dark mode
                body.classList.add('dark-mode');
                darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                localStorage.setItem('darkMode', 'enabled');
            }
        });
    }

    // Verifica a cada segundo se o dark mode mudou (para persistência)
    setInterval(applyDarkMode, 1000);
});