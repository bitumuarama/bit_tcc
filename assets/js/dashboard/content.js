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
                    type: "POST",                 // Método de envio
                    url: $path,  // O endpoint para onde o formulário será enviado
                    data: formData,               // Os dados do formulário
                    success: function (data) {
                        console.log(data); // Verifique o que está sendo retornado aqui no console do navegador
                    
                        if (data.trim() == "success") {
                            $("#status").html('<p class="slide-mensage sucess">Formulário enviado com sucesso!</p>'); // Mensagem de sucesso
                        } else if (data.trim() == "already") {
                            $("#status").html('<p class="slide-mensage alert">Cliente/CPF já cadastrado!</p>'); // Mensagem de sucesso
                        }
                        
                        else {
                            $("#status").html('<p class="slide-mensage alert">Ocorreu um erro ao enviar o formulário.</p>'); // Mensagem de erro
                        }
                    }
                    ,
                    error: function (xhr, status, error) {
                        console.log("Não enviou o formulário")
                        $("#status").html('<p class="slide-mensage alert">Ocorreu um erro ao enviar o formulário.</p>'); // Mensagem de erro
                    }
                });
            });

        });
    });
});
