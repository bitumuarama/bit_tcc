<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function search($termSearch)
{
    include("../../assets/php/connection.php");
    
    if ($termSearch == 'all') {
        $stmt = $conexao->prepare("SELECT os.id, c.nome AS cliente_nome, c.celular AS cliente_celular, os.equipamento FROM ordem_de_servico os INNER JOIN cliente c ON os.cliente_id = c.id");
        $stmt->execute();
        $resultado = $stmt->get_result();
    } else {
        $searchValue = "%$termSearch%";
        $stmt = $conexao->prepare("SELECT os.id, c.nome AS cliente_nome, c.celular AS cliente_celular, os.equipamento FROM ordem_de_servico os INNER JOIN cliente c ON os.cliente_id = c.id WHERE os.nome LIKE ?");
        $stmt->bind_param("s", $searchValue);
        $stmt->execute();
        $resultado = $stmt->get_result();
    }
    
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['cliente_nome']}</td>"; // Display client's name
            echo "<td>{$row['equipamento']}</td>";
            echo "<td>{$row['cliente_celular']}</td>"; // Display client's cellphone
            echo "<td>
                <input class='edit' type='button' data-id='" . $row['id'] . "' value='Editar'>
                <input class='delete' type='button' data-id='" . $row['id'] . "' value='Excluir'>
            </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Nenhuma ordem de serviço encontrada.</td></tr>";
    }
}


    function editValue($id)
    {
        include("../../assets/php/connection.php");
        $stmt = $conexao->prepare("SELECT id, cliente_id, equipamento, problema_relatado, problema_constatado, servico_executado, servicos FROM ordem_de_servico WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            while ($pesquisa = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$pesquisa['id']}</td>";
                echo "<td>{$pesquisa['cliente_id']}</td>";
                echo "<td>{$pesquisa['equipamento']}</td>";
                echo "<td>{$pesquisa['problema_relatado']}</td>";
                echo "<td>{$pesquisa['problema_constatado']}</td>";
                echo "<td>{$pesquisa['servico_executado']}</td>";
                echo "<td>{$pesquisa['servicos']}</td>";
                echo "<td>
                <input type='button' id='editarCliente' value='Editar'>
                <input type='button' id='excluirCliente' value='Excluir'>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhuma ordem de serviço encontrado.</td></tr>";
        }
    }
    function updateData($id, $nome, $cpf, $data_nascimento, $celular)
    {
        include("../../assets/php/connection.php");
        $stmt = $conexao->prepare("UPDATE ordem_de_servico SET nome = ?, cpf = ?, data_nascimento = ?, celular = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $cliente_id, $equipamento, $problema_relatado, $problema_constatado,$servico_executado,$servicos);
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
        $stmt = $conexao->prepare("SELECT id, cliente_id, equipamento, problema_relatado, problema_constatado, servico_executado, servicos FROM ordem_de_servico WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateClientData') {
        $id = $_POST['id'];
        $cliente_id = $_POST['cliente_id'];
        $equipamento = $_POST['equipamento'];
        $problema_relatado = $_POST['problema_relatado'];
        $problema_constatado = $_POST['problema_constatado'];
        $servico_executado = $_POST['servico_executado'];
        $servicos = $_POST['servicos'];

        
        updateData($id, $cliente_id, $equipamento, $problema_relatado, $problema_constatado,$servico_executado,$servicos);
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
    <h2>Controle de Ordem de Serviços</h2>
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
            <div class="small-field field">
            
                
    <div class="extra-small-field field">
      <label for="ordem_servico_id">ID da Ordem de Serviço:</label>
      <input type="text" id="ordem_servico_id" name="ordem_servico_id" value="<?php echo $ordem_servico_id ?>" readonly>
    </div>
      <label for="equipamento">Equipamento</label><br>
      <input type="text" name="equipamento" id="equipamento">
    </div>

    <div class="textarea-field field">
      <label for="problemarelatado">Probelema Relatado </label><br>
      <textarea id="problemarelatado" name="problemarelatado" cols="20" rows="10"></textarea>
    </div>

    <div class="textarea-field field">
      <label for="problemaconstatado">Problema Constatado</label><br>
      <textarea id="problemaconstatado" name="problemaconstatado" cols="20" rows="10"></textarea>
    </div>

    <div class="textarea-field field">
      <label for="servicoexecutado">Serviço Executado</label><br>
      <textarea id="servicoexecutado" name="servicoexecutado" cols="20" rows="10"></textarea>
    </div>



    <fieldset class="fieldset-field field" name="servico">
      <legend>SERVIÇOS:</legend>
      <div>
        <label for="formatacao">Formatação</label>
        <input type="checkbox" id="formatacao" name="servicos[]" value="formatacao" />
      </div>

      <div>
        <label for="limpeza">Limpeza</label>
        <input type="checkbox" id="limpeza" name="servicos[]" value="limpeza" />
      </div>

      <div>
        <label for="trocadepeca">Troca de peça</label>
        <input type="checkbox" id="trocadepeca" name="servicos[]" value="trocadepeca" />
      </div>

      <div>
        <label for="montagem">Montagem</label>
        <input type="checkbox" id="montagem" name="servicos[]" value="montagem" />
      </div>

      <div>
        <label for="instalacao">Instalação de Programas</label>
        <input type="checkbox" id="instalacao" name="servicos[]" value="instalacao" />
      </div>

      <div>
        <label for="restauracao">Recuperação de Arquivos</label>
        <input type="checkbox" id="restauracao" name="servicos[]" value="restauracao" />
      </div>
    </fieldset>
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
                    <th>Equipamento</th>
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
