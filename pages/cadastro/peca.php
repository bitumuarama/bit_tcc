<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Conexão
    require_once("../../assets/php/auth_session.php");
    include("../../assets/php/connection.php");

    // Functions
    function search($termSearch)
    {
        include("../../assets/php/connection.php");
        if ($termSearch == 'all') {
            $stmt = $conexao->prepare("SELECT id, nome, marca, categoria, estoque_atual FROM peca");
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $searchValue = "%$termSearch%";
            $stmt = $conexao->prepare("SELECT id, nome, marca, categoria, estoque_atual FROM peca WHERE nome LIKE ?");
            $stmt->bind_param("s", $searchValue);
            $stmt->execute();
            $resultado = $stmt->get_result();
        }
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['nome']}</td>";
                echo "<td>{$row['marca']}</td>";
                echo "<td>{$row['categoria']}</td>";
                echo "<td>{$row['estoque_atual']}</td>";
                echo "<td>
                    <div class='actions'>
                    <button class='edit_peca button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/edit-icon.png' alt='Editar'></button>
                    <button class='delete_peca button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/delete-icon.png' alt='Excluir'></button>
                </div></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhuma peca.</td></tr>";
        }
    }

    function updateData($id, $nome, $descricao, $marca, $categoria, $estoque_minimo, $estoque_atual, $valor_custo, $valor_venda)
    {
        $valor = str_replace('.', '', $valor_custo);    
        $valorCusto = str_replace(',', '.', $valor);
        $valor = str_replace('.', '', $valor_venda);    
        $valorVenda = str_replace(',', '.', $valor);

        include("../../assets/php/connection.php");
        $stmt = $conexao->prepare("UPDATE peca SET
         nome = ?, descricao = ?,marca = ?, categoria = ?, estoque_minimo = ?, estoque_atual = ?, valor_custo = ?, valor_venda = ?
          WHERE id = ?");
        $stmt->bind_param("ssssssddi", $nome, $descricao, $marca, $categoria, $estoque_minimo, $estoque_atual, $valorCusto, $valorVenda, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => $valor_custo]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro: ' . $stmt->error]);
        }

        $stmt->close();
        $conexao->close();
    }

    function deleteData($id)
    {
        include("../../assets/php/connection.php");
    
        if ($id != "") {
    
            // Verificar se a peça está sendo usada em ordens de serviço
            $checkStmt = $conexao->prepare("SELECT COUNT(*) FROM ordem_de_servico_peca WHERE peca_id = ?");
            $checkStmt->bind_param("i", $id);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();
    
            // Se a peça estiver sendo usada, não prosseguir com o DELETE
            if ($count > 0) {
                echo json_encode(['success' => false, 'message' => 'erro-chave-estrangeira']);
                $conexao->close();
                return;
            }
    
            // Proceder com a remoção da peça
            $stmt = $conexao->prepare("DELETE FROM peca WHERE id = ?");
            $stmt->bind_param("i", $id);
    
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => $id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'erro']);
            }
            
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'erro']);
        }
        $conexao->close();
    }
    

    // Quando houver um clique em .edit (botão de edição)
    if (isset($_POST['action']) && $_POST['action'] == 'getData') {
        $id = $_POST['id'];
        $stmt = $conexao->prepare("SELECT * FROM peca WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateData') {

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $marca = $_POST['marca'];
        $categoria = $_POST['categoria'];
        $estoque_minimo = $_POST['estoque_minimo'];
        $estoque_atual = $_POST['estoque_atual'];
        $valor_custo = $_POST['valor_custo'];
        $valor_venda = $_POST['valor_venda'];

        updateData($id, $nome, $descricao, $marca, $categoria, $estoque_minimo, $estoque_atual, $valor_custo, $valor_venda);

        mysqli_close($conexao);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'deleteData') {
        deleteData($_POST['id']);
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
    <title>Controle de Peças</title>

    <script src="../assets/js/masks.js"></script>
</head>

<body>
    <h2>Controle de Peças</h2>
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
                    <input type="text" class="contabil" name="valor_custo" id="valor_custo" placeholder="R$ 0,00"
                        required>
                </div>

                <div class="extra-small-field field">
                    <label for="valor_venda">Valor de Venda</label>
                    <input type="text" class="contabil" name="valor_venda" id="valor_venda" placeholder="R$ 0,00"
                        required>
                </div>

                <div class="actions">
                    <input class="success-btn" type="button" value="Salvar" id="salvar_peca">
                    <input class="close alert-btn" type="button" value="Cancelar">
                </div>



            </form>
        </div>
    </div>

    <div id="excluirModal" class="modal hidden">
        <div class="modal-content">
            <span class="close close-btn">&times;</span>
            <h3 class="confirm-msg">Você tem certeza que deseja excluir? ID:
                <input type="text" id="idPeca" readonly>
            </h3>
            <div class="button-area">
                <input class="alert-btn" id="excluir_peca" type="button" value="Confirmar">
                <input class="cancel-btn close" type="button" value="Cancelar">
            </div>
        </div>
    </div>


    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Categoria</th>
                    <th>Estoque</th>
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