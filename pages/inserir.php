<?php

require_once("../assets/php/connection.php");

$nome = "Admin";
$cargo = "Administrador";
$usuario = "Admin";
$senha = "123abC";
$email = "comercialexemplo@bit.com";
$celular = "(00) 00000-0000";

$insert = $conexao->prepare("INSERT INTO funcionario (nome, cargo, usuario, senha, email, celular) VALUES (?, ?, ?, ?, ?, ?)");
$insert->bind_param("ssssss", $nome, $cargo, $usuario, $senha, $email, $celular);

$insert->execute()
?>
