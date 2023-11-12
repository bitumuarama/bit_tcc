$(document).ready(function () {
    $('a.menu-item').click(function (e) {
        e.preventDefault();

        var href = $(this).attr('href').substring(1);

        var $path = href + ".php";

        // Realiza a chamada AJAX para carregar o conteúdo do arquivo PHP
        $(".content").load($path, function (response, status, xhr) {
            if (status == "error") {
                var msg = "Desculpe, ocorreu um erro: ";
                $(".content").html("<p class='content-error'>" + msg + xhr.status + " " + xhr.statusText + "</p>");
            }

            // Adiciona um evento de submit aos formulários carregados dinamicamente
            $('form').submit(function (e) {
                e.preventDefault();

                var formData = $(this).serialize();
                // Realiza a chamada AJAX
                $.ajax({
                    type: "POST",
                    url: $path,
                    data: formData,               // Os dados do formulário
                    success: function (data) {
                        switch (data.trim()) {
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
                            default: {
                                console.log(data);
                                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro ao enviar o formulário.</p>');
                            }
                        }

                    }
                    ,
                    error: function (xhr, status, error) {
                        console.log(data)
                        $("#status").html('<p class="slide-mensage alert">Ocorreu um erro inesperado!</p>');
                    }
                });
            });

        });
    });
});
