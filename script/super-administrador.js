async function desenharGrafico() {
    try {
        // Busca os dados JSON do nosso arquivo PHP
        const response = await fetch('dados_grafico.php');
        const data = await response.json();

        const ctx = document.getElementById('graficoEstoqueCategoria').getContext('2d');

        new Chart(ctx, {
            type: 'bar', // Tipo do gráfico: Barras
            data: {
                labels: data.labels, // Nomes das Categorias (Eixo X)
                datasets: [{
                    label: 'Valor Total de Estoque (R$)',
                    data: data.data, // Valores (Eixo Y)
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valor em Reais (R$)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

    } catch (error) {
        console.error('Erro ao buscar dados do gráfico:', error);
        document.getElementById('graficoEstoqueCategoria').innerHTML = '<p style="text-align:center; color:red;">Não foi possível carregar os dados do gráfico.</p>';
    }
}

// 2. Chama a função para desenhar o gráfico quando a página carregar
document.addEventListener('DOMContentLoaded', desenharGrafico);