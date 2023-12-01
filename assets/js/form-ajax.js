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
            data: { 'action': 'getData', 'id': editId },
            dataType: 'json',
            success: function (data) {
                // Campos do formulário com os dados recebidos
                $('#editModal #id').val(data.id);
                $('#editModal #nome').val(data.nome);
                $('#editModal #rg').val(data.rg);
                $('#editModal #cpf').val(data.cpf);
                $('#editModal #data_nascimento').val(data.data_nascimento);
                $('#editModal #celular').val(data.celular);
                $('#editModal #cep').val(data.cep);
                $('#editModal #estado').val(data.estado);
                $('#editModal #cidade').val(data.cidade);
                $('#editModal #bairro').val(data.bairro);
                $('#editModal #rua').val(data.rua);
                $('#editModal #numero').val(data.numero);

                // Abre o modal
                $('#editModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $(document).on('click', ".editpeca", function (e) {
        var editId = $(this).data('id');
        console.log(editId);
        $.ajax({
            url: $path,
            type: 'POST',
            data: { 'action': 'getData', 'id': editId },
            dataType: 'json',
            success: function (data) {
                // Campos do formulário com os dados recebidos
                $('#editModal #id').val(data.id);
                $('#editModal #nome').val(data.nome);
                $('#editModal #descricao').val(data.descricao);
                $('#editModal #marca').val(data.marca);
                $('#editModal #categoria').val(data.categoria);
                $('#editModal #estoque_minimo').val(data.estoque_minimo);
                $('#editModal #estoque_atual').val(data.estoque_atual);
                $('#editModal #valor_custo').val(data.valor_custo);
                $('#editModal #valor_venda').val(data.valor_venda);


                // Abre o modal
                $('#editModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $(document).on('click', "#salvar", function (e) {
        var id = $('#id').val();
        var nome = $('#nome').val();
        var rg = $('#rg').val();
        var cpf = $('#cpf').val();
        var data_nascimento = $('#data_nascimento').val();
        var celular = $('#celular').val();
        var cep = $('#cep').val();
        var estado = $('#estado').val();
        var cidade = $('#cidade').val();
        var bairro = $('#bairro').val();
        var rua = $('#rua').val();
        var numero = $('#numero').val();

        $.ajax({
            url: $path,
            type: 'POST',
            data: {
                'action': 'updateClientData',
                'id': id,
                'nome': nome,
                'rg': rg,
                'cpf': cpf,
                'data_nascimento': data_nascimento,
                'celular': celular,
                'cep': cep,
                'estado': estado,
                'cidade': cidade,
                'bairro': bairro,
                'rua': rua,
                'numero': numero,
            },
            success: function (response) {
                console.log(response)
                alertMessage(response);
                if (response == 'success') {
                    $('#search-result').html('<td></td><td>Pesquise novamente!</td>'); // Atualiza o corpo da tabela com a resposta recebida
                    setTimeout(() => {
                        $('#editModal').hide();
                    }, 250)
                } else {

                }

            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $(document).on('click', "#salvarpeca", function (e) {
        var id = $('#id').val();
        var nome = $('#nome').val();
        var descricao = $('#descricao').val();
        var marca = $('#marca').val();
        var categoria = $('#categoria').val();
        var estoque_minimo = $('#estoque_minimo').val();
        var estoque_atual = $('#estoque_atual').val();
        var valor_custo = $('#valor_custo').val();
        var valor_venda = $('#valor_venda').val();

        $.ajax({
            url: $path,
            type: 'POST',
            data: {
                'action': 'updatePecaData',
                'id': id,
                'nome': nome,
                'descricao': descricao,
                'marca': marca,
                'categoria': categoria,
                'estoque_minimo': estoque_minimo,
                'estoque_atual': estoque_atual,
                'valor_custo': valor_custo,
                'valor_venda': valor_venda,
            },
            success: function (response) {
                console.log(response)
                alertMessage(response);
                if (response == 'success') {
                    $('#search-result').html('<td></td><td>Pesquise novamente!</td>'); // Atualiza o corpo da tabela com a resposta recebida
                    setTimeout(() => {
                        $('#editModal').hide();
                    }, 250)
                } else {

                }

            },
            error: function (xhr, status, error) {
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

    function alertMessage($response) {
        switch ($response) {
            case "success": {
                $("#status").html('<p class="slide-mensage success">Formulário enviado com sucesso!</p>');
                break;
            };
            case "already_registered_user": {
                $("#status").html('<p class="slide-mensage alert">Este usuário já está cadastrado!</p>');
                break;
            }
            case "already": {
                $("#status").html('<p class="slide-mensage alert">CPF já cadastrado!</p>');
                break;
            };
            case "cpf": {
                $("#status").html('<p class="slide-mensage alert">CPF inválido!</p>');
                break;
            }
            case "teste": {
                $("#status").html('<p class="slide-mensage success">Passou no Teste De</p>');
                break;
            }
            case "pesquisa_cliente": {
                $("#status").html('<p class="slide-mensage sucess"> Pesquisa de cliente</p>')
                break;
            }
            default: {
                console.log($response);
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro ao enviar o formulário.</p>');
            }
        }
    }
})

