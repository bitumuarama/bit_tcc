$(document).ready(function () {

    // Função para carregar o conteúdo com base no hash ou link
    function loadContent(path) {
        $.ajax({
            url: path + '.html',
            type: 'POST',
            data: $("#formContent").serialize(),
            success: function (data) {
                $("#content").html(data); // Atualiza o conteúdo do elemento com id 'content'
            },
            error: function (jqXHR, textStatus, errorThrown) {
                window.location.href = '../pages/dashboard.php';
            }
        });

    }

    // Carregar o conteúdo quando a página for carregada
    if (window.location.hash) {
        var initialPath = window.location.hash.substring(1);
        loadContent(initialPath);
    }

    $(".menu-list a").on('click', function (e) {
        var link = $(this).attr('href'); // Obtém o valor do href
        var path = link.replace("#", ""); // Remove o '#'

        loadContent(path);
    });


});
function defaultContent() {
    // Remove o hash da URL
    history.pushState("", document.title, window.location.pathname);

    // Redireciona para o dashboard
    window.location.href = '../pages/dashboard.php';
}