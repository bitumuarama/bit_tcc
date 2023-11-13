<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {

  header('HTTP/1.0 403 Forbidden');
  echo 'Você não tem permissão para acessar este arquivo diretamente.';
  exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['id'])) {
  $_SESSION['erro'] = "Sessão expirada. Faça login novamente!";
  header("location: ../index.php");
}


require_once("../../assets/php/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['nome'])) {
    // O código para processar o formulário vai aqui
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $cidade = $_POST['cidade'];
    $endereco = $_POST['endereco'];
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data'];


    $conexao = mysqli_connect($host, $username, $password, $database);

    $sql = "INSERT INTO cliente (nome, cpf, rg, cidade, endereco, cep, estado, telefone, data_nascimento)
     VALUES ('$nome', '$cpf', '$rg', '$cidade', '$endereco', '$cep', '$estado', '$telefone', '$data_nascimento')";

    if (mysqli_query($conexao, $sql)) {
      $msg = "Dados inseridos com sucesso";
      $timestamp = time(); // Salva o tempo atual
    } else {
      $msg = "Erro: " . $sql . "<br>" . mysqli_error($conexao);
    }

    // Código para verificar se $msg deve ser resetado
    // Supondo que você quer que $msg seja null após 5 segundos
    if (isset($msg) && (time() - $timestamp > 5)) {
      $msg = null;
    }

    // Exibe a mensagem se ela não for null

    mysqli_close($conexao);
    exit;
  }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Cliente</title>
</head>

<body>
  <form action="cliente.php" method="POST">

    <div>
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome">
    </div>
    <div>
      <label for="endereco">Endereço</label>
      <input type="text" name="endereco" id="endereco">
    </div>

    <div>
      <div>
        <label for="cep">CEP</label>
        <input type="text" name="cep" id="cep">
      </div>
      <div>
        <label for="cidade">Cidade</label>
        <input type="text" name="cidade" id="cidade">
      </div>
      <div>
        <label for="estado">Estado</label>
        <input type="text" name="estado" id="estado">
      </div>


    </div>

    <div>
      <div>
        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" id="telefone" size="20" maxlength="15">
      </div>
      <div>
        <label for="rg">RG</label>
        <input type="text" name="rg" id="rg">
      </div>
      <div>
        <label for="cpf">CPF</label>
        <input type="text" name="cpf" id="cpf">
      </div>
      <div>
        <label for="data">Data nascimento</label>
        <input type="date" name="data" id="data">
      </div>
    </div>
    <button type="submit" name="salvar">Cadastrar</button>
  </form>
</body>

</html>