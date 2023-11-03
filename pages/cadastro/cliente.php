<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../assets/php/auth_session.php");
include("../../assets/php/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['nome'])) {
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

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
      echo "success"; // Envia 'success' se a inserção foi bem-sucedida
    } else {
      echo "error"; // Envia 'error' se a inserção falhou
    }

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
<h2>Cadastrar Clientes</h2>
  <form class="grid-template" action="cliente.php" method="POST">


    <div class="normal-field">
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" required>
    </div>

    <div class="small-field">
      <label for="telefone">Telefone</label>
      <input type="text" name="telefone" id="telefone" size="20" maxlength="15">
    </div>

    <div class="normal-field">
      <label for="endereco">Endereço</label>
      <input type="text" name="endereco" id="endereco">
    </div>

    <div class="small-field">
      <label for="cep">CEP</label>
      <input type="text" name="cep" id="cep">
    </div>

    <div class="normal-field">
      <label for="cidade">Cidade</label>
      <input type="text" name="cidade" id="cidade">
    </div>

    <div  class="small-field">
      <label for="estado">Estado</label>
      <select name="estado" id="estado">
        <option value="SC">Santa Catarina</option>
        <option value="PR" selected>Paraná</option>
        <option value="SP">São Paulo</option>
      </select>
    </div>

    <div class="small-field">
      <label for="rg">RG</label>
      <input type="text" name="rg" id="rg">
    </div>
    <div class="small-field">
      <label for="cpf">CPF</label>
      <input type="text" name="cpf" id="cpf">
    </div>
    <div class="small-field">
      <label for="data">Data nascimento</label>
      <input type="date" name="data" id="data">
    </div>
    <div class="button-area">
      <button type="submit" name="salvar">Cadastrar</button>
    </div>
  </form>
</body>

</html>