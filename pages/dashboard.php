<?php require_once('../assets/php/auth_session.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/logo.ico">

    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <header>
        <div class="user-primary-info">
            <a class="user-profile-img " href="?perfil">
                <img src="<?php $_img ?>" alt="">
            </a>
            <div class="user-identify">
                <a class="user-info user-name" href="">Nome:
                    <p>
                        <?php echo $_SESSION['nome'] ?>
                    </p>
                </a>
            </div>
        </div>
        <img src="../assets/img/logo_bit_200x100.png" alt="Logo" class="logo" onclick="restaurarConteudoPadrao()">

        <div class="logout-area">
            <a class="logout-button" href="../assets/php/exit.php">Sair</a>
            <!-- Menu -->
            <div class="mobile-menu">

                <input id="dropdown" class="input-box" type="checkbox" style="display:none;">

                <label for="dropdown" class="dropdown">
                    <span class="hamburger">
                        <span class="icon-bar top-bar"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </span>
                </label>
                <script src="teste.js"></script>
            </div>
        </div>

    </header>

    <main>
        <!-- Menu -->
        <div class="menu">
            <div class="desktop-menu" id="desktopMenu">
                <div class="menu-header" id="menuHeader">

                    <a class="menu-title" id="desktopMenuTitle" href="" onclick="restaurarConteudoPadrao()">Painel de
                        Controle</a>
                    <div class="desktop-menu-icon" id="desktopMenuIcon">
                        <div class="central-bar" id="desktopMenuBar"></div>
                    </div>
                </div>

                <div class="desktop-menu-items" id="desktopMenuItems">

                    <ul class="menu-list" id="mliCadastro">
                        <h2>Controle</h2>
                        <li><a href="#controle/ordem-de-servico">Ordem de Serviço</a></li>
                        <li><a href="#controle/pagamentos">Pagamentos</a></li>
                        <li><a href="#controle/clientes">Clientes</a></li>
                        <li><a href="#controle/funcionarios">Funcionários</a></li>
                    </ul>
                    <ul class="menu-list" id="mliCadastroUsuario">
                        <h2>Cadastro</h2>
                        <li><a href="#cadastro/usuario">Usuário</a></li>
                        <li><a href="#cadastro/cliente">Cliente</a></li>
                        <li><a href="#cadastro/funcionario">Funcionário</a></li>
                    </ul>
                    <ul class="menu-list" id="mliCadastroUsuario">
                        <h2>Relatórios </h2>
                        <li><a href="#relatorio/servicos">Serviços</a></li>
                        <li><a href="#relatorio/pecas">Peças</a></li>
                        <li><a href="#relatorio/clientes">Clientes</a></li>
                        <li><a href="#relatorio/ordem_servico">Ordem de Serviço</a></li>
                    </ul>
                </div>
                <script src="../assets/js/dashboard/desktop-menu.js"></script>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="content" id="content">
            <h1>Bem-vindo ao Sistema</h1>
            <p>Olá,
                <?php echo $_SESSION['nome'] ?>! Esperamos que aproveite sua experiência.
            </p>
            <h2>Dicas Rápidas</h2>
            <ul>
                <li id="dica-01"></li>
                <li id="dica-02"></li>
                <li id="dica-03"></li>
                <li id="dica-04"></li>
                <li id="dica-05"></li>
            </ul>
            <script src="../assets/js/gerador-de-dicas.js"></script>
            <p>Aproveite essas orientações para facilitar suas tarefas e assegurar a operação eficiente do sistema.</p>
            <h2>Sobre o Nosso Sistema</h2>
            <div class="feature">
                <p>Explore todas as possibilidades que nosso sistema de ponta oferece para otimizar as operações da sua
                    empresa. Nossa solução abrangente aborda diversos aspectos da gestão empresarial:</p>
                <ul>
                    <li><strong>Ordens de Serviço Eficientes:</strong> Gerencie suas ordens de serviço de maneira
                        eficaz, garantindo um fluxo de trabalho contínuo e organizado.</li>
                    <li><strong>Inventário Sempre Atualizado:</strong> Mantenha controle total sobre as peças e
                        componentes, evitando atrasos e interrupções desnecessárias.</li>
                    <li><strong>Segurança de Dados Priorizada:</strong> Assegure a confidencialidade dos dados dos
                        clientes e da empresa por meio de medidas de segurança avançadas.</li>
                    <li><strong>Agendamento Simplificado:</strong> Facilite a vida dos clientes permitindo que agendem
                        serviços online, proporcionando comodidade e eficiência.</li>
                    <li><strong>Registro Detalhado das Atividades:</strong> Tenha um histórico completo de todas as
                        atividades no sistema para rastreabilidade e auditorias precisas.</li>
                </ul>
                <script src="../assets/js/dashboard/content.js"></script>

            </div>

    </main>

</body>

</html>