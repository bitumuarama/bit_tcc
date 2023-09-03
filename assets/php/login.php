<?php
if (isset($_POST['submit'])) {
    $email = $_POST['username'];
    $senha = $_POST['password'];

    session_start();

    require_once("connection.php");

    // Declaração preparada para evitar SQL injection
    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE BINARY nome = ? AND BINARY senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];

        // Antes de qualquer saída
        header("location: ../../pages/dashboard.php");
        exit; // Saída script após redirecionar
    } else {
        $_SESSION['erro'] = "Usuário ou senha inválidos.";
        header("location: ../../index.php");
        exit; // Saída script após redirecionar
    }
} else {
    header("location: ../../index.php"); // Redirecionamento em caso de falha
    exit; // Saída do script após redirecionar
}
?>
