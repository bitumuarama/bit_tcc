<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../assets/php/auth_session.php");
include("../../assets/php/connection.php");
include("../../assets/php/cpf_validation.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['nome']) && isset($_POST['cpf'])) {
    // A conexão deve ser estabelecida antes de qualquer operação com o banco de dados
    $conexao = mysqli_connect($host, $username, $password, $database);

    if (!$conexao) {
      die("Erro de conexão: " . mysqli_connect_error());
    }

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];

    if (!validaCPF($cpf)) {
      echo "cpf";
      mysqli_close($conexao);
      exit;
    }

    // Verifica se o CPF já existe no banco de dados
    $query = $conexao->prepare("SELECT * FROM cliente WHERE cpf = ?");
    $query->bind_param("s", $cpf);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
      echo "already";
      mysqli_close($conexao);
      exit;
    } else {
      // Prepara a inserção usando consultas preparadas para evitar injeção de SQL
      $rg = $_POST['rg'];
      $cidade = $_POST['cidade'];
      $endereco = $_POST['endereco'];
      $cep = $_POST['cep'];
      $estado = $_POST['estado'];
      $telefone = $_POST['telefone'];
      $data_nascimento = $_POST['data'];

      $insert = $conexao->prepare("INSERT INTO cliente (nome, cpf, rg, cidade, endereco, cep, estado, telefone, data_nascimento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insert->bind_param("sssssssss", $nome, $cpf, $rg, $cidade, $endereco, $cep, $estado, $telefone, $data_nascimento);

      if ($insert->execute()) {
        echo "success";
      } else {
        echo "error";
      }
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

  <script src="../assets/js/masks.js"></script>
</head>

<body>
  <h2>Cadastrar Clientes</h2>
  <form class="grid-template" action="cliente.php" method="POST">


    <div class="larger-field field">
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" required>
    </div>

    <div class="extra-small-field field">
      <label for="data">Data nascimento</label>
      <input type="date" name="data" id="data">
    </div>

    <div class="extra-small-field field">
      <label for="rg">RG</label>
      <input type="text" name="rg" id="rg">
    </div>

    <div class="extra-small-field field">
      <label for="cpf">CPF</label>
      <input type="text" name="cpf" id="cpf">


    </div>


    <div class="small-field field">
      <label for="celular">Celular</label>
      <input type="text" name="celular" id="celular">

    </div>

    <div class="larger-field field">
      <label for="endereco">Endereço</label>
      <input type="text" name="endereco" id="endereco">
    </div>

    <div class="small-field field">
      <label for="cep">CEP</label>
      <input type="text" name="cep" id="cep">
    </div>

    <div class="normal-field field">
      <label for="cidade">Cidade</label>
      <input type="text" name="cidade" id="cidade">
    </div>

    <div class="small-field field">
      <label for="estado">Estado</label>
      <select name="estado" id="estado">
        <option value="SC">Santa Catarina</option>
        <option value="PR" selected>Paraná</option>
        <option value="SP">São Paulo</option>
      </select>
    </div>


    <div class="button-area">
      <button type="submit" name="salvar">Cadastrar</button>
    </div>
  </form>
</body>

</html>