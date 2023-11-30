<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("../../assets/php/cpf_validation.php");
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
                    <div class='actions'>
                    <button class='edit button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/edit-icon.png' alt='Editar'></button>
                    <button class='delete button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/delete-icon.png' alt='Excluir'></button>
                </div></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum cliente encontrado.</td></tr>";
        }
    }

    function updateData($id, $nome, $rg, $cpf, $data_nascimento, $celular, $cep, $estado, $cidade, $bairro, $rua, $numero)
    {
        include("../../assets/php/connection.php");
        $stmt = $conexao->prepare("UPDATE cliente SET
         nome = ?, rg = ?,cpf = ?, data_nascimento = ?, celular = ?, cep = ?, estado = ?, cidade = ?, bairro = ?, rua = ?, numero = ?
          WHERE id = ?");
        $stmt->bind_param("sssssssssssi", $nome, $rg, $cpf, $data_nascimento, $celular, $cep, $estado, $cidade, $bairro, $rua, $numero, $id);
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
    if (isset($_POST['action']) && $_POST['action'] == 'getData') {
        $id = $_POST['id'];
        $stmt = $conexao->prepare("SELECT * FROM cliente WHERE id = ?");
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
        $rg = $_POST['rg'];
        $cpf = $_POST['cpf'];
        $data_nascimento = $_POST['data_nascimento'];
        $celular = $_POST['celular'];
        $cep = $_POST['cep'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $bairro = $_POST['bairro'];
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        if (!validaCPF($cpf)) {
            echo "cpf";
        } else {
            updateData($id, $nome, $rg, $cpf, $data_nascimento, $celular, $cep, $estado, $cidade, $bairro, $rua, $numero);
        }
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

    <script src="../assets/js/masks.js"></script>
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
            <form class="grid-template" id="editForm">
                <div class="extra-small-field field id">
                    <label for="id">ID</label>
                    <input type="text" name="id" id="id" placeholder="ID" readonly>
                </div>
                <div class="larger-field field">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" placeholder="Nome Completo">
                </div>

                <div class="extra-small-field field">
                    <label for="data_nascimento">Data nascimento</label>
                    <input type="date" name="data_nascimento" id="data_nascimento">
                </div>

                <div class="extra-small-field field">
                    <label for="rg">RG</label>
                    <input type="text" name="rg" id="rg" placeholder="XX.XXX.XXX-X">
                </div>

                <div class="extra-small-field field">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" placeholder="XXX.XXX.XXX-XX">


                </div>


                <div class="small-field field">
                    <label for="celular">Celular</label>
                    <input class="celular" type="text" name="celular" id="celular" placeholder="(XX) XXXXXX-XXXX">
                </div>

                <div class="small-field field">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" id="cep" placeholder="XXXXX-XXX">
                </div>

                <div class="small-field field">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado">
                        <option value="SC">Santa Catarina</option>
                        <option value="PR">Paraná</option>
                        <option value="SP">São Paulo</option>
                    </select>
                </div>

                <div class="normal-field field">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" placeholder="Cidade">
                </div>

                <div class="small-field field">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" id="bairro" placeholder="Ex.: Centro">
                </div>

                <div class="larger-field field">
                    <label for="rua">Rua</label>
                    <input type="text" name="rua" id="rua" placeholder="Ex.: Av. Tecnologias / Rua das Caldeiras">
                </div>

                <div class="extra-small-field field">
                    <label for="numero">N°</label>
                    <input type="text" name="numero" id="numero" placeholder="Ex.: 1001">
                </div>
                <div class="actions">
                    <input class="success-btn" type="button" value="Salvar" id="salvar">
                    <input class="close alert-btn" type="button" value="Cancelar">
                </div>
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