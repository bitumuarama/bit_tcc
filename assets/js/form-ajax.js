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


                $('#editModal #formatacao').prop('checked', data.os_servicos.includes('formatacao')); // Formatação
                $('#editModal #limpeza').prop('checked', data.os_servicos.includes('limpeza')); // Limpeza
                $('#editModal #trocadepeca').prop('checked', data.os_servicos.includes('trocadepeca')); // Troca de peça
                $('#editModal #montagem').prop('checked', data.os_servicos.includes('montagem')); // Montagem
                $('#editModal #instalacao').prop('checked', data.os_servicos.includes('instalacao')); // Instalação de Programas
                $('#editModal #restauracao').prop('checked', data.os_servicos.includes('restauracao')); // Recuperação de Arquivos


                // Abre o modal
                $('#editModal').removeClass('hidden').show();
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
            case "erro-chave-estrangeira": {
                $("#status").html('<p class="slide-mensage alert">Este cliente possui ordens de serviço em seu nome!</p>');
                break;
            }
            case "senha-nao-coincide": {
                $("#status").html('<p class="slide-mensage alert">As senhas não coincidem!</p>');
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

