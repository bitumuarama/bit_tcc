<?php

$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "bit_tcc";
$conexao = mysqli_connect($host, $username, $password, $database);


if (isset($_POST['salvar'])) {
  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $marca = $_POST['marca'];
  $categoria = $_POST['categoria'];
  $estmin = $_POST['estmin'];
  $estatual = $_POST['estatual'];
  $valorcusto = $_POST['valorcusto'];
  $valorvenda = $_POST['valorvenda'];


  //3. Preparar a SQL
  $sql = "insert into peca (nome, descricao, marca, categoria, estoqueminimo, estoqueatual, valorcusto, valorvenda) values ('$nome', '$descricao', ' $marca', '$categoria', '$estmin', '$estatual', 
    '$valorcusto', '$valorvenda')";

  //4. Executar a SQL
  mysqli_query($conexao, $sql);


}

?>