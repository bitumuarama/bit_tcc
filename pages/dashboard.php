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
        <img src="../assets/img/logo_bit_300x150px.svg" alt="Logo" class="logo" onclick="restaurarConteudoPadrao()">
        <div>
            <a class="logout-link" href="../assets/php/exit.php">Sair</a>
        </div>
    </header>

    <!-- Dashboard Body -->
    <div class="dashboard">

        <!-- Menu -->
        <div class="menu-primary" id="menu">
            <div class="menu-header" id="menuHeader">

                <a class="menu-title" id="menuTitle" href="" onclick="restaurarConteudoPadrao()">Painel de Controle</a>
                <div class="menu-icon" id="menuIcon">
                    <div class="central-bar" id="centralBar"></div>
                </div>
            </div>

            <div class="menu-items" id="menuItems">

                <ul class="menu-list" id="mliCadastroUsuario">
                    <h2>Controle</h2>
                    <li><a href="#controle/ordem_servico">Ordem de Serviço</a></li>
                    <li><a href="#controle/pagamentos">Pagamentos</a></li>
                    <li><a href="#controle/clientes">Clientes</a></li>
                    <li><a href="#controle/funcionarios">Funcionários</a></li>
                </ul>
                <ul class="menu-list" id="mliCadastroUsuario">
                    <h2>Cadastro</h2>
                    <li><a href="#cadastro/usuario">Usuário</a></li>
                    <li><a href="#cadastro/">Cliente</a></li>
                    <li><a href="#cadastro/">Funcionário</a></li>
                    <li><a href="#cadastro/">Página 4</a></li>
                </ul>
                <ul class="menu-list" id="mliCadastroUsuario">
                    <h2>Relatórios </h2>
                    <li><a href="#relatorio/servicos">Serviços</a></li>
                    <li><a href="#relatorio/pecas">Peças</a></li>
                    <li><a href="#relatorio/clientes">Clientes</a></li>
                    <li><a href="#relatorio/ordem_servico">Ordem de Serviço</a></li>
                </ul>

            </div>
            <script src="../assets/js/dashboard-menu.js"></script>
        </div>

        <!-- Conteúdo Dashboard-->
        <div class="content" id="content">
            <h1>Bem-vindo ao Sistema</h1>
            <p>Olá,
                <?php echo $_SESSION['nome'] ?>! Esperamos que aproveite sua experiência.
            </p>

            <h2>Dicas Rápidas</h2>
            <ul>
                <li>Dica 1: [Dica ou truque relevante]</li>
                <li>Dica 2: [Outra dica útil]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
                <li>Dica 3: [Mais uma dica interessante]</li>
            </ul>
            <h2>Destaque de Recurso</h2>
            <div class="feature">
                <h3>[Nome do Recurso Destacado]</h3>
                <p>[Breve descrição do recurso e por que é útil para o usuário.]</p>
                <a href="faq.html">Saiba mais</a>


            </div>
        </div>
        <script src="../assets/js/dashboard-content.js"></script>

    </div>

</body>

</html>