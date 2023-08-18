<?php
// Função para obter parâmetros da URL
function getParameterByName($name, $url = null) {
  if (!$url) $url = $_SERVER['REQUEST_URI'];
  $name = preg_quote($name);
  if (preg_match("/[?&]$name=([^&]+)/", $url, $match)) {
    return urldecode($match[1]);
  }
  return null;
}

// Verificar se o parâmetro 'exemplo' está presente na URL
$exemploParam = getParameterByName('exemplo');
if ($exemploParam === '1') {
  echo 'Título Modificado - Exemplo 1';
} elseif ($exemploParam === '2') {
  echo 'Título Modificado - Exemplo 2';
} else {
  echo 'Meu Site';
}
?>
