<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Login</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img src="assets/img/logo.png" alt="Logo da Empresa">
        </div>
        <form method="POST" action="php/login.php">
            <label for="username">Usuário:

            </label>
            <input type="text" id="username" name="username" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>

            <?php if (isset($error_message)): ?>
                <p class="login-erro">
                    <?php echo $error_message; ?>
                </p>
                    <?php endif; ?>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>

</html>