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
    } else {
        
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
            $error_message = "Usuário ou Senha inválidos!";
        }
        
        // Fechar a conexão com o banco de dados
        $conn->close();
    }
}
?>

