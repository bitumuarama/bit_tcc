<?php
ob_start(); // Inicia o buffer de saída
require_once('../../assets/php/auth_session.php');
include('../../assets/php/connection.php');

if (isset($_POST['salvar'])) {
  $equipamento = $_POST['equipamento'];
  $problema_relatado = $_POST['problemarelatado'];
  $problema_constatado = $_POST['problemaconstatado'];
  $servico_executado = $_POST['servicoexecutado'];
  $servico = implode(', ', $_POST['servicos']); // Transforma o array em uma string separada por vírgulas
  $cliente = $_POST['cliente_id'];
  $peca = $_POST['peca_id'];
  $valor_servico = $_POST['valorservico'];
  $valor_total = $_POST['valortotal'];

  $stmt = $conexao->prepare("INSERT INTO ordem_de_servico (equipamento, problema_relatado, problema_constatado, servico_executado, servico, valor_servico, id_cliente, id_peca, valor_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssssss", $equipamento, $problema_relatado, $problema_constatado, $servico_executado, $servico, $cliente, $peca, $valor_servico, $valor_total);

  if ($stmt->execute()) {
    $_SESSION['status'] = 'success';
    header("Location: ../dashboard.php#cadastro/cliente");
    exit();
  } else {
    $_SESSION['status'] = 'error';
    exit();
  }
} else {
  $_SESSION['status'] = 'error';
  header("Location: ../dashboard.php#cadastro/ordem-de-servico");
}
ob_end_flush(); // Envia o buffer de saída e desliga o bufferamento
?>