<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once("../../assets/php/auth_session.php");
  include("../../assets/php/connection.php");
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conexao->begin_transaction();

    try {
      $cliente_id = $_POST['cliente_id'];
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

      $ordemDeServicoId = $conexao->insert_id;

      $stmtPeca = $conexao->prepare("INSERT INTO `ordem_de_servico_peca` (`ordem_de_servico_id`, `peca_id`, `quantidade`) VALUES (?, ?, ?)");

      $peca_ids = $_POST['peca_ids'];
      $peca_quantidades = $_POST['peca_quantidades'];

      for ($i = 0; $i < count($peca_ids); $i++) {
        $stmtPeca->bind_param("iii", $ordemDeServicoId, $peca_ids[$i], $peca_quantidades[$i]);
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


  if (isset($_GET['searchTerm']) && isset($_GET['searchContext'])) {
    $searchTerm = $_GET['searchTerm'];
    $searchContext = $_GET['searchContext'];
    $searchTerm = "%$searchTerm%";

    if ($searchContext === 'clientes') {
      $stmt = $conexao->prepare("SELECT id, nome FROM cliente WHERE nome LIKE ?");
      $stmt->bind_param("s", $searchTerm);
    } elseif ($searchContext === 'pecas') {
      $stmt = $conexao->prepare("SELECT id, nome FROM peca WHERE nome LIKE ?");
      $stmt->bind_param("s", $searchTerm);
    } else {
      echo "Contexto de pesquisa não reconhecido.";
      exit;
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verifica qual é o contexto e renderiza o HTML apropriado
    if ($searchContext === 'clientes') {
      while ($cliente = $resultado->fetch_assoc()) {
        echo "<tr><td>{$cliente['id']}</td><td>{$cliente['nome']}</td><td><button type='button' class='select-client' data-id='{$cliente['id']}'>Selecionar</button></td></tr>";
      }
    } elseif ($searchContext === 'pecas') {
      while ($peca = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$peca['id']}</td>";
        echo "<td>{$peca['nome']}</td>";
        echo "<td><input type='number' class='peca-quantidade' min='1'></td>";
        echo "<td><button type='button' class='select-peca' data-id='{$peca['id']}'>Adicionar</button></td>";
        echo "</tr>";
      }

    }

    $conexao->close();
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
</head>

<body>
  <h2>Cadastrar Ordem de Serviço</h2>
  <div id="clienteModal" class="modal hidden">
    <div class="modal-content">
      <span class="close">&times;</span>
      <form method="GET" id="searchFormCliente">
        <input type="text" id="searchTermCliente" placeholder="Digite para pesquisar...">
        <button type="submit">Pesquisar</button>
      </form>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Selecionar</th>
          </tr>
        </thead>
        <tbody id="search-results-cliente">
        </tbody>
      </table>
    </div>
  </div>

  <div id="pecaModal" class="modal hidden">
    <div class="modal-content">
      <span class="close">&times;</span>
      <form method="GET" id="searchFormPeca">
        <input type="text" id="searchTermPeca" placeholder="Digite para pesquisar...">
        <button type="submit">Pesquisar</button>
      </form>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Quantidade</th>
          </tr>
        </thead>
        <tbody id="search-results-peca">
        </tbody>
      </table>
    </div>
  </div>

  <form class="grid-template" id="submitForm" action="orderm-de-servico.php" method="POST">
    <div class="normal-field field">
      <label>Cliente</label>
      <input type="text" id="clienteNome" placeholder="Clique para selecionar um cliente" readonly />
      <input type="hidden" id="cliente_id" />
      <button type="button" id="selecionarCliente">Selecionar Cliente</button>
    </div>


    <div class="small-field field">
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
      <button type="submit" name="salvar">Cadastrar</button>
    </div>

  </form>
</body>

</html>