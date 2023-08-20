<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <link rel="stylesheet" href="../assets/css/sistema.css">
</head>

<body>
    <header>
        <div class="header-content">
            <div class="user-profile">
                <img src="user-photo.jpg" alt="Foto de Usuário">

                <!-- Modal -->
                <div id="userModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Editar Informações Pessoais</h2>

                        <form method="POST" action="php/login.php">
                            <label for="username">Usuário:
                            </label>
                            <input type="text" id="username" name="username" required>
                            <label for="password">Senha:</label>
                            <input type="password" id="password" name="password" required>
                        </form>
                        <form method="POST" action="php/login.php">
                            <label for="username">Usuário:
                            </label>
                            <input type="text" id="username" name="username" required>
                            <label for="password">Senha:</label>
                            <input type="password" id="password" name="password" required>
                        </form>

                        <!-- Conteúdo do modal para editar as informações do usuário -->
                        <button id="saveButton" class="modal-button save-button">Salvar</button>
                        <button id="cancelButton" class="modal-button cancel-button">Cancelar</button>
                    </div>
                </div>

                <script>
                    // Abrir o modal ao clicar na imagem do usuário
                    var modal = document.getElementById("userModal");
                    var img = document.querySelector(".user-profile img");
                    img.addEventListener("click", function () {
                        modal.style.display = "block";
                    });

                    // Fechar o modal ao clicar no botão de fechar
                    var closeBtn = document.querySelector(".close");
                    closeBtn.addEventListener("click", function () {
                        modal.style.display = "none";
                    });

                    // Fechar o modal ao clicar fora do conteúdo do modal
                    window.addEventListener("click", function (event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    });

                    // Ação ao clicar no botão "Salvar"
                    var saveButton = document.getElementById("saveButton");
                    saveButton.addEventListener("click", function () {
                        // Lógica para salvar as alterações
                        modal.style.display = "none";
                    });

                    // Ação ao clicar no botão "Cancelar"
                    var cancelButton = document.getElementById("cancelButton");
                    cancelButton.addEventListener("click", function () {
                        // Lógica para cancelar as alterações
                        modal.style.display = "none";
                    });
                </script>

                <div class="user-info">
                    <h3>Nome de Usuário</h3>
                    <p>ID de Usuário</p>
                    <p>Horário de Início de Sessão</p>
                </div>
            </div>
            <a href="#" class="logout-button">Sair</a>
        </div>
    </header>

    <!-- Resto do conteúdo do sistema -->

</body>

</html>