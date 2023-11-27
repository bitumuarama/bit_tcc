$(document).ready(function () {
    var $path;

    $('a.menu-item').click(function (e) {
        e.preventDefault();

        var href = $(this).attr('href').substring(1);
        $path = href + ".php";

        console.log($path);
    });

    $(document).on('submit', '#searchCliente', function (e) {
        e.preventDefault();
        console.log("searchForm");

        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: $path,
            data: formData,
            success: function (data) {
                $("#search-result-cliente").html(data);
            }
            ,
            error: function (xhr, status, error) {
                console.log("Error: " + error)
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro inesperado!</p>');
            }
        });
    })

    $(document).on('click', '.select-button', function () {
        console.log('Click select-button')
        console.log($(this).data())

        var type = $(this).data('type');
        var clienteId = $(this).data('id');
        var clienteNome = $(this).data('nome');
        var quantidade = $(this).data('quantidade')
        atualizarInputs(type, clienteId, clienteNome, quantidade);
    })

    $(document).on('change', '.quantidade-input', function () {
        var quantidade = $(this).val();
        console.log(quantidade)
        $(this).closest('tr').find('.select-button').attr('data-quantidade', quantidade);
    });

    function atualizarInputs(type, id, nome, quantidade) {
        console.log("Entrou com " + quantidade + " " + nome)
        quantidade = (quantidade > 0) ? quantidade : 1;
        console.log("Executou com " + quantidade + " " + nome)
        switch (type) {
            case "cliente": {
                console.log("Inserindo ID: " + id + "\nNome: " + nome)
                $('#clienteNome').val(nome);
                $('#clienteId').val(id);
                break;
            }
            case "peca": {
                console.log("Adicionar peça: " + nome);
                var pecaHtml = $('<div class="peca-item" data-peca-id="' + id + '">' +
                    '<span class="peca-nome">' + nome + '</span>' +
                    ' x <span class="peca-quantidade">' + quantidade + '</span>' +
                    '<input type="hidden" name="peca_ids[]" value="' + id + '">' +
                    '<input type="hidden" name="peca_quantidades[]" value="' + quantidade + '">' +
                    '<button type="button" class="remove-peca">Remover</button>' +
                    '</div>');

                $('#pecasSelecionadas').append(pecaHtml);
                break;
            }

        }
    }

    $(document).on('click', ".edit", function (e) {
        var editId = $(this).data('id');
        console.log(editId);
        $.ajax({
            url: $path,
            type: 'POST',
            data: { 'action': 'getClienteData', 'id': editId },
            dataType: 'json',
            success: function (data) {
                // Campos do formulário com os dados recebidos
                $('#editModal #id').val(data.id);
                $('#editModal #nome').val(data.nome);
                $('#editModal #cpf').val(data.cpf);
                $('#editModal #data_nascimento').val(data.data_nascimento);
                $('#editModal #celular').val(data.celular);
    
                // Abre o modal
                $('#editModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
    
    $(document).on('click', "#salvar", function(e) {
        var id = $('#id').val();
        var nome = $('#nome').val();
        var cpf = $('#cpf').val();
        var data_nascimento = $('#data_nascimento').val();
        var celular = $('#celular').val();
        
        $.ajax({
            url: $path,
            type: 'POST',
            data: {
                'action': 'updateClientData',
                'id': id,
                'nome': nome,
                'cpf': cpf,
                'data_nascimento': data_nascimento,
                'celular': celular
            },
            success: function(response) {
                console.log(response)
                if (response === 'success') {
                    alert('Dados do cliente atualizados com sucesso.');
                    $('#search-result').html('Pesquise novamente!'); // Atualiza o corpo da tabela com a resposta recebida
                } else {
                    alert('Erro ao atualizar os dados do cliente.');
                    console.error(response);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $(document).on('submit', '#searchPeca', function (e) {
        e.preventDefault();
        console.log("searchForm");

        var formData = $(this).serialize();

        // Certifique-se de que o $path está definido
        if (!$path) {
            console.log("Caminho para o formulário não definido.");
            return;
        }

        // Realiza a chamada AJAX
        $.ajax({
            type: "POST",
            url: $path,
            data: formData,
            success: function (data) {
                $("#search-result-peca").html(data);
            }
            ,
            error: function (xhr, status, error) {
                console.log("Error: " + error)
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro inesperado!</p>');
            }
        });
    })




})

