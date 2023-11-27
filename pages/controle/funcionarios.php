<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once("../../assets/php/auth_session.php");
    include("../../assets/php/connection.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['searchTerm'])) {
            $searchValue = $_POST['searchTerm'] ?? '';
            $searchValue = "%$searchValue%"; // Prepara a pesquisa para LIKE

            $stmt = $conexao->prepare("SELECT id, nome, cpf, data_nascimento, celular FROM cliente WHERE nome LIKE ?");
            $stmt->bind_param("s", $searchValue);
            $stmt->execute();
            $cliente_resultado = $stmt->get_result();
        } else {
            $stmt = $conexao->prepare("SELECT id, nome, cpf, data_nascimento, celular FROM cliente");
            $stmt->execute();
            $cliente_resultado = $stmt->get_result();
        }

        if ($cliente_resultado->num_rows > 0) {
            while ($cliente = $cliente_resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$cliente['id']}</td>";
                echo "<td>{$cliente['nome']}</td>";
                echo "<td>{$cliente['cpf']}</td>";
                echo "<td>{$cliente['data_nascimento']}</td>";
                echo "<td>{$cliente['celular']}</td>";
                echo "<td><input type='button' value='Editar'><input type='button'value='Excluir'></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum cliente encontrado.</td></tr>";
        }
        mysqli_close($conexao);
        exit;
    }


} else {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Funcionários</title>
</head>

<body>
    <h2>Controle de Funcionários</h2>
    <div id="searchSection">
        <form class="search-form" id="searchForm" method="POST">
            <input class="search-input" type="text" name="searchTerm" placeholder="Digite para pesquisar...">
            <button class="search-button" type="submit"><img class="icons" src="../assets/img/search-icon.png"
                    alt="Icon"></button>
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
            <tbody id="search-result">
                <?php
                $stmt = $conexao->prepare("SELECT id, nome, cpf, data_nascimento, celular FROM cliente");
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    while ($pesquisa = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$pesquisa['id']}</td>";
                        echo "<td>{$pesquisa['nome']}</td>";
                        echo "<td>{$pesquisa['cpf']}</td>";
                        echo "<td>{$pesquisa['data_nascimento']}</td>";
                        echo "<td>{$pesquisa['celular']}</td>";
                        echo "<td><input type='button' value='Editar'><input type='button'value='Excluir'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum cliente encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>