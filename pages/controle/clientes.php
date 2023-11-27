<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Functions
    function search($termSearch)
    {
        include("../../assets/php/connection.php");
        if ($termSearch == 'all') {
            $stmt = $conexao->prepare("SELECT id, nome, cpf, data_nascimento, celular FROM cliente");
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $searchValue = "%$termSearch%";
            $stmt = $conexao->prepare("SELECT id, nome, cpf, data_nascimento, celular FROM cliente WHERE nome LIKE ?");
            $stmt->bind_param("s", $searchValue);
            $stmt->execute();
            $resultado = $stmt->get_result();
        }
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['nome']}</td>";
                echo "<td>{$row['cpf']}</td>";
                echo "<td>{$row['data_nascimento']}</td>";
                echo "<td>{$row['celular']}</td>";
                echo "<td>
                    <input class='edit' type='button' data-id='" . $row['id'] . "' value='Editar'>
                    <input class='delete' type='button' data-id='" . $row['id'] . "' value='Excluir'>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum cliente encontrado.</td></tr>";
        }
    }

    function editValue($id)
    {
        include("../../assets/php/connection.php");
        $stmt = $conexao->prepare("SELECT id, nome, cpf, data_nascimento, celular FROM cliente WHERE id = ?");
        $stmt->bind_param("i", $id);
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
                echo "<td>
                <input type='button' id='editarCliente' value='Editar'>
                <input type='button' id='excluirCliente' value='Excluir'>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum cliente encontrado.</td></tr>";
        }
    }
    function updateData($id, $nome, $cpf, $data_nascimento, $celular)
    {
        include("../../assets/php/connection.php");
        $stmt = $conexao->prepare("UPDATE cliente SET nome = ?, cpf = ?, data_nascimento = ?, celular = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $cpf, $data_nascimento, $celular, $id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error: " . $stmt->error;
        }
        $stmt->close();
        $conexao->close();
    }

    // Conexão
    require_once("../../assets/php/auth_session.php");
    include("../../assets/php/connection.php");

    // Quando houver um clique em .edit (botão de edição)
    if (isset($_POST['action']) && $_POST['action'] == 'getClienteData') {
        $id = $_POST['id'];
        $stmt = $conexao->prepare("SELECT id, nome, cpf, data_nascimento, celular FROM cliente WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateClientData') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $data_nascimento = $_POST['data_nascimento'];
        $celular = $_POST['celular'];
        updateData($id, $nome, $cpf, $data_nascimento, $celular);
        mysqli_close($conexao);
        exit;
    }

    // Quando enviar o formulário de pesquisa
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['searchTerm'])) {
            $searchValue = $_POST['searchTerm'] ?? 'all';
            search($searchValue);
        }
        mysqli_close($conexao);
        exit;
    }

} else {
    // Acesso no diretório raiz
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
        <form class="search-form" id="searchForm" method="POST">
            <input class="search-input" type="text" name="searchTerm" placeholder="Digite para pesquisar...">
            <button class="search-button" type="submit"><img class="icons" src="../assets/img/search-icon.png"
                    alt="Icon"></button>
        </form>
    </div>

    <div id="editModal" class="modal hidden">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="editForm">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Data de Nascimento</th>
                            <th>Celular</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" id="id" readonly>
                            </td>
                            <td>
                                <input type="text" id="nome">
                            </td>
                            <td>
                                <input type="text" id="cpf">
                            </td>
                            <td>
                                <input type="date" id="data_nascimento">
                            </td>
                            <td>
                                <input type="text" id="celular">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="button" value="Salvar" id="salvar">
                <input class="close" type="button" value="Cancelar">
            </form>
        </div>
    </div>

    <div id="excluirModal" class="modal hidden">
        <div class="modal-content">
            <span class="close">&times;</span>
            <input type="button" value="Confirmar">
            <input class="close" type="button" value="Cancelar">
        </div>
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
                <?php search('all'); ?>
            </tbody>
        </table>
    </div>
</body>

</html>