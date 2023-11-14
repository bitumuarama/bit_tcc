<?php
require_once("../../assets/php/connection.php");

$searchValue = $_GET['search'] ?? '';
$searchValue = "%$searchValue%"; // Prepara a pesquisa para LIKE

$stmt = $conexao->prepare("SELECT id, nome FROM cliente WHERE nome LIKE ?");
$stmt->bind_param("s", $searchValue);
$stmt->execute();
$cliente_resultado = $stmt->get_result();

if ($cliente_resultado->num_rows > 0) {
  while ($cliente = $cliente_resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$cliente['id']}</td>";
    echo "<td>{$cliente['nome']}</td>";
    echo "<td><input type='radio' name='clienteSelecionado' value='{$cliente['id']}'></td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='3'>Nenhum cliente encontrado.</td></tr>";
}
$conexao->close();
?>
