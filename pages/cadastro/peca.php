<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);


  require_once("../../assets/php/auth_session.php");
  include("../../assets/php/connection.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $marca = $_POST['marca'];
    $categoria = $_POST['categoria'];
    $estoque_minimo = $_POST['estoque_minimo'];
    $estoque_atual = $_POST['estoque_atual'];
    $valor_custo = $_POST['valor_custo'];
    $valor_venda = $_POST['valor_venda'];

    $insert = $conexao->prepare("INSERT INTO peca (nome, descricao, marca, categoria, estoque_minimo, estoque_atual, valor_custo, valor_venda) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("ssssiddi", $nome, $descricao, $marca, $categoria, $estoque_minimo, $estoque_atual, $valor_custo, $valor_venda);

    if ($insert->execute()) {
      echo "success";
    } else {
      echo "error: " . $insert->error;
    }

    $insert->close();
    $conexao->close();
    exit;
  }
} else {
  // Acesso não-AJAX, nega acesso
  header('HTTP/1.0 403 Forbidden');
  exit;
}
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Peças</title>
  <script src="../assets/js/masks.js"></script>
</head>

<body>
  <h2>Cadastrar Peças</h2>
  <form class="grid-template" id="submitForm" method="POST">

    <div class="larger-field field">
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" placeholder="Nome da Peça" required>
    </div>

    <div class="textarea-field field">
      <label for="descricao">Descrição</label>
      <textarea name="descricao" id="descricao" placeholder="Descrição da Peça" required></textarea>
    </div>

    <div class="normal-field field">
      <label for="marca">Marca</label>
      <input type="text" name="marca" id="marca" placeholder="Marca da Peça" required>
    </div>

    <div class="normal-field field">
      <label for="categoria">Categoria</label>
      <input type="text" name="categoria" id="categoria" placeholder="Categoria da Peça" required>
    </div>

    <div class="extra-small-field field">
      <label for="estoque_minimo">Estoque Mínimo</label>
      <input type="number" name="estoque_minimo" id="estoque_minimo" min="0" required>
    </div>

    <div class="extra-small-field field">
      <label for="estoque_atual">Estoque Atual</label>
      <input type="number" name="estoque_atual" id="estoque_atual" min="0" required>
    </div>

    <div class="extra-small-field field">
      <label for="valor_custo">Valor de Custo</label>
      <input type="text" class="contabil" name="valor_custo" id="valor_custo" placeholder="R$ 0,00" required>
    </div>

    <div class="extra-small-field field">
      <label for="valor_venda">Valor de Venda</label>
      <input type="text" class="contabil" name="valor_venda" id="valor_venda" placeholder="R$ 0,00" required>
    </div>

    <div class="button-area">
      <button type="submit" name="salvar">Cadastrar</button>
    </div>
  </form>
</body>

</html>