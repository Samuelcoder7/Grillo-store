<?php
/**
 * ============================================================================
 * PÁGINA: SUPER ADMINISTRADOR
 * ============================================================================
 * Esta página é exclusiva para super administradores do sistema.
 * Apenas usuários com emails autorizados podem acessar.
 * 
 * FLUXO DE SEGURANÇA:
 * 1. session_start() → Inicia a sessão do usuário
 * 2. require_once(middleware-super-admin.php) → Valida permissões de admin
 *    - Se usuário não logado → Redireciona para login.php
 *    - Se logado mas não é super admin → Redireciona para login.php
 *    - Se é super admin → Continua carregando a página
 * 
 * EMAILS PERMITIDOS:
 * - sdvr2017@gmail.com
 * - pabloviniciusog@gmail.com
 */

/**
 * SEÇÃO: Inicialização de Sessão e Autenticação
 * ============================================================================
 */

// Inicia a sessão para acessar dados do usuário logado
session_start();

/**
 * INCLUSÃO DO MIDDLEWARE DE VALIDAÇÃO
 * ===================================
 * O arquivo 'middleware-super-admin.php' contém:
 * - Whitelist de emails autorizados
 * - Lógica de validação de permissões
 * - Redirecionamento automático se não autorizado
 * 
 * require_once(): garante que o arquivo seja incluído apenas uma vez
 * (evita erros se o arquivo for incluído múltiplas vezes)
 */
require_once('middleware-super-admin.php');


?>

<!DOCTYPE html>
<!-- DOCTYPE declara que este é um documento HTML5 -->

<html lang="pt-BR">
<!-- Define idioma da página como Português Brasileiro -->

<head>
    <!-- Seção de metadados e configurações da página -->
    
    <!-- Define conjunto de caracteres UTF-8 (suporta acentos e caracteres especiais) -->
    <meta charset="UTF-8">
    
    <!-- Viewport: instrui navegadores mobile a usar a largura real do dispositivo -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título que aparece na aba do navegador -->
    <title>Grillo Store - Super Administrador</title>
    
    <!-- Link para arquivo CSS da página (estilo visual) -->
    <link rel="stylesheet" href="../estilo/super-administrador.css">
</head>

<body>
    <!-- SEÇÃO: CABEÇALHO COM TÍTULO
         ====================================================================
         Exibe o título principal da página do painel administrativo -->
    
    <div class="Titulo">
        <!-- Título principal em h1 (maior destaque visual) -->
        <h1>Painel do Super Administrador</h1>
    </div>

    <!-- SEÇÃO: NAVEGAÇÃO / MENU DE GERENCIAMENTO
         ====================================================================
         Menu com links para diferentes áreas de gestão do e-commerce -->
    
    <div class="Botoes navegacao">
        <!-- Elemento NAV (semântico) que contém a navegação -->
        <nav>
            <!-- Lista não ordenada de links de navegação -->
            <ul>
                <!-- Link para gerenciar produtos (CRUD: Create, Read, Update, Delete) -->
                <li><a href="gerenciar_produtos.php">Gerenciar Produtos</a></li>
                
                <!-- Link para gerenciar categorias de produtos -->
                <li><a href="gerenciar_categorias.php">Gerenciar Categorias</a></li>
                
                <!-- Link para gerenciar usuários do sistema -->
                <li><a href="gerenciar_usuarios.php">Gerenciar Usuários</a></li>
                
                <!-- Link para visualizar relatórios e estatísticas -->
                <li><a href="relatorios.php">Relatórios</a></li>
                
                <!-- Link para painel de mensagens (contato do cliente) -->
                <li><a href="painel_mensagens.php">Painel de Mensagens</a></li>
            </ul>
        </nav>
    </div>

</body>

</html>