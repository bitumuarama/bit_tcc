<?php
if (isset($_POST['submit'])) {
    $email = $_POST['username'];
    $senha = $_POST['password'];

    session_start();

    $sql = "SELECT * FROM usuario
            WHERE BINARY nome = '{$email}'
            AND BINARY senha = '{$senha}'";

    require_once("connection.php");
    $resultado = mysqli_query($conexao, $sql);
    $registros = mysqli_num_rows($resultado);

    if ($registros > 0) {
        $usuario = mysqli_fetch_array($resultado);


        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];

        echo "Logado com sucesso";
        header("location: ../../pages/dashboard.php");
        exit; // Saia do script após redirecionar
    } else {
        $_SESSION['erro'] = "Usuário ou senha inválidos.";
        header("location: ../../index.php");
        exit; // Saia do script após redirecionar
    }
}
?>