$(document).ready(function () {
    var $path;

    // Reconhecer o caminho de arquivo $path
    $('a.menu-item').click(function (e) {
        e.preventDefault();

        var href = $(this).attr('href').substring(1);
        $path = href + ".php";

        console.log($path);
    });



    // Pesquisar Cliente no Cadastro de OS
    $(document).on('submit', '#os_searchCliente', function (e) {
        e.preventDefault();
        console.log("Pesquisando Cliente para Ordem  de Serviço");

        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: $path,
            data: formData,
            success: function (data) {
                $("#search-result").html(data);
            }
            ,
            error: function (xhr, status, error) {
                alertMessage(error);
            }
        });
    })

    // Selecionar Cliente para OS
    $(document).on('click', '.select-cliente', function () {
        console.log($(this).data())

        var id = $(this).data('id');
        var nome = $(this).data('nome');

        console.log("Inserindo ID: " + id + "\nNome: " + nome)
        $('#clienteNome').val(nome);
        $('#clienteId').val(id);
    })




    // Ao clicar no botão de edição ele atualiza os valores do modal de edição e exibe na tela
    $(document).on('click', ".edit_cliente", function (e) {
        var editId = $(this).data('id');
        console.log("Cliente ID:" + editId);
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


    // Identifica os valores dos campos do modal e envia como um formulário
    // para o próprio PHP como action: updateClientData passando os inputs
    $(document).on('click', "#salvar_cliente", function (e) {
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
                alertMessage(response);
                if (response == 'success') {
                    // Atualiza a lista principal e esconde o modal
                    $('#search-result').html('<td colspan="6">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#editModal').hide();
                    }, 250)
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    // Reconhece o ID do cliente ao pressionar no botão de exclusão e abre o modal para confirmação
    $(document).on('click', ".delete_cliente", function (e) {
        var idCliente = $(this).data('id');
        $.ajax({
            url: $path,
            type: 'POST',
            success: function () {
                $('#idCliente').val(idCliente);
                console.log("Abriu modal e o ID é:" + idCliente);

                $('#excluirModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Ao pressionar o botão de confirmação ele tenta excluir o cliente de acordo com o ID
    $(document).on('click', "#excluir_cliente", function (e) {
        var id = $('#idCliente').val();

        $.ajax({
            url: $path,
            type: 'POST',
            dataType: 'json',
            data: { 'action': 'deleteData', 'id': id, },
            success: function (response) {
                console.log("Resposta json: " + response.success)
                if (response.success) {
                    $('#search-result').html('<td colspan="6">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#excluirModal').hide();
                        alertMessage('success');
                    }, 250)
                } else {
                    alertMessage('erro-chave-estrangeira');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    // Ao clicar no botão de edição ele atualiza os valores do modal de edição e exibe na tela
    $(document).on('click', ".edit_funcionario", function (e) {
        var editId = $(this).data('id');
        console.log("Funcionario ID:" + editId);
        $.ajax({
            url: $path,
            type: 'POST',
            data: { 'action': 'getData', 'id': editId },
            dataType: 'json',
            success: function (data) {
                // Campos do formulário com os dados recebidos
                $('#editModal #id').val(data.id);
                $('#editModal #nome').val(data.nome);
                $('#editModal #usuario').val(data.usuario);
                $('#editModal #cargo').val(data.cargo);
                $('#editModal #senha').val(data.senha);
                $('#editModal #confirmarSenha').val(data.senha);
                $('#editModal #email').val(data.email);
                $('#editModal #celular').val(data.celular);

                // Abre o modal
                $('#editModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $(document).on('click', "#salvar_funcionario", function (e) {
        // Obtem os valores dos campos
        var id = $('#editModal #id').val();
        var nome = $('#editModal #nome').val();
        var usuario = $('#editModal #usuario').val();
        var cargo = $('#editModal #cargo').val();
        var senha = $('#editModal #senha').val();
        var confirmarSenha = $('#editModal #confirmarSenha').val();
        var email = $('#editModal #email').val();
        var celular = $('#editModal #celular').val();

        // Verifica se as senhas coincidem antes de enviar
        if (senha !== confirmarSenha) {
            alertMessage('senha-nao-coincide');
            return;
        }

        // Faz a chamada AJAX
        $.ajax({
            url: $path,
            type: 'POST',
            data: {
                'action': 'updateEmployeeData',
                'id': id,
                'nome': nome,
                'usuario': usuario,
                'cargo': cargo,
                'senha': senha,
                'email': email,
                'celular': celular
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#search-result').html('<td colspan="7">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#editModal').hide();
                    }, 250);
                    alertMessage('success');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
    // Ao clicar no botão de edição ele atualiza os valores do modal de edição e exibe na tela
    $(document).on('click', ".edit_peca", function (e) {
        var editId = $(this).data('id');
        console.log("Peça ID:" + editId);
        $.ajax({
            url: $path,
            type: 'POST',
            data: { 'action': 'getData', 'id': editId },
            dataType: 'json',
            success: function (data) {
                console.log(data);
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

    $(document).on('click', "#salvar_peca", function (e) {
        // Obtem os valores dos campos
        var id = $('#editModal #id').val();
        var nome = $('#editModal #nome').val();
        var descricao = $('#editModal #descricao').val();
        var marca = $('#editModal #marca').val();
        var categoria = $('#editModal #categoria').val();
        var estoque_minimo = $('#editModal #estoque_minimo').val();
        var estoque_atual = $('#editModal #estoque_atual').val();
        var valor_custo = $('#editModal #valor_custo').val();
        var valor_venda = $('#editModal #valor_venda').val();
        // Faz a chamada AJAX
        $.ajax({
            url: $path,
            type: 'POST',
            data: {
                'action': 'updateData',
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
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.success) {
                    $('#search-result').html('<td colspan="6">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#editModal').hide();
                    }, 250);
                    alertMessage('success');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Ao pressionar o botão de confirmação ele tenta excluir o cliente de acordo com o ID
    $(document).on('click', "#excluir_peca", function (e) {
        var id = $('#idPeca').val();
        console.log("O ID é " + id)

        $.ajax({
            url: $path,
            type: 'POST',
            dataType: 'json',
            data: { 'action': 'deleteData', 'id': id, },
            success: function (response) {
                console.log("Resposta json: " + response.success)
                if (response.success) {
                    $('#search-result').html('<td colspan="6">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#excluirModal').hide();
                        alertMessage('success');
                    }, 250)
                } else {
                    alertMessage(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Reconhece o ID do cliente ao pressionar no botão de exclusão e abre o modal para confirmação
    $(document).on('click', ".delete_peca", function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: $path,
            type: 'POST',
            success: function () {
                $('#idPeca').val(id);
                console.log("Abriu modal e o ID é:" + id);

                $('#excluirModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Reconhece o ID do funcionario ao pressionar no botão de exclusão e abre o modal para confirmação
    $(document).on('click', ".delete_funcionario", function (e) {
        var idCliente = $(this).data('id');
        $.ajax({
            url: $path,
            type: 'POST',
            success: function () {
                $('#idFuncionario').val(idCliente);
                console.log("Abriu modal e o ID é:" + idCliente);

                $('#excluirModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Ao pressionar o botão de confirmação ele tenta excluir o funcionario de acordo com o ID
    $(document).on('click', "#excluir_funcionario", function (e) {
        var id = $('#idFuncionario').val();

        $.ajax({
            url: $path,
            type: 'POST',
            dataType: 'json',
            data: { 'action': 'deleteData', 'id': id, },
            success: function (response) {
                console.log("Resposta json: " + response.success)
                if (response.success) {
                    $('#search-result').html('<td colspan="7">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#excluirModal').hide();
                        alertMessage('success');
                    }, 250)
                } else {
                    alertMessage('erro');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });



    // Ao clicar no botão de edição ele atualiza os valores do modal de edição e exibe na tela
    $(document).on('click', ".edit_funcionario", function (e) {
        var editId = $(this).data('id');
        console.log("Funcionario ID:" + editId);
        $.ajax({
            url: $path,
            type: 'POST',
            data: { 'action': 'getData', 'id': editId },
            dataType: 'json',
            success: function (data) {
                // Campos do formulário com os dados recebidos
                $('#editModal #id').val(data.id);
                $('#editModal #nome').val(data.nome);
                $('#editModal #usuario').val(data.usuario);
                $('#editModal #cargo').val(data.cargo);
                $('#editModal #senha').val(data.senha);
                $('#editModal #confirmarSenha').val(data.senha);
                $('#editModal #email').val(data.email);
                $('#editModal #celular').val(data.celular);

                // Abre o modal
                $('#editModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $(document).on('click', "#salvar_funcionario", function (e) {
        // Obtem os valores dos campos
        var id = $('#editModal #id').val();
        var nome = $('#editModal #nome').val();
        var usuario = $('#editModal #usuario').val();
        var cargo = $('#editModal #cargo').val();
        var senha = $('#editModal #senha').val();
        var confirmarSenha = $('#editModal #confirmarSenha').val();
        var email = $('#editModal #email').val();
        var celular = $('#editModal #celular').val();

        // Verifica se as senhas coincidem antes de enviar
        if (senha !== confirmarSenha) {
            alertMessage('senha-nao-coincide');
            return;
        }

        // Faz a chamada AJAX
        $.ajax({
            url: $path,
            type: 'POST',
            data: {
                'action': 'updateEmployeeData',
                'id': id,
                'nome': nome,
                'usuario': usuario,
                'cargo': cargo,
                'senha': senha,
                'email': email,
                'celular': celular
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#search-result').html('<td colspan="7">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#editModal').hide();
                    }, 250);
                    alertMessage('success');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Reconhece o ID do funcionario ao pressionar no botão de exclusão e abre o modal para confirmação
    $(document).on('click', ".delete_funcionario", function (e) {
        var idCliente = $(this).data('id');
        $.ajax({
            url: $path,
            type: 'POST',
            success: function () {
                $('#idFuncionario').val(idCliente);
                console.log("Abriu modal e o ID é:" + idCliente);

                $('#excluirModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Ao pressionar o botão de confirmação ele tenta excluir o funcionario de acordo com o ID
    $(document).on('click', "#excluir_funcionario", function (e) {
        var id = $('#idFuncionario').val();

        $.ajax({
            url: $path,
            type: 'POST',
            dataType: 'json',
            data: { 'action': 'deleteData', 'id': id, },
            success: function (response) {
                console.log("Resposta json: " + response.success)
                if (response.success) {
                    $('#search-result').html('<td colspan="7">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#excluirModal').hide();
                        alertMessage('success');
                    }, 250)
                } else {
                    alertMessage('erro');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });





    // CONCLUIIR
    $(document).on('click', '.edit_os', function (e) {
        var editId = $(this).data('id');
        console.log(editId + " ordem de serviço");
        $.ajax({
            url: $path,
            type: 'POST',
            data: { 'action': 'getData', 'id': editId },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                // Campos do formulário com os dados recebidos
                // Preenchendo os campos do formulário de edição com os dados recebidos
                $('#editModal #ordem_servico_id').val(data.os_id);
                $('#editModal #nome').val(data.c_nome);
                $('#editModal #equipamento').val(data.os_equipamento);
                $('#editModal #problema_relatado').val(data.os_problema_relatado);
                $('#editModal #problema_constatado').val(data.os_problema_constatado);
                $('#editModal #servico_executado').val(data.os_servico_executado);
                $('#editModal #valor_servico').val(data.os_valor_servico);
                $('#editModal #valor_total').val(data.os_valor_total);

                // Abre o modal
                $('#editModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // CONCLUIIIR
    $(document).on('click', '#salvar_os', function (e) {
        e.preventDefault();

        var os_id = $('#ordem_servico_id').val();
        var os_equipamento = $('#equipamento').val();
        var os_problema_relatado = $('#problema_relatado').val();
        var os_problema_constatado = $('#problema_constatado').val();
        var os_servico_executado = $('#servico_executado').val();
        var os_servicos = [];
        // $('input[name="servicos[]"]:checked').each(function () {
        //     os_servicos.push(this.value);
        // });
        var os_valor_servico = $('#valor_servico').val();
        var os_valor_total = $('#valor_total').val();

        // Preparando a data para o AJAX
        var data = {
            'action': 'updateOrderService',
            'ordem_servico_id': os_id,
            'equipamento': os_equipamento,
            'problema_relatado': os_problema_relatado,
            'problema_constatado': os_problema_constatado,
            'servico_executado': os_servico_executado,
            'servicos': os_servicos,
            'valor_servico': os_valor_servico,
            'valor_total': os_valor_total
        };

        // Chamada AJAX para atualizar os dados da OS
        $.ajax({
            url: $path,
            type: 'POST',
            dataTyope: 'json',
            data: data,
            success: function (response) {
                alertMessage(response);
                if (response == 'success') {
                    // Atualiza a lista principal e esconde o modal
                    $('#search-result').html('<td colspan="6">Pesquise novamente!</td>');
                    $('#editModal').hide();
                } else {
                    // Tratar a resposta em caso de erro
                    console.error('Erro ao salvar: ', response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro AJAX: ', error);
            }
        });
    });



    $(document).on('click', ".finish_os", function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: $path,
            type: 'POST',
            data: { 'action': 'getReceiveData', 'id': id },
            dataType: 'json',
            success: function (data) {
                // Campos do formulário com os dados recebidos
                $('#finalizarModal #ordemServicoID').val(id);
                $('#finalizarModal #clienteId').val(data.cliente_id);
                $('#finalizarModal #clienteNome').val(data.cliente_nome);
                $('#finalizarModal #valorTotal').val(data.valor_total);

                // Abre o modal
                $('#finalizarModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $(document).on('click', "#saveFinishOS", function (e) {
        // Obtem os valores dos campos
        var clienteId = $('#finalizarModal #clienteId').val();
        var formaPagamento = $('#finalizarModal #formaPagamento').val();
        var valorTotal = $('#finalizarModal #valorTotal').val();
        var valorPago = $('#finalizarModal #valorPago').val();
        var ordemServicoID = $('#finalizarModal #ordemServicoID').val();


        console.log(clienteId)
        console.log(formaPagamento)
        console.log(valorTotal)
        console.log(valorPago)
        console.log(ordemServicoID)
        // Faz a chamada AJAX
        $.ajax({
            url: $path,
            type: 'POST',
            data: {
                'action': 'saveReceives',
                'clienteId': clienteId,
                'formaPagamento': formaPagamento,
                'valorTotal': valorTotal,
                'valorPago': valorPago,
                'ordemServicoID': ordemServicoID,
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#search-result').html('<td colspan="7">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#finalizarModal').hide();
                    }, 250);
                    alertMessage('success');
                }
            },
            error: function (xhr, status, error) {
                console.error("erro aqui: " + error);
            }
        });
    });









    // Reconhece o ID de OS ao pressionar no botão de exclusão e abre o modal para confirmação
    $(document).on('click', ".delete_os", function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: $path,
            type: 'POST',
            success: function () {
                $('#idOS').val(id);
                console.log("Abriu modal e o ID é:" + id);

                $('#excluirModal').removeClass('hidden').show();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Ao pressionar o botão de confirmação ele tenta excluir a OS de acordo com o ID
    $(document).on('click', "#excluir_os", function (e) {
        var id = $('#idOS').val();
        console.log("Valordo input ID:" + id);

        $.ajax({
            url: $path,
            type: 'POST',
            dataType: 'json',
            data: { 'action': 'deleteData', 'id': id, },
            success: function (response) {
                console.log("Resposta json: " + response.success)
                if (response.success) {
                    $('#search-result').html('<td colspan="6">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#excluirModal').hide();
                        alertMessage('success');
                    }, 250)
                } else {
                    console.log(response.message)
                    alertMessage('erro');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    // Trata formulários que precisam de uma busca de dados no banco de dados
    $(document).on('click', '#pesquisar_peca', function (e) {
        e.preventDefault();

        var term = $('#searchTerm').val();

        $.ajax({
            type: "POST",
            url: $path,
            data: { 'action': 'searchPeca', 'term': term },
            success: function (data) {
                $("#peca-results").html(data);
            }
            ,
            error: function (xhr, status, error) {
                console.log("Error: " + error)
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro inesperado!</p>');
            }
        });
    })

    $(document).on('click', '.select-peca', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var quantidade = $(this).closest('tr').find('.peca-qtd').val(); // Obtem a quantidade da mesma linha do botão clicado
        console.log(quantidade);
        if (quantidade == "Sem estoque") {
            alertMessage('sem-estoque');
            return;
        }
        console.log("Adicionando peça ID: " + id + " com quantidade: " + quantidade);
    
        $.ajax({
            url: $path,
            type: 'POST',
            dataType: 'json',
            data: { 'action': 'addPeca', 'id': id, 'quantidade': quantidade }, // Envia a quantidade junto com o ID
            success: function (data) {
                console.log("Resposta json: ", data);
                // Adiciona ID, Nome e Quantidade na div#selects
                $('#selects').append("<p data-id='" + data.id + "'> x " + data.quantidade + " " + data.nome + " - R$ " + (data.valor_venda * data.quantidade).toFixed(2).replace('.', ',') + "</p>");
    
                // Atualiza o valor total
                var valorTotal = parseFloat($('#valorTotal').text().replace('R$', '').replace(',', '.')) || 0;
                valorTotal += data.preco * data.quantidade;
                $('#valorTotal').text('R$ ' + valorTotal.toFixed(2).replace('.', ','));
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
    






    // Ao clicar no botão de edição ele atualiza os valores do modal de edição e exibe na tela
    $(document).on('click', ".edit_receive", function (e) {
        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: $path,
            data: { 'action': 'getData', 'id': id },
            success: function (data) {
                console.log("Data: " + data);

                if (data && data.length > 0) {
                    var recebimentosHtml = '';
                    var clienteNome = '';
                    var osValorTotal = '';

                    data.forEach(function (item, index) {
                        if (index === 0) {
                            clienteNome = item.cliente_nome;
                            osValorTotal = item.os_valor_total;
                            $("#ordem_servico_id").val(item.os_id);
                        }

                        recebimentosHtml += '<tr>' +
                            '<td>' + item.valor_recebimento + '</td>' +
                            '<td>' + item.forma_pagamento + '</td>' +
                            '<td>' + item.data_recebimento + '</td>' +
                            '</tr>';
                    });

                    $("#cliente_nome").val(clienteNome);
                    $("#os_valor_total").val(osValorTotal);
                    $("#recebimentoList").html(recebimentosHtml);
                } else {
                    $("#recebimentoList").html('<tr><td colspan="3">Nenhum recebimento encontrado.</td></tr>');
                }
            },
            error: function (xhr, status, error) {
                console.log("Error: " + error)
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro inesperado!</p>');
            }
        });
    });

    // Reconhece o ID de OS ao pressionar no botão de exclusão e abre o modal para confirmação
    $(document).on('click', ".delete_receive", function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: $path,
            type: 'POST',
            success: function () {
                $('#idRecebimento').val(id);
                console.log("Abriu modal e o ID é:" + id);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Ao pressionar o botão de confirmação ele tenta excluir a OS de acordo com o ID
    $(document).on('click', "#excluir_recebimento", function (e) {
        var id = $('#idRecebimento').val();
        console.log("Valordo input ID:" + id);

        $.ajax({
            url: $path,
            type: 'POST',
            dataType: 'json',
            data: { 'action': 'deleteData', 'id': id, },
            success: function (response) {
                console.log("Resposta json: " + response.success)
                if (response.success) {
                    $('#search-result').html('<td colspan="7">Pesquise novamente!</td>');
                    setTimeout(() => {
                        $('#excluirModal').hide();
                        alertMessage('success');
                    }, 250)
                } else {
                    console.log(response.message)
                    alertMessage('erro');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    function alertMessage($response) {
        switch ($response) {
            case "success": {
                $("#status").html('<p class="slide-mensage success">Operação realizada com sucesso!</p>');
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
            case "erro-chave-estrangeira": {
                $("#status").html('<p class="slide-mensage alert">Não é possível excluir. (Em uso)</p>');
                break;
            }
            case "senha-nao-coincide": {
                $("#status").html('<p class="slide-mensage alert">As senhas não coincidem!</p>');
                break;
            }
            case "sem-estoque": {
                $("#status").html('<p class="slide-mensage alert">Não há estoque!</p>');
                break;
            }
            case "pesquisa_cliente": {
                $("#status").html('<p class="slide-mensage sucess"> Pesquisa de cliente</p>')
                break;
            }
            default: {
                console.log($response);
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro: ' + $response + '</p>');
            }
        }
        return;
    }
})

