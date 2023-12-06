$(document).ready(function () {
    // Funções genéricas para mostrar e esconder modais
    function showModal(modalId) {
        $(modalId).removeClass('hidden').show();
    }

    function hideModal(modalId) {
        $(modalId).hide();
    }

    // Função para adicionar peças selecionadas à ordem de serviço
    function addSelectedPeca(pecaId, pecaNome, quantidade) {
        var pecaHtml = $('<div class="peca-item" data-peca-id="' + pecaId + '">' +
            '<span class="peca-nome">' + pecaNome + '</span>' +
            ' x <span class="peca-quantidade">' + quantidade + '</span>' +
            '<input type="hidden" name="peca_ids[]" value="' + pecaId + '">' +
            '<input type="hidden" name="peca_quantidades[]" value="' + quantidade + '">' +
            '<button type="button" class="remove-peca">Remover</button>' +
            '</div>');

        $('#pecasSelecionadas').append(pecaHtml);
    }

    // Manipuladores de eventos para abrir e fechar modais
    $(document).on('click', '#selecionarCliente', function () {
        showModal('#clienteModal');
    });

    $(document).on('click', '#selecionarPeca', function () {
        showModal('#pecaModal');
    });

    $(document).on('click', '.edit', function () {
        console.log("Editar")
        showModal('#editModal');
    });

    $(document).on('click', '.edit_os', function () {
        console.log("Editar")
        showModal('#editModal');
    });
    $(document).on('click', '.edit_peca', function () {
        console.log("Editar")
        showModal('#editModal');
    });

    $(document).on('click', '.delete_cliente', function () {
        console.log("Excluir")
        showModal('#excluirModal');
    });

    $(document).on('click', '.delete_funcionario', function () {
        console.log("Excluir")
        showModal('#excluirModal');
    });
    
    $(document).on('click', '.delete_peca', function () {
        console.log("Excluir")
        showModal('#excluirModal');
    });

    $(document).on('click', '.delete_os', function () {
        console.log("Excluir")
        showModal('#excluirModal');
    });
    $(document).on('click', '.edit_receive', function () {
        console.log("Edit")
        showModal('#editModal');
    });
    $(document).on('click', '.delete_receive', function () {
        console.log("Excluir")
        showModal('#excluirModal');
    });
    $(document).on('click', '.finish_os', function () {
        console.log("Finalizar")
        showModal('#finalizarModal');
    });

    $(document).on('click', '#salvar', function () {
        console.log("Salvar")
    })


    $(document).on('click', '.close', function () {
        var modalId = '#' + $(this).closest('.modal').attr('id');
        hideModal(modalId);
    });

    $(window).on('click', function (event) {
        if ($(event.target).hasClass('modal')) {
            hideModal('.modal');
        }
    });

    // Seleção de cliente

    $(document).on('click', '.select-button', function () {
        hideModal('.modal');
    });


    // Seleção e remoção de peças
    $(document).on('click', '.select-peca', function () {
        var pecaId = $(this).data('id');
        var pecaNome = $(this).closest('tr').find('td:nth-child(2)').text();
        var quantidade = $(this).closest('tr').find('.peca-quantidade').val();

        if (!quantidade || parseInt(quantidade) <= 0) {
            alert('Por favor, insira uma quantidade válida.');
            return;
        }

        addSelectedPeca(pecaId, pecaNome, quantidade);
        hideModal('#pecaModal');
    });


});
