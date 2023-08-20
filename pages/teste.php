<!DOCTYPE html>
<html>
<head>
<style>
  body {
    margin: 0;
    padding: 10px;
  }

  .container {
    display: flex;
    align-items: flex-start;
  }

  .button-div {
    margin-right: 20px;
  }

  .expand-button {
    padding: 10px;
    font-size: 16px;
    background-color: #3498db;
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
  }

  .text-div {
    flex: 1;
    border: 1px solid #ddd;
    padding: 10px;
    transition: max-width 0.3s, max-height 0.3s;
    overflow: hidden;
  }
</style>
</head>
<body>

<div class="container">
  <div class="button-div">
    <button class="expand-button" id="toggleButton">Exemplo de Botão</button>
  </div>
  <div class="text-div" id="textContainer">
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget bibendum lorem. Proin feugiat, mauris vel pharetra
      consequat, purus sem tincidunt massa, quis tempor lectus nisl at nunc. Praesent at ultrices lorem. Ut sed orci eget ante
      consequat, purus sem tincidunt massa, quis tempor lectus nisl at nunc. Praesent at ultrices lorem. Ut sed orci eget ante
      consequat, purus sem tincidunt massa, quis tempor lectus nisl at nunc. Praesent at ultrices lorem. Ut sed orci eget ante
      scelerisque tempus. Sed feugiat quam nec libero vehicula, id varius risus finibus.
    </p>
    <h1>Exemplo</h1>
    <h2>Mais exemplos</h2>
    <!-- Adicione mais parágrafos de texto sobre tecnologia aqui -->
  </div>
</div>

<script>
  const expandButton = document.getElementById('toggleButton');
  const textContainer = document.getElementById('textContainer');

  let isExpanded = false;

  expandButton.addEventListener('click', () => {
    isExpanded = !isExpanded;
    if (isExpanded) {
      expandButton.style.width = '200px';
      expandButton.style.height = '100px';
      textContainer.style.maxWidth = '100%';
      textContainer.style.maxHeight = '100vh';
      textContainer.style.overflowY = 'auto';
    } else {
      expandButton.style.width = 'auto';
      expandButton.style.height = 'auto';
      textContainer.style.maxWidth = 'calc(100% - 140px)';
      textContainer.style.maxHeight = 'calc(100vh - 20px)';
      textContainer.style.overflowY = 'hidden';
    }
  });
</script>

</body>
</html>
