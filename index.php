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
        <div class="img-login-box ">
            <img src="assets/img/logo_bit_300x150px.svg" alt="Logo da Empresa">
        </div>
        <div class="login-box">

            <form action="assets/php/login.php" method="POST">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username">

                <label for="password">Senha:</label>
                <input type="password" id="password" name="password">
                <?php if (isset($error_message)): ?>
                    <p class="login-erro">
                        <?php echo $error_message; ?>
                    </p>
                <?php endif; ?>

                <button type="submit" name="submit">Entrar</button>
            </form>
        </div>
    </div>
    <footer class="login-footer">
        <div class="footer-container">
            <p class="site-name">Bertolli Info Technology</p>
            <p class="copyright">Copyright © 2023 - Todos os direitos reservados.</p>
        </div>
    </footer>
</body>

</html>