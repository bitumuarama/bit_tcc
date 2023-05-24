<?php
// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter as informações do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conectar ao banco de dados
    $servername = "localhost";
    $database = "bit_tcc";
    $username_db = "root";
    $password_db = "";

    $conn = new mysqli($servername, $username_db, $password_db, $database);

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta SQL para verificar as credenciais
    $sql = "SELECT * FROM usuario WHERE nome = '$username' AND senha = '$password'";
    $result = $conn->query($sql);

    // Verificar se a consulta retornou algum resultado
    if ($result->num_rows === 1) {
        // Credenciais válidas, redirecionar para a página de controle
        header("Location: pages/sistema.php");
        exit();
    } else {
        // Credenciais inválidas, exibir mensagem de erro
        $error_message = "Usuário ou senha inválidos.";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>


    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
  <div class="container">
    <div class="logo-container">
      <img src="assets/img/logo_bit_200x100.png" alt="Logo da Empresa">
    </div>
  
    <?php if (isset($error_message)): ?>
      <p><?php echo $error_message; ?></p>
    <?php endif; ?>
  
    <form method="POST">
      <label for="username">Usuário:</label>
      <input type="text" id="username" name="username" required>
  
      <label for="password">Senha:</label>
      <input type="password" id="password" name="password" required>
  
      <button type="submit">Entrar</button>
    </form>
  </div>

 <!--   <footer>
    <p>Este site é restrito e só pode ser acessado por pessoal autorizado. Em caso de dúvidas, entre em contato com o Administrador.</p>
</footer> -->
</body>
</html>
