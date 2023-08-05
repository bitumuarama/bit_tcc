<?php require_once('../assets/php/auth_session.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Login</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.ico">

    <link rel="stylesheet" href="../assets/css/sistema.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Bem-Vindo ao Sistema!</h1>
            <?php
            session_start();
            $nome = $_SESSION['nome'];
            echo $_SESSION['nome'];
            ?>
            <p>Informações básicas da página e do Usuário...</p>
        </header>



        <!-- Novo contêiner que envolve "cont1" e "int" -->
        <div class="menu-container">
            <div class="cont1">
                <div class="cont2">
                    <h1>PAINEL DE CONTROLE</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </div>

            </div>

            <div class="int">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                    class="bi bi-question-circle-fill" viewBox="0 0 50 50">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                </svg>
            </div>
        </div>

    </div>

    <!-- Adicione o seguinte código JavaScript no final do seu arquivo HTML -->
    <script>
        const menuContainer = document.querySelector('.menu-container');
        const minimizedBar = document.querySelector('.cont2');
        const content = document.querySelector('.cont1');

        minimizedBar.addEventListener('mouseenter', () => {
            menuContainer.classList.add('expanded');
        });

        menuContainer.addEventListener('mouseleave', () => {
            menuContainer.classList.remove('expanded');
        });
    </script>

    <a href="../assets/php/exit.php">Sair</a>
</body>

</html>