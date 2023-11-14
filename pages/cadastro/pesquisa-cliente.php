<?php
// Inclua seu arquivo de conexão com o banco de dados
require_once("../../assets/php/connection.php");

$termo = $_GET['termo'] ?? '';
$termo = "%$termo%"; // Prepare o termo para a pesquisa com o LIKE

// Prepare e execute a consulta
$stmt = $conexao->prepare("SELECT id, nome FROM cliente WHERE nome LIKE ?");
$stmt->bind_param("s", $termo);
$stmt->execute();
$resultado = $stmt->get_result();

// Construa os resultados da pesquisa
while ($cliente = $resultado->fetch_assoc()) {
  echo "<div class='cliente-result' data-id='{$cliente['id']}' data-nome='{$cliente['nome']}'>{$cliente['nome']}</div>";
}

$conexao->close();
?>
