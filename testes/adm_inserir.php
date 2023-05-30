<?php
// Dados de conexão com o banco de dados
$servername = "localhost";
$database = "bit_tcc";
$username_db = "root";
$password_db = "";

// Dados do usuário para inserção
$nome = "Bruno Bertolli";
$senha = "123";
$email = "bertolli@example.com";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Verificar se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
  die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Preparar a consulta SQL para inserção
$sql = "INSERT INTO usuario (nome, senha, email) VALUES ('$nome', '$senha', '$email')";

// Executar a consulta SQL
if ($conn->query($sql) === TRUE) {
  echo "Registro inserido com sucesso!";
} else {
  echo "Erro ao inserir registro: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
