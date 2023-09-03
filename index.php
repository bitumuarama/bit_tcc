<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Login</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.ico">

    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="container">
        <img src="assets/img/logo_bit_200x100.png" alt="LOGO">
        <div class="login-form">
            <form action="assets/php/login.php" method="POST">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <p class="login-erro">
                    <?php
                    if (isset($_SESSION['erro'])) {
                        echo $_SESSION['erro'];
                        unset($_SESSION['erro']);
                    }
                    ?>
                </p>
                <?php if (isset($_SESSION['id'])): ?>
                    <a href="pages/dashboard.php" class="button-link">Entrar</a>
                <?php else: ?>
                    <button type="submit" name="submit">Entrar</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        ?>
        <a class="login-alert" href="pages/dashboard.php" class="button">
            <div class="login-alert-mensage">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 72 72"
                    style="fill:#FFFFFF;">
                    <path
                        d="M 43 12 C 40.791 12 39 13.791 39 16 C 39 18.209 40.791 20 43 20 L 46.34375 20 L 35.171875 31.171875 C 33.609875 32.733875 33.609875 35.266125 35.171875 36.828125 C 35.951875 37.608125 36.977 38 38 38 C 39.023 38 40.048125 37.608125 40.828125 36.828125 L 52 25.65625 L 52 29 C 52 31.209 53.791 33 56 33 C 58.209 33 60 31.209 60 29 L 60 16 C 60 13.791 58.209 12 56 12 L 43 12 z M 23 14 C 18.037 14 14 18.038 14 23 L 14 49 C 14 53.962 18.037 58 23 58 L 49 58 C 53.963 58 58 53.962 58 49 L 58 41 C 58 38.791 56.209 37 54 37 C 51.791 37 50 38.791 50 41 L 50 49 C 50 49.551 49.552 50 49 50 L 23 50 C 22.448 50 22 49.551 22 49 L 22 23 C 22 22.449 22.448 22 23 22 L 31 22 C 33.209 22 35 20.209 35 18 C 35 15.791 33.209 14 31 14 L 23 14 z">
                    </path>
                </svg>
                <p class="mensagem">
                    Sessão Ativa:
                    <?php echo $_SESSION['nome'] ?>!
                </p>
            </div>
            <span class="barra"></span>
        </a>
        <script src="assets/js/login-alert.js"></script>
        <?php
    } ?>


    <footer>
        <p class="site-name">Bertolli Info Technology</p>
        <p class="copyright">Copyright © 2023 - Todos os direitos reservados.</p>
    </footer>
</body>

</html>