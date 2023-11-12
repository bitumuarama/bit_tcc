$(document).ready(function () {
    $('#cpf').mask('000.000.000-00', { reverse: true });
    $('#rg').mask('00.000.000-0', { reverse: true })
    $('#celular').mask('(00) 00000-0000', { reverse: false });
    $('#cep').mask('00000-000', { reverse: true });

    let valorLimite = 50000;
    $(".contabil").maskMoney({ prefix: 'R$ ', allowNegative: false, thousands: '.', decimal: ',', affixesStay: false }).on('change', function () {
        var valorAtual = $(this).maskMoney('unmasked')[0];
        if (valorAtual > valorLimite) {
            alert('O valor não pode exceder R$' + valorLimite.toFixed(2).replace('.', ','));
            $(this).maskMoney('mask', valorLimite);
        }
    });
});

