<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {

  header('HTTP/1.0 403 Forbidden');
  echo 'Você não tem permissão para acessar este arquivo diretamente.';
  exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../assets/php/auth_session.php");
include("../../assets/php/connection.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // A conexão deve ser estabelecida antes de qualquer operação com o banco de dados
  $conexao = mysqli_connect($host, $username, $password, $database);

  // Atribui variáveis com os dados do POST
  $cliente_id = $_POST['cliente_id'];
  $equipamento = $_POST['equipamento'];
  $problema_relatado = $_POST['problemarelatado'];
  $problema_constatado = $_POST['problemaconstatado'];
  $servico_executado = $_POST['servicoexecutado'];
  $servicos = isset($_POST['servicos']) ? implode(',', $_POST['servicos']) : '';
  $peca_id = $_POST['peca_id']; // Certifique-se de que esta coluna realmente existe na tabela
  $valor_servico = $_POST['valorservico']; // Certifique-se de que esta coluna realmente existe na tabela
  $valor_total = $_POST['valortotal']; // Certifique-se de que esta coluna realmente existe na tabela

  // Insere no banco de dados
  $stmt = $conexao->prepare("INSERT INTO `ordem_de_servico` (`equipamento`, `problema_relatado`, `problema_constatado`, `servico_executado`, `servico`, `id_cliente`, `id_peca`, `valor_servico`, `valor_total`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

  // Verifica se a preparação da consulta foi bem-sucedida
  if (!$stmt) {
    // Se não foi, imprime o erro
    echo "Erro na preparação: " . $conexao->error;
    exit;
  }

  // Continua com a execução normal do código
  $stmt->bind_param("sssssiidd", $equipamento, $problema_relatado, $problema_constatado, $servico_executado, $servicos, $cliente_id, $peca_id, $valor_servico, $valor_total);

  if ($stmt->execute()) {
    echo "success";
  } else {
    echo "error: " . $stmt->error;
  }

  $stmt->close();
  $conexao->close();
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

  <!-- Modal para pesquisa de clientes -->
  <div id="modalCliente" class="modal hidden">
    <div class="modal-content">
      <span class="close">&times;</span>
      <form method="GET" id="searchForm" action="buscar-cliente.php">
        <input type="text" id="searchInput" placeholder="Digite para pesquisar clientes...">
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
        <tbody id="cliente-tbody">
        </tbody>
      </table>
      <button type="button" id="selecionarCliente">Selecionar Cliente</button>

    </div>
  </div>


  <form class="grid-template" id="primaryForm" action="orderm-de-servico.php" method="POST">
    <div class="normal-field field">
      <label for="cliente_id">Cliente</label>
      <input type="text" id="clienteNome" placeholder="Clique para selecionar um cliente" readonly />
      <input type="hidden" name="cliente_id" id="cliente_id" />
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
      <label for="peca_id">Peças</label>
      <select name="peca_id" id="cliente_id" required>
        <option value="">Selecione a peça utilizada</option>
        <?php
        $sql = "select * from peca order by nome";
        $a = mysqli_query($conexao, $sql);
        while ($linha = mysqli_fetch_array($a)):
          $id = $linha['id'];
          $nome = $linha['nome'];

          echo "<option value='{$id}'>{$nome}</option>";
        endwhile;
        ?>
      </select>
    </div>


    <div class="extra-small-field field">
      <label for="valorservico">Valor Serviço: </label>
      <input class="contabil" type="text" placeholder="R$ 0,00" name="valorservico" value="">
    </div>
    <div class="extra-small-field field">
      <label for="valortotal">Valor Total: </label>
      <input class="contabil" type="text" placeholder="R$ 0,00" name="valortotal" value="">
    </div>

    <div class="button-area">
      <button type="submit" name="salvar">Cadastrar</button>
    </div>

  </form>

</body>

</html>