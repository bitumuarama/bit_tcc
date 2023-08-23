<?php
if (isset($_GET['login_error']) && $_GET['login_error'] == 1) {
    // Exibe o modal se houver um erro de login
    echo '<div class="modal-container" id="modalContainer">
            <div class="modal-content">
                <p>Usuário ou senha inválido(s).</p>
                <button onclick="closeModal()">Fechar</button>
            </div>
          </div>';
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

    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="container">
        <img src="assets/img/logo_bit_300x150px.svg" alt="LOGO">


        <footer>
            <div class="footer-container">
                <p class="site-name">Bertolli Info Technology</p>
                <p class="copyright">Copyright © 2023 - Todos os direitos reservados.</p>
            </div>
        </footer>
</body>

</html>