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
            $stmt = $conexao->prepare("SELECT os.id, c.nome AS cliente_nome, c.celular AS cliente_celular, os.equipamento, os.data_criacao, os.valor_total, os.status FROM ordem_de_servico os INNER JOIN cliente c ON os.cliente_id = c.id");
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $searchValue = "%$termSearch%";
            $stmt = $conexao->prepare("SELECT os.id, c.nome AS cliente_nome, c.celular AS cliente_celular, os.equipamento, os.data_criacao, os.valor_total, os.status FROM ordem_de_servico os INNER JOIN cliente c ON os.cliente_id = c.id WHERE c.nome LIKE ?");
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
                    echo "<td>{$row['valor_total']}</td>";
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
                    </div></td>";
                    }
                    echo "</tr>";
                }
            }
        } else {
            echo "<tr><td colspan='6'>Nenhuma ordem de serviço encontrada.</td></tr>";
        }
    }

    function updateData($os_id, $c_id, $c_celular, $os_equipamento, $os_problema_relatado, $os_problema_constatado, $os_servico_executado, $os_servicos, $os_pecas, $os_valor_servico)
    {
        include("../../assets/php/connection.php");

        // Atualizar informações do cliente
        $stmt = $conexao->prepare("UPDATE cliente SET celular = ? WHERE id = ?");
        $stmt->bind_param("si", $c_celular, $c_id);
        if (!$stmt->execute()) {
            echo "error: " . $stmt->error;
            $stmt->close();
            $conexao->close();
            return;
        }
        $stmt->close();

        // Atualizar informações da ordem de serviço
        $stmt = $conexao->prepare("UPDATE ordem_de_servico SET equipamento = ?, problema_relatado = ?, problema_constatado = ?, servico_executado = ?, servicos = ?, pecas = ?, valor_servico = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $os_equipamento, $os_problema_relatado, $os_problema_constatado, $os_servico_executado, $os_servicos, $os_pecas, $os_valor_servico, $os_id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error: " . $stmt->error;
        }
        $stmt->close();
        $conexao->close();
    }

    function deleteData($id)
    {
        include("../../assets/php/connection.php");

        if ($id != "") {

            $stmt = $conexao->prepare("DELETE FROM ordem_de_servico WHERE id = ?");

            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => $id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro: ' . $stmt->error]);
            }

            $stmt->close();
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
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'salvarrecebimento') {
        $clienteId = $_POST['clienteId'];
        $ordemServicoID = $_POST['ordemServicoID'];
        $valorPago = $_POST['valorPago'];
        $valorTotal = $_POST['valorTotal'];
        $formaPagamento = $_POST['formaPagamento'];
        
        $stmt = $conexao->prepare("INSERT INTO recebimento (cliente_id, os_id, valor_pago, valor_total, forma_pagamento) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iidds", $clienteId, $ordemServicoID, $valorPago, $valorTotal, $formaPagamento);
    
        try {
            if ($stmt->execute()) {
                $usts = $conexao->prepare("UPDATE ordem_de_servico SET status = 'pendente' WHERE id = ?");
                $usts->bind_param("i", $ordemServicoID);
    
                if ($usts->execute()) {
                    echo json_encode(['success' => true, 'message' => $ordemServicoID]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erro: ' . mysqli_error($conexao)]);
                }
    
                $usts->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro: ' . mysqli_error($conexao)]);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        }
    
        $stmt->close();
        $conexao->close();
    }
    
    



    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateOSData') {
        $os_id = $_POST['ordem_de_servico_id'];
        $c_id = $_POST['cliente_id'];
        $c_celular = $_POST['celular'];
        $os_equipamento = $_POST['equipamento'];

        $os_problema_relatado = $_POST['problema_relatado'] ?? '';
        $os_problema_constatado = $_POST['problema_constatado'] ?? '';
        $os_servico_executado = $_POST['servico_executado'] ?? '';
        $os_servicos = $_POST['servicos'] ?? '';
        $os_pecas = $_POST['pecas'] ?? '';
        $os_valor_servico = $_POST['valor_servico'] ?? '';

        // Chamando a função updateData
        updateData($os_id, $c_id, $c_celular, $os_equipamento, $os_problema_relatado, $os_problema_constatado, $os_servico_executado, $os_servicos, $os_pecas, $os_valor_servico);

        // Não é necessário fechar a conexão aqui se ela já é fechada dentro da função updateData
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
            <form class="grid-template" id="editForm">

                <div class="extra-small-field field">
                    <label for="ordem_servico_id">OS:</label>
                    <input type="text" id="ordem_servico_id" name="ordem_servico_id" readonly>
                </div>
                <div class="small-field field">
                    <label for="nome">Nome</label><br>
                    <input type="text" name="nome" id="nome">
                </div>
                <div class="small-field field">
                    <label for="equipamento">Equipamento</label><br>
                    <input type="text" name="equipamento" id="equipamento">
                </div>

                <!-- <div class="textarea-field field">
                    <label for="problema_relatado">Probelema Relatado </label><br>
                    <textarea id="problema_relatado" name="problema_relatado" cols="20" rows="10"></textarea>
                </div>

                <div class="textarea-field field">
                    <label for="problema_constatado">Problema Constatado</label><br>
                    <textarea id="problema_constatado" name="problema_constatado" cols="20" rows="10"></textarea>
                </div>

                <div class="textarea-field field">
                    <label for="servico_executado">Serviço Executado</label><br>
                    <textarea id="servico_executado" name="servico_executado" cols="20" rows="10"></textarea>
                </div> -->



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
                        <label for="troca_de_peca">Troca de peça</label>
                        <input type="checkbox" id="troca_de_peca" name="servicos[]" value="troca_de_peca" />
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
                <div class="normal-field field">
                    <label>Peças</label>
                    <div id="pecasSelecionadas">
                        <p>Sem peças</p>
                    </div>
                </div>

                <div class="extra-small-field field">
                    <label for="valor_servico">Valor Serviço: </label>
                    <input class="contabil" type="text" placeholder="R$ 0,00" name="valor_servico" id="valor_servico"
                        value="">
                </div>


                <div class="extra-small-field field">
                    <label for="valor_total">Valor Total: </label>
                    <input class="contabil" type="text" placeholder="R$ 0,00" name="valor_total" id="valor_total"
                        value="">
                </div>

                <form class="search-form" id="searchPeca">
                    <input class="search-input" type="text" name="search-peca" placeholder="Digite para pesquisar...">
                    <button class="search-button" type="submit"><img class="icons" src="../assets/img/search-icon.png"
                            alt="Icon"></button>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="search-result-peca"></tbody>
                </table>

                <input type="button" value="Salvar" id="salvar">
                <input class="close" type="button" value="Cancelar">
            </form>
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

    <!-- ... Seu HTML existente ... -->

    <div id="finalizarModal" class="modal hidden">
        <div class="modal-content">
            <span class="close">&times;</span>
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

                <input type="button" value="Confirmar" id="confirmarFinalizacao" name="finalizar">
                <input class="close" type="button" value="Cancelar">
            </form>
        </div>
    </div>

    <!-- ... (código anterior) ... -->

    <!-- <script>

        // Função para abrir o modal de finalização ao clicar no botão "Finalizar"
        $(".finish_os").click(function () {
            var id = $(this).closest("tr").find("td:eq(0)").text();
            var clienteNome = $(this).closest("tr").find("td:eq(1)").text();
            var valorTotal = $(this).closest("tr").find("td:eq(5)").text(); // Ajuste para pegar o valor na coluna correta

            // Preenche o modal de finalização
            preencherModalFinalizar(id, clienteNome, valorTotal);

            // Abre o modal de finalização
            $("#finalizarModal").removeClass("hidden");
        });

        // Função para preencher o modal de finalização com os dados da ordem de serviço
        // Função para preencher o modal de finalização com os dados da ordem de serviço
        function preencherModalFinalizar(id, clienteNome, valorTotal) {
            $("#ordemServicoID").val(id);
            $("#clienteNome").val(clienteNome);

            // Remove apenas o prefixo "R$ "
            valorTotal = valorTotal.replace('R$ ', '');

            // Atribui o valor diretamente ao campo "Valor Total" no modal
            $("#valorTotal").val('R$ ' + valorTotal);
        }


    </script> -->




    <div id="clientList">
        <table id="clientsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Equipamento</th>
                    <th>Celular</th>
                    <th>Data de Criação</th>
                    <th>Valor</th>
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
</body>

</html>