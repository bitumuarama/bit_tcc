<?php require_once('../assets/php/auth_session.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/logo.ico">

    <link rel="stylesheet" href="../assets/css/sistema.css">
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
                <a class="user-info user-id" href="">ID:
                    <p>
                        <?php
                        function formatID($id)
                        {
                            return str_pad($id, 5, '0', STR_PAD_LEFT);
                        }

                        $userID = $_SESSION['id'];
                        $formattedID = formatID($userID);

                        echo $formattedID;
                        ?>
                    </p>
                </a>
                <a class="user-info user-pos" href="">Cargo:</a>
            </div>
        </div>
        <div>
            <a class="logout-link" href="../assets/php/exit.php">Sair</a>
        </div>
    </header>

    <main>
        <div class="menu">
            <div class="menu-button" id="menuButton">
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
            </div>
            <ul class="menu-items" id="menuItems">
                <li><a href="#1">Página 1</a></li>
                <li><a href="#2">Página 2</a></li>
                <li><a href="#3">Página 3</a></li>
                <li><a href="#4">Página 4</a></li>
            </ul>
        </div>
        <script src="../assets/js/menu.js"></script>
        <br>
        <div class="content">
            <!-- Your page content goes here -->
            <h1>Welcome to My Website!</h1>
            <p>This is the content area that will change dynamically based on the selected menu option.</p>
        </div>

    </main>
</body>

</html>