var conteudoPadrao = null; // Armazena o conteúdo padrão inicial

// Função para carregar o conteúdo usando AJAX
function carregarConteudo(secao, nome) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (conteudoPadrao === null) {
                // Armazena o conteúdo padrão antes de substituí-lo
                conteudoPadrao = document.getElementById("content").innerHTML;
            }
            document.getElementById("content").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../pages/" + secao + "/" + nome + ".php", true); // Monta o caminho com base na seção e nome
    xhttp.send();
}

// Função para restaurar o conteúdo padrão
function restaurarConteudoPadrao() {
    if (conteudoPadrao !== null) {
        document.getElementById("content").innerHTML = conteudoPadrao;
    }
}

// Captura os cliques no menu e carrega o conteúdo correspondente
document.addEventListener("DOMContentLoaded", function () {
    var menuLinks = document.querySelectorAll("#menu a");
    menuLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Evita o comportamento padrão do link
            var href = link.getAttribute("href").substring(1); // Obtém o nome da opção
            var partes = href.split('/'); // Divide a seção e o nome
            var secao = partes[0];
            var nome = partes[1];
            carregarConteudo(secao, nome);
        });
    });
});
