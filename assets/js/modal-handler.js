$(document).ready(function () {
  // Função para mostrar o modal
  function showModal() {
    $('#modalCliente').removeClass('hidden').show();
  }

  // Função para esconder o modal
  function hideModal() {
    $('#modalCliente').hide();
  }

  // Abre o modal quando o input de nome do cliente é clicado
  $(document).on('click', '#clienteNome', showModal);

  // Fecha o modal quando o botão fechar é clicado
  $(document).on('click', '.close', hideModal);

  // Fecha o modal quando clicar fora dele
  $(window).click(function (event) {
    if ($(event.target).is('#modalCliente')) {
      hideModal();
    }
  });

  // Função para buscar clientes
  function searchClientes(searchValue) {
    $.ajax({
      url: 'cadastro/buscar-clientes.php',
      type: 'GET',
      data: { 'search': searchValue },
      success: function(data) {
        $('#cliente-tbody').html(data);
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  }

  // Evento de submit para o formulário de pesquisa
  $(document).on('submit', '#searchForm', function(e) {
    e.preventDefault();
    var searchValue = $('#searchInput').val();
    searchClientes(searchValue);
  });

  // Carrega todos os clientes ao abrir a página
  searchClientes('');

  // Evento de clique para o botão de selecionar cliente
  $(document).on('click', '#selecionarCliente', function() {
    var clienteSelecionado = $('input[name="clienteSelecionado"]:checked');
    
    // Se houver um cliente selecionado, atualiza os inputs
    if (clienteSelecionado.length > 0) {
      var clienteId = clienteSelecionado.val(); // O valor do rádio selecionado (id do cliente)
      var clienteNome = clienteSelecionado.closest('tr').find('td:eq(1)').text(); // Texto da segunda célula (nome do cliente)

      // Atualiza os campos do formulário com os dados do cliente selecionado
      $('#clienteNome').val(clienteNome);
      $('#cliente_id').val(clienteId);

      // Fecha o modal
      hideModal();
    } else {
      alert('Por favor, selecione um cliente.');
    }
  });
});
