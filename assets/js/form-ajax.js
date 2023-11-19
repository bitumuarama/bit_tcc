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

    $(document).on('click', "#editarCliente", function (e) {
        

    })




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

