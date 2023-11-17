<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once("../../assets/php/auth_session.php");
    include("../../assets/php/connection.php");





    // Fazer código para apresentar valores na tabela.
    if (isset($_GET['search'])) {

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
    <title>Controle de Clientes</title>
</head>

<body>
    <h2>Controle de Clientes</h2>
    <div id="searchSection">
        <form id="searchFormCliente">
            <input type="text" id="searchTermCliente" placeholder="Digite para pesquisar...">
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <div id="clientList">
        <table id="clientsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
                    <th>Celular</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="search-results-cliente">
                <?php
                $stmt = $conexao->prepare("SELECT id, nome FROM cliente");
                $stmt->execute();
                $cliente_resultado = $stmt->get_result();

                if ($cliente_resultado->num_rows > 0) {
                    while ($cliente = $cliente_resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$cliente['id']}</td>";
                        echo "<td>{$cliente['nome']}</td>";
                        echo "<td><input type='button' name='clienteSelecionado' value='{$cliente['id']}'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum cliente encontrado.</td></tr>";
                }
                ?>

                <input type="button" value="Selecionar">
            </tbody>
        </table>
    </div>
</body>

</html>