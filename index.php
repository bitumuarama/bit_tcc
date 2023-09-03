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
        <img src="assets/img/logo_bit_300x150px.svg" alt="LOGO">
        <div class="login-form">
            <form action="assets/php/login.php" method="POST">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password">
                <p class="login-erro">
                    <?php
                    if (isset($_SESSION['erro'])) {
                        echo $_SESSION['erro'];
                        unset($_SESSION['erro']); // Limpar a variável de sessão
                    }
                    ?>
                </p>
                <button type="submit" name="submit">Entrar</button>
            </form>
        </div>
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        ?>
        <div class="login-alert">
            <p>
                Parece que você já possui uma sessão ativa como
                <?php echo $_SESSION['nome'] ?>, deseja ser redirecionado ao sistema?
                <a href="pages/dashboard.php" class="button">Entrar</a>
            </p>
        </div>
        <?php
    } ?>


    <footer>
        <p class="site-name">Bertolli Info Technology</p>
        <p class="copyright">Copyright © 2023 - Todos os direitos reservados.</p>
    </footer>
</body>

</html>