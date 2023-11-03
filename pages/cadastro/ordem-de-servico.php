<?php
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "bit_tcc";
$conexao = mysqli_connect($host, $username, $password, $database);


if (isset($_POST['salvar'])) {
  $equipamento = $_POST['equipamento'];
  $problemarelatado = $_POST['problemarelatado'];
  $problemaconstatado = $_POST['problemaconstatado'];
  $servicoexecutado = $_POST['servicoexecutado'];
  $servico = implode(', ', $_POST['servicos']); // Transforma o array em uma string separada por vírgulas
  $cliente = $_POST['cliente_id'];
  $peca = $_POST['peca_id'];
  $valorservico = $_POST['valorservico'];
  $valortotal = $_POST['valortotal'];

  //3. Preparar a SQL
  $sql = "INSERT INTO ordemdeservico (equipamento, problemarelatado, problemaconstatado, servicoexecutado, servico, valorservico, codigo_cliente, codigo_peca, valortotal) VALUES 
                        ('$equipamento', '$problemarelatado', '$problemaconstatado', '$servicoexecutado', '$servico', '$valorservico', '$cliente','$peca', '$valortotal')";

  //4. Executar a SQL
  mysqli_query($conexao, $sql);


}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Document</title>

<body>
  <h2>Cadastrar Ordem de Serviço</h2>
  <form method="POST" class="mt-4">

    <div name="cliente">
      <label for="cliente_id">Cliente</label>
      <select name="cliente_id" id="cliente_id" required>
        <option value="">Selecione o cliente</option>
        <?php
        $sql = "select * from cliente order by nome";
        $resultado = mysqli_query($conexao, $sql);
        while ($linha = mysqli_fetch_array($resultado)):
          $id = $linha['codigo'];
          $nome = $linha['nome'];

          echo "<option value='{$id}'>{$nome}</option>";
        endwhile;
        ?>
      </select>
    </div>


    <div>
      <label for="equipamento">Equipamento</label><br>
      <input type="text" name="equipamento" id="equipamento">
    </div>
    <div>
      <label for="problemarelatado">Probelema Relatado </label><br>
      <textarea id="problemarelatado" name="problemarelatado" rows="5" cols="33">
        </textarea>
    </div>
    <div>
      <label for="problemaconstatado">Problema Constatado</label><br>
      <textarea id="problemaconstatado" name="problemaconstatado" rows="5" cols="33">
        </textarea>
    </div>
    <div>
      <label for="servicoexecutado">Serviço Executado</label><br>
      <textarea id="servicoexecutado" name="servicoexecutado" rows="5" cols="33">
        </textarea>
    </div>

    <fieldset name="servico">
      <legend>SERVIÇOS:</legend>

      <div>
        <input type="checkbox" id="formatacao" name="servicos[]" value="formatacao" checked />
        <label for="formatacao">Formatação</label>
      </div>

      <div>
        <input type="checkbox" id="limpeza" name="servicos[]" value="limpeza" />
        <label for="limpeza">Limpeza</label>
      </div>

      <div>
        <input type="checkbox" id="trocadepeca" name="servicos[]" value="trocadepeca" />
        <label for="trocadepeca">Troca de peça</label>
      </div>

      <div>
        <input type="checkbox" id="montagem" name="servicos[]" value="montagem" />
        <label for="montagem">Montagem</label>
      </div>

      <div>
        <input type="checkbox" id="instalacao" name="servicos[]" value="instalacao" />
        <label for="instalacao">Instalação de Programas</label>
      </div>

      <div>
        <input type="checkbox" id="restauracao" name="servicos[]" value="restauracao" />
        <label for="restauracao">Recuperação de Arquivos</label>
      </div>
    </fieldset>
    <div class="input-box" name="peca">
      <label for="peca_id">Peças</label>
      <select name="peca_id" id="cliente_id" required>
        <option value="">Selecione a peça utilizada</option>
        <?php
        $sql = "select * from peca order by nome";
        $resultado = mysqli_query($conexao, $sql);
        while ($linha = mysqli_fetch_array($resultado)):
          $id = $linha['codigo'];
          $nome = $linha['nome'];

          echo "<option value='{$id}'>{$nome}</option>";
        endwhile;
        ?>
      </select>
    </div>


    <div>
      <label for="valorservico">Valor Serviço: R$</label>
      <input type="Text" size="12" name="valorservico" onKeyUp="mascaraMoeda(this, event)" value="">
    </div>
    <div>
      <label for="valortotal">Valor Total: R$</label>
      <input type="Text" size="12" name="valortotal" onKeyUp="mascaraMoeda(this, event)" value="">
    </div>


    <button type="submit" name="salvar" class="btn btn-dark">Cadastrar</button>

  </form>








</body>

</html>