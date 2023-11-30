<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once("../../assets/php/auth_session.php");
  include("../../assets/php/connection.php");


  // Fetch the latest order ID from the database
  $query = "SELECT MAX(id) AS max_id FROM ordem_de_servico";
  $result = mysqli_query($conexao, $query);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $latest_order_id = $row['max_id'];

    $id = $latest_order_id + 1;

  } else {
    $id = "Inválido";
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['search-cliente'])) {
      $search = $_POST['search-cliente'];
      $search = "%$search%";

      $stmt = $conexao->prepare("SELECT id, nome FROM cliente WHERE nome LIKE ?");
      $stmt->bind_param("s", $search);
      $stmt->execute();
      $resultado = $stmt->get_result();

      while ($row = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td><button class='select-button' type='button' data-type='cliente' data-id='" . $row['id'] . "' data-nome='" . $row['nome'] . "'>Selecionar</button></td>";
        echo "</tr>";
      }
      exit;
    }

    if (isset($_POST['search-peca'])) {
      $search = $_POST['search-peca'];
      $search = "%$search%";

      $stmt = $conexao->prepare("SELECT * FROM peca WHERE nome LIKE ?");
      $stmt->bind_param("s", $search);
      $stmt->execute();
      $resultado = $stmt->get_result();

      while ($row = $resultado->fetch_assoc()) {
        // Calculando a diferença de estoque
        $estoque = $row['estoque_atual'] - $row['estoque_minimo'];

        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['valor_venda'] . "</td>";

        if ($estoque > 0) {
          echo "<td><input type='number' class='quantidade-input' min='1' max='" . $estoque . "' value='1'></td>";
          echo "<td><button class='select-button' type='button'
         data-type='peca' data-id='" . $row['id'] . "' data-nome='" . $row['nome'] . "'
          data-quantidade=''>Adicionar</button></td>";
        } else {
          echo "<td><input type='text' placeholder='Sem estoque' readonly></input></td>";
          echo "<td><button class='locked-button' type='button'
           data-type='peca' data-id='" . $row['id'] . "' data-nome='" . $row['nome'] . "'
            data-quantidade='0'>Adicionar</button></td>";
        }

        echo "</tr>";
      }
      exit;
    }


    $conexao->begin_transaction();

    try {
      $cliente_id = $_POST['clienteId'];
      $equipamento = $_POST['equipamento'];
      $problema_relatado = $_POST['problemarelatado'];
      $problema_constatado = $_POST['problemaconstatado'];
      $servico_executado = $_POST['servicoexecutado'];
      $servicos = isset($_POST['servicos']) ? implode(',', $_POST['servicos']) : '';
      $valor_servico = $_POST['valorservico'];
      $valor_total = $_POST['valortotal'];

      $stmt = $conexao->prepare("INSERT INTO `ordem_de_servico` (`cliente_id`, `equipamento`, `problema_relatado`, `problema_constatado`, `servico_executado`, `servicos`, `valor_servico`, `valor_total`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssssdd", $cliente_id, $equipamento, $problema_relatado, $problema_constatado, $servico_executado, $servicos, $valor_servico, $valor_total);

      if (!$stmt->execute()) {
        throw new Exception("Erro ao inserir ordem de serviço: " . $stmt->error);
      }

      $id = $conexao->insert_id;


      $stmtPeca = $conexao->prepare("INSERT INTO `ordem_de_servico_peca` (`ordem_de_servico_id`, `peca_id`, `quantidade`) VALUES (?, ?, ?)");


      $peca_ids = $_POST['peca_ids'];
      $peca_quantidades = $_POST['peca_quantidades'];

      for ($i = 0; $i < count($peca_ids); $i++) {
        $stmtUpdatePeca = $conexao->prepare("UPDATE peca SET estoque_atual = estoque_atual - ? WHERE id = ?");
        $stmtUpdatePeca->bind_param("ii", $peca_quantidades[$i], $peca_ids[$i]);

        if (!$stmtUpdatePeca->execute()) {
          throw new Exception("Erro ao atualizar quantidade da peça: " . $stmtUpdatePeca->error);
        }

        $stmtPeca->bind_param("iii", $id, $peca_ids[$i], $peca_quantidades[$i]);
        if (!$stmtPeca->execute()) {
          throw new Exception("Erro ao inserir peça: " . $stmtPeca->error);
        }
      }


      // Se tudo estiver ok, commit a transação
      $conexao->commit();
      echo "success";
    } catch (Exception $e) {
      // Se algo deu errado, rollback a transação
      $conexao->rollback();
      echo "error: " . $e->getMessage();
    } finally {
      $stmt->close();
      $stmtPeca->close();
      $conexao->close();
    }
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
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Cadastro - Ordem de Serviço</title>

  <script src="../assets/js/masks.js"></script>
  <script src="../assets/js/modal.js"></script>

</head>

<body>
  <h2>Cadastrar Ordem de Serviço</h2>
  <div id="clienteModal" class="modal hidden">
    <div class="modal-content">
      <form class="search-form" id="searchCliente">
        <input class="search-input" type="text" name="search-cliente" placeholder="Digite para pesquisar...">
        <button class="search-button" type="submit"><img class="icons" src="../assets/img/search-icon.png"
            alt="Icon"></button>
        <span class="close">&times;</span>
      </form>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Selecionar</th>
          </tr>
        </thead>
        <tbody id="search-result-cliente"></tbody>
      </table>
    </div>
  </div>

  <div id="pecaModal" class="modal hidden">
    <div class="modal-content">
      <form class="search-form" id="searchPeca">
        <input class="search-input" type="text" name="search-peca" placeholder="Digite para pesquisar...">
        <button class="search-button" type="submit"><img class="icons" src="../assets/img/search-icon.png"
            alt="Icon"></button>
        <span class="close">&times;</span>
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
    </div>
  </div>

  <form class="grid-template" id="submitForm" action="orderm-de-servico.php" method="POST">
    <div class="normal-field field">
      <label>Cliente</label>
      <input type="hidden" id="clienteId" name="clienteId" />
      <div class="search-div" id="selecionarCliente">
        <input class="search-input" type="text" id="clienteNome" name="clienteNome"
          placeholder="Clique para selecionar um cliente" readonly />
        <button class="search-button" type="button"><img class="icons" src="../assets/img/search-icon.png"
            alt="Icon"></button>
      </div>
    </div>


    <div class="small-field field">
      <label for="equipamento">Equipamento</label><br>
      <input type="text" name="equipamento" id="equipamento">
    </div>



    <div class="extra-small-field field">
      <label for="id">ID da Ordem de Serviço:</label>
      <input type="text" id="id" name="id" value="<?php echo $id ?>" readonly>
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

    <div class="normal-field field">
      <label>Peças</label>
      <div id="pecasSelecionadas">
      </div>
      <button type="button" id="selecionarPeca">Adicionar Peças</button>
    </div>

    <input class="contabil" type="text" name="valorpeca" value="" hidden>

    <div class="extra-small-field field">
      <label for="valorservico">Valor Serviço: </label>
      <input class="contabil" type="text" placeholder="R$ 0,00" name="valorservico" id="valorservico" value="">
    </div>


    <div class="extra-small-field field">
      <label for="valortotal">Valor Total: </label>
      <input class="contabil" type="text" placeholder="R$ 0,00" name="valortotal" id="valortotal" value="">
    </div>

    <div class="button-area">
      <button class="submit-button" type="submit" name="salvar">Cadastrar</button>
    </div>

  </form>
</body>

</html>