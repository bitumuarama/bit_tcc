<?php
ob_start(); // Inicia o buffer de saída
require_once('../../assets/php/auth_session.php');
include('../../assets/php/connection.php');

if (isset($_POST['salvar'])) {
  $nome = $_POST['nome'];
  $cpf = $_POST['cpf'];
  $rg = $_POST['rg'];
  $cidade = $_POST['cidade'];
  $endereco = $_POST['endereco'];
  $cep = $_POST['cep'];
  $estado = $_POST['estado'];
  $telefone = $_POST['telefone'];
  $data = $_POST['data'];

  $stmt = $conexao->prepare("INSERT INTO cliente (nome, cpf, rg, cidade, endereco, cep, estado, telefone, data_nascimento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssssss", $nome, $cpf, $rg, $cidade, $endereco, $cep, $estado, $telefone, $data);

  if ($stmt->execute()) {
    $_SESSION['status'] = 'success';
    header("Location: ../dashboard.php#cadastro/cliente");
    exit();
  } else {
    $_SESSION['status'] = 'error';
    header("Location: ../dashboard.php#cadastro/cliente");
    exit();
  }
} else {
  $_SESSION['status'] = 'error';
  header("Location: ../dashboard.php#cadastro/cliente");
}
ob_end_flush(); // Envia o buffer de saída e desliga o bufferamento
?>