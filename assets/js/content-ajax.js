$(document).ready(function () {
    // Verifica o caminho e carrega o conteúdo de acordo com o link de acesso
    var $path;

    $('a.menu-item').click(function (e) {
        e.preventDefault();

        var href = $(this).attr('href').substring(1);
        $path = href + ".php";

        $('.content').load($path, function (response, status, xhr) {
            if (status == "error") {
                var msg = "Desculpe, ocorreu um erro: ";
                $(".content").html("<p class='content-error'>" + msg + xhr.status + " " + xhr.statusText + "</p>");
            }
        });
    });


    // Trata formulário para enviar o cadastro nas páginas de acesso
    $(document).on('submit', '#submitForm', function (e) {
        e.preventDefault();
        console.log("submitForm");

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
                alertMessage(data.trim())
            }
            ,
            error: function (xhr, status, error) {
                console.log("Error: " + error)
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro inesperado!</p>');
            }
        });
    })

    $('a.menu-item').click(function (e) {
        e.preventDefault();

        var href = $(this).attr('href').substring(1);
        $path = href + ".php";

        $('.content').load($path, function (response, status, xhr) {
            if (status == "error") {
                var msg = "Desculpe, ocorreu um erro: ";
                $(".content").html("<p class='content-error'>" + msg + xhr.status + " " + xhr.statusText + "</p>");
            }
        });
    });

    // Trata formulário de pesquisa em páginas de acesso.



    // Mensagens de Erros que devem ser exibidas na página
    function alertMessage($response) {
        switch ($response) {
            case "success": {
                $("#status").html('<p class="slide-mensage success">Formulário enviado com sucesso!</p>');
                break;
            };
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
});

