<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Conexão
    require_once("../../assets/php/auth_session.php");
    include("../../assets/php/connection.php");


    function search($termSearch)
    {
        include("../../assets/php/connection.php");

        if ($termSearch == 'all') {
            $stmt = $conexao->prepare("SELECT os.id, c.nome AS cliente_nome, c.celular AS cliente_celular, os.equipamento, os.data_criacao, os.status FROM ordem_de_servico os INNER JOIN cliente c ON os.cliente_id = c.id");
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $searchValue = "%$termSearch%";
            $stmt = $conexao->prepare("SELECT os.id, c.nome AS cliente_nome, c.celular AS cliente_celular, os.equipamento, os.data_criacao, os.status FROM ordem_de_servico os INNER JOIN cliente c ON os.cliente_id = c.id WHERE c.nome LIKE ?");
            $stmt->bind_param("s", $searchValue);
            $stmt->execute();
            $resultado = $stmt->get_result();
        }

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                if ($row['status'] == 'Ativo') {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['cliente_nome']}</td>";
                    echo "<td>{$row['equipamento']}</td>";
                    echo "<td>{$row['cliente_celular']}</td>";
                    echo "<td>{$row['data_criacao']}</td>";
                    if (allowedUser()) {
                        echo "<td>
                    <div class='actions'>
                    <button class='edit_os button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/edit-icon.png' alt='Editar'></button>
                    <button class='delete_os button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/delete-icon.png' alt='Excluir'></button>
                    <button class='finish_os button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/check-icon.png' alt='Excluir'></button>
                    </div></td>";
                    } else {
                        echo "<td>
                    <div class='actions'>
                    <button class='edit_os button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/edit-icon.png' alt='Editar'></button>
                    <button class='finish_os button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/check-icon.png' alt='Excluir'></button>
                    </div></td>";
                    }
                    echo "</tr>";
                }
            }
        } else {
            echo "<tr><td colspan='6'>Nenhuma ordem de serviço encontrada.</td></tr>";
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'searchPeca' && isset($_POST['term'])) {
        $term = $_POST['term'];

        // Cria uma consulta SQL para buscar as peças    
        $stmt = $conexao->prepare("SELECT * FROM peca WHERE (nome LIKE CONCAT('%', ?, '%')) OR (descricao LIKE CONCAT('%', ?, '%'))");
        if ($stmt === false) {
            // A declaração não foi preparada corretamente
            // Trate o erro aqui
            die("Erro na preparação da declaração: " . $conexao->error);
        }
        $stmt->bind_param("ss", $term, $term);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='part-id'>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td class='part-name'>" . htmlspecialchars($row["nome"]) . "</td>";
                echo "<td class='part-desc'>" . htmlspecialchars($row["descricao"]) . "</td>";
                echo "<td class='part-brand'>" . htmlspecialchars($row["marca"]) . "</td>";
                if($row['estoque_atual'] > 2) {
                    echo "<td><input class='peca-qtd' type='number'></input></td>";
                    echo "<td><button class='select-peca button-icon' data-id='" . $row['id'] . "' data-qtd='" . $row['estoque_atual'] . "'>Adicionar</button></td>";
                } else {
                    echo "<td><input class='peca-qtd' type='text' value='Sem estoque' readonlyy></input></td>";
                    echo "<td><button class='select-peca button-icon' data-id='" . $row['id'] . "' data-qtd='" . $row['estoque_atual'] . "'>Adicionar</button></td>";
                }
                echo "</tr>";
            }
        } else {
            // Escapa o termo antes de exibi-lo por razões de segurança
            echo "<tr><td colspan='4'>Nenhuma peça encontrada para: " . htmlspecialchars($term) . "</td></tr>";
        }
    }

    // Busca pelo código a peça que será adicionada à OS
    if (isset($_POST['action']) && $_POST['action'] == 'addPeca') {
        $id = $_POST['id'];
        $quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 1;

        $stmt = $conexao->prepare("SELECT id, nome, valor_venda FROM peca WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($peca = $resultado->fetch_assoc()) {
            $peca['quantidade'] = $quantidade; // Adiciona a quantidade ao array
            $peca['total'] = $peca['valor_venda'] * $quantidade; // Calcula o total
        }

        header('Content-Type: application/json');
        echo json_encode($peca); // Retorna o preço unitário, o nome, o id, a quantidade e o total
    }




    function updateData($os_id, $os_equipamento, $os_problema_relatado, $os_problema_constatado, $os_servico_executado, $os_servicos, $os_valor_servico)
    {
        include("../../assets/php/connection.php");

        if (isset($_POST['servicos'])) {
            // Supondo que 'servicos' seja um array, você pode convertê-lo em string para armazenar no banco de dados
            $servicos = implode(',', $_POST['servicos']);
        } else {
            $servicos = '';
        }

        // Atualizar informações da ordem de serviço
        $stmt = $conexao->prepare("UPDATE ordem_de_servico SET equipamento = ?, problema_relatado = ?, problema_constatado = ?, servico_executado = ?, servicos = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $os_equipamento, $os_problema_relatado, $os_problema_constatado, $os_servico_executado, $servicos, $os_id);

        if ($stmt->execute()) {
            $stmt->close();
            $conexao->close();
            return true; // Sucesso
        } else {
            $error = $stmt->error;
            $stmt->close();
            $conexao->close();
            return ['error' => $error]; // Retorna o erro para ser tratado por quem chamou a função
        }
    }


    function deleteData($id)
    {
        include("../../assets/php/connection.php");

        // Inicia uma transação para garantir que todas as operações sejam concluídas com sucesso
        $conexao->begin_transaction();

        try {
            // Primeiro, exclui todas as relações na tabela ordem_de_servico_peca
            $stmt = $conexao->prepare("DELETE FROM ordem_de_servico_peca WHERE ordem_de_servico_id = ?");
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao excluir peças relacionadas: ' . $stmt->error);
            }
            $stmt->close();

            // Depois, exclui a ordem de serviço
            $stmt = $conexao->prepare("DELETE FROM ordem_de_servico WHERE id = ?");
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao excluir ordem de serviço: ' . $stmt->error);
            }
            $stmt->close();

            // Se tudo ocorreu bem, confirma as operações
            $conexao->commit();
            echo json_encode(['success' => true, 'message' => 'Ordem de serviço excluída com sucesso.']);
        } catch (Exception $e) {
            // Se algo der errado, desfaz as operações
            $conexao->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        $conexao->close();
    }


    // Quando houver um clique em .edit (botão de edição)
    if (isset($_POST['action']) && $_POST['action'] == 'getData') {
        $id = $_POST['id'];
        $stmt = $conexao->prepare("
            SELECT 
                os.id AS os_id, 
                c.nome AS c_nome, 
                os.equipamento AS os_equipamento, 
                os.problema_relatado AS os_problema_relatado, 
                os.problema_constatado AS os_problema_constatado, 
                os.servico_executado AS os_servico_executado, 
                os.servicos AS os_servicos, 
                os.valor_servico AS os_valor_servico, 
                os.valor_total AS os_valor_total, 
                GROUP_CONCAT(p.nome SEPARATOR ', ') AS os_pecas
            FROM 
                ordem_de_servico os 
            INNER JOIN 
                cliente c ON os.cliente_id = c.id
            LEFT JOIN 
                ordem_de_servico_peca osp ON os.id = osp.ordem_de_servico_id
            LEFT JOIN 
                peca p ON osp.peca_id = p.id
            WHERE 
                os.id = ?
            GROUP BY 
                os.id");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] == 'getReceiveData') {
        $id = $_POST['id'];
        $stmt = $conexao->prepare("
            SELECT 
                c.id AS cliente_id, 
                c.nome AS cliente_nome, 
                os.valor_total AS valor_total
            FROM 
                ordem_de_servico os 
            INNER JOIN 
                cliente c ON os.cliente_id = c.id
            WHERE 
                os.id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }


    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'saveReceives') {
        $clienteId = $_POST['clienteId'];
        $formaPagamento = $_POST['formaPagamento'];
        $valorTotal = $_POST['valorTotal'];
        $valorPago = $_POST['valorPago'];
        $ordemServicoID = $_POST['ordemServicoID'];

        $stmt = $conexao->prepare("INSERT INTO recebimento (cliente_id, os_id, valor_pago, valor_total, forma_pagamento) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iidds", $clienteId, $ordemServicoID, $valorPago, $valorTotal, $formaPagamento);

        try {
            if ($stmt->execute()) {
                $usts = $conexao->prepare("UPDATE ordem_de_servico SET status = 'Pendente' WHERE id = ?");
                $usts->bind_param("i", $ordemServicoID);

                if ($usts->execute()) {
                    echo json_encode(['success' => true, 'message' => $ordemServicoID]);
                } else {
                    // O mysqli_error não será necessário aqui, pois uma exceção será lançada em caso de erro.
                    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar status da ordem de serviço.']);
                }

                $usts->close();
            } else {
                // O mysqli_error não será necessário aqui, pois uma exceção será lançada em caso de erro.
                echo json_encode(['success' => false, 'message' => 'Erro ao inserir recebimento.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        }

        $stmt->close();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateOrderService') {
        $os_id = $_POST['ordem_servico_id'];
        $os_equipamento = $_POST['equipamento'];

        $os_problema_relatado = $_POST['problema_relatado'] ?? '';
        $os_problema_constatado = $_POST['problema_constatado'] ?? '';
        $os_servico_executado = $_POST['servico_executado'] ?? '';

        // $os_servicos = is_array($_POST['servicos']) ? implode(', ', $_POST['servicos']) : $_POST['servicos'];
        $os_servicos = '';

        $os_valor_servico = $_POST['valor_servico'] ?? '';

        $update_success = updateData($os_id, $os_equipamento, $os_problema_relatado, $os_problema_constatado, $os_servico_executado, $os_servicos, $os_valor_servico);

        header('Content-Type: application/json');
        if ($update_success) {
            echo json_encode(['success' => true, 'message' => $id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro: ' . $stmt->error]);
        }

        exit;
    }


    // Faz a chamada de exclusão passando o ID
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
    <title>Controle de Clientes</title>

    <script src="../assets/js/masks.js"></script>
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
            <span class="close close-btn">&times;</span>

            <div class="extra-larger-field field">
                <div>
                    <div>
                        <h1>
                            Peças
                        </h1>
                        <label class="expandir" for="expandir" id="expandirLabel">+</label>
                        <input class="hidden" type="checkbox" id="expandir">
                    </div>

                    <div class="lista-peca hidden">
                        <div class="search-div">
                            <input class="search-input" type="text" id="searchTerm"
                                placeholder="Digite para pesquisar...">
                            <button id="pesquisar_peca" class="search-button">
                                <img class="icons" src="../assets/img/search-icon.png" alt="Icon">
                            </button>
                        </div>


                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Marca</th>
                                    <th>Quantidade</th>
                                    <th>Adicionar</th>
                                </tr>
                            </thead>
                            <tbody id="peca-results"></tbody>
                        </table>
                    </div>

                </div>
                <div id="pecasSelecionadas">
                    <div id="selects"></div>
                    <p>Valor total: <input id="valorTotal" type="text" placeholder="R$ 0,00" readonly></p>
                </div>
            </div>


            <div class="actions">
                <input class="success-btn" type="button" value="Salvar" id="salvar_os">
                <input class="close alert-btn" type="button" value="Cancelar">
            </div>
        </div>
    </div>

    <div id="excluirModal" class="modal hidden">
        <div class="modal-content">
            <span class="close close-btn">&times;</span>
            <h3 class="confirm-msg">Você tem certeza que deseja excluir? OS:
                <input type="text" id="idOS" readonly>
            </h3>
            <div class="button-area">
                <input class="alert-btn" id="excluir_os" type="button" value="Confirmar">
                <input class="cancel-btn close" type="button" value="Cancelar">
            </div>
        </div>
    </div>

    <div id="table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Equipamento</th>
                    <th>Celular</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="search-result">
                <tr>
                    <?php search('all'); ?>
                </tr>
            </tbody>
        </table>
    </div>


    <div id="finalizarModal" class="modal hidden">
        <div class="modal-content">
            <span class="close close-btn">&times;</span>
            <form id="finalizarForm">

                <div class="field">
                    <label for="clienteNome">Nome do Cliente:</label>
                    <input type="text" id="clienteId" name="clienteId" readonly hidden>
                    <input type="text" id="clienteNome" name="clienteNome" readonly>
                </div>
                <div>
                    <label for="formaPagamento">Forma de Pagamento:</label>
                    <select id="formaPagamento" name="formaPagamento">
                        <option value="cartao_credito">Cartão de Crédito</option>
                        <option value="cartao_debito">Cartão de Débito</option>
                        <option value="pix">PIX</option>
                        <option value="boleto">Boleto Bancário</option>
                        <option value="cheque">Cheque</option>
                        <option value="dinheiro">Dinheiro</option>
                        <!-- Adicione mais opções conforme necessário -->
                    </select>
                </div>
                <div class="field">
                    <label for="valorTotal">Valor Total:</label>
                    <input type="text" id="valorTotal" name="valorTotal" placeholder="R$" readonly>
                </div>
                <div class="field">
                    <label for="valorPago">Valor Pago:</label>
                    <input type="text" class="contabil" id="valorPago" name="valorPago" placeholder="R$">
                </div>
                <div class="field">
                    <label for="ordemServicoID">ID da Ordem de Serviço:</label>
                    <input type="text" id="ordemServicoID" name="ordemServicoID" readonly>
                </div>

                <div class="button-area">
                    <input class="success-btn" id="saveFinishOS" type="button" value="Confirmar">
                    <input class="cancel-btn close" type="button" value="Cancelar">
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('expandir').addEventListener('change', function (event) {
            var expandir = document.getElementById('expandir');
            var listaPeca = document.querySelector('.lista-peca');

            if (expandir.checked) {
                // Se o checkbox estiver marcado, adicione a classe 'show'
                listaPeca.classList.add('show');
            } else {
                // Se o checkbox não estiver marcado, remova a classe 'show'
                listaPeca.classList.remove('show');
            }

        });

    </script>
</body>

</html>