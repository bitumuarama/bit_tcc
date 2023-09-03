<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    $_SESSION['erro'] = "Sessão expirada. Faça login novamente!";
    header("location: ../index.php");
}
?>
